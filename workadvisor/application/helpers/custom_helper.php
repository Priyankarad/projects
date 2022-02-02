<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Custom Helper
* Author: Pixlrit
* version: 1.0
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

if ( ! function_exists('array_multi_subsort')){
    function array_multi_subsort($array, $subkey)
    { 
        $b = array(); $c = array();
        foreach ($array as $k => $v)
        {
			
            $b[$k] = strtolower($v->$subkey);
        }
        asort($b);
        foreach ($b as $key => $val)
        {
            $c[] = $array[$key];
        }
        return array_reverse($c);
    }
}
if ( ! function_exists('arraymultisubsort')){
    function arraymultisubsort($array, $subkey)
    { 
        $b = array(); $c = array();
        foreach ($array as $k => $v)
        {
			
            $b[$k] = strtolower($v[$subkey]);
        }
        asort($b);
        foreach ($b as $key => $val)
        {
            $c[] = $array[$key];
        }
        return array_reverse($c);
    }
}

/**
* [To decode string]
* @param string $str
*/
if ( ! function_exists('ci_denc')){
    function ci_denc($str){
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
* [To encode string]
* @param string $str
*/
if(!function_exists('ci_enc')) {
    function ci_enc($str){
        $one = serialize($str);
        $two = @gzcompress($one,9);
        $three = addslashes($two);
        $four = base64_encode($three);
        $five = strtr($four, '+/=', '-_.');
        return $five;
    }
}

/**
* [To language translation]
* @param string $key
*/
if(!function_exists('lang')){
    function lang($key)
    { 
        $CI = & get_instance();
        return $CI->lang->line($key);
    }
}

/**
* [To language translation]
* @param string $key
*/
if(!function_exists('getLikeStatus')){
    function getLikeStatus($userID,$postID)
    { 
        $CI = & get_instance();
        $singleRecord = $CI->common_model->getsingle(LIKE,array('liked_by'=>$userID,'post_id'=>$postID));
        $likeCount = $CI->common_model->getAllwhere(LIKE,array('post_id'=>$postID,'status'=>1));
        return array($singleRecord,$likeCount['total_count']);
    }
}

/**
* [To Api Language Translation]
*/
if ( ! function_exists('lang_api')) {
    function lang_api($key,$locale) 
    {
        $CI = & get_instance();
        $CI->lang->load('admin_'.$locale.'_lang', $locale);
        $lang_str = ($CI->lang->line($key)) ? $CI->lang->line($key) : '';
        return $lang_str;
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
* [To get database error message]
*/
if ( ! function_exists('db_err_msg')) {
    function db_err_msg()
    {
        $CI = & get_instance();
        $error = $CI->db->error();
        if(isset($error['message']) && !empty($error['message'])){
            return 'Database error - '.$error['message'];
        }else{
            return FALSE;
        }
    }
}

/**
* [To parse html]
* @param string $str
*/
if (!function_exists('parseHTML')) {
    function parseHTML($str){
        $str = str_replace('src="//', 'src="https://', $str);
        return $str;
    }
}

/**
* [To create directory]
* @param string $folder_path
*/
if (!function_exists('make_directory')) {
    function make_directory($folder_path) {
        if (!file_exists($folder_path)) {
            mkdir($folder_path, 0777, true);
        }
    }
}


/**
* [To get data row count]
* @param string $table
* @param array $where
*/
if ( ! function_exists('getAllCount')) {
    function getAllCount($table,$where="")
    {
        $CI = & get_instance();
        if(!empty($where)){
            $CI->db->where($where);
        }
        $q = $CI->db->count_all_results($table);
        return addZero($q);
    }
}

/**
* [To get previous dates]
* @param int $no_of_days
*/
if ( ! function_exists('get_previous_dates')) {
    function get_previous_dates($no_of_days)
    {
        $dates_arr = array(); 
        $timestamp = time();
        for ($i = 0 ; $i < (int) $no_of_days ; $i++) {
            $dates_arr[] = date('Y-m-d', $timestamp);
            $timestamp -= 24 * 3600;
        }
        return $dates_arr;
    }
}

/**
* [To get dates difference]
* @param date $from
* @param date $to
*/
if ( ! function_exists('diff_in_weeks_and_days')) {
    function diff_in_weeks_and_days($from, $to) 
    {
        $day   = 24 * 3600;
        $from  = strtotime($from);
        $to    = strtotime($to);

        $diff  = abs($to - $from);
        $weeks = floor($diff / $day / 7);
        $days  = $diff / $day - $weeks * 7;
        $out   = array();
        $out['week'] = ($weeks) ? $weeks : 0;
        $out['days'] = ($days) ? $days : 0;
        return $out;
    }
}


/**
* [To calculate dates]
* @param date $selected_date
* @param string $type
*/
if ( ! function_exists('calculate_date')) {
    function calculate_date($selected_date,$type)
    {
        if(in_array($type, array('MENSURATION','DELIVERY'))){
            if(empty($selected_date)) return '';
            $current_week_days = '';
            $current_date = date('Y-m-d');
            if($type == 'MENSURATION'){
                $current_week_days = diff_in_weeks_and_days($selected_date,date('Y-m-d'));
            }else{
                $final_caluclated_date = date('Y-m-d', strtotime($selected_date." -".NO_OF_WEEKS." week"));
                $current_week_days = diff_in_weeks_and_days($final_caluclated_date,date('Y-m-d'));
            }
            return $current_week_days;
        }else{
            return '';
        }
    }
}


/**
* [To sort multi-dimensional array]
* @param array $response
* @param string $column
* @param string $type
*/
if ( ! function_exists('sortarr')) {
    function sortarr($response,$column,$type)
    {
        $arr =array();
        foreach ($response as $r) {
$arr[] = $r->$column; // In Object
}
if($type == 'ASC'){
    array_multisort($arr,SORT_ASC,$response);
}else{
    array_multisort($arr,SORT_DESC,$response);
}
return $response;
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
* [To export csv file from array]
* @param string $fileName
* @param array $assocDataArray
* @param array $headingArr
*/
if ( ! function_exists('exportCSV')) {
    function exportCSV($fileName,$assocDataArray,$headingArr)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$fileName);
        $output = fopen('php://output', 'w');
        fputcsv($output, $headingArr);
        foreach ($assocDataArray as $key => $value) {
            fputcsv($output, $value);
        }
        exit;
    }
}

/**
* extract_value
* @return string
*/
if (!function_exists('extract_value'))
{

    function extract_value($array, $key, $default = "")
    {
        $CI = & get_instance();
        if(isset($array[$key])){
            return @trim(strip_tags($array[$key]));
        }else{
            return @trim($default);
        }
    }

}

/**
* [To check number is digit or not]
* @param int $element
*/
if ( ! function_exists('is_digits')) {
function is_digits($element){ // for check numeric no without decimal
    return !preg_match ("/[^0-9]/", $element);
}
}

/**
* [To get all months list]
*/
if ( ! function_exists('getMonths')) {
    function getMonths(){
        $monthArr = array('January','February','March','April','May','June','July','August','September','October','November','December');
        return $monthArr ;
    }
}

if ( ! function_exists('uploadImageData')){
    function uploadImageData($filename,$subfolder,$ext,$size="",$width="",$height=""){
        $UPLOAD_DIR='uploads/'.$subfolder;
        $img = str_replace('data:image/'.$ext.';base64,', '', $filename);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $UPLOAD_DIR .'/'. time().'_'.rand(99999,9999999999).'_'.rand(10000,99999) . '.'.$ext;
        $success = file_put_contents($file, $data);
        $return=array();
        if($success){
            $return=array('status'=>'success','imagename'=>$file);
        }else{
            $return=array('status'=>'Failed','imagename'=>'');
        }
        return $return;

    }
}


if ( ! function_exists('uploadImageData_')){
    function uploadImageData_($filename,$subfolder,$ext,$size="",$width="",$height=""){$CI = & get_instance();
        $UPLOAD_DIR='uploads/'.$subfolder;
        $img = str_replace('data:image/'.$ext.';base64,', '', $filename);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $imgName = time().'_'.rand(99999,9999999999).'_'.rand(10000,99999) . '.'.$ext;
        $file = $UPLOAD_DIR.'/'.$imgName; 
        $success = imagecreatefromstring(file_put_contents($file, $data));
        $imgdata=@exif_read_data($img, 'IFD0');
        list($width, $height) = getimagesize($file);
        if ($width >= $height){
            $config['width'] = 800;
        }
        else{
            $config['height'] = 5000;
        }
        $config['master_dim'] = 'auto';
        $CI->load->library('image_lib',$config); 
        if (!$CI->image_lib->resize()){  
// echo "error";
        }else{

            $CI->image_lib->clear();
            $config=array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $file;
            switch($imgdata['Orientation']) {
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
            $CI->image_lib->initialize($config); 
            $CI->image_lib->rotate();
        }

        $return=array();
        if($success){
            $return=array('status'=>'success','imagename'=>$file);
        }else{
            $return=array('status'=>'Failed','imagename'=>'');
        }
        return $return;

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
//echo $newfilename;
//die();
        $CI = & get_instance();
        /* To create directory */
        $directory_path = 'uploads/'.$subfolder; 
        make_directory($directory_path);

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
* [To check autorized user]
* @param string $return_uri
*/
if ( ! function_exists('is_logged_in')) {
    function is_logged_in($return_uri = '') {
        $ci =&get_instance();
        $user_login = $ci->session->userdata('user_id');
        if(!isset($user_login) || $user_login != true) {
            if($return_uri) {
                $ci->session->set_flashdata('blog_token',time());
                redirect('?return_uri='.urlencode(base_url().$return_uri));  
            } else {
                $ci->session->set_flashdata('blog_token',time());
                redirect("/");  
            }   
        }   
    }
}

/**
* [To excecute CURL]
* @param string $Url
* @param array $jsondata
* @param array $post
* @param array $headerData
*/
if (!function_exists('ExecuteCurl')){
    function ExecuteCurl($url, $jsondata = '', $post = '', $headerData = []){
        $ch = curl_init();
        $headers = array('Accept: application/json', 'Content-Type: application/json');
        if (!empty($headerData) && is_array($headerData)){
            foreach ($headerData as $key => $value)
            {
                $headers[$key] = $value;
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($jsondata != '')
        {
            curl_setopt($ch, CURLOPT_POST, count($jsondata));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        if ($post != '')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

/**
* [To send mail]
* @param string $from
* @param string $to
* @param string $subject
* @param string $message
*/
if ( ! function_exists('send_mail')) {
    function send_mail($message,$subject,$to_email,$from_email="",$attach="")
    {
        $ci = &get_instance();
        $config['mailtype'] = 'html';
        $ci->email->initialize($config);
        if(!empty($from_email)){
            $ci->email->from(FROM_EMAIL,SITE_NAME);
        }else{
            $ci->email->from(FROM_EMAIL,SITE_NAME);
        }
        $ci->email->to($to_email);
        $ci->email->subject($subject);
        $ci->email->message($message);
        if(!empty($attach))
        {
            $ci->email->attach($attach);
        }
        if($ci->email->send()) {  

            return true;
        } else {
            return false;
        }
    }
}


if ( ! function_exists('crypto_rand_secure')) {
    function crypto_rand_secure($min, $max) 
    {
        $range = $max - $min;
        if ($range < 1) return $min;
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        } while ($rnd >= $range);
        return $min + $rnd;
    }
}

/**
* [To generate random token]
* @param string $length
*/
if ( ! function_exists('generateToken')) {
    function generateToken($length) 
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
        }
        return $token;
    }
}



/**
* [To export DOC file]
* @param string $html
* @param string $filename
*/
if ( ! function_exists('exportDOCFile')) {
    function exportDOCFile($html,$filename = ''){
        $$filename = (!empty($filename)) ? $filename : 'document';
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=".$filename.".doc");
        echo $html;
    }
}

/**
* [To get user ip address]
*/
if (!function_exists('getRealIpAddr'))
{
    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
{   //check ip from share internet
    $ip = $_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{   //to check ip is pass from proxy
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
$ip = $_SERVER['REMOTE_ADDR']; //'103.15.66.178';//
}
return $ip;
}
}

/**
* [get_domain Get domin based on given url]
* @param  string $url
*/
if ( ! function_exists('get_domain')) 
{ 
    function get_domain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }
}

/**
* [to check url is 404 or not]
* @param  string $url
*/
if ( ! function_exists('is_404')) 
{ 
    function is_404($url) {
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);

        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        /* If the document has loaded successfully without any redirection or error */
        if ($httpCode >= 200 && $httpCode < 300) {
            return false;
        } else {
            return true;
        }
    }
}


/**
* [To Get date difference]
* @param  [string] $start
* @param  [string] $end
*/
if (!function_exists('dateDiff'))
{
    function dateDiff($start, $end)
    {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400) + 1;
    }
}




/**
* [To get user image thumb]
* @param  [string] $filepath
* @param  [string] $subfolder
* @param  [int] $width
* @param  [int] $height
* @param  [int] $min_width
* @param  [int] $min_height
*/
if (!function_exists('get_image_thumb'))
{
    function get_image_thumb($filepath,$subfolder,$width,$height,$min_width="",$min_height=""){

        if(empty($min_width))
        {
            $min_width = $width;
        }
        if(empty($min_height))
        {
            $min_height = $height;
        }
        /* To get image sizes */
        $image_sizes = getimagesize($filepath);
        if(!empty($image_sizes))
        {
            $img_width  = $image_sizes[0];
            $img_height = $image_sizes[1];
            if($img_width <= $min_width && $img_height <= $min_height)
            {
                return $filepath;
            }
        }

        $ci   = &get_instance();
        /* Get file info using file path */
        $file_info = pathinfo($filepath);
        if(!empty($file_info)){
            $filename = $file_info['basename'];
            $ext      = $file_info['extension'];
            $dirname  = $file_info['dirname'].'/';
            $path     = $dirname.$filename;
            $file_status = @file_exists($path);
            if($file_status){
                $config['image_library']  = 'gd2';
                $config['source_image']   = $path;
                $config['create_thumb']   = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width']          = $width;
                $config['height']         = $height;
                $config['new_image']      = FCPATH.'/uploads/images/thumb/';
				
                $ci->load->library('image_lib', $config);
                $ci->image_lib->initialize($config);
                if(!$ci->image_lib->resize()) {
                    return $path;
                } else {
                    @chmod($path, 0777);
                    $thumbnail = preg_replace('/(\.\w+)$/im', '', urlencode($filename)) . '_thumb.' . $ext;
                    return 'uploads/'.$subfolder.'/'.$thumbnail;
                }
            }else{
                return $filepath;
            }
        }else{
            return $filepath;
        }
    }
}

/**
* [To delete file from directory]
* @param  [string] $filename
* @param  [string] $filepath
*/
if (!function_exists('delete_file'))
{
    function delete_file($filename,$filepath)
    {
        /* Send file path last slash */
        $file_path_name = $filepath.$filename;
        if(!empty($filename) && @file_exists($file_path_name) && @unlink($file_path_name)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}

/**
* [To get data row count]
* @param string $table
* @param array $where
*/
if ( ! function_exists('getSingleRecord')) {
    function getSingleRecord($table,$where=""){
        $CI = & get_instance();
        if(!empty($table) && !empty($where)){
            $singleRecord = $CI->common_model->getsingle($table,$where);

        }
        return $singleRecord;
    }
}
/*****/
/**Check Friend**/
/*****/
if(!function_exists('checkFriend')){
    function checkFriend($userOne,$userTwo){
        if($userOne==$userTwo){
            $ret="You";
            return $ret;
            exit;
        }
        $CI = & get_instance();
        if(!empty($userOne) && !empty($userTwo)){
            $condition="(`user_one_id` ='$userOne' AND `user_two_id` = '$userTwo') OR (`user_one_id` = '$userTwo' AND `user_two_id` = '$userOne')";
            $checkFriend = $CI->common_model->getsingle(FRIENDS,$condition);
            if(!empty($checkFriend)){
                $req_status=$checkFriend->status;
                if($req_status==0){
                    if($checkFriend->user_two_id==$userOne){
                        $ret='NotConfirm';  
                    }else{
                        $ret='Pending'; 
                    } 
                }else if($req_status==1){
                    $ret='Accepted'; 
                }else{
                    $ret='Other';  
                }
            }else{
                $ret="No";
            } 
        }
        return $ret;
    }
}
/*****************************/
/*****************************/
/*****-Check Friend-**********/
/*****************************/
/*****************************/
if(!function_exists('checkRequest')){
    function checkRequest($userOne,$userTwo){
        if($userOne==$userTwo){
            $ret="You";
            return $ret;
            exit;
        }
        $CI = & get_instance();
        if(!empty($userOne) && !empty($userTwo)){
            $condition="(`sender` ='$userOne' AND `receiver` = '$userTwo') OR (`sender` = '$userTwo' AND `receiver` = '$userOne')";
            $checkRequest = $CI->common_model->getsingle(REQUESTS,$condition);
            if(!empty($checkRequest)){
                $req_status=$checkRequest->status;
                if($req_status==0){
                    if($checkRequest->receiver==$userOne){
                        $ret='NotConfirm';  
                    }else{
                        $ret='Pending'; 
                    } 
                }else if($req_status==1){
                    $ret='Accepted'; 
                }else{
                    $ret='Other';  
                }
            }else{
                $ret="No";
            } 
        }
        return $ret;
    }
}
/**
* [To print number in standard format with 0 prefix]
* @param int $no
*/
if ( ! function_exists('addZero')) {
    function addZero($no)
    {
        if($no >= 10){
            return $no;
        }else{
            return "0".$no;
        }
    }
}
/**
* [To convert date time format]
* @param datetime $datetime
* @param string $format
*/
if( ! function_exists('convertDateTime')) {
    function convertDateTime($datetime,$format='d F Y, h:i A')
    {
        $convertedDateTime = date($format,strtotime($datetime));
        return $convertedDateTime;
    }
}

/**
* [Star ratings]
*/
if( ! function_exists('starRating')) {
    function starRating($ratings,$reviewCount=false)
    {
        $ratings = number_format($ratings,1);
        $html='';
        $html.='<div class="stars">';
        if($ratings==0){
            $html.='<span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }
        else if($ratings>0 && $ratings<=0.5){
            $html.='<span class="staress"><i class="fa fa-star-half"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }
        else if($ratings>0.5 && $ratings<1){
            $html.='<span class="staress"><i class="fa fa-star-half-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }
        else if($ratings==1){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }

        else if($ratings>1 && $ratings<=1.5){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-half"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }
        else if($ratings>1.5 && $ratings<2){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-half-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }
        else if($ratings==2){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }


        else if($ratings>2 && $ratings<=2.5){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-half"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }
        else if($ratings>2.5 && $ratings<3){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-half-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }
        else if($ratings==3){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }

        else if($ratings>3 && $ratings<=3.5){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-half"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }
        else if($ratings>3.5 && $ratings<4){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-half-o"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }
        else if($ratings==4){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-o"></i></span>
            ';
        }



        else if($ratings>4 && $ratings<=4.5){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-half"></i></span>
            ';
        }
        else if($ratings>4.5 && $ratings<5){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star-half-o"></i></span>
            ';
        }
        else if($ratings==5){
            $html.='<span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            <span class="staress"><i class="fa fa-star"></i></span>
            ';
        }

        if($reviewCount){
            $html.='<span class="staress">('.$reviewCount.' reviews)</span>';
        }else if($reviewCount == 0){
            $html.='<span class="staress">(0 reviews)</span>';
        }else{
            $html.='<span class="staress">('.$ratings.' ratings)</span>';
        }

        $html.='</div>';
        return $html;
    }
}

if( ! function_exists('userOverallRatings')) {
    function userOverallRatings($userId)
    {
        $CI = & get_instance();
        $data = array();
        $ratingDetails = $CI->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$userId));
        $data['reviewCount'] = $ratingDetails['total_count'];
        if(!empty($ratingDetails['result'])){
            $ratingAverage=0;
            $reviewCount  = $ratingDetails['total_count'];
            foreach($ratingDetails['result'] as $row){
                $average = 0;
                $total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
                if($total>0){
                    $average = $total/5;
                }
                $ratingAverage+=$average;
            }
            if($ratingAverage>0)
                $data['ratingAverage'] = $ratingAverage/$reviewCount;
            else
                $data['ratingAverage'] = 0;
            $data['starRating'] = starRating($data['ratingAverage'],$data['reviewCount']);
        }else{
            $data['starRating'] = starRating(0,0);
        }
        return $data;
    }
}


if( ! function_exists('jobRequestedBy')) {
    function jobRequestedBy($sender,$receiver)
    {
        $CI = & get_instance();
        $id = 0;
        $requestedBy = $CI->common_model->getsingle(REQUESTS,array('sender'=>$sender,'receiver'=>$receiver));
        if(!empty($requestedBy)){
            $id = $requestedBy->job_requested_by;
        }
        return $id;
    }
}

if( ! function_exists('isFavourite')) {
    function isFavourite($sender,$receiver)
    {
        $CI = & get_instance();
        $isFavourite = 'no';
        $favouriteData = $CI->common_model->getsingle(FAVOURITES,array('added_by'=>$sender,'added_to'=>$receiver));
        if(!empty($favouriteData)){
            $isFavourite = 'yes';
        }
        return $isFavourite;
    }
}

/*For getting post comments*/
if( ! function_exists('getComments')) {
    function getComments($post_id)
    {
        $CI = & get_instance();
        $commentData = $CI->common_model->GetJoinRecord(COMMENTS,'user_id',USERS,'id','comments.*,tb_users.firstname,tb_users.lastname,tb_users.profile',array('comments.post_id'=>$post_id));
        if(!empty($commentData['result'])){
            return $commentData['result'];
        }else{
            return false;
        }
        
    }

    if( ! function_exists('checkRemoteFile')){
        function checkRemoteFile($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if(curl_exec($ch)!==FALSE)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}

/**
 * [To send push notifications]
 * @param string $msg
 * @param int $user_id
 * @param array $params
*/
if ( ! function_exists('send_push_notifications')) {
    function send_push_notifications($msg,$user_id,$params){
        $CI = & get_instance();
        /*  To Get User Details  */
        $userDetails = $CI->common_model->getsingle(USERS,array('id' => $user_id));
        $device_type = $userDetails->device_type;
        $device_token = $userDetails->device_id;
        /* Send IOS notifications */
        if($device_type == "IOS"){
            send_ios_notification($params,$device_token);
        }
        $device_type = 'ANDROID';
        /* Send Android notifications */
        if($device_type == "ANDROID"){
           // $device_token = 'dlDAIBnDe3U:APA91bEZdvqGnXY8B2GoftSeya6uil_4s_lqLNKw2xHt0xfG06bJjOdXqGzmtTuzpp943tux9xbHpCMcHi1UXPWrKnSQscFVzm6iZ6Xz538AeS_oik5RYkger0kgL4obH4TPnSb_G_Mh';
            send_android_notification($params,$device_token);
        }
    }
}

if(!function_exists('send_android_notification')) {
    function send_android_notification($data, $target){
        $CI = & get_instance();
        $fields = array(
            'data' => $data
        );
        $fields['to'] = $target;
        $server_key = 'AAAA73IAhp0:APA91bHDlqfUWFOxGSEs6rVVPB15R-ll5_4ipABzTS12mfGRDagQKE95QO22bEkaQc2NCdlp8bWpLSjlHYWtfjYfUH66lCIg6GFvyhs6w6sLTKEQ-no0tNj_Fo-KFFIayrs3wKS1vm-J';
        $headers = array
        (
            'Authorization: key=' . $server_key,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        $resp   = json_decode($result);
        //pr($resp);
        if(!empty($resp)){
            if($resp->success == 1){
                log_message('ERROR',"FCM - Message send successfully, message - ".$data['body']);
            }else{
                log_message('ERROR',"FCM - Message failed, message - ".$data['body']);
            }
        }
        curl_close($ch);
		return $resp;
    }
	
}



if(!function_exists('send_ios_notification')) {
    function send_ios_notification($data, $target) {
        $CI = & get_instance();
        $fields = array(
            'notification' => $data
        );
        $fields['to'] = $target;
        $server_key = 'AAAA73IAhp0:APA91bHDlqfUWFOxGSEs6rVVPB15R-ll5_4ipABzTS12mfGRDagQKE95QO22bEkaQc2NCdlp8bWpLSjlHYWtfjYfUH66lCIg6GFvyhs6w6sLTKEQ-no0tNj_Fo-KFFIayrs3wKS1vm-J';
        $headers = array
        (
            'Authorization: key=' . $server_key,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        $resp   = json_decode($result);
        //pr($resp);
        if(!empty($resp)){
            if($resp->success == 1){
                log_message('ERROR',"FCM - Message send successfully, message - ".$data['body']);
            }else{
                log_message('ERROR',"FCM - Message failed, message - ".$data['body']);
            }
        }
        curl_close($ch);
		return $resp;
    }
}

/* End of file custom_helper.php */
/* Location: ./system/application/helpers/custom_helper.php */

?>