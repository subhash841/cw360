<?php 
class AppQuiz extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
      	$this->load->model('API/AppQuiz_model');
      	$this->load->model('API/AppCommon_model');
      	$this->load->model('quiz_model');
      	$this->load->helper('common_api_helper');

	}


	public function quiz_instruction()
	{
		    $inputs = $this->input->post();
    		// print_r($inputs);die;     
	        $user_id = $inputs['user_id'];
	        $data=array();
	   		 	$question_limit=$this->AppQuiz_model->get_question_limt_topic($inputs['quiz_id']);
				$data['question_data']=$this->AppQuiz_model->get_quiz_instruction_data($user_id,$inputs['quiz_id']);
				$data['question_data']['coins_needed']=$question_limit['total_questions']*$data['question_data']['wrong_ans_coins'];
          		sendjson(array("status" => TRUE, "message" => "Quiz instruction data found.","data"=> $data));
	        
    	
	}

	public function quiz_start_check()
	{
		$authenicate=authenicate_access_token(getallheaders());   
    	// print_r($_POST);die;     
       	if($authenicate=='1'){
     	    $inputs = $this->input->post();
     	    //print_r($inputs);die;
	        $user_id = $inputs['user_id'];
	        $coins_needed = $inputs['coins_needed'];
	   		  if(empty($user_id)){
	            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
	        }else if($user_id>0){	            
	   		   	$data = $this->AppQuiz_model->quiz_details($inputs);
	   		   	$get_User_Coins=getUserCoins();
	   		 	$quiz_start_chk=$this->AppQuiz_model->quiz_start_chk_data($inputs);

				$users_quiz_coin_limit=$this->AppQuiz_model->users_quiz_coin_limit($user_id);
	   		   	$quiz_question_check = $this->AppQuiz_model->quiz_question_check($inputs['quiz_id']);
	   		   	$current_date=date("Y-m-d");
	   		   	// echo $get_User_Coins;
	   		   	// echo $coins_needed;
	   		   	// echo $quiz_start_chk;die;
	   		 	if($quiz_start_chk != '0' && $users_quiz_coin_limit['coin_limit'] != '0'){

					sendjson(array("status" => FALSE, "message" => "Quiz attempted.", "data"=>""));
				
				}else if($quiz_question_check == '0'){
          		
          			sendjson(array("status" => FALSE, "message" => "No Question Available.", "data"=>$no_question_available));

	   		   	}else if($current_date <= $users_quiz_coin_limit['limit_end_date'] && $users_quiz_coin_limit['coin_limit'] == '0'){

						sendjson(array("status" => FALSE, "message" => "You have reached maximum ".$users_quiz_coin_limit['max_limit_coin']." coin earn limit for Quiz . You can start earning coins from date ".$users_quiz_coin_limit['limit_end_date'], "data"=>$users_quiz_coin_limit));

				}else if($current_date > $users_quiz_coin_limit['limit_end_date'] && $quiz_start_chk=='0' && $get_User_Coins >= $coins_needed){	
			   		$this->AppQuiz_model->quiz_start_insert_data($inputs);
					sendjson(array("status" => TRUE, "message" => "Play quiz data found."));
				}else if($quiz_start_chk=='0' && $get_User_Coins >= $coins_needed && $users_quiz_coin_limit['coin_limit'] != '0'){	
			   		$this->AppQuiz_model->quiz_start_insert_data($inputs);
					sendjson(array("status" => TRUE, "message" => "Play quiz data found."));
				}else{
	          			sendjson(array("status" => FALSE, "message" => "Insufficient Coins."));
		   		   }
	        }else{
	            
	            sendjson(array("status" => FALSE, "message" => "Seems that you are not logged in"));
	        }
    	}else{ 
    			sendjson($authenicate); 
    	}
	}

	public function quiz_answer_summary(){
		$authenicate=authenicate_access_token(getallheaders());   
    		// print_r($_POST);die;     
	    if($authenicate=='1'){	
			$inputs = $this->input->post();
			$user_id = $inputs['user_id'];	
			$data['quiz_id']=$inputs['quiz_id'];
			$data['topic_id']=$inputs['topic_id'];
			$data['attempt_question_quiz_ans'] = $this->AppQuiz_model->get_quiz_ans($data['quiz_id'],$user_id);
			$correct_ans_array=array();
			// print_r($data);die;	
			$wrong_ans_array=array();
			// echo "<pre>--total";
			foreach ($data['attempt_question_quiz_ans'] as $key => $value) {
				if($value['ans_status']=='right'){
					$correct_ans_array[]=$value;
				}else{
					$wrong_ans_array[]=$value;
				}
			}
			$data['count_correct']=count($correct_ans_array);
			$data['count_wrong']=count($wrong_ans_array);
			$data['sum_correct']=array_sum(array_column($correct_ans_array, 'coins'));
			$data['sum_wrong']=array_sum(array_column($wrong_ans_array, 'coins'));
			$data['topics_quiz_list'] = $this->AppCommon_model->get_all_quiz(6,$data['topic_id'],'', $user_id);
			$data['sidebar_games'] = $this->AppCommon_model->get_all_games(sidebar_card_limit(),$data['topic_id'],0);
	        $data['sidebar_blogs'] = $this->AppCommon_model->get_all_blogs(sidebar_card_limit(),$data['topic_id'],0);
			sendjson(array("status" => TRUE, "message" => "Quiz answer summary data found.","data"=> $data));	
		}else{ 
			sendjson($authenicate);
		}
	}

	public function question_bank_id(){
			$authenicate=authenicate_access_token(getallheaders());   
    		// print_r($_POST);die;     
	       	if($authenicate=='1'){
	     	    $inputs = $this->input->post();
		        $user_id = $inputs['user_id'];
		   		if(empty($user_id)){

		            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));

		        }else if($user_id>0){	

					$get_question_limt_topic=$this->AppQuiz_model->get_question_limt_topic($inputs['quiz_id']);

					$data['question_limit']=$get_question_limt_topic['total_questions'];

					$topic_id=$get_question_limt_topic['topic_id'];

					$attempt_question_limit = $this->AppQuiz_model->attempt_question_limit($inputs['quiz_id'],$user_id );

					$limit_qtn=$get_question_limt_topic['total_questions']-$attempt_question_limit;

					$users_quiz_coin_limit=$this->AppQuiz_model->users_quiz_coin_limit($user_id);
					// print_r($users_quiz_coin_limit['coin_limit']);die;
					if($data['question_limit'] >= $attempt_question_limit && $users_quiz_coin_limit['coin_limit'] !='0'){   
						
						$data['question']=$this->AppQuiz_model->get_question_list($limit_qtn,$_POST['quiz_id'],$topic_id, $user_id);

							sendjson(array("status" => TRUE, "message" => "Play quiz  question data found.","data"=> $data));

			            }else if($users_quiz_coin_limit['coin_limit'] == '0'){

								sendjson(array("status" => TRUE, "message" => "You have reached maximum ".$users_quiz_coin_limit['max_limit_coin']." coin earn limit for Quiz . You can start earning coins from date ".$users_quiz_coin_limit['limit_end_date'], "data"=>$users_quiz_coin_limit));

						}else{		              
			                              
							sendjson(array("status" => FALSE, "message" => "Quiz finished."));		
			            }
		        	}
		    }else{ 
    			sendjson($authenicate);
     		}	


		
		// print_r($_POST);die;
	}
	
	public function question_bank()
	{	
		$authenicate=authenicate_access_token(getallheaders());   
    		// print_r($_POST);die;     
	       	if($authenicate=='1'){
	     	    $inputs = $this->input->post();
		        $user_id = $inputs['user_id'];		        
		   		if(empty($user_id)){
		            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
		        }else if($user_id>0){	

				$data['question']=$this->AppQuiz_model->get_question($inputs['question_id']);
				$data['question']['question_ans']=$this->AppQuiz_model->get_question_ans($inputs['question_id']);
				$users_quiz_coin_limit=$this->AppQuiz_model->users_quiz_coin_limit($user_id);
				if($users_quiz_coin_limit['coin_limit'] == '0'){
						sendjson(array("status" => TRUE, "message" => "You have reached maximum ".$users_quiz_coin_limit['max_limit_coin']." coin earn limit for Quiz . You can start earning coins from date ".$users_quiz_coin_limit['limit_end_date'], "data"=>$users_quiz_coin_limit));
					}else{		              
		                           
						sendjson(array("status" => TRUE, "message" => "Quiz data found.","data"=> $data));		
		            }	
			}
		}else{ 
    			sendjson($authenicate);
     	}
	}

	public function question_check_process(){		
		$authenicate=authenicate_access_token(getallheaders());   
    		// print_r($_POST);die;     
	       	if($authenicate=='1'){
	     	    $inputs = $this->input->post();
		        $user_id = $inputs['user_id'];
		   		if(empty($user_id)){
		            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
		        }else if($user_id>0){
					$data['answer_chk']=$this->AppQuiz_model->get_question_answer_chk($inputs);
						sendjson(array("status" => TRUE, "message" => "Quiz question answer check.","data"=> $data));			
		        	}
		    }else{ 
    			sendjson($authenicate);
     		}	
	}

	public function question_time_out()
	{
			$authenicate=authenicate_access_token(getallheaders());   
    		// print_r($_POST);die;     
	       	if($authenicate=='1'){
	     	    $inputs = $this->input->post();
		        $user_id = $inputs['user_id'];
		   		if(empty($user_id)){
		            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
		        }else if($user_id>0){

						$data['question']=$this->AppQuiz_model->question_time_out($inputs);
						sendjson(array("status" => TRUE, "message" => "Quiz question time out.","data"=> $data));			
		        	}
		    }else{ 
    			sendjson($authenicate);
     		}
	}	


	public function quiz_preview($id = "")
	{
		$quiz_id = $id;
		$topic_id = $this->uri->segment(5);
		$t_id_array=explode('-',$topic_id);
		$topic_id=implode(',', $t_id_array);
		$userId =  $this->uri->segment(6);
		$question_limit = $this->AppQuiz_model->get_question_limt_topic($quiz_id);
		$question_data = $this->quiz_model->get_preview_quiz_instruction_data('1', $topic_id, 0, $quiz_id);
		$attempt_question_quiz_ans= $this->AppQuiz_model->get_quiz_summary_share($quiz_id, $userId);
		$data['meta_data'] = $question_data;
		$data['meta_data']['quiz_name'] = $attempt_question_quiz_ans['quiz_title'];
		// $data['meta_data']['title'] = $data['question_data']['name'];
		if (!empty($userId)) {
			$get_quiz_summary_share = $this->quiz_model->get_quiz_summary_share($quiz_id, $userId);
			$correct_ans_array = array();
			// print_r($data);die;	
			$wrong_ans_array = array();
			
			foreach ($get_quiz_summary_share as $key => $value) {
				if ($value['ans_status'] == 'right') {
					$correct_ans_array[] = $value;
				} else {
					$wrong_ans_array[] = $value;
				}
			}
			$count_correct = count($correct_ans_array);
			$count_wrong= count($wrong_ans_array);
			$player_level = quiz_player_statistic($count_correct, $count_wrong);
			$user_name = $this->quiz_model->get_user_name($userId);
			$name = empty($user_name['name']) ? 'CW360#' . $userId : $user_name['name'];
			$data['meta_data']['title'] = $name . ' has been rated ' . $player_level['article'] . ' ' .
			ucfirst($player_level['type']) . ' on '.$attempt_question_quiz_ans['quiz_title'];
			$data['meta_data']['meta_description'] = 'CrowdWisdom360 Predictions and Quizzes';
			// print_r($data);die;
			sendjson(array("status" => TRUE, "message" => "Quiz preview data.","data"=> $data['meta_data']));
		}
	}
}
?>
