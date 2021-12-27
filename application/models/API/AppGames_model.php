<?php

class AppGames_model extends CI_Model{

	function all_prediction_price($game_id) {
        $this->db->select('id, (CASE WHEN prediction_executed = 0 then current_price
            WHEN prediction_executed = 1 && wrong_prediction = 0 then current_price
            ELSE 0
            END)as current_price');
        $this->db->from('predictions');
        $this->db->where_in('id',"SELECT prediction_id from executed_predictions where game_id=$game_id GROUP BY prediction_id",false);
        return $this->db->get()->result_array();
    }
    function leaderboard_details($game_id) {
        $this->db->select("id, user_id, GROUP_CONCAT(bonus_points) as bonus_points, GROUP_CONCAT(DISTINCT(prediction_id) SEPARATOR ',') as predictions, GROUP_CONCAT(wrong_prediction) as wrong_prediction");
        $this->db->from('executed_predictions');
        // $this->db->where(array('ep.game_id' => $game_id,'ep.swipe_status' => 'agreed'));
        // $this->db->where('game_id', $game_id);
        // $this->db->where('swipe_status', 'agreed');
        if($game_id > 268){        
            // $this->db->where("(swipe_status = 'agreed' AND game_id = $game_id)");
            $this->db->where("swipe_status" , 'agreed');
            $this->db->where("game_id",$game_id);
            $this->db->or_where("(bonus_points > 0 AND game_id =$game_id)");
            }else{
            // $this->db->where("(swipe_status = 'agreed' AND game_id = $game_id)");
            // $this->db->or_where("(bonus_points > 0 and wrong_prediction = 1  AND game_id = $game_id)");
            $this->db->where("swipe_status" , 'agreed');
            $this->db->where("game_id",$game_id);
            }
        $this->db->group_by('user_id');
        $this->db->order_by('id','ASC');
        return $this->db->get()->result_array();
        // $this->db->get()->result_array();
        // echo $this->db->last_query();
    }
    function all_users_details($game_id) {
        $this->db->select("p.id, p.user_id, p.points, IFNULL(u.name, CONCAT('CW360#',p.user_id)) as name, u.image");
        $this->db->from('points as p');
        $this->db->join('users as u','p.user_id = u.id','LEFT');
        // $this->db->where(array('ep.game_id' => $game_id,'ep.swipe_status' => 'agreed'));
        $this->db->where('p.game_id', $game_id);
        $this->db->order_by('p.id','ASC');
        return $this->db->get()->result_array();
    }
    function get_max_players($game_id) {
        $this->db->select('max_players');
        $this->db->from('games');
        $this->db->where('id', $game_id);
        return $this->db->get()->row_array();
    }
    function get_user_coins($user_id) {
        $this->db->select('coins');
        $this->db->from('coins');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->row_array();
    }
    function require_coins($game_id) {
        $this->db->select('req_game_points');
        $this->db->from('games');
        $this->db->where('id', $game_id);
        return $this->db->get()->row_array();
    }
    function deduct_coins_to_add_points($req_game_points,$game_id,$user_id,$fixed_points){
        $this->db->set('coins', 'coins - '.$req_game_points, false);
        $this->db->where('user_id',$user_id);
        $this->db->update('coins');
        if ($this->db->affected_rows() > 0) {
            $insert_wallet_history = array(
                        'user_id' => $user_id,
                        'game_id' => $game_id,
                        'coins' => $req_game_points,
                        'type' => '3',
                        'created_date' => date('Y-m-d H:i:s')
                    );
            $this->db->insert('wallet_history',$insert_wallet_history);
            if ($this->db->affected_rows() > 0) {
                    $insert_array= array(
                        'user_id' => $user_id,
                        'game_id' => $game_id,
                        'points' => $fixed_points
                    );
                $this->db->insert('points',$insert_array);
                if ($this->db->affected_rows() > 0) {
                    $insert_points_log= array(
                            'user_id' => $user_id,
                            'game_id' => $game_id,
                            'points_before' => 0,
                            'update_points' => $fixed_points,
                            'points_after' => $fixed_points,
                            'update_type' => '0'
                        );
                    $this->db->insert('points_log',$insert_points_log);
                    if ($this->db->affected_rows() > 0) {
                        return 'points_inserted';
                    }else{
                        return 'points_log_query_failed';
                    }
                } else {
                    return 'points_query_failed';
                }
            } else {
                return 'wallet_history_query_failed';
            }
        } else {
            return 'coins_query_failed';
        }
    }
    function get_executed_predictions($game_id,$user_id) {
        $where = array('ep.user_id' => $user_id, 'ep.game_id' => $game_id);
        $this->db->select('ep.id,ep.prediction_id,ep.executed_points,ep.swipe_status, p.title, p.price, p.current_price, p.end_date,p.agreed,p.disagreed,ep.game_id,p.fpt_end_datetime,ep.wrong_prediction,(case when ep.modified_date IS NOT NULL then ep.modified_date else ep.created_date END) as created_date,now() as current_dateTime, (case when p.end_date < NOW() Then "C" when ep.swipe_status = "disagreed" Then "A" else "B" END) as sorting_list');
        $this->db->from('executed_predictions ep');
        $this->db->join('predictions p', 'ep.prediction_id=p.id', 'LEFT');
        $this->db->where($where);
        $this->db->order_by('sorting_list','ASC');
        $this->db->order_by('created_date','DESC');
        // $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    function check_predictions_avlib($prediction_id,$game_id) {
        $where = array('id' => $prediction_id, 'game_id' => $game_id);
        $this->db->select('count(id) as count_date');
        $this->db->from('predictions');
        $this->db->where($where);
        $this->db->where('(end_date <= NOW() OR is_published = 0)');
        return $this->db->get()->row_array();
    }

