<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends My_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		redirect(base_url());
	}
/*********************************************/	
	public function search($search_by_industry = false){
		if(!empty($search_by_industry)){
			$where = " slug like '%$search_by_industry%'";
			$category_data = $this->common_model->getAllwhere(CATEGORY,$where,'id','DESC','','');
			$category_id = $category_data['result'][0]->id;
			$category_name = $category_data['result'][0]->name; 
			if(get_current_user_id()){
				$data = $this->common_model->getAllwhere(USERS,array('status'=>'verify','user_category'=>$category_id,'id!='=>get_current_user_id()),'id','DESC','','');
			}else{
				$data = $this->common_model->getAllwhere(USERS,array('status'=>'verify','user_category'=>$category_id),'id','DESC','','');
			}
			$this->session->set_userdata('categories_id',$category_id);
			if($data['total_count']==0){
				$this->session->set_userdata('searchResults',array('data'=>array(),'tags'=>''));		
			}else{
				$this->session->set_userdata('searchResults',array('data'=>$data['result'],'tags'=>''));	
			}
			$this->session->set_userdata('categories_id',$category_id);
			redirect(site_url('search/searchresults/?category='.$category_name));
		}
		else{
			$this->session->unset_userdata('categories_id');
			$this->session->set_userdata('searchResults','');	
			$this->form_validation->set_rules('searchTags', 'Tags', 'required');
			$tags=$this->input->post('searchTags');
			$user = get_current_user_id();
			$userData = $this->common_model->getsingle(USERS,array('id'=>$user));
			$data['userRole']='';
			if(!empty($userData)){
				$data['userRole'] = $userData->user_role;
			}
			$sql = '';
	        if ($this->form_validation->run() == TRUE){
	        	$tags=$this->input->post('searchTags');
	        	$ntg=explode(' ',$tags);
				$fname="";
				$lname="";
				if(count($ntg)>1){
					$fname=$ntg[0];
					$lname=$ntg[1];
				}else if(count($ntg) == 1){
					//$fname=$ntg[0];
					$fname=$tags;
				}

				$catIds=array();
				$categ=$this->common_model->getAllwhere(CATEGORY,"name LIKE '%$tags%' AND category_status='1'");
				if(!empty($categ['result'])){
					foreach($categ['result'] as $catg){
					$catIds[]=$catg->id;
					}
				}
				$categQuery="";
				if(!empty($catIds)){
					$categoryids=implode(',',$catIds);
					$categQuery=" AND (user_category IN(".$categoryids.") and user_category!=1)";
				}

	        	$locality=trim($this->input->post('locality'));
			    $city=trim($this->input->post('city'));
			    $state=trim($this->input->post('state'));
				$country=trim($this->input->post('country'));
				$postal_code=trim($this->input->post('postal_code'));
				$sql.='1=1 AND active=1 AND status="verify"';

	        	if($locality!=''){
	        		$sql.= "  AND (city LIKE '%$locality%' OR country LIKE '%$locality%' OR state LIKE '%$locality%' OR zip LIKE '%$locality%')";
	        	}
	        	else if($state!=''){
	        		$sql.= " AND (city LIKE '%$state%' OR country LIKE '%$state%' OR state LIKE '%$state%' OR zip LIKE '%$state%')";
	        	}
	        	else if($country!=''){
	        		$sql.= " AND (city LIKE '%$country%' OR country LIKE '%$country%' OR state LIKE '%$country%' OR zip LIKE '%$country%')";
	        	}
	        	else if($postal_code!=''){
	        		$sql.= " AND (city LIKE '%$postal_code%' OR country LIKE '%$postal_code%' OR state LIKE '%$postal_code%' OR zip LIKE '%$postal_code%')";
	        	}
	        	else if($locality=='' &&  $state=='' && $country=='' && $postal_code=='' && $city!=''){
	        		$sql.= " AND (city LIKE '%$city%' OR country LIKE '%$city%' OR state LIKE '%$city%' OR zip LIKE '%$city%')";
	        	}
	        	$fqry="";
				if($fname!="" && $lname!="" ){
					$fqry="OR (firstname like '$fname%' AND lastname like '$lname%')";	
				}
				if($fname!="" && $lname==""){
					$fqry="OR (firstname like '$fname%')";	
				}
	        	// if(!empty($fname) && !empty($lname)){
	        	// 	$sql.= "AND ((firstname LIKE '%$fname%' AND  lastname LIKE '%$lname%') OR (firstname LIKE '%$lname%' AND  lastname LIKE '%$fname%'))";
	        	// }else if(!empty($fname)){
	        	// 	$sql.= "AND (firstname LIKE '%$fname%' OR  lastname LIKE '%$fname%')";
	        	// }

	        	$ntags=str_replace(' ','',$tags);
				$data = $this->common_model->getAllwhere(USERS,$sql." AND (FIND_IN_SET('$tags',professional_skill) OR FIND_IN_SET('$ntags',REPLACE(professional_skill,' ','')) OR FIND_IN_SET('$tags',additional_services) OR FIND_IN_SET('$ntags',REPLACE(additional_services,' ','')) ".$fqry." OR firstname LIKE '%$tags%' OR lastname LIKE '%$tags%' OR business_name LIKE '%$tags%' OR current_position like '%$tags%'  ".$categQuery." and tb_users.id!='$user' )", 'id', 'DESC','all','','','','');
				
				//$data = $this->common_model->getAllwhere(USERS,$sql, 'id', 'DESC','all','','','','');

				if($data['total_count']==0){
				$this->session->set_userdata('searchResults',array('data'=>array(),'tags'=>$tags,'state'=>$state,'country'=>$country,'city'=>$city,'locality'=>$locality));		
				}else{
				$this->session->set_userdata('searchResults',array('data'=>$data['result'],'tags'=>$tags,'state'=>$state,'country'=>$country,'city'=>$city,'locality'=>$locality));	
				}
				redirect(site_url('search/searchresults/'));
			}else{
			
				$this->session->set_userdata('error','validation Error');
				redirect(base_url());	
			}
		}		
	}
