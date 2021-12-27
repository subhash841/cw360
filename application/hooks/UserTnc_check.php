<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserTnc_check
{
  protected $ci;
	public function __construct(){
        global $CI;
        $this->ci = &get_instance();
        $this->user_table ='users';
        $this->ci->load->model(array('Common_model'));
    }

	public function index(){
    $class = $this->ci->router->fetch_class();
       $session        = $this->ci->session->userdata('data');
       $check_login = $this->ci->Common_model->check_tnc_login($session['uid']);
      //print_r($class);die;
    if(!empty($session) && $class!='TnC' && $class!='login'){
       if($check_login['tnc_agree']!='1'){
          redirect('TnC');
       }
    }
     //print_r($session);die;
	}



 

}
?>