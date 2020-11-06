<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Slider extends CI_Controller
{

    var $folder = 'Promotions';
    var $file   = 'Slider';
    
    //---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->muhanz->check_auth();
        $this->_init();
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
            'page'              => 'index',
            'id_data'           => '',
            'title_slider'      => '',
            'sorting'           => '',
            'url'               => '',
            'image'             => '',
            'start_date'        => '',
            'end_date'          => '',
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
        $list = $this->Promotions_m->get_datatables_slider();
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
                'banners_id'        => $row->banners_id,
                'title'             => $row->title.'<div class="row-action"><span><a class="mlinks" href="'.base_url().'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file).'/edit/'.$row->banners_id.'">Edit</a></span><span><a href="javascript:void(0)" class="del mlink" term_url="webadmin/'.strtolower($this->folder).'/'.strtolower($this->file).'/delete/'.$row->banners_id.'" term_id="'.$row->banners_id.'">Delete</a></span></div>',
                'image'             => '<img src="'.base_url().'assets/app/images/promotions/'.$row->image.'" width="100%">',
                'sorting'           => $row->sorting,
                'status'            => '<span class="badge '.$classStatus.'">'.$row->status.'</span>',
            );
            $x++;
        }

        $data2 = array (
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Promotions_m->count_all_slider(),
            "recordsFiltered" => $this->Promotions_m->count_filtered_slider(),
            'data' => $data,
        );

        echo json_encode($data2);
    }

    public function save()
    {
        $this->output->unset_template('layout');
        $type               = strtolower($this->file);
        $currentDateTime    = date('Y-m-d H:i:s');
        $title              = $this->input->post('title');
        $start_date         = $this->input->post('start_date');
        $end_date           = $this->input->post('end_date');
        if ($start_date > $currentDateTime) {
            $status = 'Off Progress';
        } else if ($start_date < $currentDateTime && $end_date < $currentDateTime) {
            $status = 'Off Progress';
        } else {
            $status = 'On Progress';
        }
        
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path']      = './assets/app/images/promotions/';
            $config['allowed_types']    = 'jpg|jpeg|png|gif';
            $config['max_size']         = 2048;
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('image')){
                $image = '';
                return $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
            }else{
                $data = array('upload_data' => $this->upload->data());
                $image = $data['upload_data']['file_name']; 
            }
        } else {
            $image = '';
        }
        
        $data = array(
            'title'                     => $this->input->post('title'),
            'type'                      => strtolower($this->file),
            'sorting'                   => $this->input->post('sorting'),
            'image'                     => $image,
            'url'                       => $this->input->post('url'),
            'start_date'                => $this->input->post('start_date'),
            'end_date'                  => $this->input->post('end_date'),
            'status'                    => $status,
            'edited_by'                 => $this->ion_auth->get_user_id(),
            'edited_date'               => $currentDateTime
        );
        $last_id_slider     = $this->Promotions_m->save_slider($data);
        if ($last_id_slider) {
            $this->muhanz->success($this->lang->line('save_success'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        } else {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }
    }

    public function edit($id)
    {

        $this->load->js('assets/app/js/pages/'.strtolower($this->file).'.init.js');

        $title  = str_replace("_", " ", $this->file);
        $row    = $this->Promotions_m->get_data_slider($id);

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
            'title_slider'                  => $row->title,
            'sorting'                       => $row->sorting,
            'image'                         => $row->image,
            'url'                           => $row->url,
            'start_date'                    => $row->start_date,
            'end_date'                      => $row->end_date,
            'id_data'                       => $id,
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
        $title              = $this->input->post('title');
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
        
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path']      = './assets/app/images/promotions/';
            $config['allowed_types']    = 'jpg|jpeg|png|gif';
            $config['max_size']         = 2048;
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('image')){
                $image = '';
                return $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
            }else{
                $data = array('upload_data' => $this->upload->data());
                $image = $data['upload_data']['file_name']; 
            }
            $data = array(
                'image'                     => $image
            );
            $update_slider          = $this->Promotions_m->update_slider($id_data, $data);
        } else {
            
        }
        
        $data = array(
            'title'                     => $this->input->post('title'),
            'type'                      => strtolower($this->file),
            'sorting'                   => $this->input->post('sorting'),
            'url'                       => $this->input->post('url'),
            'start_date'                => $this->input->post('start_date'),
            'end_date'                  => $this->input->post('end_date'),
            'status'                    => $status,
            'edited_by'                 => $this->ion_auth->get_user_id(),
            'edited_date'               => $currentDateTime
        );
        $update_slider          = $this->Promotions_m->update_slider($id_data, $data);

        if ($update_slider) {
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
        if ($this->Promotions_m->delete_slider($id, $data)) {
            $this->muhanz->success($this->lang->line('delete_success'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }  else {
            $this->muhanz->error($this->lang->line('delete_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }
    }

}
