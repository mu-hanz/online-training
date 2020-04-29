<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	//---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->_init();
        
    }

    private function _init()
    {
        $this->output->set_template('store/layout/store');
		$this->load->section('mainmenu', 'store/layout/main_menu');
		$this->load->section('footer', 'store/layout/footer');
	}
	
	public function index()
	{
		$this->load->view('store/home');
	}

	public function starter()
	{
		$this->load->view('store/starter');
	}
}
