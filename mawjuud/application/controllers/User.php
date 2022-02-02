<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set('display_errors', 1);
class User extends CI_Controller {
    public function __construct(){
        parent::__construct();
    }  
    public function index(){
    }

    /*to check if the user is already exist*/
    function userRegistrationStatus(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $email=$this->input->post('user_email');
            $details=$this->common_model->getsingle(PROPERTY_USERS,array('email'=>$email));
            if(!empty($details)){
                $arr['userdata']=$details;
                $arr['result']=1;
                $arr['msg']='User Exist'; 
            }else{
                $arr['result']=0;
                $arr['msg']='New User';
            }
            $this->session->set_userdata('user_email',$email);
            echo json_encode($arr);
            exit(); 
        }
    }


    /*to check or create user password*/
    function userPassword($type){
        $status = 0;
        $email = '';
        if($this->session->userdata('user_email')){
            $email = $this->session->userdata('user_email');
        }
        $passwords = '';
        if($type == 'enter'){
            $passwords = md5(trim($this->input->post('enter_password')));
            $password = md5(trim($this->input->post('enter_password')));
            $userDetails = $this->common_model->getsingle(PROPERTY_USERS,array('email'=>$email,'password'=>$password,'login_type'=>'normal'));
            if(!empty($userDetails)){
                $status = 1;
            }
        }else if($type == 'create'){
            $dataInsert = array();
            $dataInsert['email'] = $email;
            $dataInsert['verify_status'] = 'unverified';
            $dataInsert['login_type'] = 'normal';
            $passwords = md5(trim($this->input->post('create_password')));
            $dataInsert['password'] = md5(trim($this->input->post('create_password')));
            if($this->common_model->insertData(PROPERTY_USERS,$dataInsert)){
                $status = 2;
                $message = '';
                $from = 'info@mawjuud.com';
                $subject = 'Hi there, Please verify your account';
                $config['protocol'] = 'ssmtp';
                $config['smtp_host'] = 'ssl://ssmtp.gmail.com';
                $config['mailtype'] = 'html';
                $config['newline'] = '\r\n';
                $config['charset'] = 'utf-8';
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $mailData = array();
                $mailData['username'] = "";
                $mailData['url_verify'] = base_url().'user/verify?email=' . $dataInsert['email'];
                $message = $this->load->view('frontend/signup_template',$mailData,true);
                $this->email->from($from,'Mawjuud.com');
                $this->email->to($email);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->set_header('From','Mawjuud.com');
                $this->email->send();
            }
        }

        $userDetails = $this->common_model->getsingle(PROPERTY_USERS,array('email'=>$email,'password'=>$passwords,'login_type'=>'normal'));
        if(isset($userDetails->verify_status) && ($userDetails->verify_status == 'unverified')){
            $status = 4;
        }
        else if(isset($userDetails->user_type) && ($userDetails->user_type != '')){
                $status = 3;
        }
        if($status != 0 && $status != 4){
            $sessionData = array(
                'username' => $userDetails->email,
                'user_number' => $userDetails->user_number,
                'code' => $userDetails->user_country_code,
                'user_role' => $userDetails->user_type,
                'user_id' => $userDetails->id,
                'profile_thumbnail' => $userDetails->profile_thumbnail,
            );
            $this->session->set_userdata('sessionData',$sessionData);
        }
        $actual_link = $this->session->userdata('redirect_url');
        if($actual_link!='' && $actual_link!=base_url()){
            if($this->session->userdata('sessionData')){
                if((strpos($actual_link, 'pass=password') !== false) || (strpos($actual_link, 'popup=login') !== false)){
                    $url_data = parse_url($actual_link);
                    $actual_link = str_replace('?'.$url_data['query'], '', $actual_link);
                }
            }
        }else{
            $actual_link = base_url().'user/myaccount';
        }
        echo json_encode(array('status'=>$status,'redirect_url'=>$actual_link));
        die;
    }


    /*user signup*/
    public function userSignUp(){
        if(!$this->input->is_ajax_request()){
            exit('No direct script access allowed'); 
        }
        if($this->input->post()){
            $dataInsert = array();
            $dataInsert['firstname'] = $this->input->post('firstnameSignup');
            $dataInsert['lastname'] = $this->input->post('lastnameSignup');
            $dataInsert['mobile_no'] = $this->input->post('mobile_no');
            $dataInsert['email'] = trim($this->input->post("emailSignup"));
            $dataInsert['password'] = md5(trim($this->input->post("pass1Signup")));
            $dataInsert['user_type'] = $this->input->post('register_as_agent');
            $dataInsert['verify_status'] = "unverified";
            $dataInsert['login_type'] = "normal";
            if($this->user_model->checkUserRegister($dataInsert['email'])){
                $arr['msg']="Already registered. Please login.";
                $arr['result']=0;// when the user is already registered
                echo json_encode($arr);
                exit();
            }
            if($this->common_model->insertData(PROPERTY_USERS,$dataInsert)){
                $message = '';
                $message .='<img src="'.base_url().'/assets/images/logogreen.png"/>';
                $message .= "<p>Hi there  ,\r\n
                You're seconds away from connecting with 1,000+ members who are looking for \r\n
                a roommate right now.</p>\r\n\r\n";
                $message .= '<a style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;
                color: #ffffff;background: #f26d35;line-height: 3;padding:15px;" href='. base_url().'/user/verify?email=' . $dataInsert['email'].'>Verify your email</a>';
                $config['protocol'] = 'ssmtp';
                $config['smtp_host'] = 'ssl://ssmtp.gmail.com';
                $config['mailtype'] = 'html';
                $config['newline'] = '\r\n';
                $config['charset'] = 'utf-8';

                $this->load->library('email', $config);

                $this->email->from('info@roomono.net', 'Roomono');
                $this->email->to($dataInsert['email']);

                $this->email->subject('Verification Email');
                $this->email->message($message);

                if ($this->email->send()){
                }else{
                    show_error($this->email->print_debugger());
                }
                $arr['result']=1;// when successfully registered
                echo json_encode($arr);
                exit();
                }else{
                    $arr['result']=2; //  when some error occured
                    echo json_encode($arr);
                    exit();
                }
            }
        }

