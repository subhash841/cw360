<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AppHome extends CI_Controller
{

  public function __construct(){
      parent::__construct();
      $this->load->model(array('API/AppHome_model','API/AppCommon_model'));
      $this->load->config('api_validationrules', TRUE);
      $this->load->helper('common_api_helper');
  }


  /*********************TOPICS LIST************************/
  public function topic_list(){
    $inputs = $this->input->post();
    $limit = isset($inputs['limit']) ? $inputs['limit']:'';
    $offset = isset($inputs['offset']) ? $inputs['offset']:'';
    $data = $this->AppHome_model->topic_list($limit,$offset);
    sendjson(array('status'=>TRUE,'message'=>'Data found','data'=> $data));
  }

   public function topic_game_list() {  
        $inputs = $this->input->post(); 
        $id = isset($inputs['id']) ? $inputs['id']:'';
        $user_id = isset($inputs['user_id']) ? $inputs['user_id']:0;
        $all_games = $this->AppHome_model->game_list();
        if(!empty($id)) {
            $topic_games = $this->AppHome_model->get_topicgames($id);
            $category_name = $this->AppHome_model->get_category_name($id);
            $data['topics_quiz_list'] = $this->AppHome_model->get_quiz_list(6,$id,'','',$user_id);
            $data['sidebar_blogs'] = $this->AppHome_model->get_all_blogs(sidebar_card_limit(),$id,0);
            $data['sidebar_quiz'] = $this->AppHome_model->get_all_quiz(sidebar_card_limit(),$id,0,$user_id);
            $data['category_id'] = $id;
            $data['category'] = array('all');
            $data['topics'] = array('all' => $all_games);

        if (empty(!$id)) {
            array_push($data['category'], $category_name['name']);
            $data['topics']['topic_name'] = $topic_games;
        }
        sendjson(array('status' =>TRUE,'message'=>'Data available','data' => $data));
      }else{
        sendjson(array('status' =>FALSE,'message'=>'Required Topic ID'));
      }
    }


  /*********************GAMES LIST************************/
  public function game_list(){
    $inputs = $this->input->post();
    $limit = isset($inputs['limit']) ? $inputs['limit']:'';
    $offset = isset($inputs['offset']) ? $inputs['offset']:'';
    // echo $limit;die;
    $data = $this->AppHome_model->game_list($limit,$offset);
    sendjson(array('status'=>TRUE,'message'=>'Data found','data' => $data));
  }


  /*********************QUIZ LIST************************/
  public function quiz_list(){
    $inputs = $this->input->post();
    $limit = isset($inputs['limit']) ? $inputs['limit']:'';
    $offset = isset($inputs['offset']) ? $inputs['offset']:'';
    $data = $this->AppHome_model->quiz_list($limit,$offset,$inputs['user_id']);
    if(empty($data)){
    sendjson(array('status'=>TRUE,'message'=>'No Quiz Available'));
    }else{
    sendjson(array('status'=>TRUE,'message' =>'Data found','data' => $data));
    }
  }

  public function sidebar_list(){
    $inputs = $this->input->post();
    $data['sidebar_games'] = $this->AppCommon_model->get_all_games_sidebar(sidebar_card_limit(),$inputs['topic_id'],0);
	  $data['sidebar_blogs'] = $this->AppCommon_model->get_all_blogs(sidebar_card_limit(),$inputs['topic_id'],0);
    $data['sidebar_quiz'] = $this->AppCommon_model->get_all_quiz(sidebar_card_limit(),$inputs['topic_id'],0,$inputs['user_id']);
    // print_r($data);die;
    //count of side bar data
    $data['sidebar_games_count'] = sizeof($this->AppCommon_model->get_all_games_sidebar('',$inputs['topic_id'],0));
	  $data['sidebar_blogs_count'] = sizeof($this->AppCommon_model->get_all_blogs('',$inputs['topic_id'],0));
    $data['sidebar_quiz_count'] = sizeof($this->AppCommon_model->get_all_quiz('',$inputs['topic_id'],0,$inputs['user_id']));
    if(empty($data)){
    sendjson(array('status'=>TRUE,'message'=>'No Sidebar Available'));
    }else{
    sendjson(array('status'=>TRUE,'message' =>'Data found','data' => $data));
    }
  }
  public function sidebar_list_load_more(){
    $inputs = $this->input->post();
    $offset = isset($inputs['offset']) ? $inputs['offset']:'';
    $data['sidebar_games'] = $this->AppCommon_model->get_all_games_sidebar(sidebar_card_limit(),$inputs['topic_id'],$offset);
    // echo $this->db->last_query();die;
	  $data['sidebar_blogs'] = $this->AppCommon_model->get_all_blogs(sidebar_card_limit(),$inputs['topic_id'],$offset);
    $data['sidebar_quiz'] = $this->AppHome_model->get_all_quiz(sidebar_card_limit(),$inputs['topic_id'],$offset,$inputs['user_id']);
    if(empty($data)){
    sendjson(array('status'=>TRUE,'message'=>'No Sidebar Available'));
    }else{
    sendjson(array('status'=>TRUE,'message' =>'Data found','data' => $data));
    }
  }



  /*********************BLOG LIST************************/
  public function blog_list(){
    $inputs = $this->input->post();
    $limit = isset($inputs['limit']) ? $inputs['limit']:'';
    //$limit = isset($inputs['limit']) ? $inputs['limit']:'';
    $data = $this->AppHome_model->blog_list($limit);
    sendjson(array('status'=>TRUE,'message' =>'Data found','data' => $data));
  }

   /*********************subscription LIST************************/
   public function subscription_list(){
     $data = $this->AppCommon_model->subscription_list();
     sendjson(array('status'=>TRUE,'message' =>'Data found','data' => $data));
    }
    /*********************get_notification LIST************************/

    function get_notifications_list()
    {
      $authenicate=authenicate_access_token(getallheaders());   
    	// print_r($_POST);die;     
       	if($authenicate=='1'){
           $inputs = $this->input->post();
           $user_id = $inputs['user_id'];
           if(empty($user_id)){
            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
        }else if($user_id>0){	            
          
          $data=$this->AppCommon_model->get_notifications($user_id);
            sendjson(array("status" => TRUE, "message" => "Notifications data found","data"=> $data));
        }else{
            
            sendjson(array("status" => FALSE, "message" => "Seems that you are not logged in"));
        }
            // sendjson(array('status'=>TRUE,'message' =>'Data found','data' => $data));

         }else{
          sendjson($authenicate);
         }
    }
  function get_notifications_count()
    {
      $inputs = $this->input->post();
      $user_notifications = $inputs['user_notifications'];
      $user_id = $inputs['user_id'];
      if(empty($user_id)){
        sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
      }else{
        $notification_ids = api_notification_ids($user_id); 
        $data['notification_details'] = api_get_notification_details($notification_ids,$user_id);
        // print_r($data);die;
        $lastNotificationId = $data['notification_details']['lastNotificationId'];
        if(empty($lastNotificationId)){
          sendjson(array('status'=>TRUE,'message' =>'No Data found'));
        }else{
          $data['new_notifications']=$this->AppCommon_model->get_new_notifications($lastNotificationId,$user_notifications,$user_id); //get new notifications
          sendjson(array('status'=>TRUE,'message' =>'Notifications data found','data' => $data));
        }
      }
    }
 
}
?>
