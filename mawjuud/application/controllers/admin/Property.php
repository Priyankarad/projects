<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Property extends CI_Controller{
	public function __construct(){
        parent::__construct();
		adminLoginCheck();
    }

    /*to get most favourite property*/
    public function favouriteProperty(){
    	$data['title']='Most Favourite Property List';
		$data['favouriteProperty'] = $this->common_model->GetJoinRecordThree(FAVOURITE_PROPERTY,'property_id',PROPERTY,'id',CATEGORY,'id',PROPERTY,'listing','property.*,category.name,count(favourite_property.id) as fav_count',array('favourite_property.status'=>1),"favourite_property.property_id",'fav_count','desc');
		$this->load->view('admin/favourite_property',$data);
    }

    /*to get most searched property*/
    public function searchedProperty(){
        $data['title']='Most Searched Property List';
        $data['searchedProperty'] = $this->common_model->getAllwhere(PROPERTY,array(),'page_view','DESC','all');
        $this->load->view('admin/searched_property',$data);
    }

    /*to see scheduled tours*/
    public function scheduledTours(){
        $data['title']='Scheduled Tours';
        $data['scheduledTours'] = $this->common_model->GetJoinRecordThree(TOUR_REQUEST,'property_id',PROPERTY,'id',PROPERTY_USERS,'id',TOUR_REQUEST,'requested_by','property.title,property.thumbnail_photo_media,property_users.firstname,property_users.lastname,property_users.profile_thumbnail,tour_request.*','','','tour_created_date','desc');
        $this->load->view('admin/scheduled_tours',$data);
    }

    /*to get property listings*/
    public function listing(){
        $data['title']='Property Lisitngs';
        $data['propertyListing'] = $this->common_model->getAllwhere(PROPERTY,array(),'created_date','DESC','all');
        $this->load->view('admin/listings',$data);
    }

    /*total enquiries for rent*/
    public function totalEnquiriesRent(){
        $data['title']='Total Enquiries For Rent';
        $data['enquiriesList'] = $this->common_model->GetJoinRecord(PROPERTY,'id',ASK_QUESTION,'property_id','property.*,count(ask_question.id) as inquiry_count',array('property_type'=>'rent'),'ask_question.property_id','inquiry_count','desc');
        $this->load->view('admin/enquiries_rent',$data);
    }

    /*total enquiries for sale*/
    public function totalEnquiriesSale(){
        $data['title']='Total Enquiries For Sale';
        $data['enquiriesList'] = $this->common_model->GetJoinRecord(PROPERTY,'id',ASK_QUESTION,'property_id','property.*,count(ask_question.id) as inquiry_count',array('property_type'=>'sale'),'ask_question.property_id','inquiry_count','desc');
        $this->load->view('admin/enquiries_sale',$data);
    }

    /*for approving listings*/
    public function approve($propertyID){
        $propertyData = $this->common_model->getsingle(PROPERTY,array('id'=>$propertyID));
        if(!empty($propertyData)){
            if($propertyData->approved == 0){
                $this->session->set_flashdata('success','Property approved successfully');
                $this->common_model->updateFields(PROPERTY,array('approved'=>1),array('id'=>$propertyID));
            }else{
                $this->session->set_flashdata('success','Property unapproved successfully');
                $this->common_model->updateFields(PROPERTY,array('approved'=>0),array('id'=>$propertyID));
            }
        }
        redirect('listings');
    }

    /*for edit property*/
    public function propertyEdit($propertyID){
        $propertyID = decoding($propertyID);
        $data['title'] = 'Edit Property';
        $where = array('property.id'=>$propertyID);
        $propertyData = $this->common_model->GetJoinRecord(PROPERTY,'listing',CATEGORY,'id','property.*,category.name,category.image as cat_img,',$where);
        $data['propertyData'] = $propertyData['result'][0];
        $data['amenities'] = $this->common_model->getAllwhere(AMENITIES,'','name','asc');
        $data['questions'] = $this->common_model->getAllwhere(QUESTIONS,array('property_id'=>$propertyID));
        $this->load->view('admin/edit_property',$data);
    }

    /*for update property*/
    public function updateProperty(){
        if($this->input->post()){
            $dataInsert = array();
            $dataInsert['title'] = $this->input->post('property_title');
            $dataInsert['latitude'] = $this->input->post('latitude');
            $dataInsert['longitude'] = $this->input->post('longitude');
            $dataInsert['property_address'] = $this->input->post('search_location1');
            $dataInsert['neighbourhood'] = $this->input->post('neighbourhood1');
            if($this->input->post('beds')){
                $dataInsert['bedselect'] = $this->input->post('beds');
            }
            $dataInsert['bathselect'] = $this->input->post('baths');
            $propertyPrice = (str_replace(",", "", $this->input->post('price')));
            $dataInsert['property_price'] = $propertyPrice;
            $dataInsert['view_type'] = $this->input->post('view_type');
            $dataInsert['furnishing'] = $this->input->post('furnishing');
            if($this->input->post('hide_addr')){
                $dataInsert['hide_addr'] = $this->input->post('hide_addr');
            }
            if($this->input->post('property_reference')){
                $dataInsert['property_reference'] = $this->input->post('property_reference');
            }
            $dataInsert['property_terms'] = $this->input->post('property_terms');
            $dataInsert['rent_duration'] = $this->input->post('rent_duration');
            $dataInsert['security_deposit'] = $this->input->post('security_deposit');
            $date = date("Y-m-d",strtotime($this->input->post('date_available')));
            if($date!='1969-12-31'){
                $dataInsert['date_available'] = $date;
            }
            $dataInsert['square_feet'] = (str_replace(",", "", $this->input->post('square_feet')));
            $dataInsert['description'] = $this->input->post('description');
            if($this->input->post('hide_property_address'))
                $dataInsert['hide_property_address'] = 1;
            $dataInsert['user_name'] = $this->input->post('user_name');
            $dataInsert['email'] = $this->input->post('email');
            $dataInsert['phone'] = $this->input->post('phone');
            $dataInsert['number_code'] = $this->input->post('number_code');
            $dataInsert['other_contact'] = $this->input->post('other_contact');
            $dataInsert['other_code'] = $this->input->post('other_code');
            $dataInsert['amenities'] = serialize($this->input->post('amenities'));
            $dataInsert['additional_amenities'] = $this->input->post('additional_amenities1');
            $weekDays = array('Mondays','Tuesdays','Wednesdays','Thursdays','Fridays','Saturdays','Sundays');
            $weekArray = array();
            foreach ($weekDays as $day) {
                if(!empty($this->input->post(lcfirst($day))))
                    $weekArray[lcfirst($day)] = $this->input->post(lcfirst($day));
            }
            $dataInsert['availability_days'] = serialize($weekArray);
            if($this->input->post('directly_listing') && ($this->input->post('directly_listing') == 'on')){
                $dataInsert['directly_listing'] = 1;
                $dataInsert['publish_date'] = date('Y-m-d');
            }
            $thumbnail_photo_media = '';
            $allimg = array();
            if(isset($_FILES['file']['name'][0]) &&  $_FILES['file']['name'][0]!=''){
                $filesCount = count($_FILES['file']['name']);
                if($filesCount>0){
                    for($i = 0; $i < $filesCount; $i++){
                        $_FILES['docfile']['name'] = $_FILES['file']['name'][$i];
                        $_FILES['docfile']['type'] = $_FILES['file']['type'][$i];
                        $_FILES['docfile']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
                        $_FILES['docfile']['error'] = $_FILES['file']['error'][$i];
                        $_FILES['docfile']['size'] = $_FILES['file']['size'][$i];
                        $config['upload_path'] = 'uploads/property_img/';
                        $config['allowed_types'] = 'jpg|jpeg|gif|png';
                        $path=$config['upload_path'];
                        $config['overwrite'] = '1';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ( !$this->upload->do_upload("docfile"))
                        {
                            echo "error";
                            $error = array('error' => $this->upload->display_errors());
                            print_r($error);
                            die;
                        }
                        else
                        {
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
                            $filename = $_FILES['docfile']['tmp_name'];
                            $imgdata=@exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');
                            list($width, $height) = getimagesize($filename);
                            if ($width >= $height){
                                $config['width'] = 800;
                            }
                            else{
                                $config['height'] = 800;
                            }
                            $config['master_dim'] = 'auto';
                            $this->load->library('image_lib',$config); 
                            if (!$this->image_lib->resize()){  
                                echo "error";
                            }else{
                                $this->image_lib->clear();
                                $config=array();
                                $config['image_library'] = 'gd2';
                                $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
                                if(isset($imgdata['Orientation'])){
                                    switch($imgdata['Orientation']) {
                                        case 3:
                                        $config['rotation_angle']='180';
                                        break;
                                        case 6:
                                        $config['rotation_angle']='270';
                                        break;
                                        case 8:
                                        $config['rotation_angle']='90';
                                        break;
                                    }
                                    $this->image_lib->initialize($config); 
                                    $this->image_lib->rotate();
                                }
                            }
                        }   
                        $allimg[]=base_url().'uploads/property_img/'.$this->upload->file_name;     
                    }
                }
            }

            $images = $this->input->post('images');
            if(!empty($allimg)){
                $thumbnail_photo_media.=implode('|',$allimg);
                if($images!=''){
                    $thumbnail_photo_media.="|";
                }
            }

            if($images!=''){
                $images = str_replace(',','|',$images);
                $thumbnail_photo_media.=$images;
            }

            $dataInsert['thumbnail_photo_media'] = $thumbnail_photo_media;
            $dataInsert['photo_media'] = $thumbnail_photo_media;

            $propertyID = $this->input->post('property_id');
            $this->common_model->updateFields(PROPERTY,$dataInsert,array('id'=>$propertyID));
            $this->common_model->deleteData(QUESTIONS,array('property_id'=>$propertyID));
            if($this->input->post('questions') && ($this->input->post('directly_listing') == 'on')){
                $questionsArray = array();
                $questions = $this->input->post('questions');
                foreach($questions as $ques){
                    $quest = array();
                    $quest['property_id'] = $propertyID; 
                    $quest['question'] = $ques; 
                    $questionsArray[] = $quest;
                }
                $this->db->insert_batch(QUESTIONS,$questionsArray);
            }
            $this->session->set_flashdata('success','Property updated successfully');

        }
    }
}   