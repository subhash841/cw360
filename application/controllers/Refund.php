<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Refund extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
    }

	public function index($type="") {
        $header_data['uid'] = $this->user_id ;
        $header_data['page_title'] = "Refund";
        //$data['game_list'] = $this->home_model->active_game_list();
        // print_r($header_data['uid']);die;
        $header_data['type'] = $type;
        if($type=='app'){
        $this->load->view("header", $header_data);
        $this->load->view("refund");
        }else{
        $this->load->view("header", $header_data);
        $this->load->view("refund");
        $this->load->view("footer");
        }
    }

}
