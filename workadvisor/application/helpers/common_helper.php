<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function generate_password($string) {
    return password_hash($string, PASSWORD_DEFAULT);
}

function password_check($password,$hash) {
    return password_verify($password, $hash) ?  "verified" : "invalid";
}

if (!function_exists('get_current_user_id')) {
    function get_current_user_id() {
        $ci = & get_instance();
        if ($ci->session->userdata('loggedIn')) {
			$email=$ci->session->userdata['userData']['email'];
			$userDetails = $ci->common_model->getsingle(USERS,array('email'=>$email));
            return $userDetails->id;
        } else {
            return false;
        }
    }
}

if (!function_exists('get_current_user_details')) {
    function get_current_user_details() {
        $ci = & get_instance();
        $ci->load->model('User_model');
        if ($ci->session->userdata('id')) {
            $user_id = $ci->session->userdata('id');
            return $ci->User_model->get_userdata($user_id);
        } else {
            return false;
        }
    }
}

function get_where($table = null, $where = array(),$type = null) {
    $ci = & get_instance();
    if($type=='row')
    {
        $query = $ci->db->get_where($table, $where);
         if ($query->num_rows() > 0) {
                       return $query->row();
                   } else {
                   return false;
                   }     
    }
    else
    {
       $query = $ci->db->get_where($table, $where);
       return $query->result_array();
    }
}

function update_data($table = null, $data = array(), $where = array()) {
    $ci = & get_instance();
    $ci->db->update($table, $data, $where);
	//return $ci->db->last_query();
    if ($ci->db->affected_rows() > 0)
        return true;
    else
        return false;
}