<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	//---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->_init();
        if (!$this->ion_auth->logged_in()) {
            $this->session->set_userdata('redirect_login', $this->agent->referrer());
            redirect('');
        }


    }

    private function _init()
    {
        $data = array(
            'user' => $this->ion_auth->user()->row()
        );

        $this->output->set_template('main/users/layout_users');
        $this->load->section('header', 'main/layout/header');
        $this->load->section('menu', 'main/users/users_menu');
        
        
    }

    public function index()
	{	
        
        $data = array(
            'user' => $this->ion_auth->user()->row()
        );

		$this->output->set_title($this->muhanz->app_title('User Login'));

		$this->load->view('main/users/dashboard', $data);
    }

    public function my_order()
	{	
        

		$this->output->set_title($this->muhanz->app_title('Order Saya'));

		$this->load->view('users/my_order');
    }

    public function my_profile()
	{	
        
        $data = array(
            'user' => $this->ion_auth->user()->row()
        );

		$this->output->set_title($this->muhanz->app_title('Profil Saya'));

		$this->load->view('users/my_profile', $data);
    }
    

}