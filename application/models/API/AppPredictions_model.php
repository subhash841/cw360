<?php

class AppPredictions_model extends CI_Model{

	public function get_game_points($game_id, $user_id) {
        $this->db->select("req_game_points,(SELECT points FROM points WHERE game_id = $game_id AND user_id = $user_id) as points");
        $this->db->from('games');
        $this->db->where('id', $game_id);
        return $this->db->get()->row_array();
    }

	public function get_predictions_details($game_id, $user_id, $limit = '', $offset = 0) {
		$where = array('p.game_id' => $game_id, 'p.is_published' => 1, 'p.is_active' => 1);
        $this->db->select('p.id,p.title,p.price,p.current_price,DATE_FORMAT(p.start_date, "%Y.%m.%d, %H:%i:%s")as start_date,DATE_FORMAT(p.end_date, "%Y.%m.%d, %H:%i:%s")as end_date,DATE_FORMAT(p.fpt_end_datetime, "%Y.%m.%d, %H:%i:%s")as fpt_end_datetime,p.agreed,p.disagreed,p.meta_keywords,p.meta_description,p.image,(CASE WHEN p.fpt_end_datetime < NOW() AND p.agreed =0 AND p.disagreed= 0 THEN 0 ELSE 1 END) AS to_display');
        $this->db->from('predictions p');
        $this->db->where($where);
        $this->db->where('NOW() >= p.start_date AND NOW() <= p.end_date');
        $this->db->where("NOT EXISTS (SELECT id FROM executed_predictions as ep 
            WHERE p.id = ep.prediction_id AND user_id=$user_id)");           //Do not remove space before WHERE clause on this line
        $this->db->having('to_display', '1');
        $this->db->order_by('p.id', 'DESC');
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        if ($limit == 1) {
            $result = $this->db->get()->row_array();
        } else {
            $result = $this->db->get()->result_array();
        }
        // echo $this->db->last_query();die;
        // print_r($result);
        return $result;
	}
	public function check_summary_count($game_id, $user_id) {
		$where = array('game_id' => $game_id, 'user_id' => $user_id);

        $this->db->select('count(id) as count');
        $this->db->from('executed_predictions');
        $this->db->where($where);
        $result = $this->db->get()->row_array();
        if ($result['count'] > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getUserCoins($user_id) {
        $this->db->select("coins");
        $this->db->from('coins');
        $this->db->where('user_id', $user_id);
        $userCoins = $this->db->get()->row_array();
        //echo $this->db->last_query()die;
        return $userCoins;
    }

    function get_coin_conversion_details($game_id) {
        $this->db->select('point_value_per_coin,coin_transfer_limit');
        $this->db->from('games'); 
        $this->db->where('id', $game_id); 
        $result = $this->db->get()->row_array();
        return $result;
    }
}
