<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$this->load->css('assets/app/libs/apexcharts/apexcharts.min.js');

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

	public function data()
	{
		$this->output->unset_template('app/layout/webadmin');

		$data		= $this->dashboard_m->get_visitor_chart();

		foreach ($data as $key) {
            $val[] = $key->count;
		}
		

		// $data = array(22,24,54,65,22,35,66,32,99);
		// header('Content-Type: application/json');
		// print_r($val);
		echo json_encode($val);

	}

	

}
