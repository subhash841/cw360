<?php

class Home_model extends CI_Model {
    function __construct() {
        parent::__construct();

          $sessiondata = $this->session->userdata('data');
          if (!empty($sessiondata)) {
            	$this->user_id = $sessiondata['uid'];
        	}else{
        		$this->user_id=0;
        	}
    }

    public function get_topic_list($limit="") {
       $this->db-> select( 't.*, bc.name as categoryname');
       $this->db-> from( 'topics t' );
       $this->db-> join( "blog_category bc", "bc.id = t.category","left");
       $this->db-> where('(t.created_date is NOT NULL OR t.is_trending = 1) AND t.is_active = 1');
       //$this->db-> or_where('t.is_trending','1');
       // $this->db->having('t.is_active = 1');
       $this->db-> order_by("t.trending_created_date desc");
       if(!empty($limit)){
           $this->db->limit('8');
       }
       $res = $this->db->get()->result_array();
       // echo $this->db->last_query();die;
       return $res;
    }

   

    // public function get_topic_list_userwise($limit="") {
    //     $this->db-> select( 't.*, bc.name as categoryname' );
    //     $this->db-> from( 'topics t' );
    //     $this->db-> join( "blog_category bc", "bc.id = t.category", "LEFT");
    //     $this->db-> join( "quiz_action q", "q.topic_id = t.id", "LEFT");
    //     $this->db-> join( "executed_predictions ep", "ep.topic_id = t.id", "LEFT");
    //     $this->db->where('t.is_active','1');  
    //     if(!empty($limit)){              
    //     	$this->db->limit('8');
    // 	}
    // 	$this->db->where('q.user_id',$this->user_id, FALSE);
    // 	$this->db->or_where('ep.user_id',$this->user_id, NULL, FALSE);
    //     $this->db->order_by('created_date','DESC');
    //     $res=$this->db->get()->result_array();        
    //     return $res;
    // }


   /* public function get_topic_list_userwise($limit="") {
        $this->db-> select( 't.*, bc.name as categoryname' );
        $this->db-> from( 'topics t' );
        $this->db-> join( "blog_category bc", "bc.id = t.category", "LEFT");
        $this->db-> join( "quiz_action q", "q.topic_id = t.id", "LEFT");
        $this->db-> join( "executed_predictions ep", "ep.topic_id = t.id", "LEFT");
        $this->db->where('t.is_active','1');  
        if(!empty($limit)){              
        	$this->db->limit('8');
    	}
    	$this->db->where('q.user_id',$this->user_id, FALSE);
    	$this->db->or_where('ep.user_id',$this->user_id, NULL, FALSE);
        $this->db->order_by('created_date','DESC');
        return $this->db->get()->result_array();
        
    }*/

    public function get_prediction_games_list($limit="") {
        $this->db-> select('g.id, g.title, g.req_game_points,g.req_game_points, g.topic_id, g.top_news, g.description, g.image, g.initial_game_points, g.reward, g.start_date,g.end_date, g.start_time, g.end_time, g.min_no_trade, g.shortsell_portfolio_limit, g.max_game_points, g.meta_keywords, g.meta_description, g.status, g.is_published, g.is_active,(CASE when DATEDIFF(g.end_date, NOW()) < 0 then "Game Ended" when DATEDIFF(g.end_date, NOW()) = 0 then "Ends Today" else concat(DATEDIFF(g.end_date, NOW())," ","Days Left") END)as game_end_date,g.max_players');
        $this->db-> from('games g');  
        // $this->db->join('points pt','pt.game_id =g.id','left');      
        $this->db->where('g.is_active','1');
        $this->db->where('g.is_published','1');
        $this->db->where("NOW() between date_format(str_to_date(g.start_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') and (date_format(str_to_date(g.end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'))");
        $this->db->order_by('g.id','DESC');
        if(!empty($limit)){
        	$this->db->limit('5');
        }
        $res=$this->db->get()->result_array();
        // echo $this->db->last_query();
        // echo "<pre>";
        // print_r($res);
        // die;
        return $res;
        
    }


    public function get_prediction_games_userwise($limit="") {
        $this->db-> select( 'g.*' );
        $this->db-> from( 'games g' );
        $this->db-> join( "executed_predictions ep", "ep.game_id = g.id", "LEFT");
      	$this->db->where('ep.user_id',$this->user_id, NULL, FALSE);
        $this->db->where('g.is_active','1');  
        $this->db->where('g.is_published','1');
        $this->db->where("NOW() between date_format(str_to_date(g.start_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') and (date_format(str_to_date(g.end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'))");
        $this->db->order_by('created_date','DESC');
        if(!empty($limit)){              
        	$this->db->limit('4');
    	}
        return $this->db->get()->result_array();
        
    }

   /* public function get_quiz_list_userwise($limit="") {
        $this->db-> select('q.*,qa.user_id');
        $this->db-> from( 'quiz q' );
        $this->db-> join( "quiz_action qa", "qa.quiz_id = q.quiz_id", "LEFT");
        $this->db->where('qa.user_id',$this->user_id);
        $this->db->where('q.is_active','1');          
        if(!empty($limit)){              
            $this->db->limit('4');
        }
        $this->db->order_by('q.created_date','DESC');
        return $this->db->get()->result_array();
        
    }

    public function get_blogs_list($limit="") {
        $this->db-> select(' id, user_id, name, category_id, sub_category_id, title, description, image,  total_likes, total_comments, total_views, link, type, meta_keywords, meta_description, is_approve, is_active, blog_order,DATE_FORMAT(blog_date, "%d %b %Y")as blog_date');
        $this->db-> from( 'blogs');        
        $this->db->where('type','1');
        $this->db->where('is_active','1');
        $this->db->where('is_approve','1');
        $this->db->where('is_active','1');
        if(!empty($limit)){
        	$this->db->limit('6');
        }
        $this->db->order_by('created_date','DESC');
        return $this->db->get()->result_array();
        
    }


    public function get_blogs_list_userwise($limit="") {
        $this->db-> select('*');
        $this->db-> from( 'blogs ' );
      	$this->db->where('user_id',$this->user_id);
        $this->db->where('is_active','1');          
        if(!empty($limit)){              
        	$this->db->limit('6');
    	}
        $this->db->order_by('created_date','DESC');
        return $this->db->get()->result_array();
        
    }*/

