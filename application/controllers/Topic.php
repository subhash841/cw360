<?php

class Topic extends CI_Controller {

    function __construct() {
        parent::__construct();
        $sessiondata = $this->session->userdata('data');
        if (!empty($sessiondata)) {
            $this->user_id = $sessiondata['uid'];
        } else {
            $this->user_id = 0;
        }
        $this->load->model('Topic_model');
    }

    function index($id = "") {
        $all_topics = $this->Topic_model->get_all_topics();
//        $data['all_topic_count'] = $this->Topic_model->get_all_topics_count();
        
        if (!empty($id)) {
            $category_topics = $this->Topic_model->get_topics($id);
            $category_name = $this->Topic_model->get_category_name($id);
        }

        $data['category'] = array('all');
        $data['topics'] = array('all' => $all_topics);
        $data['main_category'] = $id;
        if (empty(!$id)) {
            array_push($data['category'], $category_name['name']);
            $data['topics'][$category_name['name']] = $category_topics;
        }


        $header_data['uid'] = $this->user_id;
        $this->load->view("header", $header_data);
        $this->load->view('topic_list', $data);
        $this->load->view('footer');
    }

    function getTopics() {  

        $offset = $this->input->post('offset', TRUE);
        $category = $this->input->post('category', TRUE);

        if (!empty($offset) && !empty($category)) {
            $data['topics'] = $this->Topic_model->get_all_topics_by_category($offset, $category);
        } else if (!empty($offset)) {
            $data['topics'] = $this->Topic_model->get_all_topics($offset);
        } else {
            $data['topics'] = "";
        }
        echo json_encode($data['topics']);
    }

}
