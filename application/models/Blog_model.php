<?php

class Blog_model extends CI_Model {

    public function get_blog_detail($id) {
        $this->db->select('*');
        $this->db->from('blogs');
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        return reset($result);
    }

    function update_view_count($id){
        $this->db->set('total_views', 'total_views+1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('blogs');
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
    }

    function get_user_like($blog_id,$user_id){
        $this->db->select('is_like');
        $this->db->from('blog_likes');
        $this->db->where(array('blog_id'=>$blog_id,'user_id'=>$user_id,'is_like'=>1));
        $result = $this->db->get()->result_array();
        return reset($result);
    }

    function update_blog_like($blog_id,$user_id){
        $this->db->select('id,user_id,blog_id,is_like');
        $this->db->from('blog_likes');
        $this->db->where(array('blog_id'=>$blog_id,'user_id'=>$user_id));
        $result = $this->db->get()->row_array();
        if(empty($result)){
            $data = array('user_id'=>$user_id,'blog_id'=>$blog_id,'is_like'=>'1','created_date'=>'now()');
            $this->db->insert('blog_likes',$data);
            // echo $this->db->last_query();
            return ($this->db->affected_rows() != 1) ? array('status'=>FALSE,'msg'=>'unable to add your like' ,'like_value'=>'0'): array('status' => TRUE ,'msg'=>'like added sucessfully','like_value'=>'1') ;
        }else{
            $like = ($result['is_like']==0) ? '1' : '0'; 
            $this->db->set(array('is_like'=>$like,'modified_date'=>'now()'));
            $this->db->where(array('blog_id'=> $blog_id,'user_id'=>$user_id));
            $this->db->update('blog_likes');
            // echo $this->db->last_query();
            return ($this->db->affected_rows() != 1) ? array('status'=>FALSE,'msg'=>'unable to update your like','like_value'=>'0' ) : array('status' => TRUE ,'msg'=>'like updated sucessfully','like_value'=>$like);
        }
    }

    function add_blog_comment($blog_id,$user_id,$comment){
        $this->db->insert('blog_comments',array('user_id'=>$user_id,'voice_id'=>$blog_id,'comment'=>$comment));
        $insert_id = $this->db->insert_id();
        return $insert_id;
        // return $this->db->affected_rows() != 1 ?FALSE:TRUE;
    }

    function get_comment($comment_id){
        $this->db->select('b.id,b.comment,u.id as user_id, u.name,u.email,u.image');
        $this->db->from('blog_comments b');
        $this->db->join('users u', ' b.user_id = u.id ', 'left');
        $this->db->where(array('b.id'=>$comment_id,'b.is_active'=>'1'));
        return $this->db->get()->row_array();
    }

    function get_comments($blog_id,$user_id){
        // $this->db->select("b.id as comment_id,b.user_id,b.comment, b.total_replies, u.name, u.email, u.image,
        // (CASE when DATEDIFF(b.created_date, NOW()) = 0 then 'Today' else concat(DATEDIFF(b.created_date, NOW()),' ','Days ago') END)as created_date,
        // (CASE WHEN cl.comment_id = b.id AND cl.user_id = '$user_id' AND cl.user_like = '1' THEN 1 ELSE 0 END) as is_user_like");
        // $this->db->from("blog_comments b");
        // $this->db->join('users u', 'b.user_id = u.id', 'LEFT');
        // $this->db->join("comment_like cl ON cl.comment_id = b.id","LEFT");
        // $this->db->where("b.voice_id = '$blog_id' AND 'b.is_active'=>'1'");
        // $this->db->order_by('b.id','desc');
        // $this->db->get()->result_array();


        $this->db->select("b.id as comment_id,b.user_id,b.comment, b.total_replies, u.id, u.name, u.email, u.image,
            ( SELECT (CASE WHEN user_like = '1' THEN 1 ELSE 0 END) FROM comment_like WHERE  user_id = '$user_id'  AND comment_id = b.id ) as is_user_like,
        (CASE when DATEDIFF(b.created_date, NOW()) = 0 then 'Today' else concat(DATEDIFF(b.created_date, NOW()),' ','Days ago') END)as created_date, 
        cl.user_like as comment_like"); 
        $this->db->from('blog_comments b');
        $this->db->join('comment_like cl', 'cl.comment_id = b.id','left');
        $this->db->join('users u', ' b.user_id = u.id ','left');
        $this->db->where(array('b.voice_id'=>$blog_id,'b.is_active'=>'1'));
        $this->db->group_by('b.id');
        $this->db->order_by('b.id','desc');
        
        return $this->db->get()->result_array();
        //  $this->db->get()->result_array();
        //  echo $this->db->last_query();
        // die;
    }

    function update_comment_like($blog_id,$user_id,$comment_id){
        $this->db->select('id,blog_id,comment_id,user_id,user_like');
        $this->db->from('comment_like');
        $this->db->where(array('blog_id'=>$blog_id,'user_id'=>$user_id,'comment_id'=>$comment_id));
        $result = $this->db->get()->row_array();
        if(empty($result)){
            $data = array('blog_id'=>$blog_id,'comment_id'=>$comment_id,'user_id'=>$user_id,'user_like'=>'1');
            $this->db->insert('comment_like',$data);
            // echo $this->db->last_query();
            return ($this->db->affected_rows() != 1) ? array('status'=>FALSE,'msg'=>'unable to add your like' ,'like_value'=>'0'): array('status' => TRUE ,'msg'=>'like added sucessfully','like_value'=>'1') ;
        }else{
            $like = ($result['user_like']==0) ? '1' : '0'; 
            $this->db->set(array('user_like'=>$like,'modified_date'=>date('Y-m-d  H:i:s a') ) );
            $this->db->where(array('blog_id'=> $blog_id,'user_id'=>$user_id,'comment_id'=>$comment_id));
            $this->db->update('comment_like');
            // echo $this->db->last_query();
            return ($this->db->affected_rows() != 1) ? array('status'=>FALSE,'msg'=>'unable to update your like','like_value'=>'0' ) : array('status' => TRUE ,'msg'=>'like updated sucessfully','like_value'=>$like);
        }
    }

    function get_comment_replies($comment_id,$user_id){
        $this->db->select("bcr.id,bcr.reply,u.id as user_id, u.name, u.email, u.image,
        (CASE when DATEDIFF(bcr.created_date, NOW()) = 0 then 'Today' else concat(DATEDIFF(bcr.created_date, NOW()),' ','Days ago') END)as coment_rply_date,
         ( SELECT (CASE WHEN user_like = '1' THEN 1 ELSE 0 END) FROM comment_like WHERE  user_id = '$user_id'  AND comment_reply_id = bcr.id ) as user_like,
        cl.user_like as comment_like");
        $this->db->from('blog_comments_reply bcr');
        $this->db->join('users u','bcr.user_id = u.id', 'left');
        $this->db->join('comment_like cl','bcr.id = cl.comment_reply_id', 'left');
        $this->db->where(array('bcr.comment_id'=>$comment_id,'bcr.is_active'=>'1'));
         $this->db->group_by('bcr.id');
        $this->db->order_by('bcr.id','desc');
                //  $this->db->get()->result_array();
        //  echo $this->db->last_query();
        // die;
        return $this->db->get()->result_array();
                // (CASE WHEN cl.comment_reply_id = bcr.id AND cl.user_id = '$user_id' AND cl.user_like = '1' THEN 1 ELSE 0 END) as user_like,
    }

    function add_reply($user_id, $comment_id, $blog_id, $reply){
        $data = array(
            'user_id'=>$user_id,
            'voice_id'=>$blog_id,
            'comment_id'=>$comment_id,
            'reply'=>$reply
        );
        $this->db->insert('blog_comments_reply',$data);
        return $this->db->affected_rows() == 1 ? TRUE : FALSE; 
    }

    function get_all_blog($limit=''){
        $this->db->select("id,name,category_id,title,description,image,DATE_FORMAT(modified_date, '%e %b %Y') as created_date");
        $this->db->from('blogs');
        $this->db->where(array('is_active'=>'1','is_approve'=>'1'));
        $this->db->order_by('modified_date','desc');
        if($limit !=''){
            $this->db->limit($limit,'0');
        }
        $result = $this->db->get()->result_array();
        return $result;
    }

    function add_user_blog($user_id,$title,$image,$description){
        $data=array(
            'user_id'=>$user_id,
            'title'=>$title,
            'image'=>$image,
            'description'=>$description,
            'created_date'=> date('Y-m-d H:i:s')
        );
        $this->db->insert('blogs',$data);
        return ($this->db->affected_rows() == 1) ? TRUE : FALSE;
        
    }


    function update_comment_reply_like($blog_id,$user_id,$comment_reply_id){
        $this->db->select('id,blog_id,comment_reply_id,user_id,user_like');
        $this->db->from('comment_like');
        $this->db->where(array('blog_id'=>$blog_id,'user_id'=>$user_id,'comment_reply_id'=>$comment_reply_id));
        $result = $this->db->get()->row_array();
        if(empty($result)){
            $data = array('blog_id'=>$blog_id,'comment_reply_id'=>$comment_reply_id,'user_id'=>$user_id,'user_like'=>'1');
            $this->db->insert('comment_like',$data);
            return ($this->db->affected_rows() != 1) ? array('status'=>FALSE,'msg'=>'unable to add your like' ,'like_value'=>'0'): array('status' => TRUE ,'msg'=>'like added sucessfully','like_value'=>'1') ;
        }else{
            $like = ($result['user_like']==0) ? '1' : '0'; 
            $this->db->set(array('user_like'=>$like,'modified_date'=>date('Y-m-d  H:i:s a') ) );
            $this->db->where(array('blog_id'=> $blog_id,'user_id'=>$user_id,'comment_reply_id'=>$comment_reply_id));
            $this->db->update('comment_like');
            // echo $this->db->last_query();
            return ($this->db->affected_rows() != 1) ? array('status'=>FALSE,'msg'=>'unable to update your like','like_value'=>'0' ) : array('status' => TRUE ,'msg'=>'like updated sucessfully','like_value'=>$like);
        }
    }

    public function get_blog_by_topic_list($limit="",$topic_id="",$offset=0) {
        /*$this->db->select("id,name,category_id,title,description,image,DATE_FORMAT(modified_date, '%e %b %Y') as created_date");
        $this->db-> from( 'blogs');        
        $this->db->where('is_active','1');
        $this->db->where('is_approve','1');
        
        if(!empty($topic_id)){
            $this->db->where("topic_id REGEXP CONCAT('(^|,)(', REPLACE('$topic_id', ',', '|'), ')(,|$)')");
            $result='result_array';
        }else{
            $result='result_array';
        }
              
        $this->db->order_by('modified_date','desc');
        // echo $result;
        if(!empty($limit)){
            $this->db->limit($limit,$offset);
        }
        $res=$this->db->get()->$result();
        // echo $this->db->last_query();die;
        return $res; */

        $this->db->select("id,name,category_id,title,description,image,DATE_FORMAT(modified_date, '%e %b %Y') as created_date");
        $this->db->from('blogs');
        $this->db->where(array('is_active'=>'1','is_approve'=>'1'));
        if($limit !=''){
            $this->db->limit($limit,$offset);
        }
        if($topic_id !=''){
            $this->db->order_by('FIELD (topic_id,'.  empty($topic_id) ? '': $topic_id .') DESC');
        } else {
            $this->db->order_by('id', 'DESC');
        }

        $result = $this->db->get()->result_array();
        return $result;
        
    }
}
