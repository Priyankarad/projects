<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Custom Helper
* Author: Priyanka Jain
*/
/**
* [To print array]
* @param array $arr
*/
if(!function_exists('pr')){
    function pr($arr){
        echo '<pre>'; 
        print_r($arr);
        echo '</pre>';
        die;
    }
}

/**
* [To print last query]
*/
if ( ! function_exists('lq')) {
    function lq()
    {
        $CI = & get_instance();
        echo $CI->db->last_query();
        die;
    }
}

/**
* [To upload all files]
* @param string $subfolder
* @param string $ext
* @param int $size
* @param int $width
* @param int $height
* @param string $filename
*/
if ( ! function_exists('fileUploading')) {
    function fileUploading($filename,$subfolder,$ext,$size="",$width="",$height=""){
        $filenames1=$_FILES["$filename"]['name'];
        $filenames2=explode('.',$filenames1);
        $fileext=end($filenames2);
        $newfilename=time().'_'.rand(99999,9999999999).'_'.rand(10000,99999).'.'.$fileext;
        $CI = & get_instance();
        $directory_path = 'uploads/'.$subfolder;
        $config['upload_path']   = $directory_path.'/';
        $config['allowed_types'] = $ext; 
        $config['file_name'] = $newfilename;
        if($size){
            $config['max_size']   = 100; 
        }
        if($width){
            $config['max_width']  = 1024; 
        }
        if($height){
            $config['max_height'] = 768;  
        }
        $CI->load->library('upload', $config);
        if (!$CI->upload->do_upload($filename)) { 
            $error = array('error' => strip_tags($CI->upload->display_errors())); 
            return $error;
        }
        else {
            $data = array('upload_data' => $CI->upload->data()); 
            $config2['image_lib'] = 'gd2';
            $config2['quality'] = 60; 
            $config2['source_image'] = $directory_path.$newfilename;
            $config2['maintain_ratio'] = TRUE;
            $CI->load->library('image_lib',$config2);
            $CI->image_lib->resize();
            return $data;
        } 
    }
}

/**
* [To encode string]
* @param string $str
*/
if ( ! function_exists('encoding')) {
    function encoding($str){
        $one = serialize($str);
        $two = @gzcompress($one,9);
        $three = addslashes($two);
        $four = base64_encode($three);
        $five = strtr($four, '+/=', '-_.');
        return $five;
    }
}

/**
* [To decode string]
* @param string $str
*/
if ( ! function_exists('decoding')) {
    function decoding($str){
        $one = strtr($str, '-_.', '+/=');
        $two = base64_decode($one);
        $three = stripslashes($two);
        $four = @gzuncompress($three);
        if ($four == '') {
            return "z1"; 
        } else {
            $five = unserialize($four);
            return $five;
        }
    }
}

/**
* [To get services list]
* @param string $str
*/
if ( ! function_exists('getServicesList')) {
    function getServicesList($id,$type){
        $CI = & get_instance();
        if($type == 'school'){
            $table = COURSE;
            $column = 'course_id';
            $dataFetch = "course.*";
            $where = array('school_course.school_id'=>$id);
        }else{
            $table = SCHOOL;
            $column = 'school_id';
            $dataFetch = "school.*";
            $where = array('school_course.course_id'=>$id);
        }
        $getServicesList = $CI->common_model->GetJoinRecord($table,'id',SCHOOL_COURSE,$column,$dataFetch,$where);
        if(!empty($getServicesList['result'])){
            return $getServicesList['result'];
        }else{
            return false;
        }
    }
}