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
        $this->db->select('DATE_FORMAT(tanggal, "%m/%Y") as month_date, IFNULL(SUM(hits),0) AS count');
        $this->db->from('viewers');
        $this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 7 DAY AND NOW()');
        $this->db->group_by('DATE(tanggal)');
        $this->db->order_by('DATE(tanggal)','asc');
        return $this->db->get()->result();
    }

    public function get_visitor_chart_last() {
        $this->db->select('IFNULL(SUM(hits),0) AS total');
        $this->db->from('viewers');
        $this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 7 DAY AND NOW()');
        return $this->db->get()->row();
    }

    public function get_visitor_chart_last_seven() {
        $this->db->select('IFNULL(SUM(hits),0) AS total');
        $this->db->from('viewers');
        $this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 14 DAY AND NOW() - INTERVAL 7 DAY');
        return $this->db->get()->row();
    }

    public function get_visitor_chart_month() {
        $this->db->select('DATE_FORMAT(tanggal, "%m/%Y") as month_date, COUNT(ip) AS count');
        $this->db->from('viewers');
        $this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 5 MONTH AND NOW()');
        $this->db->group_by('MONTH(tanggal)');
        $this->db->order_by('DATE(tanggal)','asc');
        return $this->db->get()->result();
    }

    public function get_visitor_chart_month_unique() {
        $this->db->distinct();
        $this->db->select('DATE_FORMAT(tanggal, "%m/%Y") as month_date, COUNT(DISTINCT ip) AS count');
        $this->db->from('viewers');
    	$this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 5 MONTH AND NOW()');
        $this->db->group_by('MONTH(tanggal)');
        $this->db->order_by('DATE(tanggal)','desc');
        return $this->db->get()->result();
        
    }

    public function get_visitor_chart_month_page_view() {
        $this->db->select('DATE_FORMAT(tanggal, "%m/%Y") as month_date, IFNULL(SUM(hits),0) AS count');
        $this->db->from('viewers');
        $this->db->where('DATE(tanggal) BETWEEN NOW() - INTERVAL 5 MONTH AND NOW()');
        $this->db->group_by('MONTH(tanggal)');
        $this->db->order_by('DATE(tanggal)','asc');
        return $this->db->get()->result();
    }
}