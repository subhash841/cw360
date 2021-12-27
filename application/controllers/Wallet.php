<?php
class Wallet extends CI_Controller {

    function __construct() {
        parent::__construct();
        $sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        }else{
            $this->user_id = 0;
        }
        // $this->load->library('session');
        $this->load->model('users_model');
        $this->load->model('subscription_plans_model');
        $this->load->helper('response_codes_helper');
        $this->load->config('api_validationrules', TRUE);
    }

    function transactions() {
        // echo "</pre>";
        // print_r($_REQUEST);die;
        $transaction_id='';
        if (!empty($_REQUEST)) {
            $transaction_id = $_REQUEST['Unique_Ref_Number'];
            $optField = trim($_REQUEST['optional_fields']);
            $user_id = substr($optField,0,-1);
            $device_used = substr($optField,-1);       // 1 is for Web payment, 0 is for Android app payment
            $this->response_eazypay($user_id,$device_used);
        }
        redirect('wallet/transaction_details?reference_id='.$transaction_id.'&uid='.$user_id.'&via='.$device_used);
    }

    function transaction_details() {
        $transaction_status = $this->subscription_plans_model->transaction_status($_GET['uid'],$_GET['reference_id']);
        if (empty($transaction_status)) {
            // redirect('Subscriptions');
            $data['transaction_details'] = array('payment_status' => 'Payment details could not found!!! If you have made any payment and amount has been deducted from your account, then please contact us.','response_code'=>501);
        }elseif($transaction_status['response_code']=='E000'){
            $from_time = strtotime($transaction_status['created_date']);
            $to_time=strtotime(date('Y-m-d H:i:s')); 
            $timediff = round(abs($to_time - $from_time) / 60,2);
            if ($timediff<=2) {
                $data['transaction_details'] = array('payment_status' => 'Payment completed successfully. Please check your subscription history','trans_response'=>$transaction_status['trans_response'],'response_code'=>$transaction_status['response_code'],'transaction_id'=>$transaction_status['unique_ref_number'],'coins'=>$transaction_status['coins'],'transaction_amount'=>$transaction_status['transaction_amount']);
            }else{
                $data['transaction_details'] = array('payment_status' => 'Transaction has been already done. Please check your subscription history','trans_response'=>$transaction_status['trans_response'],'response_code'=>$transaction_status['response_code'],'transaction_id'=>$transaction_status['unique_ref_number'],'coins'=>$transaction_status['coins'],'transaction_amount'=>$transaction_status['transaction_amount']);
            }
        }else{
                $data['transaction_details'] = array('payment_status' => 'Payment failed!!! Try after some time. If any amount has been deducted from your account then contact us','trans_response'=>$transaction_status['trans_response'],'response_code'=>$transaction_status['response_code'],'transaction_id'=>$transaction_status['unique_ref_number'],'coins'=>$transaction_status['coins'],'transaction_amount'=>$transaction_status['transaction_amount']);
        }
        if ($_GET['via'] == '1') {
            $this->load->view("header");        // if paid via web
        }
        $this->load->view("coins_transactions",$data);
        if ($_GET['via'] == '1') {
            $this->load->view("footer");        // if paid via web
        }
    }

    function response_eazypay($user_id=0,$device_used){
          $response_data = $_REQUEST;
        
        if (!empty($response_data)) {
            $responsecode      =  $response_data['Response_Code'];
            $uniquerefnumber   =  $response_data['Unique_Ref_Number'];
            $servicetaxamount  =  $response_data['Service_Tax_Amount'];
            $processingfee     =  $response_data['Processing_Fee_Amount'];
            $totalamount       =  $response_data['Total_Amount'];
            $transactionamount =  $response_data['Transaction_Amount'];
            $transactiondate   =  $response_data['Transaction_Date'];
            $interchangevalue  =  $response_data['Interchange_Value'];
            $tdr               =  $response_data['TDR'];
            $paymode           =  $response_data['Payment_Mode'];
            $submerchantid     =  $response_data['SubMerchantId'];
            $referenceno       =  $response_data['ReferenceNo'];
            $id                =  $response_data['ID'];
            $tps               =  $response_data['TPS'];
            $hrs               =  $response_data['RS'];
            $mandatory_fields  =  $response_data['mandatory_fields'];
            $optional_fields   =  $response_data['optional_fields'];
            $rsv               =  $response_data['RSV'];
            $keyvalue          =  '2669791971405500';
            $hashData          =  "$id|$responsecode|$uniquerefnumber|$servicetaxamount|$processingfee|$totalamount|$transactionamount|$transactiondate|$interchangevalue|$tdr|$paymode|$submerchantid|$referenceno|$tps|".$keyvalue;
            $Hstring           =  hash("SHA512",$hashData);
            $trans_code        =  trim($responsecode);
            $trans_response    =  transaction_response_codes($trans_code);
            $user_email        =  '';
            $user_mobile       =  '';
            /*if (!empty($mandatory_fields)) {
                $mandatory_fields_data  =   explode('|',$mandatory_fields);
                $user_mobile = $mandatory_fields_data[3];
                $user_email = $mandatory_fields_data[4];
            }*/
            $userDetails = $this->subscription_plans_model->get_user_details($user_id);
            if (!empty($userDetails)) {
                $user_email = $userDetails['email'];
                $user_mobile = $userDetails['phone'];
            }
            
            if(strtoupper($trans_code)=="E000" && $Hstring==$hrs)
            {
                $transaction_status = '1'; 
            }else{
                $transaction_status = '0';
            }

            $coins_data  = $this->subscription_plans_model->get_coins_data($transactionamount);
            $coins       = $coins_data['coins'];
            $subscription_id   = $coins_data['id'];
            // print_r($session_cookie);
            // print_r($sessiondata);die;
           
            $transaction_data  = array(
                'user_id'               =>  $user_id,
                'user_email'            =>  $user_email,
                'user_mobile'           =>  $user_mobile,
                'coins'                 =>  $coins,
                'package_id'            =>  $subscription_id,
                'response_code'         =>  $responsecode,
                'trans_response'        =>  $trans_response,
                'unique_ref_number'     =>  $uniquerefnumber,
                'service_tax_amount'    =>  $servicetaxamount,
                'processing_fee_amount' =>  $processingfee,
                'total_amount'          =>  $totalamount,
                'transaction_amount'    =>  $transactionamount,
                'transaction_date'      =>  $transactiondate,
                'interchange_value'     =>  $interchangevalue,
                'tdr'                   =>  $tdr,
                'payment_mode'          =>  $paymode,
                'merchantid'            =>  $id,
                'submerchantid'         =>  $submerchantid,
                'referenceno'           =>  $referenceno,
                'rs'                    =>  $hrs,
                'tps'                   =>  $tps,
                'optional_fields'       =>  $optional_fields,
                'rsv'                   =>  $rsv,
                'transaction_status'    =>  $transaction_status,
                'device_used'           =>  $device_used,
                'created_date'          =>  date('Y-m-d H:i:s')
            );

            $this->subscription_plans_model->insert_transaction_data($transaction_data);  //insert transaction history
            if ($transaction_status=='1') {
                $this->subscription_plans_model->add_coins($coins,$user_id,$subscription_id);     //update coins
            }
        }
    }


}
