<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Events extends CI_Controller
{

    //---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->_init();
        if (!$this->ion_auth->logged_in()) {
            $this->session->set_userdata('redirect_login', $this->agent->referrer());
            redirect('webadmin/login');
        }

        $this->load->model('Post_m');
        $this->load->model('Terms_m');

        $config = array(
			'table'       => 'posts',
			'id'          => 'post_id',
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

    public function index()
    {

        if (!isset($_GET['type'])) {
            show_404();
        } else {
            $type = $_GET['type'];
        }
        // css
        $this->load->css('assets/system/css/dataTables.bootstrap4.min.css');
        $this->load->css('assets/system/css/buttons.bootstrap4.min.css');
        $this->load->css('assets/system/css/responsive.bootstrap4.min.css');
        $this->load->css('assets/system/css/sweetalert2.min.css');
        // js
        $this->load->js('assets/system/js/sweetalert2.min.js');
        $this->load->js('assets/system/js/jquery.dataTables.min.js');
        $this->load->js('assets/system/js/dataTables.bootstrap4.min.js');
        $this->load->js('assets/system/js/dataTables.responsive.min.js');
        $this->load->js('assets/system/js/responsive.bootstrap4.min.js');

        $data = array(
            'count_all'     => $this->Post_m->count_post($type, 'all'),
            'count_publish' => $this->Post_m->count_post($type, 'publish'),
            'count_trash'   => $this->Post_m->count_post($type, 'trash'),
            'count_draft'   => $this->Post_m->count_post($type, 'draft'),
            'count_schedule'   => $this->Post_m->count_post($type, 'on_schedule'),
        );

        $this->load->js('assets/system/js/scripts/s-post.js');
        $this->output->set_title('Semua Artikel');
        $this->load->view('system/post/list_post', $data);
    }

    public function list_event()
    {
        

        // css
        $this->load->css('assets/app/libs/datatables/dataTables.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/responsive.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/buttons.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/select.bootstrap4.min.css');
        $this->load->css('assets/sweetalert/sweetalert2.min.css');
        $this->load->css('assets/app/css/data-list-view.css');

        // js
        $this->load->js('assets/app/libs/datatables/jquery.dataTables.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.bootstrap4.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.responsive.min.js');
        $this->load->js('assets/app/libs/datatables/responsive.bootstrap4.min.js');
        $this->load->js('assets/sweetalert/sweetalert2.all.min.js');

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
        $this->load->view('app/sample');
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

        if($sc){
            $schedule_date = date('Y-m-d H:i:s', strtotime($this->input->post('schedule_date').' '.$this->input->post('schedule_time')));
            $schedule_status = '1';
            $event_status = 'on_schedule';
            $redirect_url = 'webadmin/posts/events/create';
        } else {
            $schedule_date = date('Y-m-d H:i:s', now());
            $schedule_status = '0';
            $event_status = 'publish';
            $redirect_url = 'webadmin/posts/events/list_event';
        }

        $type_to_initial = explode(" ", $this->input->post('type_id_name'));
        $type_initial = "";
        foreach ($type_to_initial as $i) {
            $type_initial .= $i[0];
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
            'event_name'        => $this->input->post('event_name'),
            'event_subtitle'    => $this->input->post('event_subtitle'),
            'event_sku'         => $this->input->post('event_sku'),
            'event_slug'        => $this->slug->create_uri($this->input->post('event_name').'-'.$type_initial.'-'.$this->input->post('group_id_name').'-'.$this->input->post('regional_id_name')),
            'event_images'      => str_ireplace('media/', "", $this->input->post('cover')),
            'event_thumbs'      => str_ireplace('media/', "", $this->input->post('thumbs')),
            'event_author'      => $this->ion_auth->user()->row()->id,
            'event_cost'        => $this->input->post('event_cost'),
            'event_cost_promo'  => $this->input->post('event_cost_promo'),
            'event_duration'    => $this->input->post('event_duration'),
            'event_start_date'  => $this->input->post('event_start_date'),
            'event_start_time'  => $this->input->post('event_start_time'),
            'event_end_date'    => $this->input->post('event_end_date'),
            'event_end_time'    => $this->input->post('event_end_time'),
            'event_schedule'    => $schedule_status,
            'event_schedule_date'    => $schedule_date,
            'event_status'      => $event_status,
        );

        $insert_event = $this->Post_m->insert_event($data);
        if ($insert_event) {
            $this->muhanz->success($this->lang->line('save_success'), $redirect_url);
        } else {
            $this->muhanz->error($this->lang->line('save_error'), $redirect_url);
        }

    }

    public function content()
    {   
        $this->load->css('assets/sweetalert/sweetalert2.min.css');
        
        $this->load->js('assets/sweetalert/sweetalert2.all.min.js');
        $this->load->js('assets/tinymce/tinymce.min.js');
        $this->load->js('assets/tinymce/tinymce.init.js');
        $this->load->js('assets/app/js/pages/event-content.init.js');

        $title = 'Create New Events';

        $data = array(
            'title'             => $title,
            'action'            => base_url('webadmin/posts/events/save_content'),
            'cancel'            => false,
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
            'post_image'    => str_ireplace(base_url('media/'), "", $this->input->post('cover')),
            'post_thumbs'   => str_ireplace(base_url('media/'), "", $this->input->post('thumbs')),
        );

        $insert_content = $this->Post_m->insert_content($data);
        if ($insert_content) {
            $this->muhanz->success($this->lang->line('save_success'), 'webadmin/posts/events/list_content');
        } else {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/posts/events/list_content');
        }

    }

    public function save_post($type)
    {
        $this->output->unset_template('layout');

        if (!empty($_POST['draft'])) {
            $post_status = 'draft';
            $sc = $this->input->post('scheduler');
            if($sc){
                $post_date = date('Y-m-d H:i:s', strtotime($this->input->post('date_schedule').' '.$this->input->post('time_schedule')));
                $post_status = 'draft';
                $post_scheduler = '1';
            } else {
                $post_date = date('Y-m-d H:i:s', now());
                $post_status = 'draft';
                $post_scheduler = '0';
            }
            
        } else {
            
            $sc = $this->input->post('scheduler');
        
            if($sc){
                $post_date = date('Y-m-d H:i:s', strtotime($this->input->post('date_schedule').' '.$this->input->post('time_schedule')));
                $post_status = 'on_schedule';
                $post_scheduler = '1';
            } else {
                $post_date = date('Y-m-d H:i:s', now());
                $post_status = 'publish';
                $post_scheduler = '0';
            }
        
        }
        
        
        $data = array(
            'post_title'    => $this->input->post('post_title'),
            'post_author'   => $this->ion_auth->user()->row()->id,
            'post_content'  => $this->input->post('post_content'),
            'post_slug'     => $this->Terms_m->slug_check_term($this->input->post('post_slug')),
            'post_type'     => $type,
            'post_date'     => $post_date,
            'post_modifed'  => date('Y-m-d H:i:s', now()),
            'post_status'   => $post_status,
            'post_scheduler'=> $post_scheduler,
            'post_image'    => str_ireplace(base_url('media/'), "", $this->input->post('post_image')),
            'post_template' => $this->input->post('post_template'),

        );

        $insert_post = $this->Post_m->insert_post($data);

        if ($insert_post) {
            if ($type == 'pages') //jika ini pages
            {

                if ($post_status == 'draft') {
                    notify_suscces('Berhasil disimpan.', 'webadmin/post/edit_post/pages/' . $insert_post);
                } else {
                    notify_suscces('Berhasil diposting.', 'webadmin/post?type=pages&filter=all');
                }
            }

            if ($type == 'blog') //jika ini blog
            {
                $tags          = $this->input->post('tags');
                $tags_add      = $this->input->post('tags_add');
                $post_category = $this->input->post('post_category');

                if (isset($tags) && !empty($tags)) // jika tag sebelumnya sudah di buat
                {

                    foreach ($tags as $tag) {
                        $data_rel = array(
                            'object_id'        => $insert_post,
                            'term_taxonomy_id' => $tag,
                        );

                        $this->Terms_m->insert_term('term_relationships', $data_rel);

                        $this->Terms_m->update_count_term($tag);
                    }
                }

                if (isset($tags_add) && !empty($tags_add)) // jika ini tag baru dan belum di buat
                {

                    foreach ($tags_add as $tags) {
                        $data_term = array(
                            'term_id' => $this->Terms_m->id_max_term('terms'),
                            'name'    => $tags,
                            'slug'    => slug($this->Terms_m->slug_check_term($tags)),
                        );

                        $insert_term = $this->Terms_m->insert_term('terms', $data_term);

                        $data_tax = array(
                            'term_taxonomy_id' => $insert_term,
                            'term_id'          => $insert_term,
                            'taxonomy'         => 'tags',
                        );

                        $this->Terms_m->insert_term('term_taxonomy', $data_tax);

                        $data_rel = array(
                            'object_id'        => $insert_post,
                            'term_taxonomy_id' => $insert_term,
                        );

                        $this->Terms_m->insert_term('term_relationships', $data_rel);

                        $this->Terms_m->update_count_term($insert_term);

                    }
                }

                if (isset($post_category) && !empty($post_category)) {
                    // insert detail kategori

                    foreach ($post_category as $category) {
                        $data_rel = array(
                            'object_id'        => $insert_post,
                            'term_taxonomy_id' => $category,
                        );

                        $this->Terms_m->insert_term('term_relationships', $data_rel);
                        $this->Terms_m->update_count_term($category);
                    }
                } else //set to uncategorized
                {
                    $data_rel = array(
                        'object_id'        => $insert_post,
                        'term_taxonomy_id' => '1',
                    );

                    $this->Terms_m->insert_term('term_relationships', $data_rel);
                    $this->Terms_m->update_count_term('1');
                }

                if ($post_status == 'draft') {
                    notify_suscces('Disimpan ke draft.', 'webadmin/post/edit_post/blog/' . $insert_post);
                } else {
                    notify_suscces('Published.', 'webadmin/post?type=blog&filter=all');
                }

            }

            if ($type == 'events') //jika ini events
            {

                $post_category = $this->input->post('post_category');

                $data_rel = array(
                    'object_id'        => $insert_post,
                    'term_taxonomy_id' => $post_category,
                );

                $this->Terms_m->insert_term('term_relationships', $data_rel);
                $this->Terms_m->update_count_term($post_category);

                //insert pengaturan events
                $data_events = array(
                    'id_post'              => $insert_post,
                    'event_subtitle'       => $this->input->post('event_subtitle'),
                    'product_name'         => $this->input->post('product_name'),
                    'event_thumb'          => str_ireplace(base_url('media/'), "", $this->input->post('post_image1')),
                    'event_start_date'     => date("Y-m-d", strtotime($this->input->post('event_start_date'))),
                    'event_early'          => date("Y-m-d", strtotime($this->input->post('event_early'))),
                    'event_end_date'       => date("Y-m-d", strtotime($this->input->post('event_end_date'))),
                    'event_max_early_user' => $this->input->post('event_max_early_user'),
                    'event_price_sale'     => $this->input->post('event_price_sale'),
                    'event_price'          => $this->input->post('event_price'),
                    'event_timing'         => $this->input->post('event_timing'),
                    'event_location'       => $this->input->post('event_location'),
                    'event_regional'       => $this->input->post('event_regional'),
                );

                $this->Post_m->insert_events($data_events);

                //insert testi
                $post_testi = $this->input->post('testi');

                if (isset($post_testi) && !empty($post_testi)) {
                    // insert testimoni
                    foreach ($post_testi as $testi => $value) {
                        $data_testi_name = array(
                            'id_post'    => $insert_post,
                            'name_testi' => $value['name'],
                            'comment'    => $value['comment'],
                            'company'    => $value['company'],
                        );

                        $this->Testi_m->insert_testi($data_testi_name);
                    }
                }

                //insert gallery
                $post_gallery = $this->input->post('post_images_gallery');

                if (isset($post_gallery) && !empty($post_gallery)) {
                    // insert testimoni
                    foreach ($post_gallery as $gallery) {
                        $data_gallery = array(
                            'images'  => str_ireplace(base_url('media/'), "", $gallery),
                            'id_post' => $insert_post,
                        );

                        $this->Gallery_m->insert_gallery($data_gallery);
                    }
                }

                if ($post_status == 'draft') {
                    notify_suscces('Disimpan ke draft.', 'webadmin/post/edit_post/events/' . $insert_post);
                } else {
                    notify_suscces('Published.', 'webadmin/post?type=events&filter=all');
                }

            }
        } else {
            notify_error('Gagal diposting.', 'webadmin/post/create/' . $type);
        }
    }

    public function edit_post($type, $id)
    {
        $this->load->css('assets/system/js/datetime/css/bootstrap-datetimepicker.css');
        
        $this->load->js('assets/system/js/tinymce/jquery.tinymce.min.js');
        $this->load->js('assets/system/js/tinymce/tinymce.min.js');
        $this->load->js('assets/system/js/jquery.autocomplete.min.js');
        $this->load->js('assets/system/js/datetime/moment-with-locales.js');
        $this->load->js('assets/system/js/datetime/js/bootstrap-datetimepicker.min.js');
        $this->load->js('assets/system/js/scripts/ui-post.js');

        $data_post = $this->Post_m->edit_post($id);

        if ($data_post->post_image != '') {
            $post_image = base_url('media/' . $data_post->post_image);
        } else {
            $post_image = $data_post->post_image;
        }
        
        

        if ($data_post->post_status == 'draft') {
            $button = 'Publish';
            $draft  = 'Simpan Draft';
        } else {
            $button = 'Update';
            $draft  = 'Jadikan Draft';
        }

        if ($type == 'events') {
            $type_post_link = 'event';
        } elseif ($type == 'pages') {
            $type_post_link = 'page';
        } else {
            $type_post_link = 'blog';
        }

        if ($type == 'pages') {

            $data = array(
                'action'            => base_url('webadmin/post/update_post/' . $data_post->id_post),
                'text_button'       => $button,
                'draft'             => $draft,
                'cancel'            => base_url('webadmin/post?type=' . $type . '&filter=all'),
                'post_title'        => $data_post->post_title,
                'post_slug'         => $data_post->post_slug,
                'post_content'      => $data_post->post_content,
                'post_view'         => $data_post->post_view,
                'post_date'         => date("d M Y", strtotime($data_post->post_date)),
                'post_time'         => date("H:i", strtotime($data_post->post_date)),
                'post_modifed'      => date("d M Y", strtotime($data_post->post_modifed)),
                'post_time_modifed' => date("H:i", strtotime($data_post->post_modifed)),
                'post_author'       => $data_post->first_name,
                'post_image'        => $post_image,
                'post_template'     => $data_post->post_template,
            );
            $this->output->set_title('Edit Artikel');
            $this->load->view('system/post/form_pages', $data);
        } elseif ($type == 'events') {

            $this->load->css('assets/system/css/daterangepicker.css');
            $this->load->js('assets/system/js/moment.min.js');
            $this->load->js('assets/system/js/daterangepicker.js');

            $data_event = $this->Post_m->edit_event($id);
            
            if ($data_event->event_thumb != '') {
                $post_image1 = base_url('media/' . $data_event->event_thumb);
            } else {
                $post_image1 = $data_event->event_thumb;
            }

            $data = array(
                'action'               => base_url('webadmin/post/update_post/' . $data_post->id_post),
                'text_button'          => $button,
                'draft'                => $draft,
                'cancel'               => base_url('webadmin/post?type=' . $type . '&filter=all'),
                'post_title'           => $data_post->post_title,
                'post_slug'            => $data_post->post_slug,
                'post_content'         => $data_post->post_content,
                'post_view'            => $data_post->post_view,
                'post_date'            => date("d M Y", strtotime($data_post->post_date)),
                'post_time'            => date("H:i", strtotime($data_post->post_date)),
                'post_modifed'         => date("d M Y", strtotime($data_post->post_modifed)),
                'post_time_modifed'    => date("H:i", strtotime($data_post->post_modifed)),
                'post_author'          => $data_post->first_name,
                'post_image'           => $post_image,
                'post_image1'          => $post_image1,
                'type_post'            => $type_post_link,
                'data_term'            => $this->Terms_m->get_terms('category-events', '0')->result(),
                'data_term_current'    => $this->Terms_m->get_terms('category-events', '', $data_post->id_post)->result(),
                'data_testi'           => $this->Testi_m->data_testi($id),
                'data_gallery'         => $this->Gallery_m->data_gallery($id),
                'product_name'         => $data_event->product_name,
                'event_subtitle'       => $data_event->event_subtitle,
                'event_start_date'     => date("d-m-Y", strtotime($data_event->event_start_date)),
                'event_early'          => date("d-m-Y", strtotime($data_event->event_early)),
                'event_end_date'       => date("d-m-Y", strtotime($data_event->event_end_date)),
                'event_max_early_user' => $data_event->event_max_early_user,
                'event_price_sale'     => $data_event->event_price_sale,
                'event_price'          => $data_event->event_price,
                'event_timing'         => $data_event->event_timing,
                'event_location'       => $data_event->event_location,
                'event_regional'       => $data_event->event_regional,
            );
            $this->output->set_title('Edit Artikel');
            $this->load->view('system/post/form_event', $data);
        } else {
            $data = array(
                'action'            => base_url('webadmin/post/update_post/' . $data_post->id_post),
                'text_button'       => $button,
                'draft'             => $draft,
                'cancel'            => base_url('webadmin/post?type=' . $type . '&filter=all'),
                'post_title'        => $data_post->post_title,
                'post_slug'         => $data_post->post_slug,
                'post_content'      => $data_post->post_content,
                'post_view'         => $data_post->post_view,
                'post_date'         => date("d M Y", strtotime($data_post->post_date)),
                'post_date_ori'     => $data_post->post_date,
                'post_time'         => date("H:i", strtotime($data_post->post_date)),
                'post_modifed'      => date("d M Y", strtotime($data_post->post_modifed)),
                'post_time_modifed' => date("H:i", strtotime($data_post->post_modifed)),
                'post_author'       => $data_post->first_name,
                'post_image'        => $post_image,
                'type_post'         => $type_post_link,
                'data_term'         => $this->Terms_m->get_terms('category', '0')->result(),
                'data_term_current' => $this->Terms_m->get_terms('category', '', $data_post->id_post)->result(),
                'data_term_tags'    => $this->Terms_m->get_terms('tags', '', $data_post->id_post)->result(),
                'post_scheduler'    => $data_post->post_scheduler,
                'post_status'       => $data_post->post_status,
            );
            $this->output->set_title('Edit Artikel');
            $this->load->view('system/post/form_post', $data);
        }
    }

    public function update_post($id)
    {
        $this->output->unset_template('layout');

        if (!empty($_POST['draft'])) {
            
            $sc = $this->input->post('scheduler');
            if($sc){
                $post_date = date('Y-m-d H:i:s', strtotime($this->input->post('date_schedule').' '.$this->input->post('time_schedule')));
                $post_status = 'draft';
                $post_scheduler = '1';
            } else {
                $post_date = $this->input->post('post_date_ori');
                $post_status = 'draft';
                $post_scheduler = '0';
            }
            
        } else {
            
            $sc = $this->input->post('scheduler');
        
            if($sc){
                $post_date = date('Y-m-d H:i:s', strtotime($this->input->post('date_schedule').' '.$this->input->post('time_schedule')));
                $post_status = 'on_schedule';
                $post_scheduler = '1';
            } else {
                $post_date = $this->input->post('post_date_ori');
                $post_status = 'publish';
                $post_scheduler = '0';
            }
        }

        $row = $this->Post_m->edit_post($id, 'category');
        if ($this->input->post('post_slug') != $row->post_slug) {
            $slug = $this->Terms_m->slug_check_term($this->input->post('post_slug'));
        } else {
            $slug = $this->input->post('post_slug');
        }

        $data = array(
            'post_title'    => $this->input->post('post_title'),
            'post_author'   => $this->ion_auth->user()->row()->id,
            'post_content'  => $this->input->post('post_content'),
            'post_slug'     => $slug,
            'post_date'     => $post_date,
            'post_modifed'  => date('Y-m-d H:i:s', now()),
            'post_status'   => $post_status,
            'post_scheduler'=> $post_scheduler,
            'post_image'    => str_ireplace(base_url('media/'), "", $this->input->post('post_image')),
            'post_template' => $this->input->post('post_template'),

        );

        $update_post = $this->Post_m->update_post($id, $data);

        if ($update_post) {
            if ($row->post_type == 'pages') {
                //jika ini pages
                if ($post_status == 'draft') {
                    notify_suscces('Disimpan ke draft.', 'webadmin/post/edit_post/pages/' . $id);
                } else {
                    notify_suscces('Published.', 'webadmin/post?type=pages&filter=all');
                }
            }

            if ($row->post_type == 'blog') //jika ini blog
            {
                //delete all tags,category before update
                $this->Terms_m->delete_term_post($id);

                $tags          = $this->input->post('tags');
                $tags_add      = $this->input->post('tags_add');
                $post_category = $this->input->post('post_category');

                if (isset($tags) && !empty($tags)) // jika tag sebelumnya sudah di buat
                {

                    foreach ($tags as $tag) {
                        $data_rel = array(
                            'object_id'        => $id,
                            'term_taxonomy_id' => $tag,
                        );

                        $this->Terms_m->insert_term('term_relationships', $data_rel);

                        $this->Terms_m->update_count_term($tag);
                    }
                }

                if (isset($tags_add) && !empty($tags_add)) // jika ini tag baru dan belum di buat
                {

                    foreach ($tags_add as $tags) {
                        $data_term = array(
                            'term_id' => $this->Terms_m->id_max_term('terms'),
                            'name'    => $tags,
                            'slug'    => slug($this->Terms_m->slug_check_term($tags)),
                        );

                        $insert_term = $this->Terms_m->insert_term('terms', $data_term);

                        $data_tax = array(
                            'term_taxonomy_id' => $insert_term,
                            'term_id'          => $insert_term,
                            'taxonomy'         => 'tags',
                        );

                        $this->Terms_m->insert_term('term_taxonomy', $data_tax);

                        $data_rel = array(
                            'object_id'        => $id,
                            'term_taxonomy_id' => $insert_term,
                        );

                        $this->Terms_m->insert_term('term_relationships', $data_rel);

                        $this->Terms_m->update_count_term($insert_term);

                    }
                }

                if (isset($post_category) && !empty($post_category)) {
                    // insert detail kategori

                    foreach ($post_category as $category) {
                        $data_rel = array(
                            'object_id'        => $id,
                            'term_taxonomy_id' => $category,
                        );

                        $this->Terms_m->insert_term('term_relationships', $data_rel);
                        $this->Terms_m->update_count_term($category);
                    }
                } else //set to uncategorized
                {
                    $data_rel = array(
                        'object_id'        => $id,
                        'term_taxonomy_id' => '1',
                    );

                    $this->Terms_m->insert_term('term_relationships', $data_rel);
                    $this->Terms_m->update_count_term('1');
                }

                if ($post_status == 'draft') {
                    notify_suscces('Disimpan ke draft.', 'webadmin/post/edit_post/blog/' . $id);
                } else {
                    notify_suscces('Published.', 'webadmin/post?type=blog&filter=all');
                }

            }

            if ($row->post_type == 'events') //jika ini blog
            {
                //delete all category before update
                $this->Terms_m->delete_term_post($id);

                $post_category = $this->input->post('post_category');

                $data_rel = array(
                    'object_id'        => $id,
                    'term_taxonomy_id' => $post_category,
                );

                $this->Terms_m->insert_term('term_relationships', $data_rel);
                $this->Terms_m->update_count_term($post_category);

                //insert pengaturan events
                $data_events = array(
                    'product_name'         => $this->input->post('product_name'),
                    'event_subtitle'       => $this->input->post('event_subtitle'),
                    'event_thumb'          => str_ireplace(base_url('media/'), "", $this->input->post('post_image1')),
                    'event_start_date'     => date("Y-m-d", strtotime($this->input->post('event_start_date'))),
                    'event_early'          => date("Y-m-d", strtotime($this->input->post('event_early'))),
                    'event_end_date'       => date("Y-m-d", strtotime($this->input->post('event_end_date'))),
                    'event_max_early_user' => $this->input->post('event_max_early_user'),
                    'event_price_sale'     => $this->input->post('event_price_sale'),
                    'event_price'          => $this->input->post('event_price'),
                    'event_timing'         => $this->input->post('event_timing'),
                    'event_location'       => $this->input->post('event_location'),
                    'event_regional'       => $this->input->post('event_regional'),
                );

                $this->Post_m->update_events($id, $data_events);

                //delete testi
                $this->Testi_m->remove_testi($id);

                //insert testi
                $post_testi = $this->input->post('testi');

                if (isset($post_testi) && !empty($post_testi)) {
                    // insert testimoni
                    foreach ($post_testi as $testi => $value) {
                        $data_testi_name = array(
                            'id_post'    => $id,
                            'name_testi' => $value['name'],
                            'comment'    => $value['comment'],
                            'company'    => $value['company'],
                        );

                        $this->Testi_m->insert_testi($data_testi_name);
                    }
                }

                //delete gallery
                $this->Gallery_m->remove_gallery($id);

                //insert gallery
                $post_gallery = $this->input->post('post_images_gallery');

                if (isset($post_gallery) && !empty($post_gallery)) {
                    // insert testimoni
                    foreach ($post_gallery as $gallery) {
                        $data_gallery = array(
                            'images'  => str_ireplace(base_url('media/'), "", $gallery),
                            'id_post' => $id,
                        );

                        $this->Gallery_m->insert_gallery($data_gallery);
                    }
                }

                if ($post_status == 'draft') {
                    notify_suscces('Disimpan ke draft.', 'webadmin/post/edit_post/events/' . $id);
                } else {
                    notify_suscces('Published.', 'webadmin/post?type=events&filter=all');
                }

            }
        } else {
            notify_error('Gagal diupdate', 'webadmin/post/create/' . $type);
        }

    }

    public function move_trash_select($type)
    {
        $this->output->unset_template('layout');

        $post_id = comma_separated_to_array($this->input->post('post_id'));

        if (isset($post_id)) {
            foreach ($post_id as $id) {
                $this->Post_m->update_post_trash($id);
            }

            notify_suscces('Berhasil.', 'webadmin/post?type=' . $type . '&filter=all');
        }
    }

    public function move_trash($type, $id)
    {
        $this->output->unset_template('layout');

        if (isset($id)) {
            if ($this->Post_m->update_post_trash($id)) {
                redirect('webadmin/post?type=' . $type . '&filter=all');
            }
        }
    }

    public function restore_select($type)
    {
        $this->output->unset_template('layout');

        $post_id = comma_separated_to_array($this->input->post('post_id'));

        if (isset($post_id)) {
            foreach ($post_id as $id) {
                $this->Post_m->update_post_restore($id);
            }

            notify_suscces('Berhasil.', 'webadmin/post?type=' . $type . '&filter=all');
        }
    }

    public function restore($type, $id)
    {
        $this->output->unset_template('layout');

        if (isset($id)) {
            if ($this->Post_m->update_post_restore($id)) {
                redirect('webadmin/post?type=' . $type . '&filter=trash');
            }
        }
    }

    public function delete_permanent_select($type)
    {
        $this->output->unset_template('layout');

        $post_id = comma_separated_to_array($this->input->post('post_id'));

        if (isset($post_id)) {
            foreach ($post_id as $id) {
                $this->Post_m->delete_permanent($id);
            }

            notify_suscces('Data dihapus.', 'webadmin/post?type=' . $type . '&filter=all');
        }
    }

    public function delete_permanent($type, $id)
    {
        $this->output->unset_template('layout');

        if (isset($id)) {
            if ($this->Post_m->delete_permanent($id)) {
                redirect('webadmin/post?type=' . $type . '&filter=trash');
            }
        }
    }

    // Kategori
    public function category($type)
    {
        // css
        $this->load->css('assets/system/css/dataTables.bootstrap4.min.css');
        $this->load->css('assets/system/css/buttons.bootstrap4.min.css');
        $this->load->css('assets/system/css/responsive.bootstrap4.min.css');
        $this->load->css('assets/system/css/sweetalert2.min.css');
        // js
        $this->load->js('assets/system/js/sweetalert2.min.js');
        $this->load->js('assets/system/js/jquery.dataTables.min.js');
        $this->load->js('assets/system/js/dataTables.bootstrap4.min.js');
        $this->load->js('assets/system/js/dataTables.responsive.min.js');
        $this->load->js('assets/system/js/responsive.bootstrap4.min.js');
        $this->load->js('assets/system/js/scripts/ui-term.js');

        if ($type == 'events') {
            $terms = 'category-events';
        } else {
            $terms = 'category';
        }

        $data = array(
            'action'      => base_url('webadmin/post/save_category/' . $type),
            'cancel'      => '',
            'parent'      => '',
            'name'        => '',
            'description' => '',
            'slug'        => '',
            'data_term'   => $this->Terms_m->get_terms($terms, '0')->result(), // default parent 0
            'total_items' => $this->Terms_m->get_terms($terms)->num_rows(),
        );

        if ($type == 'events') {
            $this->output->set_title('Kategori Event');
            $this->load->view('system/post/category_event', $data);
        } else {
            $this->output->set_title('Kategori');
            $this->load->view('system/post/category', $data);
        }

    }

    public function save_category($type)
    {
        $this->output->unset_template('layout');

        if ($type == 'events') {
            $taxonomy = 'category-events';
        } else {
            $taxonomy = 'category';
        }

        $data_term = array(
            'term_id' => $this->Terms_m->id_max_term('terms'),
            'name'    => ucwords($this->input->post('name')),
            'slug'    => $this->Terms_m->slug_check_term($this->input->post('slug')),
        );

        $insert_term = $this->Terms_m->insert_term('terms', $data_term);
        
        // echo $insert_term;
        // echo '<br>';
        // echo  $taxonomy;
    
        if ($this->input->post('parent')) {
            $parent = $this->input->post('parent');
        } else {
            $parent = '0';
        }
        
        $data_tax = array(
            'term_taxonomy_id' => $insert_term, // get last id insert
            'term_id'          => $insert_term, // get last id insert
            'taxonomy'         => $taxonomy,
            'description'      => ucwords($this->input->post('description')),
            'parent'           => $parent,
        );

        $insert_tax = $this->Terms_m->insert_term('term_taxonomy', $data_tax);

        if ($insert_term && $insert_tax) {
            notify_suscces('Kategori berhasil di buat.', 'webadmin/post/category/' . $type);
        } else {
            notify_error('Kategori Gagal disimpan ke database', 'webadmin/post/category/' . $type);
        }

    }

    public function save_category_on_post($type)
    {
        $this->output->unset_template('layout');

        if ($type == 'events') {
            $taxonomy = 'category-events';
        } else {
            $taxonomy = 'category';
        }

        $data_term = array(
            'term_id' => $this->Terms_m->id_max_term('terms'),
            'name'    => ucwords($this->input->post('name')),
            'slug'    => $this->Terms_m->slug_check_term($this->input->post('slug')),
        );

        $insert_term = $this->Terms_m->insert_term('terms', $data_term);

        $data_tax = array(
            'term_taxonomy_id' => $insert_term, // get last id insert
            'term_id'          => $insert_term, // get last id insert
            'taxonomy'         => $taxonomy,
            'parent'           => $this->input->post('parent'),
        );

        $insert_tax = $this->Terms_m->insert_term('term_taxonomy', $data_tax);

        if ($insert_term && $insert_tax) {
            $message = array(
                'term_id' => $insert_term,
                'name'    => ucwords($this->input->post('name')),
                'status'  => 'success',
                'type'    => 'success',
                'message' => 'Kategori Berhasil dibuat',
                'parent'  => $this->input->post('parent'),
            );

            echo json_encode($message);
        } else {
            $message = array(
                'message' => 'Gagal membuat kategori',
                'status'  => 'error',
                'type'    => 'danger',
            );

            echo json_encode($message);
        }

    }

    public function edit_category($type, $id)
    {
        // css
        $this->load->css('assets/system/css/dataTables.bootstrap4.min.css');
        $this->load->css('assets/system/css/buttons.bootstrap4.min.css');
        $this->load->css('assets/system/css/responsive.bootstrap4.min.css');
        $this->load->css('assets/system/css/sweetalert2.min.css');
        // js
        $this->load->js('assets/system/js/sweetalert2.min.js');
        $this->load->js('assets/system/js/jquery.dataTables.min.js');
        $this->load->js('assets/system/js/dataTables.bootstrap4.min.js');
        $this->load->js('assets/system/js/dataTables.responsive.min.js');
        $this->load->js('assets/system/js/responsive.bootstrap4.min.js');
        $this->load->js('assets/system/js/scripts/ui-term.js');

        if ($type == 'events') {
            $terms = 'category-events';
        } else {
            $terms = 'category';
        }

        $row = $this->Terms_m->edit_term($id, $terms);

        $data = array(
            'action'      => base_url('webadmin/post/update_category/' . $type . '/' . $id),
            'cancel'      => base_url('webadmin/post/category/' . $type),
            'term_id'     => $id,
            'parent'      => $row->parent,
            'name'        => $row->name,
            'description' => $row->description,
            'slug'        => $row->slug,
            'data_term'   => $this->Terms_m->get_terms($terms, '0')->result(), // default parent 0
            'total_items' => $this->Terms_m->get_terms($terms)->num_rows(),

        );

        if ($type == 'events') {
            $this->output->set_title('Edit Kategori Event');
            $this->load->view('system/post/category_event', $data);
        } else {
            $this->output->set_title('Edit Kategori');
            $this->load->view('system/post/category', $data);
        }

    }

    public function update_category($type, $id)
    {
        $this->output->unset_template('layout');

        if ($type == 'events') {
            $terms = 'category-events';
        } else {
            $terms = 'category';
        }

        $row = $this->Terms_m->edit_term($id, $terms);
        if ($this->input->post('slug') != $row->slug) {
            $slug = $this->Terms_m->slug_check_term($this->input->post('slug'));
        } else {
            $slug = $this->input->post('slug');
        }

        $data_term = array(
            'name' => ucwords($this->input->post('name')),
            'slug' => $slug,
        );

        $data_parent = array(
            'parent'      => $this->input->post('parent'),
            'description' => $this->input->post('description'),
        );

        if ($this->Terms_m->update_term($id, $data_term, 'terms') && $this->Terms_m->update_term($id, $data_parent, 'term_taxonomy')) {
            notify_suscces('Kategori berhasil di update.', 'webadmin/post/category/' . $type);
        } else {
            notify_error('Gagal diupdate', 'webadmin/post/category/' . $type);
        }

    }

    public function delete_category_select($type)
    {
        $this->output->unset_template('layout');

        $term_id = comma_separated_to_array($this->input->post('term_id'));
        $data    = array('parent' => '0');

        if (isset($term_id)) {

            foreach ($term_id as $id) {
                $this->Terms_m->update_parent($id, $data);
            }

            if ($this->Terms_m->delete_term($term_id)) {

                if ($this->Terms_m->update_to_uncategorized($type)) {
                    notify_suscces('Berhasil dihapus.', 'webadmin/post/category/' . $type);
                } else {
                    notify_error('Tidak ada kategori yang dipilih.', 'webadmin/post/category/' . $type);
                }

            } else {
                notify_error('Tidak ada kategori yang dipilih.', 'webadmin/post/category/' . $type);
            }
        }
    }

    public function delete_category($type, $id)
    {
        $this->output->unset_template('layout');

        $data = array('parent' => '0');
        if (isset($id)) {
            if ($this->Terms_m->update_parent($id, $data)) {
                if ($this->Terms_m->delete_term($id)) {
                    if ($this->Terms_m->update_to_uncategorized($type)) {
                        redirect('webadmin/post/category/' . $type);
                    }
                }
            }
        }
    }

    // Tags
    public function tags()
    {
        // css
        $this->load->css('assets/system/css/dataTables.bootstrap4.min.css');
        $this->load->css('assets/system/css/buttons.bootstrap4.min.css');
        $this->load->css('assets/system/css/responsive.bootstrap4.min.css');
        $this->load->css('assets/system/css/sweetalert2.min.css');
        // js
        $this->load->js('assets/system/js/sweetalert2.min.js');
        $this->load->js('assets/system/js/jquery.dataTables.min.js');
        $this->load->js('assets/system/js/dataTables.bootstrap4.min.js');
        $this->load->js('assets/system/js/dataTables.responsive.min.js');
        $this->load->js('assets/system/js/responsive.bootstrap4.min.js');
        $this->load->js('assets/system/js/scripts/ui-term.js');

        $data = array(
            'action'      => base_url('webadmin/post/save_tags'),
            'cancel'      => '',
            'parent'      => '',
            'name'        => '',
            'description' => '',
            'slug'        => '',
            'data_term'   => $this->Terms_m->get_terms('tags', '0')->result(), // default parent 0
            'total_items' => $this->Terms_m->get_terms('tags', '0')->num_rows(),
        );

        $this->output->set_title('Tag');
        $this->load->view('system/post/tags', $data);
    }

    public function data_tags()
    {
        $this->output->unset_template('layout');

        $data_tags = $this->Terms_m->search_term($_GET['term']);
        $data      = array();
        foreach ($data_tags as $tags) {
            $data[] = array(
                "value" => $tags->name,
                "id"    => $tags->term_id,
            );

        }
        echo json_encode($data);
    }

    public function save_tags()
    {
        $this->output->unset_template('layout');

        $data_term = array(
            'term_id' => $this->Terms_m->id_max_term('terms'),
            'name'    => ucwords($this->input->post('name')),
            'slug'    => $this->Terms_m->slug_check_term($this->input->post('slug')),
        );

        $insert_term = $this->Terms_m->insert_term('terms', $data_term);

        $data_tax = array(
            'term_taxonomy_id' => $insert_term, // get last id insert
            'term_id'          => $insert_term, // get last id insert
            'taxonomy'         => 'tags',
            'description'      => ucwords($this->input->post('description')),
        );

        $insert_tax = $this->Terms_m->insert_term('term_taxonomy', $data_tax);

        if ($insert_term && $insert_tax) {
            notify_suscces('Tag berhasil di buat.', 'webadmin/post/tags');
        } else {
            notify_error('Tag Gagal disimpan ke database', 'webadmin/post/tags');
        }

    }

    public function edit_tags($id)
    {
        // css
        $this->load->css('assets/system/css/dataTables.bootstrap4.min.css');
        $this->load->css('assets/system/css/buttons.bootstrap4.min.css');
        $this->load->css('assets/system/css/responsive.bootstrap4.min.css');
        $this->load->css('assets/system/css/sweetalert2.min.css');
        // js
        $this->load->js('assets/system/js/sweetalert2.min.js');
        $this->load->js('assets/system/js/jquery.dataTables.min.js');
        $this->load->js('assets/system/js/dataTables.bootstrap4.min.js');
        $this->load->js('assets/system/js/dataTables.responsive.min.js');
        $this->load->js('assets/system/js/responsive.bootstrap4.min.js');
        $this->load->js('assets/system/js/scripts/ui-term.js');

        $row = $this->Terms_m->edit_term($id, 'tags');

        $data = array(
            'action'      => base_url('webadmin/post/update_tags/' . $id),
            'cancel'      => base_url('webadmin/post/tags'),
            'term_id'     => $id,
            'name'        => $row->name,
            'description' => $row->description,
            'slug'        => $row->slug,
            'data_term'   => $this->Terms_m->get_terms('tags', '0')->result(), // default parent 0
            'total_items' => $this->Terms_m->get_terms('tags', '0')->num_rows(),

        );
        $this->output->set_title('Edit Tag');
        $this->load->view('system/post/tags', $data);
    }

    public function update_tags($id)
    {
        $this->output->unset_template('layout');

        $row = $this->Terms_m->edit_term($id, 'tags');
        if ($this->input->post('slug') != $row->slug) {
            $slug = $this->Terms_m->slug_check_term($this->input->post('slug'));
        } else {
            $slug = $this->input->post('slug');
        }

        $data_term = array(
            'name' => ucwords($this->input->post('name')),
            'slug' => $slug,
        );

        $data_parent = array(
            'description' => $this->input->post('description'),
        );

        if ($this->Terms_m->update_term($id, $data_term, 'terms') && $this->Terms_m->update_term($id, $data_parent, 'term_taxonomy')) {
            notify_suscces('Tag berhasil di update.', 'webadmin/post/tags');
        } else {
            notify_error('Gagal diupdate', 'webadmin/post/tags');
        }

    }

    public function delete_tags_select()
    {
        $this->output->unset_template('layout');

        $term_id = comma_separated_to_array($this->input->post('term_id'));

        if (isset($term_id)) {

            if ($this->Terms_m->delete_term($term_id)) {
                notify_suscces('Berhasil dihapus.', 'webadmin/post/tags');
            } else {
                notify_error('Tidak ada tags yang dipilih.', 'webadmin/post/tags');
            }
        }
    }

    public function delete_tags($id)
    {
        $this->output->unset_template('layout');

        if (isset($id)) {
            if ($this->Terms_m->delete_term($id)) {
                redirect('webadmin/post/tags');
            }
        }
    }

    //json data post
    public function get_csrf()
    {
        $this->output->unset_template('layout');
        $csrf['csrf_name']  = $this->security->get_csrf_token_name();
        $csrf['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($csrf);
    }

    public function json_post($type, $filter, $author = false)
    {
        $this->output->unset_template('layout');

        function is_tags($id_post, $type)
        {
            $ci = &get_instance();

            $data_tags = $ci->Terms_m->get_terms_json('terms.name,terms.slug', 'tags', $id_post)->result();
            $data      = array();
            foreach ($data_tags as $key) {
                $data[] = '<a href="' . base_url('webadmin/post?type=' . $type . '&filter=' . $key->slug) . '" class="ajax-list">' . $key->name . '</a>';
            }
            $comma_separated = implode(", ", $data);
            if ($comma_separated == '') {
                $tags = '—';
            } else {
                $tags = $comma_separated;
            }
            return $tags;

        }

        function is_cat($id_post, $post_type)
        {
            $ci = &get_instance();

            if ($post_type == 'events') {
                $type_cat = 'category-events';
            } else {
                $type_cat = 'category';
            }

            $data_tags = $ci->Terms_m->get_terms_json('terms.name,terms.slug', $type_cat, $id_post)->result();
            $data      = array();
            foreach ($data_tags as $key) {
                $data[] = '<a href="' . base_url('webadmin/post?type=' . $post_type . '&filter=' . $key->slug) . '" class="ajax-list">' . $key->name . '</a>';
            }
            $comma_separated = implode(", ", $data);

            if ($comma_separated == '') {
                $cat = '—';
            } else {
                $cat = $comma_separated;
            }
            return $cat;

        }

        function is_title($id_post, $post_title, $post_slug, $post_status, $post_type, $post_trash)
        {

            if ($post_trash == '1') {
                $data = '
                      <div class="row-action" id="action' . $id_post . '">
                        <span><a class="ajax-link" href="' . base_url('webadmin/post/restore/' . $post_type . '/' . $id_post) . '">Pulihkan</a></span>
                        <span><a class="ajax-link del" href="' . base_url('webadmin/post/delete_permanent/' . $post_type . '/' . $id_post) . '">Hapus Selamanya</a></span>
                      </div>
                      ';
            } else {

                if ($post_status == 'draft') {
                    if ($post_type == 'events') {
                        $type_post_link = 'event';
                    } elseif ($post_type == 'pages') {
                        $type_post_link = 'pages';
                    } else {
                        $type_post_link = 'blog';
                    }

                    $link_view = base_url($type_post_link . '/preview/' . $post_slug);
                    $text      = 'Preview';

                } else {
                    if ($post_type == 'events') {
                        $type_post_link = 'event';
                    } elseif ($post_type == 'pages') {
                        $type_post_link = 'pages';
                    } else {
                        $type_post_link = 'blog';
                    }
                    $link_view = base_url($type_post_link . '/' . $post_slug);
                    $text      = 'View';
                }

                $data = '
                      <div class="row-action" id="action' . $id_post . '">
                        <span><a class="ajax-list" href="' . base_url('webadmin/post/edit_post/' . $post_type . '/' . $id_post) . '">Edit</a></span>
                        <span><a class="ajax-link del" href="' . base_url('webadmin/post/move_trash/' . $post_type . '/' . $id_post) . '">Delete</a></span>
                        <span><a href="' . $link_view . '" target="blank">' . $text . '</a></span>
                      </div>
                      ';
            }

            return $data;
        }

        function is_status($post_status)
        {
            if ($post_status == 'draft') {
                $status = '— <span class="text-draft">' . ucwords($post_status) . '</span>';
                return $status;
            } elseif($post_status == 'on_schedule'){
                $status = '— <span class="text-scheduled">Scheduled</span>';
                return $status;
            }
        }

        function is_date($post_status, $post_modifed, $post_date)
        {
            $date_draft = date("d M Y", strtotime($post_modifed));
            $date_pubsh = date("d M Y", strtotime($post_date));

            if ($post_status == 'draft') {
                $date = '<span class="text-muted">Terakhir diedit<br><abbr title="' . $post_modifed . '">' . $date_draft . '</abbr></span>';
            } elseif($post_status == 'on_schedule') {
                $date = '<span style="color:#63c381;">Scheduled<br><abbr title="' . $post_date . '">' . $date_pubsh . '</abbr></span>';
            } else {
                $date = '<span class="text-muted">Published<br><abbr title="' . $post_date . '">' . $date_pubsh . '</abbr></span>';
            }

            return $date;
        }

        $this->datatables->select('id_post, post_title, post_type, post_trash, first_name,post_author, post_status, post_date, post_slug, post_modifed');
        $this->datatables->from('posts');
        $this->datatables->join('users', 'users.id = posts.post_author', 'left');
        $this->datatables->join('term_relationships', 'term_relationships.object_id = posts.id_post', 'left');
        $this->datatables->join('terms', 'terms.term_id = term_relationships.term_taxonomy_id', 'left');
        $this->datatables->where('post_type', $type);

        if ($filter == 'all') {
            $this->datatables->where('post_trash != "1"');
        } elseif ($filter == 'trash') {
            $this->datatables->where('post_trash', '1');
        } elseif ($filter == 'on_schedule') {
            $this->datatables->where('post_trash', '0');
            $this->datatables->where('post_status', $filter);
        } elseif ($filter == 'draft' || $filter == 'publish') {
            $this->datatables->where('post_trash', '0');
            $this->datatables->where('post_status', $filter);
        } else {
            $this->datatables->where('post_trash', '0');
            $this->datatables->where('terms.slug', $filter);
        }

        if ($author) {
            $this->datatables->where('post_author', $author);
        }

        $this->datatables->order_by('id_post', 'desc');
        $this->datatables->group_by('id_post');
        $this->datatables->add_column('title', '$1', "is_title('id_post','post_title','post_slug','post_status','post_type','post_trash')");
        $this->datatables->add_column('category', '$1', "is_cat('id_post','post_type')");
        $this->datatables->add_column('tags', '$1', "is_tags('id_post','post_type')");
        $this->datatables->add_column('author', '<a href="' . base_url() . 'webadmin/post?type=' . $type . '&filter=all&author=$2">$1</a>', 'first_name,post_author');
        $this->datatables->add_column('date', '$1', "is_date('post_status','post_modifed','post_date')");
        $this->datatables->add_column('status', '$1', "is_status('post_status')");

        return print_r($this->datatables->generate());
    }

}
