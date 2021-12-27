<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

$config['profile'] = array(  
    array(
        'field' => 'name',
        'label' => 'Name',
        'rules' => 'trim|required|regex_match[/^([^0-9]*)$/]'
    ),array(
        'field' => 'gender',
        'label' => 'gender',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Please select gender"),
    ),array(
        'field' => 'dob',
        'label' => 'Date of Birth',
        'rules' => 'trim|required',
        'errors'=> array('required'=>"Please select Date of Birth"),
    ),array(
        'field' => 'phone',
        'label' => 'Mobile no.',
        'rules' => 'trim|required|is_natural|regex_match[/^(\+\d{1,3}[- ]?)?\d{10}$/]',
    ),array(
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