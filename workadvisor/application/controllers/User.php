<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
error_reporting(E_ERROR | E_PARSE);
class User extends My_Controller {
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('america/new_york');
        $this->load->model('User_model');
        $this->load->config('linkedin');
    }
    public function index(){
        if($this->session->userdata('id')){
            redirect('');
        }else{
            $data['authUrl'] = $this->facebook->login_url();
            $data['loginURL'] = $this->googleplus->loginURL();      
            $data['oauthURL'] = base_url().$this->config->item('linkedin_redirect_url').'?oauth_init=1';    
            $this->frontendtemplates('signup',$data);
        }
    }
    /********************************/
    /************ Login ************/
    /********************************/
    public function login(){
        if($this->session->userdata('id')){
            $this->session->set_userdata('posts',array());
            $this->common_model->updateFields(USERS,array('login_status'=>1),array('id'=>get_current_user_id()));
            redirect(site_url('profile'));
        }
        else{
            $data['authUrl'] = $this->facebook->login_url();
            $data['oauthURL'] = base_url().'home/linkedinAuth?oauth_init=1';
            $data['loginURL'] = $this->googleplus->loginURL();
            $this->frontendtemplates('login',$data);
        }   
    }
    /********************************/
    /************ Register Process ************/
    /********************************/
    public function registerprocess(){
        $firstname=$this->input->post('firstname');
        $lastname=$this->input->post('lastname');
        $email=$this->input->post('email');
        $password=$this->input->post('password');
        $result = $this->User_model->check_email($email);

        if(!empty($result)) {
            $this->session->set_flashdata('registermsg','
                <div class="alert alert-danger text-center">You are already registered! Please login here.</div>
                ');
            redirect('register');
        } else {
            $userdata = array(
                'type' => 'normal',
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => generate_password($password),
                'profile' => DEFAULT_IMAGE,
                'status' => 'unverify',                  
                'device_id' => '',                 
                'device_type' => '',                  
                'latitude' => '',                
                'longitude' => '',                  
            );
            if($this->User_model->insert_user($userdata)) {
$from = "noreply@workadvisor.co";    //senders email address
$subject = 'Verify email address - WorkAdvisor.co';  //email subject
$message = '';
$message .= 'Please click on the below activation link to verify your email address<br><br>';
$message .= '<a style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;
color: #ffffff;background: #008000;line-height: 3;padding:15px;" href='. base_url().'User/confirmEmail/'. base64_encode($email) .'>Verify your email</a>';
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
$mailData['username'] = $firstname;
$message = $this->load->view('frontend/mailtemplate',$mailData,true);
$this->email->from($from);
$this->email->to($email);
$this->email->subject($subject);
$this->email->message($message);
$this->email->set_header('From', $from);
if($this->email->send()){
    $this->session->set_flashdata('registermsg', '
        <div class="alert alert-success text-center">Successfully registered. Please confirm the mail that has been sent to your email.<br>
        Please allow up to 30 seconds for email to arrive to your inbox. </div>
        ');
    redirect('register');
}
            }
            else{                       
                $this->session->set_flashdata('registermsg','
                    <div class="alert alert-danger text-center">Error in registration!!!!!</div>
                    ');
                redirect('register');
            }                       
        }
    }
    /********************************/
    /******** Confirm Email **********/
    /********************************/
    public function confirmEmail(){
        $hashcode = base64_decode($this->uri->segment(3));
        if($this->User_model->verifyEmail($hashcode)){
            $this->session->set_flashdata('updatemsg', '
                <div class="alert alert-success text-center">Email address is confirmed. Please contine to process</div>
                ');
// $data['email'] = $hashcode;
//$this->frontendtemplates('create_category',$data);
            $this->create_category($hashcode);
        }else{
            $this->session->set_flashdata('loginmsg', '
                <div class="alert alert-danger text-center">Email address is not confirmed. Please try to re-register.</div>
                ');
            redirect('login');
        }
    }
    /********************************/
    /********** Login Process *******/
    /********************************/
    public function loginprocess($review = false){
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $result = $this->User_model->check_email($email);            
        if(!empty($result)){
            $hashpassword = $result->password;
            $user_role = $result->user_role;
            $newpassword = password_check($password,$hashpassword);
            if($newpassword=='verified'){
                $result1=$this->User_model->user_login($email,$hashpassword);
                $status=$result1->status;
                $activated=$result1->active;
                if($activated==0){
                    $this->session->set_flashdata('loginmsg','<div class="alert alert-danger text-center"> Your account has been deactivated. Contact To admin. </div>');
                    redirect(base_url('login'));
                    exit;
                }
                if($status=='verify'){ 
                    $loginSession=array(
                        'type' => 'facebook',
                        'oauth_uid' => $result1->oauth_uid,
                        'firstname' =>$result1->firstname,
                        'lastname' => $result1->lastname,
                        'email' => $result1->email,
                        'gender' => $result1->gender,
                        'lang' => $result1->lang,
                        'profile_url' => $result1->profile_url,
                        'profile' => $result1->profile,
                        'status' => $result1->status
                    );                  
                    $this->session->set_userdata('loggedIn', true);
                    $this->session->set_userdata('userData',$loginSession);
                    
                    if(!empty($_POST['keepMeLoggedin'])) {
                    /* set cookie */
                    $cookie1= array(
                             'name'   => 'usernamecookie',
                             'value'  => $email,
                             'expire' => '864000', // 10 days
                        );
                        $cookie2= array(
                             'name'   => 'passcookie',
                             'value'  => $password,
                             'expire' => '864000', // 10 days
                         );
                        $this->input->set_cookie($cookie1);
                        $this->input->set_cookie($cookie2);
                    }
                    /* set cookie end */
                    if($this->check_userrole()){
                        $this->session->set_userdata('posts',array());
                        if($review == 'review' && $this->input->post('userURL')){
                                $url = $this->input->post('userURL')."?review=1";
                                redirect($url);
                        }else{
                            if($this->session->userdata('message_link') && !empty($this->session->userdata('message_link'))){
                                redirect($this->session->userdata('message_link'));
                            }else{
                                if($this->session->userdata('actual_link') && !empty($this->session->userdata('actual_link'))){
                                    redirect($this->session->userdata('actual_link')."?review=1");
                                }else{
                                    $this->common_model->updateFields(USERS,array('login_status'=>1),array('id'=>get_current_user_id()));
                                    if($result1->user_role == 'Performer'){
                                        redirect('profile');
                                    }else{
                                        redirect('businessprofile');                                                        
                                    }
                                }
                            }
                        }
                    }else{
                        $this->session->set_flashdata('updatemsg','
                            <div class="alert alert-danger text-center">Build Profile</div>
                            ');
                        $this->create_category($result1->email);
                    }
                }else{
                    $this->session->set_flashdata('loginmsg','
                        <div class="alert alert-danger text-center">Oops!.  Please verify your email id before proceeding !!!</div>
                        ');
                    redirect('login');
                }                     
            }
            else{
                $this->session->set_flashdata('loginmsg','
                    <div class="alert alert-danger text-center">Oops!.  Invalid username or password!!!</div>
                    ');
                redirect('login');  
            }
        } else
        {
            $this->session->set_flashdata('loginmsg','
                <div class="alert alert-danger text-center">Oops!.  Username Not Available, Please Register here!.!!!</div>
                ');
            redirect('login');                               
        }
    } 
    /********************************/
    /*****Social Authentication*****/
    /********************************/
    public function social_authentication(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $this->common_model->updateFields(USERS,array('login_status'=>1),array('id'=>get_current_user_id()));
            $userdata=json_decode($this->input->post('userdata'));
            $type=$userdata->type;
            $id=$userdata->id;
            $firstname=$userdata->first_name;
            $lastname=$userdata->last_name;
            $email=($userdata->email ?: '');
            if($type=='google')
            {
                $picture=$userdata->picture.'&size=1024'; 
            }
            else
            {
                $picture=$userdata->picture; 
            }
            if($this->session->userdata("id")){
                $arr['result']=2;
                $arr['msg']="Already logged in";
                echo json_encode($arr);
                exit();
            }   
            else{
                $details=$this->User_model->check_email($email);                                          
                if(!empty($details)){   
                    $this->session->set_userdata('loggedIn', true);
                    $loginSession=array(
                        'type' => 'facebook',
                        'oauth_uid' => $details->oauth_uid,
                        'firstname' =>$details->firstname,
                        'lastname' => $details->lastname,
                        'email' => $details->email,
                        'gender' => $details->gender,
                        'lang' => $details->lang,
                        'profile_url' => $details->profile_url,
                        'profile' => $details->profile,
                        'status' => $details->status,
                        'active' => 1
                    );
                    $this->session->set_userdata('userData',$loginSession);
//pr($this->session->userdata['userData']);
                    $usermail= base64_encode($details->email);
                    $arr['userdata']=$details->user_role;
                    $arr['email']=$usermail;
                    $arr['result']=1;
                    $arr['msg']='login successfull'; 
                    echo json_encode($arr);
                    exit();
                }else{
                    $arr_reg=array('type'=>$type,'firstname'=>$firstname,'lastname'=>$lastname,'email'=>$email,'password'=>'','profile'=>DEFAULT_IMAGE,'status'=>'verify','active'=>1);
                    $register_user=$this->User_model->insert_user($arr_reg);
                    $userDetails= $this->User_model->get_userdata($register_user);
                    $this->session->set_userdata('loggedIn', true);
                    $loginSession=array(
                        'type' => 'facebook',
                        'oauth_uid' => $userDetails->oauth_uid,
                        'firstname' =>$userDetails->firstname,
                        'lastname' => $userDetails->lastname,
                        'email' => $userDetails->email,
                        'gender' => $userDetails->gender,
                        'lang' => $userDetails->lang,
                        'profile_url' => $userDetails->profile_url,
                        'profile' => $userDetails->profile,
                        'status' => $userDetails->status
                    );
                    $this->session->set_userdata('userData',$loginSession);
//pr($this->session->userdata['userData']);
                    $usermail= base64_encode($email);
                    $arr['userdata']=$details;
                    $arr['email']=$usermail;
                    $arr['result']=1;
                    $arr['msg']='login successfull';                                       
                }
            }
        }else{
            $arr['result']=0;
            $arr['msg']='invalid argument supply';
        }     
        echo json_encode($arr);
    }
    /*********************************************/
    /************** CREATE CATEGORY **************/
    /*********************************************/
    public function create_category($email = ''){
        if($this->session->userdata('loggedIn')){
            $email=$this->session->userdata['userData']['email'];
            $data['email']=$email;
            $data['categories'] = $this->common_model->getAllwhere(CATEGORY,array('category_status'=>1));
            $userDetails = $this->common_model->getsingle(USERS,array('email'=>$email));
            $data['category_details'] = $this->common_model->getsingle(CATEGORY,array('user_id'=>$userDetails->id));
            $this->frontendtemplates('create_category',$data);
        }else{
            $this->session->set_flashdata('error','
                <div class="alert alert-danger text-center">Oops!.  Plz Login!!!</div>
                ');
            redirect(base_url('login'));
        }
    }
    /*********************************************/
    /************** CREATE CATEGORY **************/
    /*********************************************/
    public function social_createcategory($email){
        $usermail = base64_decode($email);
        $data['email'] = $usermail;
        $data['categories'] = $this->common_model->getAllwhere(CATEGORY,array('category_status'=>1));
        $userDetails = $this->common_model->getsingle(USERS,array('email'=>$usermail));
        $data['category_details'] = $this->common_model->getsingle(CATEGORY,array('user_id'=>$userDetails->id));
        $this->frontendtemplates('create_category',$data);
    }
/**
* Function Name: categoryAdd
* Description:   To Add New Category
*/
public function categoryAdd(){
// pr($_POST);
    $data = $this->input->post();
    $email = $data['user_email'];
    $category_name = $data['categoryName'];
    $user_data = $this->common_model->getsingle(USERS,array('email'=>$email));
    $category_data = $this->common_model->getsingle(CATEGORY,array('name'=>$category_name));
    if(empty($category_data)){
        $dataArr = array();
        $dataArr['user_id']             = $user_data->id;
        $dataArr['name']            = extract_value($data,'categoryName','');
// $dataArr['que_1']            = extract_value($data,'que_1','');
// $dataArr['que_2']            = extract_value($data,'que_2','');
// $dataArr['que_3']            = extract_value($data,'que_3','');
// $dataArr['que_4']            = extract_value($data,'que_4','');
// $dataArr['que_5']            = extract_value($data,'que_5','');
        $dataArr['category_status']     = 0;
        $slugArr = explode(" ",extract_value($data,'categoryName',''));
        $slug = isset($slugArr[0])?$slugArr[0]:'';
        $dataArr['slug'] = $slug;
        $dataArr['created_date']        = date('Y-m-d H:i:s');
        $addCat = $this->common_model->insertData(CATEGORY,$dataArr);
        $cate['user_category'] = $addCat;
        $cate['user_role'] = $this->input->post('userRoles');
        $this->common_model->updateFields(USERS,$cate,array('id'=>$user_data->id));
        if($this->input->post('que_')){
            $employeeQ = $this->input->post('que_');
            if($this->input->post('userRoles') == 'Employer'){
                $ques = array();  
                foreach($employeeQ as $row){
                    $que['category_id'] = $addCat;
                    $que['question'] = '';
                    $que['user_type'] = 'Employee';
                    $ques[] = $que;
                }
                $this->db->insert_batch(CATEGORY_QUESTIONS, $ques);

                $ques = array();
                foreach($employeeQ as $row){
                    $que['category_id'] = $addCat;
                    $que['question'] = $row;
                    $que['user_type'] = 'Employer';
                    $ques[] = $que;
                }
                $this->db->insert_batch(CATEGORY_QUESTIONS, $ques);

                $que['user_type'] = 'Employer';
                redirect('businessprofile');
            }else{
                $ques = array();
                foreach($employeeQ as $row){
                    $que['category_id'] = $addCat;
                    $que['question'] = $row;
                    $que['user_type'] = 'Employee';
                    $ques[] = $que;
                }
                $this->db->insert_batch(CATEGORY_QUESTIONS, $ques);

                $ques = array();
                foreach($employeeQ as $row){
                    $que['category_id'] = $addCat;
                    $que['question'] = '';
                    $que['user_type'] = 'Employer';
                    $ques[] = $que;
                }
                $this->db->insert_batch(CATEGORY_QUESTIONS, $ques);
                redirect('profile');
            }

        }
        if($addCat){
            $this->session->set_flashdata('updatemsg','
                <div class="alert alert-danger text-center">Oops!.  Plz Set your Role!!!</div>
                ');
            $this->create_category($email);
        }
    }else{
        $this->session->set_flashdata('updatemsg','
            <div class="alert alert-danger text-center">Category already added please try other!!!</div>
            ');
        $this->create_category($email);
    }
}
/*********************************************/
/************** INSERT USERDATA **************/
/*********************************************/
public function insert_userdata(){
    $user_role=$this->input->post('optradio');
    $user_category = $this->input->post('user_category');
    $user_email=$this->input->post('user_email');
    $userdata['user_role'] = $user_role;
    if(isset($user_category) && !empty($user_category)){
        $userdata['user_category'] = $user_category;
    }
    $condition=array('email'=>$user_email);     
    $update =$this->common_model->updateFields('tb_users',$userdata,$condition);
    if($update){        
        $condition=array('email'=>$user_email);                                       
        $user_data = get_where('tb_users',$condition,'row');
        $sess_data = array('id' =>$user_data->id,'userrole' => $user_data->user_role);
        $this->session->set_userdata($sess_data);
        if($user_data->user_role == 'Performer'){
            $this->session->set_userdata('user_login_type','performer');
            $this->session->set_userdata('posts',array());
            redirect('profile');
        }
        else{
            $this->session->set_userdata('posts',array());
            $this->session->set_userdata('user_login_type','employer');
            redirect('businessprofile');
        }
    }            
}
/*********************************************/
/************** FORGOT PASSWORD **************/
/*********************************************/
public function ForgotPassword($id)
{
    $data['user_id'] = $id;
    $this->frontendtemplates('forgetpassword',$data);
}
public function ForgotPasswordProcess(){
    $email = $this->input->post('email');      
    $findemail = $this->User_model->check_email($email);  
    if(!empty($findemail)){
        $user_email = $findemail->email;
        $user_firstname = $findemail->firstname;
        $passwordrandomnumber  = rand(999999999,9999999999);
        $userdata = array(
            'passwordrandom_number' =>  $passwordrandomnumber                   
        ); 
        $condition=array('email'=>$user_email);                                                             
        $update = update_data('tb_users',$userdata,$condition);
        if($update)
        { 
$from = "noreply@workadvisor.co";    //senders email address
$subject = 'Reset your Password';  //email subject
$message = '';
$message .= 'Please click on the below activation link to Reset Your Password<br><br>';
$message .= '<a style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;
color: #ffffff;background: #008000;line-height: 3;padding:15px;" href='. base_url().'User/confirmPasswordLink/'. $passwordrandomnumber .'>Reset Your Password</a>';
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
$mailData['username'] = $user_firstname;
$message = $this->load->view('frontend/mailtemplate',$mailData,true);
$this->email->from($from);
$this->email->to($user_email);
$this->email->subject($subject);
$this->email->message($message);
$this->email->set_header('From', $from);
if($this->email->send()){
    $this->session->set_flashdata('loginmsg','
        <div class="alert alert-success text-center">Please check your email.</div>
        ');
    redirect('login'); 
}else{
    $this->session->set_flashdata('loginmsg','
        <div class="alert alert-danger text-center">Failed to send mail, please try again!</div>
        ');
    redirect('login'); 
}
} 
}else{
    $this->session->set_flashdata('loginmsg','
        <div class="alert alert-danger text-center">Oops!. Email not found!!!!</div>
        ');
    redirect('login');  
}
}
/*********************************************/
/************** CONFIRM PASSWORD **************/
/*********************************************/
public function confirmPasswordLink($randomnumber){
    $condition=array('passwordrandom_number'=>$randomnumber);                                                                                
    $user_data = get_where('tb_users',$condition,'row');
    if(!empty($user_data))
    {
        $this->ForgotPassword($user_data->id);
    }
}
/*********************************************/
/******** UPDATE RESET PASSWORD **************/
/*********************************************/
public function UpdateResetPassword(){
    $user_id = $this->input->post('user_id');
    $newpass = $this->input->post('newpassword');
    $cnewpass = $this->input->post('cnewpassword');
    if($newpass == $cnewpass){   
        $userdata = array(
            'password' => generate_password($this->input->post('cnewpassword')),
            'passwordrandom_number' => ' '
        );
        $condition=array('id'=>$user_id);   
        $update = update_data('tb_users',$userdata,$condition);
        if($update){ 
            $this->session->unset_userdata('id');
            $this->session->sess_destroy();             
            redirect('login');
        }
    }else{
        $this->session->set_flashdata('loginmsg','
            <div class="alert alert-danger text-center">Password is Not Match Plz Try Again!!!</div>
            ');
        redirect('login'); 
    }
}
/****************************************/
public function wallpost2(){
    if($this->checkUserLogin()){
        if(!empty($_FILES['file'])){
            $loggedUserId=get_current_user_id();
            $fileName = $_FILES['file']['name'];
            $dats=explode('.',$fileName);
            $ext=$dats[1];
            $targetDir = FCPATH."uploads/videos/";
            $time = time().'_'.rand(99999,9999999999).'_'.rand(10000,99999);
            $newfilename=$time.'.'."mp4";
            $temp=$time;
            $targetFile = $targetDir.$newfilename;
            if(move_uploaded_file($_FILES['file']['tmp_name'],$targetFile)){
                $dataArr['post_video']=$newfilename;
                $datam=array('lastFileName'=>$newfilename);
                $this->session->set_userdata($datam);
                $loggedUserId=get_current_user_id();
                $user_data = $this->common_model->getsingle(USERS,array('id'=>$loggedUserId));
                if($user_data->user_role == 'Performer'){
                    $workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$loggedUserId,'status'=>1),'id','DESC','all',1);
                    if(!empty($workingAt['result'])){
                        $compId=$workingAt['result'][0]->receiver;
                        $company =$this->common_model->getsingle(USERS,array('id'=>$compId));
                        $dataArr['company']=$company->id;
                    }else{
                        $dataArr['company']=0;
                    }
                }

                $dataArr['post_title']=$_POST['post_title'];
                $dataArr['post_content']=$_POST['post_content'];
                $dataArr['user_id']=$loggedUserId;
                $dataArr['post_status']=0;

                exec("ffmpeg -i ".$targetDir.$temp.".mp4"); 
                $dataArr['post_video'] = $temp.".mp4";
                $addpost = $this->common_model->insertData(POSTS,$dataArr); 
//$postData = $this->common_model->getsingle(POSTS,array('id'=>$addpost));

            }else{
                echo $fileName. " Not Getting";
            }
        }else{
            echo "not";
        }
    }else{
        $ret=array('status'=>'Failed','msg'=>'Something Went Wrong, Try Again');
        echo json_encode($ret); 
    }   
}
public function wallpost3(){
    $dataArr=array();
    $filename=$this->session->userdata('lastFileName');
    $post=$this->input->post('post_content');
    $dataArr['post_content']=$post;
    $addpost = $this->common_model->updateFields(POSTS,$dataArr,array('post_video'=>$filename,'post_video!='=>''));
    if($addpost){
        $arr=array('results'=>1,'msg'=>'posted successfully');
    }else{
        $arr=array('results'=>0,'msg'=>'Video not ready to upload.');
    }
    $datam=array('lastFileName'=>'');
    $this->session->set_userdata($datam);
    $this->session->unset_userdata($datam);
    echo json_encode($arr);
}
/*******************/
/****************************************/
/****************************************/
public function wallpost(){
    if($this->checkUserLogin()){
        //if(isset($_POST['post_content'])){
            $allimg=array();
            if(isset($_FILES['post_image'])){
                $filesCount = count($_FILES['post_image']['name']);
                if($filesCount>0){
                    for($i = 0; $i < $filesCount; $i++){
                        $_FILES['docfile']['name'] = $_FILES['post_image']['name'][$i];
                        $_FILES['docfile']['type'] = $_FILES['post_image']['type'][$i];
                        $_FILES['docfile']['tmp_name'] = $_FILES['post_image']['tmp_name'][$i];
                        $_FILES['docfile']['error'] = $_FILES['post_image']['error'][$i];
                        $_FILES['docfile']['size'] = $_FILES['post_image']['size'][$i];
                        $config['upload_path'] = 'uploads/posts/';
                        $config['allowed_types'] = 'jpg|jpeg|gif|png';
                        $path=$config['upload_path'];
                        $config['overwrite'] = '1';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ( !$this->upload->do_upload("docfile"))
                        {
                            echo "error";
                            $error = array('error' => $this->upload->display_errors());
                            print_r($error);
                            die;
                        }
                        else
                        {
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
                            $filename = $_FILES['docfile']['tmp_name'];


                            $imgdata=@exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');


                            list($width, $height) = getimagesize($filename);
                            if ($width >= $height){
                                $config['width'] = 800;
                            }
                            else{
                                $config['height'] = 800;
                            }
                            $config['master_dim'] = 'auto';


                            $this->load->library('image_lib',$config); 

                            if (!$this->image_lib->resize()){  
                                echo "error";
                            }else{

                                $this->image_lib->clear();
                                $config=array();

                                $config['image_library'] = 'gd2';
                                $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;

                                if(isset($imgdata['Orientation'])){
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

                                    $this->image_lib->initialize($config); 
                                    $this->image_lib->rotate();
                                }
                            }
                        }   
                        $allimg[]=base_url().'uploads/posts/'.$this->upload->file_name;     
                    }
                    $dataArr['post_image']=implode(',',$allimg);
                }
            }

            $loggedUserId=get_current_user_id();
            $user_data = $this->common_model->getsingle(USERS,array('id'=>$loggedUserId));
            if($user_data->user_role == 'Performer'){
                $workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$loggedUserId,'status'=>1),'id','DESC','all',1);
                if(!empty($workingAt['result'])){
                    $compId=$workingAt['result'][0]->receiver;
                    $company =$this->common_model->getsingle(USERS,array('id'=>$compId));
                    $dataArr['company']=$company->id;
                }else{
                    $dataArr['company']=0;
                }
            }

            $dataArr['post_title']=$_POST['post_title'];
            $dataArr['post_content']=$_POST['post_content'];
            $dataArr['user_id']=$loggedUserId;
            $dataArr['post_status']=0;

            $addpost = $this->common_model->insertData(POSTS,$dataArr); 




            $postData = $this->common_model->getsingle(POSTS,array('id'=>$addpost));
            if($addpost){
                $postimg="";  
                if(isset($_POST['post_images']) && $_POST['post_images']!=""){   
                    $imgsert=$_POST['post_images'];
//$postimgarr=explode(',',$imgsert);
                    if(count($imgsert)>1){ 
                        $postimg.='
                        <div class="row">
                        ';
                        foreach($imgsert as $postim){
                            $postimg.='
                            <div class ="col-sm-4 col-md-4"><a href="#" class="thumbnail"><img src="'.$postim.'" alt="Post Image"></a></div>
                            ';
                        }
                        $postimg.="
                        </div>
                        ";
                    }else{
                        $postimg='
                        <div class="over_viewimg">
                        <img src="'.$imgsert[0].'" class="img-fluid">
                        <div class="bl-box"><img src="'.base_url().'assets/images/scrl.png"></div>
                        </div>
                        ';
                    }
                }  
                $html='
                <div class="main_blog">
                <div class="over_viewimg">
                '.$postimg.'
                </div>
                <div class="contant_overviw esdu" onclick="setID('.$postData->id.');">
                <h1>'. date('d-m-Y H:i A').'</h1>
                <div class="btnns">
                <div class="form-group">
                <a href="#" class="linke"><img src="'.base_url().'assets/images/like.png">
                <i class="fa fa-thumbs-up"></i>
                </a>
                </div>
                <a href="" class="editss" data-toggle="modal" data-target="#myModal2" onclick="editPost('.$postData->id.')"><img src="'.base_url().'assets/images/edit.png"></a>
                <a href="" class="editss" data-toggle="modal" data-target="#modalDelete"><i class="fa fa fa-trash-o"></i></a>
                </div>
                <p>'.$dataArr['post_content'].'</p>
                </div>
                </div>
                ';
                $ret=array('status'=>'successful_post','msg'=>$html);  
            }else{
                $ret=array('status'=>'Failed','msg'=>'Something Went Wrong, Try Again');
            }    
        // }else{
        //  $ret=array('status'=>'Failed','msg'=>'Something Went Wrong, Try Again');
        // }
        $ret=array('status'=>'successful_post');
        echo json_encode($ret); 
    }else{
        $ret=array('status'=>'Failed','msg'=>'Something Went Wrong, Try Again');
        echo json_encode($ret);             
    }
}   
/********************-Add friend-********************/
function addfriend(){
    if($_POST['userid']){
        if($this->checkUserLogin()){
            $user_id=$_POST['userid'];  
            $userid=decoding($user_id);
            $sender=get_current_user_id();
            $condition="(`user_one_id` ='$sender' AND `user_two_id` = '$userid') OR (`user_one_id` = '$userid' AND `user_two_id` = '$sender')";
            $checkFriend = $this->common_model->getsingle(FRIENDS,$condition);
            if(!empty($checkFriend)){
                $req_status=$checkFriend->status;
                if($req_status==0){
                    if($checkFriend->user_one_id==$sender){
                        $ret=array('status'=>0,'msg'=>'Request already Sent');
                        echo json_encode($ret);
                        exit;
                    }else{
                        $ret=array('status'=>0,'msg'=>'Request Pending');
                        echo json_encode($ret);
                        exit;
                    } 
                }else{
                    $ret=array('status'=>0,'msg'=>'already friend'); 
                    echo json_encode($ret);
                    exit;
                }
            }else{
                $dataInsert=array('user_one_id'=>$sender,'user_two_id'=>$userid,'status'=>0,'action_user_id'=>$sender,'sent_date'=>date('Y-m-d H:i:s'));
                $ins=$this->common_model->insertData(FRIENDS, $dataInsert);
                $notiF = array();
                $notiF['sender'] = $sender;
                $notiF['receiver'] = $userid;
                $notiF['msg'] = "friend_request_received";
                $this->common_model->insertData('notifications',$notiF);
                if($ins){
                    $ret=array('status'=>1,'msg'=>'Request Sent');
                    echo json_encode($ret);
                    exit;
                }else{
                    $ret=array('status'=>0,'msg'=>'Login first');
                    echo json_encode($ret);
                    exit;
                }
            }   
        }else{
            $ret=array('status'=>0,'msg'=>'Login first');
            echo json_encode($ret);
        }
    }
}
/*************************FRIEND***REQUEST***********/
function requestStatus(){
    if($_POST['userid']){
        if($this->checkUserLogin()){
            $user_id=$_POST['userid'];
            $status=$_POST['status'];
            $userid=decoding($user_id);
            $cuid=get_current_user_id();
            if($status=='Accept'){
                $mstatus=1;
            }else if($status=='Reject'){
                $mstatus=2;
            }else{
                $mstatus=3;
            }
            $updtData=array('status'=>$mstatus,'action_user_id'=>$cuid,'accept_date'=>date('Y-m-d H:i:s'));
            $where=array('user_one_id'=>$userid,'user_two_id'=>$cuid);

            if($mstatus == 1 || $mstatus == 3){
                $updt=$this->common_model->updateFields(FRIENDS, $updtData, $where);
                $notiF = array();
                $notiF['sender'] = $cuid;
                $notiF['receiver'] = $userid;
                $notiF['msg'] = "friend_request_accepted";
                $this->common_model->insertData('notifications',$notiF);
                if($updt){
                    $ret=array('status'=>1,'msg'=>'Accepted');
                    echo json_encode($ret);
                    exit;
                }else{
                    $ret=array('status'=>0,'msg'=>'Something Went Wrong');
                    echo json_encode($ret); 
                    exit;
                }
            }
            else{
                $this->common_model->deleteData(FRIENDS,$where);
                $ret=array('status'=>1,'msg'=>'Accepted');
                echo json_encode($ret);
                exit;
            }


// if($updt){
//  $ret=array('status'=>1,'msg'=>'Accepted');
//  echo json_encode($ret);
//  $this->common_model->deleteData(FRIENDS,$where);
//  exit;
// }else{
//  $ret=array('status'=>0,'msg'=>'Something Went Wrong');
//  echo json_encode($ret); 
//  exit;
// }    
        }else{
            $ret=array('status'=>0,'msg'=>'Login first');
            echo json_encode($ret);
            exit;
        }
    }
}
/*****************************SEND-JOB-REQUEST****************************/ 
function sendjobrequest(){
    if($_POST['userid']){
        if($this->checkUserLogin()){
            $user_id=$_POST['userid'];  
            $userid=decoding($user_id);
            $sender=get_current_user_id();
            $condition="(`sender` ='$sender' AND `receiver` = '$userid') OR (`sender` = '$userid' AND `receiver` = '$sender')";
            $checkRequests = $this->common_model->getsingle(REQUESTS,$condition);
            if(!empty($checkRequests)){
                $req_status=$checkRequests->status;
                if($req_status==0){
                    if($checkRequests->sender==$sender){
                        $ret=array('status'=>0,'msg'=>'Request already Sent');
                        echo json_encode($ret);
                        exit;
                    }else{
                        $ret=array('status'=>0,'msg'=>'Request Pending');
                        echo json_encode($ret);
                        exit;
                    } 
                }else{
                    $ret=array('status'=>0,'msg'=>'already friend'); 
                    echo json_encode($ret);
                    exit;
                }
            }else{
                if($this->input->post('emp')!='false'){
                    $dataInsert=array('sender'=>$userid,'receiver'=>$sender,'status'=>0,'action_user_id'=>$sender,'sent_date'=>date('Y-m-d H:i:s'),'accept_status_notify_business_sent'=>1,'job_requested_by'=>$sender);
                    $notiF = array();
                    $notiF['sender'] = $sender;
                    $notiF['receiver'] = $userid;
                    $notiF['msg'] = "Job_req_by_employer";
                    $this->common_model->insertData('notifications',$notiF);
                }else{
                    $dataInsert=array('sender'=>$sender,'receiver'=>$userid,'status'=>0,'action_user_id'=>$sender,'sent_date'=>date('Y-m-d H:i:s'),'job_requested_by'=>$sender,'accept_status_notify'=>1);
                    $notiF = array();
                    $notiF['sender'] = $sender;
                    $notiF['receiver'] = $userid;
                    $notiF['msg'] = "Job_req_by_performer";
                    $this->common_model->insertData('notifications',$notiF);
                }
                $ins=$this->common_model->insertData(REQUESTS, $dataInsert);
                if($ins){
                    $ret=array('status'=>1,'msg'=>'Request Sent');
                    echo json_encode($ret);
                    exit;
                }else{
                    $ret=array('status'=>0,'msg'=>'Login first');
                    echo json_encode($ret);
                    exit;
                }
            }   
        }else{
            $ret=array('status'=>0,'msg'=>'Login first');
            echo json_encode($ret);
        }
    }
}

function jobrequeststatus(){
    if($_POST['userid']){
        if($this->checkUserLogin()){
            $user_id=$_POST['userid'];
            $status=$_POST['status'];
            $userid=decoding($user_id);
            $cuid=get_current_user_id();
            if($status=='Accept'){
                $mstatus=1;
            }else if($status=='Reject' || $status=='Unfriend' || $status=='Block'){
                $mstatus=2;
            }else{
                $mstatus=3;
            }
            if($this->input->post('per')!='false'){
                $updtData=array('status'=>$mstatus,'action_user_id'=>$cuid,'accept_date'=>date('Y-m-d H:i:s'),'confirmed_business'=>1);
            }else{
                $updtData=array('status'=>$mstatus,'action_user_id'=>$cuid,'accept_date'=>date('Y-m-d H:i:s'),'confirmed'=>1);
            }
            if($this->input->post('per')!='false'){
                $where=array('sender'=>$cuid,'receiver'=>$userid);
                $notiF = array();
                $notiF['sender'] = $cuid;
                $notiF['receiver'] = $userid;
                $notiF['msg'] = "Job_accepted_by_performer";
                $this->common_model->insertData('notifications',$notiF);
            }else{
                $where=array('sender'=>$userid,'receiver'=>$cuid);
                $notiF = array();
                $notiF['sender'] = $cuid;
                $notiF['receiver'] = $userid;
                $notiF['msg'] = "Job_accepted_by_employer";
                $this->common_model->insertData('notifications',$notiF);
            }

            if($mstatus == 1 || $mstatus == 3){
                $updt=$this->common_model->updateFields(REQUESTS, $updtData, $where);
                //lq();
                if($updt){
                    $ret=array('status'=>1,'msg'=>'Accepted');
                    echo json_encode($ret);
                    exit;
                }else{
                    $ret=array('status'=>0,'msg'=>'Something Went Wrong');
                    echo json_encode($ret); 
                    exit;
                }
            }
            else{
                $this->common_model->deleteData(REQUESTS,$where);
                $ret=array('status'=>1,'msg'=>'Accepted');
                echo json_encode($ret);
                exit;
            }

        }else{
            $ret=array('status'=>0,'msg'=>'Login first');
            echo json_encode($ret);
            exit;
        }
    }
}
/****************************Send-Message********************************/  
public function sendmessage(){
    if($_POST['userid']){
        if($this->checkUserLogin()){
            $sender=get_current_user_id();
            $receiver=decoding($_POST['userid']);
            $message=$_POST['message'];
            $user_data = $this->common_model->getsingle(USERS,array('id'=>$sender));
            // $dataInsert=array('sender'=>$sender,'receiver'=>$receiver,'status'=>0,'message'=>$message,'message_date'=>date('Y-m-d H:i:s'),'notify'=>0);
            $dataInsert['sender'] = $sender;
            $dataInsert['receiver'] = $receiver;
            $dataInsert['status'] = 0;
            $dataInsert['message'] = $message;
            $dataInsert['message_date'] = date('Y-m-d H:i:s');
            $dataInsert['notify'] = 0;
            if($this->input->post('group') == 'group'){
                $dataInsert['is_group'] = 1;
                //$groupMembers = $this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$receiver));
                $this->common_model->updateFields(MESSAGE_GROUP,array('message_date'=>$dataInsert['message_date']),array('id'=>$receiver));
                //$dataInsert['receiver'] = $groupMembers->group_members;
                $dataInsert['group_id'] = $receiver;
            }
            $dataInsert['new_msg_read_by'] = get_current_user_id();
            $ins=$this->common_model->insertData('messages',$dataInsert);
            $notiF = array();
            $notiF['sender'] = $sender;
            $notiF['msg'] = "MSG";
            if($this->input->post('group') == 'group'){
                $groupMembers = $this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$receiver));
                if(!empty($groupMembers->group_members)){
                    $members = explode(',',$groupMembers->group_members);
                    foreach($members as $row){
                        if($sender!=$row){
                            $notiF['receiver'] = $row;
                            $notiF['is_group'] = 1;
                            $notiF['group_id'] = $receiver;
                            $this->common_model->insertData('notifications',$notiF);
                        }
                    }
                }
            }else{
                $notiF['receiver'] = $receiver;
                if($this->input->post('group') != 'group'){
                    $this->common_model->insertData('notifications',$notiF);
                }
            }

            if($ins){
                $uimg=(!empty($user_data->profile)) ? $user_data->profile:DEFAULT_IMAGE;
                if(!empty($user_data->business_name))
                {
                    $user_name =  $user_data->business_name;
                }
                else
                {
                    $user_name = $user_data->firstname.' '.$user_data->lastname;
                }
                $html='
                <div class="fil_ds wid_ri">
                <div class="pro_img"><img src="'.$uimg.'" alt="'.strtoupper(substr($user_data->firstname,0,1)).'" style="width: 40px;border-radius: 20px;"></div>
                <div class="msg_bx bg_chng">
                <b>'.ucwords($user_name).'</b>
                <pre>'.$message.'</pre></div>
                <span class="date">'.date('M-d-Y h:i A',strtotime(date('Y-m-d H:i:s'))).'</span>
                </div>
                ';
                $ret=array('status'=>'success','msg'=>$html);
                echo json_encode($ret);
                exit;
            }else{
                $ret=array('status'=>'Failed','msg'=>'Something Went Wrong');
                echo json_encode($ret); 
                exit;
            }
        }else{
            $message_link = base_url().'viewdetails/profile/'.($_POST['userid']);
            $this->session->set_userdata('message_link',$message_link."?msg=1");
            $ret=array('status'=>'Failed','msg'=>'Login first');
            echo json_encode($ret);
            exit;   
        }
    }else{
        $ret=array('status'=>'Failed','msg'=>'<div class="alert alert-danger">Not Allowed</div>');
        echo json_encode($ret);
        exit;
    }
}
/**************************************************************/
// public function message(){
//     $contactList = array();
//     $messages = array();
//     if($this->checkUserLogin()){
//         $firstGroupChat = 0;
//         $user_id=get_current_user_id();
//         $customQuery="SELECT * FROM (SELECT * FROM `".MESSAGES."` ORDER BY `message_date` DESC) `temp` INNER JOIN `".USERS."` ON `".USERS."`.`id`=`temp`.`sender` OR `".USERS."`.`id`=`temp`.`receiver` WHERE (`temp`.`sender` = '".$user_id."' OR `temp`.`receiver` = '".$user_id."') AND `tb_users`.`id` != '".$user_id."' AND NOT find_in_set($user_id,temp.deleted_by) AND is_group!=1 GROUP BY `tb_users`.`id` ORDER BY temp.id DESC";
//         $messageUsers1 = $this->common_model->custom_query($customQuery);

//         $messageUsers = array();
//         if(!empty($messageUsers1)){
//             $count = 0;
//             foreach($messageUsers1 as $row){
//                 $users = new stdClass();
//                 $users->id = $row['id'];
//                 $where = ' NOT find_in_set('.get_current_user_id().',new_msg_read_by) and receiver='.get_current_user_id().' and sender='.$row['id'];
//                 $messageCount = $this->common_model->getAllwhere(MESSAGES, $where,'', '','count(id) as count');
//                 $users->msg_count = isset($messageCount['result'][0]->count)?$messageCount['result'][0]->count:0;
//                 $users->profile = $row['profile'];
//                 $users->business_name = $row['business_name'];
//                 $users->firstname = $row['firstname'];
//                 $users->lastname = $row['lastname'];
//                 $users->message_date = $row['message_date'];
//                 $users->group = 1;
//                 $messageUsers[] = $users;
                
//             }
//         }
//         $where = ' find_in_set('.get_current_user_id().',group_members) !=0';
//         $groupNames = $this->common_model->getAllwhere(MESSAGE_GROUP,$where,'created_date','desc', 'message_date as message_date,message_group.name as business_name,message_group.group_icon as profile,message_group.*');

//         if(!empty($groupNames['result']) && !empty($messageUsers)){
//             $contactNames = array_merge($messageUsers,$groupNames['result']);
//         }else if(!empty($groupNames['result'])){
//             $contactNames = $groupNames['result'];
//         }else if(!empty($messageUsers)){
//             $contactNames = $messageUsers;
//         }
//         if(!empty($contactNames)){
//             $contactList = array_multi_subsort($contactNames,'message_date');
//             $data['other_user'] = isset($contactList[0]->id)?$contactList[0]->id:'';
//         }

//         if(!empty($contactList)){
//             foreach ($contactList as $key=>$row) {
//                 if(isset($row->owner_id)){
//                     $groupMembers = explode(",",$row->group_members);
//                     if(in_array(get_current_user_id(),$groupMembers)){
//                         $where = ' NOT find_in_set('.get_current_user_id().',new_msg_read_by) and is_group=1 and receiver='.$row->id;
//                         $messageCount = $this->common_model->getAllwhere(MESSAGES, $where,'', '','count(id) as count');
//                         $contactList[$key]->msg_count = isset($messageCount['result'][0]->count)?$messageCount['result'][0]->count:0;
//                     }
//                 }
//             }
//         }
//         $message_to = 0;
//         $data['allFriends']=$contactList;
//         $singleUser= array();
//         if(!empty($contactList)){
//             $is_group = isset($contactList[0]->owner_id)?$contactList[0]->owner_id:'no_group';
//             if($is_group!='no_group'){
//                 $firstGroupChat = 1;
//                 $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0";
//                 $singleUser=$this->common_model->GetJoinRecord(MESSAGES,'group_id',MESSAGE_GROUP,'id','messages.id as msg_id,messages.*,message_group.*',$where);
//             }else{
//                 $singleUser=$this->common_model->getsingle(MESSAGES,"(receiver='$user_id' OR sender='$user_id') ORDER BY id DESC");
//             }
//             $data['group'] = $is_group;
//         }

//         $data['conversation']=array('result'=>array());
//         if(!empty($singleUser)){

//             if($firstGroupChat == 0){
//                 if($singleUser->sender!=$user_id){
//                     $id=$singleUser->sender;
//                 }else{
//                     $id=$singleUser->receiver;  
//                 }
//                 $where = array('sender'=>$id,'receiver'=>$user_id);
//                 $updtData = array('accept_status_notify'=>2);
//                 $this->common_model->updateFields(MESSAGES, $updtData, $where);
//             }


//             if($firstGroupChat == 1){
//                 $firstUser = isset($contactList[0]->id)?$contactList[0]->id:'';
//                 $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0 and message_group.id='$firstUser'";

//                 $conversation = $this->common_model->GetJoinRecordThree(MESSAGES,'sender',USERS,'id',MESSAGE_GROUP,'id',MESSAGES,'group_id','messages.id as msg_id,messages.*,message_group.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$where,"",'messages.id','DESC',7,0);
//                 $data['group'] = 1;
//                 $data['conversation'] = $conversation;

//                 $where1 = " NOT find_in_set(".get_current_user_id().",messages.new_msg_read_by) and find_in_set(".get_current_user_id().",message_group.group_members) !=0 and message_group.id='$firstUser'";
//                 $updateConversationStatus = $this->common_model->GetJoinRecordThree(MESSAGES,'sender',USERS,'id',MESSAGE_GROUP,'id',MESSAGES,'group_id','messages.id as msg_id,messages.*,message_group.*,tb_users.firstname,tb_users.lastname,tb_users.profile',$where1,"",'messages.id','DESC',7,0);
//             }else{
//                 $con=" ((sender='$user_id' AND receiver='$id') OR (sender='$id' AND receiver='$user_id')) AND NOT find_in_set($user_id,deleted_by)";
//                 $conversation = $this->common_model->GetJoinRecord(MESSAGES,'sender',USERS,'id','messages.id as msg_id,messages.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$con,'','messages.id','DESC',7,0);
//                 $data['conversation'] = $conversation;
//                 $data['group'] = 0;

//                 $where1 = " NOT find_in_set(".get_current_user_id().",messages.new_msg_read_by) and receiver=".get_current_user_id();
//                 $updateConversationStatus = $this->common_model->getAllwhere(MESSAGES,$where1,'','','messages.*,messages.id as msg_id',7,0);
//             }

//             if(!empty($updateConversationStatus['result'])){
//                 $cdata = $updateConversationStatus['result'];
//                 foreach($cdata as $row){
//                     $new_msg_read_by = $row->new_msg_read_by;
//                     if(!empty($new_msg_read_by)){
//                         $new_msg_read_by1 = explode(',',$new_msg_read_by);
//                         $new_msg_read_by1[] = get_current_user_id();
//                         $new_msg_read = implode(',',$new_msg_read_by1);
//                         $this->common_model->updateFields(MESSAGES,array('new_msg_read_by'=>$new_msg_read),array('id'=>$row->msg_id));
//                     }
//                 }
//             }
//         }else{
//         }


//         $this->session->set_userdata('messages',$messages);
//         $count = 0;
//         $contactsData = array();
//         $con="(user_one_id='$user_id'  OR user_two_id='$user_id')";
//         $contactData = $this->common_model->getAllwhere(FRIENDS,$con);
//         if(!empty($contactData['result'])){
//             foreach ($contactData['result'] as $friend) {
//                 $user = 0;
//                 if($friend->user_one_id != $user_id){
//                     $user = $friend->user_one_id; 
//                 }else if($friend->user_two_id != $user_id){
//                     $user = $friend->user_two_id; 
//                 }
//                 $username = $this->common_model->getsingle(USERS,array('id'=>$user));
//                 if(!empty($username)){
//                     $contactsData[$count]['id'] = isset($username->id)?$username->id:'';
//                     if($username->business_name == '' && ($username->firstname || $username->lastname )){
//                         $contactsData[$count]['name'] = $username->firstname." ".$username->lastname;
//                     }
//                     else{
//                         $contactsData[$count]['name'] = isset($username->business_name)?$username->business_name:'';
//                     }
//                     $count++;
//                 }
//             }
//         }

//         $con="(sender='$user_id'  OR receiver='$user_id')";
//         $contactData = $this->common_model->getAllwhere(REQUESTS,$con);
//         if(!empty($contactData['result'])){
//             foreach ($contactData['result'] as $requests) {
//                 $user = 0;
//                 if($requests->sender != $user_id){
//                     $user = $requests->sender; 
//                 }else if($requests->receiver != $user_id){
//                     $user = $requests->receiver; 
//                 }
//                 $username = $this->common_model->getsingle(USERS,array('id'=>$user));
                
//                 if(!empty($username)){
//                     $contactsData[$count]['id'] = $username->id;
//                     if( $username->business_name == '')
//                         $contactsData[$count]['name'] = $username->firstname." ".$username->lastname;
//                     else
//                         $contactsData[$count]['name'] = $username->business_name;
//                     $count++;
//                 }
//             }
//         }
//         //$data['other_user'] = $id;
//         $data['contactsData'] = $contactsData;
        
//         $this->pageview('message',$data,$data,array()); 
//     }else{
//         redirect(base_url('login'));    
//     }
// }
public function message(){
    $contactList = array();
    $messages = array();
    if($this->checkUserLogin()){
        $firstGroupChat = 0;
        $user_id=get_current_user_id();
        $customQuery="SELECT * FROM (SELECT * FROM `".MESSAGES."` ORDER BY `message_date` DESC) `temp` INNER JOIN `".USERS."` ON `".USERS."`.`id`=`temp`.`sender` OR `".USERS."`.`id`=`temp`.`receiver` WHERE (`temp`.`sender` = '".$user_id."' OR `temp`.`receiver` = '".$user_id."') AND `tb_users`.`id` != '".$user_id."' AND NOT find_in_set($user_id,temp.deleted_by) AND is_group!=1 GROUP BY `tb_users`.`id` ORDER BY temp.id DESC";
        $messageUsers1 = $this->common_model->custom_query($customQuery);

        $messageUsers = array();
        if(!empty($messageUsers1)){
            $count = 0;
            foreach($messageUsers1 as $row){
                $users = new stdClass();
                $users->id = $row['id'];
                $where = ' NOT find_in_set('.get_current_user_id().',new_msg_read_by) and receiver='.get_current_user_id().' and sender='.$row['id'];
                $messageCount = $this->common_model->getAllwhere(MESSAGES, $where,'', '','count(id) as count');
                $users->msg_count = isset($messageCount['result'][0]->count)?$messageCount['result'][0]->count:0;
                $users->profile = $row['profile'];
                $users->business_name = $row['business_name'];
                $users->firstname = $row['firstname'];
                $users->lastname = $row['lastname'];
                $users->message_date = $row['message_date'];
                $users->login_status = $row['login_status'];
                $users->group = 1;
                $messageUsers[] = $users;
                
            }
        }
        $where = ' find_in_set('.get_current_user_id().',group_members) !=0';
        $groupNames = $this->common_model->getAllwhere(MESSAGE_GROUP,$where,'created_date','desc', 'message_date as message_date,message_group.name as business_name,message_group.group_icon as profile,message_group.*');

        if(!empty($groupNames['result']) && !empty($messageUsers)){
            $contactNames = array_merge($messageUsers,$groupNames['result']);
        }else if(!empty($groupNames['result'])){
            $contactNames = $groupNames['result'];
        }else if(!empty($messageUsers)){
            $contactNames = $messageUsers;
        }
        if(!empty($contactNames)){
            $contactList = array_multi_subsort($contactNames,'message_date');
            $data['other_user'] = isset($contactList[0]->id)?$contactList[0]->id:'';
        }

        if(!empty($contactList)){
            foreach ($contactList as $key=>$row) {
                if(isset($row->owner_id)){
                    $groupMembers = explode(",",$row->group_members);
                    if(in_array(get_current_user_id(),$groupMembers)){
                        $where = ' NOT find_in_set('.get_current_user_id().',new_msg_read_by) and is_group=1 and receiver='.$row->id;
                        $messageCount = $this->common_model->getAllwhere(MESSAGES, $where,'', '','count(id) as count');
                        $contactList[$key]->msg_count = isset($messageCount['result'][0]->count)?$messageCount['result'][0]->count:0;
                        $contactList[$key]->login_status = 0;
                    }
                }
            }
        }
        $message_to = 0;
        $data['allFriends']=$contactList;
        $singleUser= array();
        if(!empty($contactList)){
            $is_group = isset($contactList[0]->owner_id)?$contactList[0]->owner_id:'no_group';
            if($is_group!='no_group'){
                $firstGroupChat = 1;
                $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0";
                $singleUser=$this->common_model->GetJoinRecord(MESSAGES,'group_id',MESSAGE_GROUP,'id','messages.id as msg_id,messages.*,message_group.*',$where);
            }else{
                $singleUser=$this->common_model->getsingle(MESSAGES,"(receiver='$user_id' OR sender='$user_id') ORDER BY id DESC");
            }
            $data['group'] = $is_group;
        }

        $data['conversation']=array('result'=>array());
        if(!empty($singleUser)){

            if($firstGroupChat == 0){
                if($singleUser->sender!=$user_id){
                    $id=$singleUser->sender;
                }else{
                    $id=$singleUser->receiver;  
                }
                $where = array('sender'=>$id,'receiver'=>$user_id);
                $updtData = array('accept_status_notify'=>2);
                $this->common_model->updateFields(MESSAGES, $updtData, $where);
            }


            if($firstGroupChat == 1){
                $firstUser = isset($contactList[0]->id)?$contactList[0]->id:'';
                $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0 and message_group.id='$firstUser'";

                $conversation = $this->common_model->GetJoinRecordThree(MESSAGES,'sender',USERS,'id',MESSAGE_GROUP,'id',MESSAGES,'group_id','messages.id as msg_id,messages.*,message_group.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$where,"",'messages.id','DESC',7,0);
                $data['group'] = 1;
                $data['conversation'] = $conversation;

                $where1 = " NOT find_in_set(".get_current_user_id().",messages.new_msg_read_by) and find_in_set(".get_current_user_id().",message_group.group_members) !=0 and message_group.id='$firstUser'";
                $updateConversationStatus = $this->common_model->GetJoinRecordThree(MESSAGES,'sender',USERS,'id',MESSAGE_GROUP,'id',MESSAGES,'group_id','messages.id as msg_id,messages.*,message_group.*,tb_users.firstname,tb_users.lastname,tb_users.profile',$where1,"",'messages.id','DESC',7,0);
            }else{
                $con=" ((sender='$user_id' AND receiver='$id') OR (sender='$id' AND receiver='$user_id')) AND NOT find_in_set($user_id,deleted_by)";
                $conversation = $this->common_model->GetJoinRecord(MESSAGES,'sender',USERS,'id','messages.id as msg_id,messages.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$con,'','messages.id','DESC',7,0);
                $data['conversation'] = $conversation;
                $data['group'] = 0;

                $where1 = " NOT find_in_set(".get_current_user_id().",messages.new_msg_read_by) and receiver=".get_current_user_id();
                $updateConversationStatus = $this->common_model->getAllwhere(MESSAGES,$where1,'','','messages.*,messages.id as msg_id',7,0);
            }

            if(!empty($updateConversationStatus['result'])){
                $cdata = $updateConversationStatus['result'];
                foreach($cdata as $row){
                    $new_msg_read_by = $row->new_msg_read_by;
                    if(!empty($new_msg_read_by)){
                        $new_msg_read_by1 = explode(',',$new_msg_read_by);
                        $new_msg_read_by1[] = get_current_user_id();
                        $new_msg_read = implode(',',$new_msg_read_by1);
                        $this->common_model->updateFields(MESSAGES,array('new_msg_read_by'=>$new_msg_read),array('id'=>$row->msg_id));
                    }
                }
            }
        }else{
        }


        $this->session->set_userdata('messages',$messages);
        $count = 0;
        $contactsData = array();
        $con="(user_one_id='$user_id'  OR user_two_id='$user_id')";
        $contactData = $this->common_model->getAllwhere(FRIENDS,$con);
        if(!empty($contactData['result'])){
            foreach ($contactData['result'] as $friend) {
                $user = 0;
                if($friend->user_one_id != $user_id){
                    $user = $friend->user_one_id; 
                }else if($friend->user_two_id != $user_id){
                    $user = $friend->user_two_id; 
                }
                $username = $this->common_model->getsingle(USERS,array('id'=>$user));
                if(!empty($username)){
                    $contactsData[$count]['id'] = isset($username->id)?$username->id:'';
                    if($username->business_name == '' && ($username->firstname || $username->lastname )){
                        $contactsData[$count]['name'] = $username->firstname." ".$username->lastname;
                    }
                    else{
                        $contactsData[$count]['name'] = isset($username->business_name)?$username->business_name:'';
                    }
                    $count++;
                }
            }
        }

        $con="(sender='$user_id'  OR receiver='$user_id')";
        $contactData = $this->common_model->getAllwhere(REQUESTS,$con);
        if(!empty($contactData['result'])){
            foreach ($contactData['result'] as $requests) {
                $user = 0;
                if($requests->sender != $user_id){
                    $user = $requests->sender; 
                }else if($requests->receiver != $user_id){
                    $user = $requests->receiver; 
                }
                $username = $this->common_model->getsingle(USERS,array('id'=>$user));
                
                if(!empty($username)){
                    $contactsData[$count]['id'] = $username->id;
                    if( $username->business_name == '')
                        $contactsData[$count]['name'] = $username->firstname." ".$username->lastname;
                    else
                        $contactsData[$count]['name'] = $username->business_name;
                    $count++;
                }
            }
        }
        //$data['other_user'] = $id;
        $data['contactsData'] = $contactsData;
        
        $this->pageview('message',$data,$data,array()); 
    }else{
        redirect(base_url('login'));    
    }
}


//function for creating group
public function create_group(){
    if($this->input->post()){
        $insertData['name'] = $this->input->post('group_name');
        $members = $this->input->post('group_members');
        $members[] = get_current_user_id();
        $insertData['group_members'] = implode(",",$members);
        $insertData['owner_id'] = get_current_user_id();
        $insertData['created_date'] = date('Y-m-d H:i:s');
        $insertData['message_date'] = $insertData['created_date'];
        if(isset($_FILES['group_profile']['name']) && !empty($_FILES['group_profile']['name'])){

            $config['upload_path'] = 'uploads/users/';
            $config['allowed_types'] = 'jpg|jpeg|gif|png';
            $config['max_size'] = '6048';
            $this->load->library('upload', $config);
//check if a file is being uploaded
            if(strlen($_FILES["group_profile"]["name"])>0){
                if ( !$this->upload->do_upload("group_profile"))
                {
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);
                }
                else
                {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
                    $filename = $_FILES['group_profile']['tmp_name'];


                    $imgdata=@exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');


                    list($width, $height) = getimagesize($filename);
                    if ($width >= $height){
                        $config['width'] = 800;
                    }
                    else{
                        $config['height'] = 800;
                    }
                    $config['master_dim'] = 'auto';
                    $config['maintain_ratio'] = TRUE;

                    $this->load->library('image_lib',$config); 

                    if (!$this->image_lib->resize()){  
                        echo "error";
                    }else{

                        $this->image_lib->clear();
                        $config=array();

                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;

                        if(isset($imgdata['Orientation'])){
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

                            $this->image_lib->initialize($config); 
                            $this->image_lib->rotate();
                        }
                    }
                }      
            }  
        }
        if(isset($this->upload->file_name) && $this->upload->file_name){
            $insertData['group_icon']    =  base_url().'uploads/users/'.$this->upload->file_name;
        }else{
            $insertData['group_icon']    = base_url().DEFAULT_IMAGE;
        }
        if($this->input->post('g_id')){
            $update = $this->common_model->updateFields(MESSAGE_GROUP,$insertData,array('id'=>$this->input->post('g_id')));
        }else{
            $this->common_model->insertData(MESSAGE_GROUP,$insertData);
        }
        redirect('user/message');
    }

}

/**********************************************/
/******************#HISTORY#*******************/
/**********************************************/
public function history(){
    if($this->checkUserLogin()){
        $user_id=get_current_user_id();
//rating by company
        $this->session->set_userdata('rated_to_',$user_id);
        $condition=array('id'=>$user_id);                                   
//code for showing top user data 
        $workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$user_id,'status'=>1),'id','DESC','all',1);

        if(!empty($workingAt['result'])){
            $compId=$workingAt['result'][0]->receiver;
            $data['workingAt'] = get_where('tb_users',array('id'=>$compId),'row');
        }else{
            $data['workingAt']=array();
        }

        $data['ratingsData'] = userOverallRatings($user_id);
        $data['ratingDetails'] = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id));
//performance calculation
        $percentarray = array();
        if(!empty($data['ratingDetails']['result'])){
            $percent_cnt1 = 0;
            $percent_cnt2 = 0;
            $percent_cnt3 = 0;
            $percent_cnt4 = 0;
            $percent_cnt5 = 0;

            foreach($data['ratingDetails']['result'] as $row){
                $average = 0;
                $total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
                if($total>0){
                    $average = $total/5;
                    $average = floor($average);
                    if($average > 0){
                        if($average == 1)
                            $percent_cnt1++;
                        if($average == 2)
                            $percent_cnt2++;
                        if($average == 3)
                            $percent_cnt3++;
                        if($average == 4)
                            $percent_cnt4++;
                        if($average == 5)
                            $percent_cnt5++;
                    }
                }
            }
            if($percent_cnt1>0){
                $percentarray[1] = ($percent_cnt1/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt2>0){
                $percentarray[2] = ($percent_cnt2/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt3>0){
                $percentarray[3] = ($percent_cnt3/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt4>0){
                $percentarray[4] = ($percent_cnt4/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt5>0){
                $percentarray[5] = ($percent_cnt5/$data['ratingDetails']['total_count'])*100;
            }
        }
        $data['percentarray'] = $percentarray;                                             
        $data['user_data'] = get_where('tb_users',$condition,'row');
        $category=$data['user_data']->user_category;
        $data['category_questions'] = $this->common_model->getsingle(CATEGORY,array('id'=>$category));
        $data['category_questions_performer'] = $this->common_model->get_two_table_data('category_questions.*',CATEGORY_QUESTIONS,CATEGORY,'category_questions.category_id = category.id',array('user_type'=>'Employee','category.id'=>$category),$groupby="");

        $data['category_questions_employer'] = $this->common_model->get_two_table_data('category_questions.*',CATEGORY_QUESTIONS,CATEGORY,'category_questions.category_id = category.id',array('user_type'=>'Employer','category.id'=>$category),$groupby="");
        $userTypeData =  $this->common_model->getsingle(USERS,array('id'=>get_current_user_id()));
        $data['user_role'] = $userTypeData->user_role;
        $inform=array('ratings.company_id','tb_users.business_name');
        $compRatdata=$this->common_model->get_two_table_data($inform,RATINGS,USERS,'ratings.company_id=tb_users.id',array('ratings.rated_to_user'=>$user_id),"ratings.company_id",'ratings.rate_date','DESC');
        
        /************************/
        $indivReview=array();
        foreach($compRatdata as $com){
            $companyId=$com['company_id'];
            $business_name=$com['business_name'];
            $ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id,'company_id'=>$companyId),'ratings.rate_date','DESC');

            if(!empty($ratingDetails['result'])){
                foreach($ratingDetails['result'] as $row){
                    $retedby=$row->rated_by_user;   
                    $cusers = $this->common_model->getsingle(USERS,array('id'=>$retedby));
                    if(!empty($cusers)){
                        if($cusers->user_role != 'Employer'){
                            $givername=isset($cusers->firstname) ? $cusers->firstname : "" ;
                            $givername.=isset($cusers->lastname) ? " ".$cusers->lastname : "" ;
                        }else{
                            $givername=isset($cusers->business_name) ? ucwords($cusers->business_name) : "" ;
                        }
                        $profile=isset($cusers->profile) ? $cusers->profile : "" ;
                        $city=isset($cusers->city) ? $cusers->city : "" ;
                        $state=isset($cusers->state) ? $cusers->state : "" ;
                        $country=isset($cusers->country) ? $cusers->country : "";

                        $history = array();
                        $ques_[0] = starRating($row->ques_1);
                        $ques_[1] = starRating($row->ques_2);
                        $ques_[2] = starRating($row->ques_3);
                        $ques_[3] = starRating($row->ques_4);
                        $ques_[4] = starRating($row->ques_5);

                        $ques_['rate_id']=$row->id;
                        $ques_['reply']=$row->reply;
                        $ques_['message']=$row->message;
                        $ques_['anonymous']=$row->anonymous;
                        $ques_['company_id']=$companyId;
                        $ques_['retedbyid']=$row->rated_by_user;
                        $ques_['givername']=$givername;
                        $ques_['profile']=$profile;
                        $ques_['user_role'] = $cusers->user_role;
                        $ques_['address']=trim($city).', '.trim($state).', '.trim($country);

                        if($cusers->user_role != 'Employer'){
                            $ques_['star_ratings'] = userOverallRatings($cusers->id);
                        }

                        $indivReview[$business_name][]= $ques_;
                    }else{
                        $ques_['rate_id']=isset($row->id)?$row->id:'';
                        $ques_['reply']=isset($row->reply)?$row->reply:'';
                        $ques_['message']=isset($row->message)?$row->message:'';
                        $ques_['anonymous']=isset($row->message)?$row->anonymous:0;
                        $ques_['company_id']=isset($companyId)?$companyId:'';
                        $ques_['retedbyid']=isset($row->rated_by_user)?$row->rated_by_user:'';
                        $ques_['givername']='Unknown';
                        $ques_['user_role'] = '';
                        $ques_['profile']='';
                        $ques_['address']='';
                        $ques_['star_ratings'] = starRating(0);
                        $indivReview[$business_name][]= $ques_;
                    }
                }


            } else{
                for($i=0;$i<=5;$i++){
                    $ques_[$i] = starRating(0);
                }
                $indivReview[$business_name]['historyRating'][]= $ques_;


            }
        }
        $data['MyhistoryRating'] = $indivReview;
        $data['user_id'] = $user_id;
        $data['userType'] = 'self';
        $this->pageview('history',$data,$data,array()); 
    }else{
        redirect(base_url('login'));    
    }
}

public function viewhistory($id,$star_id = false){
    if($id!=""){
        $user_id=decoding($id);
        $this->session->set_userdata('u_id',$user_id);
        $data['userType'] = 'other';
        if($user_id == get_current_user_id()){
            $data['userType'] = 'self';
        }
//rating by company_id
        $condition=array('id'=>$user_id);                                   
//code for showing top user data 
        $workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$user_id,'status'=>1),'id','DESC','all',1);

        if(!empty($workingAt['result'])){
            $compId=$workingAt['result'][0]->receiver;
            $data['workingAt'] = get_where('tb_users',array('id'=>$compId),'row');
        }else{
            $data['workingAt']=array();
        }

        $data['ratingsData'] = userOverallRatings($user_id);
        $data['ratingDetails'] = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id));
//performance calculation
        $percentarray = array();
        if(!empty($data['ratingDetails']['result'])){
            $percent_cnt1 = 0;
            $percent_cnt2 = 0;
            $percent_cnt3 = 0;
            $percent_cnt4 = 0;
            $percent_cnt5 = 0;

            foreach($data['ratingDetails']['result'] as $row){
                $average = 0;
                $total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
                if($total>0){
                    $average = $total/5;
                    $average = floor($average);
                    if($average > 0){
                        if($average == 1)
                            $percent_cnt1++;
                        if($average == 2)
                            $percent_cnt2++;
                        if($average == 3)
                            $percent_cnt3++;
                        if($average == 4)
                            $percent_cnt4++;
                        if($average == 5)
                            $percent_cnt5++;
                    }
                }
            }
            if($percent_cnt1>0){
                $percentarray[1] = ($percent_cnt1/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt2>0){
                $percentarray[2] = ($percent_cnt2/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt3>0){
                $percentarray[3] = ($percent_cnt3/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt4>0){
                $percentarray[4] = ($percent_cnt4/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt5>0){
                $percentarray[5] = ($percent_cnt5/$data['ratingDetails']['total_count'])*100;
            }
        }
        $data['percentarray'] = $percentarray;                                              
        $data['user_data'] = get_where('tb_users',$condition,'row');
        $category=isset($data['user_data']->user_category)?$data['user_data']->user_category:'';
        $userTypeData =  $this->common_model->getsingle(USERS,array('id'=>$user_id));
        if($category!="" && !empty($userTypeData)){
            if($userTypeData->user_role == 'Performer'){
                $userType = 'Employee';
            }else if($userTypeData->user_role == 'Employer'){
                $userType = 'Employer';
            }else{
                $userType="";
            }
            $data['category_questions'] = $this->common_model->get_two_table_data('category_questions.*',CATEGORY_QUESTIONS,CATEGORY,'category_questions.category_id = category.id',array('user_type'=>$userType,'category.id'=>$category),$groupby="");

            $data['category_questions_performer'] = $this->common_model->get_two_table_data('category_questions.*',CATEGORY_QUESTIONS,CATEGORY,'category_questions.category_id = category.id',array('user_type'=>'Employee','category.id'=>$category),$groupby="");

            $data['category_questions_employer'] = $this->common_model->get_two_table_data('category_questions.*',CATEGORY_QUESTIONS,CATEGORY,'category_questions.category_id = category.id',array('user_type'=>'Employer','category.id'=>$category),$groupby="");
        }

        if(!empty($userTypeData)){

            $data['user_role']=$userTypeData->user_role;
        }else{
            $data['user_role']="";
        }

        if($star_id)
        {
            $ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id),'rate_date','DESC');
            if(!empty($ratingDetails['result'])){
                $userIds = array();
                foreach($ratingDetails['result'] as $row){
                    $average = 0;
                    $total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
                    if($total>0){
                        $average = $total/5;
                        $average = floor($average);
                        if($average > 0){
                            if($average == $star_id){
                                $userIds[] = $row->rated_by_user;
                            }
                        }
                    }
                }
                $users = implode(',', $userIds);
                $where = " ratings.rated_to_user=$user_id and ratings.rated_by_user IN(".$users.")";

                $companyId='';
                $business_name='';
                $indivReview=array();
                $ratingDetails = $this->common_model->getAllwhere(RATINGS,$where);
                if(!empty($ratingDetails['result'])){
                    foreach($ratingDetails['result'] as $row){
                        $retedby=$row->rated_by_user;   
                        $cusers = $this->common_model->getsingle(USERS,array('id'=>$retedby));
                        if(!empty($cusers)){
                            if($cusers->user_role != 'Employer'){
                                $givername=isset($cusers->firstname) ? $cusers->firstname : "" ;
                                $givername.=isset($cusers->lastname) ? " ".$cusers->lastname : "" ;
                            }else{
                                $givername=isset($cusers->business_name) ? ucwords($cusers->business_name) : "" ;
                            }
                            $profile=isset($cusers->profile) ? $cusers->profile : "" ;
                            $city=isset($cusers->city) ? $cusers->city : "" ;
                            $state=isset($cusers->state) ? $cusers->state : "" ;
                            $country=isset($cusers->country) ? $cusers->country : "";

                            $history = array();
                            $ques_[0] = starRating($row->ques_1);
                            $ques_[1] = starRating($row->ques_2);
                            $ques_[2] = starRating($row->ques_3);
                            $ques_[3] = starRating($row->ques_4);
                            $ques_[4] = starRating($row->ques_5);

                            $ques_['rate_id']=isset($row->id)?$row->id:'';
                            $ques_['reply']=isset($row->reply)?$row->reply:'';
                            $ques_['message']=$row->message;
                            $ques_['anonymous']=$row->anonymous;
                            $ques_['company_id']=$companyId;
                            $ques_['retedbyid']=$row->rated_by_user;
                            $ques_['givername']=$givername;
                            $ques_['profile']=$profile;
                            $ques_['user_role'] = $cusers->user_role;
                            $ques_['address']=trim($city).', '.trim($state).', '.trim($country);
                            if($cusers->user_role != 'Employer'){
                                $ques_['star_ratings'] = userOverallRatings($cusers->id);
                            }

                            $indivReview[$business_name][]= $ques_;
                        }
                        else{
                            $ques_['rate_id']=isset($row->id)?$row->id:'';
                            $ques_['reply']=isset($row->reply)?$row->reply:'';
                            $ques_['message']=isset($row->message)?$row->message:'';
                            $ques_['anonymous']=isset($row->message)?$row->anonymous:0;
                            $ques_['company_id']=isset($companyId)?$companyId:'';
                            $ques_['retedbyid']=isset($row->rated_by_user)?$row->rated_by_user:'';
                            $ques_['givername']='Unknown';
                            $ques_['user_role'] = '';
                            $ques_['profile']='';
                            $ques_['address']='';
                            $ques_['star_ratings'] = starRating(0);
                            $indivReview[$business_name][]= $ques_;
                        }
                    }


                } else{
                    for($i=0;$i<=5;$i++){
                        $ques_[$i] = starRating(0);
                    }
                    $indivReview[$business_name]['historyRating'][]= $ques_;


                }
            }

        }else{
            $inform=array('ratings.company_id','tb_users.business_name');
            $compRatdata=$this->common_model->get_two_table_data($inform,RATINGS,USERS,'ratings.company_id=tb_users.id',array('ratings.rated_to_user'=>$user_id),"ratings.company_id",'ratings.rate_date','DESC');

            /************************/
            $indivReview=array();
            foreach($compRatdata as $com){
                $companyId=$com['company_id'];
                $business_name=$com['business_name'];
                $ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id,'company_id'=>$companyId));
                $reviewcounter=$ratingDetails['total_count'];
                $ratingAverages=0;
                $ques1 = 0;
                $ques2 = 0;
                $ques3 = 0;
                $ques4 = 0;
                $ques5 = 0;
                $ques = array();
                if(!empty($ratingDetails['result'])){
                    foreach($ratingDetails['result'] as $row){
                        $retedby=$row->rated_by_user;   
                        $cusers = $this->common_model->getsingle(USERS,array('id'=>$retedby));
                        if(!empty($cusers)){
                            if($cusers->user_role !='Employer'){
                                $givername=isset($cusers->firstname) ? $cusers->firstname : "" ;
                                $givername.=isset($cusers->lastname) ? " ".$cusers->lastname : "" ;
                            }else{
                                $givername=isset($cusers->business_name) ? ucwords($cusers->business_name) : "" ;
                            }

                            $profile=isset($cusers->profile) ? $cusers->profile : "" ;
                            $city=isset($cusers->city) ? $cusers->city : "" ;
                            $state=isset($cusers->state) ? $cusers->state : "" ;
                            $country=isset($cusers->country) ? $cusers->country : "";

                            $history = array();
                            $ques_[0] = starRating($row->ques_1);
                            $ques_[1] = starRating($row->ques_2);
                            $ques_[2] = starRating($row->ques_3);
                            $ques_[3] = starRating($row->ques_4);
                            $ques_[4] = starRating($row->ques_5);

                            $ques_['rate_id']=isset($row->id)?$row->id:'';
                            $ques_['reply']=isset($row->reply)?$row->reply:'';
                            $ques_['message']=$row->message;
                            $ques_['anonymous']=$row->anonymous;
                            $ques_['company_id']=$companyId;
                            $ques_['retedbyid']=$row->rated_by_user;
                            $ques_['givername']=$givername;
                            $ques_['user_role'] = $cusers->user_role;
                            $ques_['profile']=$profile;
                            $ques_['address']=trim($city).', '.trim($state).', '.trim($country);
                            if($cusers->user_role != 'Employer'){
                                $ques_['star_ratings'] = userOverallRatings($cusers->id);
                            }

                            $indivReview[$business_name][]= $ques_;
                        }
                        else{
                            $ques_['rate_id']=isset($row->id)?$row->id:'';
                            $ques_['reply']=isset($row->reply)?$row->reply:'';
                            $ques_['message']=isset($row->message)?$row->message:'';
                            $ques_['anonymous']=isset($row->message)?$row->anonymous:0;
                            $ques_['company_id']=isset($companyId)?$companyId:'';
                            $ques_['retedbyid']=isset($row->rated_by_user)?$row->rated_by_user:'';
                            $ques_['givername']='Unknown';
                            $ques_['user_role'] = '';
                            $ques_['profile']='';
                            $ques_['address']='';
                            $ques_['star_ratings'] = starRating(0);
                            $indivReview[$business_name][]= $ques_;
                        }
                    }

                } else{
                    for($i=0;$i<=5;$i++){
                        $ques_[$i] = starRating(0);
                    }
                    $indivReview[$business_name]['historyRating'][]= $ques_;

                }
            }

        }
//code for showing write review data
        if(!empty($data['ratingDetails']['result'])){
            $questionRating = array();
            foreach($data['ratingDetails']['result'] as $row){
                if($row->rated_by_user == get_current_user_id()){
                    $questionRating[] = $row->ques_1;
                    $questionRating[] = $row->ques_2;
                    $questionRating[] = $row->ques_3;
                    $questionRating[] = $row->ques_4;
                    $questionRating[] = $row->ques_5;
                    $questionRating[] = $row->message;
                }
            }
            $data['questionRating'] = $questionRating;
        }
        $data['user_id'] = $user_id;
        $data['MyhistoryRating'] = $indivReview;
        if(get_current_user_id()){
            $data['anonymous'] = $this->common_model->getsingle(RATINGS,array('rated_by_user'=>get_current_user_id(),'rated_to_user'=>$user_id));
        }
        $this->pageview('history',$data,$data,array()); 
    }else{
        redirect(base_url('login'));    
    }
}
/**********************************************/
/******************#HISTORY-View-Individual#*******************/
/**********************************************/
public function indivisualhistory($id,$compid,$star_id = false){
    if($id!=""){

        $user_id=decoding($id);
        $this->session->set_userdata('rated_to_',$user_id);
        $data['userType'] = 'other';
        if($user_id == get_current_user_id()){
            $data['userType'] = 'self';
        }
        $company_id=decoding($compid);
//rating by company
        $condition=array('id'=>$user_id);                                        
//code for showing top user data 
        $workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$user_id,'status'=>1),'id','DESC','all',1);

        if(!empty($workingAt['result'])){
            $compId=$workingAt['result'][0]->receiver;
            $data['workingAt'] = get_where('tb_users',array('id'=>$compId),'row');
        }else{
            $data['workingAt']=array();
        }

        $data['ratingsData'] = userOverallRatings($user_id);
        $data['ratingDetails'] = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id));
//performance calculation
        $percentarray = array();
        if(!empty($data['ratingDetails']['result'])){
            $questionRating = array();
            foreach($data['ratingDetails']['result'] as $row){
                if($row->rated_by_user == get_current_user_id()){
                    $questionRating[] = $row->ques_1;
                    $questionRating[] = $row->ques_2;
                    $questionRating[] = $row->ques_3;
                    $questionRating[] = $row->ques_4;
                    $questionRating[] = $row->ques_5;
                    $questionRating[] = $row->message;
                }
            }
            $data['questionRating'] = $questionRating;
            $percent_cnt1 = 0;
            $percent_cnt2 = 0;
            $percent_cnt3 = 0;
            $percent_cnt4 = 0;
            $percent_cnt5 = 0;

            foreach($data['ratingDetails']['result'] as $row){
                $average = 0;
                $total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
                if($total>0){
                    $average = $total/5;
                    $average = floor($average);
                    if($average > 0){
                        if($average == 1)
                            $percent_cnt1++;
                        if($average == 2)
                            $percent_cnt2++;
                        if($average == 3)
                            $percent_cnt3++;
                        if($average == 4)
                            $percent_cnt4++;
                        if($average == 5)
                            $percent_cnt5++;
                    }
                }
            }
            if($percent_cnt1>0){
                $percentarray[1] = ($percent_cnt1/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt2>0){
                $percentarray[2] = ($percent_cnt2/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt3>0){
                $percentarray[3] = ($percent_cnt3/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt4>0){
                $percentarray[4] = ($percent_cnt4/$data['ratingDetails']['total_count'])*100;
            }if($percent_cnt5>0){
                $percentarray[5] = ($percent_cnt5/$data['ratingDetails']['total_count'])*100;
            }
        }
        $data['percentarray'] = $percentarray;

        $data['user_data'] = get_where('tb_users',$condition,'row');
        $category=$data['user_data']->user_category;
        $data['category'] = $this->common_model->getsingle(CATEGORY,array('id'=>$category));
        $userTypeData =  $this->common_model->getsingle(USERS,array('id'=>$user_id));
        if($category!=""){
            if($userTypeData->user_role == 'Performer'){
                $userType = 'Employee';
            }else{
                $userType = 'Employer';
            }
            $data['category_questions'] = $this->common_model->get_two_table_data('category_questions.*',CATEGORY_QUESTIONS,CATEGORY,'category_questions.category_id = category.id',array('user_type'=>$userType,'category.id'=>$category),$groupby="");

            $data['category_questions_performer'] = $this->common_model->get_two_table_data('category_questions.*',CATEGORY_QUESTIONS,CATEGORY,'category_questions.category_id = category.id',array('user_type'=>'Employee','category.id'=>$category),$groupby="");

            $data['category_questions_employer'] = $this->common_model->get_two_table_data('category_questions.*',CATEGORY_QUESTIONS,CATEGORY,'category_questions.category_id = category.id',array('user_type'=>'Employer','category.id'=>$category),$groupby="");
        }

        $inform=array('ratings.company_id','tb_users.business_name');
        $compRatdata=$this->common_model->get_two_table_data($inform,RATINGS,USERS,'ratings.company_id=tb_users.id',array('ratings.rated_to_user'=>$user_id,'company_id'=>$company_id),"ratings.company_id");
        /************************/
        $indivReview=array();
        foreach($compRatdata as $com){
            $companyId=$com['company_id'];
            $business_name=$com['business_name'];
            $ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id,'company_id'=>$companyId));
            if(!empty($ratingDetails['result'])){
                foreach($ratingDetails['result'] as $row){
                    $retedby=$row->rated_by_user;   
                    $cusers = $this->common_model->getsingle(USERS,array('id'=>$retedby));
                    if(!empty($cusers)){
                        if($cusers->user_role != 'Employer'){
                            $givername=isset($cusers->firstname) ? $cusers->firstname : "" ;
                            $givername.=isset($cusers->lastname) ? " ".$cusers->lastname : "" ;
                        }else{
                            $givername=isset($cusers->business_name) ? ucwords($cusers->business_name) : "" ;
                        }
                        $profile=isset($cusers->profile) ? $cusers->profile : "" ;
                        $city=isset($cusers->city) ? $cusers->city : "" ;
                        $state=isset($cusers->state) ? $cusers->state : "" ;
                        $country=isset($cusers->country) ? $cusers->country : "";

                        $history = array();
                        $ques_[0] = starRating($row->ques_1);
                        $ques_[1] = starRating($row->ques_2);
                        $ques_[2] = starRating($row->ques_3);
                        $ques_[3] = starRating($row->ques_4);
                        $ques_[4] = starRating($row->ques_5);

                        $ques_['rate_id']=isset($row->id)?$row->id:'';
                        $ques_['reply']=isset($row->reply)?$row->reply:'';
                        $ques_['message']=$row->message;
                        $ques_['anonymous']=$row->anonymous;
                        $ques_['company_id']=$companyId;
                        $ques_['retedbyid']=$row->rated_by_user;
                        $ques_['givername']=$givername;
                        $ques_['user_role'] = $cusers->user_role;
                        $ques_['profile']=$profile;
                        $ques_['address']=trim($city).', '.trim($state).', '.trim($country);
                        if($cusers->user_role != 'Employer'){
                            $ques_['star_ratings'] = userOverallRatings($cusers->id);
                        }
                        $indivReview[$business_name][]= $ques_;
                    }else{
                        $ques_['rate_id']=isset($row->id)?$row->id:'';
                        $ques_['reply']=isset($row->reply)?$row->reply:'';
                        $ques_['message']=isset($row->message)?$row->message:'';
                        $ques_['anonymous']=isset($row->message)?$row->anonymous:0;
                        $ques_['company_id']=isset($companyId)?$companyId:'';
                        $ques_['retedbyid']=isset($row->rated_by_user)?$row->rated_by_user:'';
                        $ques_['givername']='Unknown';
                        $ques_['user_role'] = '';
                        $ques_['profile']='';
                        $ques_['address']='';
                        $ques_['star_ratings'] = starRating(0);
                        $indivReview[$business_name][]= $ques_;
                    }
                }

            } else{
                for($i=0;$i<=5;$i++){
                    $ques_[$i] = starRating(0);
                }
                $indivReview[$business_name]['historyRating'][]= $ques_;

            }
            $data['user_role'] = $userTypeData->user_role;
        }
        $data['MyhistoryRating'] = $indivReview;
        if(get_current_user_id()){
            $data['anonymous'] = $this->common_model->getsingle(RATINGS,array('rated_by_user'=>get_current_user_id(),'rated_to_user'=>$user_id));
        }
        $this->pageview('indivisual_history',$data,$data,array()); 
    }else{
        redirect(base_url('login'));    
    }
}
/**********************************************/
/************#Indivisual Message#**************/
/**********************************************/
// public function indivisualMessage(){
//     $messages = array();
//     if($this->checkUserLogin()){
//         $groupChat = 1;
//         $group = $this->input->post('group');
//         $id=decoding($_POST['userid']);
//         $user_id=get_current_user_id();

//         if($group=='no_group'){
//             $groupChat = 0;
//             $where = array('sender'=>$id,'receiver'=>$user_id);
//             $updtData = array('accept_status_notify'=>2);
//             $this->common_model->updateFields(MESSAGES, $updtData, $where);
//         }

//         if($groupChat == 1){
//             $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0 and message_group.id='$id'";

//             $conversation = $this->common_model->GetJoinRecordThree(MESSAGES,'sender',USERS,'id',MESSAGE_GROUP,'id',MESSAGES,'group_id','messages.id as msg_id,messages.*,message_group.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$where,"",'messages.id','DESC',7,0);
//             $data['group'] = 1;
//             $data['conversation'] = $conversation;
//         }else{
//             $con=" ((sender='$user_id' AND receiver='$id') OR (sender='$id' AND receiver='$user_id')) AND NOT find_in_set($user_id,deleted_by)";
//             $conversation = $this->common_model->GetJoinRecord(MESSAGES,'sender',USERS,'id','messages.id as msg_id,messages.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$con,'','messages.id','DESC',7,0);
//             $data['conversation'] = $conversation;
//             $data['group'] = 0;
//         }

//         if(!empty($conversation['result'])){
//             foreach($conversation['result'] as $row){
//                 $messages[] = $row->msg_id;
//             }
//         }
//         $this->session->set_userdata('messages',$messages);
//         $groupMember = '';
//         if($group=='no_group'){
//             $data['user_data'] = $this->common_model->getsingle(USERS,array('id'=>$id));
//         }else{
//             $data['user_data'] = $this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$id));
//             $where = " id IN(".$data['user_data']->group_members.") and id!=".get_current_user_id();
//             $groupMembers = $this->common_model->getAllwhere(USERS,$where);
//             $groupMemberList = array();
//             if(!empty($groupMembers['result'])){
//                 foreach($groupMembers['result'] as $members){
//                     $groupMemberList[] = ucwords($members->firstname.' '.$members->lastname);
//                 }
//             }
//             $groupMemberList[] = 'You';
//             $groupMember = implode(', ',$groupMemberList);
//         }
//         $data['personal_data'] = $this->common_model->getsingle(USERS,array('id'=>$user_id));
//         $data['other_user'] = $id;
//         $htm=$this->load->view('frontend/chatview',$data,true); 
//         $ret=array('result'=>1,'msg'=>$htm,'userid'=>$id,'members'=>$groupMember);
//         echo json_encode($ret);
//         exit;
//     }else{
//         $ret=array('result'=>0,'msg'=>'<div class="alert alert-danger">Not Allowed</div>');
//         echo json_encode($ret);
//         exit;   
//     }
// }
public function indivisualMessage(){
    $messages = array();
    if($this->checkUserLogin()){
        $groupChat = 1;
        $group = $this->input->post('group');
        $id=decoding($_POST['userid']);
        $user_id=get_current_user_id();

        /*Both User Data*/
        if($group == 'no_group'){
            $where = ' id IN('.$id.','.$user_id.')';
        }else{
            $groupData = $this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$id));
             $groupMembersIDs = $groupData->group_members;
            $where = ' id IN('.$groupMembersIDs.')';
        }
       $usersData = $this->common_model->getAllwhere(USERS,$where);

        $userData = array();
       if(!empty($usersData['result'])){
            foreach($usersData['result'] as $user){
                $userData[$user->id]['firstname'] = ucfirst($user->firstname);
                $userData[$user->id]['lastname'] = ucfirst($user->lastname);
                $userData[$user->id]['business_name'] = ucwords($user->business_name);
                $userData[$user->id]['profile'] = (!empty($user->profile) && ($user->profile!='assets/images/default_image.jpg'))? $user->profile:base_url().DEFAULT_IMAGE;
            }
       }
        $data['allUserData'] = $userData;
        $data['other_user'] = $id;
        $htm=$this->load->view('frontend/chatview',$data,true); 
        
        if($group=='no_group'){
            $data['user_data'] = $this->common_model->getsingle(USERS,array('id'=>$id));
        }else{
            $data['user_data'] = $this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$id));
            $where = " id IN(".$data['user_data']->group_members.") and id!=".get_current_user_id();
            $groupMembers = $this->common_model->getAllwhere(USERS,$where);
            $groupMemberList = array();
            if(!empty($groupMembers['result'])){
                foreach($groupMembers['result'] as $members){
                    $groupMemberList[] = ucwords($members->firstname.' '.$members->lastname);
                }
            }
            $groupMemberList[] = 'You';
            $groupMember = implode(', ',$groupMemberList);
        }
        $ret=array('result'=>1,'msg'=>$htm,'userid'=>$id,'members'=>$groupMember);
        echo json_encode($ret);
        exit;
    }else{
        $ret=array('result'=>0,'msg'=>'<div class="alert alert-danger">Not Allowed</div>');
        echo json_encode($ret);
        exit;   
    }
}

