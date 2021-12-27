<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');


class Eazy_pay {
  public $CI;
  public $merchant_id;
  public $encryption_key;
  public $sub_merchant_id;
  public $reference_no;
  public $paymode;
  public $return_url;

  const DEFAULT_BASE_URL = 'https://eazypay.icicibank.com/EazyPG?';

  public function __construct() {

        $CI = & get_instance();

        $CI->merchant_id              =    '221165';
        $CI->encryption_key           =    '2269792511605500';
        $CI->sub_merchant_id          =    '1';
        $CI->merchant_reference_no    =    '444';
        $CI->paymode                  =    '9';
        $CI->return_url               =    'https://www.crowdwisdom360.com/wallet/';
  } 


  public function getPaymentUrl($amount, $reference_no, $optionalField=null)
  {
    $mandatoryField   =    $CI->getMandatoryField($amount, $reference_no);
    $optionalField    =    $CI->getOptionalField($optionalField);
    $amount           =    $CI->getAmount($amount);
    $reference_no     =    $CI->getReferenceNo($reference_no);

    $paymentUrl = $CI->generatePaymentUrl($mandatoryField, $optionalField, $amount, $reference_no);
    return $paymentUrl;
          // return redirect()->to($paymentUrl);
  }

  protected function generatePaymentUrl($mandatoryField, $optionalField, $amount, $reference_no)
  {
    $encryptedUrl = self::DEFAULT_BASE_URL."merchantid=".$CI->merchant_id."&mandatory fields=".$mandatoryField."&optional fields=".$optionalField."&returnurl=".$CI->getReturnUrl()."&Reference No=".$reference_no."&submerchantid=".$CI->getSubMerchantId()."&transaction amount=".$amount."&paymode=".$CI->getPaymode();

    return $encryptedUrl;
  }

  protected function getMandatoryField($amount, $reference_no)
  {
    return $CI->getEncryptValue($reference_no.'|'.$CI->sub_merchant_id.'|'.$amount);
  }

      // optional field must be seperated with | eg. (20|20|20|20)
  protected function getOptionalField($optionalField=null)
  {
    if (!is_null($optionalField)) {
      return $CI->getEncryptValue($optionalField);
    }
    return null;
  }

  protected function getAmount($amount)
  {
    return $CI->getEncryptValue($amount);
  }

  protected function getReturnUrl()
  {
    return $CI->getEncryptValue($CI->return_url);
  }

  protected function getReferenceNo($reference_no)
  {
    return $CI->getEncryptValue($reference_no);
  }

  protected function getSubMerchantId()
  {
    return $CI->getEncryptValue($CI->sub_merchant_id);
  }

  protected function getPaymode()
  {
    return $CI->getEncryptValue($CI->paymode);
  }

      // use @ to avoid php warning php 

  protected function getEncryptValue($str)
  {
    $block = @mcrypt_get_block_size('rijndael_128', 'ecb');
    $pad = $block - (strlen($str) % $block);
    $str .= str_repeat(chr($pad), $pad);
    return base64_encode(@mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $CI->encryption_key, $str, MCRYPT_MODE_ECB));
  }


}
  // call The method
/*$base=new Eazypay();
$url=$base->getPaymentUrl($amount, $reference_no, $optionalField=null);
*/







// }//class