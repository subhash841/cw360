<?php
class Wallet_history_model extends CI_Model {

    public function get_history($user_id,$offset='0'){
        $this->db->select('wh.id,wh.coins, q.name as quiz_name,g.title as game_name,
        wh.type,DATE_FORMAT(wh.created_date,"%e %b %Y") as date,s.package_name');
        $this->db->from('wallet_history wh');
        $this->db->join('quiz q','wh.quiz_id = q.quiz_id','left');
        $this->db->join('games g','wh.game_id = g.id','left');
        // $this->db->join('predictions p','wh.prediction_id = p.id','left');
        $this->db->join('subscription_plans s','wh.subscription_id = s.id','left');
        $this->db->where(array('wh.user_id' => $user_id,'wh.prediction_id '=> null, 'wh.coins !=' =>' NULL'));
        $this->db->order_by('wh.id','DESC');
        $this->db->limit('20',$offset);
        return $result = $this->db->get()->result_array();
        // $result = $this->db->get()->result_array();
        // echo $this->db->last_query();
        // echo count($result);
        // echo'<br><pre>';
        // print_r($result);
        // die;
        
    }

}  