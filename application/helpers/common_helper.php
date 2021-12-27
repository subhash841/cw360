<?php
 
    function get_user_mobile($user_id=0) {
        $CI = & get_instance();
            $CI->db->select('phone');
            $CI->db->from('users');
            $CI->db->where('id', $user_id);
        $result = $CI->db->get()->result_array();
        $mobile = reset($result);
        if (!empty($mobile['phone']) && strlen($mobile['phone']) <= 10) {
            return $mobile['phone'];
        }else{
            return 0;
        }
    }

    if (!function_exists('user_details')) {
        
        function user_details($user_id=0) {
            $ci = &get_instance();
            $ci->db->select('id,name,dob,email,gender,phone,image');
            $ci->db->where('id', $user_id);
            $query_result = $ci->db->get('users')->row_array();
            //print_r($query_result);die;
            if (!empty($query_result)) {
                return $query_result;
            }else{
                return 0;
            }            
        }
    }


    function blank_value($value=""){   
        if (!empty($value) && $value!='0.00'){
            return number_format($value,2);
        }else{
            return $value='-';
        }
    }

    function loadFile($segment1,$segment2=null){
        $segment1 = ucfirst($segment1);
        if ($segment1=='Predictions' && $segment2=='prediction_game') {
            return 'prediction_game';
        }else if ($segment1=='Predictions' && $segment2=='leaderboard') {
            return 'leaderboard';
        }else if ($segment1=='Predictions' && $segment2=='summary') {
            return 'summary';
        }else{
            return false;
        }
    }

    function encodeString($string){
        if (!empty($string)) {
            return base64_encode($string);
        }else{
            return false;
        }
    }

    function decodeString($string){
        if (!empty($string)) {
            return base64_decode($string);
        }else{
            return false;
        }
    }


    
    function get_User_Coins(){
        $CI = & get_instance();
        $CI->load->model('predictions_model'); 
        $userCoins = $CI->predictions_model->getUserCoins();
        if (!empty($userCoins['coins'])) {
            return $userCoins['coins'];
        }else{
            return 0;
        }
    }

    function get_Redeem_User_Coins(){
        $CI = & get_instance();
        $CI->load->model('predictions_model');
        $userCoins = $CI->predictions_model->getRedeemUserCoins();
        if (!empty($userCoins['coins'])) {
            return $userCoins['coins'];
        }else{
            return '0';
        }
    }
    
    function get_topic_limt(){
        return '27';
    }
    
    function get_game_limit(){
        return '4';
    }
    
    function get_right_side_game_limit(){
        return '6';
    }
    
    function sidebar_card_limit(){
        return '6';
    }
    
    function getall_rewards(){
        $CI = & get_instance();
        $CI->load->model('Common_model');
        $rewards['reward'] = $CI->Common_model->get_rewards();
        if (!empty($rewards)) {
            return $rewards['reward'];
        }else{
            return 0;
        }
    }

    function macid_uniqueId($macid)
    {        
        $setUniqueId= get_cookie('setUniqueId'); 
        if(empty($setUniqueId)){
            $cookie= array(
               'name'   => 'setUniqueId',
               'value'  => $macid,                            
               'expire' => 86400*365,
           );
           set_cookie($cookie);
        } 
        // echo $setUniqueId;die;
        return $setUniqueId;
    }


    function send_email( $to, $from, $subject, $msg ) {
    $config = array ();

    $config[ 'api_key' ] = "8aa5eea08abe60782f6fb7a9ddc36a3f-52cbfb43-35bf5489";
    $config[ 'api_url' ] = "https://api.mailgun.net/v3/notifications.crowdwisdom.co.in/messages";

    $message = array ();
    $message[ 'to' ] = $to;
    $message[ 'bcc' ] = 'crowdwisdom360@gmail.com,subscriptions@crowdwisdom.live';
    $message[ 'from' ] = "Crowdwisdom Team <notifications@crowdwisdom.co.in>";
    //$message['replyto']=$from;
    $message[ 'subject' ] = $subject;
    $message[ 'html' ] = $msg;
    $message = http_build_query( $message );

    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $config[ 'api_url' ] );
    curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
    curl_setopt( $ch, CURLOPT_USERPWD, "api:{$config[ 'api_key' ]}" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 20 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $message );

    $result = curl_exec( $ch );
    curl_close( $ch );
    return $result;
}

function notification_ids(){
    $ci = &get_instance();
    $ci->load->model('Home_model');
    $notifications = $ci->Home_model->get_notification_ids();
    return $notifications;
}
function get_notification_details($notification_ids){
    $ci = &get_instance();
    $ci->load->model('Home_model');
    $lastNotificationId = $ci->Home_model->get_last_notification_id();
    if (!empty($notification_ids)) {
        if (!empty($lastNotificationId)) {
            $allIds = array_column($notification_ids, 'id');
            if (in_array($lastNotificationId['last_notification_id'], $allIds)) {
                $notificationCount = array_search($lastNotificationId['last_notification_id'], $allIds);    //returns an index and that is the exact count of new notifications
            }else{
                $notificationCount = count($notification_ids);      //if last notification not found then count should be of all notifications
            }
        }else{
            $notificationCount = count($notification_ids);       //count of all notifications
        }
    }else{
        $notificationCount = 0;             //empty notifications
    }
    $result = array('notificationCount' => $notificationCount,'lastNotificationId' => $lastNotificationId['last_notification_id']);
    return $result;
}


function special_character( $string ) {
        $string = str_replace( "'", "&#039;", $string );
        $string = str_replace( '"', '&#039;', $string );
        return $string;
}
function quiz_player_statistic ($count_correct,$count_wrong){
    $count_total = $count_correct + $count_wrong;
    if ($count_correct == 0) {
        $player_state = 0;
    }else{
        $player_state = (100 * $count_correct) / $count_total;
    }
    if ($player_state >= 75) {
        $data = array('type' => 'expert',
                      'article' => 'an',
                      'class' => 'badge-pill badge-warning');
    }else if($player_state >=50 && $player_state < 75){
        $data = array('type' => 'knowledgeable',
                      'article' => '',
                      'class' => 'badge-pill knowledgeable-text');
    }else{
        $data = array('type' => 'learner',
                      'article' => 'as a',
                      'class' => 'badge-pill learner-text');
    }
    return $data;

}