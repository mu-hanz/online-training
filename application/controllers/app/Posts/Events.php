<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Events extends CI_Controller
{

    //---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->muhanz->check_auth();
        $this->_init();
        $this->load->model('Post_m');
        $this->load->model('Terms_m');

        $config = array(
			'table'       => 'posts',
			'id'          => 'id_post',
			'field'       => 'post_slug',
			'title'       => 'post_title',
			'replacement' => 'dash', // Either dash or underscore
        );
        
        $this->load->library('slug', $config);

    }

    private function _init()
    {
        $this->output->set_template('app/layout/webadmin');
		$this->load->section('topbar', 'app/layout/mz_topbar');
		$this->load->section('menubar', 'app/layout/mz_menubar');

    }

    public function list_event()
    {
        

        // css
        $this->load->css('assets/app/libs/datatables/dataTables.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/responsive.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/buttons.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/select.bootstrap4.min.css');
        $this->load->css('assets/sweetalert/sweetalert2.min.css');
        if($this->input->cookie('themes') == 'dark'){
            $this->load->css('assets/app/css/data-list-view-dark.css');
        } else {
            $this->load->css('assets/app/css/data-list-view.css');
        }

       

        // js
        $this->load->js('assets/app/libs/datatables/jquery.dataTables.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.bootstrap4.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.responsive.min.js');
        $this->load->js('assets/app/libs/datatables/responsive.bootstrap4.min.js');
        $this->load->js('assets/sweetalert/sweetalert2.all.min.js');
        $this->load->js('assets/app/js/pages/event.datatables.js');

        $title = 'List Events';

        $data = array(
            'title'             => $title,
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Events' , '/webadmin/posts/events');
        $this->breadcrumbs->push('Create', '/webadmin/posts/events/create');
        // View
        $this->load->view('app/post/event_list', $data);
    }

    public function list_content()
    {
        // css
        $this->load->css('assets/app/libs/datatables/dataTables.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/responsive.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/buttons.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/select.bootstrap4.min.css');
        $this->load->css('assets/sweetalert/sweetalert2.min.css');

        // js
        $this->load->js('assets/app/libs/datatables/jquery.dataTables.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.bootstrap4.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.responsive.min.js');
        $this->load->js('assets/app/libs/datatables/responsive.bootstrap4.min.js');
        $this->load->js('assets/sweetalert/sweetalert2.all.min.js');
        $this->load->js('assets/app/js/pages/content.datatables.js');

        $title = 'Content List';

        $data = array(
            'title'             => $title,
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Events' , '/webadmin/posts/events');
        $this->breadcrumbs->push('Content', '/webadmin/posts/events/content');
        // View
        $this->load->view('app/post/content_list', $data);
    }

    public function create()
    {   
        $this->load->css('assets/sweetalert/sweetalert2.min.css');
        
        $this->load->js('assets/sweetalert/sweetalert2.all.min.js');
        $this->load->js('assets/app/libs/select2/select2.min.js');
        $this->load->js('assets/app/libs/flatpickr/flatpickr.min.js');
        $this->load->js('assets/app/js/pages/form-advanced.init.js');
        $this->load->js('assets/app/js/pages/event-content.init.js');
        $title = 'Create New Events';
        
        $data = array(
            'title'             => $title,
            'action'            => base_url('webadmin/posts/events/save_event'),
            'cancel'            => false,
            'data_content'      => $this->Post_m->data_content(),
            'data_group'        => $this->Terms_m->get_terms('category-groups', '0')->result(),
            'data_certificate'  => $this->Terms_m->get_terms('certification-events', '0')->result(),
            'data_category'     => $this->Terms_m->get_terms('category-events', '0')->result(),
            'data_type'         => $this->Terms_m->get_terms('events-type', '0')->result(),
            'data_regional'     => $this->Terms_m->get_terms('events-regional', '0')->result(),
            'data_location'     => $this->Terms_m->get_terms('events-location', '0')->result(),
            'data_event'      => array()
        );

        
        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Events' , '/webadmin/posts/events');
        $this->breadcrumbs->push('Create', '/webadmin/posts/events/create');
        // View
        $this->load->view('app/post/events_detail', $data);

    }

    public function save_event()
    {
        $this->output->unset_template();

        $sc = $this->input->post('schedule_date');
        $redirect_url = 'webadmin/posts/events/list_event';
        if($sc){
            $schedule_date = date('Y-m-d H:i:s', strtotime($this->input->post('schedule_date').' '.$this->input->post('schedule_time')));
            $schedule_status = '1';
            $event_status = 'on_schedule';
        } else {
            $schedule_date = date('Y-m-d H:i:s', now());
            $schedule_status = '0';
            $event_status = 'publish';
        }

        if($this->input->post('event_register') == '0'){
            $event_register = $this->input->post('event_register');
        } else {
            $event_register = '1';
        }
        
        $data = array(
            'post_id'           => $this->input->post('post_content'),
            'group_id'          => $this->input->post('group_id'),
            'certificate_id'    => $this->input->post('certificate_id'),
            'type_id'           => $this->input->post('type_id'),
            'location_id'       => $this->input->post('location_id'),
            'regional_id'       => $this->input->post('regional_id'),
            'category_id'       => $this->input->post('category_id'),
            'link_streaming'    => $this->input->post('link_streaming'),
            'streaming_id'      => $this->input->post('streaming_id'),
            'streaming_key'     => $this->input->post('streaming_key'),
            'event_type'        => $this->input->post('event_type'),
            'event_name'        => $this->input->post('event_name'),
            'event_subtitle'    => $this->input->post('event_subtitle'),
            'event_sku'         => $this->input->post('event_sku'),
            'event_slug'        => $this->slug->create_uri($this->input->post('event_name').'-'.$this->input->post('event_type').'-'.$this->input->post('event_group_name').'-'.$this->input->post('event_regional_name').'-'.$this->input->post('event_sku')),
            'event_images'      => str_ireplace(base_url(), "/", $this->input->post('cover')),
            'event_thumbs'      => str_ireplace(base_url(), "/", $this->input->post('thumbs')),
            'event_author'      => $this->ion_auth->user()->row()->id,
            'event_cost'        => $this->input->post('event_cost'),
            'event_cost_promo'  => $this->input->post('event_cost_promo'),
            'event_duration'    => $this->input->post('event_duration'),
            'event_start_date'  => $this->input->post('event_start_date'),
            'event_start_time'  => $this->input->post('event_start_time'),
            'event_end_date'    => $this->input->post('event_end_date'),
            'event_end_time'    => $this->input->post('event_end_time'),
            'event_close_date'  => $this->input->post('event_close_date'),
            'event_close_time'  => $this->input->post('event_close_time'),
            'event_max_participant'  => $this->input->post('event_max_participant'),
            'event_video'       => $this->input->post('event_video'),
            'event_schedule'    => $schedule_status,
            'event_schedule_date' => $schedule_date,
            'event_status'      => $event_status,
            'event_register'     => $event_register,
        );

        $insert_event = $this->Post_m->insert_event($data);
        if ($insert_event) {
            $this->muhanz->success($this->lang->line('save_success'), $redirect_url);
        } else {
            $this->muhanz->error($this->lang->line('save_error'), $redirect_url);
        }

    }


    public function edit_event($id)
    {   
        $this->load->css('assets/sweetalert/sweetalert2.min.css');
        
        $this->load->js('assets/sweetalert/sweetalert2.all.min.js');
        $this->load->js('assets/app/libs/select2/select2.min.js');
        $this->load->js('assets/app/libs/flatpickr/flatpickr.min.js');
        $this->load->js('assets/app/js/pages/form-advanced.init.js');
        $this->load->js('assets/app/js/pages/event-content.init.js');
        $this->load->js('assets/app/js/pages/event.init.js');

        $title = 'Edit Events';

        $data = array(
            'title'             => $title,
            'action'            => base_url('webadmin/posts/events/update_event/'.$id),
            'cancel'            => true,
            'data_event'        => $this->Post_m->get_event($id),
            'data_content'      => $this->Post_m->data_content(),
            'data_group'        => $this->Terms_m->get_terms('category-groups', '0')->result(),
            'data_certificate'  => $this->Terms_m->get_terms('certification-events', '0')->result(),
            'data_category'     => $this->Terms_m->get_terms('category-events', '0')->result(),
            'data_type'         => $this->Terms_m->get_terms('events-type', '0')->result(),
            'data_regional'     => $this->Terms_m->get_terms('events-regional', '0')->result(),
            'data_location'     => $this->Terms_m->get_terms('events-location', '0')->result(),
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Events' , '/webadmin/posts/events');
        $this->breadcrumbs->push('Edit Event', '/webadmin/posts/events/create/content');
        // View
        $this->load->view('app/post/events_detail', $data);

    }

    public function update_event($id)
    {
        $this->output->unset_template();

        $redirect_url = 'webadmin/posts/events/edit_event/'.$id;

        $sc = $this->input->post('schedule_date');
        if($sc){
            $schedule_date = date('Y-m-d H:i:s', strtotime($this->input->post('schedule_date').' '.$this->input->post('schedule_time')));
            $schedule_status = '1';
            $event_status = 'on_schedule';
        } else {
            $schedule_date = date('Y-m-d H:i:s', now());
            $schedule_status = '0';
            $event_status = 'publish';
        }

        if($this->input->post('event_register') == '0'){
            $event_register = $this->input->post('event_register');
        } else {
            $event_register = '1';
        }

        $data = array(
            'post_id'           => $this->input->post('post_content'),
            'group_id'          => $this->input->post('group_id'),
            'certificate_id'    => $this->input->post('certificate_id'),
            'type_id'           => $this->input->post('type_id'),
            'location_id'       => $this->input->post('location_id'),
            'regional_id'       => $this->input->post('regional_id'),
            'category_id'       => $this->input->post('category_id'),
            'link_streaming'    => $this->input->post('link_streaming'),
            'streaming_id'      => $this->input->post('streaming_id'),
            'streaming_key'     => $this->input->post('streaming_key'),
            'event_type'        => $this->input->post('event_type'),
            'event_name'        => $this->input->post('event_name'),
            'event_subtitle'    => $this->input->post('event_subtitle'),
            'event_sku'         => $this->input->post('event_sku'),
            'event_slug'        => $this->slug->create_uri($this->input->post('event_name').'-'.$this->input->post('event_type').'-'.$this->input->post('event_group_name').'-'.$this->input->post('event_regional_name').'-'.$this->input->post('event_sku'), $id),
            'event_images'      => str_ireplace(base_url(), "/", $this->input->post('cover')),
            'event_thumbs'      => str_ireplace(base_url(), "/", $this->input->post('thumbs')),
            'event_author'      => $this->ion_auth->user()->row()->id,
            'event_cost'        => $this->input->post('event_cost'),
            'event_cost_promo'  => $this->input->post('event_cost_promo'),
            'event_duration'    => $this->input->post('event_duration'),
            'event_start_date'  => $this->input->post('event_start_date'),
            'event_start_time'  => $this->input->post('event_start_time'),
            'event_end_date'    => $this->input->post('event_end_date'),
            'event_end_time'    => $this->input->post('event_end_time'),
            'event_close_date'  => $this->input->post('event_close_date'),
            'event_close_time'  => $this->input->post('event_close_time'),
            'event_max_participant'  => $this->input->post('event_max_participant'),
            'event_video'  => $this->input->post('event_video'),
            'event_schedule'    => $schedule_status,
            'event_schedule_date' => $schedule_date,
            'event_status'      => $event_status,
            'event_register'     => $event_register,
        );

        $update_event = $this->Post_m->update_events($id, $data);
        if ($update_event) {
            $this->muhanz->success($this->lang->line('update_success'), $redirect_url);
        } else {
            $this->muhanz->error($this->lang->line('update_error'), $redirect_url);
        }


    }

    public function content()
    {   
        $this->load->css('assets/sweetalert/sweetalert2.min.css');
        
        $this->load->js('assets/sweetalert/sweetalert2.all.min.js');
        $this->load->js('assets/tinymce/tinymce.min.js');
        $this->load->js('assets/tinymce/tinymce.init.js');
        $this->load->js('assets/app/js/pages/event-content.init.js');

        $title = 'Create New Content';

        $data = array(
            'title'             => $title,
            'action'            => base_url('webadmin/posts/events/save_content'),
            'cancel'            => false,
            'data_content'      => array()
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Events' , '/webadmin/posts/events');
        $this->breadcrumbs->push('Content', '/webadmin/posts/events/create/content');
        // View
        $this->load->view('app/post/events_content', $data);

    }

    public function save_content()
    {
        $this->output->unset_template();

        if (!empty($_POST['draft'])) {
            $post_status = 'draft';
        } else {
            $post_status = 'publish';
        }

        $data = array(
            'post_title'    => $this->input->post('post_title'),
            'post_author'   => $this->ion_auth->user()->row()->id,
            'post_content'  => $this->input->post('post_content'),
            'post_slug'     => $this->slug->create_uri($this->input->post('post_title')),
            'post_type'     => 'events-content',
            'post_date'     => date('Y-m-d H:i:s', now()),
            'post_modifed'  => date('Y-m-d H:i:s', now()),
            'post_status'   => $post_status,
            'post_image'    => str_ireplace(base_url(), "/", $this->input->post('cover')),
            'post_thumbs'   => str_ireplace(base_url(), "/", $this->input->post('thumbs')),
        );

        $insert_content = $this->Post_m->insert_content($data);
        if ($insert_content) {
            $this->muhanz->success($this->lang->line('save_success'), 'webadmin/posts/events/list_content');
        } else {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/posts/events/list_content');
        }

    }


    public function edit_content($id)
    {   
        $this->load->css('assets/sweetalert/sweetalert2.min.css');
        
        $this->load->js('assets/sweetalert/sweetalert2.all.min.js');
        $this->load->js('assets/tinymce/tinymce.min.js');
        $this->load->js('assets/tinymce/tinymce.init.js');
        $this->load->js('assets/app/js/pages/event-content.init.js');

        $title = 'Edit Events Content';

        $data = array(
            'title'             => $title,
            'action'            => base_url('webadmin/posts/events/update_content/'.$id),
            'cancel'            => true,
            'data_content'      => $this->Post_m->get_content($id)
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Events' , '/webadmin/posts/events');
        $this->breadcrumbs->push('Edit Content', '/webadmin/posts/events/create/content');
        // View
        $this->load->view('app/post/events_content', $data);

    }


    public function update_content($id)
    {
        $this->output->unset_template();

        $data = array(
            'post_title'    => $this->input->post('post_title'),
            'post_author'   => $this->ion_auth->user()->row()->id,
            'post_content'  => $this->input->post('post_content'),
            'post_slug'     => $this->slug->create_uri($this->input->post('post_title'), $id),
            'post_modifed'  => date('Y-m-d H:i:s', now()),
            'post_image'    => str_ireplace(base_url(), "/", $this->input->post('cover')),
            'post_thumbs'   => str_ireplace(base_url(), "/", $this->input->post('thumbs')),
        );

        $update_post = $this->Post_m->update_post($id, $data);
        if ($update_post) {
            $this->muhanz->success($this->lang->line('save_success'), 'webadmin/posts/events/edit_content/'.$id);
        } else {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/posts/events/edit_content/'.$id);
        }

    }

    public function delete_content($id)
    {
        $this->output->unset_template('layout');

        if (isset($id)) {
            if ($this->Post_m->delete_permanent($id)) {
                $this->muhanz->success($this->lang->line('delete_success'), 'webadmin/posts/events/list_content');
            } else {
                $this->muhanz->error($this->lang->line('delete_error'), 'webadmin/posts/events/list_content');
            }
        } else {
            $this->muhanz->error($this->lang->line('delete_error'), 'webadmin/posts/events/list_content');
        }
    }



    public function json_event()
    {
        
        $this->output->unset_template();

        function is_img($event_thumbs, $event_images)
        {   
            if(!empty($event_thumbs)){
                $event_thumbs = $event_thumbs;
            } else if(!empty($event_images)){
                $event_thumbs = $event_images;
            } else {
                $event_thumbs = 'assets/app/images/img-default.png';
            }

            $data = ' <img class="card-img-top img-fluid" src="'.base_url($event_thumbs).'" id="thumbs" style="width:170px">';
            
            return $data;
        }


        function is_date($event_start_date, $event_start_time, $event_end_date, $event_end_time, $event_duration, $event_type)
        {
            $start_date = date("d M Y H:i:s", strtotime($event_start_date.' '.$event_start_time));
            $end_date = date("d M Y H:i:s", strtotime($event_end_date.' '.$event_end_time));

            $data = 'Start Date : '.$start_date.'<br> End Date : '.$end_date.'<br> Duration : '.$event_duration;
            
            if($event_type !== 'e-training' && $event_type !== 'in-house-training'){
            
                $data = 'Start Date : '.$start_date.'<br> End Date : '.$end_date.'<br> Duration : '.$event_duration;
            
            } else {
                
                $data = 'Start Date : -<br> End Date : -<br> Duration : '.$event_duration;
                
            }
            
            return $data;
            
        }

        function is_event($event_name, $event_subtitle, $event_sku, $category, $type, $group, $certificate, $regional, $address, $location)
        {
            
            $type_to_initial = explode(" ", $type);
            $type_initial = "";
            foreach ($type_to_initial as $i) {
                $type_initial .= $i;
            }

            $data = '
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <strong>'.$event_name.' <i>('.$type_initial.')</i></strong><br>
                    <small><i>'.$event_subtitle.'</i></small>
                </div>
                <div class="col-lg-6">
                    Type : '.$type.'<br>
                    SKU : '.$event_sku.'<br>
                    Category : '.$category.'
                </div>
                <div class="col-lg-6">
                    Group : '.$group.'<br>
                    Certificate : '.$certificate.'<br>
                    Regional : '.$regional.'
                </div>
                <div class="col-lg-12">
                    Location : '.$location.' ('.$address.')
                </div>
            </div>
        ';
            
            return $data;
        }

        function is_action($event_id, $event_slug)
        {
    
            $data = '<a href="'.base_url('webadmin/posts/events/edit_event/'.$event_id).'" class="btn btn-primary btn-sm btn-block mlink"><i class="uil uil-edit"></i> Edit</a>
            <a href="'.base_url('events/detail/'.$event_slug).'" target="_blank" class="btn btn-secondary btn-sm btn-block"><i class="uil uil-eye"></i> View</a>
            <button class="btn btn-danger btn-sm  btn-block"><i class="uil uil-trash-alt"></i> Delete</button>';
            
            return $data;
        }
      

        $this->datatables->select('event_id, event_thumbs, event_images, event_name, event_subtitle, event_sku, event_duration, event_start_date, event_start_time, event_end_date, event_end_time, event_type,event_slug, c.name as category, t.name as type, g.name as group, ct.name as certificate, r.name as regional, l1.description as address, l.name as location');
        $this->datatables->from('events');
        $this->datatables->join('terms as c', 'c.term_id = events.category_id', 'left');
        $this->datatables->join('terms as t', 't.term_id = events.type_id', 'left');
        $this->datatables->join('terms as g', 'g.term_id = events.group_id', 'left');
        $this->datatables->join('terms as ct', 'ct.term_id = events.certificate_id', 'left');
        $this->datatables->join('terms as r', 'r.term_id = events.regional_id', 'left');
        $this->datatables->join('terms as l', 'l.term_id = events.location_id', 'left');
        $this->datatables->join('term_taxonomy as l1', 'l1.term_id = l.term_id', 'left');
        $this->datatables->where('event_status != "deleted"');
        $this->datatables->order_by('event_id', 'desc');
        $this->datatables->group_by('event_id');

        $this->datatables->add_column('detail_event', '$1', "is_event('event_name','event_subtitle','event_sku','category','type','group','certificate','regional','address', 'location')");
        $this->datatables->add_column('event_date', '$1', "is_date('event_start_date','event_start_time','event_end_date','event_end_time','event_duration','event_type')");
        $this->datatables->add_column('event_img', '$1', "is_img('event_thumbs','event_images')");
        $this->datatables->add_column('action', '$1', "is_action('event_id','event_slug')");
        
      
        return print_r($this->datatables->generate());
    }

    public function json_content()
    {
        $this->output->unset_template('layout');

        function is_action($id_post)
        {
            $CI =& get_instance();

            $count_post = $CI->Post_m->check_post_used($id_post);
            $data = '';
            $data .= '<a href="'.base_url('webadmin/posts/events/edit_content/'.$id_post).'" class="btn btn-primary btn-sm btn-block mlink"><i class="uil uil-edit"></i> Edit</a>';
            
            if($count_post <= 0){
                $data .= '<button class="btn btn-danger btn-sm  btn-block del" data-id="'.$id_post.'"><i class="uil uil-trash-alt"></i> Delete</button>';
            }
           
        
            return $data;
        }
      

        $this->datatables->select('id_post, post_status, post_title, post_date, post_modifed, a.first_name as author_name, e.first_name as author_name_edit');
        $this->datatables->from('posts');
        $this->datatables->join('users as a', 'a.id = posts.post_author', 'left');
        $this->datatables->join('users as e', 'e.id = posts.post_author_modifed', 'left');
        $this->datatables->where('post_type','events-content');
        $this->datatables->order_by('id_post', 'desc');
        $this->datatables->group_by('id_post');
        $this->datatables->add_column('action', '$1', "is_action('id_post')");
        
        return print_r($this->datatables->generate());
    }

}
