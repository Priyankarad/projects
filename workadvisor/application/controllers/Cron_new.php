<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
class Cron_new extends My_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('User_model');
	}

	public function index(){
		$from = "noreply@WorkAdvisor.co";
		$notificationsAll = $this->common_model->getAllwhere('notifications');
		if(!empty($notificationsAll['result'])){
			foreach($notificationsAll['result'] as $rows){
				$senderDetails = $this->common_model->getsingle(USERS,array('id'=>$rows->sender));
				$receiverDetails = $this->common_model->getsingle(USERS,array('id'=>$rows->receiver));
				$email = $receiverDetails->email;
				$message = '';
				if($rows->msg!=''){
					if($rows->msg == 'friend_request_received'){
						$subject = 'Friend Request';
						$username = ucfirst($receiverDetails->firstname)." ".ucfirst($receiverDetails->lastname);
						//$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->firstname." ".$senderDetails->lastname."</a> sent you a friend request.";
						$message.='Making friends already! You received a friend request from '.ucfirst($senderDetails->firstname)." ".ucfirst($senderDetails->lastname).' on WorkAdvisor.co.<p><a href="'.base_url().'user/accept_job/emp" type="button" style="background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;font-size: 15px;"> + Accept Friend Request </a></p>';

					}
					else if($rows->msg == 'LIKE'){
						$subject = 'Notfication for Post Like';
						if($receiverDetails->business_name!=''){
							$username = ucfirst($receiverDetails->business_name);
						}else{
							$username = ucfirst($receiverDetails->firstname)." ".ucfirst($receiverDetails->lastname);
						}

						if($senderDetails->business_name!=''){
							$senderUsername = ucfirst($senderDetails->business_name);
						}else{
							$senderUsername = ucfirst($senderDetails->firstname)." ".ucfirst($senderDetails->lastname);
						}

						$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderUsername."</a> liked your post.";

					}
					else if($rows->msg == 'friend_request_accepted'){
						$subject = 'Notfication for Friend Request Acceptance';
						$username = ucfirst($receiverDetails->firstname)." ".ucfirst($receiverDetails->lastname);
						$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.ucfirst($senderDetails->firstname)." ".ucfirst($senderDetails->lastname)."</a> has accepted your friend request.";
					}
					else if($rows->msg == 'Job_req_by_employer'){
						$subject = 'Job Request';
						$username = ucfirst($receiverDetails->firstname)." ".ucfirst($receiverDetails->lastname);
						//$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->business_name."</a> sent you a job request.";
						$message.='Awesome! You received a job request from '.ucfirst($senderDetails->firstname)." ".ucfirst($senderDetails->lastname).' on WorkAdvisor.co.<p><a href="'.base_url().'user/accept_job/emp" type="button" style="background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;font-size: 15px;"> + Accept Job Request </a></p>';
					}
					else if($rows->msg == 'Job_req_by_performer'){
						$subject = 'Notfication for Job Request';
						$username = ucwords($receiverDetails->business_name);
						//$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->firstname." ".$senderDetails->lastname."</a> sent you a job request.";
						$message.='Awesome! You received a job request from '.ucfirst($senderDetails->firstname)." ".ucfirst($senderDetails->lastname).' on WorkAdvisor.co.<p><a href="'.base_url().'user/accept_job/per" type="button" style="background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;font-size: 15px;"> + Accept Job Request </a></p>';
					}
					else if($rows->msg == 'Job_accepted_by_performer'){
						$subject = 'Notfication for Job Request Acceptance';
						$username = ucwords($receiverDetails->business_name);
						$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.ucfirst($senderDetails->firstname)." ".ucfirst($senderDetails->lastname)."</a> has accepted your job request.";
					}
					else if($rows->msg == 'Job_accepted_by_employer'){
						$subject = 'Notfication for Job Request Acceptance';
						$username = ucfirst($receiverDetails->firstname)." ".ucfirst($receiverDetails->lastname);
						$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.ucwords($senderDetails->business_name)."</a> has accepted your job request.";
					}
					else if($rows->msg == 'MSG'){
						if(($rows->is_group == 1) && $rows->group_id){
							$group_id = $rows->group_id;
							$groupData = $this->common_model->getsingle(MESSAGE_GROUP,array('id'=>$group_id));
							$msgData = " sent a message in ".ucfirst($groupData->name); 
						}else{
							$msgData = " sent you a message"; 
						}
						$subject = 'Message on WorkAdvisor';
						if(($receiverDetails->user_role == 'Employer') && ($senderDetails->user_role == 'Employer')){
							$username = ucwords($receiverDetails->business_name);
							//$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->business_name."</a>".$msgData."<br><a href='".base_url()."user/message' type='button' style='background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;'>Message</a>";

							$message.='Hey '.($username).'! <a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.ucwords($senderDetails->business_name).'</a> sent you a message on WorkAdvisor.co. <p><a href="'.base_url().'user/message" type="button" style="background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;font-size: 15px;">Message</a></p>';

						}else if(($receiverDetails->user_role == 'Performer') && ($senderDetails->user_role == 'Performer')){
							$username = ucfirst($receiverDetails->firstname)." ".ucfirst($receiverDetails->lastname);
							//$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->firstname." ".$senderDetails->lastname."</a>".$msgData."<br><a href='".base_url()."user/message' type='button' style='background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;'>Message</a>";

							$message.='Hey '.$username.'! <a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.ucfirst($senderDetails->firstname)." ".ucfirst($senderDetails->lastname).'</a> sent you a message on WorkAdvisor.co. <p><a href="'.base_url().'user/message" type="button" style="background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;font-size: 15px;">Message</a></p>';

						}else if(($receiverDetails->user_role == 'Employer') && ($senderDetails->user_role == 'Performer')){
							$username = ucwords($receiverDetails->business_name);
							//$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->firstname." ".$senderDetails->lastname."</a>".$msgData."<br><a href='".base_url()."user/message' type='button' style='background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;'>Message</a>";
							$message.='Hey '.$username.'! <a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.ucfirst($senderDetails->firstname)." ".ucfirst($senderDetails->lastname).'</a> sent you a message on WorkAdvisor.co. <p><a href="'.base_url().'user/message" type="button" style="background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;font-size: 15px;">Message</a></p>';

						}else if(($receiverDetails->user_role == 'Performer') && ($senderDetails->user_role == 'Employer')){
							$username = ucfirst($receiverDetails->firstname)." ".ucfirst($receiverDetails->lastname);
							//$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->business_name."</a>".$msgData."<br><a href='".base_url()."user/message' type='button' style='background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;'>Message</a>";
							$message.='Hey '.$username.'! <a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.ucwords($senderDetails->business_name).'</a> sent you a message on WorkAdvisor.co. <p><a href="'.base_url().'user/message" type="button" style="background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;font-size: 15px;">Message</a></p>';
						}
					}
					$config['protocol'] = 'ssmtp';
					$config['smtp_host'] = 'ssl://ssmtp.gmail.com';
					$config['mailtype'] = 'html';
					$config['newline'] = '\r\n';
					$config['charset'] = 'utf-8';
					$this->load->library('email', $config);
					$this->email->initialize($config);
					//$email= 'priyanka.pixlrit@gmail.com';
					$mailData = array();
					$mailData['message'] = $message;
					$mailData['username'] = $username;
					$message = $this->load->view('frontend/mail_temp',$mailData,true);
					$this->email->set_header('From', $from);
					$this->email->from($from);
					$this->email->to($email);
					$this->email->subject($subject);
					$this->email->message($message);
					if($this->email->send()){
						$this->common_model->deleteData('notifications',array('id'=>$rows->id));
					}
				}
			}
		}
	}
}