    /*public function get_subscription_history()
    {
        
        $this->db-> select('pt.id, pt.user_id, pt.user_email, pt.user_mobile, pt.package_id, pt.package_name, pt.transaction_amount,  pt.transaction_status, pt.transaction_date,sp.points as coins');
        $this->db-> from( 'package_transactions pt' );
        $this->db->join('subscription_plans sp','sp.id=pt.package_id');
        $this->db->where('pt.user_id',$this->user_id); 
        $this->db->order_by('pt.created_date','DESC');
        return $this->db->get()->result_array();
    }*/
    public function get_subscription_history()
    {   
        $this->db->select('st.id, round(st.coins) as coins, st.package_id, st.transaction_amount, date_format(str_to_date(st.transaction_date, "%d-%m-%Y %H:%i:%s"), "%Y-%m-%d %H:%i:%s") as transaction_date, sp.package_name');
        $this->db->from('subscription_transactions st');
        $this->db->join('subscription_plans sp','st.package_id=sp.id','LEFT');
        $this->db->where('st.user_id',$this->user_id); 
        $this->db->where('st.response_code','E000'); 
        $this->db->order_by('st.id','DESC');
        return $this->db->get()->result_array();
    }
    public function get_notifications()
    {   
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where("(user_id = $this->user_id OR user_id IS NULL) AND created_date BETWEEN NOW() - INTERVAL 10 DAY AND NOW() AND (game_id IS NULL OR game_id IS NOT NULL OR prediction_id IS NULL OR prediction_id IS NOT NULL) AND (CASE 
            WHEN prediction_id IS NOT NULL AND prediction_status IS NULL THEN FIND_IN_SET($this->user_id, user_id_set) ELSE TRUE END) AND created_date >= (SELECT created_date FROM users where id = $this->user_id)");     //Not to remove space after CASE word
        $this->db->order_by('id','DESC');
        $notifications = $this->db->get()->result_array();
        if (!empty($notifications)) {
            $lastNotificationId = $notifications[0]['id'];
                $this->db->set('last_notification_id', $lastNotificationId);
                $this->db->where('id', $this->user_id);
                $this->db->update('users');
        }
        return $notifications;
    }
     public function get_notification_ids()
    {   
        $this->db->select('id');
        $this->db->from('notifications');
        $this->db->where("(user_id = $this->user_id OR user_id IS NULL) AND created_date BETWEEN NOW() - INTERVAL 10 DAY AND NOW() AND (game_id IS NULL OR game_id IS NOT NULL OR prediction_id IS NULL OR prediction_id IS NOT NULL) AND (CASE 
            WHEN prediction_id IS NOT NULL AND prediction_status IS NULL THEN FIND_IN_SET($this->user_id, user_id_set) ELSE TRUE END) AND created_date >= (SELECT created_date FROM users where id = $this->user_id)");         //Not to remove space after CASE word
        $this->db->order_by('id','DESC');
        return $this->db->get()->result_array();
    }
    public function get_last_notification_id()
    {   
        $this->db->select('last_notification_id');
        $this->db->from('users');
        $this->db->where('id',$this->user_id);
        return $this->db->get()->row_array();
    }
    public function get_new_notifications($lastNotificationId,$user_notifications)
    {   
        if (empty($lastNotificationId)) {
            $lastNotificationId = 0;
        }
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where("id > $lastNotificationId AND (user_id = $this->user_id OR user_id IS NULL) AND created_date BETWEEN NOW() - INTERVAL 10 DAY AND NOW() AND (game_id IS NULL OR game_id IS NOT NULL OR prediction_id IS NULL OR prediction_id IS NOT NULL) AND (CASE 
            WHEN prediction_id IS NOT NULL AND prediction_status IS NULL THEN FIND_IN_SET($this->user_id, user_id_set) ELSE TRUE END) AND created_date >= (SELECT created_date FROM users where id = $this->user_id)");     //Not to remove space after CASE word
        $this->db->order_by('id','DESC');
        $notifications = $this->db->get()->result_array();
        if ($user_notifications=='true') {
            if (!empty($notifications)) {
                $lastNotificationId = $notifications[0]['id'];
                    $this->db->set('last_notification_id', $lastNotificationId);
                    $this->db->where('id', $this->user_id);
                    $this->db->update('users');
            }
        }
        return $notifications;
    }
    public function get_user_coins()
    {   
        $this->db->select('coins');
        $this->db->from('coins');
        $this->db->where('user_id',$this->user_id);
        return $this->db->get()->row_array();
    }

    // public function user_details($user_id)
    // {
    //     $this->db->select('name,dob,email,gender,phone,image');
    //     $this->db->from('users');
    //     $this->db->where('id',$user_id);
    //     return $this->db->get()->row_array();
    // }


}