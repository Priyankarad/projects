<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends MY_Controller {
	function __construct() {
		 //ob_start();
        parent::__construct();
        $this->load->config('linkedin');
    }
	public function index(){
		if(isset($_GET['code'])){
			$this->googleplus->getAuthenticate();
			$gpInfo = $this->googleplus->getUserInfo();
			$userData['type'] = 'google';
			$userData['oauth_uid']      = $gpInfo['id'];
			$userData['firstname']     = $gpInfo['given_name'];
			$userData['lastname']      = $gpInfo['family_name'];
			$userData['email']          = (!empty($gpInfo['email']) && isset($gpInfo['email']))?$gpInfo['email']:'';
			$userData['gender']         = (!empty($gpInfo['gender']) && isset($gpInfo['gender']))?$gpInfo['gender']:'';
			$userData['lang']         = (!empty($gpInfo['locale']) && isset($gpInfo['locale']))?$gpInfo['locale']:'';
			$userData['profile_url']    = !empty($gpInfo['link'])?$gpInfo['link']:'';
			$userData['profile']    = !empty($gpInfo['picture'] && (checkRemoteFile($gpInfo['picture'])))?$gpInfo['picture']:'assets/images/default_image.jpg';
			$userData['status']='verify';
			$userData['active']='1';
			$userInfo = getSingleRecord(USERS,array('email'=>$userData['email']));
			if(!empty($userInfo)){
				if($userInfo->type == 'google'){
					$userData['profile'] = !empty($userInfo->profile && (checkRemoteFile($userInfo->profile)))?$userInfo->profile:'assets/images/default_image.jpg';
				}else{
					$this->session->set_flashdata('registermsg','
						<div class="alert alert-danger text-center">Oops!.  you are also registered please login here!!!</div>
						');
					redirect('register');
				}
			}
			$userID = $this->common_model->checkUser($userData);
			if($userID=="Profile Deleted"){
			 $this->session->set_flashdata('loginmsg','<div class="alert alert-danger text-center"> Your account has been deactivated. Contact To admin. </div>');
		     redirect(base_url('login'));
             exit;			 
			}
			$this->session->set_userdata('loggedIn', true);
			$this->session->set_userdata('userData', $userData);
			// echo $this->session->userdata('message_link');die;
			if($this->session->userdata('message_link') && !empty($this->session->userdata('message_link'))){
				redirect($this->session->userdata('message_link'));
			}else{

				if($this->session->userdata('actual_link') && !empty($this->session->userdata('actual_link'))){
					redirect($this->session->userdata('actual_link')."?review=1");
				}else{
					$this->session->set_userdata('posts',array());
					redirect(base_url('profile'));
				}
			}
		}
/************************************
if($this->facebook->is_authenticated()){
$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
// Preparing data for database insertion
$userData['type'] = 'facebook';
$userData['oauth_uid'] = $userProfile['id'];
$userData['firstname'] = $userProfile['first_name'];
$userData['lastname'] = $userProfile['last_name'];
$userData['email'] = $userProfile['email'];
$userData['gender'] = $userProfile['gender'];
$userData['lang'] = $userProfile['locale'];
$userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
$userData['profile'] = $userProfile['picture']['data']['url'];
$profile1="https://graph.facebook.com/".$userProfile['id']."/picture?type=large";
$userData['profile'] = $profile1;
$userData['status']='verify';
$userID = $this->common_model->checkUser($userData);
if(!empty($userID)){
$this->session->set_userdata('loggedIn', true);
$data['userData'] = $userData;
$this->session->set_userdata('userData',$userData);
}else{
$data['userData'] = array();
}
$userData['logoutUrl'] = $this->facebook->logout_url();
redirect(base_url('profile'));
}else{
$fbuser = '';
$headerdata['authUrl'] = $this->facebook->login_url(); 
}
****/
//Top 6 performers based on Reviews
$data['userRankRatings'] = $this->common_model->get_two_table_data('tb_users.*,count(ratings.id) as review_count',USERS,RATINGS,'tb_users.id = ratings.rated_to_user',array('user_role!='=>'Employer'),'rated_to_user','review_count',"DESC");
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

		$workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$rating['id'],'status'=>1),'id','DESC','all',1);
        if(!empty($workingAt['result'])){
            $compId=$workingAt['result'][0]->receiver;
            $workingData = get_where('tb_users',array('id'=>$compId),'row');
            if(!empty($workingData)){
            	$data['userRankRatings'][$key]['workingAt'] = $workingData->business_name;
            	$data['userRankRatings'][$key]['workingAt_id'] = $workingData->id;
            }
        }else{
            $data['userRankRatings'][$key]['workingAt'] = array();
        }
	}
}
// pr($data['userRankRatings']);
$data['seo'] = 'home';
$data['sliders'] =  $this->common_model->getAllwhere(SLIDERS,array("1"=>1));
$this->load->view('frontend/template/header',$data);
$data['performer_data'] = $this->common_model->getAllwhere(USERS,array('status'=>'verify','user_role'=>'Performer','active'=>1),'id','DESC','','6');
if(!empty($data['performer_data']['result'])){
	$count = 0;
	foreach ($data['performer_data']['result'] as $row) {
		$ratingData =  userOverallRatings($row->id);
		if(isset($ratingData['ratingAverage']))
			$data['performer_data']['result'][$count]->ratingAverage = $ratingData['ratingAverage'];
		else
			$data['performer_data']['result'][$count]->ratingAverage = 0;
		$data['performer_data']['result'][$count]->reviewCount = $ratingData['reviewCount'];
		$data['performer_data']['result'][$count]->starRating = $ratingData['starRating'];
		$count++;
	}
}


