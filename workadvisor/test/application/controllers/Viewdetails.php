<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Viewdetails extends My_Controller {
	public function __construct(){
		parent::__construct();
		// $this->session->set_userdata('actual_link','');
	}

	public function profile($user_id = ''){
		$this->session->set_userdata('posts',array());
		$id = decoding($user_id);
		$this->session->set_userdata('rated_to_',$id);
		$lastData=$this->common_model->custom_query("SELECT `id` as last_ID from ".POSTS." WHERE post_status='0' AND user_id='$id'  ORDER BY id ASC LIMIT 1");
        if(!empty($lastData)){
			$data['last_ID']=$lastData[0]['last_ID'];
		}
		
		
		$data['user_data'] = $this->common_model->getsingle(USERS,array('id'=>$id));
		$userType = 'Employee';
		$userTypeData =  $this->common_model->getsingle(USERS,array('id'=>get_current_user_id()));
		if(isset($userTypeData->user_role) && $userTypeData->user_role==''){
			redirect('user/create_category');
		}
		$category=isset($data['user_data']->user_category)?$data['user_data']->user_category:'';
		$category=$data['user_data']->user_category;
		$data['category_det'] = $this->common_model->getsingle(CATEGORY,array('id'=>$category));
		$data['category_questions']=array();
		if($category!=""){
			if(isset($userTypeData->user_role) && $userTypeData->user_role == 'Performer'){
				$userType = 'Employee';
				$data['role'] = isset($userTypeData->user_role)?$userTypeData->user_role:'';
			}else if(isset($userTypeData->user_role) && $userTypeData->user_role == 'Employer'){
				$userType = 'Employer';
				$data['role'] = isset($userTypeData->user_role)?$userTypeData->user_role:'';
			}
			$data['category_questions'] = $this->common_model->get_two_table_data('category_questions.*',CATEGORY_QUESTIONS,CATEGORY,'category_questions.category_id = category.id',array('user_type'=>$userType,'category.id'=>$category),$groupby="");
			if(get_current_user_id()){
				$data['anonymous'] = $this->common_model->getsingle(RATINGS,array('rated_by_user'=>get_current_user_id(),'rated_to_user'=>$id));
			}
		}
		if(isset($data['user_data']->user_role) && $data['user_data']->user_role == 'Performer'){

			$workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$id,'status'=>1),'id','DESC','all',1);
			if(!empty($workingAt['result'])){
				$compId=$workingAt['result'][0]->receiver;
				$data['workingAt'] = get_where('tb_users',array('id'=>$compId),'row');
			}else{
				$data['workingAt']=array();
			}
		}

		$this->common_model->updateFields(POSTS,array('repeat_status'=>0),array('user_id'=>$id));

		$data['posts_details'] = $this->common_model->getAllwhere(POSTS,array('user_id'=>$id,'post_status'=>0,'repeat_status'=>0), 'id', 'DESC','all',2,0,$group_by='',$and_where = '');
		if(!empty($data['posts_details']['result'])){
			foreach($data['posts_details']['result'] as $row1){
				$this->common_model->updateFields(POSTS,array('repeat_status'=>1),array('id'=>$row1->id));
			}
		}
		$data['isfriend']='No';
		if($this->checkUserLogin()){
			$user_one = get_current_user_id();
			if($user_one==$id){
				redirect(site_url('profile'));
			}

			$user_two =$id;
			$condition="(`user_one_id` ='$user_one' AND `user_two_id` = '$user_two') OR (`user_one_id` = '$user_two' AND `user_two_id` = '$user_one')";
			$checkFriend = $this->common_model->getsingle(FRIENDS,$condition);
			$data['isfriend']=0;
			if(!empty($checkFriend)){
				$req_status=$checkFriend->status;
				if($req_status==0){
					if($checkFriend->user_two_id==$user_one){
						$data['isfriend']='NotConfirm';  
					}else{
						$data['isfriend']='Pending'; 
					} 
				}else if($req_status==1){
					$data['isfriend']='Accepted'; 
				}else{
					$data['isfriend']='Other';  
				}
			}
			$con="((sender='$user_one' AND receiver='$id') OR (sender='$id' AND receiver='$user_one')) AND NOT find_in_set(".get_current_user_id().",deleted_by)";
			$data['conversation'] = $this->common_model->getAllwhere(MESSAGES,$con,'id','DESC','all',5,0,$group_by='',$and_where = '');
			$data['personal_data'] = $this->common_model->getsingle(USERS,array('id'=>$user_one));
		}
		$info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country','tb_users.user_role','tb_users.business_name');
		if(!empty($data['user_data'])){
			if($data['user_data']->user_role == 'Employer'){
				$relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
				$condition2="(requests.receiver='$id' OR requests.sender='$id') AND requests.status=1 AND tb_users.id!='$id' AND tb_users.user_role!='Employer'";
				$data['allFriends'] = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");
			}
			else{
				$relation2="tb_users.id=friends.user_one_id OR tb_users.id=friends.user_two_id";
				$condition2="(friends.user_two_id='$id' OR friends.user_one_id='$id') AND friends.status=1 AND tb_users.id!='$id' ";
//$data['allFriends'] = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation2,$condition2,$groupby="");
				$allFriends = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation2,$condition2,$groupby="");
				$relation2="tb_users.id=requests.receiver";
				$condition2="(requests.sender='$id') AND requests.status=1 AND tb_users.id!='$id' ";
// $allFriendsCompany = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");
				$allFriendsCompany = array();
				if(!empty($allFriendsCompany) && !empty($allFriends)){
					$data['allFriends'] = array_merge($allFriends,$allFriendsCompany);
				}else if(!empty($allFriends)){
					$data['allFriends'] = $allFriends;
				}else if(!empty($allFriendsCompany)){
					$data['allFriends'] = $allFriendsCompany;
				}

			}
		}

		$relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
