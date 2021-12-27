<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Privacypolicy extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        $sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
    }

	public function index($type='') {
        $header_data['uid'] = $this->user_id ;
        $header_data['page_title'] = "Privacy Policy";
        $header_data['type'] = $type;
        //$data['game_list'] = $this->home_model->active_game_list();
        // print_r($header_data['uid']);die;
        // echo $type;die;
        if($type=='app'){
            $this->load->view("header", $header_data);
            $this->load->view("privacy_policy");
        }else{
            $this->load->view("header", $header_data);
            $this->load->view("privacy_policy");
            $this->load->view("footer");
        }
    }

}
