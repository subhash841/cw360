<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AppBlog extends CI_Controller
{

  public function __construct(){
    parent::__construct();
    $this->load->model(array('API/AppBlog_model','API/AppCommon_model','sidebar_model'));
    $this->load->config('api_validationrules', TRUE);
    $this->load->helper('common_api_helper');
  }


  /*BLOGS DETAILS*/
  public function detail(){
    $inputs = $this->input->post();
    $id = isset($inputs['blog_id']) ? $inputs['blog_id']:0;
    $user_id = isset($inputs['user_id']) ? $inputs['user_id']:0;


    if(!empty($id)){
      $data['blog'] = $this->AppBlog_model->get_blog_detail($id);
      $data['blog']['user_like'] = 0;
      if(!empty($user_id)){

        $result =$this->AppBlog_model->get_user_like($id,$user_id);
        if(!empty($result)){
          $data['blog']['user_like'] = 1;
        }
      }
      $data['comment'] = $this->AppBlog_model->get_comments($id,$user_id);
            $data['sidebar_games'] = $this->sidebar_model->get_all_games(sidebar_card_limit(),$data['blog']['topic_id'],0);
            $data['sidebar_quiz'] = $this->sidebar_model->get_all_quiz(sidebar_card_limit(),$data['blog']['topic_id'],0);
            sendjson(array('status' =>TRUE,'message'=>'Blog Detail available','data' => $data));
          }else{
            sendjson(array('status'=>FALSE,'message'=>'Blog ID required'));
          }
        }



        function update_view(){
          $inputs = $this->input->post();
          $id = isset($inputs['blog_id']) ? $inputs['blog_id']:0;
          if($id !=''){
            $result = $this->AppBlog_model->update_view_count($id);
            sendjson(array('status' => TRUE,'count' =>$result,'message'=>'View Updated successfully'));
          }else{
            sendjson(array('status' => FALSE,'message'=>'Blog ID required'));
          }
        }


        function update_like(){
          $authenicate=authenicate_access_token(getallheaders());   
          if($authenicate==1){
            $inputs = $this->input->post();
            $blog_id = isset($inputs['blog_id']) ? $inputs['blog_id']:0;
            $user_id = isset($inputs['user_id']) ? $inputs['user_id']:0;

            if(!empty($user_id) && !empty($blog_id)){
              $result = $this->AppBlog_model->update_blog_like($blog_id,$user_id);
              sendjson(array('status' => TRUE,'count' => $result));
            }else{
              sendjson(array('status'=>FALSE,'message'=>'Invalid login'));
            }

          }else{
            sendjson($authenicate);
          }
        }


        function add_user_blog(){
          $authenicate=authenicate_access_token(getallheaders());   
          if($authenicate==1){
            $inputs = $this->input->post();
            $title = isset($inputs['title']) ? $inputs['title']:'';
            $image = isset($inputs['image']) ? $inputs['image']:'';
            $description = isset($inputs['description']) ? $inputs['description']:'';
            $user_id = isset($inputs['user_id']) ? $inputs['user_id']:0;

            if(empty($title) || empty($image) || empty($description) || empty($user_id)){
              sendjson(array('status' => FALSE,'message' => 'Invalid data'));
            }else{

              $result = $this->AppBlog_model->add_user_blog($user_id,$title,$image,$description);
              if($result){
                sendjson(array('status' => TRUE,'message' => 'Blog added successfully'));
              }else{
                sendjson(array('status' => TRUE,'message' => 'Unable to add blog'));
              }
            }

          }else{
            sendjson($authenicate);
          }  
        }


        function addcomment(){
          $authenicate=authenicate_access_token(getallheaders());
          if($authenicate==1){
            $inputs = $this->input->post();
            $comment = isset($inputs['comment']) ? $inputs['comment']:'';
            $blog_id = isset($inputs['blog_id']) ? $inputs['blog_id']:0;
            $user_id = isset($inputs['user_id']) ? $inputs['user_id']:0;

            if(!empty($user_id)){
              if(empty($comment) || $blog_id ==''){
                sendjson(array('status' => TRUE,'message' =>'Incomplete request'));

              }else{
               $result =$this->AppBlog_model->add_blog_comment($blog_id,$user_id,$comment);
               if($result){
               // $comment = $this->AppBlog_model->get_comment($result);
                $comment = $this->AppBlog_model->get_comments($blog_id,$user_id);
                if($comment){
                  sendjson(array('status' => TRUE,'message' => 'Comment added successfully','data'=>$comment));

                }else{

                  sendjson(array('status' => FALSE,'message' =>'Unable to add comment'));
                  
                }
              }else{
                sendjson(array('status'=>FALSE,'message'=>'Unable to add comment'));
              }
            }
          }else{
            sendjson(array('status'=>FALSE,'message'=>'Invalid login'));
          }

        }else{
          sendjson($authenicate);
        }
      }


      function update_comment_like(){
        $authenicate=authenicate_access_token(getallheaders());
        if($authenicate==1){
          $inputs = $this->input->post();
          $blog_id = isset($inputs['blog_id']) ? $inputs['blog_id']:0;
          $comment_id = isset($inputs['comment_id']) ? $inputs['comment_id']:'';
          $user_id = isset($inputs['user_id']) ? $inputs['user_id']:0; 

          if(!empty($user_id)){
            if(empty($blog_id) || empty($comment_id)){

              sendjson(array('status' => FALSE,'message' =>'Incomplete Request'));

            }else{
              $result =$this->AppBlog_model->update_comment_like($blog_id,$user_id,$comment_id);
              sendjson(array('status'=>TRUE,'data'=> $result));
            }

          }else{
            sendjson(array('status'=>FALSE,'message'=>'Invalid login'));
          }
        }else{
          sendjson($authenicate);

        }
      }



      function get_comment_replies(){
        $inputs = $this->input->post();
        //$user_id = isset($inputs['user_id']) ? $inputs['user_id']:0;
        $user_id = $inputs['user_id'];
        if($user_id != '0'){
          $authenicate=authenicate_access_token(getallheaders());
          if($authenicate==1){
            $comment_id = isset($inputs['comment_id']) ? $inputs['comment_id']:'';
            if($comment_id !=''){
              $result= $this->AppBlog_model->get_comment_replies($comment_id,$user_id);
              if($result){
                sendjson(array('status'=>TRUE,'message'=>'replies fetch sucessfully','data'=>$result));
              }else{
                sendjson(array('status'=>FALSE,'message'=>'replies not found'));
              }
            }else{
              sendjson(array('status'=>FALSE,'message'=>'replies not found'));
            }

          }else{
            sendjson($authenicate);
          }

        }else{
          //echo 'test';
          $comment_id = isset($inputs['comment_id']) ? $inputs['comment_id']:'';
          if($comment_id !=''){
            $result= $this->AppBlog_model->get_comment_replies($comment_id,$user_id);
            if($result){
              sendjson(array('status'=>TRUE,'message'=>'replies fetch sucessfully','data'=>$result));
            }else{
              sendjson(array('status'=>FALSE,'message'=>'replies not found'));
            }
          }else{
            sendjson(array('status'=>FALSE,'message'=>'replies not found'));
          }
        }
      }




    /*function add_reply(){
      $authenicate=authenicate_access_token(getallheaders());
      if($authenicate==1){
          $inputs = $this->input->post();
          $comment_id = isset($inputs['comment_id']) ? $inputs['comment_id']:'';
          $reply = isset($inputs['reply']) ? $inputs['reply']:'';
          $blog_id = isset($inputs['blog_id']) ? $inputs['blog_id']:0;
          $user_id = isset($inputs['user_id']) ? $inputs['user_id']:0; 

          if(!empty($user_id)){
            if(empty($comment_id) || $blog_id =='' || empty($reply)){
                sendjson(array('status' => TRUE,'message' => 'Incomplete Request'));
            }else{
              $result =$this->AppBlog_model->add_reply($user_id, $comment_id, $blog_id, $reply);
              if($result){
                sendjson(array('status'=>TRUE,'message'=>'Reply added successfully'));
            }else{
                sendjson(array('status'=>FALSE,'message'=>'Unable to add reply'));
            }

        }
    }else{
        sendjson(array('status'=>FALSE,'message'=>'Invalid login'));
    }
    }else{
        sendjson($authenicate);
    }
  }*/



  function add_reply(){
    $authenicate=authenicate_access_token(getallheaders());
    if($authenicate==1){
      $inputs = $this->input->post();
      $comment_id = isset($inputs['comment_id']) ? $inputs['comment_id']:'';
      $reply = isset($inputs['reply']) ? $inputs['reply']:'';
      $blog_id = isset($inputs['blog_id']) ? $inputs['blog_id']:0;
      $user_id = isset($inputs['user_id']) ? $inputs['user_id']:0; 

      if(!empty($user_id)){
        if(empty($comment_id) || $blog_id =='' || empty($reply)){
          sendjson(array('status' => TRUE,'message' => 'Incomplete Request'));
        }else{
          $result =$this->AppBlog_model->add_reply($user_id, $comment_id, $blog_id, $reply);
          $data = $this->AppBlog_model->get_comment_replies($comment_id,$user_id);
          if($result){
            sendjson(array('status'=>TRUE,'message'=>'Reply added successfully','data'=>$data));
          }else{
            sendjson(array('status'=>FALSE,'message'=>'Unable to add reply'));
          }

        }
      }else{
        sendjson(array('status'=>FALSE,'message'=>'Invalid login'));
      }
    }else{
      sendjson($authenicate);
    }
  }


  function update_comment_reply_like(){

    $authenicate=authenicate_access_token(getallheaders());
    if($authenicate==1){

      $inputs = $this->input->post();
      $blog_id = isset($inputs['blog_id']) ? $inputs['blog_id']:0;
      $comment_reply_id = isset($inputs['comment_reply_id']) ? $inputs['comment_reply_id']:0;
      $user_id = isset($inputs['user_id']) ? $inputs['user_id']:0;

      if(!empty($user_id) && !empty($blog_id) && !empty($comment_reply_id)){
        $result =$this->AppBlog_model->update_comment_reply_like($blog_id,$user_id,$comment_reply_id);
        sendjson(array('status'=>TRUE,'data'=>$result));
      }else{
        sendjson(array('status'=>FALSE,'message'=>'Invalid login'));
      }
    }else{
      sendjson($authenicate);
    }
  }











}
?>
