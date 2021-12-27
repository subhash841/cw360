<?php

class Predictions_model extends CI_Model {

    function __construct() {
        parent::__construct();
        // echo "<pre>";
        $sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
    }

    public function get_predictions_details($game_id, $limit = '', $offset = 0) {

        $where = array('p.game_id' => $game_id, 'p.is_published' => 1, 'p.is_active' => 1);


        $this->db->select('p.id,p.title,p.price,p.current_price,p.start_date,p.end_date,p.fpt_end_datetime,p.agreed,p.disagreed,p.meta_keywords,p.meta_description,p.image,(CASE WHEN p.fpt_end_datetime < NOW() AND p.agreed =0 AND p.disagreed= 0 THEN 0 ELSE 1 END) AS to_display');
        $this->db->from('predictions p');
        $this->db->where($where);
        $this->db->where('NOW() >= p.start_date AND NOW() <= p.end_date');
        $this->db->where("NOT EXISTS (SELECT id FROM executed_predictions as ep 
            WHERE p.id = ep.prediction_id AND user_id=$this->user_id)");           //Do not remove space before WHERE clause on this line
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

    public function get_prediction_data($prediction_id) {
        if (!empty($prediction_id)) {
            $this->db->select('start_date,end_date,fpt_end_datetime,price,current_price,agreed,disagreed,is_published');
            $this->db->from('predictions');
            $this->db->where('id', $prediction_id);
            $result = $this->db->get()->row_array();
            return $result;
        } else {
            return false;
        }
    }

    public function insert_prediction_data($postData) {
        $insert_array = array(
            'user_id' => $postData['user_id'],
            'game_id' => $postData['game_id'],
            'agreed' => $postData['swipe_type'] == 'right' ? '1' : '0',
            'disagreed' => $postData['swipe_type'] == 'left' ? '1' : '0',
            'prediction_id' => $postData['current_prediction_id'],
            'executed_points' => $postData['swipe_type'] == 'right' ? $postData['current_prediction_price'] : '0',
            'swipe_status' => $postData['swipe_type'] == 'right' ? 'agreed' : 'disagreed',
            'created_date' => date("Y-m-d H:i:s")
        );

        $this->db->insert('executed_predictions', $insert_array);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_game_points($postData) {
        $this->db->set('points', 'points - ' . $postData['current_prediction_price'], false);
        $this->db->set('update_type', '1');
        $this->db->where('user_id', $postData['user_id']);
        $this->db->where('game_id', $postData['game_id']);
        $this->db->update('points');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_game_points($game_id, $user_id) {
        $this->db->select('points');
        $this->db->from('points');
        $this->db->where(array('user_id' => $user_id, 'game_id' => $game_id));
        return $this->db->get()->row_array();
    }
    public function check_prediction_swiped($user_id,$game_id,$prediction_id) {
        $this->db->select('id');
        $this->db->from('executed_predictions');
        $this->db->where(array('user_id' => $user_id, 'game_id' => $game_id, 'prediction_id' => $prediction_id));
        return $this->db->get()->row_array();
    }

    public function getUserCoins() {
        $this->db->select("coins");
        $this->db->from('coins');
        $this->db->where('user_id', $this->user_id);
        $userCoins = $this->db->get()->row_array();
        //echo $this->db->last_query()die;
        return $userCoins;
    }
    public function getRedeemUserCoins() {       
        $userCoins=array();        
        $this->db->select("id,coins, type");
        $this->db->from("wallet_history");
        $this->db->where("user_id",$this->user_id); 
        $userGetallCoins = $this->db->get()->result_array();
        // echo "<pre>";
        $coins=0;
        $redeemcoins=0;
        foreach($userGetallCoins as $key => $value){
            //echo "<br>";
                if($value['type']=="0" ||  $value['type']=="1"){
                        $coins=$coins+$value['coins'];    
                        //echo $coins."add";        
                }else  if($value['type']=="2" ||  $value['type']=="5"){
                    $redeemcoins=$redeemcoins+$value['coins'];
                }else if($value['type']=="3" || $value['type']=="4" || $value['type']=="6" || $value['type']=="7" || $value['type']=="8" || $value['type']=="9"){
                        //echo $coins;
                    if($value['type']=="7"){
                        //echo "1 type".$value['type'];
                        $redeemcoins=$redeemcoins-$value['coins'];
                    }else if($coins >= $value['coins']){
                        //echo "2 type".$value['type'];
                        $coins=$coins-$value['coins'];

                    }else if($value['coins'] > $coins){
                        //echo "3 type".$value['type'];
                        $re_coins=$value['coins']-$coins;
                        // echo $re_coins;
                        $redeemcoins=$redeemcoins-$re_coins;
                        $coins=0;
                    }
                
                }
                $userCoins['coins']=$redeemcoins;
            
        }
        return $userCoins;            
    }

    public function deduct_coins_to_add_points($req_game_points,$game_id,$fixed_points){
        $this->db->set('coins', 'coins - '.$req_game_points, false);
        $this->db->where('user_id',$this->user_id);
        $this->db->update('coins');
        if ($this->db->affected_rows() > 0) {
            $insert_wallet_history = array(
                        'user_id' => $this->user_id,
                        'game_id' => $game_id,
                        'coins' => $req_game_points,
                        'type' => '3',
                        'created_date' => date('Y-m-d H:i:s')
                    );
            $this->db->insert('wallet_history',$insert_wallet_history);
            if ($this->db->affected_rows() > 0) {
                    $insert_array= array(
                        'user_id' => $this->user_id,
                        'game_id' => $game_id,
                        'points' => $fixed_points
                    );
                $this->db->insert('points',$insert_array);
                if ($this->db->affected_rows() > 0) {
                    $insert_points_log= array(
                            'user_id' => $this->user_id,
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

    function get_games($game_id="", $topic_id, $offset = 0) {
        if (!empty($topic_id)) {
            //$this->db->select('id,title,image,(CASE when DATEDIFF(end_date, NOW()) <= 0 then "Game Ended" else concat(DATEDIFF(end_date, NOW())," ","Days left") END)as end_date');
            //$this->db->from('games');
            //$this->db->where(array('is_published' => 1, 'is_active' => 1, 'id !=' => $game_id));
            //$this->db->limit($limit,$offset);
            //return $this->db->get()->result_array();
            $limit = get_right_side_game_limit();
            if(!empty($game_id)){
                            $sql = "SELECT id, title, image, topic_id, (CASE when DATEDIFF(end_date, NOW()) <= 0 then \"Game Ended\" else concat(DATEDIFF(end_date, NOW()), \" \", \"Days left\") END)as end_date "
                    . "FROM games WHERE is_published = 1 AND is_active = 1 AND NOW() <= end_date AND id != " . $game_id . "  ORDER BY FIELD (topic_id," . $topic_id . ") DESC limit " . $limit . " offset " . $offset ;
            }else{
            $sql = "SELECT id, title, image, topic_id, (CASE when DATEDIFF(end_date, NOW()) <= 0 then \"Game Ended\" else concat(DATEDIFF(end_date, NOW()), \" \", \"Days left\") END)as end_date "
                    . "FROM games WHERE is_published = 1 AND is_active = 1 AND NOW() <= end_date ORDER BY FIELD (topic_id," . $topic_id . ") DESC limit " . $limit . " offset " . $offset ;
            }
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }
    }

    function check_summary_count($game_id) {
        $where = array('game_id' => $game_id, 'user_id' => $this->user_id);

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

}