<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Administrator extends SR_Controller{
	public function __construct(){
        parent::__construct();
        $this->load->library('pagination');
        $this->load->helper('url');
		$this->checkAdminlogin();
    }
	public function index(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$headerdata['title']='Dashboard';
		$page='index';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	
/***********************************************/
/***********************PROFILE*****************/
/***********************************************/
	public function profile(){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$userid=$this->session->userdata['admin_id'];
		$userdata=$this->common_model->getsingle(PROPERTY_USERS,array('id'=>$userid,'user_type'=>'owner'));
		$maindata['userdata']=$userdata;
		$page='profile';
		$headerdata['title']='Profile';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*******************UPDATE-PROFILE**************/
/***********************************************/
	public function updateprofile(){
		$datas=array();
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		if($this->form_validation->run() == TRUE){
		$firstname=$this->input->post('firstname');
		$lastname=$this->input->post('lastname');
		$email=$this->input->post('email');
		$mobile=$this->input->post('mobile');
		$userid=$this->session->userdata['admin_id'];
		$emailcheck=$this->common_model->getsingle(USERS,array('id!='=>$userid,'email'=>$email));
		if(!empty($emailcheck)){
		$this->session->set_flashdata('error_msg','Email- <strong>'.$email.'</strong> already registered with us. ');  
		redirect(site_url('administrator/profile'));   
		}
		$mobilecheck=$this->common_model->getsingle(USERS,array('id!='=>$userid,'mobile'=>$mobile));
		if(!empty($mobilecheck)){
		$this->session->set_flashdata('error_msg','Mobile- <strong>'.$mobile.'</strong> already registered with us. ');  
		redirect(site_url('administrator/profile'));   
		}
		$datas['firstname']=$firstname;
		$datas['lastname']=$lastname;
		$datas['email']=$email;
		$datas['mobile']=$mobile;
		$this->common_model->updateFields(USERS,$datas,array('id'=>$userid));
		$this->session->set_flashdata('success_msg','Your profile updated successfully.');
		redirect(site_url('administrator/profile'));
		}else{
		$this->session->set_flashdata('error_msg',validation_errors());
		redirect(site_url('administrator/profile')); 	
		}	
		
	}		
/***********************************************/
/*****************CHANGE-PASSWORD***************/
/***********************************************/
	public function changepassword(){
		$this->form_validation->set_rules('old_password', 'Old password', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required');
		if($this->form_validation->run() == TRUE){
		$old_password=$this->input->post('old_password');
		$new_password=$this->input->post('new_password');
		$confirm_password=$this->input->post('confirm_password');
		$userid=$this->session->userdata['userData']['id'];
		$userdata=$this->common_model->getsingle(USERS,array('id'=>$userid));
		$password=$userdata->password;
		if($password==md5($old_password)){
		$this->common_model->updateFields(USERS,array('password'=>md5($new_password)),array('id'=>$userid));	
		$this->session->set_flashdata('success_msg','Your password has been changed.');
		redirect(site_url('administrator/profile'));
		}else{
		$this->session->set_flashdata('error_msg','Your Old password not matched. Try again.');
		redirect(site_url('administrator/profile')); 
		}	
		}else{
		$this->session->set_flashdata('error_msg',validation_errors());
		redirect(site_url('administrator/profile')); 	
		}
	}
	
/***********************************************/
/*************************USERS*****************/
/***********************************************/
	public function users($pageid=0){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$limit=10;
		$offset=$pageid;
		$userdata=$this->common_model->getAllwhere(PROPERTY_USERS,array('user_type'=>'owner'),'firstname','ASC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['users']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('admin/administrator/users/');
		$config['total_rows'] = $total_count;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['num_links'] = 5;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul><!--pagination-->';
		$config['first_link'] = '&laquo;';
		$config['first_tag_open'] = '<li class="page-item" aria-label="Previous">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '&raquo;';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class=" page-item active"><a class="page-link" href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['anchor_class'] = 'class="page-link"';
		$config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);
		/*******/
        $maindata['pagination']= $this->pagination->create_links();
		$maindata['offset']=$offset;
		$page='users';
		$headerdata['title']='Manage Users';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*****************Manage Agents*****************/
/***********************************************/
	public function agents($pageid=0){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$limit=10;
		$offset=$pageid;
		$userdata=$this->common_model->getAllwhere(PROPERTY_USERS,array('user_type'=>'agent'),'firstname','ASC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['users']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('admin/administrator/agents/');
		$config['total_rows'] = $total_count;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['num_links'] = 5;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul><!--pagination-->';
		$config['first_link'] = '&laquo;';
		$config['first_tag_open'] = '<li class="page-item" aria-label="Previous">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '&raquo;';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class=" page-item active"><a class="page-link" href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['anchor_class'] = 'class="page-link"';
		$config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);
		/*******/
        $maindata['pagination']= $this->pagination->create_links();
		$maindata['offset']=$offset;
		$page='agents';
		$headerdata['title']='Manage Agent';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*****************Manage Listings*****************/
/***********************************************/
	public function listings($pageid=0){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$limit=10;
		$offset=$pageid;
		$userdata=$this->common_model->getAllwhere(PROPERTY,array(),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['listings']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('admin/administrator/listings/');
		$config['total_rows'] = $total_count;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['num_links'] = 5;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul><!--pagination-->';
		$config['first_link'] = '&laquo;';
		$config['first_tag_open'] = '<li class="page-item" aria-label="Previous">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '&raquo;';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class=" page-item active"><a class="page-link" href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['anchor_class'] = 'class="page-link"';
		$config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);
		/*******/
        $maindata['pagination']= $this->pagination->create_links();
		$maindata['offset']=$offset;
		$page='listings';
		$headerdata['title']='Manage Listings';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/********************DELETE-USERS*****************/
/***********************************************/
	public function deleteusers(){
		if(isset($_POST['id']) && $_POST['id']!="" ){
			$mid=$_POST['id'];
			$id=decoding($mid);
			$table=$_POST['tablename'];
			$userdata=$this->common_model->deleteData($table,array('id'=>$id));
			echo json_encode( array('response'=>1,'msg'=>'data deleted successfully'));
		}else{
		echo json_encode( array('response'=>0,'msg'=>'Undefined method !'));
		}
		
	}
/***********************************************/
/**********************Category******************/
/***********************************************/
	public function category($pageid=0){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$userid=$this->session->userdata['userData']['id'];
		$limit=10;
		$offset=$pageid;
		$userdata=$this->common_model->getAllwhere(CATEGORY,array('status'=>1),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['category']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('administrator/category/');
		$config['total_rows'] = $total_count;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['num_links'] = 5;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul><!--pagination-->';
		$config['first_link'] = '&laquo;';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '&raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
		/*******/
        $maindata['pagination']= $this->pagination->create_links();
		$maindata['offset']=$offset;
		$page='category';
		$headerdata['title']='Category';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/********************ADD-CATEGORY*****************/
/***********************************************/
	public function addcategory(){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$page='addcategory';
		$headerdata['title']='Category';
		$category=$this->common_model->getAllwhere(CATEGORY,array('status'=>1),'category','ASC','all');
		$maindata['category']=$category['result'];
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/********************INSERT-CATEGORY*****************/
/***********************************************/
	public function insertcategory(){
		$datas=array();
		$this->form_validation->set_rules('category', 'Category', 'trim|required');
		if($this->form_validation->run() == TRUE){
		$category=$this->input->post('category');
		$parent_category=$this->input->post('parent_category');
		
		$categorycheck=$this->common_model->getsingle(CATEGORY,array('category'=>$category));
		if(!empty($categorycheck)){
		$this->session->set_flashdata('error_msg','Category- <strong>'.$category.'</strong> already Exist. ');  
		redirect(site_url('administrator/addcategory/'));   
		}
		$datas['category']=$category;
		$datas['parent_id']=$parent_category;
		
		$insrt=$this->common_model->insertData(CATEGORY,$datas);
		if($insrt){
		$this->session->set_flashdata('success_msg','Category added successfully.');
		redirect(site_url('administrator/category')); 
		}else{
		$this->session->set_flashdata('error_msg','Something  went wrong , try again.');
		redirect(site_url('administrator/addcategory'));	
		}
		}else{
		$this->session->set_flashdata('error_msg',validation_errors());
		redirect(site_url('administrator/addcategory')); 
		}
	}
/***********************************************/
/********************EDIT-CATEGORY*****************/
/***********************************************/
	public function editcategory($mid=""){
		if($mid!=""){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$catid=decoding($mid);
		$userdata=$this->common_model->getsingle(CATEGORY,array('id'=>$catid));
		$maindata['userdata']=$userdata;
		$page='editcategory';
		$headerdata['title']='Category';
		$category=$this->common_model->getAllwhere(CATEGORY,array('status'=>1,'id!='=>$catid),'category','ASC','all');
		$maindata['category']=$category['result'];
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
		}else{
			redirect(site_url('administrator/category/'));
		}
	}
/***********************************************/
/********************UPDATE-CATEGORY*****************/
/***********************************************/
	public function updatecategory(){
        $datas=array();
		$this->form_validation->set_rules('category', 'Category', 'trim|required');
		
		if($this->form_validation->run() == TRUE){
		$category=$this->input->post('category');
		$parent_category=$this->input->post('parent_category');
		$id=$this->input->post('id');
		$catid=decoding($id);
		$categorycheck=$this->common_model->getsingle(CATEGORY,array('id!='=>$catid,'category'=>$category));
		if(!empty($categorycheck)){
		$this->session->set_flashdata('error_msg','Category- <strong>'.$category.'</strong> already Exist. ');  
		redirect(site_url('administrator/editcategory/'.$id));   
		}
		
		$datas['category']=$category;
		$datas['parent_id']=$parent_category;
		$this->common_model->updateFields(CATEGORY,$datas,array('id'=>$catid));
		$this->session->set_flashdata('success_msg','Category updated successfully.');
		redirect(site_url('administrator/category'));
		}else{
		$this->session->set_flashdata('error_msg',validation_errors());
		redirect(site_url('administrator/editcategory'.$id)); 	
		}	
	}

/***********************************************/
/********************LOGOUT*****************/
/***********************************************/
	public function logout(){
	$this->session->sess_destroy();
	redirect(base_url());
	}
/***********************************************/
/********************CHECK-USER*****************/
/***********************************************/
	
}
?>