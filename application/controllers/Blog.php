<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blog extends CI_Controller {
  
  function __construct() {
      parent::__construct();
      $this->load->model(array('Blog_model','games_model','quiz_model','sidebar_model'));

      $sessiondata = $this->session->userdata('data');
      if (!empty($sessiondata)) {
          $this->user_id = $sessiondata['uid'];
      }else{
          $this->user_id=0;
      }
    }

    function detail_old($id=''){
        $data['user_like'] = 0;
        $data['user_id'] = $this->user_id;

        if(!empty($this->user_id)){
            $result =$this->Blog_model->get_user_like($id,$this->user_id);
            if(!empty($result) ){
              $data['user_like'] = 1;
            }
        }

        if(!empty($id)){
            $data['blog'] = $this->Blog_model->get_blog_detail($id);
            if(empty($data['blog'])){
                redirect('home');
            }
            $data['comment'] = $this->Blog_model->get_comments($id,$this->user_id);
            $data['sidebar_games'] = $this->games_model->get_all_games();
            $data['meta_data'] =  $data['blog'];
            $this->load->view('header',$data);
            $this->load->view('yourvoice',$data);
            $this->load->view('footer');
        }else{
          redirect('home');
        }
    }

    function detail($id=''){
        $data['user_like'] = 0;
        $data['user_id'] = $this->user_id;

        if(!empty($this->user_id)){
            $result =$this->Blog_model->get_user_like($id,$this->user_id);
            if(!empty($result) ){
              $data['user_like'] = 1;
            }
        }       
        $blogs = $this->Blog_model->get_blog_detail($id);
        if(!empty($id) && $blogs['is_approve']=='1'){
            $data['blog'] = $this->Blog_model->get_blog_detail($id);
            if(empty($data['blog'])){
                redirect('home');
            }
            $data['comment'] = $this->Blog_model->get_comments($id,$this->user_id);
//            $data['sidebar_games'] = $this->games_model->get_blog_games($data['blog']['topic_id']);
//            $data['sidebar_quiz'] = $this->quiz_model->get_quiz_by_topic_list(4, $data['blog']['topic_id']);
            $data['sidebar_games'] = $this->sidebar_model->get_all_games(sidebar_card_limit(),$data['blog']['topic_id'],0);
            $data['sidebar_quiz'] = $this->sidebar_model->get_all_quiz(sidebar_card_limit(),$data['blog']['topic_id'],0);
            /*echo '<pre>'; print_r($data['sidebar_games']);
            exit();*/
            $data['meta_data'] =  $data['blog'];
            $this->load->view('header',$data);
            $this->load->view('yourvoice',$data);
            $this->load->view('footer');
        }else{
          redirect('home');
        }
    }

     /*function load_games(){
        $offset = $_POST['offset'];
        $result = $this->games_model->get_all_games($offset);
        echo json_encode($result);
    }*/

    function all_list(){
        $data['all_blogs'] = $this->Blog_model->get_all_blog();
//        $data['sidebar_games'] = $this->games_model->get_all_games();
//        $data['sidebar_quiz'] = $this->quiz_model->get_quiz_list(4);
        $data['sidebar_games'] = $this->sidebar_model->get_all_games(sidebar_card_limit(),'',0);
        $data['sidebar_quiz'] = $this->sidebar_model->get_all_quiz(sidebar_card_limit(),'',0);
        $this->load->view('header');
        $this->load->view('yourvoice_list',$data);
        $this->load->view('footer');
    }

    function update_view(){
        $id = $_POST['id'];
        if($id !=''){
          $result = $this->Blog_model->update_view_count($id);
           echo json_encode($result);
        }
    }

    function update_like(){
      $blog_id= $_POST['blog_id'];
      if(!empty($this->user_id) && !empty($blog_id)){
          $result =$this->Blog_model->update_blog_like($blog_id,$this->user_id);
          echo json_encode($result);
       }else{
        echo json_encode(array('status'=>FALSE,'msg'=>'Invalid login'));
       }
    }

    function addcomment(){
        $comment = $_POST['comment'];
        $blog_id = $_POST['blog_id'];
        if(!empty($this->user_id) && !empty($comment) && $blog_id !=''){
            $result =$this->Blog_model->add_blog_comment($blog_id,$this->user_id,$comment);
            if($result){
                $comment = $this->Blog_model->get_comment($result);
                if($comment){
                    echo json_encode(array('status'=>TRUE,'msg'=>'Comment added successfully', 'data'=> $comment));
                }else{
                    echo json_encode(array('status'=>FALSE,'msg'=>'Unable to add comment'));
                }
            }else{
                echo json_encode(array('status'=>FALSE,'msg'=>'Unable to add comment'));
            }
        }else{
            echo json_encode(array('status'=>FALSE,'msg'=>'Invalid login'));
        }
    }

    function update_comment_like(){
        $blog_id= $_POST['blog_id'];
        $comment_id= $_POST['comment_id'];
        if(!empty($this->user_id) && !empty($blog_id) && !empty($comment_id)){
            $result =$this->Blog_model->update_comment_like($blog_id,$this->user_id,$comment_id);
            echo json_encode($result);
        }else{
            echo json_encode(array('status'=>FALSE,'msg'=>'Invalid login'));
        }
    }

    function get_comment_replies(){
        $comment_id = @$_POST['comment_id'];
        $user_id = $this->user_id;

        if($comment_id !=''){
            $result= $this->Blog_model->get_comment_replies($comment_id,$user_id);
            if($result){
                echo json_encode(array('status'=>TRUE,'msg'=>'replies fetch sucessfully','data'=>$result));
            }else{
                echo json_encode(array('status'=>FALSE,'msg'=>'replies not found'));
            }
        }else{
            echo json_encode(array('status'=>FALSE,'msg'=>'replies not found'));
        }
    }

    function add_reply(){
        $comment_id = $_POST['cmnt_id'];
        $reply = $_POST['reply'];
        $blog_id = $_POST['blog_id'];
        if(!empty($this->user_id) && !empty($comment_id) && $blog_id !='' && !empty($reply)){
            $result =$this->Blog_model->add_reply($this->user_id, $comment_id, $blog_id, $reply);
            if($result){
                echo json_encode(array('status'=>TRUE,'msg'=>'Reply added successfully'));
            }else{
                echo json_encode(array('status'=>FALSE,'msg'=>'Unable to add reply'));
            }
        }else{
            echo json_encode(array('status'=>FALSE,'msg'=>'Invalid login'));
        }
    }

    function add_user_blog(){
        $title = $_POST['title'];
        $image = $_POST['image'];
        $description = $_POST['description'];
        $user_id = $this->user_id;
        if(empty($title) || empty($image) || empty($description) || empty($user_id)){
            echo json_encode(array('status'=>FALSE,'msg'=>'Invalid data send'));
        }else{
            $result = $this->Blog_model->add_user_blog($user_id,$title,$image,$description);
            if($result){
                echo json_encode(array('status'=>TRUE,'msg'=>'Blog added sucessfully'));
            }else{
                echo json_encode(array('status'=>FALSE,'msg'=>'Unable to add your blog'));
            }
        }
    }

    function load_games(){
        $offset = $_POST['offset'];
        $topics = $_POST['topics'];
        $result = $this->games_model->get_blog_games( $topics,$offset);
        echo json_encode($result);
    }

    function update_comment_reply_like(){
        $blog_id= $_POST['blog_id'];
        $comment_reply_id= $_POST['comment_reply_id'];
        if(!empty($this->user_id) && !empty($blog_id) && !empty($comment_reply_id)){
            $result =$this->Blog_model->update_comment_reply_like($blog_id,$this->user_id,$comment_reply_id);
            echo json_encode($result);
        }else{
            echo json_encode(array('status'=>FALSE,'msg'=>'Invalid login'));
    }


    function load_quiz(){
        $offset = $_POST['offset'];
        $topics = $_POST['topics'];
        $result = $this->quiz_model->get_quiz_by_topic_list(4, $topics,$offset);
        echo json_encode($result);
    }
}

    function load_quiz(){
        $offset = $_POST['offset'];
        $topics = $_POST['topics'];
        $result = $this->quiz_model->get_quiz_by_topic_list(4, $topics,$offset);
        echo json_encode($result);
    }
}
