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
            $event      = $this->Post_m->get_event($id);
            $campagin   = $this->Post_m->get_data_promotions_campaign($event->event_id);
            $flexi      = $this->Post_m->promo_flexi($event->event_id);
    
            if($campagin->num_rows() > 0){
                $price  = $campagin->row()->price_campaign;
            } else  {
                $price  = $event->event_cost_promo;
            } 

            if($event->event_type == 'virtual-training' || $event->event_type == 'e-training'){
                    $link_streaming        = $event->link_streaming;
                    $streaming_id          = $event->streaming_id;
                    $streaming_key         = $event->streaming_key;
            } else {
                    $link_streaming        = '';
                    $streaming_id          = '';
                    $streaming_key         = '';
            }

            $data_evirtual = [
                'link_streaming'        => $link_streaming,
                'streaming_id'          => $streaming_id,
                'streaming_key'         => $streaming_key,
            ];

            $status_flexi = 0;
            $data_flexi = [];

            if($flexi->num_rows() > 0){

                $flx = $flexi->row();

                $data_flexi = [
                    'promotions_id'         => $flx->promotions_id,
                    'criteria_qty'          => $flx->criteria_qty,
                    'criteria_price'        => $flx->criteria_price,
                    'discount_percent'      => $flx->discount_percent,
                    'discount_price'        => $flx->discount_price,
                ];

                $status_flexi = 1;
            }
 
    
            $data = [
                'id'            => $event->event_id,
                'sku'           => $event->event_sku,
                'qty'           => 1,
                'old_price'     => $price,
                'original_price'=> $event->event_cost,
                'price'         => $price,
                'old_subtotal'  => 0,
                'name'          => $event->event_name,
                'images'        => $event->event_thumbs,
                'slug'          => 'events/detail/'.$event->event_slug,
                'event_type'    => $event->event_type,
                'event_sku'     => $event->event_sku,
                'event_duration'=> $event->event_duration,
                'event_start_date'      => $event->event_start_date.' '.$event->event_start_time,
                'event_end_date'        => $event->event_end_date.' '.$event->event_end_time,
                'data_evirtual' => $data_evirtual,
                'flexi'         => $status_flexi,
                'data_flexi'    => $data_flexi,
                'used_flexi'    => 0,
                'flexi_can_use' => 0,
                
            ];  

            $this->cart->product_name_rules = '[:print:]'; // for allow all character in the name product

            $insert = $this->cart->insert($data);

            // print_r($insert);

            if($insert){
                
                $flexi = $this->check_flexi_combo($insert);
                if($flexi){
                    $flexi_user = $this->check_flexi_combo_user($insert);
                }

                // update old_subtotal
                $rowid = $this->cart->get_item($insert);
                $data_old_sub = [
                    'rowid' => $insert,
                    'old_subtotal'  => $rowid['qty'] * $rowid['old_price'],
                ]; 

                $this->cart->update($data_old_sub);
                //end

                // apply voucher 
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

                    } else {

                        $this->muhanz->error($this_voucher['respon'], $redirect_url);

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

        // need checking session of cart

        $redirect_url = 'events-cart';

        $id = $this->input->post('rowid');
        $qty = $this->input->post('qty');

        $get_event_id = $this->cart->get_item($id);

        $checkStock = $this->Shopping_cart_m->check_stock_event($get_event_id['id'])->row();

        if($qty > $checkStock->event_max_participant){
            $data = array(
                'limit_stock' => true,
                'rowid' => $id,
                'qty' => $get_event_id['qty'],
                'message' => 'Slot Peserta sudah penuh!',
            );

            echo json_encode($data);

            exit;
        }

        $data = array(
            'rowid' => $id,
            'qty'   => $qty
        );

        if($this->cart->update($data)){
            
            $flexi = $this->check_flexi_combo($id);

            $flexi_user_message = '';
            $status_flexi = 'success';
            $used_flexi = false;
            $qty_flexi = $qty;
            $can_use_flexi_if_has_used = false;

            if($flexi){
                $flexi_user = $this->check_flexi_combo_user($id);

                if($flexi_user == 'need_login'){
                    $rowidflexi = $this->cart->get_item($id);

                    $qty_flexi = $rowidflexi['qty'];

                    $flexi_user_message = 'Anda harus login untuk bisa minkmati promo ini!';
                    $status_flexi = 'error';
                    $used_flexi = true;
                    $can_use_flexi_if_has_used = false;
                } else if ($flexi_user == 'has_used'){
                    $rowidflexi = $this->cart->get_item($id);
                    $qty_flexi = $rowidflexi['qty'];
                    $flexi_user_message = 'Anda sudah pernah menggunakan promo ini Harga normal akan di berlakukan!';
                    $status_flexi = 'error';
                    $used_flexi = true;
                    $can_use_flexi_if_has_used = true;
                }
            }
            
            $sub = $this->get_update_sub($id);

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
                    $rowid_vocuher_second = $this->cart->get_item($rowid_voucher);
                    $data = array(
                        'count' => $this->cart->total_items() - 1,
                        'rowid' => $id,
                        'subtotal' => $sub,
                        'total' => rupiah($this->cart->total()),
                        'status' => 'success',
                        'message' => $this_voucher['respon'],
                        'price_voucher' => rupiah_num($rowid_vocuher_second['price']),
                        'sub_voucher' => rupiah_num($rowid_vocuher_second['subtotal']),
                        'used_voucher' => true,
                        'rowid_voucher' => 0,
                        'flexi_user_message' => $flexi_user_message,
                        'status_flexi' =>  $status_flexi,
                        'used_flexi' => $used_flexi,
                        'qty_flexi' => $qty_flexi,
                        'can_use_flexi_if_has_used' => $can_use_flexi_if_has_used,

                    );

                    echo json_encode($data);
                } else {
                    $this->cart->remove($rowid_voucher);
                    $data = array(
                        'count' => $this->cart->total_items(),
                        'rowid' => $id,
                        'subtotal' => $sub,
                        'total' => rupiah($this->cart->total()),
                        'status' => 'success',
                        'message' => $this_voucher['respon'],
                        'used_voucher' => false,
                        'rowid_voucher' => $rowid_voucher,
                        'flexi_user_message' => $flexi_user_message,
                        'status_flexi' =>  $status_flexi,
                        'used_flexi' => $used_flexi,
                        'qty_flexi' => $qty_flexi,
                        'can_use_flexi_if_has_used' => $can_use_flexi_if_has_used,
                    );

                    echo json_encode($data);
                }
                
            } else {

                $data = array(
                    'count' => $this->cart->total_items(),
                    'rowid' => $id,
                    'subtotal' => $sub,
                    'total' => rupiah($this->cart->total()),
                    'status' => 'success',
                    'message' => 'Berhasil di Update!',
                    'used_voucher' => false,
                    'rowid_voucher' => 0,
                    'flexi_user_message' => $flexi_user_message,
                    'status_flexi' =>  $status_flexi,
                    'used_flexi' => $used_flexi,
                    'qty_flexi' => $qty_flexi,
                    'can_use_flexi_if_has_used' => $can_use_flexi_if_has_used,
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
            $used = 0;
            foreach($cart as $items){
                
                if($items['sku'] == 'voucher'){
                    $code_voucher = $items['code_voucher']; //simpan ke variable
                    $rowid_voucher = $items['rowid'];
                    $used = 1;
                    break;
                }
            }

            $count_total_items = $this->cart->total_items() - $used;
            if($count_total_items == 0){
                $this->cart->destroy();
                $data = array(
                    'status_cart' => 0,
                );

                echo json_encode($data);
                exit;
            }

            if($rowid_voucher != ''){
                $this->cart->remove($rowid_voucher);
                $this_voucher = $this->apply_voucher_second($code_voucher);
                if($this_voucher['status'] == true){
                    $rowid_vocuher_second = $this->cart->get_item($rowid_voucher);
                    $data = array(
                        'count' => $this->cart->total_items() - 1,
                        'total' => rupiah_num($this->cart->total()),
                        'status' => 'success',
                        'rowid_voucher' => 0,
                        'total' => rupiah_num($this->cart->total()),
                        'message' => $this_voucher['respon'],
                        'price_voucher' => rupiah_num($rowid_vocuher_second['price']),
                        'sub_voucher' => rupiah_num($rowid_vocuher_second['subtotal']),
                        'used_voucher' => true,
                    );
                    echo json_encode($data);
                } else {
                    $this->cart->remove($rowid_voucher);
                    $rowid = $this->cart->get_item($id);
                    $data = array(
                        'count' => $this->cart->total_items(),
                        'rowid' => $id,
                        'total' => rupiah_num($this->cart->total()),
                        'status' => 'success',
                        'message' => $this_voucher['respon'],
                        'used_voucher' => false,
                        'rowid_voucher' => $rowid_voucher,
                    );

                    echo json_encode($data);
                }

            } else {
                
                $data = array(
                    'count' => $this->cart->total_items(),
                    'total' => rupiah_num($this->cart->total()),
                    'status' => 'success',
                    'rowid_voucher' => 0,
                    'used_voucher' => false,
                );

                echo json_encode($data);
            }


        } else {
            $this->muhanz->error('Something Wrong!', $redirect_url);
        }

    
    }


    public function get_update_sub($id)
	{
        $rowid = $this->cart->get_item($id);

        $sub = [];
        if($rowid['used_flexi'] == 1){

            if($rowid['data_flexi']['discount_percent'] != 0){
                
                $sub['old_subtotal'] = rupiah_num($rowid['old_subtotal']);
                $sub['discount'] = $rowid['data_flexi']['discount_percent'];
                $sub['subtotal'] = rupiah_num($rowid['subtotal']);
                $sub['type'] = 1; // persen

                // $sub = "<del class='text-muted'>".rupiah_num($rowid['old_subtotal'])."</del><span class='text-danger'> (- ".$rowid['data_flexi']['discount_percent']."%)</span><br>".rupiah_num($rowid['subtotal']);
       
            } else {
                $sub['old_subtotal'] = rupiah_num($rowid['old_subtotal']);
                $sub['discount'] = rupiah_num($rowid['data_flexi']['discount_price']);
                $sub['subtotal'] = rupiah_num($rowid['subtotal']);
                $sub['type'] = 2;  // harga

                // $sub = "<del class='text-muted'>".rupiah_num($rowid['old_subtotal'])."</del><span class='text-danger'> (- ".$rowid['data_flexi']['discount_price'].")</span><br>".rupiah_num($rowid['subtotal']);

            }

        } else {
            $sub['old_subtotal'] = false;
            $sub['discount'] = false;
            $sub['type'] = 0;
            $sub['subtotal'] = rupiah_num($rowid['subtotal']);
            
        }

        return $sub;
    }

    public function apply_voucher_second($code_voucher){ 

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
        } elseif($promotions == 'has_used') {
            $status = false;
            $respon = 'Voucher sudah pernah digunakan!';
        } elseif($promotions == 'need_login') {
            $status = false;
            $respon = 'Silahkan login terlebih dahulu!';
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

                $discount               = $voucher->nominal_discount;
                $nominal_minimum        = $voucher->nominal_limit;
                $name_voucher           = $code_voucher;

            } else {

                $calc   = ($voucher->percent_discount/100) * $this->cart->total();

                if($calc > $voucher->percent_max_discount){

                    $discount   = $voucher->percent_max_discount;

                } else {

                    $discount   = $calc;

                }
                $nominal_minimum        = $voucher->percent_limit;
                $name_voucher           = $code_voucher.' ('.$voucher->percent_discount.'%)';

            }
        }


        //jika min nominal tidak terpenuhi
        if ($this->ion_auth->logged_in()) {
            if($nominal_minimum > $this->cart->total()){
                $status = false;
                $respon = 'Jumlah minimum order harus lebih dari '.rupiah_num($nominal_minimum);
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

        } else {

            $status = false;
            $respon = 'Silahkan login terlebih dahulu!';

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
        } elseif($promotions == 'has_used') {
            $this->muhanz->error('Voucher sudah pernah digunakan!', ''); exit;
        } elseif($promotions == 'need_login') {
            $this->muhanz->error('Silahkan login terlebih dahulu!', ''); exit;
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

            $discount           = $voucher->nominal_discount;
            $nominal_minimum    = $voucher->nominal_limit;
            $name_voucher       = $code_voucher;

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
            $this->muhanz->error('Jumlah minimum order harus lebih dari '.rupiah_num($nominal_minimum), ''); exit;
        }

        // echo $discount;
        if ($this->ion_auth->logged_in()) {
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
        } else {
            $this->muhanz->error('Silahkan login terlebih dahulu!', '');
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

                        //check if user has been us this voucher

                        if ($this->ion_auth->logged_in()) { // jika user login

                            $check_used = $this->Shopping_cart_m->check_voucher_user($respon_voucher->promotions_id, $this->ion_auth->user()->row()->id);

                            if($check_used->num_rows() >= $respon_voucher->limit_user){
                                $respon = 'has_used';
                            } else {
                                $respon = $respon_voucher->promotions_id; // variable id
                            }

                        } else {
                            $respon = 'need_login';
                        }

                        
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


    public function check_flexi_combo($id){

        $rowidflexi = $this->cart->get_item($id);

        if($rowidflexi['flexi'] == 1){

            $ori_sub = $rowidflexi['qty'] * $rowidflexi['old_price']; // ori subtotal sebelum diskon

            if($rowidflexi['data_flexi']['criteria_qty'] != 0){

                if($rowidflexi['qty'] >= $rowidflexi['data_flexi']['criteria_qty'] ){ // jika berdasarkan qty


                        if($rowidflexi['data_flexi']['discount_percent'] != 0){ // jika diskon persen
                            

                            $discount_price =  ($rowidflexi['data_flexi']['discount_percent']/100) * $rowidflexi['old_price'];

                            $data = [
                            'rowid'         => $id,
                            'price'         => $rowidflexi['old_price'] - $discount_price,
                            'old_subtotal'  => $ori_sub,
                            'used_flexi'    => 1,
                            ];  
                            
                            return $this->cart->update($data);

                        }  else if ($rowidflexi['data_flexi']['discount_price'] != 0){ // jika diskon harga

                            $discount_price =  ($ori_sub - $rowidflexi['data_flexi']['discount_price']) / $rowidflexi['qty'];

                            $data = [
                                'rowid'         => $id,
                                'price'         => $discount_price,
                                'old_subtotal'  => $ori_sub,
                                'used_flexi'    => 1,
                                ];  
                            
                                return $this->cart->update($data);

                        }

                    
                } else { // kembalikan ke harga awal sebelum flexi

                    $data = [
                        'rowid'         => $id,
                        'price'         => $rowidflexi['old_price'],
                        'used_flexi'    => 0,
                        ];  
                        
                        return $this->cart->update($data);
                }

            } else if($rowidflexi['data_flexi']['criteria_price'] != 0){

                if($ori_sub >= $rowidflexi['data_flexi']['criteria_price'] ){ // jika berdasarkan nila total

                   

                        if($rowidflexi['data_flexi']['discount_percent'] != 0){ // jika diskon persen
                            

                            $discount_price =  ($rowidflexi['data_flexi']['discount_percent']/100) * $rowidflexi['old_price'];

                            $data = [
                            'rowid'         => $id,
                            'price'         => $rowidflexi['old_price'] - $discount_price,
                            'old_subtotal'  => $ori_sub,
                            'used_flexi'    => 1,
                            ];  
                            
                            return $this->cart->update($data);

                        }  else if($rowidflexi['data_flexi']['discount_price'] != 0 ){ // jika diskon harga

                            $discount_price =  ($ori_sub - $rowidflexi['data_flexi']['discount_price']) / $rowidflexi['qty'];

                            $data = [
                                'rowid'         => $id,
                                'price'         => $discount_price,
                                'old_subtotal'  => $ori_sub,
                                'used_flexi'    => 1,
                                ];  
                            
                                return $this->cart->update($data);

                        }
                    

                } else { // kembalikan ke harga awal sebelum flexi

                    $data = [
                        'rowid'         => $id,
                        'price'         => $rowidflexi['old_price'],
                        'used_flexi'    => 0,
                        ];  
                        
                    return $this->cart->update($data);
                }

            }

        } 
    }


    public function check_flexi_combo_user($id)
    { 
        $rowidflexi = $this->cart->get_item($id);
        $ori_sub = $rowidflexi['qty'] * $rowidflexi['old_price']; // ori subtotal sebelum diskon
        $respon = '';

        $promotions_id = $rowidflexi['data_flexi']['promotions_id'];
        $event_id = $rowidflexi['id'];

        if($rowidflexi['data_flexi']['criteria_qty'] != 0){

            if($rowidflexi['qty'] >= $rowidflexi['data_flexi']['criteria_qty'] ){ // jika berdasarkan qty

                $qty_required = $rowidflexi['data_flexi']['criteria_qty'] - 1;

                if (!$this->ion_auth->logged_in()) {
                    $respon = 'need_login';
                    $data = [
                        'rowid'         => $id,
                        'price'         => $rowidflexi['old_price'],
                        'used_flexi'    => 0,
                        'qty'           => $qty_required,
                        ];  
                        
                    $this->cart->update($data);
                } else {
                    $check_flexi = $this->Shopping_cart_m->get_data_flexi($promotions_id)->row();
                    $check_used = $this->Shopping_cart_m->check_flexi_user($promotions_id, $event_id, $this->ion_auth->user()->row()->id);

                    if($check_used->num_rows() >= $check_flexi->limit_user){ // boleh lanjut tanpa promo
                        $data = [
                            'rowid'         => $id,
                            'price'         => $rowidflexi['old_price'],
                            'used_flexi'    => 0,
                            'flexi_can_use' => 1,
                        ];  
                        $this->cart->update($data);

                        return 'has_used';
    
                    } else {
    
                        return 'oke';   
                    }

                    
                }
            } else {
                $data = [
                    'rowid'         => $id,
                    'price'         => $rowidflexi['old_price'],
                    'used_flexi'    => 0,
                    'flexi_can_use' => 0,
                ];  
                $this->cart->update($data);

                return 'oke';
            }

        } else if($rowidflexi['data_flexi']['criteria_price'] != 0){

            if($ori_sub >= $rowidflexi['data_flexi']['criteria_price'] ){ // jika berdasarkan nila total
                if (!$this->ion_auth->logged_in()) {

                    $data = [
                        'rowid'         => $id,
                        'price'         => $rowidflexi['old_price'],
                        'used_flexi'    => 0,
                        'qty'           => 1,
                        ];  
                        
                    $this->cart->update($data);

                    $respon = 'need_login';
                } else {
                    
                    $check_flexi = $this->Shopping_cart_m->get_data_flexi($promotions_id)->row();
                    $check_used = $this->Shopping_cart_m->check_flexi_user($promotions_id);

                    if($check_used->num_rows() >= $check_flexi->limit_user){ // boleh lanjut tanpa promo
                        $data = [
                            'rowid'         => $id,
                            'price'         => $rowidflexi['old_price'],
                            'used_flexi'    => 0,
                            'flexi_can_use' => 1,
                        ];  
                        $this->cart->update($data);
                        return 'has_used';
    
                    } else {
    
                        return 'oke';  
                    }
                    
                }
            } else {
                $data = [
                    'rowid'         => $id,
                    'price'         => $rowidflexi['old_price'],
                    'used_flexi'    => 0,
                    'flexi_can_use' => 0,
                ];  
                $this->cart->update($data);
    
                return 'oke';
            }
        }  

        return $respon;
    }

}