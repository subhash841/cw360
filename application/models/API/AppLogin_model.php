<?php

class AppLogin_model extends CI_Model{

    function __construct() {
        parent::__construct();
        $this->get_initial_coins="50";

    }
    public function validatepostdata(){
        $this->form_validation->set_rules($this->config->item('profile', 'validationrules'));
         if ($this->form_validation->run() == FALSE) {          
              return FALSE;
          } else {
              return TRUE;
          }
    }

	public function authenicate( $inputs ) {
        $name = $inputs[ 'name' ];
        $social_id = $inputs[ 'social_id' ];
        $email = $inputs[ 'email' ];
        $login_type = $inputs[ 'login_type' ];
        $device_type = $inputs[ 'device_type' ];
        $device_token = $inputs[ 'device_token' ];
        $app_macid_unique = $inputs[ 'macid_unique' ];
        $where_cond = "";
        if(($login_type == "Facebook" && !empty($email))||($login_type == "Google" && !empty($email))){
            $where_cond = " AND email = '$email'";
        }
		$auth_token=generate_access_token(); //create token
        $check_macId=$this->check_macid_unique($app_macid_unique);
        // var_dump($app_macid_unique);die;
		 if($check_macId['cnt_macid_unique']!= 0 ){
			 $where="login_type = '$login_type' AND social_id = '$social_id'  AND app_macid_unique = '$app_macid_unique' $where_cond";
		 }else{
            $where="login_type = '$login_type' AND social_id = '$social_id'  $where_cond";
		 }
	    $this->db->select( "id,name,email,login_type,alise,location,party_affiliation,certificate_path,unearned_points,tnc_agree,coins,macid_unique,device_type,device_token,app_macid_unique");
        $this->db->from("users");
        $this->db->where($where);
        $result = $this->db->get();
        $is_exists = $result->num_rows();
        $response = $result -> row_array();
        // echo $is_exists; die;
        // echo $this->db->last_query();die;
         // return array('status'=>FALSE,'message'=>"Logged in on ".$response["device_type"]); die; 
        // print_r($response);die;
        if($check_macId['cnt_macid_unique'] != "0" && $is_exists == "0"){
            return array('status'=>FALSE,'message'=>'You can login only with this mail '.$check_macId['email'].' ('.$check_macId['login_type'].')');
        }/* else if (!empty($response['device_type']) && $response['device_type'] != $device_type){
        	return array('status'=>FALSE,'message'=>"Logged in on ".$response["device_type"]); 
        } */else if($is_exists == "0"){
            $insert_array = array(
	                "name" => $name,
	                "social_id" => $social_id,
	                "twitter_id" => $twitter_handle,
	                "email" => $email,
	                "login_type" => $login_type,
	                "device_type" => $device_type,
                    "device_token" => $device_token,
	                "app_macid_unique" => $app_macid_unique,
	                "auth_token" => $auth_token,
                    // "created_date"=>date("%Y-%m-%d H:i:s")
                );
            $this->db->insert("users", $insert_array);
            $last_id =$this->db->insert_id();

            //insert coins
            $game_coins_data=array('coins'=> $this->get_initial_coins, 
                   'user_id'=>$last_id,
                   'created_date'=> date('Y-m-d H:i:s')
                );
            $this->db->insert( 'coins', $game_coins_data );                 
            $this->db->insert( 'wallet_history', $game_coins_data );

            $data = array (
                "id" =>"$last_id",
                "user_id" =>"$last_id",
                "name" =>$name,
                "email" =>$email,
                "login_type" =>$login_type,
                "device_type" =>$device_type,
                "tnc_agree" =>"0",                
                "auth_token" =>$auth_token,
                "free_coin" => $this->get_initial_coins
            );
            // $this->update_notifications_id($last_id);
            $data[ 'status' ] =TRUE;
            // print_r($data);die;
            return $data;
        }else {      
            $this->db->set('device_type',$device_type);
            $this->db->set('device_token',$device_token);
            $this->db->set('auth_token',$auth_token);
            $this->db->set('app_macid_unique',$app_macid_unique);
            $this->db->where('id',$response['id']);
            $this->db->update('users');
            $data[ 'status' ] =TRUE;
            $data[ 'tnc_agree' ] = $response[ 'tnc_agree' ];
            $data[ 'macid_unique' ] = $response[ 'app_macid_unique' ];
            $data[ 'user_id' ] = $response[ 'id' ];
            $data[ 'auth_token' ] = $auth_token;
            return $data;
        }
    }

