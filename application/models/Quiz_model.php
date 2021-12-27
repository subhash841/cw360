<?php

class Quiz_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
        $this->quiz_win_coin_limit="2000";
        $this->limit_end_date=date('Y-m-d',strtotime('+30 days',strtotime(date('Y-m-d'))));
        $this->table_name="quiz_action";
    }

    public function get_quiz_list($limit="",$topic_id="",$offset=0,$quiz_id="") {
        $this->db-> select('*');
        $this->db-> from( 'quiz');        
        $this->db->where('is_active','1');
        $this->db->where('is_published','1');
        $this->db->where('date(end_date) >= curdate()');
        if($this->user_id !=0 ){
        $this->db->where("quiz_id not in (select quiz_id from quiz_attempted where user_id = $this->user_id  group by quiz_id)");
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

    public function get_quiz_by_topic_list($limit="",$topic_id="",$offset=0) {
        $this->db-> select('*');
        $this->db-> from( 'quiz');        
        $this->db->where('is_active','1');
        $this->db->where('is_published','1');
        $this->db->where('date(end_date) >= curdate()');
        if($this->user_id !=0 ){
        $this->db->where("quiz_id not in (select quiz_id from quiz_attempted where user_id = $this->user_id  group by quiz_id)");
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

    public function get_quiz_instruction_data($limit="",$topic_id="",$offset=0,$quiz_id="") {
        $this->db-> select('quiz_id, user_id, category, topic_id, name, description, image, total_questions, correct_ans_coins, wrong_ans_coins,  is_published, is_active, meta_description, meta_keywords');
        $this->db-> from( 'quiz');        
        $this->db->where('is_active','1');
        $this->db->where('is_published','1');
        $this->db->where('date(end_date) >= curdate()');
        $this->db->where('quiz_id',$quiz_id);
        if($this->user_id !=0 ){
            $this->db->where("quiz_id not in (select quiz_id from quiz_attempted where user_id = $this->user_id  group by quiz_id)");
        }
      
        $res=$this->db->get()->row_array();
        // echo $this->db->last_query();die;
        return $res; 
        
    }

    function get_question_list($question_limit,$quiz_id,$topic_id) {

        $this->db->distinct();
        $this->db->select("q.id");
        $this->db->from("questions q");
        // $this->db->join("quiz_action qa","qa.topic_id=q.topic_id","left");
        // $this->db->where("FIND_IN_SET($topic_id,q.topic_id)>0");
        $this->db->where("q.id not in (select question_id from quiz_action where user_id = $this->user_id  and quiz_id=$quiz_id)");
        $this->db->where("q.topic_id REGEXP CONCAT('(^|,)(', REPLACE('$topic_id', ',', '|'), ')(,|$)')");
        $this->db->where('q.is_active','1');
          $this->db->where('q.is_published','1');
        $this->db->order_by('q.id', 'RANDOM');
        $this->db->limit($question_limit);
        $res= $this->db->get()->result_array();
        //         echo $this->user_id;
        // echo $this->db->last_query();die;
       
        if(empty($res) && $question_limit!= 0){
        $this->db->distinct();
        $this->db->select("q.id");
        $this->db->from("questions q");
      /*  $this->db->join("quiz_action qa","qa.topic_id=q.topic_id","left");
        $this->db->where("FIND_IN_SET($topic_id,q.topic_id)>0");*/
        $this->db->where("q.topic_id REGEXP CONCAT('(^|,)(', REPLACE('$topic_id', ',', '|'), ')(,|$)')");
        $this->db->where('q.is_active','1');
        $this->db->where('q.is_published','1');
        $this->db->order_by('q.id', 'RANDOM');
        $this->db->limit($question_limit);
        // $res= $this->db->get()->result_array();
        $res= $this->db->get()->result_array();
        }

       
        return $res;
    }

    public function attempt_question_limit($quiz_id)
    {
        $where = array('user_id' => $this->user_id, 'quiz_id' => $quiz_id);
        $this->db->select("count(id) as attempt_question_limit");
        $this->db->from("quiz_action");       
        $this->db->where($where);
        $res= $this->db->get()->row_array();
        // echo $this->db->last_query();
        // echo "<pre>";
        // print_r($res);
        return $res['attempt_question_limit'];
    }

    function get_question($id) {
        $this->db->select("id, question, topic_id ,quiz_id");
        $this->db->from("questions");
        $this->db->where('is_active','1');
        $this->db->where('is_published','1');
        // $this->db->join("quiz_action qa","qa.topic_id=q.topic_id","left");
        // $this->db->where("FIND_IN_SET($topic_id,q.topic_id)>0");
        // $this->db->where("q.id not in (select question_id from quiz_action)");
        // $this->db->order_by('q.id', 'RANDOM');
        //$this->db->limit($question_limit);
        $this->db->where("id",$id);
        $res= $this->db->get()->row_array();
        // echo $this->db->last_query();
        // echo "<pre>";
        // print_r($res);
        return $res;
    }

    function get_question_limt_topic($quiz_id){
        $this->db->select("topic_id,total_questions");
        $this->db->from("quiz");
        $this->db->where("quiz_id",$quiz_id);
        $res= $this->db->get()->row_array();
        // echo $this->db->last_query();
        // echo "<pre>";
        // print_r($res);
         return $res;
    }

    function get_question_ans($question_id){
        $this->db->select("id,question_id,choice,correct_choice");
        $this->db->from("question_choices");
        $this->db->where("question_id",$question_id);
        $res= $this->db->get()->result_array();
        return $res;
    }

    function get_point_for_answer($quiz_id){
 
        $this->db->select("quiz_id,correct_ans_coins,wrong_ans_coins");
        $this->db->from("quiz");
        $this->db->where("quiz_id",$quiz_id);
        $res= $this->db->get()->row_array();
        return $res;

    }
    function get_question_answer_chk(){
        // $_POST['id'],$_POST['question_id']
        $data_ans_point=$this->get_point_for_answer($_POST['quiz_id']);
        $this->db->select("id,question_id,choice,correct_choice");
        $this->db->from("question_choices");
        $this->db->where("id",$_POST['id']);
        $this->db->where("question_id",$_POST['question_id']);
        $res= $this->db->get()->row_array();
        if($res['correct_choice']=='yes'){
            $result="1";
            $ans_status='right';
            $ans_point=$data_ans_point['correct_ans_coins'];
            $type='5';
            $update_coins='coins + '.$ans_point;
        }else{
             $result="0";
             $ans_status='wrong';
             $ans_point=$data_ans_point['wrong_ans_coins'];
             $type='6';
            $update_coins='coins - '.$ans_point;
        }
           $insert_array=array('quiz_id'=>$_POST['quiz_id'], 
                        'question_id'=>$_POST['question_id'],
                        'choice'=>$_POST['id'],
                        'user_id'=>$this->user_id,//set seesion $this->userdata['user_id'] 
                        'ans_status'=>$ans_status,
                        'coins'=>$ans_point,
                        'created_date'=> date('Y-m-d H:i:s'));
        // echo $this->db->last_query();
        // echo "<pre>";
        // print_r($res);die;
        if($this->db->insert($this->table_name,$insert_array)){

            $this->db->set('coins', $update_coins, false);
             $this->db->where('user_id',$this->user_id);
           $this->db->update('coins');
            if ($this->db->affected_rows() > 0) {
                $insert_wallet_history = array(
                            'user_id' =>$this->user_id,
                            'quiz_id' =>$_POST['quiz_id'],
                            'coins' => $ans_point,
                            'type'=>$type, 
                            'created_date'=>date('Y-m-d H:i:s')
                            );
  
                }
     
                $this->db->insert('wallet_history',$insert_wallet_history);
         return $result;
        }else{
          return $result;
        }
        
    }

    function question_time_out(){
        // $_POST['id'],$_POST['question_id']
 
        $this->db->select("id,topic_id,question");
        $this->db->from("questions");
        $this->db->where('is_active','1');
        $this->db->where('is_published','1');
        $this->db->where("id",$_POST['id']);
        $res= $this->db->get()->row_array();
        $data_ans_point=$this->get_point_for_answer($_POST['quiz_id']);
        // print_r($data_ans_point['wrong_ans_coins']);die;
        $result="0";
        $ans_status='timeout';
        $ans_point=$data_ans_point['wrong_ans_coins'];
    
           $insert_array=array('quiz_id'=>$_POST['quiz_id'], 
                        'question_id'=>$res['id'],
                        'choice'=>'0',
                        'user_id'=>$this->user_id,//set seesion $this->userdata['user_id'] 
                        'ans_status'=>$ans_status,
                        'coins'=>$ans_point,
                        'created_date'=> date('Y-m-d H:i:s'),);
        // echo $this->db->last_query();
        // echo "<pre>";
        // print_r($res);die;
        if($this->db->insert($this->table_name,$insert_array)){
            $this->db->set('coins', 'coins -'.$ans_point, false);
            $this->db->where('user_id',$this->user_id);
            $this->db->update('coins');
            if ($this->db->affected_rows() > 0) {
                $insert_wallet_history = array(
                            'user_id' =>$this->user_id,
                            'quiz_id' =>$_POST['quiz_id'],
                            'coins' => $ans_point,
                            'type'=>'6', 
                            'created_date'=>date('Y-m-d H:i:s')
                            );
  
                }
     
                $this->db->insert('wallet_history',$insert_wallet_history);
         return $result;
        }else{
          return $result;
        }
        
    }

    public function get_quiz_ans($quiz_id)
    {
        $this->db->select("qa.id,  qa.quiz_id, qa.question_id, qa.choice, qa.user_id, qa.ans_status, qa.coins,q.question,(select choice from question_choices where question_id=qa.question_id and correct_choice='yes') as correct_ans,(select name from quiz where quiz_id=qa.quiz_id) as quiz_title");
        $this->db->from("quiz_action  qa");
        $this->db->join("questions  q","qa.question_id=q.id");
        $this->db->where(array("qa.quiz_id"=>$quiz_id,"qa.user_id"=> $this->user_id));
        $this->db->order_by('qa.id');
        $res= $this->db->get()->result_array();
        // echo $this->db->last_query();die;
        return $res;
    }
    public function get_quiz_summary_share($quiz_id,$user_id)
    {
        $this->db->select("qa.id,  qa.quiz_id, qa.question_id, qa.choice, qa.user_id, qa.ans_status, qa.coins,q.question,(select choice from question_choices where question_id=qa.question_id and correct_choice='yes') as correct_ans,(select name from quiz where quiz_id=qa.quiz_id) as quiz_title");
        $this->db->from("quiz_action  qa");
        $this->db->join("questions  q","qa.question_id=q.id");
        $this->db->where(array("qa.quiz_id"=>$quiz_id,"qa.user_id"=> $user_id));
        $this->db->order_by('qa.id');
        $res= $this->db->get()->result_array();
        // echo $this->db->last_query();die;
        return $res;
    }
     public function quiz_start_chk_data()
    {
        $this->db->select("count(id) as attempt_count");
        $this->db->from("quiz_attempted");
        $this->db->where(array("quiz_id"=>base64_decode($_POST['quiz_id']),"user_id"=>$this->user_id));
        $res= $this->db->get()->row_array();
        // echo $this->db->last_query();die;
        return $res['attempt_count'];
    }

    public function quiz_start_insert_data()
    {
        $insert_array=array("quiz_id"=>base64_decode($_POST['quiz_id']),"user_id"=>$this->user_id, 'created_date'=> date('Y-m-d H:i:s'));
          if($this->db->insert('quiz_attempted',$insert_array)){
                $is_chceck_users_quiz_coin_limit=$this->users_quiz_coin_limit(); 

                if($is_chceck_users_quiz_coin_limit['quiz_coin_limit_attempt_count'] == 0){
                    $insert_coin_limit_array=array("user_id"=>$this->user_id,"coin_limit"=>$this->quiz_win_coin_limit, 'limit_start_date'=> date('Y-m-d'),'limit_end_date'=>$this->limit_end_date,'max_limit_coin'=>$this->quiz_win_coin_limit);

                    $this->db->insert('users_quiz_coin_limit',$insert_coin_limit_array);

                }else if($is_chceck_users_quiz_coin_limit['limit_end_date'] < date('Y-m-d') && $is_chceck_users_quiz_coin_limit['quiz_coin_limit_attempt_count'] != 0) {
                     $update_coin_limit_array=array("coin_limit"=>$this->quiz_win_coin_limit, 'limit_start_date'=> date('Y-m-d'),'limit_end_date'=>$this->limit_end_date); 
                     $this->db->where("user_id",$this->user_id);
                     $this->db->update('users_quiz_coin_limit',$update_coin_limit_array);  
                }
            return true;
          }else{
            return false;
          }
    }

    public function users_quiz_coin_limit()
    {
        $this->db->select("count(id) as quiz_coin_limit_attempt_count,coin_limit,limit_end_date,max_limit_coin");
        $this->db->from("users_quiz_coin_limit");
        $this->db->where("user_id",$this->user_id);
        $res= $this->db->get()->row_array();
        return $res;
    }
     public function quiz_question_check($quiz_id)
    {
        $this->db->select("topic_id");
        $this->db->from("quiz ");
        $this->db->where("quiz_id",$quiz_id);
        $res= $this->db->get()->row_array();
        $topic_id= $res['topic_id'];
        $this->db->select("count(id) as no_question_available");
        $this->db->from("questions");
        $this->db->where("topic_id REGEXP CONCAT('(^|,)(', REPLACE('$topic_id', ',', '|'), ')(,|$)')");
        $res= $this->db->get()->row_array();
        // echo $this->db->last_query();die;
        return $res['no_question_available'];        
    }
    public function get_user_name($user_id){
      $this->db->select('name');
      $this->db->from('users'); 
      $this->db->where('id',$user_id);
      $result = $this->db->get()->row_array();
      return $result;
    }

    public function get_preview_quiz_instruction_data($limit="",$topic_id="",$offset=0,$quiz_id="") {
        $this->db-> select('quiz_id, user_id, category, topic_id, name, description, image, total_questions, correct_ans_coins, wrong_ans_coins,  is_published, is_active');
        $this->db-> from( 'quiz');        
        $this->db->where('is_active','1');
        $this->db->where('is_published','1');
        $this->db->where('date(end_date) >= curdate()');
        $this->db->where('quiz_id',$quiz_id);
        // if($this->user_id !=0 ){
        //     $this->db->where("quiz_id not in (select quiz_id from quiz_attempted where user_id = $this->user_id  group by quiz_id)");
        // }
      
        $res=$this->db->get()->row_array();
        // echo $this->db->last_query();die;
        return $res; 
        
    }
}    