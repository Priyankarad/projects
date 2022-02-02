<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*to get current user id*/
if (!function_exists('get_current_user_id')) {
    function get_current_user_id() {
        $ci = & get_instance();
        if (isset($ci->session->userdata['sessionData']['user_id'])){
			$user_id=$ci->session->userdata['sessionData']['user_id'];
			$userDetails = $ci->common_model->getsingle(PROPERTY_USERS,array('id'=>$user_id));
            return $userDetails->id;
        } else {
            return false;
        }
    }
}

/*user session set or net*/
if (!function_exists('loginCheck')) {
    function loginCheck($user=false){
        $ci = & get_instance();
        if(isset($ci->session->userdata['sessionData']['user_id'])){
            return true;
        }else{
            if($user){
                redirect(base_url().'?popup=login');
            }else{
                return false;
            }
        }
    }
}

/*admin session set or net*/
if (!function_exists('adminLoginCheck')) {
    function adminLoginCheck(){
        $CI = & get_instance();
        if($CI->session->userdata('admin_id')){
            return true;
        }else{
			// return $ci->session->userdata('admin_id');
          redirect(base_url('siteadmin'));
        }
    }
}
/*to get current user details*/
if (!function_exists('get_current_user_details')) {
    function get_current_user_details() {
        $ci = & get_instance();
        $ci->load->model('User_model');
        if (isset($ci->session->userdata['sessionData']['user_id'])) {
            $user_id = $ci->session->userdata['sessionData']['user_id'];
            return $ci->User_model->get_userdata($user_id);
        } else {
            return false;
        }
    }
}



/*to upload image*/
if (!function_exists('uploadImage')) {
    function uploadImage($type,$folder) {
        if(isset($_FILES[$type]['name']) && !empty($_FILES[$type]['name'])){
            $ci = & get_instance();
            $newImage = '';
            $fileName = basename($_FILES[$type]["name"]);
            $fileTmp = $_FILES[$type]["tmp_name"];
            $fileType = $_FILES[$type]["type"];
            $fileSize = $_FILES[$type]["size"];
            $fileExt = substr($fileName, strrpos($fileName, ".") + 1);
            $largeImageLoc = 'uploads/'.$folder.'/'.time().".".$fileExt;
            $thumbImageLoc = 'uploads/'.$folder.'/thumb/'.time().".".$fileExt;
            if(!empty($fileName)){
                if(move_uploaded_file($fileTmp, $largeImageLoc)){
                    $Orientation = 0;
                    $imgdata=@exif_read_data(FCPATH.$largeImageLoc,"FILE,COMPUTED,ANY_TAG,IFD0,THUMBNAIL,COMMENT,EXIF,Orientation", true);
                    if(isset($imgdata['IFD0']['Orientation'])){
                        $Orientation = $imgdata['IFD0']['Orientation'];
                    }
                    chmod ($largeImageLoc, 0777);
                    $arr_image_details = getimagesize($largeImageLoc); 
                    $width = $arr_image_details[0];
                    $height = $arr_image_details[1];
                    $MaxWe = 100;
                    $MaxHe = 150;
                    $percent = 100;
                    if($width > $MaxWe) $percent = floor(($MaxWe * 100) / $width);

                    if(floor(($height * $percent)/100)>$MaxHe)  
                        $percent = (($MaxHe * 100) / $height);

                    if($width > $height) {
                        $newWidth=$MaxWe;
                        $newHeight=round(($height*$percent)/100);
                    }else{
                        $newWidth=round(($width*$percent)/100);
                        $newHeight=$MaxHe;
                    }

                    $new_image = imagecreatetruecolor($newWidth, $newHeight);
                    $source = '';
                    switch($fileType) {
                        case "image/gif":
                        $source = imagecreatefromgif($largeImageLoc); 
                        break;
                        case "image/pjpeg":
                        case "image/jpeg":
                        case "image/jpg":
                        $source = imagecreatefromjpeg($largeImageLoc); 
                        break;
                        case "image/png":
                        case "image/x-png":
                        $source = imagecreatefrompng($largeImageLoc); 
                        break;
                    }

                    imagecopyresized($new_image, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                    switch($fileType) {
                        case "image/gif":
                        imagegif($new_image,$thumbImageLoc); 
                        break;
                        case "image/pjpeg":
                        case "image/jpeg":
                        case "image/jpg":
                        imagejpeg($new_image,$thumbImageLoc,90); 
                        break;
                        case "image/png":
                        case "image/x-png":
                        imagepng($new_image,$thumbImageLoc);  
                        break;
                    }
                    imagedestroy($new_image);
                    $config['image_library'] = 'gd2';
                    $config['master_dim'] = 'auto';
                    $config['maintain_ratio'] = FALSE;
                    $ci->load->library('image_lib',$config); 
                    if (!$ci->image_lib->resize()){  
                        echo "error";
                    }else{
                        $ci->image_lib->clear();
                        $config=array();
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = FCPATH.$thumbImageLoc;
                        if($Orientation!=0){
                            switch($Orientation) {
                                case 3:
                                $config['rotation_angle']='180';
                                break;
                                case 6:
                                $config['rotation_angle']='270';
                                break;
                                case 8:
                                $config['rotation_angle']='90';
                                break;
                            }
                            $ci->image_lib->initialize($config); 
                            $ci->image_lib->rotate();
                        }
                    }
                    return array('original'=>$largeImageLoc,'thumb'=>$thumbImageLoc);   
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }
}