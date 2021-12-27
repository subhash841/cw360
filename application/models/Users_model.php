<?php
class Users_model extends CI_Model {

  	
    public function validatepostdata(){
        $this->form_validation->set_rules($this->config->item('profile', 'validationrules'));
         if ($this->form_validation->run() == FALSE) {          
              return FALSE;
          } else {
              return TRUE;
          }
    }

    function my_profile($user_id) {    
        $this->db->select('name, DATE_FORMAT(dob,"%d/%m/%Y")as dob, gender, phone, email, is_phone_verified');
        $this->db->from("users");     
        $this->db->where('id',$user_id);
        return $this->db->get()->row_array();
    }

    function get_user_wallet_data($user_id) {    
        $this->db->select('g.title, game_points');
        $this->db->from("game_point_history gh");     
        $this->db->join("games g","g.id=gh.game_id");     
        $this->db->where('gh.user_id',$user_id);
        return $this->db->get()->result_array();
    }
    
    public function update_profile(){
      $date = $this->input->post('dob');
    /*  $dob = date("d/m/Y", strtotime($date));*/

      $update_array= array(
                          'name' => $_POST['name'],
                          'gender' => $_POST['gender'],
                          'phone' => $_POST['phone'],                         
                          'dob' => $date,                         
                          'email' => $_POST['email'],                          
                          'image' => $_POST['main_image'],                          
         );
        //print_r($update_array);die;
    $this->db->where('id',$_POST['user_id']);
    if($this->db->update('users',$update_array)){       
       $_SESSION['data']['email']=$_POST['email'];
       return true;
    }else{
      return false;
    }
  }




  public function validateMobile(){

        $this->form_validation->set_rules($this->config->item('mobile', 'api_validationrules'));
        
         if ($this->form_validation->run() == FALSE) {          
              return FALSE;
          } else {
              return TRUE;
          }
  }

  public function fb_otp_verified($id,$phone,$country_code,$user_id=0){

        $otp_status = array('is_phone_verified' => '1','phone_verify_id' => $id,'phone' => $phone,'country_code' => $country_code);
        $this->db->where('id',$user_id);
        $this->db->update('users',$otp_status);
        return TRUE;
  }

  public function is_already_verified($mobile_no=0){

        $this->db->select('id');
        $this->db->from("users");          
        $this->db->where('phone',$mobile_no);
        $this->db->where('is_phone_verified','1');
        return $this->db->get()->result_array();
  }

  public function insert_otp($otp,$user_id=0){
        $otp_array = array('otp' => $otp);

        $this->db->where('id',$user_id);
        $this->db->update('users',$otp_array);
  }
  public function get_otp($user_id=0){
        $this->db->select('otp');
        $this->db->from("users");          
        $this->db->where('id',$user_id);
        return $this->db->get()->row_array();
  }
  public function validateOTP(){

        $this->form_validation->set_rules($this->config->item('otp', 'api_validationrules'));
        
         if ($this->form_validation->run() == FALSE) {          
              return FALSE;
          } else {
              return TRUE;
          }
  }
  public function insert_otp_status($user_id=0,$phone){
        $otp_status = array('is_phone_verified' => '1','phone' => $phone);
        $this->db->where('id',$user_id);
        $this->db->update('users',$otp_status);
  }

  public function get_phone($user_id=0){
        $this->db->select('phone, is_phone_verified');
        $this->db->from("users");          
        $this->db->where('id',$user_id);
        return $this->db->get()->row_array();
  }

}  
?>