/***To verify account*****/
public function verify(){
    if(!empty($this->input->get())){
        $email=$this->input->get('email');
        $userDetails = $this->user_model->checkUserRegister($email);
        if(!empty($userDetails)){
            if($userDetails->verify_status == 'unverified'){
                $where=array('email'=>$email);
                $details=$this->user_model->verify($where);
                if(!empty($details))
                    $updated= $this->user_model->verify_user(trim($email));
                $sessionData = array(
                    'username' => $userDetails->email,
                    'user_number' => $userDetails->user_number,
                    'code' => $userDetails->user_country_code,
                    'user_role' => $userDetails->user_type,
                    'user_id' => $userDetails->id,
                );
                $this->session->set_userdata('sessionData',$sessionData);
                redirect('/');
            }else{
                redirect(base_url().'?popup=login');
            }
        }
    }
}

function congratulations(){
    loginCheck('user');
    $this->load->view('frontend/congratulations');
}
/********* verification ***********/    
public function verification(){
    if($this->session->flashdata('message')){
        $message = $this->session->flashdata('message');
    }else{
        $message="";
    }
    $data_array['message']=$message;
    $this->template->load_front_template('verification',$data_array);
}

/*Facebook signup-signin*/
public function fbauth(){
    if($this->facebook->is_authenticated()){
        if(isset($_GET['error'])){
            redirect(base_url());
        }
        $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        $userData = array();
        $userData['firstname'] = $userProfile['first_name'];
        $userData['lastname'] = $userProfile['last_name'];
        $userData['email'] = !empty($userProfile['email'])?$userProfile['email']:'';
        $userData['password'] = '';
        $userData['oauth_uid'] = $userProfile['id'];
        $userData['verify_status'] = 'verified';
        $userData['login_type'] = 'facebook';
        $userData['profile_img'] = $userProfile['picture']['data']['url'];
        $userData['profile_thumbnail'] = $userProfile['picture']['data']['url'];
        //$userInfo = $this->common_model->getsingle(PROPERTY_USERS,array('email'=>$userProfile['email'],'login_type'=>'facebook'));
        if($userData['email']!=''){
            $userInfo = $this->common_model->getsingle(PROPERTY_USERS,array('email'=>$userProfile['email']));
            if(!empty($userInfo)){
                if($userInfo->login_type != 'facebook'){
                    $this->session->set_userdata('user_email',$userProfile['email']);
                    redirect('/?pass=password&1=1');
                }
            }
        }
        else{
            $userInfo = $this->common_model->getsingle(PROPERTY_USERS,array('oauth_uid'=>$userProfile['id'],'login_type'=>'facebook'));
        }

        if(!empty($userInfo)){
            $userData['user_type'] = $userInfo->user_type;
            $userData['profile_img'] = $userInfo->profile_img;
            $userData['profile_thumbnail'] = $userInfo->profile_thumbnail;
        }else{
            $userData['user_type'] = '';
        }
        $userID = $this->common_model->checkUser($userData);
        if(!empty($userID)){
            $this->session->set_userdata('loggedIn', true);
            $this->session->set_userdata('sessionData',$userData);
        }else{
            $data['userData'] = array();
        }
        $headerdata['logoutUrl'] = $this->facebook->logout_url();
    }
    $data['authUrl'] = $this->facebook->login_url();
    $data['loginURL'] = $this->googleplus->loginURL();
    // $where = array('email'=>$userData['email'],'login_type'=>'facebook');
    if($userData['email']!=''){
        $where = array('email'=>$userData['email']);
        $details=$this->common_model->getsingle(PROPERTY_USERS,$where);
    }else{
        $where = array('oauth_uid'=>$userData['oauth_uid']);
        $details=$this->common_model->getsingle(PROPERTY_USERS,$where);
    }

    if(!empty($details)){
        $sessionData = array(
            'username' => $details->email,
            'user_role' => $details->user_type,
            'first_name' => $details->firstname,
            'last_name' => $details->lastname,
            'user_id' => $details->id,
            'user_number' => $details->user_number,
            'code' => $details->user_country_code,
            'profile_thumbnail' => $details->profile_thumbnail
        );
        $this->session->set_userdata('sessionData',$sessionData);
        if($details->user_type=='')
            redirect('/');
        else{
            $actual_link = $this->session->userdata('redirect_url');
            if($actual_link!='' && $actual_link!=base_url() && (stripos($actual_link, 'popup=login') === false)){
                redirect($actual_link);
            }else{
                redirect('user/myaccount');
            }
        }
    }

}

