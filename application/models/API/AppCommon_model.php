<?php

class AppCommon_model extends CI_Model{
        

        function __construct() {
        parent::__construct();
        
        }



    public function get_all_games($limit='',$topic_id="",$offset = 0) {
        $this->db->select('id,title,req_game_points,req_game_points,image,(CASE when DATEDIFF(end_date, NOW()) < 0 then "Game Ended" when DATEDIFF(end_date, NOW()) = 0 then "Ends Today" else concat(DATEDIFF(end_date, NOW())," ","Days Left") END)as end_date');
        $this->db->from('games');
       /* $this->db->where('is_active', '1');
        $this->db->where('is_published', '1');*/                           
        /*$this->db->where("NOW() between date_format(str_to_date(start_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') and (date_format(str_to_date(end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'))");*/
        if(!empty($limit)){
            $this->db->limit($limit, $offset);
        }
        if(!empty($topic_id)){   
            $sql=$this->topic_wise_sort($topic_id);    
            $this->db->order_by($sql.' DESC');
        } else {
            $this->db->order_by('id', 'DESC');
        }
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function get_all_games_sidebar($limit='',$topic_id="",$offset = 0) {
        $this->db->select('id,title,req_game_points,req_game_points,image,(CASE when DATEDIFF(end_date, NOW()) < 0 then "Game Ended" when DATEDIFF(end_date, NOW()) = 0 then "Ends Today" else concat(DATEDIFF(end_date, NOW())," ","Days Left") END)as end_date,topic_id');
        $this->db->from('games');
        $this->db->where('is_active', '1');
        $this->db->where('is_published', '1');                          
        $this->db->where("NOW() between date_format(str_to_date(start_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') and (date_format(str_to_date(end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'))");
        if(!empty($limit)){
            $this->db->limit($limit, $offset);
        }
        if(!empty($topic_id)){   
            $sql=$this->topic_wise_sort($topic_id);    
            $this->db->order_by($sql.' DESC');
        } else {
            $this->db->order_by('id', 'DESC');
        }
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function get_all_blogs($limit="",$topic_id="",$offset=0) {
        $this->db->select("id,name,category_id,title,description,image,DATE_FORMAT(modified_date, '%e %b %Y') as created_date");
        $this->db->from('blogs');
        $this->db->where(array('is_active'=>'1','is_approve'=>'1'));
        if($limit !=''){
            $this->db->limit($limit,$offset);
        }
        if(!empty($topic_id)){   
            $sql=$this->topic_wise_sort($topic_id);    
            $this->db->order_by($sql.' DESC');
        } else {
            $this->db->order_by('id', 'DESC');
        }

        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function get_all_quiz($limit="",$topic_id="",$offset=0,$user_id) {
        $this->db-> select('*');
        $this->db-> from( 'quiz');        
        $this->db->where('is_active','1');
        $this->db->where('is_published','1');
        $this->db->where('end_date >= now()');
       
        if(!empty($topic_id)){   
            $sql=$this->topic_wise_sort($topic_id);    
            $this->db->order_by($sql.' DESC');

        }else{
            $this->db->order_by('quiz_id','DESC');
        }
        if($user_id !=0 ){
            $this->db->where("quiz_id not in (select quiz_id from quiz_attempted where user_id = $user_id group by quiz_id)");
        }
        if(!empty($limit)){
            $this->db->limit($limit,$offset);
        }
        $res=$this->db->get()->result_array();
        return $res; 
        
    }


    private function topic_wise_sort($topic_id){
        $topic_id_arr=explode(',',$topic_id);
        $sql='';
        $i=0;
        foreach ($topic_id_arr as $key => $topic_id_value){           
            if($i != 0){
                $sql.=' OR  ';
            }    
            $sql.='FIND_IN_SET('. $topic_id_value .',topic_id) ';
                
                $i++;
            
        }
        return $sql;
    }

    public function getUserCoins($user_id) {
        $this->db->select("coins");
        $this->db->from('coins');
        $this->db->where('user_id', $user_id );
        $userCoins = $this->db->get()->row_array();
        //echo $this->db->last_query()die;
        return $userCoins;
    }
    
    public function getRedeemUserCoins($user_id) {       
        $userCoins=array();
        $this->db->select("id,coins,type");
        $this->db->from("wallet_history");
        $this->db->where("user_id",$user_id); 
        $userGetallCoins = $this->db->get()->result_array();
        // echo $this->db->last_query();die;
        // echo "<pre>";
        $coins=0;
        $redeemcoins=0;
        foreach($userGetallCoins as $key => $value){
                if($value['type']=="0" ||  $value['type']=="1"){
                        $coins=$coins+$value['coins'];            
                }else  if($value['type']=="2" ||  $value['type']=="5"){
                    $redeemcoins=$redeemcoins+$value['coins'];
                }else if($value['type']=="3" || $value['type']=="4" || $value['type']=="6" || $value['type']=="7" || $value['type']=="8" || $value['type']=="9"){

                    if($value['type']=="7"){
                        $redeemcoins=$redeemcoins-$value['coins'];
                    }else if($coins >= $value['coins']){
                        $coins=$coins-$value['coins'];

                    }else if($value['coins'] > $coins){
                        $re_coins=$value['coins']-$coins;
                        // echo $re_coins;
                        $redeemcoins=$redeemcoins-$re_coins;
                        $coins=0;
                    }
                
                }
                $userCoins['coins']=$redeemcoins;
            
        }
    
        return $userCoins;
    }

    public function get_rewards() {
        $this->db->select('id, title, req_coins, image');
        $this->db->where(array('is_published' => '1', 'is_published' => '1'));
        $this->db->from('rewards');
        return $this->db->get()->result_array();
    }

    public function insert_redeem_data(){
        $insert_array=array(
                                'user_id' =>$_POST['user_id'] ,
                                'coins' => $_POST['point_redeem'],
                                'created_date' => date("Y-m-d H:i:s"),
                             );
        // print_r($insert_array);
            if($this->db->insert('redeem_history',$insert_array)){
                $this->db->set('coins', 'coins - '.$_POST['point_redeem'], false);
                $this->db->where('user_id',$_POST['user_id']);
                $this->db->update('coins');
                    if ($this->db->affected_rows() > 0) {
                        $insert_wallet_history = array(
                                    'user_id' => $_POST['user_id'],
                                    'coins' => $_POST['point_redeem'],
                                    'type' => '7',//deduct coin for redemption
                                    'created_date' => date('Y-m-d H:i:s')
                                );
                        $this->db->insert('wallet_history',$insert_wallet_history);
                    }
            }
            $title = "Redeemable Coins Request";
            $message ="";
            $message .= "Dear User, <br /><br />";
            $message .= "We are in receipt of your redemption request of ";
            $message .= $_POST['point_redeem'];
            $message .= "Coins.It takes us a max of 48 hours to send in the appropriate reward via e-mail and a week if it has to be sent by post.<br /><br />";
            $message .= "In case of weekends, please add a couple of days more to the turnaround time. In case you are concerned, <br />";          
            $message .= "don’t hesitate to write to us admin@crowdwisdom.live and we will respond as quickly as possible.<br /><br />";
            $message .= "Thanks and Regards,<br /><br />CrowdWisdom Team";
            //$res=send_email( $_POST['email'], '', $title, $message );
            //$data=explode(',', $res);
            //print_r($res);
            return true;
    }

    public function get_history($user_id,$offset='',$count=''){
        $this->db->select('wh.id,wh.coins, q.name as quiz_name,g.title as game_name,
        wh.type,DATE_FORMAT(wh.created_date,"%e %b %Y") as date,s.package_name');
        $this->db->from('wallet_history wh');
        $this->db->join('quiz q','wh.quiz_id = q.quiz_id','left');
        $this->db->join('games g','wh.game_id = g.id','left');
        // $this->db->join('predictions p','wh.prediction_id = p.id','left');
        $this->db->join('subscription_plans s','wh.subscription_id = s.id','left');
        $this->db->where(array('wh.user_id' => $user_id,'wh.prediction_id '=> null, 'wh.coins !=' =>' NULL'));
        $this->db->order_by('wh.id','DESC');
        if($count!='0' && !empty($offset)){
            $this->db->limit('20',$offset);
        }
        
        $result = $this->db->get()->result_array();
        // echo $this->db->last_query();die;
        if($count=='0' && empty($offset)){
            $res['count_history']=count($result);
            return $res; 
        }else{

            return $result;
        }

                                    
        // $result = $this->db->get()->result_array();
        // echo $this->db->last_query();
        // echo count($result);
        // echo'<br><pre>';
        // print_r($result);
        // die;
        
    }
    public function get_subscription_history($user_id)
    {   
        $this->db->select('st.id, round(st.coins) as coins, st.package_id, st.transaction_amount, date_format(str_to_date(st.transaction_date, "%d-%m-%Y %H:%i:%s"), "%e %M %Y  %h:%i %p") as transaction_date, sp.package_name');
        $this->db->from('subscription_transactions st');
        $this->db->join('subscription_plans sp','st.package_id=sp.id','LEFT');
        $this->db->where('st.user_id',$user_id); 
        $this->db->where('st.response_code','E000'); 
        $this->db->order_by('st.id','DESC');
        return $this->db->get()->result_array();
    }
    public function subscription_list(){
        $this->db->select('`id`, `game_id`, `package_name`, `coins`, `price`, `description`, `is_active`,');
        $this->db->from('subscription_plans');
        $this->db->where('is_active',1); 
        return $this->db->get()->result_array();
    }

    public function get_notifications($user_id)
    {   
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where("(user_id = $user_id OR user_id IS NULL) AND created_date BETWEEN NOW() - INTERVAL 10 DAY AND NOW() AND (game_id IS NULL OR game_id IS NOT NULL OR prediction_id IS NULL OR prediction_id IS NOT NULL) AND (CASE 
            WHEN prediction_id IS NOT NULL AND prediction_status IS NULL THEN FIND_IN_SET($user_id, user_id_set) ELSE TRUE END) AND created_date >= (SELECT created_date FROM users where id = $user_id)");     //Not to remove space after CASE word
        $this->db->order_by('id','DESC');
        $notifications = $this->db->get()->result_array();
    //    echo  $this->db->last_query();die;
        // print_r($notifications);die;
        if (!empty($notifications)) {
            $lastNotificationId = $notifications[0]['id'];
                $this->db->set('last_notification_id', $lastNotificationId);
                $this->db->where('id', $user_id);
                $this->db->update('users');
        }
        return $notifications;
    }

    public function get_new_notifications($lastNotificationId,$user_notifications,$user_id)
    {   
        if (empty($lastNotificationId)) {
            $lastNotificationId = 0;
        }
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where("id > $lastNotificationId AND (user_id = $user_id OR user_id IS NULL) AND created_date BETWEEN NOW() - INTERVAL 10 DAY AND NOW() AND (game_id IS NULL OR game_id IS NOT NULL OR prediction_id IS NULL OR prediction_id IS NOT NULL) AND (CASE 
            WHEN prediction_id IS NOT NULL AND prediction_status IS NULL THEN FIND_IN_SET($user_id, user_id_set) ELSE TRUE END) AND created_date >= (SELECT created_date FROM users where id = $user_id)");     //Not to remove space after CASE word
        $this->db->order_by('id','DESC');
        $notifications = $this->db->get()->result_array();
        if ($user_notifications=='true') {
            if (!empty($notifications)) {
                $lastNotificationId = $notifications[0]['id'];
                    $this->db->set('last_notification_id', $lastNotificationId);
                    $this->db->where('id', $user_id);
                    $this->db->update('users');
            }
        }
        return $notifications;
    }
	       
	}
?>
