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
        $this->output->set_template('store/layout/store');
		$this->load->section('mainmenu', 'store/layout/main_menu');
		
		$this->load->section('footer', 'store/layout/footer');
    }

    public function index($slug)
	{	
        $this->load->css('assets/store/css/blog.css');

        $this->load->js('assets/store/js/articles.init.js');


        if(!$slug){
            show_404();
        }

        $data_articles = $this->Post_m->view_articles($slug);

        if($data_articles->num_rows() <= 0){
            show_404();
        }

        $articles = $data_articles->row();

		$data = array(
            'articles'      => $articles,
            'data_articles'      => $this->Post_m->get_articles_all('4'),
            'data_category'     => $this->Terms_m->get_terms('category-articles', '')->result(),
		);

		$this->output->set_title($this->muhanz->app_title($articles->post_title));

		$this->load->view('store/articles_detail', $data);
    }
    
    public function all_articles()
	{	
        $this->load->js('assets/store/js/articles.init.js');
        
        $this->output->set_title($this->muhanz->app_title('Semua Artikel'));

        $data = array(
			'articles'      => $this->Post_m->get_articles_all($this->perPage),
        );
        
		$this->load->view('store/articles_grid', $data);
    }


    public function load_articles_ajax()
	{	

        $this->output->unset_template();
        $offset = $this->perPage * $this->input->post('offset');
		$articles     = $this->Post_m->get_articles_all($this->perPage, $offset);
        
        foreach($articles as $data){
            $post_title = strip_tags($data->post_title);
            $content = strip_tags($data->post_content);
            echo '<div class="col-xl-4 col-lg-6 col-md-6 new-grid">
					<div class="box_grid wow">
					<figure class="block-reveal blog-grid">	
						<a href="'.base_url('articles/detail/'.$data->post_slug).'" class="mlink">
							<img src="'.base_url($data->post_image).'" class="img-fluid blog-grid-img" alt="'.$data->post_title.'">
						</a>
						</figure>
						<div class="wrapper">
                        <small><i class="icon_folder-alt"></i>  '.$data->name.'</small> <small><i class="icon_clock_alt"></i>  '.date("d M Y H:i", strtotime($data->post_date)).'</small>
                        <a href="'.base_url('articles/detail/'.$data->post_slug).'" class="mlink"><h4 class="event-name1 mt-2">'.character_limiter($post_title, 100).'</h4></a>
							<p>'.character_limiter($content, 100).'</p>
						</div>
					</div>
                </div>';
                
        }
        
		exit;
    }
    
}