public function indivisualMessageOld(){
    
    if($this->checkUserLogin()){
        $groupChat = 1;
        $group = $this->input->post('group');
        $id=$_POST['userid'];
        $user_id=get_current_user_id();
        $top_id=isset($_POST['top_id'])?$_POST['top_id']:'';
        if($group==''){
            $groupChat = 0;
            $where = array('sender'=>$id,'receiver'=>$user_id);
            $updtData = array('accept_status_notify'=>2);
            $this->common_model->updateFields(MESSAGES, $updtData, $where);
        }


        if($groupChat == 1){
            $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0 AND messages.id < '$top_id' and message_group.id='$id'";

            $conversation = $this->common_model->GetJoinRecordThree(MESSAGES,'sender',USERS,'id',MESSAGE_GROUP,'id',MESSAGES,'group_id','messages.id as msg_id,messages.*,message_group.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$where,"",'messages.id','DESC',7,0);
            $data['group'] = 1;
            $data['conversation'] = $conversation;
        }else{
            $con="((sender='$user_id' AND receiver='$id') OR (sender='$id' AND receiver='$user_id')) AND NOT find_in_set($user_id,deleted_by) AND messages.id < '$top_id'";
            $conversation = $this->common_model->GetJoinRecord(MESSAGES,'sender',USERS,'id','messages.id as msg_id,messages.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$con,'','messages.id','DESC',7,0);
            $data['conversation'] = $conversation;
            $data['group'] = 0;
        }
        $data['other_user'] = $id;
        $htm=$this->load->view('frontend/chatview1',$data,true); 
        $ret=array('result'=>1,'msg'=>$htm,'userid'=>$id);
        echo json_encode($ret);
        exit;
    }else{
        $ret=array('result'=>0,'msg'=>'<div class="alert alert-danger">Not Allowed</div>');
        echo json_encode($ret);
        exit;   
    }
}
/*******************Check New Messages*******************/
// public function checkMessages(){
//     $groupChat = 1;
//     $messages = array();
//     $group = $this->input->post('type');
//     $id = $this->input->post('id');
//     $user_id=get_current_user_id();

//     if($group=='no_group'){
//         $groupChat = 0;
//         $where = array('sender'=>$id,'receiver'=>$user_id);
//         $updtData = array('accept_status_notify'=>2);
//         $this->common_model->updateFields(MESSAGES, $updtData, $where);
//     }

//     if($groupChat == 1){
//         $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0 and message_group.id='$id' AND NOT find_in_set($user_id,messages.new_msg_read_by)";

//         $conversation = $this->common_model->GetJoinRecordThree(MESSAGES,'sender',USERS,'id',MESSAGE_GROUP,'id',MESSAGES,'group_id','messages.id as msg_id,messages.*,message_group.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$where,"",'messages.id','DESC',7,0);
//     }else{
//         $con=" ((sender='$user_id' AND receiver='$id') OR (sender='$id' AND receiver='$user_id')) AND NOT find_in_set($user_id,deleted_by)  AND NOT find_in_set($user_id,messages.new_msg_read_by)";
//         $conversation = $this->common_model->GetJoinRecord(MESSAGES,'sender',USERS,'id','messages.id as msg_id,messages.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$con,'','messages.id','DESC',7,0);
//     }

//     if(!empty($conversation['result'])){
//         foreach($conversation['result'] as $row){
//             $messages[] = $row->msg_id;
//         }
//     }
//     //$this->session->set_userdata('messages',$messages);

//     $html = '';   
//     $alreadyDiplayedMessages= array();   
//     if(!empty($conversation['result'])){
//         $alreadyDiplayedMessages = $this->session->userdata('messages');
//         $allmessages=array_reverse($conversation['result']);
//         foreach($allmessages as $msgs){ 
//         if(!in_array($msgs->msg_id,$alreadyDiplayedMessages)){
//             $html.='<input type="hidden" name="msgid" class="topId" value="'.$msgs->msg_id.'" >';
//             if($msgs->sender == get_current_user_id()){
//                 $html.='<div class="fil_ds wid_ri">
//                 <a href="'.base_url().'viewdetails/profile/'.encoding($msgs->sender).'">
//                 <div class="pro_img">
//                 <img src="';
//                 if(!empty($msgs->profile) && $msgs->profile!='assets/images/default_image.jpg' )
//                 {
//                     $html.=$msgs->profile;
//                 }else{
//                     $html.= base_url().DEFAULT_IMAGE;
//                 }

//                 if(!empty($msgs->business_name))
//                 {
//                     $user_name = $msgs->business_name;
//                 }
//                 else
//                 {
//                     $user_name = $msgs->firstname.' '.$msgs->lastname;
//                 }

//                 $html.='" alt="'.strtoupper(substr($msgs->firstname,0,1)).'" style="width: 40px;border-radius: 20px;">
//                 </div>
//                 </a>
//                 <div class="msg_bx bg_chng">

//                 <b>'.ucwords($user_name).'</b>

//                 <pre>'.$msgs->message.'
//                 </pre>
//                 </div>
//                 <span class="date">
//                 '.date('M-d-Y h:i A',strtotime($msgs->message_date)).'
//                 </span>
//                 </div>';
//             }else{ 
//                 $html.='<div class="fil_ds">
//                 <a href="'.base_url().'viewdetails/profile/'.encoding($msgs->sender).'">
//                 <div class="pro_img">
//                 <img src="';
//                 if(!empty($msgs->profile) && $msgs->profile!='assets/images/default_image.jpg' )
//                 {
//                     $html.=$msgs->profile;
//                 }else{
//                     $html.= base_url().DEFAULT_IMAGE;
//                 }

//                 if(!empty($msgs->business_name))
//                 {
//                     $user_name = $msgs->business_name;
//                 }
//                 else
//                 {
//                     $user_name = $msgs->firstname.' '.$msgs->lastname;
//                 }
//                 $html.='" alt="'.strtoupper(substr($msgs->firstname,0,1)).'" style="width: 40px;border-radius: 20px;">
//                 </div>
//                 </a>
//                 <div class="msg_bx">
//                 <b>'.ucwords($user_name).'</b>
//                 <pre>'.$msgs->message.'
//                 </pre>
//                 </div>
//                 <span class="date">
//                 '.date('M-d-Y h:i A',strtotime($msgs->message_date)).'
//                 </span>
//                 </div>';
//             }
//         }
//         } 
//     } 

//     $ret=array('result'=>1,'msg'=>$html);
//     echo json_encode($ret);
//     if(!empty($conversation['result'])){
//         $allmessages=array_reverse($conversation['result']);
//         foreach($allmessages as $msgs){ 
//             $new_msg_read_by1 = isset($msgs->new_msg_read_by)?$msgs->new_msg_read_by:'';
//             if(!empty($new_msg_read_by1)){
//                 $new_msg_read_by = explode(',',$new_msg_read_by1);
//                 $new_msg_read_by[] = get_current_user_id();
//                 $msg_read = implode(',',$new_msg_read_by);
//             }else{
//                 $new_msg_read_by = array();
//                 $new_msg_read_by[] = get_current_user_id();
//                 $msg_read = implode(',',$new_msg_read_by);
//             }
//             $this->common_model->updateFields(MESSAGES,array('new_msg_read_by'=>$msg_read),array('id'=>$msgs->msg_id));
//         }
//     }
//     exit;
// }
public function checkMessages(){
    $groupChat = 1;
    $messages = array();
    $group = $this->input->post('type');
    $id = $this->input->post('id');
    $user_id=get_current_user_id();

    if($group=='no_group'){
        $groupChat = 0;
        $where = array('sender'=>$id,'receiver'=>$user_id);
        $updtData = array('accept_status_notify'=>2);
        $this->common_model->updateFields(MESSAGES, $updtData, $where);
    }

    if($groupChat == 1){
        $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0 and message_group.id='$id' AND NOT find_in_set($user_id,messages.new_msg_read_by)";

        $conversation = $this->common_model->GetJoinRecordThree(MESSAGES,'sender',USERS,'id',MESSAGE_GROUP,'id',MESSAGES,'group_id','messages.id as msg_id,messages.*,message_group.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$where,"",'messages.id','DESC',7,0);
    }else{
        $con=" ((sender='$user_id' AND receiver='$id') OR (sender='$id' AND receiver='$user_id')) AND NOT find_in_set($user_id,deleted_by)  AND NOT find_in_set($user_id,messages.new_msg_read_by)";
        $conversation = $this->common_model->GetJoinRecord(MESSAGES,'sender',USERS,'id','messages.id as msg_id,messages.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$con,'','messages.id','DESC',7,0);
    }

    if(!empty($conversation['result'])){
        foreach($conversation['result'] as $row){
            $messages[] = $row->msg_id;
        }
    }
    //$this->session->set_userdata('messages',$messages);

    $html = '';   
    $alreadyDiplayedMessages= array();   
    if(!empty($conversation['result'])){
        $alreadyDiplayedMessages = $this->session->userdata('messages');
        $allmessages=array_reverse($conversation['result']);
        foreach($allmessages as $msgs){ 
        if(!in_array($msgs->msg_id,$alreadyDiplayedMessages)){
            $html.='<input type="hidden" name="msgid" class="topId" value="'.$msgs->msg_id.'" >';
            if($msgs->sender == get_current_user_id()){
                $html.='<div class="fil_ds wid_ri">
                <a href="'.base_url().'viewdetails/profile/'.encoding($msgs->sender).'">
                <div class="pro_img">
                <img src="';
                if(!empty($msgs->profile) && $msgs->profile!='assets/images/default_image.jpg' )
                {
                    $html.=$msgs->profile;
                }else{
                    $html.= base_url().DEFAULT_IMAGE;
                }

                if(!empty($msgs->business_name))
                {
                    $user_name = $msgs->business_name;
                }
                else
                {
                    $user_name = $msgs->firstname.' '.$msgs->lastname;
                }

                $html.='" alt="'.strtoupper(substr($msgs->firstname,0,1)).'" style="width: 40px;border-radius: 20px;">
                </div>
                </a>
                <div class="msg_bx bg_chng">

                <b>'.ucwords($user_name).'</b>

                <pre>'.$msgs->message.'
                </pre>
                </div>
                <span class="date">
                '.date('M-d-Y h:i A',strtotime($msgs->message_date)).'
                </span>
                </div>';
            }else{ 
                $html.='<div class="fil_ds">
                <a href="'.base_url().'viewdetails/profile/'.encoding($msgs->sender).'">
                <div class="pro_img">
                <img src="';
                if(!empty($msgs->profile) && $msgs->profile!='assets/images/default_image.jpg' )
                {
                    $html.=$msgs->profile;
                }else{
                    $html.= base_url().DEFAULT_IMAGE;
                }

                if(!empty($msgs->business_name))
                {
                    $user_name = $msgs->business_name;
                }
                else
                {
                    $user_name = $msgs->firstname.' '.$msgs->lastname;
                }
                $html.='" alt="'.strtoupper(substr($msgs->firstname,0,1)).'" style="width: 40px;border-radius: 20px;">
                </div>
                </a>
                <div class="msg_bx">
                <b>'.ucwords($user_name).'</b>
                <pre>'.$msgs->message.'
                </pre>
                </div>
                <span class="date">
                '.date('M-d-Y h:i A',strtotime($msgs->message_date)).'
                </span>
                </div>';
            }
        }
        } 
    } 

    $ret=array('result'=>1,'msg'=>'');
    echo json_encode($ret);
    if(!empty($conversation['result'])){
        $allmessages=array_reverse($conversation['result']);
        foreach($allmessages as $msgs){ 
            $new_msg_read_by1 = isset($msgs->new_msg_read_by)?$msgs->new_msg_read_by:'';
            if(!empty($new_msg_read_by1)){
                $new_msg_read_by = explode(',',$new_msg_read_by1);
                $new_msg_read_by[] = get_current_user_id();
                $msg_read = implode(',',$new_msg_read_by);
            }else{
                $new_msg_read_by = array();
                $new_msg_read_by[] = get_current_user_id();
                $msg_read = implode(',',$new_msg_read_by);
            }
            $this->common_model->updateFields(MESSAGES,array('new_msg_read_by'=>$msg_read),array('id'=>$msgs->msg_id));
        }
    }
    exit;
}

/****************Check Message Notification*********************/
public function checkMsgNotifications(){
    $sender= '';
    $user_id = get_current_user_id();
    $where = " find_in_set(".$user_id.",message_group.group_members) !=0 AND NOT find_in_set($user_id,messages.msg_notification_ids) and is_group=1 and sender!=".$user_id;

    $conversation = $this->common_model->GetJoinRecordThree(MESSAGES,'sender',USERS,'id',MESSAGE_GROUP,'id',MESSAGES,'group_id','messages.id as msg_id,messages.*,message_group.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$where,"",'messages.id','DESC',1);
    if(!empty($conversation['result'])){
        $newmsg = $conversation['result'];
        $usrDtl=$this->common_model->getsingle(USERS,array('id'=>$newmsg[0]->sender));
        if($usrDtl->business_name!=''){
            $sendername=$usrDtl->business_name;
        }else{
            $sendername=$usrDtl->firstname.' '.$usrDtl->lastname;
        }
        $sender = $sendername."-".$newmsg[0]->name?$newmsg[0]->name:'';
    }
    if(empty($conversation['result'])){
        $con=" receiver='$user_id' AND NOT find_in_set($user_id,deleted_by)  AND NOT find_in_set($user_id,messages.msg_notification_ids)";
        $conversation = $this->common_model->GetJoinRecord(MESSAGES,'sender',USERS,'id','messages.id as msg_id,messages.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$con,'','messages.id','DESC',1);
        if(!empty($conversation['result'])){
            $newmsg = $conversation['result'];
            $usrDtl=$this->common_model->getsingle(USERS,array('id'=>$newmsg[0]->sender));
            if($usrDtl->business_name!=''){
                $sender=$usrDtl->business_name;
            }else{
                $sender=$usrDtl->firstname.' '.$usrDtl->lastname;
            }
        }
    }

    $msg = '';
    if(!empty($conversation['result'])){
        $allmessages=array_reverse($conversation['result']);
        foreach($allmessages as $msgs){ 
            $msg =  isset($msgs->message)?$msgs->message:'';
        }
    }
    $ret=array('result'=>1,'msg'=>$msg,'sender'=>$sender);
    echo json_encode($ret);

    if(!empty($conversation['result'])){
        $allmessages=array_reverse($conversation['result']);
        foreach($allmessages as $msgs){ 
            $new_msg_read_by1 = isset($msgs->msg_notification_ids)?$msgs->msg_notification_ids:'';
            if(!empty($new_msg_read_by1)){
                $new_msg_read_by = explode(',',$new_msg_read_by1);
                $new_msg_read_by[] = get_current_user_id();
                $msg_read = implode(',',$new_msg_read_by);
            }else{
                $new_msg_read_by = array();
                $new_msg_read_by[] = get_current_user_id();
                $msg_read = implode(',',$new_msg_read_by);
            }
            $this->common_model->updateFields(MESSAGES,array('msg_notification_ids'=>$msg_read),array('id'=>$msgs->msg_id));
        }
    }
    exit;

}

/***********************Check-Notification*********************/
public function checknotification(){
    if($this->checkUserLogin()){
        $cuid=get_current_user_id();    
        $info=array('tb_users.id as usrid','tb_users.firstname','tb_users.lastname','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country','friends.id');
        $condition=array('friends.user_two_id'=>$cuid,'friends.status'=>0,'friends.notify'=>0);
        $relation="tb_users.id=friends.user_one_id";
        $pendingRequest = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,$groupby="");
        $condition1="receiver ='$cuid' AND `notify` = '0' ";
        $checkmessage = $this->common_model->getsingle(MESSAGES,$condition1);
        $i=0;
        if(!empty($pendingRequest)){
            foreach($pendingRequest as $row){ $i++;
                $sendername=$row['firstname'].' '.$row['lastname'];
                $message="You have a new New Friend Request";   
                $frid=$row['id'];
                $arr['msg']=$message;
                $arr['title']=$sendername;
                $arr['result']=1;
                $arr['type']='F-REQUEST';
                $arr['returl']=site_url('profile');
                echo json_encode($arr);
                sleep(3);
                $updtData=array('notify'=>1);
                $where=array('id'=>$frid);
                $updt=$this->common_model->updateFields(FRIENDS, $updtData, $where);
            }   
        }
        if(!empty($checkmessage)){ $i++;
            $sender=$checkmessage->sender;
            $message=$checkmessage->message;
            $usrDtl=$this->common_model->getsingle(USERS,array('id'=>$sender));
            $sendername=$usrDtl->firstname.' '.$usrDtl->lastname;
            $msgid=$checkmessage->id;
            $uimg=(!empty($usrDtl->profile))? $usrDtl->profile:DEFAULT_IMAGE;
            $rets='
            <div class="fil_ds">
            <div class="pro_img"><img src="'.$uimg.'" alt="'.strtoupper(substr($usrDtl->firstname,0,1)).'" style="width: 40px;border-radius: 20px;"></div>
            <div class="msg_bx">'.$message.'</div>
            <span class="date">'.date('M-d-Y h:i A',strtotime($checkmessage->message_date)).'</span>
            </div>
            ';
            $arr['msg']=$message;
            $arr['title']=$sendername;
            $arr['result']=1;
            $arr['type']='MESSAGE';
            $arr['msView']=$rets;
            $arr['usId']=$checkmessage->sender;
            $arr['returl']=site_url('user/message');
            echo json_encode($arr);
            sleep(3);
            $updtData1=array('notify'=>1);
            $where1=array('id'=>$msgid);
            $updts=$this->common_model->updateFields(MESSAGES, $updtData1, $where1);
        }   
        if($i==0){
            $arr['msg']="NO Message";
            $arr['title']="No Message";
            $arr['result']=0;
            $arr['type']='';
            $arr['returl']="";
            echo json_encode($arr);     
        }
    }
}   
/*********************************************/
/***************** LOGOUT *******************/
/*********************************************/   
public function logout(){
    $this->common_model->updateFields(USERS,array('login_status'=>0),array('id'=>get_current_user_id()));
    $this->session->unset_userdata('loggedIn');
    $this->session->unset_userdata('userData');
    $this->facebook->destroy_session();
    $this->session->sess_destroy();
    redirect(base_url());
} 
/******************-Deactivate-Account-**********************/    
public function deleteaccount(){
    $userid=get_current_user_id();  
    $updtData1=array('active'=>0);
    $where1=array('id'=>$userid);
    $updts=$this->common_model->updateFields(USERS, $updtData1, $where1);
    $this->session->unset_userdata('loggedIn');
    $this->session->unset_userdata('userData');
    $this->facebook->destroy_session();
    $this->session->sess_destroy();
    $this->session->set_flashdata('loginmsg','
        <div class="alert alert-danger text-center"> Your account has been deactivated successfully. Thanks for being with us.</div>
        ');
    redirect(base_url('login'));
}
/********************************/

public function find_friend(){
    $data['category_data'] = $this->common_model->getAllwhere(CATEGORY,array('category_status'=>'1'),'id','DESC','','');
    $this->load->view('frontend/fiendourfriend',$data);
}

function curl($url, $post = "") {
    $curl = curl_init();
    $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
    if ($post != "") {
        curl_setopt($curl, CURLOPT_POST, 5);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    $contents = curl_exec($curl);
    curl_close($curl);
    return $contents;
}

public function editwallpost(){
    if($this->checkUserLogin()){
        //if(isset($_POST['post_content'])){
            $allimg=array();
            $dataArr = array();
            if(isset($_FILES['post_images']['name'][0]) && !empty($_FILES['post_images']['name'][0])){
                $filesCount = count($_FILES['post_images']['name']);

                if($filesCount>0){
                    for($i = 0; $i < $filesCount; $i++){
                        $_FILES['docfile']['name'] = $_FILES['post_images']['name'][$i];
                        $_FILES['docfile']['type'] = $_FILES['post_images']['type'][$i];
                        $_FILES['docfile']['tmp_name'] = $_FILES['post_images']['tmp_name'][$i];
                        $_FILES['docfile']['error'] = $_FILES['post_images']['error'][$i];
                        $_FILES['docfile']['size'] = $_FILES['post_images']['size'][$i];
                        $config['upload_path'] = 'uploads/posts/';
                        $config['allowed_types'] = 'jpg|jpeg|gif|png';
                        $path=$config['upload_path'];
                        $config['overwrite'] = '1';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ( !$this->upload->do_upload("docfile"))
                        {
                            echo "error";
                            $error = array('error' => $this->upload->display_errors());
                            print_r($error);
                            die;
                        }
                        else
                        {
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
                            $filename = $_FILES['docfile']['tmp_name'];


                            $imgdata=@exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');


                            list($width, $height) = getimagesize($filename);
                            if ($width >= $height){
                                $config['width'] = 800;
                            }
                            else{
                                $config['height'] = 800;
                            }
                            $config['master_dim'] = 'auto';


                            $this->load->library('image_lib',$config); 

                            if (!$this->image_lib->resize()){  
                                echo "error";
                            }else{

                                $this->image_lib->clear();
                                $config=array();

                                $config['image_library'] = 'gd2';
                                $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;

                                if(isset($imgdata['Orientation'])){
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

                                    $this->image_lib->initialize($config); 
                                    $this->image_lib->rotate();
                                }
                            }
                        }   
                        $allimg[]=base_url().'uploads/posts/'.$this->upload->file_name;     
                    }
                }
            }
            $oldPost = $this->input->post('post_images_');
            if(!empty($oldPost)){
                foreach($this->input->post('post_images_') as $row){
                    $allimg[] = $row;
                }
            }

            if(!empty($allimg))
                $dataArr['post_image']=implode(',',$allimg);
            else
                $dataArr['post_image']='';

            $dataArr['post_content']=$_POST['post_content'];
            $update = $this->common_model->updateFields(POSTS,$dataArr,array('id'=>$this->input->post('post_id')));


            
            $postData = $this->common_model->getsingle(POSTS,array('id'=>$this->input->post('post_id')));
            if(true){
                $postimg="";  
                if(isset($postData->post_image) && $postData->post_image!=""){   
                    $imgsert=$postData->post_image;
                    $imgsert = explode(',',$imgsert);
                    if(count($imgsert)>1){ 
                        $postimg.='
                        <div class="row">
                        ';
                        foreach($imgsert as $postim){
                            $postimg.='
                            <div class ="col-sm-4 col-md-4"><a href="#" class="thumbnail"><img src="'.base_url().$postim.'" alt="Post Image"></a></div>
                            ';
                        }
                        $postimg.="
                        </div>
                        ";
                    }else{
                        $postimg='
                        <div class="over_viewimg">
                        <img src="'.base_url().$imgsert[0].'" class="img-fluid">
                        <div class="bl-box"><img src="'.base_url().'assets/images/scrl.png"></div>
                        </div>
                        ';
                    }
                }  
                $html='
                <div class="main_blog">
                <div class="over_viewimg">
                '.$postimg.'
                </div>
                <div class="contant_overviw esdu" onclick="setID('.$postData->id.');">
                <h1>'. date('d-m-Y H:i A').'</h1>
                <div class="btnns">
                <div class="form-group">
                <a href="#" class="linke"><img src="'.base_url().'assets/images/like.png">
                <i class="fa fa-thumbs-up"></i>
                </a>
                </div>
                <a href="" class="editss" data-toggle="modal" data-target="#myModal2" onclick="editPost('.$postData->id.')"><img src="'.base_url().'assets/images/edit.png"></a>
                <a href="" class="editss" data-toggle="modal" data-target="#modalDelete"><i class="fa fa fa-trash-o"></i></a>
                </div>
                <p>'.$dataArr['post_content'].'</p>
                </div>
                </div>
                ';
                $ret=array('status'=>'successful_post','msg'=>$html);  
            }else{
                $ret=array('status'=>'Failed','msg'=>'Something Went Wrong, Try Again');
            }
        // }else{
        //  $ret=array('status'=>'Failed','msg'=>'Something Went Wrong, Try Again');
        // }
        $ret=array('status'=>'successful_post');
        echo json_encode($ret); 
    }else{
        $ret=array('status'=>'Failed','msg'=>'Something Went Wrong, Try Again');
        echo json_encode($ret);             
    }
}

public function getMails(){
    $userData = $this->common_model->getsingle(USERS,array('id'=>get_current_user_id()));

}


// public function test(){
//  echo '<a href="https://accounts.google.com/o/oauth2/auth?client_id=758763789707-04pg43rrkkml6ab4r9gts376ufqjbcfn.apps.googleusercontent.com&redirect_uri=https://webandappdevelopers.com/workadviser_ci/user/google&scope=https://www.google.com/m8/feeds/&response_type=code">test</a>';
// }

public function google(){
    $accesstoken = '';
    $client_id = '252607257150-kr5at3658jl7mtoef6boer0ign6ue3fk.apps.googleusercontent.com';
    $client_secret = 'NCH7GB-x4yYNpA81R2tOD-OJ';
    $redirect_uri = 'https://workadvisor.co/user/google';
    $simple_api_key = 'AIzaSyBtnpUvM-rYuJmGWKISG6F2Hgq6-8jr-88';
    $max_results = 500;
    $auth_code = $_GET["code"];
    $fields = array(
        'code' => urlencode($auth_code),
        'client_id' => urlencode($client_id),
        'client_secret' => urlencode($client_secret),
        'redirect_uri' => urlencode($redirect_uri),
        'grant_type' => urlencode('authorization_code')
    );
    $post = '';
    foreach ($fields as $key => $value) {
        $post .= $key . '=' . $value . '&';
    }
    $post = rtrim($post, '&');

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
    curl_setopt($curl, CURLOPT_POST, 5);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $result = curl_exec($curl);

    curl_close($curl);

    $response = json_decode($result);
    if (isset($response->access_token)) {
        $accesstoken = $response->access_token;
        $_SESSION['access_token'] = $response->access_token;
    }
    if (isset($_GET['code'])) {
        $accesstoken = $_SESSION['access_token'];
    }

    if (isset($_REQUEST['logout'])) {
        unset($_SESSION['access_token']);
    }
    $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=' . $max_results . '&alt=json&oauth_token=' . $accesstoken;
    $xmlresponse = $this->curl($url);
    $contacts = json_decode($xmlresponse,true);
    //pr($contacts);
    $return = array();
    if (!empty($contacts['feed']['entry'])) {
        foreach($contacts['feed']['entry'] as $contact) {
//retrieve Name and email address  
//$data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$contact['gd$email'][0]['address'].'?alt=json',true);
            if($this->get_http_response_code('http://picasaweb.google.com/data/entry/api/user/'.$contact['gd$email'][0]['address'].'?alt=json') != "200"){
                $return[] = array (
                    'name'=> $contact['title']['$t'],
                    'email' => $contact['gd$email'][0]['address'],
                    'image' => base_url().'assets/images/default_mail.jpg'
                );
            }else{
                $data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$contact['gd$email'][0]['address'].'?alt=json');
                $img = json_decode($data);
                $return[] = array (
                    'name'=> $contact['title']['$t'],
                    'email' => $contact['gd$email'][0]['address'],
                    'image' => $img->{'entry'}->{'gphoto$thumbnail'}->{'$t'}
                );
            }
        }               
    }
    $data = array();
    $data['contacts'] = $return;
    $data['authUrl'] = $this->facebook->login_url();
    $data['loginURL'] = $this->googleplus->loginURL();  
    $this->pageview('friends_invite',$data,$data,array());
}

/*Invitation mail using Yahoo*/


public  function yahoo_response()
{
    require_once(APPPATH.'libraries/yahoo_api/globals.php');
    require_once(APPPATH.'libraries/yahoo_api/oauth_helper.php');
    $request_token          =   $_SESSION['request_token'];
    $request_token_secret   =   $_SESSION['request_token_secret'];
    $oauth_verifier         =   $_GET['oauth_verifier'];
    $retarr = get_access_token_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET,
        $request_token, $request_token_secret,
        $oauth_verifier, false, true, true);
    $retarrs = array();
    if (! empty($retarr)) {
        list($info, $headers, $body, $body_parsed) = $retarr;
        if ($info['http_code'] == 200 && !empty($body)) {
            $guid    =  $body_parsed['xoauth_yahoo_guid'];
            $access_token  = rfc3986_decode($body_parsed['oauth_token']) ;
            $access_token_secret  = $body_parsed['oauth_token_secret'];

            $retarrs = callcontact_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET,
                $guid, $access_token, $access_token_secret,
                false, true);
        }
    }
    $data = array();
    $data['contacts'] = $retarrs;
    $data['authUrl'] = $this->facebook->login_url();
    $data['loginURL'] = $this->googleplus->loginURL();  
    $this->pageview('friends_invite',$data,$data,array());
}
function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

public function send_invitation(){
    if($this->input->post('emails')){
        $cuid=get_current_user_id();
        $userData = $this->common_model->getsingle(USERS,array('id'=>$cuid));
        $senderName = ucwords($userData->firstname)." ".ucwords($userData->lastname);
        $email = $this->input->post('emails');
        $tosend = implode(',',$email);
        if(!empty($email)){
            foreach($email as $row){
                $message = '';
                $from = "noreply@workadvisor.co";    
                $subject = 'WorkAdvisor.co Invitation from '.$senderName; 
                if($this->input->post('message_content')){
                    $message .=  '<pre style="font-family: arial,sans-serif;">'.$this->input->post('message_content').'</pre>';
                }
                $message .= ' Hey! '.$senderName.' invited you to join WorkAdvisor.co 
                <br><br>';
                $message .= '<a style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;
                color: #ffffff;background: #008000;line-height: 3;padding:15px;" href="'. base_url().'login">+ Join WorkAdvisor.co</a><br/><br/>';

                $config['protocol'] = 'ssmtp';
                $config['smtp_host'] = 'ssl://ssmtp.gmail.com';
                $config['mailtype'] = 'html';
                $config['newline'] = '\r\n';
                $config['charset'] = 'utf-8';
                $this->load->library('email');
                $this->email->initialize($config);
                $mailData = array();
                $mailData['message'] = $message;
                $mailData['username'] = '';
                $message = $this->load->view('frontend/mail_temp',$mailData,true);
                $this->email->from($from);
                // $this->email->to($tosend);
                $this->email->to($row);
                //$this->email->bcc($tosend);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->set_header('From', $from);
                if($this->email->send()){
                }
            }
            $this->session->set_flashdata('success','
                        <div class="alert alert-success text-center">Invitation successfully sent to all the friends !!</div>
                        ');
            redirect('profile'); 
        }
    }
}

public function invite_gmail_contacts(){
    $data = array();
    $data['authUrl'] = $this->facebook->login_url();
    $data['loginURL'] = $this->googleplus->loginURL();  
    $data['oauthURL'] = base_url().$this->config->item('linkedin_redirect_url').'?oauth_init=1';
    $this->pageview('manual_email',$data,$data,array());
}

public function newNotifications(){
    if($this->checkUserLogin()){
        $arrayCount = 0;
        $count = 0;
        $html = '';
        $notficationsArray = array();
        $cuid=get_current_user_id();
        $from = "noreply@workadvisor.co";
        $userData = $this->common_model->getsingle(USERS,array('id'=>$cuid));
        $email = $userData->email;
        // $email = "priyanka.pixlrit@gmail.com";
        $username = $userData->firstname;
        $business_names = $userData->business_name;
        $message_notification =  $userData->message_notification;
        $job_request_received_notification =  $userData->job_request_received_notification;
        $friend_request_received_notification =  $userData->friend_request_received_notification;
        $friend_request_acceptance_notification =  $userData->friend_request_acceptance_notification;
        $job_request_acceptance_notification =  $userData->job_request_acceptance_notification;
        $config['protocol'] = 'ssmtp';
        $config['smtp_host'] = 'ssl://ssmtp.gmail.com';
        $config['mailtype'] = 'html';
        $config['newline'] = '\r\n';
        $config['charset'] = 'utf-8';
        $this->load->library('email', $config);
        $this->email->initialize($config);
//code for messages
        $info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','messages.message_date as accept_date','tb_users.business_name','msg_status','messages.id as msg_id');
//$condition=array('messages.receiver'=>$cuid,'messages.notify'=>0,'messages.accept_status_notify'=>1);
        $condition=array('messages.receiver'=>$cuid,'messages.accept_status_notify'=>1);
        $relation="messages.sender=tb_users.id";
        $pendingMessages = $this->common_model->get_two_table_data($info,USERS,MESSAGES,$relation,$condition,$groupby="");
        if(!empty($pendingMessages)){
            foreach($pendingMessages as $row){
                $notficationsArray[$arrayCount] = $row;
                $notficationsArray[$arrayCount]['type'] = 'message';
                $arrayCount++;
            }
        }

        //find user groups
        $where =  'find_in_set('.get_current_user_id().',group_members) !=0';
        $userGroups = $this->common_model->getAllwhere(MESSAGE_GROUP, $where);
        if(!empty($userGroups['result'])){
            foreach($userGroups['result'] as $row){
                $group_id = $row->id;
                $group_name = $row->name;
                $where = ' NOT find_in_set('.get_current_user_id().',new_msg_read_by) and is_group=1 and receiver='.$group_id.' and sender!='.get_current_user_id();
                $relation="messages.sender=tb_users.id";
                $pendingMessages = $this->common_model->get_two_table_data($info,USERS,MESSAGES,$relation,$where,"");
                if(!empty($pendingMessages)){
                    foreach($pendingMessages as $row){
                        $notficationsArray[$arrayCount] = $row;
                        $notficationsArray[$arrayCount]['type'] = 'group_message';
                        $notficationsArray[$arrayCount]['group_name'] = $group_name;
                        $notficationsArray[$arrayCount]['receiver'] = $group_id;
                        $arrayCount++;
                    }
                }
            }
        }
//code for business profile request
        if($userData->user_role =='Employer'){
            $info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','requests.accept_date','msg_status','requests.id as requests_id');
//$condition=array('requests.receiver'=>$cuid,'requests.notify'=>0,'requests.accept_status_notify'=>1);
            $condition=array('requests.receiver'=>$cuid,'requests.accept_status_notify'=>1,'requests.status!='=>1,'requests.confirmed!='=>2);
            $relation="requests.sender=tb_users.id";
            $pendingRequests = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation,$condition,$groupby="");



            if(!empty($pendingRequests)){
                foreach($pendingRequests as $row){
                    $notficationsArray[$arrayCount] = $row;
                    $notficationsArray[$arrayCount]['type'] = 'business';
                    $arrayCount++;
                }
            }
        }


        //code for business profile request to performer
        if($userData->user_role =='Performer'){
            $info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','requests.accept_date','msg_status','requests.id as requests_id','tb_users.business_name');
            $condition=array('requests.sender'=>$cuid,'requests.accept_status_notify_business_sent'=>1,'requests.status!='=>1,'job_requested_by!='=>$cuid,'requests.confirmed_business!='=>2);
            $relation="requests.receiver=tb_users.id";
            $pendingRequests = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation,$condition,$groupby="");
            if(!empty($pendingRequests)){
                foreach($pendingRequests as $row){
                    $notficationsArray[$arrayCount] = $row;
                    $notficationsArray[$arrayCount]['type'] = 'business_job';
                    $arrayCount++;
                }
            }
        }


//code for new friend request came to user
        if($userData->user_role =='Performer'){
            $info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','friends.accept_date','tb_users.business_name','msg_status','friends.id as friend_id');
// $condition=array('friends.user_two_id'=>$cuid,'friends.notify'=>0,'friends.accept_status_notify'=>1);
            $condition=array('friends.user_two_id'=>$cuid,'friends.accept_status_notify!='=>2,'friends.status!='=>1);
            $relation="friends.user_one_id=tb_users.id";
            $pendingFriendRequest = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,$groupby="");
            if(!empty($pendingFriendRequest)){
                foreach($pendingFriendRequest as $row){
                    $notficationsArray[$arrayCount] = $row;
                    $notficationsArray[$arrayCount]['type'] = 'recievedrequest';
                    $arrayCount++;
                }
            }
        }

//code when the friend has accepted your request
        if($userData->user_role =='Performer'){
            $info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','friends.accept_date','msg_status','friends.id as friend_id');
// $condition=array('friends.user_one_id'=>$cuid,'friends.notify'=>0,'friends.status'=>1,'friends.accept_status_notify'=>1);
            $condition=array('friends.user_one_id'=>$cuid,'friends.status'=>1,'friends.accept_status_notify!='=>3);
            $relation="friends.user_two_id=tb_users.id";
            $pendingFriendRequestAccepted = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,$groupby="");

            if(!empty($pendingFriendRequestAccepted)){
                foreach($pendingFriendRequestAccepted as $row){
                    $notficationsArray[$arrayCount] = $row;
                    $notficationsArray[$arrayCount]['type'] = 'accepted';
                    $arrayCount++;
                }
            }
        }


        //code when the company has accepted your request
        if($userData->user_role =='Performer'){
            $info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','requests.accept_date','msg_status','requests.id as requests_id','tb_users.business_name');

            $condition=array('requests.sender'=>$cuid,'requests.status'=>1,'requests.confirmed'=>1);
            $relation="requests.receiver=tb_users.id";
            $pendingJobRequestAccepted = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation,$condition,$groupby="");
            if(!empty($pendingJobRequestAccepted)){
                foreach($pendingJobRequestAccepted as $row){
                    $notficationsArray[$arrayCount] = $row;
                    $notficationsArray[$arrayCount]['type'] = 'accepted_job';
                    $arrayCount++;
                }
            }
        }

        //code when the performer has accepted your job request
        if($userData->user_role =='Employer'){
            $info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','requests.accept_date','msg_status','requests.id as requests_id','tb_users.business_name');
            $condition=array('requests.receiver'=>$cuid,'requests.status'=>1,'requests.confirmed_business'=>1,'requests.job_requested_by'=>$cuid);
            $relation="requests.sender=tb_users.id";
            $pendingJobRequestAccepted = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation,$condition,$groupby="");
            if(!empty($pendingJobRequestAccepted)){
                foreach($pendingJobRequestAccepted as $row){
                    $notficationsArray[$arrayCount] = $row;
                    $notficationsArray[$arrayCount]['type'] = 'accepted_job_business';
                    $arrayCount++;
                }
            }
        }

        //code for liking post
        $info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','like.like_date as accept_date','tb_users.business_name','like.post_id as post_id');
        $condition=array('like.posted_by'=>$cuid,'like.notification_status_seen'=>0);
        $relation="like.liked_by=tb_users.id";
        $likeData = $this->common_model->get_two_table_data($info,USERS,LIKE,$relation,$condition,$groupby="");
        if(!empty($likeData)){
            foreach($likeData as $row){
                $notficationsArray[$arrayCount] = $row;
                $notficationsArray[$arrayCount]['type'] = 'like';
                $arrayCount++;
            }
        }



        $threeNotification = array();//to default show
        if(!empty($notficationsArray) && count($notficationsArray)>0){
            $top5 = 0;
            $notficationsArray = json_decode(json_encode($notficationsArray));
            $notficationsArray = (array_multi_subsort($notficationsArray,'accept_date'));
            foreach($notficationsArray as $row){
                $top5++;
                if($top5<=5){
                    $count++;
                    if($row->type == 'like'){
                        $senderID = encoding($row->userid);
                        $receiverID = encoding($cuid);
                        $postID = $row->post_id;
                        $name = '';
                        if($row->business_name!='' && isset($row->business_name)){
                            $html.='<li><a href="'.base_url().'user/updatestatus/like/'.$senderID.'/'.$receiverID.'/'.$postID.'">'.ucwords($row->business_name).' liked your post.</a></li>';
                            $name = ucwords($row->business_name);
                            $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/like/'.$senderID.'/'.$receiverID.'/'.$postID.'">'.ucwords($row->business_name).' liked your post.</a></li>';
                        }else{
                            $html.='<li><a href="'.base_url().'user/updatestatus/like/'.$senderID.'/'.$receiverID.'/'.$postID.'">'.ucwords($row->firstname." ".$row->lastname).' liked your post.</a></li>';
                            $name = ucwords($row->firstname." ".$row->lastname);
                            $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/like/'.$senderID.'/'.$receiverID.'/'.$postID.'">'.ucwords($row->firstname." ".$row->lastname).' liked your post.</a></li>';
                        }
                    }

                    if($row->type == 'message'){
                        $senderID = encoding($row->userid);
                        $receiverID = encoding($cuid);
                        $name = '';
                        if($row->business_name!='' && isset($row->business_name)){
                            $html.='<li><a href="'.base_url().'user/updatestatus/message/'.$senderID.'/'.$receiverID.'">'.ucwords($row->business_name).' sent you a message.</a></li>';
                            $name = ucwords($row->business_name);
                            $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/message/'.$senderID.'/'.$receiverID.'">'.ucwords($row->business_name).' sent you a message.</a></li>';
                        }else{
                            $html.='<li><a href="'.base_url().'user/updatestatus/message/'.$senderID.'/'.$receiverID.'">'.ucwords($row->firstname." ".$row->lastname).' sent you a message.</a></li>';
                            $name = ucwords($row->firstname." ".$row->lastname);
                            $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/message/'.$senderID.'/'.$receiverID.'">'.ucwords($row->firstname." ".$row->lastname).' sent you a message.</a></li>';
                        }
                    }
                    if($row->type == 'group_message'){
                        $senderID = encoding($row->userid);
                        $receiverID = encoding($row->receiver);
                        $name = '';
                        if($row->business_name!='' && isset($row->business_name)){
                            $html.='<li><a href="'.base_url().'user/updatestatus/group_message/'.$senderID.'/'.$receiverID.'">'.ucwords($row->business_name).' sent a message in '.$row->group_name.'.</a></li>';
                            $name = ucwords($row->business_name);
                            $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/group_message/'.$senderID.'/'.$receiverID.'">'.ucwords($row->business_name).' sent a message in '.$row->group_name.'.</a></li>';
                        }else{
                            $html.='<li><a href="'.base_url().'user/updatestatus/group_message/'.$senderID.'/'.$receiverID.'">'.ucwords($row->firstname." ".$row->lastname).' sent a message in '.$row->group_name.'.</a></li>';
                            $name = ucwords($row->firstname." ".$row->lastname);
                            $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/group_message/'.$senderID.'/'.$receiverID.'">'.ucwords($row->firstname." ".$row->lastname).' sent a message in '.$row->group_name.'.</a></li>';
                        }
                    }
                    else if($row->type == 'business'){
                        $senderID = encoding($row->userid);
                        $receiverID = encoding($cuid);
                        $html.='<li><a href="'.base_url().'user/updatestatus/business/'.$senderID.'/'.$receiverID.'">'.ucwords($row->firstname." ".$row->lastname).' sent you a job request.</a></li>';
                        $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/business/'.$senderID.'/'.$receiverID.'">'.ucwords($row->firstname." ".$row->lastname).' sent you a job request.</a></li>';
                    }
                    else if($row->type == 'business_job'){
                        $senderID = encoding($cuid);
                        $receiverID = encoding($row->userid);
                        if($row->business_name!='' && isset($row->business_name)){
                            $html.='<li><a href="'.base_url().'user/updatestatus/business_job/'.$senderID.'/'.$receiverID.'">'.ucwords($row->business_name).' sent you a job request.</a></li>';
                            $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/business_job/'.$senderID.'/'.$receiverID.'">'.ucwords($row->business_name).' sent you a job request.</a></li>';
                        }
                    }
                    else if($row->type == 'recievedrequest'){
                        $senderID = encoding($row->userid);
                        $receiverID = encoding($cuid);
                        if($row->business_name!='' && isset($row->business_name)){
                            $html.='<li><a href="'.base_url().'user/updatestatus/recievedrequest/'.$senderID.'/'.$receiverID.'">'.ucwords($row->business_name).' sent you a friend request.</a></li>';
                            $name = ucwords($row->business_name);
                            $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/recievedrequest/'.$senderID.'/'.$receiverID.'">'.ucwords($row->business_name).' sent you a friend request.</a></li>';
                        }else{
                            $html.='<li><a href="'.base_url().'user/updatestatus/recievedrequest/'.$senderID.'/'.$receiverID.'">'.ucwords($row->firstname." ".$row->lastname).' sent you a friend request.</a></li>';
                            $name = ucwords($row->firstname." ".$row->lastname);
                            $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/recievedrequest/'.$senderID.'/'.$receiverID.'">'.ucwords($row->firstname." ".$row->lastname).' sent you a friend request.</a></li>';
                        }
                    }
                    else if($row->type == 'accepted'){
                        $senderID = encoding($cuid);
                        $receiverID = encoding($row->userid);
                        $html.='<li><a href="'.base_url().'user/updatestatus/accepted/'.$senderID.'/'.$receiverID.'">'.ucwords($row->firstname." ".$row->lastname).' has accepted your friend request.</a></li>';
                        $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/accepted/'.$senderID.'/'.$receiverID.'">'.ucwords($row->firstname." ".$row->lastname).' has accepted your friend request.</a></li>';
                    }
                    else if($row->type == 'accepted_job'){
                        $senderID = encoding($cuid);
                        $receiverID = encoding($row->userid);
                        $html.='<li><a href="'.base_url().'user/updatestatus/accepted_job/'.$senderID.'/'.$receiverID.'">'.ucwords($row->business_name).' has accepted your job request.</a></li>';
                        $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/accepted_job/'.$senderID.'/'.$receiverID.'">'.ucwords($row->business_name).' has accepted your job request.</a></li>';
                    }else if($row->type == 'accepted_job_business'){
                        $senderID = encoding($row->userid);
                        $receiverID = encoding($cuid);
                        $html.='<li><a href="'.base_url().'user/updatestatus/accepted_job_business/'.$senderID.'/'.$receiverID.'">'.ucwords($row->firstname." ".$row->lastname).' has accepted your job request.</a></li>';
                        $threeNotification[$top5] = '<li><a href="'.base_url().'user/updatestatus/accepted_job/'.$senderID.'/'.$receiverID.'">'.ucwords($row->business_name).' has accepted your job request.</a></li>';
                    }
                }
            }

            if(!empty($threeNotification)){
                $notCount = 0;
                foreach($threeNotification as $notification){
                    $notCount++;
                    if($notCount<4){
                        $whereNotification['number'] = $notCount;
                        $whereNotification['user_id'] = get_current_user_id();
                        $dataUpdate['message'] = $notification;
                        $userNotification = $this->common_model->getsingle(NOTIFICATION_HISTORY,$whereNotification); 
                        if(empty($userNotification)){
                            $dataInsert['number'] = $notCount;
                            $dataInsert['user_id'] = get_current_user_id();
                            $dataInsert['message'] = $notification;
                            $this->common_model->insertData(NOTIFICATION_HISTORY,$dataInsert);
                        }else{
                            $this->common_model->updateFields(NOTIFICATION_HISTORY,$dataUpdate,$whereNotification);
                        }
                    }
                }
            }

            //if the notifications are less than 3 then fetch from the last three notifications
            if($top5<3){
                $top5 = 3 - $top5;
                if($top5>0){
                    $lastThreeNotifications = $this->common_model->getAllwhere(NOTIFICATION_HISTORY,array('user_id'=>get_current_user_id()));
                    if(!empty($lastThreeNotifications['result'])){
                        $moreNot = 0;
                        foreach($lastThreeNotifications['result'] as $notification){
                            $moreNot++;
                            if($moreNot<=$top5){
                                $html.=$notification->message;
                            }
                        }
                    }
                }
            }
        }else{
            $lastThreeNotifications = $this->common_model->getAllwhere(NOTIFICATION_HISTORY,array('user_id'=>get_current_user_id()));
            if(!empty($lastThreeNotifications['result'])){
                foreach($lastThreeNotifications['result'] as $notification){
                    $html.=$notification->message;
                }
            }else{
                $html.='<li>No new notifications found</li>';
            }
            $this->session->set_userdata('notifications','');
        }
        $this->session->set_userdata('notifications',$html);
        echo json_encode(array('count'=>$count,'html'=>$html));
    }
}

