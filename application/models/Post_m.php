<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Post_m extends CI_Model
{

    var $table_promotions           = 'promotions';
    var $join_table_promotions      = 'promotions_detail';
    var $join_table_promotions2     = 'promotions_tier';
    var $join_table_promotions3     = 'promotions_type';

    public function list_collectible_voucher($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table_promotions);
        $this->db->join($this->table_promotions, $this->join_table_promotions.'.promotions_id = '.$this->table_promotions.'.promotions_id', 'left');
        $this->db->join($this->join_table_promotions3, $this->table_promotions.'.promotions_id = '.$this->join_table_promotions3.'.promotions_id', 'left');
        $this->db->where($this->join_table_promotions.'.event_id', $id);
        $this->db->where($this->table_promotions.'.status', 'On Progress');
        $this->db->where($this->table_promotions.'.type_voucher', 'Collectible');
        $this->db->where($this->join_table_promotions.'.status_delete', '0');
        return $this->db->get()->result();
    }

    public function count_data_promotions_flexi_combo($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table_promotions);
        $this->db->join($this->table_promotions, $this->join_table_promotions.'.promotions_id = '.$this->table_promotions.'.promotions_id', 'left');
        $this->db->where($this->join_table_promotions.'.event_id', $id);
        $this->db->where($this->table_promotions.'.status', 'On Progress');
        $this->db->where($this->table_promotions.'.type', 'flexi_combo');
        $this->db->where($this->join_table_promotions.'.status_delete', '0');
        return $this->db->get()->num_rows();
    }

    public function count_collectible_voucher($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table_promotions);
        $this->db->join($this->table_promotions, $this->join_table_promotions.'.promotions_id = '.$this->table_promotions.'.promotions_id', 'left');
        $this->db->where($this->join_table_promotions.'.event_id', $id);
        $this->db->where($this->table_promotions.'.status', 'On Progress');
        $this->db->where($this->table_promotions.'.type_voucher', 'Collectible');
        $this->db->where($this->join_table_promotions.'.status_delete', '0');
        return $this->db->get()->num_rows();
    }

    

    public function get_data_promotions_flexi_combo_tier($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table_promotions);
        $this->db->join($this->table_promotions, $this->join_table_promotions.'.promotions_id = '.$this->table_promotions.'.promotions_id', 'left');
        $this->db->join($this->join_table_promotions2, $this->table_promotions.'.promotions_id = '.$this->join_table_promotions2.'.promotions_id', 'left');
        $this->db->where($this->join_table_promotions.'.event_id', $id);
        $this->db->where($this->table_promotions.'.status', 'On Progress');
        $this->db->where($this->table_promotions.'.type', 'flexi_combo');
        $this->db->where($this->join_table_promotions.'.status_delete', '0');
        return $this->db->get()->result();
    }



    public function get_data_promotions_campaign($id)
    {
        $dateNow = date('Y-m-d H:i:s', now());

        $this->db->select('*');
        $this->db->from($this->join_table_promotions);
        $this->db->join($this->table_promotions, $this->join_table_promotions.'.promotions_id = '.$this->table_promotions.'.promotions_id', 'left');
        $this->db->join($this->join_table_promotions2, $this->table_promotions.'.promotions_id = '.$this->join_table_promotions2.'.promotions_id', 'left');
        $this->db->where($this->join_table_promotions.'.event_id', $id);
        $this->db->where($this->table_promotions.'.start_date <=', $dateNow);
        $this->db->where($this->table_promotions.'.end_date >=', $dateNow);
        $this->db->where($this->table_promotions.'.status', 'On Progress');
        $this->db->where($this->table_promotions.'.type', 'campaign');
        $this->db->where($this->join_table_promotions.'.status_delete', '0');
        return $this->db->get();
    }



    public function promo_flexi($id)
    {
        $dateNow = date('Y-m-d H:i:s', now());

        $this->db->select('*');
        $this->db->from('promotions');
        $this->db->join('promotions_detail', 'promotions_detail.promotions_id = promotions.promotions_id', 'left');
        $this->db->join('promotions_tier', 'promotions_tier.promotions_id = promotions.promotions_id', 'left');
        $this->db->where('promotions.start_date <=', $dateNow);
        $this->db->where('promotions.end_date >=', $dateNow);
        $this->db->where('promotions.status', 'On Progress');
        $this->db->where('promotions.type', 'flexi_combo');
        $this->db->where('promotions.status_delete', '0');
        $this->db->where('event_id', $id);
        return $this->db->get();
    }


    public function insert_post($data)
    {
        $this->db->insert('posts', $data);
        return $this->db->insert_id();
    }

    public function insert_content($data)
    {
        $this->db->insert('posts', $data);
        return $this->db->insert_id();
    }

    public function insert_event($data)
    {
        $this->db->insert('events', $data);
        return $this->db->insert_id();
    }

    public function data_content()
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('post_type', 'events-content');
        return $this->db->get()->result();
    }

    public function get_content($id)
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('post_type', 'events-content');
        $this->db->where('id_post', $id);
        return $this->db->get()->row();
    }

    public function get_articles($id)
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('post_type', 'articles');
        $this->db->where('id_post', $id);
        return $this->db->get()->row();
    }

    public function get_pages($id)
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('post_type', 'pages');
        $this->db->where('id_post', $id);
        return $this->db->get()->row();
    }
    
    public function update_post($id, $data)
    {
        $this->db->where('id_post', $id);
        return $this->db->update('posts', $data);
    }

    public function update_post_trash($id)
    {
        $this->db->set('post_trash', '1');
        $this->db->where('id_post', $id);
        return $this->db->update('posts');
    }

    public function update_post_restore($id)
    {
        $this->db->set('post_trash', '0');
        $this->db->where('id_post', $id);
        return $this->db->update('posts');
    }

    public function delete_permanent($id)
    {
        $this->db->where('id_post', $id);
        return $this->db->delete('posts');
    }

    public function check_post_used($id)
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where('post_id', $id);
        return $this->db->get()->num_rows();
    }


    //events
    public function update_events($id, $data)
    {
        $this->db->where('event_id', $id);
        return $this->db->update('events', $data);
    }

    public function get_event($id)
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->join('posts', 'posts.id_post = events.post_id', 'left');
        $this->db->where('event_id', $id);
        return $this->db->get()->row();
    }
    
    public function data_cron()
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('post_type', 'blog');
        $this->db->where('post_status', "on_schedule");
        $this->db->where('post_trash', '0');
        $this->db->order_by('id_post','desc');
        return $this->db->get()->result();
    }

    public function get_event_all($limit = false, $offset = false, $search = false)
    {
        $this->db->select('events.*, g.name as group_name, g.slug as group_slug, g.term_id as groupid, c.name as cert_name ');
        $this->db->from('events');
        $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
        $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
        $this->db->where('event_status', 'publish');
        if($search){
            $this->db->like('event_name', $search);
        }

        if($limit && $offset){
            $this->db->limit($limit, $offset);
        } elseif ($limit && $offset == false){
            $this->db->limit($limit);
        }

        $this->db->order_by('events.event_id','desc');
        
        return $this->db->get();
    }

    public function get_event_group($limit = false, $offset = false, $group = false)
    {
        $this->db->select('events.*, g.name as group_name, g.slug as group_slug, g.term_id as groupid, c.name as cert_name ');
        $this->db->from('events');
        $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
        $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
        $this->db->where('event_status', 'publish');
        if($group){
            $this->db->where('g.term_id', $group);
        }

        if($limit && $offset){
            $this->db->limit($limit, $offset);
        } elseif ($limit && $offset == false){
            $this->db->limit($limit);
        }
        $this->db->group_by('event_id');
        $this->db->order_by('events.event_id','desc');
        return $this->db->get();
    }

    public function get_event_type($limit = false, $offset = false, $type = false)
    {
        $this->db->select('events.*, g.name as group_name, g.slug as group_slug, g.term_id as groupid, c.name as cert_name ');
        $this->db->from('events');
        $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
        $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
        $this->db->join('terms t', 't.term_id = events.type_id', 'left');
        $this->db->where('event_status', 'publish');
        if($type){
            $this->db->where('t.term_id', $type);
        }

        if($limit && $offset){
            $this->db->limit($limit, $offset);
        } elseif ($limit && $offset == false){
            $this->db->limit($limit);
        }
        $this->db->group_by('event_id');
        $this->db->order_by('events.event_id','desc');
        return $this->db->get();
    }

    public function get_event_search_count($search = false)
    {
        $this->db->select('events.*, g.name as group_name, c.name as cert_name ');
        $this->db->from('events');
        $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
        $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
        $this->db->where('event_status', 'publish');
        $this->db->like('event_name', $search);
        $this->db->order_by('events.event_id','desc');
        return $this->db->get();
    }

    public function get_event_group_count($group = false)
    {
        $this->db->select('events.*, g.name as group_name, c.name as cert_name ');
        $this->db->from('events');
        $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
        $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
        $this->db->where('event_status', 'publish');
        $this->db->where('g.term_id', $group);
        $this->db->group_by('event_id');
        return $this->db->get();
    }

    public function get_event_type_count($type = false)
    {
        $this->db->select('events.*, g.name as group_name, c.name as cert_name ');
        $this->db->from('events');
        $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
        $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
        $this->db->join('terms t', 't.term_id = events.type_id', 'left');
        $this->db->where('event_status', 'publish');
        $this->db->where('t.term_id', $type);
        $this->db->group_by('event_id');
        return $this->db->get();
    }


    public function get_articles_all($limit = false, $offset = false)
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->join('term_relationships', 'term_relationships.object_id = posts.id_post', 'left');
        $this->db->join('terms', 'terms.term_id = term_relationships.term_taxonomy_id', 'left');
        $this->db->where('post_status', 'publish');
        $this->db->where('post_type', 'articles');

        if($limit && $offset){
            $this->db->limit($limit, $offset);
        } elseif ($limit && $offset == false){
            $this->db->limit($limit);
<<<<<<< Updated upstream
        }
        $this->db->order_by('posts.id_post','desc');
