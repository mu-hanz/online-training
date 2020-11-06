<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	//---Templating----//
    public function __construct()
    {
        parent::__construct();
        $this->_init();
        $this->muhanz->check_auth_user();
        $this->load->model('Dashboard_m');
        $this->load->library('form_validation');
    }

    private function _init()
    {
        $data = array(
            'user' => $this->ion_auth->user()->row()
        );
        $this->output->set_template('main/users/layout_users');
        $this->load->section('header', 'main/layout/header');
        $this->load->section('menu', 'main/users/users_menu');  
        $this->load->js('assets/scripts/pay.init.js'); 
    }

    public function index()
	{	
        $status = $this->input->get('status_code');
        if($status){
            redirect('users/dashboard/order');
        }

        $data = array(
            'user' => $this->ion_auth->user()->row(),
            'last_order'=> $this->Dashboard_m->get_order_users(5)->result()
        );
		$this->output->set_title($this->muhanz->app_title('Dasboard Saya'));
		$this->load->view('main/users/dashboard', $data);
    }

    public function profile()
	{	
        $this->load->css('assets/parsley/parsley.css');
        $this->load->js('assets/parsley/parsley.min.js');
        $this->load->js('assets/app/js/pages/sweetalert.init.js');
        $data = array(
            'user'                  => $this->ion_auth->user()->row(),
            'action'                => base_url('store/users/dashboard/update_profile'),
            'redirect_sweetalert'   => '/users/profile'
        );
		$this->output->set_title($this->muhanz->app_title('Profile'));
		$this->load->view('main/users/profile', $data);
    }

    public function update_profile()
    {
        $this->output->unset_template('layout');
        $id = $this->input->post('id');

        if (!empty($this->input->post('password'))) {
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]');
            if($this->form_validation->run() === FALSE){
                $this->muhanz->error($this->lang->line('confirm_password_not_match'), 'users/profile');
            } else {
                $data = array(
                    'password'              => $this->input->post('password'),
                    'first_name'            => $this->input->post('first_name'),
                    'last_name'             => $this->input->post('last_name'),
                    'username'              => $this->input->post('email'),
                    'email'                 => $this->input->post('email'),
                    'phone'                 => $this->input->post('phone'),
                    'job_title'             => $this->input->post('job_title'),
                    'company'               => $this->input->post('company'),
                    'company_npwp'          => $this->input->post('company_npwp'),
                    'company_address'       => $this->input->post('company_address'),
                );
                if (!$this->ion_auth->update($id, $data)) {
                    $this->muhanz->error($this->lang->line('save_error'), 'users/profile');
                } else {
                    $this->muhanz->success($this->lang->line('save_success'), 'users/profile');
                }
            }
        } else {
            $data = array(
                'first_name'            => $this->input->post('first_name'),
                'last_name'             => $this->input->post('last_name'),
                'username'              => $this->input->post('email'),
                'email'                 => $this->input->post('email'),
                'phone'                 => $this->input->post('phone'),
                'job_title'             => $this->input->post('job_title'),
                'company'               => $this->input->post('company'),
                'company_npwp'          => $this->input->post('company_npwp'),
                'company_address'       => $this->input->post('company_address'),
            );
            if (!$this->ion_auth->update($id, $data)) {
                $this->muhanz->error($this->lang->line('save_error'), 'users/profile');
            } else {
                $this->muhanz->success($this->lang->line('save_success'), 'users/profile');
            }
        }
    }

    public function participant()
	{	
        $this->load->css('assets/main/css/dataTables.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/responsive.bootstrap4.min.css');
        $this->load->css('assets/app/libs/datatables/buttons.bootstrap4.min.css');
        $this->load->js('assets/app/libs/datatables/jquery.dataTables.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.bootstrap4.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.responsive.min.js');
        $this->load->js('assets/app/libs/datatables/responsive.bootstrap4.min.js');
        $this->load->js('assets/app/libs/datatables/dataTables.checkboxes.min.js');
        $this->load->js('assets/app/libs/datatables/dom-checkbox.js');
        $this->load->js('assets/app/js/pages/datatable_responsive.init.js');

        $user = $this->ion_auth->user()->row();

        $data = array(
            'user'          => $this->ion_auth->user()->row(),
            'list_members'  => $this->Dashboard_m->list_members($user->id),
            'page'          => 'index',
            'redirect_sweetalert'   => 'users/dashboard/participant'
        );
		$this->output->set_title($this->muhanz->app_title('Members'));
		$this->load->view('main/users/members', $data);
    }

    public function add_participant()
	{	

        $data = array(
            'action'        => base_url('users/dashboard/save_participant'),
            'user'          => $this->ion_auth->user()->row(),
            'id_members'    => '',
            'name'          => '',
            'email'         => '',
            'job_title'     => '',
            'phone'         => '',
            'page'          => 'add'
        );
        $this->output->set_title($this->muhanz->app_title('Add Members'));
		$this->load->view('main/users/members', $data);
    }

    public function save_participant()
    {
        $this->output->unset_template('layout');
        $data = array(
            'id_users'        => $this->ion_auth->user()->row()->id,  
            'name'            => $this->input->post('name'),
            'email'           => $this->input->post('email'),
            'job_title'       => $this->input->post('job_title'),
            'phone'           => $this->input->post('phone'),
            'created_date'    => date('Y-m-d H:i:s')
        );
        if (!$this->Dashboard_m->save_members($data)) {
            $this->muhanz->error($this->lang->line('save_error'), 'users/dashboard/participant');
        } else {
            $this->muhanz->success($this->lang->line('save_success'), 'users/dashboard/participant');
        }
    }

    public function edit_participant($id)
	{	
        $row = $this->Dashboard_m->edit_members($id);
        $data = array(
            'action'        => base_url('users/dashboard/update_participant'),
            'user'          => $this->ion_auth->user()->row(),
            'id_members'    => $row->id_members,
            'name'          => $row->name,
            'email'         => $row->email,
            'job_title'     => $row->job_title,
            'phone'         => $row->phone,
            'page'          => 'edit'
        );
        $this->output->set_title($this->muhanz->app_title('Members Edit'));
		$this->load->view('main/users/members', $data);
    }

    public function update_participant()
    {
        $this->output->unset_template('layout');
        $id = $this->input->post('id');

        $data = array(
            'name'            => $this->input->post('name'),
            'email'           => $this->input->post('email'),
            'job_title'       => $this->input->post('job_title'),
            'phone'           => $this->input->post('phone'),
        );
        if (!$this->Dashboard_m->update_members($id, $data)) {
            $this->muhanz->error($this->lang->line('save_error'), 'users/dashboard/participant');
        } else {
            $this->muhanz->success($this->lang->line('save_success'), 'users/dashboard/participant');
        }
    }

    public function delete_participant()
    {
        $this->output->unset_template();
        
        $id = $this->input->post('term_id');
        if ($this->Dashboard_m->delete_members($id)) {
            $this->muhanz->success($this->lang->line('delete_success'), 'members');
        }  else {
            $this->muhanz->error($this->lang->line('delete_error'), 'members');
        }
    } 

    public function order()
	{	
        $data = array(
            'user' => $this->ion_auth->user()->row(),
            'last_order'=> $this->Dashboard_m->get_order_users()->result()
        );
		$this->output->set_title($this->muhanz->app_title('Order Saya'));
		$this->load->view('main/users/my_order', $data);
    }


    public function detail_order($id)
	{	
        $data = array(
            'user' => $this->ion_auth->user()->row(),
            'data_transaction' => $this->Dashboard_m->get_order_detail_users($id)->row(),
            'list_order'=> $this->Dashboard_m->get_order_users_detail($id)
        );
		$this->output->set_title($this->muhanz->app_title('Order Saya'));
		$this->load->view('main/users/detail_order', $data);
    }

    public function create_invoice($id)
	{	
        $this->output->unset_template();

        $data_transaction = $this->Dashboard_m->get_order_detail_users($id)->row();
        $data = array(
            'data_transaction' => $this->Dashboard_m->get_order_detail_users($id)->row(),
            'list_order'=> $this->Dashboard_m->get_order_users_detail($id)
        );

        $layout       = 'main/invoice_pdf_tpl';
        

        //save_pdf
        $html = $this->load->view($layout, $data, true);
        $file_name = $data_transaction->order_id;
        $this->pdf->download_pdf($html, $file_name);


    }


    
    

}