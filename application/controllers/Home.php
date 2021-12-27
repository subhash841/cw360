<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        }else{
            $this->user_id=0;
        }
        $this->load->model(array('home_model','quiz_model','Blog_model'));       
        // $setUniqueId=delete_cookie('setUniqueId');  
        // $setUniqueId=get_cookie('session_cookie');
        //$session_cookie=$this->input->cookie('setUniqueId', TRUE);  
        // echo $session_cookie;die;
        // $cookie=$this->input->cookie('setUniqueId', TRUE);
        // $session_cookie=substr($cookie,5);
        // echo $session_cookie;die;
        // print_r($sessiondata);die;
    }

    function index($type='') {
     
        // print_r($_SESSION[ 'login_data' ]);die;
        // $this->session->sess_destroy();die;
        $data['topic_data']=$this->home_model->get_topic_list();
    	// $data['user_details']=$this->home_model->user_details($this->user_id);
           // echo $this->db->last_query();die;

    	// $data['topic_userwise_list']=$this->home_model->get_topic_list_userwise(true);
    	$data['prediction_games_list']=$this->home_model->get_prediction_games_list(true);
    	$data['userwise_prediction_games_list']=$this->home_model->get_prediction_games_userwise(true);
        $data['quiz_data']=$this->quiz_model->get_quiz_list();
        $data['all_blogs'] = $this->Blog_model->get_all_blog(6);
    	// echo $this->db->last_query();
    	// echo "<pre>";
    	// print_r($data['quiz_data']);die;
    	//$data['userwise_quiz_list']=$this->home_model->get_quiz_list_userwise(true);
    	// $data['blogs_list']=$this->home_model->get_blogs_list(true);
    	// $data['userwise_blogs_list']=$this->home_model->get_blogs_list_userwise(true);
        $this->load->view('header',$data);
        $this->load->view('home',$data);
        $this->load->view('footer',$data);
    }


    function sub_history(){
        $data['subscription_history_data']=$this->home_model->get_subscription_history();
        // print_r($this->db->last_query());die;
        echo json_encode($data);

    }

    function destroy_session()
    {
        $redirect_to = "Home";  

        if($_POST['popup_macId_chk']=='1'){
            //print_r($_SESSION);die;
                          $this->db->set('device_type',NULL);
                        $this->db->where('id', $this->user_id);
                        $this->db->update('users');  
            session_destroy();
            session_unset();
        }
        echo json_encode($redirect_to);
    }

    function get_notifications()
    {
       $data['notifications']=$this->home_model->get_notifications();
       echo json_encode($data);
    }
    function get_notification_count()
    {
      $user_notifications = $_POST['user_notifications'];
      $notification_ids = notification_ids(); 
      $data['notification_details'] = get_notification_details($notification_ids);
      $lastNotificationId = $data['notification_details']['lastNotificationId'];
      $data['new_notifications']=$this->home_model->get_new_notifications($lastNotificationId,$user_notifications); //get new notifications
      echo json_encode($data);
    }
    function get_user_coins()
    {
      $data['user_coins']=$this->home_model->get_user_coins();
      echo json_encode($data);
    }


}
