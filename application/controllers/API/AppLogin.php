<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AppLogin extends CI_Controller
{
  	public function __construct(){
      parent::__construct();
      $this->load->model('API/AppLogin_model');
      $this->load->helper('common_api_helper');
	  $this->load->library('notification');
	  
    }

	public function user_login(){
	    $inputs =$this->input-> post();
        $login_type = $inputs['login_type'];
        $email = $inputs[ 'email' ];
        $device_type = $inputs[ 'device_type' ];
        $macid_unique = $inputs[ 'macid_unique' ];

        if(!in_array($login_type,array('Facebook','Google'))){
            sendjson(array('status'=>FALSE,'message'=>'Invalid login type.'));
        }/* else if(!in_array($device_type,array('Web','Android'))){
          sendjson(array('status'=>FALSE,'message'=>'Invalid device type.'));
        } */else if($login_type == 'Google' && empty($email)) {
          sendjson(array('status'=>FALSE,'message'=>'Empty Email.'));
        }/* else if(empty($device_type)) {
          sendjson(array('status'=>FALSE,'message'=>'Empty device type.'));
        } */else if(empty($macid_unique)) {
          sendjson(array('status'=>FALSE,'message'=>'Empty macid unique id.'));
        }else {
        	// print_r($check_macId);die;
           		$data=$this->AppLogin_model->authenicate($inputs);
              // print_r($data['status']);die;
              if(empty($data['status'])){               
                sendjson( array('status'=>FALSE,'message'=>$data['message']));      
              }else{
               	sendjson( array('status'=>TRUE,'message'=>'Data found','data'=> $data));      
              }
        }							
	}

	public function user_tnc() {
		$authenicate=authenicate_access_token(getallheaders());        
       	if($authenicate=='1'){
       	    $inputs = $this->input->post();
	        $user_id =$inputs['user_id' ];
	        if(empty($user_id)){
	            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
	        }else if($user_id>0){
				$data = $this->AppLogin_model->update_notifications_id($user_id);
				if($data==true){
					$this->AppLogin_model->check_tnc_login($user_id);
				}				
	           sendjson(array("status" => TRUE, "message" => "Tnc agreed successfully","data"=>''));
	        }else{
	            sendjson(array( "status" => FALSE, "message" => "Seems that you are not logged in"));
	        }
       	}else{ sendjson($authenicate); }

    }


    public function update_profile() {
    	$authenicate=authenicate_access_token(getallheaders());   
    	// print_r($_POST);die;     
       	if($authenicate=='1'){
     	    $inputs = $this->input->post();
	        $user_id = $inputs['user_id'];
	   		  if(empty($user_id)){
	            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
	        }else if($user_id>0){	            
	   		 $data = $this->AppLogin_model->update_user_profile( $inputs );	          
          		sendjson( array ( "status" => TRUE, "message" => "Profile updated successfully!","data"=>""));
	        }else{
	            sendjson( array ( "status" => FALSE, "message" => "Seems that you are not logged in" ) );
	        }
    	}else{ 
    		sendjson($authenicate); 
    	}
        
    }



    public function update_profile_image() {
        $authenicate=authenicate_access_token(getallheaders());   
        // print_r($_POST);die;     
        if($authenicate=='1'){
            $inputs = $this->input->post();
            $user_id = $inputs['user_id'];
            $main_image=$inputs['main_image'];
            if(empty($user_id)){
                sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
            }else if(empty($main_image)){
                sendjson(array ("status" => FALSE, "message" => "Please provide profile image."));
            }else if($user_id>0){               
             $data = $this->AppLogin_model->update_user_profile_image( $inputs );           
                sendjson( array ( "status" => TRUE, "message" => "Profile image updated successfully!","data"=>""));
            }else{
                sendjson( array ( "status" => FALSE, "message" => "Seems that you are not logged in" ) );
            }
        }else{ 
            sendjson($authenicate); 
        }
        
    }
    public function update_profile_details() {
    	$authenicate=authenicate_access_token(getallheaders());   
    	// print_r($_POST);die;     
       	if($authenicate=='1'){
     	    $inputs = $this->input->post();
	        $user_id = $inputs['user_id'];
	   		  if(empty($user_id)){
	            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
	        }else if($user_id>0){	            
	   		 $data = $this->AppLogin_model->update_profile_details( $user_id );	          
          		sendjson( array ( "status" => TRUE, "message" => "Profile details data found.","data"=> $data ));
	        }else{
	            sendjson( array ( "status" => FALSE, "message" => "Seems that you are not logged in" ) );
	        }
    	}else{ 
    		sendjson($authenicate); 
    	}
        
    }

    public function user_logout() {
		/* $authenicate=authenicate_access_token(getallheaders());        
       	if($authenicate=='1'){ */
       	    $inputs = $this->input->post();
	        $user_id =$inputs['user_id' ];
	        if(empty($user_id)){
	            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
	        }else if($user_id>0){
	            $data = $this->AppLogin_model->logout($user_id);
	           sendjson(array("status" => TRUE, "message" => "You are logged out successfully","data"=>''));
	        }else{
	            sendjson( array ( "status" => FALSE, "message" => "Seems that you are not logged in" ) );
	        }
       	// }else{ sendjson($authenicate); }

    }


    public function update_user_coins() {
    	$authenicate=authenicate_access_token(getallheaders());   
    	// print_r($_POST);die;     
       	if($authenicate=='1'){
     	    $inputs = $this->input->post();
	        $user_id = $inputs['user_id'];
	   		  if(empty($user_id)){
	            sendjson(array ("status" => FALSE, "message" => "Please provide user id"));
	        }else if($user_id>0){	            
	   		   $data = getUserCoins();
          		sendjson(array("status" => TRUE, "message" => "update user coins found","data"=> $data));
	        }else{
	            
	            sendjson(array("status" => FALSE, "message" => "Seems that you are not logged in"));
	        }
    	}else{ 
    			sendjson($authenicate); 
    	}
        
    }

}
?>
