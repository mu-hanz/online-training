<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Terms extends CI_Controller
{

    //---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->muhanz->check_auth();
        $this->_init();
        $this->load->model('Terms_m');


        $config = array(
			'table'       => 'terms',
			'id'          => 'term_id',
			'field'       => 'slug',
			'title'       => 'name',
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

    // Category
    public function create($type)
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
        $this->load->js('assets/app/js/pages/terms.init.js');

        if ($type == 'events') {
            $terms = 'category-events';
            $title = 'Events Category';
            $parent = true;
        } else if ($type == 'events-type'){
            $terms = 'events-type';
            $title = 'Events Type';
            $parent = false;
        } else if ($type == 'groups'){
            $terms = 'category-groups';
            $title = 'Groups';
            $parent = false;
        } else if ($type == 'products'){
            $terms = 'category-products';
            $title = 'Products Category';
            $parent = true;
        } else if ($type == 'certification'){
            $terms = 'certification-events';
            $title = 'Certificate Events';
            $parent = false;
        } else if ($type == 'location'){
            $terms = 'events-location';
            $title = 'Events Location';
            $parent = false;
        } else if ($type == 'regional'){
            $terms = 'events-regional';
            $title = 'Events Regional';
            $parent = false;
        } else {
            $terms = 'category-articles';
            $title = 'Articles Category';
            $parent = true;
        }

        $data = array(
            'title'       => $title, 
            'type'        => $type, 
            'terms'       => $terms,
            'is_parent'   => $parent,
            'action'      => base_url('webadmin/posts/terms/save/' . $type),
            'cancel'      => '',
            'parent'      => '',
            'name'        => '',
            'description' => '',
            'slug'        => '',
            'data_term'   => $this->Terms_m->get_terms($terms, '0')->result(), // default parent 0
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push($title , '/webadmin/posts/'.$type);
        $this->breadcrumbs->push('Category', '/webadmin/posts/terms/create/articles');
        // View
        $this->load->view('app/post/terms', $data);

    }

    public function save($type)
    {
        $this->output->unset_template('layout');

        if ($type == 'events') {
            $taxonomy = 'category-events';
            $title = 'Events Category';
        } else if ($type == 'events-type'){
            $taxonomy = 'events-type';
            $title = 'Events Type';
        } else if ($type == 'groups'){
            $taxonomy = 'category-groups';
            $title = 'Groups';
        } else if ($type == 'products'){
            $taxonomy = 'category-products';
            $title = 'Products Category';
        } else if ($type == 'certification'){
            $taxonomy = 'certification-events';
            $title = 'Certificate Events';
        } else if ($type == 'location'){
            $taxonomy = 'events-location';
            $title = 'Events Location';
        } else if ($type == 'regional'){
            $taxonomy = 'events-regional';
            $title = 'Events Regional';
        } else {
            $taxonomy = 'category-articles';
            $title = 'Articles Category';
        }

        $data_term = array(
            'term_id' => $this->Terms_m->id_max_term('terms'),
            'name'    => ucwords($this->input->post('name')),
            'slug'    => $this->slug->create_uri($this->input->post('name'))
        );

        $insert_term = $this->Terms_m->insert_term('terms', $data_term);
    
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
            $this->muhanz->success($this->lang->line('save_success'), 'webadmin/posts/terms/create/' . $type);
        } else {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/posts/terms/create/' . $type);
        }

    }


    public function edit($type, $id)
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
        $this->load->js('assets/app/js/pages/terms.init.js');

        if ($type == 'events') {
            $terms = 'category-events';
            $title = 'Events Category';
            $parent = true;
        } else if ($type == 'events-type'){
            $terms = 'events-type';
            $title = 'Events Type';
            $parent = false;
        } else if ($type == 'groups'){
            $terms = 'category-groups';
            $title = 'Groups';
            $parent = false;
        } else if ($type == 'products'){
            $terms = 'category-products';
            $title = 'Products Category';
            $parent = true;
        } else if ($type == 'certification'){
            $terms = 'certification-events';
            $title = 'Certificate Events';
            $parent = false;
        } else if ($type == 'location'){
            $terms = 'events-location';
            $title = 'Events Location';
            $parent = false;
        } else if ($type == 'regional'){
            $terms = 'events-regional';
            $title = 'Events Regional';
            $parent = false;
        } else {
            $terms = 'category-articles';
            $title = 'Articles Category';
            $parent = true;
        }

        $row = $this->Terms_m->edit_term($id, $terms);

        $data = array(
            'title'       => $title,
            'type'        => $type, 
            'terms'       => $terms,
            'is_parent'   => $parent,
            'action'      => base_url('webadmin/posts/terms/update/'. $type. '/'. $id),
            'cancel'      => base_url('webadmin/posts/terms/create/' . $type),
            'term_id'     => $id,
            'parent'      => $row->parent,
            'name'        => $row->name,
            'description' => $row->description,
            'slug'        => $row->slug,
            'data_term'   => $this->Terms_m->get_terms($terms, '0')->result(), // default parent 0
            'total_items' => $this->Terms_m->get_terms($terms)->num_rows(),

        );

        $this->output->set_title($this->muhanz->app_title('Edit '. $title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push($title , '/webadmin/posts/'.$type);
        $this->breadcrumbs->push('Category', '/webadmin/posts/terms/create/'. $type);
        $this->breadcrumbs->push($row->name, '/webadmin/posts/terms/create/articles');
        // View
        $this->load->view('app/post/terms', $data);

    }

    public function update($type, $id)
    {
        $this->output->unset_template('layout');

        $redirect_url = "webadmin/posts/terms/create/". $type;

        $row = $this->Terms_m->edit_term($id);

        $data_term = array(
            'name' => ucwords($this->input->post('name')),
            'slug' => $this->slug->create_uri($this->input->post('name'), $id),
        );

        $data_parent = array(
            'parent'      => $this->input->post('parent'),
            'description' => $this->input->post('description'),
        );

        if ($this->Terms_m->update_term($id, $data_term, 'terms') && $this->Terms_m->update_term($id, $data_parent, 'term_taxonomy')) {
            $this->muhanz->success($this->lang->line('save_success'), $redirect_url);
        } else {
            $this->muhanz->error($this->lang->line('save_error'), $redirect_url);
        }

    }

    public function delete($type)
    {
        $this->output->unset_template();
        
        $id = $this->input->post('term_id');
        $redirect_url = "webadmin/posts/terms/create/". $type;
        $data = array('parent' => '0');
        if ($this->Terms_m->update_parent($id, $data)) {
            if ($this->Terms_m->delete_term($id)) {
                if ($this->Terms_m->update_to_uncategorized($type)) {
                    $this->muhanz->success($this->lang->line('delete_success'), $redirect_url);
                }  else {
                    $this->muhanz->error($this->lang->line('delete_error'), $redirect_url);
                }
            }  else {
                $this->muhanz->error($this->lang->line('delete_error'), $redirect_url);
            }
        }  else {
            $this->muhanz->error($this->lang->line('delete_error'), $redirect_url);
        }
    }

}
