<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->get_initial_coins="50";
        $this->device_type="Android";

        $sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        }else{
            $this->user_id=0;
        }
    }

    function index() {
        $queryString = $this -> input -> get();
        $this -> session -> set_userdata( 'querystring', $queryString );
           // print_r($queryString);die;
        // $gid = $queryString['gid'];
        $userdata = $this -> session -> userdata( 'data' );
        if ( ! empty( $userdata ) ) {

            if ( @$queryString['section'] == "home" ) {
                redirect('Home');
            }else if ( @$queryString['section'] == "subscriptions" ) {
                redirect('Subscriptions');
            }else if (empty(@$queryString['sub_section' ]) && @$queryString['section' ] == "predictions" && isset($queryString['gid'])) {
                //$this->check_rewards_cookie($queryString);  //set cookie for game if don't want to show rules/rewards popup
                redirect('Predictions/prediction_game/'.$queryString[ 'gid' ]);
            }else if (!empty(@$queryString['sub_section' ]) && isset($queryString['gid']) && @$queryString['section'] != "quiz" && @$queryString['section'] != "blog") {
                redirect('Predictions/'.@$queryString['sub_section' ].'/'.$queryString[ 'gid' ]);
            }else if ( @$queryString['section' ] == "games" && isset($queryString['gid'])) {
                redirect('games/'.$queryString[ 'gid' ]);
            }else if ( !empty(@$queryString['section' ])  && empty($queryString['gid'])) {
                redirect($queryString['section' ]);
            }else if (@$queryString['section'] == "instruction" &&  !empty(@$queryString['section' ]) &&  !empty(@$queryString['section2' ])&&  !empty(@$queryString['section3' ])) {
                redirect("quiz/".$queryString['section' ]."/".$queryString['section2']."?topic_id=".$queryString['section3']);
            }else if (@$queryString['section'] == "blog" &&  !empty(@$queryString['section' ]) &&  !empty(@$queryString['sub_section' ])&&  !empty(@$queryString['gid' ])) {
                redirect($queryString['section' ]."/".$queryString['sub_section']."/".$queryString['gid']);
            }else if (@$queryString['section'] == "blog" &&  @$queryString['gid' ]=="list") {
                redirect("blog/".$queryString['gid' ]);
            }else if (@$session_querystring['section'] == "quiz" &&  !empty(@$session_querystring['section' ]) &&  !empty(@$session_querystring['sub_section' ]) && !empty($session_querystring['gid'])) {
                redirect("quiz/".$session_querystring['sub_section' ]."/".$session_querystring['gid']);
            }else {
                redirect('Home');
            }

        }
        $this -> load -> view( 'login_revised' );
    }

    public function twitterlogin() {
        require_once APPPATH . 'libraries/twitteroauth/OAuth.php';
        require_once APPPATH . 'libraries/twitteroauth/TwitterOAuth.php';

        define( 'CONSUMER_KEY', 'ULpQloiD7Cc5Tig4RVjzBE7Qp' );
        define( 'CONSUMER_SECRET', 'QTsBYnWrhODkPtmuM3kpdnaDZWoGVuRFFeMEbFmEtUsNPLN7mF' );

        define( 'OAUTH_CALLBACK', base_url() . 'Login/callback' );

        $connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET );

        // get the token from connection object
        $request_token = $connection -> getRequestToken( OAUTH_CALLBACK );
        // if request_token exists then get the token and secret and store in the session
        if ( $request_token ) {
            $token = $request_token[ 'oauth_token' ];
            //echo $token."  ";
            $_SESSION[ 'request_token' ] = $token;
            //echo $_SESSION['request_token']." ";
            $_SESSION[ 'request_token_secret' ] = $request_token[ 'oauth_token_secret' ];
            //echo $_SESSION['request_token_secret']." ";
            // get the login url from getauthorizeurl method
            $login_url = $connection -> getAuthorizeURL( $token );
            header( "Location:$login_url" );
        }

        /*
         * PART 2 - PROCESS
         * 1. check for logout
         * 2. check for user session  
         * 3. check for callback
         */

        // 1. to handle logout request
        if ( isset( $_GET[ 'logout' ] ) ) {
            //unset the session
            session_unset();
            // redirect to same page to remove url paramters
            $redirect = 'http://' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'PHP_SELF' ];
            header( 'Location: ' . filter_var( $redirect, FILTER_SANITIZE_URL ) );
        }


        // 2. if user session not enabled get the login url
        // 3. if its a callback url


        /*
         * PART 3 - FRONT END 
         *  - if userdata available then print data
         *  - else display the login url
         */

        if ( isset( $login_url ) && ! isset( $_SESSION[ 'data' ] ) ) {
            // echo the login url
            echo "<a href='$login_url'><button>Login with twitter</button></a>";
        } else {
            // get the data stored from the session
            $data = $_SESSION[ 'data' ];
            // echo the name username and photo
            echo "Name : " . $data -> name . "<br>";
            echo "Username : " . $data -> screen_name . "<br>";
            echo "Photo : <img src='" . $data -> profile_image_url . "'/><br><br>";
            // echo the logout button
            echo "<a href='?logout=true'><button>Logout</button></a>";
        }
    }

    public function callback() {
        require_once APPPATH . 'libraries/twitteroauth/OAuth.php';
        require_once APPPATH . 'libraries/twitteroauth/TwitterOAuth.php';

        define( 'CONSUMER_KEY', 'ULpQloiD7Cc5Tig4RVjzBE7Qp' );
        define( 'CONSUMER_SECRET', 'QTsBYnWrhODkPtmuM3kpdnaDZWoGVuRFFeMEbFmEtUsNPLN7mF' );

        define( 'OAUTH_CALLBACK', base_url() . 'Login/callback' );

        if ( isset( $_GET[ 'denied' ] ) ) {
            $this -> logout();
        }

        if ( isset( $_GET[ 'oauth_token' ] ) ) {

            // create a new twitter connection object with request token
            $connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET, $_SESSION[ 'request_token' ], $_SESSION[ 'request_token_secret' ] );
            //var_dump($connection);
            // get the access token from getAccesToken method
            $access_token = $connection -> getAccessToken( $_REQUEST[ 'oauth_verifier' ] );
            if ( $access_token ) {
                // create another connection object with access token
                $connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET, $access_token[ 'oauth_token' ], $access_token[ 'oauth_token_secret' ] );
                // set the parameters array with attributes include_entities false
                //$params = array('include_entities' => 'false');
                $params = array ( 'include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true' );
                // get the data
                $data = $connection -> get( 'account/verify_credentials', $params );
            }
        }

        if ( count( $data -> errors ) == 0 ) {
            /* User details from twitter */
            $inputs = $this -> input -> post(); 
            $user_name = $data -> name;
            $socialid = $data -> id_str;
            $twitterid = $data -> screen_name;
            $user_email = $data -> email;
            $login_type = "Twitter";
            $this -> db -> select( "id,alise,location,party_affiliation,certificate_path,unearned_points,tnc_agree,coins" );
            $this -> db -> from( "users" );
            $this -> db -> where( "social_id = '$socialid' AND login_type = '$login_type'" );
            $result = $this -> db -> get();

            $is_exists = $result -> num_rows();
            // echo $this->db->last_query();die;
            $preid = $this->session->userdata( 'querystring' );
        /*if($preid[ 'pid' ]!=''){
            $game_data=get_active_game_name('',$preid[ 'pid' ],'prediction');
            $game_id=$game_data['id'];

            $data = $result -> row_array();
            $user_id=$data['id'];
           
            //check game posint 
            $this -> db -> select( "id, user_id, game_id, game_points");
            $this -> db -> from( "game_point_history" );
            $this -> db -> where( "user_id = '$user_id' AND game_id = '$game_id'" );
            $res = $this -> db -> get();
            // echo $this->db->last_query();
            $is_point_exists = $res -> num_rows();

            $game_point_data = array (
                "user_id" => $user_id,
                "game_points" => $game_data['initial_game_points'],
                "got_points_status" => "1",
                "game_id" => $game_id,

                    // "unearned_points" => "35"
            );
            $userdata[ 'game_points' ] = @$game_data['initial_game_points'];
        }*/

            /* Userdata */
            $userdata = array (
                "name" => $user_name,
                "social_id" => $socialid,
                "email" => $user_email,
                "twitter_id" => $twitterid,
                "login_type" => $login_type,
                "coins"=>$this->get_initial_coins,
                    //"unearned_points" => "35"
            );
            // print_r($user_email);die;

            if ($is_exists == 0) {
                /* Insert user data and set session */
                $login_ip = $this->input->ip_address();
                $userdata[ 'login_ip' ] = $login_ip; 
                $this -> db -> insert( 'users', $userdata );
                $userid = $this -> db -> insert_id();
                $game_coins_data=array('coins'=>$this->get_initial_coins, 
                   'user_id'=>$userid,
                   'created_date'=> date('Y-m-d H:i:s')
                );
                $this -> db -> insert( 'coins', $game_coins_data );
                $this->db->insert( 'wallet_history', $game_coins_data );
                $userdata[ 'uid' ] = $userid;
                $userdata[ 'game_point_pop' ] ='1'; 
                $userdata[ 'get_initial_coins' ] =$this->get_initial_coins;       
                $userdata[ 'tnc_agree' ] = "0";            

            } else {
                $data = $result -> row_array();
                $userdata[ 'uid' ] = $data[ 'id' ];
                $userdata[ 'game_point_pop' ] ='0';
                $userdata[ 'total_points' ] = @$data[ 'game_points' ];
                $userdata[ 'tnc_agree' ] = @$data[ 'tnc_agree' ];
                $login_ip = $this->input->ip_address();
                $this->db->set('login_ip',$login_ip);
                $this->db->where('id', $data[ 'id' ]);
                $this ->db-> update('users');
            }

            $_SESSION[ 'data' ] = $userdata;

                if ( ! empty( $_SESSION[ 'data' ] ) ) {
                    $session_querystring = $this -> session -> userdata( 'querystring' );
                    // print_r($session_querystring);die;

                        if ( $_SESSION[ 'data' ][ 'tnc_agree' ] == "0" ) {
                         redirect( 'TnC' );
                        } else if ( @$session_querystring[ 'section' ] == "home" ) {
                            redirect( 'Home' );
                        } else if (empty(@$session_querystring['sub_section' ]) &&  @$session_querystring[ 'section' ] == "predictions" && isset( $session_querystring[ 'gid' ] ) ) {
                            //$this->check_rewards_cookie($session_querystring); //set cookie for game if don't want to show rules/rewards popup
                            redirect( "Predictions/prediction_game/" . $session_querystring[ 'gid' ] );
                        }else if ( !empty(@$session_querystring['sub_section' ]) && isset($session_querystring['gid'])) {
                            redirect('Predictions/'.@$session_querystring['sub_section' ].'/'.$session_querystring[ 'gid' ]);
                        }else if ( @$session_querystring[ 'section' ] == "games" && isset( $session_querystring[ 'gid' ] ) ) {
                            redirect( "games/" . $session_querystring[ 'gid' ] );
                        }else if ( !empty(@$session_querystring['section' ])  && empty($session_querystring['gid'])) {
                            redirect($session_querystring['section' ]);
                        } else {
                            redirect( 'Home' );
                        }
                    }
             else {
                redirect( 'Login' );
            }
        } else {
            $this -> logout();
        }
    }

    //Facebook Login
    public function fblogin() {        
        $inputs = $this -> input -> post();   
        // print_r($inputs);die;  
        $user_name = $inputs[ 'name' ];
        $socialid = $inputs[ 'user_id' ];
        $user_email = isset( $inputs[ 'user_email' ] ) ? $inputs[ 'user_email' ] : "";
        $login_type = "Facebook";

        $this -> db -> select( "id,name,email,login_type,alise,location,party_affiliation,certificate_path,unearned_points,tnc_agree,coins,macid_unique,device_type,device_token");
        $this -> db -> from( "users" );
        $setUniqueId=get_cookie('setUniqueId');
         //echo $setUniqueId;
        if(!empty($setUniqueId)){
            $this -> db -> where( "social_id = '$socialid' AND login_type = '$login_type' AND macid_unique='$setUniqueId'");
        }else{
            $this -> db -> where( "social_id = '$socialid' AND login_type = '$login_type'" );
        }

        $result = $this -> db -> get();
        // echo $this->db->last_query();die;
        $is_exists = $result -> num_rows();

        /* Userdata */
        $userdata = array (
            "name" => $user_name,
            "social_id" => $socialid,
            "email" => $user_email,
            "login_type" => $login_type,
            "coins"=>$this->get_initial_coins,
            "device_type"=>$this->device_type,
            //"unearned_points" => "35"
        );

        $preid = $this->session->userdata( 'querystring' );
        // if($preid[ 'pid' ]!=''){
        //     $game_data=get_active_game_name('',$preid[ 'pid' ],'prediction');
        //     $game_id=$game_data['id'];

        //     $data = $result -> row_array();
        //     $user_id=$data['id'];
           
        //     // //check game posint 
        //     // $this -> db -> select( "id, user_id, game_id, game_points");
        //     // $this -> db -> from( "game_point_history" );
        //     // $this -> db -> where( "user_id = '$user_id' AND game_id = '$game_id'" );
        //     // $res = $this -> db -> get();
        //     // // echo $this->db->last_query();
        //     // $is_point_exists = $res -> num_rows();

        //     $game_point_data = array (
        //         "user_id" => $user_id,
        //         "game_points" => $game_data['initial_game_points'],
        //         "got_points_status" => "1",
        //         "game_id" => $game_id,

        //             // "unearned_points" => "35"
        //     );
        //     $userdata[ 'game_points' ] = $game_data['initial_game_points'];
        // }

        $final_res = $result->row_array();
        if(!empty($setUniqueId) && $is_exists == 0){
            $this -> db -> select( "id,name,email,login_type, alise,location,party_affiliation,certificate_path,unearned_points,tnc_agree, coins,macid_unique" );
                $this -> db -> from( "users" );
            if(!empty($setUniqueId)){
                $this ->db->where("macid_unique",$setUniqueId);
            }                  
            $result1 = $this -> db -> get();
            $mac_res = $result1->row_array();
            //print_r($mac_res);die;
            $userLogindata = array (                               
                        "popup" => '1',
                        "msg"=>"You can login only with this mail ".@$mac_res['email'] . ' (' . @$mac_res['login_type'] . ')',
                    );
            $_SESSION[ 'login_data' ] = $userLogindata;
            $redirect_url= 'Home/index/3';
            echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url) );
                       die;
        // echo $this->db->last_query();

        }/* else if (!empty($final_res['device_type']) && $this->device_type != $final_res['device_type']) {
                        //print_r($mac_res);die;
            $userLogindata = array (                               
                        "popup" => '1',
                        "msg"=>"Logged in on ".$final_res["device_type"],
                    );
            $_SESSION[ 'login_data' ] = $userLogindata;
             $redirect_url= 'Home/index/3';
            echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url) );
                       die;
        } */else if ($is_exists == 0) {
            /* Insert user data and set session */
            $login_ip = $this->input->ip_address();
            $userdata[ 'login_ip' ] = $login_ip; 
            $this -> db -> insert( 'users', $userdata );
            $userid = $this -> db -> insert_id();
            //insert coins
           $game_coins_data=array('coins'=>$this->get_initial_coins, 
                   'user_id'=>$userid,
                   'created_date'=> date('Y-m-d H:i:s')
                );
            $this -> db -> insert( 'coins', $game_coins_data );
            $this->db->insert( 'wallet_history', $game_coins_data );
            //end insert coins
            $userdata[ 'uid' ] = $userid;
            $userdata[ 'game_point_pop' ] ='1';
            $userdata[ 'get_initial_coins' ] =$this->get_initial_coins;
            $userdata[ 'game_points' ] =$game_data['initial_game_points'];  
            $userdata[ 'tnc_agree' ] = "0";          

        } else {
            $data = $result -> row_array();
            $userdata[ 'uid' ] = $data[ 'id' ];
            $userdata[ 'game_point_pop' ] ='0';           
            $userdata[ 'tnc_agree' ] = $data[ 'tnc_agree' ];
            $login_ip = $this->input->ip_address();
            $this->db->set('login_ip',$login_ip);
            $this->db->set('device_type',$this->device_type);
            $this->db->where('id', $data[ 'id' ]);
            $this ->db-> update('users'); 

        }

         /*set cookei*/               

               
               // print_r($final_res);die;
                if (empty($setUniqueId)) {
                        if(!empty($final_res['macid_unique'])){
                            $macid =$final_res['macid_unique'];
                        }else{ 
                            $macid ='CW360'.$userdata[ 'uid' ]; 
                        }
                        $macid_unique =macid_uniqueId($macid); 
                        
                        $this->db->set('macid_unique',$macid);
                        $this->db->set('device_type',$this->device_type);
                        $this->db->where('id', $userdata[ 'uid' ]);
                        $this->db->update('users'); 
                        
                        $_SESSION[ 'data' ] = $userdata;                      
                        $this->check_login_cookie($userdata);  //set cookie for payment
                         //echo $macid_unique; die;             
                    }else if($setUniqueId != $final_res['macid_unique']){
                            $userLogindata = array (                               
                                "popup" => '1',
                                "msg"=>"You can login only with this mail ".@$mac_res['email'] . ' (' . @$mac_res['login_type'] . ')',
                            );
                        $_SESSION[ 'login_data' ] = $userLogindata;  
                        $redirect_url= 'Home/index/4';
                      echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url ) );
                       die;
                    }else if($setUniqueId == $final_res['macid_unique']){
                           // delete_cookie("setUniqueId");                  
                          $_SESSION[ 'data' ] = $userdata;   
                    }else{
                         $_SESSION[ 'data' ] = $userdata;  
                    }    

        if ( ! empty( $_SESSION[ 'data' ] ) ) {
                // $_SESSION[ 'data' ]['rlsnrwds'] = 
            // echo $rlsnrwds; die;
                $session_querystring = $this -> session -> userdata( 'querystring' );
                $this->check_login_cookie($session_querystring);  //set cookie for payment
                // print_r($session_querystring);die;
                if(!empty($inputs['rlsnrwds']) && @$inputs['rlsnrwds'] == 'no'){
                     $fbLoginQuerystring = array('gid' => $inputs['gid'], 'rlsnrwds' => $inputs['rlsnrwds']);
                     // print_r($fbLoginQuerystring);die;
                     //$this->check_rewards_cookie($fbLoginQuerystring); //set cookie for game if don't want to show rules/rewards popup
                }
                $gid = $session_querystring[ 'gid' ];
                    $redirect_url="";
                    if($_SESSION[ 'data' ][ 'tnc_agree' ] == "0" ) {
                    $redirect_url= 'TnC';
                      echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url ) );
                    }else if ( @$session_querystring[ 'section' ] == "home" ) {
                       $redirect_url = "Home";
                            echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url ) );
                    }else if ( @$session_querystring[ 'section' ] == "subscriptions" ) {
                       $redirect_url = "Subscriptions";
                            echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url ) );
                    }else if (empty(@$session_querystring['sub_section' ]) &&  @$session_querystring[ 'section' ] == "predictions" && isset($session_querystring['gid'])) {    
                            //$this->check_rewards_cookie($session_querystring); //set cookie for game if don't want to show rules/rewards popup
                            $redirect_url = "Predictions/prediction_game/".$gid;
                          echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url ) );
                    }else if (!empty(@$session_querystring['sub_section' ]) && isset($session_querystring['gid']) && @$session_querystring['section'] != "quiz"&& @$session_querystring['section'] != "blog") {    
                            $redirect_url = "Predictions/".@$session_querystring['sub_section' ]."/".$gid;
                          echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url ) );
                    }else if ( @$session_querystring[ 'section' ] == "games" && isset($session_querystring['gid'])) {    
                            $redirect_url = "games/".$gid;
                          echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url ) );
                    }else if ( !empty(@$session_querystring['section' ])  && empty($session_querystring['gid']) && @$session_querystring['section'] != "instruction") {
                              $redirect_url = $session_querystring['section' ];
                          echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url ) );
                    }else if (@$session_querystring['section'] == "instruction" && !empty(@$session_querystring['section' ]) &&  !empty(@$session_querystring['section2' ])&&  !empty(@$session_querystring['section3' ])) {
                            $redirect_url ="quiz/".$session_querystring['section' ]."/".$session_querystring['section2']."?topic_id=".$session_querystring['section3'];
                             echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url ) );
                    }else if (@$session_querystring['section'] == "blog" &&  !empty(@$session_querystring['section' ]) &&  !empty(@$session_querystring['sub_section' ])&&  !empty(@$session_querystring['gid' ])) {
                        $redirect_url =$session_querystring['section' ]."/".$session_querystring['sub_section']."/".$session_querystring['gid'];
                         echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url ) );
                    }else if (@$session_querystring['section'] == "blog" &&  @$session_querystring['gid' ]=="list") {
                        $redirect_url ="blog/".$queryString['gid' ];
                               echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => $redirect_url ) );
                    } else {    
                    echo json_encode( array ( "status" => TRUE, "message" => "", "redirect_url" => "Home" ) );
                }
                 
            
        } else {
            echo json_encode( array ( "status" => FALSE, "message" => "", "redirect_url" => "Login" ) );
        }
    }

    public function googlelogin() {

        require_once APPPATH . 'libraries/src/Google_Client.php';
        require_once APPPATH . 'libraries/src/contrib/Google_Oauth2Service.php';
        $session_querystring = $this -> session -> userdata( 'querystring' );
        if(empty($session_querystring)){
            $queryString = $this -> input -> get();
            $this -> session -> set_userdata( 'querystring', $queryString );
        }
        // print_r($session_querystring);die;


        $google_client_id = '884397487568-3ktp387ra6kgq3gb0qc0iga6g2pagbh4.apps.googleusercontent.com';
        $google_client_secret = 'hAxuV6RG5AvlF1qGSCGvhPFu';

        $google_redirect_url = base_url() . 'Login/googleloginresponse';

        $gClient = new Google_Client(); 
        $gClient -> setApplicationName( 'crowdwisdom360' );
        $gClient -> setClientId( $google_client_id );
        $gClient -> setScopes( 'email' );
        $gClient -> setClientSecret( $google_client_secret );
        $gClient -> setRedirectUri( $google_redirect_url );

        $authUrl = $gClient -> createAuthUrl();

        if ( isset( $authUrl ) ) {
            header( 'Location: ' . filter_var( $authUrl, FILTER_SANITIZE_URL ) );
        }
    }

    public function googleloginresponse() {
        require_once APPPATH . 'libraries/src/Google_Client.php';
        require_once APPPATH . 'libraries/src/contrib/Google_Oauth2Service.php';

        $google_client_id = '884397487568-3ktp387ra6kgq3gb0qc0iga6g2pagbh4.apps.googleusercontent.com';
        $google_client_secret = 'hAxuV6RG5AvlF1qGSCGvhPFu';

        $google_redirect_url = base_url() . 'Login/googleloginresponse'; // Localhost URL 
        $login_redirect_url = base_url() . 'Login'; // Localhost Login Redirect URL


        $gClient = new Google_Client();
        $gClient -> setApplicationName( 'crowdwisdom360' );
        $gClient -> setClientId( $google_client_id );
        $gClient -> setClientSecret( $google_client_secret );
        $gClient -> setRedirectUri( $google_redirect_url );
        //$gClient->setDeveloperKey($google_developer_key);

        $google_oauthV2 = new Google_Oauth2Service( $gClient );

        //If user wish to log out, we just unset Session variable
        if ( isset( $_REQUEST[ 'reset' ] ) ) {
            unset( $_SESSION[ 'token' ] );
            $gClient -> revokeToken();
            header( 'Location: ' . filter_var( $login_redirect_url, FILTER_SANITIZE_URL ) ); //redirect user back to page
        }

        //If code is empty, redirect user to google authentication page for code.
        //Code is required to aquire Access Token from google
        //Once we have access token, assign token to session variable
        //and we can redirect user back to page and login.
        if ( isset( $_GET[ 'code' ] ) ) {
            $gClient -> authenticate( $_GET[ 'code' ] );
            $_SESSION[ 'token' ] = $gClient -> getAccessToken();
            header( 'Location: ' . filter_var( $google_redirect_url, FILTER_SANITIZE_URL ) );
            return;
        }


        if ( isset( $_SESSION[ 'token' ] ) ) {
            $gClient -> setAccessToken( $_SESSION[ 'token' ] );
        }

        if ( $gClient -> getAccessToken() ) {
            //For logged in user, get details from google using access token
            $user = $google_oauthV2->userinfo-> get();
            $_SESSION[ 'token' ] = $gClient -> getAccessToken();

            if ( ! empty( $user ) && ! empty( $user[ 'email' ] ) ) {
                $user_id = $user[ 'id' ];
                if ( empty( $user[ 'name' ] ) ) {
                    $user_name = "";
                } else {
                    $user_name = $user[ 'name' ];
                }

                $user_email = $user[ 'email' ];
                $socialid = $user[ 'id' ];
                $login_type = "Google";

                //check if google id or email exists in the database
                //$response = $this->User_model->checkgooglelogin($googleid, $email); // Call API
                $this -> db -> select( "id,name,email,alise,location,party_affiliation,certificate_path,unearned_points,tnc_agree, coins,macid_unique,device_type" );
                $this -> db -> from( "users" );

                $setUniqueId=get_cookie('setUniqueId');

                if(!empty($setUniqueId)){
                    $this -> db -> where( "social_id = '$socialid' AND login_type = '$login_type' AND macid_unique='$setUniqueId'");
                }else{
                    $this -> db -> where( "social_id = '$socialid' AND login_type = '$login_type'" );
                } 

                $result = $this -> db -> get();
                $res = $result->row_array();
                // echo $this->db->last_query();
                $user_name = $res['name'];
                $is_exists = $result -> num_rows();

                /* Userdata */
                $userdata = array (
                    "name" => $user_name,
                    "social_id" => $socialid,
                    "email" => $user_email,
                    "login_type" => $login_type,
                    "coins" => $this->get_initial_coins,
                    "device_type"=>$this->device_type,
                );
              
               


                $preid = $this->session->userdata( 'querystring' );
            $final_res = $result->row_array();
                // print_r($res['device_type']);die;
                if(!empty($setUniqueId) && $is_exists == 0){
                    $this -> db -> select( "id,name,email,login_type, alise,location,party_affiliation,certificate_path,unearned_points,tnc_agree, coins,macid_unique" );
                        $this -> db -> from( "users" );
                    if(!empty($setUniqueId)){
                        $this ->db->where("macid_unique",$setUniqueId);
                    }                  
                    $result1 = $this -> db -> get();
                    $mac_res = $result1->row_array();
                    //print_r($mac_res);die;
                    $userLogindata = array (                               
                                "popup" => '1',
                                "msg"=>"You can login only with this mail ".@$mac_res['email'] . ' (' . @$mac_res['login_type'] . ')',
                            );
                    $_SESSION[ 'login_data' ] = $userLogindata;
                    redirect('Home/index/2');
                // echo $this->db->last_query();

                }else if ($is_exists == 0) {
                    /* Insert user data and set session */
                    $login_ip = $this->input->ip_address();
                    $userdata[ 'login_ip' ] = $login_ip;                   
                    $this ->db->insert( 'users', $userdata);
                    $userid = $this ->db->insert_id();
                    //insert coins
                   $game_coins_data=array('coins'=>$this->get_initial_coins, 
                           'user_id'=>$userid,
                           'created_date'=> date('Y-m-d H:i:s')
                        );
                    $this->db->insert( 'coins', $game_coins_data );                 
                    $this->db->insert( 'wallet_history', $game_coins_data );
                    //end insert coins
                    $userdata[ 'uid' ] = $userid;
                    $userdata[ 'game_point_pop' ] ='1';
                    $userdata[ 'get_initial_coins' ] =$this->get_initial_coins;
                    $userdata[ 'tnc_agree' ] = "0";
            
                }/* else if(!empty($final_res['device_type']) && $this->device_type != $final_res['device_type']) {
                        //print_r($mac_res);die;
                    $userLogindata = array (                               
                                "popup" => '1',
                                "msg"=>"Logged in on ".$final_res["device_type"],
                            );
                    $_SESSION[ 'login_data' ] = $userLogindata;
                    $redirect_url= 'Home/index/3';
                    redirect('Home/index/2');
                } */else{

                    $data = $result -> row_array();
                    $userdata[ 'uid' ] = $data[ 'id' ];
                    $userdata[ 'game_point_pop' ] ='0';
                    $userdata[ 'tnc_agree' ] = $data[ 'tnc_agree' ];
                    $login_ip = $this->input->ip_address();
                    $this->db->set('login_ip',$login_ip);
                    $this->db->set('device_type',$this->device_type);
                    $this->db->where('id', $data[ 'id' ]);
                    $this->db->update('users'); 
                    //echo $this->db->last_query();die();
                }

                  /*set cookei*/
        
                  $this->check_login_cookie($userdata);  //set cookie for payment
                // print_r($final_res);die;
                if (empty($setUniqueId)) {
                   
                    if(!empty($final_res['macid_unique'])){
                            $macid =$final_res['macid_unique'];
                        }else{
                          $macid='CW360'.$userdata[ 'uid' ]; 
                        }
                     // print_r($macid);die;
                        $macid_unique =macid_uniqueId($macid); 
                    
                        $this->db->set('macid_unique',$macid);
                        $this->db->set('device_type',$this->device_type);
                        $this->db->where('id', $userdata[ 'uid' ]);
                        $this->db->update('users'); 

                         $_SESSION[ 'data' ] = $userdata;                      
                        // echo $macid_unique; die;             
                    }else if($setUniqueId != $final_res['macid_unique']){
                            $userLogindata = array (                               
                                "popup" => '1',
                                "msg"=>"You can login only with this mail ".@$mac_res['email'] . ' (' . @$mac_res['login_type'] . ')',
                            );
                        $_SESSION[ 'login_data' ] = $userLogindata;  
                         redirect('Home/index/2'); 
                    }else if($setUniqueId == $final_res['macid_unique']){
                           // delete_cookie("setUniqueId");                  
                          $_SESSION[ 'data' ] = $userdata;   
                    }else{
                         $_SESSION[ 'data' ] = $userdata;  
                    }
                    // print_r($userdata);
                if (! empty( $_SESSION[ 'data' ] )) {
                    $session_querystring = $this -> session -> userdata( 'querystring' );
                    $this->check_login_cookie($session_querystring);  //set cookie for payment
                    // print_r($session_querystring);
                    $gid = @$session_querystring[ 'gid' ];
                        if ($_SESSION[ 'data' ][ 'tnc_agree' ] == "0" ) {
                         redirect( 'TnC' );
                        }else if ( @$session_querystring[ 'section' ] == "home" ) {
                             // echo "1";
                            redirect( 'Home' );

                        }else if ( @$session_querystring[ 'section' ] == "subscriptions" ) {
                             // echo "1";
                            redirect( 'Subscriptions' );

                        }else if ( empty(@$session_querystring['sub_section' ]) && @$session_querystring[ 'section' ] == "predictions" && isset($session_querystring['gid'])) {
                            // echo "2";
                            //$this->check_rewards_cookie($session_querystring);  //set cookie for game if don't want to show rules/rewards popup
                           redirect('Predictions/prediction_game/'.$gid);
                        }else if ( !empty(@$session_querystring['sub_section' ]) && isset($session_querystring['gid']) && @$session_querystring['section'] != "quiz" && @$session_querystring['section'] != "blog") {
                             // echo "3";
                            redirect('Predictions/'.@$session_querystring['sub_section' ].'/'.$session_querystring[ 'gid' ]);
                        }else if ( @$session_querystring[ 'section' ] == "games" && isset($session_querystring['gid'])) {
                            // echo "4";
                            redirect('games/'.$gid);
                        }else if ( !empty(@$session_querystring['section' ])  && empty($session_querystring['gid']) && @$session_querystring['section'] != "instruction") {
                            // echo "5";
                                redirect($session_querystring['section' ]);
                        }else if (@$session_querystring['section'] == "instruction" &&  !empty(@$session_querystring['section' ]) &&  !empty(@$session_querystring['section2' ])&&  !empty(@$session_querystring['section3' ])  && empty($session_querystring['gid'])) {
                            // echo "6";
                            redirect("quiz/".$session_querystring['section' ]."/".$session_querystring['section2']."?topic_id=".$session_querystring['section3']);
                        }else if (@$session_querystring['section'] == "quiz" &&  !empty(@$session_querystring['section' ]) &&  !empty(@$session_querystring['sub_section' ]) && !empty($session_querystring['gid'])) {
                            // echo "6";
                            redirect("quiz/".$session_querystring['sub_section' ]."/".$session_querystring['gid']);
                        }else if (@$session_querystring['section'] == "blog" &&  !empty(@$session_querystring['section' ]) &&  !empty(@$session_querystring['sub_section' ])&&  !empty(@$session_querystring['gid' ])) {
                            redirect($session_querystring['section' ]."/".$session_querystring['sub_section']."/".$session_querystring['gid']);
                        }else if (@$session_querystring['section'] == "blog" &&  @$session_querystring['gid' ]=="list") {
                            redirect("blog/".$session_querystring['gid' ]);
                        }else {
                            // echo "7";
                             redirect( 'Home' );
                        }
                    }
                } else {
                    redirect( 'Login' );
                }
            
        } else {
            header( 'Location: ' . filter_var( $login_redirect_url, FILTER_SANITIZE_URL ) );
        }
    }

    public function logout( $logout_section = "" ) {
        $redirect_to = "Home"; 
        $this->db->set('device_type',"Android");
        $this->db->where('id', $this->user_id);
        $this->db->update('users');     
        session_destroy();
        session_unset();
        redirect( $redirect_to);
    }

    public function privacy_policy() {
        $header_data[ 'page_title' ] = "Privacy Policy";
        $header_data[ 'page_img' ] = base_url( "images/logo/prediction_share_logo.png" );
        $header_data[ 'uid' ] = 0;
        $header_data[ 'silver_points' ] = 0;
        $header_data[ 'alias' ] = "";
        $header_data[ 'page_meta_keywords' ] = "";
        $header_data[ 'page_meta_description' ] = "";

        //$this -> load -> view( "bootstrap_header", $header_data );
        $this->load->view( "privacy_policy" );
        //$this -> load -> view( "bootstrap_footer" );
    }

    public function update_game_point_pop(){
        $status="";
       //print_r($_SESSION['data']);
        $_SESSION['data']['game_point_pop']='0';
        //print_r($_SESSION['data']);die;
        if($_SESSION['data']['game_point_pop'] == 0){
             $status="pass";
        }else{
             $status="fail";
        }
        echo json_encode($status);

    }
    /*private function check_rewards_cookie($queryString){
        if (!empty($queryString['rlsnrwds'])) {
            $check_cookie = get_cookie('game_'.$queryString['gid'].'_play');
            if (empty($check_cookie)) {
                $cookie= array(
                   'name'   => 'game_'.$queryString['gid'].'_play',
                   'value'  => 'play_game_'.$queryString['gid'],
                   'expire' => 86400 * 730
                );
                set_cookie($cookie);
            }
        }
    }*/


    public function check_login_cookie($queryString){
        
            $check_cookie = get_cookie('session_cookie');
            // echo "yees";die;
            // print_r($queryString);
            if (empty($check_cookie)) {
                $cookie= array(
                    'name'   => 'session_cookie',
                    'value'  => $queryString['uid'],
                    'expire' => 86400 * 730
                );
                set_cookie($cookie);
                // print_r($cookie);die;
            }
    }
}
