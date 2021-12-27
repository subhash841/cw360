<?php
class Subscriptions_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table_name="subscription_plans";
    }


    public function get_subscription_list(){
        $this->db->select('id, game_id, package_name, points, price, description');
        $this->db->from($this->table_name);
        $this->db->where('is_active','1');
        $result = $this->db->get()->result_array();
        return $result;

    }

}
