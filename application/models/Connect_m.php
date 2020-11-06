<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Connect_m extends CI_Model { 
     
    function __construct() { 
        $this->tableName = 'users'; 
    } 

    public function cek_user($email){ 
        $this->db->select('email, id, oauth_uid'); 
        $this->db->from($this->tableName);
        $this->db->where('email', $email);
        return $this->db->get(); 
    }

     
    public function checkUser($data){ 

        $cekUser = $this->cek_user($data->email);


        if($cekUser->num_rows() > 0){ 
            // Get prev user data 
            $result = $cekUser->row(); 
             
            if($result->oauth_uid == null){
                $dataUpdateUser  = [
                    'ip_address'        => $this->input->ip_address(),
                    'oauth_modified'    => date("Y-m-d H:i:s"),
                    'oauth_uid'         => $data->identifier,
                    'password_connect'  => password_hash($data->identifier, PASSWORD_BCRYPT),
                    'last_login'        => time(),
                    'oauth_photoURL'    => str_replace("=s96-c","=s400-c",$data->photoURL),
                    'oauth_provider'    => 'google', 
                ];

                $update = $this->db->update($this->tableName, $dataUpdateUser, array('id' => $result->id));
            } else {
                // Update user data 
                $dataUpdateUser  = [
                    'ip_address'        => $this->input->ip_address(),
                    'oauth_modified'    => date("Y-m-d H:i:s"),
                    'last_login'        => time(),
                    'oauth_photoURL'    => str_replace("=s96-c","=s400-c",$data->photoURL),
                ];

                $update = $this->db->update($this->tableName, $dataUpdateUser, array('id' => $result->id)); 
            }
            
             
            // Get user ID 
            $userID = $result->id; 

        }else{ 
            // Insert user data 
            $dataInsertUser  = [
                'ip_address'        => $this->input->ip_address(),
                'username'          => $data->email,
                'email'             => $data->email,
                'password_connect'  => password_hash($data->identifier, PASSWORD_BCRYPT),
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

            $dataGroups  = [
                'user_id' => $userID,
                'group_id' => 2,
            ];

            $this->db->insert('users_groups', $dataGroups); 
        } 
         
        // Return user ID 
        return $userID?$userID:false; 
    } 
 
}