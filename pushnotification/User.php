<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as REST API for user
 * @package   CodeIgniter
 * @category  Controller
 * @author    MobiwebTech Team
 */

class User extends Common_API_Controller {

	function __construct() 
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
    }
    
    /**
     * Function Name: signup
     * Description:   To User Registration
    */
    function signup_post()
    {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();

        $this->form_validation->set_rules('name',lang_api('name',$this->locale),'trim|required');
        $this->form_validation->set_rules('email',lang_api('email-id',$this->locale),'trim|required|valid_email|is_unique['.USERS.'.email]');

        $this->form_validation->set_rules('password',lang_api('password',$this->locale),'trim|required|min_length[6]|max_length[14]|callback_pswd_regex_check');

        $this->form_validation->set_rules('confm_pswd',lang_api('confirm_password',$this->locale),'trim|required|min_length[6]|max_length[14]|callback_pswd_regex_check|matches[password]');
        $this->form_validation->set_rules('age',lang_api('age',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('address',lang_api('address',$this->locale),'trim|required');
        $this->form_validation->set_rules('country',lang_api('country',$this->locale),'trim|required');
        $this->form_validation->set_rules('about',lang_api('about',$this->locale),'trim|required');
        $this->form_validation->set_rules('gender',lang_api('gender',$this->locale),'trim|required|in_list[MALE,FEMALE]');
        $this->form_validation->set_rules('lat',lang_api('latitude',$this->locale),'trim|required');
        $this->form_validation->set_rules('lng',lang_api('longitude',$this->locale),'trim|required');
        $this->form_validation->set_rules('city',lang_api('city',$this->locale),'trim|required');
        $this->form_validation->set_rules('device_type', lang_api('device_type',$this->locale), 'trim|required|in_list[ANDROID,IOS]');
        $this->form_validation->set_rules('device_id', lang_api('device_id',$this->locale), 'trim|required');
        $this->form_validation->set_rules('device_key', lang_api('device_key',$this->locale), 'trim|required');
        $this->form_validation->set_message('is_unique', 'This {field} is already exist');
        if (empty($_FILES['user_image']['name']))
        {
            $this->form_validation->set_rules('user_image', lang_api('user_image',$this->locale), 'required');
        }
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {   
            $dataArr = array();
            $dataArr['name']              = extract_value($data,'name','');
            $dataArr['email']             = extract_value($data,'email','');
            $dataArr['password']          = md5(extract_value($data,'password',''));
            $dataArr['age']               = extract_value($data,'age','');
            $dataArr['address']           = extract_value($data,'address','');
            $dataArr['country']           = extract_value($data,'country','');
            $dataArr['gender']            = extract_value($data,'gender','');
            $dataArr['about']             = $data['about'];
            $dataArr['lat']               = extract_value($data,'lat','');
            $dataArr['lng']               = extract_value($data,'lng','');
            $dataArr['city']              = extract_value($data,'city','');
            $dataArr['login_session_key'] = get_guid();
            $dataArr['device_id']         = extract_value($data,'device_id','');
            $dataArr['device_type']       = extract_value($data,'device_type','');
            $dataArr['device_key']        = extract_value($data,'device_key','');
            $dataArr['is_verified']       = 0;
            $dataArr['active_pills']      = DEFAULT_ACTIVE_PILLS;
            $dataArr['created_date']      = datetime();

            /* Upload user image */
            $image = fileUpload('user_image','users','png|jpg|jpeg|gif');
            if(isset($image['error'])){
                $return['status']         =   0; 
                $return['message']        =   strip_tags($image['error']);
                $this->response($return);exit;
            }else{
                $dataArr['user_image']    =  'uploads/users/'.$image['upload_data']['file_name'];
            }

            /* Create user image thumb */
            $dataArr['user_image_thumb']  = get_image_thumb($dataArr['user_image'],'users',250,250);

            /* Insert User Data Into Users Table */
            $lid = $this->Common_model->insertData(USERS,$dataArr);
        	if($lid){

        		/* Save user device history */
        		save_user_device_history($lid,$dataArr['device_id'],$dataArr['device_type'],$dataArr['device_key']);

                /* Send verification mail to user */
                $email = $dataArr['email'];
                $token = encoding($email."-".$lid."-".time());
                $tokenArr = array('user_token' => $token);
                $this->Common_model->updateFields(USERS,$tokenArr,array('id' => $lid));
                $link = base_url().'user/verifyuser?email='.$email.'&token='.$token;
                $message  = "";
                $message .= "<img style='width:200px' src='".base_url()."assets/img/logo.png' class='img-responsive'></br></br>";
                $message .= "<br><br> Hello, <br/><br/>";
                $message .= "Your ".SITE_NAME." profile has been created. Please click on below link to verify your account. <br/><br/>";
                $message .= "Click here : <a href='".$link."'>Verify Your Email</a>";
                $this->email->to($email);
                $this->email->from(FROM_EMAIL,SITE_NAME);
                $this->email->subject('['.SITE_NAME.'] Thank you for registering with us');
                $this->email->message($message);
                $this->email->set_mailtype("html");
                $this->email->send();

                /* Return success response */
                $return['status']         =   1; 
	            $return['message']        =   lang_api('successfully_registered',$this->locale); 
        	}else{
                $return['status']         =   0; 
	            $return['message']        =   lang_api('general_error',$this->locale);
        	}
        }
        $this->response($return);
    }

    /**
     * Function Name: login
     * Description:   To User Login
     */
    function login_post()
    {
        $return['code'] =   200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('email',lang_api('email-id',$this->locale),'trim|required|valid_email');
        $this->form_validation->set_rules('password',lang_api('password',$this->locale),'trim|required');
        $this->form_validation->set_rules('device_type',lang_api('device_type',$this->locale), 'trim|required|in_list[ANDROID,IOS]');
        $this->form_validation->set_rules('device_id', lang_api('device_id',$this->locale), 'trim|required');
        $this->form_validation->set_rules('device_key', lang_api('device_key',$this->locale), 'trim|required');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {   
            $dataArr = array();
            $dataArr['email']     = extract_value($data,'email','');
            $dataArr['password']  = md5(extract_value($data,'password',''));
            $dataArr['user_type'] = 'NORMAL_USER'; 

            /* Get User Data From Users Table */
            $Status = $this->Common_model->getsingle(USERS,$dataArr);
            if(empty($Status))
            {
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_email_or_pass',$this->locale);
            }
            else if(!empty($Status) && $Status->is_verified == 0){
                $return['status']         =   0; 
                $return['message']        =   lang_api('varification_error',$this->locale);
            }
            else if(!empty($Status) && $Status->is_blocked == 1){
                $return['status']         =   0; 
                $return['message']        =   lang_api('blocked_user_error',$this->locale); 
            }
            else if(!empty($Status) && $Status->is_deactivated == 1){
                $return['status']         =   0; 
                $return['message']        =   lang_api('deactivate_user_error',$this->locale);; 
            }
            else if($Status->is_verified == 1 && $Status->is_blocked == 0 && $Status->is_deactivated == 0){

                /* Save user device history */
                save_user_device_history($Status->id,$data['device_id'],$data['device_type'],$data['device_key']);

                /* Update User Data */
                $UpdateData = array();
                $UpdateData['device_type']       = extract_value($data,'device_type',NULL);
                $UpdateData['device_id']         = extract_value($data,'device_id',NULL);
                $UpdateData['device_key']        = extract_value($data,'device_key',NULL);
                $this->Common_model->updateFields(USERS,$UpdateData,array('id' => $Status->id));
                /* Return Response */
                $response = getUserInformation($Status->id);
                $return['status']         =   1; 
                $return['response']       =   $response; 
                $return['message']        =   lang_api('successfully_login',$this->locale);
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: countries
     * Description:   To Get All Countries
     */
    function countries_post()
    {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $countries  = $this->Common_model->getAll(COUNTRY,'country_name','ASC');
        if($countries){
            /* Return Response */
            $response = array();

            foreach($countries as $r)
            {
              $country_name   = null_checker($r->country_name);  
              array_push($response, $country_name);
            }
            $return['status']    =   1; 
            $return['response']  =   $response; 
            $return['message']   =   lang_api('success',$this->locale);
        }else{
            $return['status']  =   0; 
            $return['message'] =   lang_api('countries_not_found',$this->locale);
        }
        $this->response($return);
    }

    /**
     * Function Name: resend_verification_link
     * Description:   To Re-send User Verification Link
     */
    function resend_verification_link_post()
    {
        $return['code'] =   200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('email',lang_api('email-id',$this->locale),'trim|required|valid_email');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']  =   0; 
            $return['message'] =   $error; 
        }
        else
        {   
            $dataArr = array();
            $dataArr['email'] = extract_value($data,'email','');
            $dataArr['user_type'] = 'NORMAL_USER'; 

            /* Get User Data From Users Table */
            $result = $this->Common_model->getsingle(USERS,$dataArr);
            if(empty($result))
            {
                $return['status']     =   0; 
                $return['message']    =   lang_api('email_not_exist',$this->locale); 
            }
            else{
               if($result->is_verified == 0){
                    $user_id    = $result->id;
                    $user_email = $result->email;
                    /* Update user token */
                    $token = encoding($user_email."-".$user_id."-".time());

                    $tokenArr = array('user_token' => $token);
                    $update_status = $this->Common_model->updateFields(USERS,$tokenArr,array('id' => $user_id));
                    
                    $link = base_url().'user/verifyuser?email='.$user_email.'&token='.$token;
                    $message  = "";
                    $message .= "<img style='width:200px' src='".base_url()."assets/img/logo.png' class='img-responsive'></br></br>";
                    $message .= "<br><br> Hello, <br/><br/>";
                    $message .= "Your ".SITE_NAME." profile has been created. Please click on below link to verify your account. <br/><br/>";
                    $message .= "Click here : <a href='".$link."'>Verify Your Email</a>";
                    $this->email->to($user_email);
                    $this->email->from(FROM_EMAIL,SITE_NAME);
                    $this->email->subject('['.SITE_NAME.'] Thank you for registering with us');
                    $this->email->message($message);
                    $this->email->set_mailtype("html");
                    if($this->email->send()){
                        $return['status']  =   1; 
                        $return['message'] =   lang_api('send_mail_message',$this->locale);
                    }else{
                        $return['status']  =   0; 
                        $return['message'] =   EMAIL_SEND_FAILED;
                    }
               }else{
                    $return['status']  =   0; 
                    $return['message'] =   lang_api('profile_already_verified',$this->locale);
               }
            }
        }
        $this->response($return);
    }

     /**
     * Function Name: forgot_password
     * Description:   To User Forgot Password
     */
    function forgot_password_post()
    {
        $return['code'] =   200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('email',lang_api('email-id',$this->locale),'trim|required|valid_email');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']  =   0; 
            $return['message'] =   $error; 
        }
        else
        {   
            $dataArr = array();
            $dataArr['email'] = extract_value($data,'email','');
            $dataArr['user_type'] = 'NORMAL_USER'; 

            /* Get User Data From Users Table */
            $result = $this->Common_model->getsingle(USERS,$dataArr);
            if(empty($result))
            {
                $return['status']     =   0; 
                $return['message']    =   lang_api('email_not_exist',$this->locale); 
            }
            else{
               if($result->is_verified == 1){
                    /* Update user token */
                    $email = $result->email;
                    $user_id = $result->id;
                    $token = encoding($email."-".$user_id."-".time());
                    $updateArr = array('user_token' => $token);
                    $update_status = $this->Common_model->updateFields(USERS,$updateArr,array('id' => $user_id));
                    $link = base_url().'user/resetpassword?email='.$email.'&token='.$token;
                    $message  = "";
                    $message .= "<img style='width:200px' src='".base_url()."assets/img/logo.png' class='img-responsive'></br></br>";
                    $message .= "<br><br> Hello, <br/><br/>";
                    $message .= "Somebody (hopefully you) requested a new password for the ".SITE_NAME." account for ".$result->name.". No changes have been made to your account yet.<br/><br/>";
                    $message .= "You can reset your password by clicking this <a href='".$link."'>link</a>  <br/><br/>";
                    $message .= "We'll be here to help you every step of the way. <br/><br/>";
                    $message .= "If you did not request a new password, let us know immediately by forwarding this email to ".SUPPORT_EMAIL.". <br/><br/>";
                    $message .= "Thanks, <br/>";
                    $message .= "The ".SITE_NAME." Team";
                    $this->email->to($email);
                    $this->email->from(SUPPORT_EMAIL,SITE_NAME);
                    $this->email->subject('Reset your '.SITE_NAME.' password');
                    $this->email->message($message);
                    $this->email->set_mailtype("html");
                    if($this->email->send()){
                        $return['status']  =   1; 
                        $return['message'] =   lang_api('send_mail_message',$this->locale);
                    }else{
                        $return['status']  =   0; 
                        $return['message'] =   EMAIL_SEND_FAILED;
                    }
               }else{
                    $return['status']  =   0; 
                    $return['message'] =   lang_api('verified_message',$this->locale);
               }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: social_login
     * Description:   To User Social Login/Signup
    */
    function social_login_post()
    {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('social_type', lang_api('social_type',$this->locale), 'trim|required|in_list[FACEBOOK,GOOGLE,TWITTER,INSTAGRAM]');
        $this->form_validation->set_rules('social_id',lang_api('social_id',$this->locale),'trim|required');
        if($data['social_type'] == 'FACEBOOK'){
            $this->form_validation->set_rules('email_id',lang_api('email-id',$this->locale),'trim|required|valid_email');
        }
        $this->form_validation->set_rules('device_type', lang_api('device_type',$this->locale), 'trim|required|in_list[ANDROID,IOS]');
        $this->form_validation->set_rules('device_id', lang_api('device_id',$this->locale), 'trim|required');
        $this->form_validation->set_rules('device_key', lang_api('device_key',$this->locale), 'trim|required');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {   
            $social_id = extract_value($data,'social_id','');
            $email_id  = extract_value($data,'email_id','');

            /* check social id exist or not */
            $social_details = $this->Common_model->getsingle(USERS,array('email' => $email_id,'user_type' => 'NORMAL_USER'));
           
            if(empty($social_details)){
                /* Return success response */
                $return['status']   =   1; 
                $return['response'] =   array('is_social_id_exist' => FALSE);
                $return['message']  =   lang_api('social_id_not_exist',$this->locale); 
            }else{
                if(!empty($social_details) && $social_details->is_blocked == 1){
                    $return['status']         =   0; 
                    $return['message']        =   lang_api('blocked_user_error',$this->locale); 
                    $this->response($return);exit;
                }
                else if(!empty($social_details) && $social_details->is_deactivated == 1){
                    $return['status']         =   0; 
                    $return['message']        =   lang_api('deactivate_user_error',$this->locale);
                    $this->response($return);exit;
                }

                /* Save user device history */
                save_user_device_history($social_details->id,$data['device_id'],$data['device_type'],$data['device_key']);

                /* Update User Data */
                $UpdateData = array();
                $UpdateData['device_type']       = extract_value($data,'device_type',NULL);
                $UpdateData['device_id']         = extract_value($data,'device_id',NULL);
                $UpdateData['device_key']        = extract_value($data,'device_key',NULL);
                $this->Common_model->updateFields(USERS,$UpdateData,array('id' => $social_details->id));

                /* Return Response */
                $response = getUserInformation($social_details->id);
                $response['is_social_id_exist']        = TRUE;
                $return['status']         =   1; 
                $return['response']       =   $response; 
                $return['message']        =   lang_api('login_successfully',$this->locale);
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: update_profile
     * Description:   To Update User Profile
    */
    function update_profile_post()
    {
        $data = $this->input->post();

        /* To check if user is blocked by admin */    
        check_blocked_users($data['profile_id']);
        $return['code'] = 200;
        $return['response'] = new stdClass();

        /* Get User Profile Details */
        $user_details = $this->Common_model->getsingle(USERS,array('id' => $data['profile_id'],'user_type' => 'NORMAL_USER'));
        if(empty($user_details))
        {
            $return['status']         =   0; 
            $return['message']        =   lang_api('invalid_profile_id',$this->locale);
            $this->response($return);exit;
        }

        $this->form_validation->set_rules('profile_id',lang_api('profile_id',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('name',lang_api('name',$this->locale),'trim|required');
        $this->form_validation->set_rules('age',lang_api('age',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('country',lang_api('country',$this->locale),'trim|required');
        
        if(!empty($data['password']) && empty($user_details->social_id)){
            $this->form_validation->set_rules('password',lang_api('password',$this->locale),'trim|required|min_length[6]|max_length[14]|callback_pswd_regex_check');
        }

        $this->form_validation->set_rules('about',lang_api('about',$this->locale),'trim|required');
        $this->form_validation->set_rules('address',lang_api('address',$this->locale),'trim|required');

         $this->form_validation->set_rules('lat',lang_api('latitude',$this->locale),'trim|required');
         $this->form_validation->set_rules('lng',lang_api('longitude',$this->locale),'trim|required');

         $this->form_validation->set_rules('city',lang_api('city',$this->locale),'trim|required');
         $this->form_validation->set_rules('gender',lang_api('gender',$this->locale),'trim|required|in_list[MALE,FEMALE]');
        
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {   
            $dataArr = array();
            $dataArr['name']              = extract_value($data,'name','');
            if(!empty($data['password']) && empty($user_details->social_id)){
                $dataArr['password']      = md5(extract_value($data,'password',''));
            }
            $dataArr['age']               = extract_value($data,'age','');
            $dataArr['address']           = extract_value($data,'address','');
            $dataArr['country']           = extract_value($data,'country','');
            $dataArr['gender']            = extract_value($data,'gender','');
            $dataArr['about']             = $data['about'];
            $dataArr['lat']               = extract_value($data,'lat','');
            $dataArr['lng']               = extract_value($data,'lng','');
            $dataArr['city']              = extract_value($data,'city','');

            if (isset($_FILES) && !empty($_FILES['user_image']['name'])){
                /* Upload user image */
                $image = fileUpload('user_image','users','png|jpg|jpeg|gif');
                if(isset($image['error'])){
                    $return['status']         =   0; 
                    $return['message']        =   strip_tags($image['error']);
                    $this->response($return);exit;
                }else{
                    $dataArr['user_image']    =  'uploads/users/'.$image['upload_data']['file_name'];
                }

                /* Create user image thumb */
                $dataArr['user_image_thumb']  = get_image_thumb($dataArr['user_image'],'users',250,250);
            }

            /* Update User Data Into Users Table */
            $status = $this->Common_model->updateFields(USERS,$dataArr,array('id' => $user_details->id));
            if($status){
                /* Return success response */
                $return['status']         =   1; 
                $return['message']        =   lang_api('user_details_updated_successfully',$this->locale); 
            }else{
                $return['status']         =   0; 
                $return['message']        =   NO_CHANGES;
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: social_signup
     * Description:   To User Social Registration
    */
    function social_signup_post()
    {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();

        $this->form_validation->set_rules('name',lang_api('name',$this->locale),'trim|required');
        $this->form_validation->set_rules('email',lang_api('email-id',$this->locale),'trim|required|valid_email|is_unique['.USERS.'.email]');
        $this->form_validation->set_rules('age',lang_api('age',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('address',lang_api('address',$this->locale),'trim|required');
        $this->form_validation->set_rules('country',lang_api('country',$this->locale),'trim|required');
        $this->form_validation->set_rules('about',lang_api('about',$this->locale),'trim|required');
        $this->form_validation->set_rules('gender',lang_api('gender',$this->locale),'trim|required|in_list[MALE,FEMALE]');
        $this->form_validation->set_rules('lat',lang_api('latitude',$this->locale),'trim|required');
        $this->form_validation->set_rules('lng',lang_api('longitude',$this->locale),'trim|required');
        $this->form_validation->set_rules('city',lang_api('city',$this->locale),'trim|required');
        $this->form_validation->set_rules('device_type', lang_api('device_type',$this->locale), 'trim|required|in_list[ANDROID,IOS]');
        $this->form_validation->set_rules('device_id', lang_api('device_id',$this->locale), 'trim|required');
         $this->form_validation->set_rules('device_key', lang_api('device_key',$this->locale), 'trim|required');
        $this->form_validation->set_rules('social_type', lang_api('social_type',$this->locale), 'trim|required|in_list[FACEBOOK,GOOGLE,TWITTER,INSTAGRAM]');
        $this->form_validation->set_rules('social_id',lang_api('social_id',$this->locale),'trim|required');
        $this->form_validation->set_message('is_unique', 'This {field} is already exist');
        if (isset($_FILES) && empty($_FILES['user_image']['name']))
        {
            $this->form_validation->set_rules('user_image', lang_api('user_image',$this->locale), 'required');
        }
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {   
            $dataArr = array();
            $dataArr['name']              = extract_value($data,'name','');
            $dataArr['email']             = extract_value($data,'email','');
            $dataArr['age']               = extract_value($data,'age','');
            $dataArr['address']           = extract_value($data,'address','');
            $dataArr['country']           = extract_value($data,'country','');
            $dataArr['gender']            = extract_value($data,'gender','');
            $dataArr['about']             = $data['about'];
            $dataArr['lat']               = extract_value($data,'lat','');
            $dataArr['lng']               = extract_value($data,'lng','');
            $dataArr['city']              = extract_value($data,'city','');
            $dataArr['login_session_key'] = get_guid();
            $dataArr['device_id']         = extract_value($data,'device_id','');
            $dataArr['device_type']       = extract_value($data,'device_type','');
            $dataArr['device_key']        = extract_value($data,'device_key','');
            $dataArr['social_id']         = extract_value($data,'social_id','');
            $dataArr['social_type']       = extract_value($data,'social_type','');
            $dataArr['is_verified']       = 1;
            $dataArr['active_pills']      = DEFAULT_ACTIVE_PILLS;
            $dataArr['created_date']      = datetime();

            if (isset($_FILES) && !empty($_FILES['user_image']['name']))
            {
                /* Upload user image */
                $image = fileUpload('user_image','users','png|jpg|jpeg|gif');
                if(isset($image['error'])){
                    $return['status']         =   0; 
                    $return['message']        =   strip_tags($image['error']);
                    $this->response($return);exit;
                }else{
                    $dataArr['user_image']    =  'uploads/users/'.$image['upload_data']['file_name'];
                }

                /* Create user image thumb */
                $dataArr['user_image_thumb']  = get_image_thumb($dataArr['user_image'],'users',250,250);
            }

            /* Insert User Data Into Users Table */
            $lid = $this->Common_model->insertData(USERS,$dataArr);
            if($lid){

                /* Save user device history */
                save_user_device_history($lid,$dataArr['device_id'],$dataArr['device_type'],$dataArr['device_key']);

                /* Get User Data From Users Table */
                $Status = $this->Common_model->getsingle(USERS,array('id' => $lid));

                /* Return Response */
                $response = getUserInformation($lid);

                $return['status']         =   1; 
                $return['response']       =   $response;
                $return['message']        =   lang_api('successfully_registered',$this->locale); 
            }else{
                $return['status']         =   0; 
                $return['message']        =   lang_api('general_error',$this->locale);
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: deactivate_account
     * Description:   To Deactivate User Account
    */
    function deactivate_account_post()
    {
        $data = $this->input->post();

        /* To check if user is blocked by admin */    
        check_blocked_users($data['profile_id']);
        $return['code'] = 200;
        $return['response'] = new stdClass();

        $this->form_validation->set_rules('profile_id',lang_api('profile_id',$this->locale),'trim|required|numeric');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {   
            $profile_id = extract_value($data,'profile_id','');

            /* Get User Data From Users Table */
            $details = $this->Common_model->getsingle(USERS,array('id' => $profile_id));
            if(!empty($details)){
                if($details->is_deactivated == 1){
                    $return['status']         =   0; 
                    $return['message']        =  lang_api('already_deactivated',$this->locale); ;
                }else if($details->is_deactivated == 0){
                    /* Update User Details */
                    $status = $this->Common_model->updateFields(USERS,array('is_deactivated' => 1),array('id' => $profile_id));
                    if($status){
                        $return['status']         =   1; 
                        $return['message']        =  lang_api('deactivated_successfully',$this->locale);
                    }else{ 
                        $return['status']         =   0; 
                        $return['message']        =   lang_api('general_error',$this->locale);
                    }
                }
            }else{
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_profile_id',$this->locale);
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: settings
     * Description:   To Manage User Settings
    */
    function settings_post()
    {
        $data = $this->input->post();

        /* To check if user is blocked by admin */    
        check_blocked_users($data['profile_id']);
        $return['code'] = 200;
        $return['response'] = new stdClass();

        $this->form_validation->set_rules('profile_id',lang_api('profile_id',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('setting_key',lang_api('setting_key',$this->locale),'trim|required|in_list[is_following_you,event_updates,want_object]');
        $this->form_validation->set_rules('setting_type',lang_api('setting_type',$this->locale),'trim|required|numeric|in_list[0,1]');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {   
            $profile_id   = extract_value($data,'profile_id','');
            $setting_key  = extract_value($data,'setting_key','');
            $setting_type = extract_value($data,'setting_type','');

            /* Get User Data From Users Table */
            $details = $this->Common_model->getsingle(USERS,array('id' => $profile_id));
            if(!empty($details)){
                /* Update User Details */
                $status = $this->Common_model->updateFields(USERS,array($setting_key => $setting_type),array('id' => $profile_id));
                if($status){
                    $return['status']         =   1; 
                    $return['message']        =   lang_api('setting_updated_successfully',$this->locale);
                }else{
                    $return['status']         =   0; 
                    $return['message']        =   lang_api('general_error',$this->locale);
                }
            }else{
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_profile_id',$this->locale);
            }
        }
        $this->response($return);
    }

     /**
     * Function Name: categories
     * Description:   To Get All Categories
     */
    function categories_post()
    {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $categories  = $this->Common_model->getAll(ITEM_CATEGORY,'category_name','ASC');
        if($categories){
            /* Return Response */
            $response = array();

            foreach($categories as $r)
            {
              $row['category_id']   = null_checker($r->category_id);  
              $row['category_name'] = null_checker($r->category_name);  
              array_push($response, $row);
            }
            $return['status']    =   1; 
            $return['response']  =   $response; 
            $return['message']   =   lang_api('success',$this->locale);
        }else{
            $return['status']  =   0; 
            $return['message'] =   lang_api('categories',$this->locale).' '.lang_api('not_found',$this->locale);
        }
        $this->response($return);
    }

    /*
     * Function Name: profile_detail
     * Description:   To Get users information
    */
    function profile_details_post(){
        $data = $this->input->post();    

        /* To check if user is blocked by admin */    
        check_blocked_users($data['user_id']);
        $return['code'] = 200;        
        $return['response'] = new stdClass();        
        $this->form_validation->set_rules('user_id', lang_api('user_id',$this->locale), 'trim|required');
        $this->form_validation->set_rules('profile_visitor_id', lang_api('profile_visitor_id',$this->locale), 'trim|required');

        if($this->form_validation->run() == FALSE)         
        {            
            $error = $this->form_validation->rest_first_error_string();             
            $return['status']         =   0;             
            $return['message']        =   $error;  
        }        
        else        
        {  
            /* Get User Id */                 
            $result  = $this->Common_model->getsingle(USERS,array('id' => $data['profile_visitor_id']));
            
            if(!empty($result)){
                /* Return Response */
                $response = getUserInformation($result->id,$data['profile_visitor_id']);
                $response['follow_status']    =  "";
                if($data['user_id'] != $data['profile_visitor_id'])
                { 
                    $response['follow_status']  = get_follow_status($data['user_id'],$data['profile_visitor_id']);

                }
                
                $return['status']    =   1;                     
                $return['response']  =   $response;                     
                $return['message']   =   lang_api('success',$this->locale); 
            
            }else{
                $return['status']  =   0;                     
                $return['message'] =  lang_api('invalid_user_id',$this->locale);
            }
            
        }
        $this->response($return); 
    }

    /**
     * Function Name: update_location
     * Description:   To Update User location
    */
    function update_location_post()
    {
        $data = $this->input->post();

        /* To check if user is blocked by admin */    
        check_blocked_users($data['profile_id']);
        $return['code'] = 200;
        $return['response'] = new stdClass();

        $this->form_validation->set_rules('profile_id',lang_api('profile_id',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('lat',lang_api('latitude',$this->locale),'trim|required');
        $this->form_validation->set_rules('lng',lang_api('longitude',$this->locale),'trim|required');
            
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {  

            /* Get User Profile Details */
           $user_details = $this->Common_model->getsingle(USERS,array('id' => $data['profile_id']));
            if(empty($user_details))
            {
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_profile_id',$this->locale);
                $this->response($return);exit;
            } 
            $dataArr = array();
           
            $dataArr['lat']               = extract_value($data,'lat','');
            $dataArr['lng']               = extract_value($data,'lng','');
            

            /* Update User Location Into Users Table */
            $status = $this->Common_model->updateFields(USERS,$dataArr,array('id' => $user_details->id));
            if($status){
                /* Return success response */
                $return['status']         =   1; 
                $return['message']        =   lang_api('location_update_success',$this->locale);
            }else{
                $return['status']         =   0; 
                $return['message']        =   NO_CHANGES;
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: follow
     * Description:   To User following
    */
    function follow_post(){
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();

        $this->form_validation->set_rules('send_user_id',lang_api('send_user_id',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('recieve_user_id',lang_api('recieve_user_id',$this->locale),'trim|required|numeric');
        
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {   
            $send_id    = $data['send_user_id'];
            $recieve_id = $data['recieve_user_id'];
             /* To Get Send User Id From User Table*/ 
           $userDetails = $this->Common_model->getsingle(USERS,array('id' => $send_id));
            if(empty($userDetails))
            {
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_send_user_id',$this->locale);
                $this->response($return);exit;
            } 
            /* To Get Recieve User Id From User Table*/ 
            $user_details = $this->Common_model->getsingle(USERS,array('id' => $recieve_id));
            if(empty($user_details))
            {
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_recieve_user_id',$this->locale);
                $this->response($return);exit;
            }

            if($send_id != $recieve_id){

                $following_user = $this->Common_model->getsingle(FOLLOWERS,array('send_user_id' => $send_id,'recieve_user_id'=>$recieve_id));
                if(!empty($following_user)){
                    $return['status']         =   0; 
                    $return['message']        =   lang_api('already_following_message',$this->locale);
                    $this->response($return);exit;
                }

                //**To send notification data**//
                $userId           = $user_details->id;
                $userName         = $userDetails->name;
                $user_image       = $userDetails->user_image;
                $user_image_thumb = $userDetails->user_image_thumb;

                /*  To Get Friend Details  */
                $friend_details = $this->Common_model->getsingle(USERS,array('id' => $userId));
        
                $dataArr = array();
                $dataArr['send_user_id']     = extract_value($data,'send_user_id','');
                $dataArr['recieve_user_id']  = extract_value($data,'recieve_user_id','');
                $dataArr['sent_time']        = datetime();
                $lid = $this->Common_model->insertData(FOLLOWERS,$dataArr);
                if($lid){

                    /* To get blocked user ids */
                    $blocked_friend_ids = get_block_users($data['recieve_user_id']);
                    if(!in_array($data['send_user_id'], $blocked_friend_ids))
                    {
                       /* To send push notifications */
                        $notification_message = $userDetails->name." is following you ";
                        $noti_type = array('notification_type' => 'follower','send_id' => $send_id);
                        if(!empty($friend_details) && $friend_details->is_following_you == 0&& $friend_details->is_blocked == 0 && $friend_details->is_deactivated == 0){
                            send_push_notifications($notification_message,$userId,$noti_type);
                        }

                        //To send notification details// 
                        $mobile_notification_msg = "##user_name## is following you";
                        save_notification($userId,$send_id,$userName,$user_image,$user_image_thumb,'follower',$mobile_notification_msg,$dataArr['recieve_user_id'],'follower_id',$lid); 
                    }

                    $return['status']         =   1; 
                    $return['message']        =   lang_api('following_successfully',$this->locale);
                    $this->response($return);exit;
                }else{
                    $return['status']         =   0; 
                    $return['message']        =   lang_api('general_error',$this->locale);
                }
            }else{
                $return['status']         =   0; 
                $return['message']        =   lang_api('you_cant_follow_your_self',$this->locale);
            }
        }
        $this->response($return);
 
    }

    /**
     * Function Name: unfollow
     * Description:   To User Un-follow
    */
    function unfollow_post(){
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('send_user_id',lang_api('send_user_id',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('recieve_user_id',lang_api('recieve_user_id',$this->locale),'trim|required|numeric');
        
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {   
            $send_id    = $data['send_user_id'];
            $recieve_id = $data['recieve_user_id'];

            /* To Get Sent User Id From User Table*/ 
            $userDetails = $this->Common_model->getsingle(USERS,array('id' => $send_id));
            if(empty($userDetails))
            {
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_send_user_id',$this->locale);
                $this->response($return);exit;
            } 
            /* To Get Recieve User Id From User Table*/ 
            $user_details = $this->Common_model->getsingle(USERS,array('id' => $recieve_id));
            if(empty($user_details))
            {
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_recieve_user_id',$this->locale);
                $this->response($return);exit;
            }

            if($send_id == $recieve_id){
                $return['status']         =   0; 
                $return['message']        =   lang_api('you_cant_un_follow_your_self',$this->locale);
                $this->response($return);exit;
            }


            $dataArr = array();
            $dataArr['send_user_id']     = extract_value($data,'send_user_id','');
            $dataArr['recieve_user_id']  = extract_value($data,'recieve_user_id','');

            /** To Delete Row From followers Table**/ 
            $un_follow = $this->Common_model->deleteData(FOLLOWERS,$dataArr);
            if($un_follow){
                $return['status'] = 1;
                $return['message']  = lang_api('un_follow_successfully',$this->locale);
            }else{
                $return['status'] = 0;
                $return['message']= lang_api('general_error',$this->locale);
            }
        }  
        $this->response($return); 
    }

    /**
     * Function Name: accept_follower
     * Description:   To follower accept
    */
    function accept_follower_post(){
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('following_id',lang_api('following_id',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('user_id',lang_api('user_id',$this->locale),'trim|required|numeric');
        
        
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {
            /* To Get Sent User Id From User Table*/ 
            $user_details = $this->Common_model->getsingle(USERS,array('id' => $data['user_id']));
            if(empty($user_details))
            {
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_user_id',$this->locale);
                $this->response($return);exit;
            } 

            /* To Get Following Details*/ 
            $following_details = $this->Common_model->GetJoinRecord(FOLLOWERS,'send_user_id',USERS,'id','*,'.USERS.'.id as userid,'.FOLLOWERS.'.id as follow_id',array(FOLLOWERS.'.id' => $data['following_id']));
            if(!empty($following_details)){

                if($following_details[0]->follow_id != $data['following_id']){
                    $return['status']         =   0; 
                    $return['message']        =   lang_api('invalid_following_id',$this->locale);
                    $this->response($return);exit;
                }
                if($following_details[0]->recieve_user_id != $data['user_id']){
                    $return['status']         =   0; 
                    $return['message']        =   lang_api('invalid_user_id',$this->locale);
                    $this->response($return);exit;
                }

                /* Get follower status */
                $follower_status = $following_details[0]->status;
                if($follower_status == 'ACCEPT'){
                    $return['status']         =   0; 
                    $return['message']        =   lang_api('request_already_accepted',$this->locale);
                    $this->response($return);exit;
                }else{
                    /* Return Response */
                    $dataArr = array();
                    $dataArr['status']       = 'ACCEPT';
                    $dataArr['accept_time']  = datetime();
                    $accept_request = $this->Common_model->updateFields(FOLLOWERS,$dataArr,array('id' => $data['following_id']));
                    if($accept_request){
                        //**To send notification data**//
                        $userId           = $following_details[0]->send_user_id;
                        $userName         = $user_details->name;
                        $user_image       = $user_details->user_image;
                        $user_image_thumb = $user_details->user_image_thumb;
                        
                        /* To get blocked user ids */
                        $blocked_friend_ids = get_block_users($following_details[0]->send_user_id);
                        if(!in_array($following_details[0]->recieve_user_id, $blocked_friend_ids))
                        {
                            /*To send push notifications */
                            $notification_message = $user_details->name." is accepting your request ";
                            $noti_type = array('notification_type' => 'accept_follow_request','rec_id' => $user_details->id);
                            send_push_notifications($notification_message,$userId,$noti_type);

                            //To send notification details// 
                            $mobile_notification_msg = "##user_name## has accepted your request";
                            save_notification($userId,$following_details[0]->recieve_user_id,$userName,$user_image,$user_image_thumb,'accept_follow_request',$mobile_notification_msg,NULL,'follower_id',$data['following_id']);
                        }
            
                        $return['status']         =   1;
                        $return['message']        =   lang_api('request_accept_successfully',$this->locale);
                    }else{
                        $return['status']         =   0; 
                        $return['message']        =   lang_api('general_error',$this->locale);
                    }
                }
            }else{
                $return['status']         =   0; 
                $return['message']        =   lang_api('request_not_found',$this->locale);
            }
        
        }
        $this->response($return); 
    }

    /**
     * Function Name: reject_follower
     * Description:   To follower accept
    */
    function reject_follower_post(){
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('following_id',lang_api('following_id',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('user_id',lang_api('user_id',$this->locale),'trim|required|numeric');
        
        
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {
            /* To Get Sent User Id From User Table*/ 
            $user_details = $this->Common_model->getsingle(USERS,array('id' => $data['user_id']));
            if(empty($user_details))
            {
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_user_id',$this->locale);
                $this->response($return);exit;
            } 

            /* To Get Following Details*/ 
            $follower_details = $this->Common_model->getsingle(FOLLOWERS,array('id' => $data['following_id']));

            if($follower_details->id != $data['following_id']){
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_following_id',$this->locale);
                $this->response($return);exit;
            }
            if($follower_details->recieve_user_id != $data['user_id']){
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_user_id',$this->locale);
                $this->response($return);exit;
            }
            
        
           /* Get Follower Status */
           $follower_status = $follower_details->status;
           if($follower_status == 'PENDING'){
               $accept_request = $this->Common_model->deleteData(FOLLOWERS,array('id' => $data['following_id']));
                if($accept_request){
                    //**To send notification data**//
                    $userId           = $follower_details->send_user_id;
                    $userName         = $user_details->name;
                    $user_image       = $user_details->user_image;
                    $user_image_thumb = $user_details->user_image_thumb;
    
                    $return['status']         =   1; 
                    $return['message']        =   lang_api('request_rejected_successfully',$this->locale);
                }else{
                    $return['status']         =   0; 
                    $return['message']        =   lang_api('general_error',$this->locale);
                }     
           }else{
                $return['status']         =   0; 
                $return['message']        =   lang_api('request_already_accepted',$this->locale);
                $this->response($return);exit;
           }
       
        }
        $this->response($return); 
    }

    /**
     * Function Name: following_listing
     * Description:   To Get following User List
    */
    function following_listing_post(){
        $data = $this->input->post();

        /* To check if user is blocked by admin */    
        check_blocked_users($data['user_id']);
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('user_id',lang_api('user_id',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('profile_visitor_id',lang_api('profile_visitor_id',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('page_no', 'Page No', 'trim|numeric|callback__pageno_min_value');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {

            $page_no  = extract_value($data,'page_no',1); 
            $offset   = get_offsets($page_no);
            /* To Get Sent User Id From User Table*/ 
            $user_details = $this->Common_model->getsingle(USERS,array('id' => $data['user_id']));
            if(empty($user_details))
            {
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_user_id',$this->locale);
                $this->response($return);exit;
            } 

            /* To Get Following*/ 
            $following = $this->Common_model->GetJoinRecord(FOLLOWERS,'recieve_user_id',USERS,'id','*,'.USERS.'.id as user_id',array('send_user_id'=>$data['profile_visitor_id'],'status'=>'ACCEPT'),'',FOLLOWERS.'.id','DESC',10,$offset);
            
                if(!empty($following)){

                    /* Return Response */                    
                    $response = array();  

                    $total_requested = (int) $page_no * 10;

                    /* Get total records */  
                    $total_records =  $this->Common_model->GetJoinRecord(FOLLOWERS,'recieve_user_id',USERS,'id','*,'.USERS.'.id as user_id',array('send_user_id'=>$data['profile_visitor_id'],'status'=>'ACCEPT'),'',FOLLOWERS.'.id','DESC');

                    if(count($total_records) > $total_requested){                      
                        $has_next = TRUE;                    
                    }else{                        
                        $has_next = FALSE;                    
                    }
                    foreach($following as $f){
                        $row['user_id']          = null_checker($f->user_id);
                        $row['name']             = null_checker($f->name);
                        $row['sent_time']        = null_checker($f->sent_time);
                        $row['email']            = null_checker($f->email);
                        $row['status']           = null_checker($f->status);
                        $row['user_image']       = null_checker(base_url().$f->user_image);
                        $row['user_image_thumb'] = null_checker(base_url().$f->user_image_thumb);
                        $row['follow_status']    = get_follow_status($data['user_id'],$f->id);
                        array_push($response, $row); 
                        
                    }
                    $return['status']    =   1;        
                    $return['has_next']  =   $has_next;              
                    $return['response']  =   $response;                     
                    $return['message']   =   lang_api('success',$this->locale);


                }else{
                    $return['status']  =   0;                     
                    $return['message'] =   lang_api('following_not_found',$this->locale);
                }
        }
        $this->response($return);
    }

    /**
     * Function Name: follower_listing
     * Description:   To Get follower User List
    */
    function follower_listing_post(){
        $data = $this->input->post();

        /* To check if user is blocked by admin */    
        check_blocked_users($data['user_id']);
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('user_id',lang_api('user_id',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('profile_visitor_id',lang_api('profile_visitor_id',$this->locale),'trim|required|numeric');
        $this->form_validation->set_rules('page_no', 'Page No', 'trim|numeric|callback__pageno_min_value');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        {

            $page_no  = extract_value($data,'page_no',1); 
            $offset   = get_offsets($page_no);
            /* To Get Sent User Id From User Table*/ 
            $user_details = $this->Common_model->getsingle(USERS,array('id' => $data['user_id']));
            if(empty($user_details))
            {
                $return['status']         =   0; 
                $return['message']        =   lang_api('invalid_user_id',$this->locale);
                $this->response($return);exit;
            } 


            /* To Get Following*/ 
            $following = $this->Common_model->GetJoinRecord(FOLLOWERS,'send_user_id',USERS,'id','*,'.USERS.'.id as user_id',array('recieve_user_id'=>$data['profile_visitor_id'],'status'=>'ACCEPT'),'',FOLLOWERS.'.id','DESC',10,$offset);
            
                if(!empty($following)){

                    /* Return Response */                    
                    $response = array();  

                    $total_requested = (int) $page_no * 10;

                    /* Get total records */  
                    $total_records =  $this->Common_model->GetJoinRecord(FOLLOWERS,'send_user_id',USERS,'id','',array('recieve_user_id'=>$data['profile_visitor_id'],'status'=>'ACCEPT'),'',FOLLOWERS.'.id');
                   
                    if(count($total_records) > $total_requested){                      
                        $has_next = TRUE;                    
                    }else{                        
                        $has_next = FALSE;                    
                    }

                    foreach($following as $f){
                        $row['user_id']          = null_checker($f->user_id);
                        $row['name']             = null_checker($f->name);
                        $row['sent_time']        = null_checker($f->sent_time);
                        $row['email']            = null_checker($f->email);
                        $row['status']           = null_checker($f->status);
                        $row['user_image']       = null_checker(base_url().$f->user_image);
                        $row['user_image_thumb'] = null_checker(base_url().$f->user_image_thumb);
                        $row['follow_status']    = get_follow_status($data['user_id'],$f->id);
                        array_push($response, $row); 
                        
                    }
                    $return['status']    =   1;        
                    $return['has_next']  =   $has_next;              
                    $return['response']  =   $response;                     
                    $return['message']   =   'success';

                }else{
                    $return['status']  =   0;                     
                    $return['message'] =   lang_api('following_not_found',$this->locale);
                }
        }
        $this->response($return);
    }

    /**
     * Function Name: logout
     * Description:   To User Logout
     */
    function logout_post()
    {
        $return['code'] =   200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('user_id',lang_api('user_id',$this->locale),'trim|required');
        $this->form_validation->set_rules('device_type',lang_api('device_type',$this->locale), 'trim|required|in_list[ANDROID,IOS]');
        $this->form_validation->set_rules('device_id', lang_api('device_id',$this->locale), 'trim|required');
        $this->form_validation->set_rules('device_key', lang_api('device_key',$this->locale), 'trim|required');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
            
        }
        else
        { 
            $where = array(
                        'device_key'  => $data['device_key']
                    );
            $this->Common_model->deleteData(USERS_DEVICE_HISTORY,$where);
            $this->Common_model->updateFields(USERS,array('device_id' => NULL),array('id' => $data['user_id']));
            $return['status']         =   1; 
            $return['message']        =   lang_api('logged_out_successfully',$this->locale); 
        }
        $this->response($return);
    }

    /**
     * Function Name: clear_bages
     * Description:   To Update bages
     */
    function clear_bages_post()
    {
        $return['code'] =   200;
        $return['response'] = new stdClass();
        $data = $this->input->post();

        /* To check if user is blocked by admin */    
        check_blocked_users($data['user_id']);

         $this->form_validation->set_rules('user_id',lang_api('user_id',$this->locale),'trim|required');
        $this->form_validation->set_rules('device_type',lang_api('device_type',$this->locale), 'trim|required|in_list[ANDROID,IOS]');
        $this->form_validation->set_rules('device_id', lang_api('device_id',$this->locale), 'trim|required');
        $this->form_validation->set_rules('device_key', lang_api('device_key',$this->locale), 'trim|required');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
        }
        else
        { 
            $where = array(
                        'id'     => $data['user_id']
                    );
            $this->Common_model->updateFields(USERS,array('badges'=> 0 ),$where);
            $return['status']         =   1; 
            $return['message']        =   lang_api('badges_cleared_successfully',$this->locale);
            
        }
        $this->response($return);
    }

    /**
     * Function Name: get_bages
     * Description:   To Get bages
     */
    function get_bages_post()
    {
        $return['code'] =   200;
        $return['response'] = new stdClass();
        $data = $this->input->post();

        /* To check if user is blocked by admin */    
        check_blocked_users($data['user_id']);

        $this->form_validation->set_rules('user_id',lang_api('user_id',$this->locale),'trim|required');
        $this->form_validation->set_rules('device_type',lang_api('device_type',$this->locale), 'trim|required|in_list[ANDROID,IOS]');
        $this->form_validation->set_rules('device_id', lang_api('device_id',$this->locale), 'trim|required');
        $this->form_validation->set_rules('device_key', lang_api('device_key',$this->locale), 'trim|required');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
            
        }
        else
        { 
            $where = array(
                        'id'     => $data['user_id']
                    );
            $getBages = $this->Common_model->getsingle(USERS,$where);
            $return['device_badges']  = null_checker(@$getBages->badges);
            $return['status']         =   1; 
            $return['message']        =  lang_api('success',$this->locale); 
        }
        $this->response($return);
    }

    /**
     * Function Name: notification
     * Description:   To Get Notification
    */
    function notification_post()
    {
        $data = $this->input->post();   
        /* To check if user is blocked by admin */    
        check_blocked_users($data['user_id']);     
        $return['code'] = 200;        
        $return['response'] = array();        

        $this->form_validation->set_rules('user_id',lang_api('user_id',$this->locale),'trim|required');        
        $this->form_validation->set_rules('page_no', 'Page No', 'trim|numeric|callback__pageno_min_value');        
        if($this->form_validation->run() == FALSE)         
        {            
            $error = $this->form_validation->rest_first_error_string();             
            $return['status']         =   0;             
            $return['message']        =   $error;  
        }
        else
        {
            
            $page_no  = extract_value($data,'page_no',1); 
            $offset   = get_offsets($page_no); 

            /* Get blocked ids */
            $friend_ids = get_block_users($data['user_id']);

            $blocked_items_ids = array('0');
            if(!empty($friend_ids))
            {
                $test = $this->Common_model->getAllwherein(ITEMS,'','user_id',$friend_ids);
                foreach($test as $blocked_item_ids) 
                { 
                    array_push($blocked_items_ids, $blocked_item_ids->id);
                }
            }

            /* Get unique item ids */
            $blocked_items_ids = array_values(array_unique($blocked_items_ids)); 

            /* Get Item Images */
            $notificaton = $this->Common_model->GetUserNotifications($data['user_id'],$offset,$friend_ids,$blocked_items_ids);
            if(!empty($notificaton['result'])){

                
                /* Return Response */                    
                    $response = array();  

                    $total_requested = (int) $page_no * 10; 

                    /* Get total records */  
                    $total_records = $notificaton['total_count'];
                    if($total_records > $total_requested){                      
                        $has_next = TRUE;                    
                    }else{                        
                        $has_next = FALSE;                    
                    }  
                    foreach ($notificaton['result'] as $n) 
                    {
                        
                            $details_arr = new stdClass();
                            $row['notificaton_id']   = null_checker($n->notificaton_id);
                            $row['user_id']          = null_checker($n->user_id);
                            $row['user_name']        = null_checker($n->name);
                            $row['user_image']       = null_checker(base_url().$n->user_main_original_image);
                            $row['user_image_thumb'] = null_checker(base_url().$n->user_main_thumb_image);
                            $row['noti_type']        = null_checker($n->noti_type);
                            $row['friend_id']        = null_checker($n->friend_id);
                            switch ($n->noti_type) 
                            {
                                case 'admin_notification':
                                case 'release_freeze_pills':
                                    $row['message']  = $n->message;
                                    break;
                                case 'admin_item_delete':
                                    if($this->locale == 'english'){
                                        $row['message']  = $n->message;
                                    }else{
                                        $row['message']  = str_replace("Admin has deleted your", "L'amministratore ha eliminato il tuo", $n->message);
                                    }
                                    break;
                                default:
                                    $row['message']  = lang_api($n->noti_type,$this->locale);
                                    break;
                            }
                            $row['read_status']      = null_checker($n->read_status);
                            $row['sent_time']        = null_checker($n->sent_time);

                            
                            /* For Events */
                            // if($n->noti_type == 'join_event')
                            // {
                            //     $event_id = $n->join_event_id;
                            //     if(!empty($event_id))
                            //     {
                            //         /* Get event details */
                            //         $event_details = $this->Common_model->getsingle(EVENTS,array('id' => $event_id));
                            //         if(!empty($event_details))
                            //         {
                            //             $details_arr->event_id   =  $event_details->id;
                            //             $details_arr->event_name =  $event_details->name;
                            //         }
                            //     }
                            // }

                            /* For Item Like */
                            if($n->noti_type == 'item_like')
                            {
                                $item_id = $n->item_id;
                                if(!empty($item_id))
                                {
                                    /* Get item details */
                                    $item_details = $this->Common_model->getsingle(ITEMS,array('id' => $item_id,'item_status !=' => 'PEMANENT_BLOCK'));
                                    if(!empty($item_details))
                                    {
                                        $details_arr->item_id     =  $item_details->id;
                                        $details_arr->item_name   =  $item_details->name;
                                        $details_arr->item_status =  $item_details->item_status;
                                    }
                                }
                            }

                            /* For Follower */
                            if($n->noti_type == 'follower' || $n->noti_type == 'accept_follow_request')
                            {
                                $follower_id = $n->follower_id;
                                if(!empty($follower_id))
                                {
                                    /* Get follower details */
                                    $follower_details = $this->Common_model->getsingle(FOLLOWERS,array('id' => $follower_id));
                                    if(!empty($follower_details))
                                    {
                                        $details_arr->following_id      = $follower_details->id;
                                        $details_arr->follow_status     = $follower_details->status;
                                        $details_arr->follow_status     = $follower_details->status;
                                        $details_arr->send_user_id      = $follower_details->send_user_id;
                                        $details_arr->recieve_user_id   = $follower_details->recieve_user_id;
                                    }
                                }
                            }

                            /* For Swap */
                            if($n->noti_type == 'swap_request' || $n->noti_type == 'close_swap' || $n->noti_type == 'extra_pills' || $n->noti_type == 'swap_confirm' || $n->noti_type == 'add_swap_item' || $n->noti_type == 'remove_swap_item' || $n->noti_type == 'undo_swap')
                            { 
                                $swap_id = $n->swap_id;
                                if(!empty($swap_id))
                                {
                                    /* Get Swap Details */
                                    // $swap_data = $this->Common_model->get_swapped_items($data['user_id'],'','',$swap_id);
                                    $swap_data = $this->Common_model->getAllwhere(SWAPPER,array('id' => $swap_id));
                                    if(!empty($swap_data))
                                    {
                                        $user_details  = $this->Common_model->getsingle(USERS,array('id' => $data['user_id']));
                                        foreach($swap_data as $r)                    
                                        {          
                                            $swapper_id = $r->id;
                                            $details_arr->swap_requestor_user_id = null_checker($r->user_id);
                                            $details_arr->swap_id                = null_checker($r->id);
                                            $details_arr->current_user_id        = null_checker($user_details->id);
                                            $details_arr->current_user_name      = null_checker($user_details->name);
                                            $details_arr->current_user_original_image = null_checker(base_url().$user_details->user_image);
                                            $details_arr->current_user_thumb_image    = null_checker(base_url().$user_details->user_image_thumb);
                                            $details_arr->current_pills          = (int) null_checker($user_details->active_pills);
                                            if($user_details->id == $r->user_id){
                                                $details_arr->current_user_swap_status = null_checker($r->user_confirm_status);
                                                $details_arr->current_user_extra_pills = (int) null_checker($r->user_extra_pills);
                                            }else{
                                                $details_arr->current_user_swap_status = null_checker($r->friend_confirm_status);
                                                $details_arr->current_user_extra_pills = (int) null_checker($r->friend_extra_pills);
                                            }
                                            if($user_details->id == $r->user_id){
                                                $friend_id = $r->friend_id;
                                            }else{
                                                $friend_id = $r->user_id;
                                            }

                                            /* Get Friend Details */
                                            $friend_details  = $this->Common_model->getsingle(USERS,array('id' => $friend_id));
                                            $details_arr->friend_user_id    = null_checker($friend_details->id);
                                            $details_arr->friend_user_name  = null_checker($friend_details->name);
                                            $details_arr->friend_original_image = null_checker(base_url().$friend_details->user_image);
                                            $details_arr->friend_thumb_image    = null_checker(base_url().$friend_details->user_image_thumb);
                                            $details_arr->friend_pills      = (int) null_checker($friend_details->active_pills);
                                            if($user_details->id == $r->user_id){
                                                $details_arr->friend_user_swap_status = null_checker($r->friend_confirm_status);
                                                $details_arr->friend_user_extra_pills = (int) null_checker($r->friend_extra_pills);
                                            }else{
                                                $details_arr->friend_user_swap_status = null_checker($r->user_confirm_status);
                                                $details_arr->friend_user_extra_pills = (int) null_checker($r->user_extra_pills);
                                            }
                                            $details_arr->swap_initiate_time  = time_ago($r->swap_initiate_time);
                                            
                                            /* Get Current User Swapped Item Details */
                                            $user_items = array();
                                            /*$user_swap_items = $this->Common_model->getAllwhere(SWAPPER_ITEMS,array('swapper_id' => $swapper_id,'item_owner_id' => $data['user_id']),'id','DESC');*/
                                            $user_swap_items = $this->Common_model->GetJoinRecord(SWAPPER_ITEMS,'item_id',ITEMS,'id','',array(SWAPPER_ITEMS.'.swapper_id' => $swapper_id,SWAPPER_ITEMS.'.item_owner_id' => $data['user_id'],ITEMS.'.item_status !=' => 'PEMANENT_BLOCK'),'',SWAPPER_ITEMS.'.id','DESC','','',SWAPPER_ITEMS.'.item_id',$blocked_items_ids);
                                            if(!empty($user_swap_items)){
                                                foreach($user_swap_items as $ui)
                                                {
                                                    /* Get First Item Details */
                                                    $item_details = $this->Common_model->getsingle(ITEMS,array('id' => $ui->item_id));
                                                    if(!empty($item_details))
                                                    {
                                                        $user_item_row['user_item_name']  = $item_details->name;
                                                        $user_item_row['user_item_id']    = $item_details->id;
                                                        $user_item_row['user_item_pills'] = $item_details->pills;
                                                        $user_item_images = array();

                                                        /* Get Item Images */
                                                        $item_images = $this->Common_model->getAllwhere(ITEM_IMAGES,array('item_id' => $ui->item_id),'id','DESC','',5);
                                                        if(!empty($item_images)){
                                                            foreach($item_images as $ii)
                                                            {
                                                                $user_item_image_row['user_item_original_images'] = base_url().$ii->item_image;
                                                                $user_item_image_row['user_item_thumb_images']    = base_url().$ii->item_image_thumb;
                                                                array_push($user_item_images, $user_item_image_row);
                                                            }
                                                        }
                                                        $user_item_row['user_items_images'] = $user_item_images;
                                                    }
                                                    array_push($user_items, $user_item_row);
                                                }
                                            }
                                            $details_arr->user_items = $user_items;

                                            /* Get Friend Swapped Item Details */
                                            $friend_items = array();
                                            // $friend_swap_items = $this->Common_model->getAllwhere(SWAPPER_ITEMS,array('swapper_id' => $swapper_id,'item_owner_id' => $friend_id),'id','DESC');
                                            $friend_swap_items = $this->Common_model->GetJoinRecord(SWAPPER_ITEMS,'item_id',ITEMS,'id','',array(SWAPPER_ITEMS.'.swapper_id' => $swapper_id,SWAPPER_ITEMS.'.item_owner_id' => $friend_id,ITEMS.'.item_status !=' => 'PEMANENT_BLOCK'),'',SWAPPER_ITEMS.'.id','DESC','','',SWAPPER_ITEMS.'.item_id',$blocked_items_ids);
                                            if(!empty($friend_swap_items)){
                                                foreach($friend_swap_items as $fi)
                                                {
                                                    /* Get First Item Details */
                                                    $item_details = $this->Common_model->getsingle(ITEMS,array('id' => $fi->item_id));
                                                    if(!empty($item_details))
                                                    {
                                                        $friend_item_row['friend_item_name']  = $item_details->name;
                                                        $friend_item_row['friend_item_id']    = $item_details->id;
                                                        $friend_item_row['friend_item_pills'] = $item_details->pills;
                                                        $friend_item_images = array();

                                                        /* Get Item Images */
                                                        $item_images = $this->Common_model->getAllwhere(ITEM_IMAGES,array('item_id' => $fi->item_id),'id','DESC','',5);
                                                        if(!empty($item_images)){
                                                            foreach($item_images as $ii)
                                                            {
                                                                $friend_item_image_row['friend_item_original_images'] = base_url().$ii->item_image;
                                                                $friend_item_image_row['friend_item_thumb_images']    = base_url().$ii->item_image_thumb;
                                                                array_push($friend_item_images, $friend_item_image_row);
                                                            }
                                                        }
                                                        $friend_item_row['friend_items_images'] = $friend_item_images;
                                                    }
                                                    array_push($friend_items, $friend_item_row);

                                                }
                                            }
                                            $details_arr->friend_items = $friend_items;
                                        }  
                                    }
                                }
                            }

                            $row['details']  = $details_arr;
                            array_push($response, $row);
                        
                    }
                    $return['status']    =   1; 
                    $return['has_next']  =   $has_next;                    
                    $return['response']  =   $response;                     
                    $return['message']   =  lang_api('success',$this->locale);
            }else{
                $return['status']         =   0;             
                $return['message']        =   lang_api('notification_not_found',$this->locale);;
            }
        }
        $this->response($return);  
    }

    /**
     * Function Name: update_device
     * Description:   To Update User Device ID
     */
    function update_device_post()
    {
        $return['code'] =   200;
        $return['response'] = new stdClass();
        $data = $this->input->post();

        /* To check if user is blocked by admin */    
        check_blocked_users($data['user_id']);

        $this->form_validation->set_rules('user_id',lang_api('user_id',$this->locale),'trim|required');
        $this->form_validation->set_rules('old_device_id', lang_api('old_device_id',$this->locale), 'trim|required');
        $this->form_validation->set_rules('new_device_id', lang_api('new_device_id',$this->locale), 'trim|required');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
            
        }
        else
        { 
            $where = array(
                        'user_id'     => $data['user_id'],
                        'device_id'   => $data['old_device_id']
                    );
            $status = $this->Common_model->updateFields(USERS_DEVICE_HISTORY,array('device_id' => $data['new_device_id']),$where);
            if($status){
                $return['status']         =   1; 
                $return['message']        =   lang_api('device_id_update_successfully',$this->locale); 
            }else{
                $return['status']         =   0; 
                $return['message']        =   lang_api('failed_or_not_find_any_changes',$this->locale);
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: update_device_new
     * Description:   To Update User Device ID
     */
    function update_device_new_post()
    {
        $return['code'] =   200;
        $return['response'] = new stdClass();
        $data = $this->input->post();

        /* To check if user is blocked by admin */    
        check_blocked_users($data['user_id']);

        $this->form_validation->set_rules('user_id',lang_api('user_id',$this->locale),'trim|required');
        $this->form_validation->set_rules('device_key', lang_api('device_key',$this->locale), 'trim|required');
        $this->form_validation->set_rules('new_device_id', lang_api('new_device_id',$this->locale), 'trim|required');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
            
        }
        else
        { 
            $device_type = (!empty($data['device_type'])) ? $data['device_type'] : 'IOS';
            /* Update device info */
            $this->Common_model->updateFields(USERS,array('device_id' => $data['new_device_id']),array('id' => $data['user_id']));

            /* Manage device history */
            $device_details = $this->Common_model->getsingle(USERS_DEVICE_HISTORY,array('device_key' => $data['device_key']));
            if(empty($device_details)){
                $data_arr = array();
                $data_arr['user_id']     = $data['user_id'];
                $data_arr['device_id']   = $data['new_device_id'];
                $data_arr['device_type'] = $device_type;
                $data_arr['device_key']  = $data['device_key'];
                if(!empty($data['version']))
                {
                    $data_arr['version']     = $data['version'];
                }
                if(!empty($data['device_info']))
                {
                    $data_arr['device_info']  = $data['device_info'];
                }
                $data_arr['added_date']  = datetime();
                $lid = $this->Common_model->insertData(USERS_DEVICE_HISTORY,$data_arr);
                if($lid){
                    $return['status']         =   1; 
                    $return['message']        =   lang_api('device_id_update_successfully',$this->locale); 
                }else{
                    $return['status']         =   0; 
                    $return['message']        =   lang_api('failed_or_not_find_any_changes',$this->locale);
                }
            }else{
                $where = array(
                        'user_id'     => $data['user_id'],
                        'device_key'  => $data['device_key']
                    );
                $update_arr = array();
                $update_arr['device_id'] = $data['new_device_id'];
                if(!empty($data['version']))
                {
                    $update_arr['version'] = $data['version'];
                }
                if(!empty($data['device_info']))
                {
                    $update_arr['device_info'] = $data['device_info'];
                }
                $status = $this->Common_model->updateFields(USERS_DEVICE_HISTORY,$update_arr,$where);
                if($status){
                    $return['status']         =   1; 
                    $return['message']        =   lang_api('device_id_update_successfully',$this->locale); 
                }else{
                    $return['status']         =   0; 
                    $return['message']        =   lang_api('failed_or_not_find_any_changes',$this->locale);
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: update_app_alert
     * Description:   To Update App Alert
     */
    function update_app_alert_post()
    {
        $return['code'] =   200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('device_type',lang_api('device_type',$this->locale),'trim|required|in_list[ANDROID,IOS]');
        $this->form_validation->set_rules('lang','Language','trim|required|in_list[english,italian]');
        if($this->form_validation->run() == FALSE) 
        {
            $error = $this->form_validation->rest_first_error_string(); 
            $return['status']         =   0; 
            $return['message']        =   $error; 
            
        }
        else
        { 
            /* Return Response */
            $response = array();
            $device_type = $data['device_type'];
            if($device_type == 'IOS'){
                $response['is_required'] = 1;
                $response['min_app_version'] = '2.2'; // should be one place after decimal
                $response['alert_message'] = lang_api('update_app_msg_ios',$this->locale); 
            }else{
                $response['is_required'] = 1;
                $response['min_app_version'] = '19';
                $response['alert_message']  = lang_api('update_app_msg_android',$this->locale); 
            }
            $return['status']    =  1; 
            $return['response']  =  $response; 
            $return['message']   =  'success';
        }
        $this->response($return);
    }

    public function test_push_notifications_post()
    {
        $device_type = $_POST['device_type'];
        $device_token = $_POST['device_token'];
        $message  = $_POST['message'];
        $params = array('type' => 'testing notifications');
        if($device_type == 'ANDROID'){
            $noti_data = array('body' => $message,'title' => '','params' => $params);
            $fields = array
            (
                'data' => $noti_data
            );

            if(is_array($device_token)){
                $fields['registration_ids'] = $device_token;
            } else {
                $fields['to'] = $device_token;
            }
            $server_key = 'AIzaSyDEiGNYzs9FYa9M7L7u6dOTM9vtdukLTJg';

            $headers = array
                (
                'Authorization: key=' . $server_key,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            echo "<pre>";
            print_r($result);
            $resp   = json_decode($result);
            pr($resp);
            curl_close($ch);
        }else{
            $passphrase = '123';
            $user_certificate_path = APPPATH . "/third_party/swpush.certi.pem";
            
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', $user_certificate_path);
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

            // Open a connection to the APNS server
            $fp = stream_socket_client(APNS_GATEWAY_URL, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

            if (!$fp) {
                echo 'ERROR',"APN: Maybe some errors: $err: $errstr";exit;
            } else {
                log_message('ERROR',"Connected to APNS, message - ".$message);
            }

            
            // Create the payload body
            $body['aps'] = array(
                'alert' => $message,
                'params'=> $params,
                'badge' => 0,
                'sound' => 'default'
                );

            // Encode the payload as JSON
            $payload = json_encode($body);

            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;

            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));

            if (!$result) {
                echo 'APN: Message not delivered';die;
            } else {
                echo 'APN: Message successfully delivered';die;
            }
            // Close the connection to the server
            fclose($fp);
        }
        $this->response(array('status' => 'DONE'));
    }

    
    /*
    *Function Name:block_user
    *Description:To Block User
    */
    public function block_user_post(){
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('user_id', lang_api('user_id',$this->locale), 'trim|required|numeric');
        $this->form_validation->set_rules('friend_id', lang_api('friend_id',$this->locale), 'trim|required|numeric');
        if($this->form_validation->run() == false){
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        }
        else
        {
            /* Check user valid or invalid */
            $user_detail = $this->Common_model->getsingle(USERS,array('id'=>$data['user_id']));
            if(empty($user_detail)){
                $return['status'] = 0;
                $return['message'] = lang_api('invalid_user_id',$this->locale);
                $this->response($return);exit;
            }

            /* Check friend valid or invalid */
            $friend_details = $this->Common_model->getsingle(USERS,array('id' => $data['friend_id']));
            if(empty($friend_details)){
                $return['status'] = 0;
                $return['message'] = lang_api('invalid_friend_id',$this->locale);
                $this->response($return);exit;
            }


            if($data['user_id'] == $data['friend_id']){
                $return['status'] = 0;
                $return['message'] = lang_api('you_can_not_block_your_self',$this->locale);
                $this->response($return);exit;
            }

            $get_block_user = $this->Common_model->getsingle(BLOCK_USER,array('user_id' => $data['user_id'], 'friend_id' => $data['friend_id']));
            if(empty($get_block_user)){

                /* Inser data in block_user table */
                $dataArr['user_id']    = extract_value($data,'user_id','');
                $dataArr['friend_id']  =extract_value($data,'friend_id','');
                $dataArr['block_time'] = datetime();

                $lid = $this->Common_model->insertData(BLOCK_USER,$dataArr);
                if($lid){

                    $return['status']  = 1;
                    $return['message'] = lang_api('user_blocked_successfully',$this->locale);
                }else{
                    $return['status']  = 0;
                    $return['message'] = lang_api('general_error',$this->locale);
                }
            }else{
                $dataArr['user_id']    = extract_value($data,'user_id','');
                $dataArr['friend_id']  =extract_value($data,'friend_id','');

                $delete = $this->Common_model->deleteData(BLOCK_USER,$dataArr);
                if($delete){
                    $return['status']  = 1;
                    $return['message'] = lang_api('user_unblocked_successfully',$this->locale);
                }else{
                    $return['status']  = 0;
                    $return['message'] = lang_api('general_error',$this->locale);
                }
            }
        }
        $this->response($return);
    }

    /*
    *Functuio Name:block_user_list
    *Description: To Get Block user list
    */
 
    public function block_user_list_post(){
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();

        /* Form Validation */
        $this->form_validation->set_rules('user_id', lang_api('user_id',$this->locale), 'trim|required|numeric');
        $this->form_validation->set_rules('page_no', 'Page No', 'trim|numeric|callback__pageno_min_value');

        if($this->form_validation->run() == false){
            $error = $this->form_validation->rest_first_error_string();
            $return['status']  = 0;
            $return['message'] = $error;
        }
        else
        {
            
            /* Check user valid or invalid */
            $user_details = $this->Common_model->getsingle(USERS,array('id' => $data['user_id']));
            if(empty($user_details)){
                $return['status']  = 0;
                $return['message'] = lang_api('invalid_user_id',$this->locale);
                $this->response($return);exit;
            }

            $page_no  = extract_value($data,'page_no',1); 
            $offset   = get_offsets($page_no); 

            /* Friend details */
            $get_block_user_list = $this->Common_model->GetJoinRecord(BLOCK_USER,'friend_id',USERS,'id','',array('user_id' => $data['user_id']),'',BLOCK_USER.'.id','DESC',10,$offset);
            $user_list = array();
            if(!empty($get_block_user_list)){

                $total_requested = (int) $page_no * 10;

                /* Get total record */
                $total_record = getAllcount(BLOCK_USER,array('user_id' => $data['user_id']));
                if($total_record > $total_requested){
                    $has_next = TRUE;
                }else{
                    $has_next = FALSE;
                }
                 foreach($get_block_user_list as $block_users){

                    $dataArr['friend_id']          = null_checker($block_users->id);
                    $dataArr['friend_name']        = null_checker($block_users->name);
                    $dataArr['friend_email']       = null_checker($block_users->email);
                    $dataArr['friend_image']       = null_checker(base_url().$block_users->user_image);
                    $dataArr['friend_image_thumb'] = null_checker(base_url().$block_users->user_image_thumb);
                    array_push($user_list,$dataArr);
                 }
                $return['status']   = 1;
                $return['response'] = $user_list;
                $return['has_next'] = $has_next;
                $return['message']  = lang_api('success',$this->locale);
            }else{
                $return['status']   = 0;
                $return['message']  = lang_api('user_not_found',$this->locale);
            }

        }
        $this->response($return);
    }
 
 
}

/* End of file User.php */
/* Location: ./application/controllers/api/User.php */

?>