<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PN_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	 	 
	/***************Admin*****************/
	 public function pageviewadmin($page,$headerdata=array(),$maindata=array(),$footerdata=array()){
		 $this->load->view('admin/includes/header',$headerdata);
		 $this->load->view('admin/'.$page,$maindata);
		 $this->load->view('admin/includes/footer',$footerdata);
	 }	
	/********************************/
	/********************************/
    public function checkAdminlogin(){
			      if($this->session->userdata('admin_id')){
						return true;
			      }else{
					 $this->session->set_flashdata('loginerror','Please login.'); 
			         redirect(BASEURL);
			      }
    }
    /********************************/
    /********************************/
    public function deleteData(){
    	$tableName = $this->input->post('table_name');
    	$record = $this->input->post('record');
    	if($this->sr_model->deleteData($tableName,array('id'=>$record))){
    		echo json_encode(array('status'=>1));
    	}
    }
	/*************************************/
	/*************************************/
	public function sendEmail($from,$fromname,$to,$subject,$message){
        $this->load->library('email');
		$config = array ('mailtype' => 'html','charset'  => 'utf-8','priority' => '1');
        $this->email->initialize($config);
        $this->email->from($from,$fromname);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
         return$this->email->send();
		 
    	}
	/*to delete data*/
	public function delete_data($redirect,$tablename,$type,$id){
		$this->common_model->deleteData($tablename,array('id'=>decoding($id)));
		$this->session->set_flashdata('success',ucfirst($type).' deleted successfully');
            redirect(site_url($redirect));
	}
  /*************************************/
  /*************************************/
}