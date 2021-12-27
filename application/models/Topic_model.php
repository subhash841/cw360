<?php

class Topic_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_topics($id = "") {
        $limit = get_topic_limt();
        $this->db->select('id, topic, image');
        $this->db->where_in('category', $id);
        $this->db->where('is_active', '1');
        $this->db->from('topics');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    function get_all_topics($offset = 0) {
        $limit = get_topic_limt();
        $this->db->select('id, topic, image');
        $this->db->from('topics');
        $this->db->where('is_active', '1');
        $this->db->order_by("trending_created_date desc");
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
        //echo $a= $this->db->last_query();
    }

    function get_all_topics_by_category($offset = "", $category = "") {
        $limit = get_topic_limt();
        $this->db->select('id, topic, image');
        $this->db->from('topics');
        $this->db->where(array('category' => $category, 'is_active' => '1'));
        $this->db->limit($limit, $offset);

        return $this->db->get()->result_array();
    }

    function get_category_name($id) {
//        $this->db->select('name');
//        $this->db->where('id', $id);
//        $this->db->from('blog_category');
//        return $this->db->get()->row_array();
        $this->db->select('t.topic as name');
        $this->db->from('topics t');
        $this->db->join('blog_category b', 't.category=b.id', 'LEFT');
        $this->db->where(array('t.id' => $id, 'b.is_active' => 1,'t.is_active' => 1));
        return $this->db->get()->row_array();
    }

//
//    function get_all_topics_count() {
//        $this->db->select('count("id")');
//        $this->db->from('topics');
//        $this->db->where('is_active', '1');
//        $result = $this->db->get()->row_array();
//        return reset($result);
//    }
}