public function updatestatus($type,$sender,$receiver,$post_id=false){
    $sender = decoding($sender);
    $receiver = decoding($receiver);
    if($type == 'message'){
        $where = array('sender'=>$sender,'receiver'=>$receiver);
        $updtData = array('accept_status_notify'=>2);
        $this->common_model->updateFields(MESSAGES, $updtData, $where);
        redirect('user/message');
    }else if($type == 'like'){
        $where = array('liked_by'=>$sender,'posted_by'=>$receiver,'post_id'=>$post_id);
        $updtData = array('notification_status_seen'=>1);
        $this->common_model->updateFields(LIKE, $updtData, $where);
        redirect('profile');
    }
    else if($type == 'group_message'){
        redirect('user/message');
    }
    else if($type == 'business'){
        $where = array('sender'=>$sender,'receiver'=>$receiver);
        $updtData = array('accept_status_notify'=>2);
        $this->common_model->updateFields(REQUESTS, $updtData, $where);
// redirect('viewdetails/profile/'.encoding($sender));
        $this->session->set_userdata('request_redirect',1);
        redirect('businessprofile');
    }else if($type == 'business_job'){
        $where = array('sender'=>$sender,'receiver'=>$receiver);
        $updtData = array('accept_status_notify_business_sent'=>2);
        $this->common_model->updateFields(REQUESTS, $updtData, $where);
        $this->session->set_userdata('friends_redirect',1);
        redirect('profile');
    }else if($type == 'recievedrequest'){
        $where = array('user_one_id'=>$sender,'user_two_id'=>$receiver);
        $updtData = array('accept_status_notify'=>2);
        $this->common_model->updateFields(FRIENDS, $updtData, $where);
        redirect('viewdetails/profile/'.encoding($sender));
    }else if($type == 'accepted'){
        $where = array('user_one_id'=>$sender,'user_two_id'=>$receiver);
        $updtData = array('accept_status_notify'=>3);
        $this->common_model->updateFields(FRIENDS, $updtData, $where);
        $this->session->set_userdata('friends_redirect',1);
        redirect('profile');
    }else if($type == 'accepted_job'){
        $where = array('sender'=>$sender,'receiver'=>$receiver);
        $updtData = array('confirmed'=>2);
        $this->common_model->updateFields(REQUESTS, $updtData, $where);
        redirect('viewdetails/profile/'.encoding($receiver));
    }else if($type == 'accepted_job_business'){
        $where = array('sender'=>$sender,'receiver'=>$receiver);
        $updtData = array('confirmed_business'=>2);
        $this->common_model->updateFields(REQUESTS, $updtData, $where);
        redirect('viewdetails/profile/'.encoding($sender));
    }
}

