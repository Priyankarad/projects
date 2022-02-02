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
		$userid=$this->session->userdata['userData']['id'];
		$userdata=$this->sr_model->getsingle(USERS,array('id'=>$userid));
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
			$userid=$this->session->userdata['userData']['id'];
			$emailcheck=$this->sr_model->getsingle(USERS,array('id!='=>$userid,'email'=>$email));
			if(!empty($emailcheck)){
				$this->session->set_flashdata('error_msg','Email- <strong>'.$email.'</strong> already registered with us. ');  
				redirect(site_url('administrator/profile'));   
			}
			$mobilecheck=$this->sr_model->getsingle(USERS,array('id!='=>$userid,'mobile'=>$mobile));
			if(!empty($mobilecheck)){
				$this->session->set_flashdata('error_msg','Mobile- <strong>'.$mobile.'</strong> already registered with us. ');  
				redirect(site_url('administrator/profile'));   
			}
			$datas['firstname']=$firstname;
			$datas['lastname']=$lastname;
			$datas['email']=$email;
			$datas['mobile']=$mobile;
			$this->sr_model->updateFields(USERS,$datas,array('id'=>$userid));
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
			$userdata=$this->sr_model->getsingle(USERS,array('id'=>$userid));
			$password=$userdata->password;
			if($password==md5($old_password)){
				$this->sr_model->updateFields(USERS,array('password'=>md5($new_password)),array('id'=>$userid));	
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
	/**********************Markets***************/
	/***********************************************/
	public function markets($pageid=0){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$userid=$this->session->userdata['userData']['id'];
		$limit=10;
		$offset=$pageid;
		$userdata=$this->sr_model->getAllwhere(MARKET,array('status'=>0),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['markets']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('administrator/markets/');
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
		$page='markets';
		$headerdata['title']='Markets';
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
			$userdata=$this->sr_model->deleteData($table,array('id'=>$id));
			echo json_encode( array('response'=>1,'msg'=>'data deleted successfully'));
		}else{
			echo json_encode( array('response'=>0,'msg'=>'Undefined method !'));
		}

	}
	/***********************************************/
	/********************ADD-MARKET*****************/
	/***********************************************/
	public function addmarket(){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$page='addmarket';
		$headerdata['title']='Markets';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/********************INSERT-CUSTOMER*****************/
	/***********************************************/
	public function insertmarket(){
		$datas=array();
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$name=$this->input->post('name');
			$description=$this->input->post('description');
			$emailcheck=$this->sr_model->getsingle(MARKET,array('name'=>$name));
			if(!empty($emailcheck)){
				$this->session->set_flashdata('error_msg','Marker name- <strong>'.$name.'</strong> already registered with us. ');  
				redirect(site_url('administrator/addmarket/'));   
			}

			if(!empty($_FILES['marketimage']['name'])){
				/* To upload image */
				$product_img = fileUploading('marketimage','market','gif|jpg|png|jpeg','','','');
				if(isset($product_img['error'])){
					$return['status']         =   'fail'; 
					$return['msg']      =   strip_tags($product_img['error']);
					$this->session->set_flashdata('erro_msg',$return['msg']);
					redirect(site_url('administrator/addmarket'));
				}else{
					$data_arr['products']   = $product_img['upload_data']['file_name'];
					$datas['image'] 	= get_image_thumb($data_arr['products'],'market',400,400);
				}
			}
			$datas['name']=$name;
			$datas['description']=$description;
			$datas['status']=0;
			$insrt=$this->sr_model->insertData(MARKET,$datas);
			if($insrt){
				$this->session->set_flashdata('success_msg','Market added successfully.');
				redirect(site_url('administrator/markets')); 
			}else{
				$this->session->set_flashdata('error_msg','Something  went wrong , try again.');
				redirect(site_url('administrator/addmarket'));	
			}

		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/addmarket')); 
		}

	}
	/***********************************************/
	/********************EDIT-MARKET*****************/
	/***********************************************/
	public function editmarket($mid=""){
		if($mid!=""){
			$headerdata=array();	
			$footerdata=array();
			$maindata=array();
			$marketid=decoding($mid);
			$userdata=$this->sr_model->getsingle(MARKET,array('id'=>$marketid));
			$maindata['userdata']=$userdata;
			$page='editmarket';
			$headerdata['title']='Markets';
			$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
		}else{
			redirect(site_url('administrator/markets/'));
		}
	}
	/***********************************************/
	/********************UPDATE-MARKET*****************/
	/***********************************************/
	public function updatemarket(){
		$datas=array();
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$name=$this->input->post('name');
			$description=$this->input->post('description');
			$id=$this->input->post('id');
			$marketid=decoding($id);

			$emailcheck=$this->sr_model->getsingle(MARKET,array('id!='=>$marketid,'name'=>$name));
			if(!empty($emailcheck)){
				$this->session->set_flashdata('error_msg','Market Name- <strong>'.$name.'</strong> already registered with us. ');  
				redirect(site_url('administrator/editmarket/'.$id));   
			}
			if(!empty($_FILES['marketimage']['name'])){
				/* To upload image */
				$product_img = fileUploading('marketimage','market','gif|jpg|png|jpeg','','','');
				if(isset($product_img['error'])){
					$return['status']         =   'fail'; 
					$return['msg']      =   strip_tags($product_img['error']);
					$this->session->set_flashdata('erro_msg',$return['msg']);
					redirect(site_url('administrator/editmarket'));
				}else{
					$data_arr['products']   = $product_img['upload_data']['file_name'];
					$datas['image'] 	= get_image_thumb($data_arr['products'],'market',400,400);
				}
			}
			$datas['name']=$name;
			$datas['description']=$description;

			$this->sr_model->updateFields(MARKET,$datas,array('id'=>$marketid));
			$this->session->set_flashdata('success_msg','Market updated successfully.');
			redirect(site_url('administrator/markets'));
		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/editmarket'.$id)); 	
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
		$userdata=$this->sr_model->getAllwhere(CATEGORY,array('status'=>1),'id','DESC','all',$limit,$offset);
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
		$category=$this->sr_model->getAllwhere(CATEGORY,array('status'=>1),'category','ASC','all');
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

			$categorycheck=$this->sr_model->getsingle(CATEGORY,array('category'=>$category));
			if(!empty($categorycheck)){
				$this->session->set_flashdata('error_msg','Category- <strong>'.$category.'</strong> already Exist. ');  
				redirect(site_url('administrator/addcategory/'));   
			}
			$datas['category']=$category;
			$datas['parent_id']=$parent_category;

			$insrt=$this->sr_model->insertData(CATEGORY,$datas);
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
			$userdata=$this->sr_model->getsingle(CATEGORY,array('id'=>$catid));
			$maindata['userdata']=$userdata;
			$page='editcategory';
			$headerdata['title']='Category';
			$category=$this->sr_model->getAllwhere(CATEGORY,array('status'=>1,'id!='=>$catid),'category','ASC','all');
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
			$categorycheck=$this->sr_model->getsingle(CATEGORY,array('id!='=>$catid,'category'=>$category));
			if(!empty($categorycheck)){
				$this->session->set_flashdata('error_msg','Category- <strong>'.$category.'</strong> already Exist. ');  
				redirect(site_url('administrator/editcategory/'.$id));   
			}

			$datas['category']=$category;
			$datas['parent_id']=$parent_category;
			$this->sr_model->updateFields(CATEGORY,$datas,array('id'=>$catid));
			$this->session->set_flashdata('success_msg','Category updated successfully.');
			redirect(site_url('administrator/category'));
		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/editcategory'.$id)); 	
		}	
	}

	/***********************************************/
	/**********************PRODUCTs******************/
	/***********************************************/
	public function products($pageid=0){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$userid=$this->session->userdata['userData']['id'];
		$limit=10;
		$offset=$pageid;

		$userdata=$this->sr_model->getAllwhere(PRODUCT,array('status'=>1),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['products']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('administrator/products/');
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
		$page='products';
		$headerdata['title']='Products';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/********************ADD-PRODUCT*****************/
	/***********************************************/
	public function addproduct(){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$category=$this->sr_model->getAllwhere(CATEGORY,array('status'=>1),'category','ASC','all');
		$maindata['category']=$category['result'];
		$market=$this->sr_model->getAllwhere(MARKET,array('status'=>0),'name','ASC','all');
		$maindata['market']=$market['result'];
		$standard=$this->sr_model->getAllwhere(STANDARD,array('status'=>0),'name','ASC','all');
		$maindata['standard']=$standard['result'];
		$partners=$this->sr_model->getAllwhere(PARTNERS);
		$maindata['partners'] = $partners['result'];
		$page='addproduct';
		$headerdata['title']='Products';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/********************INSERT-PRODUCT*****************/
	/***********************************************/
	public function insertproduct(){
		$datas=array();
		$this->form_validation->set_rules('product', 'Product', 'trim|required');
		$this->form_validation->set_rules('category[]', 'Category', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('description', 'Small Description', 'trim|required');
		$this->form_validation->set_rules('full_description', 'Description', 'trim|required');
		$this->form_validation->set_rules('market[]', 'Market', 'trim|required');
		$this->form_validation->set_rules('standard[]', 'Standard', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$product=$this->input->post('product');
			$category=$this->input->post('category');
			$price=$this->input->post('price');
			$description=$this->input->post('description');
			$quote=$this->input->post('quote');
			$market1=$this->input->post('market');
			$full_description=$this->input->post('full_description');
			$manufacture=$this->input->post('manufacture');
			$standard1=$this->input->post('standard');
			$doc_name=$this->input->post('doc_name');
			$partnersArr = $this->input->post('partners');
			$partners = '';
			if(!empty($partnersArr)){
				$partners = implode(',',$partnersArr);
			}
			$categs=implode(',',$category);
			$market=implode(',',$market1);
			$standard=implode(',',$standard1);
			if(!empty($_FILES['image']['name'])){
				/* To upload image */
				$product_img = fileUploading('image','products','gif|jpg|png|jpeg','','','');
				if(isset($product_img['error'])){
					$return['status']         =   'fail'; 
					$return['msg']      =   strip_tags($product_img['error']);
					$this->session->set_flashdata('erro_msg',$return['msg']);
					redirect(site_url('administrator/addproduct'));

				}else{
					$data_arr['products']   = $product_img['upload_data']['file_name'];
					$datas['images'] 	= get_image_thumb($data_arr['products'],'products',400,400);
				}
			}
$dc_names="";
			if(!empty($_FILES) && !empty($_FILES['doc_files']['name'][0])){
				$documents =array();
				$extension=array("doc","docx","html","xls","xlsx","pdf");
				foreach($_FILES["doc_files"]["tmp_name"] as $key=>$tmp_name) {
					$file_name=$_FILES["doc_files"]["name"][$key];
					$file_tmp=$_FILES["doc_files"]["tmp_name"][$key];
					$ext=pathinfo($file_name,PATHINFO_EXTENSION);
					if(in_array($ext,$extension)) {
						$path= "./uploads/files/";
						$im_name = time()."_".$_FILES['doc_files']['name'][$key];
						$dc_names=$doc_name[$key];
						$uploadfile = $path.$im_name;
						move_uploaded_file($_FILES['doc_files']['tmp_name'][$key], $uploadfile);
						$newarray=array('doc_name'=>$dc_names,'document'=>$im_name);
						//$documents[] = $im_name;
						$documents[] = $newarray;
					}
					else {
						$return['status'] ='fail'; 
						$return['msg']      =   "<div class='alert alert-danger'><strong>The valid format is doc,docx,html,xls,xlsx for Document.</strong></div>";
						$this->session->set_flashdata('erro_msg',$return['msg']);
						redirect(site_url('administrator/addproduct'));
					}
				}
				//$datas['files'] = implode('|', $documents);
				$datas['files'] = serialize($documents);
			}


			if(!isset($quote)){ $quote=0;}
			$datas['product']=$product;
			$datas['partners']=$partners;
			$datas['category']=$categs;
			$datas['price']=$price;
			$datas['description']=$description;
			$datas['quote']=$quote;
			$datas['market']=$market;
			$datas['full_description']=$full_description;
			$datas['manufacture']=$manufacture;
			$datas['standard']=$standard;
			//$datas['doc_name']=$doc_name;
			//$datas['doc_description']=$doc_description;
			$datas['videos']=$this->input->post('videos');
			$insrt=$this->sr_model->insertData(PRODUCT,$datas);
			if(!empty($insrt)){
				/********FILE-UPLOAD*********/
				if(!empty($_FILES['gallery']['name'])){
					$mcount=count($_FILES['gallery']['name']);
					for($i=0;$i<$mcount;$i++){
						$filenames1=$_FILES["gallery"]['name'][$i];
						$filenames2=explode('.',$filenames1);
						$fileext=end($filenames2);
						$newfilename=time().'_'.rand(99999,9999999999).'_'.rand(10000,99999).'.'.$fileext;
						$_FILES['YourImage1']['name'] = $_FILES['gallery']['name'][$i];
						$_FILES['YourImage1']['type'] = $_FILES['gallery']['type'][$i];
						$_FILES['YourImage1']['tmp_name'] = $_FILES['gallery']['tmp_name'][$i];
						$_FILES['YourImage1']['error'] = $_FILES['gallery']['error'][$i];
						$_FILES['YourImage1']['size'] = $_FILES['gallery']['size'][$i];
						$config['image_library'] = 'GD2';
						$config['upload_path']   = FCPATH.'uploads/products';
						$config['allowed_types'] = 'jpg|gif|png|jpeg|JPEG|JPG|PNG'; 
						$this->load->library('image_lib');
						$config['file_name'] = $newfilename;
						$config['source_image'] =$_FILES['YourImage1']['tmp_name'];
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if($this->upload->do_upload('YourImage1')){
							$fileData = $this->upload->data();
							$file_name = $fileData['file_name'];
							$datas2['image']=$file_name;
							$datas2['product_id']=$insrt;
							$insrt2=$this->sr_model->insertData(GALLERY,$datas2);

						}
					}
				}
			}
			/********FILE-UPLOAD*********/

			if($insrt){
				$this->session->set_flashdata('success_msg','Product added successfully.');
				redirect(site_url('administrator/products')); 
			}else{
				$this->session->set_flashdata('error_msg','Something  went wrong , try again.');
				redirect(site_url('administrator/addproduct'));	
			}
		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/addproduct')); 
		}
	}
	/***********************************************/
	/********************EDIT-PRODUCT*****************/
	/***********************************************/
	public function editproduct($mid=""){
		if($mid!=""){
			$headerdata=array();	
			$footerdata=array();
			$maindata=array();
			$catid=decoding($mid);
			$category=$this->sr_model->getAllwhere(CATEGORY,array('status'=>1),'category','ASC','all');
			$maindata['category']=$category['result'];
			$market=$this->sr_model->getAllwhere(MARKET,array('status'=>0),'name','ASC','all');
			$maindata['market']=$market['result'];
			$userdata=$this->sr_model->getsingle(PRODUCT,array('id'=>$catid));
			$maindata['userdata']=$userdata;
			$standard=$this->sr_model->getAllwhere(STANDARD,array('status'=>0),'name','ASC','all');
			$maindata['standard']=$standard['result'];
			$partners=$this->sr_model->getAllwhere(PARTNERS);
			$maindata['partners'] = $partners['result'];
			$page='editproduct';
			$headerdata['title']='Products';
			$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
		}else{
			redirect(site_url('administrator/products/'));
		}
	}
	/***********************************************/
	/********************UPDATE-PRODUCT*****************/
	/***********************************************/
	public function updateproduct(){
		$id=$this->input->post('id');
		$datas=array();
		$this->form_validation->set_rules('product', 'Product', 'trim|required');
		$this->form_validation->set_rules('category[]', 'Category', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('market[]', 'Market', 'trim|required');
		$this->form_validation->set_rules('standard[]', 'Standard', 'trim|required');
		$this->form_validation->set_rules('full_description', 'Full Description', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$product=$this->input->post('product');
			$category=$this->input->post('category');
			$price=$this->input->post('price');
			$description=$this->input->post('description');
			$quote=$this->input->post('quote');
			$market1=$this->input->post('market');
			$full_description=$this->input->post('full_description');
			$partnersArr = $this->input->post('partners');
			$partners = '';
			if(!empty($partnersArr)){
				$partners = implode(',',$partnersArr);
			}
			$catid=decoding($id);
			$manufacture=$this->input->post('manufacture');
			$standard1=$this->input->post('standard');
			$doc_name=$this->input->post('doc_name');
			
			$old_doc_name=$this->input->post('old_doc_name');
			$old_doc_files=$this->input->post('old_doc_files');
			$newarray1=array();
			if(!empty($old_doc_name)){ $n=0; foreach($old_doc_name as $old){ 
				$newarray1[]=array('doc_name'=>$old,'document'=>$old_doc_files[$n]);
				$n++;
			}
			}
			
			//$doc_description=$this->input->post('doc_description');
			$categs=implode(',',$category);
			$market=implode(',',$market1);
			$standard=implode(',',$standard1);

			if(!empty($_FILES['image']['name'])){
				$product_img = fileUploading('image','products','gif|jpg|png|jpeg','','','');
				if(isset($product_img['error'])){
					$return['status']         =   'fail'; 
					$return['msg']      =   strip_tags($product_img['error']);
					$this->session->set_flashdata('error_msg',$return['msg']);
					redirect(site_url('administrator/addproduct'));
				}else{
					$data_arr['products']   = $product_img['upload_data']['file_name'];
					$datas['images'] 	= get_image_thumb($data_arr['products'],'products',400,400);
				}
			}
$dc_names="";
			if(!empty($_FILES) && !empty($_FILES['doc_files']['name'][0]))
			{
				$documents =array();
				$extension=array("doc","docx","html","xls","xlsx","pdf");
				foreach($_FILES["doc_files"]["tmp_name"] as $key=>$tmp_name) {
					$file_name=$_FILES["doc_files"]["name"][$key];
					$file_tmp=$_FILES["doc_files"]["tmp_name"][$key];
					$ext=pathinfo($file_name,PATHINFO_EXTENSION);
					if(in_array($ext,$extension)) {
						$path= "./uploads/files/";
						$im_name = time()."_".$_FILES['doc_files']['name'][$key];
						$dc_names=$doc_name[$key];
						$uploadfile = $path.$im_name;
						move_uploaded_file($_FILES['doc_files']['tmp_name'][$key], $uploadfile);
						$newarray=array('doc_name'=>$dc_names,'document'=>$im_name);
						//$documents[] = $im_name;
						$documents[] = $newarray;
					}
					else {
						$return['status'] ='fail'; 
						$return['msg']      =   "<div class='alert alert-danger'><strong>The valid format is doc,docx,html,xls,xlsx for Document.</strong></div>";
						$this->session->set_flashdata('erro_msg',$return['msg']);
						redirect(site_url('administrator/editproduct/'.$id));
					}
				}
			}
			
			if(!empty($documents)){
				$docs=array_merge($newarray1,$documents);

				$datas['files'] = serialize($docs);
			}
			if(!isset($quote)){ $quote=0;}
			$datas['product']=$product;
			$datas['partners']=$partners;
			$datas['category']=$categs;
			$datas['price']=$price;
			$datas['description']=$description;
			$datas['quote']=$quote;
			$datas['market']=$market;
			$datas['full_description']=$full_description;
			$datas['manufacture']=$manufacture;
			$datas['standard']=$standard;

			$datas['videos']=$this->input->post('videos');

			$this->sr_model->updateFields(PRODUCT,$datas,array('id'=>$catid));

			/********FILE-UPLOAD*********/
			if(!empty($_FILES['gallery']['name'])){
				$mcount=count($_FILES['gallery']['name']);
				for($i=0;$i<$mcount;$i++){
					$filenames1=$_FILES["gallery"]['name'][$i];
					$filenames2=explode('.',$filenames1);
					$fileext=end($filenames2);
					$newfilename=time().'_'.rand(99999,9999999999).'_'.rand(10000,99999).'.'.$fileext;
					$_FILES['YourImage1']['name'] = $_FILES['gallery']['name'][$i];
					$_FILES['YourImage1']['type'] = $_FILES['gallery']['type'][$i];
					$_FILES['YourImage1']['tmp_name'] = $_FILES['gallery']['tmp_name'][$i];
					$_FILES['YourImage1']['error'] = $_FILES['gallery']['error'][$i];
					$_FILES['YourImage1']['size'] = $_FILES['gallery']['size'][$i];
					$config['image_library'] = 'GD2';
					$config['upload_path']   = FCPATH.'uploads/products';
					$config['allowed_types'] = 'jpg|gif|png|jpeg|JPEG|JPG|PNG'; 
					$this->load->library('image_lib');
					$config['file_name'] = $newfilename;
					$config['source_image'] =$_FILES['YourImage1']['tmp_name'];
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload('YourImage1')){
						$fileData = $this->upload->data();
						$file_name = $fileData['file_name'];
						$datas2['image']=$file_name;
						$datas2['product_id']=$catid;
						$insrt2=$this->sr_model->insertData(GALLERY,$datas2);
					}
				}
			}
			$this->session->set_flashdata('success_msg','Product updated successfully.');
			redirect(site_url('administrator/products'));
		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/editproduct/'.$id)); 	
		}	
	}

	/***********************************************/
	/**********************SIZE******************/
	/***********************************************/
	public function size($pageid=0){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$userid=$this->session->userdata['userData']['id'];
		$limit=10;
		$offset=$pageid;
		$userdata=$this->sr_model->getAllwhere(SIZE,array('status'=>1),'id','ASC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['size']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('administrator/size/');
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
		$page='size';
		$headerdata['title']='Product Entity';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/********************ADD-SIZE*****************/
	/***********************************************/
	public function addsize(){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$page='addsize';
		$headerdata['title']='Product Entity';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/********************INSERT-SIZE*****************/
	/***********************************************/
	public function insertsize(){
		$datas=array();
		$this->form_validation->set_rules('size', 'Size', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$size=$this->input->post('size');
			$categorycheck=$this->sr_model->getsingle(SIZE,array('size'=>$size));
			if(!empty($categorycheck)){
				$this->session->set_flashdata('error_msg','Size- <strong>'.$size.'</strong> already Exist. ');  
				redirect(site_url('administrator/addsize/'));   
			}
			$datas['size']=$size;
			$insrt=$this->sr_model->insertData(SIZE,$datas);
			if($insrt){
				$this->session->set_flashdata('success_msg','Size added successfully.');
				redirect(site_url('administrator/size')); 
			}else{
				$this->session->set_flashdata('error_msg','Something  went wrong , try again.');
				redirect(site_url('administrator/addsize'));	
			}
		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/addsize')); 
		}
	}
	/***********************************************/
	/********************EDIT-SIZE*****************/
	/***********************************************/
	public function editsize($mid=""){
		if($mid!=""){
			$headerdata=array();	
			$footerdata=array();
			$maindata=array();
			$catid=decoding($mid);
			$userdata=$this->sr_model->getsingle(SIZE,array('id'=>$catid));
			$maindata['userdata']=$userdata;
			$page='editsize';
			$headerdata['title']='Product Entity';
			$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
		}else{
			redirect(site_url('administrator/size/'));
		}
	}
	/***********************************************/
	/********************UPDATE-SIZE*****************/
	/***********************************************/
	public function updatesize(){
		$datas=array();
		$this->form_validation->set_rules('size', 'Size', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$size=$this->input->post('size');
			$id=$this->input->post('id');
			$catid=decoding($id);
			$categorycheck=$this->sr_model->getsingle(SIZE,array('id!='=>$catid,'size'=>$size));
			if(!empty($categorycheck)){
				$this->session->set_flashdata('error_msg','Size- <strong>'.$size.'</strong> already Exist. ');  
				redirect(site_url('administrator/editsize/'.$id));   
			}
			$datas['size']=$size;
			$this->sr_model->updateFields(SIZE,$datas,array('id'=>$catid));
			$this->session->set_flashdata('success_msg','Size updated successfully.');
			redirect(site_url('administrator/size'));
		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/editsize'.$id)); 	
		}	
	}
	/***********************************************/
	/********************ALL-ORDERS*****************/
	/***********************************************/
	public function allorders($pageid=0){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$userid=$this->session->userdata['userData']['id'];
		$limit=20;
		$offset=$pageid;
		
		$userdata=$this->sr_model->getAllwhere('quotes','','id','DESC','all',$limit,$offset);
	
		$total_count=$userdata['total_count'];
		$maindata['orders']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('administrator/allorders/');
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
		$maindata['pagination']= $this->pagination->create_links();;
		$page='allorders';
		$headerdata['title']='Orders';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/*****************VIEW-ORDERS************/
	/***********************************************/
	public function vieworder($mid=""){
		if($mid!=""){
			$headerdata=array();	
			$footerdata=array();
			$maindata=array();
			$order_id=decoding($mid);
			$vendorid=$this->session->userdata['userData']['id'];
			$data=array('orders.id','orders.vendor_id', 'orders.address', 'orders.city', 'orders.state', 'orders.zip', 'orders.address_shippping', 'orders.city_shippping', 'orders.state_shippping', 'orders.zip_shippping', 'orders.total_pay', 'orders.discount', 'orders.promocode', 'orders.status', 'orders.lastupdate','users.firstname','users.lastname','users.email','users.mobile','order_details.actualprice','order_details.productid','order_details.product_name','order_details.product_quantity','order_details.product_color','order_details.product_size','order_details.product_for','order_details.currency_id');
			$table1=ORDERS;
			$table2=ORDERDETAILS;
			$table3=USERS;
			$relation1="orders.id=order_details.order_id";
			$relation2="order_details.product_for=users.id";
			$condition="order_details.order_id='$order_id'";

			$alldata=$this->sr_model->getThreeTableData($data,$table1,$table2,$table3,$relation1,$relation2,$condition,$groupby="","orders.id","DESC");

			$maindata['orderdetails']=$alldata;
			$page='view_orders';
			$headerdata['title']='ORDERS';
			$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
		}else{
			redirect(site_url('administrator/customers/'));
		}
	}
	/***********************************************/
	/********************DELETE-PRODUCT-IMAGES*****************/
	/***********************************************/
	public function deleteproductimage(){
		if(isset($_POST['image_id']) && $_POST['image_id']!="" ){
			$mid=$_POST['image_id'];
			$table=GALLERY;
			$userdata=$this->sr_model->deleteData($table,array('id'=>$mid));
			echo json_encode( array('response'=>1,'resp'=>1,'status'=>1,'msg'=>'data deleted successfully'));
		}else{
			echo json_encode( array('response'=>0,'msg'=>'Undefined method !'));
		}

	}
	/***********************************************/
	/********************DELETE-PRODUCT-Document*****************/
	/***********************************************/
	public function deleteproductdoc(){
		if(isset($_POST['product_id']) && $_POST['product_id']!="" ){
			$product_id=decoding($_POST['product_id']);
			$doc_name=$_POST['doc_name'];
			$docs=$_POST['docs'];
			$table=PRODUCT;
			$removable_arr=array('doc_name'=>$doc_name,'document'=>$docs);
			
			$products=$this->sr_model->getsingle(PRODUCT,array('id'=>$product_id));
			$filesq=$products->files;
			$filearr=unserialize($filesq);
			$productsdoc=array();
			foreach($filearr as $file){
				if($file['doc_name']==$doc_name && $file['document']==$docs){
					
				}else{
				$productsdoc[]=$file;
				}
				
			}
			$prserial=serialize($productsdoc);
			$datas=array('files'=>$prserial);
			$this->sr_model->updateFields(PRODUCT,$datas,array('id'=>$product_id));
			//unset($filearr);
			
			echo json_encode( array('response'=>1,'resp'=>1,'status'=>1,'msg'=>'data deleted successfully'));
		}else{
			echo json_encode( array('response'=>0,'msg'=>'Undefined method !'));
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
	/**********************STANDARDS***************/
	/***********************************************/
	public function standards($pageid=0){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$userid=$this->session->userdata['userData']['id'];
		$limit=10;
		$offset=$pageid;
		$userdata=$this->sr_model->getAllwhere(STANDARD,array('status'=>0),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['markets']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('administrator/standards/');
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
		$page='standards';
		$headerdata['title']='Standards';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/********************ADD-STANDARD*****************/
	/***********************************************/
	public function addstandard(){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$page='addstandard';
		$headerdata['title']='Standards';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/********************INSERT-STANDARD*****************/
	/***********************************************/
	public function inserstandard(){
		$datas=array();
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$name=$this->input->post('name');
			$description=$this->input->post('description');
			$emailcheck=$this->sr_model->getsingle(STANDARD,array('name'=>$name));
			if(!empty($emailcheck)){
				$this->session->set_flashdata('error_msg','Standard name- <strong>'.$name.'</strong> already registered with us. ');  
				redirect(site_url('administrator/addstandard/'));   
			}

			if(!empty($_FILES['marketimage']['name'])){
				/* To upload image */
				$product_img = fileUploading('marketimage','standard','gif|jpg|png|jpeg','','','');
				if(isset($product_img['error'])){
					$return['status']         =   'fail'; 
					$return['msg']      =   strip_tags($product_img['error']);
					$this->session->set_flashdata('erro_msg',$return['msg']);
					redirect(site_url('administrator/addstandard'));
				}else{
					$data_arr['products']   = $product_img['upload_data']['file_name'];
					$datas['image'] 	= get_image_thumb($data_arr['products'],'standard',400,400);
				}
			}
			$datas['name']=$name;
			$datas['description']=$description;
			$datas['status']=0;
			$insrt=$this->sr_model->insertData(STANDARD,$datas);
			if($insrt){
				$this->session->set_flashdata('success_msg','Standard added successfully.');
				redirect(site_url('administrator/standards')); 
			}else{
				$this->session->set_flashdata('error_msg','Something  went wrong , try again.');
				redirect(site_url('administrator/addstandard'));	
			}

		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/addstandard')); 
		}

	}
	/***********************************************/
	/********************EDIT-STANDARD*****************/
	/***********************************************/
	public function editstandard($mid=""){
		if($mid!=""){
			$headerdata=array();	
			$footerdata=array();
			$maindata=array();
			$marketid=decoding($mid);
			$userdata=$this->sr_model->getsingle(STANDARD,array('id'=>$marketid));
			$maindata['userdata']=$userdata;
			$page='editstandard';
			$headerdata['title']='Standards';
			$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
		}else{
			redirect(site_url('administrator/standards/'));
		}
	}
	/***********************************************/
	/********************UPDATE-STANDARD*****************/
	/***********************************************/
	public function updatestandard(){
		$datas=array();
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$name=$this->input->post('name');
			$description=$this->input->post('description');
			$id=$this->input->post('id');
			$marketid=decoding($id);

			$emailcheck=$this->sr_model->getsingle(STANDARD,array('id!='=>$marketid,'name'=>$name));
			if(!empty($emailcheck)){
				$this->session->set_flashdata('error_msg','Standard Name- <strong>'.$name.'</strong> already registered with us. ');  
				redirect(site_url('administrator/editstandard/'.$id));   
			}
			if(!empty($_FILES['marketimage']['name'])){
				/* To upload image */
				$product_img = fileUploading('marketimage','standard','gif|jpg|png|jpeg','','','');
				if(isset($product_img['error'])){
					$return['status']         =   'fail'; 
					$return['msg']      =   strip_tags($product_img['error']);
					$this->session->set_flashdata('erro_msg',$return['msg']);
					redirect(site_url('administrator/editstandard'));
				}else{
					$data_arr['products']   = $product_img['upload_data']['file_name'];
					$datas['image'] 	= get_image_thumb($data_arr['products'],'standard',400,400);
				}
			}
			$datas['name']=$name;
			$datas['description']=$description;

			$this->sr_model->updateFields(STANDARD,$datas,array('id'=>$marketid));
			$this->session->set_flashdata('success_msg','Standard updated successfully.');
			redirect(site_url('administrator/standards'));
		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/editstandard'.$id)); 	
		}	
	}
	/***********************************************/
	/**********************ARTICLES***************/
	/***********************************************/
	public function articles($pageid=0){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$userid=$this->session->userdata['userData']['id'];
		$limit=10;
		$offset=$pageid;
		$userdata=$this->sr_model->getAllwhere(ARTICLE,array('status'=>0),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['markets']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('administrator/articles/');
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
		$page='articles';
		$headerdata['title']='Articles';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/********************ADD-ARTICLES*****************/
	/***********************************************/
	public function addarticle(){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$page='addarticle';
		$headerdata['title']='Articles';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/********************INSERT-ARTICLES*****************/
	/***********************************************/
	public function insertarticle(){
		$datas=array();
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$title=$this->input->post('title');
			$description=$this->input->post('description');
			$emailcheck=$this->sr_model->getsingle(ARTICLE,array('title'=>$title));
			if(!empty($emailcheck)){
				$this->session->set_flashdata('error_msg','Article title- <strong>'.$title.'</strong> already registered with us. ');  
				redirect(site_url('administrator/addarticle/'));   
			}

			if(!empty($_FILES['marketimage']['name'])){
				/* To upload image */
				$product_img = fileUploading('marketimage','article','gif|jpg|png|jpeg','','','');
				if(isset($product_img['error'])){
					$return['status']         =   'fail'; 
					$return['msg']      =   strip_tags($product_img['error']);
					$this->session->set_flashdata('erro_msg',$return['msg']);
					redirect(site_url('administrator/addarticle'));
				}else{
					$data_arr['products']   = $product_img['upload_data']['file_name'];
					$datas['image'] 	= get_image_thumb($data_arr['products'],'article',400,400);
				}
			}
			$datas['title']=$title;
			$datas['description']=$description;
			$datas['postdate']=date('Y-m-d');
			$datas['postby']=$this->session->userdata['userData']['id'];
			$datas['status']=0;
			$insrt=$this->sr_model->insertData(ARTICLE,$datas);
			if($insrt){
				$this->session->set_flashdata('success_msg','Standard added successfully.');
				redirect(site_url('administrator/articles')); 
			}else{
				$this->session->set_flashdata('error_msg','Something  went wrong , try again.');
				redirect(site_url('administrator/addarticle'));	
			}

		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/addarticle')); 
		}

	}
	/***********************************************/
	/********************EDIT-ARTICLES*****************/
	/***********************************************/
	public function editarticle($mid=""){
		if($mid!=""){
			$headerdata=array();	
			$footerdata=array();
			$maindata=array();
			$marketid=decoding($mid);
			$userdata=$this->sr_model->getsingle(ARTICLE,array('id'=>$marketid));
			$maindata['userdata']=$userdata;
			$page='editarticle';
			$headerdata['title']='Articles';
			$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
		}else{
			redirect(site_url('administrator/articles/'));
		}
	}
	/***********************************************/
	/********************UPDATE-ARTICLES*****************/
	/***********************************************/
	public function updatearticle(){
		$datas=array();
		$this->form_validation->set_rules('title', 'title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$title=$this->input->post('title');
			$description=$this->input->post('description');
			$id=$this->input->post('id');
			$marketid=decoding($id);

			$emailcheck=$this->sr_model->getsingle(ARTICLE,array('id!='=>$marketid,'title'=>$title));
			if(!empty($emailcheck)){
				$this->session->set_flashdata('error_msg','Article title- <strong>'.$title.'</strong> already registered with us. ');  
				redirect(site_url('administrator/editstandard/'.$id));   
			}
			if(!empty($_FILES['marketimage']['name'])){
				/* To upload image */
				$product_img = fileUploading('marketimage','article','gif|jpg|png|jpeg','','','');
				if(isset($product_img['error'])){
					$return['status']         =   'fail'; 
					$return['msg']      =   strip_tags($product_img['error']);
					$this->session->set_flashdata('erro_msg',$return['msg']);
					redirect(site_url('administrator/editarticle/'.$id));
				}else{
					$data_arr['products']   = $product_img['upload_data']['file_name'];
					$datas['image'] 	= get_image_thumb($data_arr['products'],'article',400,400);
				}
			}
			$datas['title']=$title;
			$datas['description']=$description;

			$this->sr_model->updateFields(ARTICLE,$datas,array('id'=>$marketid));
			$this->session->set_flashdata('success_msg','Article updated successfully.');
			redirect(site_url('administrator/articles'));
		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/editarticle/'.$id)); 	
		}	
	}
	/***********************************************/
	/**********************LINKS***************/
	/***********************************************/
	public function links($pageid=0){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$userid=$this->session->userdata['userData']['id'];
		$limit=10;
		$offset=$pageid;
		$userdata=$this->sr_model->getAllwhere(LINKS,array('status'=>0),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['links']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('administrator/links/');
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
		$page='links';
		$headerdata['title']='Links';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/********************ADD-LINKS*****************/
	/***********************************************/
	public function addlink(){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$page='addlink';
		$headerdata['title']='Links';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}
	/***********************************************/
	/********************INSERT-LINKS*****************/
	/***********************************************/
	public function insertlink(){
		$datas=array();
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('url', 'URL', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$title=$this->input->post('title');
			$url=$this->input->post('url');
			$datas['title']=$title;
			$datas['url']=$url;
			$datas['status']=0;

			$insrt=$this->sr_model->insertData(LINKS,$datas);
			if($insrt){
				$this->session->set_flashdata('success_msg','Links added successfully.');
				redirect(site_url('administrator/links')); 
			}else{
				$this->session->set_flashdata('error_msg','Something  went wrong , try again.');
				redirect(site_url('administrator/addlink'));	
			}

		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/addlink')); 
		}

	}
	/***********************************************/
	/********************EDIT-LINKS*****************/
	/***********************************************/
	public function editlink($mid=""){
		if($mid!=""){
			$headerdata=array();	
			$footerdata=array();
			$maindata=array();
			$marketid=decoding($mid);
			$userdata=$this->sr_model->getsingle(LINKS,array('id'=>$marketid));
			$maindata['userdata']=$userdata;
			$page='editlink';
			$headerdata['title']='Links';
			$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
		}else{
			redirect(site_url('administrator/links/'));
		}
	}
	/***********************************************/
	/********************UPDATE-LINKS***************/
	/***********************************************/
	public function updatelink(){
		$datas=array();
		$this->form_validation->set_rules('title', 'title', 'trim|required');
		$this->form_validation->set_rules('url', 'URL', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$title=$this->input->post('title');
			$url=$this->input->post('url');
			$id=$this->input->post('id');
			$marketid=decoding($id);

			$datas['title']=$title;
			$datas['url']=$url;

			$this->sr_model->updateFields(LINKS,$datas,array('id'=>$marketid));
			$this->session->set_flashdata('success_msg','Link updated successfully.');
			redirect(site_url('administrator/links'));
		}else{
			$this->session->set_flashdata('error_msg',validation_errors());
			redirect(site_url('administrator/editlink/'.$id)); 	
		}	
	}
	/***********************************************/
	/********************CHECK-USER*****************/
	/***********************************************/

	/***********************************************/
	/********************PAGE-SETTINGS*****************/
	/***********************************************/
	public function page_settings(){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$pageData = $this->sr_model->getAllwhere(PAGES);
		$maindata['pageData']=$pageData['result'];
		$page='pages_list';
		$headerdata['title']='Page Settings';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}

	/***********************************************/
	/********************EDIT-PAGE*****************/
	/***********************************************/
	public function editpage($pageID){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$pageID = decoding($pageID);
		$pageData = $this->sr_model->getAllwhere(PAGES,array('page'=>$pageID));
		$maindata['pageData']=$pageData['result'];
		if($pageID == 1){
			$page='edit_about';
		}else if($pageID == 2){
			$page='edit_services';
		}else if($pageID == 3){
			$page='edit_home';
			$maindata['sliderData'] = $this->sr_model->getAllwhere(SLIDER);
		}else if($pageID == 4){
			$maindata['download'] = $this->sr_model->getAllwhere(DOWNLOAD);
			$maindata['downloadDcouments'] = $this->sr_model->getAllwhere(DOWNLOAD_DOCUMENTS);
			$page='edit_download';
		}
		$headerdata['title']='Edit Page';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
	}

	/***********************************************/
	/********************UPDATE-PAGE*****************/
	/***********************************************/
	public function updatepage(){
		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$page = $this->input->post('page');
		if($page == 'about'){
			$columnsArray = array('about_absolute_emc','biography','fast_response','attention_to_detail','cut_through_it_all','quality_statement','emc_image','bio_image','fast_image','attention_image','cut_image','quality_image');
			$imgcol = array('emc_image','bio_image','fast_image','attention_image','cut_image','quality_image');
			foreach($columnsArray as $key){
				$status = 0;
				if(($key == 'emc_image') && !empty($_FILES['emc_image']['name']))
				{
					$status = 1;
					$image = fileUpload('emc_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(($key == 'bio_image') && !empty($_FILES['bio_image']['name'])){
					$status = 1;
					$image = fileUpload('bio_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(($key == 'fast_image') && !empty($_FILES['fast_image']['name'])){
					$status = 1;
					$image = fileUpload('fast_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];
				}else if(($key == 'attention_image') && !empty($_FILES['attention_image']['name'])){
					$status = 1;
					$image = fileUpload('attention_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(($key == 'cut_image') && !empty($_FILES['cut_image']['name'])){
					$status = 1;
					$image = fileUpload('cut_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];
				}else if(($key == 'quality_image') && !empty($_FILES['quality_image']['name'])){
					$status = 1;
					$image = fileUpload('quality_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];
				}else if(!in_array($key,$imgcol)){
					$status = 1;
					$dataUpdate['value'] = $this->input->post($key);
				}
				if($status == 1){
					$this->sr_model->updateFields(PAGES,$dataUpdate,array('key'=>$key));
				}
			}
		}else if($page == 'services'){
			$columnsArray = array('consulting','service_and_calibration','quality_statement','investment','prove_your_setup','onsite_or_remote','take_the_next_step','investment_image','prove_your_setup_image','onsite_or_remote_image','take_the_next_step_image');
			$imgcol = array('investment_image','prove_your_setup_image','onsite_or_remote_image','take_the_next_step_image');
			foreach($columnsArray as $key){
				$status = 0;
				if(($key == 'investment_image') && !empty($_FILES['investment_image']['name']))
				{
					$status = 1;
					$image = fileUpload('investment_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(($key == 'prove_your_setup_image') && !empty($_FILES['prove_your_setup_image']['name'])){
					$status = 1;
					$image = fileUpload('prove_your_setup_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(($key == 'onsite_or_remote_image') && !empty($_FILES['onsite_or_remote_image']['name'])){
					$status = 1;
					$image = fileUpload('onsite_or_remote_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];
				}else if(($key == 'take_the_next_step_image') && !empty($_FILES['take_the_next_step_image']['name'])){
					$status = 1;
					$image = fileUpload('take_the_next_step_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(!in_array($key,$imgcol)){
					$status = 1;
					$dataUpdate['value'] = $this->input->post($key);
				}
				if($status == 1){
					$this->sr_model->updateFields(PAGES,$dataUpdate,array('key'=>$key));
				}
			}
		}else if($page == 'home'){
			$columnsArray = array('fast_image','attention_image','cut_image','image_1','image_2','emc_rf_image','standards_equipment_image','test_setup_products_image','fast_response','attention_to_detail','cut_through_it_all','emc_rf','standards_equipment','test_setup_products');
			$imgcol = array('fast_image','attention_image','cut_image','image_1','image_2','emc_rf_image','standards_equipment_image','test_setup_products_image');
			$filesArr = array();
			if(!empty($_FILES['files']['name'])){
				$filesCount = count($_FILES['files']['name']);
				if($filesCount>0){
					for($i = 0; $i < $filesCount; $i++){
					  
						$_FILES['docfile']['name'] = $_FILES['files']['name'][$i];
						$_FILES['docfile']['type'] = $_FILES['files']['type'][$i];
						$_FILES['docfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
						$_FILES['docfile']['error'] = $_FILES['files']['error'][$i];
						$_FILES['docfile']['size'] = $_FILES['files']['size'][$i];
						$config['upload_path'] = 'uploads/files/';
						$path=$config['upload_path'];
						$config['allowed_types'] = 'png|jpg|jpeg|gif';
						$config['overwrite'] = '1';
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if($this->upload->do_upload('docfile')){
							$fileData = $this->upload->data();
							$dataInsert['image']  = 'uploads/files/'.$fileData['file_name'];
							$ins = $this->sr_model->insertData(SLIDER, $dataInsert);
						}else{
							print_r($this->upload->display_errors());
						}
					}
				}
			}
           
        //update slider url 
        $urls=$this->input->post('url');
		$this->db->select('id');            
        $query_vs = $this->db->get_where('slider', array('id!=' => ''));
        $result_vs = $query_vs->result_array();
        $i=0;
        foreach($result_vs as $vs_url)
        {
            $this->db->where('id', $vs_url['id']);
            $this->db->update('slider',array('url'=>$urls[$i]));
           $i++;  
        } 
        //update slider urls
			foreach($columnsArray as $key){
				$status = 0;
				if(($key == 'fast_image') && !empty($_FILES['fast_image']['name']))
				{
					$status = 1;
					$image = fileUpload('fast_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(($key == 'attention_image') && !empty($_FILES['attention_image']['name'])){
					$status = 1;
					$image = fileUpload('attention_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(($key == 'cut_image') && !empty($_FILES['cut_image']['name'])){
					$status = 1;
					$image = fileUpload('cut_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];
				}else if(($key == 'image_1') && !empty($_FILES['image_1']['name'])){
					$status = 1;
					$image = fileUpload('image_1','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(($key == 'image_2') && !empty($_FILES['image_2']['name'])){
					$status = 1;
					$image = fileUpload('image_2','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(($key == 'emc_rf_image') && !empty($_FILES['emc_rf_image']['name'])){
					$status = 1;
					$image = fileUpload('emc_rf_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(($key == 'standards_equipment_image') && !empty($_FILES['standards_equipment_image']['name'])){
					$status = 1;
					$image = fileUpload('standards_equipment_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(($key == 'test_setup_products_image') && !empty($_FILES['test_setup_products_image']['name'])){
					$status = 1;
					$image = fileUpload('test_setup_products_image','files','jpg|gif|png|jpeg|JPG|PNG');
					$dataUpdate['value'] = 'uploads/files/'.$image['upload_data']['file_name'];

				}else if(!in_array($key,$imgcol)){
					$status = 1;
					$dataUpdate['value'] = $this->input->post($key);
				}
				if($status == 1){
					$this->sr_model->updateFields(PAGES,$dataUpdate,array('key'=>$key));
				}
			}
		}
		$this->session->set_flashdata('success_msg','Page updated successfully.');
		redirect(site_url('administrator/page_settings'));
	}

	/***** Partner *******/
	public function allpartners($pageid=0){

		$headerdata=array();	
		$footerdata=array();
		$maindata=array();
		$userid=$this->session->userdata['userData']['id'];
		$limit=10;
		//if(iss)
		$offset=$pageid;
		$userdata=$this->sr_model->getAllwhere(PARTNERS,array('status'=>1),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['partners']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('administrator/allpartners/');
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
		$page='allpartners';
		$headerdata['title']='Partners';
		$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);

	}

	public function addpartner(){
		$datas=array();
		if(count($this->input->post()) > 0){
			$this->form_validation->set_rules('partnertitle', 'Partner Title', 'trim|required');
			$this->form_validation->set_rules('partner_desc', 'Partner Description', 'trim|required');
			if (empty($_FILES['partnerimage']['size']) && empty($this->input->post('oldimage')))
                $this->form_validation->set_rules('partnerimage', 'Partner Image', 'required');
				if($this->form_validation->run() == TRUE){
					$partnertitle=$this->input->post('partnertitle');
					$partnerdesc=$this->input->post('partner_desc');
					$url=$this->input->post('url');
					$datas['title']=$partnertitle;
					//if($partnerdesc!="")
					$datas['content']=$partnerdesc;
					if (!empty($_FILES['partnerimage']['size'])){
						$image = fileUpload('partnerimage','partners','jpg|gif|png|jpeg|JPG|PNG');
						$datas['images'] = 'uploads/partners/'.$image['upload_data']['file_name'];

						if(!empty($this->input->post('partnerid'))){
							unlink(FCPATH.'/'.$this->input->post('oldimage'));
						}
					}
					
					$datas['status']=1;
					if(!empty($this->input->post('partnerid'))){
						$id=decoding($this->input->post('partnerid'));
						$this->sr_model->updateFields(PARTNERS,$datas,array('id'=>$id));
						$insrt=1;
					}else
						$insrt=$this->sr_model->insertData(PARTNERS,$datas);
					if($insrt){
						$this->session->set_flashdata('success_msg','Links added successfully.');
						redirect(site_url('administrator/allpartners')); 
					}else{
						$this->session->set_flashdata('error_msg','Something  went wrong , try again.');
						redirect(site_url('administrator/addpartner'));	
					}

				}else{
					$this->session->set_flashdata('error_msg',validation_errors());
					redirect(site_url('administrator/addpartner')); 
				}
		}else{
			$partnerid=$this->uri->segment(2);
						$headerdata=array();	
			$footerdata=array();
			$maindata=array();
			if($partnerid!=""){

				$partnerid=decoding($partnerid);
				$userdata=$this->sr_model->getsingle(PARTNERS,array('id'=>$partnerid));
				$maindata['userdata']=$userdata;
				$page='addpartner';
				$headerdata['title']='Partners';
				$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
			}else {
				$page='addpartner';
				$headerdata['title']='Partners';
				$this->pageviewadmin($page,$headerdata,$maindata,$footerdata);
			}
		}		
	}

	public function deletepartner(){
		if(isset($_POST['id']) && $_POST['id']!="" ){
			$mid=$_POST['id'];
			$id=decoding($mid);
			$table=$_POST['tablename'];
			$userdata=$this->sr_model->deleteData($table,array('id'=>$id));
			echo json_encode( array('response'=>1,'msg'=>'data deleted successfully'));
		}else{
			echo json_encode( array('response'=>0,'msg'=>'Undefined method !'));
		}
	}

	/***** Partner *******/

	public function deleteSlider($imgID,$pageID){
		$this->sr_model->deleteData(SLIDER,array('id'=>$imgID));
		redirect('administrator/editpage/'.encoding($pageID));
	}

	public function updateDownload(){
		$name = '';
		$fileName = '';
		$postData = $this->input->post();
		if(!empty($_FILES['brochure_image']['name'])){
			$path= "uploads/files/";
			$im_name = $_FILES['brochure_image']['name'];
			$uploadfile = $path.$im_name;
			move_uploaded_file($_FILES['brochure_image']['tmp_name'], $uploadfile);
			$dataUpdate['image'] = $uploadfile;
			$this->sr_model->updateFields(DOWNLOAD,$dataUpdate,array('id'=>1));
		}

		if(!empty($_FILES['brochure_file']['name'])){
			$typeID = 1;
			$name = 'brochure_name';
			$fileName = 'brochure_file';
			$this->uploadMultipleImg($fileName,$name,$postData,$typeID);
		}

		if(!empty($_FILES['manual_image']['name'])){
			$path= "uploads/files/";
			$im_name = $_FILES['manual_image']['name'];
			$uploadfile = $path.$im_name;
			move_uploaded_file($_FILES['manual_image']['tmp_name'], $uploadfile);
			$dataUpdate['image'] = $uploadfile;
			$this->sr_model->updateFields(DOWNLOAD,$dataUpdate,array('id'=>2));
		}

		if(!empty($_FILES['manuals_file']['name'])){
			$typeID = 2;
			$name = 'manuals_name';
			$fileName = 'manuals_file';
			$this->uploadMultipleImg($fileName,$name,$postData,$typeID);
		}

		if(!empty($_FILES['software_image']['name'])){
			$path= "uploads/files/";
			$im_name = $_FILES['software_image']['name'];
			$uploadfile = $path.$im_name;
			move_uploaded_file($_FILES['software_image']['tmp_name'], $uploadfile);
			$dataUpdate['image'] = $uploadfile;
			$this->sr_model->updateFields(DOWNLOAD,$dataUpdate,array('id'=>3));
		}

		if(!empty($_FILES['software_file']['name'])){
			$name = 'software_name';
			$fileName = 'software_file';
			$typeID = 3;
			$this->uploadMultipleImg($fileName,$name,$postData,$typeID);
		}

		if(!empty($_FILES['fliers_image']['name'])){
			$path= "uploads/files/";
			$im_name = $_FILES['fliers_image']['name'];
			$uploadfile = $path.$im_name;
			move_uploaded_file($_FILES['fliers_image']['tmp_name'], $uploadfile);
			$dataUpdate['image'] = $uploadfile;
			$this->sr_model->updateFields(DOWNLOAD,$dataUpdate,array('id'=>4));
		}

		if(!empty($_FILES['fliers_file']['name'])){
			$name = 'fliers_name';
			$fileName = 'fliers_file';
			$typeID = 4;
			$this->uploadMultipleImg($fileName,$name,$postData,$typeID);
		}

		$this->session->set_flashdata('success_msg','Download updated successfully.');
		redirect(site_url('administrator/page_settings'));
	}


	function uploadMultipleImg($fileName,$name,$postData,$typeID){
		if(!empty($_FILES[$fileName]['name'])){
			$filesCount = count($_FILES[$fileName]['name']);
			if($filesCount>0){
				for($i = 0; $i < $filesCount; $i++){
					$_FILES['docfile']['name'] = $_FILES[$fileName]['name'][$i];
					$_FILES['docfile']['type'] = $_FILES[$fileName]['type'][$i];
					$_FILES['docfile']['tmp_name'] = $_FILES[$fileName]['tmp_name'][$i];
					$_FILES['docfile']['error'] = $_FILES[$fileName]['error'][$i];
					$_FILES['docfile']['size'] = $_FILES[$fileName]['size'][$i];
					$config['upload_path'] = 'uploads/documents/';
					$path=$config['upload_path'];
					$config['allowed_types'] = 'doc|docx|pdf|html|xls|xlsx';
					$config['overwrite'] = '1';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload('docfile')){
						$fileData = $this->upload->data();
						$dataInsert['image']  = 'uploads/documents/'.$fileData['file_name'];
						$dataInsert['doc_name'] = $postData[$name][$i];
						$dataInsert['type_id'] = $typeID;
						$ins = $this->sr_model->insertData(DOWNLOAD_DOCUMENTS, $dataInsert);
					}else{
						print_r($this->upload->display_errors());
					}
				}
			}
		}
	}

	public function deleteDocument($imgID,$pageID){
		$this->sr_model->deleteData(DOWNLOAD_DOCUMENTS,array('id'=>$imgID));
		redirect('administrator/editpage/'.encoding($pageID));
	}
}
?>