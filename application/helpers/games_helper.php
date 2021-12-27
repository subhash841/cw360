<?php 
 function get_user_portfolio($game_id,$user_id){
    $ci = &get_instance();
    $all_prediction_price = $ci->games_model->all_prediction_price($game_id);   //get all predictions current price
    $leaderboard_details = $ci->games_model->leaderboard_details($game_id);   //get executed predictions,users and points data
    $all_users = $ci->games_model->all_users_details($game_id);       //get users and points data
    $prediction_ids = array_column($all_prediction_price, 'id');        //separate all ids
    $prediction_price = array_column($all_prediction_price, 'current_price'); //separate current price
    $predictionData = array_combine($prediction_ids, $prediction_price);    //assign current price to ids

    $leaderBoard = array();
    $user_points = '';
    foreach ($all_users as $key => $value) {
        $predDataKey =  array_search($value['user_id'],array_column($leaderboard_details, 'user_id'));
        if (!empty($predDataKey) || $predDataKey===0) {
            $leaderBoardPredData = $leaderboard_details[$predDataKey];  //get executed prediction data from leaderboard_details 
            $prediction_id_set = $leaderBoardPredData['predictions'];             //user's executed predictions
            $prediction_id_array  = explode(", ",$prediction_id_set);     //executed predictions converted to array
            $bonus_points_set = $leaderBoardPredData['bonus_points'];                         //user's bonus points
            $bonus_points_array = explode(",",$bonus_points_set);               //bonus points converted to array
            $bonus_points_array = array_sum($bonus_points_array);
            // $get_predictions= array_flip(array_intersect(array_flip($predictionData),$prediction_id_array)); //get current price of user's executed prediction from all predictions set
            $get_predictions= array_intersect_key($predictionData,array_flip($prediction_id_array));    //get current price of user's executed prediction from all predictions set
            $current_price_sum = array_sum($get_predictions);       //sum of all prediction's current price 
            // print_r($current_price_sum);die;
            $leaderboard_points = $bonus_points_array + $value['points'] + $current_price_sum;      //calculation for leader board total points
        }else{
            $leaderboard_points = $value['points'];
        }
        // $leaderboard_points =  number_format((float)$leaderboard_points, 2, '.', '');
        $leaderBoard[$key] = array('id' => $value['id'],'user_id' => $value['user_id'], 'total_points' => $leaderboard_points);
        if ($user_id == $value['user_id']) {
          $user_points = $leaderboard_points;
        }
    }
    if (!empty($leaderBoard)) {
          $totalPoints = array_column($leaderBoard, 'total_points');
          array_multisort($totalPoints, SORT_DESC, $leaderBoard);
          
        $user_rank =  array_search($user_id, array_column($leaderBoard, 'user_id'));
        $is_user_exist = in_array($user_id, array_column($leaderBoard, 'user_id')); 
        if ($is_user_exist ==true) {
          $user_rank = $user_rank + 1;
        }else{
          $user_rank = '0';
        } 
      $data = array('user_points' => empty($user_points) ? '0' : $user_points,'user_rank' => $user_rank);
    }else{
      $data = array('user_points' => '0','user_rank' => '0');
    }
    return $data;
}