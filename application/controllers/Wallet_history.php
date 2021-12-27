<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wallet_history extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
        $this->load->model(array('games_model','Wallet_history_model'));
    }


    function index(){
        $header_data['uid'] = $this->user_id;
        $header_data['page_title'] = "Wallet history";
        $data['sidebar_games'] = $this->games_model->get_all_games();
        $data['wallet_history'] = $this->Wallet_history_model->get_history($this->user_id);
        $this->load->view("header", $header_data);
        $this->load->view("wallet_history",$data);
        $this->load->view("footer");
    }

    function load_games(){
        $offset = $_POST['offset'];
        $result = $this->games_model->get_all_games($offset);
        echo json_encode($result);
    }

    function get_history(){
        $offset = @$_POST['offset'];
        if(!empty($offset) && !empty($this->user_id) ){
            $result = $this->Wallet_history_model->get_history($this->user_id,$offset);
            if($result){
                echo json_encode(array('status'=>TRUE,'data'=>$result ));
            }else{
                echo json_encode(array('status'=>FALSE,'msg'=>'unable to get data' ));
            }
            
        }else{
            echo json_encode(array('status'=>FALSE,'msg'=>'Invalid argument pass' ));
        }
    }

    

}