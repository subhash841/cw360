<?php

class Games_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $sessiondata = $this->session->userdata('data');
        // print_r($sessiondata);die;
        if (!empty($sessiondata)) {
            $this->user_id = @$sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
    }

    public function get_game_details($game_id) {
        $this->db->select('id,title,req_game_points,end_date,description,link,topic_id,max_players,meta_description,image');
        $this->db->from('games');
        $this->db->where('id', $game_id);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function get_executed_predictions($game_id, $offset = 0, $limit = 10) {
        $where = array('ep.user_id' => $this->user_id, 'ep.game_id' => $game_id);
        $this->db->select('ep.id,ep.prediction_id,ep.executed_points,ep.swipe_status, p.title, p.price, p.current_price, p.end_date,p.agreed,p.disagreed,ep.game_id,p.fpt_end_datetime,ep.wrong_prediction,(case when ep.modified_date IS NOT NULL then ep.modified_date else ep.created_date END) as created_date,now() as current_dateTime');
        $this->db->from('executed_predictions ep');
        $this->db->join('predictions p', 'ep.prediction_id=p.id', 'LEFT');
        $this->db->where($where);
        $this->db->order_by('created_date','DESC');
        $this->db->limit($limit, $offset);
         // $this->db->get()->result_array();
         // echo $this->db->last_query();die;
        return $this->db->get()->result_array();
    }

    public function get_executed_predictions_yes_no_click($game_id, $predictions) {
        $where = array('ep.user_id' => $this->user_id, 'ep.game_id' => $game_id, 'ep.prediction_id' => $predictions);
        $this->db->select("ep.id,ep.prediction_id,ep.executed_points,ep.swipe_status,p.title, p.price,p.current_price ,p.end_date,p.agreed,p.disagreed,ep.game_id,ep.wrong_prediction,(case when ep.modified_date IS NOT NULL then ep.modified_date else ep.created_date END) as created_date,p.fpt_end_datetime,(SELECT points FROM points WHERE user_id=$this->user_id and game_id=$game_id) as points,now() as current_dateTime");
        $this->db->from('executed_predictions ep');
        $this->db->join('predictions p', 'ep.prediction_id=p.id', 'LEFT');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function summary_chanages_predictions() {

        $where = array('id' => $_POST['id'], 'game_id' => $_POST['game_id']);
        $this->db->select('price,IFNULL(current_price,0)as current_price');
        $this->db->from('predictions');
        $this->db->where($where);
        $res = $this->db->get()->row_array();
        $check_game_point = $this->check_game_point();
        $game_points = $res["current_price"];
        $available_point = $check_game_point[0]['points'];

        $swipe_status = '';
        $buy_points = '0';
        $sell_points = '0';
        $where_cond = array('user_id' => $this->user_id, 'prediction_id' => $_POST['id'], 'game_id' => $_POST['game_id']);
        
        if ($_POST['condition'] == 'Yes' && $available_point >= $game_points) {
            // echo "true";
            //after yes diduct point current point 
            $this->db->set("points", "points - $game_points", FALSE);
            $this->db->set('update_type', '2');
            $this->db->where('user_id', $this->user_id);
            $this->db->where('game_id', $_POST['game_id']);
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
            $this->db->where('user_id', $this->user_id);
            $this->db->update('executed_predictions');

            //insert log of executed_predictions 
            $summary_history = array(
                'user_id' => $this->user_id,
                'game_id' => $_POST['game_id'],
                'prediction_id' => $_POST['id'],
                'swipe_status' => $swipe_status,
                'sell_points' => $sell_points,
                'buy_points' => $buy_points,
                'created_date' => date('Y-m-d H:i:s')
            );
            $this->db->insert('summary_history', $summary_history);

            $res_summary = $this->get_executed_predictions_yes_no_click($_POST['game_id'], $_POST['id']);
            return $res_summary;
        } else if ($_POST['condition'] == 'No') {
            //echo "false";
            $this->db->set("points", "points + $game_points", FALSE);
            $this->db->set('update_type', '3');
            $this->db->where('user_id', $this->user_id);
            $this->db->where('game_id', $_POST['game_id']);
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
            $this->db->where('user_id', $this->user_id);
            $this->db->update('executed_predictions');

            //insert log of executed_predictions 
            $summary_history = array(
                'user_id' => $this->user_id,
                'game_id' => $_POST['game_id'],
                'prediction_id' => $_POST['id'],
                'swipe_status' => $swipe_status,
                'sell_points' => $sell_points,
                'buy_points' => $buy_points,
                'created_date' => date('Y-m-d H:i:s')
            );
            $this->db->insert('summary_history', $summary_history);

            $res_summary = $this->get_executed_predictions_yes_no_click($_POST['game_id'], $_POST['id']);


            return $res_summary;
        } else {

            return false;
        }
    }

    public function check_game_point() {

        $where = array('user_id' => $this->user_id, 'game_id' => $_POST['game_id']);
        $this->db->select('points');
        $this->db->from('points');
        $this->db->where($where);
        return $this->db->get()->result_array();
        // return $res['points'];
        // print_r($res);
    }

    public function check_predictions_avlib() {

        $where = array('id' => $_POST['id'], 'game_id' => $_POST['game_id']);
        $this->db->select('count(id) as count_date');
        $this->db->from('predictions');
        $this->db->where($where);
        $this->db->where('end_date <= NOW()');
        return $this->db->get()->row_array();
        // return $res['points'];
        // print_r($res);
    }

    function get_all_games($offset = 0) {
        $limit = get_game_limit();
        $this->db->select('id,title,req_game_points,req_game_points,image,(CASE when DATEDIFF(end_date, NOW()) <= 0 then "Game Ended" else concat(DATEDIFF(end_date, NOW())," ","Days left") END)as end_date');
        $this->db->from('games');
        $this->db->where('is_active', '1');
        $this->db->where('is_published', '1');
        $this->db->order_by('id','DESC');
        $this->db->limit($limit, $offset);
        $result = $this->db->get()->result_array();
        return $result;
    }

    function get_games($id) {
        $limit = get_game_limit();
/*        $sql = "select  id,title,req_game_points,req_game_points,image, (CASE when DATEDIFF(end_date, NOW()) <= 0 then 'Game Ended' else concat(DATEDIFF(end_date, NOW()),' ','Days left') END)as end_date ,topic_id FROM games where FIND_IN_SET('" . $id . "',topic_id)  AND is_active = '1' ORDER BY id DESC limit " . $limit . " ";*/
        $sql = "select  id,title,req_game_points,req_game_points,image, (CASE when DATEDIFF(end_date, NOW()) <= 0 then 'Game Ended' else concat(DATEDIFF(end_date, NOW()),' ','Days left') END)as end_date ,topic_id FROM games where topic_id= " . $id . " AND is_active = '1' ORDER BY id DESC limit " . $limit . " ";
//        $sql = "select  id,title,image,  ,topic_id FROM games where FIND_IN_SET('" . $id . "',topic_id) limit " . $limit . " ";
        $query = $this->db->query($sql);

        $result = $query->result_array();
       // echo $this->db->last_query();die;
        return $result;
    }

    function get_cat_games($offset, $cat_id) {
        $limit = get_game_limit();
        $sql = "select  id,title,req_game_points,req_game_points,image,(CASE when DATEDIFF(end_date, NOW()) <= 0 then 'Game Ended' else concat(DATEDIFF(end_date, NOW()),' ','Days left') END)as end_date,topic_id FROM games where FIND_IN_SET('" . $cat_id . "',topic_id)  AND is_active = '1' ORDER BY id DESC limit " . $limit . " OFFSET " . $offset . " ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function get_all_games_count() {
        $this->db->select('count("id")');
        $this->db->where('is_active', '1');
        $this->db->from('games');
        $result = $this->db->get()->row_array();
        return reset($result);
    }

    function get_cat_game_count($id) {
        $sql = "select count('id') FROM games where FIND_IN_SET('" . $id . "',topic_id) AND is_active = '1'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return reset($result);
    }
    
    public function get_game_reward_details($game_id) {
        $this->db->select('g.id,g.description,g.price');
        $this->db->from('games_reward g');
        $this->db->where('game_id', $game_id);
//        $this->db->where('g.is_published', '1');
//        $this->db->where('g.is_active', '1');
        $result = $this->db->get()->result_array();
        return $result;
    }


    /*function all_prediction_price($game_id) {
        $this->db->select('id, current_price');
        $this->db->from('predictions');
        $this->db->where_in('id',"SELECT prediction_id from executed_predictions where game_id=$game_id GROUP BY prediction_id",false);
        return $this->db->get()->result_array();
    }*/
    function all_prediction_price($game_id) {
        $this->db->select('id, (CASE WHEN prediction_executed = 0 then current_price
            WHEN prediction_executed = 1 && wrong_prediction = 0 then current_price
            ELSE 0
            END)as current_price');
        $this->db->from('predictions');
        $this->db->where_in('id',"SELECT prediction_id from executed_predictions where game_id=$game_id GROUP BY prediction_id",false);
        return $this->db->get()->result_array();
    }

    /*function leaderboard_details($game_id) {
        $this->db->select("ep.id, ep.user_id, GROUP_CONCAT(ep.bonus_points) as bonus_points, GROUP_CONCAT(DISTINCT(ep.prediction_id) SEPARATOR ',') as predictions, IFNULL(u.name, CONCAT('CW360#',ep.user_id)) as name, u.image, (SELECT points from points where user_id = ep.user_id and game_id=$game_id limit 1) as points");
        $this->db->from('executed_predictions as ep');
        $this->db->join('users as u','ep.user_id = u.id','LEFT');
        // $this->db->where(array('ep.game_id' => $game_id,'ep.swipe_status' => 'agreed'));
        $this->db->where('ep.game_id', $game_id);
        $this->db->where('ep.swipe_status', 'agreed');
        $this->db->group_by('ep.user_id');
        $this->db->order_by('ep.id','ASC');
        return $this->db->get()->result_array();
        // $this->db->get()->result_array();
        // echo $this->db->last_query();
    }*/
    function leaderboard_details($game_id) {
        $this->db->select("id, user_id, GROUP_CONCAT(bonus_points) as bonus_points, GROUP_CONCAT(DISTINCT(prediction_id) SEPARATOR ',') as predictions");
        $this->db->from('executed_predictions');
        // $this->db->where(array('ep.game_id' => $game_id,'ep.swipe_status' => 'agreed'));
        $this->db->where('game_id', $game_id);
        $this->db->where('swipe_status', 'agreed');
        $this->db->group_by('user_id');
        $this->db->order_by('id','ASC');
        return $this->db->get()->result_array();
        // $this->db->get()->result_array();
        // echo $this->db->last_query();
    }
    function current_players($game_id) {
        $this->db->select('user_id');
        $this->db->from('points');
        $this->db->where('game_id', $game_id);
        return $this->db->get()->result_array();
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

}

