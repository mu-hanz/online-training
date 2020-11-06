<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->muhanz->check_auth();
        $this->_init();
		
		$this->load->model('orders_m');
	}	

	// Templating
	private function _init()
	{
		$this->output->set_template('app/layout/webadmin');
		$this->load->section('topbar', 'app/layout/mz_topbar');
		$this->load->section('menubar', 'app/layout/mz_menubar');

	}

	public function index()
	{
	
		// css
        $this->load->css('assets/app/libs/datatables/dataTables.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/responsive.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/buttons.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/select.bootstrap4.min.css');
		$this->load->css('assets/sweetalert/sweetalert2.min.css');
		
		// js
		$this->load->js('assets/app/libs/datatables/jquery.dataTables.min.js');
		$this->load->js('assets/app/libs/datatables/dataTables.bootstrap4.min.js');
		$this->load->js('assets/app/libs/datatables/dataTables.responsive.min.js');
		$this->load->js('assets/app/libs/datatables/responsive.bootstrap4.min.js');
		$this->load->js('assets/sweetalert/sweetalert2.all.min.js');
		$this->load->js('assets/app/js/pages/orders.datatables.js');

		$title = 'Manage Orders';

        $data = array(
            'title'             => $title,
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Order' , '/webadmin/orders/orders');

		// Load View
		$this->load->view('app/orders', $data);

	}

	public function detail($transaction_id)
    {

		$title = 'Detail Orders';

        $data = array(
            
		);
		
        $data = array(
			'title'             => $title,
            'data_transaction' 	=>  $this->orders_m->get_order_transactions($transaction_id)->row(),
            'list_order'		=> $this->orders_m->get_order_transaction_detail($transaction_id)
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Order' , '/webadmin/orders/orders');
		$this->breadcrumbs->push('Detail' , '/webadmin/orders/orders/detail');

		$this->load->view('app/orders_detail', $data);
	}

	public function json_orders()
    {
        $this->output->unset_template('layout');

        function is_tools($transaction_id)
        {

            $data = '<a href="'.base_url('webadmin/orders/orders/detail/'.$transaction_id).'" class="btn btn-primary btn-sm btn-block mlink">View Detail</a>';
            return $data;
		}
		
		function is_invoice($transaction_id)
        {

            $data = '<a href="'.base_url('webadmin/orders/orders/create_invoice/'.$transaction_id).'" class="btn btn-light btn-sm btn-block">Donwnload Invoice</a>';
            return $data;
        }
      

        $this->datatables->select('transaction_id, order_id, payment_type, payment_status, created_date, total');
        $this->datatables->from('transactions');
        $this->datatables->order_by('transaction_id', 'desc');
		$this->datatables->add_column('invoice', '$1', "is_invoice('transaction_id')");
        $this->datatables->add_column('tools', '$1', "is_tools('transaction_id')");
        
        return print_r($this->datatables->generate());
	}
	

	public function detail_order()
	{
		$this->output->unset_template();

		$list_event = $this->orders_m->detail_order($this->input->post('id'));

		echo json_encode($list_event);

	}
	

	public function create_invoice($transaction_id)
	{	
        $this->output->unset_template();

        $data_transaction = $this->orders_m->get_order_transactions($transaction_id)->row();
        $data = array(
            'data_transaction' => $data_transaction,
            'list_order'=> $this->orders_m->get_order_transaction_detail($transaction_id)
        );

        $layout       = 'main/invoice_pdf_tpl';
        

        //save_pdf
        $html = $this->load->view($layout, $data, true);
        $file_name = $data_transaction->order_id;
        $this->pdf->download_pdf($html, $file_name);


    }

	

}
