<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends SR_Controller{
	public function __construct(){
        parent::__construct();
		adminLoginCheck();
    }

    /*users(owner) list*/
	public function index(){
		$data['title']='Users List';
		$page='users';
		$data['users'] = $this->common_model->getAllwhere(PROPERTY_USERS,array('user_type'=>'owner'),'firstname','ASC','all');
		$this->load->view('admin/users',$data);
	}	

	/*update user*/
	public function userUpdate($userID){
		$data['title'] = 'User Edit';
		$userID = decoding($userID);
		if($this->input->post()){
			$this->form_validation->set_rules('firstname','Firstname ','required');
			$this->form_validation->set_rules('lastname','Lastname','required');
			$this->form_validation->set_rules('email','Email','required');
			$dataUpdate['firstname'] = $this->input->post('firstname');
			$dataUpdate['lastname'] = $this->input->post('lastname');
			$dataUpdate['email'] = $this->input->post('email');
			$dataUpdate['user_country_code'] = $this->input->post('country_code');
			$dataUpdate['user_number'] = $this->input->post('cell_phone');
			if(isset($_FILES['profile_img']['name']) && !empty($_FILES['profile_img']['name']))
            {
            	$profileImgData = uploadImage('profile_img','users');
            	if(!empty($profileImgData)){
            		$dataUpdate['profile_img'] = base_url().$profileImgData['original'];
            		$dataUpdate['profile_thumbnail'] = base_url().$profileImgData['thumb'];
            	}
            }
            $this->common_model->updateFields(PROPERTY_USERS,$dataUpdate,array('id'=>$userID));
            $this->session->set_flashdata('success','User updated successfully');
            redirect(site_url('adusers'));
		}else{
			$data['userData'] = $this->common_model->getsingle(PROPERTY_USERS,array('id'=>$userID));
		}
		$this->load->view('admin/user_edit',$data);
	}

	/*agent list*/
	public function agentList(){
		$data['title']='Agents List';
		$page='agents';
		$data['users'] = $this->common_model->getAllwhere(PROPERTY_USERS,array('user_type'=>'agent'),'firstname','ASC','all');
		$this->load->view('admin/agents',$data);
	}

	/*update agent*/
	public function agentUpdate($userID){
		$data['title'] = 'Agent Edit';
		$userID = decoding($userID);
		if($this->input->post()){
			$this->form_validation->set_rules('firstname','Firstname ','required');
			$this->form_validation->set_rules('lastname','Lastname','required');
			$this->form_validation->set_rules('email','Email','required');
			$dataUpdate['firstname'] = $this->input->post('firstname');
			$dataUpdate['lastname'] = $this->input->post('lastname');
			$dataUpdate['email'] = $this->input->post('email');
			$dataUpdate['user_country_code'] = $this->input->post('country_code');
			$dataUpdate['user_number'] = $this->input->post('cell_phone');
			$dataUpdate['agency_name'] = $this->input->post('agency_name');
			            $dataUpdate['agency_cell_code'] = $this->input->post('agency_cell_code');
            $dataUpdate['agency_cell'] = $this->input->post('agency_cell');
            $dataUpdate['agency_phone_code'] = $this->input->post('agency_phone_code');
            $dataUpdate['agency_phone'] = $this->input->post('agency_phone');
            $dataUpdate['img_name'] = $this->input->post('img_name');
            $dataUpdate['license_description'] = $this->input->post('license_description');
            if($this->input->post('licenses_number'))
                $dataUpdate['licenses_number'] = implode(",",$this->input->post('licenses_number'));
            if($this->input->post('services_area'))
                $dataUpdate['services_area'] = implode(",",$this->input->post('services_area'));
            if($this->input->post('language'))
                $dataUpdate['language'] = implode(",",$this->input->post('language'));
            $dataUpdate['profile_video'] = $this->input->post('profile_video');
            $dataUpdate['website_url'] = $this->input->post('website_url');
            $dataUpdate['blog'] = $this->input->post('blog');
            $dataUpdate['facebook_profile_url'] = $this->input->post('fb_url');
            $dataUpdate['twitter_profile_url'] = $this->input->post('twitter_url');
            $dataUpdate['linkedin_profile_url'] = $this->input->post('linkedin_url');
			if(isset($_FILES['profile_img']['name']) && !empty($_FILES['profile_img']['name']))
			{
				$profileImgData = uploadImage('profile_img','users');
				if(!empty($profileImgData)){
					$dataUpdate['profile_img'] = base_url().$profileImgData['original'];
					$dataUpdate['profile_thumbnail'] = base_url().$profileImgData['thumb'];
				}
			}
			$this->common_model->updateFields(PROPERTY_USERS,$dataUpdate,array('id'=>$userID));
			$this->session->set_flashdata('success','Agent updated successfully');
			redirect(site_url('adagents'));
		}else{
			$data['userData'] = $this->common_model->getsingle(PROPERTY_USERS,array('id'=>$userID));
		}
		$this->load->view('admin/agent_edit',$data);
	}

	public function suspend($type,$userID){
		$userData = $this->common_model->getsingle(PROPERTY_USERS,array('id'=>$userID));
		if(!empty($userData)){
			if($userData->suspend == 0){
				$message = 'Your profile is suspended. Please contact Admin for more information.';
				$this->session->set_flashdata('success',ucfirst($type).' suspended successfully');
				$this->common_model->updateFields(PROPERTY_USERS,array('suspend'=>1),array('id'=>$userID));
			}else{
				$message = 'Your profile is now Active.';
				$this->session->set_flashdata('success',ucfirst($type).' unsuspended successfully');
				$this->common_model->updateFields(PROPERTY_USERS,array('suspend'=>0),array('id'=>$userID));
			}
			$from = 'info@mawjuud.com';
			$email = $userData->email;
			$name = ucwords($userData->firstname.' '.$userData->lastname);
				sendMail($email,$from,$message,$name,'Mawjuud');
		}
		if($type == 'user'){
			redirect('adusers');
		}else{
			redirect('adagents');
		}
	}
}
?>