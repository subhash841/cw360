<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AppHistory extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('API/AppCommon_model');
      	$this->load->helper('common_api_helper');
	}


	function WalletHistoryLoadGames(){
        $authenicate=authenicate_access_token(getallheaders());
        if($authenicate=='1'){
        	$inputs = $this->input->post();
            $user_id = $inputs['user_id'];
            $offset = $inputs['offset'];
            $count = $inputs['count'];
        $result = $this->AppCommon_model->get_history($user_id,$offset,$count);
                 if($result){
	                 sendjson(array('status'=>TRUE, "message" => "Wallet History data found.",'data'=>$result));
	            }else{
	                 sendjson(array('status'=>FALSE,'message'=>'No data found' ));
	            }
       }else{ 
        		sendjson($authenicate);
        }
    }

    function getWalletHistory(){
    	$authenicate=authenicate_access_token(getallheaders());
        if($authenicate=='1'){
        	$inputs = $this->input->post();
            $user_id = $inputs['user_id'];
            $offset = $inputs['offset'];
			$count = $inputs['count'];
	     	if(empty($user_id)){
	            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
	        }else if(!empty($user_id) ){
				$result = $this->AppCommon_model->get_history($user_id,$offset,$count);
			
	            // echo $this->db->last_query();die;
	            if($result){
	                 sendjson(array('status'=>TRUE, "message" => "Wallet History data found.",'data'=>$result));
	            }else{
	                  sendjson(array('status'=>FALSE,'message'=>'No data found' ));
	            }
	            
	        }else{
	            sendjson(array('status'=>FALSE,'message'=>'Invalid argument pass' ));
	        }
        }else{ 
        		sendjson($authenicate);
        }
	}
	

	public function getPurchaseHistory(){
    	$authenicate=authenicate_access_token(getallheaders());
        if($authenicate=='1'){
        	$inputs = $this->input->post();
            $user_id = $inputs['user_id'];
	       
	     	if(empty($user_id)){
	            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
	        }else if(!empty($user_id) ){
				$result = $this->AppCommon_model->get_subscription_history($user_id);
			
	            // echo $this->db->last_query();die;
	            if($result){
	                 sendjson(array('status'=>TRUE, "message" => "Purchase History data found.",'data'=>$result));
	            }else{
	                  sendjson(array('status'=>FALSE,'message'=>'No data found' ));
	            }
	            
	        }else{
	            sendjson(array('status'=>FALSE,'message'=>'Invalid argument pass' ));
	        }
        }else{ 
        		sendjson($authenicate);
        }
    }


} 
