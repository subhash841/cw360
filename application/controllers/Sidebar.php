<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sidebar extends CI_Controller {
  
  function __construct() {
      parent::__construct();
      $this->load->model(array('sidebar_model'));

      $sessiondata = $this->session->userdata('data');
      if (!empty($sessiondata)) {
          $this->user_id = $sessiondata['uid'];
      }else{
          $this->user_id=0;
      }
    }
    
    function load_games(){
        $offset = $_POST['offset'];
        $topics = $_POST['topics'];
        $limit = sidebar_card_limit();
        $result = $this->sidebar_model->get_all_games($limit,$topics,$offset);
        echo json_encode($result);
    }
    
    function load_blogs(){
        $offset = $_POST['offset'];
        $topics = $_POST['topics'];
        $limit = sidebar_card_limit();
        $result = $this->sidebar_model->get_all_blogs($limit,$topics,$offset);
        echo json_encode($result);
    }
    
    function load_quiz(){
        $offset = $_POST['offset'];
        $topics = $_POST['topics'];
        $limit = sidebar_card_limit();
        $result = $this->sidebar_model->get_all_quiz($limit,$topics,$offset);
        echo json_encode($result);
    }
    
}

