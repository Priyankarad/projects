<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Custom Helper
* Author: Sorav Garg
* Author Email: soravgarg123@gmail.com
* version: 1.0
*/

/**
 * [To print array]
 * @param array $arr
*/
if ( ! function_exists('pr')) {
  function pr($arr)
  {
    echo '<pre>'; 
    print_r($arr);
    echo '</pre>';
    die;
  }
}

/**
 * [To language translation]
 * @param string $key
*/
if ( ! function_exists('lang')) {
  function lang($key)
  {
    $CI = & get_instance();
    return $CI->lang->line($key);
  }
}

/**
* [To save notifications]
* @param  [int]    $user_id
* @param  [string] $user_name
* @param  [string] $noti_type
* @param  [string] $user_image
* @param  [string] $user_image_thumb
* @param  [int]    $friend_id
* @param  [string] $params
* @param  [string] $message
*/
if(! function_exists('save_notification')){
  function save_notification($user_id,$sender_id = NULL,$user_name,$user_image,$user_image_thumb,$noti_type,$message,$friend_id = NULL,$field = NULL,$field_value = NULL){
    $CI = & get_instance();
    $notification_arr = array(
                    'user_id'          => $user_id,
                    'sender_id'        => $sender_id,
                    'user_name'        => $user_name,
                    'user_image'       => $user_image,
                    'user_image_thumb' => $user_image_thumb,
                    'noti_type'        => $noti_type,
                    'friend_id'        => $friend_id,
                    'message'          => $message,
                    'sent_time'        => datetime()
                  );
      if(!empty($field) && !empty($field_value))
      {
          $notification_arr[$field] = $field_value;
      }
      $lid = $CI->Common_model->insertData(NOTIFICATIONS,$notification_arr);
      if($lid)
      {
        return TRUE;
      }else{
        return FALSE;
      }
  }
}

