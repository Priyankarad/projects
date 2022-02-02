<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends My_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index($category=""){
		if($category!=""){
			$data['category_data'] = $this->common_model->getAllwhere(CATEGORY,array('slug'=>$category),'id','DESC','','');
			$hdata['seo'] = 'category';
			$this->load->view('frontend/template/header',$hdata);
					$this->load->view('frontend/category_view',$data);
		$this->load->view('frontend/template/footer');
		}else{
	//$data['category_data'] = $this->common_model->getAllwhere(CATEGORY,array('category_status'=>'1','id!='=>1),'id','DESC','','');
	$data['category_data'] = $this->common_model->get_two_table_data('category.*,count(tb_users.id) as cat,tb_users.user_category',CATEGORY,USERS,'category.id= tb_users.user_category',array('category_status'=>'1'),'tb_users.user_category',"cat",'desc');
	
	$data['seo'] = 'category';
	$this->pageview('allcategory',$data,$data,array());
		}
	}
	public function search($category){
		if($category!=""){
			$where = " slug like '%$category%'";
			$category_data = $this->common_model->getAllwhere(CATEGORY,$where,'id','DESC','','');
		
			$category_id=$category_data['result'][0]->id;
			$data['performer_data'] = $this->common_model->getAllwhere(USERS,array('status'=>'verify','user_role'=>'Performer','user_category'=>$category_id),'id','DESC','','');
			if(!empty($data['performer_data']['result'])){
				$count = 0;
				foreach ($data['performer_data']['result'] as $row) {
					$ratingData =  userOverallRatings($row->id);
					if(isset($ratingData['ratingAverage']))
						$data['performer_data']['result'][$count]->ratingAverage = $ratingData['ratingAverage'];
					else
						$data['performer_data']['result'][$count]->ratingAverage = 0;
					$data['performer_data']['result'][$count]->reviewCount = $ratingData['reviewCount'];
					$data['performer_data']['result'][$count]->starRating = $ratingData['starRating'];
					$count++;
				}
			}

			 $this->pageview('category_view',$data,$data,array());
		}else{
		redirect(base_url());	
		}
	}

}