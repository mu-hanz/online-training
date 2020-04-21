<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->_init();
		
		// Check Login
		// if(!$this->ion_auth->logged_in()) { 
        //     $this->session->set_userdata('redirect_login', current_url());
        //     redirect('webadmin/auth/login'); 
		// }
		
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

		// Load View
		$this->load->view('app/dashboard');

	}

	public function starter()
	{
		// Load View
		$this->load->view('app/starter');
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

		foreach ($sum_viewer_all as $key) {
            $val['all_visitor'][] = $key->count;
		}

		foreach ($sum_viewer_unique as $key) {
            $val1['unique_visitor'][] = $key->count;
		}

		$data = array_merge($val, $val1);

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