/**
 * [To check blocked users]
 * @param int $user_id
*/
if ( ! function_exists('check_blocked_users')) {
  function check_blocked_users($user_id)
  {
    $CI = & get_instance();
    $result = $CI->Common_model->getsingle(USERS,array('id' => $user_id));
    if(!empty($result))
    {
      $response =  array();
      $response['code'] = 200;
      $response['response'] = array();
      $response['status']   = 0;
      if($result->is_verified == 0){
        $response['message'] = lang_api('varification_error',$CI->locale);
        echo json_encode($response);exit;
      }else if($result->is_blocked == 1){
        $response['message'] = lang_api('blocked_user_error',$CI->locale);
        echo json_encode($response);exit;
      }else if($result->is_deactivated == 1){
        $response['message'] = lang_api('deactivate_user_error',$CI->locale);
        echo json_encode($response);exit;
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
  function send_push_notifications($msg,$user_id,$params)
  {
    $CI = & get_instance();
    /*  To Get Friend Details  */
    $friend_details = $CI->Common_model->getsingle(USERS,array('id' => $user_id));
    if(!empty($friend_details) && $friend_details->is_blocked == 0 && $friend_details->is_deactivated == 0){
      $device_history = $CI->Common_model->getAllwhere(USERS_DEVICE_HISTORY,array('user_id' => $user_id));
      if(!empty($device_history))
      {
        /* To update user badges */
        $device_badges = (int) $friend_details->badges + 1;
        $CI->Common_model->updateFields(USERS, array('badges' => $device_badges), array('id' => $user_id));

        foreach($device_history as $dh)
        {
          $device_token   = $dh->device_id;
          $device_type    = $dh->device_type;
          $device_badges  = (int) $friend_details->badges + 1;
          $device_key     = $dh->device_key;

          /* Where condition to update badges device wise */
          $update_badges_condition = array(
                                      'user_id'     => $user_id,
                                      'device_type' => $device_type,
                                      'device_key'  => $device_key
                                    );

          /* Send IOS notifications */
          if($device_type == "IOS"){
              send_ios_notification($device_token,$msg,$params,$device_badges,$update_badges_condition);
          }

           /* Send Android notifications */
          if($device_type == "ANDROID"){
              $noti_data = array('body' => $msg,'params' => $params);
              send_android_notification($noti_data,$device_token,$device_badges,$update_badges_condition);
          }
        }
      }
      else
      {
        /* To update user badges */
        $device_badges = (int) $friend_details->badges + 1;
        $CI->Common_model->updateFields(USERS, array('badges' => $device_badges), array('id' => $user_id));

          $device_token   = $friend_details->device_id;
          $device_type    = $friend_details->device_type;
          $device_badges  = (int) $friend_details->badges + 1;
          $device_key     = $friend_details->device_key;

          /* Where condition to update badges device wise */
          $update_badges_condition = array(
                                      'user_id'     => $user_id,
                                      'device_type' => $device_type,
                                      'device_key'  => $device_key
                                    );

          /* Send IOS notifications */
          if($device_type == "IOS"){
              send_ios_notification($device_token,$msg,$params,$device_badges,$update_badges_condition);
          }

           /* Send Android notifications */
          if($device_type == "ANDROID"){
              $noti_data = array('body' => $msg,'params' => $params);
              send_android_notification($noti_data,$device_token,$device_badges,$update_badges_condition);
          }
      }
    }
  }
}

/**
 * [To Get Item Status]
 * @param int $type
*/
if ( ! function_exists('get_item_status')) {
  function get_item_status($type)
  {
    switch ($type) {
      case '0':
        return 'LIKED';
        break;
      case '1':
        return 'DIS-LIKED';
        break;
      case '2':
        return 'BLOCKED';
        break;
      default:
        return 'NONE';
        break;
    }
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
 * [To get all timezones]
*/
if ( ! function_exists('timezones')) {
  function timezones() 
  {
    $zones_array = array();
    $timestamp = time();
    foreach(timezone_identifiers_list() as $key => $zone) {
      date_default_timezone_set($zone);
      $zones_array[$zone] = date('P', $timestamp);
    }
    return $zones_array;
  }
}

/**
 * [To get timezone identifire]
 * @param string $timezone
*/
if ( ! function_exists('getTimeZoneTime')) {
  function getTimeZoneTime($timezone="")
  {
    $CI = & get_instance();
    if(!empty($timezone)){
      $tz = $timezone;
    }else{
      $tz = $CI->session->userdata('timezone');
    }
    if(!empty($tz)){
      $timezone_list = timezones();
      if(isset($timezone_list[$tz]) && !empty($timezone_list[$tz])) {
        return $timezone_list[$tz];
      }else{
        return '-07:00'; //America/Los_Angeles
      }
    }else{
      return '-07:00'; //America/Los_Angeles
    }
  }
}

/**
 * [To get local time from user timezone]
 * @param datetime $utc
 * @param string $format
*/
if ( ! function_exists('getLocalTime')) {
  function getLocalTime($utc,$format)
  {  
    $datetime = '';
    $CI = & get_instance();
    $timezone = $CI->session->userdata('timezone');
    $identifire = getTimeZoneTime($timezone);
    $identifireArr = explode(":", $identifire);
    $pos = strpos($identifireArr[0], '+');
    if($pos === false){
      $datetime = date($format,strtotime($identifireArr[0].' hour -'.$identifireArr[1].' minutes',strtotime($utc)));
    }else{
      $datetime = date($format,strtotime($identifireArr[0].' hour +'.$identifireArr[1].' minutes',strtotime($utc)));
    }
    return $datetime;
  }
}

/**
 * [To get current local time]
 * @param datetime $utc
 * @param string $format
*/
if ( ! function_exists('getCurrentLocalTime')) {
  function getCurrentLocalTime($utc,$format)
  {  
    $datetime = '';
    $utc = $utc." ".date('H:i:s');
    $CI = & get_instance();
    $timezone = $CI->session->userdata('timezone');
    $identifire = getTimeZoneTime($timezone);
    $identifireArr = explode(":", $identifire);
    $pos = strpos($identifireArr[0], '+');
    if($pos === false){
      $datetime = date($format,strtotime($identifireArr[0].' hour -'.$identifireArr[1].' minutes',strtotime($utc)));
    }else{
      $datetime = date($format,strtotime($identifireArr[0].' hour +'.$identifireArr[1].' minutes',strtotime($utc)));
    }
    return $datetime;
  }
}

/**
 * [To get item images]
 * @param int $item_id
*/
if ( ! function_exists('getItemImages')) {
  function getItemImages($item_id)
  {
    $CI = & get_instance();
    $item_images = $CI->Common_model->getAllwhere(ITEM_IMAGES,array('item_id' => $item_id),'id','DESC','',5);
    return $item_images;
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
 * [To update user pills]
 * @param int $user_id
 * @param int $pills
 * @param string $type
 * @param string $column
*/
if ( ! function_exists('update_user_pills')) {
  function update_user_pills($user_id,$pills,$type,$column="active_pills")
  {
    $CI = & get_instance();
    $this->db->where('id',$user_id);
    $this->db->set($column, $column.$type.$pills, FALSE);
    $this->db->update(USER);
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }
}

/**
 * [To get user data]
 * @param int $profile_id
*/

if(! function_exists('getUserInformation')){
  function getUserInformation($profile_id){
    $CI = & get_instance();
    $result = $CI->Common_model->getsingle(USERS,array('id'=>$profile_id));
    $response = array();
    if(!empty($result)){
      $response['name']                      = null_checker($result->name);
      $response['useremail']                 = null_checker($result->email);
      $response['profile_id']                = null_checker($result->id);
      $response['age']                       = null_checker($result->age);
      $response['description']               = null_checker($result->about);
      $response['user_since']                = null_checker($result->created_date);
      $response['country']                   = null_checker($result->country);
      $response['lat']                       = null_checker($result->lat);
      $response['lng']                       = null_checker($result->lng);
      $response['city']                      = null_checker($result->city);
      $response['gender']                    = null_checker($result->gender);
      $response['address']                   = null_checker($result->address);
      $response['social_type']               = null_checker($result->social_type);
      $response['active_pills']              = null_checker($result->active_pills,0);
      $response['freeze_pills']              = null_checker($result->freeze_pills,0);
      $response['is_following_you']          = null_checker($result->is_following_you,0);
      $response['want_object']               = null_checker($result->want_object,0);
      $response['event_updates']             = null_checker($result->event_updates,0);
      $response['badges']                    = null_checker($result->badges,0);
      $response['login_session_key']         = $result->login_session_key;
      $response['total_follower']            = (int) getAllCount(FOLLOWERS,array('recieve_user_id' => $profile_id,'status'=>'ACCEPT'));
      $response['total_following']           = (int) getAllCount(FOLLOWERS,array('send_user_id' => $profile_id,'status'=>'ACCEPT'));
      $response['total_item']                = (int) getAllCount(ITEMS,array('user_id' => $profile_id,'item_status'=>'ACTIVE'));
      $response['total_swap']                = (int) count(get_swapped_requests($profile_id));
      if(empty($result->user_image)){
          $response['profile_image']    = "";
      }else{
          $response['profile_image']    = base_url().$result->user_image;
      }
      if(empty($result->user_image_thumb)){
          $response['profile_image_thumb']    = "";
      }else{
          $response['profile_image_thumb']    = base_url().$result->user_image_thumb;
      }

      $data = $CI->input->post();
    }
    return $response;
  }
}

/**
 * [To Get Swapped Requests]
 * @param int $user_id
*/

if(! function_exists('get_swapped_requests'))
{
    function get_swapped_requests($user_id)
    {
        $CI = & get_instance();
        $data = array();
        $where_condition = SWAPPER.".swap_status = 'SWAPPED' AND (".SWAPPER.".user_id = ".$user_id." OR ".SWAPPER.".friend_id = ".$user_id.")";
        $CI->db->select("*,".SWAPPER.'.id AS swap_id');
        $CI->db->from(SWAPPER);
        $CI->db->join(SWAPPER_ITEMS, SWAPPER_ITEMS.".swapper_id = ".SWAPPER.".id");
        $CI->db->where($where_condition,NULL,FALSE);
        $CI->db->group_by(SWAPPER.".id");
        $CI->db->order_by(SWAPPER_ITEMS.'.id', 'DESC');
        $q = $CI->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return $data;
    }
}

/**
 * [To get Swap item count]
 * @param int $user_id
*/
if(!function_exists('get_swap_item')){
    function get_swap_item($user_id){
      $CI = & get_instance();
      $where_condition = "swap_status = 'SWAPPED' AND (user_id = ".$user_id." OR friend_id = ".$user_id.")";
      echo getAllCount(SWAPPER,$where_condition);
    }
}

/*
 * [To Get User Swap Items]
 * @param string $type
*/
if (!function_exists('get_user_swap_items')) {
  function get_user_swap_items($type)
  {
    $CI = & get_instance();
    $data = array();
    $CI->db->select("S.id AS swap_id,S.user_extra_pills AS user_pills,S.friend_extra_pills AS friend_pills,S.swap_initiate_time AS swap_initiate_time,U.name AS user_name,F.name AS friend_name");
    $CI->db->from(SWAPPER.' AS S');
    $CI->db->join(USERS.' AS U', "U.id = S.user_id",'inner');
    $CI->db->join(USERS.' AS F', "F.id = S.friend_id",'inner');
    $CI->db->where('S.swap_status',$type);
    $CI->db->order_by('S.id', 'DESC');
    $q = $CI->db->get();
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $rows) {
            $data[] = $rows;
        }
        $q->free_result();
    }
    return $data;
  }
}

/**
*[To get block user id]
* @param int $user_id
*/
if(!function_exists('get_block_users')){
    function get_block_users($user_id)
    {
      $CI = & get_instance();
      $friend_ids = array('0');
      $CI->db->select('friend_id');
      $CI->db->from(BLOCK_USER);
      $CI->db->where('user_id',$user_id);
      $q = $CI->db->get();
      if($q->num_rows() > 0){
        $form_names = $q->result_array();
        $friend_ids = array_column($form_names, 'friend_id');
      }
      return $friend_ids;
    }
}

/**
 * [To get user follow status]
 * @param int $user_id
 * @param int $profile_visitor_id
*/
if (!function_exists('get_follow_status')) {
  function get_follow_status($user_id,$profile_visitor_id)
  {
    $CI = & get_instance();

    // $where_condition = '((send_user_id = '.$user_id.' OR send_user_id = '.$profile_visitor_id.') AND (recieve_user_id = '.$user_id.' OR recieve_user_id = '.$profile_visitor_id.'))';
    $where_condition = 'send_user_id = '.$user_id.' AND recieve_user_id = '.$profile_visitor_id;
    $CI->db->select('*');
    $CI->db->from(FOLLOWERS);
    $CI->db->where($where_condition,NULL,FALSE);
    $q = $CI->db->get();
    $num = $q->num_rows();
    if ($num > 0) {
      return 'FOLLOW';
    }else{
      return 'UN-FOLLOW';
    }
  }
}





/**
 * [To get user current location data]
*/
if ( ! function_exists('getCurrentLocationData')) {
  function getCurrentLocationData()
  {
    $data  = file_get_contents('https://api.ipify.org/?format=json');
    $query = json_decode($data,TRUE);
    if(!empty($query) && !empty($query['ip'])){
      $data1  = file_get_contents('http://freegeoip.net/json/'.$query['ip']);
      $query1 = json_decode($data1,TRUE);
      return $query1;
    }else{
      return array();
    }
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
 * [To get current datetime]
*/
if ( ! function_exists('datetime')) {
  function datetime()
  {
    $datetime = date('Y-m-d H:i:s');
    return $datetime;
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
 * [To convert date time format]
 * @param datetime $datetime
 * @param string $format
*/
if ( ! function_exists('convertDateTime')) {
  function convertDateTime($datetime,$format='')
  {
    $new_fromat = '';
    if(empty($format)){
      $new_fromat = 'd F Y, h:i A';
    }else{
      $new_fromat = $format;
    }
    return date($new_fromat,strtotime($datetime));
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
  function fileUploading($subfolder,$ext,$size="",$width="",$height="",$filename)
  {
      $CI = & get_instance();
      $config['upload_path']   = 'uploads/'.$subfolder.'/'; 
      $config['allowed_types'] = $ext; 
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
      $ci = &get_instance();
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
if (!function_exists('ExecuteCurl'))
{

    function ExecuteCurl($url, $jsondata = '', $post = '', $headerData = [])
    {
        $ch = curl_init();
        $headers = array('Accept: application/json', 'Content-Type: application/json');
        if (!empty($headerData) && is_array($headerData))
        {
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
 * [To filter POST/GET value]
 * @param string $value
*/
if ( ! function_exists('filtervalue')) {
  function filtervalue($value)
  {
    $filtered_val = '';
    $filtervalue  = strip_tags($value);
    return $filtervalue; 
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
  function send_mail($from,$to,$subject,$message)
  {
      $ci = &get_instance();
      $config['mailtype'] = 'html';
      $ci->email->initialize($config);
      $ci->email->from($from);
      $ci->email->to($to);
      $ci->email->subject($subject);
      $ci->email->message($message);
      if($ci->email->send()) {  
        return true;
      } else {
        return false;
      }
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
          $string = $array[$key];
          return trim(strip_tags($string));
        }else{
          return $default;
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
 * [To get live videos thumb Youtube,Vimeo]
 * @param string $videoString
*/
if ( ! function_exists('getVideoThumb')) {
  function getVideoThumb($videoString = null){
      // return data
      $videos = array();
      if (!empty($videoString)) {
          // split on line breaks
          $videoString = stripslashes(trim($videoString));
          $videoString = explode("\n", $videoString);
          $videoString = array_filter($videoString, 'trim');
          // check each video for proper formatting
          foreach ($videoString as $video) {
              // check for iframe to get the video url
              if (strpos($video, 'iframe') !== FALSE) {
                  // retrieve the video url
                  $anchorRegex = '/src="(.*)?"/isU';
                  $results = array();
                  if (preg_match($anchorRegex, $video, $results)) {
                      $link = trim($results[1]);
                  }
              } else {
                  // we already have a url
                  $link = $video;
              }
              // if we have a URL, parse it down
              if (!empty($link)) {
                  // initial values
                  $video_id = NULL;
                  $videoIdRegex = NULL;
                  $results = array();
                  // check for type of youtube link
                  if (strpos($link, 'youtu') !== FALSE) {
                      if (strpos($link, 'youtube.com') !== FALSE) {
                          // works on:
                          // http://www.youtube.com/embed/VIDEOID
                          // http://www.youtube.com/embed/VIDEOID?modestbranding=1&amp;rel=0
                          // http://www.youtube.com/v/VIDEO-ID?fs=1&amp;hl=en_US
                          $videoIdRegex = '/youtube.com\/(?:embed|v){1}\/([a-zA-Z0-9_]+)\??/i';
                      } else if (strpos($link, 'youtu.be') !== FALSE) {
                          // works on:
                          // http://youtu.be/daro6K6mym8
                          $videoIdRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
                      }
                      if ($videoIdRegex !== NULL) {
                          if (preg_match($videoIdRegex, $link, $results)) {
                              $video_str = 'http://www.youtube.com/v/%s?fs=1&amp;autoplay=1';
                              $thumbnail_str = 'http://img.youtube.com/vi/%s/2.jpg';
                              $fullsize_str = 'http://img.youtube.com/vi/%s/0.jpg';
                              $video_id = $results[1];
                          }
                      }
                  }
                  // handle vimeo videos
                  else if (strpos($video, 'vimeo') !== FALSE) {
                      if (strpos($video, 'player.vimeo.com') !== FALSE) {
                          // works on:
                          // http://player.vimeo.com/video/37985580?title=0&amp;byline=0&amp;portrait=0
                          $videoIdRegex = '/player.vimeo.com\/video\/([0-9]+)\??/i';
                      } else {
                          // works on:
                          // http://vimeo.com/37985580
                          $videoIdRegex = '/vimeo.com\/([0-9]+)\??/i';
                      }
                      if ($videoIdRegex !== NULL) {
                          if (preg_match($videoIdRegex, $link, $results)) {
                              $video_id = $results[1];
                              // get the thumbnail
                              try {
                                  $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
                                  if (!empty($hash) && is_array($hash)) {
                                      $video_str = 'http://vimeo.com/moogaloop.swf?clip_id=%s';
                                      $thumbnail_str = $hash[0]['thumbnail_small'];
                                      $fullsize_str = $hash[0]['thumbnail_large'];
                                  } else {
                                      // don't use, couldn't find what we need
                                      unset($video_id);
                                  }
                              } catch (Exception $e) {
                                  unset($video_id);
                              }
                          }
                      }
                  }
                  // check if we have a video id, if so, add the video metadata
                  if (!empty($video_id)) {
                      // add to return
                      $videos[] = array(
                          'url' => sprintf($video_str, $video_id),
                          'thumbnail' => sprintf($thumbnail_str, $video_id),
                          'fullsize' => sprintf($fullsize_str, $video_id)
                      );
                  }
              }
          }
      }
      // return array of parsed videos
      return $videos;
  }
}

if ( ! function_exists('getVimeoVideoIdFromUrl')) {
  function getVimeoVideoIdFromUrl($url = '') {
      $regs = array();
      $id = '';
      if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
          $id = $regs[3];
      }
      return $id;
  }
}

/**
 * [To get embedded live video url]
 * @param string $url
 * @param string $type
*/
if ( ! function_exists('parseLiveVideo')) {
  function parseLiveVideo($url,$type = 'youtube') {
    $parsedURL = '';
    switch ($type) {
      case 'youtube':
        $parsedURL = str_replace('watch?v=', 'embed/', $url);
        break;
      case 'vimeo':
        $vid  = getVimeoVideoIdFromUrl($url);
        $parsedURL = 'https://player.vimeo.com/video/'.$vid;
        break;
      default:
        $parsedURL = '';
        break;
    }
    return $parsedURL;
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
 * [Create GUID]
 * @return string
 */
if (!function_exists('get_guid'))
{
    function get_guid()
    {
        if (function_exists('com_create_guid'))
        {
            return strtolower(com_create_guid());
        }
        else
        {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12);
            return strtolower($uuid);
        }
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
 * [get_ip_location_details Get location details based on given IP Address]
 * @param  [string] $ip_address [IP Adress]
 * @return [array]           [location details]
 */
if ( ! function_exists('get_ip_location_details')) 
{    
    function get_ip_location_details($ip_address) 
    {
        $url = "http://api.ipinfodb.com/v3/ip-city/?key=" . IPINFODBKEY . "&ip=" . $ip_address . "&timezone=true&format=json";
        $location_data = json_decode(ExecuteCurl($url), true);
        return $location_data;
    }
}

/**
* [geocoding_location_details Get location details based on given geo coordinate]
* @param  [string] $latitude  [latitude]
* @param  [string] $longitude [longitude]
* @return [array]            [location details]
*/
if(!function_exists('geocoding_location_details'))
{    
    function geocoding_location_details($latitude, $longitude)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latitude.",".$longitude;
        $details = json_decode(file_get_contents($url));
        return $details;
    }
}

/**
* [To Format Bytes]
* @param  [integer] $bytes
*/
if (!function_exists('formatSizeUnits'))
{
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = NumberFormat($bytes / 1073741824) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = NumberFormat($bytes / 1048576) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = NumberFormat($bytes / 1024) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = NumberFormat($bytes) . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = NumberFormat($bytes) . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}

/**
* [To Get offset using page no, limit]
* @param  [integer] $PageNo
* @param  [integer] $Limit
*/
if (!function_exists('getOffset'))
{
    function getOffset($PageNo, $Limit)
    {
        if (empty($PageNo))
        {
            $PageNo = 1;
        }
        $offset = ($PageNo - 1) * $Limit;
        return $offset;
    }
}

/**
* [To create seo friendly string]
* @param  [string] $str
*/
if (!function_exists('get_seo_url'))
{
  function get_seo_url($str){
    if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
    $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
    $str = strtolower( trim($str, '-') );
    return $str;
  }
}

/**
* [To save user devices history]
* @param  [int] $user_id
* @param  [string] $device_id
* @param  [string] $device_type
* @param  [string] $device_key
*/
if (!function_exists('save_user_device_history'))
{
  function save_user_device_history($user_id,$device_id,$device_type,$device_key){
    $CI = & get_instance();

    /* Check device details already exist or not */
    $device_arr = array(
                    'user_id'    => $user_id,
                    'device_key' => $device_key,
                    'device_type' => $device_type
                  );
    $status = $CI->Common_model->getAllwhere(USERS_DEVICE_HISTORY,$device_arr);
    if(empty($status)){
      /* Insert device history */
      $device_arr['device_id'] = $device_id;
      $device_arr['added_date'] = datetime();
      $lid = $CI->Common_model->insertData(USERS_DEVICE_HISTORY,$device_arr);
      if($lid){
        return TRUE;
      }else{
        return FALSE;
      }
    }else{
      $CI->Common_model->updateFields(USERS_DEVICE_HISTORY,array('device_id' => $device_id),array('id' => $status[0]->id));
    }
  }
}

/**
* [To get offsets]
* @param  [int] $page_no
*/
if (!function_exists('get_offsets'))
{
  function get_offsets($page_no = 0)
  {
     $offset = ($page_no == 0) ? 0 : (int) $page_no * 10 - 10;
     return $offset;
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
  function get_image_thumb($filepath,$subfolder,$width,$height,$min_width="",$min_height="")
  {

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
          $ci->load->library('image_lib', $config);
          $ci->image_lib->initialize($config);
          if(!$ci->image_lib->resize()) {
              return $path;
          } else {
            @chmod($path, 0777);
            $thumbnail = preg_replace('/(\.\w+)$/im', '', $filename) . '_thumb.' . $ext;
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
* [To upload file]
* @param  [string] $filename
* @param  [string] $subfolder
* @param  [string] $filename
* @param  [int] $size
* @param  [int] $width
* @param  [int] $height
*/
if (!function_exists('fileUpload'))
{
  function fileUpload($filename,$subfolder,$ext,$size="",$width="",$height="")
  {
      $CI = & get_instance();
      $config['upload_path']   = 'uploads/'.$subfolder.'/'; 
      $config['allowed_types'] = $ext; 
      if($size){
        $config['max_size']   = 10000; 
      }
      if($width){
        $config['max_width']  = 102400; 
      }
      if($height){
        $config['max_height'] = 76800;  
      }
      $CI->load->library('upload', $config);
      $CI->upload->initialize($config);
      if (!$CI->upload->do_upload($filename)) {
        $error = array('error' => $CI->upload->display_errors()); 
        return $error;
      }
     else { 
        $data = array('upload_data' => $CI->upload->data()); 
        return $data;
     } 
  }
}

/**
 * [To check null value]
 * @param string $value
*/
if ( ! function_exists('null_checker')) {
  function null_checker($value,$custom="")
  {
    $return = "";
    if($value != "" && $value != NULL){
      $return = ($value == "" || $value == NULL) ? $custom : $value;
      return $return;
    }else{
      return $return;
    }
  }
}

/**
 * Image Uploading
 *
*/
function corefileUploading($name,$subfolder){    
  $f_name1 = $_FILES[$name]['name'];    
  $f_tmp1  = $_FILES[$name]['tmp_name'];    
  $f_size1 = $_FILES[$name]['size'];    
  $f_extension1 = explode('.',$f_name1);     
  $f_extension1 = strtolower(end($f_extension1));    
  $f_newfile1="";    
  if($f_name1){      
    $f_newfile1 = rand()."-swapush-".time().'.'.$f_extension1;      
    $store1 = "uploads/".$subfolder."/". $f_newfile1;     
    if(move_uploaded_file($f_tmp1,$store1)){        
      chmod($store1, 0777);       
      return $store1;     
    }else{       
      return "";      
    }
  }else{
    return "";    
  }    
}



/**
* [To get time ago string]
* @param  [datetime] $datetime
*/
if(!function_exists('time_ago'))
{
  function time_ago($datetime, $full = false)
  {
      $now     = new DateTime;
      $ago     = new DateTime($datetime);
      $diff    = $now->diff($ago);
      $diff->w = floor($diff->d / 7);
      $diff->d -= $diff->w * 7;
      $CI = & get_instance(); 
      $user_lang = (!empty($CI->input->post('lang'))) ? $CI->input->post('lang') : DEFAULT_LANGUAGE;
      $string = array(
          'y' => lang_api('year',$user_lang),
          'm' => lang_api('month',$user_lang),
          'w' => lang_api('week',$user_lang),
          'd' => lang_api('day',$user_lang),
          'h' => lang_api('hour',$user_lang),
          'i' => lang_api('minute',$user_lang),
          's' => lang_api('second',$user_lang)
      );
      foreach ($string as $k => &$v) {
          if ($diff->$k) {
              $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
          } else {
              unset($string[$k]);
          }
      }
      
      if (!$full)
          $string = array_slice($string, 0, 1);
      return $string ? implode(', ', $string) . ' '.lang_api('ago',$user_lang) : lang_api('just_now',$user_lang);
  }
}