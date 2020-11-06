<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Orders_m extends CI_Model
{

    public function detail_order($transaction_id)
    {
        $this->db->select('*');
        $this->db->from('transaction_detail');
        $this->db->where('transaction_id', $transaction_id);
        return $this->db->get()->result();
    }



    function get_order_transactions($transaction_id){

        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->join('users', 'users.id = transactions.user_id');
        $this->db->group_by('transaction_id');
        $this->db->where('transaction_id', $transaction_id);
        return $this->db->get();
    }

    function get_order_transaction_detail($transaction_id){
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
    

}