// public function searchName(){
//     $searchName = $this->input->post('search');

// //$where = " firstname like '%$searchName%' OR lastname like '%$searchName%'";
//     $user_id=get_current_user_id();
//     $customQuery="SELECT * FROM (SELECT * FROM `".MESSAGES."` ORDER BY `message_date` DESC) `temp` INNER JOIN `".USERS."` ON `".USERS."`.`id`=`temp`.`sender` OR `".USERS."`.`id`=`temp`.`receiver` WHERE (`temp`.`sender` = '".$user_id."' OR `temp`.`receiver` = '".$user_id."') AND `tb_users`.`id` != '".$user_id."' AND(firstname like '%$searchName%' OR lastname like '%$searchName%' OR CONCAT(tb_users.`firstname`,' ',tb_users.`lastname`) like '%$searchName%' OR tb_users.`business_name` like '%$searchName%') AND NOT find_in_set($user_id,temp.deleted_by) GROUP BY `tb_users`.`id` ORDER BY temp.id DESC";
//         $messageUsers1 = $this->common_model->custom_query($customQuery);
//         $messageUsers = array();
//         if(!empty($messageUsers1)){
//             $count = 0;
//             foreach($messageUsers1 as $row){
//                 $users = new stdClass();
//                 $users->id = $row['id'];
//                 $where = ' NOT find_in_set('.get_current_user_id().',new_msg_read_by) and receiver='.get_current_user_id().' and sender='.$row['id'];
//                 $messageCount = $this->common_model->getAllwhere(MESSAGES, $where,'', '','count(id) as count');
//                 $users->msg_count = isset($messageCount['result'][0]->count)?$messageCount['result'][0]->count:0;
//                 $users->profile = $row['profile'];
//                 $users->business_name = $row['business_name'];
//                 $users->firstname = $row['firstname'];
//                 $users->lastname = $row['lastname'];
//                 $users->message_date = $row['message_date'];
//                 $users->group = 1;
//                 $messageUsers[] = $users;
//             }
//         }
//         $contactList= '';
//         $where = ' find_in_set('.get_current_user_id().',group_members) !=0 and name like "%'.$searchName.'%"';
//         $groupNames = $this->common_model->getAllwhere(MESSAGE_GROUP,$where,'created_date','desc', 'created_date as message_date,message_group.name as business_name,message_group.group_icon as profile,message_group.*');