/*google signup-signin*/
public function googleplus(){
    if(isset($_GET['code'])){
        $this->googleplus->getAuthenticate();
        $gpInfo = $this->googleplus->getUserInfo();
        $userData = array();
        $userData['firstname'] = $gpInfo['given_name'];
        $userData['lastname'] = $gpInfo['family_name'];
        $userData['email'] = $gpInfo['email'];
        $userData['password'] = '';
        $userData['oauth_uid'] = $gpInfo['id'];
        $userData['verify_status'] = 'verified';
        $userData['login_type'] = 'google';
        $userData['profile_img'] = !empty($gpInfo['picture'])?$gpInfo['picture']:'';;
        $userData['profile_thumbnail'] = !empty($gpInfo['picture'])?$gpInfo['picture']:'';;
        //$userInfo =$this->common_model->getsingle(PROPERTY_USERS,array('email'=>$userData['email'],'login_type'=>'google'));
        $userInfo = $this->common_model->getsingle(PROPERTY_USERS,array('email'=>$gpInfo['email']));
        if(!empty($userInfo)){
            if($userInfo->login_type != 'google'){
                $this->session->set_userdata('user_email',$gpInfo['email']);
                redirect('/?pass=password&1=1');
            }
        }

        if(!empty($userInfo)){
            $userData['user_type'] = $userInfo->user_type;
            $userData['profile_img'] = $userInfo->profile_img;
            $userData['profile_thumbnail'] = $userInfo->profile_thumbnail;
        }else{
            $userData['user_type'] = '';
        }
        $userID = $this->common_model->checkUser($userData);
        if(!empty($userID)){
            $this->session->set_userdata('loggedIn', true);
            $this->session->set_userdata('sessionData',$userData);
        }else{
            $data['userData'] = array();
        }
        $headerdata['logoutUrl'] = $this->facebook->logout_url();
    }
    $data['authUrl'] = $this->facebook->login_url();
    $data['loginURL'] = $this->googleplus->loginURL();

    // $where = array('email'=>$userData['email'],'login_type'=>'google');
    $where = array('email'=>$userData['email']);
    $details=$this->common_model->getsingle(PROPERTY_USERS,$where);
    if(!empty($details)){
        $sessionData = array(
            'username' => $details->email,
            'user_role' => $details->user_type,
            'first_name' => $details->firstname,
            'last_name' => $details->lastname,
            'user_id' => $details->id,
            'user_number' => $details->user_number,
            'code' => $details->user_country_code,
            'profile_thumbnail' => $details->profile_thumbnail
        );
        $this->session->set_userdata('sessionData',$sessionData);
        if($details->user_type=='')
            redirect('/');
        else{
            $actual_link = $this->session->userdata('redirect_url');
            if($actual_link!='' && $actual_link!=base_url() && (stripos($actual_link, 'popup=login') === false)){
                redirect($actual_link);
            }else{
                redirect('user/myaccount');
            }
        }
    }
}

/*logout*/
public function logout() {
    $redirect = $this->session->userdata('redirect_url');
    $this->session->sess_destroy();
    redirect($redirect);
}

