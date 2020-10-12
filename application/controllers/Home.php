<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \DrewM\MailChimp\MailChimp;
class Home extends CI_Controller {

	//---Templating----//
    public function __construct()
    {
        parent::__construct();
		$this->_init();
		
        $this->load->model('Post_m');
    }

    private function _init()
    {
        $this->output->set_template('main/layout/index');
		$this->load->section('header', 'main/layout/header');
		$this->load->section('footer', 'main/layout/footer');
	}
	
	public function index()
	{	
		$this->load->js('assets/main/js/jquery.magnific-popup.min.js');
		$this->load->js('assets/main/js/magnific.init.js');

		$this->load->js('assets/main/js/owl.carousel.min.js');
		$this->load->js('assets/main/js/owl.init.js');

		$this->load->js('assets/main/js/jquery.flexslider-min.js');
		$this->load->js('assets/main/js/flexslider.init.js');

		$this->load->js('assets/main/scripts/main.init.js');

		
		$this->load->section('slider', 'main/layout/slider');

		$data_home = array(
			'event_popular'      => $this->Post_m->get_event_all('9')->result(),
			'data_articles'      => $this->Post_m->get_articles_all('3')->result(),
		);

		$this->output->set_title($this->muhanz->app_title('Training Center'));

		$this->load->view('main/home',$data_home);
	}

	public function starter()
	{
		$this->load->view('store/starter');
	}


	public function contact()
	{
		$this->load->view('main/contact');
	}


	public function mailchimp()
	{
		$this->output->unset_template();

		$email = $this->input->post('email');

		$MailChimp = new MailChimp('7b270d30c8f507ebdb7c7208c741169e-us14');
        $list_id = '340ce8a83a';
        $result = $MailChimp->post("lists/$list_id/members", [
            'email_address' => $email,
            'status'        => 'subscribed',
        ]);

        if ($MailChimp->success()) {
			// print_r($result);
			$data = [
				'status' => 'success',
				'message' => 'Terima Kasih!'
			];

			echo json_encode($data);

		} else {
			// echo $MailChimp->getLastError();
			$data = [
				'status' => 'error',
				'message' => 'Sistem sedang dalam perbaikan.'
			];

			echo json_encode($data);
		}
	}
}
