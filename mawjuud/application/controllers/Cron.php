<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
class Cron extends CI_Controller {

	public function index()
	{
		$this->feedData();
	}

	public function checkRemoteFile($url){
		if(@is_array(getimagesize($url))){
			$image = 1;
		} else {
			$image = 0;
		}
		return $image;
	}

	public function checkRemoteFile1($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
// don't download content
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if(curl_exec($ch)!==FALSE)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function feedData(){
		ini_set('max_execution_time', 0);
		$count=0;
		$where = "id > 181";
		$allFeeds = $this->common_model->getAllwhere(SOURCE_FEEDS,$where);
		if(!empty($allFeeds['result'])){
			foreach($allFeeds['result'] as $feeds){
				$url = $feeds->feed;
				$feedType = $feeds->source;
				$type = $feeds->type;
				$feedData = $this->getPropertyData($url);
				/*---------Gomaster Sale------------*/
				if(!empty($feedData['SalesListing']) && $type == 'sale' && $feedType=='gomaster'){
					foreach($feedData['SalesListing'] as $sale){
						$count++;
						/*agent data*/
						$agentData = array();
						$agentData['firstname'] = (isset($sale['Listing_Agent']) && !empty($sale['Listing_Agent']))?$sale['Listing_Agent']:'';
						$agentData['user_type'] = 'agent';
						$agentData['email'] = (isset($sale['Listing_Agent_Email']) && !empty($sale['Listing_Agent_Email']))?$sale['Listing_Agent_Email']:'';
						$agentData['password'] = (isset($sale['Listing_Agent_Email']) && !empty($sale['Listing_Agent_Email']))?md5($sale['Listing_Agent_Email']):'';
						$agentData['user_number'] = (isset($sale['Listing_Agent_Phone']) && !empty($sale['Listing_Agent_Phone']))?$sale['Listing_Agent_Phone']:'';
						$agentData['agency_name'] = (isset($sale['company_name']) && !empty($sale['company_name']))?$sale['company_name']:'';
						$agentData['profile_thumbnail'] = (isset($sale['company_logo']) && !empty($sale['company_logo']))?$sale['company_logo']:'';
						$agentData['profile_img'] = (isset($sale['company_logo']) && !empty($sale['company_logo']))?$sale['company_logo']:'';
						$where = array('email'=>$agentData['email']);
						$agentDataExist = $this->common_model->getsingle(PROPERTY_USERS,$where);
						$userID='';
						if(!empty($agentDataExist)){
							$this->common_model->updateFields(PROPERTY_USERS,$agentData,$where);
							$userID = isset($agentDataExist->id)?$agentDataExist->id:'';
						}else{
							$userID = $this->common_model->insertData(PROPERTY_USERS,$agentData);
							$agentData = array('agency_name'=>$agentData['agency_name'],'name'=>$agentData['firstname'],'email'=>$agentData['email']);
							$this->sendMail($agentData);
						}
						/*property data*/
						$dataInsert = array();
						$dataInsert['user_id'] = $userID;
						$dataInsert['title'] = (isset($sale['Marketing_Title']) && !empty($sale['Marketing_Title']))?$sale['Marketing_Title']:'';
						$dataInsert['property_reference'] = (isset($sale['Unit_Reference_No']) && !empty($sale['Unit_Reference_No']))?$sale['Unit_Reference_No']:'';
						$dataInsert['description'] = (isset($sale['Web_Remarks']) && !empty($sale['Web_Remarks']))?$sale['Web_Remarks']:'';
//$dataInsert['property_type'] = (isset($sale['Property_Type']) && !empty($sale['Property_Type']))?lcfirst($sale['Property_Type']):'';
						$dataInsert['property_type'] = 'sale';
						if(isset($sale['Unit_Type']) && !empty($sale['Unit_Type'])){
							$where = " name like '%".$sale['Unit_Type']."%'";
							$categoryData = $this->common_model->getsingle(CATEGORY,$where);
						}
						if(!empty($categoryData)){
							$dataInsert['listing'] = $categoryData->id;
						}
						$dataInsert['publish_date'] = (isset($sale['Listing_Date']) && !empty($sale['Listing_Date']))?$sale['Listing_Date']:'';
						$images = isset($sale['Images']['ImageUrl'])?$sale['Images']['ImageUrl']:'';

						$singleImg = array();
						$mainImg   = array();
						if(!empty($images)){
							/*to check if they are valid images*/
							$imgArr = array();
							if(!is_array($images)){
								$imgArr[] = $images;
							}else{
								$imgArr = $images;
							}

							$images = array();
							foreach($imgArr as $img){
								if($this->checkRemoteFile($img)){
									$images[] = $img;
								}
							}
						// 	echo $count.'<pre>---';
						// print_r($images);
						// echo '<pre><hr>';

							if(count($images)>1){
								foreach($images as $img){
									$singleImg[] = $this->uploadImageThumbnail($img);
									$mainImg[] = $this->uploadImage($img);
								}
							}else if((count($images)) == 1){
								$singleImg[] = $this->uploadImageThumbnail($sale['Images']['ImageUrl']);
								$mainImg[] = $this->uploadImage($sale['Images']['ImageUrl']);
							}

							$dataInsert['thumbnail_photo_media'] = !empty($singleImg)?implode('|',$singleImg):'';
							$dataInsert['photo_media'] = !empty($mainImg)?implode('|',$mainImg):'';
						}


						$dataInsert['property_price'] = (isset($sale['Selling_Price']) && !empty($sale['Selling_Price']))?$sale['Selling_Price']:'';
						$dataInsert['square_feet'] = (isset($sale['Unit_Builtup_Area']) && !empty($sale['Unit_Builtup_Area']))?$sale['Unit_Builtup_Area']:'';
						$dataInsert['bedselect'] = (isset($sale['Bedroom_Details']) && !empty($sale['Bedroom_Details']))?$sale['Bedroom_Details']:'100';
						$dataInsert['bathselect'] = (isset($sale['No_of_Bathroom']) && !empty($sale['No_of_Bathroom']))?$sale['No_of_Bathroom']:'';
						$coOrdinates = (isset($sale['Map_Coordinates']) && !empty($sale['Map_Coordinates']))?explode(",",$sale['Map_Coordinates']):'';

						if(!empty($coOrdinates)){
							if($coOrdinates[0] > $coOrdinates[1]){
								$dataInsert['latitude'] = isset($coOrdinates[1])?$coOrdinates[1]:'';
								$dataInsert['longitude'] = isset($coOrdinates[0])?$coOrdinates[0]:'';
							}else{
								$dataInsert['latitude'] = isset($coOrdinates[0])?$coOrdinates[0]:'';
								$dataInsert['longitude'] = isset($coOrdinates[1])?$coOrdinates[1]:'';
							}
						}
						$dataInsert['user_name'] = (isset($sale['Listing_Agent']) && !empty($sale['Listing_Agent']))?$sale['Listing_Agent']:'';
						$dataInsert['email'] = (isset($sale['Listing_Agent_Email']) && !empty($sale['Listing_Agent_Email']))?$sale['Listing_Agent_Email']:'';
						$propertyAddress = '';
						if(isset($sale['Sub_Community']) && !empty($sale['Sub_Community'])){
							$propertyAddress.= $sale['Sub_Community'];
						}
						if(isset($sale['Sub_Community']) && !empty($sale['Sub_Community']) && isset($sale['Community']) && !empty($sale['Community'])){
							$propertyAddress.= ', ';
						}
						if(isset($sale['Community']) && !empty($sale['Community'])){
							$propertyAddress.= $sale['Community'];
						}
						$dataInsert['property_address'] = $propertyAddress;
						$dataInsert['phone'] = (isset($sale['Listing_Agent_Phone']) && !empty($sale['Listing_Agent_Phone']))?$sale['Listing_Agent_Phone']:'';
						$dataInsert['source'] = $feedType;
						$refStep1 = substr($dataInsert['property_type'], 0, 1);
						$catData = $this->common_model->getsingle(CATEGORY,array('id'=>$dataInsert['listing']));
						$category = isset($catData->name)?$catData->name:'';
						$refStep2 = substr($category, 0, 1);
						$refStep3 = date('y');
						$refStep4 = mt_rand(100000, 999999);
						$referenceNumber = ucwords($refStep1.$refStep2."-MJ".$refStep3).$refStep4;
						$dataInsert['mawjuud_reference'] = $referenceNumber;
						$where = array('property_reference'=>$dataInsert['property_reference']);
						$propertyData = $this->common_model->getsingle(PROPERTY,$where);
						$dataInsert['source_id'] = $feeds->id;
						if(empty($propertyData)){
							$this->common_model->insertData(PROPERTY,$dataInsert);
						}else{
							if(!empty($propertyData->photo_media)){
								$imgArray = explode('|',$propertyData->photo_media);
								foreach($imgArray as $img){
									$img = str_replace(base_url(),FCPATH,$img);
									unlink($img);
								}
							}

							if(!empty($propertyData->thumbnail_photo_media)){
								$imgArray = explode('|',$propertyData->thumbnail_photo_media);
								foreach($imgArray as $img){
									$img = str_replace(base_url(),FCPATH,$img);
									unlink($img);
								}
							}
							$dataInsert['updated_date'] = date('Y-m-d H:i:s');
							$this->common_model->updateFields(PROPERTY,$dataInsert,$where);
						}
					}
				}
				/*-----------Gomaster Rent---------*/
				if(!empty($feedData['RentListing']) && $type == 'rent'  && $feedType=='gomaster'){
					foreach($feedData['RentListing'] as $rent){
						/*agent data*/
						$agentData = array();
						$agentData['firstname'] = (isset($rent['Listing_Agent']) && !empty($rent['Listing_Agent']))?$rent['Listing_Agent']:'';
						$agentData['user_type'] = 'agent';
						$agentData['email'] = (isset($rent['Listing_Agent_Email']) && !empty($rent['Listing_Agent_Email']))?$rent['Listing_Agent_Email']:'';
						$agentData['password'] = (isset($rent['Listing_Agent_Email']) && !empty($rent['Listing_Agent_Email']))?md5($rent['Listing_Agent_Email']):'';
						$agentData['user_number'] = (isset($rent['Listing_Agent_Phone']) && !empty($rent['Listing_Agent_Phone']))?$rent['Listing_Agent_Phone']:'';
						$agentData['agency_name'] = (isset($rent['company_name']) && !empty($rent['company_name']))?$rent['company_name']:'';
						$agentData['profile_thumbnail'] = (isset($rent['company_logo']) && !empty($rent['company_logo']))?$rent['company_logo']:'';
						$agentData['profile_img'] = (isset($rent['company_logo']) && !empty($rent['company_logo']))?$rent['company_logo']:'';
						$where = array('email'=>$agentData['email']);
						$agentDataExist = $this->common_model->getsingle(PROPERTY_USERS,$where);
						$userID='';
						if(!empty($agentDataExist)){
							$this->common_model->updateFields(PROPERTY_USERS,$agentData,$where);
							$userID = isset($agentDataExist->id)?$agentDataExist->id:'';
						}else{
							$userID = $this->common_model->insertData(PROPERTY_USERS,$agentData);
							$agentData = array('agency_name'=>$agentData['agency_name'],'name'=>$agentData['firstname'],'email'=>$agentData['email']);
							$this->sendMail($agentData);
						}
						/*property data*/
						$dataInsert = array();
						$dataInsert['user_id'] = $userID;
						$dataInsert['title'] = (isset($rent['Marketing_Title']) && !empty($rent['Marketing_Title']))?$rent['Marketing_Title']:'';
						$dataInsert['property_reference'] = (isset($rent['Unit_Reference_No']) && !empty($rent['Unit_Reference_No']))?$rent['Unit_Reference_No']:'';
						$dataInsert['description'] = (isset($rent['Web_Remarks']) && !empty($rent['Web_Remarks']))?$rent['Web_Remarks']:'';
//$dataInsert['property_type'] = (isset($rent['Property_Type']) && !empty($rent['Property_Type']))?lcfirst($rent['Property_Type']):'';
						$dataInsert['property_type'] = 'rent';
						if(!empty($rent['Unit_Type'])){
							$where = " name like '%".$rent['Unit_Type']."%'";
							$categoryData = $this->common_model->getsingle(CATEGORY,$where);
						}
						if(!empty($categoryData)){
							$dataInsert['listing'] = $categoryData->id;
						}
						$dataInsert['publish_date'] = (isset($rent['Listing_Date']) && !empty($rent['Listing_Date']))?$rent['Listing_Date']:'';
						$images = isset($rent['Images']['ImageUrl'])?$rent['Images']['ImageUrl']:'';
						$singleImg = array();
						$mainImg   = array();
						if(!empty($images)){
							/*to check if they are valid images*/
							$imgArr = array();
							if(!is_array($images)){
								$imgArr[] = $images;
							}else{
								$imgArr = $images;
							}

							$images = array();
							foreach($imgArr as $img){
								if($this->checkRemoteFile($img)){
									$images[] = $img;
								}
							}

							if(count($images)>1){
								foreach($images as $img){
									$singleImg[] = $this->uploadImageThumbnail($img);
									$mainImg[] = $this->uploadImage($img);
								}
							}else if((count($images)) == 1){
								$singleImg[] = $this->uploadImageThumbnail($rent['Images']['ImageUrl']);
								$mainImg[] = $this->uploadImage($rent['Images']['ImageUrl']);
							}

							$dataInsert['thumbnail_photo_media'] =  !empty($singleImg)?implode('|',$singleImg):'';
							$dataInsert['photo_media'] =  !empty($mainImg)?implode('|',$mainImg):'';
						}

						$dataInsert['property_price'] = (isset($rent['RentPerAnum']) && !empty($rent['RentPerAnum']))?$rent['RentPerAnum']:'';
						$dataInsert['square_feet'] = (isset($rent['Unit_Builtup_Area']) && !empty($rent['Unit_Builtup_Area']))?$rent['Unit_Builtup_Area']:'';
						$dataInsert['bedselect'] = (isset($rent['Bedroom_Details']) && !empty($rent['Bedroom_Details']))?$rent['Bedroom_Details']:'100';
						$dataInsert['bathselect'] = (isset($rent['No_of_Bathroom']) && !empty($rent['No_of_Bathroom']))?$rent['No_of_Bathroom']:'';
						$coOrdinates = (isset($rent['Map_Coordinates']) && !empty($rent['Map_Coordinates']))?explode(",",$rent['Map_Coordinates']):'';
						if(!empty($coOrdinates)){
							if($coOrdinates[0] > $coOrdinates[1]){
								$dataInsert['latitude'] = isset($coOrdinates[1])?$coOrdinates[1]:'';
								$dataInsert['longitude'] = isset($coOrdinates[0])?$coOrdinates[0]:'';
							}else{
								$dataInsert['latitude'] = isset($coOrdinates[0])?$coOrdinates[0]:'';
								$dataInsert['longitude'] = isset($coOrdinates[1])?$coOrdinates[1]:'';
							}
						}
						$dataInsert['user_name'] = (isset($rent['Listing_Agent']) && !empty($rent['Listing_Agent']))?$rent['Listing_Agent']:'';
						$dataInsert['email'] = (isset($rent['Listing_Agent_Email']) && !empty($rent['Listing_Agent_Email']))?$rent['Listing_Agent_Email']:'';
						$dataInsert['phone'] = (isset($rent['Listing_Agent_Phone']) && !empty($rent['Listing_Agent_Phone']))?$rent['Listing_Agent_Phone']:'';
						$propertyAddress = '';
						if(isset($rent['Sub_Community']) && !empty($rent['Sub_Community'])){
							$propertyAddress.= $rent['Sub_Community'];
						}
						if(isset($rent['Sub_Community']) && !empty($rent['Sub_Community']) && isset($rent['Community']) && !empty($rent['Community'])){
							$propertyAddress.= ', ';
						}
						if(isset($rent['Community']) && !empty($rent['Community'])){
							$propertyAddress.= $rent['Community'];
						}
						$dataInsert['property_address'] = $propertyAddress;
						$dataInsert['source'] = $feedType;
						$refStep1 = substr($dataInsert['property_type'], 0, 1);
						$catData = $this->common_model->getsingle(CATEGORY,array('id'=>$dataInsert['listing']));
						$category = isset($catData->name)?$catData->name:'';
						$refStep2 = substr($category, 0, 1);
						$refStep3 = date('y');
						$refStep4 = mt_rand(100000, 999999);
						$referenceNumber = ucwords($refStep1.$refStep2."-MJ".$refStep3).$refStep4;
						$dataInsert['mawjuud_reference'] = $referenceNumber;
						$where = array('property_reference'=>$dataInsert['property_reference']);
						$propertyData = $this->common_model->getsingle(PROPERTY,$where);
						$dataInsert['source_id'] = $feeds->id;
						if(empty($propertyData)){
							$this->common_model->insertData(PROPERTY,$dataInsert);
						}else{
							if(!empty($propertyData->photo_media)){
								$imgArray = explode('|',$propertyData->photo_media);
								foreach($imgArray as $img){
									$img = str_replace(base_url(),FCPATH,$img);
									unlink($img);
								}
							}

							if(!empty($propertyData->thumbnail_photo_media)){
								$imgArray = explode('|',$propertyData->thumbnail_photo_media);
								foreach($imgArray as $img){
									$img = str_replace(base_url(),FCPATH,$img);
									unlink($img);
								}
							}
							$dataInsert['updated_date'] = date('Y-m-d H:i:s');
							$this->common_model->updateFields(PROPERTY,$dataInsert,$where);
						}
					}
				}

				/*-----------Propspace--------------*/
				if(!empty($feedData['Listing'])  && $feedType=='propspace'){
					foreach($feedData['Listing'] as $prop){
						/*agent data*/
						$agentData = array();
						$agentName = (isset($prop['Listing_Agent']) && !empty($prop['Listing_Agent']))?explode(" ",$prop['Listing_Agent']):'';
						$agentData['firstname'] = isset($agentName[0])?$agentName[0]:'';
						$agentData['lastname'] = isset($agentName[1])?$agentName[1]:'';
						$agentData['user_type'] = 'agent';
						$agentData['email'] = (isset($prop['Listing_Agent_Email']) && !empty($prop['Listing_Agent_Email']))?$prop['Listing_Agent_Email']:'';
						$agentData['password'] = (isset($prop['Listing_Agent_Email']) && !empty($prop['Listing_Agent_Email']))?md5($prop['Listing_Agent_Email']):'';
						$agentData['user_number'] = (isset($prop['Listing_Agent_Phone']) && !empty($prop['Listing_Agent_Phone']))?$prop['Listing_Agent_Phone']:'';
						$agentData['agency_name'] = (isset($prop['company_name']) && !empty($prop['company_name']))?$prop['company_name']:'';
						if($this->remoteFileExists($prop['company_logo'])){
							$agentData['profile_thumbnail'] = (isset($prop['company_logo']) && !empty($prop['company_logo']))?$prop['company_logo']:'';

							$agentData['profile_img'] = (isset($prop['company_logo']) && !empty($prop['company_logo']))?$prop['company_logo']:'';
						}
						$where = array('email'=>$agentData['email']);
						$agentDataExist = $this->common_model->getsingle(PROPERTY_USERS,$where);
						$userID='';
						if(!empty($agentDataExist)){
							$this->common_model->updateFields(PROPERTY_USERS,$agentData,$where);
							$userID = isset($agentDataExist->id)?$agentDataExist->id:'';
						}else{
							$userID = $this->common_model->insertData(PROPERTY_USERS,$agentData);
							$agentData = array('agency_name'=>$agentData['agency_name'],'name'=>$agentData['firstname'],'email'=>$agentData['email']);
							$this->sendMail($agentData);
						}

						/*property data*/
						$dataInsert = array();
						$dataInsert['user_id'] = $userID;
						$dataInsert['title'] = (isset($prop['Property_Title']) && !empty($prop['Property_Title']))?$prop['Property_Title']:'';
						$dataInsert['property_reference'] = (isset($prop['Property_Ref_No']) && !empty($prop['Property_Ref_No']))?$prop['Property_Ref_No']:'';
						$dataInsert['description'] = (isset($prop['Web_Remarks']) && !empty($prop['Web_Remarks']))?$prop['Web_Remarks']:'';
						$dataInsert['property_type'] = (isset($prop['Ad_Type']) && !empty($prop['Ad_Type']))?lcfirst($prop['Ad_Type']):'';
						if(!empty($prop['Unit_Type'])){
							$where = " name like '%".$prop['Unit_Type']."%'";
							$categoryData = $this->common_model->getsingle(CATEGORY,$where);
						}
						if(!empty($categoryData)){
							$dataInsert['listing'] = $categoryData->id;
						}
						$dataInsert['publish_date'] = (isset($prop['Listing_Date']) && !empty($prop['Listing_Date']))?date('H:i:s Y-m-d',strtotime($prop['Listing_Date'])):'';
						$images = isset($prop['Images']['image'])?$prop['Images']['image']:'';
						$singleImg = array();
						$mainImg   = array();
						if(!empty($images)){
							/*to check if they are valid images*/
							$imgArr = array();
							if(!is_array($images)){
								$imgArr[] = $images;
							}else{
								$imgArr = $images;
							}

							$images = array();
							foreach($imgArr as $img){
								if($this->checkRemoteFile($img)){
									$images[] = $img;
								}
							}
							if(count($images)>1){
								foreach($images as $img){
									$singleImg[] = $this->uploadImageThumbnail($img);
									$mainImg[] = $this->uploadImage($img);
								}
							}else if((count($images)) == 1){
								$singleImg[] = $this->uploadImageThumbnail($prop['Images']['image']);
								$mainImg[] = $this->uploadImage($prop['Images']['image']);
							}

							echo $dataInsert['property_reference'].'<br><br>';
							echo '<pre>';
							print_r($singleImg);
							echo '</pre><hr>';
							$dataInsert['thumbnail_photo_media'] = !empty($singleImg)?implode('|',$singleImg):'';
							$dataInsert['photo_media'] = !empty($mainImg)?implode('|',$mainImg):'';
						}

						$dataInsert['property_price'] = (isset($prop['Price']) && !empty($prop['Price']))?$prop['Price']:'';
						$dataInsert['square_feet'] = (isset($prop['Unit_Builtup_Area']) && !empty($prop['Unit_Builtup_Area']))?number_format($prop['Unit_Builtup_Area']):'';
						$dataInsert['bedselect'] = (isset($prop['Bedrooms']) && !empty($prop['Bedrooms']))?$prop['Bedrooms']:'100';
						$dataInsert['bathselect'] = (isset($prop['No_of_Bathroom']) && !empty($prop['No_of_Bathroom']))?$prop['No_of_Bathroom']:'';
						$dataInsert['latitude'] = (isset($prop['Latitude']) && !empty($prop['Latitude']))?$prop['Latitude']:'';
						$dataInsert['longitude'] = (isset($prop['Longitude']) && !empty($prop['Longitude']))?$prop['Longitude']:'';

						$dataInsert['user_name'] = (isset($prop['Listing_Agent']) && !empty($prop['Listing_Agent']))?$prop['Listing_Agent']:'';
						$dataInsert['email'] = (isset($prop['Listing_Agent_Email']) && !empty($prop['Listing_Agent_Email']))?$prop['Listing_Agent_Email']:'';
						$dataInsert['phone'] = (isset($prop['Listing_Agent_Phone']) && !empty($prop['Listing_Agent_Phone']))?$prop['Listing_Agent_Phone']:'';

						$propertyAddress = '';
						if(isset($prop['Property_Name']) && !empty($prop['Property_Name'])){
							$propertyAddress.= $prop['Property_Name'];
						}
						if(isset($prop['Property_Name']) && !empty($prop['Property_Name']) && isset($prop['Community']) && !empty($prop['Community'])){
							$propertyAddress.= ', ';
						}
						if(isset($prop['Community']) && !empty($prop['Community'])){
							$propertyAddress.= $prop['Community'];
						}

						$dataInsert['property_address'] = $propertyAddress;
						$dataInsert['source'] = $feedType;
						$refStep1 = substr($dataInsert['property_type'], 0, 1);
						$catData = $this->common_model->getsingle(CATEGORY,array('id'=>$dataInsert['listing']));
						$category = isset($catData->name)?$catData->name:'';
						$refStep2 = substr($category, 0, 1);
						$refStep3 = date('y');
						$refStep4 = mt_rand(100000, 999999);
						$referenceNumber = ucwords($refStep1.$refStep2."-MJ".$refStep3).$refStep4;
						$dataInsert['mawjuud_reference'] = $referenceNumber;
						$where = array('property_reference'=>$dataInsert['property_reference']);
						$propertyData = $this->common_model->getsingle(PROPERTY,$where);
						$dataInsert['source_id'] = $feeds->id;
						if(empty($propertyData)){
							$this->common_model->insertData(PROPERTY,$dataInsert);
						}else{
							if(!empty($propertyData->photo_media)){
								$imgArray = explode('|',$propertyData->photo_media);
								foreach($imgArray as $img){
									$img = str_replace(base_url(),FCPATH,$img);
									unlink($img);
								}
							}

							if(!empty($propertyData->thumbnail_photo_media)){
								$imgArray = explode('|',$propertyData->thumbnail_photo_media);
								foreach($imgArray as $img){
									$img = str_replace(base_url(),FCPATH,$img);
									unlink($img);
								}
							}
							$dataInsert['updated_date'] = date('Y-m-d H:i:s');
							$this->common_model->updateFields(PROPERTY,$dataInsert,$where);
						}
					}
				}

				/*-----------Ycloud CRM--------------*/
				if(!empty($feedData['Listing'])  && $feedType=='ycloud'){
				$c = 0;
					foreach($feedData['Listing'] as $prop){
						$c++;
						/*agent data*/
						$agentData = array();
						$agentName = (isset($prop['Listing_Agent']) && !empty($prop['Listing_Agent']))?explode(" ",$prop['Listing_Agent']):'';
						$agentData['firstname'] = isset($agentName[0])?$agentName[0]:'';
						$agentData['lastname'] = isset($agentName[1])?$agentName[1]:'';
						$agentData['user_type'] = 'agent';
						$agentData['email'] = (isset($prop['Listing_Agent_Email']) && !empty($prop['Listing_Agent_Email']))?$prop['Listing_Agent_Email']:'';
						$agentData['password'] = (isset($prop['Listing_Agent_Email']) && !empty($prop['Listing_Agent_Email']))?md5($prop['Listing_Agent_Email']):'';
						$agentData['user_number'] = (isset($prop['Listing_Agent_Phone']) && !empty($prop['Listing_Agent_Phone']))?$prop['Listing_Agent_Phone']:'';
						$agentData['agency_name'] = (isset($prop['company_name']) && !empty($prop['company_name']))?ucfirst($prop['company_name']):'';
						if(!empty($prop['company_logo']) && $this->remoteFileExists($prop['company_logo'])){
							$agentData['profile_thumbnail'] = (isset($prop['company_logo']) && !empty($prop['company_logo']))?$prop['company_logo']:'';

							$agentData['profile_img'] = (isset($prop['company_logo']) && !empty($prop['company_logo']))?$prop['company_logo']:'';
						}
						$where = array('email'=>$agentData['email']);
						$agentDataExist = $this->common_model->getsingle(PROPERTY_USERS,$where);
						$userID='';
						if(!empty($agentDataExist)){
							$this->common_model->updateFields(PROPERTY_USERS,$agentData,$where);
							$userID = isset($agentDataExist->id)?$agentDataExist->id:'';
						}else{
							$userID = $this->common_model->insertData(PROPERTY_USERS,$agentData);
							$agentData = array('agency_name'=>$agentData['agency_name'],'name'=>$agentData['firstname'],'email'=>$agentData['email']);
							$this->sendMail($agentData);
						}

						/*property data*/
						$dataInsert = array();
						$dataInsert['user_id'] = $userID;
						$dataInsert['title'] = (isset($prop['Property_Title']) && !empty($prop['Property_Title']))?$prop['Property_Title']:'';
						$dataInsert['property_reference'] = (isset($prop['Property_Ref_No']) && !empty($prop['Property_Ref_No']))?$prop['Property_Ref_No']:'';
						$dataInsert['description'] = (isset($prop['Web_Remarks']) && !empty($prop['Web_Remarks']))?$prop['Web_Remarks']:'';
						$dataInsert['property_type'] = (isset($prop['Ad_Type']) && !empty($prop['Ad_Type']))?lcfirst($prop['Ad_Type']):'';
						if(!empty($prop['Unit_Type'])){
							$category = explode(' ',$prop['Unit_Type']);
							$where = '(';
							$cnt = 0;
							foreach($category as $cat){
								$cnt++;
								if($cnt == 1){
									$where.= " name like '%".$cat."%' ";
								}else{
									$where.= " OR name like '%".$cat."%' ";
								}
								if(count($category) == $cnt){
									$where.=") ";
								}
							}
//$where = " name like '%".$prop['Unit_Type']."%'";
							$categoryData = $this->common_model->getsingle(CATEGORY,$where);
						}
						if(!empty($categoryData)){
							$dataInsert['listing'] = $categoryData->id;
						}else{
							$dataInsert['listing'] = '';
						}
						$dataInsert['publish_date'] = (isset($prop['Listing_Date']) && !empty($prop['Listing_Date']))?date('H:i:s Y-m-d',strtotime($prop['Listing_Date'])):'';
						$images = isset($prop['Images']['image'])?$prop['Images']['image']:'';
						$singleImg = array();
						$mainImg   = array();
						if(!empty($images)){
							/*to check if they are valid images*/
							$imgArr = array();
							if(!is_array($images)){
								$imgArr[] = $images;
							}else{
								$imgArr = $images;
							}

							$images = array();
							foreach($imgArr as $img){
								if($this->checkRemoteFile($img)){
									$images[] = $img;
								}
							}
							if(count($images)>1){
								foreach($images as $img){
									$singleImg[] = $this->uploadImageThumbnail($img,'ycloud');
									$mainImg[] = $this->uploadImage($img,'ycloud');
								}
							}
							else if((count($images)) == 1){
								$singleImg[] = $this->uploadImageThumbnail($prop['Images']['image']);
								$mainImg[] = $this->uploadImage($prop['Images']['image']);
							}
							$dataInsert['thumbnail_photo_media'] = !empty($singleImg)?implode('|',$singleImg):'';
							$dataInsert['photo_media'] = !empty($mainImg)?implode('|',$mainImg):'';
						}
						echo '<pre>';
						print_r($singleImg);
						echo '</pre><hr>';
						$dataInsert['property_price'] = (isset($prop['Price']) && !empty($prop['Price']))?$prop['Price']:'';
						$dataInsert['square_feet'] = (isset($prop['Unit_Builtup_Area']) && !empty($prop['Unit_Builtup_Area']))?number_format($prop['Unit_Builtup_Area']):'';
						$dataInsert['bedselect'] = (isset($prop['Bedrooms']) && !empty($prop['Bedrooms']))?$prop['Bedrooms']:'100';
						$dataInsert['bathselect'] = (isset($prop['No_of_Bathroom']) && !empty($prop['No_of_Bathroom']))?$prop['No_of_Bathroom']:'';
						$dataInsert['latitude'] = (isset($prop['Latitude']) && !empty($prop['Latitude']))?$prop['Latitude']:'';
						$dataInsert['longitude'] = (isset($prop['Longitude']) && !empty($prop['Longitude']))?$prop['Longitude']:'';

						$dataInsert['user_name'] = (isset($prop['Listing_Agent']) && !empty($prop['Listing_Agent']))?$prop['Listing_Agent']:'';
						$dataInsert['email'] = (isset($prop['Listing_Agent_Email']) && !empty($prop['Listing_Agent_Email']))?$prop['Listing_Agent_Email']:'';
						$dataInsert['phone'] = (isset($prop['Listing_Agent_Phone']) && !empty($prop['Listing_Agent_Phone']))?$prop['Listing_Agent_Phone']:'';

						$propertyAddress = '';
						if(isset($prop['Property_Name']) && !empty($prop['Property_Name'])){
							$propertyAddress.= $prop['Property_Name'];
						}
						if(isset($prop['Property_Name']) && !empty($prop['Property_Name']) && isset($prop['Community']) && !empty($prop['Community'])){
							$propertyAddress.= ', ';
						}
						if(isset($prop['Community']) && !empty($prop['Community'])){
							$propertyAddress.= $prop['Community'];
						}

						$dataInsert['property_address'] = $propertyAddress;
						$dataInsert['source'] = $feedType;
						$refStep1 = substr($dataInsert['property_type'], 0, 1);
						$catData = $this->common_model->getsingle(CATEGORY,array('id'=>$dataInsert['listing']));
						$category = isset($catData->name)?$catData->name:'';
						$refStep2 = substr($category, 0, 1);
						$refStep3 = date('y');
						$refStep4 = mt_rand(100000, 999999);
						$referenceNumber = ucwords($refStep1.$refStep2."-MJ".$refStep3).$refStep4;
						$dataInsert['mawjuud_reference'] = $referenceNumber;
						$where = array('property_reference'=>$dataInsert['property_reference']);
						$propertyData = $this->common_model->getsingle(PROPERTY,$where);
						$dataInsert['source_id'] = $feeds->id;
						if(empty($propertyData)){
							$this->common_model->insertData(PROPERTY,$dataInsert);
						}else{
							if(!empty($propertyData->photo_media)){
								$imgArray = explode('|',$propertyData->photo_media);
								foreach($imgArray as $img){
									$img = str_replace(base_url(),FCPATH,$img);
									unlink($img);
								}
							}

							if(!empty($propertyData->thumbnail_photo_media)){
								$imgArray = explode('|',$propertyData->thumbnail_photo_media);
								foreach($imgArray as $img){
									$img = str_replace(base_url(),FCPATH,$img);
									unlink($img);
								}
							}
							$dataInsert['updated_date'] = date('Y-m-d H:i:s');
							$this->common_model->updateFields(PROPERTY,$dataInsert,$where);
						}
					}
				}

				/*-----------MyCRM--------------*/
				if(!empty($feedData['property'])  && $feedType=='mycrm'){
					foreach($feedData['property'] as $prop){
						/*agent data*/
						$agentData = array();
						$agentName = (isset($prop['agent']['name']) && !empty($prop['agent']['name']))?explode(" ",ucwords($prop['agent']['name'])):'';
						$agentData['firstname'] = isset($agentName[0])?$agentName[0]:'';
						$agentData['lastname'] = isset($agentName[1])?$agentName[1]:'';
						$agentData['user_type'] = 'agent';
						$agentData['email'] = (isset($prop['agent']['email']) && !empty($prop['agent']['email']))?$prop['agent']['email']:'';
						$agentData['user_number'] = (isset($prop['agent']['phone']) && !empty($prop['agent']['phone']))?$prop['agent']['phone']:'';

						$where = array('email'=>$agentData['email']);
						$agentDataExist = $this->common_model->getsingle(PROPERTY_USERS,$where);
						$userID='';
						if(!empty($agentDataExist)){
							$this->common_model->updateFields(PROPERTY_USERS,$agentData,$where);
							$userID = isset($agentDataExist->id)?$agentDataExist->id:'';
						}else{
							$userID = $this->common_model->insertData(PROPERTY_USERS,$agentData);
							$agentData = array('agency_name'=>'Your agency','name'=>$agentData['firstname'],'email'=>$agentData['email']);
							$this->sendMail($agentData);
						}

						/*property data*/
						$dataInsert = array();
						$dataInsert['user_id'] = $userID;
						$dataInsert['title'] = (isset($prop['title_en']) && !empty($prop['title_en']))?$prop['title_en']:'';
						$dataInsert['property_reference'] = (isset($prop['reference_number']) && !empty($prop['reference_number']))?$prop['reference_number']:'';
						$dataInsert['description'] = (isset($prop['description_en']) && !empty($prop['description_en']))?$prop['description_en']:'';

						if(isset($prop['rental_period'])){
							$dataInsert['property_type'] = 'rent';
						}else{
							$dataInsert['property_type'] = 'sale';
						}

						if($prop['property_type'] == 'AP'){
							$propertyType = 'Apartment';
						}elseif($prop['property_type'] == 'OF'){
							$propertyType = 'Office';
						}elseif($prop['property_type'] == 'TH'){
							$propertyType = 'Townhouse';
						}elseif($prop['property_type'] == 'VH' || $prop['property_type'] == 'DX'){
							$propertyType = 'Villa';
						}

						if(!empty($propertyType)){
							$where = " name like '%".$propertyType."%'";
							$categoryData = $this->common_model->getsingle(CATEGORY,$where);
						}
						if(!empty($categoryData)){
							$dataInsert['listing'] = $categoryData->id;
						}
						$images = isset($prop['photo']['url'])?$prop['photo']['url']:'';
						$singleImg = array();
						$mainImg   = array();
						if(!empty($images)){
							/*to check if they are valid images*/
							$imgArr = array();
							if(!is_array($images)){
								$imgArr[] = $images;
							}else{
								$imgArr = $images;
							}

							$images = array();
							foreach($imgArr as $img){
								if($this->checkRemoteFile($img)){
									$images[] = $img;
								}
							}
							if(count($images)>1){
								foreach($images as $img){
									$singleImg[] = $this->uploadImageThumbnail($img);
									$mainImg[] = $this->uploadImage($img);
								}
							}
							else if((count($images)) == 1){
								$singleImg[] = $this->uploadImageThumbnail($prop['photo']['url']);
								$mainImg[] = $this->uploadImage($prop['photo']['url']);
							}
							$dataInsert['thumbnail_photo_media'] = !empty($singleImg)?implode('|',$singleImg):'';
							$dataInsert['photo_media'] = !empty($mainImg)?implode('|',$mainImg):'';
						}

						$dataInsert['property_price'] = (isset($prop['price']) && !empty($prop['price']))?$prop['price']:'';
						$dataInsert['square_feet'] = (isset($prop['size']) && !empty($prop['size']))?$prop['size']:'';
						$dataInsert['bedselect'] = (isset($prop['bedroom']) && !empty($prop['bedroom']))?$prop['bedroom']:'100';
						$dataInsert['bathselect'] = (isset($prop['bathroom']) && !empty($prop['bathroom']))?$prop['bathroom']:'';
						$coOrdinates = (isset($prop['geopoints']) && !empty($prop['geopoints']))?explode(",",$prop['geopoints']):'';
						$dataInsert['latitude'] = isset($coOrdinates[1])?$coOrdinates[1]:'';
						$dataInsert['longitude'] = isset($coOrdinates[0])?$coOrdinates[0]:'';
						$dataInsert['user_name'] = (isset($prop['agent']['name']) && !empty($prop['agent']['name']))?$prop['agent']['name']:'';
						$dataInsert['email'] = (isset($prop['agent']['email']) && !empty($prop['agent']['email']))?$prop['agent']['email']:'';
						$dataInsert['phone'] = (isset($prop['agent']['phone']) && !empty($prop['agent']['phone']))?$prop['agent']['phone']:'';

						$propertyAddress = '';
						if(isset($prop['sub_community']) && !empty($prop['sub_community'])){
							$propertyAddress.= $prop['sub_community'];
						}
						if(isset($prop['sub_community']) && !empty($prop['sub_community']) && isset($prop['community']) && !empty($prop['community'])){
							$propertyAddress.= ', ';
						}
						if(isset($prop['community']) && !empty($prop['community'])){
							$propertyAddress.= $prop['community'];
						}

						$dataInsert['property_address'] = $propertyAddress;
						$dataInsert['source'] = $feedType;
						$refStep1 = substr($dataInsert['property_type'], 0, 1);
						$catData = $this->common_model->getsingle(CATEGORY,array('id'=>$dataInsert['listing']));
						$category = isset($catData->name)?$catData->name:'';
						$refStep2 = substr($category, 0, 1);
						$refStep3 = date('y');
						$refStep4 = mt_rand(100000, 999999);
						$referenceNumber = ucwords($refStep1.$refStep2."-MJ".$refStep3).$refStep4;
						$dataInsert['mawjuud_reference'] = $referenceNumber;
						$where = array('property_reference'=>$dataInsert['property_reference']);
						$propertyData = $this->common_model->getsingle(PROPERTY,$where);
						$dataInsert['source_id'] = $feeds->id;
						if(empty($propertyData)){
							$this->common_model->insertData(PROPERTY,$dataInsert);
						}else{
							if(!empty($propertyData->photo_media)){
								$imgArray = explode('|',$propertyData->photo_media);
								foreach($imgArray as $img){
									$img = str_replace(base_url(),FCPATH,$img);
									unlink($img);
								}
							}

							if(!empty($propertyData->thumbnail_photo_media)){
								$imgArray = explode('|',$propertyData->thumbnail_photo_media);
								foreach($imgArray as $img){
									$img = str_replace(base_url(),FCPATH,$img);
									unlink($img);
								}
							}
							$dataInsert['updated_date'] = date('Y-m-d H:i:s');
							$this->common_model->updateFields(PROPERTY,$dataInsert,$where);
						}

					}
				}

}//feeds foreach
}//if allFeeds
}

public function remoteFileExists($url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_NOBODY, true);
	$result = curl_exec($curl);
	$ret = false;
	if ($result !== false) {
		$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  

		if ($statusCode == 200) {
			$ret = true;   
		}
	}
	curl_close($curl);
	return $ret;
}

public function getPropertyData($URL,$type=false){
	$c = curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_URL, $URL);
	$contents = curl_exec($c);
	curl_close($c);
	if($type){
		return $contents;
	}else{
		if ($contents){
			return json_decode(json_encode(simplexml_load_string($contents, "SimpleXMLElement", LIBXML_NOCDATA)),1);
		}
	}
}

