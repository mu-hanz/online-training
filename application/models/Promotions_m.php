<?php
 
class Promotions_m extends CI_Model {
 
    var $table          = 'promotions';
    var $join_table     = 'promotions_tier';
    var $join_table2    = 'promotions_detail';
    var $join_table3    = 'promotions_type';
    var $column_order   = array(null, 'promotions.promotions_id', 'promotions.promotions_name', 'promotions.start_date', 'promotions.end_date', 'promotions.status');
    var $column_search  = array('promotions.promotions_name', 'promotions.start_date', 'promotions.end_date', 'promotions.status');
    var $order          = array('promotions.promotions_id' => 'asc');

    var $table2         = 'events';
    // var $join_table2_1  = 'events_contents';
    var $join_table2_2  = 'posts';
    var $join_table2_3  = 'terms';
    var $column_order2  = array(null, 'events.event_id', 'posts.post_title', 'events.event_cost', 'events.event_cost_promo', 'events.event_on_sale', 'terms.name');
    var $column_search2 = array('posts.post_title', 'events.event_cost', 'terms.name'); 
    var $order2         = array('events.event_id' => 'desc'); 

    var $table3         = 'banners';
    var $column_order3  = array(null, 'banners.banners_id', 'banners.title', 'banners.image', 'banners.start_date', 'banners.end_date', 'banners.status', 'banners.sorting');
    var $column_search3 = array('banners.title', 'banners.start_date', 'banners.end_date', 'banners.status'); 
    var $order3         = array('banners.banners_id' => 'desc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function count_check_active_flexi_combo($id)
    {
        $this->db->from($this->join_table2);
        $this->db->join($this->table, $this->join_table2.'.promotions_id = '.$this->table.'.promotions_id', 'left');
        $this->db->where($this->table.'.type', 'flexi_combo');
        $this->db->where($this->table.'.status', 'On Progress');
        $this->db->where($this->table.'.status_delete', '0');
        $this->db->where($this->join_table2.'.event_id', $id);
        return $this->db->count_all_results();
    }

    public function count_check_active_flexi_combo_update($id, $id_data)
    {
        $this->db->from($this->join_table2);
        $this->db->join($this->table, $this->join_table2.'.promotions_id = '.$this->table.'.promotions_id', 'left');
        $this->db->where($this->table.'.type', 'flexi_combo');
        $this->db->where($this->table.'.status', 'On Progress');
        $this->db->where($this->table.'.status_delete', '0');
        $this->db->where($this->join_table2.'.event_id', $id);
        $this->db->where($this->join_table2.'.promotions_id !=', $id_data);
        return $this->db->count_all_results();
    }






    public function get_data_promotions_campaign($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table2);
        $this->db->join($this->table, $this->join_table2.'.promotions_id = '.$this->table.'.promotions_id', 'left');
        $this->db->join($this->join_table, $this->table.'.promotions_id = '.$this->join_table.'.promotions_id', 'left');
        $this->db->where($this->join_table2.'.event_id', $id);
        $this->db->where($this->table.'.status', 'On Progress');
        $this->db->where($this->table.'.type', 'campaign');
        $this->db->where($this->join_table2.'.status_delete', '0');
        return $this->db->get()->num_rows();
    }

    public function get_data_promotions_campaign_update($id, $id_data)
    {
        $this->db->select('*');
        $this->db->from($this->join_table2);
        $this->db->join($this->table, $this->join_table2.'.promotions_id = '.$this->table.'.promotions_id', 'left');
        $this->db->join($this->join_table, $this->table.'.promotions_id = '.$this->join_table.'.promotions_id', 'left');
        $this->db->where($this->join_table2.'.event_id', $id);
        $this->db->where($this->join_table2.'.promotions_id !=', $id_data);
        $this->db->where($this->table.'.status', 'On Progress');
        $this->db->where($this->table.'.type', 'campaign');
        $this->db->where($this->join_table2.'.status_delete', '0');
        return $this->db->get()->num_rows();
    }

