<?php

/**
 * 
 */
class TnC extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
            $this->load->view('tnc');
    }
    function app() {
        $data['type']="app";
        $this->load->view('tnc',$data);
}

    function tnc_agree() {
        $session_querystring = $this->session->userdata('querystring');

        // print_r($_SESSION);
        $uid = $_SESSION['data']['uid'];

        $update_tnc = array(
            "tnc_agree" => "1"
        );
        $this->db->where("id = '$uid'");
        $this->db->update("users", $update_tnc);

  
            $_SESSION['data']['tnc_agree'] = "1";
            if ($session_querystring['section'] == "home") {
                redirect('home');
            }else if ( @$session_querystring[ 'section' ] == "predictiondetail" && isset( $session_querystring[ 'pid' ] ) ) {
                            redirect( "predictions/details/" . $session_querystring[ 'pid' ] );
                        }else {
                redirect('home');
            }        
    }
}