/*function for uploading the images*/
public function uploadImageThumbnail($url,$type=false){
	if($type && ($type == 'ycloud')){
		$name = date('ymdHis');
		$this->createThumbnail($url,350,200,FCPATH.'property_imgs/',$name.'.png');
		return base_url().'property_imgs/'.$name.'.png';
	}else{
// $url_arr = parse_url($url);
// $query = $url_arr['query'];
// $url = str_replace(array($query,'?'), '', $url);
// $filename = substr($url, strrpos($url, '/') + 1);
		$name = date('ymdHis');
		$this->createThumbnail($url,350,200,FCPATH.'property_imgs/',$name.'.png');
		return base_url().'property_imgs/'.$name.'.png';
	}
}

/*function for uploading the images*/
public function uploadImage($url,$type=false){
	if($type && ($type == 'ycloud')){
		$name = date('ymdHis');
		file_put_contents(FCPATH.'property_imgs/'.$name.'.png', file_get_contents($url));
		return base_url().'property_imgs/'.$name.'.png';
	}else{
// $url_arr = parse_url($url);
// $query = $url_arr['query'];
// $url = str_replace(array($query,'?'), '', $url);
// $filename = substr($url, strrpos($url, '/') + 1);
		$name = date('ymdHis');
		file_put_contents(FCPATH.'property_imgs/'.$name.'.png', file_get_contents($url));
		return base_url().'property_imgs/'.$name.'.png';
	}
}


