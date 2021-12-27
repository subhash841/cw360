<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AppGame extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this
            ->load
            ->model(array(
            'API/AppGames_model',
            'API/AppPredictions_model',
            'sidebar_model',
            'games_model',
            'predictions_model',
            'games_dashboard_model'
        ));
        $this
            ->load
            ->helper(array(
            'prediction_helper',
            'games_helper',
            'common_api_helper'
        ));
        $this
            ->load
            ->model(array(
            'Common_model',
            'blog_model',
            'API/AppCommon_model'
        ));
    }

    public function prediction_game()
    {
        $postData = $this
            ->input
            ->post();
        $game_id = $postData['game_id'];
        $user_id = $postData['user_id'];
        $topic_id = $postData['topic_id'];
        if (empty($game_id))
        {
            sendjson(array(
                'status' => false,
                'message' => 'Game id is null'
            ));
        }
        else
        {
            $predictionId = !empty($postData['prediction_id']) ? $postData['prediction_id'] : '';
            // $data['game_id'] = $game_id;
            $data['game_details'] = $this
                ->AppGames_model
                ->game_details($game_id);
            $available_points = $this
                ->predictions_model
                ->get_game_points($game_id, $user_id);
            $data['available_points'] = $available_points['points'];
            $data['portfolio_data'] = get_user_portfolio($game_id, $user_id);
            // $data['prediction_details'] = $this->predictions_model->get_predictions_details($game_id);
            $allpredictionDetails = $this
                ->AppPredictions_model
                ->get_predictions_details($game_id, $user_id);
            $is_game_summary_exist = $this
                ->AppPredictions_model
                ->check_summary_count($game_id, $user_id);

            if (empty($allpredictionDetails) && $is_game_summary_exist == true)
            {
                sendjson(array(
                    'status' => true,
                    'message' => 'Redirect to summary screen'
                ));
            }
            else
            {
                if (!empty($predictionId))
                { //to get shared prediction on top
                    $prediction_key = array_search($predictionId, array_column($allpredictionDetails, 'id'));
                    $is_key_exist = in_array($predictionId, array_column($allpredictionDetails, 'id'));
                    if ($is_key_exist == true)
                    {
                        $pred_array = $allpredictionDetails[$prediction_key];
                        unset($allpredictionDetails[$prediction_key]);
                        array_unshift($allpredictionDetails, $pred_array); //to get prediction at 1st positionin array
                        // $data['meta_data'] = $pred_array;
                        // $data['meta_data']['game_title'] = $data['meta_data']['title'];
                        
                    }
                } /*else{
                  // get game meta data
                  $data['meta_data'] = $data['game_details'];
                }*/
                if (!empty($allpredictionDetails))
                {
                    if (count($allpredictionDetails) > 3)
                    {
                        $allpredictionDetails = array_slice($allpredictionDetails, 0, 3); //get first 3 records from all predictions
                        
                    }
                }
                $data['prediction_details'] = $allpredictionDetails;
                $data['current_datetime'] = date("Y.m.d, H:i:s");
                $data['topics_quiz_list'] = $this
                    ->AppCommon_model
                    ->get_all_quiz(6, $topic_id, '', $user_id);
                $data['sidebar_games'] = $this
                    ->AppCommon_model
                    ->get_all_games(sidebar_card_limit() , $topic_id, 0);
                $data['sidebar_blogs'] = $this
                    ->AppCommon_model
                    ->get_all_blogs(sidebar_card_limit() , $topic_id, 0);
                sendjson(array(
                    "status" => true,
                    "message" => "Prediction data",
                    "data" => $data
                ));
            }
        }
    }

    public function prediction_action()
    {
        $postData = $this
            ->input
            ->post();
        $game_id = $postData['game_id'];
        $user_id = $postData['user_id'];
        $view_the_game = $postData['view_the_game']; //if user wants to view the game, then it should be 1 else null
        // $play_game_cookie = get_cookie('game_'.$postData['game_id'].'_play');
        $game_available = $this
            ->games_model
            ->check_game_existance($game_id);
        if (empty($game_id))
        {
            sendjson(array(
                'status' => false,
                'message' => 'Game id is null'
            ));
        }
        else if (!empty($user_id) && $view_the_game == 'yes')
        {
            // $data['action'] = 'redirect_to_login';
            $data = $this->view_the_game($postData, $game_available); //process for users who just want to view the game
            
        }
        else
        {
            $authenicate = authenicate_access_token(getallheaders());
            if ($authenicate == '1')
            {
                $current_prediction_data = '';
                $limit = 1;
                $offset = 2;
                $user_game_points = $this
                    ->AppPredictions_model
                    ->get_game_points($game_id, $user_id);
                $check_prediction_swiped = $this
                    ->predictions_model
                    ->check_prediction_swiped($user_id, $game_id, $postData['current_prediction_id']);
                if (empty($user_game_points['points']))
                {
                    sendjson(array(
                        'status' => true,
                        'message' => 'Game coins require',
                        'popup_msg' => 'Entry Fee: ' . $user_game_points['req_game_points'] . ' Coins. Do you want to continue?'
                    ));
                    return;
                }
                $game_points = $user_game_points['points'];
                $current_datetime = date("Y-m-d H:i:s");
                if (!empty($postData['current_prediction_id']))
                {
                    $current_prediction_data = $this
                        ->predictions_model
                        ->get_prediction_data($postData['current_prediction_id']);
                    $current_prediction_price = $current_prediction_data['current_price']; //price of visible prediction
                    
                }
                else
                {
                    sendjson(array(
                        'status' => false,
                        'message' => 'Current prediction id is null'
                    ));
                    return;
                }
                if (!empty($postData['next_prediction_id']))
                {
                    $next_prediction_data = $this
                        ->predictions_model
                        ->get_prediction_data($postData['next_prediction_id']);
                    $next_prediction_price = $next_prediction_data['current_price']; //price of second (next to visible) prediction
                    
                }

                if ($current_prediction_data == false || empty($current_prediction_data))
                {
                    sendjson(array(
                        'status' => true,
                        'code' => 403,
                        'message' => 'Prediction not found'
                    ));
                }
                else if (!empty($check_prediction_swiped))
                {
                    sendjson(array(
                        'status' => true,
                        'code' => 403,
                        'message' => 'Prediction has been already swiped'
                    ));
                }
                else if ($game_points < $current_prediction_price && $postData['swipe_type'] == 'right')
                {
                    sendjson(array(
                        'status' => true,
                        'message' => 'Insufficient game points'
                    ));
                }
                else if ($current_datetime > $current_prediction_data['fpt_end_datetime'] && $current_prediction_data['agreed'] == '0' && $current_prediction_data['disagreed'] == '0')
                {
                    sendjson(array(
                        'status' => true,
                        'code' => 403,
                        'message' => 'Prediction no longer exists'
                    ));
                }
                else if ($current_prediction_data['is_published'] == 0 || $current_prediction_data['end_date'] < date('Y-m-d H:i:s') || empty($game_available['is_published']) || $game_available['end_date'] < (date('Y-m-d H:i:s')))
                {
                    sendjson(array(
                        'status' => true,
                        'code' => 403,
                        'message' => 'This prediction is not available now'
                    ));
                }
                else
                {
                    if ($current_prediction_price >= '0' && $current_prediction_price < '1')
                    {
                        $current_prediction_price = '1';
                    }
                    else if ($current_prediction_price > '100')
                    {
                        $current_prediction_price = '100';
                    }

                    $postData = $postData + array(
                        'current_prediction_price' => $current_prediction_price
                    );

                    $insert_execution = $this
                        ->predictions_model
                        ->insert_prediction_data($postData);
                    if ($postData['swipe_type'] == 'right')
                    {
                        $update_game_points = $this
                            ->predictions_model
                            ->update_game_points($postData);
                    }
                    else
                    {
                        $update_game_points = true;
                    }

                    if ($insert_execution == true && $update_game_points == true)
                    {
                        $available_points = '';
                        if ($postData['swipe_type'] == 'right')
                        {
                            $available_points = $game_points - $current_prediction_price;
                            $available_points = number_format((float)$available_points, 2, '.', '');
                        }
                        if (empty($postData['next_prediction_id']))
                        {
                            $data = array(
                                'available_points' => $available_points
                            );
                        }
                        else
                        {
                            $fpt_end_datetime = $next_prediction_data['fpt_end_datetime'];
                            $data = array(
                                'fpt_end_datetime' => $fpt_end_datetime,
                                'prediction_end_date' => date('d M Y', strtotime($next_prediction_data['end_date'])) ,
                                'current_price' => round($next_prediction_price) ,
                                'available_points' => $available_points
                            );
                        }

                        $result_load_prediction = $this
                            ->AppPredictions_model
                            ->get_predictions_details($game_id, $user_id, $limit, $offset);
                        $load_prediction_data = array(
                            'load_prediction_data' => $result_load_prediction
                        );
                        if (!empty($result_load_prediction))
                        {
                            $data = array_merge($data, $load_prediction_data); //merging next prediction's data that to be loaded.
                            
                        }
                        $action = array(
                            'action' => 'play_the_game'
                        );
                        $data = array_merge($data, $action);
                        // sendjson(array("status" => TRUE, "message" => "Prediction swiped","data"=>$data,'load_prediction_data' => $result_load_prediction));
                        sendjson(array(
                            "status" => true,
                            "message" => "Prediction swiped",
                            "data" => $data
                        ));
                    }
                    else
                    {
                        sendjson(array(
                            'status' => false,
                            'message' => 'Prediction not inserted or game coins not updated'
                        ));
                    }
                }
            }
            else
            {
                sendjson($authenicate);
            }
        }
    }

    private function view_the_game($postData, $game_available)
    {
        $current_prediction_data = '';
        $limit = 1;
        $offset = $postData['offset'];
        $current_datetime = date("Y-m-d H:i:s");
        if (!empty($postData['current_prediction_id']))
        {
            $current_prediction_data = $this
                ->predictions_model
                ->get_prediction_data($postData['current_prediction_id']);
            $current_prediction_price = $current_prediction_data['current_price']; //price of visible prediction
            
        }
        else
        {
            sendjson(array(
                'status' => false,
                'message' => 'Current prediction id is null'
            ));
            return;
        }
        if (!empty($postData['next_prediction_id']))
        {
            $next_prediction_data = $this
                ->predictions_model
                ->get_prediction_data($postData['next_prediction_id']);
            $next_prediction_price = $next_prediction_data['current_price']; //price of second (next to visible) prediction
            
        }

        if ($current_prediction_data == false || empty($current_prediction_data))
        {
            sendjson(array(
                'status' => true,
                'message' => 'Prediction not found'
            ));
        }
        else if ($current_datetime > $current_prediction_data['fpt_end_datetime'] && $current_prediction_data['agreed'] == '0' && $current_prediction_data['disagreed'] == '0')
        {
            sendjson(array(
                'status' => true,
                'message' => 'Prediction no longer exists'
            ));
        }
        else if ($current_prediction_data['is_published'] == 0 || $current_prediction_data['end_date'] < date('Y-m-d H:i:s') || empty($game_available['is_published']) || $game_available['end_date'] < (date('Y-m-d H:i:s')))
        {
            sendjson(array(
                'status' => true,
                'message' => 'This prediction is not available now'
            ));
        }
        else
        {
            if ($current_prediction_price >= '0' && $current_prediction_price < '1')
            {
                $current_prediction_price = '1';
            }
            else if ($current_prediction_price > '100')
            {
                $current_prediction_price = '100';
            }
            $postData = $postData + array(
                'current_prediction_price' => $current_prediction_price
            );
            $data = array();
            if (!empty($postData['next_prediction_id']))
            {
                $fpt_end_datetime = $next_prediction_data['fpt_end_datetime'];
                $data = array(
                    'fpt_end_datetime' => $fpt_end_datetime,
                    'prediction_end_date' => date('d M Y', strtotime($next_prediction_data['end_date'])) ,
                    'current_price' => round($next_prediction_price) ,
                );
            }
            $result_load_prediction = $this
                ->AppPredictions_model
                ->get_predictions_details($postData['game_id'], $postData['user_id'], $limit, $offset);
            $load_prediction_data = array(
                'load_prediction_data' => $result_load_prediction
            );
            $action = array(
                'action' => 'view_the_game'
            );
            if (!empty($result_load_prediction))
            {
                $data = array_merge($data, $load_prediction_data); //merging next prediction's data that to be loaded.
                
            }
            $data = array_merge($data, $action);
            sendjson(array(
                "status" => true,
                "message" => "Prediction swiped",
                "data" => $data
            ));
        }
    }

    public function leaderboard()
    {
        $postData = $this
            ->input
            ->post();
        $game_id = $postData['game_id'];
        $user_id = $postData['user_id'];
        $topic_id = $postData['topic_id'];

        if (empty($game_id))
        {
            sendjson(array(
                'status' => false,
                'message' => 'Game id is null'
            ));
        }
        else
        {
            $all_prediction_price = $this
                ->AppGames_model
                ->all_prediction_price($game_id); //get all predictions current price
            $leaderboard_details = $this
                ->AppGames_model
                ->leaderboard_details($game_id); //get executed predictions,users and points data
            $all_users = $this
                ->AppGames_model
                ->all_users_details($game_id); //get users and points data
            $prediction_ids = array_column($all_prediction_price, 'id'); //separate all ids
            $prediction_price = array_column($all_prediction_price, 'current_price'); //separate current price
            $predictionData = array_combine($prediction_ids, $prediction_price); //assign current price to ids
            $leaderBoard = array();
            $user_points = '';
            $available_points = '';
            foreach ($all_users as $key => $value)
            {
                $predDataKey = array_search($value['user_id'], array_column($leaderboard_details, 'user_id'));
                if (!empty($predDataKey) || $predDataKey === 0)
                {
                    $leaderBoardPredData = $leaderboard_details[$predDataKey]; //get executed prediction data from leaderboard_details array
                    $prediction_id_set = $leaderBoardPredData['predictions']; //user's executed predictions
                    $prediction_id_array = explode(", ", $prediction_id_set); //executed predictions converted to array
                    $bonus_points_set = $leaderBoardPredData['bonus_points']; //user's bonus points
                    $bonus_points_array = explode(",", $bonus_points_set); //bonus points converted to array
                    $bonus_points_array = array_sum($bonus_points_array);
                    // $get_predictions= array_flip(array_intersect(array_flip($predictionData),$prediction_id_array)); //get current price of user's executed prediction from all predictions set
                    $get_predictions = array_intersect_key($predictionData, array_flip($prediction_id_array)); //get current price of user's executed prediction from all predictions set
                    $current_price_sum = array_sum($get_predictions); //sum of all prediction's current price
                    // print_r($current_price_sum);die;
                    $leaderboard_points = $bonus_points_array + $value['points'] + $current_price_sum; //calculation for leader board total points
                }
                else
                {
                    $leaderboard_points = $value['points'];
                }

                $leaderboard_points = number_format((float)$leaderboard_points, 2, '.', '');
                $leaderBoard[$key] = array(
                    'id' => $value['id'],
                    'user_id' => $value['user_id'],
                    'name' => $value['name'],
                    'image' => $value['image'],
                    'total_points' => $leaderboard_points
                ); //set final array for users one by one
                if ($user_id == $value['user_id'])
                {
                    $user_points = $leaderboard_points;
                    $available_points = $value['points'];
                }
            }
            $topics_quiz_list = $this
                ->AppCommon_model
                ->get_all_quiz(6, $topic_id, '', $user_id);
            $sidebar_games = $this
                ->AppCommon_model
                ->get_all_games(sidebar_card_limit() , $topic_id, 0);
            $sidebar_blogs = $this
                ->AppCommon_model
                ->get_all_blogs(sidebar_card_limit() , $topic_id, 0);
            if (!empty($leaderBoard))
            {
                $totalPoints = array_column($leaderBoard, 'total_points');
                array_multisort($totalPoints, SORT_DESC, $leaderBoard);
                // print_r($leaderBoard);die;
                $user_rank = array_search($user_id, array_column($leaderBoard, 'user_id'));
                $is_user_exist = in_array($user_id, array_column($leaderBoard, 'user_id'));
                if ($is_user_exist == true)
                {
                    $user_rank = $user_rank + 1;
                }
                else
                {
                    $user_rank = '0';
                }

                $data = array(
                    'status' => 'success',
                    'message' => '200',
                    'leaderboard_data' => $leaderBoard,
                    'user_points' => $user_points,
                    'available_points' => $available_points,
                    'user_rank' => $user_rank,
                    'topics_quiz_list' => $topics_quiz_list,
                    'sidebar_games' => $sidebar_games,
                    'sidebar_blogs' => $sidebar_blogs
                );
                sendjson(array(
                    'status' => true,
                    'message' => 'Leaderboard data',
                    "data" => $data
                ));
            }
            else
            {
                $data = array(
                    'topics_quiz_list' => $topics_quiz_list,
                    'sidebar_games' => $sidebar_games,
                    'sidebar_blogs' => $sidebar_blogs
                );
                sendjson(array(
                    'status' => true,
                    'message' => 'No records found',
                    'data' => $data
                ));
            }
        }
    }

    public function check_game_player_limit()
    {
        $authenicate = authenicate_access_token(getallheaders());
        if ($authenicate == '1')
        {
            $postData = $this
                ->input
                ->post();
            $game_id = $postData['game_id'];
            $user_id = $postData['user_id'];
            if (empty($game_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'Game id is null'
                ));
            }
            else if (empty($user_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'User id is null'
                ));
            }
            else
            {
                $max_players = $this
                    ->AppGames_model
                    ->get_max_players($game_id);
                $current_players = $this
                    ->games_model
                    ->current_players($game_id);
                if (!empty($current_players))
                {
                    $all_users = array_column($current_players, 'user_id');
                    $total_users = count($all_users);
                    if ($total_users >= $max_players['max_players'] && in_array($user_id, $all_users) == false)
                    {
                        sendjson(array(
                            'status' => true,
                            'message' => 'Maximum players limit of ' . $max_players['max_players'] . ' players for this game has been reached. Try out other games.',
                            'isLimitExceed' => true
                        ));
                    }
                    else
                    {
                        sendjson(array(
                            'status' => true,
                            'message' => 'User can enter into the game',
                            'isLimitExceed' => false
                        ));
                    }
                }
                else
                {
                    sendjson(array(
                        'status' => true,
                        'message' => 'User can enter into the game',
                        'isLimitExceed' => false
                    ));
                }
            }
        }
        else
        {
            sendjson($authenicate);
        }
    }

    function deduct_coins()
    {
        $authenicate = authenicate_access_token(getallheaders());
        if ($authenicate == '1')
        {
            $postData = $this
                ->input
                ->post();
            $game_id = $postData['game_id'];
            $user_id = $postData['user_id'];
            if (empty($game_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'Game id is null'
                ));
            }
            else if (empty($user_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'User id is null'
                ));
            }
            else
            {
                $user_coins = $this
                    ->AppGames_model
                    ->get_user_coins($user_id);
                $req_coins = $this
                    ->AppGames_model
                    ->require_coins($game_id);
                $check_user_points = $this
                    ->predictions_model
                    ->get_game_points($game_id, $user_id);
                if (!empty($check_user_points))
                {
                    sendjson(array(
                        'status' => true,
                        'message' => 'Coins have been already added to play this game'
                    ));
                }
                else
                {
                    if (!empty($user_coins))
                    {
                        if ($user_coins['coins'] < $req_coins['req_game_points'])
                        {
                            sendjson(array(
                                'status' => true,
                                'message' => 'You do not have enough coins in your wallet',
                                'action' => 'redirect to subscription screen'
                            ));
                        }
                        else
                        {
                            //assign initial game point to user when user enter in prediction
                            $game_details = $this
                                ->games_model
                                ->get_game_details($postData['game_id']);
                            $fixed_points = $game_details['initial_game_points'];
                            //$fixed_points = 1000;
                            $add_game_points = $this
                                ->AppGames_model
                                ->deduct_coins_to_add_points($req_coins['req_game_points'], $game_id, $user_id, $fixed_points);
                            if ($add_game_points == 'coins_query_failed')
                            {
                                sendjson(array(
                                    'status' => false,
                                    'message' => 'Coins deduction failed'
                                ));
                            }
                            elseif ($add_game_points == 'wallet_history_query_failed')
                            {
                                sendjson(array(
                                    'status' => false,
                                    'message' => 'Wallet history not inserted'
                                ));
                            }
                            elseif ($add_game_points == 'points_query_failed')
                            {
                                sendjson(array(
                                    'status' => false,
                                    'message' => 'Coins not inserted'
                                ));
                            }
                            elseif ($add_game_points == 'points_log_query_failed')
                            {
                                sendjson(array(
                                    'status' => false,
                                    'message' => 'Coins log not inserted'
                                ));
                            }
                            else
                            {
                                sendjson(array(
                                    'status' => true,
                                    'message' => 'Coins added',
                                    'popup_msg' => $fixed_points . ' Coins have been added to play this game'
                                ));
                            }
                        }
                    }
                    else
                    {
                        sendjson(array(
                            'status' => true,
                            'message' => 'You do not have enough coins in your wallet',
                            'action' => 'redirect to subscription screen'
                        ));
                    }
                }
            }
        }
        else
        {
            sendjson($authenicate);
        }
    }

    function summary()
    {
        $authenicate = authenicate_access_token(getallheaders());
        if ($authenicate == '1')
        {
            $postData = $this
                ->input
                ->post();
            $game_id = $postData['game_id'];
            $user_id = $postData['user_id'];
            $topic_id = $postData['topic_id'];
            if (empty($game_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'Game id is null'
                ));
            }
            else if (empty($user_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'User id is null'
                ));
            }
            else
            {
                $prediction_data = $this
                    ->AppPredictions_model
                    ->get_predictions_details($game_id, $user_id, 1);
                if (!empty($prediction_data))
                {
                    sendjson(array(
                        'status' => true,
                        'message' => 'Redirect to prediction screen'
                    ));
                }
                else
                {
                    $data['prediction_list'] = $this
                        ->AppGames_model
                        ->get_executed_predictions($game_id, $user_id);
                    $change_prediction_time = $this
                        ->games_model
                        ->get_game_details($game_id);
                    $data['change_prediction_time'] = $change_prediction_time['change_prediction_time'];
                    if (empty($data['prediction_list']) || empty($user_id))
                    {
                        sendjson(array(
                            'status' => true,
                            'message' => 'Redirect to prediction screen'
                        ));
                    }
                    $available_points = $this
                        ->predictions_model
                        ->get_game_points($game_id, $user_id);
                    $data['available_points'] = $available_points['points'];
                    $data['game_details'] = $this
                        ->AppGames_model
                        ->game_details($game_id);
                    $data['portfolio_data'] = get_user_portfolio($game_id, $user_id);
                    $data['topics_quiz_list'] = $this
                        ->AppCommon_model
                        ->get_all_quiz(6, $topic_id, '', $user_id);
                    $data['sidebar_games'] = $this
                        ->AppCommon_model
                        ->get_all_games(sidebar_card_limit() , $topic_id, 0);
                    $data['sidebar_blogs'] = $this
                        ->AppCommon_model
                        ->get_all_blogs(sidebar_card_limit() , $topic_id, 0);
                    sendjson(array(
                        'status' => true,
                        'message' => 'Summary data',
                        'data' => $data
                    ));
                }
            }
        }
        else
        {
            sendjson($authenicate);
        }
    }

    /* public function get_average_portfolio(){
        $postData = $this->input->post();
        $user_id = $postData['user_id'];
        if(empty($user_id)){
            sendjson(array('status'=>FALSE,'message'=>'User id is null'));
        }else{
            $userwise_game_ids = $this->games_model->get_userwise_gameids($user_id);  //get all game ids which user has played
            $categorywise_rank = array();
            if (!empty($userwise_game_ids)) {
                $game_ids = array_column($userwise_game_ids, 'game_id');
                $topic_ids_set = $this->games_model->get_topic_ids($game_ids);      //get topic ids of games
                $topic_ids = array_column($topic_ids_set, 'topic_id');
                $game_category_data = $this->games_model->get_category_data($topic_ids);    //get category data of topic ids
                $categories = array();
                foreach ($topic_ids_set as $key => $value) {
                    $array_position = array_search($value['topic_id'], array_column($game_category_data, 'id'));
                    $category_data = $game_category_data[$array_position];
                    $user_rank_details = $this->get_user_rank($user_id,$value['id']);   //get user's rank for game
                    $categories[$category_data['name']][] = $user_rank_details;
                }
                if (!empty($categories)) {
                    foreach ($categories as $category_key => $category) {
                        $categorywise_rank[] = array('category_name' => $category_key,
                                                    'rank_count' => count($category),
                                                    'rank_sum' => array_sum($category));
                    }
                }
            }
            $data['categorywise_rank'] = $categorywise_rank;
            sendjson(array('status'=>TRUE,'message'=>'Average rank portfolio','data'=> $data));
        } 
    }
    
    private function get_user_rank($user_id, $game_id){
        $all_prediction_price = $this->games_model->all_prediction_price($game_id);   //get all predictions current price
        $leaderboard_details = $this->games_model->leaderboard_details($game_id);     //get executed predictions,users and points data
        $all_users = $this->games_model->all_users_details($game_id);                //get users and points data
        $prediction_ids = array_column($all_prediction_price, 'id');                   //separate all ids
        $prediction_price = array_column($all_prediction_price, 'current_price');      //separate current price
        $predictionData = array_combine($prediction_ids, $prediction_price);           //assign current price to ids
        $leaderBoard = array();
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
              $leaderBoard[$key] = array('id' => $value['id'],'user_id' => $value['user_id'],'total_points' => $leaderboard_points);                                                              //set final array for users one by one
        }
        if (!empty($leaderBoard)) {
            $totalPoints = array_column($leaderBoard, 'total_points');
            array_multisort($totalPoints, SORT_DESC, $leaderBoard);
            // print_r($leaderBoard);die;
            $user_rank =  array_search($user_id, array_column($leaderBoard, 'user_id'));
            $is_user_exist = in_array($user_id, array_column($leaderBoard, 'user_id')); 
            if ($is_user_exist==true) {
              $user_rank = $user_rank + 1;
            }else{
              $user_rank = '0';
            }
            return $user_rank;
        }else{
            return '0';
        }
    }
    */
    public function get_average_portfolio(){
		$user_id = $this->input->post('user_id');
		$userwise_game_ids = $this->games_model->get_userwise_last_ninetyday_gameids($user_id);  //get all game ids which user has played
		// print_r($userwise_game_ids);die;
		// echo $this->db->last_query();
		// print_r($userwise_game_ids);die;
		$categorywise_rank = array();
		if (!empty($userwise_game_ids)) {
			$game_ids = array_column($userwise_game_ids, 'game_id');
			$topic_ids_set = $this->games_model->get_topic_ids($game_ids);		//get topic ids of games
			// print_r($topic_ids_set);die;
			$topic_ids = array_column($topic_ids_set, 'topic_id');
			// $topic_idsArray = array_map('trim', explode(',', $topic_ids));
			$game_category_data = $this->games_model->get_category_data($topic_ids);	//get category data of topic ids
			$categories = array();
			$sumArray=array();
			$topicArray=[];
			// print_r($topic_ids);die;
			
			foreach ($topic_ids_set as $key => $value) {
				// echo $value['topic_id'];
				// print_r($topicArray);
				$array_position = array_search($value['topic_id'], array_column($game_category_data, 'id'));
				$category_data = $game_category_data[$array_position];
				// echo implode(',',$games_ids_set['gamesId']);
				// $user_ex_prediction_details = $this->get_ex_prediction_details($user_id,$value['id']); 	//get user's prediction data
				if(!in_array($value['topic_id'],$topicArray)){
					// $i++;
					$games_ids_set = $this->games_model->get_games_ids($value['topic_id'],$user_id);		//get games ids of topic
					$gamesArray = array_map('trim', explode(',', $games_ids_set));
					$user_ex_prediction_details = $this->get_ex_prediction_details($user_id,$gamesArray); 	//get user's prediction data
					array_push($topicArray,$value['topic_id']);
					// print_r($gamessArray);
					$categories[$category_data['name']][] = $user_ex_prediction_details;
				}
			}
			// echo $i;
			// print_r($categories);
			// die;

			if (!empty($categories)) {
				$category_count=array();
				foreach ($categories as $category_key => $category) {
						$arrCount=array();
					if (in_array('NA', $category)) {
						$arrCount = count($category);				//returns count of array elements
						$catArr = array();
						foreach ($category as $key => $value) {
							if ($value=='NA') {
								$catArr[] = $value;					//returns all 'NA' arrays
							}
						}
						$catArrCount = count($catArr);				//returns count of NA
						if ($arrCount == $catArrCount) {
							$totalSumArr = 'NA';	
						}else{
							$totalSumArr = array_sum($category);	
						}
					}else{
						$arrCount = count($category);				//returns count of array elements
						$totalSumArr = array_sum($category);
                    }
                    
                    if (is_numeric($totalSumArr))
                        {
                            $pre_data = $totalSumArr/$arrCount;
                            $prediction_data=number_format($pre_data, 2, '.', '');
                        }else{
                            $prediction_data = $totalSumArr;
                        }

					
                    $res_data=array('category_name' => $category_key,
                                    // 'prediction_data_count'=>$arrCount,
					    		    'prediction_data' => $prediction_data);
					$categorywise_rank[] = $res_data;
					}
			}
		}
		// print_r($categorywise_rank);die;
		// die;
		$data = $categorywise_rank;
            // print_r($data);die;
                        sendjson(array(
                            'status' => true,
                            'message' => 'Average prediction portfolio',
                            'data' => $data,
                        ));
    }
    
    private	function get_ex_prediction_details($user_id,$game_id){
		// echo $game_id;
		$total_executed_predictions=$this->games_model->get_total_executed_predictions($user_id,$game_id);
		$total_ex_predictions_correct=$this->games_model->get_total_executed_predictions_correct($user_id,$game_id);
        // print_r($total_ex_predictions_correct);
        // echo $this->db->last_query();
        // echo "<pre>";
		
		if($total_ex_predictions_correct['count_right']=='0' && $total_executed_predictions!='0'){
			$final="0";
		}else if($total_ex_predictions_correct['count_right'] != '0'){
			/* echo "<pre>";			
            echo ($total_ex_predictions_correct['count_right']/$total_executed_predictions)*100;
            echo "</pre>"; */
			$final=($total_ex_predictions_correct['count_right']/$total_executed_predictions)*100;
			/* if($count=='0'){
				// echo "if";
				$final='NA';
			}else if($count !='0') {
				// echo "else if 1";
				$final=($count/$total_executed_predictions)*100;
						// echo ($count/$total_executed_predictions)*100;
					}else if($count_n=='1'&& $count !='0'){
						// echo "else if 2";
						$final="0";
					} */
		}else{
			$final='NA';
		}
		// $final;
		// echo "</br>";
		return  $final;
		//return array('total_prediction'=>$total_executed_predictions,'total_correct_pre'=>$total_ex_predictions_correct);
		// print_r($myArray);die;
		// $sumArray = array();


		// echo $this->db->last_query();
		// print_r($total_executed_predictions);die;

	}

    public function chanage_prediction_yesno()
    {
        $authenicate = authenicate_access_token(getallheaders());
        if ($authenicate == '1')
        {
            $postData = $this
                ->input
                ->post();
            $game_id = $postData['game_id'];
            $prediction_id = $postData['prediction_id'];
            $user_id = $postData['user_id'];
            $condition = $postData['condition'];
            $created_date = $postData['created_date'];
            if (empty($game_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'Game id is null'
                ));
            }
            else if (empty($prediction_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'Prediction id is null'
                ));
            }
            else if (empty($user_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'User id is null'
                ));
            }
            else
            {
                $res = $this
                    ->AppGames_model
                    ->check_predictions_avlib($prediction_id, $game_id);
                $res1 = $this
                    ->AppGames_model
                    ->check_game_point($user_id, $game_id);
                $change_prediction_time = $this
                    ->games_model
                    ->get_game_details($game_id);
                $prediction_time = $change_prediction_time['change_prediction_time'];
                $current_dateTime = date('Y-m-d H:i:s');
                $start_date = new DateTime($current_dateTime);
                $skip_pred_time = $start_date->diff(new DateTime($created_date));
                $minutes = $skip_pred_time->i;
                if ($prediction_time == 1)
                {
                    $time_msg = 'Wait until ' . $prediction_time . ' minute get over!';
                }
                else
                {
                    $time_msg = 'Wait until ' . $prediction_time . ' minutes get over!';
                }
                // echo $time_msg;die;
                // print_r($minutes);die;
                if (empty($change_prediction_time['is_published']) || $change_prediction_time['end_date'] < (date('Y-m-d H:i:s')) || $res['count_date'] != '0')
                {
                    sendjson(array(
                        'status' => true,
                        'code' => 403,
                        'message' => 'Sorry! This prediction has been ended or not available now'
                    ));
                }
                else if ($res1[0]['points'] == '0' && $condition == 'Yes')
                {
                    sendjson(array(
                        'status' => true,
                        'message' => 'Insufficient coins'
                    ));
                }
                else if ($minutes < $prediction_time)
                {
                    sendjson(array(
                        'status' => false,
                        'message' => $time_msg
                    ));
                    // print_r($data);die;
                    
                }
                else if ($condition == 'Yes' && $res1[0]['points'] != '0' && $res['count_date'] == '0')
                {

                    $data = $this
                        ->AppGames_model
                        ->summary_chanages_predictions($game_id, $prediction_id, $user_id, $condition);
                    if ($data == false)
                    {
                        sendjson(array(
                            'status' => true,
                            'message' => 'Insufficient coins'
                        ));
                    }
                    else
                    {
                        $data['change_prediction_time'] = $change_prediction_time['change_prediction_time'];
                        sendjson(array(
                            'status' => true,
                            'message' => 'Prediction changed to Yes',
                            'data' => $data
                        ));
                    }
                }
                else if ($condition == 'No' && $res['count_date'] == '0')
                {

                    $data = $this
                        ->AppGames_model
                        ->summary_chanages_predictions($game_id, $prediction_id, $user_id, $condition);
                    $data['change_prediction_time'] = $change_prediction_time['change_prediction_time'];
                    sendjson(array(
                        'status' => true,
                        'message' => 'Prediction changed to No',
                        'data' => $data
                    ));
                }
                else
                {
                    sendjson(array(
                        'status' => false,
                        'message' => 'Something went wrong'
                    ));
                }
            }
        }
        else
        {
            sendjson($authenicate);
        }
    }

    function rules_rewards()
    {
        $postData = $this
            ->input
            ->post();
        $game_id = $postData['game_id'];
        $user_id = $postData['user_id'];
        $topic_id = $postData['topic_id'];
        if (empty($game_id))
        {
            sendjson(array(
                'status' => false,
                'message' => 'Game id is null'
            ));
        }
        else
        {
            $available_points = $this
                ->predictions_model
                ->get_game_points($game_id, $user_id);
            $data['available_points'] = $available_points['points'];
            $data['portfolio_data'] = get_user_portfolio($game_id, $user_id);
            $data['game_details'] = $this
                ->AppGames_model
                ->game_details($game_id);
            $data['game_reward_details'] = $this
                ->AppGames_model
                ->get_game_reward_details($game_id);
            $data['topics_quiz_list'] = $this
                ->AppCommon_model
                ->get_all_quiz(6, $topic_id, '', $user_id);
            $data['sidebar_games'] = $this
                ->AppCommon_model
                ->get_all_games(sidebar_card_limit() , $topic_id, 0);
            $data['sidebar_blogs'] = $this
                ->AppCommon_model
                ->get_all_blogs(sidebar_card_limit() , $topic_id, 0);
            sendjson(array(
                'status' => true,
                'message' => 'Rules and Rewards',
                'data' => $data
            ));
        }
    }

    public function game_dashboard()
    {
        $authenicate = authenicate_access_token(getallheaders());
        if ($authenicate == '1')
        {
            $inputs = $this
                ->input
                ->post();
            // print_r($inputs);die;
            $user_id = $inputs['user_id'];
            $data = array();
            if (empty($user_id))
            {
                sendjson(array(
                    "status" => false,
                    "message" => "Please provide user id"
                ));
            }
            else if ($user_id > 0)
            {

                $data['game_dashboard'] = array();
                $game_ids = $this
                    ->games_dashboard_model
                    ->getGame_idList($user_id);
                // print_r($game_ids);die;
                $data['game_dashboard']['active_game_data'] = $this->game_dashboard_data($game_ids, 1, $user_id);
                $data['game_dashboard']['completed_game_data'] = $this->game_dashboard_data($game_ids, 0, $user_id);

                sendjson(array(
                    "status" => true,
                    "message" => "Game dashboarddata found.",
                    "data" => $data
                ));
            }
            else
            {

                sendjson(array(
                    "status" => false,
                    "message" => "Seems that you are not logged in"
                ));
            }
        }
        else
        {
            sendjson($authenicate);
        }
    }

    public function game_dashboard_data($game_ids, $game_status, $user_id)
    {
        $game_data = array();
        foreach ($game_ids as $key => $value)
        {
            $gamedata = $this
                ->games_dashboard_model
                ->game_dashboard_data($value['game_id'], $game_status);
            $rankdata = $this->portfolio_data($value['game_id'], $user_id);
            $predictionsdata = $this
                ->games_dashboard_model
                ->predictions_data($value['game_id'], $user_id);
            if (!empty($rankdata) && !empty($gamedata))
            {
                $game_data[] = array_merge($rankdata, $gamedata, $predictionsdata);
            }

        }
        return $game_data;
    }

    public function portfolio_data($game_id, $user_id)
    {

        $all_prediction_price = $this
            ->AppGames_model
            ->all_prediction_price($game_id); //get all predictions current price
        $leaderboard_details = $this
            ->AppGames_model
            ->leaderboard_details($game_id); //get executed predictions,users and points data
        $all_users = $this
            ->AppGames_model
            ->all_users_details($game_id); //get users and points data
        $prediction_ids = array_column($all_prediction_price, 'id'); //separate all ids
        $prediction_price = array_column($all_prediction_price, 'current_price'); //separate current price
        $predictionData = array_combine($prediction_ids, $prediction_price); //assign current price to ids
        $leaderBoard = array();
        $user_points = '';
        $available_points = '';
        // print_r($all_users);die;
        foreach ($all_users as $key => $value)
        {
            $predDataKey = array_search($value['user_id'], array_column($leaderboard_details, 'user_id'));
            if (!empty($predDataKey) || $predDataKey === 0)
            {
                $leaderBoardPredData = $leaderboard_details[$predDataKey]; //get executed prediction data from leaderboard_details array
                $prediction_id_set = $leaderBoardPredData['predictions']; //user's executed predictions
                $prediction_id_array = explode(", ", $prediction_id_set); //executed predictions converted to array
                $bonus_points_set = $leaderBoardPredData['bonus_points']; //user's bonus points
                $bonus_points_array = explode(",", $bonus_points_set); //bonus points converted to array
                $bonus_points_array = array_sum($bonus_points_array);
                $get_predictions = array_intersect_key($predictionData, array_flip($prediction_id_array)); //get current price of user's executed prediction from all predictions set
                $current_price_sum = array_sum($get_predictions); //sum of all prediction's current price
                // print_r($current_price_sum);die;
                $leaderboard_points = $bonus_points_array + $value['points'] + $current_price_sum; //calculation for leader board total points
                
            }
            else
            {
                $leaderboard_points = $value['points'];
            }
            $leaderboard_points = number_format((float)$leaderboard_points, 2, '.', '');
            // $leaderboard_points =  round($leaderboard_points);
            $leaderBoard[$key] = array(
                'id' => $value['id'],
                'user_id' => $value['user_id'],
                'total_points' => $leaderboard_points
            );
            //   print_r($leaderBoard);die;                                                         //set final array for users one by one
            if ($user_id == $value['user_id'])
            {
                $user_points = round($leaderboard_points);
                $available_points = round($value['points']);
            }
        }
        if (!empty($leaderBoard))
        {
            $totalPoints = array_column($leaderBoard, 'total_points');
            array_multisort($totalPoints, SORT_DESC, $leaderBoard);
            // print_r($leaderBoard);die;
            $user_rank = array_search($user_id, array_column($leaderBoard, 'user_id'));
            $is_user_exist = in_array($user_id, array_column($leaderBoard, 'user_id'));
            if ($is_user_exist == true)
            {
                $user_rank = $user_rank + 1;
            }
            else
            {
                $user_rank = '0';
            }
            return $data = array(
                'portfolio_points' => $user_points,
                'available_points' => $available_points,
                'user_rank' => $user_rank
            );
        }
    }

    /*public function check_user_points()
    {
        $authenicate = authenicate_access_token(getallheaders());
        if ($authenicate == '1')
        {
            $postData = $this
                ->input
                ->post();
            $game_id = $postData['game_id'];
            $user_id = $postData['user_id'];
            if (empty($game_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'Game id is null'
                ));
            }
            else if (empty($user_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'User id is null'
                ));
            }
            else
            {
                $user_game_points = $this
                    ->AppPredictions_model
                    ->get_game_points($game_id, $user_id);
                if (empty($user_game_points['points']))
                {
                    sendjson(array(
                        'status' => true,
                        'message' => 'Game points require',
                        'popup_msg' => 'Entry Fee: ' . $user_game_points['req_game_points'] . ' Coins. Do you want to continue?'
                    ));
                }
                else
                {
                    sendjson(array(
                        'status' => true,
                        'message' => 'Game points exist'
                    ));
                }
            }
        }
        else
        {
            sendjson($authenicate);
        }
    }*/
    public function check_user_points()
    {
        $authenicate = authenicate_access_token(getallheaders());
        if ($authenicate == '1')
        {
            $postData = $this->input->post();
            $game_id = $postData['game_id'];
            $user_id = $postData['user_id'];
            if (empty($game_id))
            {
                sendjson(array(
                    'status' => false,
                    'code' => 417,
                    'message' => 'Game id is null'
                ));
            }
            else if (empty($user_id))
            {
                sendjson(array(
                    'status' => false,
                    'code' => 417,
                    'message' => 'User id is null'
                ));
            }
            else
            {
                $user_game_points = $this
                    ->AppPredictions_model
                    ->get_game_points($game_id, $user_id);
                if (empty($user_game_points['points']))
                { 
                    $user_coins = $this
                        ->AppGames_model
                        ->get_user_coins($user_id);
                    $req_coins = $this
                        ->AppGames_model
                        ->require_coins($game_id);
                    if (!empty($user_coins))
                    {
                        if ($user_coins['coins'] < $req_coins['req_game_points'])
                        {
                            sendjson(array(
                                'status' => false,
                                'code' => 404,
                                'message' => 'Insufficient coins',
                                'action' => 'redirect to subscription screen'
                            ));
                        }
                        else
                        {
                            //assign initial game point to user when user enter in prediction
                            $game_details = $this
                                ->games_model
                                ->get_game_details($postData['game_id']);
                            $fixed_points = $game_details['initial_game_points'];
                            //$fixed_points = 1000;
                            $add_game_points = $this
                                ->AppGames_model
                                ->deduct_coins_to_add_points($req_coins['req_game_points'], $game_id, $user_id, $fixed_points);
                            if ($add_game_points == 'coins_query_failed')
                            {
                                sendjson(array(
                                    'status' => false,
                                    'code' => 501,
                                    'message' => 'Coins deduction failed'
                                ));
                            }
                            elseif ($add_game_points == 'wallet_history_query_failed')
                            {
                                sendjson(array(
                                    'status' => false,
                                    'code' => 501,
                                    'message' => 'Wallet history not inserted'
                                ));
                            }
                            elseif ($add_game_points == 'points_query_failed')
                            {
                                sendjson(array(
                                    'status' => false,
                                    'code' => 501,
                                    'message' => 'Coins not inserted'
                                ));
                            }
                            elseif ($add_game_points == 'points_log_query_failed')
                            {
                                sendjson(array(
                                    'status' => false,
                                    'code' => 501,
                                    'message' => 'Coins log not inserted'
                                ));
                            }
                            else
                            {
                                sendjson(array(
                                    'status' => true,
                                    'code' => 200,
                                    'message' => 'Coins added'
                                ));
                            }
                        }
                    }
                    else
                    {
                        sendjson(array(
                            'status' => false,
                            'code' => 404,
                            'message' => 'Insufficient coins',
                            'action' => 'redirect to subscription screen'
                        ));
                    }
                }
                else
                {
                    sendjson(array(
                        'status' => true,
                        'code' => 200,
                        'message' => 'Game coins exist'
                    ));
                }
            }
        }
        else
        {
            sendjson($authenicate);
        }
    }

    public function refresh_portfolio()
    {
        $authenicate = authenicate_access_token(getallheaders());
        if ($authenicate == '1')
        {
            $postData = $this
                ->input
                ->post();
            $game_id = $postData['game_id'];
            $user_id = $postData['user_id'];
            if (empty($game_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'Game id is null'
                ));
            }
            else if (empty($user_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'User id is null'
                ));
            }
            else
            {
                $gameEndDate = $this
                    ->AppGames_model
                    ->getGameEndDate($game_id); //For API only
                $all_prediction_price = $this
                    ->games_model
                    ->all_prediction_price($game_id); //get all predictions current price
                $leaderboard_details = $this
                    ->games_model
                    ->leaderboard_details($game_id); //get executed predictions,users and points data
                $all_users = $this
                    ->games_model
                    ->all_users_details($game_id); //get users and points data
                $prediction_ids = array_column($all_prediction_price, 'id'); //separate all ids
                $prediction_price = array_column($all_prediction_price, 'current_price'); //separate current price
                $predictionData = array_combine($prediction_ids, $prediction_price); //assign current price to ids
                $leaderBoard = array();
                $user_portfolio_points = '';
                $user_available_points = '';
                foreach ($all_users as $key => $value)
                {
                    $predDataKey = array_search($value['user_id'], array_column($leaderboard_details, 'user_id'));
                    if (!empty($predDataKey) || $predDataKey === 0)
                    {
                        $leaderBoardPredData = $leaderboard_details[$predDataKey]; //get executed prediction data from leaderboard_details array
                        $prediction_id_set = $leaderBoardPredData['predictions']; //user's executed predictions
                        $prediction_id_array = explode(", ", $prediction_id_set); //executed predictions converted to array
                        $bonus_points_set = $leaderBoardPredData['bonus_points']; //user's bonus points
                        $bonus_points_array = explode(",", $bonus_points_set); //bonus points converted to array
                        $bonus_points_array = array_sum($bonus_points_array);
                        // $get_predictions= array_flip(array_intersect(array_flip($predictionData),$prediction_id_array));	//get current price of user's executed prediction from all predictions set
                        $get_predictions = array_intersect_key($predictionData, array_flip($prediction_id_array)); //get current price of user's executed prediction from all predictions set
                        $current_price_sum = array_sum($get_predictions); //sum of all prediction's current price
                        // print_r($current_price_sum);die;
                        $leaderboard_points = $bonus_points_array + $value['points'] + $current_price_sum; //calculation for leader board total points
                        
                    }
                    else
                    {
                        $leaderboard_points = $value['points'];
                    }
                    // $leaderboard_points =  number_format((float)$leaderboard_points, 2, '.', '');
                    $leaderBoard[$key] = array(
                        'id' => $value['id'],
                        'user_id' => $value['user_id'],
                        'total_points' => $leaderboard_points
                    ); //set final array for users one by one
                    if ($user_id == $value['user_id'])
                    {
                        $user_portfolio_points = round($leaderboard_points);
                        $user_available_points = round($value['points']);
                    }
                }

                if (!empty($leaderBoard))
                {
                    $totalPoints = array_column($leaderBoard, 'total_points');
                    array_multisort($totalPoints, SORT_DESC, $leaderBoard);

                    $user_rank = array_search($user_id, array_column($leaderBoard, 'user_id'));
                    $is_user_exist = in_array($user_id, array_column($leaderBoard, 'user_id'));
                    if ($is_user_exist == true)
                    {
                        $user_rank = $user_rank + 1;
                    }
                    else
                    {
                        $user_rank = '0';
                    }

                    $data = array(
                        'user_rank' => $user_rank,
                        'user_portfolio_points' => $user_portfolio_points,
                        'user_available_points' => $user_available_points,
                        'gameEndDate' => $gameEndDate
                    );
                    sendjson(array(
                        "status" => true,
                        "message" => "Portfolio data found",
                        "data" => $data
                    ));
                }
                else
                {
                    sendjson(array(
                        'status' => false,
                        'message' => 'Empty records'
                    ));
                }
            }
        }
        else
        {
            sendjson($authenicate);
        }
    }

    function get_predictions_points()
    {
        $postData = $this
            ->input
            ->post();
        $predition_id = $postData['prediction_id'];
        if (empty($predition_id))
        {
            sendjson(array(
                'status' => false,
                'message' => 'Prediction id is null'
            ));
        }
        else
        {
            $prediction_data = $this
                ->predictions_model
                ->get_prediction_data($postData['prediction_id']);
            if (empty($prediction_data))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'Prediction price not found'
                ));
            }
            else
            {
                $data = array(
                    'prediction_price' => round($prediction_data['current_price'])
                );
                sendjson(array(
                    "status" => true,
                    "message" => "Prediction price found",
                    "data" => $data
                ));
            }
        }
    }

    public function coins_coversion_details()
    {
        $authenicate = authenicate_access_token(getallheaders());
        if ($authenicate == '1')
        {
            $postData = $this
                ->input
                ->post();
            $game_id = $postData['game_id'];
            $user_id = $postData['user_id'];
            if (empty($game_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'Game id is null'
                ));
            }
            else if (empty($user_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'User id is null'
                ));
            }
            else
            {
                $data = $this
                    ->AppPredictions_model
                    ->get_coin_conversion_details($game_id);
                $data['user_coins'] = $this
                    ->AppPredictions_model
                    ->getUserCoins($user_id);
                sendjson(array(
                    "status" => true,
                    "message" => "Coins coversion details found",
                    "data" => $data
                ));
            }
        }
        else
        {
            sendjson($authenicate);
        }
    }
    public function convert_coins_into_points()
    {
        $authenicate = authenicate_access_token(getallheaders());
        if ($authenicate == '1')
        {
            $postData = $this
                ->input
                ->post();
            $game_id = $postData['game_id'];
            $user_id = $postData['user_id'];
            if (empty($game_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'Game id is null'
                ));
            }
            else if (empty($user_id))
            {
                sendjson(array(
                    'status' => false,
                    'message' => 'User id is null'
                ));
            }
            else
            {
                $data = $this
                    ->AppPredictions_model
                    ->get_coin_conversion_details($postData['game_id']);
                $converted_points_entry = $this
                    ->games_model
                    ->check_converted_points_entry($postData['user_id'], $postData['game_id']);
                $user_coins = $this
                    ->AppPredictions_model
                    ->getUserCoins($postData['user_id']);
                // print_r($data);die;
                /* if (is_numeric($postData['coins_convert'])==false) {
                        sendjson(array('status'=>FALSE,'message'=>'Coins field must contain numbers only'));
                    }else */
                if ($postData['coins_convert'] > $user_coins['coins'])
                {
                    sendjson(array(
                        'status' => false,
                        'message' => 'You do not have enough coins in your wallet'
                    ));
                }
                else if ($postData['coins_convert'] > $data['coin_transfer_limit'])
                {
                    sendjson(array(
                        'status' => false,
                        'message' => 'Max coins transfer limit exceeds'
                    ));
                }
                else if (!empty($converted_points_entry))
                {
                    sendjson(array(
                        'status' => false,
                        'message' => 'You have exceeded your attempts'
                    ));
                }
                else
                {
                    $conversion_data = array(
                        'game_id' => $postData['game_id'],
                        'user_id' => $postData['user_id'],
                        'coins' => $postData['coins_convert'],
                        'point_value_per_coin' => $data['point_value_per_coin'],
                        'points' => $postData['coins_convert'] * $data['point_value_per_coin']
                    );
                    $convert_coins = $this
                        ->games_model
                        ->convert_coins_to_points($conversion_data);
                    if ($convert_coins === true)
                    {
                        sendjson(array(
                            'status' => true,
                            'message' => 'Coins added successfully'
                        ));
                    }
                    else
                    {
                        sendjson(array(
                            'status' => false,
                            'message' => 'Something went wrong'
                        ));
                    }
                }
            }

        }
        else
        {
            sendjson($authenicate);
        }
    }

}
