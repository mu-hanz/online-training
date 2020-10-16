<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Users extends CI_Controller {

	//---Templating----//
    public function __construct()
    {
        parent::__construct();
        
		$this->_init();
		$this->config->load('email', true);
    }

    private function _init()
    {
        $this->output->set_template('main/users/layout');
    }

    public function login()
	{	
        // Check Login
		if($this->ion_auth->logged_in()) { 
            redirect('users/dashboard', 'refresh'); 
        }

		$this->output->set_title($this->muhanz->app_title('Login'));

		$this->load->view('main/users/login');
    }

    public function register()
	{	

		$this->output->set_title($this->muhanz->app_title('Register'));

		$this->load->view('main/users/register');
    }

    public function lost_password()
	{	

		$this->output->set_title($this->muhanz->app_title('Lost Password'));

		$this->load->view('main/users/lost_password');
    }

    public function send_email()
	{	
        $data = array(
            'user' => $this->ion_auth->user()->row()
        );

        // $email_html = $this->load->view('users/layout/email_activation', $data_users, true);
        $email_html = $this->load->view('users/layout/email_activation', $data, true);

        $this->email->clear();
        $this->email->from($this->config->item('email_from', 'email'), $this->config->item('email_from_name', 'email'));
        $this->email->to('muhanz21@gmail.com');
        $this->email->subject('Konfirmasikan email Anda');
        $this->email->message($email_html);
        $send    = $this->email->send();

        if ($send) {
                
            $this->muhanz->success('Sukses', 'users/dashboard');

        } else {
            echo $this->email->print_debugger();
        }

    }

    public function update_profile()
	{	
        $data = array(
            'user'      => $this->ion_auth->user()->row(),
            'action'    => base_url('store/users/users/update_profile')
        );
		$this->output->set_title($this->muhanz->app_title('Profile'));

		$this->load->view('main/users/profile', $data);
    }

}