public function createThumbnail( $src, $max_w, $max_h, $dir, $fle ) {
	$img_url = file_get_contents( $src );
	$img = imagecreatefromstring( $img_url );
	$old_x = imagesx( $img );
	$old_y = imagesy( $img ); 
	switch ( true ) {
		case ( $old_x > $old_y ):   
		$thumb_w = $max_w;
		$thumb_h = $old_y / $old_x * $max_w;
		break;
		case ( $old_x < $old_y ):   
		$thumb_w  = $old_x / $old_y * $max_h;
		$thumb_h  = $max_h;
		break;
		case ( $old_x == $old_y ):  
		$thumb_w = $max_w;
		$thumb_h = $max_h;
		break;
	}
	$thumb = imagecreatetruecolor( $thumb_w, $thumb_h );
	imagecopyresampled( $thumb, $img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y );
	$result = imagejpeg( $thumb, $dir . $fle );
	imagedestroy( $thumb ); 
	imagedestroy( $img );
	return $result;
}

/*function to fetch school and transport stations*/
public function fetchApiData(){
	$allLocations = $this->common_model->getAllwhere(UAE_LOCATIONS);
	if(!empty($allLocations['result'])){
		foreach($allLocations['result'] as $location){
			$latitude = $location->latitude;
			$longitude = $location->longitude;
			/*School Data*/
			$url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?type=school&location='.$latitude.','.$longitude.'&radius=10000&key=AIzaSyBnfFqFyXxLDqjwPM_3SFXX4dlBZkpLzTs';
			$result = $this->getPropertyData($url,'json');
			if(!empty($result)){
				$schoolData = json_decode($result);
				if(!empty($schoolData->results)){
					foreach ($schoolData->results as $school) {
						$dataInsert['name'] = $school->name;
						$dataInsert['latitude'] = isset($school->geometry->location->lat)?$school->geometry->location->lat:'';
						$dataInsert['longitude'] = isset($school->geometry->location->lng)?$school->geometry->location->lng:'';
						$dataInsert['ratings'] = isset($school->rating)?$school->rating:'';
						$dataInsert['address'] = isset($school->vicinity)?$school->vicinity:'';
						$dataInsert['unique_id'] = isset($school->id)?$school->id:'';
						$schoolDataExist = $this->common_model->getsingle(SCHOOL,array('unique_id'=>$school->id));
						if(!empty($schoolDataExist)){
							$this->common_model->updateFields(SCHOOL,$dataInsert,array('unique_id'=>$school->id));
						}else{
							$this->common_model->insertData(SCHOOL,$dataInsert);
						}
					}
				}
			}

			/*Transit Stations*/
			$url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?type=transit_station&location='.$latitude.','.$longitude.'&radius=10000&key=AIzaSyBnfFqFyXxLDqjwPM_3SFXX4dlBZkpLzTs';
			$result = $this->getPropertyData($url,'json');
			if(!empty($result)){
				$schoolData = json_decode($result);
				if(!empty($schoolData->results)){
					foreach ($schoolData->results as $transport) {
						$dataInsert['name'] = $transport->name;
						$dataInsert['latitude'] = isset($transport->geometry->location->lat)?$transport->geometry->location->lat:'';
						$dataInsert['longitude'] = isset($transport->geometry->location->lng)?$transport->geometry->location->lng:'';
						$dataInsert['ratings'] = isset($transport->rating)?$transport->rating:'';
						$dataInsert['address'] = isset($transport->vicinity)?$transport->vicinity:'';
						$dataInsert['unique_id'] = isset($transport->id)?$transport->id:'';
						$schoolDataExist = $this->common_model->getsingle(TRANSPORT,array('unique_id'=>$transport->id));
						if(!empty($schoolDataExist)){
							$this->common_model->updateFields(TRANSPORT,$dataInsert,array('unique_id'=>$transport->id));
						}else{
							$this->common_model->insertData(TRANSPORT,$dataInsert);
						}
					}
				}
			}
		}
	}
}

