<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{

    //---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->muhanz->check_auth();
        $this->_init();
        $this->load->model('Post_m');

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
        $this->load->js('assets/app/js/pages/pages.datatables.js');

        $title = 'Pages List';

        $data = array(
            'title'             => $title,
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Pages' , '/webadmin/posts/pages/list');
        $this->breadcrumbs->push('List', '/webadmin/posts/articles/list');
        // View
        $this->load->view('app/post/pages_list', $data);

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

        $title = 'Create New Pages';

        $data = array(
            'title'             => $title,
            'action'            => base_url('webadmin/posts/pages/save_post'),
            'cancel'            => false,
            'data_content'      => array()
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Pages' , '/webadmin/posts/pages');
        $this->breadcrumbs->push('Create', '/webadmin/posts/pages/create');
        // View
        $this->load->view('app/post/pages', $data);

    }

    public function save_post()
    {
        $this->output->unset_template('layout');
        
        if($this->input->post('draft')){
            $post_status = 'draft';
            $redirect_url = 'webadmin/posts/pages/edit/';
        } else {
            $post_status = 'publish';
            $redirect_url = 'webadmin/posts/pages/list';
        }
        
        $data = array(
            'post_title'    => $this->input->post('post_title'),
            'post_author'   => $this->ion_auth->user()->row()->id,
            'post_content'  => $this->input->post('post_content'),
            'post_slug'     => $this->slug->create_uri($this->input->post('post_title')),
            'post_type'     => 'pages',
            'post_date'     => date('Y-m-d H:i:s', now()),
            'post_modifed'  => date('Y-m-d H:i:s', now()),
            'post_status'   => $post_status,
            'post_image'    => str_ireplace(base_url(), "", $this->input->post('cover')),

        );

        $insert_post = $this->Post_m->insert_post($data);

        if ($insert_post) {

            if ($post_status == 'draft') {
                $this->muhanz->success($this->lang->line('save_success'), $redirect_url.$insert_post);
            } else {
                $this->muhanz->success($this->lang->line('save_success'), $redirect_url);
            }
    

        } else {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/posts/pages/create');
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

        $title = 'Edit Pages';

        $data = array(
            'title'             => $title,
            'action'            => base_url('webadmin/posts/pages/update_post/'.$id),
            'cancel'            => true,
            'data_content'      => $this->Post_m->get_pages($id)
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Pages' , '/webadmin/posts/pages');
        $this->breadcrumbs->push('Edit', '/webadmin/posts/pages/create');
        // View
        $this->load->view('app/post/pages', $data);
        
    }

    public function update_post($id)
    {
        $this->output->unset_template('layout');
        
            if($this->input->post('draft')){
                $post_status = 'draft';
                $redirect_url = 'webadmin/posts/pages/edit/';
            } else {
                $post_status = 'publish';
                $redirect_url = 'webadmin/posts/pages/list';
            }
        
        $data = array(
            'post_title'    => $this->input->post('post_title'),
            'post_author'   => $this->ion_auth->user()->row()->id,
            'post_content'  => $this->input->post('post_content'),
            'post_slug'     => $this->slug->create_uri($this->input->post('post_title'), $id),
            'post_date'     => date('Y-m-d H:i:s', now()),
            'post_modifed'  => date('Y-m-d H:i:s', now()),
            'post_status'   => $post_status,
            'post_image'    => str_ireplace(base_url(), "", $this->input->post('cover')),

        );

        $update_post = $this->Post_m->update_post($id,  $data);

        if ($update_post) {

            if ($post_status == 'draft') {
                $this->muhanz->success($this->lang->line('update_success'), $redirect_url.$id);
            } else {
                $this->muhanz->success($this->lang->line('update_success'), $redirect_url);
            }

        } else {
            $this->muhanz->error($this->lang->line('update_error'), 'webadmin/posts/pages/edit/'.$id);
        }

    }


    public function delete($id)
    {
        $this->output->unset_template('layout');

        if (isset($id)) {
            if ($this->Post_m->delete_permanent($id)) {
                $this->muhanz->success($this->lang->line('delete_success'), 'webadmin/posts/pages/list');
            } else {
                $this->muhanz->error($this->lang->line('delete_error'), 'webadmin/posts/pages/list');
            }
        } else {
            $this->muhanz->error($this->lang->line('delete_error'), 'webadmin/posts/pages/list');
        }
    }


    public function json_pages()
    {
        $this->output->unset_template('layout');

        function is_action($id_post)
        {
            $CI =& get_instance();

            $count_post = $CI->Post_m->check_post_used($id_post);
            $data = '';
            $data .= '<a href="'.base_url('webadmin/posts/pages/edit/'.$id_post).'" class="btn btn-primary btn-sm btn-block mlink"><i class="uil uil-edit"></i> Edit</a>';
            
            if($count_post <= 0){
                $data .= '<button class="btn btn-danger btn-sm  btn-block del" data-id="'.$id_post.'"><i class="uil uil-trash-alt"></i> Delete</button>';
            }
           
        
            return $data;
        }

        function is_view($slug)
        {
            $data = '';
            $data .= '<a href="'.base_url('pages/'.$slug).'" class="btn btn-primary btn-sm btn-block" target="_blank"><i class="uil uil-eye"></i> View</a>';
            return $data;
        }
      

        $this->datatables->select('id_post, post_status, post_title, post_date, post_modifed, post_slug, a.first_name as author_name, e.first_name as author_name_edit');
        $this->datatables->from('posts');
        $this->datatables->join('users as a', 'a.id = posts.post_author', 'left');
        $this->datatables->join('users as e', 'e.id = posts.post_author_modifed', 'left');
        $this->datatables->where('post_type','pages');
        $this->datatables->order_by('id_post', 'desc');
        $this->datatables->group_by('id_post');
        $this->datatables->add_column('action', '$1', "is_action('id_post')");
        $this->datatables->add_column('view', '$1', "is_view('post_slug')");
        
        return print_r($this->datatables->generate());
    }

}
