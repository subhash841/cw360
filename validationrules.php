<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

$config['profile'] = array(  
    array(
        'field' => 'name',
        'label' => 'Name',
        'rules' => 'trim|required|alpha_numeric_spaces|trim'
    ), 
    array(
        'field' => 'gender',
        'label' => 'gender',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Please select gender"),
    ),
    array(
        'field' => 'dob',
        'label' => 'Date of Birth',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Please select Date of Birth"),
    ),
    array(
        'field' => 'phone',
        'label' => 'Mobile no.',
        'rules' => 'trim|required|is_natural',
    ),

    array(
        'field' => 'email',
        'label' => 'Email Id',
        'rules' => 'trim|required|valid_email'
    ),

);

$config['mobile'] = array(  
    array(
        'field' => 'phone',
        'label' => 'mobile no.',
        'rules' => 'trim|required|is_natural|exact_length[10]'
    )
);

$config['otp'] = array(  
    array(
        'field' => 'otp_number',
        'label' => 'OTP',
        'rules' => 'trim|required'
    )
);


?>