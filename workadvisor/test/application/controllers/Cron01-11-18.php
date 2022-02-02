<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
class Cron extends My_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('User_model');
	}

	public function index(){
		$usersAll = $this->common_model->getAllwhere(USERS);
		if(!empty($usersAll['result'])){
			foreach($usersAll['result'] as $rows){
				$arrayCount = 0;
				$count = 0;
				$notficationsArray = array();
				$from = "noreply@workadvisor.co";
				$cuid = $rows->id;
				$email = $rows->email;
				//$email = "priyanka.pixlrit@gmail.com";
				$username = $rows->firstname;
				$business_names = $rows->business_name;
				$message_notification =  $rows->message_notification;
				$job_request_received_notification =  $rows->job_request_received_notification;
				$friend_request_received_notification =  $rows->friend_request_received_notification;
				$friend_request_acceptance_notification =  $rows->friend_request_acceptance_notification;
				$job_request_acceptance_notification =  $rows->job_request_acceptance_notification;
				$config['protocol'] = 'ssmtp';
				$config['smtp_host'] = 'ssl://ssmtp.gmail.com';
				$config['mailtype'] = 'html';
				$config['newline'] = '\r\n';
				$config['charset'] = 'utf-8';
				$this->load->library('email', $config);
				$this->email->initialize($config);
//code for messages
				$info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','messages.message_date as accept_date','tb_users.business_name','msg_status','messages.id as msg_id');

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


//code for business profile request
				if($rows->user_role =='Employer'){
					$info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','requests.accept_date','msg_status','requests.id as requests_id');

					$condition=array('requests.receiver'=>$cuid,'accept_status_notify!='=>3,'job_requested_by!='=>$cuid);
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
				if($rows->user_role =='Performer'){
					$info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','requests.accept_date','msg_status','requests.id as requests_id','tb_users.business_name');
					$condition=array('requests.sender'=>$cuid,'job_requested_by!='=>$cuid,'accept_status_notify_business_sent!='=>3);
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
				if($rows->user_role =='Performer'){
					$info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','friends.accept_date','tb_users.business_name','msg_status','friends.id as friend_id');
					$condition=array('friends.user_two_id'=>$cuid,'friends.status!='=>1);
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
				if($rows->user_role =='Performer'){
					$info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','friends.accept_date','msg_status','friends.id as friend_id');
					$condition=array('friends.user_one_id'=>$cuid,'friends.status'=>1);
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
				if($rows->user_role =='Performer'){
					$info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','requests.accept_date','msg_status','requests.id as requests_id','tb_users.business_name');

					$condition=array('requests.sender'=>$cuid,'requests.msg_status!='=>2,'requests.job_requested_by'=>$cuid,'requests.confirmed!='=>3,'requests.status'=>1);
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
				

				//code when the performer has accepted company's job request
				if($rows->user_role =='Employer'){
					$info=array('tb_users.id as userid','tb_users.firstname','tb_users.lastname','requests.accept_date','msg_status','requests.id as requests_id','tb_users.business_name');
					$condition=array('requests.receiver'=>$cuid,'requests.msg_status!='=>2,'requests.job_requested_by'=>$cuid,'requests.confirmed_business!='=>3,'requests.status'=>1);
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

				//pr($notficationsArray);
				if(!empty($notficationsArray) && count($notficationsArray)>0){
					$notficationsArray = json_decode(json_encode($notficationsArray));
					$notficationsArray = (array_multi_subsort($notficationsArray,'accept_date'));
					foreach($notficationsArray as $row){
						$count++;
						if($row->type == 'message'){
							if($message_notification == 1){
								$senderID = encoding($row->userid);
								$receiverID = encoding($cuid);
								$name = '';
								if($row->business_name!='' && isset($row->business_name)){

									$name = $row->business_name;
								}else{

									$name = $row->firstname." ".$row->lastname;
								}
								$subject = 'Notfication for Message';
								// $message = '';
								// $message .='<img src="'.base_url().'/assets/images/logomain.png"/>';
								// $message .= '
								// <p>Hi '.$username.'</p>
								// ';
								// $message .= '<br><br> '.$name." sent you a message.";
								// $message .= '<br><br><a href="'.base_url().'">click here to join Workadvisor</a> ';
								$message = '';
								$message .= $name." sent you a message.";
								$mailData = array();
								$mailData['message'] = $message;
								$mailData['username'] = $username;
								$message = $this->load->view('frontend/mailtemplate',$mailData,true);
								$this->email->from($from);
								$this->email->to($email);
								$this->email->subject($subject);
								$this->email->message($message);
								if($row->msg_status == 0){
									$this->email->send();
									$this->common_model->updateFields(MESSAGES,array('msg_status'=>1),array('id'=>$row->msg_id));
								}
							}else{
								$this->common_model->updateFields(MESSAGES,array('msg_status'=>1),array('id'=>$row->msg_id));
							}
						}
						else if($row->type == 'business'){
							if($job_request_received_notification == 1){
								$senderID = encoding($row->userid);
								$receiverID = encoding($cuid);
								$subject = 'Notfication for Job Request';
								$message = '';
								$message .= $row->firstname." ".$row->lastname." sent you a job request.";
								$mailData = array();
								$mailData['message'] = $message;
								$mailData['username'] = $business_names;
								$message = $this->load->view('frontend/mailtemplate',$mailData,true);
								$this->email->from($from);
								$this->email->to($email);
								$this->email->subject($subject);
								$this->email->message($message);
								//if($row->msg_status == 0){
									$this->email->send();
									$this->common_model->updateFields(REQUESTS,array('msg_status'=>1,'accept_status_notify'=>3),array('id'=>$row->requests_id));
								//}
							}else{
								$this->common_model->updateFields(REQUESTS,array('msg_status'=>1,'accept_status_notify'=>3),array('id'=>$row->requests_id));
							}
						}
						else if($row->type == 'business_job'){
							if($friend_request_received_notification == 1){
								$senderID = encoding($cuid);
								$receiverID = encoding($row->userid);
								$subject = 'Notfication for Job Request';
								$message = '';
								$message .= $row->business_name." sent you a job request.";
								$mailData = array();
								$mailData['message'] = $message;
								$mailData['username'] = $username;
								$message = $this->load->view('frontend/mailtemplate',$mailData,true);
								$this->email->from($from);
								$this->email->to($email);
								$this->email->subject($subject);
								$this->email->message($message);
								//if($row->msg_status == 0){
									$this->email->send();
									$this->common_model->updateFields(REQUESTS,array('msg_status'=>1,'accept_status_notify_business_sent'=>3),array('id'=>$row->requests_id));
								//}
							}else{
								$this->common_model->updateFields(REQUESTS,array('msg_status'=>1,'accept_status_notify_business_sent'=>3),array('id'=>$row->requests_id));
							}
						}
						else if($row->type == 'recievedrequest'){
							if($friend_request_received_notification == 1){
								$senderID = encoding($row->userid);
								$receiverID = encoding($cuid);
								if($row->business_name!='' && isset($row->business_name)){

									$name = $row->business_name;
								}else{

									$name = $row->firstname." ".$row->lastname;
								}

								$subject = 'Notfication for Received Request';
								// $message = '';
								// $message .='<img src="'.base_url().'/assets/images/logomain.png"/>';
								// $message .= '
								// <p>Hi '.$username.'</p>
								// ';
								// $message .= '<br><br> '.$row->firstname." ".$row->lastname." sent you a friend request.";
								// $message .= '<br><br><a href="'.base_url().'">click here to join Workadvisor</a> ';
								$message = '';
								$message .= $row->firstname." ".$row->lastname." sent you a friend request.";
								$mailData = array();
								$mailData['message'] = $message;
								$mailData['username'] = $username;
								$message = $this->load->view('frontend/mailtemplate',$mailData,true);
								$this->email->from($from);
								$this->email->to($email);
								$this->email->subject($subject);
								$this->email->message($message);
								if($row->msg_status == 0){
									$this->email->send();
									$this->common_model->updateFields(FRIENDS,array('msg_status'=>1),array('id'=>$row->friend_id));
								}
							}else{
								$this->common_model->updateFields(FRIENDS,array('msg_status'=>1),array('id'=>$row->friend_id));
							}
						}
						else if($row->type == 'accepted'){
							if($friend_request_acceptance_notification == 1){
								$senderID = encoding($cuid);
								$receiverID = encoding($row->userid);

								$subject = 'Notfication for Friend Request Acceptance';
								// $message = '';
								// $message .='<img src="'.base_url().'/assets/images/logomain.png"/>';
								// $message .= '
								// <p>Hi '.$username.'</p>
								// ';
								// $message .= '<br><br> '.$row->firstname." ".$row->lastname." has accepted your friend request.";
								// $message .= '<br><br><a href="'.base_url().'">click here to join Workadvisor</a> ';
								$message = '';
								$message .= $row->firstname." ".$row->lastname." has accepted your friend request.";
								$mailData = array();
								$mailData['message'] = $message;
								$mailData['username'] = $username;
								$message = $this->load->view('frontend/mailtemplate',$mailData,true);
								$this->email->from($from);
								$this->email->to($email);
								$this->email->subject($subject);
								$this->email->message($message);
								if($row->msg_status == 0 || $row->msg_status == 1){
									$this->email->send();
									$this->common_model->updateFields(FRIENDS,array('msg_status'=>2),array('id'=>$row->friend_id));
								}
							}else{
								$this->common_model->updateFields(FRIENDS,array('msg_status'=>2),array('id'=>$row->friend_id));
							}
						}
						else if($row->type == 'accepted_job'){
							if($job_request_acceptance_notification == 1){
								$senderID = encoding($cuid);
								$receiverID = encoding($row->userid);

								$subject = 'Notfication for Job Request Acceptance';
								// $message = '';
								// $message .='<img src="'.base_url().'/assets/images/logomain.png"/>';
								// $message .= '
								// <p>Hi '.$username.'</p>
								// ';
								// $message .= '<br><br> '.$row->business_name." has accepted your job request.";
								// $message .= '<br><br><a href="'.base_url().'">click here to join Workadvisor</a> ';
								$message = '';
								$message .= $row->business_name." has accepted your job request.";
								$mailData = array();
								$mailData['message'] = $message;
								$mailData['username'] = $username;
								$message = $this->load->view('frontend/mailtemplate',$mailData,true);
								$this->email->from($from);
								$this->email->to($email);
								$this->email->subject($subject);
								$this->email->message($message);
								//if($row->msg_status == 0 || $row->msg_status == 1){
									$this->email->send();
									$this->common_model->updateFields(REQUESTS,array('msg_status'=>2,'confirmed'=>3),array('id'=>$row->requests_id));
								//}
							}else{
								$this->common_model->updateFields(REQUESTS,array('msg_status'=>2,'confirmed'=>3),array('id'=>$row->requests_id));
							}
						}
						else if($row->type == 'accepted_job_business'){
							if($job_request_acceptance_notification == 1){
								$senderID = encoding($row->userid);
								$receiverID = encoding($cuid);
								$subject = 'Notfication for Job Request Acceptance';
								$message = '';
								$message .= $row->firstname." ".$row->lastname." has accepted your job request.";
								$mailData = array();
								$mailData['message'] = $message;
								$mailData['username'] = $business_names;
								$message = $this->load->view('frontend/mailtemplate',$mailData,true);
								$this->email->from($from);
								$this->email->to($email);
								$this->email->subject($subject);
								$this->email->message($message);
								//if($row->msg_status == 0 || $row->msg_status == 1){
									$this->email->send();
									$this->common_model->updateFields(REQUESTS,array('msg_status'=>2,'confirmed_business'=>3),array('id'=>$row->requests_id));
								//}
							}else{
								$this->common_model->updateFields(REQUESTS,array('msg_status'=>2,'confirmed_business'=>3),array('id'=>$row->requests_id));
							}
						}

					}
				}
			}
		}
	}

	// public function test(){
	// 	$config = array();
	// 	$config['protocol'] = 'ssmtp';
	// 	$config['smtp_host'] = 'ssl://ssmtp.gmail.com';
	// 	$config['mailtype'] = 'html';
	// 	$config['newline'] = '\r\n';
	// 	$config['charset'] = 'utf-8';
	// 	$this->load->library('email', $config);
	// 	$this->email->initialize($config);
	// 	$subject = 'Notfication for Received Request';

	// 	$this->email->from('priyanka.pixlrit@gmail.com');
	// 	$this->email->to('priyanka.pixlrit@gmail.com');
	// 	$this->email->subject('test');
	// 	$this->email->message("hhhhhhh");
	// 	if($this->email->send()){
	// 		echo "yes";
	// 	}
	// }
}