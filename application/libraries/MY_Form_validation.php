<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    public $CI; 
 

   
    function price_increase_percent_validation() {
        $ci->form_validation->set_message('price_increase_percent_validation', "Buy units limit exceeds");
        $ci = & get_instance();
        $ci->db->select("max_limit_buy,price_increase_percent ,IFNULL((SELECT `per_qty_points` FROM `transactions` WHERE `transaction_type`='buy' and `user_id`='".$_POST['user_id']."' and `game_id`='".$_POST['game_id']."' and `predictions_id` ='".$_POST['prediction_id']."' and wrong_prediction!='1' order by `id` desc  limit 1), per_qty_points) as game_points");
        $ci->db->db->from('predictions');               
        $ci->db->db->where(array('game_id'=>$_POST['game_id'],'id'=>$_POST['prediction_id']));
        $result = $this->db->get()->row_array();
        $price_increase_percent= ($result['game_points'] * $result['price_increase_percent']) / 100;
        $max_price=$result['game_points'] + $price_increase_percent;
        $low_price=$result['game_points'] - $price_increase_percent;
         // print_r( $result);die;  
            if($_POST['quantity'] > $result['max_limit_buy']){                
              return FALSE;
            }else{
              return TRUE;
            }
    }

  


   
    function qnt_validation(){
        $ci = & get_instance();
        $postData=$ci->input->post();
        $ci->db->select('executed_qty AS quantity');
        $ci->db->from('transactions');
        $ci->db->where(array('user_id'=>$postData['user_id'], 'game_id'=>$postData['game_id'],'predictions_id'=>$postData['prediction_id'],'transaction_type'=>'buy','wrong_prediction!='=>'1'));
        $result = $ci->db->get()->row_array();
        // print_r( $result);die;  
        if($postData['trade']=='sell'){
                if($result['quantity']!='' && $postData['quantity'] >= $result['quantity']){
                   $msg="Units Exceeded";
              }else{
                  $msg="Please buy unit before sell";
              }
            $ci->form_validation->set_message('qnt_validation', $msg);
                 return FALSE;
          }else{
            return TRUE;
          }           
    }
    function qnt_sell_validation(){
        $ci = & get_instance();
        $postData=$ci->input->post();
        $ci->db->select('executed_qty AS quantity');
        $ci->db->from('transactions');
        $ci->db->where(array('user_id'=>$_POST['user_id'], 'game_id'=>$_POST['game_id'],'predictions_id'=>$_POST['prediction_id'],'transaction_type'=>'buy','wrong_prediction!='=>'1'));
        $result = $ci->db->get()->row_array();
         //print_r( $result);die;  
        if($postData['trade']=='sell'&& $postData['quantity'] >= $result['quantity']){ 
            return FALSE;
          }else{
            return TRUE;
          } 
    }

   








}//class