public function sendMail($agentData){
	/*For sending feedback mail to agent as soon as the xml feed gets adds*/
	$from = 'info@mawjuud.com';
	$subject = 'Successful feeds integration';
	$message = 'Dear '.$agentData['agency_name'].',<br/><br/>';
	$message.=ucwords($agentData['name']).' is now part of Mawjuud \'s family. All properties have been uploaded and you can view your listings and promote items to featured items using the below links.<br/><br/>'; 
	$message.='Promoting your items to featured using Mawjuud will help increase your chances in selling/renting out your properties.<br/>';
	$message.='We have created logins for agents also .You can login to website with email address as <strong>'.$agentData['email'].'</strong> and password as <strong>'.$agentData['email'].'</strong><br/><br/>';
	$message.='Please send us you company logo, so that we can update it in Mawjuud.com<br/><br/>';
	$message.='User credentials :<br/><br/>';
	$message.='Username : '.$agentData['email'].'<br/>';
	$message.='Password : '.$agentData['email'].'<br/>';
	$config['protocol'] = 'ssmtp';
	$config['smtp_host'] = 'ssl://ssmtp.gmail.com';
	$config['mailtype'] = 'html';
	$config['newline'] = '\r\n';
	$config['charset'] = 'utf-8';
	$this->load->library('email', $config);
	$this->email->initialize($config);
	$mailData = array();
	$mailData['message'] = $message;
	$message = $this->load->view('frontend/mailcron',$mailData,true);
	$this->email->from($from);
	$this->email->to($agentData['email']);
	$this->email->subject($subject);
	$this->email->message($message);
	$this->email->set_header('From', $from);
	if($this->email->send()){
	}
}

