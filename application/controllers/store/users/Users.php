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


    public function forgot_password()
	{	
        $this->output->unset_template();

		    $identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if (empty($identity))
			{

				if ($this->config->item('identity', 'ion_auth') != 'email')
				{
                    $message_error = 'Username not found';
				}
				else
				{
					$message_error = 'Email not found';
                }
                
                $message = array(
                    'url'     => base_url('account/lost-password'),
                    'status'  => 'error',
                    'type'    => 'danger',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                    'message' => $message_error
                );
        
                echo json_encode($message);
                
                exit;
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$email_html = $this->load->view('main/users/lost_password_tpl', $forgotten, TRUE);

                $this->email->clear();
                $this->email->from($this->config->item('email_from', 'email'), $this->config->item('email_from_name', 'email'));
                $this->email->to($forgotten['identity']);
                $this->email->subject('Reset your password');
                $this->email->message($email_html);
                $send    = $this->email->send();

                if ($send) {
                        
                    $this->muhanz->success('Success', 'account/login');

                } else {
                    // echo $this->email->print_debugger();
                    $message = array(
                        'url'     => base_url('account/lost-password'),
                        'status'  => 'error',
                        'type'    => 'danger',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                        'message' => 'Sistem sedang dalam perbaikan.'
                    );
            
                    echo json_encode($message);

                }

                // print_r($forgotten);

			}
			else
			{

                $message = array(
                    'url'     => base_url('account/lost-password'),
                    'status'  => 'error',
                    'type'    => 'danger',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                    'message' => strip_tags($this->ion_auth->errors())
                );
        
                echo json_encode($message);

			}
    }

    public function change_password($code = NULL)
	{
        if (!$code)
		{
			show_404();
        }
        

        $data = [
            'action' => base_url('account/reset-password/'.$code)
        ];

        $this->load->view('main/users/reset_password', $data);
        
    }



    public function reset_password($code = NULL)
	{
        $this->output->unset_template();

		if (!$code)
		{
			show_404();
		}
		
		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{

            $identity = $user->{$this->config->item('identity', 'ion_auth')};
            // finally change the password
            $change = $this->ion_auth->reset_password($identity, $this->input->post('password'));

            if ($change)
            {

                $this->muhanz->success('Success', 'account/login');
            }
            else
            {

                $message = array(
                    'url'     => base_url('account/change-password/'.$code),
                    'status'  => 'error',
                    'type'    => 'danger',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                    'message' => strip_tags($this->ion_auth->errors())
                );
        
                echo json_encode($message);

                
            }
            
			
		}
		else
		{
            $message = array(
                'url'     => base_url('account/change-password/'.$code),
                'status'  => 'error',
                'type'    => 'danger',
                'csrf_hash' => $this->security->get_csrf_hash(),
                'message' => strip_tags($this->ion_auth->errors())
            );
    
            echo json_encode($message);
		}
	}


    

    public function send_email()
	{	
        $data = array(
            'user' => $this->ion_auth->user()->row()
        );

        // $email_html = $this->load->view('users/layout/email_activation', $data_users, true);
        $email_html = $this->load->view('main/users/email_activation', $data, true);

        $this->email->clear();
        $this->email->from($this->config->item('email_from', 'email'), $this->config->item('email_from_name', 'email'));
        $this->email->to($this->ion_auth->user()->row()->email);
        $this->email->subject('Konfirmasikan email Anda');
        $this->email->message($email_html);
        $send    = $this->email->send();

        if ($send) {
                
            redirect('users/dashboard');

        } else {
            // echo $this->email->print_debugger();
            $message = array(
                'url'     => base_url('account/lost-password'),
                'status'  => 'error',
                'type'    => 'danger',
                'csrf_hash' => $this->security->get_csrf_hash(),
                'message' => 'Sistem sedang dalam perbaikan.'
            );
    
            echo json_encode($message);
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