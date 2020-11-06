<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Campaign extends CI_Controller
{

    var $folder = 'Promotions';
    var $file   = 'Campaign';
    
    //---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->muhanz->check_auth();
        $this->_init();
        $this->load->model($this->folder.'_m');
        $this->load->library('upload');
        $this->load->library('slug');
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
        $list = $this->Promotions_m->get_datatables_campaign();
		$data = array();
        $no = $_POST['start'];
        $x = '1';
        foreach ($list as $row) {
            if ($row->status == 'On Progress') {
                $classStatus = 'badge-success';
            } else {
                $classStatus = 'badge-danger';
            }
            $data[] = array (
                'no'                => $x,
                'promotions_id'     => $row->promotions_id,
                'promotions_name'   => $row->promotions_name.'<div class="row-action"><span><a class="mlinks" href="'.base_url().'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file).'/edit/'.$row->promotions_id.'">Edit</a></span><span><a href="javascript:void(0)" class="del mlink" term_url="webadmin/'.strtolower($this->folder).'/'.strtolower($this->file).'/delete/'.$row->promotions_id.'" term_id="'.$row->promotions_id.'">Delete</a></span></div>',
                'start_date'        => $row->start_date,
                'end_date'          => $row->end_date,
                'status'            => '<span class="badge '.$classStatus.'">'.$row->status.'</span>',
            );
            $x++;
        }

        $data2 = array (
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Promotions_m->count_all_campaign(),
            "recordsFiltered" => $this->Promotions_m->count_filtered_campaign(),
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
            'cancel'                    => '',
            'parent'                    => '',
            'name'                      => '',
            'description'               => '',
            'slug'                      => '',
            'page'                      => 'create',
            'promotions_name'           => '',
            'promotions_content'        => '',
            'start_date'                => '',
            'end_date'                  => '',
            'valid_on'                  => '',
            'id_data'                   => '',
            'get_data_training'         => $this->Promotions_m->get_data_training(),
            'count_data_training'       => $this->Promotions_m->count_data_training()
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

    // public function get_data_json2()
    // {
    //     $this->output->unset_template();
    //     $list       = $this->Promotions_m->get_datatables2();
	// 	$data       = array();
    //     $no         = $_POST['start'];
    //     $page       = $_POST['page'];
    //     $id_data    = $_POST['id_data'];
    //     if ($page == 'create') {
    //         foreach ($list as $row) {
    //             $data[] = array (
    //                 'event_id'          => $row->event_id,
    //                 'post_title'        => $row->post_title,
    //                 'event_cost'        => 'Rp. '.number_format($row->event_cost),
    //                 'event_location'    => $row->event_location,
    //                 'checkbox'          => '0',
    //                 'price_campaign'    => '',
    //             );
    //         }
    //     } else {
    //         $list2       = $this->Promotions_m->get_data_promotions_detail($id_data);
    //         foreach ($list as $row) {
    //             $checkbox = 0;
    //             foreach ($list2 as $row2) {
    //                 if ($row->event_id === $row2->event_id) {
    //                     $checkbox = '1';
    //                     break;
    //                 }
    //             }
    //             $data[] = array (
    //                 'event_id'          => $row->event_id,
    //                 'post_title'        => $row->post_title,
    //                 'event_cost'        => 'Rp. '.number_format($row->event_cost),
    //                 'event_location'    => $row->event_location,
    //                 'checkbox'          => $checkbox,
    //             );
    //         }
    //     }
    //     $data2 = array (
    //         "draw" => $_POST['draw'],
    //         "recordsTotal" => $this->Promotions_m->count_all2(),
    //         "recordsFiltered" => $this->Promotions_m->count_filtered2(),
    //         'data' => $data,
    //     );

    //     echo json_encode($data2);
    // }

    public function save()
    {
        $this->output->unset_template('layout');
        $type               = strtolower($this->file);
        $currentDateTime    = date('Y-m-d H:i:s');
        $promotions_name    = $this->input->post('promotions_name');
        $start_date         = $this->input->post('start_date');
        $end_date           = $this->input->post('end_date');
        if ($start_date > $currentDateTime) {
            $status = 'Off Progress';
        } else if ($start_date < $currentDateTime && $end_date < $currentDateTime) {
            $status = 'Off Progress';
        } else {
            $status = 'On Progress';
        }

        $count_data_training    = $this->input->post('count_data_training');
        $valid_on               = $this->input->post('valid_on');
        $temp_count             = 0;
        for($i=1; $i <= $count_data_training; $i++){
            $id                 = $this->input->post('id'.$i);
            $price_campaign     = $this->input->post('price_campaign'.$i);

            $count_row          = $this->Promotions_m->get_data_promotions_campaign($id);
            $temp_count+= $count_row;
        }

        if ($temp_count >= '1') {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        } else {
            if (!empty($_FILES['promotions_image']['name'])) {
                $config['upload_path']      = './assets/app/images/promotions/';
                $config['allowed_types']    = 'jpg|jpeg|png|gif';
                $config['max_size']         = 2048;
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('promotions_image')){
                    $promotions_image = '';
                    return $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
                }else{
                    $data = array('upload_data' => $this->upload->data());
                    $promotions_image = $data['upload_data']['file_name']; 
                }
            } else {
                $promotions_image = '';
            }
            
            $data_promotions = array(
                'type'                      => strtolower($this->file),
                'promotions_name'           => $this->input->post('promotions_name'),
                'slug'                      => $this->slug->create_slug($this->input->post('promotions_name')),
                'promotions_content'        => $this->input->post('contents',FALSE),
                'promotions_image'          => $promotions_image,
                'start_date'                => $this->input->post('start_date'),
                'end_date'                  => $this->input->post('end_date'),
                'valid_on'                  => $this->input->post('valid_on'),
                'status'                    => $status,
                'edited_by'                 => $this->ion_auth->get_user_id(),
                'edited_date'               => $currentDateTime
            );
            $last_id_promotions     = $this->Promotions_m->save_promotions($data_promotions);
            
            for($i=1; $i <= $count_data_training; $i++){
                $id                 = $this->input->post('id'.$i);
                $price_campaign     = $this->input->post('price_campaign'.$i);
                if (isset($id)) {
                    $data_promotions_detail = array(
                        'promotions_id'     => $last_id_promotions,
                        'event_id'          => $id,
                        'price_campaign'    => str_replace(',', '', $price_campaign),
                    );
                    if ($price_campaign != '0' && $price_campaign != '') {
                        $insert_promotions_detail = $this->Promotions_m->save_promotions_detail($data_promotions_detail);
                    }
                }
            }
            if ($last_id_promotions) {
                $this->muhanz->success($this->lang->line('save_success'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
            } else {
                $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
            }
        }
    }

    public function edit($id)
    {
        $this->load->js('assets/app/libs/summernote/summernote-bs4.min.js');
        $this->load->js('assets/app/js/pages/'.strtolower($this->file).'_create.init.js');

        $title  = str_replace("_", " ", $this->file);
        $row    = $this->Promotions_m->get_data($id);
        $row2   = $this->Promotions_m->get_data_promotions_type($id);

        $data = array(
            'title'                         => $title, 
            'folder'                        => strtolower($this->folder),
            'file'                          => strtolower($this->file),
            'action'                        => base_url('webadmin/'.strtolower($this->folder).'/'.strtolower($this->file).'/update'),
            'cancel'                        => '',
            'parent'                        => '',
            'name'                          => '',
            'description'                   => '',
            'slug'                          => '',
            'page'                          => 'edit',
            'promotions_name'               => $row->promotions_name,
            'promotions_image'              => $row->promotions_image,
            'promotions_content'            => $row->promotions_content,
            'start_date'                    => $row->start_date,
            'end_date'                      => $row->end_date,
            'valid_on'                      => $row->valid_on,
            'id_data'                       => $id,
            'get_data_training'             => $this->Promotions_m->get_data_training(),
            'count_data_training'           => $this->Promotions_m->count_data_training(),
            'get_data_training_detail'      => $this->Promotions_m->get_data_training_detail($id),
        );

        $this->output->set_title($this->muhanz->app_title($title));
        // Breadcrumbs
		$this->breadcrumbs->push('Dashboard', '/webadmin');
		$this->breadcrumbs->push($title , '/webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        $this->breadcrumbs->push('Edit', ' ');
        // View
        $this->load->view('app/'.strtolower($this->folder).'/'.strtolower($this->file), $data);
    }

    public function update()
    {
        $this->output->unset_template('layout');
        $type               = strtolower($this->file);
        $currentDateTime    = date('Y-m-d H:i:s');
        $promotions_name    = $this->input->post('promotions_name');
        $start_date         = $this->input->post('start_date');
        $end_date           = $this->input->post('end_date');
        $id_data            = $this->input->post('id_data');
        if ($start_date > $currentDateTime) {
            $status = 'Off Progress';
        } else if ($start_date < $currentDateTime && $end_date < $currentDateTime) {
            $status = 'Off Progress';
        } else {
            $status = 'On Progress';
        }

        $count_data_training        = $this->input->post('count_data_training');
        $valid_on                   = $this->input->post('valid_on');
        $temp_count                 = 0;
        for($i=1; $i <= $count_data_training; $i++){
            $id                 = $this->input->post('id'.$i);
            $price_campaign     = $this->input->post('price_campaign'.$i);

            $count_row          = $this->Promotions_m->get_data_promotions_campaign_update($id, $id_data);
            $temp_count+= $count_row;
        }
        if ($temp_count >= '1') {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        } else {
            if (!empty($_FILES['promotions_image']['name'])) {
                $config['upload_path']      = './assets/app/images/promotions/';
                $config['allowed_types']    = 'jpg|jpeg|png|gif';
                $config['max_size']         = 2048;
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('promotions_image')){
                    $promotions_image = '';
                    return $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
                }else{
                    $data = array('upload_data' => $this->upload->data());
                    $promotions_image = $data['upload_data']['file_name']; 
                }
                $data_promotions = array(
                    'promotions_image'          => $promotions_image
                );
                $update_promotions          = $this->Promotions_m->update_promotions($id_data, $data_promotions);
            } else {
                
            }
            
            $data_promotions = array(
                'type'                      => strtolower($this->file),
                'promotions_name'           => $this->input->post('promotions_name'),
                'slug'                      => $this->slug->create_slug($this->input->post('promotions_name')),
                'promotions_content'        => $this->input->post('contents',TRUE),
                'start_date'                => $this->input->post('start_date'),
                'end_date'                  => $this->input->post('end_date'),
                'valid_on'                  => $this->input->post('valid_on'),
                'status'                    => $status,
                'edited_by'                 => $this->ion_auth->get_user_id(),
                'edited_date'               => $currentDateTime
            );
            $update_promotions          = $this->Promotions_m->update_promotions($id_data, $data_promotions);
            $delete_promotions_detail   = $this->Promotions_m->delete_promotions_detail($id_data);
            
            for($i=1; $i <= $count_data_training; $i++){
                $id                 = $this->input->post('id'.$i);
                $price_campaign     = $this->input->post('price_campaign'.$i);
                if (isset($id)) {
                    $data_promotions_detail = array(
                        'promotions_id'     => $id_data,
                        'event_id'          => $id,
                        'price_campaign'    => str_replace(',', '', $price_campaign),
                    );
                    if ($price_campaign != '0' && $price_campaign != '') {
                        $insert_promotions_detail = $this->Promotions_m->save_promotions_detail($data_promotions_detail);
                    }
                }
            }
            if ($update_promotions) {
                $this->muhanz->success($this->lang->line('save_success'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
            } else {
                $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
            }
        } 
    }

    public function delete()
    {
        $this->output->unset_template();
        
        $id = $this->input->post('term_id'); 
        $data = array(
            'status_delete' => '1',
        );
        if ($this->Promotions_m->delete_promotions($id, $data)) {
            $this->muhanz->success($this->lang->line('delete_success'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }  else {
            $this->muhanz->error($this->lang->line('delete_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }
    }

}
