<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

    var $folder = 'Shopping_cart';
    var $file   = '';

	//---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->_init();
        

        $this->load->config('midtrans', true);
        $production         = $this->config->item('production', 'midtrans');
        $server_key         = $this->config->item('server_key', 'midtrans');
        $server_key_sandbox = $this->config->item('server_key_sandbox', 'midtrans');
        $url                = $this->config->item('url', 'midtrans');
        $url_sandbox        = $this->config->item('url_sandbox', 'midtrans');

        if ($production == "true") {
            $this->is_server_key = $server_key;
            $this->is_url        = $url;
        } else {
            $this->is_server_key = $server_key_sandbox;
            $this->is_url        = $url_sandbox;
        }

        $params = array('server_key' => $this->is_server_key, 'production' => $production);

        $this->load->library('midtrans');
        $this->midtrans->config($params);

    
        $this->load->model('Post_m');
        $this->load->model('Shopping_cart_m');
        $this->load->library('cart');
        $this->config->load('email', true);
    }

    private function _init()
    {
        $this->output->set_template('main/layout/index');
		$this->load->section('header', 'main/layout/header');
		$this->load->section('footer', 'main/layout/footer');
    }


    public function index()
	{	
        if (!$this->ion_auth->logged_in()) {
            $this->session->set_userdata('redirect_login', base_url('events-checkout'));
        }

        $cart = $this->cart->contents();

        if(empty($cart)): 
            redirect(base_url('events-cart'));
            exit;
        endif;

        $this->load->css('assets/checkbox/css/button-checks.css');
        $this->load->js('assets/checkbox/js/button-checks.min.js');
        $this->load->js('assets/scripts/auth_cart.pjax.js');
        $this->load->js('assets/scripts/checkout.init.js');
        

        $this->output->set_title($this->muhanz->app_title('Event Cart'));
        
        $data = [
            'event_popular'      => $this->Post_m->get_event_all('3')->result(),
        ];

		$this->load->view('main/checkout');
    }

    public function place_order()
	{
        $this->output->unset_template();

        $cart = $this->cart->contents(); // data keranjang

        $count_user         = []; // variable array data user
        $subtotal           = 0;
        $subtotal_flexi     = 0;
        $voucher_id         = 0;
        $discount_voucher   = 0;
        $discount_flexi     = 0;
        $date_transactions  = date('Y-m-d H:i:s', now());
        $promotions_id_flexi= 0;
        $success            = true;
        $order_id           = 'EVT-'.strtotime("now");

        // check post data peserta dan menyimpannya ke array
        foreach($cart as $items){
            if($items['sku'] != 'voucher'){

                if($this->input->post('user_data-'.$items['id'])){
                    $count_user[$items['id']] = count($this->input->post('user_data-'.$items['id'])); //simpan ke variable
                }
                
               
            }
        }
        
        // validasi jika data peserta belum lengkap
        foreach($cart as $items){
            if($items['sku'] != 'voucher'){

                if(!$this->input->post('user_data-'.$items['id'])){
                    $data = [
                        'no_participant' => true,
                        'message' => 'Data Peserta belum lengkap!',
                        'status'  => 'error', 
                        'csrf_hash' => $this->security->get_csrf_hash(),
                        'error_code'=> '200'
                    ];
                    echo json_encode($data);
                    exit;
                }

                if($count_user[$items['id']] != $items['qty']){
                    $data = [
                        'no_participant' => true,
                        'message' => 'Data Peserta belum lengkap!',
                        'status'  => 'error', 
                        'csrf_hash' => $this->security->get_csrf_hash(),
                        'error_code'=> '300'
                    ];
                    echo json_encode($data);
                    exit;
                } 


                if($items['used_flexi'] == 1){
                    $subtotal_flexi += $items['subtotal']; 
                    $subtotal += $items['old_subtotal'];
                } else {
                    $subtotal_flexi += $items['subtotal'];
                    $subtotal += $items['subtotal'];
                }

            } else {
                $voucher_id       = $items['id'];
                $discount_voucher += $items['subtotal'];
            }
        }

        // hitung jumlah potongan
        if($subtotal != $subtotal_flexi){ // jika ada diskon flexi combo
            $discount_flexi = $subtotal- $subtotal_flexi;
        } 


        // proses simpan data ke tabel transactions
        $data = [
            'order_id'          => $order_id,
            'user_id'           => $this->ion_auth->user()->row()->id,
            'subtotal'          => $subtotal, 
            'discount_voucher'  => $discount_voucher,
            'discount_flexi'    => '-'.$discount_flexi,
            'total'             => $this->cart->total(),
            'payment_status'    => 'unpaid',
            'created_date'      => $date_transactions
        ];

        $insert_transactions = $this->Shopping_cart_m->insert_transactions($data);
    
        if($insert_transactions){

            // kurangi limit used voucher jika ada
            if($voucher_id != 0){
                $data = [
                    'user_id'           => $this->ion_auth->user()->row()->id,
                    'id_promotion'      => $voucher_id, 
                    'event_id'          => 0,
                    'transaction_id'    => $insert_transactions,
                    'used_date'         => $date_transactions
                ];
        
                if(!$this->Shopping_cart_m->insert_promotions_user($data, $voucher_id)){
                    // rollback
                    $this->rollback($insert_transactions);

                    $data = [
                        'no_participant' => false,
                        'message' => 'Saat ini sistem sedang dalam perbaikan',
                        'status'  => 'error', 
                        'csrf_hash' => $this->security->get_csrf_hash(),
                        'error_code'=> '400'
                    ];
                    echo json_encode($data);
                    exit;
                }
            }
            
            $no = 100;
            foreach($cart as $items){
                if($items['sku'] != 'voucher'){ // voucher jangan di masukan ke sini
                    if($items['used_flexi'] == 1){ // jika menggunakan promo flexi 

                        $promotions_id_flexi = $items['data_flexi']['promotions_id'];

                        $data = [
                            'user_id'           => $this->ion_auth->user()->row()->id,
                            'id_promotion'      => $promotions_id_flexi, 
                            'event_id'          => $items['id'],
                            'transaction_id'    => $insert_transactions,
                            'used_date'         => $date_transactions
                        ];
                
                        if(!$this->Shopping_cart_m->insert_promotions_user($data, $promotions_id_flexi)){
                            // rollback
                            $this->rollback($insert_transactions);

                            $data = [
                                'no_participant' => false,
                                'message' => 'Saat ini sistem sedang dalam perbaikan',
                                'status'  => 'error', 
                                'csrf_hash' => $this->security->get_csrf_hash(),
                                'error_code'=> 'Flexi Combo '.$no
                            ];
                            echo json_encode($data);
                            exit;
                        }

                    }
                    

                    $data = [
                        'event_id'              => $items['id'],
                        'event_name'            => $items['name'], 
                        'event_slug'            => $items['slug'], 
                        'event_images'          => $items['images'], 
                        'event_type'            => $items['event_type'], 
                        'event_sku'             => $items['event_sku'], 
                        'event_duration'        => $items['event_duration'], 
                        'event_start_date'      => $items['event_start_date'], 
                        'event_end_date'        => $items['event_end_date'], 
                        'link_streaming'        => $items['data_evirtual']['link_streaming'], 
                        'streaming_id'          => $items['data_evirtual']['streaming_id'], 
                        'streaming_key'         => $items['data_evirtual']['streaming_key'], 
                        'event_price'           => $items['price'], 
                        'qty'                   => $items['qty'], 
                        'promotions_id'         => $promotions_id_flexi, 
                        'transaction_id'        => $insert_transactions, 
                    ];

                    $insert_transaction_detail = $this->Shopping_cart_m->insert_transaction_detail($data, $items['qty'], $items['id']);
                    if(!$insert_transaction_detail){

                        // rollback
                        $this->rollback($insert_transactions, $insert_transaction_detail);

                        $data = [
                            'no_participant' => false,
                            'message' => 'Saat ini sistem sedang dalam perbaikan',
                            'status'  => 'error', 
                            'csrf_hash' => $this->security->get_csrf_hash(),
                            'error_code'=> 'Transaction Detail '.$no
                        ];
                        echo json_encode($data);
                        exit;
                    }

                    // simpan data peserta

                    $user_data = $this->input->post('user_data-'.$items['id']);

                    if (isset($user_data) && !empty($user_data)) {
                        foreach ($user_data as $user_id) {

                            $participant = $this->Shopping_cart_m->get_data_participant($user_id);

                            $data = [
                                'user_id'               => $user_id,
                                'name'                  => $participant->name,
                                'email'                 => $participant->email,
                                'job_title'             => $participant->job_title,
                                'phone'                 => $participant->phone,
                                'transaction_detail_id' => $insert_transaction_detail, 
                            ];

                            if(!$this->Shopping_cart_m->insert_transaction_user_data($data)){
                                // rollback
                                $this->rollback($insert_transactions, $insert_transaction_detail);

                                $data = [
                                    'no_participant' => false,
                                    'message' => 'Saat ini sistem sedang dalam perbaikan',
                                    'status'  => 'error', 
                                    'csrf_hash' => $this->security->get_csrf_hash(),
                                    'error_code'=> 'participant '.$no
                                ];
                                echo json_encode($data);
                                exit;
                            }

                        }

                    }

                    // insert/Update Billings
                    $dataUser = [
                        'first_name'            => $this->input->post('first_name'),
                        'last_name'             => $this->input->post('last_name'),
                        'company'               => $this->input->post('company'),
                        'company_address'       => $this->input->post('company_address'),
                        'phone'                 => $this->input->post('phone'),
                        'company_npwp'          => $this->input->post('company_npwp'),
                    ];

                    if(!$this->Shopping_cart_m->update_user_billing($dataUser, $this->ion_auth->user()->row()->id)){
                        // rollback
                        $this->rollback($insert_transactions, $insert_transaction_detail);

                        $data = [
                            'no_participant' => false,
                            'message' => 'Saat ini sistem sedang dalam perbaikan',
                            'status'  => 'error', 
                            'csrf_hash' => $this->security->get_csrf_hash(),
                            'error_code'=> 'Billing '.$no
                        ];
                        echo json_encode($data);
                        exit;
                    }

                }
                $no++;
            }

        } else {
            $data = [
                'no_participant' => false,
                'message' => 'Saat ini sistem sedang dalam perbaikan',
                'status'  => 'error', 
                'csrf_hash' => $this->security->get_csrf_hash(),
                'error_code'=> '500'
            ];
            echo json_encode($data);
            exit;
        }

        
        // jika semuanya berjalan normal maka tampilkan pembayaran
        $payment = $this->payment($order_id);
        $data = [
            'token'         => $payment,
            'status'        => 'success', 
            'order_id'      => $order_id,
            'date_transaction' => $date_transactions,
        ];
        echo json_encode($data);

        
    }


    public function snap_onpending()
	{
        $this->output->unset_template();
        
        $result_data    = json_decode($this->input->post('result_data'));
        $status         = $this->input->post('status');
        
        // $cart = $this->cart->contents();

        // print_r($cart);

        // exit;
        $payment_date = null;
        
  
        // update transaction
        if($result_data){

            if ($result_data->transaction_status == 'capture') {
                if ($result_data->payment_type == 'credit_card'){
                  if($result_data->fraud_status == 'challenge'){
                        $payment_status = 'Challenge by FDS';
                    } 
                    else {
                        $payment_status = 'paid';
                        $payment_date = $result_data->transaction_time;
                    }
                  }
                }
              else if ($result_data->transaction_status == 'settlement'){
                    $payment_status = 'paid';
                } 
                else if($result_data->transaction_status == 'pending'){
                    $payment_status = 'pending';
                } 
                else if ($result_data->transaction_status == 'deny') {
                    $payment_status = 'deny';
              }

            $data_update = [
                'payment_type'      => $result_data->payment_type,
                'payment_status'    => $payment_status,
                'transaction_time'  => $result_data->transaction_time,
                'payment_date'      => $payment_date,
            ];

            $this->Shopping_cart_m->update_transaction($data_update, $result_data->order_id);

            $data = [
                'name'              => $this->ion_auth->user()->row()->first_name.' '.$this->ion_auth->user()->row()->last_name,
                'items'             => $this->cart->contents(),
                'order_id'          => $result_data->order_id,
                'transaction_time'  => $result_data->transaction_time,
                'status'            => false,
                'total'             => rupiah($this->cart->total()),
                'payment_status'    => $payment_status
            ];
            
            $email_html = $this->load->view('main/email/invoice_tpl', $data, true);

            $this->email->clear();
            $this->email->from($this->config->item('email_from', 'email'), $this->config->item('email_from_name', 'email'));
            $this->email->to($this->ion_auth->user()->row()->email);
            $this->email->subject('Transaksi Training Center Order ID #'.$result_data->order_id);
            $this->email->message($email_html);
            $send    = $this->email->send();

            if($send){
                echo json_encode($result_data);
            } else {
                echo $this->email->print_debugger();
            }
        }

        // if close by user payment
        if($status){

            $data = [
                'name'              => $this->ion_auth->user()->row()->first_name.' '.$this->ion_auth->user()->row()->last_name,
                'items'             => $this->cart->contents(),
                'order_id'          => $this->input->post('order_id'),
                'transaction_time'  => $this->input->post('date_transaction'),
                'status'            => true,
                'total'             => rupiah($this->cart->total())
            ];

            $email_html = $this->load->view('main/email/invoice_tpl', $data, true);

            $this->email->clear();
            $this->email->from($this->config->item('email_from', 'email'), $this->config->item('email_from_name', 'email'));
            $this->email->to($this->ion_auth->user()->row()->email);
            $this->email->subject('Transaksi Training Center Order ID #'.$this->input->post('order_id'));
            $this->email->message($email_html);
            $send    = $this->email->send();

            if($send){
                $data = [
                    'status_message' => 'Close by User'
                ];
                echo json_encode($data);
            } else {
                echo $this->email->print_debugger();
            }
        }

        $this->cart->destroy(); // clear cart
        
    }


    public function snap_payment()
	{
        $this->output->unset_template();
        
        $id = $this->input->post('id');

        $subtotal           = 0;
        $subtotal_flexi     = 0;
        $item_details       = [];

        $transaction  = $this->Shopping_cart_m->get_order_detail_users($id);

       
        $cart = $this->Shopping_cart_m->get_order_users_detail($id); // data keranjang
        //  echo json_encode($cart);
        $dataUser = $this->ion_auth->user()->row();
        // Required
		$transaction_details = array(
            'order_id' => $transaction->order_id,
            'gross_amount' => $transaction->total, // no decimal allowed for creditcard
        );

        //voucher
        $item_details[] = [
            'id' => 100,
            'price' => $transaction->discount_voucher,
            'quantity' => 1,
            'name' => 'Potongan Voucher'
        ];

        foreach($cart as $items){

            $item_details[] = [
                'id' => $items->event_id,
                'price' => $items->event_price,
                'quantity' => $items->qty,
                'name' => character_limiter($items->event_name, 40)
            ];
           
        }
  
  
        $billing_address = array(
        'first_name'    => $dataUser->first_name,
        'last_name'     => $dataUser->last_name,
        'address'       => $dataUser->company_address,
        'phone'         => $dataUser->phone,
        );

  
        $customer_details = array(
        'first_name'    => $dataUser->first_name,
        'last_name'     => $dataUser->last_name,
        'email'         => $dataUser->email,
        'phone'         => $dataUser->phone,
        'billing_address'  => $billing_address
        );

        // Fill transaction details
        $transaction = array(
        'transaction_details'   => $transaction_details,
        'customer_details'      => $customer_details,
        'item_details'          => $item_details,
        'credit_card'           => array('secure' => true),
		'callbacks'             => array("finish" => base_url('users/dashboard'))
        );
        //error_log(json_encode($transaction));
        $snapToken = $this->midtrans->getSnapToken($transaction);
        error_log($snapToken);

        $data = [
            'token'         => $snapToken,
            'status'        => 'success', 
        ];

        echo json_encode($data);
        
    }

    public function snap_onpayment()
	{
        $this->output->unset_template();
        
        $result_data    = json_decode($this->input->post('result_data'));

        $payment_date = null;
        
  
        // update transaction
        if($result_data){

            if ($result_data->transaction_status == 'capture') {
                if ($result_data->payment_type == 'credit_card'){
                  if($result_data->fraud_status == 'challenge'){
                        $payment_status = 'Challenge by FDS';
                    } 
                    else {
                        $payment_status = 'paid';
                        $payment_date = $result_data->transaction_time;
                    }
                  }
                }
              else if ($result_data->transaction_status == 'settlement'){
                    $payment_status = 'paid';
                } 
                else if($result_data->transaction_status == 'pending'){
                    $payment_status = 'pending';
                } 
                else if ($result_data->transaction_status == 'deny') {
                    $payment_status = 'deny';
              }

            $data_update = [
                'payment_type'      => $result_data->payment_type,
                'payment_status'    => $payment_status,
                'transaction_time'  => $result_data->transaction_time,
                'payment_date'      => $payment_date,
            ];

            $this->Shopping_cart_m->update_transaction($data_update, $result_data->order_id);

        }
 
    }

    public function payment($order_id)
	{

        $this->output->unset_template();

        $subtotal           = 0;
        $subtotal_flexi     = 0;
        $item_details       = [];

        $cart = $this->cart->contents(); // data keranjang
        $dataUser = $this->ion_auth->user()->row();
        // Required
		$transaction_details = array(
            'order_id' => $order_id,
            'gross_amount' => $this->cart->total(), // no decimal allowed for creditcard
        );

        foreach($cart as $items){

            
            if($items['sku'] != 'voucher'){

                $item_details[] = [
                    'id' => $items['id'],
                    'price' => $items['price'],
                    'quantity' => $items['qty'],
                    'name' => character_limiter($items['name'], 40)
                ];

            } else {
                // voucher
                $item_details[] = [
                    'id' => $items['id'],
                    'price' => $items['price'],
                    'quantity' => 1,
                    'name' => $items['name']
                ];
            }
        }
  
  
        $billing_address = array(
        'first_name'    => $dataUser->first_name,
        'last_name'     => $dataUser->last_name,
        'address'       => $dataUser->company_address,
        'phone'         => $dataUser->phone,
        );

  
        $customer_details = array(
        'first_name'    => $dataUser->first_name,
        'last_name'     => $dataUser->last_name,
        'email'         => $dataUser->email,
        'phone'         => $dataUser->phone,
        'billing_address'  => $billing_address
        );

        // Fill transaction details
        $transaction = array(
        'transaction_details'   => $transaction_details,
        'customer_details'      => $customer_details,
        'item_details'          => $item_details,
        'credit_card'           => array('secure' => true),
		'callbacks'             => array("finish" => base_url('users/dashboard'))
        );
        //error_log(json_encode($transaction));
        $snapToken = $this->midtrans->getSnapToken($transaction);
        error_log($snapToken);
        return $snapToken;

    }


    public function rollback($id, $id_participan =  false)
	{   
        $this->Shopping_cart_m->rollback_checkout('transactions', $insert_transactions);
        $this->Shopping_cart_m->rollback_checkout('promotions_users', $insert_transactions);
        $this->Shopping_cart_m->rollback_checkout('transaction_detail', $insert_transactions);
        if($id_participan){
            $this->Shopping_cart_m->rollback_checkout('transaction_participants', $id_participan);    
        }
        
    }


    public function add_participant()
	{	

        $this->output->unset_template();
        

        $user_id = $this->ion_auth->user()->row()->id;

        $data = [
            'id_users'              => $this->ion_auth->user()->row()->id,
            'name'                  => $this->input->post('name'),
            'email'                 => $this->input->post('email'),
            'job_title'             => $this->input->post('job_title'),
            'phone'                 => $this->input->post('phone'),
            'created_date'          => date('Y-m-d H:i:s', now()),
        ];

        $add     = $this->Shopping_cart_m->add_participant($data);

        if ($add) {

            $message = array(
                'status'  => 'success',
                'type'    => 'success',
                'message' => strip_tags($this->lang->line('save_success')),
                'id'	  => $add,
                'name'    => $this->input->post('name'),
            );
    
            echo json_encode($message);

        } else {
            $this->muhanz->error($this->lang->line('save_error'), '');
        }

    }


    public function get_participant()
	{	

        $this->output->unset_template();

        $user_id = $this->ion_auth->user()->row()->id;


        $data = $this->Shopping_cart_m->get_participant($user_id);
    
        echo json_encode($data);
    }


    public function cancel_payment_by_user()
	{	

        $this->output->unset_template();

        $this->cart->destroy();

        redirect(base_url());
    }

}