/***************** Search Results *****************/
	public function searchresults(){
		$page="searchresult";
		$headerdata=array();
		$maindata=array();
		$footerdata=array();
		if($this->session->userdata('searchResults')){
			$user = get_current_user_id();
			$userData = $this->common_model->getsingle(USERS,array('id'=>$user));
			$maindata['userRole']='';
			if(!empty($userData)){
				$maindata['userRole'] = $userData->user_role;
			}
			$aldata=$this->session->userdata('searchResults');
			$maindata['results']=$aldata['data'];
			$maindata['tags']=$aldata['tags'];
			$maindata['locality']=isset($aldata['locality'])?$aldata['locality']:'';
			$maindata['user_data']= $userData;
			$maindata['categoryData']=$this->common_model->getAllwhere(CATEGORY,"category_status='1'");
			$this->pageview($page,$headerdata,$maindata,$footerdata);
		}else{
			$maindata['categoryData']=$this->common_model->getAllwhere(CATEGORY,"category_status='1'");
			$this->pageview($page,$headerdata,$maindata,$footerdata);
			//redirect(base_url());
		}
	}
/*********************************************/	


/*************Search Filter*******************/
public function searchFilter(){
	if($this->input->post('searchTags') || $this->session->userdata('categories_id')){

		if($this->session->userdata('categories_id'))
		{
			$extqury="(1=1)";
			$catIds=array();
			$catCount = 0;
			//$catIds[] = $this->session->userdata('categories_id');
			if($this->input->post('category')){
				foreach($this->input->post('category') as $cat){
					$catIds[] = $cat;
				}
			}else{
				$catIds[] = $this->session->userdata('categories_id');
			}
			$categQuery="";
			if(!empty($catIds)){
				$catCount++;
				$categoryids=implode(',',$catIds);
				$categQuery=" AND (user_category IN(".$categoryids.") and user_category!=1)";
			}
			$profile='';
			if($this->input->post('profile')){
				if($this->input->post('profile') == 1){
					$profile = 'AND user_role = "Employer"';
				}else{
					$profile = 'AND user_role = "Performer"';
				}
			}
			$data = $this->common_model->getAllwhere(USERS,$extqury." AND active='1' ".$profile." ".$categQuery, 'id', 'DESC','all','','','','');
			// lq();
		}else{
			$tags=$this->input->post('searchTags');
			$tagArr=explode(' ',$tags);
			$fname="";
			$lname="";
			if(count($tagArr)>1){
				$fname=$tagArr[0];
				$lname=$tagArr[1];
			}
			if(count($tagArr) == 1){
				$fname=$tagArr[0];
			}


			$sessionData = $this->session->userdata('searchResults');
			$locality=trim($this->input->post('locality'));
			$city=trim($this->input->post('city'));
			$state=trim($this->input->post('state'));
			$country=trim($this->input->post('country'));

			$catIds=array();
			$catCount = 0;
			$categ=$this->common_model->getAllwhere(CATEGORY,"name LIKE '%$tags%' AND category_status='1'");
			if(!empty($categ['result'])){
				foreach($categ['result'] as $catg){
					$catCount++;
					$catIds[]=$catg->id;
				}
			}

			if($this->input->post('category')){
				foreach($this->input->post('category') as $cat){
					$catIds[] = $cat;
				}
			}

			$categQuery="";
			if(!empty($catIds)){
				$catCount++;
				$categoryids=implode(',',$catIds);
				$categQuery=" AND (user_category IN(".$categoryids.") and user_category!=1)";
			}

			$extqury="(1=1)";
			if($state!=""){
				$extqury="state LIKE '%$state%'";
			}else if($country!=""){
				$extqury="country LIKE '%$country%'";
			}else if($city!=""){
				$extqury="(city LIKE '%$city%' or country LIKE '%$city%')";
			}else if($locality!=""){
				$extqury="city LIKE '%$locality%'";
			}else{
				$extqury="(1=1)";
			}
			$fqry="";
			if($fname!="" && $lname!="" ){
				$fqry="OR (firstname like '$fname%' AND lastname like '$lname%')";	
			}
			$ntags=str_replace(' ','',$tags);

			$profile='';
			if($this->input->post('profile')){
				if($this->input->post('profile') == 1){
					$profile = 'AND user_role = "Employer"';
				}else{
					$profile = 'AND user_role = "Performer"';
				}
			}


			// if($catCount){
			// 	$data = $this->common_model->getAllwhere(USERS,$extqury." AND active='1' ".$profile." ".$categQuery." AND (firstname like '%$fname%' AND lastname like '%$lname%')", 'id', 'DESC','all','','','','');
			// }else{
				$data = $this->common_model->getAllwhere(USERS,$extqury." AND active='1' ".$profile." ".$categQuery." AND (FIND_IN_SET('$tags',professional_skill) OR FIND_IN_SET('$ntags',REPLACE(professional_skill,' ','')) OR FIND_IN_SET('$tags',additional_services) OR FIND_IN_SET('$ntags',REPLACE(additional_services,' ','')) ".$fqry." OR firstname LIKE '%$tags%' OR lastname LIKE '%$tags%' OR business_name LIKE '%$tags%'  OR current_position like '%$tags%'  )", 'id', 'DESC','all','','','','');
			//}
 // lq();
		}



		if(!empty($data['result'])){
			$count = 0;
			foreach($data['result'] as $row){
				$ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$row->id));
				$data['reviewCount'] = $ratingDetails['total_count'];
				if(!empty($ratingDetails['result'])){
					$ratingAverage=0;
					$reviewCount  = $ratingDetails['total_count'];
					foreach($ratingDetails['result'] as $row){
						$average = 0;
						$total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
						if($total>0){
							$average = $total/5;
						}
						$ratingAverage+=$average;
					}
					if($ratingAverage>0)
						$data['result'][$count]->ratingAverage = floor($ratingAverage/$reviewCount);
					else
						$data['result'][$count]->ratingAverage = 0;
					$data['result'][$count]->reviewCount = $reviewCount;
				}else{
					$data['result'][$count]->ratingAverage = 0;
					$data['result'][$count]->reviewCount = 0;
				}
				$count++;
			}

			if(!empty($data['result'])){
				$starSet = 0;
				$finalArray = array();
				if($this->input->post('stars')){
					$stars = $this->input->post('stars');
					foreach($data['result'] as $row){
						if(in_array($row->ratingAverage,$stars)){
							$starSet = 1;
							$finalArray[] = $row;
						}
					}
					if(empty($finalArray)){
						echo "<div class='alert alert-danger'>
                        <strong>Oops!</strong> No Result Found.
                    	</div>";
                    	exit;
					}
				}else{
					$finalArray = $data['result'];
				}
				if($this->input->post('mostleast')){
					if($this->input->post('mostleast') == 1){
						$finalArray = array_multi_subsort($finalArray,'reviewCount');
					}else{
						$finalArray = array_multi_subsort($finalArray,'reviewCount');
						$finalArray = array_reverse($finalArray);
					}
				}else if($starSet==0){
					$finalArray = $data['result'];
				}
				$data['results'] = $finalArray;
				$user = get_current_user_id();
				$userData = $this->common_model->getsingle(USERS,array('id'=>$user));
				$userRole='';
				if(!empty($userData)){
					$data['userRole'] = $userData->user_role;
				}else{
					$data['userRole']="";
				}
				$this->load->view('frontend/search_filter',$data);
			}else{
				echo "<div class='alert alert-danger'>
                        <strong>Oops!</strong> No Result Found.
                    </div>";
			}
		}else{
			echo "<div class='alert alert-danger'>
                        <strong>Oops!</strong> No Result Found.
                    </div>";
		}
	}else{
		echo "<div class='alert alert-danger'>
                        <strong>Oops!</strong> No Result Found.
                    </div>";
	}	
}


}