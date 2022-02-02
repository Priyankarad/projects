<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	
/**
 * This Class used as admin management
 * @package   CodeIgniter
 * @category  Controller
 * @author    edit_usernawaz
 */


class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->uid = $this->session->userdata("id");
		$this->session_model->checkAdminSession();
	}

	/**
	 * Function Name: dashboard
	 * Description:   To admin dashboard
	 */
	public function dashboard()
	{
		$data['parent'] = "dashboard";
		$this->template->load('default', 'dashboard',$data);
	}

	/**
	 * Function Name: changepassword
	 * Description:   To change admin password view
	 */
	public function changepassword()
	{
		$data['parent'] = "password";
		$this->template->load('default', 'changepassword',$data);
	}

	/**
	 * Function Name: logout
	 * Description:   To admin logout
	 */
	public function logout()
	{
		$this->session->sess_destroy();
		delete_cookie("work_adviser");
		redirect("admin");
	}
	
	/**
	 * Function Name: dochangepassword
	 * Description:   To change admin password
	 */
	public function dochangepassword()
	{
		if($this->input->is_ajax_request())
		{
			$new_pswd     = base64_decode($this->input->post('new_pswd'));
			$confirm_pswd = base64_decode($this->input->post('confirm_pswd'));
			if(!empty($new_pswd) && !empty($confirm_pswd)){
				if($new_pswd != $confirm_pswd){
					echo json_encode(array('type' => 'failed','msg' => 'Password not matched !'));
				}else{
					$pswdArr = array('password' => do_hash($new_pswd));
					$where   = array('id' => $this->uid);
					if($this->common_model->updateFields(ADMIN,$pswdArr,$where)){
						echo json_encode(array('type' => 'success','msg' => 'Password successfully changed !'));
					}else{
						echo json_encode(array('type' => 'failed','msg' => 'You didn`t have any changes !'));
					}
				}
			}else{
				echo json_encode(array('type' => 'failed','msg' => 'Failed please try again !'));
			}
		}
	}


	/**
	 * Function Name: users
	 * Description  : To get all users
	 */
	public function users()
	{
		$config['parent'] = "users";
		$config['users']  = $this->common_model->getAllwhere(USERS,array('user_role'=>'Performer'),'id','DESC');
		// pr($config['users']);
		$this->template->load('default', 'users',$config);
	}


	/**
	 * Function Name: users_details
	 * Description  : To get single users
	 */
	public function performer_details($user_id = "")
	{
		$config['parent'] = "users";
		$userId = decoding($user_id);
		$config['performer_details']  = $this->common_model->getSingle(USERS,array('id'=>$userId));
		// pr($config['users']);
		$this->template->load('default', 'users/performer_details',$config);
	}