    public function update_notifications_id($user_id){
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where("(user_id = $user_id OR user_id IS NULL) AND created_date BETWEEN NOW() - INTERVAL 10 DAY AND NOW() AND (game_id IS NULL OR game_id IS NOT NULL OR prediction_id IS NULL OR prediction_id IS NOT NULL) AND (CASE 
            WHEN prediction_id IS NOT NULL AND prediction_status IS NULL THEN FIND_IN_SET($user_id, user_id_set) ELSE TRUE END) AND created_date >= (SELECT created_date FROM users where id = $user_id)");     //Not to remove space after CASE word
        $this->db->order_by('id','DESC');
        $notifications = $this->db->get()->result_array();
        if (!empty($notifications)) {
            $lastNotificationId = $notifications[0]['id'];
                $this->db->set('last_notification_id', $lastNotificationId);
                $this->db->where('id', $user_id);
                $this->db->update('users');
                $msg=$this->get_initial_coins." coins have been added to your wallet.";
                $notifications_push=array("title"=>$msg,
                                          "coin"=>$this->get_initial_coins);
                            //  print_r($notifications_push);die;             
                $this->notification->get_ids_and_fields($notifications_push,$user_id);
        }
        return true;
    }
    public function check_tnc_login($id) {
        $this->db->set('tnc_agree','1');
        $this->db->where('id', $id);
        $this->db->update('users');
        return TRUE;
    } 


    public function logout($user_id) {
        $update_array = array (
            "device_token" => NULL,
            // "auth_token" => NULL,
            // "device_type" => NULL,
        );
        $this->db->where("id='$user_id'");
        $this->db->update("users",$update_array);
        return TRUE;
    }

    public function update_user_profile($inputs){
        $update_array= array(
                          'name' => $inputs['name'],
                          'gender' => $inputs['gender']=="Male" ? "m" :"f",
                          'phone' => $inputs['phone'],                         
                          'dob' => $inputs['dob'],                         
                          'email' => $inputs['email'],                          
                          'image' => $inputs['main_image'],                          
         );
            
        $this->db->where('id',$inputs['user_id']);
        if($this->db->update('users',$update_array)){       
            return true;
        }else{
          return false;
        }
    }

       public function update_user_profile_image($inputs){
        $update_array= array(                                
                          'image' => $inputs['main_image'],                          
         );
            
        $this->db->where('id',$inputs['user_id']);
        if($this->db->update('users',$update_array)){       
            return true;
        }else{
          return false;
        }
    }

    public function update_profile_details($id) {
        $this->db->select('id, name, social_id, twitter_id, email, login_type, alise, location, party_affiliation, is_active, tnc_agree, unearned_points, device_token, auth_token, (case when gender="m" then "Male"  when gender="f" then "Female" else "NA" end) as gender, image, phone, device_type, dob');
        $this->db->from('users');
        $this->db->where('id', $id);
        $res=$this->db->get()->row_array();
        return $res;
    } 
    public function check_macid_unique($macid) {
        // $arr=array("macid_unique"=>$macid);
        $this->db->select("count(app_macid_unique) as cnt_macid_unique,email,login_type,app_macid_unique");
        $this->db->from("users");
        $this->db->where("app_macid_unique", $macid);
        $res = $this->db->get()->row_array();      
         return $res;
    } 

}
?>
