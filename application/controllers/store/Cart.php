<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    var $folder = 'Shopping_cart';
    var $file   = '';

	//---Templating----//
    public function __construct()
    {
        parent::__construct();
		$this->_init();
    
        $this->load->model('Post_m');
        $this->load->model('Shopping_cart_m');
        $this->load->library('cart');
    }

    private function _init()
    {
        $this->output->set_template('main/layout/index');
		$this->load->section('header', 'main/layout/header');
		$this->load->section('footer', 'main/layout/footer');
    }


    public function index()
	{	
        // $this->cart->destroy();

        $this->load->js('assets/main/scripts/cart.init.js');

        $this->output->set_title($this->muhanz->app_title('Event Cart'));
        
        $data = [
            'event_popular'      => $this->Post_m->get_event_all('3')->result(),
        ];

		$this->load->view('main/cart', $data);
    }

    public function add_cart()
	{
        $this->output->unset_template();

        $redirect_url = $this->input->post('url');
        $id = $this->input->post('id');

        if($id){
            $event =   $this->Post_m->get_event($id);
            $campagin = $this->Post_m->get_data_promotions_campaign($event->event_id);
    
            if($campagin->num_rows() > 0){
                $price = $campagin->row()->price_campaign;
            } else {
                $price = $event->event_cost_promo;
            }

            $check_flexi = 
    
            $data = array(
                'id'      => $event->event_id,
                'sku'     => $event->event_sku,
                'qty'     => 1,
                'price'   => $price,
                'name'    => $event->event_name,
                'images'  => $event->event_thumbs,
                'slug'    => 'events/detail/'.$event->event_slug,
            );    
            $this->cart->product_name_rules = '[:print:]'; // for allow all character in the name product
            if($this->cart->insert($data)){

                $cart = $this->cart->contents();
                $code_voucher = '';
                $rowid_voucher = '';
                foreach($cart as $items){
                    
                    if($items['sku'] == 'voucher'){
                        $code_voucher = $items['code_voucher']; //simpan ke variable
                        $rowid_voucher = $items['rowid'];
                        break;
                    }
                }

                if($rowid_voucher != ''){
                    $this->cart->remove($rowid_voucher);
                    $this_voucher = $this->apply_voucher_second($code_voucher);
                    if($this_voucher['status'] == true){
                        $this->muhanz->success($event->event_name, $redirect_url);
                    }
                } else {
                    $this->muhanz->success($event->event_name, $redirect_url);
                }

                
            } else {
                $this->muhanz->error('Sistem Error!', $redirect_url);
            }

        } else {

            $this->muhanz->error('Sistem Error!', $redirect_url);
        }


    }


    public function update_cart()
	{
        $this->output->unset_template();

        
        

        $redirect_url = 'events-cart';
        $id = $this->input->post('rowid');
        $qty = $this->input->post('qty');

        $data = array(
            'rowid' => $id,
            'qty'   => $qty
        );

        if($this->cart->update($data)){

            $cart = $this->cart->contents();
            $code_voucher = '';
            $rowid_voucher = '';
            foreach($cart as $items){
                
                if($items['sku'] == 'voucher'){
                    $code_voucher = $items['code_voucher']; //simpan ke variable
                    $rowid_voucher = $items['rowid'];
                    break;
                }
            }

            if($rowid_voucher != ''){

                    $this->cart->remove($rowid_voucher);
                    $this_voucher = $this->apply_voucher_second($code_voucher);
                    if($this_voucher['status'] == true){
                        $rowid = $this->cart->get_item($id);
                        $rowid_vocuher_second = $this->cart->get_item($rowid_voucher);

                        $data = array(
                            'rowid' => $id,
                            'subtotal' => rupiah($rowid['subtotal']),
                            'total' => rupiah($this->cart->total()),
                            'status' => 'success',
                            'message' => $this_voucher['respon'],
                            'price_voucher' => rupiah($rowid_vocuher_second['price']),
                            'sub_voucher' => rupiah($rowid_vocuher_second['subtotal']),
                            'used_voucher' => true,
                            'rowid_voucher' => 0,
                        );

                        echo json_encode($data);
                    } else {
                        $this->cart->remove($rowid_voucher);
                        $rowid = $this->cart->get_item($id);
                        $data = array(
                            'rowid' => $id,
                            'subtotal' => rupiah($rowid['subtotal']),
                            'total' => rupiah($this->cart->total()),
                            'status' => 'success',
                            'message' => $this_voucher['respon'],
                            'used_voucher' => false,
                            'rowid_voucher' => $rowid_voucher,
                        );

                        echo json_encode($data);
                    }
                } else {

                    $rowid = $this->cart->get_item($id);
                    $data = array(
                        'rowid' => $id,
                        'subtotal' => rupiah($rowid['subtotal']),
                        'total' => rupiah($this->cart->total()),
                        'status' => 'success',
                        'message' => 'Berhasil di Update!',
                        'used_voucher' => false,
                        'rowid_voucher' => 0,
                    );

                    echo json_encode($data);
                    
                }

            
           
        } else {
            $this->muhanz->error('Something Wrong!', $redirect_url);
        }

    
    }

    public function remove_cart()
	{
        $this->output->unset_template();

        $redirect_url = 'events-cart';
        $id = $this->input->post('rowid');

        if($this->cart->remove($id)){

            $cart = $this->cart->contents();
            $code_voucher = '';
            $rowid_voucher = '';
            foreach($cart as $items){
                
                if($items['sku'] == 'voucher'){
                    $code_voucher = $items['code_voucher']; //simpan ke variable
                    $rowid_voucher = $items['rowid'];
                    break;
                }
            }

            if($rowid_voucher != ''){
                $this->cart->remove($rowid_voucher);
                $this_voucher = $this->apply_voucher_second($code_voucher);
                if($this_voucher['status'] == true){
                    $data = array(
                        'count' => count($this->cart->contents()),
                        'total' => rupiah($this->cart->total()),
                        'status' => 'success',
                        'rowid_voucher' => 0,
                        'total' => rupiah($this->cart->total()),
                        'message' => $this_voucher['respon'],
                        'price_voucher' => rupiah($rowid_vocuher_second['price']),
                        'sub_voucher' => rupiah($rowid_vocuher_second['subtotal']),
                        'used_voucher' => true,
                    );
                    echo json_encode($data);
                } else {
                    $this->cart->remove($rowid_voucher);
                    $rowid = $this->cart->get_item($id);
                    $data = array(
                        'count' => count($this->cart->contents()),
                        'rowid' => $id,
                        'total' => rupiah($this->cart->total()),
                        'status' => 'success',
                        'message' => $this_voucher['respon'],
                        'used_voucher' => false,
                        'rowid_voucher' => $rowid_voucher,
                    );

                    echo json_encode($data);
                }

            } else {
                
                $data = array(
                    'count' => count($this->cart->contents()),
                    'total' => rupiah($this->cart->total()),
                    'status' => 'success',
                    'rowid_voucher' => 0,
                );

                echo json_encode($data);
            }


        } else {
            $this->muhanz->error('Something Wrong!', $redirect_url);
        }

    
    }

    public function apply_voucher_second($code_voucher){ //Fungsi untuk menampilkan Cart

        $this->output->unset_template();
        $respon = '';
        $status = true;
        $promotions = $this->check_voucher($code_voucher);

        if($promotions == 'soldout' || $promotions == 'expierd'){
            $status = false;
            $respon = 'Voucher Sudah Habis/Kadaluarsa!';
        }  elseif($promotions == 'not_start') {
            $status = false;
            $respon = 'Voucher Belum bisa digunakan!';
        } elseif($promotions == 'no_voucher') {
            $status = false;
            $respon = 'Voucher tidak ditemukan!';
        }

        // echo $promotions;


        $cart = $this->cart->contents();
        $status = TRUE;
        $event_name = '';
        foreach($cart as $items){
            $check_event = $this->Shopping_cart_m->check_events_voucher($items['id'], $promotions);
            if($check_event->num_rows() == 0){
                $status = FALSE;
                $event_name = $items['name'];
                break;
            }
        }

        if(!$status){

            $status = false;
            $respon = 'Voucher tidak digunakan atau gabung dengan training ('.$event_name.')!';

        }  else {

            //lanjut jika oke semuanya
            $voucher = $this->Shopping_cart_m->apply_voucher($promotions);

            $discount   = 0;
            $nominal_minimum  = 0;

            if($voucher->type_discount == 'nominal'){

                $discount   = $voucher->nominal_discount;
                $nominal_minimum      = $voucher->nominal_limit;
                $name_voucher = $code_voucher;

            } else {

                $calc   = ($voucher->percent_discount/100) * $this->cart->total();

                if($calc > $voucher->percent_max_discount){
                    $discount   = $voucher->percent_max_discount;
                } else {
                    $discount   = $calc;
                }
                $nominal_minimum      = $voucher->percent_limit;
                $name_voucher = $code_voucher.' ('.$voucher->percent_discount.'%)';

            }
        }


        //jika min nominal tidak terpenuhi

        if($nominal_minimum > $this->cart->total()){
            $status = false;
            $respon = 'Jumlah minimum order harus lebih dari '.rupiah($nominal_minimum);
        } else {

            // echo $discount;

            $data = array(
                'id'      => $promotions,
                'sku'     => 'voucher',
                'qty'     => 1,
                'price'   => -$discount,
                'name'    => $name_voucher,
                'code_voucher'    => $code_voucher,
            );    
            $this->cart->product_name_rules = '[:print:]'; // for allow all character in the name product
            if($this->cart->insert($data)){
                $status = true;
                $respon = 'Voucher berhasil digunakan';
            } else {
                $status = false;
                $respon = 'Sistem mengalami kendala!';
            }
        }

        $data_respon = [
            'status' => $status,
            'respon' => $respon
        ];

        return $data_respon;

    }


    public function apply_voucher($code_voucher = false){ //Fungsi untuk menampilkan Cart

        $this->output->unset_template();
        
        if($code_voucher){
            $code_voucher = $code_voucher;
        } else {
            $code_voucher = $this->input->post('code_voucher');
            // $code_voucher = '123456';
        }
        
        $promotions = $this->check_voucher($code_voucher);

        if($promotions == 'soldout' || $promotions == 'expierd'){
            $this->muhanz->error('Voucher Sudah Habis/Kadaluarsa!', ''); exit;
        }  elseif($promotions == 'not_start') {
            $this->muhanz->error('Voucher Belum bisa digunakan!', ''); exit;
        } elseif($promotions == 'no_voucher') {
            $this->muhanz->error('Voucher tidak ditemukan!', ''); exit;
        }

        // echo $promotions;


        $cart = $this->cart->contents();
        $status = TRUE;
        $event_name = '';
        foreach($cart as $items){
            $check_event = $this->Shopping_cart_m->check_events_voucher($items['id'], $promotions);
            if($check_event->num_rows() == 0){
                $status = FALSE;
                $event_name = $items['name'];
                break;
            }
        }

        if(!$status){

            $this->muhanz->error('Voucher tidak digunakan atau gabung dengan training ('.$event_name.')!', ''); exit;

        } 

        //lanjut jika oke semuanya
        $voucher = $this->Shopping_cart_m->apply_voucher($promotions);

        $discount   = 0;
        $nominal_minimum  = 0;

        if($voucher->type_discount == 'nominal'){

            $discount   = $voucher->nominal_discount;
            $nominal_minimum      = $voucher->nominal_limit;
            $name_voucher = $code_voucher;

        } else {

            $calc   = ($voucher->percent_discount/100) * $this->cart->total();

            if($calc > $voucher->percent_max_discount){
                $discount   = $voucher->percent_max_discount;
            } else {
                $discount   = $calc;
            }
            $nominal_minimum      = $voucher->percent_limit;
            $name_voucher = $code_voucher.' ('.$voucher->percent_discount.'%)';

        }


        //jika min nominal tidak terpenuhi

        if($nominal_minimum > $this->cart->total()){
            $this->muhanz->error('Jumlah minimum order harus lebih dari '.rupiah($nominal_minimum), ''); exit;
        }

        // echo $discount;

        $data = array(
            'id'      => $promotions,
            'sku'     => 'voucher',
            'qty'     => 1,
            'price'   => -$discount,
            'name'    => $name_voucher,
            'code_voucher'    => $code_voucher,
        );    
        $this->cart->product_name_rules = '[:print:]'; // for allow all character in the name product
        if($this->cart->insert($data)){
            $this->muhanz->success('Voucher berhasil digunakan', '');
        } else {
            $this->muhanz->error('Sistem mengalami kendala!', '');
        }

    }


    public function check_voucher($code_voucher){

        $this->output->unset_template();
        
        $date_now = strtotime(date('Y-m-d H:i:s', now()));
        $check_voucher = $this->Shopping_cart_m->check_voucher($code_voucher);

        if($check_voucher->num_rows() == 0){

             $respon = 'no_voucher';

        } else {

            $respon_voucher = $check_voucher->row();

            if($date_now < strtotime($respon_voucher->start_date)){
                $respon = 'not_start';
            } else {
                if(strtotime($respon_voucher->start_date) <= $date_now && strtotime($respon_voucher->end_date) >= $date_now ){
                    if($respon_voucher->limit_promotion > 0){
                        $respon = $respon_voucher->promotions_id; // variable id
                    } else {
                        $respon = 'soldout';
                    }
                } else {
                    $respon = 'expierd';
                }
            }
        }

        return $respon;
    }


    public function check_flexi_combo(){
        $cart = $this->cart->contents();
        $status = TRUE;
        $event_name = '';
        foreach($cart as $items){
            $check_event = $this->Shopping_cart_m->check_events_voucher($items['id'], $promotions);
            if($check_event->num_rows() == 0){
                $status = FALSE;
                $event_name = $items['name'];
                break;
            }
        }
    }
}