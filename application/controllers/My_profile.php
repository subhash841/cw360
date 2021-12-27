<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class My_profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
         $this->load->model(array('users_model','sidebar_model'));
        $this->load->config('validationrules', TRUE);
    }

    function index() {
        $getData = $this->input->get();
        if (!empty($getData)) {
            $data['referrer'] = $getData['referrer'];
            $data['gameId'] = $getData['gameId'];
        }else{
            $data['referrer'] = '';
            $data['gameId'] = '';
        }
           // echo $this->agent->referrer();die;
        $header_data['uid'] = $this->user_id;
        $header_data['page_title'] = "My Profile";
        $data['my_profile'] = $this->users_model->my_profile($this->user_id);
        $this->load->view("header", $header_data);
        $this->load->view("my_profile", $data);
        $this->load->view("footer");
    }


    function update_profile() {
        $data = array();
        $validationResult = $this->users_model->validatepostdata();
        $_POST['user_id'] = $this->user_id;
         if ($validationResult === FALSE) {
            $data['status'] = 'failure';
            $data['data'] = '';
            $data['error'] = array(
                'name' => strip_tags(form_error('name')),
                'gender' => strip_tags(form_error('gender')),
                'dob' => strip_tags(form_error('dob')),
                'phone' => strip_tags(form_error('phone')),
                'email' => strip_tags(form_error('email')),
            );
        } else {
                $data['status'] = 'success';
                $data['message'] = 'Profile Updated Sucessfully';
                $data['user_id'] = $this->users_model->update_profile();
        }
        echo json_encode($data);
    }

        public function edit_profile_page()
    {
          $user_session_data = $this->session->userdata('data');
        if (empty($user_session_data['uid'])) 
        {
            redirect(base_url() . 'login?section=My_profile/edit_profile_page');
        }
        else
        {
        $data=array();
        $data['sidebar_blogs'] = $this->sidebar_model->get_all_blogs(sidebar_card_limit(),'',0);
        $data['sidebar_quiz'] = $this->sidebar_model->get_all_quiz(sidebar_card_limit(),'',0);
        $this->load->view('header');
        $this->load->view('edit_profile',$data);
        $this->load->view('footer');
        }
   }

}
