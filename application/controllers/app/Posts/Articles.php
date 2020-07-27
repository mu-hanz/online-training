<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Articles extends CI_Controller
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

    public function list()
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
        $this->load->js('assets/app/js/pages/articles.datatables.js');

        $title = 'Articles List';

        $data = array(
            'title'             => $title,
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Articles' , '/webadmin/posts/articles/list');
        $this->breadcrumbs->push('List', '/webadmin/posts/articles/list');
        // View
        $this->load->view('app/post/articles_list', $data);

    }

    public function create()
    {
        $this->load->css('assets/sweetalert/sweetalert2.min.css');
        
        $this->load->js('assets/sweetalert/sweetalert2.all.min.js');
        $this->load->js('assets/tinymce/tinymce.min.js');
        $this->load->js('assets/tinymce/tinymce.init.js');
        $this->load->js('assets/app/libs/flatpickr/flatpickr.min.js');
        $this->load->js('assets/app/js/pages/event-content.init.js');
        $this->load->js('assets/app/js/pages/posts.init.js');

        $title = 'Create New Articles';

        $data = array(
            'title'             => $title,
            'action'            => base_url('webadmin/posts/articles/save_post'),
            'cancel'            => false,
            'data_category'     => $this->Terms_m->get_terms('category-articles', '0')->result(),
            'data_category_current' => array(),
            'data_content'      => array()
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Articles' , '/webadmin/posts/articles');
        $this->breadcrumbs->push('Create', '/webadmin/posts/articles/create');
        // View
        $this->load->view('app/post/articles', $data);

    }

    public function save_post()
    {
        $this->output->unset_template('layout');
        
        if($this->input->post('scheduler')){

            $post_date = date('Y-m-d H:i:s', strtotime($this->input->post('date_schedule').' '.$this->input->post('time_schedule')));
            $post_scheduler = '1';
            $post_status = 'on_schedule'; 
            $redirect_url = 'webadmin/posts/articles/list';
            
        } else {

            $post_date = date('Y-m-d H:i:s', now());
            $post_scheduler = '0';

            if($this->input->post('draft')){
                $post_status = 'draft';
                $redirect_url = 'webadmin/posts/articles/edit/';
            } else {
                $post_status = 'publish';
                $redirect_url = 'webadmin/posts/articles/list';
            }
        
        }
        
        $data = array(
            'post_title'    => $this->input->post('post_title'),
            'post_author'   => $this->ion_auth->user()->row()->id,
            'post_content'  => $this->input->post('post_content'),
            'post_slug'     => $this->slug->create_uri($this->input->post('post_title')),
            'post_type'     => 'articles',
            'post_date'     => $post_date,
            'post_modifed'  => date('Y-m-d H:i:s', now()),
            'post_status'   => $post_status,
            'post_scheduler'=> $post_scheduler,
            'post_image'    => str_ireplace(base_url(), "", $this->input->post('cover')),

        );

        $insert_post = $this->Post_m->insert_post($data);

        if ($insert_post) {
                $success = false;
                $post_category = $this->input->post('post_category');

            if (isset($post_category) && !empty($post_category)) {
                // insert detail kategori

                foreach ($post_category as $category) {
                    $data_rel = array(
                        'object_id'        => $insert_post,
                        'term_taxonomy_id' => $category,
                    );

                    if($this->Terms_m->insert_term('term_relationships', $data_rel) && $this->Terms_m->update_count_term($category))
                    {
                        $success = true;
                    }

                }
            } 
            else //set to uncategorized
            {
                $data_rel = array(
                    'object_id'        => $insert_post,
                    'term_taxonomy_id' => '1',
                );

                if($this->Terms_m->insert_term('term_relationships', $data_rel) && $this->Terms_m->update_count_term('1'))
                {
                    $success = true;
                };

            }

            if ($success) {
                if ($post_status == 'draft') {
                    $this->muhanz->success($this->lang->line('save_success'), $redirect_url.$insert_post);
                } else {
                    $this->muhanz->success($this->lang->line('save_success'), $redirect_url);
                }
            } else {
                $this->muhanz->error($this->lang->line('save_error'), 'webadmin/posts/articles/create');
            }

        } else {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/posts/articles/create');
        }
    }

    public function edit($id)
    {

        $this->load->css('assets/sweetalert/sweetalert2.min.css');
        
        $this->load->js('assets/sweetalert/sweetalert2.all.min.js');
        $this->load->js('assets/tinymce/tinymce.min.js');
        $this->load->js('assets/tinymce/tinymce.init.js');
        $this->load->js('assets/app/libs/flatpickr/flatpickr.min.js');
        $this->load->js('assets/app/js/pages/event-content.init.js');
        $this->load->js('assets/app/js/pages/posts.init.js');

        $title = 'Edit Articles';

        $data = array(
            'title'             => $title,
            'action'            => base_url('webadmin/posts/articles/update_post/'.$id),
            'cancel'            => true,
            'data_category'     => $this->Terms_m->get_terms('category-articles', '0')->result(),
            'data_category_current' => $this->Terms_m->get_terms('category-articles','', $id)->result(),
            'data_content'      => $this->Post_m->get_articles($id)
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Articles' , '/webadmin/posts/articles');
        $this->breadcrumbs->push('Create', '/webadmin/posts/articles/create');
        // View
        $this->load->view('app/post/articles', $data);
        
    }

    public function update_post($id)
    {
        $this->output->unset_template('layout');
        
        if($this->input->post('scheduler')){

            $post_date = date('Y-m-d H:i:s', strtotime($this->input->post('date_schedule').' '.$this->input->post('time_schedule')));
            $post_scheduler = '1';
            $post_status = 'on_schedule'; 
            $redirect_url = 'webadmin/posts/articles/list';
            
        } else {
            $post_date = date('Y-m-d H:i:s', now());
            $post_scheduler = '0';

            if($this->input->post('draft')){
                $post_status = 'draft';
                $redirect_url = 'webadmin/posts/articles/edit/';
            } else {
                $post_status = 'publish';
                $redirect_url = 'webadmin/posts/articles/list';
            }
        
        }
        
        $data = array(
            'post_title'    => $this->input->post('post_title'),
            'post_author'   => $this->ion_auth->user()->row()->id,
            'post_content'  => $this->input->post('post_content'),
            'post_slug'     => $this->slug->create_uri($this->input->post('post_title'), $id),
            'post_date'     => $post_date,
            'post_modifed'  => date('Y-m-d H:i:s', now()),
            'post_status'   => $post_status,
            'post_scheduler'=> $post_scheduler,
            'post_image'    => str_ireplace(base_url(), "", $this->input->post('cover')),

        );

        $update_post = $this->Post_m->update_post($id,  $data);

        if ($update_post) {

            //delete all tags,category before update
            $this->Terms_m->delete_term_post($id);

                $success = false;
                $post_category = $this->input->post('post_category');

            if (isset($post_category) && !empty($post_category)) {
                // insert detail kategori

                foreach ($post_category as $category) {
                    $data_rel = array(
                        'object_id'        => $id,
                        'term_taxonomy_id' => $category,
                    );

                    if($this->Terms_m->insert_term('term_relationships', $data_rel) && $this->Terms_m->update_count_term($category))
                    {
                        $success = true;
                    }

                }
            } 
            else //set to uncategorized
            {
                $data_rel = array(
                    'object_id'        => $id,
                    'term_taxonomy_id' => '1',
                );

                if($this->Terms_m->insert_term('term_relationships', $data_rel) && $this->Terms_m->update_count_term('1'))
                {
                    $success = true;
                };

            }

            if ($success) {
                if ($post_status == 'draft') {
                    $this->muhanz->success($this->lang->line('update_success'), $redirect_url.$id);
                } else {
                    $this->muhanz->success($this->lang->line('update_success'), $redirect_url);
                }
            } else {
                $this->muhanz->error($this->lang->line('update_error'), 'webadmin/posts/articles/edit/'.$id);
            }

        } else {
            $this->muhanz->error($this->lang->line('update_error'), 'webadmin/posts/articles/edit/'.$id);
        }

    }


    public function delete($id)
    {
        $this->output->unset_template('layout');

        if (isset($id)) {
            if ($this->Post_m->delete_permanent($id)) {
                $this->muhanz->success($this->lang->line('delete_success'), 'webadmin/posts/articles/list');
            } else {
                $this->muhanz->error($this->lang->line('delete_error'), 'webadmin/posts/articles/list');
            }
        } else {
            $this->muhanz->error($this->lang->line('delete_error'), 'webadmin/posts/articles/list');
        }
    }


    public function json_articles()
    {
        $this->output->unset_template('layout');

        function is_action($id_post)
        {
            $CI =& get_instance();

            $count_post = $CI->Post_m->check_post_used($id_post);
            $data = '';
            $data .= '<a href="'.base_url('webadmin/posts/articles/edit/'.$id_post).'" class="btn btn-primary btn-sm btn-block mlink"><i class="uil uil-edit"></i> Edit</a>';
            
            if($count_post <= 0){
                $data .= '<button class="btn btn-danger btn-sm  btn-block del" data-id="'.$id_post.'"><i class="uil uil-trash-alt"></i> Delete</button>';
            }
           
        
            return $data;
        }
      

        $this->datatables->select('id_post, post_status, post_title, post_date, post_modifed, a.first_name as author_name, e.first_name as author_name_edit');
        $this->datatables->from('posts');
        $this->datatables->join('users as a', 'a.id = posts.post_author', 'left');
        $this->datatables->join('users as e', 'e.id = posts.post_author_modifed', 'left');
        $this->datatables->where('post_type','articles');
        $this->datatables->order_by('id_post', 'desc');
        $this->datatables->group_by('id_post');
        $this->datatables->add_column('action', '$1', "is_action('id_post')");
        
        return print_r($this->datatables->generate());
    }

}
