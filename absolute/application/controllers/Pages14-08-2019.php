<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pages extends SR_Controller{
	public function __construct(){
        parent::__construct();
        $this->load->library('pagination');
        $this->load->helper('url');
    }
/***********************************************/
/***********************************************/
/***********************************************/
	public function index(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$page='index';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/******************ABOUT************************/
/***********************************************/
	public function about(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$aboutData = $this->sr_model->getAllwhere(PAGES,array('page'=>1));
		$maindata['aboutData'] = $aboutData['result'];
		$page='about';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/****************SERVICES***********************/
/***********************************************/
	public function services(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$serviceData = $this->sr_model->getAllwhere(PAGES,array('page'=>2));
		if(!empty($serviceData)){
			$maindata['serviceData'] = $serviceData['result'];
		}
		$page='services';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	} 
/***********************************************/
/****************INFORMATION***********************/
/***********************************************/
	public function information(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$page='information';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
	public function standards($pageid=0){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$limit=150;
		$offset=$pageid;
		$userdata=$this->sr_model->getAllwhere(PRODUCT,array('status'=>1),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['products']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('standards/');
		$config['total_rows'] = $total_count;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 2;
		$config['num_links'] = 2;
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
		
		$userdata2=$this->sr_model->getAllwhere(STANDARD,array('status'=>0),'id','DESC','all');
		$maindata['standards']=$userdata2['result'];
		$page='standards';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
	public function articles($pageid=0){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$limit=4;
		$offset=$pageid;
		$userdata=$this->sr_model->getAllwhere(ARTICLE,array('status'=>0),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['articles']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('articles/');
		$config['total_rows'] = $total_count;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 2;
		$config['num_links'] = 2;
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
		$page='articles';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
	
   public function articledetails($articalid=""){
	   if($articalid!=""){
		 $id=decoding($articalid);
		 $userdata=$this->sr_model->getsingle(ARTICLE,array('id'=>$id));
		 if(empty($userdata)){
			 redirect(site_url('articles'));
		 }
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$maindata['article']=$userdata;
		$page='singleblog';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	   }else{
		   redirect(site_url('articles'));
	   }
	}
   public function download(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array  ();
		$page='download';
		$maindata['documents'] = $this->sr_model->getAllwhere(DOWNLOAD);
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}

	public function downloadDocuments($type){
		$id = decoding($type);
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$maindata['documents'] = $this->sr_model->getAllwhere(DOWNLOAD_DOCUMENTS,array('type_id'=>$id));
		$page='download_documents';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}

   public function links($pageid=0){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
        $limit=150;
		$offset=$pageid;
		$userdata=$this->sr_model->getAllwhere(LINKS,array('status'=>0),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['links']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('links/');
		$config['total_rows'] = $total_count;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 2;
		$config['num_links'] = 2;
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
		$page='links';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*****************CONTACT***********************/
/***********************************************/
	public function contact(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$page='contact';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*****************LOGIN***********************/
/***********************************************/
	public function login(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$page='login';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
	
/***********************************************/
/*****************PARTNERS***********************/
/***********************************************/
	public function partners(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$partners=$this->sr_model->getAllwhere(PARTNERS,array('status'=>1),'id','DESC','all',150,0);
		$maindata['partnerslist']=$partners;
		$page='partners';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*****************PRODUCTS***********************/
/***********************************************/
	public function products($pageid=0){

		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$limit=9;
		$offset=$pageid;
		$userdata=$this->sr_model->getAllwhere(PRODUCT,array('status'=>1),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['products']=$userdata['result'];
		/***Pagination****/
		$config['base_url'] = site_url('products/');
		$config['total_rows'] = $total_count;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 2;
		$config['num_links'] = 2;
		//$config['use_page_numbers'] = TRUE;
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
		
		$page='products';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*****************MARKETS***********************/
/***********************************************/
	public function markets($pageid=0){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$limit=150;
		$offset=$pageid;
		$userdata=$this->sr_model->getAllwhere(MARKET,array('status'=>0),'id','DESC','all',$limit,$offset);
		$total_count=$userdata['total_count'];
		$maindata['markets2']=$userdata['result'];
		
		/***Pagination****/
		$config['base_url'] = site_url('markets/');
		$config['total_rows'] = $total_count;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 2;
		$config['num_links'] = 2;
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
		$page='markets';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*****************SCHWARZBECK********************/
/***********************************************/
	public function singlepartners(){
		$partnerid=$this->uri->segment(2);
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$partnerid=decoding($partnerid);
		$userdata=$this->sr_model->getsingle(PARTNERS,array('id'=>$partnerid));
		$maindata['partnerdata']=$userdata;
		$page='singlepartner';
		$where = " FIND_IN_SET(".$partnerid.",partners)!=0";
		$partnersProduct=$this->sr_model->getAllwhere(PRODUCT,$where);
		$maindata['partnersProduct']=$partnersProduct['result'];
		//$headerdata['title']='singlepartner';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*****************MESSTECHNIK***********************/
/***********************************************/
	public function messtechnik(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$page='messtechnik';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*****************ANTENNAS***********************/
/***********************************************/
	public function antennas(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$page='antennas';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*****************Cart***********************/
/***********************************************/
	public function cart(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$maindata['cartdata']=$this->cart->contents();
		$page='cart';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/*****************Cart***********************/
/***********************************************/
	public function proceed(){
		$this->form_validation->set_rules('alltotal', 'Total', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$alltotal=$this->input->post('alltotal');
			$discount=$this->input->post('discount');
			$promocode=$this->input->post('promocode');
			
			$this->session->set_userdata('finalpay',array('cartdata'=>$this->cart->contents(),'discount'=>$discount,'promocode'=>$promocode));
			redirect(site_url('checkout'));
		}else{
		$this->session->set_flashdata('error_msg',validation_errors());
		redirect(site_url('cart')); 	
		}
		
	}
	public function checkout(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$countries_res=$this->sr_model->getAllwhere('countries',array(),'name','ASC','all');
		$countries=$countries_res['result'];
		$allcountries="";
		foreach($countries as $country){
		$allcountries.='<option value="'.$country->id.'">'.$country->name.'</option>';	
		}
		$maindata['allcountries']=$allcountries;
		$maindata['cartdata']=$this->cart->contents();
		$page='checkout';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}

/***********************************************/
/*****************ANTENNAS***********************/
/***********************************************/
	public function rmatickets($id=''){
	    if(empty($id)){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$page='RMA-ticket';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	
	    }else{
	    $data=$this->input->post();
	    extract($data);
	    $fename=$fname." ".$lname;
	  $message="
		<div>
		<h2>CREATE RMA / TICKET</h2>
		Name- ".$fename."<br>
	    Company- ".$company."<br>
	    Address- ".$address."<br>
	    City- ".$city."<br>
	    State / Territory- ".$state."<br>
	    Country- ".$country."<br>
	    Zip / Territory Code- ".$zip."<br>
	    Phone- ".$phone."<br>
	    Email- ".$email."<br>
	    RMA- ".$rma."<br>
	    Model / Part Number- ".$modal_no."<br>
	    Part Description- ".$description."<br>
	    Serial- ".$serial."<br>  
	    Detailed description- ".$calibration."<br>
		<p></p>
		</div>";
	     
	    echo send_mail($message,'you have received new ticket','info@absolute-emc.com',$data['email']);
	    
	    }
	}
/***********************************************/
/*****************ANTENNAS***********************/
/***********************************************/
	public function singleblog(){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$page='singleblog';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}
/***********************************************/
/***********************************************/
}	
?>