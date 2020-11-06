<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotions extends CI_Controller {

	//---Templating----//
    public function __construct()
    {
        parent::__construct();
		$this->_init();
		
        $this->load->model('Post_m');

        $this->perPage = 6;
    }

    private function _init()
    {
        $this->output->set_template('main/layout/index');
		$this->load->section('header', 'main/layout/header');
		$this->load->section('footer', 'main/layout/footer');
    }

    public function index($slug)
	{	

    }

    public function all_promotions() {
        $config["base_url"]             = base_url() . "promotions/all-promotions";
        $config['total_rows']           = $this->Post_m->get_promotions_all()->num_rows();
        $config['per_page']             = '9';
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


        
        $this->output->set_title($this->muhanz->app_title('All Promotions'));

        $data = array(
			'promotions'      => $this->Post_m->get_promotions_all($config["per_page"], $from)->result(),
        );
        
		$this->load->view('main/promotions', $data);
    }

    public function detail_promotions($slug) {

        $this->load->js('assets/main/js/jquery.countdown.min.js');
        $this->load->js('assets/main/js/countdown.init.js');

        $row = $this->Post_m->get_data_promotions($slug);

        $config["base_url"]             = base_url() . "promotions/detail-promotion/" .$slug;
        $config['total_rows']           = $this->Post_m->get_detail_promotions_all($row->promotions_id)->num_rows();
        $config['per_page']             = '9';
        $config['uri_segment']          = 4;
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
        $from = $this->uri->segment(4);


        
        $this->output->set_title($this->muhanz->app_title('All Promotions'));

        $data = array(
            'promotions'            => $this->Post_m->get_detail_promotions_all($row->promotions_id, $config["per_page"], $from)->result(),
            'promotions_image'      => $row->promotions_image,
            'promotions_name'       => $row->promotions_name,
            'promotions_content'    => $row->promotions_content,
            'start_date'            => $row->start_date,
            'end_date'              => $row->end_date
        );
        
		$this->load->view('main/promotions_detail', $data);
    }
    
}