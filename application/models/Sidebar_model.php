<?php

class Sidebar_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $sessiondata = $this->session->userdata('data');
        // print_r($sessiondata);die;
        if (!empty($sessiondata)) {
            $this->user_id = @$sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
    }
    
    function get_all_games($limit='',$topic_id="",$offset = 0) {
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
           /*  $this->db->order_by($sql.' DESC');
            $this->db->order_by('id', 'DESC'); */
            $this->db->order_by($sql." desc");
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
            /* $this->db->order_by($sql.' DESC');
            $this->db->order_by('id', 'DESC'); */
            $this->db->order_by($sql."desc ,id desc,blog_order desc"); 

        } else {
            $this->db->order_by('id', 'DESC');
        }

        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function get_all_quiz($limit="",$topic_id="",$offset=0) {
        $this->db-> select('`quiz_id`, `user_id`, `category`, `topic_id`, `name`, `description`, `image`, `total_questions`, `correct_ans_coins`, `wrong_ans_coins`, `meta_keywords`, `meta_description`, `is_active`, `is_published`, `end_date`, `created_date`, `modified_date`');
        $this->db-> from( 'quiz');        
        $this->db->where('is_active','1');
        $this->db->where('is_published','1');
        $this->db->where('end_date >= now()');
       
        if(!empty($topic_id)){   
            $sql=$this->topic_wise_sort($topic_id);    
            /* $this->db->order_by($sql.' DESC');
            $this->db->order_by('quiz_id','DESC'); */
            $this->db->order_by($sql."desc ,quiz_id desc"); 

        }else{
            $this->db->order_by('quiz_id','DESC');
        }
        if($this->user_id !=0 ){
            $this->db->where("quiz_id not in (select quiz_id from quiz_attempted where user_id = $this->user_id  group by quiz_id)");
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
    
}