//         if(!empty($groupNames['result']) && !empty($messageUsers)){
//             $contactNames = array_merge($messageUsers,$groupNames['result']);
//         }else if(!empty($groupNames['result'])){
//             $contactNames = $groupNames['result'];
//         }else if(!empty($messageUsers)){
//             $contactNames = $messageUsers;
//         }
//         if(!empty($contactNames)){
//             $contactList = array_multi_subsort($contactNames,'message_date');
//         }

//         $data['allFriends']=$contactList;
//     $this->load->view('frontend/messagenames',$data);
// }
public function searchName(){
    $searchName = $this->input->post('search');

//$where = " firstname like '%$searchName%' OR lastname like '%$searchName%'";
    $user_id=get_current_user_id();
    $customQuery="SELECT * FROM (SELECT * FROM `".MESSAGES."` ORDER BY `message_date` DESC) `temp` INNER JOIN `".USERS."` ON `".USERS."`.`id`=`temp`.`sender` OR `".USERS."`.`id`=`temp`.`receiver` WHERE (`temp`.`sender` = '".$user_id."' OR `temp`.`receiver` = '".$user_id."') AND `tb_users`.`id` != '".$user_id."' AND(firstname like '%$searchName%' OR lastname like '%$searchName%' OR CONCAT(tb_users.`firstname`,' ',tb_users.`lastname`) like '%$searchName%' OR tb_users.`business_name` like '%$searchName%') AND NOT find_in_set($user_id,temp.deleted_by) GROUP BY `tb_users`.`id` ORDER BY temp.id DESC";
        $messageUsers1 = $this->common_model->custom_query($customQuery);
        $messageUsers = array();
        if(!empty($messageUsers1)){
            $count = 0;
            foreach($messageUsers1 as $row){
                $users = new stdClass();
                $users->id = $row['id'];
                $where = ' NOT find_in_set('.get_current_user_id().',new_msg_read_by) and receiver='.get_current_user_id().' and sender='.$row['id'];
                $messageCount = $this->common_model->getAllwhere(MESSAGES, $where,'', '','count(id) as count');
                $users->msg_count = isset($messageCount['result'][0]->count)?$messageCount['result'][0]->count:0;
                $users->profile = $row['profile'];
                $users->business_name = $row['business_name'];
                $users->firstname = $row['firstname'];
                $users->lastname = $row['lastname'];
                $users->message_date = $row['message_date'];
                $users->login_status = $row['login_status'];
                $users->group = 1;
                $messageUsers[] = $users;
            }
        }
        $contactList= '';
        $where = ' find_in_set('.get_current_user_id().',group_members) !=0 and name like "%'.$searchName.'%"';
        $groupNames = $this->common_model->getAllwhere(MESSAGE_GROUP,$where,'created_date','desc', 'created_date as message_date,message_group.name as business_name,message_group.group_icon as profile,message_group.*');

        if(!empty($groupNames['result']) && !empty($messageUsers)){
            $contactNames = array_merge($messageUsers,$groupNames['result']);
        }else if(!empty($groupNames['result'])){
            $contactNames = $groupNames['result'];
        }else if(!empty($messageUsers)){
            $contactNames = $messageUsers;
        }
        if(!empty($contactNames)){
            $contactList = array_multi_subsort($contactNames,'message_date');
        }

        $data['allFriends']=$contactList;
        if(!empty($contactList)){
            $isGroup = 'group';
            if(!empty($contactList[0]->group)){
                $isGroup = 'no_group';
            }
            $friendID = !empty($contactList[0]->id)?$contactList[0]->id:'';
        }
    $html = $this->load->view('frontend/messagenames',$data,true);
    echo json_encode(array('html'=>$html,'isGroup'=>$isGroup,'friendID'=>$friendID));die;
}


