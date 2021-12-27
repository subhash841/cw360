<?php

class AppSubscription_plans extends CI_Controller {

    function __construct() {
      parent::__construct();
        $this->load->model('subscription_plans_model');
        $this->load->helper('common_api_helper');
        $merchant_id;
        $encryption_key;
        $sub_merchant_id;
        $reference_no;
        $paymode;
        $return_url;
        $default_base_url;
        $points;
        $amount;

        $this->merchant_id            =   '267146';
        $this->encryption_key         =   '2669791971405500';
        $this->sub_merchant_id        =   '45';
        $this->reference_no           =    mt_rand(1000000000, 9999999999);
        $this->paymode                =   '9';
        $this->return_url             =   'https://www.crowdwisdom360.com/wallet/transactions';
        $this->$default_base_url      =   'https://eazypay.icicibank.com/EazyPG?';
    }

    function api_payment_url()
    {
      $authenicate=authenicate_access_token(getallheaders());
      if($authenicate=='1'){
        $postData = $this->input->post();
        $user_id = $postData['user_id'];          
        $package_id = $postData['package_id'];     
        if (empty($user_id)) {
              sendjson(array('status'=>false,'code'=>417,'message'=>'User id is null'));
        }else if(empty($package_id)){
              sendjson(array('status'=>false,'code'=>417,'message'=>'Package id is null'));
        }else if(strlen($user_id) > 9){
              sendjson(array('status'=>false,'code'=>403,'message'=>'Length of user id exceeds the limit'));    //this is because in optional field, we can send value length of 10 digits only
        }else{ 
            $optionalField = $user_id.'0';    // 1 is for Web payment, 0 is for Android app payment
            $game_points_data = $this->subscription_plans_model->get_game_points_data($package_id);
            if (!empty($game_points_data)) {
              $amount = number_format((float)$game_points_data['price'], 2, '.', '');
              $data['paymentDetails'] = $this->getPaymentUrl($amount, $this->reference_no, $optionalField);
              sendjson(array("status" => true, "code" => 200, "message" => "Payment URL generated","data"=>$data));
            }else{
              sendjson(array('status'=>false,'code'=>501,'message'=>'Package data not available.'));
            }
        }
      }else{
        sendjson($authenicate); 
      }
    }

    public function getPaymentUrl($amount, $reference_no, $optionalField)
    {  

      // $plainUrl = $this->generatePlainUrl($amount, $reference_no, $optionalField);   // Plain URL
      // print_r($plainUrl);die;

      $mandatoryField   =    $this->getMandatoryField($amount, $reference_no);
      $optionalField    =    $this->getOptionalField($optionalField);
      $amount           =    $this->getAmount($amount);
      $reference_no     =    $this->getReferenceNo($reference_no);

      $paymentUrl = $this->generatePaymentUrl($mandatoryField, $optionalField, $amount, $reference_no);       // Encrypted URL
      return $paymentUrl;
    }

  protected function generatePaymentUrl($mandatoryField, $optionalField, $amount, $reference_no)
  {

    $encryptedUrl = $this->$default_base_url."merchantid=".$this->merchant_id."&mandatory fields=".$mandatoryField."&optional fields=".$optionalField."&returnurl=".$this->getReturnUrl()."&Reference No=".$reference_no."&submerchantid=".$this->getSubMerchantId()."&transaction amount=".$amount."&paymode=".$this->getPaymode();
    return $encryptedUrl;
  }

  protected function generatePlainUrl($amount, $reference_no, $optionalField)
  {
      $mandatoryField   =    $reference_no.'|'.$this->sub_merchant_id.'|'.$amount;
      $createPlainUrl = $this->$default_base_url."merchantid=".$this->merchant_id."&mandatory fields=".$mandatoryField."&optional fields=".$optionalField."&returnurl=".$this->return_url."&Reference No=".$reference_no."&submerchantid=".$this->sub_merchant_id."&transaction amount=".$amount."&paymode=".$this->paymode;
      return $createPlainUrl;

  }

  protected function getMandatoryField($amount, $reference_no)
  {
    return $this->getEncryptValue($reference_no.'|'.$this->sub_merchant_id.'|'.$amount);
    // return $this->getEncryptValue($reference_no.'|'.$this->sub_merchant_id.'|'.$amount.'|'.$mobile.'|'.$email);
  }
    
  protected function getOptionalField($optionalField)
  {
    if (!empty($optionalField)) {
      return $this->getEncryptValue($optionalField);    // optional field must be seperated with | eg.(20|20|20|20)
    }else{
      return null;
    }
  }

  protected function getAmount($amount)
  {
    return $this->getEncryptValue($amount);
  }

  protected function getReturnUrl()
  {
    return $this->getEncryptValue($this->return_url);
  }

  protected function getReferenceNo($reference_no)
  {
    return $this->getEncryptValue($reference_no);
  }

  protected function getSubMerchantId()
  {
    return $this->getEncryptValue($this->sub_merchant_id);
  }
  
  protected function getPaymode()
  {
    return $this->getEncryptValue($this->paymode);
  }

  protected function getEncryptValue($str)
  {
    $cipher = "AES-128-ECB"; 
    if (in_array($cipher, openssl_get_cipher_methods())) 
    { 
      $ivlen = openssl_cipher_iv_length($cipher); 
      $iv = openssl_random_pseudo_bytes($ivlen); 
      $ciphertext = openssl_encrypt($str, $cipher, $this->encryption_key, $options=0, $iv); 
      //return $ciphertext."n"; 
      return $ciphertext; 
    }
    //old code below for php v 5 
    // $block = @mcrypt_get_block_size('rijndael_128', 'ecb');
    // $pad = $block - (strlen($str) % $block);
    // $str .= str_repeat(chr($pad), $pad);
    // return base64_encode(@mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->encryption_key, $str, MCRYPT_MODE_ECB));
  }

}