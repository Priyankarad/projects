<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends SR_Controller{
	
	public function __construct(){
        parent::__construct();
        $this->load->library('pagination');
        $this->load->helper('url');
    }
	public function index(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$page='category';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
	
	public function viewcategory($catid,$pageid=0){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$limit=15;
		$category_id=decoding($catid);
		$categDetails=$this->sr_model->getsingle(CATEGORY,array('id'=>$category_id));
		if(empty($categDetails)){
			redirect(BASEURL);
		}
		$offset=$pageid;
		$condition="status='1' AND FIND_IN_SET('$category_id',category)";
		$userdata=$this->sr_model->getAllwhere(PRODUCT,$condition,'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['products']=$userdata['result'];
		/***Pagination****/
$config = array();
$config["base_url"] = site_url("category/viewcategory/$catid");
//$total_row = $this->pagination_model->record_count();
$config["total_rows"] = $total_count;
$config["per_page"] = 6;
//$config['use_page_numbers'] = TRUE;
$config['num_links'] = $total_count;
$config['full_tag_open'] = '<ul class="pagination my_pagination float-right">';
$config['full_tag_close'] = '</ul><!--pagination-->';
$config['first_link'] = '&larr;';
$config['first_tag_open'] = '<li class="page-item">';
$config['first_tag_close'] = '</li>';
$config['last_link'] = '&rarr;';
$config['last_tag_open'] = '<li class="page-item">';
$config['last_tag_close'] = '</li>';
$config['next_link'] = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
$config['next_tag_open'] = '<li class="page-item">';
$config['next_tag_close'] = '</li>';
$config['prev_link'] = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
$config['prev_tag_open'] = '<li class="page-item">';
$config['prev_tag_close'] = '</li>';
$config['cur_tag_open'] = '<li class="page-item"><a class="page-link active" href="">';
$config['cur_tag_close'] = '</a></li>';
$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';
$config['attributes'] = array('class' => 'page-link');
$this->pagination->initialize($config);

/*	 $config['base_url'] = site_url("category/viewcategory/$catid");
		$config['total_rows'] = $total_count;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 2;
		$config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination my_pagination float-right">';
		$config['full_tag_close'] = '</ul><!--pagination-->';
		$config['first_link'] = '&larr;';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '&rarr;';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item"><a class="page-link active" href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link');
		
        $this->pagination->initialize($config); */
		/*******/
		$maindata['pagination']= $this->pagination->create_links();
		$maindata['category_name']=$categDetails->category;
		$maindata['offset']=$offset;
		$page='categorydetails';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
}