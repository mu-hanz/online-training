<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Connect extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Connect_m');
    }

    public function index($provider)
    {
     
        try {
			$adapter = $this->hybridauth->HA->authenticate($provider);
			$profile = $adapter->getUserProfile();

            $isConnected = $adapter->isConnected();

            if($isConnected){
 
                $check_user = $this->Connect_m->checkUser($profile);
            

                if($check_user){

                    if ($this->ion_auth->login($profile->email, $profile->identifier))
                    {
                        $this->hybridauth->HA->disconnectAllAdapters();
                        // redirect('users/dashboard');
                        echo "
                        <script>
                            if (window.opener.closeAuthWindow) {
                                window.opener.closeAuthWindow();
                                window.opener.location.reload();
                            }
                        </script>";
                        
                    } else {

                        if ($this->ion_auth->login_connect($profile->email, $profile->identifier)) {

                            $this->hybridauth->HA->disconnectAllAdapters();
                            // redirect('users/dashboard');
                            echo "
                            <script>
                                if (window.opener.closeAuthWindow) {
                                    window.opener.closeAuthWindow();
                                    window.opener.location.reload();
                                }
                            </script>";
    
                        } else {
                            $this->hybridauth->HA->disconnectAllAdapters();
                            redirect('account/login');
                        }


                    }
                    
                    
                    

                } else {
                    $this->hybridauth->HA->disconnectAllAdapters();
                    redirect('account/login');
                }

            } else {
                $this->hybridauth->HA->disconnectAllAdapters();
                redirect('account/login');
            }
            
            
            
            
            // echo '<pre>',print_r($profile,1),'</pre>';
            

            // $img = str_replace("=s96-c","=s500-c",$profile->photoURL);

            // echo '<img src="'.$img.'">';

            

		} catch (Exception $e) {
			show_error($e->getMessage());
		}
    }
}