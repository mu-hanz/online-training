<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->muhanz->check_auth();
		$this->_init();
	
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
	
		///

	}

	public function change_themes()
	{
		$this->output->unset_template();

		if($this->input->post('themes') == '1'){
			$cookie= array(
				'name'   => 'themes',
				'value'  => 'dark', 
				'expire' => 2147483647,
				'secure' => FALSE                                                                                                             
			);
			set_cookie($cookie);
		} else {
			delete_cookie('themes');
		}
	}



	

}
