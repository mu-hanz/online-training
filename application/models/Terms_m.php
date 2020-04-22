<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Terms_m extends CI_Model
{

    public function insert_term($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update_term($id, $data, $table)
    {
        $this->db->where('term_id', $id);
        return $this->db->update($table, $data);
    }

    public function update_count_term($id)
    {

        $this->db->select('*');
        $this->db->from('term_relationships');
        $this->db->where('term_taxonomy_id', $id);
        $check = $this->db->get()->num_rows();

        $this->db->set('count', $check);
        $this->db->where('term_id', $id);
        return $this->db->update('term_taxonomy');
    }

    public function update_parent($id, $data)
    {
        $this->db->where('parent', $id);
        return $this->db->update('term_taxonomy', $data);
    }

    public function search_term($query)
    {

        $this->db->select('*');
        $this->db->from('terms');
        $this->db->join('term_taxonomy', 'term_taxonomy.term_id = terms.term_id', 'left');
        $this->db->where('taxonomy', 'tags');
        $this->db->like('name', $query);
        return $this->db->get()->result();
    }

    public function delete_term_post($id)
    {
        // $this->db->where_in('object_id', $id);
        // $this->db->delete('term_relationships');

        $this->db->select('*');
        $this->db->from('term_relationships');
        $this->db->where_in('object_id', $id);
        $check = $this->db->get()->result();

        foreach ($check as $row) {
            $this->db->where_in('object_id', $row->object_id);
            $this->db->delete('term_relationships');

            $this->db->select('*');
            $this->db->from('term_relationships');
            $this->db->where('term_taxonomy_id', $row->term_taxonomy_id);
            $check = $this->db->get()->num_rows();

            $this->db->set('count', $check);
            $this->db->where('term_id', $row->term_taxonomy_id);
            $this->db->update('term_taxonomy');
        }
    }

    public function delete_term($id)
    {
        $this->db->where_in('term_id', $id);
        return $this->db->delete('terms');
    }

    public function get_terms($term, $parent = false)
    {
		$this->db->cache_off();

        $this->db->select('*');
        $this->db->from('terms');
        $this->db->join('term_taxonomy', 'term_taxonomy.term_id = terms.term_id', 'left');
        $this->db->where('term_taxonomy.taxonomy', $term);

        if ($parent != '') {
            $this->db->where('term_taxonomy.parent', $parent);
        }



        $this->db->order_by('terms.term_id', 'desc');
        $this->db->group_by('terms.term_id');
        return $this->db->get();
    }

    public function get_terms_json($select, $term, $object_id = false)
    {
        $this->db->select($select);
        $this->db->from('terms');
        $this->db->join('term_taxonomy', 'term_taxonomy.term_id = terms.term_id', 'left');
        $this->db->join('term_relationships', 'term_relationships.term_taxonomy_id = term_taxonomy.term_taxonomy_id', 'left');
        $this->db->where('term_taxonomy.taxonomy', $term);
        $this->db->where('term_relationships.object_id', $object_id);
        $this->db->order_by('terms.term_id', 'desc');
        return $this->db->get();
    }

    public function edit_term($id, $table)
    {
		$this->db->cache_off();
        $this->db->select('*');
        $this->db->from('terms');
        $this->db->join('term_taxonomy', 'term_taxonomy.term_id = terms.term_id', 'left');
        $this->db->where('term_taxonomy.taxonomy', $table);
        $this->db->where('terms.term_id', $id);
        return $this->db->get()->row();
    }

    public function check_parent($id)
    {
		$this->db->cache_off();
        $this->db->select('*');
        $this->db->from('term_taxonomy');
        $this->db->where('parent', $id);
        return $this->db->get()->num_rows();
    }

    public function id_max_term($table)
    {
        if ($table == 'terms') {
            $result = $this->db->query('SELECT MAX(term_id) as max_term FROM terms')->row()->max_term + 1;
            return $result;
        } else if ($table == 'taxonomy') {
            $result = $this->db->query('SELECT MAX(term_taxonomy_id) as max_tax FROM term_taxonomy')->row()->max_tax + 1;
            return $result;
        } else {
            $result = $this->db->query('SELECT MAX(object_id) as max_rel FROM term_relationships')->row()->max_rel + 1;
            return $result;
        }
    }

    public function update_to_uncategorized($type)
    {
        if ($type == 'product') {
            $terms_id = '1';
        } else {
            $terms_id = '0';
        }

        $this->db->select('*');
        $this->db->from('products');
        $data_post = $this->db->get()->result();

        foreach ($data_post as $data) {
            $this->db->select('*');
            $this->db->from('term_relationships');
            $this->db->where('object_id', $data->product_id);
            $check = $this->db->get()->num_rows();

            if ($check <= 0) {
                $data_rel = array(
                    'object_id'        => $data->id_post,
                    'term_taxonomy_id' => $terms_id,
                );
                $this->db->insert('term_relationships', $data_rel);
            }
        }

        $this->db->select('*');
        $this->db->from('term_relationships');
        $this->db->where('term_taxonomy_id', $terms_id);
        $check = $this->db->get()->num_rows();

        $this->db->set('count', $check);
        $this->db->where('term_id', $terms_id);
        return $this->db->update('term_taxonomy');

    }

}
