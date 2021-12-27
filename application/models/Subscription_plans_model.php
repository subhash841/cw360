<?php

class Subscription_plans_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table_name="subscription_plans";
    }

    public function get_subscription_list(){
        $this->db->select('id, game_id, package_name, coins, price, description');
        $this->db->from($this->table_name);
        $this->db->where('is_active','1');
        // $this->db->limit(1);
        $result = $this->db->get()->result_array();
        return $result;

    }
    public function get_game_points_data($id){
      $this->db->select('coins, price');
      $this->db->from($this->table_name);
      $this->db->where(array('id' => $id, 'is_active' => '1'));
      // $this->db->where(array('id' => $id));
      $result = $this->db->get()->result_array();
      return reset($result);
    }
    
    public function get_coins_data($price){
      $price = floor($price);
      $this->db->select('id,coins');
      $this->db->from($this->table_name);
      $this->db->where(array('price' => $price, 'is_active' => '1'));
      $result = $this->db->get()->row_array();
      return $result;
    }

    public function insert_transaction_data($data){
        $this->db->insert('subscription_transactions',$data);
    }

    public function get_subscription_plans($game_id=0){
      // $game_id = 3; //dynamic game id to be added.
      $this->db->select('*');
      $this->db->from($this->table_name);
      $this->db->where('game_id', $game_id);
      $this->db->where('is_active', '1');
      $result = $this->db->get()->result_array();
      // print_r($result);die;
      return $result;
    }
    public function transaction_status($user_id,$transaction_id){
      // $game_id = 3; //dynamic game id to be added.
      $this->db->select('coins,response_code,trans_response,unique_ref_number,transaction_amount,created_date');
      $this->db->from('subscription_transactions');
      $this->db->where(array('user_id'=>$user_id, 'unique_ref_number'=>$transaction_id));
      $result = $this->db->get()->row_array();
      return $result;
    }

    public function add_coins($coins,$user_id,$subscription_id){
        $this->db->where('user_id', $user_id);
        $this->db->set("coins", "coins + $coins", FALSE);
        $this->db->set("modified_date", date('Y-m-d H:i:s'));
        $this->db->update('coins');       //update coins

        $insert_array = array(  'user_id' => $user_id,
                                'subscription_id' => $subscription_id,
                                'coins' => $coins,
                                'type' => '1',
                                'created_date' => date('Y-m-d H:i:s')
        );

        $this->db->insert('wallet_history',$insert_array);   //insert wallet history
    }

    public function get_user_details($user_id){
      $this->db->select('email,phone');
      $this->db->from('users');
      $this->db->where('id',$user_id);
      return $this->db->get()->row_array();
    }
  
  }  
?>