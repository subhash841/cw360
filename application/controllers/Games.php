<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Games extends CI_Controller {

    function __construct() {
        parent::__construct();
	    $this->load->model(array('Games_model','predictions_model','quiz_model'));
	    $this->load->helper(array('prediction_helper'));
		$this->load->model(array('Common_model', 'blog_model', 'sidebar_model'));
		
		$sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
    }

    public function index($id = "") {
        $all_games = $this->Games_model->get_all_games();
        // print_r($all_games);die;
//        $data['all_game_count'] = $this->Games_model->get_all_games_count();
        if (!empty($id)) {
            $category_games = $this->Games_model->get_games($id);
            // echo('<pre>');
            // print_r($category_games);
            // die;
//            $data['cat_game_count'] = $this->Games_model->get_cat_game_count($id);
            $this->load->model('Topic_model');
            $category_name = $this->Topic_model->get_category_name($id);
			$data['topics_quiz_list'] = $this->quiz_model->get_quiz_list(6,$id);
			$data['sidebar_blogs'] = $this->sidebar_model->get_all_blogs(sidebar_card_limit(),$id,0);
			// echo $this->db->last_query();die;
        	$data['sidebar_quiz'] = $this->sidebar_model->get_all_quiz(sidebar_card_limit(),$id,0);
        }else{
			$data['topics_quiz_list'] = $this->quiz_model->get_quiz_list(6);
			$data['sidebar_blogs'] = $this->sidebar_model->get_all_blogs(sidebar_card_limit(),'',0);
        	$data['sidebar_quiz'] = $this->sidebar_model->get_all_quiz(sidebar_card_limit(),'',0);
        }
//        $data['sidebar_blogs'] = $this->blog_model->get_blog_by_topic_list(6,'');
        $data['category_id'] = $id;
        $data['category'] = array('all');
        $data['topics'] = array('all' => $all_games);

        // print_r($category_name['name']);die;
        if (empty(!$id)) {
            array_push($data['category'], $category_name['name']);
            $data['topics'][$category_name['name']] = $category_games;
        }
        $this->load->view('header');
        $this->load->view('games', $data);
        $this->load->view('footer');
    }

    public function summary($game_id = '') {
        if (empty($game_id)) {
            redirect('Home');
        }
        $data['game_id'] = $game_id;
        $prediction_data = $this->predictions_model->get_predictions_details($game_id, 1);
        if (!empty($prediction_data)) {
            redirect('Predictions/prediction_game/' . $game_id);
        }
        $data['game_details'] = $this->Games_model->get_game_details($game_id);
        $data['prediction_list'] = $this->Games_model->get_executed_predictions($game_id);
        $change_prediction_time = $this->Games_model->get_game_details($game_id);
        $data['change_prediction_time'] = $change_prediction_time['change_prediction_time'];
        $data['available_points'] = $this->predictions_model->get_game_points($game_id,$this->user_id);
        $this->load->view('header');
        $this->load->view('summary', $data);
        $this->load->view('footer');
    }

    function get_all_games() {
        $offset = $_POST['offset'];
        $data = $this->Games_model->get_all_games($offset);
        echo json_encode($data);
    }

    function get_cat_games() {
		$offset = isset($_POST['offset']) ? $_POST['offset']:'0';
        $category = @$_POST['category'];
		$data = $this->Games_model->get_cat_games($offset, $category);
		if(!empty($data)){
			echo json_encode($data);
		}else{
			redirect('games');
		}
    }
    
    public function summary_chanages_predictions(){		
		$res=$this->Games_model->check_predictions_avlib();
		$res1=$this->Games_model->check_game_point();

		// echo $this->db->last_query();
		 // echo $_POST['condition'];die;
		// echo "<pre>";
		// print_r($res['end_date']);
		// 	echo "<pre>";
		// print_r($res1[0]['points']);
		// 	echo "<pre>";
		// print_r($res1[0]['points']);die;

		$change_prediction_time = $this->Games_model->get_game_details($_POST['game_id']); 
		$check_prediction_click = $this->Games_model->check_summary_chanages_predictions_click(); 
		//print_r($check_prediction_click['swipe_staus']);die;
		if($check_prediction_click['swipe_staus'] != $_POST['condition']){
			if(empty($change_prediction_time['is_published']) || $change_prediction_time['end_date'] < (date('Y-m-d H:i:s')) || $res['count_date'] != '0'){
				// echo "end date";
				$data='end';
			}else if($res1[0]['points'] == '0' && $_POST['condition']=='Yes'){	
				// echo "false";
				$data=false;
			}else if($_POST['condition']=='Yes' && $res1[0]['points'] != '0' && $res['count_date'] == '0'){
				
				$data=$this->Games_model->summary_chanages_predictions();
				if ($data==false) {
					$data=false;
				}else{
					$data['change_prediction_time'] = $change_prediction_time['change_prediction_time'];
				}
				// echo "yes";
			}else if($_POST['condition']=='No' && $res['count_date'] == '0'){
	
				$data=$this->Games_model->summary_chanages_predictions();
				$data['change_prediction_time'] = $change_prediction_time['change_prediction_time'];	
				// echo "no";
			}else{
	
				// echo "error";
				$data="error";
			}
		}else{

            $data= "exists_prediction";
        }
		
		echo json_encode($data);
	}
	
	public function get_executed_predictions()
	{
		$postData = $this->input->post();
		$change_prediction_time = $this->games_model->get_game_details($postData['game_id']);
        $data['change_prediction_time'] = $change_prediction_time['change_prediction_time'];
		$data['prediction_list'] = $this->Games_model->get_executed_predictions($postData['game_id'],$postData['offset']);
        echo json_encode($data);	

	}

	/*public function leaderboard(){
		$postData = $this->input->post();
		$game_id = $postData['game_id'];
		
		if (empty($game_id)) {
			$data = array('status' => 'failure','message' => 'redirect_to_home');		//if game id is empty then redirect to home screen
		}else{
        	$all_prediction_price = $this->games_model->all_prediction_price($game_id);		//get all predictions current price
		    $leaderboard_details = $this->games_model->leaderboard_details($game_id);		//get executed predictions,users and points data
		    $prediction_ids = array_column($all_prediction_price, 'id');				//separate all ids
		    $prediction_price = array_column($all_prediction_price, 'current_price');	//separate current price
		    $predictionData = array_combine($prediction_ids, $prediction_price);		//assign current price to ids

		    $leaderBoard = array();
		    $user_points = '';
		    foreach ($leaderboard_details as $key => $value) {
		        $prediction_id_set = $value['predictions'];							//user's executed predictions
		        $prediction_id_array  = explode(", ",$prediction_id_set);			//executed predictions converted to array
		        $bonus_points_set = $value['bonus_points'];							//user's bonus points
		        $bonus_points_array = explode(",",$bonus_points_set);				//bonus points converted to array
		        $bonus_points_array = array_sum($bonus_points_array);
		        // $get_predictions= array_flip(array_intersect(array_flip($predictionData),$prediction_id_array));	//get current price of user's executed prediction from all predictions set
		        $get_predictions= array_intersect_key($predictionData,array_flip($prediction_id_array));	//get current price of user's executed prediction from all predictions set
		        $current_price_sum = array_sum($get_predictions);		//sum of all prediction's current price 
		        // print_r($current_price_sum);die;
		        $leaderboard_points = $bonus_points_array + $value['points'] + $current_price_sum;		//calculation for leader board total points
		        $leaderboard_points =  number_format((float)$leaderboard_points, 2, '.', '');
		        $leaderBoard[$key] = array('id' => $value['id'],'user_id' => $value['user_id'],'name' => $value['name'],'image' => $value['image'],'total_points' => $leaderboard_points);		//set final array for users one by one
		        if ($this->user_id == $value['user_id']) {
	                $user_points = $leaderboard_points;
	            } 
		    }
		    if (!empty($leaderBoard)) {
	            $totalPoints = array_column($leaderBoard, 'total_points');
	            array_multisort($totalPoints, SORT_DESC, $leaderBoard);
	            
		        $user_rank =  array_search($this->user_id, array_column($leaderBoard, 'user_id'));
		        $is_user_exist = in_array($this->user_id, array_column($leaderBoard, 'user_id')); 
		        if ($is_user_exist ==true) {
		        	$user_rank = $user_rank + 1;
		        }else{
		        	$user_rank = '0';
		        }
		        
	            $data = array('status' => 'success','message' => '200','leaderboard_data' => $leaderBoard,'user_points' => $user_points,'user_rank' => $user_rank,'sess_user_id' => $this->user_id);
	        }else{
	             $data = array('status' => 'failure','message' => 'empty_records');
	        }
        }
        echo json_encode($data);   
	}*/

	public function leaderboard(){
		$postData = $this->input->post();
		$game_id = $postData['game_id'];
		
		if (empty($game_id)) {
			$data = array('status' => 'failure','message' => 'redirect_to_home');		//if game id is empty then redirect to home screen
		}else{
			$all_prediction_price = $this->games_model->all_prediction_price($game_id);		//get all predictions current price
			// print_r($all_prediction_price);die;
			$leaderboard_details = $this->games_model->leaderboard_details($game_id);		//get executed predictions,users and points data
			// print_r($leaderboard_details);die;
			$all_users = $this->games_model->all_users_details($game_id);		//get users and points data
			
		    $prediction_ids = array_column($all_prediction_price, 'id');				//separate all ids
		    $prediction_price = array_column($all_prediction_price, 'current_price');	//separate current price
			$predictionData = array_combine($prediction_ids, $prediction_price);		//assign current price to ids
		

		    $leaderBoard = array();
		    $user_points = '';
		    foreach ($all_users as $key => $value) {
		    	$predDataKey =  array_search($value['user_id'],array_column($leaderboard_details, 'user_id'));
				if (!empty($predDataKey) || $predDataKey===0) {
					$leaderBoardPredData = $leaderboard_details[$predDataKey];	//get executed prediction data from leaderboard_details array
			        $prediction_id_set = $leaderBoardPredData['predictions'];				//user's executed predictions
			        $prediction_id_array  = explode(", ",$prediction_id_set);	//executed predictions converted to array
			        $bonus_points_set = $leaderBoardPredData['bonus_points'];				//user's bonus points
			        $bonus_points_array = explode(",",$bonus_points_set);	//bonus points converted to array
			        $bonus_points_array = array_sum($bonus_points_array);
			        // $get_predictions= array_flip(array_intersect(array_flip($predictionData),$prediction_id_array));	//get current price of user's executed prediction from all predictions set
			        $get_predictions= array_intersect_key($predictionData,array_flip($prediction_id_array));	//get current price of user's executed prediction from all predictions set
			        $current_price_sum = array_sum($get_predictions);		//sum of all prediction's current price 
			        // print_r($current_price_sum);die;
			        $leaderboard_points = $bonus_points_array + $value['points'] + $current_price_sum;		//calculation for leader board total points
					// print_r($current_price_sum);
				}else{
					$leaderboard_points = $value['points'];
				}

		        $leaderboard_points =  number_format((float)$leaderboard_points, 2, '.', '');
		        $leaderBoard[$key] = array('id' => $value['id'],'user_id' => $value['user_id'],'name' => $value['name'],'image' => $value['image'],'total_points' => $leaderboard_points);		//set final array for users one by one
		        if ($this->user_id == $value['user_id']) {
	                $user_points = $leaderboard_points;
	            } 
		    }
		    if (!empty($leaderBoard)) {
	            $totalPoints = array_column($leaderBoard, 'total_points');
	            array_multisort($totalPoints, SORT_DESC, $leaderBoard);
		    	// print_r($leaderBoard);die;
		        $user_rank =  array_search($this->user_id, array_column($leaderBoard, 'user_id'));
		        $is_user_exist = in_array($this->user_id, array_column($leaderBoard, 'user_id')); 
		        if ($is_user_exist ==true) {
		        	$user_rank = $user_rank + 1;
		        }else{
		        	$user_rank = '0';
		        }
		        
	            $data = array('status' => 'success','message' => '200','leaderboard_data' => $leaderBoard,'user_points' => $user_points,'user_rank' => $user_rank,'sess_user_id' => $this->user_id);
	        }else{
	             $data = array('status' => 'failure','message' => 'empty_records');
	        }
        }
        echo json_encode($data);   
	}

	public function check_game_player_limit(){
		$postData = $this->input->post();
		$game_id = $postData['game_id'];
		$game_player_count = $postData['game_player_count'];
		$current_players = $this->games_model->current_players($game_id);
		if (!empty($current_players)) {
			$all_users = array_column($current_players, 'user_id');
			$total_users = count($all_users);
			if ($total_users >= $game_player_count && in_array($this->user_id,$all_users)==false) {
				$data['result'] = false;
			}else{
				$data['result'] = true;
			}
		}else{
			$data['result'] = true;
		}
		echo json_encode($data);
	}

	public function refresh_portfolio(){
		$postData = $this->input->post();
		$game_id = $postData['game_id'];
		
		if (empty($game_id)) {
			$data = array('status' => 'failure','message' => 'redirect_to_home');		//if game id is empty then redirect to home screen
		}else{
        	$all_prediction_price = $this->games_model->all_prediction_price($game_id);		//get all predictions current price
		    $leaderboard_details = $this->games_model->leaderboard_details($game_id);		//get executed predictions,users and points data
		    $all_users = $this->games_model->all_users_details($game_id);		//get users and points data
		    $prediction_ids = array_column($all_prediction_price, 'id');				//separate all ids
		    $prediction_price = array_column($all_prediction_price, 'current_price');	//separate current price
		    $predictionData = array_combine($prediction_ids, $prediction_price);		//assign current price to ids

		    $leaderBoard = array();
		    $user_portfolio_points = '';
		    $user_available_points = '';
		    foreach ($all_users as $key => $value) {
		    	$predDataKey =  array_search($value['user_id'],array_column($leaderboard_details, 'user_id'));
		    	if (!empty($predDataKey) || $predDataKey===0) {
		    		$leaderBoardPredData = $leaderboard_details[$predDataKey];	//get executed prediction data from leaderboard_details array
			        $prediction_id_set = $leaderBoardPredData['predictions'];							//user's executed predictions
			        $prediction_id_array  = explode(", ",$prediction_id_set);			//executed predictions converted to array
			        $bonus_points_set = $leaderBoardPredData['bonus_points'];							//user's bonus points
			        $bonus_points_array = explode(",",$bonus_points_set);				//bonus points converted to array
			        $bonus_points_array = array_sum($bonus_points_array);
			        // $get_predictions= array_flip(array_intersect(array_flip($predictionData),$prediction_id_array));	//get current price of user's executed prediction from all predictions set
			        $get_predictions= array_intersect_key($predictionData,array_flip($prediction_id_array));	//get current price of user's executed prediction from all predictions set
			        $current_price_sum = array_sum($get_predictions);		//sum of all prediction's current price 
			        // print_r($current_price_sum);die;
			        $leaderboard_points = $bonus_points_array + $value['points'] + $current_price_sum;		//calculation for leader board total points
			    }else{
					$leaderboard_points = $value['points'];
				}
		        // $leaderboard_points =  number_format((float)$leaderboard_points, 2, '.', '');
		        $leaderBoard[$key] = array('id' => $value['id'],'user_id' => $value['user_id'],'total_points' => $leaderboard_points);		//set final array for users one by one
		        if ($this->user_id == $value['user_id']) {
	                $user_portfolio_points = $leaderboard_points;
	                $user_available_points = round($value['points']);
	            } 
		    }

		    if (!empty($leaderBoard)) {
	            $totalPoints = array_column($leaderBoard, 'total_points');
	            array_multisort($totalPoints, SORT_DESC, $leaderBoard);
	            
		        $user_rank =  array_search($this->user_id, array_column($leaderBoard, 'user_id'));
		        $is_user_exist = in_array($this->user_id, array_column($leaderBoard, 'user_id')); 
		        if ($is_user_exist ==true) {
		        	$user_rank = $user_rank + 1;
		        }else{
		        	$user_rank = '0';
		        }
		        
	            $data = array('status' => 'success','message' => '200','user_rank' => $user_rank,'user_portfolio_points' => $user_portfolio_points,'user_available_points' => $user_available_points);
	        }else{
	             $data = array('status' => 'failure','message' => 'empty_records');
	        }
        }
        echo json_encode($data); 
	}

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
					$gamessArray = array_map('trim', explode(',', $games_ids_set));
					$user_ex_prediction_details = $this->get_ex_prediction_details($user_id,$gamessArray); 	//get user's prediction data
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

					
					$res_data=array('category_name' => $category_key,
					// 'prediction_data' => array_sum($category));
					'prediction_data_count'=>$arrCount,
					'prediction_data' => $totalSumArr);
					$categorywise_rank[] = $res_data;
					}
			}
		}
		// print_r($categorywise_rank);die;
		// die;
		$data['categorywise_rank'] = $categorywise_rank;
		echo json_encode($data);
	}

	private	function get_ex_prediction_details($user_id,$game_id){
		// echo $game_id;
		$total_executed_predictions=$this->games_model->get_total_executed_predictions($user_id,$game_id);
		$total_ex_predictions_correct=$this->games_model->get_total_executed_predictions_correct($user_id,$game_id);
		// print_r($total_ex_predictions_correct);
		// echo $this->db->last_query();
		if($total_ex_predictions_correct['count_right']=='0' && $total_executed_predictions!='0'){
			$final="0";
		}else if($total_ex_predictions_correct['count_right'] != '0'){
			// echo "<pre>";
	        // foreach ($total_ex_predictions_correct as $key => $value) {
			// 	// echo "<br>";
			// 	// echo $value;
			// 	if($value['bonus_points']>'0'){
			// 		$count= $count+1; 
			// 		$count_n=$count_n;
			// 	}else{
			// 		$count= $count; 
			// 		$count_n=$count_n+1;
			// 	}
				// echo"<br>";
			// }			
			// echo $total_ex_predictions_correct['count_right']." / ".$total_executed_predictions;
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
/* 
	public function get_average_portfolio(){
		$user_id = $this->input->post('user_id');
		$userwise_game_ids = $this->games_model->get_userwise_gameids($user_id);  //get all game ids which user has played
		$categorywise_rank = array();
		if (!empty($userwise_game_ids)) {
			$game_ids = array_column($userwise_game_ids, 'game_id');
			$topic_ids_set = $this->games_model->get_topic_ids($game_ids);		//get topic ids of games
			$topic_ids = array_column($topic_ids_set, 'topic_id');
			$game_category_data = $this->games_model->get_category_data($topic_ids);	//get category data of topic ids
			$categories = array();
			foreach ($topic_ids_set as $key => $value) {
				$array_position = array_search($value['topic_id'], array_column($game_category_data, 'id'));
				$category_data = $game_category_data[$array_position];
				$user_rank_details = $this->get_user_rank($user_id,$value['id']); 	//get user's rank for game
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
		echo json_encode($data);
	} */


	private function get_user_rank($user_id, $game_id){
	  	$all_prediction_price = $this->Games_model->all_prediction_price($game_id);   //get all predictions current price
	  	$leaderboard_details = $this->Games_model->leaderboard_details($game_id);     //get executed predictions,users and points data
	  	$all_users = $this->Games_model->all_users_details($game_id);                //get users and points data
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
	public function coins_coversion_details(){
		$postData = $this->input->post();
		$data = $this->Games_model->get_coin_conversion_details($postData['game_id']);
		
		// to be added from query
		// $data['point_value_per_coin'] = 30;
		// $data['coin_transfer_limit'] =	50;
		$data['user_coins'] = $this->predictions_model->getUserCoins($postData['user_id']);
		echo json_encode($data);
	}
	public function convert_coins_into_points(){
		$postData = $this->input->post();
		$data = $this->Games_model->get_coin_conversion_details($postData['game_id']);
		$converted_points_entry = $this->Games_model->check_converted_points_entry($postData['user_id'],$postData['game_id']);
		// print_r($data);
		// to be added from query
		// $data['point_value_per_coin'] = 30;
		// $data['coin_transfer_limit'] =	50;
		$user_coins = $this->predictions_model->getUserCoins($postData['user_id']);
		if (is_numeric($postData['coins_convert'])==false) {
			$result = array('status'=>'failure', 'message'=>'Coins field must contain numbers only');
		}else if($postData['coins_convert'] > $user_coins['coins']){
			$result = array('status'=>'failure', 'message'=>'You do not have enough coins in your wallet');
		}else if ($postData['coins_convert'] > $data['coin_transfer_limit']) {
			$result = array('status'=>'failure', 'message'=>'Max coins transfer limit exceeds');
		}else if (!empty($converted_points_entry)) {
			$result = array('status'=>'failure', 'message'=>'You have exceeded your attempts');
		}else{
			$conversion_data = array('game_id' => $postData['game_id'],
									 'user_id' => $postData['user_id'],
									 'coins' => $postData['coins_convert'],
									 'point_value_per_coin' => $data['point_value_per_coin'],
									 'points' => $postData['coins_convert'] * $data['point_value_per_coin']
									);
			$convert_coins = $this->Games_model->convert_coins_to_points($conversion_data);
			if ($convert_coins === true){
				$result = array('status'=>'success', 'message'=>'Coins added successfully');
			}else{
				$result = array('status'=>'failure', 'message'=>'Something went wrong.');
			}
		}
		echo json_encode($result);
	}



}
