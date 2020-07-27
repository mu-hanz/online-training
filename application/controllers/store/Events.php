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
        $this->output->set_template('store/layout/store');
		$this->load->section('mainmenu', 'store/layout/main_menu');
		
		$this->load->section('footer', 'store/layout/footer');
    }

    public function index($slug)
	{	

        $this->load->js('assets/store/js/events.init.js');


        if(!$slug){
            show_404();
        }

        $data_event = $this->Post_m->view_event($slug);

        if($data_event->num_rows() <= 0){
            show_404();
        }

        $event = $data_event->row();

		$data = array(
			'event'      => $event,
		);

		$this->output->set_title($this->muhanz->app_title($event->event_name));

		$this->load->view('store/event_detail', $data);
    }
    
    public function all_events()
	{	
        // echo $this->input->get('s', TRUE);

        $this->load->js('assets/store/js/events.init.js');

        
        $this->output->set_title($this->muhanz->app_title('Semua Pelatihan'));

        $data = array(
			'event'      => $this->Post_m->get_event_all($this->perPage),
        );
        
		$this->load->view('store/event_grid', $data);
    }


    public function group($group)
	{	

        $this->load->js('assets/store/js/events.init.js');

        
        $this->output->set_title($this->muhanz->app_title('Semua Pelatihan'));

        $data = array(
			'event'      => $this->Post_m->get_event_all($this->perPage),
        );
        
		$this->load->view('store/event_grid', $data);
    }

    public function load_events_ajax()
	{	

        $this->output->unset_template();
        $offset = $this->perPage * $this->input->post('offset');
		$event     = $this->Post_m->get_event_all($this->perPage, $offset);
        
        foreach($event as $data){

            echo '<div class="col-xl-4 col-lg-6 col-md-6 new-grid">
					<div class="box_grid wow">
					<figure class="block-reveal">	
					<div class="block-horizzontal"></div>
						<a href="'.base_url('events/detail/'.$data->event_slug).'" class="mlink">
							<div class="preview"><span>Lihat Training</span></div><img src="'.base_url($data->event_thumbs).'" class="img-fluid" alt="'.$data->event_name.'">
						</a>
						</figure>
						<div class="wrapper">
							<small>'.$data->group_name.'</small>
							<h4 class="event-name">'.$data->event_name.'</h4>
						</div>
						<ul>
							<li><i class="icon_shield_alt  text-primary"></i> '.$data->cert_name.'</li>
							<li><a href="'.base_url('events/detail/'.$data->event_slug).'" class="mlink">View Detail</a></li>
						</ul>
					</div>
                </div>';
                
        }
        
		exit;
    }
    
}