<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_users extends CI_Controller {

    function index(){
        $this->load->view('delete_user');
    }

    function deleteUser(){
    	$postData = $this->input->post();
    	$emails = $postData['emails'];
    	// $emailsArray = ;
    	$emailsArray = array_map('trim', explode(',', $emails));
    	$emailString = array();
    	foreach ($emailsArray as $value) {
    		$emailString[] = "'$value'";
    	}
    	if (!empty($emailString)) {
    		$allEmails = implode(',', $emailString);
	        $sqlQuery = "UPDATE users set social_id = REPLACE(social_id, social_id, concat(".mt_rand(10,1000000).",'_',social_id)), email = REPLACE(email, email, concat('old".mt_rand(10,1000)."','_',email)), macid_unique = REPLACE(macid_unique, macid_unique, concat('old".mt_rand(10,1000000)."','_',macid_unique)),app_macid_unique = REPLACE(app_macid_unique, app_macid_unique, concat('old".mt_rand(10,1000000)."','_',app_macid_unique)) WHERE email in(".$allEmails.")";
	        $this->db->query($sqlQuery);
	        if($this->db->affected_rows()>'0'){
	        	$data = array('status'=>true, 'type'=>'success', 'message'=>'User deleted successfully');
	        }else if ($this->db->affected_rows()=='0') {
	        	$data = array('status'=>false, 'type'=>'warning', 'message'=>'No user deleted from the given emails');
	        }else{
	        	$data = array('status'=>false, 'type'=>'error', 'message'=>'Something went wrong');
	        }
	        echo json_encode($data);
	    }
    }


}
