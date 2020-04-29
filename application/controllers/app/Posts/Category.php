<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{

    //---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->_init();
        if (!$this->ion_auth->logged_in()) {
            $this->session->set_userdata('redirect_login', $this->agent->referrer());
            redirect('webadmin/login', 'refresh');
        }
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
        $this->load->js('assets/app/js/pages/category.init.js');

        if ($type == 'events') {
            $terms = 'category-events';
            $title = 'Events Category';
        } else if ($type == 'groups'){
            $terms = 'category-groups';
            $title = 'Groups Category';
        } else {
            $terms = 'category-articles';
            $title = 'Articles Category';
        }

        $data = array(
            'title'       => $title,  
            'action'      => base_url('webadmin/posts/category/save/' . $type),
            'cancel'      => '',
            'parent'      => '',
            'name'        => '',
            'description' => '',
            'slug'        => '',
            'data_term'   => $this->Terms_m->get_terms($terms, '0')->result(), // default parent 0
        );

        $this->output->set_title($title);
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push('Articles', '/webadmin/posts/articles');
        $this->breadcrumbs->push('Category', '/webadmin/posts/category/create/articles');
        // View
        $this->load->view('app/post/category', $data);

    }

    public function save($type)
    {
        $this->output->unset_template('layout');

        if ($type == 'events') {
            $taxonomy = 'category-events';
        } else if ($type == 'groups'){
            $taxonomy = 'category-groups';
        } else {
            $taxonomy = 'category-articles';
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
            $this->muhanz->success($this->lang->line('save_success'), 'webadmin/posts/category/create/' . $type);
        } else {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/posts/category/create/' . $type);
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
