<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class AppReward extends CI_Controller
{

  public function __construct(){
    parent::__construct();
    $this->load->model(array('API/AppHome_model','API/AppCommon_model'));
    $this->load->config('api_validationrules', TRUE);
    $this->load->helper('common_api_helper');
  }



  /*********************REWARD LIST************************/
  public function get_rewards(){
    $data = $this->AppCommon_model->get_rewards();
    sendjson(array('status'=>TRUE,'message'=>'Data found','data'=> $data));
  }
  public function get_redeem_coin(){
    $authenicate=authenicate_access_token(getallheaders());
    if($authenicate==1){
      $user_id=$this->input->post('user_id');
      // echo $user_id;die;
        $data = $this->AppCommon_model->getRedeemUserCoins($user_id);
        sendjson(array('status'=>TRUE,'message'=>'Data found','data'=> $data));
    }else{
      sendjson($authenicate);
    }
  }


public function point_redeem(){
    $authenicate=authenicate_access_token(getallheaders());
    if($authenicate==1){
      $user_id=$this->input->post('user_id');
      $point_redeem=$this->input->post('point_redeem');
      $check_redeemable_user_coins=$this->AppCommon_model->getRedeemUserCoins($user_id);
      $user_coins=$check_redeemable_user_coins['coins'];
      if($user_coins < $point_redeem || $point_redeem == '0')
      {
        sendjson(array('status'=>FALSE,'msg'=>'Not Enough Coins'));
      }else{
        $redeem = $this->AppCommon_model->insert_redeem_data();   
        if($redeem){
          sendjson(array('status'=>TRUE,'msg'=> "Redeemable Coins Request Succesfully Sent."));
        }else{
          sendjson(array('status'=>FALSE,'msg'=>'unsuccessful'));

        }
      }

    }else{
      sendjson($authenicate);
    }


  }

}
?>