// public function searchMsg(){
//     $contactList = array();
//     $firstGroupChat = 0;
//     $searchName = $this->input->post('search');
//     $user_id=get_current_user_id();
//     $customQuery="SELECT * FROM (SELECT * FROM `".MESSAGES."` ORDER BY `message_date` DESC) `temp` INNER JOIN `".USERS."` ON `".USERS."`.`id`=`temp`.`sender` OR `".USERS."`.`id`=`temp`.`receiver` WHERE (`temp`.`sender` = '".$user_id."' OR `temp`.`receiver` = '".$user_id."') AND `tb_users`.`id` != '".$user_id."' AND(firstname like '%$searchName%' OR lastname like '%$searchName%' OR CONCAT(tb_users.`firstname`,' ',tb_users.`lastname`) like '%$searchName%' OR tb_users.`business_name` like '%$searchName%') AND NOT find_in_set($user_id,temp.deleted_by) GROUP BY `tb_users`.`id` ORDER BY temp.id DESC";
//     $messageUsers1 = $this->common_model->custom_query($customQuery);
//     $messageUsers = array();
//         if(!empty($messageUsers1)){
//             $count = 0;
//             foreach($messageUsers1 as $row){
//                 $users = new stdClass();
//                 $users->id = $row['id'];
//                 $where = ' NOT find_in_set('.get_current_user_id().',new_msg_read_by) and receiver='.get_current_user_id().' and sender='.$row['id'];
//                 $messageCount = $this->common_model->getAllwhere(MESSAGES, $where,'', '','count(id) as count');
//                 $users->msg_count = isset($messageCount['result'][0]->count)?$messageCount['result'][0]->count:0;
//                 $users->profile = $row['profile'];
//                 $users->business_name = $row['business_name'];
//                 $users->firstname = $row['firstname'];
//                 $users->lastname = $row['lastname'];
//                 $users->message_date = $row['message_date'];
//                 $users->group = 1;
//                 $messageUsers[] = $users;
//             }
//         }
//         $contactList= '';
//     $where = ' find_in_set('.get_current_user_id().',group_members) !=0 and name like "%'.$searchName.'%"';
//     $groupNames = $this->common_model->getAllwhere(MESSAGE_GROUP,$where,'created_date','desc', 'message_date as message_date,message_group.name as business_name,message_group.group_icon as profile,message_group.*');
//     if(!empty($groupNames['result']) && !empty($messageUsers)){
//             $contactNames = array_merge($messageUsers,$groupNames['result']);
//         }else if(!empty($groupNames['result'])){
//             $contactNames = $groupNames['result'];
//         }else if(!empty($messageUsers)){
//             $contactNames = $messageUsers;
//         }
//         if(!empty($contactNames)){
//             $contactList = array_multi_subsort($contactNames,'message_date');
//             $data['other_user'] = isset($contactList[0]->id)?$contactList[0]->id:'';
//         }
//         $singleUser= array();
//         if(!empty($contactList)){
//             $is_group = isset($contactList[0]->owner_id)?$contactList[0]->owner_id:'no_group';
//             if($is_group!='no_group'){
//                 $firstGroupChat = 1;
//                 $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0";
//                 $singleUser=$this->common_model->GetJoinRecord(MESSAGES,'group_id',MESSAGE_GROUP,'id','messages.id as msg_id,messages.*,message_group.*',$where);
//             }else{
//                 $singleUser=$this->common_model->getsingle(MESSAGES,"(receiver='$user_id' OR sender='$user_id') ORDER BY id DESC");
//             }
//             $data['group'] = $is_group;
//         }

