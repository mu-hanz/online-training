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

    // public function get_data_promotions_flexi_combo_tier($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from($this->join_table_promotions);
    //     $this->db->join($this->table_promotions, $this->join_table_promotions.'.promotions_id = '.$this->table_promotions.'.promotions_id', 'left');
    //     $this->db->join($this->join_table_promotions2, $this->table_promotions.'.promotions_id = '.$this->join_table_promotions2.'.promotions_id', 'left');
    //     $this->db->where($this->join_table_promotions.'.event_id', $id);
    //     $this->db->where($this->table_promotions.'.status', 'On Progress');
    //     $this->db->where($this->table_promotions.'.type', 'flexi_combo');
    //     $this->db->where($this->join_table_promotions.'.status_delete', '0');
    //     return $this->db->get()->result();
    // }

    // public function count_data_promotions_campaign($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from($this->join_table_promotions);
    //     $this->db->join($this->table_promotions, $this->join_table_promotions.'.promotions_id = '.$this->table_promotions.'.promotions_id', 'left');
    //     $this->db->where($this->join_table_promotions.'.event_id', $id);
    //     $this->db->where($this->table_promotions.'.status', 'On Progress');
    //     $this->db->where($this->table_promotions.'.type', 'campaign');
    //     $this->db->where($this->join_table_promotions.'.status_delete', '0');
    //     return $this->db->get()->num_rows();
    // }

    // public function get_data_promotions_campaign($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from($this->join_table_promotions);
    //     $this->db->join($this->table_promotions, $this->join_table_promotions.'.promotions_id = '.$this->table_promotions.'.promotions_id', 'left');
    //     $this->db->join($this->join_table_promotions2, $this->table_promotions.'.promotions_id = '.$this->join_table_promotions2.'.promotions_id', 'left');
    //     $this->db->where($this->join_table_promotions.'.event_id', $id);
    //     $this->db->where($this->table_promotions.'.status', 'On Progress');
    //     $this->db->where($this->table_promotions.'.type', 'campaign');
    //     $this->db->where($this->join_table_promotions.'.status_delete', '0');
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    // public function insert_post($data)
    // {
    //     $this->db->insert('posts', $data);
    //     return $this->db->insert_id();
    // }

    // public function insert_content($data)
    // {
    //     $this->db->insert('posts', $data);
    //     return $this->db->insert_id();
    // }

    // public function insert_event($data)
    // {
    //     $this->db->insert('events', $data);
    //     return $this->db->insert_id();
    // }

    // public function data_content()
    // {
    //     $this->db->select('*');
    //     $this->db->from('posts');
    //     $this->db->where('post_type', 'events-content');
    //     return $this->db->get()->result();
    // }

    // public function get_content($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('posts');
    //     $this->db->where('post_type', 'events-content');
    //     $this->db->where('id_post', $id);
    //     return $this->db->get()->row();
    // }

    // public function get_articles($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('posts');
    //     $this->db->where('post_type', 'articles');
    //     $this->db->where('id_post', $id);
    //     return $this->db->get()->row();
    // }

    // public function get_pages($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('posts');
    //     $this->db->where('post_type', 'pages');
    //     $this->db->where('id_post', $id);
    //     return $this->db->get()->row();
    // }
    
    // public function update_post($id, $data)
    // {
    //     $this->db->where('id_post', $id);
    //     return $this->db->update('posts', $data);
    // }

    // public function update_post_trash($id)
    // {
    //     $this->db->set('post_trash', '1');
    //     $this->db->where('id_post', $id);
    //     return $this->db->update('posts');
    // }

    // public function update_post_restore($id)
    // {
    //     $this->db->set('post_trash', '0');
    //     $this->db->where('id_post', $id);
    //     return $this->db->update('posts');
    // }

    // public function delete_permanent($id)
    // {
    //     $this->db->where('id_post', $id);
    //     return $this->db->delete('posts');
    // }

    // public function check_post_used($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('events');
    //     $this->db->where('post_id', $id);
    //     return $this->db->get()->num_rows();
    // }


    // //events
    // public function update_events($id, $data)
    // {
    //     $this->db->where('event_id', $id);
    //     return $this->db->update('events', $data);
    // }

    // public function get_event($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('events');
    //     $this->db->join('posts', 'posts.id_post = events.post_id', 'left');
    //     $this->db->where('event_id', $id);
    //     return $this->db->get()->row();
    // }
    
    // public function data_cron()
    // {
    //     $this->db->select('*');
    //     $this->db->from('posts');
    //     $this->db->where('post_type', 'blog');
    //     $this->db->where('post_status', "on_schedule");
    //     $this->db->where('post_trash', '0');
    //     $this->db->order_by('id_post','desc');
    //     return $this->db->get()->result();
    // }

    // public function get_event_all($limit = false, $offset = false, $viewby = false, $sortby = false)
    // {
    //     $this->db->select('events.*, g.name as group_name, c.name as cert_name ');
    //     $this->db->from('events');
    //     $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
    //     $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
    //     $this->db->where('event_status', 'publish');

    //     if($limit && $offset){
    //         $this->db->limit($limit, $offset);
    //     } elseif ($limit && $offset == false){
    //         $this->db->limit($limit);
    //     }

    //     if($viewby == 'popular'){
    //         $this->db->order_by('event_id','desc');
    //     } else {
    //         $this->db->order_by('event_id','desc');
    //     }
       
    //     return $this->db->get()->result();
    // }

    // public function get_articles_all($limit = false, $offset = false)
    // {
    //     $this->db->select('*');
    //     $this->db->from('posts');
    //     $this->db->join('term_relationships', 'term_relationships.object_id = posts.id_post', 'left');
    //     $this->db->join('terms', 'terms.term_id = term_relationships.term_taxonomy_id', 'left');
    //     $this->db->where('post_status', 'publish');
    //     $this->db->where('post_type', 'articles');

    //     if($limit && $offset){
    //         $this->db->limit($limit, $offset);
    //     } elseif ($limit && $offset == false){
    //         $this->db->limit($limit);
    //     }

    //     return $this->db->get()->result();
    // }

    // public function view_event($slug)
    // {
    //     $this->db->select('events.*,posts.*, g.name as group_name, c.name as cert_name ');
    //     $this->db->from('events');
    //     $this->db->join('posts', 'posts.id_post = events.post_id', 'left');
    //     $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
    //     $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
    //     $this->db->where('event_slug', $slug);
    //     return $this->db->get();
    // }

    // public function view_articles($slug)
    // {
    //     $this->db->select('*');
    //     $this->db->from('posts');
    //     $this->db->join('term_relationships', 'term_relationships.object_id = posts.id_post', 'left');
    //     $this->db->join('terms', 'terms.term_id = term_relationships.term_taxonomy_id', 'left');
    //     $this->db->join('users', 'users.id = posts.post_author', 'left');
    //     $this->db->where('post_slug', $slug);
    //     return $this->db->get();
    // }

}
