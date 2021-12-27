<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AppCommon extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('API/AppCommon_model');
      	$this->load->helper('common_api_helper');
	}


	public function games_sidebar($id){
		 

	}


} 