<?php

class Common_model extends CI_Model {

    public function get_meta_tags($id) {
        $this->db->select('meta_keywords , meta_description , image');
        $this->db->where('id', $id);
        $this->db->from('predictions');
        // return $this->db->get()->result_array();
        return $this->db->get()->row_array();
    }
    public function check_tnc_login($id) {
        $this->db->select('id,tnc_agree');
        $this->db->where('id', $id);
        $this->db->from('users');
        return $this->db->get()->row_array();
    } 
    public function authenicate_access_token($user_id,$auth_token,$device_type){
        $this->db->select('auth_token');
        $this->db->where(array('id' => $user_id, 'auth_token' => $auth_token,'device_type'=>$device_type));
        $this->db->from('users');
        $res=$this->db->get()->row_array();
        // echo $this->db->last_query();die;
        return $res['auth_token']; 
    }

    public function get_rewards() {
        $this->db->select('id, title, req_coins, image');
        $this->db->where(array('is_published' => '1', 'is_published' => '1'));
        $this->db->from('rewards');
        return $this->db->get()->result_array();
    }

}