// $condition2="(requests.receiver='$id' OR requests.sender='$id') AND requests.status=1 AND tb_users.id!='$id' ";
		$condition2="(requests.sender='$id') AND requests.status=1 AND tb_users.id!='$id' ";
		$data['workingAt1'] = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");

//******************//
//*******************//
		$inform=array('ratings.company_id','tb_users.business_name');
		$compRatdata=$this->common_model->get_two_table_data($inform,RATINGS,USERS,'ratings.company_id=tb_users.id',array('ratings.rated_to_user'=>$id),"ratings.company_id");
		/************************/

		$datacomps = $this->common_model->getAllwhere(POSTS,array('user_id'=>$id,'post_status'=>0), 'id', 'DESC','all','','',$group_by='company',$and_where = '');

		if(!empty($datacomps['result'])){
			foreach($datacomps ['result'] as $compss){
				$company_ids=$compss->company;
				if($company_ids==0){
					$company_name=isset($data['category_det']->name)?$data['category_det']->name:'';
				}else{
					$companyDTL =$this->common_model->getsingle(USERS,array('id'=>$company_ids));
					$company_name=isset($companyDTL->business_name)?$companyDTL->business_name:'';
				}

				$postbycomp = $this->common_model->getAllwhere(POSTS,array('user_id'=>$id,'post_status'=>0,'company'=>$company_ids), 'id', 'DESC','all','','',$group_by='',$and_where = ''); 

				$data['postbycompany'][$company_name]= $postbycomp;
			}
		}

		$indivReview=array();
		foreach($compRatdata as $com){
			$companyId=$com['company_id'];
			$business_name=$com['business_name'];
			$ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$id,'company_id'=>$companyId));
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
					$givername=isset($cusers->firstname) ? $cusers->firstname : "" ;
					$profile=isset($cusers->profile) ? $cusers->profile : "" ;
					$city=isset($cusers->city) ? $cusers->city : "" ;
					$state=isset($cusers->state) ? $cusers->state : "" ;
					$country=isset($cusers->country) ? $cusers->country : "";

					if($row->ques_1){
						$ques1+= $row->ques_1;
					}
					if($row->ques_2){
						$ques2+= $row->ques_2;
					}
					if($row->ques_3){
						$ques3+= $row->ques_3;
					}
					if($row->ques_4){
						$ques4+= $row->ques_4;
					}
					if($row->ques_5){
						$ques5+= $row->ques_5;
					}

					$history = array();
					if($ques1!=0){
						$ques = $ques1/$reviewcounter;
						$history[0] = $ques;
						$ques_[0] = starRating($ques);
					}
					else
						$ques_[0] = starRating(0);


					if($ques2!=0){
						$ques = $ques2/$reviewcounter;
						$history[1] = $ques;
						$ques_[1] = starRating($ques);
					}
					else
						$ques_[1] = starRating(0);

					if($ques3!=0){
						$ques = $ques3/$reviewcounter;
						$history[2] = $ques;
						$ques_[2] = starRating($ques);
					}
					else
						$ques_[2] = starRating(0);

					if($ques4!=0){
						$ques = $ques4/$reviewcounter;
						$history[3] = $ques;
						$ques_[3] = starRating($ques);
					}
					else
						$ques_[3] = starRating(0);

					if($ques5!=0){
						$ques = $ques5/$reviewcounter;
						$history[4] = $ques;
						$ques_[4] = starRating($ques);
					}
					else{
						$ques_[4] = starRating(0);
					}
					$ques_['message']=$row->message;
					$ques_['company_id']=$companyId;
					$ques_['retedbyid']=$row->rated_by_user;
					$ques_['givername']=$givername;
					$ques_['profile']=$profile;
					$ques_['address']=$city.','.$state.','.$country;
					$indivReview[$business_name][]= $ques_;
				}

			} else{
				for($i=0;$i<=5;$i++){
					$ques_[$i] = starRating(0);
				}
				$indivReview[$business_name]['historyRating'][]= $ques_;
			}
		}
		$data['MyhistoryRating'] = $indivReview;
