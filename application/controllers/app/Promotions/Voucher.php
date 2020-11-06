<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends CI_Controller
{

    var $folder = 'Promotions';
    var $file   = 'Voucher';
    
    //---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->muhanz->check_auth();
        $this->_init();
        $this->load->model($this->folder.'_m');
    }

    private function _init()
    {
        $this->output->set_template('app/layout/webadmin');
		$this->load->section('topbar', 'app/layout/mz_topbar');
        $this->load->section('menubar', 'app/layout/mz_menubar');
        
        // css
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
        $list = $this->Promotions_m->get_datatables_voucher();
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
            "recordsTotal" => $this->Promotions_m->count_all_voucher(),
            "recordsFiltered" => $this->Promotions_m->count_filtered_voucher(),
            'data' => $data,
        );

        echo json_encode($data2);
    }

    public function create()
    {
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
            'collected_voucher_date'    => '',
            'area_display_voucher'      => '',
            'type_discount'             => '',
            'start_date'                => '',
            'end_date'                  => '',
            'valid_on'                  => '',
            'limit_promotion'           => '',
            'limit_user'                => '',
            'nominal_limit'             => '',
            'nominal_discount'          => '',
            'percent_limit'             => '',
            'percent_discount'          => '',
            'percent_max_discount'      => '',
            'promotions_code'           => '',
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

    public function get_data_json2()
    {
        $this->output->unset_template();
        $list       = $this->Promotions_m->get_datatables2();
		$data       = array();
        $no         = $_POST['start'];
        $page       = $_POST['page'];
        $id_data    = $_POST['id_data'];
        if ($page == 'create') {
            foreach ($list as $row) {
                $data[] = array (
                    'event_id'          => $row->event_id,
                    'post_title'        => $row->post_title,
                    'event_cost'        => 'Rp. '.number_format($row->event_cost),
                    'event_location'    => $row->event_location,
                    'checkbox'          => '0',
                );
            }
        } else {
            $list2       = $this->Promotions_m->get_data_promotions_detail($id_data);
            foreach ($list as $row) {
                $checkbox = 0;
                foreach ($list2 as $row2) {
                    if ($row->event_id === $row2->event_id) {
                        $checkbox = '1';
                        break;
                    }
                }
                $data[] = array (
                    'event_id'          => $row->event_id,
                    'post_title'        => $row->post_title,
                    'event_cost'        => 'Rp. '.number_format($row->event_cost),
                    'event_location'    => $row->event_location,
                    'checkbox'          => $checkbox,
                );
            }
        }
        $data2 = array (
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Promotions_m->count_all2(),
            "recordsFiltered" => $this->Promotions_m->count_filtered2(),
            'data' => $data,
        );

        echo json_encode($data2);
    }

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
        // $type_voucher = $this->input->post('type_voucher');
         $type_voucher = 'Code Voucher';
        if ($type_voucher == 'Collectible') {
            $collected_voucher_date = $this->input->post('collected_voucher_date');
            $area_display_voucher   = $this->input->post('area_display_voucher');
            $promotions_code        = '';
        } else {
            $collected_voucher_date = '';
            $area_display_voucher   = '';
            $promotions_code        = $this->input->post('promotions_code');
        }
        $data_promotions = array(
            'type'                      => strtolower($this->file),
            'type_voucher'              => 'Code Voucher',
            'promotions_name'           => $this->input->post('promotions_name'),
            'promotions_code'           => $promotions_code,
            'area_display_voucher'      => $area_display_voucher,
            'collected_voucher_date'    => $collected_voucher_date,
            'start_date'                => $this->input->post('start_date'),
            'end_date'                  => $this->input->post('end_date'),
            'valid_on'                  => $this->input->post('valid_on'),
            'limit_promotion'           => $this->input->post('limit_promotion'),
            'limit_user'                => $this->input->post('limit_user'),
            'status'                    => $status,
            'edited_by'                 => $this->ion_auth->get_user_id(),
            'edited_date'               => $currentDateTime
        );
        $last_id_promotions = $this->Promotions_m->save_promotions($data_promotions);
        $type_discount = $this->input->post('customRadio');
        if ($type_discount == 'nominal') {
            $nominal_limit          = $this->input->post('nominal_limit');
            $nominal_discount       = $this->input->post('nominal_discount');
            $percent_limit          = '';
            $percent_discount       = '';
            $percent_max_discount   = '';
        } else {
            $nominal_limit          = '';
            $nominal_discount       = '';
            $percent_limit          = $this->input->post('percent_limit');
            $percent_discount       = $this->input->post('percent_discount');
            $percent_max_discount   = $this->input->post('percent_max_discount');
        }
        $data_promotions_type = array(
            'promotions_id'         => $last_id_promotions,
            'type_discount'         => $this->input->post('customRadio'),
            'nominal_limit'         => str_replace(',', '', $nominal_limit),
            'nominal_discount'      => str_replace(',', '', $nominal_discount),
            'percent_limit'         => str_replace(',', '', $percent_limit),
            'percent_discount'      => $percent_discount,
            'percent_max_discount'  => str_replace(',', '', $percent_max_discount),
        );
                
        $insert_promotions_type = $this->Promotions_m->save_promotions_type($data_promotions_type);
        $count_data_training    = $this->input->post('count_data_training');
        $valid_on    = $this->input->post('valid_on');
        for($i=1; $i <= $count_data_training; $i++){
            $id                 = $this->input->post('id'.$i);
            if (isset($id)) {
                $data_promotions_detail = array(
                    'promotions_id'     => $last_id_promotions,
                    'event_id'          => $id,
                );
                
                $insert_promotions_detail = $this->Promotions_m->save_promotions_detail($data_promotions_detail);
                
            }
        }

        if ($last_id_promotions) {
            $this->muhanz->success($this->lang->line('save_success'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        } else {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }
    }

    public function edit($id)
    {
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
            'type_voucher'                  => $row->type_voucher,
            'promotions_name'               => $row->promotions_name,
            'start_date'                    => $row->start_date,
            'end_date'                      => $row->end_date,
            'valid_on'                      => $row->valid_on,
            'limit_promotion'               => $row->limit_promotion,
            'limit_user'                    => $row->limit_user,
            'promotions_code'               => $row->promotions_code,
            'collected_voucher_date'        => $row->collected_voucher_date,
            'area_display_voucher'          => $row->area_display_voucher,
            'type_discount'                 => $row2->type_discount,
            'nominal_limit'                 => $row2->nominal_limit,
            'nominal_discount'              => $row2->nominal_discount,
            'percent_limit'                 => $row2->percent_limit,
            'percent_discount'              => $row2->percent_discount,
            'percent_max_discount'          => $row2->percent_max_discount,
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
        // $type_voucher       = $this->input->post('type_voucher');
        $type_voucher       = 'Code Voucher';
        if ($type_voucher == 'Collectible') {
            $collected_voucher_date = $this->input->post('collected_voucher_date');
            $area_display_voucher   = $this->input->post('area_display_voucher');
            $promotions_code        = '';
        } else {
            $collected_voucher_date = '';
            $area_display_voucher   = '';
            $promotions_code        = $this->input->post('promotions_code');
        }
        $data_promotions = array(
            'type'                      => strtolower($this->file),
            'type_voucher'              => 'Code Voucher',
            'promotions_name'           => $this->input->post('promotions_name'),
            'promotions_code'           => $promotions_code,
            'area_display_voucher'      => $area_display_voucher,
            'collected_voucher_date'    => $collected_voucher_date,
            'start_date'                => $this->input->post('start_date'),
            'end_date'                  => $this->input->post('end_date'),
            'valid_on'                  => $this->input->post('valid_on'),
            'limit_promotion'           => $this->input->post('limit_promotion'),
            'limit_user'                => $this->input->post('limit_user'),
            'status'                    => $status,
            'edited_by'                 => $this->ion_auth->get_user_id(),
            'edited_date'               => $currentDateTime
        );
        $update_promotions      = $this->Promotions_m->update_promotions($id_data, $data_promotions);
        $type_discount = $this->input->post('customRadio');
        if ($type_discount == 'nominal') {
            $nominal_limit          = $this->input->post('nominal_limit');
            $nominal_discount       = $this->input->post('nominal_discount');
            $percent_limit          = '';
            $percent_discount       = '';
            $percent_max_discount   = '';
        } else {
            $nominal_limit          = '';
            $nominal_discount       = '';
            $percent_limit          = $this->input->post('percent_limit');
            $percent_discount       = $this->input->post('percent_discount');
            $percent_max_discount   = $this->input->post('percent_max_discount');
        }
        $data_promotions_type = array(
            'type_discount'         => $this->input->post('customRadio'),
            'nominal_limit'         => str_replace(',', '', $nominal_limit),
            'nominal_discount'      => str_replace(',', '', $nominal_discount),
            'percent_limit'         => str_replace(',', '', $percent_limit),
            'percent_discount'      => $percent_discount,
            'percent_max_discount'  => str_replace(',', '', $percent_max_discount),
        );
        $update_promotions_type     = $this->Promotions_m->update_promotions_type($id_data, $data_promotions_type);
        $delete_promotions_detail   = $this->Promotions_m->delete_promotions_detail($id_data);
        $count_data_training        = $this->input->post('count_data_training');
        $valid_on                   = $this->input->post('valid_on');
        for($i=1; $i <= $count_data_training; $i++){
            $id                 = $this->input->post('id'.$i);
            if (isset($id)) {
                $data_promotions_detail = array(
                    'promotions_id'     => $id_data,
                    'event_id'          => $id,
                );
                
                $insert_promotions_detail = $this->Promotions_m->save_promotions_detail($data_promotions_detail);
                
            }
        }

        if ($update_promotions) {
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
        if ($this->Promotions_m->delete_promotions($id, $data)) {
            $this->muhanz->success($this->lang->line('delete_success'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }  else {
            $this->muhanz->error($this->lang->line('delete_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }
    }

}
