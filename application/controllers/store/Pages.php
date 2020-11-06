<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	//---Templating----//
    public function __construct()
    {
        parent::__construct();
		$this->_init();
		
        $this->load->model('Post_m');
        $this->load->model('Terms_m');

        $this->perPage = 3;
    }

    private function _init()
    {
        $this->output->set_template('main/layout/index');
		$this->load->section('header', 'main/layout/header');
		$this->load->section('footer', 'main/layout/footer');
    }

    public function index($slug)
	{	

        if($slug == 'about-us'){

            $this->output->set_title($this->muhanz->app_title('About Us'));

            $this->load->view('main/about-us');
            
        } else {

        if(!$slug){
            show_404();
        }

        $this->Post_m->update_viewers($slug);

        $data_articles = $this->Post_m->view_articles($slug);

        if($data_articles->num_rows() <= 0){
            show_404();
        }

        $pages = $data_articles->row();

		$data = array(
            'post'              => $pages,
		);

		$this->output->set_title($this->muhanz->app_title($pages->post_title));

        $this->load->view('main/pages', $data);
    }
    }
      
    
}