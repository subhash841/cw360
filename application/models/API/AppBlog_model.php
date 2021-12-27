<?php

class AppBlog_model extends CI_Model{
        

    function __construct() {
        parent::__construct();

    }


     public function get_blog_detail($id) {
        $this->db->select("`id`, IFNULL(`user_id`,'')as user_id, IFNULL(`name`,'')as name, IFNULL(`topic_id`,'')as topic_id, IFNULL(`category_id`,'')as category_id, `sub_category_id`, IFNULL(`title`,'')as title , IFNULL(`description`,'')as description , IFNULL(`image`, '')as image, IFNULL(`blog_date`,'')as blog_date, `total_likes`, `total_comments`, `total_views`, IFNULL(`link`, '') as link, `type`, IFNULL(`meta_keywords`,'')as meta_keywords , IFNULL(`meta_description`,'')as meta_description, `is_approve`, `is_active`, IFNULL(`blog_order`,'')as blog_order, (case when modified_date is null then created_date else modified_date END) as `created_date`, IFNULL(`modified_date`,'')as modified_date");
        $this->db->from('blogs');
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        foreach($result as $key => $value){
            $result[$key]['description'] = special_characters_blog($value['description']);
        }
        /*echo'<pre>';print_r($result);exit();*/
        return reset($result);
    }

    function get_user_like($blog_id,$user_id){
        $this->db->select('is_like');
        $this->db->from('blog_likes');
        $this->db->where(array('blog_id'=>$blog_id,'user_id'=>$user_id,'is_like'=>1));
        $result = $this->db->get()->result_array();
        return reset($result);
    }


    /*function get_comments($blog_id,$user_id){
        $this->db->select("b.id as comment_id,b.user_id,b.comment, b.total_replies, u.id, u.name, u.email, ifnull(u.image,'') as image,
        ( SELECT (CASE WHEN user_like = '1' THEN 1 ELSE 0 END) FROM comment_like WHERE  user_id = '$user_id'  AND comment_id = b.id ) as is_user_like,
        (CASE when DATEDIFF(b.created_date,NOW()) = 0 then 'Today' else concat(DATEDIFF(NOW(),b.created_date,' ','Days ago') END)as created_date, 
        cl.user_like as comment_like");
        $this->db->from('blog_comments b');
        $this->db->join('users u', ' b.user_id = u.id ', 'left');
        $this->db->join('comment_like cl', 'cl.comment_id = b.id', 'left');
        $this->db->where(array('voice_id'=>$blog_id,'b.is_active'=>'1'));
        $this->db->group_by('b.id');
        $this->db->order_by('b.id','desc');
        return $this->db->get()->result_array();
    }*/

    function get_comments($blog_id,$user_id){
        $this->db->select("b.id as comment_id,b.user_id,b.comment, b.total_replies, u.id, u.name, u.email, ifnull(u.image,'') as image,
        ( SELECT (CASE WHEN user_like = '1' THEN 1 ELSE 0 END) FROM comment_like WHERE  user_id = '$user_id'  AND comment_id = b.id ) as is_user_like,
        (CASE when DATEDIFF(b.created_date, NOW()) = 0 then 'Today' else concat(DATEDIFF(NOW(),b.created_date),' ','Days ago') END)as created_date,
        cl.user_like as comment_like");
        $this->db->from('blog_comments b');
        $this->db->join('users u', ' b.user_id = u.id ', 'left');
        $this->db->join('comment_like cl', 'cl.comment_id = b.id', 'left');
        $this->db->where(array('voice_id'=>$blog_id,'b.is_active'=>'1'));
        $this->db->group_by('b.id');
        $this->db->order_by('b.id','desc');
        $result=$this->db->get()->result_array();
          foreach ($result as $key => $value) {
            if($value['is_user_like']==""){
                $result[$key]['is_user_like'] = "0";
            }
        }
        return $result;
    }

    function update_view_count($id){
        $this->db->set('total_views', 'total_views+1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('blogs');
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
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


    function add_blog_comment($blog_id,$user_id,$comment){
        $this->db->insert('blog_comments',array('user_id'=>$user_id,'voice_id'=>$blog_id,'comment'=>$comment));
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function get_comment($comment_id){
        $this->db->select('b.id,b.comment,u.id as user_id, u.name,u.email,u.image');
        $this->db->from('blog_comments b');
        $this->db->join('users u', ' b.user_id = u.id ', 'left');
        $this->db->where(array('b.id'=>$comment_id,'b.is_active'=>'1'));
        return $this->db->get()->row_array();
    }

    function update_comment_like($blog_id,$user_id,$comment_id){
        $this->db->select('id,blog_id,comment_id,user_id,user_like');
        $this->db->from('comment_like');
        $this->db->where(array('blog_id'=>$blog_id,'user_id'=>$user_id,'comment_id'=>$comment_id));
        $result = $this->db->get()->row_array();
        if(empty($result)){

            $data = array('blog_id'=>$blog_id,'comment_id'=>$comment_id,'user_id'=>$user_id,'user_like'=>'1');
            $this->db->insert('comment_like',$data);
            return ($this->db->affected_rows() != 1) ? array('status'=>FALSE,'msg'=>'unable to add your like' ,'like_value'=>'0'): array('status' => TRUE ,'msg'=>'like added sucessfully','like_value'=>'1') ;
        }else{

            $like = ($result['user_like']==0) ? '1' : '0'; 
            $this->db->set(array('user_like'=>$like,'modified_date'=>date('Y-m-d  H:i:s a') ) );
            $this->db->where(array('blog_id'=> $blog_id,'user_id'=>$user_id,'comment_id'=>$comment_id));
            $this->db->update('comment_like');
            return ($this->db->affected_rows() != 1) ? array('status'=>FALSE,'msg'=>'unable to update your like','like_value'=>'0' ) : array('status' => TRUE ,'msg'=>'like updated sucessfully','like_value'=>$like);
        }
    }


     function get_comment_replies($comment_id,$user_id){
        $this->db->select("bcr.id,bcr.reply,u.id as user_id, u.name, u.email, u.image,
        (CASE when DATEDIFF(bcr.created_date,NOW()) = 0 then 'Today' else concat(DATEDIFF(NOW(),bcr.created_date),' ','Days ago') END)as coment_rply_date,
        (SELECT (CASE WHEN user_like = '1' THEN 1 ELSE 0 END) FROM comment_like WHERE  user_id = '$user_id'  AND comment_reply_id = bcr.id ) as user_like,
        cl.user_like as comment_like");
        $this->db->from('blog_comments_reply bcr');
        $this->db->join('users u','bcr.user_id = u.id', 'left');
        $this->db->join('comment_like cl','bcr.id = cl.comment_reply_id', 'left');
        $this->db->where(array('bcr.comment_id'=>$comment_id,'bcr.is_active'=>'1'));
        $this->db->group_by('bcr.id');
        $this->db->order_by('bcr.id','desc');
        $result = $this->db->get()->result_array();

        foreach ($result as $key => $value) {
            if($value['user_like']==""){
                $result[$key]['user_like'] = "0";
            }
        }
        return $result;
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
	       
	}
?>