/**
	 * Function Name: users
	 * Description  : To get all users
	 */
	public function employers()
	{
		$config['parent'] = "Employers";
		$config['users']  = $this->common_model->getAllwhere(USERS,array('user_role'=>'Employer'),'id','DESC');
		$this->template->load('default', 'users/employer',$config);
	}

	/**
	 * Function Name: delete_users
	 * Description  : To delete user
	 */
	public function delete_users($user_id = "")
	{
		$id = decoding($user_id);
		
		$deleteItem = $this->common_model->deleteData(USERS,array('id'=>$id));
		if($deleteItem){
			redirect('admin/users');
		}
	}

	/**
	 * Function Name: aproved_categories
	 * Description  : To get all Aproved Categories
	 */
	public function aproved_categories()
	{
		$config['parent'] = "Aproved_Categories";
		$config['categories']  = $this->common_model->getAllwhere(CATEGORY,array('category_status'=>1));
		$this->template->load('default', 'categories/aproved_category_list',$config);
	}

	/**
	 * Function Name: unAprovedCategories
	 * Description  : To get all Unaproved Categories
	 */
	public function unAprovedCategories()
	{
		$config['parent'] = "Unaproved_Categories";
		$config['categories']  = $this->common_model->getAllwhere(CATEGORY,array('category_status'=>0));
		$this->template->load('default', 'categories/unaproved_category_list',$config);
	}

	/**
	 * Function Name: addCategoryForm
	 * Description  : To Add category Form
	 */
	public function addCategoryForm()
	{
		$config['parent'] = "Aproved_Categories";
		$this->template->load('default', 'categories/categoryAdd',$config);
	}

	/**
	 * Function Name: categoryAdd
	 * Description:   To Add New Category
	 */
	public function categoryAdd(){
		$config['parent'] = "Aproved_Categories";
		$data = $this->input->post();
		$this->form_validation->set_rules('categoryName','Category Name','trim|required');
		// $this->form_validation->set_rules('que_[]','Questions','trim|required');
		// $this->form_validation->set_rules('que_1[]','Questions','trim|required');
		if($this->form_validation->run() == FALSE) 
        { 
        	$this->template->load('default', 'categories/categoryAdd',$config);
        }
        else
        {
	      $dataArr = array();
	       if(isset($_FILES['category_image']['name']) && !empty($_FILES['category_image']['name']))
            {
                /* Upload user image */
                $image = fileUploading('category_image','category_images','png|jpg|jpeg|gif');
                if(isset($image['error'])){
                    $return['status']         =   0; 
                    $return['message']        =   strip_tags($image['error']);
                    $this->response($return);exit;
                }else{
                    $dataArr['category_image']    =  'uploads/category_images/'.$image['upload_data']['file_name'];
					$dataArr['category_image_thumb']  = get_image_thumb($dataArr['category_image'],'category_images',500,500);
                }
            }
	      $dataArr['name']  			= extract_value($data,'categoryName','');
	      $dataArr['category_status']  	= 0;
	      $slugArr = explode(" ",extract_value($data,'categoryName',''));
	      $slug = isset($slugArr[0])?$slugArr[0]:'';
	      $dataArr['slug'] = $slug;
	      $dataArr['created_date'] 		= date('Y-m-d H:i:s');
          $addCat = $this->common_model->insertData(CATEGORY,$dataArr);
          if($addCat){
          	if($this->input->post('que_')){
          		$ques = array();
          		$employeeQ = $this->input->post('que_');
          		foreach($employeeQ as $row){
          			$que['category_id'] = $addCat;
          			$que['user_type'] = 'Employee';
          			$que['question'] = $row;
          			$ques[] = $que;
          		}
          		$this->db->insert_batch(CATEGORY_QUESTIONS, $ques);
          	}
          	if($this->input->post('que_1')){
          		$ques = array();
          		$employeeQ = $this->input->post('que_1');
          		foreach($employeeQ as $row){
          			$que['category_id'] = $addCat;
          			$que['user_type'] = 'Employer';
          			$que['question'] = $row;
          			$ques[] = $que;
          		}
          		$this->db->insert_batch(CATEGORY_QUESTIONS, $ques);
          	}

            $this->session->set_flashdata('success', 'Category added successfully');
          	
          }else{
          	$this->session->set_flashdata('error', 'Failedplease try again');
          }
          redirect('admin/aproved_categories');
		}
		
	}


	/**
	 * Function Name: editCategoryForm
	 * Description  : To Edit category Form
	 */
	public function editCategoryForm($category_id = '')
	{
		$config['parent'] = "Categories";
		$cate_id = decoding($category_id);
		$config['categoryData'] = $this->common_model->get_two_table_data('category.*,category_questions.*',CATEGORY,CATEGORY_QUESTIONS,'category.id = category_questions.category_id',array('category.id'=>$cate_id),$groupby="");
		// pr($config['categoryData']);
		$config['cate_id'] = $cate_id;
		$this->template->load('default', 'categories/category_edit',$config);
	}



	/**
	 * Function Name: categoryEdit
	 * Description:   To Edit New Category
	 */
	public function categoryEdit(){
		$config['parent'] = "Categories";
		$data = $this->input->post();
		$this->form_validation->set_rules('categoryName','Category Name','trim|required');
		// $this->form_validation->set_rules('que_[]','Questions','trim|required');
		// $this->form_validation->set_rules('que_1[]','Questions','trim|required');
		$id = extract_value($data,'ids','');
		if($this->form_validation->run() == FALSE) 
        { 
		 	$config['parent'] = "Categories";
			$config['categoryData'] 	= getSingleRecord(CATEGORY,array('id'=>$id));
			$this->template->load('default', 'categories/category_edit',$config);
        }
        else
        {
          $id = extract_value($data,'ids','');
	      $dataArr = array();
	       if(isset($_FILES['category_image']['name']) && !empty($_FILES['category_image']['name']))
            {
                /* Upload user image */
                $image = fileUploading('category_image','category_images','png|jpg|jpeg|gif');
				
                if(isset($image['error'])){
                    $return['status']         =   0; 
                    $return['message']        =   strip_tags($image['error']);
                    $this->session->set_flashdata('error',$return['message']);
					 redirect('admin/aproved_categories');
                }else{
                    $dataArr['category_image']    =  'uploads/category_images/'.$image['upload_data']['file_name'];
					$dataArr['category_image_thumb']  = get_image_thumb($dataArr['category_image'],'category_images',500,500);
                } 
            }

	      $dataArr['name']  			= extract_value($data,'categoryName','');
        
          $updateCategory = $this->common_model->updateFields(CATEGORY,$dataArr,array('id'=>$id));
          if(true){

          	$ids = $this->input->post('id');//array of ids

          	$employeeData = getSingleRecord(CATEGORY_QUESTIONS,array('category_id'=>$id,'user_type'=>'Employee'));
          	if(!empty($employeeData)){
	          	if($this->input->post('que_')){
	          		$ques = array();
	          		$employeeQ = $this->input->post('que_');
	          		$count = 0;
	          		foreach($employeeQ as $row){
	          			$que['question'] = $row;
	          			$this->common_model->updateFields(CATEGORY_QUESTIONS,$que,array('id'=>$ids[$count]));
	          			$count++;
	          		}
	          	}
	        }else{
	        	if($this->input->post('que_')){
	        		$ques = array();
	        		$employeeQ = $this->input->post('que_');
	        		foreach($employeeQ as $row){
	        			$que['category_id'] = $id;
	        			$que['user_type'] = 'Employee';
	        			$que['question'] = $row;
	        			$ques[] = $que;
	        		}
	        		$this->db->insert_batch(CATEGORY_QUESTIONS, $ques);
	        	}
	        }

	        $employeeData = getSingleRecord(CATEGORY_QUESTIONS,array('category_id'=>$id,'user_type'=>'Employer'));
	        if(!empty($employeeData)){
	          	if($this->input->post('que_1')){
	          		$ques = array();
	          		$employeeQ = $this->input->post('que_1');
	          		$count = 5;
	          		foreach($employeeQ as $row){
	          			$ques['question'] = $row;
	          			$this->common_model->updateFields(CATEGORY_QUESTIONS,$ques,array('id'=>$ids[$count]));
	          			$count++;
	          		}
	          	}
	        }else{
	        	if($this->input->post('que_1')){
	        		$ques = array();
	        		$employeeQ = $this->input->post('que_1');
	        		foreach($employeeQ as $row){
	        			$que['category_id'] = $id;
	        			$que['user_type'] = 'Employer';
	        			$que['question'] = $row;
	        			$ques[] = $que;
	        		}
	        		$this->db->insert_batch(CATEGORY_QUESTIONS, $ques);
	        	}
	        }
          	$this->session->set_flashdata('success', 'Category Updated successfully');
          	
          }
          // else{
          // 	$this->session->set_flashdata('error', 'Not found Any Changes');
          // }
          redirect('admin/aproved_categories');
   //        		echo json_encode(array('type' => 'success', 'msg' => 'Category Updated successfully','url'=>base_url().'admin/categories'));exit;
			// }else{
			// 	echo json_encode(array('type' => 'failed', 'msg' => 'Not found Any Changes','url'=>base_url().'admin/categories'));exit;
			// }
		}
		
	}
	
	/**
	 * Function Name: aprove_category
	 * Description  : To aprove category
	 */
	public function aprove_category($category_id = "")
	{
		$id = decoding($category_id);

		
		$deleteItem = $this->common_model->updateFields(CATEGORY,array('category_status'=>1),array('id'=>$id));
		if($deleteItem){
			$this->session->set_flashdata('success', 'Category Aproved successfully');
			redirect('admin/aproved_categories');
		}
	}
	
	

	/**
	 * Function Name: delete_category
	 * Description  : To delete category
	 */
	public function delete_aproved_category($category_id = "")
	{
		$id = decoding($category_id);
		
		$deleteItem = $this->common_model->deleteData(CATEGORY,array('id'=>$id));
		if($deleteItem){
			redirect('admin/aproved_categories');
		}
	}

	/**
	 * Function Name: delete_category
	 * Description  : To delete category
	 */
	public function delete_unaproved_category($category_id = "")
	{
		$id = decoding($category_id);
		
		$deleteItem = $this->common_model->deleteData(CATEGORY,array('id'=>$id));
		if($deleteItem){
			redirect('admin/unAprovedCategories');
		}
	}

    /**
	 * Function Name: users payment history
	 * Description  : To get all users payment history
	 */
	public function payment_history()
	{
		$data['parent'] = "Payment History";
		$info='payment_details.*,tb_users.firstname,tb_users.lastname';
        $relation = 'tb_users.id = payment_details.user_id';
        $data['paymentData'] = $this->common_model->get_two_table_data($info,USERS,PAYMENT_DETAILS,$relation,'user_id IS NOT NULL',$groupby="",'payment_details.id','DESC');
		$this->template->load('default', 'users/payment_history',$data);
	}

	    /**
	 * Function Name: edit_user
	 * Description  : To edit user details
	 */
	public function edit_user($user_id,$employer = false)
	{
		$this->session->set_userdata('employer','');
		$userID = decoding($user_id);
		$data['userData'] = $this->common_model->getSingle(USERS,array('id'=>$userID));
		$data['categoryData'] = $this->common_model->getAllwhere(CATEGORY);
		if($employer){
			$this->session->set_userdata('employer','employer');
		}
		$this->template->load('default', 'users/edit_user',$data);
	}

	/**
	* Function Name: update_userdetails
	* Description  : To update user details
	*/
	public function update_userdetails()
	{
		if($this->input->post('user_id')){
			$datatUpdate['firstname'] = $this->input->post('fname'); 
			$datatUpdate['lastname'] = $this->input->post('lname'); 
			$datatUpdate['phone'] = $this->input->post('contact'); 
			$datatUpdate['user_category'] = $this->input->post('category'); 
			$datatUpdate['city'] = $this->input->post('city'); 
			$datatUpdate['state'] = $this->input->post('state'); 
			$datatUpdate['country'] = $this->input->post('country'); 
			$datatUpdate['website_link'] = $this->input->post('link'); 
			$datatUpdate['professional_skill'] = $this->input->post('prof_skills'); 
			$datatUpdate['additional_services'] = $this->input->post('add_services'); 
			$this->common_model->updateFields(USERS,$datatUpdate,array('id'=>$this->input->post('user_id')));
			if($this->session->userdata('employer')){
				$this->session->set_flashdata('success', 'Employer updated successfully');
				redirect('admin/employers');
			}else{
				$this->session->set_flashdata('success', 'User updated successfully');
				redirect('admin/users');
			}
		}else{
			echo json_encode(array('response'=>'Request Failed'));
		}
	}

	

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
