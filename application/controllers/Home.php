<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->output->set_template('store/layout/store');
		$this->load->section('mainmenu', 'store/layout/main_menu');
		
		$this->load->section('footer', 'store/layout/footer');
	}
	
	public function index()
	{	

		$this->load->js('assets/store/js/jquery.flexslider.js');
		$this->load->js('assets/store/js/slider.js');

		$data_slider = array(
			'data_content'      => $this->Post_m->get_event_all('4'),
		);
		$this->load->section('slider', 'store/layout/slider', $data_slider);


		$data_home = array(
			'event_popular'      => $this->Post_m->get_event_all('5'),
			'data_articles'      => $this->Post_m->get_articles_all('4'),
		);

		$this->output->set_title($this->muhanz->app_title('Training Center'));

		$this->load->view('store/home', $data_home);
	}

	public function starter()
	{
		$this->load->view('store/starter');
	}
}
