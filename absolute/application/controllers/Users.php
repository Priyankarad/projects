<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends SR_Controller{
	public function __construct(){
        parent::__construct();
        $this->load->library('pagination');
        $this->load->helper('url');
    }
	public function index(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$homeData = $this->sr_model->getAllwhere(PAGES,array('page'=>3));
		if(!empty($homeData)){
			$maindata['homeData'] = $homeData['result'];
			$maindata['imageData'] = $this->sr_model->getAllwhere(SLIDER);
		}
		$page='index';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/********************SIGNIN*****************/
/***********************************************/
	public function signin(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$page='signin';
		$this->load->view('template/header',$headerdata);
		$this->load->view('signin',$maindata);
		$this->load->view('template/footer',$footerdata);
		//$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/********************CHECK-USER*****************/
/***********************************************/
	public function checlogin(){
		if($this->session->userdata('loggedIn') && $this->session->userdata['userData']['user_role']==1 ){
		redirect(site_url('administrator'));	
		}else if($this->session->userdata('loggedIn') && $this->session->userdata['userData']['user_role']==2){
		redirect(site_url('vendor'));	
		}else if($this->session->userdata('loggedIn') && $this->session->userdata['userData']['user_role']==3){
		redirect(site_url('customer'));
		}else{
		return true;	
		}
	}
/***********************************************/
/******************Login***********************/
/***********************************************/
	public function login(){
	$this->form_validation->set_rules('email', 'Email', 'trim|required');
	$this->form_validation->set_rules('pwd', 'Password', 'trim|required');
	if($this->form_validation->run() == TRUE){
	$email=$this->input->post('email');
	$password=$this->input->post('pwd');
	$cdata=array('*');
	$ctable=USERS;
	$ccondition=array('email'=>$email);
	$chkEmail=$this->sr_model->getDataByCondition($cdata,$ctable,$ccondition,'','','');
	$userData=array();
	if(!empty($chkEmail)){
	$hashpassword= $chkEmail[0]['password'];
    $user_role= $chkEmail[0]['user_role'];
	$status= $chkEmail[0]['status'];
	$userID= $chkEmail[0]['id'];
	if($hashpassword==md5($password)){
	if($status==1){
			$userData['loggeduserid']=$userID;
			$this->session->set_userdata('loggedIn', 1);
			$this->session->set_userdata('userData', $chkEmail[0]);
			redirect(site_url('administrator'));
	}else{
			$this->session->set_flashdata('error_msg','Your Profile has been deactivated, please contact to administrator.');
			redirect(site_url('users/signin/')); 
		 }
		 
	 }else{
			$this->session->set_flashdata('error_msg','Password not matched, please try again.');
			redirect(site_url('users/signin/'));  
	 }
	}else{
			$this->session->set_flashdata('error_msg','User Not registered with us.');
			redirect(site_url('users/signin/'));  
	}	
	}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('users/signin/')); 	
	}
	}

/***********************************************/
/********************INSERT-CONTACT*****************/
/***********************************************/
	public function insertcontact(){
		$datas=array();
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last name', 'trim|required');
		$this->form_validation->set_rules('company', 'Company', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('zipcode', 'Zip code', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');
		if($this->form_validation->run() == TRUE){
		$name=$this->input->post('fname');
		$lastname=$this->input->post('lastname');
		$company=$this->input->post('company');
		$email=$this->input->post('email');
		$address=$this->input->post('address');
		$city=$this->input->post('city');
		$zipcode=$this->input->post('zipcode');
		$phone=$this->input->post('phone');
		$message=$this->input->post('message');

		$datas['fname']=$name;
		$datas['lname']=$lastname;
		$datas['company']=$company;
		$datas['email']=$email;
		$datas['address']=$address;
		$datas['city']=$city;
		$datas['zipcode']=$zipcode;
		$datas['phone']=$phone;
		$datas['message']=$message;
		$insrt=$this->sr_model->insertData(CONTACT,$datas);
		if($insrt){
		$this->session->set_flashdata('success_msg','Your data posted successfully.');
		redirect(BASEURL.'/contact'); 
		}else{
		$this->session->set_flashdata('error_msg','Something  went wrong , try again.');
		redirect(BASEURL.'/contact'); 	
		}
		
		}else{
		$this->session->set_flashdata('error_msg',validation_errors());
		redirect(BASEURL.'/contact'); 
		}
	}
/***********************************************/
/***********************************************/	
}