<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Predictions extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('games_model', 'predictions_model'));
        $this->load->helper(array('prediction_helper','games_helper'));
        $this->load->model('Common_model');

        $sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
    }

    public function prediction_game($game_id = '') {
        $postData = $this->input->post();
        if (empty($game_id)) {
            redirect('Home');
        }
        $predictionId = $this->uri->segment(4);
        $data['game_id'] = $game_id;
        $data['game_details'] = $this->games_model->get_game_details($game_id);
        $data['available_points'] = $this->predictions_model->get_game_points($game_id, $this->user_id);
        $data['portfolio_data'] = get_user_portfolio($game_id,$this->user_id);
        // $data['prediction_details'] = $this->predictions_model->get_predictions_details($game_id);
        $allpredictionDetails = $this->predictions_model->get_predictions_details($game_id);
        if (!empty($predictionId)) {          //to get shared prediction on top
            $prediction_key = array_search($predictionId, array_column($allpredictionDetails, 'id'));
            $is_key_exist = in_array($predictionId, array_column($allpredictionDetails, 'id'));
            if ($is_key_exist == true) {
              $pred_array = $allpredictionDetails[$prediction_key];
              unset($allpredictionDetails[$prediction_key]);
              array_unshift($allpredictionDetails,$pred_array);    //to get prediction at 1st positionin array
              $data['meta_data'] = $pred_array;
            }
        }else{
          // get game meta data
          $data['meta_data'] = $data['game_details'];
        }
        if (!empty($allpredictionDetails)) {
          if (count($allpredictionDetails) > 3) {
            $allpredictionDetails = array_slice($allpredictionDetails,0,3);     //get first 3 records from all predictions
          }
        }
        $data['prediction_details'] = $allpredictionDetails;

        $is_game_summary_exist = $this->predictions_model->check_summary_count($game_id);

        if (empty($data['prediction_details']) && $is_game_summary_exist == true) {
            redirect('Predictions/summary/' . $game_id);
        }
        $data['current_datetime'] = date("Y-m-d H:i:s");
        $data['sidebar_games'] = $this->predictions_model->get_games($game_id,$data['game_details']['topic_id']);
        $data['play_game_cookie'] = get_cookie('game_'.$game_id.'_play');
        // print($data['play_game_cookie']);die;
        // delete_cookie('game_'.$game_id.'_play');die;

        $data['view_name'] = 'game_tab';
        $this->load->view('header',$data);
        $this->load->view('main_game', $data);
//        $this->load->view('predictions', $data);
        $this->load->view('footer');
    }


  function prediction_action() {
        $postData = $this->input->post();
        $play_game_cookie = get_cookie('game_'.$postData['game_id'].'_play');
        if (empty($this->user_id) || (!empty($this->user_id) && empty($play_game_cookie))) {
            // $data['action'] = 'redirect_to_login';
            $data = $this->view_the_game($postData);            //process for users who just want to view the game
        }else{
          $current_prediction_data = '';
          $limit = 1;
          $offset = 2;
          // print_r($postData);die;return; 
          $user_game_points = $this->predictions_model->get_game_points($postData['game_id'],$this->user_id);
          if (empty($user_game_points)) {
            $data['game_points_require'] = 'yes';
            echo json_encode($data);return;
          }
          $game_points = $user_game_points['points'];
          $current_datetime = date("Y-m-d H:i:s");
          if (!empty($postData['current_prediction_id'])) {
            $current_prediction_data = $this->predictions_model->get_prediction_data($postData['current_prediction_id']);
            // $current_prediction_price = get_current_price($current_prediction_data,$current_datetime);   //price of visible prediction
            $current_prediction_price = $current_prediction_data['current_price'];  //price of visible prediction
          }
          if (!empty($postData['next_prediction_id'])) {
            $next_prediction_data = $this->predictions_model->get_prediction_data($postData['next_prediction_id']);
            // $next_prediction_price = get_current_price($next_prediction_data,$current_datetime);   //price of second (next to visible) prediction
            $next_prediction_price = $next_prediction_data['current_price'];    //price of second (next to visible) prediction
          }

          if ($current_prediction_data==false || empty($current_prediction_data)) {
            $data = array('status' => 'failure','message' => 'Prediction not found','errorShow'=>'console','reload'=>'no');
          }else if($game_points < $current_prediction_price && $postData['swipe_type']=='right') {
              $data = array('status' => 'failure','message' => 'Insufficient game points','errorShow'=>'modal','reload'=>'no');
          }else if($current_datetime > $current_prediction_data['fpt_end_datetime'] && $current_prediction_data['agreed'] == '0' && $current_prediction_data['disagreed'] == '0'){
              $data = array('status' => 'failure','message' => 'Prediction no longer exists','errorShow'=>'console','reload'=>'yes');
          }else{
              if ($current_prediction_price >= '0' && $current_prediction_price < '1') {
                  $current_prediction_price = '1';
              }else if($current_prediction_price > '100'){
                  $current_prediction_price = '100';
              }

              $postData = $postData + array('current_prediction_price' => $current_prediction_price,'user_id' => $this->user_id);

              $insert_execution = $this->predictions_model->insert_prediction_data($postData);
              if ($postData['swipe_type']=='right') {
                $update_game_points = $this->predictions_model->update_game_points($postData);
              }else{
                $update_game_points = true;
              }

              if ($insert_execution==true && $update_game_points==true) {
                $available_points = '';
                if ($postData['swipe_type']=='right') {
                  $available_points = $game_points - $current_prediction_price;
                  $available_points = number_format((float)$available_points, 2, '.', '');
                }
                if (empty($postData['next_prediction_id'])) {
                  $data = array('status' => 'success', 'message' => '200', 'available_points' => $available_points);
                }else{                  
                  $fpt_end_datetime = $next_prediction_data['fpt_end_datetime'];
                  $data = array('status' => 'success',
                          'message' => '200',
                          // 'fpt_end_datetime' => date('D M d Y H:i:s', strtotime($fpt_end_datetime)),
                          'fpt_end_datetime' => $fpt_end_datetime,
                          'prediction_end_date' => date('d M Y', strtotime($next_prediction_data['end_date'])),
                          'current_price' => round($next_prediction_price),
                          'available_points' => $available_points
                        );
                }

              $result_load_prediction = $this->predictions_model->get_predictions_details($postData['game_id'],$limit,$offset);
              // print_r($result_load_prediction);die;
              $load_prediction_data = array('load_prediction_data' => $result_load_prediction);
                if (!empty($result_load_prediction)) {
                  $data = array_merge($data, $load_prediction_data);    //merging next prediction's data that to be loaded.
                }
              }else{
                  $data = array('status' => 'failure','message' => 'prediction not inserted or game points not updated','errorShow' => 'console');
              }
          }
          $action = array('action' => 'play_the_game');
          $data = array_merge($data, $action);
      }
      echo json_encode($data);
  }

    function get_predictions_data() {
        // $current_datetime = date("Y-m-d H:i:s");
        $postData = $this->input->post();
        $prediction_data = $this->predictions_model->get_prediction_data($postData['prediction_id']);
        if ($prediction_data == false) {
            $data['status'] = 'Prediction id is null';
        } else {
            if ($postData['type'] == 'price') {
                // $current_price = get_current_price($prediction_data,$current_datetime);  // show current_price from cron updated table
                $current_price = $prediction_data['current_price'];
                $data = array('prediction_price' => round($current_price), 'status' => 'success');
            } else {
                $data = array('fpt_end_datetime' => $prediction_data['fpt_end_datetime'], 'end_date' => $prediction_data['end_date'], 'status' => 'success');
            }
        }

        echo json_encode($data);
    }

    /* function quiz() {
      $this->load->view('header');
      $this->load->view('quiz');
      $this->load->view('footer');
      }

      function swipe() {
      $this->load->view('header');
      $this->load->view('index');
      $this->load->view('footer');
      }

      function rank() {
      $this->load->view('header');
      $this->load->view('rank');
      $this->load->view('footer');
      }
      function pred() {
      $this->load->view('header');
      $this->load->view('predictions');
      $this->load->view('footer');
      } */

    function voice() {
        $this->load->view('header');
        $this->load->view('yourvoice');
        $this->load->view('footer');
    }

    function prediction_list() {
        $this->load->view('header');
        $this->load->view('prediction_list');
        $this->load->view('footer');
    }

    function home() {
        $this->load->view('header');
        $this->load->view('home');
        $this->load->view('footer');
    }

    function all_games() {
        $offset = $_POST['offset'];
        $game_id = $_POST['game_id'];
        $topic_id = $_POST['topicid'];
        $result = $this->predictions_model->get_games($game_id,$topic_id,$offset);
        echo json_encode($result);
    }

    function deduct_coins() {
        $postData = $this->input->post();
        $user_coins = $this->predictions_model->getUserCoins();
        if (!empty($user_coins)) {
            if ($user_coins['coins'] < $postData['req_game_points']) {
                $data = array('status' => 'failure', 'message' => 'You do not have enough coins in your wallet','type' => 'not_enough_coins');
            } else {
                $fixed_points = 1000;
                $add_game_points = $this->predictions_model->deduct_coins_to_add_points($postData['req_game_points'], $postData['game_id'], $fixed_points);
                if ($add_game_points == 'coins_query_failed') {
                    $data = array('status' => 'failure', 'message' => 'Coins deduction failed','type' => 'query_issue');
                } elseif ($add_game_points == 'wallet_history_query_failed') {
                    $data = array('status' => 'failure', 'message' => 'Wallet history not inserted','type' => 'query_issue');
                } elseif ($add_game_points == 'points_query_failed') {
                    $data = array('status' => 'failure', 'message' => 'Points not inserted','type' => 'query_issue');
                } elseif ($add_game_points == 'points_log_query_failed') {
                    $data = array('status' => 'failure', 'message' => 'Points log not inserted','type' => 'query_issue');
                } else {
                    $data = array('status' => 'success', 'message' => $fixed_points . ' points have been added to play this game');
                }
            }
        } else {
            $data = array('status' => 'failure', 'message' => 'You do not have enough coins in your wallet', 'type' => 'not_enough_coins');
        }

        echo json_encode($data);
    }

    function game_reward() {
        $game_id = $_POST['game_id'];
        $result = $this->games_model->get_game_reward_details($game_id);
        echo json_encode($result);
    }

    function leaderboard($game_id = '') {
        // $postData = $this->input->post();
        if (empty($game_id)) {
            redirect('Home');
        }
        $data['game_id'] = $game_id;
        // $data['meta_data'] = $this->Common_model->get_meta_tags($game_id);
        $data['game_details'] = $this->games_model->get_game_details($game_id);
        $data['meta_data'] = $data['game_details'];
        $data['available_points'] = $this->predictions_model->get_game_points($game_id, $this->user_id);
        $data['portfolio_data'] = get_user_portfolio($game_id,$this->user_id);
        // $data['prediction_details'] = $this->predictions_model->get_predictions_details($game_id);
        // $is_game_summary_exist = $this->predictions_model->check_summary_count($game_id);
        // $data['current_datetime'] = date("Y-m-d H:i:s");
        $data['sidebar_games'] = $this->predictions_model->get_games($game_id,$data['game_details']['topic_id']);
        /* if (empty($data['prediction_details']) && $is_game_summary_exist == true) {
          redirect('Games/summary/' . $game_id);
          } */
        $data['view_name'] = 'rank_tab';
        $this->load->view('header',$data);
        $this->load->view('main_game', $data);
//        $this->load->view('predictions', $data);
        $this->load->view('footer');
    }

    function summary($game_id = '') {
        if (empty($game_id)) {
            redirect('Home');
        }
        $data['game_id'] = $game_id;
        $prediction_data = $this->predictions_model->get_predictions_details($game_id, 1);
        if (!empty($prediction_data)) {
            redirect('Predictions/prediction_game/' . $game_id);
        }
        $data['game_details'] = $this->games_model->get_game_details($game_id);
        $data['meta_data'] = $data['game_details'];
        $data['prediction_list'] = $this->games_model->get_executed_predictions($game_id);
        if (empty($data['prediction_list']) || empty($this->user_id)) {
          redirect('Predictions/prediction_game/' . $game_id);
        }
        $data['available_points'] = $this->predictions_model->get_game_points($game_id, $this->user_id);
        $data['portfolio_data'] = get_user_portfolio($game_id,$this->user_id);
        $data['sidebar_games'] = $this->predictions_model->get_games($game_id,$data['game_details']['topic_id']);
        $data['view_name'] = 'summary_tab';
        $this->load->view('header',$data);
        $this->load->view('main_game', $data);
//        $this->load->view('predictions', $data);
        $this->load->view('footer');
    }

    function rules_rewards($game_id = '') {
        $postData = $this->input->post();
        if (empty($game_id)) {
            redirect('Home');
        }
        $data['game_id'] = $game_id;
        // $data['meta_data'] = $this->Common_model->get_meta_tags($game_id);
        $data['game_details'] = $this->games_model->get_game_details($game_id);
        $data['meta_data']=$data['game_details'];
        $data['available_points'] = $this->predictions_model->get_game_points($game_id, $this->user_id);
        $data['portfolio_data'] = get_user_portfolio($game_id,$this->user_id);
        // $data['prediction_details'] = $this->predictions_model->get_predictions_details($game_id);
        $is_game_summary_exist = $this->predictions_model->check_summary_count($game_id);
        $data['current_datetime'] = date("Y-m-d H:i:s");
        $data['sidebar_games'] = $this->predictions_model->get_games($game_id,$data['game_details']['topic_id']);
        /* if (empty($data['prediction_details']) && $is_game_summary_exist == true) {
          redirect('Games/summary/' . $game_id);
          } */
        $data['view_name'] = 'reward_tab';
        $this->load->view('header',$data);
        $this->load->view('main_game', $data);
//        $this->load->view('predictions', $data);
        $this->load->view('footer');
    }

    function set_rewards_cookie() {
      $game_id = $_POST['game_id'];
      $user_game_points = $this->predictions_model->get_game_points($game_id,$this->user_id);
      if (empty($user_game_points)) {
        $data['game_points_require'] = 'yes';
      }else{
        $data['game_points_require'] = 'no';
      }
          $rewards_cookie = array(
            'name'   => 'game_'.$game_id.'_play',
            'value'  => 'play_game_'.$game_id,
            'expire' => 86400 * 730
          );
      set_cookie($rewards_cookie);
      $data['result'] = true;
      echo json_encode($data);
    }

    private function view_the_game($postData) {
        $current_prediction_data = '';
        $limit = 1;
        $offset = $postData['offset'];
        $current_datetime = date("Y-m-d H:i:s");
        if (!empty($postData['current_prediction_id'])) {
          $current_prediction_data = $this->predictions_model->get_prediction_data($postData['current_prediction_id']);
          $current_prediction_price = $current_prediction_data['current_price'];  //price of visible prediction
        }
        if (!empty($postData['next_prediction_id'])) {
          $next_prediction_data = $this->predictions_model->get_prediction_data($postData['next_prediction_id']);
          $next_prediction_price = $next_prediction_data['current_price'];    //price of second (next to visible) prediction
        }

        if ($current_prediction_data==false || empty($current_prediction_data)) {
          $data = array('status' => 'failure','message' => 'Prediction not found','errorShow'=>'console','reload'=>'no');
        }else if($current_datetime > $current_prediction_data['fpt_end_datetime'] && $current_prediction_data['agreed'] == '0' && $current_prediction_data['disagreed'] == '0'){
            $data = array('status' => 'failure','message' => 'Prediction no longer exists','errorShow'=>'console','reload'=>'yes');
        }else{
            if ($current_prediction_price >= '0' && $current_prediction_price < '1') {
                $current_prediction_price = '1';
            }else if($current_prediction_price > '100'){
                $current_prediction_price = '100';
            }

            $postData = $postData + array('current_prediction_price' => $current_prediction_price,'user_id' => $this->user_id);

              if (empty($postData['next_prediction_id'])) {
                $data = array('status' => 'success', 'message' => '200');
              }else{                  
                $fpt_end_datetime = $next_prediction_data['fpt_end_datetime'];
                $data = array('status' => 'success',
                        'message' => '200',
                        // 'fpt_end_datetime' => date('D M d Y H:i:s', strtotime($fpt_end_datetime)),
                        'fpt_end_datetime' => $fpt_end_datetime,
                        'prediction_end_date' => date('d M Y', strtotime($next_prediction_data['end_date'])),
                        'current_price' => round($next_prediction_price),
                      );
              }

            $result_load_prediction = $this->predictions_model->get_predictions_details($postData['game_id'],$limit,$offset);
            // print_r($result_load_prediction);die;
            $load_prediction_data = array('load_prediction_data' => $result_load_prediction);
            $action = array('action' => 'view_the_game');
            if (!empty($result_load_prediction)) {
              $data = array_merge($data, $load_prediction_data);    //merging next prediction's data that to be loaded.
            }
              $data = array_merge($data, $action);
        }
        return $data;
    }


}
