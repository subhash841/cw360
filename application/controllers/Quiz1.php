<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {

	function __construct(){
		parent::__construct();
		$sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
		$this->load->model('quiz_model');				
	}

	public function index($id="")
	{
		$user_session_data = $this->session->userdata('data');
        if (empty($user_session_data['uid'])) {
            	redirect(base_url().'login?section=home');
        }else{
			$data['quiz_id']=base64_decode($id);
			$data['topic_id']=base64_decode($this->input->get('topic_id'));
			// print_r($data);die;
			$data['sidebar_games'] = $this->predictions_model->get_games('',$data['topic_id']);
			$data['topics_quiz_list'] = $this->quiz_model->get_quiz_list(6,$data['topic_id']);
			//print_r($data['topic_id']);die;
			$this->load->view('header');
			$this->load->view('quiz',$data);
			$this->load->view('footer');
		}
	}

	public function quiz_start_chk()
	{
		$user_session_data = $this->session->userdata('data');
        if (empty($user_session_data['uid'])) {
            	redirect(base_url().'login?section=home');
        }else{
        	// print_r($_POST);
			$data['quiz_id']=base64_decode($this->input->post('quiz_id'));
			$data['topic_id']=base64_decode($this->input->post('topic_id'));
			$coins_needed=base64_decode($this->input->post('coins_needed'));
			$get_User_Coins=get_User_Coins();
			$quiz_start_chk=$this->quiz_model->quiz_start_chk_data();
			// echo $quiz_start_chk;
			// die;
			if($quiz_start_chk != '0'){
				echo json_encode("quiz_attempted");
			}else if($quiz_start_chk=='0' && $get_User_Coins >= $coins_needed){
			   $this->quiz_model->quiz_start_insert_data();
				echo json_encode("play_quiz");
			}else{
				echo json_encode("insufficientPoints");
			}
			// echo "<pre>";
			// print_r($data);die;

		}
	}


	function instruction($id=""){
			$data['quiz_id']=base64_decode($id);
			$data['topic_id']=base64_decode($this->input->get('topic_id'));
			$question_limit=$this->quiz_model->get_question_limt($data['topic_id'],$data['quiz_id']);
			$data['question_data']=$this->quiz_model->get_quiz_list('1',$data['topic_id'],0,$data['quiz_id']);
			// echo $this->db->last_query();die;
			// print_r($data['question_data'][0]['wrong_ans_coins']);die;
			// print_r($data['question_data']);die;
			$data['coins_needed']=$question_limit*$data['question_data']['wrong_ans_coins'];
			$data['sidebar_games'] = $this->predictions_model->get_games('',$data['topic_id']);
			$data['topics_quiz_list'] = $this->quiz_model->get_quiz_list(6,$data['topic_id']);
			$this->load->view('header');
			$this->load->view('quiz-instruction',$data);
			$this->load->view('footer');
	}

	function quiz_answer_summary($id=""){
		$data['quiz_id']=base64_decode($id);
		$data['topic_id']=base64_decode($this->input->get('topic_id'));
		$data['attempt_question_quiz_ans'] = $this->quiz_model->get_quiz_ans($data['quiz_id'],$data['topic_id']);
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
		$data['sum_correct']=array_sum(array_column($correct_ans_array, 'point'));
		$data['sum_wrong']=array_sum(array_column($wrong_ans_array, 'point'));
		$data['topics_quiz_list'] = $this->quiz_model->get_quiz_list(6,$data['topic_id']);
		$data['sidebar_games'] = $this->predictions_model->get_games('',$data['topic_id']);
		$this->load->view('header');
		$this->load->view('quiz_answer_summary',$data);
		$this->load->view('footer');
	}

	public function question_bank_id(){
		// print_r($_POST);die;
		$data['question_limit']=$this->quiz_model->get_question_limt($_POST['topic_id'],$_POST['quiz_id']);
		$attempt_question_limit = $this->quiz_model->attempt_question_limit($_POST['topic_id'],$_POST['quiz_id']);
		// print_r($attempt_question_limit);die;
		if($data['question_limit'] >= $attempt_question_limit){   
			$data['question']=$this->quiz_model->get_question_list($_POST['topic_id'],$data['question_limit'],$_POST['quiz_id']);
				echo json_encode($data);	
            }else{		              
                $data['question']='finish-quiz';                
				echo json_encode($data);		
            }
	}
	public function question_bank()
	{

		// $data['question_limit']=$this->quiz_model->get_question_limt($_POST['topic_id'],$_POST['quiz_id']);
		$data['question']=$this->quiz_model->get_question($_POST['question_id']);
		$data['question_ans']=$this->quiz_model->get_question_ans($_POST['question_id']);
		echo json_encode($data);		
	}
	public function question_time_out()
	{
		$data['question']=$this->quiz_model->question_time_out();
		echo json_encode($data);		
	}
	
	public function question_check_process(){
		//print_r($_POST);
		$data['answer_chk']=$this->quiz_model->get_question_answer_chk();
		echo json_encode($data);	
	}

	public  function all_quiz() {
        $offset = $_POST['offset'];
        $topic_id = $_POST['topicid'];
        $result = $this->quiz_model->get_quiz_list(6,$topic_id,$offset);
        echo json_encode($result);
	}
	
	function listt(){
		$this->load->view('header');
		$this->load->view('quiz_list');
		$this->load->view('footer');
	}
}
