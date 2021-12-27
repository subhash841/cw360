<?php
	class AppHome_model extends CI_Model{

            public function topic_list ($limit=0,$offset=0){
                $this->db-> select('t.*');
                $this->db-> from('topics t');
                $this->db-> where('(t.created_date is NOT NULL OR t.is_trending = 1) AND t.is_active = 1');
                $this->db-> order_by('trending_created_date','desc');

                if(!empty($limit)){
                     $this->db->limit($limit,$offset);
                }
                $res = $this->db->get()->result_array();
                return $res;
            }


            public function game_list ($limit=0,$offset=0){
                $this->db-> select('g.id, g.title, g.req_game_points,g.req_game_points, g.topic_id, g.top_news, g.description, g.image, g.initial_game_points, g.reward, g.start_date,g.end_date, g.start_time, g.end_time, g.min_no_trade, g.shortsell_portfolio_limit, g.max_game_points, g.meta_keywords, g.meta_description, g.status, g.is_published, g.is_active,(CASE when DATEDIFF(g.end_date, NOW()) < 0 then "Game Ended" when DATEDIFF(g.end_date, NOW()) = 0 then "Ends Today" else concat(DATEDIFF(g.end_date, NOW())," ","Days Left") END)as game_end_date,g.max_players');
                $this->db->from('games g');  
                $this->db->where('g.is_active','1');
                $this->db->where('g.is_published','1');
                $this->db->where("NOW() between date_format(str_to_date(g.start_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') and (date_format(str_to_date(g.end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'))");
                $this->db->order_by('g.id','DESC');
                if(!empty($limit)){
                    $this->db->limit($limit,$offset);
                }               
                $res=$this->db->get()->result_array();
                return $res;
            }


            public function quiz_list ($limit=0,$offset=0,$user_id=0){
                    $this->db->select('*');
                    $this->db->from( 'quiz');        
                    $this->db->where('is_active','1');
                    $this->db->where('is_published','1');
                    $this->db->where('date(end_date) >= curdate()');
                    if($user_id != 0 ){
                    $this->db->where("quiz_id not in (select quiz_id from quiz_attempted where user_id = $user_id  group by quiz_id)");
                    }
                    // print_r($topic_id); 
                    if(!empty($quiz_id)){
                            if(!empty($topic_id)){
                                $this->db->where("topic_id REGEXP CONCAT('(^|,)(', REPLACE('$topic_id', ',', '|'), ')(,|$)')");
                                $result='result_array';
                            }else{                    
                                $this->db->where('quiz_id',$quiz_id);
                                $result='row_array';
                            }
                    }else{
                        $result='result_array';
                    }        
                    $this->db->order_by('quiz_id','DESC');
                    // echo $result;
                    if(!empty($limit)){
                        $this->db->limit($limit,$offset);
                    }
                    $res=$this->db->get()->$result();
                    // echo $this->db->last_query();die;
                    return $res; 
            }

            public function blog_list ($limit=""){
                    $this->db->select("id,title,description,image,(case when modified_date is null then DATE_FORMAT(created_date, '%e %b %Y') else DATE_FORMAT(modified_date, '%e %b %Y') END) as created_date");
                    $this->db->from('blogs');
                    $this->db->where(array('is_active'=>'1','is_approve'=>'1'));
                    $this->db->order_by('modified_date','desc');
                    if(!empty($limit)){
                        $this->db->limit($limit);
                    } 
                    $result = $this->db->get()->result_array();
                    return $result; 

            }


            public function get_topicgames($id){
            $limit = 4;
            $sql = "select id,title,req_game_points,req_game_points,image, (CASE when DATEDIFF(end_date, NOW()) < 0 then 'Game Ended' when DATEDIFF(end_date, NOW()) = 0 then 'Ends Today'  else concat(DATEDIFF(end_date, NOW()),' ','Days left') END)as end_date ,topic_id FROM games where topic_id= " . $id . " AND NOW() between date_format(str_to_date(start_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') and (date_format(str_to_date(end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s')) AND   is_active = '1'AND is_published = '1' ORDER BY id DESC limit " . $limit . " ";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
            }


            function get_category_name($id) {
            $this->db->select('t.topic as name');
            $this->db->from('topics t');
            $this->db->join('blog_category b', 't.category=b.id', 'LEFT');
            $this->db->where(array('t.id' => $id, 'b.is_active' => 1,'t.is_active' => 1));
            return $this->db->get()->row_array();
            }



            public function get_quiz_list($limit="",$topic_id="",$offset=0,$quiz_id="",$user_id ="") {
                                
                $this->db-> select('*');
                $this->db-> from( 'quiz');        
                $this->db->where('is_active','1');
                $this->db->where('is_published','1');
                $this->db->where('date(end_date) >= curdate()');
                if($user_id!=0 ){
                $this->db->where("quiz_id not in (select quiz_id from quiz_attempted where user_id = $user_id  group by quiz_id)");
                }
                // print_r($topic_id); 
                if(!empty($quiz_id)){
                        if(!empty($topic_id)){
                            $this->db->where("topic_id REGEXP CONCAT('(^|,)(', REPLACE('$topic_id', ',', '|'), ')(,|$)')");
                            $result='result_array';
                        }else{                    
                            $this->db->where('quiz_id',$quiz_id);
                            $result='row_array';
                        }
                }else{
                    $result='result_array';
                }        
                $this->db->order_by('quiz_id','DESC');
                // echo $result;
                if(!empty($limit)){
                    $this->db->limit($limit,$offset);
                }
                $res=$this->db->get()->$result();
                // echo $this->db->last_query();die;
                return $res; 
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
                    $this->db->where("quiz_id not in (select quiz_id from quiz_attempted where user_id = $user_id  group by quiz_id)");
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

            public function get_notification_ids($user_id){   
                $this->db->select('id');
                $this->db->from('notifications');
                $this->db->where("(user_id = $user_id OR user_id IS NULL) AND created_date BETWEEN NOW() - INTERVAL 10 DAY AND NOW() AND (game_id IS NULL OR game_id IS NOT NULL OR prediction_id IS NULL OR prediction_id IS NOT NULL) AND (CASE 
                    WHEN prediction_id IS NOT NULL AND prediction_status IS NULL THEN FIND_IN_SET($user_id, user_id_set) ELSE TRUE END) AND created_date >= (SELECT created_date FROM users where id = $user_id)");         //Not to remove space after CASE word
                $this->db->order_by('id','DESC');
                return $this->db->get()->result_array();
            }

             public function get_last_notification_id($user_id)
            {   
                $this->db->select('last_notification_id');
                $this->db->from('users');
                $this->db->where('id',$user_id);
                return $this->db->get()->row_array();
            }

        }
?>