$data['category_data'] = $this->common_model->get_two_table_data('category.*,count(tb_users.id) as cat,tb_users.user_category',CATEGORY,USERS,'category.id= tb_users.user_category',array('category_status'=>'1'),'tb_users.user_category',"cat",'desc');

$this->load->view('frontend/frontpage',$data);
$this->load->view('frontend/template/footer');
}
public function fbauth(){
	if($this->facebook->is_authenticated()){
		if(isset($_GET['error'])){
			redirect(base_url());
		}
		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
		$userData['type'] = 'facebook';
		$userData['oauth_uid'] = $userProfile['id'];
		$userData['firstname'] = $userProfile['first_name'];
		$userData['lastname'] = $userProfile['last_name'];
		$userData['email'] = (!empty($userProfile['email']) && isset($userProfile['email']))?$userProfile['email']:'';
		$userData['gender'] = (!empty($userProfile['gender']) && isset($userProfile['gender']))?$userProfile['gender']:'';
		$userData['lang'] = (!empty($userProfile['locale']) && isset($userProfile['locale']))?$userProfile['locale']:'';
		$userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
		$userData['profile'] = $userProfile['picture']['data']['url'];
		$profile1="https://graph.facebook.com/".$userProfile['id']."/picture?type=large";
		$userData['profile'] = $profile1;
		$userData['status']='verify';
		//$userInfo = getSingleRecord(USERS,array('email'=>$userData['email']));
		$userInfo = getSingleRecord(USERS,array('oauth_uid'=>$userData['oauth_uid']));
		if(!empty($userInfo)){
			if($userInfo->type == 'facebook'){
				$userData['profile'] = $userInfo->profile;
			}else{
				$this->session->set_flashdata('registermsg','
					<div class="alert alert-danger text-center">Oops!.  you are also registered please login here!!!</div>
					');
				redirect('register');
			}
		}else{
			$userInfo = getSingleRecord(USERS,array('email'=>$userData['email']));
			if(!empty($userInfo)){
				if($userInfo->type == 'facebook'){
					$userData['profile'] = $userInfo->profile;
				}else{
					$this->session->set_flashdata('registermsg','
						<div class="alert alert-danger text-center">Oops!.  you are also registered please login here!!!</div>
						');
					redirect('register');
				}
			}
		}
		$userID = $this->common_model->checkUser($userData);
		if($userID=="Profile Deleted"){
			 $this->session->set_flashdata('loginmsg','<div class="alert alert-danger text-center"> Your account has been deactivated. Contact To admin. </div>');
		     redirect(base_url('login'));
             exit;			 
			}
		if(!empty($userID)){
			$this->session->set_userdata('loggedIn', true);
			$this->session->set_userdata('userData',$userData);
		}else{
			$data['userData'] = array();
		}
// Get logout URL
		$headerdata['logoutUrl'] = $this->facebook->logout_url();
		if($this->session->userdata('message_link') && !empty($this->session->userdata('message_link'))){
			redirect($this->session->userdata('message_link'));
		}else{

			if($this->session->userdata('actual_link') && !empty($this->session->userdata('actual_link'))){
				redirect($this->session->userdata('actual_link')."?review=1");
			}else{
				$this->session->set_userdata('posts',array());
				redirect(base_url('profile'));
			}
		}
	}else{
		$fbuser = '';
// Get login URL
		$headerdata['authUrl'] = $this->facebook->login_url(); 
	}

	$data['authUrl'] = $this->facebook->login_url();
	$data['loginURL'] = $this->googleplus->loginURL();
	$this->frontendtemplates('login',$data);
}
/****************************/
public function autofill(){
	$mresults=array();
	$arresults=array();
	if(isset($_POST['query']) || isset($_GET['query'])){
		if(isset($_POST['query']) && $_POST['query'])
			$tag=$_POST['query'];
		else
			$tag=$_GET['query'];
		$query=" select group_concat(distinct trim(substring_index(substring_index(`professional_skill`, ',', n.n), ',', -1)) separator ',' ) as `professional_skill`  from tb_users t cross join (select 1 as n union all select 2 ) n order by `professional_skill`";
		$result = $this->common_model->custom_query($query);
		$Allcategory = $this->common_model->getAllwhere(CATEGORY,"`category_status`=1 AND name LIKE '%$tag%' ", 'id', 'DESC','all','','','','');
		if(!empty($Allcategory['result'])){
			$catssdr=$Allcategory['result'];
			foreach($catssdr as $ca){
				$mresults[]=$ca->name;
			}
		}
		$nou="";
		$datausr= $this->common_model->getAllwhere(USERS,"(firstname LIKE '%$tag%' OR business_name LIKE '%$tag%' OR lastname LIKE '%$tag%' OR CONCAT(firstname, ' ', lastname) like '%$tag%')  AND active='1' ", 'id', 'DESC','all','','','','');
		$count = 0;
		if(!empty($datausr['result'])){ foreach($datausr['result'] as $usr){
			if($usr->user_role=='Employer' && $usr->user_role!=""){
				$count++;
				$nou.= '<li class="tgli"><a href="'.base_url().'viewdetails/profile/'.encoding($usr->id).'" target="_blank">'.$usr->business_name.'</a></li>';
			}else{
				$count++;
				$nou.= '<li class="tgli"><a href="'.base_url().'viewdetails/profile/'.encoding($usr->id).'" target="_blank">'.$usr->firstname.' '.$usr->lastname.'</a></li>';
			}
		}	
	}
	// lq();
	if(!empty($result)){
		$allTags=$result[0]['professional_skill'];
		$alltag=explode(',',$allTags);
		$arresults=array_merge($alltag,$mresults);	
		$output = '<ul class="list-unstyled">';  
		foreach($arresults as $val){
			if(stristr($val,$tag)){
				$count++;
				$output .= '<li class="tgli">'.$val.'</li>';
			}
		}
		if($count==0){
			$output .= '<li class="tgli">No Data Matched</li>';
		}
		$output .=$nou;
		$output .= '</ul>';
	}else{  
		$output .= '<li class="tgli">No Data Matched</li>';  
	}
	echo $output;

}else{
	echo json_encode("No Result Found");
}
}
/******************************/

public function linkedinAuth(){
	$userData = array();        
	include_once APPPATH."libraries/linkedin-oauth-client/http.php";
	include_once APPPATH."libraries/linkedin-oauth-client/oauth_client.php";
	$oauthStatus = $this->session->userdata('oauth_status');
	$sessUserData = $this->session->userdata('userData');

	if(isset($oauthStatus) && $oauthStatus == 'verified'){
		$userData = $sessUserData;
	}elseif(1){
		$client = new oauth_client_class;
		$client->client_id = $this->config->item('linkedin_api_key');
		$client->client_secret = $this->config->item('linkedin_api_secret');
		$client->redirect_uri = base_url().$this->config->item('linkedin_redirect_url');
		$client->scope = $this->config->item('linkedin_scope');
		$client->debug = false;
		$client->debug_http = true;
		$application_line = __LINE__;
		if($success = $client->Initialize()){
			if(($success = $client->Process())){
				if(strlen($client->authorization_error)){
					$client->error = $client->authorization_error;
					$success = false;
				}elseif(strlen($client->access_token)){
					$success = $client->CallAPI('http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name)', 
						'GET',
						array('format'=>'json'),
						array('FailOnAccessError'=>true), $userInfo);
				}
			}
			$success = $client->Finalize($success);
		}

		if($client->exit) exit;

		if($success){
			$first_name = !empty($userInfo->firstName)?$userInfo->firstName:'';
			$last_name = !empty($userInfo->lastName)?$userInfo->lastName:'';
			$userData = array(
				'type'=> 'linkedin',
				'oauth_uid'     => $userInfo->id,
				'firstname'     => $first_name,
				'lastname'     => $last_name,
				'email'         => $userInfo->emailAddress,
				'profile_url'     => $userInfo->pictureUrl,
				'profile' => $userInfo->pictureUrl,
				'status' => 'verify'
			);
	 $userInfo = getSingleRecord(USERS,array('email'=>$userData['email']));
		if(!empty($userInfo)){
			$userData['profile'] = $userInfo->profile;
		}
		$userID = $this->common_model->checkUser($userData);
		if($userID=="Profile Deleted"){
			 $this->session->set_flashdata('loginmsg','<div class="alert alert-danger text-center"> Your account has been deactivated. Contact To admin. </div>');
		     redirect(base_url('login'));
             exit;			 
			}
			if(!empty($userID)){
			$this->session->set_userdata('loggedIn', true);
			$this->session->set_userdata('userData',$userData);
		}else{
			$data['userData'] = array();
		}

		if($this->session->userdata('message_link') && !empty($this->session->userdata('message_link'))){
			redirect($this->session->userdata('message_link'));
		}else{

			if($this->session->userdata('actual_link') && !empty($this->session->userdata('actual_link'))){
				redirect($this->session->userdata('actual_link')."?review=1");
			}else{
				$this->session->set_userdata('posts',array());
				redirect(base_url('profile'));
			}
		}

		}else{
			$data['error_msg'] = 'Some problem occurred, please try again later!';
		}
	}elseif(isset($_REQUEST["oauth_problem"]) && $_REQUEST["oauth_problem"] <> ""){
		$data['error_msg'] = $_GET["oauth_problem"];
	}else{
		$data['oauthURL'] = base_url().$this->config->item('linkedin_redirect_url').'?oauth_init=1';
	}

	$data['oauthURL'] = base_url().$this->config->item('linkedin_redirect_url').'?oauth_init=1';
	$data['authUrl'] = $this->facebook->login_url();
	$data['loginURL'] = $this->googleplus->loginURL();
	$this->frontendtemplates('login',$data);
}
/***************************/
/***************************/
/********-TEST-ALERT-*******/
/***************************/
/***************************/
public function testalert(){
	$message="HELLO RANU THIS IS JUST FOR TESTING.";
	$params = array('title' => 'Ranudi Testing','sender_id' => 545,'body'=>$message);
	$news=send_push_notifications($message,520,$params);
	//send_android_notification($params,'2A492771-22A5-4C22-AC75-737D5FC12EBA');
	print_r($news);
 // API access key from Google API's Console
/*******
define('API_ACCESS_KEY', 'AIzaSyB8hTXL1ZZQEoev41QUhBpJ_OJ8ToLSY30' );
define('SERVER_KEY', 'AAAA73IAhp0:APA91bHDlqfUWFOxGSEs6rVVPB15R-ll5_4ipABzTS12mfGRDagQKE95QO22bEkaQc2NCdlp8bWpLSjlHYWtfjYfUH66lCIg6GFvyhs6w6sLTKEQ-no0tNj_Fo-KFFIayrs3wKS1vm-J' );
$registrationIds = array( "cZNVE0ITSTo:APA91bG5Y9KgyUMIkcAgsBDNkti6UxUl6urQWj2oK3OAfDgw-ePvJKHkNyHyL5mZdnFyLx5wfhYLWD5p32CWnseS1dVbqXiDvkWD4zVgs68Ynh6p2bc3GKIb-beWR-obWkOXRV4BD8FC","faZsTxVdEeo:APA91bE4DYcJtavBHx_FTnpZbasQGHVRB8s3OHlqGcTvkMimBfL8eYStkod5UGdvFe1Apm8qg2sPZ14NdtlroF5iWykKpTELupAanQHCxMV9lKg46E5kTOabfhsWSZYjDFrnWm0-wJYD");
// prep the bundle
$msg = array(
        'title'  => "This is my Title",
        'body'  => "Hello this is my message message text",
		'priority'=>'high'
    );
$fields = array(
            'registration_ids'  =>$registrationIds,
            'notification'      => $msg
        );

$headers = array(
            'Authorization: key=' . SERVER_KEY,
            'Content-Type: application/json'
        );

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
echo $result;
/***************
$url = "https://fcm.googleapis.com/fcm/send";
$token = "2A492771-22A5-4C22-AC75-737D5FC12EBA";
$serverKey = 'AAAA73IAhp0:APA91bHDlqfUWFOxGSEs6rVVPB15R-ll5_4ipABzTS12mfGRDagQKE95QO22bEkaQc2NCdlp8bWpLSjlHYWtfjYfUH66lCIg6GFvyhs6w6sLTKEQ-no0tNj_Fo-KFFIayrs3wKS1vm-J';
$title = "Title";
$body = "Body of the message";
$notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' => '1');
$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
$json = json_encode($arrayToSend);
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: key='. $serverKey;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
//Send the request
$response = curl_exec($ch);
//Close request
if ($response === FALSE) {
die('FCM Send Error: ' . curl_error($ch));
}
curl_close($ch);
***/
}
} ?>