/*to update user category*/
public function update_category(){
    if($this->input->post()){
        $dataUpdate = array();
        $dataUpdate['user_type'] = $this->input->post('usercategory');
        $sessionData = $this->session->userdata('sessionData');
        $userID = $sessionData['user_id'];
        $this->common_model->updateFields(PROPERTY_USERS, $dataUpdate,array('id'=>$userID));
        $where = array('id'=>$userID);
        $details=$this->common_model->getsingle(PROPERTY_USERS,$where);
        if(!empty($details)){
            $sessionData = array(
                'username' => $details->email,
                'user_role' => $details->user_type,
                'first_name' => $details->firstname,
                'last_name' => $details->lastname,
                'user_id' => $details->id,
                'user_number' => $details->user_number,
                'code' => $details->user_country_code,
                'profile_thumbnail' => $details->profile_thumbnail
            );
            $this->session->set_userdata('sessionData',$sessionData);
        }
        redirect('user/congratulations');
        //redirect('user/myaccount');
    }
}

/*to load reset password view*/
public function resetPassword($id = false){
    $data = array();
    $data['user_id'] = decoding($id);
    $this->load->view('frontend/reset_password',$data);
}

/*to update resetted password*/
public function update_password(){
    $status = 0;
    if(!$this->input->is_ajax_request()){
        echo json_encode(array('response'=>'Invalid request'));
    }
    if($this->input->post()){
        $dataUpdate = array();
        $dataUpdate['password'] = md5($this->input->post('newpassword'));
        $this->common_model->updateFields(PROPERTY_USERS, $dataUpdate,array('id'=>$this->input->post('user_id')));
        $status = 1;
    }
    echo json_encode(array('status'=>$status));
}

