<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Connect_m extends CI_Model { 
     
    function __construct() { 
        $this->tableName = 'users'; 
    } 
     
    public function checkUser($data){ 

        $this->db->select('id'); 
        $this->db->from($this->tableName); 
         
        $con = array( 
            'oauth_uid' => $data->identifier 
        ); 

        $this->db->where($con); 
        $query = $this->db->get(); 
         
        $check = $query->num_rows(); 

        if($check > 0){ 
            // Get prev user data 
            $result = $query->row_array(); 
             
            // Update user data 
            $dataUpdateUser  = [
                'ip_address'        => $this->input->ip_address(),
                'oauth_modified'    => date("Y-m-d H:i:s"),
                'last_login'        => time(),
                'oauth_photoURL'    => str_replace("=s96-c","=s400-c",$data->photoURL),
            ];

            $update = $this->db->update($this->tableName, $dataUpdateUser, array('id' => $result['id'])); 
             
            // Get user ID 
            $userID = $result['id']; 

        }else{ 
            // Insert user data 
            $dataInsertUser  = [
                'ip_address'        => $this->input->ip_address(),
                'username'          => $data->email,
                'email'             => $data->email,
                'password'          => password_hash($data->identifier, PASSWORD_BCRYPT),
                'first_name'        => $data->firstName,
                'last_name'         => $data->lastName,
                'active'            => 1,
                'created_on'        => time(),
                'oauth_modified'    => date("Y-m-d H:i:s"),
                'last_login'        => time(),
                'oauth_photoURL'    => str_replace("=s96-c","=s400-c",$data->photoURL),
                'oauth_uid'         => $data->identifier,
                'oauth_provider'    => 'google', 
            ];


            $insert = $this->db->insert($this->tableName, $dataInsertUser); 
             
            // Get user ID 
            $userID = $this->db->insert_id(); 
        } 
         
        // Return user ID 
        return $userID?$userID:false; 
    } 
 
}