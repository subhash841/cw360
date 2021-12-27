<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Quiz extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$sessiondata = $this->session->userdata('data');
		if (!empty($sessiondata)) {
			$this->user_id = $sessiondata['uid'];
		} else {
			$this->user_id = 0;
		}
		$this->load->model(array('quiz_model', 'blog_model', 'sidebar_model'));
	}

	public function index($id = "")
	{
		$user_session_data = $this->session->userdata('data');
		if (empty($user_session_data['uid'])) {
			redirect(base_url() . 'login?section=home');
		} else {
			$data['quiz_id'] = base64_decode($id);
			$data['topic_id'] = base64_decode($this->input->get('topic_id'));
			$data['question_data'] = $this->quiz_model->get_quiz_instruction_data('1', $data['topic_id'], 0, $data['quiz_id']);
			$data['meta_data']['title'] = $data['question_data']['name'];
			$data['meta_data']['meta_description'] = $data['question_data']['meta_description'];
			$data['meta_data']['meta_keywords'] = $data['question_data']['meta_keywords'];
			$data['meta_data']['image'] = $data['question_data']['image'];
			//			$data['sidebar_games'] = $this->predictions_model->get_games('',$data['topic_id']);
			$data['topics_quiz_list'] = $this->quiz_model->get_quiz_list(4, $data['topic_id']);
			$data['sidebar_games'] = $this->sidebar_model->get_all_games(sidebar_card_limit(), $data['topic_id'], 0);
			$data['sidebar_blogs'] = $this->sidebar_model->get_all_blogs(sidebar_card_limit(), $data['topic_id'], 0);
			//			$data['sidebar_blogs'] = $this->blog_model->get_blog_by_topic_list(6,$data['topic_id']);
			//print_r($data['topic_id']);die;
			$this->load->view('header',$data);
			$this->load->view('quiz', $data);
			$this->load->view('footer');
		}
	}

	public function quiz_start_chk()
	{
		$user_session_data = $this->session->userdata('data');
		if (empty($user_session_data['uid'])) {
			redirect(base_url() . 'login?section=home');
		} else {
			// print_r($_POST);
			$data['quiz_id'] = base64_decode($this->input->post('quiz_id'));
			$coins_needed = base64_decode($this->input->post('coins_needed'));
			$get_User_Coins = get_User_Coins();
			$quiz_start_chk = $this->quiz_model->quiz_start_chk_data();
			$users_quiz_coin_limit = $this->quiz_model->users_quiz_coin_limit();
			$quiz_question_check = $this->quiz_model->quiz_question_check($data['quiz_id']);
			$current_date = date("Y-m-d");
			//echo $quiz_start_chk;
			// echo date("Y-m-d");
			// print_r($users_quiz_coin_limit);
			// die;
			if ($quiz_start_chk != '0' && $users_quiz_coin_limit['coin_limit'] != '0') {
				echo json_encode("quiz_attempted");
			} else if ($quiz_question_check == '0') {
				echo json_encode("no_question_available");
			} else if ($current_date <= $users_quiz_coin_limit['limit_end_date'] && $users_quiz_coin_limit['coin_limit'] == '0') {
				echo json_encode($users_quiz_coin_limit);
			} else if ($current_date > $users_quiz_coin_limit['limit_end_date'] && $quiz_start_chk == '0' && $get_User_Coins >= $coins_needed) {
				$this->quiz_model->quiz_start_insert_data();
				echo json_encode("play_quiz");
			} else if ($quiz_start_chk == '0' && $get_User_Coins >= $coins_needed && $users_quiz_coin_limit['coin_limit'] != '0') {
				$this->quiz_model->quiz_start_insert_data();
				echo json_encode("play_quiz");
			} else {
				// echo json_encode("insufficientPoints");
				echo json_encode("insufficientCoins");
			}
			// echo "<pre>";
			// print_r($data);die;

		}
	}


	function instruction($id = "")
	{
		$data['quiz_id'] = base64_decode($id);
		$data['topic_id'] = base64_decode($this->input->get('topic_id'));
		$userId = base64_decode($this->input->get('user_id'));

		$question_limit = $this->quiz_model->get_question_limt_topic($data['quiz_id']);
		$data['question_data'] = $this->quiz_model->get_quiz_instruction_data('1', $data['topic_id'], 0, $data['quiz_id']);
		// echo $this->db->last_query();die;
		// print_r($question_limit['total_questions'] * $data['question_data']['wrong_ans_coins']);die;
		// print_r($data['question_data'][0]['wrong_ans_coins']);die;
		// print_r($data['question_data']);die;
		$data['coins_needed'] = $question_limit['total_questions'] * $data['question_data']['wrong_ans_coins'];
		$data['sidebar_games'] = $this->sidebar_model->get_all_games(sidebar_card_limit(), $data['topic_id'], 0);
		$data['topics_quiz_list'] = $this->quiz_model->get_quiz_list(6, $data['topic_id']);
		$data['sidebar_blogs'] = $this->sidebar_model->get_all_blogs(sidebar_card_limit(), $data['topic_id'], 0);
		$data['meta_data'] = $data['question_data'];
		// print_r($data['question_data']);die;
		$data['meta_data']['title'] = $data['question_data']['name'];
		$data['meta_data']['meta_description'] = $data['question_data']['meta_description'];
		$data['meta_data']['meta_keywords'] = $data['question_data']['meta_keywords'];
		$data['meta_data']['image'] = $data['question_data']['image'];
		if (!empty($userId)) {
			$get_quiz_summary_share = $this->quiz_model->get_quiz_summary_share($data['quiz_id'], $userId);
			$correct_ans_array = array();
			// print_r($data);die;	
			$wrong_ans_array = array();
			// echo "<pre>--total";
			foreach ($get_quiz_summary_share as $key => $value) {
				if ($value['ans_status'] == 'right') {
					$correct_ans_array[] = $value;
				} else {
					$wrong_ans_array[] = $value;
				}
			}
			$count_correct = count($correct_ans_array);
			$count_wrong = count($wrong_ans_array);
			$player_level = quiz_player_statistic($count_correct, $count_wrong);
			$user_name = $this->quiz_model->get_user_name($userId);
			$name = empty($user_name['name']) ? 'CW360#' . $userId : $user_name['name'];
			$data['meta_data']['title'] = $name . ' is ' . $player_level['article'] . ' ' . $player_level['type'] . ' in this quiz.';
		}

		$this->load->view('header', $data);
		$this->load->view('quiz-instruction', $data);
		$this->load->view('footer');
	}

	function quiz_answer_summary($id = "")
	{
		if (!empty($this->user_id)) {
			$data['quiz_id'] = base64_decode($id);
			$data['topic_id'] = base64_decode($this->input->get('topic_id'));
			$data['attempt_question_quiz_ans'] = $this->quiz_model->get_quiz_ans($data['quiz_id']);
			$correct_ans_array = array();
			// print_r($data);die;	
			$wrong_ans_array = array();
			// echo "<pre>--total";
			foreach ($data['attempt_question_quiz_ans'] as $key => $value) {
				if ($value['ans_status'] == 'right') {
					$correct_ans_array[] = $value;
				} else {
					$wrong_ans_array[] = $value;
				}
			}
			$data['count_correct'] = count($correct_ans_array);
			$data['count_wrong'] = count($wrong_ans_array);
			$data['sum_correct'] = array_sum(array_column($correct_ans_array, 'coins'));
			$data['sum_wrong'] = array_sum(array_column($wrong_ans_array, 'coins'));
			$data['topics_quiz_list'] = $this->quiz_model->get_quiz_list(6, $data['topic_id']);
			//		$data['sidebar_games'] = $this->predictions_model->get_games('',$data['topic_id']);
			$data['sidebar_games'] = $this->sidebar_model->get_all_games(sidebar_card_limit(), $data['topic_id'], 0);
			$data['sidebar_blogs'] = $this->sidebar_model->get_all_blogs(sidebar_card_limit(), $data['topic_id'], 0);
			$data['meta_data'] = reset($data['topics_quiz_list']);
			// $data['meta_data']['title'] = reset($data['topics_quiz_list'])['name'];
			$data['meta_data']['title'] = reset($data['attempt_question_quiz_ans'])['quiz_title'];
			$data['user_name'] = $this->quiz_model->get_user_name($this->user_id);
			$this->load->view('header', $data);
			$this->load->view('quiz_answer_summary', $data);
			$this->load->view('footer');
		} else {
			redirect('home');
		}
	}

	public function question_bank_id()
	{
		// print_r($_POST);die;
		$get_question_limt_topic = $this->quiz_model->get_question_limt_topic($_POST['quiz_id']);
		$data['question_limit'] = $get_question_limt_topic['total_questions'];
		$topic_id = $get_question_limt_topic['topic_id'];
		$attempt_question_limit = $this->quiz_model->attempt_question_limit($_POST['quiz_id']);
		$limit_qtn = $get_question_limt_topic['total_questions'] - $attempt_question_limit;
		$users_quiz_coin_limit = $this->quiz_model->users_quiz_coin_limit();
		// print_r($users_quiz_coin_limit['coin_limit']);die;
		if ($data['question_limit'] >= $attempt_question_limit && $users_quiz_coin_limit['coin_limit'] != '0') {
			$data['question'] = $this->quiz_model->get_question_list($limit_qtn, $_POST['quiz_id'], $topic_id);
			echo json_encode($data);
		} else if ($users_quiz_coin_limit['coin_limit'] == '0') {
			echo json_encode($users_quiz_coin_limit);
		} else {
			$data['question'] = 'finish-quiz';
			echo json_encode($data);
		}
	}

	public function question_bank()
	{

		// $data['question_limit']=$this->quiz_model->get_question_limt($_POST['topic_id'],$_POST['quiz_id']);
		$data['question'] = $this->quiz_model->get_question($_POST['question_id']);
		$data['question_ans'] = $this->quiz_model->get_question_ans($_POST['question_id']);
		$users_quiz_coin_limit = $this->quiz_model->users_quiz_coin_limit();
		if ($users_quiz_coin_limit['coin_limit'] == '0') {
			echo json_encode($users_quiz_coin_limit);
		} else {

			echo json_encode($data);
		}
	}
	public function question_time_out()
	{
		$data['question'] = $this->quiz_model->question_time_out();
		echo json_encode($data);
	}

	public function question_check_process()
	{
		//print_r($_POST);
		$data['answer_chk'] = $this->quiz_model->get_question_answer_chk();
		echo json_encode($data);
	}

	public  function all_quiz()
	{
		$offset = $_POST['offset'];
		$topic_id = @$_POST['topicid'];
		$result = $this->quiz_model->get_quiz_list(4, $topic_id, $offset);
		echo json_encode($result);
	}

	public  function all_quiz_blog()
	{
		$offset = $_POST['offset'];
		$topic_id = @$_POST['topicid'];
		$result = $this->quiz_model->get_quiz_list(4, $topic_id, $offset);
		echo json_encode($result);
	}

	public  function all_quiz_by_topic_list_blog()
	{
		$offset = $_POST['offset'];
		$topic_id = @$_POST['topicid'];
		$result = $this->quiz_model->get_quiz_by_topic_list(4, $topic_id, $offset);
		echo json_encode($result);
	}

	function all_quiz_list()
	{
		$data['quiz_list'] = $this->quiz_model->get_quiz_list(4);
		$data['sidebar_games'] = $this->sidebar_model->get_all_games(sidebar_card_limit(), '', 0);
		//$data['sidebar_blogs'] = $this->quiz_model->get_all_blogs_sidebar(4);
		//        $data['sidebar_blogs'] = $this->blog_model->get_blog_by_topic_list(6,'');
		$data['sidebar_blogs'] = $this->sidebar_model->get_all_blogs(sidebar_card_limit(), '', 0);
		//		 print_r($data['sidebar_blogs']);die;

		$this->load->view('header');
		$this->load->view('quiz_list', $data);
		$this->load->view('footer');
	}

	public function all_sideblog()
	{
		$offset = $_POST['offset'];
		$topicid = @$_POST['topicid'];
		//$result = $this->quiz_model->get_all_blogs_sidebar(4,$offset);
		$result = $this->blog_model->get_blog_by_topic_list(6, $topicid, $offset);
		echo json_encode($result);
	}

	public function quiz_preview($id = "")
	{
		$data['quiz_id'] = $id;
		$topic_id = $this->uri->segment(4);
		$t_id_array = explode('-', $topic_id);
		$data['topic_id'] = implode(',', $t_id_array);
		$userId =  $this->uri->segment(5);
		$question_limit = $this->quiz_model->get_question_limt_topic($data['quiz_id']);
		$data['question_data'] = $this->quiz_model->get_preview_quiz_instruction_data('1', $data['topic_id'], 0, $data['quiz_id']);
		$data['attempt_question_quiz_ans'] = $this->quiz_model->get_quiz_summary_share($data['quiz_id'], $userId);
		$data['topics_quiz_list'] = $this->quiz_model->get_quiz_list(6, $data['topic_id']);
		$data['sidebar_blogs'] = $this->sidebar_model->get_all_blogs(sidebar_card_limit(), $data['topic_id'], 0);
		$data['meta_data'] = $data['question_data'];
		// print_r($data);die;
		// $data['meta_data']['title'] = $data['question_data']['name'];
		if (!empty($userId)) {
			$get_quiz_summary_share = $this->quiz_model->get_quiz_summary_share($data['quiz_id'], $userId);
			$correct_ans_array = array();
			// print_r($data);die;	
			$wrong_ans_array = array();
			// echo "<pre>--total";
			foreach ($get_quiz_summary_share as $key => $value) {
				if ($value['ans_status'] == 'right') {
					$correct_ans_array[] = $value;
				} else {
					$wrong_ans_array[] = $value;
				}
			}
			$data['count_correct'] = count($correct_ans_array);
			$data['count_wrong'] = count($wrong_ans_array);
			$data['player_level'] = quiz_player_statistic($data['count_correct'], $data['count_wrong']);
			$user_name = $this->quiz_model->get_user_name($userId);
			$data['name'] = empty($user_name['name']) ? 'CW360#' . $userId : $user_name['name'];
			$data['meta_data']['title'] = $data['name'] . ' has been rated ' . $data['player_level']['article'] . ' ' .
				ucfirst($data['player_level']['type']) . ' on ' . $data['attempt_question_quiz_ans'][0]['quiz_title'];
			$data['meta_data']['meta_description'] = 'CrowdWisdom360 Predictions and Quizzes';
		}
		$data['sidebar_blogs'] = $this->sidebar_model->get_all_blogs(sidebar_card_limit(), '', 0);
		$data['sidebar_games'] = $this->sidebar_model->get_all_games(sidebar_card_limit(), '', 0);
		$this->load->view('header', $data);
		$this->load->view('quiz_preview', $data);
		$this->load->view('footer', $data);
	}
}
