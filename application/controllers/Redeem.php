<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Redeem extends CI_Controller {
		function __construct()
    {
        parent::__construct();
        $sessiondata = $this->session->userdata('data');
        $this->load->model('redeem_model');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
    }


    function point_redeem(){
        $redeem=$this->redeem_model->insert_redeem_data();   
        echo json_encode($redeem);
    }    

}