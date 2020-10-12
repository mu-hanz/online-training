<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hauth Controller Class
 */

use Hybridauth\Hybridauth;


class Hauth extends CI_Controller
{

	
	/**
	 * {@inheritdoc}
	 */
	public function __construct()
	{
		parent::__construct();

	
	}

	/**
	 * {@inheritdoc}
	 */
	public function google($provider)
	{
		// $provider =  $this->input->get('provider');
		// $service = NULL;
 
        // try
        // {
        //     //Instantiate Hybridauth's classes
        //     $hybrid = new Hybridauth($this->getHybridConfig());
 
        //     //Check if given provider is enabled
        //     if ($provider && in_array($provider, $hybrid->getProviders()))
        //     {
        //         $this->session->set_userdata('provider', $provider);
        //     }
 
        //     //Update variable with the valid provider
        //     $provider = $this->session->userdata('provider');
 
        //     if ($provider)
        //     {
        //         $service = $hybrid->authenticate($provider);
        //         if ($service->isConnected())
        //         {
        //             //Get user profile
        //             $profile = $service->getUserProfile();
 
        //             //Get user contacts
        //             $contacts = $service->getUserContacts();
 
        //             /*
        //             Disconnect the service else HA would reuse stored session data
        //             rather making a fresh request in case the user has denied permissions
        //             in the previous authorization request
        //             */
        //             // $service->disconnect();
 
        //             // $this->session->unset_userdata('provider');
 
        //             //Display the profile data
        //             echo 'Name: ' . $profile->displayName;
        //             print_r($profile);
        //         }
        //         else
        //         {
        //             $this->session->set_flashdata('showmsg', array('msg' => 'Sorry! We couldn\'t authenticate your identity.'));
        //         }
        //     }
        // }
        // catch(Exception $e)
        // {
        //     if (isset($service) && $service->isConnected()) 
        //         $service->disconnect();
 
        //     $error = 'Sorry! We couldn\'t authenticate you.';
        //     $this->session->set_flashdata('showmsg', array('msg' => $error));
        //     $error .= '\nError Code: ' . $e->getCode();
        //     $error .= '\nError Message: ' . $e->getMessage();
 
        //     log_message('error', $error);
        // }
				
        $this->session->set_userdata('provider', $provider);

        echo $this->session->userdata('provider');
	}

	//Hybridauth configuration
    private function getHybridConfig()
    {
        $config = array(
 
            'callback' => site_url('users/auth/') ,
 
            'providers' => array(
                'Google' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => '1035051390977-4h6pcc65vscg7nagnmbmasdld8lkl1m2.apps.googleusercontent.com',
                        'secret' => '_fDI-jgYOYjD_wAFMZGc9eIa'
                    ) ,
                    'scope' => 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
                ) ,
 
                'Facebook' => array(
                    'enabled' => false,
                    'keys' => array(
                        'id' => (ENVIRONMENT == 'development') ? 'DEVELOPMENT_APP_ID' : 'PRODUCTION_APP_ID',
                        'secret' => (ENVIRONMENT == 'development') ? 'DEVELOPMENT_APP_SECRET' : 'PRODUCTION_APP_SECRET'
                    ) ,
                    'scope' => 'email, public_profile'
                ) ,
 
                'Twitter' => array(
                    'enabled' => false,
                    'keys' => array(
                        'key' => 'APP_KEY',
                        'secret' => 'APP_SECRET'
                    )
                )
            ) ,
 
            'hybrid_debug' => array(
                'debug_mode' => 'info', /* none, debug, info, error */
                'debug_file' => APPPATH . '/logs/log-' . date('Y-m-d') . '.php'
            )
        );
 
        return $config;
    }


}
