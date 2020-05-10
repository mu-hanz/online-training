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

    public function count_post($type, $filter)
    {

        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('post_type', $type);
        if ($filter == 'all') {
            $this->db->where('post_trash !=', '1');
        } elseif ($filter == 'trash') {
            $this->db->where('post_trash', '1');
        } else {
            $this->db->where('post_trash', '0');
            $this->db->where('post_status', $filter);
        }

        return $this->db->get()->num_rows();
    }


    //events
  

    public function update_events($id, $data)
    {
        $this->db->where('id_post', $id);
        return $this->db->update('events', $data);
    }

    public function edit_post($id)
    {
        $this->db->select('posts.*, users.first_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.post_author', 'left');
        $this->db->where('id_post', $id);
        return $this->db->get()->row();
    }

    public function edit_event($id)
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where('id_post', $id);
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
    

}