/*to send mail to the entered mail id*/
public function sendForgotMail(){
    $status = 0;
    if(!$this->input->is_ajax_request()){
        echo json_encode(array('response'=>'Invalid request'));
    }
    if($this->input->post()){
        $email = $this->input->post('resetemail');
        $where = array('email'=>$email);
        $userData = $this->common_model->getsingle(PROPERTY_USERS,$where);
        if(!empty($userData)){
            $from = 'info@mawjuud.com';
            $subject = 'For reset password';
            $password_resetkey = encoding($userData->id);
            $firstName = $userData->firstname;
            $lastName = $userData->lastname;
            $message = "</div>
            <p>You recently requested to reset your password for Account on Mawjuud.</br>
            Click the Link below to reset it.</p>
            <p>
            <a href='".base_url()."reset_password/".$password_resetkey."' >Reset your Password</a>
            </p>
            <p>If you didn't request a password reset, please ignore this Email or reply to let us know.</p>
            ";
            sendMail($email,$from,$message,'there','Reset Password');
            $status = 1;
        }else{
            $status = 2;
        }
        echo json_encode(array('status'=>$status,'email'=>$email));
    }
}

    /*to load the myaccount page and saving porfile information*/
    public function myaccount(){
        loginCheck('user');
        $this->session->set_userdata('my_account',1);
        if($this->input->post()){
            $userId = get_current_user_id();
            $dataUpdate = array();
            $dataUpdate['firstname'] = $this->input->post('first_name');
            $dataUpdate['lastname'] = $this->input->post('last_name');
            //$dataUpdate['user_type'] = $this->input->post('category_agent');
            $dataUpdate['agency_name'] = $this->input->post('agency_name');
            $dataUpdate['user_country_code'] = $this->input->post('user_country_code');
            $dataUpdate['user_number'] = $this->input->post('user_number');
            $dataUpdate['agency_cell_code'] = $this->input->post('agency_cell_code');
            $dataUpdate['agency_cell'] = $this->input->post('agency_cell');
            $dataUpdate['agency_phone_code'] = $this->input->post('agency_phone_code');
            $dataUpdate['agency_phone'] = $this->input->post('agency_phone');
            $dataUpdate['img_name'] = $this->input->post('img_name');
            $dataUpdate['logo_name'] = $this->input->post('logo_name');
            $dataUpdate['license_description'] = $this->input->post('license_description');
            $dataUpdate['nationality'] = $this->input->post('nationality');
            if($this->input->post('licenses_number'))
                $dataUpdate['licenses_number'] = implode(",",$this->input->post('licenses_number'));
            if($this->input->post('services_area'))
                $dataUpdate['services_area'] = implode(",",$this->input->post('services_area'));
            if($this->input->post('language'))
                $dataUpdate['language'] = implode(",",$this->input->post('language'));
            $dataUpdate['profile_video'] = $this->input->post('profile_video');
            $dataUpdate['website_url'] = $this->input->post('website_url');
            $dataUpdate['blog'] = $this->input->post('blog');
            $dataUpdate['facebook_profile_url'] = $this->input->post('fb_url');
            $dataUpdate['twitter_profile_url'] = $this->input->post('twitter_url');
            $dataUpdate['linkedin_profile_url'] = $this->input->post('linkedin_url');
            $profileImgData = uploadImage('profile_img','users');
            if(!empty($profileImgData)){
                $dataUpdate['profile_img'] = base_url().$profileImgData['original'];
                $dataUpdate['profile_thumbnail'] = base_url().$profileImgData['thumb'];
            }
            $logoImgData = uploadImage('agency_logo','users');
            if(!empty($logoImgData)){
                $dataUpdate['agency_logo'] = base_url().$logoImgData['thumb'];
            }
            $where = array('id'=>$userId);
            $details=$this->common_model->getsingle(PROPERTY_USERS,$where);
            if(!empty($details)){
                $sessionData = array(
                    'username' => $details->email,
                    'user_role' => $details->user_type,
                    'first_name' => $details->firstname,
                    'last_name' => $details->lastname,
                    'user_id' => $details->id,
                    'user_number' => $details->user_number,
                    'code' => $details->user_country_code,
                    'profile_thumbnail' => $details->profile_thumbnail
                );
            $this->session->set_userdata('sessionData',$sessionData);
        }
            
            $this->common_model->updateFields(PROPERTY_USERS,$dataUpdate,array('id'=>$userId));
            //$this->session->set_flashdata('success','Profile updated successfully');
           // redirect('myaccount');
            echo json_encode(array('status'=>1));die;
        }
        $data = array();
        $userData = get_current_user_details();
        if(!empty($userData)){
            $data['userData'] = $userData;
        }
        /*to fetch call activity details*/
        $data['callActivities'] = $this->common_model->GetJoinRecordThree(CALL_ACTIVITY,'user_id',PROPERTY_USERS,'id',PROPERTY,'id',CALL_ACTIVITY,'property_id','call_activity.*,property.mawjuud_reference,property_users.firstname,property_users.lastname,bedselect,bathselect,square_feet,property.id as prop_id',array('property.user_id'=>get_current_user_id()));
       
        /*to fetch contact message details*/
        $data['contactMessages'] =  $this->common_model->GetJoinRecordThree(PROPERTY,'user_id',PROPERTY_USERS,'id',CONTACT_AGENT,'property_id',PROPERTY,'id','contact_agent.*,property.mawjuud_reference,bedselect,bathselect,square_feet,property.id as prop_id',array('property_users.id'=>get_current_user_id()));

        /*to fetch all categories*/
        $data['categories'] = $this->common_model->getAllwhere(CATEGORY);

        /*to fetch all my properties*/
        //$data['propertyData'] = $this->common_model->get_two_table_data('property.*,category.name',PROPERTY,CATEGORY,"property.listing=category.id",array('user_id'=>get_current_user_id()),'','created_date','desc');
        $data['propertyData'] = $this->common_model->get_two_table_data('property.*,category.name,category.image',PROPERTY,CATEGORY,"property.listing=category.id",array('property.id!='=>0,'approved'=>1),'','created_date','desc');

        /*to fetch all favourite properties*/
          if(get_current_user_id()){
            $favouriteProperties = $this->common_model->getAllwhere(FAVOURITE_PROPERTY,array('user_id'=>get_current_user_id(),'status'=>1));
            if(!empty($favouriteProperties['result'])){
                foreach($favouriteProperties['result'] as $property){
                    $data['favourite_properties'][] = $property->property_id;
                }
            }
            $compareProperties = $this->common_model->getAllwhere(COMPARE_PROPERTY,array('user_id'=>get_current_user_id(),'status'=>1));
            if(!empty($compareProperties['result'])){
                foreach($compareProperties['result'] as $property){
                    $data['compareProperties'][] = $property->property_id;
                }
            }
        }
        $data['searchedProperty'] = $this->common_model->getAllwhere(PROPERTY_SEARCH,array('user_id'=>get_current_user_id()),'savedate','desc');
        if($this->input->get('tab')){
            $data['tab'] = $this->input->get('tab');
        }
        $this->session->set_userdata('hideProperty','');
        $this->load->view('frontend/myaccount',$data);
    } 

    /*user change password*/
    public function changePassword(){
        if(!$this->input->is_ajax_request()){
            exit('No direct script access allowed'); 
        }
        if($this->input->post()){
            $currentPassword = md5($this->input->post('crntpwd'));
            $newPassword = md5($this->input->post('newpwd'));
            $userData = $this->common_model->getsingle(PROPERTY_USERS,array('id'=>get_current_user_id(),'password'=>$currentPassword));
            if(!empty($userData)){
                $this->common_model->updateFields(PROPERTY_USERS,array('password'=>$newPassword),array('id'=>get_current_user_id()));
                echo json_encode(array('status'=>1));
            }else{
                echo json_encode(array('status'=>2));
            }
        }
    }

    /*user change email*/
    public function changeEmail(){
        if(!$this->input->is_ajax_request()){
            exit('No direct script access allowed'); 
        }
        if($this->input->post()){
            $newemail = $this->input->post('newemail');
            $this->common_model->updateFields(PROPERTY_USERS,array('email'=>$newemail),array('id'=>get_current_user_id()));
            echo json_encode(array('status'=>1));
        }
    }

    /*agents list*/
    public function agentList(){
        $data['page'] = 'agents';
        $this->load->view('frontend/agents',$data);
    }

    public function agentsData(){
        //$columns = array(0 =>'agent1',1 => 'agent2',2 => 'agent3',3 => 'agent4');
        $columns = array(0 =>'agent1',
                        1 => 'agent2',
                        2 => 'agent3');
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $agentsData = $this->common_model->getAllwhere(PROPERTY_USERS,array('user_type'=>'agent'));
        $totalData  = $totalFiltered = $agentsData['total_count'];
        $agentDetails = $this->common_model->getAllwhere(PROPERTY_USERS,array('user_type'=>'agent'),'firstname','asc','all', $limit, $start);
        $data = array();
        if(!empty($agentDetails['result']))
        {
            $count = 0;
            foreach ($agentDetails['result'] as $agent)
            {
                $count++;
                $adata['agent']= $agent;
                if($count == 1){
                    $nestedData['agent1'] = $this->load->view('frontend/agents_info',$adata,true);
                }
                if($count == 2){
                    $nestedData['agent2'] = $this->load->view('frontend/agents_info',$adata,true);
                }
                // if($count == 3){
                //     $nestedData['agent3'] = $this->load->view('frontend/agents_info',$adata,true);
                // }
                if($count == 3){
                    $nestedData['agent3'] = $this->load->view('frontend/agents_info',$adata,true);
                    $data[] = $nestedData;
                    $count = 0;
                }
            }
        }
        $json_data = array(
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data,
        );
        echo json_encode($json_data);
    }

    /*function for fetching agent details*/
    public function agentDetails(){
        $agentID = $this->input->get('id');
        if($agentID){
            $agentID = decoding($agentID);
            $data['agentDetails'] = $this->common_model->getsingle(PROPERTY_USERS,array('id'=>$agentID));
        }
        $this->load->view('frontend/agent_details',$data);
    }

    /*function for notification settings*/
    public function notificationSettings(){
        if(!$this->input->is_ajax_request()){
            exit('No direct script access allowed'); 
        }
        if($this->input->post()){
            $userID = get_current_user_id();
            $option = $this->input->post('option');
            $dataUpdate[$option] = $this->input->post('checked');
            $this->common_model->updateFields(PROPERTY_USERS,$dataUpdate,array('id'=>$userID));
            echo json_encode(array('status'=>1));
        }
    }

    /*to get my active listings*/
    public function getMyActiveListings(){
        $location = array();
        $columns = array( 
            0 =>'address', 
            1 =>'bed_bath',
            2 =>'price',
        );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $agentID = $this->input->post('agent_id');
        $propertyCount = 0;
        $propertyData = $this->common_model->getAllwhere(PROPERTY,array('user_id'=>$agentID,'rent_sale'=>0),'created_date','DESC','all');
        if(!empty($propertyData['result'])){
            $propertyCount = $propertyData['total_count']; 
        }
        $totalData  = $totalFiltered = $propertyCount;
        if($propertyCount>0){
            $lastRecordID = $propertyData['result'][$totalData-1]->id;
            if(!empty($propertyData['result'])){ 
                $count = 0;
                foreach($propertyData['result'] as $prop){ 
                    $property = (array)$prop;
                    $location[$count][] = $property['property_address'];
                    $location[$count][] = $property['latitude'];
                    $location[$count][] = $property['longitude'];
                    $location[$count][] = $property['id'];
                    if(isset($property['thumbnail_photo_media'])){
                        $imgArray = explode('|',$property['thumbnail_photo_media']); 
                        $location[$count][] = $imgArray[0];
                    }else{
                        $location[$count][] = base_url().DEFAULT_PROPERTY_IMAGE;
                    }

                    if($property['property_type']=='sale'){
                        $location[$count][] = 'SGC1';
                    }else{
                        $location[$count][] = 'SGC';
                    }

                    $location[$count][] = isset($property['property_type'])?ucfirst($property['property_type']):'';

                    $bath = '';
                    if(isset($property['bathselect'])){
                        if($property['bathselect'] == 0){
                            $bath = '-';
                        }else {
                            $bath = $property['bathselect'];
                        }
                    }
                    $location[$count][] = $bath;

                    $bed = '';
                    if(isset($property['bedselect'])){
                        if($property['bedselect']==100)
                            $bed = 'Studio';
                        else if($property['bedselect']==0)
                            $bed = '-';
                        else 
                            $bed = $property['bedselect'];  
                    }
                    $location[$count][] = $bed;
                    $location[$count][] = isset($property['square_feet'])?number_format($property['square_feet']):'';
                    $location[$count][] =isset($property['name'])?$property['name']:'';

                    $location[$count][] =isset($property['property_address'])?ucfirst($property['property_address']):'';

                    $location[$count][] = isset($property['property_price'])?number_format($property['property_price']).' AED':'';

                    $images = isset($property['thumbnail_photo_media'])?explode(",",$property['thumbnail_photo_media']):0;
                    if($images){
                        $location[$count][] = count($images);
                    }else{
                        $location[$count][] = 0;
                    }
                    if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                        $favourite = 'fillHearts';
                        $location[$count][] = 'fillHearts';
                    }else{
                        $location[$count][] = '';
                    }
                    $location[$count][] = encoding($property['id']);
                    if(isset($property['title']) && !empty($property['title']))
                        $location[$count][] = substr($property['title'], 0, 100).'...';
                    else
                        $location[$count][] = '';
                    $count++;
                }
            }
        }
        $propertyDetails = $this->common_model->getAllwhere(PROPERTY,array('user_id'=>$agentID,'rent_sale'=>0),'created_date','DESC','all',$limit,$start);
        $data = array();
        if(!empty($propertyDetails['result']))
        {
            $count = 0;
            foreach ($propertyDetails['result'] as $propertys)
            {
                $count++;
                $property = (array)$propertys;
                $img = base_url().DEFAULT_PROPERTY_IMAGE;
                if(isset($property['thumbnail_photo_media'])){
                    $imgArray = explode('|',$property['thumbnail_photo_media']); 
                    $img = $imgArray[0];
                }
                $id = encoding($property['id']);
                $address = isset($property['property_address'])?ucfirst($property['property_address']):'';
                $html='<div class="table-activeList">
                            <a href="'.base_url().'single_property?id='.$id.'">
                                <img src="'.$img.'" alt=""/>
                                <h4>'.$address.'</h4>
                            </a>
                        </div>';
                $nestedData['address']  = $html; 

                $bed = '';
                if($property['bedselect']==100){
                    $bed = "Studio";
                }else if($property['bedselect'] == 0){
                    $bed = "";
                }else{
                    $bed = $property['bedselect'];
                }

                $bath = '';
                if(isset($property['bathselect'])){
                    if($property['bathselect'] != 0){
                        $bath =  $property['bathselect'];
                    }
                }

                $beds_baths = array();
                if($bed!=''){
                    $beds_baths[] = $bed.' Bed';
                }

                if($bed!=''){
                    $beds_baths[] = $bath.' Bath';
                }

                $bedbath='-';
                if(!empty($beds_baths)){
                    $bedbath = implode(', ',$beds_baths);
                }
                $nestedData['bed_bath'] = '<div class="bed-bath-tb">'.$bedbath.'</div>'; 

                $nestedData['price'] = '<div class="prices-tb">'.isset($property['property_price'])?number_format($property['property_price']).' AED':''.'</div>'; 
                $data[] = $nestedData;
            }
        }
        if(!empty($location) && isset($location[0])){
            $location = json_encode($location);
        }
        $json_data = array(
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data,
            'location'=> $location,
        );
        echo json_encode($json_data); 
    }

    /*to get our pas sales*/
    public function getOurPastSales(){
        $location = array();
        $columns = array( 
            0 =>'address', 
            1 =>'represented',
            2 =>'sold_date',
            3 =>'price',
        );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $agentID = $this->input->post('agent_id');
        $propertyCount = 0;
        $propertyData = $this->common_model->getAllwhere(PROPERTY,array('user_id'=>$agentID,'rent_sale'=>1),'sold_rented_date','DESC','all');
        if(!empty($propertyData['result'])){
            $propertyCount = $propertyData['total_count']; 
        }
        $totalData  = $totalFiltered = $propertyCount;
        if($propertyCount>0){
            $lastRecordID = $propertyData['result'][$totalData-1]->id;
            if(!empty($propertyData['result'])){ 
                $count = 0;
                foreach($propertyData['result'] as $prop){ 
                    $property = (array)$prop;
                    $location[$count][] = $property['property_address'];
                    $location[$count][] = $property['latitude'];
                    $location[$count][] = $property['longitude'];
                    $location[$count][] = $property['id'];
                    if(isset($property['thumbnail_photo_media'])){
                        $imgArray = explode('|',$property['thumbnail_photo_media']); 
                        $location[$count][] = $imgArray[0];
                    }else{
                        $location[$count][] = base_url().DEFAULT_PROPERTY_IMAGE;
                    }

                    if($property['property_type']=='sale'){
                        $location[$count][] = 'SGC1';
                    }else{
                        $location[$count][] = 'SGC';
                    }

                    $location[$count][] = isset($property['property_type'])?ucfirst($property['property_type']):'';

                    $bath = '';
                    if(isset($property['bathselect'])){
                        if($property['bathselect'] == 0){
                            $bath = '-';
                        }else {
                            $bath = $property['bathselect'];
                        }
                    }
                    $location[$count][] = $bath;

                    $bed = '';
                    if(isset($property['bedselect'])){
                        if($property['bedselect']==100)
                            $bed = 'Studio';
                        else if($property['bedselect']==0)
                            $bed = '-';
                        else 
                            $bed = $property['bedselect'];  
                    }
                    $location[$count][] = $bed;
                    $location[$count][] = isset($property['square_feet'])?number_format($property['square_feet']):'';
                    $location[$count][] =isset($property['name'])?$property['name']:'';

                    $location[$count][] =isset($property['property_address'])?ucfirst($property['property_address']):'';

                    $location[$count][] = isset($property['property_price'])?number_format($property['property_price']).' AED':'';

                    $images = isset($property['thumbnail_photo_media'])?explode(",",$property['thumbnail_photo_media']):0;
                    if($images){
                        $location[$count][] = count($images);
                    }else{
                        $location[$count][] = 0;
                    }
                    if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                        $favourite = 'fillHearts';
                        $location[$count][] = 'fillHearts';
                    }else{
                        $location[$count][] = '';
                    }
                    $location[$count][] = encoding($property['id']);
                    if(isset($property['title']) && !empty($property['title']))
                        $location[$count][] = substr($property['title'], 0, 100).'...';
                    else
                        $location[$count][] = '';
                    $count++;
                }
            }
        }
        $propertyDetails = $this->common_model->getAllwhere(PROPERTY,array('user_id'=>$agentID,'rent_sale'=>1),'sold_rented_date','DESC','all',$limit,$start);
        $data = array();
        if(!empty($propertyDetails['result']))
        {
            $count = 0;
            foreach ($propertyDetails['result'] as $propertys)
            {
                $count++;
                $property = (array)$propertys;
                $img = base_url().DEFAULT_PROPERTY_IMAGE;
                if(isset($property['thumbnail_photo_media'])){
                    $imgArray = explode('|',$property['thumbnail_photo_media']); 
                    $img = $imgArray[0];
                }
                $id = encoding($property['id']);
                $class="";
                $type="";
                if($property['property_type'] == 'rent'){
                    $representer = 'Renter';  
                    $class = 'mw-rented';
                    $type = 'RENTED';
                }else if($property['property_type'] == 'sale'){
                    $representer = 'Seller'; 
                    $class = 'mw-solds';
                    $type = 'SOLD';
                }
                $address = isset($property['property_address'])?ucfirst($property['property_address']):'';
                $html='<div class="table-activeList">
                            <a href="'.base_url().'single_property?id='.$id.'">
                                <img src="'.$img.'" alt=""/>
                                <h4>'.$address.'</h4>
                            </a>
                            <div class="band">
                                <div class="'.$class.'">
                                    '.$type.'
                                </div>
                            </div>
                        </div>';
                $nestedData['address']  = $html; 
                $nestedData['represented'] = '<div class="bed-bath-tb">'.$representer.'</div>'; 
                $nestedData['sold_date'] = date('d/m/Y',strtotime($property['sold_rented_date'])); 
                $nestedData['price'] = '<div class="prices-tb">'.isset($property['property_price'])?number_format($property['property_price']).' AED':''.'</div>'; 
                $data[] = $nestedData;
            }
        }
        if(!empty($location) && isset($location[0])){
            $location = json_encode($location);
        }
        $json_data = array(
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data,
            'location'=> $location,
        );
        echo json_encode($json_data); 
    }
}
?>