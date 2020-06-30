<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{

    var $folder = 'Products';
    var $file   = 'Products';
    
    //---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->_init();
        if (!$this->ion_auth->logged_in()) {
            $this->session->set_userdata('redirect_login', $this->agent->referrer());
            redirect('webadmin/login', 'refresh');
        }
        $this->load->model($this->folder.'_m');
        $this->load->library('upload');
    }

    private function _init()
    {
        $this->output->set_template('app/layout/webadmin');
		$this->load->section('topbar', 'app/layout/mz_topbar');
        $this->load->section('menubar', 'app/layout/mz_menubar');
        
        // css
        $this->load->css('assets/app/libs/summernote/summernote-bs4.css');
        $this->load->css('assets/app/css/app-custom.css');
        $this->load->css('assets/app/libs/datatables/dataTables.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/responsive.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/buttons.bootstrap4.min.css');
        // $this->load->css('assets/app/libs/datatables/select.bootstrap4.min.css');
        $this->load->css('assets/app/libs/flatpickr/flatpickr.min.css');
        $this->load->css('assets/sweetalert/sweetalert2.min.css');

        // js
        
        $this->load->js('assets/app/libs/datatables/jquery.dataTables.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.bootstrap4.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.responsive.min.js');
        $this->load->js('assets/app/libs/datatables/responsive.bootstrap4.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.checkboxes.min.js');
        $this->load->js('assets/app/libs/datatables/dom-checkbox.js');
        $this->load->js('assets/app/libs/flatpickr/flatpickr.min.js');
        $this->load->js('assets/sweetalert/sweetalert2.all.min.js');
        // $this->load->js('https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js');
    }

    public function index()
    {
        $this->load->js('assets/app/js/pages/'.strtolower($this->file).'.init.js');

        $title  = str_replace("_", " ", $this->file);
        $data = array(
            'title'             => $title, 
            'folder'            => strtolower($this->folder),
            'file'              => strtolower($this->file),
            'action'            => base_url('webadmin/'.strtolower($this->folder).'/'.strtolower($this->file).'/save'),
            'cancel'            => '',
            'parent'            => '',
            'name'              => '',
            'description'       => '',
            'slug'              => '',
            'page'              => 'index'
        );
        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push($title , '/webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        $this->breadcrumbs->push('', ' ');
        // View
        $this->load->view('app/'.strtolower($this->folder).'/'.strtolower($this->file), $data);
    }

    public function get_data_json()
    {
        $this->output->unset_template();
        $list = $this->Products_m->get_datatables();
		$data = array();
        $no = $_POST['start'];
        $x = '1';
        foreach ($list as $row) {
            if ($row->status == 'Aktif') {
                $classStatus = 'badge-success';
            } else if ($row->status == 'Draft') {
                $classStatus = 'badge-warning';
            } else {
                $classStatus = 'badge-danger';
            }
            $row_image = $this->Products_m->get_products_images($row->product_id);
            $image = $row_image['product_media_name'];
            if ($image == '') {
                $image = 'no-image.jpg';
            } else {
                $image = $row_image['product_media_name'];
            }
            $data[] = array (
                'no'                => $x,
                'product_id'        => $row->product_id,
                'product_name'      => '<img src="'.base_url().'assets/app/images/products/'.$image.'" width="50px" height="50px"><br>'.$row->product_name.'<div class="row-action"><span><a class="mlinks" href="'.base_url().'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file).'/edit/'.$row->product_id.'">Edit</a></span><span><a href="javascript:void(0)" class="del mlink" term_url="webadmin/'.strtolower($this->folder).'/'.strtolower($this->file).'/delete/'.$row->product_id.'" term_id="'.$row->product_id.'">Delete</a></span></div>',
                'category'          => $row->name,
                'status'            => '<span class="badge '.$classStatus.'">'.$row->status.'</span>',
            );
            $x++;
        }

        $data2 = array (
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Products_m->count_all(),
            "recordsFiltered" => $this->Products_m->count_filtered(),
            'data' => $data,
        );

        echo json_encode($data2);
    }

    public function create()
    {
        $this->load->js('assets/app/libs/summernote/summernote-bs4.min.js');
        $this->load->js('assets/app/js/pages/'.strtolower($this->file).'_create.init.js');

        $title  = str_replace("_", " ", $this->file);

        $data = array(
            'title'                     => $title, 
            'folder'                    => strtolower($this->folder),
            'file'                      => strtolower($this->file),
            'action'                    => base_url('webadmin/'.strtolower($this->folder).'/'.strtolower($this->file).'/save'),
            'cancel'                                => '',
            'parent'                                => '',
            'name'                                  => '',
            'description'                           => '',
            'slug'                                  => '',
            'max_field_tiers'                       => '5',
            'page'                                  => 'create',
            'product_name'                          => '',
            'product_description'                   => '',
            'id_data'                               => '',
            'get_data_category'                     => $this->Products_m->get_data_category(),
            'get_data_product_media_images'         => '',
            'count_data_product_media_images'       => '',
            'get_data_product_media_files'          => '',
            'count_data_product_media_files'        => '',
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push($title , '/webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        $this->breadcrumbs->push('Create', ' ');
        // View
        $this->load->view('app/'.strtolower($this->folder).'/'.strtolower($this->file), $data);
    }

    public function upload_image_summernote(){
        $this->output->unset_template();
        if(isset($_FILES["image"]["name"])){
            $config['upload_path'] = './assets/app/images/summernote/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('image')){
                $this->upload->display_errors();
                return FALSE;
            }else{
                $data = $this->upload->data();
                echo base_url().'assets/app/images/summernote/'.$data['file_name'];
            }
        }
    }

    public function delete_image_summernote(){
        $src = $this->input->post('src');
        $file_name = str_replace(base_url(), '', $src);
        if(unlink($file_name))
        {
            echo 'File Delete Successfully';
        }
    }

    public function save()
    {
        $this->output->unset_template('layout');
        $type               = strtolower($this->file);
        $currentDateTime    = date('Y-m-d H:i:s');

        $data = array(
            'product_name'              => $this->input->post('product_name'),
            'product_description'       => $this->input->post('product_description'),
            'category_id'               => $this->input->post('category_id'),
            'status'                    => $this->input->post('status'),
            'edited_by'                 => $this->ion_auth->get_user_id(),
            'edited_date'               => $currentDateTime
        );
        if ($last_id = $this->Products_m->save_products($data)) {

            if (!empty($_FILES['file_image']['name'])) {

                $filesCount     = count($_FILES['file_image']['name']); 
                $ordering_image = $this->input->post('ordering_image');

                for($i = 0; $i < $filesCount; $i++){ 
                    $_FILES['file']['name']         = $_FILES['file_image']['name'][$i]; 
                    $_FILES['file']['type']         = $_FILES['file_image']['type'][$i]; 
                    $_FILES['file']['tmp_name']     = $_FILES['file_image']['tmp_name'][$i]; 
                    $_FILES['file']['error']        = $_FILES['file_image']['error'][$i]; 
                    $_FILES['file']['size']         = $_FILES['file_image']['size'][$i]; 
                        
                    // File upload configuration 
                    $config['upload_path']          = './assets/app/images/products/'; 
                    $config['allowed_types']        = 'jpg|jpeg|png|gif'; 
                    $config['max_size']             = 2048; 
                        
                    // Load and initialize upload library
                    $this->upload->initialize($config); 
                        
                    // Upload file to server 
                    if($this->upload->do_upload('file')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $data = array(
                            'product_id'                => $last_id,
                            'product_media_name'        => $fileData['file_name'],
                            'type'                      => 'Image',
                            'ordering'                  => $ordering_image[$i]
                        );
                        $this->Products_m->save_products_media($data);
                    }else{  
                        $this->Products_m->delete_products($last_id);
                        return $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file)); 
                    } 
                } 

            }

            if (!empty($_FILES['file_upload']['name'])) {

                $filesCount2     = count($_FILES['file_upload']['name']);
                for($i = 0; $i < $filesCount2; $i++){ 
                    $_FILES['file']['name']         = $_FILES['file_upload']['name'][$i]; 
                    $_FILES['file']['type']         = $_FILES['file_upload']['type'][$i]; 
                    $_FILES['file']['tmp_name']     = $_FILES['file_upload']['tmp_name'][$i]; 
                    $_FILES['file']['error']        = $_FILES['file_upload']['error'][$i]; 
                    $_FILES['file']['size']         = $_FILES['file_upload']['size'][$i]; 
                        
                    // File upload configuration 
                    $config['upload_path']          = './assets/app/files/products/'; 
                    $config['allowed_types']        = 'pdf|doc|docx'; 
                    $config['max_size']             = 2048; 
                        
                    // Load and initialize upload library
                    $this->upload->initialize($config); 
                        
                    // Upload file to server 
                    if($this->upload->do_upload('file')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $data = array(
                            'product_id'                => $last_id,
                            'product_media_name'        => $fileData['file_name'],
                            'type'                      => 'File',
                        );
                        $this->Products_m->save_products_media($data);
                    }else{  
                        $this->Products_m->delete_products($last_id);
                        return $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file)); 
                    } 
                }

            }

            $this->muhanz->success($this->lang->line('save_success'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));

        } else {
            return $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file)); 
        }
    }

    public function edit($id)
    {
        $this->load->js('assets/app/libs/summernote/summernote-bs4.min.js');
        $this->load->js('assets/app/js/pages/'.strtolower($this->file).'_create.init.js');

        $title  = str_replace("_", " ", $this->file);
        $row    = $this->Products_m->get_data($id);

        $data = array(
            'title'                                 => $title, 
            'folder'                                => strtolower($this->folder),
            'file'                                  => strtolower($this->file),
            'action'                                => base_url('webadmin/'.strtolower($this->folder).'/'.strtolower($this->file).'/update'),
            'cancel'                                => '',
            'parent'                                => '',
            'name'                                  => '',
            'description'                           => '',
            'slug'                                  => '',
            'max_field_tiers'                       => '5',
            'page'                                  => 'edit',
            'product_name'                          => $row->product_name,
            'product_description'                   => $row->product_description,
            'username'                              => $row->username,
            'views'                                 => $row->views,
            'edited_date'                           => $row->edited_date,
            'status'                                => $row->status,
            'category_id'                           => $row->category_id,
            'id_data'                               => $id,
            'get_data_category'                     => $this->Products_m->get_data_category(),
            'get_data_product_media_images'         => $this->Products_m->get_data_product_media_images($id),
            'count_data_product_media_images'       => $this->Products_m->count_data_product_media_images($id),
            'get_data_product_media_files'          => $this->Products_m->get_data_product_media_files($id),
            'count_data_product_media_files'        => $this->Products_m->count_data_product_media_files($id),
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push($title , '/webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        $this->breadcrumbs->push('Create', ' ');
        // View
        $this->load->view('app/'.strtolower($this->folder).'/'.strtolower($this->file), $data);
    }

    public function update()
    {
        $this->output->unset_template('layout');
        $type               = strtolower($this->file);
        $currentDateTime    = date('Y-m-d H:i:s');
        $id_data            = $this->input->post('id_data');

        $data_products = array(
            'product_name'              => $this->input->post('product_name'),
            'product_description'       => $this->input->post('product_description'),
            'category_id'               => $this->input->post('category_id'),
            'status'                    => $this->input->post('status'),
            'edited_by'                 => $this->ion_auth->get_user_id(),
            'edited_date'               => $currentDateTime
        );
        $update_products      = $this->Products_m->update_products($id_data, $data_products);

        $image_remove = $this->input->post('image_remove');
        if (isset($image_remove)) {
            $image_remove_count = count($image_remove);
            for ($i = 0; $i < $image_remove_count; $i++) {
                $data = array(
                    'status_delete' => '1'
                );
                $this->Products_m->update_products_media($image_remove[$i], $data);
            }
        }

        $file_remove = $this->input->post('file_remove');
        if (isset($file_remove)) {
            $file_remove_count = count($file_remove);
            for ($i = 0; $i < $file_remove_count; $i++) {
                $data = array(
                    'status_delete' => '1'
                );
                $this->Products_m->update_products_media($file_remove[$i], $data);
            }
        }

        if (!empty($_FILES['file_image']['name'])) {

            $filesCount     = count($_FILES['file_image']['name']); 
            $ordering_image = $this->input->post('ordering_image');

            for($i = 0; $i < $filesCount; $i++){ 
                $_FILES['file']['name']         = $_FILES['file_image']['name'][$i]; 
                $_FILES['file']['type']         = $_FILES['file_image']['type'][$i]; 
                $_FILES['file']['tmp_name']     = $_FILES['file_image']['tmp_name'][$i]; 
                $_FILES['file']['error']        = $_FILES['file_image']['error'][$i]; 
                $_FILES['file']['size']         = $_FILES['file_image']['size'][$i]; 
                    
                // File upload configuration 
                $config['upload_path']          = './assets/app/images/products/'; 
                $config['allowed_types']        = 'jpg|jpeg|png|gif'; 
                $config['max_size']             = 2048; 
                    
                // Load and initialize upload library
                $this->upload->initialize($config); 
                    
                // Upload file to server 
                if($this->upload->do_upload('file')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $data = array(
                        'product_id'                => $id_data,
                        'product_media_name'        => $fileData['file_name'],
                        'type'                      => 'Image',
                        'ordering'                  => $ordering_image[$i]
                    );
                    $this->Products_m->save_products_media($data);
                }else{
                    return $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file)); 
                } 
            } 

        }

        if (!empty($_FILES['file_upload']['name'])) {

            $filesCount2     = count($_FILES['file_upload']['name']);
            for($i = 0; $i < $filesCount2; $i++){ 
                $_FILES['file']['name']         = $_FILES['file_upload']['name'][$i]; 
                $_FILES['file']['type']         = $_FILES['file_upload']['type'][$i]; 
                $_FILES['file']['tmp_name']     = $_FILES['file_upload']['tmp_name'][$i]; 
                $_FILES['file']['error']        = $_FILES['file_upload']['error'][$i]; 
                $_FILES['file']['size']         = $_FILES['file_upload']['size'][$i]; 
                    
                // File upload configuration 
                $config['upload_path']          = './assets/app/files/products/'; 
                $config['allowed_types']        = 'pdf|doc|docx'; 
                $config['max_size']             = 2048; 
                    
                // Load and initialize upload library
                $this->upload->initialize($config); 
                    
                // Upload file to server 
                if($this->upload->do_upload('file')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $data = array(
                        'product_id'                => $id_data,
                        'product_media_name'        => $fileData['file_name'],
                        'type'                      => 'File',
                    );
                    $this->Products_m->save_products_media($data);
                }else{  
                    return $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file)); 
                } 
            }

        }

        if ($update_products) {
            $this->muhanz->success($this->lang->line('save_success'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        } else {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }
    }

    public function delete()
    {
        $this->output->unset_template();
        
        $id = $this->input->post('term_id'); 
        $data = array(
            'status_delete' => '1',
        );
        if ($this->Products_m->update_products($id, $data) OR $this->Products_m->update_products_media($id, $data)) {
            $this->muhanz->success($this->lang->line('delete_success'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }  else {
            $this->muhanz->error($this->lang->line('delete_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }
    }

}
