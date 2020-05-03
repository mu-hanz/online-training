<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->_init();
		
		// Check Login
		if(!$this->ion_auth->logged_in()) { 
            $this->session->set_userdata('redirect_login', current_url());
            redirect('webadmin/login', 'refresh'); 
		}
		
		$this->load->model('dashboard_m');
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
	
		$this->load->js('assets/app/libs/apexcharts/apexcharts.min.js');
		
		$this->load->js('assets/app/js/pages/dashboard.init.js');

		$this->output->set_title($this->muhanz->app_title('Dashboard'));

		// Load View
		$this->load->view('app/dashboard');

	}

	public function starter()
	{
		$da = array (
			'url' => base_url('submit'),
			'name' => 'Muhanz'
		);
		$ct = "Nama saya {{setData.name}} hasil dari ganerate shortcode {{code}}";
		$data = array(
			'content_use_tpl' => $this->mustache->parser_tpl('index', $this->mustache->parser_tpl('form', $da)),
			'content_not_tpl' => $this->mustache->parser($ct, $da)
		);
		
		$this->output->set_title($this->muhanz->app_title('Starter'));

		$this->load->view('app/starter1', $data);
		// Load View
		
	}

	public function starter1()
	{
		// Load View
		$this->load->view('app/starter1');
	}

	public function data()
	{
		$this->output->unset_template('app/layout/webadmin');

		$data		= $this->dashboard_m->get_visitor_chart();

		foreach ($data as $key) {
            $val['value_date'][] = $key->month_date;
		}

		foreach ($data as $key) {
            $val1['value_days'][] = $key->count;
		}

		$marge = array_merge($val, $val1);

		header('Content-Type: application/json');
		echo json_encode($marge);
		// print_r($data);

	}

	public function data_last()
	{
		$this->output->unset_template('app/layout/webadmin');

		$data1		= $this->dashboard_m->get_visitor_chart_last();
		$data2		= $this->dashboard_m->get_visitor_chart_last_seven();

		echo $data1->total.'<br>';
		echo $data2->total.'<br>';

		// print_r($data1);
	}


	public function data_visitor()
	{
		$this->output->unset_template('app/layout/webadmin');

		$sum_viewer_all		= $this->dashboard_m->get_visitor_chart_month();
		foreach ($sum_viewer_all as $key) {
            $val[] = $key->month_date;
		}

		header('Content-Type: application/json');
		echo json_encode($val);

	}

	public function data_visitor_all()
	{
		$this->output->unset_template('app/layout/webadmin');

		$sum_viewer_all		= $this->dashboard_m->get_visitor_chart_month();
		$sum_viewer_unique		= $this->dashboard_m->get_visitor_chart_month_unique();
		$sum_viewer_page		= $this->dashboard_m->get_visitor_chart_month_page_view();

		foreach ($sum_viewer_all as $key) {
            $val['all_visitor'][] = $key->count;
		}

		foreach ($sum_viewer_unique as $key) {
            $val1['unique_visitor'][] = $key->count;
		}

		foreach ($sum_viewer_page as $key) {
            $val2['page_view'][] = $key->count;
		}

		$data = array_merge($val, $val1, $val2);

		header('Content-Type: application/json');
		echo json_encode($data);

	}

	public function data_visitor_unique()
	{
		$this->output->unset_template('app/layout/webadmin');

		$sum_viewer_unique		= $this->dashboard_m->get_visitor_chart_month_unique();
		foreach ($sum_viewer_unique as $key) {
            $val[] = $key->count;
		}

		header('Content-Type: application/json');
		echo json_encode($val);

	}



	

}