//code for overall rating
//******************//

//code for overall rating
		$data['ratingDetails'] = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$id));
		$data['reviewCount'] = $data['ratingDetails']['total_count'];
		if(!empty($data['ratingDetails']['result'])){
			$ratingAverage=0;
			$reviewCount  = $data['ratingDetails']['total_count'];
			foreach($data['ratingDetails']['result'] as $row){
				$average = 0;
				$total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
				if($total>0){
					$average = $total/5;
				}
				$ratingAverage+=$average;
			}
			if($ratingAverage>0)
$data['ratingAverage'] = $ratingAverage/$reviewCount;//average ratings of all users
else
	$data['ratingAverage'] = 0;
$data['starRating'] = starRating($data['ratingAverage'],$data['reviewCount']);

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

//code for questionwise rating in history
$ques1 = 0;
$ques2 = 0;
$ques3 = 0;
$ques4 = 0;
$ques5 = 0;
$ques = array();
foreach($data['ratingDetails']['result'] as $row){
	if($row->ques_1){
		$ques1+= $row->ques_1;
	}
	if($row->ques_2){
		$ques2+= $row->ques_2;
	}
	if($row->ques_3){
		$ques3+= $row->ques_3;
	}
	if($row->ques_4){
		$ques4+= $row->ques_4;
	}
	if($row->ques_5){
		$ques5+= $row->ques_5;
	}

	$history = array();
	if($ques1!=0){
		$ques = $ques1/$reviewCount;
		$history[0] = $ques;
		$ques_[0] = starRating($ques);
	}
	else
		$ques_[0] = starRating(0);


	if($ques2!=0){
		$ques = $ques2/$reviewCount;
		$history[1] = $ques;
		$ques_[1] = starRating($ques);
	}
	else
		$ques_[1] = starRating(0);

	if($ques3!=0){
		$ques = $ques3/$reviewCount;
		$history[2] = $ques;
		$ques_[2] = starRating($ques);
	}
	else
		$ques_[2] = starRating(0);

	if($ques4!=0){
		$ques = $ques4/$reviewCount;
		$history[3] = $ques;
		$ques_[3] = starRating($ques);
	}
	else
		$ques_[3] = starRating(0);

	if($ques5!=0){
		$ques = $ques5/$reviewCount;
		$history[4] = $ques;
		$ques_[4] = starRating($ques);
	}
	else
		$ques_[4] = starRating(0);
}
$data['historyRating'] = $ques_;
$data['historyReviewsRating'] = $history;
}else{
	for($i=0;$i<=5;$i++){
		$ques_[$i] = starRating(0);
	}
	$data['historyRating'] = $ques_;
	$data['starRating'] = starRating(0,0);
}
//Rank section
$userInfo = $this->common_model->getsingle(USERS,array('id'=>$id));
$category = $userInfo->user_category;
$data['userRankRatings'] = $this->common_model->get_two_table_data('tb_users.*,count(ratings.id) as review_count',USERS,RATINGS,'tb_users.id = ratings.rated_to_user',array('tb_users.user_category'=>$category,'user_role!='=>'Employer'),'rated_to_user','review_count',"DESC");
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
			$starRating = starRating($ratingAverage,$rating['review_count']);

		}
		else{
			$ratingAverage = 0;
			$starRating = starRating($ratingAverage,0);
		}
		$data['userRankRatings'][$key]['star_rating'] = $starRating;
		$data['userRankRatings'][$key]['rank'] = $count;
	}
}
$data['other_user_id'] = $id;
$percentarray = array();
//performance calculation
if(!empty($data['ratingDetails']['result'])){
	$percent_cnt1 = 0;
	$percent_cnt2 = 0;
	$percent_cnt3 = 0;
	$percent_cnt4 = 0;
	$percent_cnt5 = 0;
	$percentarray = array();
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
//QR code generate
$data['img_url']="";
$this->load->library('ciqrcode');
$qr_image=rand().'.png';
// $params['data'] = $userInfo->email;
$params['data'] = base_url().'viewdetails/profile/'.$user_id."?review=1";
$params['level'] = 'H';
$params['size'] = 5;
$params['savename'] =FCPATH."qr_code/".$qr_image;
if($this->ciqrcode->generate($params))
{
	$data['qr_image']=base_url().'qr_code/'.$qr_image; 
}
$data['uname'] = $userInfo->firstname." ".$userInfo->lastname;
$data['uemail'] = $userInfo->email;
// $data['albumData']=$this->common_model->getAllwhere(ALBUMS,array('user_id'=>$id,'view_type!='=>2));
$albumData = $this->common_model->getAllwhere(ALBUMS,array('user_id'=>$id,'folder_id'=>0));
$employees = $this->common_model->getAllwhere(REQUESTS,array('receiver'=>$id));
$companyEmployees = array();

if(!empty($employees['result'])){
	foreach($employees['result'] as $row){
		$companyEmployees[] = $row->sender;
	}
}

if(!empty($albumData['result'])){
	$count = 0;
	$data['albumData'] = array();
	foreach($albumData['result'] as $row){
		if($row->view_type == 1 || ($row->view_type == 3 && in_array(get_current_user_id(),$companyEmployees))){
			$data['albumData']['result'][$count] = new stdClass();
			$data['albumData']['result'][$count]->id = $row->id;
			$data['albumData']['result'][$count]->name = $row->name;
			$data['albumData']['result'][$count]->albums = $row->albums;
			$data['albumData']['result'][$count]->view_type = $row->view_type;
			$count++;
		}
	}
}
$albumFolderData = $this->common_model->getAllwhere(ALBUM_DIR,array('user_id'=>$id,'dir_parent'=>0));
if(!empty($albumFolderData['result'])){
	$count = 0;
	$data['albumFolderData'] = array();
	foreach($albumFolderData['result'] as $row){
		if($row->dir_view_type == 1 || ($row->dir_view_type == 3 && in_array(get_current_user_id(),$companyEmployees))){
			$data['albumFolderData']['result'][$count] = new stdClass();
			$data['albumFolderData']['result'][$count]->id = $row->id;
			$data['albumFolderData']['result'][$count]->dir_name = $row->dir_name;
			$count++;
		}
	}
}
$this->pageview('other_user_profile',$data,$data,array()); 
}

public function reportProfile(){
	if($this->checkUserLogin()){
		$userData = $this->session->userdata();
		$uemail = $userData['userData']['email'];
		$reportingBy = $userData['userData']['firstname']." ".$userData['userData']['lastname'];
		$reportingTo = $this->input->post('name');
		$reported_by_user = get_current_user_id();
		$reported_to_user = $this->input->post('userID');
		$adminData = $this->common_model->getsingle(ADMIN,array('id'=>1));
		if(!empty($adminData)){
			$email = $adminData->mail_to;
			//$email ="priyanka.pixlrit@gmail.com";
			$from = "reportprofile@workadvisor.co";    
			$subject = 'Report Profile';  
			$message = '';
			$message .= 'User <a href="'.base_url().'viewdetails/profile/'.encoding($reported_by_user).'">'.ucfirst($reportingBy).'</a> has reported the profile of <a href="'.base_url().'viewdetails/profile/'.encoding($reported_to_user).'">'.$reportingTo.'</a>.';
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
				echo json_encode(array('status'=>1));
			}
		}else{
			echo json_encode(array('status'=>0));
		}
	}else{
		echo json_encode(array('status'=>'Failed','msg'=>'Login first'));
	}
}
}