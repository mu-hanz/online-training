<?php
 
class Products_m extends CI_Model {
 
    var $table          = 'products';
    var $join_table     = 'products_media';
    var $join_table2    = 'terms';
    var $join_table3    = 'users';
    var $column_order   = array(null, 'products.product_id', 'products.product_name', 'products.status', 'terms.name');
    var $column_search  = array('products.product_id', 'products.product_name', 'products.status', 'terms.name');
    var $order          = array('products.product_id' => 'asc');

    var $table2         = 'term_taxonomy';
    var $join_table2_1  = 'terms';  
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->select($this->column_order);
        $this->db->from($this->table);
        $this->db->join($this->join_table2, $this->join_table2.'.term_id = '.$this->table.'.category_id', 'left');
        $this->db->where($this->table.'.status_delete !=', '1');
 
        $i = 0;
     
        foreach ($this->column_search as $item)
        {
            if($_POST['search']['value'])
            {
                if($i===0)
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->join($this->join_table2, $this->join_table2.'.term_id = '.$this->table.'.category_id', 'left');
        $this->db->where($this->table.'.status_delete !=', '1');
        return $this->db->count_all_results();
    }

    public function get_products_images($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.product_id', $id);
        $this->db->where($this->join_table.'.type', 'Image');
        $this->db->order_by($this->join_table.".ordering", "asc");
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_data_category()
    {
        $this->db->select('*');
        $this->db->from($this->table2);
        $this->db->join($this->join_table2_1, $this->join_table2_1.'.term_id = '.$this->table2.'.term_id', 'left');
        $this->db->where($this->table2.'.taxonomy', 'category-products');
        $this->db->order_by($this->table2.".term_id", "desc");
        return $this->db->get()->result();
    }

    function save_products($data){
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    function save_products_media($data){
        $this->db->insert($this->join_table, $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    function delete_products($id){
        $this->db->where($this->table.'.product_id', $id);
        $this->db->delete($this->table);

        $this->db->where($this->join_table.'.product_id', $id);
        $this->db->delete($this->table);
    }
    

    public function get_data($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join($this->join_table3, $this->join_table3.'.id = '.$this->table.'.edited_by', 'left');
        $this->db->where($this->table.'.product_id', $id);
        // $this->db->where('contract_hub.programscategories !=', 'Bali Horse Riding');
        // $this->db->group_by('contract_hub.programscategories');
        // $this->db->order_by('contract_hub.id', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_data_product_media_images($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.product_id', $id);
        $this->db->where($this->join_table.'.type', 'Image');
        $this->db->where($this->join_table.'.status_delete !=', '1');
        $this->db->order_by($this->join_table.".ordering", "asc");
        return $this->db->get()->result();
    }

    public function count_data_product_media_images($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.product_id', $id);
        $this->db->where($this->join_table.'.type', 'Image');
        $this->db->where($this->join_table.'.status_delete !=', '1');
        return $this->db->get()->num_rows();
    }

    public function get_data_product_media_files($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.product_id', $id);
        $this->db->where($this->join_table.'.type', 'File');
        $this->db->where($this->join_table.'.status_delete !=', '1');
        $this->db->order_by($this->join_table.".ordering", "asc");
        return $this->db->get()->result();
    }

    public function count_data_product_media_files($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.product_id', $id);
        $this->db->where($this->join_table.'.type', 'File');
        $this->db->where($this->join_table.'.status_delete !=', '1');
        return $this->db->get()->num_rows();
    }

    function update_products($id, $data){
        $this->db->where($this->table.'.product_id', $id);
        return $this->db->update($this->table, $data); 
    }

    function update_products_media($image_remove, $data){
        $this->db->where($this->join_table.'.product_media_id', $image_remove);
        return $this->db->update($this->join_table, $data); 
    }

    function update_products_media2($id, $data){
        $this->db->where($this->join_table.'.product_id', $id);
        return $this->db->update($this->join_table, $data); 
    }
 
}