=======
        } 

>>>>>>> Stashed changes
        return $this->db->get();
    }
    

    public function get_articles_popular()
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->join('term_relationships', 'term_relationships.object_id = posts.id_post', 'left');
        $this->db->join('terms', 'terms.term_id = term_relationships.term_taxonomy_id', 'left');
        $this->db->where('post_status', 'publish');
        $this->db->where('post_type', 'articles');
        $this->db->order_by('post_view', 'desc');
        $this->db->limit(5);

        return $this->db->get()->result();
    }

    public function view_event($slug)
    {
        $this->db->select('events.*,posts.*, g.name as group_name, g.slug as group_slug, g.term_id as group_id_type, c.name as cert_name, r.name as reg_name, t.name as type_name ');
        $this->db->from('events');
        $this->db->join('posts', 'posts.id_post = events.post_id', 'left');
        $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
        $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
        $this->db->join('terms r', 'r.term_id = events.regional_id', 'left');
        $this->db->join('terms t', 't.term_id = events.type_id', 'left');
        $this->db->where('event_slug', $slug);
        return $this->db->get();
    }

    public function view_articles($slug)
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->join('term_relationships', 'term_relationships.object_id = posts.id_post', 'left');
        $this->db->join('terms', 'terms.term_id = term_relationships.term_taxonomy_id', 'left');
        $this->db->join('users', 'users.id = posts.post_author', 'left');
        $this->db->where('post_slug', $slug);
        return $this->db->get();
    }

    public function update_viewers($slug)
    {   
        $ip = $this->input->ip_address();
        
        if($ip !=  $this->session->userdata('unique_ip') || $slug != $this->session->userdata('slug')){
            $this->db->set('post_view', 'post_view+1', FALSE);
            $this->db->where('post_slug', $slug);
            $update = $this->db->update('posts');

            if($update){

                $newdata = array(
                    'unique_ip'  =>  $ip,
                    'slug'     => $slug,
                );

                $this->session->set_userdata($newdata);
            }
        }
        
        return false;
    }

    public function get_promotions_all($limit = false, $offset = false)
    {
        $this->db->select('*');
        $this->db->from('promotions');
        $this->db->where('status', 'On Progress');
        $this->db->where('status_delete', '0');
        $this->db->where('type', 'campaign');
        $this->db->order_by('promotions_id','desc');

        if($limit && $offset){
            $this->db->limit($limit, $offset);
        } elseif ($limit && $offset == false){
            $this->db->limit($limit);
        }
        
        return $this->db->get();
    }

    public function get_data_promotions($slug)
    {
        $this->db->select('*');
        $this->db->from('promotions');
        $this->db->where('slug', $slug);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_detail_promotions_all($promotions_id, $limit = false, $offset = false)
    {
        $this->db->select('events.*, g.name as group_name, c.name as cert_name');
        $this->db->from('promotions_detail');
        $this->db->join('events', 'events.event_id = promotions_detail.event_id', 'left');
        $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
        $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
        $this->db->where('promotions_id', $promotions_id);
        $this->db->where('event_status', 'publish');

        if($limit && $offset){
            $this->db->limit($limit, $offset);
        } elseif ($limit && $offset == false){
            $this->db->limit($limit);
        }

        return $this->db->get();
    }

}
