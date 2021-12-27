<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriptions extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model(array('subscription_plans_model'));
       	$sessiondata = $this->session->userdata('data');
		if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        }else{
            $this->user_id=0;
        }
	}

	public function index()
	{	
		
		$data['get_subscription_list']=$this->subscription_plans_model->get_subscription_list();
		$this->load->view('header');
		$this->load->view('subscriptions',$data);
		$this->load->view('footer');
	}

	public function footer(){		
		$this->load->view('header');
		$this->load->view('footer');

	}
	public function payment_neft(){		
		$this->load->view('header');
		$this->load->view('payment_neft');
		$this->load->view('footer');

	}
	

}
