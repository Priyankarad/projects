<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  function checkUserRegister($email){
       $tb_users=PROPERTY_USERS;
       $array=array('email'=>$email);
       $query=$this->db->select('*')->from($tb_users)->where($array)->get();
       if($query->num_rows() > 0){
         return $query->row();
       }else if($query->num_rows() > 0){
         return $query->row();
       }else{
         return false;
       }
  }

  function loginCheck($arr = array()){
       $email=(array_key_exists('email',$arr) ? $arr['email'] : '');
       $password=(array_key_exists('password',$arr) ? $arr['password'] : '');
       $array=array('email'=>$email,'password'=>$password);
       $query=$this->db->select('*')->from(PROPERTY_USERS)->where($array)->get();
       if($query->num_rows() > 0){
          return $query->row();
       }else{
         return false;
       }
  }
  
  public function verify($where) {
    return $this->db->get_where("property_users",$where)->row();
  }

  public function verify_user($email) {
    $data = array('verify_status' => 'verified');
    $this->db->where('email', $email);
    $this->db->update('property_users', $data);
    if ($this->db->affected_rows() > 0)
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }
  }

/*************-Select-Data_by-Condition-************/
public function get_data_by_condition($data,$table,$condition)
{
  $this->db->select($data);
  $query=$this->db->from($table);
  $query=$this->db->where($condition);
  $query=$this->db->get();
  return $query->result_array();
}

  /******************************************/
  /******************************************/
  /******************************************/
  public function check_email($email){
    $this->db->where('email', $email);
    $query = $this->db->get('tb_users');
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return false;
    }     
  }
  /******************************************/
  /******************************************/
  /******************************************/
  public function get_userdata($id){
    $this->db->where('id', $id);
    $query = $this->db->get(PROPERTY_USERS);
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return false;
    }     
  }
  /******************************************/
  /******************************************/
  /******************************************/
  public function insert_user($userdata){
    $this->db->insert('tb_users', $userdata);          
    $lastid = $this->db->insert_id();
    return $lastid;

  }
  /******************************************/
  /******************************************/
  /******************************************/
  function updateData($table, $data, $where) {
    $this->db->update($table, $data, $where);
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }
  /********/

  /******************************************/
  /******************************************/
  /******************************************/
  public function user_login($email,$password){
    $this ->db-> where('email', $email);
    $this->db->where('password',$password);
    $query = $this->db->get('tb_users');         
    if ($query->num_rows() > 0) {
      $this->updateData('tb_users',array('active'=>1),array('email'=>$email));
      return $query->row();
    } else {
      return false;
    }     
  }
  /******************************************/
  /******************************************/
  /******************************************/
  public function sendEmail($receiver,$name){
$from = "noreply@workadvisor.co";    //senders email address
$subject = 'Verify email address - Workadvisor';  //email subject
$message = '';
$message .= 'Please click on the below activation link to verify your email address<br><br>';
$message .= '<a style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;
color: #ffffff;background: #f26d35;line-height: 3;padding:15px;" href='. base_url().'User/confirmEmail/'. base64_encode($receiver) .'>Verify your email</a>';
//config email settings
$config['protocol'] = 'ssmtp';
$config['smtp_host'] = 'ssl://ssmtp.gmail.com';
$config['mailtype'] = 'html';
$config['newline'] = '\r\n';
$config['charset'] = 'utf-8';
$this->load->library('email', $config);
$this->email->initialize($config);

$mailData = array();
$mailData['message'] = $message;
$mailData['username'] = $name;
$message = $this->load->view('frontend/mailtemplate',$mailData,true);

$this->email->from($from);
$this->email->to($receiver);
$this->email->subject($subject);
$this->email->message($message);
if($this->email->send()){
  return true;
}else{
  echo "email send failed";
  return false;
}  
}
/******************************************/
/******************************************/
/******************************************/
public function verifyEmail($key){
  $data = array('status' => 'verify');
  $this->db->where('email',$key);
  return $this->db->update('tb_users', $data); 
}
/******************************************/
/******************************************/
/******************************************/
}