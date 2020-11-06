<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Shopping_cart_m extends CI_Model
{

    var $table          = 'shopping_cart';
    var $join_table     = 'shopping_cart_detail';
    var $join_table2    = 'events';
    var $join_table3    = 'promotions_detail';
    var $join_table4    = 'promotions';
    var $join_table5    = 'orders';
    var $join_table6    = 'promotions_type';
    var $join_table7    = 'shopping_cart_collectible_voucher';

    public function count_user_shopping_cart($id_user)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->table.'.id_user', $id_user);
        return $this->db->get()->num_rows();
    }

    public function count_event_shopping_cart_detail($id_shopping_cart, $id_event)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.id_shopping_cart', $id_shopping_cart);
        $this->db->where($this->join_table.'.id_event', $id_event);
        return $this->db->get()->num_rows();
    }

    public function count_shopping_cart_detail($id_shopping_cart)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.id_shopping_cart', $id_shopping_cart);
        return $this->db->get()->num_rows();
    }

    public function count_voucher($id_event)
    {
        $this->db->select('*');
        $this->db->from($this->join_table3);
        $this->db->join($this->join_table4, $this->join_table3.'.promotions_id = '.$this->join_table4.'.promotions_id', 'left');
        $this->db->where($this->join_table3.'.event_id', $id_event);
        $this->db->where($this->join_table4.'.status', 'On Progress');
        $this->db->where($this->join_table4.'.type', 'voucher');
        return $this->db->get()->num_rows();
    }

    public function count_status_voucher($id_shopping_cart)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.id_shopping_cart', $id_shopping_cart);
        $this->db->where($this->join_table.'.status_voucher', 'Available');
        return $this->db->get()->num_rows();
    }

    public function count_active_voucher($coupon_code)
    {
        $this->db->select('*');
        $this->db->from($this->join_table4);
        $this->db->where($this->join_table4.'.promotions_code', $coupon_code);
        $this->db->where($this->join_table4.'.status', 'On Progress');
        return $this->db->get()->num_rows();
    }

    public function count_orders_code_voucher($coupon_code)
    {
        $this->db->select('*');
        $this->db->from($this->join_table5);
        $this->db->where($this->join_table5.'.code_voucher', $coupon_code);
        return $this->db->get()->num_rows();
    }

    public function count_orders_code_voucher_by_user($coupon_code, $id_user)
    {
        $this->db->select('*');
        $this->db->from($this->join_table5);
        $this->db->where($this->join_table5.'.code_voucher', $coupon_code);
        $this->db->where($this->join_table5.'.id_user', $id_user);
        return $this->db->get()->num_rows();
    }

    public function count_collectible_voucher_by_user($id_collectible_voucher, $id_user)
    {
        $this->db->select('*');
        $this->db->from($this->join_table7);
        $this->db->where($this->join_table7.'.id_voucher', $id_collectible_voucher);
        $this->db->where($this->join_table7.'.id_user', $id_user);
        return $this->db->get()->num_rows();
    }

    public function insert_shopping_cart_detail($data)
    {
        $this->db->insert($this->join_table, $data);
        return $this->db->insert_id();
    }

    public function insert_shopping_cart($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function insert_collectible_voucher($data)
    {
        $this->db->insert($this->join_table7, $data);
        return $this->db->insert_id();
    }

    public function list_shopping_cart_detail($id_user)
    {
        $this->db->select($this->join_table.'.id, id_shopping_cart, id_event, thumbs_event, name_event, status_voucher, cost_event, cost_promo_event, cost_campaign_promo, qty');
        $this->db->from($this->join_table);
        $this->db->join($this->table, $this->join_table.'.id_shopping_cart = '.$this->table.'.id', 'left');
        $this->db->where($this->table.'.id_user', $id_user);
        return $this->db->get()->result();
    }

    public function list_shopping_cart_collectible_voucher($id_user)
    {
        $this->db->select('*');
        $this->db->from($this->join_table7);
        $this->db->join($this->join_table4, $this->join_table7.'.id_voucher = '.$this->join_table4.'.promotions_id', 'left');
        $this->db->where($this->join_table7.'.id_user', $id_user);
        $this->db->where($this->join_table4.'.status', 'On Progress');
        return $this->db->get()->result();
    }

    public function list_promotions_detail($id_voucher)
    {
        $this->db->select('*');
        $this->db->from($this->join_table3);
        $this->db->where($this->join_table3.'.promotions_id', $id_voucher);
        return $this->db->get()->result();
    }

    public function get_shopping_cart_detail($id_shopping_cart, $id_event)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.id_shopping_cart', $id_shopping_cart);
        $this->db->where($this->join_table.'.id_event', $id_event);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_shopping_cart($id_user)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->table.'.id_user', $id_user);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_event($id_event)
    {
        $this->db->select('*');
        $this->db->from($this->join_table2);
        $this->db->where($this->join_table2.'.event_id', $id_event);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_shopping_cart_detail_ajax($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_promotions($promotions_code)
    {
        $this->db->select('*');
        $this->db->from($this->join_table4);
        $this->db->where($this->join_table4.'.promotions_code', $promotions_code);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_promotions_type($promotions_id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table6);
        $this->db->where($this->join_table6.'.promotions_id', $promotions_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function update_shopping_cart_detail($id_shopping_cart, $id_event, $data)
    {
        $this->db->where('id_shopping_cart', $id_shopping_cart);
        $this->db->where('id_event', $id_event);
        return $this->db->update($this->join_table, $data);
    }

    public function update_shopping_cart($id_user, $data)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->update($this->table, $data);
    }

    public function update_shopping_cart_detail2($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->join_table, $data);
    }

    public function delete_shopping_cart_detail($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->join_table);
    }

    public function delete_shopping_cart($id_shopping_cart)
    {
        $this->db->where('id', $id_shopping_cart);
        return $this->db->delete($this->table);
    }


    public function check_flexi($event_id)
    {
        $this->db->select('promotions.*');
        $this->db->from('promotions_detail');
        $this->db->join('promotions','promotions.promotions_id = promotions_detail.promotions_id', 'left');
        $this->db->where('promotions_detail.event_id', $event_id);
        $this->db->where('promotions_code', $code);
        return $this->db->get();
    }

    public function get_data_flexi($id)
    {
        $this->db->select('*');
        $this->db->from('promotions');
        $this->db->where('promotions_id', $id);
        return $this->db->get();
    }

    public function check_flexi_user($id, $event_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('promotions_users');
        $this->db->where('id_promotion', $id);
        $this->db->where('event_id', $event_id);
        $this->db->where('user_id', $user_id);
        return $this->db->get();
    }


    public function check_stock_event($event_id)
    {
        $this->db->select('event_max_participant');
        $this->db->from('events');
        $this->db->where('event_id', $event_id);
        return $this->db->get();
    }


    public function check_voucher($code)
    {
        $this->db->select('*');
        $this->db->from('promotions');
        $this->db->where('type', 'voucher');
        $this->db->where('promotions_code', $code);
        $this->db->where('status_delete', '0');
        return $this->db->get();
    }

    public function check_voucher_user($id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('promotions_users');
        $this->db->where('id_promotion', $id);
        $this->db->where('user_id', $user_id);
        return $this->db->get();
    }

    public function check_events_voucher($id_event, $promotions_id)
    {
        $this->db->select('promotions_id');
        $this->db->from('promotions_detail');
        $this->db->where('event_id', $id_event);
        $this->db->where('promotions_id', $promotions_id);
        return $this->db->get();
    }

    public function apply_voucher($promotions_id)
    {
        $this->db->select('*');
        $this->db->from('promotions_type');
        $this->db->where('promotions_id', $promotions_id);
        return $this->db->get()->row();
    }

    public function apply_voucher1($id_user)
    {
        $this->db->select('*');
        $this->db->from($this->join_table7);
        $this->db->join($this->join_table4, $this->join_table7.'.id_voucher = '.$this->join_table4.'.promotions_id', 'left');
        $this->db->where($this->join_table7.'.id_user', $id_user);
        $this->db->where($this->join_table4.'.status', 'On Progress');
        return $this->db->get()->result();
    }


    public function get_participant($id){
        $this->db->select('id_members, name');
        $this->db->from('members');
        $this->db->where('members.id_users', $id);
        $this->db->order_by('members.id_members', 'desc');
        return $this->db->get()->result();
    }

    public function add_participant($data)
    {
        $this->db->insert('members', $data);
        return $this->db->insert_id();
    }


    public function insert_promotions_user($data, $id)
    {
        $this->db->insert('promotions_users', $data);
        
        if($this->db->insert_id()){
            $this->db->set('limit_promotion', 'limit_promotion-1', false);
            $this->db->where('promotions_id', $id);
            return $this->db->update('promotions');
        }
    }

    public function insert_transactions($data)
    {
        $this->db->insert('transactions', $data);
        return $this->db->insert_id();
    }

    public function update_transaction($data, $id)
    {
        $this->db->where('order_id', $id);
        return $this->db->update('transactions', $data);
    }

    public function insert_transaction_detail($data, $qty, $id)
    {
        $this->db->insert('transaction_detail', $data);
        $detail_id = $this->db->insert_id();
        if($this->db->insert_id()){
            $this->db->set('event_max_participant', 'event_max_participant-'.$qty, false);
            $this->db->where('event_id', $id);
            $this->db->update('events');
            return $detail_id;
        }
    }

    public function insert_transaction_user_data($data)
    {
        $this->db->insert('transaction_participants', $data);
        return $this->db->insert_id();
    }

    public function update_user_billing($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }


    public function rollback_checkout($tabel, $id)
    {
        $this->db->where('transaction_id', $id);
        return $this->db->delete($tabel);
    }


    public function get_data_participant($id){
        $this->db->select('*');
        $this->db->from('members');
        $this->db->where('id_members', $id);
        return $this->db->get()->row();
    }

    function get_order_detail_users($id){

        $user_id =  $this->ion_auth->user()->row()->id;
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->group_by('transaction_id');
        $this->db->where('user_id', $user_id);
        $this->db->where('transaction_id', $id);
        return $this->db->get()->row();
    }

    function get_order_users_detail($transaction_id){
        $this->db->select('*');
        $this->db->from('transaction_detail');
        $this->db->where('transaction_id', $transaction_id);
        return $this->db->get()->result();
    }

}
