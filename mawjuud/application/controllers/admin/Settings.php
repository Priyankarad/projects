<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct(){
        parent::__construct();
		adminLoginCheck();
    }
	/*To show source feed list*/
	public function sourceFeed()
	{
		$data['title']='Source Feed List';
		$data['feedData'] = $this->common_model->getAllwhere(SOURCE_FEEDS);
		$this->load->view('admin/source_feed',$data);
	}

	/*To add source feed*/
	public function addFeed(){
		$data['title']='Add Feed';
		if($this->input->post()){
			$feedID = $this->input->post('feed_id');
			$dataInsert = array();
			if($this->input->post('source') == 'gomaster'){
				$dataInsert['type'] = $this->input->post('type');
			}
			$dataInsert['source'] = $this->input->post('source');
			$dataInsert['feed'] = $this->input->post('url');
			$feedData = $this->common_model->getsingle(SOURCE_FEEDS,$dataInsert);
			if(empty($feedData)){
				if($feedID){
					$this->session->set_flashdata('success','Source feed updated successfully');
					$this->common_model->updateFields(SOURCE_FEEDS,$dataInsert,array('id'=>$feedID));
				}else{
					$this->session->set_flashdata('success','Source feed added successfully');
					$this->common_model->insertData(SOURCE_FEEDS,$dataInsert);
				}

			}else{
				if($feedData->id != $feedID){
					$this->session->set_flashdata('exist','Source feed already exist');
				}
			}
			redirect('source_feeds');
		}
		$this->load->view('admin/add_source_feed',$data);
	}

	/*To edit source feed*/
	public function editFeed($id){
		$data['title']='Edit Feed';
		$sourceFeedID = decoding($id);
		$data['feedData'] = $this->common_model->getsingle(SOURCE_FEEDS,array('id'=>$sourceFeedID));
		$this->load->view('admin/add_source_feed',$data);
	}

	/*page settings*/
	public function pageSettingsList(){
		$data['title'] = 'Page Settings List';
		$data['pageListing'] = $this->common_model->getAllwhere(PAGE_SETTINGS);
		$this->load->view('admin/page_settings_list',$data);
	}

	/*page update data*/
	public function pageEdit($id){
		$data['title'] = 'Edit Page';
		$pageID = decoding($id);
		$data['pageData'] = $this->common_model->getsingle(PAGE_SETTINGS,array('id'=>$pageID));
		if($this->input->post()){
			$dataUpdate['content'] = $this->input->post('contents'); 
			$this->common_model->updateFields(PAGE_SETTINGS,$dataUpdate,array('id'=>$pageID));
			$this->session->set_flashdata('success','Page updated successfully');
			redirect('page_settings');
		}
		$this->load->view('admin/page_edit',$data);
	}

}