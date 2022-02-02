<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Other_user extends CI_Controller {

	public function index()
	{		
		$abc['abc'] = 1;
	}

	/**
	 * Function Name: profile
	 * Description  : To Show Profile
	 */
	public function profile($user_id = '')
	{
		$id = decoding($user_id);
		$data['user_data'] = $this->common_model->getsingle(USERS,array('id'=>$id));
		$this->load->view('frontend/other_user_profile',$data);
	}
}

 ?>