<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller {

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

        $this->load->js('assets/main/js/jquery.magnific-popup.min.js');
		$this->load->js('assets/main/js/magnific.init.js');
        $this->load->js('assets/main/scripts/events.init.js');


        if(!$slug){
            show_404();
        }

        $data_event = $this->Post_m->view_event($slug);

        if($data_event->num_rows() <= 0){
            show_404();
        }

        $event = $data_event->row();

		$data = array(
            'event'                     => $event,
            'promo_flexi'               => $this->Post_m->promo_flexi($event->event_id)->row(),
 
            'campaign'                  => $this->Post_m->get_data_promotions_campaign($event->event_id),
		);

		$this->output->set_title($this->muhanz->app_title($event->event_name));

        $this->load->view('main/event_detail', $data);
        
        
    }
    
    public function all_events()
	{	
        
        $config["base_url"]             = base_url() . "events/all-events";
        $config['total_rows']           = $this->Post_m->get_event_all()->num_rows();
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


        
        $this->output->set_title($this->muhanz->app_title('Semua Pelatihan'));

        $data = array(
			'event'      => $this->Post_m->get_event_all($config["per_page"], $from)->result(),
        );
        
        $this->load->view('main/events', $data);
        
        // print_r($this->Post_m->get_event_all($config["per_page"], $from)->result());
    }

    public function search_events_ajax()
	{
        $this->output->unset_template();

        $data = [
            'url' => base_url('events-search?keyword='.$this->input->get('keyword',TRUE))
        ];
       echo json_encode($data);
    }

    public function search_events()
	{	
        // $this->output->unset_template();
        $query      = $this->input->get('keyword',TRUE);
        $per_page = $this->input->get('page', TRUE);

        if (isset($per_page)){
            $from = $per_page;
        } else {
            $from ='0';
        }

        $perpage = 9;

        $count = $this->Post_m->get_event_search_count($query)->num_rows();

        $config["base_url"]             = base_url() . "events-search";
        $config['total_rows']           = $count;
        $config['per_page']             = $perpage;
        $config['query_string_segment'] = 'page';
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;

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
        
    
        $this->output->set_title($this->muhanz->app_title('Pencarian: '.$query));

        $data = array(
            'event'      => $this->Post_m->get_event_all($config["per_page"], $from, $query)->result(),
            'keyword'    => $query,
            'count'     => $count
        );
        
		$this->load->view('main/event_search', $data);
    }

    public function events_group($termid, $group)
	{	
        
        $config["base_url"]             = base_url() . "events-groups/".$termid.'/'.$group;
        $config['total_rows']           = $this->Post_m->get_event_group_count($termid)->num_rows();
        $config['per_page']             = '9';
        $config['uri_segment']          = 4;
        $config['query_string_segment'] = 'start';
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


        
        $this->output->set_title($this->muhanz->app_title('Semua Pelatihan'));

        $data = array(
			'event'      => $this->Post_m->get_event_group($config["per_page"], $from, $termid)->result(),
        );
        
		$this->load->view('main/events', $data);
    }

    public function events_type($termid, $type)
	{	
        
        $config["base_url"]             = base_url() . "events-type/".$termid.'/'.$type;
        $config['total_rows']           = $this->Post_m->get_event_type_count($termid)->num_rows();
        $config['per_page']             = '9';
        $config['uri_segment']          = 4;
        $config['query_string_segment'] = 'start';
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


        
        $this->output->set_title($this->muhanz->app_title('Semua Pelatihan'));

        $data = array(
			'event'      => $this->Post_m->get_event_type($config["per_page"], $from, $termid)->result(),
        );
        
		$this->load->view('main/events', $data);
    }
    
}