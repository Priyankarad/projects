<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {

  public function __construct(){
    parent::__construct();
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
/**************************** Custom - Query **************/
    public function customquery($myquery){
        $query = $this->db->query($myquery);
        return $query->result();
    }
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