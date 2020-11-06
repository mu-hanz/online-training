<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Flexi_combo extends CI_Controller
{

    var $folder = 'Promotions';
    var $file   = 'Flexi_combo';
    
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
        $list = $this->Promotions_m->get_datatables();
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
            "recordsTotal" => $this->Promotions_m->count_all(),
            "recordsFiltered" => $this->Promotions_m->count_filtered(),
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
            'max_field_tiers'           => '5',
            'page'                      => 'create',
            'promotions_name'           => '',
            'start_date'                => '',
            'end_date'                  => '',
            'valid_on'                  => '',
            'limit_promotion'           => '',
            'limit_user'                => '',
            'limit_user_referral'       => '',
            'type_discount_referral'    => '',
            'id_data'                   => '',
            'get_data_training'         => $this->Promotions_m->get_data_training(true),
            'count_data_training'       => $this->Promotions_m->count_data_training(true)
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

        $count_data_training    = $this->input->post('count_data_training');


        if($count_data_training == 0){
            $this->muhanz->error('No Event Selected', 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
            exit;
        }
        $valid_on               = $this->input->post('valid_on');
        $temp_count             = 0;
        for($i=1; $i <= $count_data_training; $i++){
            $id                 = $this->input->post('id'.$i);
            $price_campaign     = $this->input->post('price_campaign'.$i);

            $count_row          = $this->Promotions_m->get_data_promotions_flexi_combo($id);
            $temp_count+= $count_row;
        }

        if ($temp_count >= '1') {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        } else {

            $data_promotions = array(
                'type'                      => strtolower($this->file),
                'promotions_name'           => $this->input->post('promotions_name'),
                'start_date'                => $this->input->post('start_date'),
                'end_date'                  => $this->input->post('end_date'),
                'valid_on'                  => $this->input->post('valid_on'),
                'limit_promotion'           => $this->input->post('limit_promotion'),
                'limit_user'                => $this->input->post('limit_user'),
                'limit_user_referral'       => $this->input->post('limit_user_referral'),
                'type_discount_referral'    => $this->input->post('type_discount_referral'),
                'status'                    => $status,
                'edited_by'                 => $this->ion_auth->get_user_id(),
                'edited_date'               => $currentDateTime
            );
            $last_id_promotions = $this->Promotions_m->save_promotions($data_promotions);
            if (isset($_POST['amount_discount_referral'])) {
                $amount_discount_referral = str_replace(',', '', $_POST['amount_discount_referral']);
                for($i=0;$i<count($amount_discount_referral);$i++){
                    $data_promotions_type = array(
                        'promotions_id'                 => $last_id_promotions,
                        'type_discount'                 => 'referral',
                        'amount_discount_referral'      => $amount_discount_referral[$i],
                    );
                    if ($amount_discount_referral[$i] != '0' OR $amount_discount_referral[$i] != '') {
                        $insert_promotions_type = $this->Promotions_m->save_promotions_type($data_promotions_type);
                    }
                }
            }
            $max_field_tiers    = $this->input->post('max_field_tiers');
            for ($i = 1; $i <= $max_field_tiers; $i++) {
                if (isset($_POST['customRadio'.$i]) OR isset($_POST['customRadiox'.$i])) {
                    if (isset($_POST['customRadio'.$i])) {
                        $customRadio    = $_POST['customRadio'.$i];
                    } else {
                        $customRadio    = '';
                    }
                    if (isset($_POST['customRadiox'.$i])) {
                        $customRadiox    = $_POST['customRadiox'.$i];
                    } else {
                        $customRadiox    = '';
                    }
                    $name_tier      = $_POST['name_tier'.$i];
                    if ($customRadio == 'criteria_qty') {
                        $criteria_qty   = $_POST['criteria_qty'.$i];
                        if ($customRadiox == 'discount_percent') {
                            $discount_percent   = $_POST['discount_percent'.$i];
                            $data_promotions_tier = array(
                                'promotions_id'     => $last_id_promotions,
                                'name_tier'         => $name_tier,
                                'criteria_qty'      => $criteria_qty,
                                'discount_percent'  => $discount_percent,
                            );
                        } else {
                            $discount_price = $_POST['discount_price'.$i];
                            $data_promotions_tier = array(
                                'promotions_id'     => $last_id_promotions,
                                'name_tier'         => $name_tier,
                                'criteria_qty'      => $criteria_qty,
                                'discount_price'    => str_replace(',', '', $discount_price),
                            );
                        }
                        $insert_promotions_tier = $this->Promotions_m->save_promotions_tier($data_promotions_tier);
                    } else {
                        $criteria_price = $_POST['criteria_price'.$i];
                        if ($customRadiox == 'discount_percent') {
                            $discount_percent   = $_POST['discount_percent'.$i];
                            $data_promotions_tier = array(
                                'promotions_id'     => $last_id_promotions,
                                'name_tier'         => $name_tier,
                                'criteria_price'    => str_replace(',', '', $criteria_price),
                                'discount_percent'  => $discount_percent,
                            );
                        } else {
                            $discount_price = $_POST['discount_price'.$i];
                            $data_promotions_tier = array(
                                'promotions_id'     => $last_id_promotions,
                                'name_tier'         => $name_tier,
                                'criteria_price'    => str_replace(',', '', $criteria_price),
                                'discount_price'    => str_replace(',', '', $discount_price),
                            );
                        }
                        $insert_promotions_tier = $this->Promotions_m->save_promotions_tier($data_promotions_tier);  
                    }
                }
            }
            
            for($i=1; $i <= $count_data_training; $i++){
                $id                 = $this->input->post('id'.$i);
                if (isset($id)) {

                    // Validation Duplicate Id Training / Flexi Combo On Progress
                    $count_check_active_flexi_combo = $this->Promotions_m->count_check_active_flexi_combo($id);
                    if ($count_check_active_flexi_combo >= 1) {
                        $this->Promotions_m->delete_promotions_type($last_id_promotions);
                        $this->Promotions_m->delete_promotions_tier($last_id_promotions);
                        $this->Promotions_m->delete_promotions_detail($last_id_promotions);
                        $this->Promotions_m->delete_promotions($last_id_promotions);
                        $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
                    }

                    $data_promotions_detail = array(
                        'promotions_id'     => $last_id_promotions,
                        'event_id'          => $id,
                    );
                    $insert_promotions_detail = $this->Promotions_m->save_promotions_detail($data_promotions_detail);

                    if($insert_promotions_detail){
                        $this->Promotions_m->update_event_on_sale($id, '1'); // 1 = sedang diskon flexi
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
        $this->load->js('assets/app/js/pages/'.strtolower($this->file).'_create.init.js');

        $title  = str_replace("_", " ", $this->file);
        $row    = $this->Promotions_m->get_data($id);

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
            'promotions_name'                       => $row->promotions_name,
            'start_date'                            => $row->start_date,
            'end_date'                              => $row->end_date,
            'valid_on'                              => $row->valid_on,
            'limit_promotion'                       => $row->limit_promotion,
            'limit_user'                            => $row->limit_user,
            'limit_user_referral'                   => $row->limit_user_referral,
            'type_discount_referral'                => $row->type_discount_referral,
            'promotions_tier'                       => $this->Promotions_m->get_data_promotions_tier($id),
            'count_data_promotions_tier'            => $this->Promotions_m->count_data_promotions_tier($id),
            'promotions_type_referral'              => $this->Promotions_m->get_data_promotions_type_referral($id),
            'count_data_promotions_type_referral'   => $this->Promotions_m->count_data_promotions_type_referral($id),
            'id_data'                               => $id,
            'get_data_training'                     => $this->Promotions_m->get_data_training(),
            'count_data_training'                   => $this->Promotions_m->count_data_training(),
            'get_data_training_detail'              => $this->Promotions_m->get_data_training_detail($id),
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

        if($count_data_training == 0){
            $this->muhanz->error('No Event Selected', 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
            exit;
        }

        // Validation Duplicate Id Training / Flexi Combo On Progress
        for($i=1; $i <= $count_data_training; $i++){
            $id                 = $this->input->post('id'.$i);
            if (isset($id)) {
                $count_check_active_flexi_combo_update = $this->Promotions_m->count_check_active_flexi_combo_update($id, $id_data);
                if ($count_check_active_flexi_combo_update >= 1) {
                    break 1;
                    $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
                }
            }
        }

        $valid_on                   = $this->input->post('valid_on');
        $temp_count                 = 0;
        for($i=1; $i <= $count_data_training; $i++){
            $id                 = $this->input->post('id'.$i);
            $price_campaign     = $this->input->post('price_campaign'.$i);

            $count_row          = $this->Promotions_m->get_data_promotions_flexi_combo_update($id, $id_data);
            $temp_count+= $count_row;
        }
        if ($temp_count >= '1') {
            $this->muhanz->error($this->lang->line('save_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        } else {

            $data_promotions = array(
                'type'                      => strtolower($this->file),
                'promotions_name'           => $this->input->post('promotions_name'),
                'start_date'                => $this->input->post('start_date'),
                'end_date'                  => $this->input->post('end_date'),
                'valid_on'                  => $this->input->post('valid_on'),
                'limit_promotion'           => $this->input->post('limit_promotion'),
                'limit_user'                => $this->input->post('limit_user'),
                'limit_user_referral'       => $this->input->post('limit_user_referral'),
                'type_discount_referral'    => $this->input->post('type_discount_referral'),
                'status'                    => $status,
                'edited_by'                 => $this->ion_auth->get_user_id(),
                'edited_date'               => $currentDateTime
            );
            $update_promotions      = $this->Promotions_m->update_promotions($id_data, $data_promotions);

            if($update_promotions){ // reset on_sale event 
                $data_current = $this->Promotions_m->get_data_training_detail($id_data);

                foreach($data_current as $cr){
                    $this->Promotions_m->update_event_on_sale($cr->event_id, '0'); // 0 = sedang diskon flexi
                }
                
            }

            $delete_promotions_type = $this->Promotions_m->delete_promotions_type($id_data);
            if (isset($_POST['amount_discount_referral'])) {
                $amount_discount_referral = str_replace(',', '', $_POST['amount_discount_referral']);
                for($i=0;$i<count($amount_discount_referral);$i++){
                    $data_promotions_type = array(
                        'promotions_id'                 => $id_data,
                        'type_discount'                 => 'referral',
                        'amount_discount_referral'      => $amount_discount_referral[$i],
                    );
                    if ($amount_discount_referral[$i] != '0' OR $amount_discount_referral[$i] != '') {
                        $insert_promotions_type = $this->Promotions_m->save_promotions_type($data_promotions_type);
                    }
                }
            }

            $delete_promotions_tier = $this->Promotions_m->delete_promotions_tier($id_data);
            $max_field_tiers    = $this->input->post('max_field_tiers');
            for ($i = 1; $i <= $max_field_tiers; $i++) {
                if (isset($_POST['customRadio'.$i]) OR isset($_POST['customRadiox'.$i])) {
                    if (isset($_POST['customRadio'.$i])) {
                        $customRadio    = $_POST['customRadio'.$i];
                    } else {
                        $customRadio    = '';
                    }
                    if (isset($_POST['customRadiox'.$i])) {
                        $customRadiox    = $_POST['customRadiox'.$i];
                    } else {
                        $customRadiox    = '';
                    }
                    $name_tier      = $_POST['name_tier'.$i];
                    if ($customRadio == 'criteria_qty') {
                        $criteria_qty   = $_POST['criteria_qty'.$i];
                        if ($customRadiox == 'discount_percent') {
                            $discount_percent   = $_POST['discount_percent'.$i];
                            $data_promotions_tier = array(
                                'promotions_id'     => $id_data,
                                'name_tier'         => $name_tier,
                                'criteria_qty'      => $criteria_qty,
                                'discount_percent'  => $discount_percent,
                            );
                        } else {
                            $discount_price = $_POST['discount_price'.$i];
                            $data_promotions_tier = array(
                                'promotions_id'     => $id_data,
                                'name_tier'         => $name_tier,
                                'criteria_qty'      => $criteria_qty,
                                'discount_price'    => str_replace(',', '', $discount_price),
                            );
                        }
                        $insert_promotions_tier = $this->Promotions_m->save_promotions_tier($data_promotions_tier);
                    } else {
                        $criteria_price = $_POST['criteria_price'.$i];
                        if ($customRadiox == 'discount_percent') {
                            $discount_percent   = $_POST['discount_percent'.$i];
                            $data_promotions_tier = array(
                                'promotions_id'     => $id_data,
                                'name_tier'         => $name_tier,
                                'criteria_price'    => str_replace(',', '', $criteria_price),
                                'discount_percent'  => $discount_percent,
                            );
                        } else {
                            $discount_price = $_POST['discount_price'.$i];
                            $data_promotions_tier = array(
                                'promotions_id'     => $id_data,
                                'name_tier'         => $name_tier,
                                'criteria_price'    => str_replace(',', '', $criteria_price),
                                'discount_price'    => str_replace(',', '', $discount_price),
                            );
                        }
                        $insert_promotions_tier = $this->Promotions_m->save_promotions_tier($data_promotions_tier);  
                    }
                }
            }
            $delete_promotions_detail = $this->Promotions_m->delete_promotions_detail($id_data);
            
            for($i=1; $i <= $count_data_training; $i++){
                $id                 = $this->input->post('id'.$i);
                if (isset($id)) {
                    $data_promotions_detail = array(
                        'promotions_id'     => $id_data,
                        'event_id'          => $id,
                    );
                    $insert_promotions_detail = $this->Promotions_m->save_promotions_detail($data_promotions_detail);

                    if($insert_promotions_detail){
                        $this->Promotions_m->update_event_on_sale($id, '1'); // 1 = sedang diskon flexi
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
            // reset on_sale event 
                $data_current = $this->Promotions_m->get_data_training_detail($id);

                foreach($data_current as $cr){
                    $this->Promotions_m->update_event_on_sale($cr->event_id, '0'); // 0 = reset diskon flexi
                }
                
            

            $this->muhanz->success($this->lang->line('delete_success'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }  else {
            $this->muhanz->error($this->lang->line('delete_error'), 'webadmin/'.strtolower($this->folder).'/'.strtolower($this->file));
        }
    }

}
