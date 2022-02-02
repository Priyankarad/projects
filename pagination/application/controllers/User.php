<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){
		
        parent::__construct();
        $this->load->helper('url');

        // Load session
        $this->load->library('session');

        // Load Pagination library
		$this->load->library('pagination');

		// Load model
		$this->load->model('Main_model');
	}

	public function index(){
		redirect('User/loadRecord');
	}

	public function loadRecord($rowno=0){
		$search_text = "";
		
		if($this->input->post('submit') != NULL ){
			$search_text = $this->input->post('search');
			$this->session->set_userdata(array("search"=>$search_text));
		}else{
			if($this->session->userdata('search') != NULL){
				$search_text = $this->session->userdata('search');
			}
		}
		$rowperpage = 5;
		if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
		}
      	$allcount = $this->Main_model->getrecordCount($search_text);
      	$users_record = $this->Main_model->getData($rowno,$rowperpage,$search_text);
      	$config['base_url'] = base_url().'/User/loadRecord';
      	$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['row'] = $rowno;
		$data['search'] = $search_text;
		$this->load->view('user_view',$data);
		
	}

}