<?php 


function special_characters($string) {
    $string = str_replace("'", "&#39;", $string); //convert single quote to html entity
    $string = str_replace('"', "&#34;", $string); //convert double quote to html entity
    //$string = str_replace("\t", "&nbsp;", $string); //convert double quote to html entity
    $string = nl2br($string);  //convert enter to <br /> tag html entity
    return $string;
}


function special_characters_blog($string) {
    $string = str_replace("'", "&#39;", $string); //convert single quote to html entity
    $string = str_replace('"', "&#34;", $string); //convert double quote to html entity
    $string = str_replace("\t", "&nbsp;", $string); //convert double quote to html entity
    $string=str_replace("\n\n","",$string);
    $string = nl2br($string);  //convert enter to <br /> tag html entity
    return $string;
}



 function getUserCoins(){
        $CI = & get_instance();
        $user_id=@$_POST['user_id'];
        $CI->load->model('API/AppCommon_model'); 
        $userCoins = $CI->AppCommon_model->getUserCoins($user_id);    
        if (!empty($userCoins['coins'])) {
            return $userCoins['coins'];
        }else{
            return 0;
        }
    }

    function getRedeemUserCoins(){
        $CI = & get_instance();
        $CI->load->model('API/AppCommon_model');
        $userCoins = $CI->AppCommon_model->getRedeemUserCoins();
        if (!empty($userCoins['coins'])) {
            return $userCoins['coins'];
        }else{
            return '0';
        }
    }   

    function sendjson($data = array (), $http_code = 200, $status = false){
    $CI = & get_instance();
    if($status){
        return $CI->output->set_content_type('application/json;charset=utf-8')
                        ->set_status_header($http_code)
                        ->set_output(json_encode($data,JSON_PRETTY_PRINT));
    }else{
        return $CI->output->set_content_type('application/json;charset=utf-8')
                        ->set_status_header($http_code)
                        ->set_output(json_encode($data));
        }
    }

    function generate_access_token(){
        return base64_encode(substr(uniqid("cw360"),0,20));
    }

    function authenicate_access_token($headers){
        $CI = & get_instance();
        $CI->load->model('Common_model');
        if(@$_POST['user_id'] == $headers['user_id']){
            $authenicate = $CI->Common_model->authenicate_access_token($headers['user_id'],$headers['auth_token'],$headers['device_type']);
            if (!empty($authenicate)) {
                return TRUE;
            }else{
                return array ("status" => FALSE, "message" => "Token Mismatch Error.","status_code"=>"401");
            }
        }else{
            return array ("status" => FALSE, "message" => "Invalid headers.");
        }
        
    }
    function api_notification_ids($user_id){
        $ci = &get_instance();
        $ci->load->model('API/AppHome_model');
        $notifications = $ci->AppHome_model->get_notification_ids($user_id);
        return $notifications;
    }

    function api_get_notification_details($notification_ids,$user_id){
    $ci = &get_instance();
    $ci->load->model('API/AppHome_model');
    $lastNotificationId = $ci->AppHome_model->get_last_notification_id($user_id);
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
function get_device_token( $userid) {
    $CI = & get_instance();
    $get_devicetoken = "";

    // print_r($userid);die;
    if ( $userid != 'All') {
            $get_devicetoken = "select id, device_type, device_token from users where id in ($userid) and ifnull(device_token,'') <> ''";
    }else{
        $get_devicetoken = "select id, device_type, device_token from users where ifnull(device_token,'') <> ''";
    }

    if ( $get_devicetoken != "" ) {
            $resultset = $CI -> db -> query( $get_devicetoken ) -> result_array();
            return $resultset;
    } else {
            return array ();
    }

}

?>
