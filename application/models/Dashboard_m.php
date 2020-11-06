<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function update_profile($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('users', $data); 
    }

    function list_members($id){
        $this->db->select('*');
        $this->db->from('members');
        $this->db->where('members.id_users', $id);
        return $this->db->get()->result();
    }

    public function edit_members($id)
    {
        $this->db->select('*');
        $this->db->from('members');
        $this->db->where('members.id_members', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function update_members($id, $data){
        $this->db->where('id_members', $id);
        return $this->db->update('members', $data); 
    }

    function save_members($data){
        return $this->db->insert('members', $data); 
    }

    function delete_members($id){
        $this->db->where('id_members', $id);
        return $this->db->delete('members');
    }

 

    function get_order_users($limit = false){

        $user_id =  $this->ion_auth->user()->row()->id;
        $this->db->select('a.transaction_id,a.invoice_pdf, a.order_id, a.payment_status, a.payment_cancel_date, a.total,  IFNULL(SUM(b.qty),0) AS person');
        $this->db->from('transactions as a');
        $this->db->join('transaction_detail as b', 'b.transaction_id = a.transaction_id');
        $this->db->group_by('a.transaction_id');
        $this->db->where('a.user_id', $user_id);
        if($limit){
            $this->db->limit($limit);
        }
        $this->db->order_by('a.transaction_id', 'desc');
        
        return $this->db->get();
    }


    function get_order_detail_users($id){

        $user_id =  $this->ion_auth->user()->row()->id;
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->join('users', 'users.id = transactions.user_id');
        $this->db->group_by('transaction_id');
        $this->db->where('user_id', $user_id);
        $this->db->where('transaction_id', $id);
        return $this->db->get();
    }

    function get_order_users_detail($transaction_id){
        $this->db->select('*');
        $this->db->from('transaction_detail');
        $this->db->where('transaction_id', $transaction_id);
        return $this->db->get()->result();
    }

    function list_peserta($id){
        $this->db->select('*');
        $this->db->from('transaction_participants');
        $this->db->where('transaction_detail_id', $id);
        return $this->db->get()->result();
    }

    function get_order_users1($limit = false){

        $user_id =  $this->ion_auth->user()->row()->id;
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->join('transaction_detail', 'transaction_detail.transaction_id = transactions.transaction_id', 'left');
        $this->db->join('transaction_participants', 'transaction_participants.transaction_detail_id = transaction_detail.transaction_detail_id', 'left');
        $this->db->where('transactions.user_id', 12);
        if($limit){
            $this->db->limit($limit);
        }
        return $this->db->get();
    }









    public function get_visitor() {
        $this->db->select('SUM(hits) as total_all_viewers', FALSE);
        $this->db->from('viewers');
        return $this->db->get()->row()->total_all_viewers;
    }
    
    public function get_visitor_unique() {
    $this->db->distinct();
    $this->db->select('ip');
    $query = $this->db->get('viewers');
    return $query->num_rows();
    }

    public function get_visitor_chart() {
        $this->db->select('DATE_FORMAT(tanggal, "%m/%Y") as month_date, IFNULL(SUM(hits),0) AS count');
        $this->db->from('viewers');
        $this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 7 DAY AND NOW()');
        $this->db->group_by('DATE(tanggal)');
        $this->db->order_by('DATE(tanggal)','asc');
        return $this->db->get()->result();
    }

    public function get_visitor_chart_last() {
        $this->db->select('IFNULL(SUM(hits),0) AS total');
        $this->db->from('viewers');
        $this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 7 DAY AND NOW()');
        return $this->db->get()->row();
    }

    public function get_visitor_chart_last_seven() {
        $this->db->select('IFNULL(SUM(hits),0) AS total');
        $this->db->from('viewers');
        $this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 14 DAY AND NOW() - INTERVAL 7 DAY');
        return $this->db->get()->row();
    }

    public function get_visitor_chart_month() {
        $this->db->select('DATE_FORMAT(tanggal, "%m/%Y") as month_date, COUNT(ip) AS count');
        $this->db->from('viewers');
        $this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 5 MONTH AND NOW()');
        $this->db->group_by('MONTH(tanggal)');
        $this->db->order_by('DATE(tanggal)','asc');
        return $this->db->get()->result();
    }

    public function get_visitor_chart_month_unique() {
        $this->db->distinct();
        $this->db->select('DATE_FORMAT(tanggal, "%m/%Y") as month_date, COUNT(DISTINCT ip) AS count');
        $this->db->from('viewers');
    	$this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 5 MONTH AND NOW()');
        $this->db->group_by('MONTH(tanggal)');
        $this->db->order_by('DATE(tanggal)','desc');
        return $this->db->get()->result();
        
    }

    public function get_visitor_chart_month_page_view() {
        $this->db->select('DATE_FORMAT(tanggal, "%m/%Y") as month_date, IFNULL(SUM(hits),0) AS count');
        $this->db->from('viewers');
        $this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 5 MONTH AND NOW()');
        $this->db->group_by('MONTH(tanggal)');
        $this->db->order_by('DATE(tanggal)','asc');
        return $this->db->get()->result();
    }
}