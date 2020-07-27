<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Post_m extends CI_Model
{
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

    public function get_event_all($limit = false, $offset = false, $viewby = false, $sortby = false)
    {
        $this->db->select('events.*, g.name as group_name, c.name as cert_name ');
        $this->db->from('events');
        $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
        $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
        $this->db->where('event_status', 'publish');

        if($limit && $offset){
            $this->db->limit($limit, $offset);
        } elseif ($limit && $offset == false){
            $this->db->limit($limit);
        }

        if($viewby == 'popular'){
            $this->db->order_by('event_id','desc');
        } else {
            $this->db->order_by('event_id','desc');
        }
       
        return $this->db->get()->result();
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
        }

        return $this->db->get()->result();
    }

    public function view_event($slug)
    {
        $this->db->select('events.*,posts.*, g.name as group_name, c.name as cert_name ');
        $this->db->from('events');
        $this->db->join('posts', 'posts.id_post = events.post_id', 'left');
        $this->db->join('terms g', 'g.term_id = events.group_id', 'left');
        $this->db->join('terms c', 'c.term_id = events.certificate_id', 'left');
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

}
