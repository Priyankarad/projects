<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class Api extends REST_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('User_model');
	}
/***************************/
/************Index**********/
/*********************/
	public function testing_post(){
		$id=$_POST['id'];
		$resp=array('firstname'=>'sunil','email'=>'abc@gmail.com','contact'=>'9993027934','retId'=>$id);
        $this->response($resp, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
}
/************************************/
/**
* Function Name: CHANGEPASSSWORD
* Description:   CHANGE PASSSWORD 
*/
/************************************/		
function resetpassword_post(){
	$return['ResponseCode'] = 200;
	$data = $this->input->post();
	$this->form_validation->set_rules('user_id', 'USER ID', 'trim|required');
	$this->form_validation->set_rules('current_password','current_password','trim|required');
	$this->form_validation->set_rules('new_password','new_password','trim|required|min_length[6]|max_length[14]');
	$this->form_validation->set_rules('confirm_password','Confirm Password','trim|required|min_length[6]|max_length[14]|matches[new_password]');
	$this->form_validation->set_message('min_length', 'Password must be 6 to 14 digit long.');
	$this->form_validation->set_message('matches', 'Password and confirm password not matched.');
	if($this->form_validation->run() == FALSE){
		$error = $this->form_validation->rest_first_error_string(); 
		$return['result']         =   0; 
		$return['data']         =   array(); 
		$return['Message']      =   $error; 
	}else{
		$current_password=$this->input->post('current_password');
		$new_password=$this->input->post('new_password');
		$confirm_password=$this->input->post('confirm_password');
		$user_id=$this->input->post('user_id');
		$password=generate_password($new_password);

		$userdata=$this->common_model->getsingle(USERS,array('id'=>$user_id));
		if(empty($userdata)){
			$return['result']         =   0; 
			$return['data']         =   array(); 
			$return['msg']      =   "User Id Not Exist in our database.";
		}else{
			$datapassword=$userdata->password;
			$check=password_check($current_password,$datapassword);
			if($check!='verified'){
				$return['result']         =   0; 
				$return['data']         =   array(); 
				$return['msg']      =   "Password not matched with old password. Try again.";
			}else{
				$retur=$this->common_model->updateFields(USERS,array('password' => $password),array('id' => $user_id));
				if($retur){
					/* Return success response */
					$return['result']         =   1; 
					$return['data']         =   array('userid'=>$user_id); 
					$return['msg']      =   'Password Changed successfully'; 
				}else{
					$return['result']         =   0; 
					$return['data']         =   array(); 
					$return['msg']      =   "Password must be different from old password.";
				}
			}
		}
	}
	$this->response($return); 
}
/***************************/
/********Registration*******/
/***************************/
public function registration_post(){
	$this->form_validation->set_rules('fullname', 'Full Name', 'required');
	$this->form_validation->set_rules('email', 'Email', 'required');
	$this->form_validation->set_rules('password', 'Password', 'required');
	$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
	$this->form_validation->set_rules('device_id', 'Device id', 'required');
	$this->form_validation->set_rules('device_type', 'Device type', 'required');
//$this->form_validation->set_rules('latitude', 'Latitude', 'required');
//$this->form_validation->set_rules('longitude', 'Longitude', 'required');

	if ($this->form_validation->run() == TRUE){
		$fullname=$this->input->post('fullname');
		$email=$this->input->post('email');
		$password=$this->input->post('password');
		$device_id=$this->input->post('device_id');
		$device_type=$this->input->post('device_type');
		$latitude=$this->input->post('latitude');
		$longitude=$this->input->post('longitude');
		$result = $this->User_model->check_email($email);

		if(!empty($result)){
			$error=array("result"=>0,"msg"=>"you are already registered please login");
			$this->response($error, REST_Controller::HTTP_OK);
		}else{
			$userdata = array(
				'type' => 'App',
				'firstname' => $fullname,
				'email' => $email,
				'password' => generate_password($password),
				'profile' => base_url().DEFAULT_IMAGE,
				'device_id' => $device_id,
				'device_type' => $device_type,
				'latitude' => $latitude,
				'longitude' => $longitude,
				'status' => 'unverify'					
			);
			$inserts=$this->User_model->insert_user($userdata);
			if($inserts){
				if($this->User_model->sendEmail($email,$fullname)){
					$resp=array("result"=>1,'data'=>array('user_id'=>$inserts),'msg'=>'Successfully registered. Please confirm the mail that has been sent to your email');
					$this->response($resp, REST_Controller::HTTP_OK);
				}
			}else{
				$resp=array("result"=>0,"msg"=>"Error in registration!",'data'=>0);
				$this->response($resp, REST_Controller::HTTP_OK);	
			}						
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Registration*******/
/***************************/
public function profiletype_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('profile_type', 'Profile type', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$user_role=$this->input->post('profile_type');
		$result=$this->common_model->updateFields(USERS,array('user_role'=>$user_role),array('id'=>$user_id));
		if(!empty($result)){
			$resp=array("result"=>1,'data'=>array('user_id'=>$user_id),'msg'=>'User role updated successfully.');
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Error in updation!",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);							
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Registration*******/
/***************************/
public function completeprofile_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('fullname', 'Full name', 'required');
	$this->form_validation->set_rules('email', 'Email', 'required');
	$this->form_validation->set_rules('zipcode', 'Zipcode', 'required');
	$this->form_validation->set_rules('city', 'City', 'required');
	$this->form_validation->set_rules('state', 'State', 'required');
	$this->form_validation->set_rules('country', 'Country', 'required');
	$this->form_validation->set_rules('phone', 'Phone', 'required');
	$this->form_validation->set_rules('website', 'Website', 'required');
	$this->form_validation->set_rules('current_position', 'Current position', 'required');
	$this->form_validation->set_rules('category', 'Category', 'required');

	if ($this->form_validation->run() == TRUE){	
		$user_id=$this->input->post('user_id');
		$dataarr=array();
		$dataarr['firstname']=$this->input->post('fullname');
		$dataarr['zip']=$this->input->post('zipcode');
		$dataarr['city']=$this->input->post('city');
		$dataarr['state']=$this->input->post('state');
		$dataarr['country']=$this->input->post('country');
		$dataarr['phone']=$this->input->post('phone');
		$dataarr['website_link']=$this->input->post('website');
		$dataarr['current_position']=$this->input->post('current_position');
		$dataarr['user_category']=$this->input->post('category');
		if(isset($_FILES['profile_image']['name']) && !empty($_FILES['profile_image']['name'])){
//$profile_image = fileUploading('gif|jpg|png|jpeg','','','','screenshot','screen');
			$profile_image = fileUploading('profile_image','images','*');
			if(isset($profile_image['error'])){
				$return['resp']         =   1; 
				$return['data']         =   strip_tags($profile_image['error']);
				$return['Message']      =   strip_tags($profile_image['error']);
				$this->response($return); 
				$resp=array("result"=>0,"msg"=>$return['Message']);
				$this->response($resp, REST_Controller::HTTP_OK);		
			}else{
				$profile_pic=$profile_image['upload_data']['file_name'];
				$profile_image_thumb = get_image_thumb($_SERVER["DOCUMENT_ROOT"].'/uploads/images/'.$profile_pic,'images/thumb',300,300);	
				$dataarr['profile']   = base_url().'uploads/images/'.$profile_pic;
			} 
		}

		$result=$this->common_model->updateFields(USERS,$dataarr,array('id'=>$user_id));
		if(!empty($result)){
			$resp=array("result"=>1,'data'=>array('user_id'=>$user_id),'msg'=>'User profile updated successfully.');
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Error in updation!",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);							
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********update-skills*******/
/***************************/
public function updateskills_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('professional_skill', 'Professional skill', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$professional_skill=$this->input->post('professional_skill');
		$additional_services=$this->input->post('additional_services');
		$result=$this->common_model->updateFields(USERS,array('professional_skill'=>$professional_skill,'additional_services'=>$additional_services,'basic_info'=>1),array('id'=>$user_id));
		if(!empty($result)){
			$resp=array("result"=>1,'data'=>array('user_id'=>$user_id),'msg'=>'User skills updated successfully.');
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Error in updation!",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);							
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Get-Category*******/
/***************************/
public function getcategory_post(){
	$this->form_validation->set_rules('flag', 'Flag', 'required');
	if ($this->form_validation->run() == TRUE){
		$categories = $this->common_model->getAllwhere(CATEGORY,array('category_status'=>1));
		$allcategory=$categories['result'];
		if(!empty($categories)){
			$resp=array("result"=>1,'data'=>$allcategory,'msg'=>'User role updated successfully.');
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"No category found.",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);							
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/**********Login************/
/***************************/
public function login_post(){
	$this->form_validation->set_rules('email', 'Email', 'required|trim');
	$this->form_validation->set_rules('password', 'Password', 'required');
	if ($this->form_validation->run() == TRUE){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$device_type = $this->input->post('device_type');
		$device_id = $this->input->post('device_id');
		
		$latitude=($this->input->post('latitude') && $this->input->post('latitude')!="") ? $this->input->post('latitude') : "";
		$longitude=($this->input->post('longitude') && $this->input->post('longitude')!="") ? $this->input->post('longitude') : "";
		
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
					$error =array("result"=>0,"msg"=>'Your account has been deactivated','data'=>0); 
					$this->response($error, REST_Controller::HTTP_OK);
					exit;
				}
				if($status=='verify'){
					$ckusr=$this->common_model->getsingle(USERS,array('email'=>$email));

					if(!empty($ckusr)){
						$data=array(
							'type' =>$result1->type,
							'oauth_uid' => $result1->oauth_uid,
							'firstname' =>$result1->firstname,
							'lastname' => $result1->lastname,
							'email' => $result1->email,
							'gender' => $result1->gender,
							'lang' => $result1->lang,
							'profile_url' => $result1->profile_url,
							'profile' => $result1->profile,
							'status' => $result1->status,
							'userid' => (int)$result1->id,
							'user_role'=>$ckusr->user_role,
							'website_link'=>$ckusr->website_link,
							'phone'=>$ckusr->phone,
							'current_position'=>$ckusr->current_position,
							'working_at'=>$ckusr->working_at,
							'professional_skill'=>$ckusr->professional_skill,
							'additional_services'=>$ckusr->additional_services,
							'zipcode'=>$ckusr->zip,
							'city'=>$ckusr->city,
							'state'=>$ckusr->state,
							'country'=>$ckusr->country,
							'status'=>$ckusr->status,
							'active'=>$ckusr->active,
							'language'=>$ckusr->lang
						);
					if(!empty($latitude) && !empty($longitude)){
					 $updata['latitude']=$latitude;
					 $updata['longitude']=$longitude;
					 $results=$this->common_model->updateFields(USERS,$updata,array('id'=>$result1->id));
					}
					if(!empty($device_type) && !empty($device_id)){
					 $updata['device_type']=$device_type;
					 $updata['device_id']=$device_id;
					 $results=$this->common_model->updateFields(USERS,$updata,array('id'=>$result1->id));
					}
					$resp=array("result"=>1,'msg'=>'Successfully Loggedin.','data'=>$data);
					$this->response($resp, REST_Controller::HTTP_OK);
					}else{
						$error =array("result"=>0,"msg"=>'Oops! Plz Set your Role!'); 
						$this->response($error, REST_Controller::HTTP_OK);	
					}

				}else{
					$error =array("result"=>0,"msg"=>'Please check your mail to verify your email address!','data'=>0); 
					$this->response($error, REST_Controller::HTTP_OK);	

				}

			}else{
				$error =array("result"=>0,"msg"=>'Oops! Invalid username or password!','data'=>0); 
				$this->response($error, REST_Controller::HTTP_OK);	
			}		

		}else{
			$error =array("result"=>0,"msg"=>'Oops! Username Not Available. Please Register .','data'=>0); 
			$this->response($error, REST_Controller::HTTP_OK);
		}


	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Get-User-Details******/
/***************************/
public function getuserdetails_post(){
	$this->form_validation->set_rules('user_id', 'User id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$user_data = $this->common_model->getsingle(USERS,array('id'=>$user_id));
		if(empty($user_data)){
			$resp=array("result"=>0,"msg"=>"This user not exist in our database",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);
		}
		
		$data['img_url']="";
		$this->load->library('ciqrcode');
		$qr_image=rand().'.png';
		$params['data'] = $user_id;
		$params['level'] = 'H';
		$params['size'] = 5;
		$params['savename'] =FCPATH."qr_code/".$qr_image;
		if($this->ciqrcode->generate($params)){
			$myqr_image=base_url().'qr_code/'.$qr_image; 
		}else{
			$myqr_image="";
		}
		$category_id=$user_data->user_category;
		$category_data = $this->common_model->getsingle(CATEGORY,array('id'=>$category_id));
		if(!empty($category_data->name)){
			$user_data->category_name=$category_data->name;
		}else{
			$user_data->category_name='';
		}

		if($user_data){
			$resp=array("result"=>1,'msg'=>'User Details .','data'=>$user_data,'qrcode'=>$myqr_image);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/*******************************/
/********Get-User-FRIENDS******/
/******************************/
public function getuserfriends_post(){
	$this->form_validation->set_rules('user_id', 'User id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$condition=array('id'=>$user_id);
		$data['user_data'] = get_where('tb_users',$condition,'row');

		$info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.device_id','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country','tb_users.user_role','tb_users.business_name');
		$relation="tb_users.id=friends.user_one_id";
		$condition=array('friends.user_two_id'=>$user_id,'friends.status'=>0,'tb_users.user_role!='=>"Employer");
		$relation2="tb_users.id=friends.user_one_id OR tb_users.id=friends.user_two_id";
		$condition2="(friends.user_two_id='$user_id' OR friends.user_one_id='$user_id') AND friends.status=1 AND tb_users.id!='$user_id' ";
		$pendingRequest = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,$groupby="");
		$allFriends = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation2,$condition2,$groupby="");

		$fcount = 0;
		if(!empty($data['pendingRequest'])){
			$fcount =  count($data['pendingRequest']) - 1;
		}
		
		$info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country','tb_users.business_name','requests.job_requested_by','tb_users.user_role');
		$relation="tb_users.id=requests.receiver";
		$condition=array('requests.sender'=>$user_id,'requests.status'=>0,'job_requested_by!='=>$user_id);
		$pendingRequestByCompany = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation,$condition,$groupby="");
	
		if(!empty($pendingRequestByCompany) && !empty($pendingRequest)){
			$data['pendingRequest'] = array_merge($pendingRequest,$pendingRequestByCompany);
		}else if(!empty($pendingRequest)){
			$data['pendingRequest'] = $pendingRequest;
		}else if(!empty($pendingRequestByCompany)){
			$data['pendingRequest'] = $pendingRequestByCompany;
		}else{
			$data['pendingRequest']=array();
		}

		
		
		$relation2="tb_users.id=requests.receiver";
		$condition2="(requests.sender='$user_id') AND requests.status=1 AND tb_users.id!='$user_id' ";
		$allFriendsCompany = array();
		if(!empty($allFriendsCompany) && !empty($allFriends)){
			$data['allFriends'] = array_merge($allFriends,$allFriendsCompany);
		}else if(!empty($allFriends)){
			$data['allFriends'] = $allFriends;
		}else if(!empty($allFriendsCompany)){
			$data['allFriends'] = $allFriendsCompany;
		}else{
			$data['allFriends'] = array();
		}

		$relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
		$condition2="(requests.receiver='$user_id' OR requests.sender='$user_id') AND requests.status=1 AND tb_users.id!='$user_id' ";
		$data['workingAt1'] = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");

		if($data){
			$resp=array("result"=>1,'msg'=>'User Friends Details .','data'=>$data);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}

/***************************/
/********Get-Pending Status-Details******/
/***************************/

public function getpendingrequest_post(){
	$this->form_validation->set_rules('user_id', 'User id', 'required');

	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$info=array('tb_users.id','tb_users.firstname','tb_users.device_id','tb_users.lastname','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country');
        $relation="tb_users.id=requests.sender";
        $condition=array('requests.receiver'=>$user_id,'requests.status'=>0,'requests.job_requested_by!='=>$user_id);
        $pendingRequest = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation,$condition,"");
        $userList = array();
        $usrdtl = array();
        if(!empty($pendingRequest)){
        	foreach($pendingRequest as $pending){
        		$usrdtl['id'] = $pending['id'];
        		$usrdtl['firstname'] = $pending['firstname'];
        		$usrdtl['lastname'] = $pending['lastname'];
        		$usrdtl['device_id'] = $pending['device_id'];
        		$usrdtl['email'] = $pending['email'];
        		$usrdtl['profile'] = $pending['profile'];
        		$usrdtl['city'] = $pending['city'];
        		$usrdtl['state'] = $pending['state'];
        		$usrdtl['country'] = $pending['country'];
        		$userList[] = $usrdtl;
        	}
        }
        
		$resp=array("result"=>1,'msg'=>'User List .','data'=>$userList);
		$this->response($resp, REST_Controller::HTTP_OK);
		
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}



/***************************/
/********Get-User-Details******/
/***************************/
// public function requeststatus_post(){
// 	$this->form_validation->set_rules('user_id', 'User id', 'required');

// 	if ($this->form_validation->run() == TRUE){
// 		$user_id=$this->input->post('user_id');
// 		$other_userid=$this->input->post('other_userid');
// 		$status=$this->input->post('status');

// 		$updtData=array('status'=>$status,'action_user_id'=>$user_id,'accept_date'=>date('Y-m-d H:i:s'));
// 		$where=array('user_one_id'=>$other_userid,'user_two_id'=>$user_id);
// 		if($status==1){
// 			$message="Request Accepted Successfully.";
// 		}else if($status==2){
// 			$message="Request Rejected Successfully.";
// 		}else{
// 			$message="Request placed Successfully.";
// 		}
// 		if($status==1 || $status==3){
// 			$updt=$this->common_model->updateFields(FRIENDS, $updtData, $where);				
// 			$notiF = array();
// 			$notiF['sender'] = $user_id;
// 			$notiF['receiver'] = $other_userid;
// 			if($status==1){
// 				$notiF['msg'] = "friend_request_accepted";

// 				/* To send push notifications */
// 				$notification_message = " has accepted your friend request.";
// 				$this->sendNotifications($other_userid,$user_id,'accept_friend_request',$notification_message);

// 			}else{
// 				$notiF['msg'] = "friend_request_blocked";	
// 			}
// 			$this->common_model->insertData('notifications',$notiF);
// 		}else{
// 			$updt=$this->common_model->deleteData(FRIENDS,$where);
// 		}


// 		if($updt){
// 			$resp=array("result"=>1,'msg'=>$message,'data'=>array() );
// 			$this->response($resp, REST_Controller::HTTP_OK);
// 		}else{
// 			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>0);
// 			$this->response($resp, REST_Controller::HTTP_OK);
// 		}
// 	}else{
// 		$error =array("result"=>0,"msg"=>validation_errors()); 
// 		$this->response($error, REST_Controller::HTTP_OK);
// 	}
// }


/***************************/
/********Get-User-Details******/
/***************************/
public function requeststatus_post(){
	$this->form_validation->set_rules('user_id', 'User id', 'required');

	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$other_userid=$this->input->post('other_userid');
		$status=$this->input->post('status');

		$updtData=array('status'=>$status,'action_user_id'=>$user_id,'accept_date'=>date('Y-m-d H:i:s'));
		$where=array('user_one_id'=>$other_userid,'user_two_id'=>$user_id);
		if($status==1){
			$message="Request Accepted Successfully.";
		}else if($status==2){
			$message="Request Rejected Successfully.";
		}else{
			$message="Request placed Successfully.";
		}
		if($status==1 || $status==3){
			$updt=$this->common_model->updateFields(FRIENDS, $updtData, $where);				
			$notiF = array();
			$notiF['sender'] = $user_id;
			$notiF['receiver'] = $other_userid;
			if($status==1){
				$notiF['msg'] = "friend_request_accepted";

				/* To send push notifications */
				$notification_message = " has accepted your friend request.";
				$this->sendNotifications($other_userid,$user_id,'accept_friend_request',$notification_message);

			}else{
				$notiF['msg'] = "friend_request_blocked";	
			}
			$this->common_model->insertData('notifications',$notiF);
		}else{
			$updt=$this->common_model->deleteData(FRIENDS,$where);
		}


		if($updt){
			$resp=array("result"=>1,'msg'=>$message,'data'=>array() );
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}


/***************************/
/********Pri-Job-Request-Status******/
/***************************/
public function jobrequeststatus_post(){
	$this->form_validation->set_rules('user_id', 'Current User Id', 'required');
	$this->form_validation->set_rules('other_userid', 'Other User Id', 'required');
	$this->form_validation->set_rules('per', 'Performer', 'required');//true means performer has accepted friend request
	$this->form_validation->set_rules('status', 'Status', 'required');//1/2/3
	if ($this->form_validation->run() == TRUE){
		$current_user_id = $this->input->post('user_id');
		$other_user_id = $this->input->post('other_userid');
		$per = $this->input->post('per');
		$status = $this->input->post('status');
		if($current_user_id){
            if($this->input->post('per')!='false'){
                $updtData=array('status'=>$status,'action_user_id'=>$current_user_id,'accept_date'=>date('Y-m-d H:i:s'),'confirmed_business'=>1);
            }else{
                $updtData=array('status'=>$status,'action_user_id'=>$current_user_id,'accept_date'=>date('Y-m-d H:i:s'),'confirmed'=>1);
            }

            if($this->input->post('per')!='false'){
                $where=array('sender'=>$current_user_id,'receiver'=>$other_user_id);
                $notiF = array();
                $notiF['sender'] = $current_user_id;
                $notiF['receiver'] = $other_user_id;
                $notiF['msg'] = "Job_accepted_by_performer";
                $this->common_model->insertData('notifications',$notiF);
                /* To send push notifications */
				$notification_message = " has accepted your job request.";
				$this->sendNotifications($current_user_id,$other_user_id,'accepted_job_request',$notification_message);
            }else{
                $where=array('sender'=>$other_user_id,'receiver'=>$current_user_id);
                $notiF = array();
                $notiF['sender'] = $current_user_id;
                $notiF['receiver'] = $other_user_id;
                $notiF['msg'] = "Job_accepted_by_employer";
                $this->common_model->insertData('notifications',$notiF);
                /* To send push notifications */
				$notification_message = " has accepted your job request.";
				$this->sendNotifications($other_user_id,$current_user_id,'accepted_job_request',$notification_message);
            }

            if($status == 1 || $status == 3){
                $updt=$this->common_model->updateFields(REQUESTS, $updtData, $where);
                if($updt){
                    $resp=array("result"=>1,'msg'=>'Accepted','data'=>array());
					$this->response($resp, REST_Controller::HTTP_OK);
                }else{
                    $resp=array("result"=>0,"msg"=>"Already accepted, Try again.",'data'=>0);
					$this->response($resp, REST_Controller::HTTP_OK);
                }
            }
            else{
                $this->common_model->deleteData(REQUESTS,$where);
                $resp=array("result"=>1,'msg'=>'Accepted','data'=>array());
				$this->response($resp, REST_Controller::HTTP_OK);
            }
        }
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Add-Friend******/
/***************************/
public function addfriend_post(){
	$this->form_validation->set_rules('sender_id', 'Sender id', 'required');
	$this->form_validation->set_rules('receiver_id', 'Receiver id', 'required');
	if ($this->form_validation->run() == TRUE){
		$sender_id=$this->input->post('sender_id');
		$receiver_id=$this->input->post('receiver_id');
	
		$condition="(`user_one_id` ='$sender_id' AND `user_two_id` = '$receiver_id') OR (`user_one_id` = '$receiver_id' AND `user_two_id` = '$sender_id')";
		$checkFriend = $this->common_model->getsingle(FRIENDS,$condition);
		if(!empty($checkFriend)){
			$req_status=$checkFriend->status;
			if($req_status==0){
				if($checkFriend->user_one_id==$sender_id){
					$resp=array("result"=>3,'msg'=>'Request already Sent','data'=>array());
					$this->response($resp, REST_Controller::HTTP_OK);
				}else{
					$resp=array("result"=>4,'msg'=>'Request pending.','data'=>array());
					$this->response($resp, REST_Controller::HTTP_OK);	
				}

			}else{
				$resp=array("result"=>2,'msg'=>'Already friend.','data'=>array());
				$this->response($resp, REST_Controller::HTTP_OK);
			}	
		}else{
			$dataInsert=array('user_one_id'=>$sender_id,'user_two_id'=>$receiver_id,'status'=>0,'action_user_id'=>$sender_id,'sent_date'=>date('Y-m-d H:i:s'));
			$ins=$this->common_model->insertData(FRIENDS, $dataInsert);
			$notiF = array();
			$notiF['sender'] = $sender_id;
			$notiF['receiver'] = $receiver_id;
			$notiF['msg'] = "friend_request_received";
			$this->common_model->insertData('notifications',$notiF);
			if($ins){

				/* To send push notifications */
				$notification_message = " sent you a friend request.";
				$this->sendNotifications($sender_id,$receiver_id,'friend_request',$notification_message);

				$resp=array("result"=>1,'msg'=>'Request Sent','data'=>array());
				$this->response($resp, REST_Controller::HTTP_OK);
			}else{
				$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>0);
				$this->response($resp, REST_Controller::HTTP_OK);
			}
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}

/***************************/
/********Pri-SEND-JOB-REQUEST******/
/***************************/
public function sendjobrequest_post(){
	$this->form_validation->set_rules('sender_id', 'Sender id', 'required');
	$this->form_validation->set_rules('receiver_id', 'Receiver id', 'required');
	$this->form_validation->set_rules('emp', 'Employer', 'required');//set true if sent by an employer
	if ($this->form_validation->run() == TRUE){
		$receiver = $this->input->post('receiver_id');  
		$sender = $this->input->post('sender_id');  
		$condition="(`sender` ='$sender' AND `receiver` = '$receiver') OR (`sender` = '$receiver' AND `receiver` = '$sender')";
		$checkRequests = $this->common_model->getsingle(REQUESTS,$condition);
		if(!empty($checkRequests)){
			$req_status=$checkRequests->status;
			if($req_status==0){
				if($checkRequests->sender==$sender){
					$resp=array('result'=>1,'msg'=>'Request already Sent','data'=>array());
				}else{
					$resp=array('result'=>1,'msg'=>'Request Pending','data'=>array());
				} 
			}else{
				$resp=array('result'=>1,'msg'=>'Already Friend','data'=>array()); 
			}
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			if($this->input->post('emp')!='false'){
				$dataInsert=array('sender'=>$receiver,'receiver'=>$sender,'status'=>0,'action_user_id'=>$sender,'sent_date'=>date('Y-m-d H:i:s'),'accept_status_notify_business_sent'=>1,'job_requested_by'=>$sender);
				$notiF = array();
				$notiF['sender'] = $sender;
				$notiF['receiver'] = $receiver;
				$notiF['msg'] = "Job_req_by_employer";
				$this->common_model->insertData('notifications',$notiF);
			}else{
				$dataInsert=array('sender'=>$sender,'receiver'=>$receiver,'status'=>0,'action_user_id'=>$sender,'sent_date'=>date('Y-m-d H:i:s'),'job_requested_by'=>$sender,'accept_status_notify'=>1);
				$notiF = array();
				$notiF['sender'] = $sender;
				$notiF['receiver'] = $receiver;
				$notiF['msg'] = "Job_req_by_performer";
				$this->common_model->insertData('notifications',$notiF);
			}
			$ins=$this->common_model->insertData(REQUESTS, $dataInsert);
			if($ins){

				/* To send push notifications */
				$notification_message = " sent you a job request.";
				$this->sendNotifications($sender,$receiver,'job_request',$notification_message);

				$resp=array('result'=>1,'msg'=>'Request Sent','data'=>array());
			}
			$this->response($resp, REST_Controller::HTTP_OK);
		}   
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}

/***************************/
/********Get-User-Details******/
/***************************/
public function unfriend_post(){
	$this->form_validation->set_rules('user_id', 'User id', 'required');
	$this->form_validation->set_rules('friend_id', 'Friend id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$friend_id=$this->input->post('friend_id');

		if($this->common_model->deleteData(FRIENDS,array('user_one_id'=>$friend_id,'user_two_id'=>$user_id))){
			$resp=array("result"=>1,'msg'=>'Unfriend Successfully.','data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);

		}else if($this->common_model->deleteData(FRIENDS,array('user_one_id'=>$user_id,'user_two_id'=>$friend_id))){
			$resp=array("result"=>1,'msg'=>'Unfriend Successfully.','data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********WALLPOST******/
/***************************/
public function wallpost_post(){
	$this->form_validation->set_rules('user_id', 'User id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$post_content=$this->input->post('post_content');
		$dataArr=array();

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
					$config['allowed_types'] = '*';
					$path=$config['upload_path'];
					$config['overwrite'] = '1';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if( !$this->upload->do_upload("docfile")){
						$error = array('error' => $this->upload->display_errors());
						$resp=array("result"=>0,'msg'=>$error,'data'=>array());
						$this->response($resp, REST_Controller::HTTP_OK);
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
		if(!empty($_FILES['post_video'])){
			$loggedUserId=$user_id;
			$fileName = $_FILES['post_video']['name'];
			$dats=explode('.',$fileName);
			$ext=$dats[1];
			$targetDir = FCPATH."uploads/videos/";
			$time = time().'_'.rand(99999,9999999999).'_'.rand(10000,99999);
			$newfilename=$time.'.'."mp4";
			$temp=$time;
			$targetFile = $targetDir.$newfilename;
			if(move_uploaded_file($_FILES['post_video']['tmp_name'],$targetFile)){
				$dataArr['post_video']=$newfilename;
				exec("ffmpeg -i ".$targetDir.$temp.".mp4"); 
				$dataArr['post_video'] = $temp.".mp4";

			}else{
				$resp=array("result"=>0,'msg'=>$fileName. " Not Getting",'data'=>array());
				$this->response($resp, REST_Controller::HTTP_OK);
			}
		}

		$loggedUserId=$user_id;
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

		$dataArr['post_title']='';
		$dataArr['post_content']=$post_content;
		$dataArr['user_id']=$loggedUserId;
		$dataArr['post_status']=0;
		$addpost = $this->common_model->insertData(POSTS,$dataArr); 

		$user_wallpost = $this->common_model->getAllwhere(POSTS,array('user_id'=>$loggedUserId), 'id', 'DESC','all',10,0);


		if($addpost){
			$resp=array("result"=>1,'msg'=>'Posted Successfully.','data'=>array('all_posts'=>$user_wallpost));
			$this->response($resp, REST_Controller::HTTP_OK);

		}else{
			$resp=array("result"=>0,'msg'=>'Something Went Wrong, Try Again.','data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/**********Delete-Post************/
/***************************/
public function deletepost_post(){
	$this->form_validation->set_rules('post_id', 'Post id', 'required');
	if ($this->form_validation->run() == TRUE){
		$post_id=$this->input->post('post_id');
		$posts =$this->common_model->getsingle('posts',array('id'=>$post_id));

		$post_images=$posts->post_image;
		if(!empty($post_images)){ $imgarr=explode(',',$post_images);
		foreach($imgarr as $image){
			$nimga=explode("/",$image);
			unlink($_SERVER["DOCUMENT_ROOT"].'/uploads/posts/'.end($nimga));
		}
	}

	$post_video=$posts->post_video;
	if(!empty($post_video)){
		unlink($_SERVER["DOCUMENT_ROOT"].'/uploads/videos/'.$post_video);
	}
	$user_data = $this->common_model->deleteData('posts',array('id'=>$post_id));

	if($user_data){
		$resp=array("result"=>1,'msg'=>'Post Deleted Successfully','data'=>array());
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>0);
		$this->response($resp, REST_Controller::HTTP_OK);
	}
}else{
	$error =array("result"=>0,"msg"=>validation_errors()); 
	$this->response($error, REST_Controller::HTTP_OK);
}
}
/***************************/
/********Forgot-Password******/
/***************************/
public function forgetpassword_post(){
	$this->form_validation->set_rules('email', 'User id', 'required');
	if ($this->form_validation->run() == TRUE){
		$email=$this->input->post('email');
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
	$resp=array("result"=>1,'msg'=>'Please check your email. Reset link sent to your email.','data'=>array());
	$this->response($resp, REST_Controller::HTTP_OK);
}else{
	$resp=array("result"=>1,'msg'=>'Failed to send mail, please try again!','data'=>array());
	$this->response($resp, REST_Controller::HTTP_OK);
}
} 
}else{
	$error =array("result"=>0,"msg"=>'Email not found.','data'=>0); 
	$this->response($error, REST_Controller::HTTP_OK); 
}
}else{
	$error =array("result"=>0,"msg"=>validation_errors()); 
	$this->response($error, REST_Controller::HTTP_OK);
}
}
/***************************/
/********Get-User-Details******/
/***************************/
public function getusers_post(){
	$this->form_validation->set_rules('limit', 'Limit', 'required');
	if ($this->form_validation->run() == TRUE){
		$limit=$this->input->post('limit');
		$start_from=$this->input->post('start_from');

		$startfrom=0;
		if(!empty($start_from)){
			$startfrom=	$start_from;
		}
		$user_id=$this->input->post('user_id');
		if($user_id==""){
			$user_id=0;
		}

		$user_data = $this->common_model->getAllwhere(USERS,array('status'=>'verify'), 'id', 'DESC','all',$limit,$startfrom);
		$userlist=array();
		$userdtl=array();
		if(!empty($user_data['result'])){
			foreach($user_data['result'] as $usr){
				$nuserid=$usr->id;
				$userdtl['id']=$usr->id;
				$userdtl['type']=$usr->type;
				$userdtl['firstname']=$usr->firstname;
				$userdtl['lastname']=$usr->lastname;
				$userdtl['device_id']=$usr->device_id;
				$userdtl['email']=$usr->email;
				$userdtl['profile']=$usr->profile;
				$userdtl['gender']=$usr->gender;
				$userdtl['user_role']=$usr->user_role;
				$userdtl['user_category']=$usr->user_category;
				$userdtl['zip']=$usr->zip;
				$userdtl['city']=$usr->city;
				$userdtl['state']=$usr->state;
				$userdtl['country']=$usr->country;
				$userdtl['current_position']=$usr->current_position;
				$userdtl['working_at']=$usr->working_at;
				$userdtl['basic_info']=$usr->basic_info;
				$info=array('tb_users.profile','tb_users.business_address','tb_users.city','tb_users.state','tb_users.country','tb_users.business_name','requests.job_requested_by','tb_users.user_role');
				$relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
				$condition2="(requests.receiver='$nuserid' OR requests.sender='$nuserid') AND requests.status=1 AND tb_users.id!='$nuserid' ";
				$user_workingAt1 = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");

				$currentUserData = $this->common_model->getsingle(USERS,array('id'=>$user_id));
				$status1 = '';
				if(!empty($currentUserData)){
					$userRole = $currentUserData->user_role;

					if($usr->user_role=='Employer'){ 
						if($userRole == 'Employer'){ 
						}
						else{  
							if($user_id){
								$userOne = $user_id;
								$userTwo = $usr->id;
								$isRequest = checkRequest($userOne,$userTwo);
								$requestedByUser = jobRequestedBy($userOne,$usr->id);
								if($requestedByUser != $userOne && $requestedByUser!=0 && $isRequest!='Accepted'){
									$isRequest = 'NotConfirm';
								}
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}
							else if($isRequest=='NotConfirm'){ 
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($senderID,$usr->id);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 
									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								}
							}
							else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}
							else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}
					}
					else{
						if($userRole == 'Employer'){ 
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isRequest=checkRequest($userOne,$userTwo);
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}else if($isRequest=='NotConfirm'){
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($usr->id,$senderID);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 

									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								} 

							} else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}else{
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isFriend=checkFriend($userOne,$userTwo);
							}else{
								$isFriend="No"; 
							}

							if($isFriend=='No'){ 
								$status1 = 'Add Friend';
							}
							else if($isFriend=='NotConfirm'){ 
								$status1 = 'Confirm';
							}else if($isFriend=='Pending'){
								$status1 = 'Pending';
							}else if($isFriend=='Accepted'){
								$status1 = 'Accepted';
							} 
						}
					}
				}
				$userdtl['req_status'] = $status1;


				if(!empty($user_workingAt1) && ($usr->user_role == 'Performer')){
					$userdtl['working_at']=$user_workingAt1[0]['business_name'];
					$userdtl['business_name']=$user_workingAt1[0]['business_name'];
					$userdtl['business_address']=$user_workingAt1[0]['business_address'];
				}else{
					$userdtl['working_at']='';
					$userdtl['business_name']=$usr->business_name;
					$userdtl['business_address']='';
				}
				$ratingData =  userOverallRatings($usr->id);
				$starRating=0;
				if(isset($ratingData['ratingAverage'])){ $starRating= $ratingData['ratingAverage']; }
				$userdtl['ratings']=$starRating;
				$favourite=0;
				if($user_id!=0){
					$dataArr=array('added_by'=>$user_id,'added_to'=>$nuserid);
					$alreadyFavourite = $this->common_model->getsingle(FAVOURITES,$dataArr);
					if(!empty($alreadyFavourite)){
						$favourite=1;	
					}
				}
				$userdtl['favourite']=$favourite;
				$userlist[]=$userdtl;
			}
		}

		if($user_data){
			$resp=array("result"=>1,'msg'=>'User List .','data'=>$userlist,'allusers'=>$user_data['total_count']);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Get-PROFILESTATUS******/
/***************************/
public function profilestatus_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$user_data = $this->common_model->getsingle(USERS,array('id'=>$user_id));;

		if($user_data){
			$resp=array("result"=>1,'msg'=>'Complete profile status 1 for complete 0 for incomplete .','complete_profile'=>$user_data->basic_info);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'complete_profile'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Get-PROFILESTATUS******/
/***************************/
public function getratings_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$ratingData =  userOverallRatings($user_id);
		if(isset($ratingData['ratingAverage'])){ $starRating= $ratingData['ratingAverage']; }else{ $starRating=0; }
		if($starRating!=""){
			$resp=array("result"=>1,'msg'=>'Ratings','rating'=>$starRating);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'rating'=>$starRating);
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********GET-NEARBY******/
/***************************/
public function getnearby_post(){
	//$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('limit', 'Limit', 'required');
	$this->form_validation->set_rules('latitude', 'Latitude', 'required');
	$this->form_validation->set_rules('longitude', 'Longitude', 'required');
	$this->form_validation->set_rules('distance', 'Distance', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$limit=$this->input->post('limit');
		$latitude=$this->input->post('latitude');
		$longitude=$this->input->post('longitude');
		$distance=$this->input->post('distance');
		$query="SELECT  id,type,firstname,lastname,email,profile,gender,device_id,business_name,user_role,user_category,zip,city,state,country,current_position,working_at,basic_info,(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos( radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) as distance FROM `tb_users` WHERE `status`='verify' HAVING  distance < $distance  ORDER BY distance";	
		//pr($query);
		$alldata=$this->User_model->customquery($query);
		$userdtl=array();
		$userlist=array();
		if(!empty($alldata)){
			foreach($alldata as $usr){
				$userdtl['distance']=$usr->distance;
				$nuserid=$usr->id;
				$userdtl['id']=$usr->id;
				$userdtl['type']=$usr->type;
				$userdtl['firstname']=$usr->firstname;
				$userdtl['lastname']=$usr->lastname;
				$userdtl['device_id']=$usr->device_id;
				$userdtl['email']=$usr->email;
				$userdtl['profile']=$usr->profile;
				$userdtl['gender']=$usr->gender;
				$userdtl['user_role']=$usr->user_role;
				$userdtl['user_category']=$usr->user_category;
				$userdtl['zip']=$usr->zip;
				$userdtl['city']=$usr->city;
				$userdtl['state']=$usr->state;
				$userdtl['country']=$usr->country;
				$userdtl['current_position']=$usr->current_position;
				$userdtl['basic_info']=$usr->basic_info;
				$info=array('tb_users.profile','tb_users.business_address','tb_users.city','tb_users.state','tb_users.country','tb_users.business_name','requests.job_requested_by','tb_users.user_role');
				$relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
				$condition2="(requests.receiver='$nuserid' OR requests.sender='$nuserid') AND requests.status=1 AND tb_users.id!='$nuserid' ";
				$user_workingAt1 = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");
				if(!empty($user_workingAt1) && ($usr->user_role == 'Performer')){
					$userdtl['working_at']=$user_workingAt1[0]['business_name'];
					$userdtl['business_name']=$user_workingAt1[0]['business_name'];
					$userdtl['business_address']=$user_workingAt1[0]['business_address'];
				}else{
					$userdtl['working_at']='';
					$userdtl['business_name']=$usr->business_name;
					$userdtl['business_address']='';
				}
				$ratingData =  userOverallRatings($usr->id);
				$starRating=0;
				if(isset($ratingData['ratingAverage'])){ $starRating= $ratingData['ratingAverage']; }
				$userdtl['ratings']=$starRating;
				$status1 = '';
				
				if(!empty($user_id)){ 
                $currentUserData = $this->common_model->getsingle(USERS,array('id'=>$user_id));
				$status1 = '';
				if(!empty($currentUserData)){
					$userRole = $currentUserData->user_role;
					if($usr->user_role=='Employer'){ 
						if($userRole == 'Employer'){ 
						}
						else{  
							if($user_id){
								$userOne = $user_id;
								$userTwo = $usr->id;
								$isRequest = checkRequest($userOne,$userTwo);
								$requestedByUser = jobRequestedBy($userOne,$usr->id);
								if($requestedByUser != $userOne && $requestedByUser!=0 && $isRequest!='Accepted'){
									$isRequest = 'NotConfirm';
								}
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}
							else if($isRequest=='NotConfirm'){ 
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($senderID,$usr->id);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 
									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								}
							}
							else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}
							else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}
					}
					else{
						if($userRole == 'Employer'){ 
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isRequest=checkRequest($userOne,$userTwo);
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}else if($isRequest=='NotConfirm'){
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($usr->id,$senderID);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 

									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								} 

							} else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}else{
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isFriend=checkFriend($userOne,$userTwo);
							}else{
								$isFriend="No"; 
							}

							if($isFriend=='No'){ 
								$status1 = 'Add Friend';
							}
							else if($isFriend=='NotConfirm'){ 
								$status1 = 'Confirm';
							}else if($isFriend=='Pending'){
								$status1 = 'Pending';
							}else if($isFriend=='Accepted'){
								$status1 = 'Accepted';
							} 
						}
					}
				}
				}else{ $status1 = '';}
				$favourite=0;
				if(!empty($user_id)){
					if($usr->id!=$user_id || $user_id!=""){
						$dataArr=array('added_by'=>$user_id,'added_to'=>$usr->id);
						$alreadyFavourite = $this->common_model->getsingle(FAVOURITES,$dataArr);
						if(!empty($alreadyFavourite)){
							$favourite=1;	
						}
					}
			    }
				$userdtl['favourite']=$favourite;
				$userdtl['req_status'] = $status1;
				$userlist[]=$userdtl;
			}
		}

		if($alldata){
			$resp=array("result"=>1,'msg'=>'User List .','data'=>$userlist);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Get-WALLPOST******/
/***************************/
public function getwallpost_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('start_limit', 'Start limit', 'required');
	$this->form_validation->set_rules('end_limit', 'End limit', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$start_limit=$this->input->post('start_limit');
		$end_limit=$this->input->post('end_limit');
		$data=array();
		$datas=array();
		$mdata=array();
		$user_data = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id), 'id', 'DESC','all',$end_limit,$start_limit);
		$data['total_count']=$user_data['total_count'];
		if(!empty($user_data['result'])){
			foreach($user_data['result'] as $dat ){
				$datas['id']=$dat->id;
				$datas['user_id']=$dat->user_id;
				$datas['post_title']=$dat->post_title;
				$datas['post_content']=$dat->post_content;
				$datas['post_image']=$dat->post_image;
				$datas['post_video']=$dat->post_video;
				$datas['post_date']=$dat->post_date;
				$datas['post_status']=$dat->post_status;
				$datas['company']=$dat->company;
				$datas['repeat_status']=$dat->repeat_status;
				$datas['user_repeat_ids']=$dat->user_repeat_ids;
				$postlikes = $this->common_model->getAllwhere(LIKE,array('post_id'=>$dat->id,'status'=>1));
				$commentData = $this->common_model->GetJoinRecord(COMMENTS,'user_id',USERS,'id','comments.*,tb_users.firstname,tb_users.lastname,tb_users.profile',array('comments.post_id'=>$dat->id));
				$datas['comments']=$commentData['total_count'];

				$likeData = $this->common_model->getsingle(LIKE,array('liked_by'=>$user_id,'post_id'=>$dat->id));
				if(!empty($likeData) && $likeData->status==1){
					$datas['status']=1;
				}else{
					$datas['status']=0;	
				}

				$datas['likes']=$postlikes['total_count'];
				$mdata[]=$datas;
			}
		}
		$data['result']=$mdata;

		if($user_data){
			$resp=array("result"=>1,'msg'=>'USER POSTS','allposts'=>$data);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'allposts'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/***SINGLE-USER-DETAILS*****/
/***************************/
public function singleuserdetails_post(){
	$this->form_validation->set_rules('user_id', 'User id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$my_id=$this->input->post('my_id');
		$favourite=0;
		
		if($my_id!=$user_id || $my_id!=""){
			$dataArr=array('added_by'=>$my_id,'added_to'=>$user_id);
			$alreadyFavourite = $this->common_model->getsingle(FAVOURITES,$dataArr);
			if(!empty($alreadyFavourite)){
				$favourite=1;	
			}
		}
		$user_data = $this->common_model->getsingle(USERS,array('id'=>$user_id));
		if(empty($user_data)){
			$resp=array("result"=>0,"msg"=>"This user not exist in our database",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);
		}
		
		$currentUserData = $this->common_model->getsingle(USERS,array('id'=>$my_id));
		$status1 = '';
		if(!empty($currentUserData)){
			$userRole = $currentUserData->user_role;
			if($user_data->user_role=='Employer'){ 
				if($userRole == 'Employer'){ 
				}
				else{  
					if($my_id){
						$userOne = $my_id;
						$userTwo = $user_data->id;
						$isRequest = checkRequest($userOne,$userTwo);
						$requestedByUser = jobRequestedBy($userOne,$user_data->id);
						if($requestedByUser != $userOne && $requestedByUser!=0 && $isRequest!='Accepted'){
							$isRequest = 'NotConfirm';
						}
					}else{
						$isRequest="No";  
					}
					if($isRequest=='No'){ 
						$status1 = 'Job Request';
					}
					else if($isRequest=='NotConfirm'){ 
						$senderID = $my_id;
						$requestedByUser = jobRequestedBy($senderID,$user_data->id);

						if($requestedByUser != $senderID && $requestedByUser!=0){ 
							$status1 = 'Accept Request';
						}else{ 
							$status1 = 'Pending';
						}
					}
					else if($isRequest=='Pending'){ 
						$status1 = 'Pending';
					}
					else if($isRequest=='Accepted'){
						$status1 = 'Accepted';
					}
				}
			}
			else{
				if($userRole == 'Employer'){ 
					if($my_id){
						$userOne=$my_id;
						$userTwo=$user_data->id;
						$isRequest=checkRequest($userOne,$userTwo);
					}else{
						$isRequest="No";  
					}
					if($isRequest=='No'){ 
						$status1 = 'Job Request';
					}else if($isRequest=='NotConfirm'){
						$senderID = $my_id;
						$requestedByUser = jobRequestedBy($user_data->id,$senderID);

						if($requestedByUser != $senderID && $requestedByUser!=0){ 

							$status1 = 'Accept Request';
						}else{ 
							$status1 = 'Pending';
						} 

					} else if($isRequest=='Pending'){ 
						$status1 = 'Pending';
					}else if($isRequest=='Accepted'){
						$status1 = 'Accepted';
					}
				}else{
					if($my_id){
						$userOne=$my_id;
						$userTwo=$user_data->id;
						$isFriend=checkFriend($userOne,$userTwo);
					}else{
						$isFriend="No"; 
					}

					if($isFriend=='No'){ 
						$status1 = 'Add Friend';
					}
					else if($isFriend=='NotConfirm'){ 
						$status1 = 'Confirm';
					}else if($isFriend=='Pending'){
						$status1 = 'Pending';
					}else if($isFriend=='Accepted'){
						$status1 = 'Accepted';
					} 
				}
			}
		}
		$req_status = $status1;


		$user_posts = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id), 'id', 'DESC','all',5,0);
		$userposts=array();
		$mdata=array();
		if(!empty($user_posts['result'])){
			foreach($user_posts['result'] as $dat ){
				$datas['id']=$dat->id;
				$datas['user_id']=$dat->user_id;
				$datas['post_title']=$dat->post_title;
				$datas['post_content']=$dat->post_content;
				$datas['post_image']=$dat->post_image;
				$datas['post_video']=$dat->post_video;
				$datas['post_date']=$dat->post_date;
				$datas['post_status']=$dat->post_status;
				$datas['company']=$dat->company;
				$datas['repeat_status']=$dat->repeat_status;
				$datas['user_repeat_ids']=$dat->user_repeat_ids;
				$postlikes = $this->common_model->getAllwhere(LIKE,array('post_id'=>$dat->id,'status'=>1));
				$commentData = $this->common_model->GetJoinRecord(COMMENTS,'user_id',USERS,'id','comments.*,tb_users.firstname,tb_users.lastname,tb_users.profile',array('comments.post_id'=>$dat->id));
				$datas['comments']=$commentData['total_count'];
				$likeData = $this->common_model->getsingle(LIKE,array('liked_by'=>$user_id,'post_id'=>$dat->id));
				if(!empty($likeData) && $likeData->status==1){
					$datas['status']=1;
				}else{
					$datas['status']=0;	
				}
				$datas['likes']=$postlikes['total_count'];
				$mdata[]=$datas;
			}
		}
		$userposts=$mdata;

		$user_albums = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_image!='=>''), 'id', 'DESC','all',5,0);
		$user_albumsre=$user_albums['result'];
		$user_album=array();
		if(!empty($user_albumsre)){
			foreach($user_albumsre as $alb){
				$user_album[]=$alb->post_image;
			}
		}

		$ratingData =  userOverallRatings($user_id);
		$user_rating=0; if(isset($ratingData['ratingAverage'])){ $user_rating= $ratingData['ratingAverage']; }
		$user_reviewCount=0; if(isset($ratingData['reviewCount'])){ $user_reviewCount= $ratingData['reviewCount']; }

		$data=array();
		$info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.device_id','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country','tb_users.user_role','tb_users.business_name');
		$relation="tb_users.id=friends.user_one_id";
		$condition=array('friends.user_two_id'=>$user_id,'friends.status'=>0,'tb_users.user_role!='=>"Employer");
		$relation2="tb_users.id=friends.user_one_id OR tb_users.id=friends.user_two_id";
		$condition2="(friends.user_two_id='$user_id' OR friends.user_one_id='$user_id') AND friends.status=1 AND tb_users.id!='$user_id' ";
		$pendingRequest = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,$groupby="");
		$allFriends = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation2,$condition2,$groupby="","","",5,0);

		$fcount = 0;
		if(!empty($data['pendingRequest'])){
			$fcount =  count($data['pendingRequest']) - 1;
		}
		$info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.device_id','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country','tb_users.business_name','requests.job_requested_by','tb_users.user_role');
		$relation="tb_users.id=requests.receiver";
		$condition=array('requests.sender'=>$user_id,'requests.status'=>0,'job_requested_by!='=>$user_id);
		$pendingRequestByCompany = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation,$condition,$groupby="");
		if(!empty($pendingRequestByCompany) && !empty($pendingRequest)){
			$data['pendingRequest'] = array_merge($pendingRequest,$pendingRequestByCompany);
		}else if(!empty($pendingRequest)){
			$data['pendingRequest'] = $pendingRequest;
		}else if(!empty($pendingRequestByCompany)){
			$data['pendingRequest'] = $pendingRequestByCompany;
		}else{
			$data['pendingRequest']=array();
		}

		$relation2="tb_users.id=requests.receiver";
		$condition2="(requests.sender='$user_id') AND requests.status=1 AND tb_users.id!='$user_id' ";
		$allFriendsCompany = array();
		if(!empty($allFriendsCompany) && !empty($allFriends)){
			$data['allFriends'] = array_merge($allFriends,$allFriendsCompany);
		}else if(!empty($allFriends)){
			$data['allFriends'] = $allFriends;
		}else if(!empty($allFriendsCompany)){
			$data['allFriends'] = $allFriendsCompany;
		}else{
			$data['allFriends'] = array();
		}

		$relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
		$condition2="(requests.receiver='$user_id' OR requests.sender='$user_id') AND requests.status=1 AND tb_users.id!='$user_id' ";
		$user_workingAt1 = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");
		if(!empty($user_workingAt1)){
			$user_data->working_at=$user_workingAt1[0]['business_name'];
			$user_data->working_at_id=$user_workingAt1[0]['id'];
		}else{
			$user_data->working_at='';	
			$user_data->working_at_id='';	
		}
		$ratingDetails= $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id));	
		$percentarray = array();
		if(!empty($ratingDetails['result'])){
			$percent_cnt1 = 0;
			$percent_cnt2 = 0;
			$percent_cnt3 = 0;
			$percent_cnt4 = 0;
			$percent_cnt5 = 0;
			foreach($ratingDetails['result'] as $row){
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
				$percentarray[1] = ($percent_cnt1/$ratingDetails['total_count'])*100;
			}if($percent_cnt2>0){
				$percentarray[2] = ($percent_cnt2/$ratingDetails['total_count'])*100;
			}if($percent_cnt3>0){
				$percentarray[3] = ($percent_cnt3/$ratingDetails['total_count'])*100;
			}if($percent_cnt4>0){
				$percentarray[4] = ($percent_cnt4/$ratingDetails['total_count'])*100;
			}if($percent_cnt5>0){
				$percentarray[5] = ($percent_cnt5/$ratingDetails['total_count'])*100;
			}
		}
		$performance = $percentarray;	

//QR code generate
		$data['img_url']="";
		$this->load->library('ciqrcode');
		$qr_image=rand().'.png';
		$params['data'] = $user_id;
		$params['level'] = 'H';
		$params['size'] = 5;
		$params['savename'] =FCPATH."qr_code/".$qr_image;
		if($this->ciqrcode->generate($params)){
			$myqr_image=base_url().'qr_code/'.$qr_image; 
		}else{
			$myqr_image="";
		}

		/*user review count greater than 250*/
		$userRatings = $this->common_model->getAllwhere(RATINGS,array('avg_rating'=>5,'rated_to_user'=>$user_id));
		$ratingCount250 = 0;
		$star_250 = 0;
		if(!empty($userRatings['total_count'])){
			$ratingCount250 = $userRatings['total_count'];
			if($ratingCount250 >= 250){
				$star_250 = 1;
			}
		}

		if($user_data){
			$resp=array("result"=>1,'msg'=>'User Details .','data'=>array('profiledata'=>$user_data,'posts'=>$userposts,'rating'=>$user_rating,'user_reviewCount'=>$user_reviewCount,'qr_image'=>$myqr_image,'favourite'=>$favourite,'album'=>$user_album,'friends'=>$data,'performance'=>$performance,'star_250'=>$star_250,'req_status'=>$req_status));
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/**********Social Login************/
/***************************/
public function sociallogin_post(){
	$this->form_validation->set_rules('firstname', 'First Name', 'required');
	$this->form_validation->set_rules('oauth_uid', 'Oauth uid', 'required');
	$this->form_validation->set_rules('device_id', 'Device id', 'required');
	$this->form_validation->set_rules('device_type', 'Device type', 'required');
	$this->form_validation->set_rules('latitude', 'Latitude', 'required');
	$this->form_validation->set_rules('longitude', 'Longitude', 'required');
	if ($this->form_validation->run() == TRUE){
		$firstname=$this->input->post('firstname');
		$lastname=$this->input->post('lastname');
		$email=$this->input->post('email');
		$oauth_uid=$this->input->post('oauth_uid');
		$profile_url=$this->input->post('profile_url');
		$type=$this->input->post('type');
		$device_id=$this->input->post('device_id');
		$device_type=$this->input->post('device_type');
		$latitude=$this->input->post('latitude');
		$longitude=$this->input->post('longitude');
		
		$result=array();
		if(!empty($email)){
		$result = $this->User_model->check_email($email);
		}
		$check_oauth = $this->common_model->getsingle(USERS,array('oauth_uid'=>$oauth_uid));
		
		
		if(!empty($result)){
			$userdata = array(
				'type' => $type,
				'device_id' => $device_id,
				'device_type' => $device_type,
				'status' => 'verify'					
			);
			
			if(!empty($oauth_uid)){
			$userdata['oauth_uid']=$oauth_uid;	
			}
			if(!empty($latitude) && !empty($longitude)){
				$userdata['latitude']=$latitude;
				$userdata['longitude']=$longitude;
			}
			$results=$this->common_model->updateFields(USERS,$userdata,array('id'=>$result->id));
			$user_data = $this->common_model->getsingle(USERS,array('id'=>$result->id));
			$resp=array("result"=>1,'data'=>array('userdata'=>$user_data),'msg'=>'Successfully Login. 1');
			$this->response($resp, REST_Controller::HTTP_OK);	

		}else if(!empty($check_oauth)){
			$userdata = array(
				'type' => $type,
				'device_id' => $device_id,
				'device_type' => $device_type,
				//'oauth_uid' => $oauth_uid,
				'status' => 'verify'					
			);
			if(!empty($oauth_uid)){
			    $userdata['oauth_uid']=$oauth_uid;	
			}
			if(!empty($latitude) && !empty($longitude)){
				$userdata['latitude']=$latitude;
				$userdata['longitude']=$longitude;
			}
			
			$results=$this->common_model->updateFields(USERS,$userdata,array('id'=>$check_oauth->id));
			$user_data = $this->common_model->getsingle(USERS,array('id'=>$check_oauth->id));
			$resp=array("result"=>1,'data'=>array('userdata'=>$user_data),'msg'=>'Successfully Login. 2');
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$userdata = array(
				'type' => $type,
				'firstname' => $firstname,
				'lastname' => $lastname,
				'email' => $email,
				'profile' => $profile_url,
				'oauth_uid' => $oauth_uid,
				'device_id' => $device_id,
				'device_type' => $device_type,
				'latitude' => $latitude,
				'longitude' => $longitude,
				'status' => 'verify'					
			);
			$inserts=$this->User_model->insert_user($userdata);

			if($inserts){
				$user_data = $this->common_model->getsingle(USERS,array('id'=>$inserts));
				$resp=array("result"=>1,'data'=>array('userdata'=>$user_data),'msg'=>'Successfully Login. 3');
				$this->response($resp, REST_Controller::HTTP_OK);
			}else{
				$resp=array("result"=>0,"msg"=>"Error in registration!",'data'=>0);
				$this->response($resp, REST_Controller::HTTP_OK);	
			}

		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/**********Login************/
/***************************/
public function getallreviews_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$my_id=$this->input->post('my_id');
		$data=array();
		$star_id="";
		$condition=array('id'=>$user_id);                                   
		$workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$user_id,'status'=>1),'id','DESC','all',1);
		if(!empty($workingAt['result'])){
			$compId=$workingAt['result'][0]->receiver;
			$data['workingAt'] = get_where('tb_users',array('id'=>$compId),'row');
		}else{
			$data['workingAt']=array();
		}

		$ratingData =  userOverallRatings($user_id);
		if(isset($ratingData['ratingAverage'])){ $starRating= $ratingData['ratingAverage']; }else{ $starRating=0; }
		$data['avgRating']=$starRating;
		$allratings=$this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id));
		$userdata =  $this->common_model->getsingle(USERS,array('id'=>$user_id));
		if(empty($userdata)){
			$error =array("result"=>0,"msg"=>'User Not Available'); 
	        $this->response($error, REST_Controller::HTTP_OK);	
		}
		
		$category_id= $userdata->user_category;
		$user_role= $userdata->user_role;
		if($category_id==""){
			$category_id=1;	
		}
		if($user_role=='Employer'){
			$questions=$this->common_model->getAllwhere('category_questions',array('category_id'=>$category_id,'user_type'=>'Employer'));
		}else{
			$questions=$this->common_model->getAllwhere('category_questions',array('category_id'=>$category_id,'user_type'=>'Employee'));	
		}
		$data['userinfo']=$userdata;
		$question_array=array();
		if(!empty($questions['result'])){
			$quesNo=0;
			foreach($questions['result'] as $ques){ $quesNo++;
				$question_array[]= $ques->question; 
			}
		}


		$arating=array();
		$srating=array();

		if(!empty($allratings['result'])){ foreach($allratings['result'] as $rating){
			$company_id=$rating->company_id;
			$rated_by_user=$rating->rated_by_user;
			$ratingData2 =  userOverallRatings($rated_by_user);
			if(isset($ratingData2['ratingAverage'])){ $starRating2= $ratingData2['ratingAverage']; }else{ $starRating2=0; }
			$ratedbydetails= $this->common_model->getsingle(USERS,array('id'=>$rated_by_user));

			$ratedbydtls=array(
				'name'=>$ratedbydetails->firstname.' '.$ratedbydetails->lastname,
				'country'=>$ratedbydetails->country,
				'state'=>$ratedbydetails->state,
				'city'=>$ratedbydetails->city,
				'profile_image'=>$ratedbydetails->profile,
				'rating'=>$starRating2,
				'rated_by_user'=>$rated_by_user,
				'anonymous'=>$rating->anonymous,
				'user_role'=>$ratedbydetails->user_role,
				'business_name'=>$ratedbydetails->business_name,
				'device_id'=>$ratedbydetails->device_id,
			);

			$questionrating=array(
				$question_array[0]=>(float)$rating->ques_1,
				$question_array[1]=>(float)$rating->ques_2,
				$question_array[2]=>(float)$rating->ques_3,
				$question_array[3]=>(float)$rating->ques_4,
				$question_array[4]=>(float)$rating->ques_5
			);

			$comment=$rating->message;
			$reply= strip_tags($rating->reply);

			$srating[]=array('ratedby_details'=>$ratedbydtls,'questions_rating'=>$questionrating,'comment'=>$comment,'reply'=>$reply); 
		}	 
	}  

	$data['user_id'] = $user_id;
	$data['MyhistoryRating'] = $srating;
	if($my_id){
		$data['anonymous'] = $this->common_model->getsingle(RATINGS,array('rated_by_user'=>$my_id,'rated_to_user'=>$user_id));
	}
	$resp=array("result"=>1,'msg'=>'User List .','data'=>$data);
	$this->response($resp, REST_Controller::HTTP_OK); 

}else{
	$error =array("result"=>0,"msg"=>validation_errors()); 
	$this->response($error, REST_Controller::HTTP_OK);
}

}
/***************************/
/********Get-Rating-Questions******/
/***************************/
public function getquestions_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$userdata= $this->common_model->getsingle(USERS,array('id'=>$user_id));
		$category_id= $userdata->user_category;
		$user_role= $userdata->user_role;

		if($user_role=='Employer'){
			$questions=$this->common_model->getAllwhere('category_questions',array('category_id'=>$category_id,'user_type'=>'Employer'));
		}else{
			$questions=$this->common_model->getAllwhere('category_questions',array('category_id'=>$category_id,'user_type'=>'Employee'));	
		}

		if(!empty($questions)){

			$resp=array("result"=>1,'msg'=>'Rating Questions ','questions'=>$questions);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'questions'=>$questions);
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Post-Review-******/
/***************************/
public function postreview_post(){
	$this->form_validation->set_rules('rated_by_user', 'Rated by user', 'required');
	$this->form_validation->set_rules('rated_to_user', 'Rated to user', 'required');
	$this->form_validation->set_rules('ques_1', 'Question 1', 'required');
	$this->form_validation->set_rules('ques_2', 'Question 2', 'required');
	$this->form_validation->set_rules('ques_3', 'Question 3', 'required');
	$this->form_validation->set_rules('ques_4', 'Question 4', 'required');
	$this->form_validation->set_rules('ques_5', 'Question 5', 'required');
	$this->form_validation->set_rules('message', 'Message', 'required');
	$this->form_validation->set_rules('anonymous', 'Anonymous', 'required');

	if ($this->form_validation->run() == TRUE){
		$dataArr=array();	
		$rated_by_user=$this->input->post('rated_by_user');
		$rated_to_user=$this->input->post('rated_to_user');
		$ques_1=$this->input->post('ques_1');
		$ques_2=$this->input->post('ques_2');
		$ques_3=$this->input->post('ques_3');
		$ques_4=$this->input->post('ques_4');
		$ques_5=$this->input->post('ques_5');
		$message=$this->input->post('message');
		$anonymous=$this->input->post('anonymous');
		$workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$rated_to_user,'status'=>1),'id','DESC','all',1);
		if(!empty($workingAt['result'])){
			$compId=$workingAt['result'][0]->receiver;
		}else{
			$compId=0;
		}

		$avg_rating1=($ques_1+$ques_2+$ques_3+$ques_4+$ques_5)/5;
		$avg_rating=round($avg_rating1, 1);
		$rate_date=date('Y-m-d H:i:s');

		$dataArr['company_id']=$compId;
		$dataArr['rated_by_user']=$rated_by_user;
		$dataArr['rated_to_user']=$rated_to_user;
		$dataArr['ques_1']=$ques_1;
		$dataArr['ques_2']=$ques_2;
		$dataArr['ques_3']=$ques_3;
		$dataArr['ques_4']=$ques_4;
		$dataArr['ques_5']=$ques_5;
		$dataArr['avg_rating']=$avg_rating;
		$dataArr['message']=$message;
		$dataArr['rate_date']=$rate_date;
		$dataArr['anonymous']=$anonymous;

		$insrt= $this->common_model->insertData('ratings',$dataArr);
		if($insrt){

			$senderDetails = $this->common_model->getsingle(USERS,array('id'=>$rated_by_user));
			$senderName = $senderDetails->firstname.' '.$senderDetails->lastname;
			if(!empty($senderDetails->business_name)){
				$senderName = $senderDetails->business_name;
			}
			/* To send push notifications */
			$notification_message = " sent you a review.";
			$this->sendNotifications($rated_by_user,$rated_to_user,'posted_review',$notification_message);

			$resp=array("result"=>1,'msg'=>'Rating Successfully Submitted. ','data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
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
/***************************/
/********UPDATE-PROFILE-******/
/***************************/
public function updateprofile_post(){
	$this->form_validation->set_rules('user_id', 'User id', 'required');
	$this->form_validation->set_rules('name', 'Name', 'required');
	$this->form_validation->set_rules('email', 'Email', 'required');
	$this->form_validation->set_rules('zip', 'Zipcode', 'required');
	$this->form_validation->set_rules('city', 'City', 'required');
	$this->form_validation->set_rules('state', 'State', 'required');
	$this->form_validation->set_rules('country', 'Country', 'required');
	$this->form_validation->set_rules('phone', 'Phone', 'required');
	$this->form_validation->set_rules('website', 'Website', 'required');
	$this->form_validation->set_rules('category', 'Category', 'required');
	$this->form_validation->set_rules('current_position', 'Current position', 'required');
	$this->form_validation->set_rules('proffesional_skills', 'Proffesional skills', 'required');
	$this->form_validation->set_rules('additional_services', 'Additional services', 'required');
	//$this->form_validation->set_rules('password', 'Password', 'required');
	if ($this->form_validation->run() == TRUE){
		$dataArr=array();	
		$rate_date=date('Y-m-d H:i:s');
		$user_id=$this->input->post('user_id');
		$password=$this->input->post('password');
		$dataArr['firstname']=$this->input->post('name');
		$dataArr['email']=$this->input->post('email');
		$dataArr['zip']=$this->input->post('zip');
		$dataArr['city']=$this->input->post('city');
		$dataArr['state']=$this->input->post('state');
		$dataArr['country']=$this->input->post('country');
		$dataArr['phone']=$this->input->post('phone');
		$dataArr['website_link']=$this->input->post('website');
		$dataArr['user_category']=$this->input->post('category');
		$dataArr['current_position']=$this->input->post('current_position');
		$dataArr['professional_skill']=$this->input->post('proffesional_skills');
		$dataArr['additional_services']=$this->input->post('additional_services');
		if(!empty($password)){
		$dataArr['password']=generate_password($this->input->post('password'));
		}
		$result=$this->common_model->updateFields(USERS,$dataArr,array('id'=>$user_id));
		if($result){
			$resp=array("result"=>1,'msg'=>'Profile Successfully Updated. ','data'=>$result);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********UPDATE-PROFILE-2******/
/***************************/
public function updateprofile2_post(){
	$this->form_validation->set_rules('user_id', 'User id', 'required');
	if ($this->form_validation->run() == TRUE){
		$dataArr=array();	
		$rate_date=date('Y-m-d H:i:s');
		$user_id=$this->input->post('user_id');
		if($this->input->post('firstname')){
			$dataArr['firstname']=$this->input->post('firstname');
		}
		if($this->input->post('lastname')){
			$dataArr['lastname']=$this->input->post('lastname');
		}
		if(!empty($this->input->post('email'))){
			$dataArr['email']=$this->input->post('email');
		}
		if(!empty($this->input->post('zip'))){
			$dataArr['zip']=$this->input->post('zip');
		}
		if(!empty($this->input->post('city'))){
			$dataArr['city']=$this->input->post('city');
		}
		if(!empty($this->input->post('state'))){
			$dataArr['state']=$this->input->post('state');
		}
		if(!empty($this->input->post('country'))){
			$dataArr['country']=$this->input->post('country');
		}
		if(!empty($this->input->post('phone'))){
			$dataArr['phone']=$this->input->post('phone');
		}
		if(!empty($this->input->post('website'))){
			$dataArr['website_link']=$this->input->post('website');
		}
		if(!empty($this->input->post('category'))){
			$dataArr['user_category']=$this->input->post('category');
		}
		if(!empty($this->input->post('current_position'))){
			$dataArr['current_position']=$this->input->post('current_position');
		}
		if(!empty($this->input->post('proffesional_skills'))){
			$pro_skills=$this->input->post('proffesional_skills');
			$dataArr['professional_skill']=$pro_skills;
		}
		if(!empty($this->input->post('additional_services'))){
			$add_skills=$this->input->post('additional_services');
			$dataArr['additional_services']=$add_skills;
		}
		if(!empty($this->input->post('password'))){
			$dataArr['password']=generate_password($this->input->post('password'));
		}

		if($this->input->post('message_notification')){
			$dataArr['message_notification']=$this->input->post('message_notification');
		}
		if($this->input->post('job_request_received_notification')){
			$dataArr['job_request_received_notification']=$this->input->post('job_request_received_notification');
		}
		if($this->input->post('friend_request_received_notification')){
			$dataArr['friend_request_received_notification']=$this->input->post('friend_request_received_notification');
		}
		
		if($this->input->post('friend_request_acceptance_notification')){
			$dataArr['friend_request_acceptance_notification']=$this->input->post('friend_request_acceptance_notification');
		}
		if($this->input->post('job_request_acceptance_notification')){
			$dataArr['job_request_acceptance_notification']=$this->input->post('job_request_acceptance_notification');
		}
		if($this->input->post('review_notification')){
			$dataArr['review_notification']=$this->input->post('review_notification');
		}
		if($this->input->post('new_task_notification')){
			$dataArr['new_task_notification']=$this->input->post('new_task_notification');
		}
		if($this->input->post('new_comments')){
			$dataArr['new_comments']=$this->input->post('new_comments');
		}
		$resultss=0;
		
		if(!empty($dataArr)){
		$this->common_model->updateFields(USERS,$dataArr,array('id'=>$user_id));
		}
		$resp=array("result"=>1,'msg'=>'Profile Successfully Updated. ','data'=>$resultss);
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Get-community-posts******/
/***************************/
public function community_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$start=$this->input->post('start_from');
		$end=$this->input->post('limit');
		if($start==""){
			$start=0;	
		}
		if($end==""){
			$end=5;	
		}
		$contactIDs = array();
		$info = 'tb_users.id';
		$relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
		$condition2="(requests.receiver='$user_id' OR requests.sender='$user_id') AND requests.status=1";
		$companyContacts = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,"");
		if(!empty($companyContacts)){
			foreach($companyContacts as $id){
				if($user_id!=$id['id']){
					$contactIDs[] = $id['id'];
				}
			}
		}
		$relation="tb_users.id=friends.user_one_id OR tb_users.id=friends.user_two_id"; 
		$condition="(friends.user_two_id='$user_id' OR friends.user_one_id='$user_id') AND friends.status=1";
		$friendContacts = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,"");
		if(!empty($friendContacts)){
			foreach($friendContacts as $id){
				if($user_id!=$id['id']){
					$contactIDs[] = $id['id'];
				}
			}
		}
//$data['highlights']=array();
$highlights=array();
$comhighlights=array();
		if(!empty($contactIDs)){
			$contacts = implode(",",$contactIDs);
			$condition = ' user_id IN('.$contacts.')';
		$allcommunitypost= $this->common_model->GetJoinRecord(USERS,'id',POSTS,'user_id','tb_users.firstname,tb_users.lastname,tb_users.business_name,tb_users.user_role,tb_users.profile,tb_users.id as user_id1,posts.*',$condition,'','posts.id','DESC',$end,$start);
		 if(!empty($allcommunitypost['result'])){ foreach($allcommunitypost['result'] as $compost){
			$highlights['firstname']=$compost->firstname;
			$highlights['lastname']=$compost->lastname;
			$highlights['business_name']=$compost->business_name;
			$highlights['user_role']=$compost->user_role;
			$highlights['profile']=$compost->profile;
			$highlights['user_id']=$compost->user_id;
			$highlights['id']=$compost->id;
			$highlights['post_title']=$compost->post_title;
			$highlights['post_content']=$compost->post_content;
			$highlights['post_image']=$compost->post_image;
			$highlights['post_video']=$compost->post_video;
			$highlights['post_date']=$compost->post_date;
			$highlights['post_status']=$compost->post_status;
			$highlights['company']=$compost->company;
			$highlights['repeat_status']=$compost->repeat_status;
			$highlights['user_repeat_ids']=$compost->user_repeat_ids;
			
			$commentData = $this->common_model->GetJoinRecord(COMMENTS,'user_id',USERS,'id','comments.*,tb_users.firstname,tb_users.lastname,tb_users.profile',array('comments.post_id'=>$compost->id));
			$postlikes = $this->common_model->getAllwhere(LIKE,array('post_id'=>$compost->id,'status'=>1));
			$likeData = $this->common_model->getsingle(LIKE,array('liked_by'=>$user_id,'post_id'=>$compost->id));
			if(!empty($likeData) && $likeData->status==1){
					$highlights['status']=1;
				}else{
					$highlights['status']=0;	
				}
            $highlights['likes']=$postlikes['total_count'];
			$highlights['comments']=$commentData['total_count'];
				
			$comhighlights[]=$highlights;	
		 }
		 }
		 $data['highlights']=$comhighlights;
		}
//lq();
//QR code generate
		$data['img_url']="";
		$this->load->library('ciqrcode');
		$qr_image=rand().'.png';
		$params['data'] = base_url().'viewdetails/profile/'.encoding($user_id)."?review=1";
		$params['level'] = 'H';
		$params['size'] = 5;
		$params['savename'] =FCPATH."qr_code/".$qr_image;
		if($this->ciqrcode->generate($params))

		{
			$data['qr_image']=base_url().'qr_code/'.$qr_image; 
		}


		$resp=array("result"=>1,'msg'=>'Community Data ','community'=>$data);
		$this->response($resp, REST_Controller::HTTP_OK);


	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********-My-Task-******/
/***************************/
public function mytask_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');

		$data = $this->common_model->GetJoinRecord(TASK,'id',TASK_ASSIGNED,'task_id','task.*,task_assigned.note,task_assigned.status',array('task_assigned.user_id'=>$user_id),'','created_date','DESC');

		$taskCount = $data['total_count'];
		$resp=array("result"=>1,'msg'=>'My task data ','mytask'=>$data);
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}

/***************************/
/********-Pri-TASK-ASSIGNED-BY-Me******/
/***************************/
public function taskassignedbyme_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$data = $this->common_model->getAllwhere(TASK,array('assigned_by'=>$user_id));
		$taskCount = $data['total_count'];
		$resp=array("result"=>1,'msg'=>'My task data ','mytask'=>$data);
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}


/***************************/
/********-Pri-TASK-ASSIGNED-BY-Me-Details******/
/***************************/
public function taskassignedbymedetails_post(){
	$this->form_validation->set_rules('task_id', 'Task Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$taskID=$this->input->post('task_id');
		$data = $this->common_model->GetJoinRecord(TASK_ASSIGNED,'user_id',USERS,'id','task_assigned.*,tb_users.firstname,tb_users.lastname',array('task_assigned.task_id'=>$taskID));
		$taskDetails = $this->common_model->getsingle(TASK,array('id'=>$taskID));
		$taskCount = $data['total_count'];
		$resp=array("result"=>1,'msg'=>'My task data ','mytask'=>$data,'taskDetails'=>$taskDetails);
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}

/***************************/
/********-Pri-TASK-DELETE-******/
/***************************/
public function taskdelete_post(){
	$this->form_validation->set_rules('task_id', 'Task Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$taskID=$this->input->post('task_id');
		$taskData=$this->common_model->getsingle(TASK,array('id'=>$taskID));
		if(!empty($taskData)){
			if($this->common_model->deleteData(TASK,array('id'=>$taskID))){
				$resp=array("result"=>1,'msg'=>'Task Deleted Successfully.','data'=>array());
			}
		}else{
			$resp=array("result"=>0,'msg'=>'No such task exist.','data'=>array());
		}
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}

/***************************/
/********-Rank-******/
/***************************/
public function rank_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$limit=$this->input->post('limit');
		$offset=$this->input->post('offset');
		$userInfo = $this->common_model->getsingle(USERS,array('id'=>$user_id));
		$category = $userInfo->user_category;
		$data['userRankRatings'] = $this->common_model->get_two_table_data('tb_users.*,count(ratings.id) as review_count',USERS,RATINGS,'tb_users.id = ratings.rated_to_user',array('tb_users.user_category'=>$category,'user_role!='=>'Employer'),'rated_to_user','review_count',"DESC",$limit,$offset);

		$myrank=array('star_rating'=>0,'rank'=>0);
		if(!empty($data['userRankRatings'])){
			$count = 0;
			foreach($data['userRankRatings'] as $key=>$rating){
				$count++;
				$ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$rating['id']));
				if(!empty($ratingDetails['result'])){
					$ratingAverage=0;
					$reviewCount  = $rating['review_count'];
					foreach($ratingDetails['result'] as $row){
						$average = 0;
						$total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
						if($total>0){
							$average = $total/5;
						}
						$ratingAverage+=$average;
					}
					if($ratingAverage>0)
						$ratingAverage = $ratingAverage/$reviewCount;
					else
						$ratingAverage = 0;
//$starRating = starRating($ratingAverage,$rating['review_count']);
					$ratingData =  userOverallRatings($rating['id']);
					$starRating=0;
					if(isset($ratingData['ratingAverage'])){ $starRating= $ratingData['ratingAverage']; }
//$userdtl['ratings']=$starRating;
				}
				else{
					$ratingAverage = 0;
// $starRating = starRating($ratingAverage,0);
					$ratingData =  userOverallRatings($rating['id']);		   
					$starRating=0;
					if(isset($ratingData['ratingAverage'])){ $starRating= $ratingData['ratingAverage']; }
//$userdtl['ratings']=$starRating;
				}
				$data['userRankRatings'][$key]['star_rating'] = $starRating;
				$data['userRankRatings'][$key]['rank'] = $count;
				if($rating['id']==$user_id){
					$myrank=array('star_rating'=>$starRating,'rank'=>$count);	
				}
			}
		}
//pr($data);

		$resp=array("result"=>1,'msg'=>'Rank ','rank'=>$data,'your_rank'=>$myrank);
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Post-Comments******/
/***************************/
public function postcomment_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('comments', 'Comment Id', 'required');
	$this->form_validation->set_rules('post_id', 'Post Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$comments=$this->input->post('comments');
		$post_id=$this->input->post('post_id');
		$dataInsert['user_id'] = $user_id;
		$dataInsert['comments'] = $comments;
		$dataInsert['post_id'] = $post_id;
		$commentID = $this->common_model->insertData(COMMENTS,$dataInsert);
		$commentData = $this->common_model->GetJoinRecord(COMMENTS,'user_id',USERS,'id','comments.*,tb_users.firstname,tb_users.lastname,tb_users.profile',array('comments.id'=>$commentID));
		$comment = isset($commentData['result'][0]) ? $commentData['result'][0]:'';

		$postData = $this->common_model->getsingle(POSTS,array('id'=>$post_id));
		$postOwner = $postData->user_id;
		/* To send push notifications */
		$notification_message = " commented on your post.";
		$this->sendNotifications($user_id,$postOwner,'post_comment',$notification_message);
		if($commentID){
			$resp=array("result"=>1,'msg'=>'Comment Posted.','comment data'=>$comment);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'rating'=>$comment);
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Search******/
/***************************/
public function search_post(){
//$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('searchTags', 'Search Tags', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$tags=$this->input->post('searchTags');
		$locality=$this->input->post('city');
		$state=$this->input->post('state');
		$country=$this->input->post('country');
		$city=$locality;
		$postal_code=$this->input->post('postal_code');
		$sql = '';
		if($user_id==""){
			$user_id=0;
		}
		$ntg=explode(' ',$tags);
		$fname="";
		$lname="";
		if(count($ntg)>1){
			$fname=$ntg[0];
			$lname=$ntg[1];
		}else if(count($ntg) == 1){
			$fname=$tags;
		}

		$catIds=array();
		$categ=$this->common_model->getAllwhere(CATEGORY,"name LIKE '%$tags%' AND category_status='1'");
		if(!empty($categ['result'])){
			foreach($categ['result'] as $catg){
				$catIds[]=$catg->id;
			}
		}
		$categQuery="";
		if(!empty($catIds)){
			$categoryids=implode(',',$catIds);
			$categQuery=" AND (user_category IN(".$categoryids.") and user_category!=1)";
		}

		$sql.='1=1 AND active=1 AND status="verify"';
		if($locality!=''){
			$sql.= "  AND (city LIKE '%$locality%' OR country LIKE '%$locality%' OR state LIKE '%$locality%' OR zip LIKE '%$locality%')";
		}
		else if($state!=''){
			$sql.= " AND (city LIKE '%$state%' OR country LIKE '%$state%' OR state LIKE '%$state%' OR zip LIKE '%$state%')";
		}
		else if($country!=''){
			$sql.= " AND (city LIKE '%$country%' OR country LIKE '%$country%' OR state LIKE '%$country%' OR zip LIKE '%$country%')";
		}
		else if($postal_code!=''){
			$sql.= " AND (city LIKE '%$postal_code%' OR country LIKE '%$postal_code%' OR state LIKE '%$postal_code%' OR zip LIKE '%$postal_code%')";
		}
		else if($locality=='' &&  $state=='' && $country=='' && $postal_code=='' && $city!=''){
			$sql.= " AND (city LIKE '%$city%' OR country LIKE '%$city%' OR state LIKE '%$city%' OR zip LIKE '%$city%')";
		}
		$fqry="";
		if($fname!="" && $lname!="" ){
			$fqry="OR (firstname like '$fname%' AND lastname like '$lname%')";	
		}
		if($fname!="" && $lname==""){
			$fqry="OR (firstname like '$fname%')";	
		}

		$ntags=str_replace(' ','',$tags);
		$data = $this->common_model->getAllwhere(USERS,$sql." AND (FIND_IN_SET('$tags',professional_skill) OR FIND_IN_SET('$ntags',REPLACE(professional_skill,' ','')) OR FIND_IN_SET('$tags',additional_services) OR FIND_IN_SET('$ntags',REPLACE(additional_services,' ','')) ".$fqry." OR firstname LIKE '%$tags%' OR lastname LIKE '%$tags%' OR business_name LIKE '%$tags%' OR current_position like '%$tags%'  ".$categQuery." and tb_users.id!='$user_id' )", 'id', 'DESC','all','','','','');

		if($data['total_count']==0){
			$result=array('data'=>array(),'tags'=>$tags,'state'=>$state,'country'=>$country,'city'=>$city);
			$resp=array("result"=>2,'msg'=>'No user found.','data'=>$result);
		}else{
			$userlist=array();
			if(!empty($data['result'])){
				foreach($data['result'] as $usr){
					$nuserid=$usr->id;
					$userdtl['id']=$usr->id;
					$userdtl['type']=$usr->type;
					$userdtl['firstname']=$usr->firstname;
					$userdtl['lastname']=$usr->lastname;
					$userdtl['device_id']=$usr->device_id;
					$userdtl['email']=$usr->email;
					$userdtl['profile']=$usr->profile;
					$userdtl['gender']=$usr->gender;
					$userdtl['user_role']=$usr->user_role;
					$userdtl['user_category']=$usr->user_category;
					$userdtl['zip']=$usr->zip;
					$userdtl['city']=$usr->city;
					$userdtl['state']=$usr->state;
					$userdtl['country']=$usr->country;
					$userdtl['current_position']=$usr->current_position;
					$userdtl['basic_info']=$usr->basic_info;

					$info=array('tb_users.profile','tb_users.business_address','tb_users.city','tb_users.state','tb_users.country','tb_users.business_name','requests.job_requested_by','tb_users.user_role');
					$relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
					$condition2="(requests.receiver='$nuserid' OR requests.sender='$nuserid') AND requests.status=1 AND tb_users.id!='$nuserid' ";
					$user_workingAt1 = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");
// if(!empty($user_workingAt1)){
// 	$userdtl['working_at']=$user_workingAt1[0]['business_name'];
// 	$userdtl['business_name']=$user_workingAt1[0]['business_name'];
// 	$userdtl['business_address']=$user_workingAt1[0]['business_address'];
// }else{
// 	$userdtl['working_at']='';
// 	$userdtl['business_name']='';
// 	$userdtl['business_address']='';
// }
				$currentUserData = $this->common_model->getsingle(USERS,array('id'=>$user_id));
				$status1 = '';
				if(!empty($currentUserData)){
					$userRole = $currentUserData->user_role;

					if($usr->user_role=='Employer'){ 
						if($userRole == 'Employer'){ 
						}
						else{  
							if($user_id){
								$userOne = $user_id;
								$userTwo = $usr->id;
								$isRequest = checkRequest($userOne,$userTwo);
								$requestedByUser = jobRequestedBy($userOne,$usr->id);
								if($requestedByUser != $userOne && $requestedByUser!=0 && $isRequest!='Accepted'){
									$isRequest = 'NotConfirm';
								}
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}
							else if($isRequest=='NotConfirm'){ 
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($senderID,$usr->id);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 
									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								}
							}
							else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}
							else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}
					}
					else{
						if($userRole == 'Employer'){ 
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isRequest=checkRequest($userOne,$userTwo);
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}else if($isRequest=='NotConfirm'){
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($usr->id,$senderID);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 

									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								} 

							} else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}else{
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isFriend=checkFriend($userOne,$userTwo);
							}else{
								$isFriend="No"; 
							}

							if($isFriend=='No'){ 
								$status1 = 'Add Friend';
							}
							else if($isFriend=='NotConfirm'){ 
								$status1 = 'Confirm';
							}else if($isFriend=='Pending'){
								$status1 = 'Pending';
							}else if($isFriend=='Accepted'){
								$status1 = 'Accepted';
							} 
						}
					}
				}
				$userdtl['req_status'] = $status1;

					if(!empty($user_workingAt1) && ($usr->user_role == 'Performer')){
						$userdtl['working_at']=$user_workingAt1[0]['business_name'];
						$userdtl['business_name']=$user_workingAt1[0]['business_name'];
						$userdtl['business_address']=$user_workingAt1[0]['business_address'];
					}else{
						$userdtl['working_at']='';
						$userdtl['business_name']=$usr->business_name;
						$userdtl['business_address']='';
					}
					$ratingData =  userOverallRatings($usr->id);
					$starRating=0;
					if(isset($ratingData['ratingAverage'])){ $starRating= $ratingData['ratingAverage']; }
					$userdtl['ratings']=$starRating;
					$favourite=0;
					if($user_id!=0){
						$dataArr=array('added_by'=>$user_id,'added_to'=>$nuserid);
						$alreadyFavourite = $this->common_model->getsingle(FAVOURITES,$dataArr);
						if(!empty($alreadyFavourite)){
							$favourite=1;	
						}
					}
					$userdtl['favourite']=$favourite;
					$userlist[]=$userdtl;
				}
			}

			$result=array('data'=>$userlist,'tags'=>$tags,'state'=>$state,'country'=>$country,'city'=>$city);

			$resp=array("result"=>1,'msg'=>'Search List.','data'=>$result);
		}



		if($data){
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/******Add-TO-Favourite-****/
/***************************/
public function addtofavourites_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('other_userid', 'Other User Id', 'required');
	$this->form_validation->set_rules('status', 'Status', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$other_userid=$this->input->post('other_userid');
		$status=$this->input->post('status');
		$dataInsert['added_by'] = $user_id;
		$dataInsert['added_to'] = $other_userid;
		$dataInsert['added_date'] = date('Y-m-d H:i:s');

		$dataArr=array('added_by'=>$user_id,'added_to'=>$other_userid);

		if($status==1){
			$alreadyFavourite = $this->common_model->getsingle(FAVOURITES,$dataArr);
			if(!empty($alreadyFavourite)){
				$resp=array("result"=>3,'msg'=>'Already favourite.','data'=>array());
				$this->response($resp, REST_Controller::HTTP_OK);
			}else{
				$insertedId = $this->common_model->insertData(FAVOURITES,$dataInsert);	
				$resp=array("result"=>1,'msg'=>'Added To favourites.','data'=>array());
				$this->response($resp, REST_Controller::HTTP_OK);	
			}

		}else{
			$this->common_model->deleteData(FAVOURITES,$dataArr);
			$resp=array("result"=>2,'msg'=>'Removed from favourites.','data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********All-Favourite-******/
/***************************/
public function favourites_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$favourites=$this->common_model->GetJoinRecord(FAVOURITES,'added_to',USERS,'id','tb_users.id as user_id,tb_users.*',array('added_by'=>$user_id));
		$data=array();
		$userdtl=array();
		$userlist=array();
		$data['total_count']=$favourites['total_count'];

		if(!empty($favourites['result'])){
			foreach($favourites['result'] as $usr){
				$nuserid=$usr->id;
				$userdtl['id']=$usr->id;
				$userdtl['type']=$usr->type;
				$userdtl['firstname']=$usr->firstname;
				$userdtl['lastname']=$usr->lastname;
				$userdtl['device_id']=$usr->device_id;
				$userdtl['email']=$usr->email;
				$userdtl['profile']=$usr->profile;
				$userdtl['gender']=$usr->gender;
				$userdtl['user_role']=$usr->user_role;
				$userdtl['user_category']=$usr->user_category;
				$userdtl['zip']=$usr->zip;
				$userdtl['city']=$usr->city;
				$userdtl['state']=$usr->state;
				$userdtl['country']=$usr->country;
				$userdtl['current_position']=$usr->current_position;
				$userdtl['working_at']=$usr->working_at;
				$userdtl['basic_info']=$usr->basic_info;
				$info=array('tb_users.profile','tb_users.business_address','tb_users.city','tb_users.state','tb_users.country','tb_users.business_name','requests.job_requested_by','tb_users.user_role');
				$relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
				$condition2="(requests.receiver='$nuserid' OR requests.sender='$nuserid') AND requests.status=1 AND tb_users.id!='$nuserid' ";
				$user_workingAt1 = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");
// if(!empty($user_workingAt1)){
// 	$userdtl['working_at']=$user_workingAt1[0]['business_name'];
// 	$userdtl['business_name']=$user_workingAt1[0]['business_name'];
// 	$userdtl['business_address']=$user_workingAt1[0]['business_address'];
// }else{
// 	$userdtl['working_at']='';
// 	$userdtl['business_name']='';
// 	$userdtl['business_address']='';
// }
				$currentUserData = $this->common_model->getsingle(USERS,array('id'=>$user_id));
				$status1 = '';
				if(!empty($currentUserData)){
					$userRole = $currentUserData->user_role;

					if($usr->user_role=='Employer'){ 
						if($userRole == 'Employer'){ 
						}
						else{  
							if($user_id){
								$userOne = $user_id;
								$userTwo = $usr->id;
								$isRequest = checkRequest($userOne,$userTwo);
								$requestedByUser = jobRequestedBy($userOne,$usr->id);
								if($requestedByUser != $userOne && $requestedByUser!=0 && $isRequest!='Accepted'){
									$isRequest = 'NotConfirm';
								}
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}
							else if($isRequest=='NotConfirm'){ 
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($senderID,$usr->id);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 
									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								}
							}
							else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}
							else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}
					}
					else{
						if($userRole == 'Employer'){ 
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isRequest=checkRequest($userOne,$userTwo);
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}else if($isRequest=='NotConfirm'){
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($usr->id,$senderID);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 

									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								} 

							} else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}else{
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isFriend=checkFriend($userOne,$userTwo);
							}else{
								$isFriend="No"; 
							}

							if($isFriend=='No'){ 
								$status1 = 'Add Friend';
							}
							else if($isFriend=='NotConfirm'){ 
								$status1 = 'Confirm';
							}else if($isFriend=='Pending'){
								$status1 = 'Pending';
							}else if($isFriend=='Accepted'){
								$status1 = 'Accepted';
							} 
						}
					}
				}
				$userdtl['req_status'] = $status1;

				if(!empty($user_workingAt1) && ($usr->user_role == 'Performer')){
					$userdtl['working_at']=$user_workingAt1[0]['business_name'];
					$userdtl['business_name']=$user_workingAt1[0]['business_name'];
					$userdtl['business_address']=$user_workingAt1[0]['business_address'];
				}else{
					$userdtl['working_at']='';
					$userdtl['business_name']=$usr->business_name;
					$userdtl['business_address']='';
				}
				$ratingData =  userOverallRatings($usr->id);
				$starRating=0;
				if(isset($ratingData['ratingAverage'])){ $starRating= $ratingData['ratingAverage']; }
				$userdtl['ratings']=$starRating;
				$favourite=0;
				if($user_id!=0){
					$dataArr=array('added_by'=>$user_id,'added_to'=>$nuserid);
					$alreadyFavourite = $this->common_model->getsingle(FAVOURITES,$dataArr);
					if(!empty($alreadyFavourite)){
						$favourite=1;	
					}
				}
				$userdtl['favourite']=$favourite;
				$userlist[]=$userdtl;
			}
		}

		$data['result']=$userlist;
		$resp=array("result"=>1,'msg'=>'All favourites.','data'=>$data);
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********All-Rank-******/
/***************************/
public function ranks_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$userInfo = $this->common_model->getsingle(USERS,array('id'=>$user_id));
		$category = $userInfo->user_category;
		$data=array();
		$userRankRatings = $this->common_model->get_two_table_data('tb_users.*,count(ratings.id) as review_count',USERS,RATINGS,'tb_users.id = ratings.rated_to_user',array('tb_users.user_category'=>$category,'user_role!='=>'Employer'),'rated_to_user','review_count',"DESC");
		$data['userRankRatings']=$userRankRatings;
		if(!empty($userRankRatings)){
			$count = 0;
			foreach($userRankRatings as $key=>$rating){
				$count++;
				$ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$rating['id']));
				if(!empty($ratingDetails['result'])){
					$ratingAverage=0;
					$reviewCount  = $rating['review_count'];
					foreach($ratingDetails['result'] as $row){
						$average = 0;
						$total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
						if($total>0){
							$average = $total/5;
						}
						$ratingAverage+=$average;
					}
					if($ratingAverage>0)
						$ratingAverage = $ratingAverage/$reviewCount;
					else
						$ratingAverage = 0;
					$ratingData =  userOverallRatings($rating['id']);		   
					$starRating=0;
					if(isset($ratingData['ratingAverage'])){ $starRating= $ratingData['ratingAverage']; }
//$userdtl['ratings']=$starRating;
//$starRating = starRating($ratingAverage,$rating['review_count']);
				}
				else{
					$ratingAverage = 0;
					$starRating=0;
					if(isset($ratingData['ratingAverage'])){ $starRating= $ratingData['ratingAverage']; }
				}

				$data['userRankRatings'][$key]['star_rating'] = $starRating;
				$data['userRankRatings'][$key]['rank'] = $count;
			}
		}

		$resp=array("result"=>1,'msg'=>'All favourites.','data'=>$data);
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********All-Favourite-******/
/***************************/
public function reportprofile_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('other_userid', 'Other User Id', 'required');
	$this->form_validation->set_rules('other_user_name', 'Other User Name', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$other_userid=$this->input->post('other_userid');
		$other_user_name=$this->input->post('other_user_name');
		$userInfo = $this->common_model->getsingle(USERS,array('id'=>$user_id));
		$uemail = $userInfo->email;
		$reportingBy = $userInfo->firstname.' '.$userInfo->lastname;
		$adminData = $this->common_model->getsingle(ADMIN,array('id'=>1));
		if(!empty($adminData)){
			$email = $adminData->mail_to;
//$email ="priyanka.pixlrit@gmail.com";
			$from = "reportprofile@workadvisor.co";    
			$subject = 'Report Profile';  
			$message = '';
			$message .= 'User <a href="'.base_url().'viewdetails/profile/'.encoding($user_id).'">'.ucfirst($reportingBy).'</a> has reported the profile of <a href="'.base_url().'viewdetails/profile/'.encoding($other_userid).'">'.$other_user_name.'</a>.';
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
			if($this->email->send()){
				$resp=array("result"=>1,'msg'=>'User Profile Reported.','data'=>array());
				$this->response($resp, REST_Controller::HTTP_OK);
			}
		}else{
			$resp=array("result"=>0,'msg'=>'something went wrong','data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********SEARCH-BY-CATEGORY******/
/***************************/
public function searchbycategory_post(){
	$this->form_validation->set_rules('category_id', 'Category Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$category_id=$this->input->post('category_id');
		$user_id=$this->input->post('user_id');
		$data=array();
		$userlist=array();
		if($category_id==0){
			$category_id="";
		}
		$usersDetails = $this->common_model->getAllwhere(USERS,array('user_category'=>$category_id));
		$data['total_count']=$usersDetails['total_count'];

		if(!empty($usersDetails['result'])){
			foreach($usersDetails['result'] as $usr){
				$nuserid=$usr->id;
				$userdtl['id']=$usr->id;
				$userdtl['type']=$usr->type;
				$userdtl['firstname']=$usr->firstname;
				$userdtl['lastname']=$usr->lastname;
				$userdtl['device_id']=$usr->device_id;
				$userdtl['email']=$usr->email;
				$userdtl['profile']=$usr->profile;
				$userdtl['gender']=$usr->gender;
				$userdtl['user_role']=$usr->user_role;
				$userdtl['user_category']=$usr->user_category;
				$userdtl['zip']=$usr->zip;
				$userdtl['city']=$usr->city;
				$userdtl['state']=$usr->state;
				$userdtl['country']=$usr->country;
				$userdtl['current_position']=$usr->current_position;
				$userdtl['working_at']=$usr->working_at;
				$userdtl['basic_info']=$usr->basic_info;
				$info=array('tb_users.profile','tb_users.business_address','tb_users.city','tb_users.state','tb_users.country','tb_users.business_name','requests.job_requested_by','tb_users.user_role');
				$relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
				$condition2="(requests.receiver='$nuserid' OR requests.sender='$nuserid') AND requests.status=1 AND tb_users.id!='$nuserid' ";
				$user_workingAt1 = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");

				if(!empty($user_workingAt1) && ($usr->user_role == 'Performer')){
					$userdtl['working_at']=$user_workingAt1[0]['business_name'];
					$userdtl['business_name']=$user_workingAt1[0]['business_name'];
					$userdtl['business_address']=$user_workingAt1[0]['business_address'];
				}else{
					$userdtl['working_at']='';
					$userdtl['business_name']=$usr->business_name;
					$userdtl['business_address']='';
				}
				$ratingData =  userOverallRatings($usr->id);
				$starRating=0;
				if(isset($ratingData['ratingAverage'])){ $starRating= $ratingData['ratingAverage']; }
				$userdtl['ratings']=$starRating;
				

				$currentUserData = $this->common_model->getsingle(USERS,array('id'=>$user_id));
				$status1 = '';
				if(!empty($currentUserData)){
					$userRole = $currentUserData->user_role;

					if($usr->user_role=='Employer'){ 
						if($userRole == 'Employer'){ 
						}
						else{  
							if($user_id){
								$userOne = $user_id;
								$userTwo = $usr->id;
								$isRequest = checkRequest($userOne,$userTwo);
								$requestedByUser = jobRequestedBy($userOne,$usr->id);
								if($requestedByUser != $userOne && $requestedByUser!=0 && $isRequest!='Accepted'){
									$isRequest = 'NotConfirm';
								}
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}
							else if($isRequest=='NotConfirm'){ 
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($senderID,$usr->id);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 
									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								}
							}
							else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}
							else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}
					}
					else{
						if($userRole == 'Employer'){ 
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isRequest=checkRequest($userOne,$userTwo);
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}else if($isRequest=='NotConfirm'){
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($usr->id,$senderID);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 

									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								} 

							} else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}else{
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isFriend=checkFriend($userOne,$userTwo);
							}else{
								$isFriend="No"; 
							}

							if($isFriend=='No'){ 
								$status1 = 'Add Friend';
							}
							else if($isFriend=='NotConfirm'){ 
								$status1 = 'Confirm';
							}else if($isFriend=='Pending'){
								$status1 = 'Pending';
							}else if($isFriend=='Accepted'){
								$status1 = 'Accepted';
							} 
						}
					}
				}
				$userdtl['req_status'] = $status1;
				$userlist[]=$userdtl;
			}//foreach end
		}

		$data['result']=$userlist;

		if($data){
			$resp=array("result"=>1,'data'=>$data,'msg'=>'User Data');	
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Filter-******/
/***************************/
public function filter_post(){
	$this->form_validation->set_rules('keyword', 'Keyword', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$rating=$this->input->post('rating');
		$reviews=$this->input->post('reviews');
		$profile_type=$this->input->post('profile_type');
		$category=$this->input->post('category');
		$keyword=$this->input->post('keyword');

		$ratings=explode(",",$rating);
		$ratings=array_filter($ratings);
		$rating=implode(",",$ratings);

		$categories=explode(",",$category);
		$categories=array_filter($categories);
		$category=implode(",",$categories);


		if($user_id==""){
			$user_id=0;
		}
		$data=array();
		$catIds=array();
		$catCount = 0;
		$extqury="(1=1)";
		$categQuery="";
		if($category!=""){
			$catCount++;
			$categQuery=" AND (user_category IN(".$category.") and user_category!=1)";
		}


		$profile='';
		if($profile_type!=""){
			if($profile_type == 1){
				$profile = 'AND user_role = "Employer"';
			}else{
				$profile = 'AND user_role = "Performer"';
			}
		}
		$fqry="";
		$keywordquery="";

		if(!empty($keyword)){
			$tags=$keyword;
			$tagArr=explode(' ',$tags);
			$fname="";
			$lname="";
			if(count($tagArr)>1){
				$fname=$tagArr[0];
				$lname=$tagArr[1];
			}
			if(count($tagArr) == 1){
				$fname=$tagArr[0];
			}
			if($fname!="" && $lname!="" ){
				$fqry="OR (firstname like '$fname%' AND lastname like '$lname%')";	
			}

			$keywordquery=" AND (FIND_IN_SET('$keyword',professional_skill) OR FIND_IN_SET('$keyword',REPLACE(professional_skill,' ','')) OR FIND_IN_SET('$keyword',additional_services) OR FIND_IN_SET('$keyword',REPLACE(additional_services,' ','')) ".$fqry." OR firstname LIKE '%$keyword%' OR lastname LIKE '%$keyword%' OR business_name LIKE '%$keyword%'  OR current_position like '%$keyword%') ";	
		}


		$data = $this->common_model->getAllwhere(USERS,"active='1' ".$profile." ".$categQuery.$keywordquery, 'id', 'DESC','all','','','','');


		$userdtl=array();
		$userlist=array();

		if(!empty($data['result'])){
			foreach($data['result'] as $usr){
				$nuserid=$usr->id;
				$userdtl['id']=$usr->id;
				$userdtl['type']=$usr->type;
				$userdtl['firstname']=$usr->firstname;
				$userdtl['lastname']=$usr->lastname;
				$userdtl['device_id']=$usr->device_id;
				$userdtl['email']=$usr->email;
				$userdtl['profile']=$usr->profile;
				$userdtl['gender']=$usr->gender;
				$userdtl['user_role']=$usr->user_role;
				$userdtl['user_category']=$usr->user_category;
				$userdtl['zip']=$usr->zip;
				$userdtl['city']=$usr->city;
				$userdtl['state']=$usr->state;
				$userdtl['country']=$usr->country;
				$userdtl['current_position']=$usr->current_position;
				$userdtl['working_at']=$usr->working_at;
				$userdtl['basic_info']=$usr->basic_info;
				$info=array('tb_users.profile','tb_users.business_address','tb_users.city','tb_users.state','tb_users.country','tb_users.business_name','requests.job_requested_by','tb_users.user_role');
				$relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
				$condition2="(requests.receiver='$nuserid' OR requests.sender='$nuserid') AND requests.status=1 AND tb_users.id!='$nuserid' ";
				$user_workingAt1 = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");
// if(!empty($user_workingAt1)){
// 	$userdtl['working_at']=$user_workingAt1[0]['business_name'];
// 	$userdtl['business_name']=$user_workingAt1[0]['business_name'];
// 	$userdtl['business_address']=$user_workingAt1[0]['business_address'];
// }else{
// 	$userdtl['working_at']='';
// 	$userdtl['business_name']='';
// 	$userdtl['business_address']='';
// }
				$currentUserData = $this->common_model->getsingle(USERS,array('id'=>$user_id));
				$status1 = '';
				if(!empty($currentUserData)){
					$userRole = $currentUserData->user_role;

					if($usr->user_role=='Employer'){ 
						if($userRole == 'Employer'){ 
						}
						else{  
							if($user_id){
								$userOne = $user_id;
								$userTwo = $usr->id;
								$isRequest = checkRequest($userOne,$userTwo);
								$requestedByUser = jobRequestedBy($userOne,$usr->id);
								if($requestedByUser != $userOne && $requestedByUser!=0 && $isRequest!='Accepted'){
									$isRequest = 'NotConfirm';
								}
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}
							else if($isRequest=='NotConfirm'){ 
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($senderID,$usr->id);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 
									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								}
							}
							else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}
							else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}
					}
					else{
						if($userRole == 'Employer'){ 
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isRequest=checkRequest($userOne,$userTwo);
							}else{
								$isRequest="No";  
							}
							if($isRequest=='No'){ 
								$status1 = 'Job Request';
							}else if($isRequest=='NotConfirm'){
								$senderID = $user_id;
								$requestedByUser = jobRequestedBy($usr->id,$senderID);

								if($requestedByUser != $senderID && $requestedByUser!=0){ 

									$status1 = 'Accept Request';
								}else{ 
									$status1 = 'Pending';
								} 

							} else if($isRequest=='Pending'){ 
								$status1 = 'Pending';
							}else if($isRequest=='Accepted'){
								$status1 = 'Accepted';
							}
						}else{
							if($user_id){
								$userOne=$user_id;
								$userTwo=$usr->id;
								$isFriend=checkFriend($userOne,$userTwo);
							}else{
								$isFriend="No"; 
							}

							if($isFriend=='No'){ 
								$status1 = 'Add Friend';
							}
							else if($isFriend=='NotConfirm'){ 
								$status1 = 'Confirm';
							}else if($isFriend=='Pending'){
								$status1 = 'Pending';
							}else if($isFriend=='Accepted'){
								$status1 = 'Accepted';
							} 
						}
					}
				}
				$userdtl['req_status'] = $status1;
				
				if(!empty($user_workingAt1) && ($usr->user_role == 'Performer')){
					$userdtl['working_at']=$user_workingAt1[0]['business_name'];
					$userdtl['business_name']=$user_workingAt1[0]['business_name'];
					$userdtl['business_address']=$user_workingAt1[0]['business_address'];
				}else{
					$userdtl['working_at']='';
					$userdtl['business_name']=$usr->business_name;
					$userdtl['business_address']='';
				}
				$ratingData =  userOverallRatings($usr->id);
				$starRating=0;
				$reviewCount=0;
				if(isset($ratingData['ratingAverage'])){
					$starRating= $ratingData['ratingAverage'];
					$reviewCount= $ratingData['reviewCount'];

				}

				$userdtl['ratings']=$starRating;
				$userdtl['reviewCount']=$reviewCount;

				$favourite=0;
				if($user_id!=0){
					$dataArr=array('added_by'=>$user_id,'added_to'=>$nuserid);
					$alreadyFavourite = $this->common_model->getsingle(FAVOURITES,$dataArr);
					if(!empty($alreadyFavourite)){
						$favourite=1;	
					}
				}
				$userdtl['favourite']=$favourite;

				if($rating!=""){
					$ratings=explode(',',$rating);
					if(in_array(round($starRating),$ratings)){
						$userlist[]=$userdtl;
					}
				}else{
					$userlist[]=$userdtl;
				}
			}
		}

		$finalArrays = $userlist;
		if(!empty($reviews) && !empty($finalArrays)){
			if($reviews==1){
				$finalArray = arraymultisubsort($finalArrays,'reviewCount');
			}else{
				$finalArray = arraymultisubsort($finalArrays,'reviewCount');
				$finalArray = array_reverse($finalArray);	
			}
		}else{
			$finalArray=$userlist;
		}


		$data['result']=$finalArray;
		$data['total_count']=count($finalArray);

		$resp=array("result"=>1,'msg'=>'All Filtered Data.','data'=>$data);
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/******Add-TASK-****/
/***************************/
public function addtask_post(){
	$this->form_validation->set_rules('task_members', 'Task members', 'required');
	$this->form_validation->set_rules('title', 'Title', 'required');
	$this->form_validation->set_rules('description', 'Description', 'required');
	$this->form_validation->set_rules('start_date', 'Start date', 'required');
	$this->form_validation->set_rules('end_date', 'End date', 'required');
	$this->form_validation->set_rules('user_id', 'User Id', 'required');

	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$taskmembers=$this->input->post('task_members');
		$task_members=explode(',',$taskmembers);
		$title=$this->input->post('title');
		$description=$this->input->post('description');
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		$dataInsert['assigned_by'] = $user_id;
		$dataInsert['title'] = $title;
		$dataInsert['description'] = $description;
		$dataInsert['start_date'] = $start_date;
		$dataInsert['end_date'] = $end_date;
		$taskID = $this->common_model->insertData(TASK,$dataInsert);

		$senderData = $this->common_model->getsingle(USERS,array('id'=>$user_id));

		if($taskID){
			if(!empty($task_members)){ $taskArr = array();
				foreach($task_members as $member){
					$taskExist = $this->common_model->getsingle(TASK_ASSIGNED,array('task_id'=>$taskID,'user_id'=>$member));
					if(empty($taskExist)){
						/* To send push notifications */
						$notification_message = " has assigned you a task.";
						$this->sendNotifications($user_id,$member,'new_task',$notification_message);

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
					$resp=array("result"=>1,'msg'=>'Task added successfully.','data'=>array());
					$this->db->insert_batch(TASK_ASSIGNED, $taskArr);
				}
			}else{
				$resp=array("result"=>0,'msg'=>'Task members not available.','data'=>array());
			}

		}else{
			$resp=array("result"=>0,'msg'=>'Task not added. Try Again.','data'=>array());	
		}

		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/******Edit-TASK-****/
/***************************/
public function edittask_post(){
	$this->form_validation->set_rules('task_members', 'Task members', 'required');
	$this->form_validation->set_rules('title', 'Title', 'required');
	$this->form_validation->set_rules('description', 'Description', 'required');
	$this->form_validation->set_rules('start_date', 'Start date', 'required');
	$this->form_validation->set_rules('end_date', 'End date', 'required');
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('task_id', 'Task Id', 'required');

	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$taskmembers=$this->input->post('task_members');
		$task_members=explode(',',$taskmembers);
		$title=$this->input->post('title');
		$description=$this->input->post('description');
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		$task_id=$this->input->post('task_id');
		$taskID=$task_id;
		$dataUpdate['assigned_by'] = $user_id;
		$dataUpdate['title'] = $title;
		$dataUpdate['description'] = $description;
		$dataUpdate['start_date'] = $start_date;
		$dataUpdate['end_date'] = $end_date;
		$this->common_model->updateFields(TASK,$dataUpdate,array('id'=>$task_id));
		$senderData = $this->common_model->getsingle(USERS,array('id'=>$user_id));
		$getAllMemberTasks = $this->common_model->getAllwhere(TASK_ASSIGNED,array('task_id'=>$task_id));
		//print_r($task_members);
		//pr($getAllMemberTasks);
		if(!empty($getAllMemberTasks['result'])){
			foreach($getAllMemberTasks['result'] as $memberData){
				if(!in_array($memberData->user_id,$task_members)){
					$this->common_model->deleteData(TASK_ASSIGNED,array('id'=>$memberData->id));
				}
			}
		}

		if($task_id){
			if(!empty($task_members)){ 
				$taskArr = array();
				foreach($task_members as $member){
					$taskExist = $this->common_model->getsingle(TASK_ASSIGNED,array('task_id'=>$task_id,'user_id'=>$member));
					if(empty($taskExist)){
						$memberTask['task_id'] = $task_id;
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
					$resp=array("result"=>1,'msg'=>'Task updated successfully.','data'=>array());
					$this->db->insert_batch(TASK_ASSIGNED, $taskArr);
				}else{
					$resp=array("result"=>1,'msg'=>'Task updated successfully.','data'=>array());
				}
			}else{
				$resp=array("result"=>0,'msg'=>'Task members not available.','data'=>array());
			}

		}else{
			$resp=array("result"=>0,'msg'=>'Task not updated. Try Again.','data'=>array());	
		}

		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Get-PROFILESTATUS******/
/***************************/
public function getmembers_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		/*to fetch performers under employer*/
		$relation2="tb_users.id=requests.sender";
		$condition2=" requests.status=1 and  requests.receiver=".$user_id;
		$memberlist = $this->common_model->get_two_table_data('tb_users.id,tb_users.firstname,tb_users.lastname',USERS,REQUESTS,$relation2,$condition2,$groupby='');
		if($memberlist){
			$resp=array("result"=>1,'msg'=>'Memberlist','lists'=>$memberlist);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'lists'=>"");
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}

/***************************/
/********Pri-UPDATE-POST******/
/***************************/
public function updatepost_post(){
	
	$this->form_validation->set_rules('post_id', 'Post Id', 'required');
	if ($this->form_validation->run() == TRUE){
		echo "SUNIL";
		pr($_POST);
		$post_id = $this->input->post('post_id');
		$allimg = array();
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
			$oldImages = explode(',',$this->input->post('post_images_'));
			foreach($oldImages as $row){
				$allimg[] = $row;
			}
		}
		if(!empty($allimg))
			$dataArr['post_image']=implode(',',$allimg);
		else
			$dataArr['post_image']='';
		if($this->input->post('post_content')){
			$dataArr['post_content']=$this->input->post('post_content');
		}
		$update = $this->common_model->updateFields(POSTS,$dataArr,array('id'=>$post_id));

		$resp=array("result"=>1,'msg'=>'Post Updated Successfully','post'=>'');
		$this->response($resp, REST_Controller::HTTP_OK);

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********UPDATE-Task-Status******/
/***************************/
public function updatetaskstatus_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('taskid', 'Task Id', 'required');
	$this->form_validation->set_rules('status', 'Status', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$note=$this->input->post('note');
		$taskid=$this->input->post('taskid');
		$status=$this->input->post('status');
		/*to fetch performers under employer*/
		$status1="";
		if($status == 0){
			$status1 = 'Pending';
		}else if($status == 1){
			$status1 = 'Process';
		}else if($status == 2){
			$status1 = 'Completed';
		}else if($status == 3){
			$status1 = 'Incomplete';
		}

		$taskData = $this->common_model->GetJoinRecord(TASK,'assigned_by',USERS,'id','tb_users.business_name,tb_users.email,tb_users.new_task_notification,task.title',array('task.id'=>$taskid));
		$userDetails = $this->common_model->getsingle(USERS,array('id'=>$user_id)); 
		if(!empty($taskData['result'][0]) && ($taskData['result'][0]->new_task_notification == 1)){
			$message = '';
			$from = "noreply@workadvisor.co";    
			$subject = 'Task Status'; 
			$message = ' Hey '.ucwords($taskData['result'][0]->business_name).'! <a href="'.base_url().'viewdetails/profile/'.encoding($userDetails->id).'" target="_blank">'.ucwords($userDetails->firstname.' '.$userDetails->lastname).'</a> has updated the status of the task <b>"'.ucfirst($taskData['result'][0]->title).'"</b> as <b>"'.$status1.'"</b> on WorkAdvisor.co.<br><br>';
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

		$dataUpdate['note']=$note;
		$dataUpdate['status']=$status;
		$updatetask=$this->common_model->updateFields(TASK_ASSIGNED,$dataUpdate,array('task_id'=>$taskid,'user_id'=>$user_id));	
		$resp=array("result"=>1,'msg'=>'Task status updated successfully.','data'=>array());
		$this->response($resp, REST_Controller::HTTP_OK);


	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Get-Albums******/
/***************************/
public function getalbums_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		/*to fetch performers under employer*/
		$data=array();
		$companies=array();
		$companies1=new StdClass;
		$datacomps = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_status'=>0), 'id', 'DESC','all','','',$group_by='company',$and_where = '');
		if(!empty($datacomps['result'])){
			$company_nobj=new StdClass;
			foreach($datacomps ['result'] as $compss){
				$company_ids=$compss->company;
				if($company_ids==0){
					$company_name=isset($data['category_questions']->name)?$data['category_questions']->name:'';
				}else{
					$companyDTL =$this->common_model->getsingle(USERS,array('id'=>$company_ids));
					$company_name=isset($companyDTL->business_name)?$companyDTL->business_name:'';
				}
				$postbycomp = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_status'=>0,'company'=>$company_ids,'post_image!='=>''), 'id', 'DESC','all','','',$group_by='',$and_where = ''); 
				$companies[]=array('company_name'=>$company_name,'compdata'=>$postbycomp['result']);
//$companies1->company_name=$company_name;
//$companies1->company_data=$postbycomp['result'];
			}
		}	
		$data['postbycompany']=$companies;
//$data['albumData']=$this->common_model->getAllwhere(ALBUMS,array('user_id'=>$user_id,'folder_id' => 0));


		$data['albumFolderData']=$this->common_model->getAllwhere(ALBUM_DIR,array('user_id'=>$user_id,'dir_parent'=>0));

		if($data){
			$resp=array("result"=>1,'msg'=>'Album Directry & data','data'=>$data);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'lists'=>"");
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/**********************************/
/********Get-Albums-By-Folder******/
/**********************************/
public function albumsbyfolder_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('folder_id', 'Folder Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$folder_id=$this->input->post('folder_id');
		/*to fetch performers under employer*/
		$data=array();
		$data['baseurl']=base_url();
		$data['albumData']=$this->common_model->getAllwhere(ALBUMS,array('user_id'=>$user_id,'folder_id' =>$folder_id));
		$data['allfolder']=$this->common_model->getAllwhere(ALBUM_DIR,array('dir_parent'=>$folder_id));

		if($data){
			$resp=array("result"=>1,'msg'=>'Directry data','data'=>$data);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'lists'=>"");
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/**********************************/
/********Get-Albums-By-Folder******/
/**********************************/
public function createfolder_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('folder_name', 'Folder Name', 'required');
	$this->form_validation->set_rules('view_type', 'View_type', 'required');
	$this->form_validation->set_rules('parent_folder_id', 'Parent Folder Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$folder_name=$this->input->post('folder_name');
		$view_type=$this->input->post('view_type');
		$parent_folder_id=$this->input->post('parent_folder_id');
		/*to fetch performers under employer*/
		$data=array();
		$dataInsert['user_id']=$user_id;
		$dataInsert['dir_name']=$folder_name;
		$dataInsert['dir_view_type']=$view_type;
		$dataInsert['dir_parent']=$parent_folder_id;

		$folderData = $this->common_model->getsingle(ALBUM_DIR,array('dir_name'=>$folder_name,'user_id'=>$user_id));

		if(empty($folderData)){
			$insrt=$this->common_model->insertData(ALBUM_DIR, $dataInsert);
			$data['folder_name']=$folder_name;
			$data['folder_id']=$insrt;
			$data['dir_view_type']=$view_type;
			$data['parent_folder_id']=$parent_folder_id;
			$resp=array("result"=>1,'msg'=>'Folder Created','data'=>$data);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Folder name already exist.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/**********************************/
/********Upload-Doc-To-Album******/
/**********************************/
public function uploadfiles_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('folder_id', 'Folder Id', 'required');
	$this->form_validation->set_rules('folder_id', 'Folder Id', 'required');

	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$folder_id=$this->input->post('folder_id');
		$view_type=$this->input->post('view_type');

		$dataInsert['user_id']=$user_id;
		$dataInsert['folder_id']=$folder_id;
		$dataInsert['view_type']=$view_type;

		if(!empty($_FILES['files']['name'])){
			$filesCount = !empty($_FILES['files']['name'])? count($_FILES['files']['name']):'';
			$userData = $this->common_model->getsingle(USERS,array('id'=>$user_id));
			if($filesCount>0){
				for($i = 0; $i < $filesCount; $i++){
					$_FILES['docfile']['name'] = $_FILES['files']['name'][$i];
					$_FILES['docfile']['type'] = $_FILES['files']['type'][$i];
					$_FILES['docfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['docfile']['error'] = $_FILES['files']['error'][$i];
					$_FILES['docfile']['size'] = $_FILES['files']['size'][$i];
					$config['upload_path'] = FCPATH.'uploads/docs/';
					$path=$config['upload_path'];
					$config['allowed_types'] = '*';
					$config['overwrite'] = '1';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload('docfile')){
						$fileData = $this->upload->data();
						$fileName = $fileData['file_name'];
						$dataInsert['albums']  = 'uploads/docs/'.$fileName;
						$dataInsert['name']  = $fileName;
						$dataInsert['created_date'] = date('Y-m-d H:i:s');
						$albumData = $this->common_model->getsingle(ALBUMS,array('user_id'=>$user_id,'albums'=>$dataInsert['albums']));
						if(empty($albumData)){
							$ins = $this->common_model->insertData(ALBUMS, $dataInsert);
						}else{
							$error =array("result"=>0,"msg"=>$this->upload->display_errors(),'data'=>'File name already exist. try another one.'); 
							$this->response($error, REST_Controller::HTTP_OK); 
						}
					}else{
						$error =array("result"=>0,"msg"=>$this->upload->display_errors(),'data'=>''); 
						$this->response($error, REST_Controller::HTTP_OK); 	
					}
				}

				$error =array("result"=>1,"msg"=>"Files successfully uploaded."); 
				$this->response($error, REST_Controller::HTTP_OK);

			}else{
				$error =array("result"=>0,"msg"=>"You did not select any files."); 
				$this->response($error, REST_Controller::HTTP_OK);
			}
		}else{
			$error =array("result"=>0,"msg"=>"Please select files to upload."); 
			$this->response($error, REST_Controller::HTTP_OK);	
		}

		if(empty($folderData)){
			$insrt=$this->common_model->insertData(ALBUM_DIR, $dataInsert);
			$data['folder_name']=$folder_name;
			$data['folder_id']=$insrt;
			$data['dir_view_type']=$view_type;
			$data['parent_folder_id']=$parent_folder_id;
			$resp=array("result"=>1,'msg'=>'Folder Created','data'=>$data);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Folder name already exist.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/**********************************/
/********Get-ALL-PHOTOS******/
/**********************************/
public function getallphotos_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('start_limit', 'Start limit', 'required');
	$this->form_validation->set_rules('end_limit', 'End limit', 'required');

	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$start_limit=$this->input->post('start_limit');
		$end_limit=$this->input->post('end_limit');

		/*to fetch performers under employer*/
		$data=array();
		$data = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_image!='=>''), 'id', 'DESC','all',$end_limit,$start_limit);
		$dataall = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_image!='=>''), 'id', 'DESC','all');
		$data = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_image!='=>''), 'id', 'DESC','all',$end_limit,$start_limit);

		$datas['total_count']=$dataall['total_count'];
		$datas['result']=$data['result'];
		$resp=array("result"=>1,'msg'=>'Albums','data'=>$datas);
		$this->response($resp, REST_Controller::HTTP_OK);	
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********UPDATE-PROFILE-******/
/***************************/
public function uploadprofilepicture_post(){
//	$resp=array("user_id"=>$_POST['user_id'],"profile_image"=>$_FILES);
//	$this->response($resp, REST_Controller::HTTP_OK);
//die();
	$this->form_validation->set_rules('user_id', 'User id', 'required');
	if ($this->form_validation->run() == TRUE){
		$dataArr=array();	
		$rate_date=date('Y-m-d H:i:s');
		$user_id=$this->input->post('user_id');
		if(isset($_FILES['profile_image']['name']) && !empty($_FILES['profile_image']['name'])){ 
			$profile_image = fileUploading('profile_image','users','*');
			if(isset($profile_image['error'])){
				$return['resp']         =   1; 
				$return['data']         =   strip_tags($profile_image['error']);
				$return['Message']      =   strip_tags($profile_image['error']);
				$this->response($return); 
				$resp=array("result"=>0,"msg"=>$return['Message']);
				$this->response($resp, REST_Controller::HTTP_OK);		
			}else{
				$profile_pic=$profile_image['upload_data']['file_name'];

				$dataarr['profile']   = base_url().'uploads/users/'.$profile_pic;

			} 
		}else{
			$resp=array("result"=>0,"msg"=>"Please select file to upload.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK); 
		}
		/**************/

		$result=$this->common_model->updateFields(USERS,$dataarr,array('id'=>$user_id));
		if($result){
			$resp=array("result"=>1,'msg'=>'Profile Image Successfully Uploaded. ','data'=>$dataarr);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********CREATE-GROUP-******/
/***************************/
public function creategroup_post(){
	$this->form_validation->set_rules('group_name', 'Group name', 'required');
	$this->form_validation->set_rules('group_members', 'Group members', 'required');
	$this->form_validation->set_rules('group_owner', 'Group owner', 'required');

	if ($this->form_validation->run() == TRUE){
		$dataInsert=array();	
		$rate_date=date('Y-m-d H:i:s');
		$name=$this->input->post('group_name');
		$group_members=$this->input->post('group_members');
		$owner_id=$this->input->post('group_owner');
		$dataInsert['name']=$name;
		$dataInsert['group_members']=$group_members;
		$dataInsert['owner_id']=$owner_id;
		$dataInsert['created_date']=date('Y-m-d H:i:s');
		$dataInsert['message_date']=date('Y-m-d H:i:s');

		/************/	
		if(isset($_FILES['group_icon']['name']) && !empty($_FILES['group_icon']['name'])){
			$profile_image = fileUploading('group_icon','users','*');
			if(isset($profile_image['error'])){
				$return['resp']         =   1; 
				$return['data']         =   strip_tags($profile_image['error']);
				$return['Message']      =   strip_tags($profile_image['error']);
				$this->response($return); 
				$resp=array("result"=>0,"msg"=>$return['Message']);
				$this->response($resp, REST_Controller::HTTP_OK);		
			}else{
				$profile_pic=$profile_image['upload_data']['file_name'];
				$dataInsert['group_icon']   = base_url().'uploads/users/'.$profile_pic;
			} 
		}
		/****************/

		$result=$this->common_model->insertData(MESSAGE_GROUP, $dataInsert);

		$respdata=array('group_data'=>$dataInsert,'group_id'=>$result);

		if($result){
			$resp=array("result"=>1,'msg'=>'Group created Successfully. ','data'=>$respdata);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********UPDATE-GROUP-******/
/***************************/
public function updategroup_post(){
	$this->form_validation->set_rules('group_id', 'Group Id', 'required');
	$this->form_validation->set_rules('group_name', 'Group name', 'required');
	$this->form_validation->set_rules('group_members', 'Group members', 'required');
	$this->form_validation->set_rules('group_owner', 'Group owner', 'required');

	if ($this->form_validation->run() == TRUE){
		$dataInsert=array();	
		$rate_date=date('Y-m-d H:i:s');
		$group_id=$this->input->post('group_id');
		$name=$this->input->post('group_name');
		$group_members=$this->input->post('group_members');
		$owner_id=$this->input->post('group_owner');
		$dataInsert['name']=$name;
		$dataInsert['group_members']=$group_members;
		$dataInsert['owner_id']=$owner_id;


		/************/	
		if(isset($_FILES['group_icon']['name']) && !empty($_FILES['group_icon']['name'])){
			$profile_image = fileUploading('group_icon','users','*');
			if(isset($profile_image['error'])){
				$return['resp']         =   1; 
				$return['data']         =   strip_tags($profile_image['error']);
				$return['Message']      =   strip_tags($profile_image['error']);
				$this->response($return); 
				$resp=array("result"=>0,"msg"=>$return['Message']);
				$this->response($resp, REST_Controller::HTTP_OK);		
			}else{
				$profile_pic=$profile_image['upload_data']['file_name'];
				$dataInsert['group_icon']   = base_url().'uploads/users/'.$profile_pic;
			} 
		}
		/****************/
		$result=$this->common_model->updateFields(MESSAGE_GROUP,$dataInsert,array('id'=>$group_id));
		$respdata=array('group_data'=>$dataInsert,'group_id'=>$group_id);

		if($result){
			$resp=array("result"=>1,'msg'=>'Group updated successfully. ','data'=>$respdata);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********EXIT-GROUP-******/
/***************************/
public function exitgroup_post(){
	$this->form_validation->set_rules('group_id', 'Group Id', 'required');
	$this->form_validation->set_rules('user_id', 'User id', 'required');

	if ($this->form_validation->run() == TRUE){
		$dataInsert=array();	
		$rate_date=date('Y-m-d H:i:s');
		$group_id=$this->input->post('group_id');
		$user_id=$this->input->post('user_id');
		$groupData = $this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$group_id));
		if(!empty($groupData)){
			$group_members=$groupData->group_members;
			$parts = explode(',', $group_members);
			while(($i = array_search($user_id, $parts)) !== false) {
				unset($parts[$i]);
			}
			$remaing=implode(',', $parts);

			$dataInsert['group_members']=$remaing;	
			$result=$this->common_model->updateFields(MESSAGE_GROUP,$dataInsert,array('id'=>$group_id));
			$groupData = $this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$group_id));
			$respdata=array('group_data'=>$groupData,'group_id'=>$group_id);
			$resp=array("result"=>1,'msg'=>'You Left The Group. ','data'=>$respdata);
			$this->response($resp, REST_Controller::HTTP_OK);		
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/***************************/
public function getgroupmember_post(){
	$this->form_validation->set_rules('group_id', 'Group Id', 'required');
		if ($this->form_validation->run() == TRUE){
			$group_id=$this->input->post('group_id');
			$groupData = $this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$group_id));
			
			if(!empty($groupData)){
				$members=$groupData->group_members;
				if($members!=""){
					$mmarr=explode(',',$members);
					$allmembers = $this->common_model->getAllwhereIn(USERS,'','id',$mmarr,'','','id,firstname,profile');
					$resp=array("result"=>1,'msg'=>'All Group Member. ','data'=>$allmembers);
			        $this->response($resp, REST_Controller::HTTP_OK);
				}else{
					$resp=array("result"=>0,'msg'=>'Group member not found. ','data'=>$allmembers);
			        $this->response($resp, REST_Controller::HTTP_OK);
				}

			}else{
			$resp=array("result"=>0,"msg"=>"Group Not Found.",'data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);	
			}
			
				}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
	
}
/***************************/
/********SEND-MAIL-INVITATION-******/
/***************************/
public function sendinvitation_post(){
	$this->form_validation->set_rules('emails', 'Emails', 'required');
	$this->form_validation->set_rules('user_id', 'User ID', 'required');
	$this->form_validation->set_rules('message_content', 'Message Content', 'required');

	if ($this->form_validation->run() == TRUE){
		$cuid = $this->input->post('user_id');
        $userData = $this->common_model->getsingle(USERS,array('id'=>$cuid));
        $senderName = ucwords($userData->firstname)." ".ucwords($userData->lastname);
        $tosend = $this->input->post('emails');
        $emails = explode(',',$this->input->post('emails'));
        if(!empty($emails)){
            foreach($emails as $row){
                $message = '';
                $from = "noreply@workadvisor.co";    
                $subject = 'WorkAdvisor.co Invitation from '.$senderName; 
                $message .= ' Hey! '.$senderName.' invited you to join WorkAdvisor.co 
                <br><br>';
                if($this->input->post('message_content')){
                    $message .=  '<pre style="font-family: arial,sans-serif;">'.$this->input->post('message_content').'</pre>';
                }
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
                $this->email->to($row);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->set_header('From', $from);
                if($this->email->send()){
                }
            }
            $resp=array("result"=>1,'msg'=>'Mail sent successfully.','data'=>'');
			$this->response($resp, REST_Controller::HTTP_OK);
        }
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}

/***************************/
/********MY-GROUPS******/
/***************************/
public function mygroups_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');

		$condition="owner_id='$user_id' OR FIND_IN_SET('$user_id',group_members)";
		$grouplist = $this->common_model->getAllwhere(MESSAGE_GROUP,$condition, 'id', 'DESC','all');

		if($grouplist){
			if(!empty($grouplist['result'])){
				$existingMembers = array();
				$deviceArray = array();
				foreach($grouplist['result'] as $group){
					$members = explode(',',$group->group_members);
					if(!empty($members)){
						foreach($members as $mem){
							if(!in_array($mem, $existingMembers)){
								$existingMembers[] = $mem;
								$userData = $this->common_model->getsingle(USERS,array('id'=>$mem));
								if(!empty($userData->device_id)){
									$deviceArray[$mem] = $userData->device_id;
								}
							}
						}
					}
				}
			}
			$deviceIDS = '';
			if(!empty($deviceArray)){
				$deviceIDS = implode(',', $deviceArray);
			}

			$resp=array("result"=>1,'msg'=>'Group List','lists'=>$grouplist,'device_id'=>$deviceIDS);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'lists'=>"");
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Get-Comment_by_post******/
/***************************/
public function getpostcomment_post(){
	$this->form_validation->set_rules('post_id', 'Post Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$post_id=$this->input->post('post_id');
		$commentData = $this->common_model->GetJoinRecord(COMMENTS,'user_id',USERS,'id','comments.*,tb_users.firstname,tb_users.lastname,tb_users.profile',array('comments.post_id'=>$post_id));

		if(!empty($commentData)){
			$resp=array("result"=>1,'msg'=>'Comment List.','comments'=>$commentData);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'rating'=>$comment);
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/***************************/
/***************************/

/***************************/
/********Get-Notifications_by_post******/
/***************************/
public function getnotificaitons_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$arrayCount = 0;
		$notficationsArray = array();
		$cuid=$this->input->post('user_id');
		$userData = $this->common_model->getsingle(USERS,array('id'=>$cuid));
//code for messages
		$info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','messages.message_date as accept_date','tb_users.business_name','msg_status','messages.id as msg_id');
		$condition=array('messages.receiver'=>$cuid,'messages.accept_status_notify'=>1);
		$relation="messages.sender=tb_users.id";
		$pendingMessages = $this->common_model->get_two_table_data($info,USERS,MESSAGES,$relation,$condition,$groupby="");
		if(!empty($pendingMessages)){
			foreach($pendingMessages as $row){
				$notficationsArray[$arrayCount] = $row;
				$notficationsArray[$arrayCount]['type'] = 'message';
				$notficationsArray[$arrayCount]['group_name'] = '';
				$notficationsArray[$arrayCount]['receiver'] = '';
				$arrayCount++;
			}
		}
//find user groups
		$where =  'find_in_set('.$cuid.',group_members) !=0';
		$userGroups = $this->common_model->getAllwhere(MESSAGE_GROUP, $where);
		if(!empty($userGroups['result'])){
			foreach($userGroups['result'] as $row){
				$group_id = $row->id;
				$group_name = $row->name;
				$where = ' NOT find_in_set('.$cuid.',new_msg_read_by) and is_group=1 and receiver='.$group_id.' and sender!='.$cuid;
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
			$condition=array('requests.receiver'=>$cuid,'requests.accept_status_notify'=>1,'requests.status!='=>1,'requests.confirmed!='=>2);
			$relation="requests.sender=tb_users.id";
			$pendingRequests = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation,$condition,$groupby="");

			if(!empty($pendingRequests)){
				foreach($pendingRequests as $row){
					$notficationsArray[$arrayCount] = $row;
					$notficationsArray[$arrayCount]['type'] = 'business';
					$notficationsArray[$arrayCount]['group_name'] = '';
					$notficationsArray[$arrayCount]['receiver'] = '';
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
					$notficationsArray[$arrayCount]['group_name'] = '';
					$notficationsArray[$arrayCount]['receiver'] = '';
					$arrayCount++;
				}
			}
		}

//code for new friend request came to user
		if($userData->user_role =='Performer'){
			$info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','friends.accept_date','tb_users.business_name','msg_status','friends.id as friend_id');
			$condition=array('friends.user_two_id'=>$cuid,'friends.accept_status_notify!='=>2,'friends.status!='=>1);
			$relation="friends.user_one_id=tb_users.id";
			$pendingFriendRequest = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,$groupby="");
			if(!empty($pendingFriendRequest)){
				foreach($pendingFriendRequest as $row){
					$notficationsArray[$arrayCount] = $row;
					$notficationsArray[$arrayCount]['type'] = 'recievedrequest';
					$notficationsArray[$arrayCount]['group_name'] = '';
					$notficationsArray[$arrayCount]['receiver'] = '';
					$arrayCount++;
				}
			}
		}

//code when the friend has accepted your request
		if($userData->user_role =='Performer'){
			$info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','friends.accept_date','msg_status','friends.id as friend_id');
			$condition=array('friends.user_one_id'=>$cuid,'friends.status'=>1,'friends.accept_status_notify!='=>3);
			$relation="friends.user_two_id=tb_users.id";
			$pendingFriendRequestAccepted = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,$groupby="");

			if(!empty($pendingFriendRequestAccepted)){
				foreach($pendingFriendRequestAccepted as $row){
					$notficationsArray[$arrayCount] = $row;
					$notficationsArray[$arrayCount]['type'] = 'accepted';
					$notficationsArray[$arrayCount]['group_name'] = '';
					$notficationsArray[$arrayCount]['receiver'] = '';
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
					$notficationsArray[$arrayCount]['group_name'] = '';
					$notficationsArray[$arrayCount]['receiver'] = '';
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
					$notficationsArray[$arrayCount]['group_name'] = '';
					$notficationsArray[$arrayCount]['receiver'] = '';
					$arrayCount++;
				}
			}
		}


		if($notficationsArray){
			$resp=array("result"=>1,'msg'=>'Notifications','lists'=>$notficationsArray);
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Somethig went wrong, Try again.",'Notifications'=>"");
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/***************************/
/***************************/


/***************************/
/********Update-privacy-status_by_post******/
/***************************/
public function updateprivacy_post(){
	$this->form_validation->set_rules('fid', 'File/Folder ID', 'required');
	$this->form_validation->set_rules('ftype', 'Document Type', 'required');
	$this->form_validation->set_rules('privacy_status', 'Privacy Status', 'required');
	if ($this->form_validation->run() == TRUE){
		$fid=$this->input->post('fid');
		$ftype=$this->input->post('ftype');
		$privacyStatus=$this->input->post('privacy_status');
		$updated = 0;
		if($ftype == 'file') {
			$updated = 1;
			$dataUpdate['view_type'] = $privacyStatus;
			$this->common_model->updateFields(ALBUMS,$dataUpdate,array('id'=>$fid));
		} else if($ftype == 'folder'){
			$updated = 1;
			$dataUpdate['dir_view_type'] = $privacyStatus;
			$this->common_model->updateFields(ALBUM_DIR,$dataUpdate,array('id'=>$fid));
		}

		if(!empty($updated)){
			$resp=array("result"=>1,'data'=>'','msg'=>'Privacy Status updated successfully.');
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>0,"msg"=>"Error in updation!",'data'=>0);
			$this->response($resp, REST_Controller::HTTP_OK);							
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/*********-POST-LIKE-*******/
/***************************/
public function likepost_post(){
	$this->form_validation->set_rules('user_id', 'User id', 'required');
	$this->form_validation->set_rules('post_id', 'Post Id', 'required');
	$this->form_validation->set_rules('status', 'Like Status', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$post_id=$this->input->post('post_id');
		$status=$this->input->post('status');
		$dataGet['liked_by']=$user_id;
		$dataGet['post_id'] =$post_id;
		$dataGet['status'] =$status;
		$dataGet['like_date'] = date('Y-m-d H:i:s');
		$postData = $this->common_model->getsingle(POSTS,array('id'=>$post_id));
		$dataGet['posted_by'] =$postData->user_id;
		$likeData = $this->common_model->getsingle(LIKE,array('liked_by'=>$user_id,'post_id'=>$post_id));
		if(!empty($likeData)){
			$resp=array("result"=>2,'data'=>'','msg'=>'Post already Liked.');
			$this->response($resp, REST_Controller::HTTP_OK);
//$this->common_model->updateFields(LIKE,array('status'=>$status),array('liked_by'=>$user_id,'post_id'=>$post_id));
		}
		if($status==0){	
			$this->common_model->updateFields(LIKE,array('status'=>$status),array('liked_by'=>$user_id,'post_id'=>$post_id));
		}else{
			$this->common_model->insertData(LIKE,$dataGet);
			$dataInsert['sender'] = $user_id;
			$dataInsert['receiver'] = $postData->user_id;
			$dataInsert['msg'] = 'LIKE';
			$this->common_model->insertData('notifications',$dataInsert);			
		}
		if($status==1){
			$resp=array("result"=>1,'data'=>'','msg'=>'Post Liked.');
			$this->response($resp, REST_Controller::HTTP_OK);
		}else{
			$resp=array("result"=>1,"msg"=>"Post Unliked");
			$this->response($resp, REST_Controller::HTTP_OK);							
		}
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/*********LIKERS-LIST*******/
/***************************/
public function likerslist_post(){
	$this->form_validation->set_rules('post_id', 'Post Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$post_id=$this->input->post('post_id');
	    $info=array('tb_users.id','tb_users.firstname','tb_users.profile');
		$relation="tb_users.id=like.liked_by";
		$condition="like.post_id ='$post_id'";
		$pendingRequest = $this->common_model->get_two_table_data($info,LIKE,USERS,$relation,$condition,$groupby="");
		$resp=array("result"=>1,'data'=>$pendingRequest,'msg'=>'Post Likes List.');
		$this->response($resp, REST_Controller::HTTP_OK);

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********Pri-To-Delete-Group******/
/***************************/
public function deletegroup_post(){
	$this->form_validation->set_rules('group_id', 'Group Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$groupID=$this->input->post('group_id');
		$groupData=$this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$groupID));

		if(!empty($groupData)){
			if($this->common_model->deleteData(MESSAGE_GROUP,array('id'=>$groupID))){
				$resp=array("result"=>1,'msg'=>'Group Deleted Successfully.','data'=>array());
			}
		}else{
			$resp=array("result"=>0,'msg'=>'No such group exist.','data'=>array());
		}
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/********DHANANJAY******/
/***************************/
public function dhananjay_post(){
	$this->form_validation->set_rules('post_id', 'Post id', 'required');
	if ($this->form_validation->run() == TRUE){
		$post_id=$this->input->post('post_id');
		$post_content=$this->input->post('post_content');
		$post_image=$this->input->post('post_image');
		//$user_id=$this->input->post('user_id');
		
		$dataArr=array();
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
					$config['allowed_types'] = '*';
					$path=$config['upload_path'];
					$config['overwrite'] = '1';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if( !$this->upload->do_upload("docfile")){
						$error = array('error' => $this->upload->display_errors());
						$resp=array("result"=>0,'msg'=>$error,'data'=>array());
						$this->response($resp, REST_Controller::HTTP_OK);
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
         $dataArr['post_content']=$post_content;
         $update = $this->common_model->updateFields(POSTS,$dataArr,array('id'=>$post_id)); 
$addpost=1;
		if($addpost){
			$resp=array("result"=>1,'msg'=>'Post updated successfully.','data'=>array('all_posts'=>array()));
			$this->response($resp, REST_Controller::HTTP_OK);

		}else{
			$resp=array("result"=>0,'msg'=>'Something Went Wrong, Try Again.','data'=>array());
			$this->response($resp, REST_Controller::HTTP_OK);
		}

	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}
/***************************/
/***************************/
/********-LEAVE-JOB-******/
/***************************/
public function leavejob_post(){
	$this->form_validation->set_rules('user_id', 'User Id', 'required');
	$this->form_validation->set_rules('other_userid', 'Other User Id', 'required');
	if ($this->form_validation->run() == TRUE){
		$user_id=$this->input->post('user_id');
		$other_userid=$this->input->post('other_userid');
		$this->common_model->deleteData(REQUESTS,array('receiver'=>$other_userid,'sender'=>$user_id));
		
		$resp=array("result"=>1,'msg'=>'Removed successfully. ','data'=>array());
		$this->response($resp, REST_Controller::HTTP_OK);
	}else{
		$error =array("result"=>0,"msg"=>validation_errors()); 
		$this->response($error, REST_Controller::HTTP_OK);
	}
}


/***************************/
}
?>