//         $data['conversation']=array('result'=>array());
//         if(!empty($singleUser)){

//             if($firstGroupChat == 0){
//                 if($singleUser->sender!=$user_id){
//                     $id=$singleUser->sender;
//                 }else{
//                     $id=$singleUser->receiver;  
//                 }
//                 $where = array('sender'=>$id,'receiver'=>$user_id);
//                 $updtData = array('accept_status_notify'=>2);
//                 $this->common_model->updateFields(MESSAGES, $updtData, $where);
//             }


//             if($firstGroupChat == 1){
//                 $firstUser = isset($contactList[0]->id)?$contactList[0]->id:'';
//                 $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0 and message_group.id='$firstUser'";

//                 $conversation = $this->common_model->GetJoinRecordThree(MESSAGES,'sender',USERS,'id',MESSAGE_GROUP,'id',MESSAGES,'group_id','messages.id as msg_id,messages.*,message_group.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$where,"",'messages.id','DESC',7,0);
//                 $data['group'] = 1;
//                 $data['conversation'] = $conversation;
//             }else{
//                 $ids = $data['other_user'];
//                 $con=" ((sender='$user_id' AND receiver='$ids') OR (sender='$ids' AND receiver='$user_id')) AND NOT find_in_set($user_id,deleted_by)";
//                 $conversation = $this->common_model->GetJoinRecord(MESSAGES,'sender',USERS,'id','messages.id as msg_id,messages.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$con,'','messages.id','DESC',7,0);
//                 $data['conversation'] = $conversation;
//                 $data['group'] = 0;
//             }
//         }else{
//         }
//         $messages = array();
//         if(!empty($conversation['result'])){
//             foreach($conversation['result'] as $row){
//                 $messages[] = $row->msg_id;
//             }
//         }
//         $data['other_user'] = isset($contactList[0]->id)?$contactList[0]->id:'';
//         $this->session->set_userdata('messages',$messages);
//         $this->load->view('frontend/usermsg',$data);

// }
public function searchMsg(){
    $contactList = array();
    $firstGroupChat = 0;
    $searchName = $this->input->post('search');
    $user_id=get_current_user_id();
    $customQuery="SELECT * FROM (SELECT * FROM `".MESSAGES."` ORDER BY `message_date` DESC) `temp` INNER JOIN `".USERS."` ON `".USERS."`.`id`=`temp`.`sender` OR `".USERS."`.`id`=`temp`.`receiver` WHERE (`temp`.`sender` = '".$user_id."' OR `temp`.`receiver` = '".$user_id."') AND `tb_users`.`id` != '".$user_id."' AND(firstname like '%$searchName%' OR lastname like '%$searchName%' OR CONCAT(tb_users.`firstname`,' ',tb_users.`lastname`) like '%$searchName%' OR tb_users.`business_name` like '%$searchName%') AND NOT find_in_set($user_id,temp.deleted_by) GROUP BY `tb_users`.`id` ORDER BY temp.id DESC";
    $messageUsers1 = $this->common_model->custom_query($customQuery);
    $messageUsers = array();
        if(!empty($messageUsers1)){
            $count = 0;
            foreach($messageUsers1 as $row){
                $users = new stdClass();
                $users->id = $row['id'];
                $where = ' NOT find_in_set('.get_current_user_id().',new_msg_read_by) and receiver='.get_current_user_id().' and sender='.$row['id'];
                $messageCount = $this->common_model->getAllwhere(MESSAGES, $where,'', '','count(id) as count');
                $users->msg_count = isset($messageCount['result'][0]->count)?$messageCount['result'][0]->count:0;
                $users->profile = $row['profile'];
                $users->business_name = $row['business_name'];
                $users->firstname = $row['firstname'];
                $users->lastname = $row['lastname'];
                $users->message_date = $row['message_date'];
                $users->login_status = $row['login_status'];
                $users->group = 1;
                $messageUsers[] = $users;
            }
        }
        $contactList= '';
    $where = ' find_in_set('.get_current_user_id().',group_members) !=0 and name like "%'.$searchName.'%"';
    $groupNames = $this->common_model->getAllwhere(MESSAGE_GROUP,$where,'created_date','desc', 'message_date as message_date,message_group.name as business_name,message_group.group_icon as profile,message_group.*');
    if(!empty($groupNames['result']) && !empty($messageUsers)){
            $contactNames = array_merge($messageUsers,$groupNames['result']);
        }else if(!empty($groupNames['result'])){
            $contactNames = $groupNames['result'];
        }else if(!empty($messageUsers)){
            $contactNames = $messageUsers;
        }
        if(!empty($contactNames)){
            $contactList = array_multi_subsort($contactNames,'message_date');
            $data['other_user'] = isset($contactList[0]->id)?$contactList[0]->id:'';
        }
        $singleUser= array();
        if(!empty($contactList)){
            $is_group = isset($contactList[0]->owner_id)?$contactList[0]->owner_id:'no_group';
            if($is_group!='no_group'){
                $firstGroupChat = 1;
                $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0";
                $singleUser=$this->common_model->GetJoinRecord(MESSAGES,'group_id',MESSAGE_GROUP,'id','messages.id as msg_id,messages.*,message_group.*',$where);
            }else{
                $singleUser=$this->common_model->getsingle(MESSAGES,"(receiver='$user_id' OR sender='$user_id') ORDER BY id DESC");
            }
            $data['group'] = $is_group;
        }

        $data['conversation']=array('result'=>array());
        if(!empty($singleUser)){

            if($firstGroupChat == 0){
                if($singleUser->sender!=$user_id){
                    $id=$singleUser->sender;
                }else{
                    $id=$singleUser->receiver;  
                }
                $where = array('sender'=>$id,'receiver'=>$user_id);
                $updtData = array('accept_status_notify'=>2);
                $this->common_model->updateFields(MESSAGES, $updtData, $where);
            }


            if($firstGroupChat == 1){
                $firstUser = isset($contactList[0]->id)?$contactList[0]->id:'';
                $where = " find_in_set(".get_current_user_id().",message_group.group_members) !=0 and message_group.id='$firstUser'";

                $conversation = $this->common_model->GetJoinRecordThree(MESSAGES,'sender',USERS,'id',MESSAGE_GROUP,'id',MESSAGES,'group_id','messages.id as msg_id,messages.*,message_group.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$where,"",'messages.id','DESC',7,0);
                $data['group'] = 1;
                $data['conversation'] = $conversation;
            }else{
                $ids = $data['other_user'];
                $con=" ((sender='$user_id' AND receiver='$ids') OR (sender='$ids' AND receiver='$user_id')) AND NOT find_in_set($user_id,deleted_by)";
                $conversation = $this->common_model->GetJoinRecord(MESSAGES,'sender',USERS,'id','messages.id as msg_id,messages.*,tb_users.firstname,tb_users.lastname,tb_users.profile,tb_users.business_name',$con,'','messages.id','DESC',7,0);
                $data['conversation'] = $conversation;
                $data['group'] = 0;
            }
        }else{
        }
        $messages = array();
        if(!empty($conversation['result'])){
            foreach($conversation['result'] as $row){
                $messages[] = $row->msg_id;
            }
        }
        $data['other_user'] = isset($contactList[0]->id)?$contactList[0]->id:'';
        $this->session->set_userdata('messages',$messages);
        $this->load->view('frontend/usermsg',$data);

}

public function checkQuestionsAvailabitity(){
    $user_type = 'Employer';
    if($this->input->post('user_type') == 'Performer'){
        $user_type = 'Employee';
    }
    $categoryData = $this->common_model->getsingle(CATEGORY_QUESTIONS,array('category_id'=>$this->input->post('user_category'),'user_type'=>$user_type,'question!='=>''));
    if(!empty($categoryData)){
        echo json_encode(array('status'=>1));
    }else{
        $categoryData = $this->common_model->getsingle(CATEGORY,array('id'=>$this->input->post('user_category')));
        if(!empty($categoryData))
        {
            if($categoryData->name == 'N/A'){
                echo json_encode(array('status'=>1));
            }else{
                echo json_encode(array('status'=>2));
            }
        }
    }
}

public function categoryAddMoreQue(){
    $cate = array();
    $cate['user_role'] = $this->input->post('user_role');
    $cate['user_category'] = $this->input->post('cate_id');
    $this->common_model->updateFields(USERS,$cate,array('id'=>get_current_user_id()));
    if($this->input->post('que_')){
        $employeeQ = $this->input->post('que_');
        if($this->input->post('user_role') == 'Employer'){
            $categoryData = $this->common_model->getAllwhere(CATEGORY_QUESTIONS,array('user_type'=>'Employer','category_id'=>$cate['user_category']));
            if(!empty($categoryData['result'])){
                $count = 0;
                $questions = $this->input->post('que_');
                foreach($categoryData['result'] as $row){
                    $dataArr = array();
                    $dataArr['question'] = $questions[$count];
                    $this->common_model->updateFields(CATEGORY_QUESTIONS,$dataArr,array('id'=>$row->id));
                    $count++;
                }
                $this->session->set_userdata('user_login_type','employer');
                redirect('businessprofile');
            }
        }else{
            $categoryData = $this->common_model->getAllwhere(CATEGORY_QUESTIONS,array('user_type'=>'Employee','category_id'=>$cate['user_category']));
            if(!empty($categoryData['result'])){
                $count = 0;
                $questions = $this->input->post('que_');
                foreach($categoryData['result'] as $row){
                    $dataArr = array();
                    $dataArr['question'] = $questions[$count];
                    $this->common_model->updateFields(CATEGORY_QUESTIONS,$dataArr,array('id'=>$row->id));
                    $count++;
                }
                $this->session->set_userdata('user_login_type','performer');
                redirect('profile');
            }
        }
    }
}

function getZipLocation(){
    $postcode = urlencode($this->input->post('zip'));
    $query = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$postcode.'&key=AIzaSyCJOMIKWJalIMrYmvfEm-gvEptfSV-ezb8';
    $result = $this->get_data($query);
    $result = json_decode($result);
    $city = '';
    $state = '';
    $country = '';
    if(!empty($result->results[0]->address_components)){
        $address = $result->results[0]->address_components;
        foreach($address as $row){
            if(isset($row->types[0]) && $row->types[0] == 'administrative_area_level_2'){
                $city = $row->short_name;
            }
            if(isset($row->types[0]) && $row->types[0] == 'administrative_area_level_1'){
                $state = $row->short_name;
            }
            if(isset($row->types[0]) && $row->types[0] == 'country'){
                $country = $row->long_name;
            }
        }
        echo json_encode(array('city'=>$city,'state'=>$state,'country'=>$country));
    }
}
function get_data($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

public function contactSave(){
    $dataArr['name'] = $this->input->post('name');
    $dataArr['email'] = $this->input->post('email');
    $dataArr['phone'] = $this->input->post('phone');
    $dataArr['message'] = $this->input->post('message');
    $this->common_model->insertData(CONTACT,$dataArr);
        $adminData = $this->common_model->getsingle(ADMIN,array('id'=>1));
    if(!empty($adminData)){
        $email = $adminData->email;
        //$email ="priyanka.pixlrit@gmail.com";
        $from = "noreply@workadvisor.co";    
        $subject = 'Contact message sent by '.ucfirst($dataArr['name']);  
        $message = '<table>';
        $message .= '<tr> <td>Name - </td><td>'.ucfirst($dataArr['name']).'</td></tr>';
        $message .= '<tr> <td>Email - </td><td>'.($dataArr['email']).'</td></tr>';
        $message .= '<tr> <td>Contact No. - </td><td>'.($dataArr['phone']).'</td></tr>';
        $message .= '<tr> <td>Message - </td><td>'.($dataArr['message']).'</td></tr>';
        $message .= '</table>';
        $config['protocol'] = 'ssmtp';
        $config['smtp_host'] = 'ssl://ssmtp.gmail.com';
        $config['mailtype'] = 'html';
        $config['newline'] = '\r\n';
        $config['charset'] = 'utf-8';
        $this->load->library('email');
        $this->email->initialize($config);
        $mailData = array();
        $mailData['message'] = $message;
        $mailData['username'] = "Admin";
        $message = $this->load->view('frontend/mailtemplate',$mailData,true);
        $this->email->from($from);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->set_header('From', $from);
        if($this->email->send()){
            $this->session->set_flashdata('success','
                <div class="alert alert-success text-center">Message successfully sent to Admin</div>
                ');
            redirect('settings/contact_us');
        }
    }
}
    
    /*To delete messages*/
    // public function deleteMessage(){
    //     if($this->input->post()){
    //         $sender = $this->input->post('sender');
    //         $receiver = $this->input->post('receiver');
    //         if($this->common_model->deleteData(MESSAGES,array('receiver'=>$receiver,'sender'=>$sender))){
    //             echo json_encode(array('status'=>1));
    //         }
    //     }
    // }

    /*To delete messages*/
    public function deleteMessage(){
        if($this->input->post()){
            $user_id = get_current_user_id();
            $sender = $this->input->post('sender');
            $receiver = $this->input->post('receiver');
            if($this->input->post('group') && $this->input->post('group')=='group'){
                $where = array('id'=>$sender);
                $this->common_model->deleteData(MESSAGE_GROUP,$where);
                echo json_encode(array('status'=>1));
            }else{
                $where=" ((sender='$sender' AND receiver='$receiver') OR (sender='$receiver' AND receiver='$sender')) AND NOT find_in_set($user_id,deleted_by)";
                $messageData = $this->common_model->getAllwhere(MESSAGES,$where);
                if(!empty($messageData['result'])){
                    foreach($messageData['result'] as $row){
                        $deletedByIds='';
                        $deletedBy= array();
                        if($row->deleted_by!=''){
                            $deletedBy = explode(',',$row->deleted_by);
                        }
                        $deletedBy[] = get_current_user_id(); 
                        $deletedByIds = implode(',',$deletedBy);
                        $this->common_model->updateFields(MESSAGES,array('deleted_by'=>$deletedByIds),array('id'=>$row->id));
                    }
                    echo json_encode(array('status'=>1));
                }
            }
        }
    }


    /*To send push notifications*/
    public function firebaseMessageNotification(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $sender = $this->input->post('sender');
            $receiver = $this->input->post('receiver');
            $senderName = $this->input->post('name_sender');
            $groupSet = $this->input->post('groupSet');
            $userData = $this->common_model->getsingle(USER,array('id'=>$sender));
            $profileImg = '';
            if(!empty($userData)){
                $profileImg = ($userData->profile!='assets/images/default_image.jpg'&& $userData->profile!='')?$userData->profile:'';
            }
            /* To send push notifications */
            $notification_message = " sent you a message.";
            $this->sendNotifications($sender.'-'.$senderName.'-'.$profileImg,$receiver,'new_message',$notification_message);
        }
    }

    public function sendNotifications($senderId,$receiverID,$title,$message){
        $senderDetails = $this->common_model->getsingle(USERS,array('id'=>$senderId));
        $senderName = $senderDetails->firstname.' '.$senderDetails->lastname;
        if(!empty($senderDetails->business_name)){
            $senderName = $senderDetails->business_name;
        }
        /* To send push notifications */
        $message = $senderName.$message;
        $params = array('title' => $title,'sender_id' => $senderId,'body'=>$message);
        send_push_notifications($message,$receiverID,$params);
    }
    /*To get histpry reviews by filter*/
    public function reviewFilter(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            if($this->session->userdata('u_id')){
                $user_id = $this->session->userdata('u_id');
            }else{
                $user_id = get_current_user_id();
            }
            $condition=array('id'=>$user_id);                           
            $workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$user_id,'status'=>1),'id','DESC','all',1);

            if(!empty($workingAt['result'])){
                $compId=$workingAt['result'][0]->receiver;
                $data['workingAt'] = get_where('tb_users',array('id'=>$compId),'row');
            }else{
                $data['workingAt']=array();
            }

            $data['ratingsData'] = userOverallRatings($user_id);
            $data['ratingDetails'] = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id));
            //performance calculation
            $percentarray = array();
            if(!empty($data['ratingDetails']['result'])){
                $percent_cnt1 = 0;
                $percent_cnt2 = 0;
                $percent_cnt3 = 0;
                $percent_cnt4 = 0;
                $percent_cnt5 = 0;

                foreach($data['ratingDetails']['result'] as $row){
                    $average = 0;
                    $total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
                    if($total>0){
                        $average = $total/5;
                        $average = floor($average);
                        if($average > 0){
                            if($average == 1)
                                $percent_cnt1++;
                            if($average == 2)
                                $percent_cnt2++;
                            if($average == 3)
                                $percent_cnt3++;
                            if($average == 4)
                                $percent_cnt4++;
                            if($average == 5)
                                $percent_cnt5++;
                        }
                    }
                }
                if($percent_cnt1>0){
                    $percentarray[1] = ($percent_cnt1/$data['ratingDetails']['total_count'])*100;
                }if($percent_cnt2>0){
                    $percentarray[2] = ($percent_cnt2/$data['ratingDetails']['total_count'])*100;
                }if($percent_cnt3>0){
                    $percentarray[3] = ($percent_cnt3/$data['ratingDetails']['total_count'])*100;
                }if($percent_cnt4>0){
                    $percentarray[4] = ($percent_cnt4/$data['ratingDetails']['total_count'])*100;
                }if($percent_cnt5>0){
                    $percentarray[5] = ($percent_cnt5/$data['ratingDetails']['total_count'])*100;
                }
            }
            $data['percentarray'] = $percentarray;                                             
        $data['user_data'] = get_where('tb_users',$condition,'row');
        $category=$data['user_data']->user_category;
        $data['category_questions'] = $this->common_model->getsingle(CATEGORY,array('id'=>$category));
        $data['category_questions_performer'] = $this->common_model->get_two_table_data('category_questions.*',CATEGORY_QUESTIONS,CATEGORY,'category_questions.category_id = category.id',array('user_type'=>'Employee','category.id'=>$category),$groupby="");

        $data['category_questions_employer'] = $this->common_model->get_two_table_data('category_questions.*',CATEGORY_QUESTIONS,CATEGORY,'category_questions.category_id = category.id',array('user_type'=>'Employer','category.id'=>$category),$groupby="");
        $userTypeData =  $this->common_model->getsingle(USERS,array('id'=>get_current_user_id()));
        //$data['user_role'] = $userTypeData->user_role;
        if(!empty($userTypeData))
            $data['user_role'] = $userTypeData->user_role;
        else
            $data['user_role'] = '';
        $inform=array('ratings.company_id','tb_users.business_name');       
        $filter = $this->input->post('filter');
            if($filter == 'new_old'){
                $compRatdata=$this->common_model->get_two_table_data($inform,RATINGS,USERS,'ratings.company_id=tb_users.id',array('ratings.rated_to_user'=>$user_id),"ratings.company_id",'ratings.rate_date','DESC');
            }else if($filter == 'old_new'){
                $compRatdata=$this->common_model->get_two_table_data($inform,RATINGS,USERS,'ratings.company_id=tb_users.id',array('ratings.rated_to_user'=>$user_id),"ratings.company_id",'ratings.rate_date','ASC');
            }else if($filter == 'most_least'){
                $compRatdata=$this->common_model->get_two_table_data($inform,RATINGS,USERS,'ratings.company_id=tb_users.id',array('ratings.rated_to_user'=>$user_id),"ratings.company_id",'ratings.avg_rating','ASC');
            }else if($filter == 'least_most'){
                $compRatdata=$this->common_model->get_two_table_data($inform,RATINGS,USERS,'ratings.company_id=tb_users.id',array('ratings.rated_to_user'=>$user_id),"ratings.company_id",'ratings.avg_rating','DESC');
            }else if($filter == 'employer'){
                $compRatdata=$this->common_model->get_two_table_data($inform,RATINGS,USERS,'ratings.company_id=tb_users.id',array('ratings.rated_to_user'=>$user_id),"ratings.company_id",'ratings.rate_date','DESC');
            }

            /************************/
            $indivReview=array();
           // foreach($compRatdata as $com){
               // $companyId=$com['company_id'];
               // $business_name=$com['business_name'];
                $filter = $this->input->post('filter');
                if($filter == 'new_old'){
                   // $ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id,'company_id'=>$companyId),'ratings.rate_date','DESC');
                    $ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id),'ratings.rate_date','DESC');
                }else if($filter == 'old_new'){
                    //$ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id,'company_id'=>$companyId),'ratings.rate_date','ASC');
                    $ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id),'ratings.rate_date','ASC');
                }else if($filter == 'most_least'){
                    //$ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id,'company_id'=>$companyId),'ratings.avg_rating','DESC');
                    $ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id),'ratings.avg_rating','DESC');
                }else if($filter == 'least_most'){
                    //$ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id,'company_id'=>$companyId),'ratings.avg_rating','ASC');
                    $ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id),'ratings.avg_rating','ASC');
                }else if($filter == 'employer'){
                    //$ratingDetails=$this->common_model->GetJoinRecord(RATINGS,'rated_by_user',USERS,'id','ratings.*',array('ratings.rated_to_user'=>$user_id,'user_role'=>'Employer'));
                    $ratingDetails=$this->common_model->GetJoinRecord(RATINGS,'rated_by_user',USERS,'id','ratings.*',array('ratings.rated_to_user'=>$user_id,'user_role'=>'Employer'));
                }

                if(!empty($ratingDetails['result'])){
                    foreach($ratingDetails['result'] as $row){
                        $retedby=$row->rated_by_user;   
                        $cusers = $this->common_model->getsingle(USERS,array('id'=>$retedby));
                        if(!empty($cusers)){
                            if($cusers->user_role != 'Employer'){
                                $givername=isset($cusers->firstname) ? $cusers->firstname : "" ;
                                $givername.=isset($cusers->lastname) ? " ".$cusers->lastname : "" ;
                            }else{
                                $givername=isset($cusers->business_name) ? ucwords($cusers->business_name) : "" ;
                            }
                            $profile=isset($cusers->profile) ? $cusers->profile : "" ;
                            $city=isset($cusers->city) ? $cusers->city : "" ;
                            $state=isset($cusers->state) ? $cusers->state : "" ;
                            $country=isset($cusers->country) ? $cusers->country : "";

                            $history = array();
                            $ques_[0] = starRating($row->ques_1);
                            $ques_[1] = starRating($row->ques_2);
                            $ques_[2] = starRating($row->ques_3);
                            $ques_[3] = starRating($row->ques_4);
                            $ques_[4] = starRating($row->ques_5);

                            $ques_['rate_id']=isset($row->id)?$row->id:'';
                            $ques_['reply']=isset($row->reply)?$row->reply:'';
                            $ques_['message']=$row->message;
                            $ques_['anonymous']=$row->anonymous;
                            $ques_['company_id']=$companyId;
                            $ques_['retedbyid']=$row->rated_by_user;
                            $ques_['givername']=$givername;
                            $ques_['profile']=$profile;
                            $ques_['user_role'] = $cusers->user_role;
                            $ques_['address']=trim($city).', '.trim($state).', '.trim($country);

                            if($cusers->user_role != 'Employer'){
                                $ques_['star_ratings'] = userOverallRatings($cusers->id);
                            }

                            $indivReview[$business_name][]= $ques_;
                        }else{
                            $ques_['rate_id']=isset($row->id)?$row->id:'';
                            $ques_['reply']=isset($row->reply)?$row->reply:'';
                            $ques_['message']=isset($row->message)?$row->message:'';
                            $ques_['anonymous']=isset($row->message)?$row->anonymous:0;
                            $ques_['company_id']=isset($companyId)?$companyId:'';
                            $ques_['retedbyid']=isset($row->rated_by_user)?$row->rated_by_user:'';
                            $ques_['givername']='Unknown';
                            $ques_['user_role'] = '';
                            $ques_['profile']='';
                            $ques_['address']='';
                            $ques_['star_ratings'] = starRating(0);
                            $indivReview[$business_name][]= $ques_;
                        }
                    }


                } else{
                    // for($i=0;$i<=5;$i++){
                    //  $ques_[$i] = starRating(0);
                    // }
                    // $indivReview[$business_name]['historyRating'][]= $ques_;
                    $indivReview[] = "empty";
                }
            //}
            $data['MyhistoryRating'] = $indivReview;
            $data['user_id'] = $user_id;
            $data['userType'] = 'self';
            $this->load->view('frontend/review_filter',$data); 
        }
    }

    public function replyToReview(){
        $rateID = $this->input->post('rate_id');
        $reply = '<p>'.$this->input->post('reply').'</p>';
        $this->common_model->updateFields(RATINGS,array('reply'=>$reply),array('id'=>$rateID));
        echo json_encode(array('status'=>1));
    }

    public function getGroupData(){
        $user_id = get_current_user_id();
        $id = $this->input->post('id');
        $groupMembers = $this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$id));
        $members = explode(',', $groupMembers->group_members);
        unset($members[array_search(get_current_user_id(), $members)]);
        echo json_encode(array('groupMembers'=>$members,'name'=>$groupMembers->name,'image'=>$groupMembers->group_icon));
    }

    /*function for adding favourites*/
    public function addToFavourite(){
        $status = 0;
            if($this->checkUserLogin()){
            if(!$this->input->is_ajax_request()){
                echo json_encode(array('response'=>'Invalid request'));
            }
            $dataArr['added_to'] = $this->input->post('other_id');
            $dataArr['added_by'] = get_current_user_id();
            $alreadyFavourite = $this->common_model->getsingle(FAVOURITES,$dataArr);
            if(empty($alreadyFavourite)){
                $insertedId = $this->common_model->insertData(FAVOURITES,$dataArr);
                if($insertedId){
                    $status = 1;
                }
                echo json_encode(array('status'=>$status));
                die;
            }else{
                $status = 2;
                if($this->common_model->deleteData(FAVOURITES,$dataArr)){
                    echo json_encode(array('status'=>$status));
                    die;
                }
            }
        }else{
            echo json_encode(array('status'=>$status));
            exit;
        }
    }

    /*to get favourites list*/
    public function favourites_list(){
        $data = array();
        $currentUser =  get_current_user_id();
        $data['favouritesData'] = $this->common_model->GetJoinRecord(FAVOURITES,'added_to',USERS,'id','tb_users.id as user_id,tb_users.*',array('added_by'=>$currentUser));
        $data['user_data'] = $this->common_model->getsingle(USERS,array('id'=>$currentUser));
        $this->pageview('favourites_list',$data,$data,array()); 
    }

    /*function for newsletter in footer*/
    function newsletter(){
        if($this->input->post()){
            $email = trim($_POST['semail']);
            if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                $apiKey = 'eb4b4765f70da55c967303b8194aae37-us19';
                $listID = 'f6a4f27f80';
                $memberID = md5(strtolower($email));
                $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
                $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
                $json = json_encode([
                    'email_address' => $email,
                    'status'        => 'subscribed',
                    'merge_fields'  => [
                        'NAME'     => '',
                    ]
                ]);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                //echo json_encode($result);
                if ($httpCode == 200) {
                    $from = "noreply@workadvisor.co";    
                    $subject = 'WorkAdvisor.co subscription';  
                    $message = '';
                    $message .= 'You have successfully subscribed to WorkAdvisor.co.<br><br>';
                    $message .= '<a href="'.base_url().'user/unsubscribe/'.encoding($email).'" target="_blank">Unsubscribe</a><br><br>';
                    $config['protocol'] = 'ssmtp';
                    $config['smtp_host'] = 'ssl://ssmtp.gmail.com';
                    $config['mailtype'] = 'html';
                    $config['newline'] = '\r\n';
                    $config['charset'] = 'utf-8';
                    $this->load->library('email', $config);
                    $this->email->initialize($config);
                    $mailData = array();
                    $mailData['message'] = $message;
                    $mailData['username'] = '';
                    $message = $this->load->view('frontend/mailtemplate',$mailData,true);
                    $this->email->from($from);
                    $this->email->to($email);
                    $this->email->subject($subject);
                    $this->email->message($message);
                    $this->email->set_header('From', $from);
                    $this->email->send();
                    $message = '<p style="color:#1a945c !important;">You have successfully subscribed to WorkAdvisor.co.</p>';
                } else {
                    switch ($httpCode) {
                        case 214:
                        $message = 'You are already subscribed.';
                        break;
                        default:
                        $message = 'Some problem occurred, please try again.';
                        break;
                    }
                    $message = '<p style="color:red !important;">'.$message.'</p>';
                }
            }else{
                $message = '<p style="color:red !important;">Please enter valid email address.</p>';
            }
        }
        echo json_encode(array('message'=>$message));
    }

    public function unsubscribe($email){
        require_once APPPATH.'libraries/mailchimp/src/Mailchimp.php';
        $api_key = 'eb4b4765f70da55c967303b8194aae37-us19';
        $list_id = 'f6a4f27f80';
        $email   = decoding($email);
        $Mailchimp  = new Mailchimp( $api_key );
        $Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );

        $unsubscribe = $Mailchimp_Lists->unsubscribe(
            $list_id,
            array('email'=>$email),      
            TRUE,      
            FALSE,    
            FALSE  
        );
        if($unsubscribe) {
            //echo "<h3 style='text-align:center;margin-top:100px;color:green;'>Unsubcribed successfully<h3>";
            $from = "noreply@workadvisor.co";    
            $subject = 'WorkAdvisor.co subscription';  
            $message = '';
            $message .= 'You have successfully unsubscribed from WorkAdvisor.co.<br><br>';
            $config['protocol'] = 'ssmtp';
            $config['smtp_host'] = 'ssl://ssmtp.gmail.com';
            $config['mailtype'] = 'html';
            $config['newline'] = '\r\n';
            $config['charset'] = 'utf-8';
            $this->load->library('email', $config);
            $this->email->initialize($config);
            $mailData = array();
            $mailData['message'] = $message;
            $mailData['username'] = '';
            $message = $this->load->view('frontend/mailtemplate',$mailData,true);
            echo $message;
        } else {
            echo json_encode(array('response'=>'Invalid request'));
        }
    }

    public function accept_job($type){
        if($type == 'per'){
            $this->session->set_userdata('request_redirect',1);
            redirect('businessprofile');
        }else if($type == 'emp'){
            $this->session->set_userdata('friends_redirect',1);
            redirect('profile');
        }
    }

    /*function for deleting review*/
    public function deleteReview($ratedTo,$ratedBy){
        $ratedTo = decoding($ratedTo);
        $ratedBy = decoding($ratedBy);
        $this->common_model->deleteData(RATINGS,array('rated_to_user'=>$ratedTo,'rated_by_user'=>$ratedBy));
        redirect($_SERVER['HTTP_REFERER']);
    }

    /*function for posting a comment*/
    public function postComment(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $dataInsert = array();
            $dataInsert['user_id'] = get_current_user_id();
            $dataInsert['comments'] = $this->input->post('comment');
            $dataInsert['post_id'] = $this->input->post('post_id');
            $commentID = $this->common_model->insertData(COMMENTS,$dataInsert);
            // $commentData = $this->common_model->getsingle(COMMENTS,array('id'=>$commentID));
            $commentData = $this->common_model->GetJoinRecord(COMMENTS,'user_id',USERS,'id','comments.*,tb_users.firstname,tb_users.lastname,tb_users.profile',array('comments.id'=>$commentID));
            $comment = isset($commentData['result'][0])? $commentData['result'][0]:'';
            $html = '';
            if(!empty($comment)){
                $html.= '<div class="wa_app_comm">';
                if(!empty($comment->profile)){
                    $html.='<img src="'.$comment->profile.'">';
                }else{
                    $html.='<img src="'.DEFAULT_IMAGE.'">';
                }
                $html.='<h4>'.$comment->firstname.' '.$comment->lastname.'</h4>';
                $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                $text = $comment->comments;
                if(preg_match($reg_exUrl, $text, $url)) {
                    $comments = preg_replace($reg_exUrl, "<a href='".$url[0]."' target='_blank'>{$url[0]}</a>", $text);
                } else {
                    $comments = $text;
                }

                $html.='<p>'.$comments.'</p>';
                if(get_current_user_id() == $comment->user_id){
                    $html.='<i class="fa fa fa-trash-o" data-comment_id="'.$comment->id.'" data-toggle="modal" data-target="#modalDeleteComment"></i>';
                }
                $html.='</div>';
            }
            echo json_encode(array('html'=>$html));
        }
    }
     /*function for deleting a comment*/
    public function deleteComment(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $commentID = $this->input->post('comment_id');
            if($this->common_model->deleteData(COMMENTS,array('id'=>$commentID))){
                echo json_encode(array('status'=>1));
            }else{
                echo json_encode(array('status'=>0));
            }
        }
    }
