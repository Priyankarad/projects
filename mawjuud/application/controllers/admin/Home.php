<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}  
	/*function for loading login view*/
	public function index(){
		if($this->input->post()){
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if ($this->form_validation->run() == TRUE)
	        {
				$email = $this->input->post('email');
				$password = md5($this->input->post('password'));

				$userData = $this->common_model->getsingle(PROPERTY_USERS,array('email'=>$email,'password'=>$password,'user_type'=>'Admin'));
				if(!empty($userData)){
					$this->session->set_userdata("admin_id", $userData->id);
					$this->session->set_userdata("firstname", $userData->firstname);
					$this->session->set_userdata("lastname", $userData->lastname);
					$this->session->set_userdata("profile_image", $userData->profile_thumbnail);
					$this->session->set_userdata('allsess',array("admin_id"=>$userData->id,"firstname"=>$userData->firstname,"lastname"=>$userData->lastname));
					redirect('dashboard','refresh'); 
				}else{
					$this->session->set_flashdata('loginerror',"Invalid Email ID or Password");
					redirect("siteadmin");
				}
	        }else{
	        	$this->load->view('admin/login');
	        }
		}else{
			$this->load->view('admin/login');
		}
	}

	/*function for loading dashboard*/
	public function dashboard(){
		adminLoginCheck();
		$data['users'] = $this->common_model->getAllwhere(PROPERTY_USERS,array('user_type'=>'owner'),'firstname','ASC','all');
		$data['agents'] = $this->common_model->getAllwhere(PROPERTY_USERS,array('user_type'=>'agent'),'firstname','ASC','all');
		$data['properties'] = $this->common_model->getAllwhere(PROPERTY,array(),'created_date','DESC','all');
		$data['tours'] = $this->common_model->GetJoinRecordThree(TOUR_REQUEST,'property_id',PROPERTY,'id',PROPERTY_USERS,'id',TOUR_REQUEST,'requested_by','property.title,property.thumbnail_photo_media,property_users.firstname,property_users.lastname,property_users.profile_thumbnail,tour_request.*','','','tour_created_date','desc');
		$data['rent'] = $this->common_model->GetJoinRecord(PROPERTY,'id',ASK_QUESTION,'property_id','property.*,count(ask_question.id) as inquiry_count',array('property_type'=>'rent'),'ask_question.property_id','inquiry_count','desc');
		$data['buy'] = $this->common_model->GetJoinRecord(PROPERTY,'id',ASK_QUESTION,'property_id','property.*,count(ask_question.id) as inquiry_count',array('property_type'=>'sale'),'ask_question.property_id','inquiry_count','desc');
		$data['feeds'] = $this->common_model->getAllwhere(SOURCE_FEEDS);
		$this->load->view('admin/dashboard',$data);
	}
	/*function for logout*/
	public function logout(){
		$this->session->unset_userdata("admin_id");
		$this->session->unset_userdata("firstname");
		$this->session->unset_userdata("lastname");
		$this->session->unset_userdata("allsess");
		redirect('siteadmin');
	}

	/*to update admin profile*/
	public function updateProfile(){
		adminLoginCheck();
		$userID=$this->session->userdata['admin_id'];
		if($this->input->post()){
			$this->form_validation->set_rules('firstname','Firstname ','required');
			$this->form_validation->set_rules('lastname','Lastname','required');
			$this->form_validation->set_rules('email','Email','required');
			$dataUpdate['firstname'] = $this->input->post('firstname');
			$dataUpdate['lastname'] = $this->input->post('lastname');
			$dataUpdate['email'] = $this->input->post('email');
			if(isset($_FILES['profile_img']['name']) && !empty($_FILES['profile_img']['name']))
			{
				$profileImgData = uploadImage('profile_img','users');
				if(!empty($profileImgData)){
					$dataUpdate['profile_img'] = base_url().$profileImgData['original'];
					$dataUpdate['profile_thumbnail'] = base_url().$profileImgData['thumb'];
				}
			}
			$this->common_model->updateFields(PROPERTY_USERS,$dataUpdate,array('id'=>$userID));
			$userData=$this->common_model->getsingle(PROPERTY_USERS,array('id'=>$userID));
			$this->session->set_flashdata('success','Admin profile updated successfully');
			$this->session->set_userdata("admin_id", $userData->id);
			$this->session->set_userdata("firstname", $userData->firstname);
			$this->session->set_userdata("lastname", $userData->lastname);
			$this->session->set_userdata("profile_image", $userData->profile_thumbnail);
			redirect(site_url('profile'));
		}
		$userdata=$this->common_model->getsingle(PROPERTY_USERS,array('id'=>$userID));
		$data['userData']=$userdata;
		$data['title']='Admin Profile';
		$this->load->view('admin/profile',$data);
	}
}
?>