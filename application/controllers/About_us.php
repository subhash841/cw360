<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class About_us extends CI_Controller {
		function __construct()
    {
        parent::__construct();
        $sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
        // $setUniqueId=get_cookie('setUniqueId');  
        // echo $setUniqueId;die;
    }


    function index($type=""){
        $header_data['uid'] = $this->user_id;
        $header_data['page_title'] = "About Us";
        $header_data['type'] = $type;
        if($type=="app"){
            $this->load->view("header", $header_data);
            $this->load->view("about_us");
        }else{
            $this->load->view("header", $header_data);
            $this->load->view("about_us");
            $this->load->view("footer");
        }    
    }

}