<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
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
        $date = date('Y-m-d');
    	$thn = date('Y');
        $this->db->select('IFNULL(SUM(hits),0) AS count');
        $this->db->from('viewers');
        $this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 7 DAY AND NOW()');
        $this->db->group_by('DATE(tanggal)');
        return $this->db->get()->result();
    }

    // public function get_visitor_chart($bln) {
    // 	$thn = date('Y');
    //     $this->db->select('IFNULL(SUM(hits),0) AS total_viewers');
    //     $this->db->from('viewers');
    //     $this->db->where('MONTH(tanggal)', $bln);
    //     $this->db->where('YEAR(tanggal)', $thn);
    //     return $this->db->get()->result();
    // }
    
    public function get_visitor_chart_u($bln) {
    	$thn = date('Y');
    	$this->db->distinct();
    	$this->db->select('ip');
    	$this->db->where('MONTH(tanggal)', $bln);
        $this->db->where('YEAR(tanggal)', $thn);
        $this->db->group_by('ip');
        $query = $this->db->get('viewers');
        return $query->num_rows();
        
    }

}