/*function to assign task*/
    public function addTasks(){
        if($this->input->post()){
            $taskMembers = $this->input->post('task_members');
            $dataUpdate['title'] = $this->input->post('title');
            $dataUpdate['description'] = $this->input->post('description');
            $dataUpdate['start_date'] = date('Y-m-d',strtotime($this->input->post('start_date')));
            $dataUpdate['end_date'] = date('Y-m-d',strtotime($this->input->post('end_date')));
            $dataUpdate['assigned_by'] = get_current_user_id();
            $senderData = $this->common_model->getsingle(USERS,array('id'=>$dataUpdate['assigned_by']));
            $message1 = 'Task successfully added!';

            if($this->input->post('task_id')){
                $message1 = 'Task successfully updated!';
                $taskID = $this->input->post('task_id');
                $this->common_model->updateFields(TASK,$dataUpdate,array('id'=>$taskID));
            }else{
                $taskID = $this->common_model->insertData(TASK,$dataUpdate);
            }
            $getAllMemberTasks = $this->common_model->getAllwhere(TASK_ASSIGNED,array('task_id'=>$taskID));
            if(!empty($getAllMemberTasks['result'])){
                foreach($getAllMemberTasks['result'] as $memberData){
                    if(!in_array($memberData->user_id,$taskMembers)){
                        $this->common_model->deleteData(TASK_ASSIGNED,array('id'=>$memberData->id));
                    }
                }
            }

            if(!empty($taskMembers)){
                $taskArr = array();
                foreach($taskMembers as $member){
                    $taskExist = $this->common_model->getsingle(TASK_ASSIGNED,array('task_id'=>$taskID,'user_id'=>$member));
                    if(empty($taskExist)){
                        $memberTask['task_id'] = $taskID;
                        $memberTask['user_id'] = $member;
                        $taskArr[] = $memberTask;
                        /*to send the mail for assigned task*/
                        $userDetails = $this->common_model->getsingle(USERS,array('id'=>$member));
                        $message = '';
                        $from = "noreply@workadvisor.co";    
                        $subject = 'New Task'; 
                        $message = ' Hey '.ucwords($userDetails->firstname.' '.$userDetails->lastname).'! <a href="'.base_url().'viewdetails/profile/'.encoding($senderData->id).'" target="_blank">'.ucwords($senderData->business_name).'</a> sent you a new task on WorkAdvisor.co.<br><br>';
                        $message .= '<a style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;
                        color: #ffffff;background: #008000;line-height: 3;padding:15px;" href="'. base_url().'profile?page=task">Tasks</a><br/><br/>';

                        $config['protocol'] = 'ssmtp';
                        $config['smtp_host'] = 'ssl://ssmtp.gmail.com';
                        $config['mailtype'] = 'html';
                        $config['newline'] = '\r\n';
                        $config['charset'] = 'utf-8';
                        $this->load->library('email');
                        $this->email->initialize($config);
                        $mailData = array();
                        $mailData['message'] = $message;
                        $mailData['username'] = '';
                        $message = $this->load->view('frontend/mail_temp',$mailData,true);
                        $this->email->from($from);
                        $this->email->to($userDetails->email);
                        $this->email->subject($subject);
                        $this->email->message($message);
                        $this->email->set_header('From', $from);
                        if($this->email->send()){
                        }

                    }
                }
                if(!empty($taskArr)){
                    $this->db->insert_batch(TASK_ASSIGNED, $taskArr);
                }
            }
            $this->session->set_flashdata('updatemsg','<div class="alert alert-success text-center">'.$message1.'</div>');                 
            redirect('profile');
        }
    }

    /*function to fetch task data*/
    public function taskData(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $taskDataArr = array();
            $taskID = $this->input->post('taskID');
            $taskData = $this->common_model->GetJoinRecord(TASK,'id',TASK_ASSIGNED,'task_id','task.*,GROUP_CONCAT(task_assigned.user_id) as user_ids',array('task.id'=>$taskID),'task_assigned.task_id');
            if(!empty($taskData['result'])){
                $taskDataArr = $taskData['result'];
            }
            echo json_encode(array('taskDataArr'=>$taskDataArr));
        }
    }

    /*function to get my tasks*/
    public function getMyTasks(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            if($this->input->post('taskID')){
                $taskInfo = array();
                $taskID = $this->input->post('taskID');
                $assignedTo = $this->input->post('assignedTo');
                if($assignedTo == 0){
                    $taskData = $this->common_model->GetJoinRecord(TASK,'id',TASK_ASSIGNED,'task_id','task.*,task_assigned.note,task_assigned.status',array('task.id'=>$taskID,'user_id'=>get_current_user_id()),'');
                    $this->common_model->updateFields(TASK_ASSIGNED,array('notification_status'=>1),array('task_id'=>$taskID,'user_id'=>get_current_user_id()));
                }else{
                    $taskData = $this->common_model->GetJoinRecord(TASK,'id',TASK_ASSIGNED,'task_id','task.*,task_assigned.note,task_assigned.status',array('task.id'=>$taskID,'task_assigned.user_id'=>$assignedTo),'');
                }
                if(!empty($taskData['result'][0])){
                    $taskInfo = (array)$taskData['result'][0];
                }
                echo json_encode(array('taskData'=>$taskInfo));
            }else{
                $userID = get_current_user_id();
                $data['taskList'] = $this->common_model->GetJoinRecord(TASK,'id',TASK_ASSIGNED,'task_id','task.*',array('task_assigned.user_id'=>$userID,'notification_status'=>0),'','created_date','DESC');
                $taskCount = $data['taskList']['total_count'];
                $html = $this->load->view('frontend/my_task_list',$data,true);
                echo json_encode(array('html'=>$html,'taskCount'=>$taskCount));
            }
        }
    }

    /*function to update my task status*/
    public function updateTaskStatus(){
        if($this->input->post()){
            $user_id = get_current_user_id();
            $dataUpdate['note'] = $this->input->post('note');
            $dataUpdate['status'] = $this->input->post('status');
            $taskId = $this->input->post('taskId');
            $taskData = $this->common_model->GetJoinRecord(TASK,'assigned_by',USERS,'id','tb_users.business_name,tb_users.email,tb_users.new_task_notification,task.title',array('task.id'=>$taskId));
			
            $status = $dataUpdate['status'];
            if($status == 0){
                $status = 'Pending';
            }
            else if($status == 1){
                $status = 'Process';
            }else if($status == 2){
                $status = 'Completed';
            }else if($status == 3){
                $status = 'Incomplete';
            }
            /*to send to employer the mail for assigned task*/
            $userDetails = $this->common_model->getsingle(USERS,array('id'=>$user_id));
            if(!empty($taskData['result'][0]) && ($taskData['result'][0]->new_task_notification == 1)){
                $message = '';
                $from = "noreply@workadvisor.co";    
                $subject = 'Task Status'; 
                $message = ' Hey '.ucwords($taskData['result'][0]->business_name).'! <a href="'.base_url().'viewdetails/profile/'.encoding($userDetails->id).'" target="_blank">'.ucwords($userDetails->firstname.' '.$userDetails->lastname).'</a> has updated the status of the task <b>"'.ucfirst($taskData['result'][0]->title).'"</b> as <b>"'.$status.'"</b> on WorkAdvisor.co.<br><br>';
                $message .= '<a style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;
                color: #ffffff;background: #008000;line-height: 3;padding:15px;" href="'. base_url().'profile?page=task">Tasks</a><br/><br/>';

                $config['protocol'] = 'ssmtp';
                $config['smtp_host'] = 'ssl://ssmtp.gmail.com';
                $config['mailtype'] = 'html';
                $config['newline'] = '\r\n';
                $config['charset'] = 'utf-8';
                $this->load->library('email');
                $this->email->initialize($config);
                $mailData = array();
                $mailData['message'] = $message;
                $mailData['username'] = '';
                $message = $this->load->view('frontend/mail_temp',$mailData,true);
                $this->email->from($from);
                $this->email->to($taskData['result'][0]->email);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->set_header('From', $from);
                if($this->email->send()){
                }
            }
            $this->common_model->updateFields(TASK_ASSIGNED,$dataUpdate,array('task_id'=>$taskId,'user_id'=>$user_id));
            $this->session->set_flashdata('updatemsg','<div class="alert alert-success text-center">Task status updated successfully</div>');                 
            redirect('profile');
        }
    }

    /*function to update post data*/
    public function updatepostdata_post(){
        if($this->input->post()){
            $user_id = get_current_user_id();
            $dataUpdate['note'] = $this->input->post('note');
            $dataUpdate['status'] = $this->input->post('status');
            $taskId = $this->input->post('taskId');
            $taskData = $this->common_model->GetJoinRecord(TASK,'assigned_by',USERS,'id','tb_users.business_name,tb_users.email,tb_users.new_task_notification,task.title',array('task.id'=>$taskId));

            $status = $dataUpdate['status'];
            if($status == 0){
                $status = 'Pending';
            }
            else if($status == 1){
                $status = 'Process';
            }else if($status == 2){
                $status = 'Completed';
            }else if($status == 3){
                $status = 'Incomplete';
            }
            /*to send to employer the mail for assigned task*/
            $userDetails = $this->common_model->getsingle(USERS,array('id'=>$user_id));
            if(!empty($taskData['result'][0]) && ($taskData['result'][0]->new_task_notification == 1)){
                $message = '';
                $from = "noreply@workadvisor.co";    
                $subject = 'Task Status'; 
                $message = ' Hey '.ucwords($taskData['result'][0]->business_name).'! <a href="'.base_url().'viewdetails/profile/'.encoding($userDetails->id).'" target="_blank">'.ucwords($userDetails->firstname.' '.$userDetails->lastname).'</a> has updated the status of the task <b>"'.ucfirst($taskData['result'][0]->title).'"</b> as <b>"'.$status.'"</b> on WorkAdvisor.co.<br><br>';
                $message .= '<a style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;
                color: #ffffff;background: #008000;line-height: 3;padding:15px;" href="'. base_url().'profile?page=task">Tasks</a><br/><br/>';

                $config['protocol'] = 'ssmtp';
                $config['smtp_host'] = 'ssl://ssmtp.gmail.com';
                $config['mailtype'] = 'html';
                $config['newline'] = '\r\n';
                $config['charset'] = 'utf-8';
                $this->load->library('email');
                $this->email->initialize($config);
                $mailData = array();
                $mailData['message'] = $message;
                $mailData['username'] = '';
                $message = $this->load->view('frontend/mail_temp',$mailData,true);
                $this->email->from($from);
                $this->email->to($taskData['result'][0]->email);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->set_header('From', $from);
                if($this->email->send()){
                }
            }
            $this->common_model->updateFields(TASK_ASSIGNED,$dataUpdate,array('task_id'=>$taskId,'user_id'=>$user_id));
            $this->session->set_flashdata('updatemsg','<div class="alert alert-success text-center">Task status updated successfully</div>');                 
            redirect('profile');
        }
    }

public function saveOldMessages1(){

        $this->load->view('frontend/old_message',$data);
    }

    function saveOldMessages(){
        $messageData = $this->common_model->getAllwhere(MESSAGES);
        echo json_encode(array('messageData'=>$messageData['result']));
    }

    function insertFirebaseMessage(){
        if($this->input->post()){
            $insertData['sender'] = $this->input->post('sender');
            $insertData['receiver'] = $this->input->post('receiver');
            $message = $this->input->post('message');
            $image = $this->input->post('image');
            $video = $this->input->post('video');
            $documentF = $this->input->post('documentF');
            $isGroup = $this->input->post('is_group');
            if($message!=''){
                $insertData['message'] = $message;
            }else if($image!=''){
                $insertData['message'] = $image;
            }else if($video!=''){
                $insertData['message'] = $video;
            }else if($documentF!=''){
                $insertData['message'] = $documentF;
            }
            if($isGroup!=''){
                $insertData['is_group'] = 1;
                $insertData['group_id'] = $insertData['receiver'];
            }
            $insertData['message_date'] = date('Y-m-d H:i:s');
            $this->common_model->insertData(MESSAGES,$insertData);

            $notiF = array();
            $notiF['sender'] = $insertData['sender'];
            $notiF['msg'] = "MSG";
            if($isGroup!=''){
                $groupMembers = $this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$insertData['receiver']));
                if(!empty($groupMembers->group_members)){
                    $members = explode(',',$groupMembers->group_members);
                    foreach($members as $row){
                        if($sender!=$row){
                            $notiF['receiver'] = $row;
                            $notiF['is_group'] = 1;
                            $notiF['group_id'] = $insertData['receiver'];
                            $this->common_model->insertData('notifications',$notiF);
                        }
                    }
                }
            }else{
                $notiF['receiver'] = $insertData['receiver'];
                if($isGroup != 'group'){
                    $this->common_model->insertData('notifications',$notiF);
                }
            }
        }
    }

    /*To store the data of likes*/
    public function likePost(){
        if(get_current_user_id()){
            if($this->input->post()){
                $dataGet['liked_by'] = get_current_user_id();
                $dataGet['post_id'] = $this->input->post('postID');
                $likeData = $this->common_model->getsingle(LIKE,$dataGet);
                if(!empty($likeData)){
                    $status = 0;
                    $postStatus = $likeData->status;
                    if($postStatus == 0){
                        $status = 1;
                    }
                    $this->common_model->updateFields(LIKE,array('status'=>$status),$dataGet);
                }else{
                    $dataGet['status'] = 1;
                    $dataGet['like_date'] = date('Y-m-d H:i:s');
                    $dataGet['posted_by'] = $this->input->post('otherUser');
                    $this->common_model->insertData(LIKE,$dataGet);
                    
                    $dataInsert['sender'] = get_current_user_id();
                    $dataInsert['receiver'] = $this->input->post('otherUser');
                    $dataInsert['msg'] = 'LIKE';
                    $this->common_model->insertData('notifications',$dataInsert);
                }
                echo json_encode(array('status'=>1,'msg'=>'Post liked successfully'));
                exit;
            }
        }else{
            $ret=array('status'=>0,'msg'=>'Login first');
            echo json_encode($ret);
            exit;
        }
    }
}