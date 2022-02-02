<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
class Cron_new extends My_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('User_model');
	}

	public function index(){
		$from = "noreply@workadvisor.co";
		$notificationsAll = $this->common_model->getAllwhere('notifications');
		if(!empty($notificationsAll['result'])){
			foreach($notificationsAll['result'] as $rows){
				$senderDetails = $this->common_model->getsingle(USERS,array('id'=>$rows->sender));
				$receiverDetails = $this->common_model->getsingle(USERS,array('id'=>$rows->receiver));
				$email = $receiverDetails->email;
				$message = '';
				if($rows->msg!=''){
					if($rows->msg == 'friend_request_received'){
						$subject = 'Notfication for Received Request';
						$username = $receiverDetails->firstname." ".$receiverDetails->lastname;
						$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->firstname." ".$senderDetails->lastname."</a> sent you a friend request.";
					}else if($rows->msg == 'friend_request_accepted'){
						$subject = 'Notfication for Friend Request Acceptance';
						$username = $receiverDetails->firstname." ".$receiverDetails->lastname;
						$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->firstname." ".$senderDetails->lastname."</a> has accepted your friend request.";
					}
					else if($rows->msg == 'Job_req_by_employer'){
						$subject = 'Notfication for Job Request';
						$username = $receiverDetails->firstname." ".$receiverDetails->lastname;
						$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->business_name."</a> sent you a job request.";
					}
					else if($rows->msg == 'Job_req_by_performer'){
						$subject = 'Notfication for Job Request';
						$username = $receiverDetails->business_name;
						$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->firstname." ".$senderDetails->lastname."</a> sent you a job request.";
					}
					else if($rows->msg == 'Job_accepted_by_performer'){
						$subject = 'Notfication for Job Request Acceptance';
						$username = $receiverDetails->business_name;
						$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->firstname." ".$senderDetails->lastname."</a> has accepted your job request.";
					}
					else if($rows->msg == 'Job_accepted_by_employer'){
						$subject = 'Notfication for Job Request Acceptance';
						$username = $receiverDetails->firstname." ".$receiverDetails->lastname;
						$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->business_name."</a> has accepted your job request.";
					}
					else if($rows->msg == 'MSG'){
						$subject = 'Notfication for Message';
						if($receiverDetails->user_role == 'Employer' && $senderDetails->user_role == 'Employer'){
							$username = $receiverDetails->business_name;
							$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->business_name."<a> sent you a message<br><a href='".base_url()."user/message' type='button' style='background: #77d94f;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;'>Message</a>";
						}else if($receiverDetails->user_role == 'Performer' && $senderDetails->user_role == 'Performer'){
							$username = $receiverDetails->firstname." ".$receiverDetails->lastname;
							$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->firstname." ".$senderDetails->lastname."</a> sent you a message<br><a href='".base_url()."user/message' type='button' style='background: #77d94f;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;'>Message</a>";
						}else if($receiverDetails->user_role == 'Employer' && $senderDetails->user_role == 'Performer'){
							$username = $receiverDetails->business_name;
							$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->firstname." ".$senderDetails->lastname."</a> sent you a message<br><a href='".base_url()."user/message' type='button' style='background: #77d94f;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;'>Message</a>";
						}else if($receiverDetails->user_role == 'Performer' && $senderDetails->user_role == 'Employer'){
							$username = $receiverDetails->firstname." ".$receiverDetails->lastname;
							$message.= '<a href="'.base_url().'viewdetails/profile/'.encoding($senderDetails->id).'" target="_blank">'.$senderDetails->business_name."</a> sent you a message<br><a href='".base_url()."user/message' type='button' style='background: #77d94f;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;'>Message</a>";
						}
					}
					$config['protocol'] = 'ssmtp';
					$config['smtp_host'] = 'ssl://ssmtp.gmail.com';
					$config['mailtype'] = 'html';
					$config['newline'] = '\r\n';
					$config['charset'] = 'utf-8';
					$this->load->library('email', $config);
					$this->email->initialize($config);
					
					$mailData = array();
					$mailData['message'] = $message;
					$mailData['username'] = $username;
					$message = $this->load->view('frontend/mailtemplate',$mailData,true);
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