/*to store users from live site*/
public function fetchUsers(){
	if($_FILES){
		$fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
		while($csv_line = fgetcsv($fp,1024))
		{
			$dataInsert['email'] = !empty($csv_line[4])?$csv_line[4]:'';
			$userData = $this->common_model->getsingle(PROPERTY_USERS,$dataInsert);
			if(empty($userData)){
				$dataInsert['firstname'] = !empty($csv_line[3])?$csv_line[3]:'';
				$dataInsert['verify_status'] = 'verified';
				$dataInsert['password'] = md5($dataInsert['email']);
				$dataInsert['login_type'] = 'normal';
				/*For sending mail to users*/
				$from = 'info@mawjuud.com';
				$subject = 'Successful Registration';
				$message = 'Dear '.ucwords($dataInsert['firstname']).',<br/>';
				$message.= 'Your account hass been successfully created on Mawjuud.<br/><br/>';
				$message.='User credentials :<br/>';
				$message.='Username : '.$dataInsert['email'].'<br/>';
				$message.='Password : '.$dataInsert['email'].'<br/>';
				$config['protocol'] = 'ssmtp';
				$config['smtp_host'] = 'ssl://ssmtp.gmail.com';
				$config['mailtype'] = 'html';
				$config['newline'] = '\r\n';
				$config['charset'] = 'utf-8';
				$this->load->library('email', $config);
				$this->email->initialize($config);
				$mailData = array();
				$mailData['message'] = $message;
				$message = $this->load->view('frontend/mailcron',$mailData,true);
				$this->email->from($from);
				$this->email->to($dataInsert['email']);
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->set_header('From', $from);
				if($this->email->send()){
				}
				$this->common_model->insertData(PROPERTY_USERS,$dataInsert);
			}
		}
	}
	$this->load->view('frontend/csv');
}
}