    public function get_data_promotions_flexi_combo($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table2);
        $this->db->join($this->table, $this->join_table2.'.promotions_id = '.$this->table.'.promotions_id', 'left');
        $this->db->join($this->join_table, $this->table.'.promotions_id = '.$this->join_table.'.promotions_id', 'left');
        $this->db->where($this->join_table2.'.event_id', $id);
        $this->db->where($this->table.'.status', 'On Progress');
        $this->db->where($this->table.'.type', 'flexi_combo');
        $this->db->where($this->join_table2.'.status_delete', '0');
        return $this->db->get()->num_rows();
    }

    public function get_data_promotions_flexi_combo_update($id, $id_data)
    {
        $this->db->select('*');
        $this->db->from($this->join_table2);
        $this->db->join($this->table, $this->join_table2.'.promotions_id = '.$this->table.'.promotions_id', 'left');
        $this->db->join($this->join_table, $this->table.'.promotions_id = '.$this->join_table.'.promotions_id', 'left');
        $this->db->where($this->join_table2.'.event_id', $id);
        $this->db->where($this->join_table2.'.promotions_id !=', $id_data);
        $this->db->where($this->table.'.status', 'On Progress');
        $this->db->where($this->table.'.type', 'flexi_combo');
        $this->db->where($this->join_table2.'.status_delete', '0');
        return $this->db->get()->num_rows();
    }

    private function _get_datatables_query()
    {
        $this->db->select($this->column_order);
        $this->db->from($this->table);
        // $this->db->join($this->join_table, $this->join_table.'.id = '.$this->table.'.edited_by', 'left');
        $this->db->where($this->table.'.status_delete !=', '1');
        $this->db->where($this->table.'.type', 'flexi_combo');
 
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
        // $this->db->join($this->join_table, $this->table.'.edited_by = '.$this->join_table.'.id', 'left');
        $this->db->where($this->table.'.status_delete !=', '1');
        $this->db->where($this->table.'.type', 'flexi_combo');
        return $this->db->count_all_results();
    }

    private function _get_datatables_query2()
    {
        $this->db->select($this->column_order2);
        $this->db->from($this->table2);
        // $this->db->join($this->join_table2_1, $this->join_table2_1.'.event_id = '.$this->table2.'.event_id', 'left');
        $this->db->join($this->join_table2_2, $this->join_table2_2.'.id_post = '.$this->table2.'.post_id', 'left');
        $this->db->join($this->join_table2_3, $this->join_table2_3.'.term_id = '.$this->table2.'.location_id', 'left');
        // $this->db->where('contract.status_delete !=', '9');
        $i = 0;
        foreach ($this->column_search2 as $item) 
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
 
                if(count($this->column_search2) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables2()
    {
        $this->_get_datatables_query2();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered2()
    {
        $this->_get_datatables_query2();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all2()
    {
        $this->db->from($this->table2);
        // $this->db->join($this->join_table2_1, $this->join_table2_1.'.event_id = '.$this->table2.'.event_id', 'left');
        $this->db->join($this->join_table2_2, $this->join_table2_2.'.id_post = '.$this->table2.'.post_id', 'left');
        $this->db->join($this->join_table2_3, $this->join_table2_3.'.term_id = '.$this->table2.'.location_id', 'left');
        // $this->db->where('contract.status_delete !=', '9');
        return $this->db->count_all_results();
    }

    function get_data_events(){
        return $this->db->get($this->table2)->result();
    }

    function save_promotions($data){
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    function save_promotions_tier($data){
        return $this->db->insert($this->join_table, $data);
    }

    function save_promotions_detail($data){
        return $this->db->insert($this->join_table2, $data);
    }

    public function get_data($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        // $this->db->join('contract', 'contract.id = contract_hub.id_contract', 'left');
        $this->db->where('promotions.promotions_id', $id);
        // $this->db->where('contract_hub.programscategories !=', 'Bali Horse Riding');
        // $this->db->group_by('contract_hub.programscategories');
        // $this->db->order_by('contract_hub.id', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_data_promotions_tier($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.promotions_id', $id);
        return $this->db->get()->result();
    }

    public function count_data_promotions_tier($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table);
        $this->db->where($this->join_table.'.promotions_id', $id);
        return $this->db->get()->num_rows();
    }

    public function get_data_promotions_type_referral($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table3);
        $this->db->where($this->join_table3.'.promotions_id', $id);
        return $this->db->get()->result();
    }

    public function count_data_promotions_type_referral($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table3);
        $this->db->where($this->join_table3.'.promotions_id', $id);
        return $this->db->get()->num_rows();
    }

    function delete_promotions_type($id){
        $this->db->where('promotions_id', $id);
        $this->db->delete($this->join_table3);
    }

    public function get_data_promotions_detail($id)
    {
        $this->db->select('*');
        $this->db->from('promotions_detail');
        $this->db->where('promotions_detail.promotions_id', $id);
        return $this->db->get()->result();
    }

    function update_promotions($id, $data){
        $this->db->where('promotions_id', $id);
        return $this->db->update($this->table, $data); 
    }

    function delete_promotions_tier($id){
        $this->db->where('promotions_id', $id);
        $this->db->delete($this->join_table);
    }

    function delete_promotions_detail($id){
        $this->db->where('promotions_id', $id);
        $this->db->delete($this->join_table2);
    }

    function delete_promotions($id, $data){
        $this->db->where('promotions_id', $id);
        $this->db->update($this->table, $data);

        $this->db->where('promotions_id', $id);
        $this->db->update($this->join_table, $data);

        $this->db->where('promotions_id', $id);
        $this->db->update($this->join_table3, $data);

        $this->db->where('promotions_id', $id);
        return $this->db->update($this->join_table2, $data);
    }






    private function _get_datatables_query_voucher()
    {
        $this->db->select($this->column_order);
        $this->db->from($this->table);
        // $this->db->join($this->join_table, $this->join_table.'.id = '.$this->table.'.edited_by', 'left');
        $this->db->where($this->table.'.status_delete !=', '1');
        $this->db->where($this->table.'.type', 'voucher');
 
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
 
    function get_datatables_voucher()
    {
        $this->_get_datatables_query_voucher();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_voucher()
    {
        $this->_get_datatables_query_voucher();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_voucher()
    {
        $this->db->from($this->table);
        // $this->db->join($this->join_table, $this->table.'.edited_by = '.$this->join_table.'.id', 'left');
        $this->db->where($this->table.'.status_delete !=', '1');
        $this->db->where($this->table.'.type', 'voucher');
        return $this->db->count_all_results();
    }

    function save_promotions_type($data){
        return $this->db->insert($this->join_table3, $data);
    }

    public function get_data_promotions_type($id)
    {
        $this->db->select('*');
        $this->db->from($this->join_table3);
        $this->db->where('promotions_type.promotions_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function update_promotions_type($id, $data){
        $this->db->where('promotions_id', $id);
        return $this->db->update($this->join_table3, $data); 
    }






    private function _get_datatables_query_campaign()
    {
        $this->db->select($this->column_order);
        $this->db->from($this->table);
        // $this->db->join($this->join_table, $this->join_table.'.id = '.$this->table.'.edited_by', 'left');
        $this->db->where($this->table.'.status_delete !=', '1');
        $this->db->where($this->table.'.type', 'campaign');
 
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
 
    function get_datatables_campaign()
    {
        $this->_get_datatables_query_campaign();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_campaign()
    {
        $this->_get_datatables_query_campaign();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_campaign()
    {
        $this->db->from($this->table);
        // $this->db->join($this->join_table, $this->table.'.edited_by = '.$this->join_table.'.id', 'left');
        $this->db->where($this->table.'.status_delete !=', '1');
        $this->db->where($this->table.'.type', 'campaign');
        return $this->db->count_all_results();
    }

    function get_data_training($edit = false){
        $this->db->select($this->column_order2);
        $this->db->from($this->table2);
        // $this->db->join($this->join_table2_1, $this->join_table2_1.'.event_id = '.$this->table2.'.event_id', 'left');
        $this->db->join($this->join_table2_2, $this->join_table2_2.'.id_post = '.$this->table2.'.post_id', 'left');
        $this->db->join($this->join_table2_3, $this->join_table2_3.'.term_id = '.$this->table2.'.location_id', 'left');
        if($edit){
            $this->db->where($this->table2.'.event_on_sale !=', '1');
        }
        return $this->db->get()->result();
    }

    public function count_data_training($edit = false)
    {
        $this->db->from($this->table2);
        // $this->db->join($this->join_table2_1, $this->join_table2_1.'.event_id = '.$this->table2.'.event_id', 'left');
        $this->db->join($this->join_table2_2, $this->join_table2_2.'.id_post = '.$this->table2.'.post_id', 'left');
        $this->db->join($this->join_table2_3, $this->join_table2_3.'.term_id = '.$this->table2.'.location_id', 'left');
        if($edit){
            $this->db->where($this->table2.'.event_on_sale !=', '1');
        }
        return $this->db->count_all_results();
    }

    function get_data_training_detail($id){
        $this->db->select('*');
        $this->db->from($this->join_table2);
        $this->db->where($this->join_table2.'.promotions_id', $id);
        return $this->db->get()->result();
    }

    function update_event_on_sale($id, $status){
        $this->db->set('event_on_sale', $status, FALSE);
        $this->db->where('event_id', $id);
        return $this->db->update($this->table2);
    }







    private function _get_datatables_query_slider()
    {
        $this->db->select($this->column_order3);
        $this->db->from($this->table3);
        // $this->db->join($this->join_table, $this->join_table.'.id = '.$this->table.'.edited_by', 'left');
        $this->db->where($this->table3.'.status_delete !=', '1');
        $this->db->where($this->table3.'.type', 'slider');
 
        $i = 0;
     
        foreach ($this->column_search3 as $item)
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
 
                if(count($this->column_search3) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order3[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order3))
        {
            $order = $this->order3;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_slider()
    {
        $this->_get_datatables_query_slider();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_slider()
    {
        $this->_get_datatables_query_slider();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_slider()
    {
        $this->db->from($this->table3);
        // $this->db->join($this->join_table, $this->table.'.edited_by = '.$this->join_table.'.id', 'left');
        $this->db->where($this->table3.'.status_delete !=', '1');
        $this->db->where($this->table3.'.type', 'slider');
        return $this->db->count_all_results();
    }

    function save_slider($data){
        $this->db->insert($this->table3, $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function get_data_slider($id)
    {
        $this->db->select('*');
        $this->db->from($this->table3);
        $this->db->where($this->table3.'.banners_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function update_slider($id, $data){
        $this->db->where('banners_id', $id);
        return $this->db->update($this->table3, $data); 
    }

    function delete_slider($id, $data){
        $this->db->where('banners_id', $id);
        return $this->db->update($this->table3, $data); 
    }







    private function _get_datatables_query_banner()
    {
        $this->db->select($this->column_order3);
        $this->db->from($this->table3);
        // $this->db->join($this->join_table, $this->join_table.'.id = '.$this->table.'.edited_by', 'left');
        $this->db->where($this->table3.'.status_delete !=', '1');
        $this->db->where($this->table3.'.type', 'banner');
 
        $i = 0;
     
        foreach ($this->column_search3 as $item)
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
 
                if(count($this->column_search3) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order3[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order3))
        {
            $order = $this->order3;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_banner()
    {
        $this->_get_datatables_query_banner();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_banner()
    {
        $this->_get_datatables_query_banner();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_banner()
    {
        $this->db->from($this->table3);
        // $this->db->join($this->join_table, $this->table.'.edited_by = '.$this->join_table.'.id', 'left');
        $this->db->where($this->table3.'.status_delete !=', '1');
        $this->db->where($this->table3.'.type', 'banner');
        return $this->db->count_all_results();
    }

    function save_banner($data){
        $this->db->insert($this->table3, $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function get_data_banner($id)
    {
        $this->db->select('*');
        $this->db->from($this->table3);
        $this->db->where($this->table3.'.banners_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function update_banner($id, $data){
        $this->db->where('banners_id', $id);
        return $this->db->update($this->table3, $data); 
    }

    function delete_banner($id, $data){
        $this->db->where('banners_id', $id);
        return $this->db->update($this->table3, $data); 
    }
 
}