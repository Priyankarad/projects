<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Standard extends SR_Controller{
	public function __construct(){
        parent::__construct();
        $this->load->library('pagination');
        $this->load->helper('url');
    }
/***********************************************/
/***********************************************/
/***********************************************/
	public function index(){
		redirct(site_url('standards'));
	}
/***********************************************/
/******************VIEW-MARKET************************/
/***********************************************/
	public function view($marketids="",$pageid=0){
		if($marketids==""){
			redirct(site_url('standards'));
		}
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$marketid=decoding($marketids);
		$mktdtl=$this->sr_model->getsingle(STANDARD,array('id'=>$marketid));
		if(empty($mktdtl)){
         	redirect(BASEURL);		
		}
		$limit=6;
		$offset=$pageid;
	   // echo "<pre>";
	//	$this->db->select('*');
       // $this->db->from('product');
        $where = "FIND_IN_SET($marketid, standard)";  
		$userdata=$this->sr_model->getAllwhereIn(PRODUCT,$where,'','','id','DESC','all',$limit,$offset,'','');
	  
		$total_count=$userdata['total_count'];
		$maindata['products']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('standard/view/'.$marketids.'/');
	$config["total_rows"] = $total_count;
$config["per_page"] = 6;
$config['use_page_numbers'] = TRUE;
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
		/*******/
		$maindata['pagination']= $this->pagination->create_links();
		$maindata['offset']=$offset;
		$maindata['mktdtl']=$mktdtl;
		$userdata2=$this->sr_model->getAllwhere(STANDARD,array('status'=>0),'id','DESC','all');
		$maindata['standards']=$userdata2['result'];
		$page='standards';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/******************VIEW-MARKET************************/
/***********************************************/
}