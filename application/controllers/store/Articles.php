<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller {

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
        $this->load->css('assets/main/css/jssocials.css');
        $this->load->css('assets/main/css/jssocials-theme-flat.css');

        $this->load->js('assets/main/scripts/jssocials.min.js');
        $this->load->js('assets/main/scripts/share.init.js');

        if(!$slug){
            show_404();
        }

        $this->Post_m->update_viewers($slug);

        $data_articles = $this->Post_m->view_articles($slug);

        if($data_articles->num_rows() <= 0){
            show_404();
        }

        $articles = $data_articles->row();

		$data = array(
            'articles'      => $articles,
            'data_articles'      => $this->Post_m->get_articles_all('2')->result(),
            'data_category'     => $this->Terms_m->get_terms('category-articles', '')->result(),
		);

		$this->output->set_title($this->muhanz->app_title($articles->post_title));

		$this->load->view('main/articles_detail', $data);
    }
    
    public function all_articles()
	{	
        

        $config["base_url"]             = base_url() . "articles/all-articles";
        $config['total_rows']           = $this->Post_m->get_articles_all()->num_rows();
        $config['per_page']             = '8';
        $config['uri_segment']          = 3;
        $config['attributes'] = array('class' => 'page-link');

        $config['full_tag_open']  = '<ul class="pagination justify-content-center mb-0">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link']      = 'Start';
        $config['first_tag_open']  = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link']      = 'End';
        $config['last_tag_open']  = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link']      = 'Next';
        $config['next_tag_open']  = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link']      = 'Prev';
        $config['prev_tag_open']  = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open']  = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open']  = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $from = $this->uri->segment(3);

        
        $this->output->set_title($this->muhanz->app_title('Semua Artikel'));

        $data = array(
            'data_articles'         => $this->Post_m->get_articles_all($config["per_page"], $from)->result(),
            'popular_articles'      => $this->Post_m->get_articles_popular(),
        );
        
        $this->load->view('main/articles', $data);
        
    }


    public function category_articles($category)
	{	
        // $this->load->js('assets/store/js/articles.init.js');
        
        $this->output->set_title($this->muhanz->app_title('Semua Artikel'));

        $data = array(
			'articles'      => $this->Post_m->get_articles_all($this->perPage),
        );
        
		$this->load->view('main/articles', $data);
    }

    
    
}