<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}

	public function frontendtemplates($view,$data=array()){

		$this->load->view('frontend/template/headerinnerpage'); 
		$this->load->view('frontend/'.$view,$data);
		$this->load->view('frontend/template/footer');
	}
/********************************/
	 public function pageview($page,$headerdata=array(),$maindata=array(),$footerdata=array()){
		 $maindata['authUrl'] = $this->facebook->login_url();
		 $maindata['loginURL'] = $this->googleplus->loginURL();
		 $footerdata['authUrl'] = $this->facebook->login_url();
		 $footerdata['loginURL'] = $this->googleplus->loginURL();
		 $this->load->view('frontend/template/headerinnerpage',$headerdata);
		 $this->load->view('frontend/'.$page,$maindata);
		 $this->load->view('frontend/template/footer',$footerdata);
	 }
	 
	 public function pageviewnofooter($page,$headerdata=array(),$maindata=array(),$footerdata=array()){
		 $this->load->view('frontend/template/headerinnerpage',$headerdata);
		 $this->load->view('frontend/'.$page,$maindata);
		 $this->load->view('frontend/template/profilefooter',$footerdata);
	 }	 
/********************************/	
    public function check_userrole(){
			      if($this->session->userdata('loggedIn')){
					$email=$this->session->userdata['userData']['email'];
					$userDetails = $this->common_model->getsingle(USERS,array('email'=>$email));
					if(!empty($userDetails)){
						return $userDetails->user_role;
					}else{
						return false;
						};
			      }else{
			         return false;
			      }
    }
    public function checkUserLogin(){
			      if($this->session->userdata('loggedIn')){
			         return true;
			      }else{
			         return false;
			      }
    }

    public function deleteData(){
    	$tableName = $this->input->post('table_name');
    	$record = $this->input->post('record');
    	if($this->common_model->deleteData($tableName,array('id'=>$record))){
    		$this->session->set_flashdata('updatemsg','<div class="alert alert-success">Record deleted successfully!</div>'); 
    		echo json_encode(array('status'=>1));
    	}
    }
}