    function check_game_point($user_id,$game_id) {
        $where = array('user_id' => $user_id, 'game_id' => $game_id);
        $this->db->select('points');
        $this->db->from('points');
        $this->db->where($where);
        return $this->db->get()->result_array();
    }
    function summary_chanages_predictions($game_id,$prediction_id,$user_id,$condition) {

        $where = array('id' => $prediction_id, 'game_id' => $game_id);
        $this->db->select('price,IFNULL(current_price,0)as current_price');
        $this->db->from('predictions');
        $this->db->where($where);
        $res = $this->db->get()->row_array();
        $check_game_point = $this->check_game_point($user_id,$game_id);
        $game_points = $res["current_price"];
        $available_point = $check_game_point[0]['points'];

        $swipe_status = '';
        $buy_points = '0';
        $sell_points = '0';
        $where_cond = array('user_id' => $user_id, 'prediction_id' => $prediction_id, 'game_id' => $game_id);
        
        if ($condition == 'Yes' && $available_point >= $game_points) {
            // echo "true";
            //after yes diduct point current point 
            $this->db->set("points", "points - $game_points", FALSE);
            $this->db->set('update_type', '2');
            $this->db->where('user_id', $user_id);
            $this->db->where('game_id', $game_id);
            $this->db->update('points');

            //cout of predictions increase or decrease              
            $this->db->set("agreed", 'agreed + 1', FALSE);
            $this->db->set("disagreed", 'disagreed - 1', FALSE);
            $this->db->where($where);
            $this->db->update('predictions');

            //update  executed_predictions
            $swipe_status = 'agreed';
            $buy_points = $res["current_price"];
            $this->db->set("agreed", 'agreed + 1', FALSE);
            $this->db->set("swipe_status", 'agreed');
            $this->db->set("executed_points", $res["current_price"]);
            $this->db->set("modified_date", date('Y-m-d H:i:s'));
            $this->db->where($where_cond);
            $this->db->where('user_id', $user_id);
            $this->db->update('executed_predictions');

            //insert log of executed_predictions 
            $summary_history = array(
                'user_id' => $user_id,
                'game_id' => $game_id,
                'prediction_id' => $prediction_id,
                'swipe_status' => $swipe_status,
                'sell_points' => $sell_points,
                'buy_points' => $buy_points,
                'created_date' => date('Y-m-d H:i:s')
            );
            $this->db->insert('summary_history', $summary_history);

            $res_summary = $this->get_executed_predictions_yes_no_click($game_id, $prediction_id,$user_id);
            return $res_summary;
        } else if ($condition == 'No') {
            //echo "false";
            $this->db->set("points", "points + $game_points", FALSE);
            $this->db->set('update_type', '3');
            $this->db->where('user_id', $user_id);
            $this->db->where('game_id', $game_id);
            $this->db->update('points');


            $this->db->set("disagreed", 'disagreed + 1', FALSE);
            $this->db->set("agreed", 'agreed - 1', FALSE);
            $this->db->where($where);
            $this->db->update('predictions');

            //update  executed_predictions
            $swipe_status = 'disagreed';
            $sell_points = $res["current_price"];
            $this->db->set("disagreed", 'disagreed + 1', FALSE);
            $this->db->set("swipe_status", 'disagreed');
            $this->db->set("executed_points", '0');
            $this->db->set("modified_date", date('Y-m-d H:i:s'));
            $this->db->where($where_cond);
            $this->db->where('user_id', $user_id);
            $this->db->update('executed_predictions');

            //insert log of executed_predictions 
            $summary_history = array(
                'user_id' => $user_id,
                'game_id' => $game_id,
                'prediction_id' => $prediction_id,
                'swipe_status' => $swipe_status,
                'sell_points' => $sell_points,
                'buy_points' => $buy_points,
                'created_date' => date('Y-m-d H:i:s')
            );
            $this->db->insert('summary_history', $summary_history);

            $res_summary = $this->get_executed_predictions_yes_no_click($game_id, $prediction_id,$user_id);
            return $res_summary;
        } else {
            return false;
        }
    }
    function get_executed_predictions_yes_no_click($game_id, $prediction_id,$user_id) {
        $where = array('ep.user_id' => $user_id, 'ep.game_id' => $game_id, 'ep.prediction_id' => $prediction_id);
        $this->db->select("ep.id,ep.prediction_id,ep.executed_points,ep.swipe_status,p.title, p.price,p.current_price ,p.end_date,p.agreed,p.disagreed,ep.game_id,ep.wrong_prediction,(case when ep.modified_date IS NOT NULL then ep.modified_date else ep.created_date END) as created_date,p.fpt_end_datetime,(SELECT points FROM points WHERE user_id=$user_id and game_id=$game_id) as points,now() as current_dateTime");
        $this->db->from('executed_predictions ep');
        $this->db->join('predictions p', 'ep.prediction_id=p.id', 'LEFT');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }
    function get_game_reward_details($game_id) {
        $this->db->select('id,description,price');
        $this->db->from('games_reward');
        $this->db->where('game_id', $game_id);
        return $this->db->get()->result_array();
    }
    function game_details($game_id) {
        $this->db->select('title,req_game_points,description,image,start_date,end_date,is_published,is_active,max_players,change_prediction_time');
        $this->db->from('games');
        $this->db->where('id', $game_id);
        return $this->db->get()->row_array();
    }
    function getGameEndDate($game_id) {
        $this->db->select('end_date');
        $this->db->from('games');
        $this->db->where('id', $game_id);
        return $this->db->get()->row_array();
    }

}
