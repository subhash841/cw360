<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Games_dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model(array('sidebar_model','games_dashboard_model','Games_model'));		
		$sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
            redirect('home');
        }
        
    }
    
    public function index() {
        $data=array();
        $data['sidebar_blogs'] = $this->sidebar_model->get_all_blogs(sidebar_card_limit(),'',0);
        // echo "<pre>";
        // print_r($data['sidebar_blogs']);die;
        $data['sidebar_quiz'] = $this->sidebar_model->get_all_quiz(sidebar_card_limit(),'',0);
        $game_ids=$this->games_dashboard_model->getGame_idList($this->user_id);
        $active_game_data=$this->game_dashboard_data($game_ids,1);
        $data['active_game_data']=$active_game_data;
        $completed_game_data=$this->game_dashboard_data($game_ids,0);
        $data['completed_game_data']=$completed_game_data;
        // print_r($data['active_game_data']);die;
        $this->load->view('header');
        $this->load->view('games_dashboard',$data);
        $this->load->view('footer');
    }

    public function game_dashboard_data($game_ids,$game_status)
    {   
        $game_data=array();
        foreach ($game_ids as $key => $value) {
            $gamedata=$this->games_dashboard_model->game_dashboard_data($value['game_id'],$game_status);
            $rankdata=$this->portfolio_data($value['game_id']);
            $predictionsdata=$this->games_dashboard_model->predictions_data($value['game_id'],$this->user_id); 
            if(!empty($rankdata)&& !empty($gamedata)){
                $game_data[]=array_merge($rankdata,$gamedata,$predictionsdata);
            }
 
        }
        return $game_data;  
    }

    function portfolio_data($game_id){

      $all_prediction_price = $this->Games_model->all_prediction_price($game_id);   //get all predictions current price
      $leaderboard_details = $this->Games_model->leaderboard_details($game_id);     //get executed predictions,users and points data
      $all_users = $this->Games_model->all_users_details($game_id);                //get users and points data
      $prediction_ids = array_column($all_prediction_price, 'id');                   //separate all ids
      $prediction_price = array_column($all_prediction_price, 'current_price');      //separate current price
      $predictionData = array_combine($prediction_ids, $prediction_price);           //assign current price to ids
      $leaderBoard = array();
      $user_points = '';
      $available_points = '';
      // print_r($all_users);die;
      foreach ($all_users as $key => $value) {
        $predDataKey =  array_search($value['user_id'],array_column($leaderboard_details, 'user_id'));
        if (!empty($predDataKey) || $predDataKey===0) {
          $leaderBoardPredData = $leaderboard_details[$predDataKey];  //get executed prediction data from leaderboard_details array
          $prediction_id_set = $leaderBoardPredData['predictions'];                                 //user's executed predictions
          $prediction_id_array  = explode(", ",$prediction_id_set);                   //executed predictions converted to array
          $bonus_points_set = $leaderBoardPredData['bonus_points'];                                 //user's bonus points
          $bonus_points_array = explode(",",$bonus_points_set);                       //bonus points converted to array
          $bonus_points_array = array_sum($bonus_points_array);
          $get_predictions= array_intersect_key($predictionData,array_flip($prediction_id_array));  //get current price of user's executed prediction from all predictions set
          $current_price_sum = array_sum($get_predictions);                                 //sum of all prediction's current price
          // print_r($current_price_sum);die;
          $leaderboard_points = $bonus_points_array + $value['points'] + $current_price_sum; //calculation for leader board total points
        }else{
          $leaderboard_points = $value['points'];
        }
          $leaderboard_points =  number_format((float)$leaderboard_points, 2, '.', '');
          // $leaderboard_points =  round($leaderboard_points);
          $leaderBoard[$key] = array('id' => $value['id'],'user_id' => $value['user_id'],'total_points' => $leaderboard_points);                                                              //set final array for users one by one
          if ($this->user_id == $value['user_id']) {
                $user_points = round($leaderboard_points);
                $available_points = round($value['points']);
            }
      }
      if (!empty($leaderBoard)) {
          $totalPoints = array_column($leaderBoard, 'total_points');
          array_multisort($totalPoints, SORT_DESC, $leaderBoard);
          // print_r($leaderBoard);die;
        $user_rank =  array_search($this->user_id, array_column($leaderBoard, 'user_id'));
        $is_user_exist = in_array($this->user_id, array_column($leaderBoard, 'user_id'));
        if ($is_user_exist==true) {
          $user_rank = $user_rank + 1;
        }else{
          $user_rank = '0';
        }
        return $data = array('user_points' => $user_points,'available_points' => $available_points,'user_rank' => $user_rank);
      }
    }
    
}
