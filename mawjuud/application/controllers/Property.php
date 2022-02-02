<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(E_ALL);
//ini_set('display_errors', 1);
class Property extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }  

    public function index(){
    }

    /*To add property*/
    public function toAddProperty(){
        loginCheck('user');
        if($this->input->post()){
            $dataInsert = array();
            $dataInsert['property_type'] = $this->input->post('property_type');
            $dataInsert['title'] = $this->input->post('property_title');
            $dataInsert['listing'] = $this->input->post('listing');
            $dataInsert['other_type'] = $this->input->post('other_type');
            $dataInsert['latitude'] = $this->input->post('latitude');
            $dataInsert['longitude'] = $this->input->post('longitude');
            $dataInsert['property_address'] = $this->input->post('search_location1');
            $dataInsert['neighbourhood'] = $this->input->post('neighbourhood1');
            $dataInsert['city'] = $this->input->post('city');
            if($dataInsert['listing'] == 1 || $dataInsert['listing'] == 4 || $dataInsert['listing'] == 6 || $dataInsert['listing'] == 10 || $dataInsert['listing'] == 12){
                //$dataInsert['bedselect'] = $this->input->post('bedselect');
                $dataInsert['bedselect'] = $this->input->post('beds');
                //$dataInsert['bathselect'] = $this->input->post('bathselect');
                $dataInsert['bathselect'] = $this->input->post('baths');
            }else if($dataInsert['listing'] == 8){
                //$dataInsert['bathselect'] = $this->input->post('bathselect');
                $dataInsert['bathselect'] = $this->input->post('baths');
            }
            $dataInsert['property_range'] = $this->input->post('property_range');
            if($dataInsert['property_type'] == 'sale'){
                $dataInsert['property_price'] = (str_replace(",", "", $this->input->post('sale_price')));
            }else{
                $dataInsert['property_price'] = (str_replace(",", "", $this->input->post('rent_price')));
            }

            $dataInsert['view_type'] = $this->input->post('view_type');
            $dataInsert['furnishing'] = $this->input->post('furnishing');
            if($this->input->post('hide_addr')){
                $dataInsert['hide_addr'] = $this->input->post('hide_addr');
            }
            if($this->input->post('property_reference')){
                $dataInsert['property_reference'] = $this->input->post('property_reference');
            }

            $refStep1 = substr($this->input->post('property_type'), 0, 1);
            $catData = $this->common_model->getsingle(CATEGORY,array('id'=>$this->input->post('listing')));
            $category = isset($catData->name)?$catData->name:'';
            $refStep2 = substr($category, 0, 1);
            $refStep3 = date('y');
            $refStep4 = mt_rand(100000, 999999);
            $referenceNumber = ucwords($refStep1.$refStep2."-MJ".$refStep3).$refStep4;
            $dataInsert['mawjuud_reference'] = $referenceNumber;
            
            $dataInsert['property_terms'] = $this->input->post('property_terms');
            $dataInsert['rent_duration'] = $this->input->post('rent_duration');
            $dataInsert['lease_duration'] = $this->input->post('lease_duration');
            $dataInsert['security_deposit'] = $this->input->post('security_deposit');
            $date = date("Y-m-d",strtotime($this->input->post('date_available')));
            if($date!='1969-12-31'){
                $dataInsert['date_available'] = $date;
            }
            $dataInsert['lease_terms'] = $this->input->post('lease_terms');
            $dataInsert['square_feet'] = $this->input->post('property_range');
            $dataInsert['description'] = $this->input->post('description');
            if($this->input->post('hide_property_address'))
                $dataInsert['hide_property_address'] = 1;
            $dataInsert['user_name'] = $this->input->post('user_name');
            $dataInsert['email'] = $this->input->post('email');
            $dataInsert['phone'] = $this->input->post('phone');
            $dataInsert['number_code'] = $this->input->post('number_code');
            $dataInsert['other_contact'] = $this->input->post('other_contact');
            $dataInsert['other_code'] = $this->input->post('other_code');
            $dataInsert['user_id'] = get_current_user_id();
            $dataInsert['amenities'] = serialize($this->input->post('amenities'));
            $dataInsert['additional_amenities'] = $this->input->post('additional_amenities1');
            if($this->input->post('property_draft') && $this->input->post('property_draft') == 1){
                $dataInsert['save_as_draft'] = 1;
            }

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
                    $dataInsert['thumbnail_photo_media']=implode('|',$allimg);
                    $dataInsert['photo_media']=implode('|',$allimg);
                }
            }


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
            $propertyID = $this->common_model->insertData(PROPERTY,$dataInsert);
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
            echo json_encode(array('status'=>1));
            die;
        }else{
            $data = array();
            $data['cities'] = $this->common_model->getAllwhere(UAE_CITY);
            $data['categories'] = $this->common_model->getAllwhere(CATEGORY);
            $data['amenities'] = $this->common_model->getAllwhere(AMENITIES,'','name','asc');
            $this->load->view('frontend/add_property',$data);
        }
    }

    /*To search property*/
    public function toSearchProperty(){
        $data['class'] = 'Muj-search';
        $userId = get_current_user_id();
        $where = " save_as_draft = 0";
        if($this->input->post()){
            $propertyType = '';
            if($this->input->post('property_sale')){
                $address = $this->input->post('sale_address');
                $propertyType = 'sale';
            }else if($this->input->post('property_rent')){
                $address = $this->input->post('rent_address');
                $propertyType = 'rent';
            }
            $where.= " and approved=1 and latitude!='' and longitude!='' and (property_address like '%".$address."%' OR neighbourhood like '%".$address."%') and property_type = '".$propertyType."'";
            $data['searched_term'] = $address;
            $data['propertyType'] = $propertyType;
        }

        if(!empty($userId)){
            $favouriteProperties = $this->common_model->getAllwhere(FAVOURITE_PROPERTY,array('user_id'=>$userId,'status'=>1));
            if(!empty($favouriteProperties['result'])){
                foreach($favouriteProperties['result'] as $property){
                    $data['favourite_properties'][] = $property->property_id;
                }
            }
            $compareProperties = $this->common_model->getAllwhere(COMPARE_PROPERTY,array('user_id'=>$userId,'status'=>1));
            if(!empty($compareProperties['result'])){
                foreach($compareProperties['result'] as $property){
                    $data['compareProperties'][] = $property->property_id;
                }
            }
        }

        $data['categories'] = $this->common_model->getAllwhere(CATEGORY);
        $data['propertyData']=$this->common_model->get_two_table_data('property.property_address,property.longitude,property.id,property.thumbnail_photo_media,property.property_type,property.bathselect,property.bedselect,property.square_feet,property.title,property.latitude,category.name',PROPERTY,CATEGORY,"property.listing=category.id",$where,'','created_date','desc');
        $data['authUrl'] = $this->facebook->login_url();
        $data['loginURL'] = $this->googleplus->loginURL();
//to unset session of hided property
        $this->session->set_userdata('hideProperty','');
        $this->load->view('frontend/search_properties',$data);
    }

    /*To fetch all the properties latitude and longitude*/
    function getAllProperties(){
        $property = array();
        $propertyData = $this->common_model->getAllwhere(PROPERTY);
        if(!empty($propertyData['result'])){
            $count = 0;
            foreach ($propertyData['result'] as $prop) {
                $property[$count]['id'] = $prop->id;
                $property[$count]['latitude'] = $prop->latitude;
                $property[$count]['longitude'] = $prop->longitude;
                $count++;
            }
        }

        $school = $this->facilities(SCHOOL);
        $transport = $this->facilities(TRANSPORT);
        echo json_encode(array('property'=>$property,'school'=>$school,'transport'=>$transport));
    }

    /*To save property search filters*/
    function savePropertySearch(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        $this->session->set_userdata('save_search',$this->input->post());
        if(!$this->session->userdata('sessionData')){
            echo json_encode(array('user_login'=>1));
            die;
        }

        if($this->input->post()){
            $status = 0;
            $dataInsert = array();
            $dataInsert['user_id'] = get_current_user_id();
            $dataInsert['area'] = $this->input->post('area');
            $dataInsert['price'] = $this->input->post('price');
            $dataInsert['beds'] = $this->input->post('beds');
            $dataInsert['baths'] = $this->input->post('baths');
            $dataInsert['min_sqft'] = $this->input->post('min_sqft');
            $dataInsert['max_sqft'] = $this->input->post('max_sqft');
            $dataInsert['min_price'] = $this->input->post('min_price');
            $dataInsert['max_price'] = $this->input->post('max_price');
            $dataInsert['days_zillow'] = $this->input->post('days_zillow');
            $dataInsert['keywords'] = $this->input->post('keywords');
            $dataInsert['listing'] = $this->input->post('listing');
            $dataInsert['view_type'] = $this->input->post('type');
            $dataInsert['title'] = $this->input->post('title');
            if($this->input->post('category'))
                $dataInsert['category'] = serialize($this->input->post('category'));
            $dataInsert['sort'] = $this->input->post('sort');
            $searchID = $this->common_model->insertData(PROPERTY_SEARCH,$dataInsert);
            if($searchID){
                $status = 1; 
            }
            echo json_encode(array('status'=>$status));
        }
    }

    /*To fetch single property details*/
    public function singlePropertyDetails(){
        $userID = get_current_user_id();
        $propertyID = decoding($this->input->get('id'));
        if(!empty($userID)){
            $favouriteProperties = $this->common_model->getsingle(FAVOURITE_PROPERTY,array('user_id'=>$userID,'status'=>1,'property_id'=>$propertyID));
            if(!empty($favouriteProperties)){
                $data['favouriteProperties'] = $favouriteProperties;
            }

            $compareProperties = $this->common_model->getsingle(COMPARE_PROPERTY,array('user_id'=>$userID,'status'=>1,'property_id'=>$propertyID));
            if(!empty($compareProperties)){
                $data['compareProperties'] = $compareProperties;
            }
        }
        /*all the favourite properties of user*/
        if(!empty($userID)){
            $favouriteProperties = $this->common_model->getAllwhere(FAVOURITE_PROPERTY,array('user_id'=>$userID,'status'=>1));
            if(!empty($favouriteProperties['result'])){
                foreach($favouriteProperties['result'] as $property){
                    $data['favourite_properties'][] = $property->property_id;
                }
            }
        }

        /*most viewed properties*/
        $data['viewdProperties'] = $this->common_model->getAllwhere(PROPERTY,array('directly_listing'=>1,'approved'=>1),'page_view','desc');

        $data['totalSaved'] = $this->common_model->getAllwhere(FAVOURITE_PROPERTY,array('status'=>1,'property_id'=>$propertyID));  
        $where = array('property.id'=>$propertyID,'property.approved'=>1);
        $propertyData=$this->common_model->GetJoinRecord(PROPERTY,'listing',CATEGORY,'id','property.*,category.name,category.image as cat_img,',$where);
        if(!empty($propertyData['result'][0])){
            $data['propertyData'] = $propertyData['result'][0];
            /*To increment page view*/
            $dataUpdate['page_view'] = $propertyData['result'][0]->page_view+1;
            $this->common_model->updateFields(PROPERTY,$dataUpdate,$where);

            /*For fetching the nearby properties within 5 miles*/
            $latitude = isset($data['propertyData']->latitude)?$data['propertyData']->latitude:'';
            $longitude = isset($data['propertyData']->longitude)?$data['propertyData']->longitude:'';
            $propertyCategory = isset($data['propertyData']->listing)?$data['propertyData']->listing:'';
            $where = array('listing'=>$propertyCategory,'approved'=>1);
            if($latitude!='' && $longitude!=''){
                $data['nearByPropertyData'] = $this->common_model->getProperties($latitude,$longitude,50,PROPERTY,$where);
            }
        }

        $amenities = $this->common_model->getAll(AMENITIES);
        if(!empty($amenities['result'])){
            foreach($amenities['result'] as $row){
                $data['amenities_id'][] = $row->id;
                $data['amenities_name'][$row->id] = $row->name;
                $data['amenities_img'][$row->id] = $row->image;
            } 
        }
        $data['propertyOwnerDetails'] = $this->common_model->get_two_table_data('property_users.*',PROPERTY,PROPERTY_USERS,"property.user_id=property_users.id",array('property.id'=>$propertyID,'property.approved'=>1),'');

        /*EMI calculation*/
        $amount = $data['propertyData']->property_price;
        $rate = 5/(12*100); 
        $term = 30*12;
        $data['emi'] = ($amount * $rate * pow(1 + $rate, $term)) / (pow(1 + $rate, $term) - 1); 

        /*For getting the comments for the current property*/
        $data['propertyComments'] = $this->common_model->GetJoinRecord(COMMENTS,'user_id',PROPERTY_USERS,'id','property_users.profile_thumbnail,comments.comment',array('comments.property_id'=>$propertyID),'','comments.comment_date','desc');

        /*For getting the property questions*/
        $data['propertyQuestions'] = $this->common_model->getAllwhere(QUESTIONS,array('property_id'=>$propertyID));
        $this->load->view('frontend/single_property',$data);
    }

    /*To favourite property*/
    function favouriteProperty(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }

        if(!$this->session->userdata('sessionData')){
            echo json_encode(array('user_login'=>1,'favouriteCount'=>0));
            die;
        }
        if($this->input->post()){
            $status = 0;
            $dataInsert = array();
            $dataInsert['user_id'] = get_current_user_id();
            $dataInsert['property_id'] = $this->input->post('property_id');
            $getFavouriteData = $this->common_model->getsingle(FAVOURITE_PROPERTY,$dataInsert);
            if(empty($getFavouriteData)){
                $dataInsert['status'] = 1;
                $favouriteID = $this->common_model->insertData(FAVOURITE_PROPERTY,$dataInsert);
                if($favouriteID){
                    $status = 1; 
                }
            }else{
                if($getFavouriteData->status == 0){
                    $dataUpdate['status'] = 1; 
                    $status = 1;
                }else{
                    $dataUpdate['status'] = 0; 
                    $status = 2;
                }
                $dataUpdate['created_date'] = date('Y-m-d H:i:s'); 
                $this->common_model->updateFields(FAVOURITE_PROPERTY,$dataUpdate,$dataInsert);
            }
//to fetch favourite count
            $favouriteCount = $this->common_model->getAllwhere(FAVOURITE_PROPERTY,array('status'=>1,'user_id'=>$dataInsert['user_id']));
            $favouriteCount = $favouriteCount['total_count'];
            echo json_encode(array('status'=>$status,'favouriteCount'=>$favouriteCount));
        }
    }

    /*Code for contacting to agent*/
    function contactAgent(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $status = 0;
            $dataInsert = array();
            $from = 'info@mawjuud.com';
            $dataInsert['name'] = ucwords($this->input->post('name'));
            $dataInsert['email'] = $this->input->post('email');
            $dataInsert['phone_number'] = $this->input->post('phone_number');
            $dataInsert['message'] = $this->input->post('message');
            $dataInsert['property_id'] = $this->input->post('property_id');
            $dataInsert['country_code'] = $this->input->post('phone_code');
            $contactID = $this->common_model->insertData(CONTACT_AGENT,$dataInsert);
            if($contactID){
                $status = 1;
            }
            /*For sending feedback mail to user and the property owner*/
            $message = "Thanks for showing your interest in Mawjuud properties. The requested agent will contact you soon.";
            sendMail($this->input->post('email'),$from,$message,$this->input->post('name'),'Mawjuud : Contact request received');

            /*fetching Agent/Owner information*/
            $ownerInfo = $this->common_model->GetJoinRecord(PROPERTY,'user_id',PROPERTY_USERS,'id','property_users.*',array('property.id'=>$this->input->post('property_id')));
            $email = '';
            $name = '';
            if(!empty($ownerInfo['result'][0])){
                $email = isset($ownerInfo['result'][0]->email)?$ownerInfo['result'][0]->email:'';
                //$email = 'priyanka.pixlrit@gmail.com';
                $firstname = isset($ownerInfo['result'][0]->firstname)?$ownerInfo['result'][0]->firstname:'';
                $lastname = isset($ownerInfo['result'][0]->lastname)?$ownerInfo['result'][0]->lastname:'';
                $name = ucwords($firstname." ".$lastname);
            }

            $propertyData = $this->common_model->getsingle(PROPERTY,array('id'=>$this->input->post('property_id')));
            $message = '<p class="onlyredsB">';
            $message.="I am interested in this Property <b><span style='color: #bf0000;font-weight: bold;font-family: Montserrat-Bold;'>";
            $message.=isset($propertyData->title)?"'".substr($propertyData->title,0,100)."...'":'';
            $message.="</span> ";
            $message.=(isset($propertyData->mawjuud_reference) && !empty($propertyData->mawjuud_reference))?$propertyData->mawjuud_reference:'';
            $message.=(isset($propertyData->property_reference) && !empty($propertyData->property_reference))?'(Reference numbers Mawjuud-'.$propertyData->property_reference.')':'';
            $message.="</b> and would like to schedule a viewing. Please Let me know when this would be possible</p>";
            /*For getting the property questions*/
            $propertyQuestions = $this->common_model->getAllwhere(QUESTIONS,array('property_id'=>$this->input->post('property_id')));
            if(!empty($propertyQuestions['total_count']) && $propertyQuestions['total_count']!=0){
                $count = 1;
                $message.="<br/><b>Question and Answers :</b><br/><br/>";
                $answers = $this->input->post('answer');
                foreach($propertyQuestions['result'] as $ques){
                    $message.="<b>Ques ".$count.": ";
                    $message.= $ques->question."</b><br/>";
                    $message.="Ans: ".$answers[$ques->id]."<br/><br/>";
                    $count++;
                }
            }
            sendMail($email,$from,$message,$name,'Mawjuud');
            echo json_encode(array('status'=>$status));
        }
    }


    /*Code for contacting to agent from agent detail page*/
    function contactAgentDetail(){
         if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $status = 0;
            $dataInsert = array();
            $from = 'info@mawjuud.com';
            $dataInsert['name'] = ucwords($this->input->post('name'));
            $dataInsert['email'] = $this->input->post('email');
            $dataInsert['phone_number'] = $this->input->post('phone_number');
            $dataInsert['message'] = $this->input->post('message');
            $dataInsert['agent_id'] = $this->input->post('agent_id');
            $dataInsert['country_code'] = $this->input->post('phone_code');
            $dataInsert['detail_page'] = 1;
            $contactID = $this->common_model->insertData(CONTACT_AGENT,$dataInsert);
            if($contactID){
                $status = 1;
            }

            /*For sending feedback mail to user and the property owner*/
            $message = "Thanks for showing your interest in Mawjuud. The requested agent will contact you soon.";
            sendMail($this->input->post('email'),$from,$message,$this->input->post('name'),'Mawjuud');

            sleep(5);
            /*fetching Agent/Owner information*/
            $agentInfo = $this->common_model->getsingle(PROPERTY_USERS,array('id'=>$dataInsert['agent_id']));
            $email = '';
            $name = '';
            if(!empty($agentInfo)){
                $email = isset($agentInfo->email)?$agentInfo->email:'';
                //$email = 'priyanka.pixlrit@gmail.com';
                $firstname = isset($agentInfo->firstname)?$agentInfo->firstname:'';
                $lastname = isset($agentInfo->lastname)?$agentInfo->lastname:'';
                $name = ucwords($firstname." ".$lastname);
            }
            sendMail($email,$from,$dataInsert['message'],$name,'Mawjuud');
            echo json_encode(array('status'=>$status));
        }
    }

    /*Code for ask question*/
    function askQuestion(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $status = 0;
            $dataInsert = array();
            $from = 'info@mawjuud.com';
            $dataInsert['name'] = ucwords($this->input->post('name'));
            $dataInsert['email'] = $this->input->post('email');
            $dataInsert['phone_number'] = $this->input->post('phone_number');
            $dataInsert['question'] = $this->input->post('question');
            $dataInsert['property_id'] = $this->input->post('property_id');
            $contactID = $this->common_model->insertData(ASK_QUESTION,$dataInsert);
            if($contactID){
                $status = 1;
            }
            /*For sending feedback mail to user and the property owner*/
            $message = "Thanks for showing your interest in Mawjuud properties. The requested agent will contact you soon.";
            sendMail($this->input->post('email'),$from,$message,$this->input->post('name'),'Mawjuud');

            /*fetching Agent/Owner information*/
            $ownerInfo = $this->common_model->GetJoinRecord(PROPERTY,'user_id',PROPERTY_USERS,'id','property_users.*',array('property.id'=>$this->input->post('property_id')));
            $email = '';
            $name = '';
            if(!empty($ownerInfo['result'][0])){
                $email = isset($ownerInfo['result'][0]->email)?$ownerInfo['result'][0]->email:'';
                $firstname = isset($ownerInfo['result'][0]->firstname)?$ownerInfo['result'][0]->firstname:'';
                $lastname = isset($ownerInfo['result'][0]->lastname)?$ownerInfo['result'][0]->lastname:'';
                $name = ucwords($firstname." ".$lastname);
            }

            $question = '';
            $question.='Someone has asked you a question on Mawjuud.<br><br><b>Question</b><br>';
            $question.= $this->input->post('question');
            sendMail($email,$from,$question,$name,'Mawjuud');
            echo json_encode(array('status'=>$status));
        }
    }


    /*For sending tour request*/
    function requestTour(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if(!$this->session->userdata('sessionData')){
            echo json_encode(array('user_login'=>1));
            die;
        }
        if($this->input->post()){
            $status = 0;
            $dataInsert = array();
            $from = 'info@mawjuud.com';
            if($this->input->post('duration') && $this->input->post('duration')!=''){
                $dataInsert['tour_selected'] = $this->input->post('tour_select');
                $dataInsert['tour_duration'] = $this->input->post('duration');
                $dataInsert['property_id'] = $this->input->post('property_id');
                $dataInsert['message'] = $this->input->post('tour_message');
                if(get_current_user_id()){
                    $dataInsert['requested_by'] = get_current_user_id();
                }
                $contactID = $this->common_model->insertData(TOUR_REQUEST,$dataInsert);

                /*For sending confirmation mail to the property owner for tour request*/
                $ownerInfo = $this->common_model->GetJoinRecord(PROPERTY,'user_id',PROPERTY_USERS,'id','property.title,property_users.*',array('property.id'=>$this->input->post('property_id')));
                $email = '';
                $name = '';
                if(!empty($ownerInfo['result'][0])){
                    $email = isset($ownerInfo['result'][0]->email)?$ownerInfo['result'][0]->email:'';
                    //$email = 'priyanka.pixlrit@gmail.com';
                    $firstname = isset($ownerInfo['result'][0]->firstname)?$ownerInfo['result'][0]->firstname:'';
                    $lastname = isset($ownerInfo['result'][0]->lastname)?$ownerInfo['result'][0]->lastname:'';
                    $name = ucwords($firstname." ".$lastname);
                    $propertyTitle = isset($ownerInfo['result'][0]->title)?$ownerInfo['result'][0]->title:'';
                }
                $message = "Someone has made a request for a tour on ".$this->input->post('tour_select')." ".$this->input->post('duration')." for the property <b>'".$propertyTitle."'</b>. <br/><br/><b>Message-</b>";
                $message.= $this->input->post('tour_message');
                sendMail($email,$from,$message,$name,'Mawjuud');
                if($contactID){
                    $status = 1;
                }
            }else{
                $status = 2;
            }
            echo json_encode(array('status'=>$status));
        }
    }

    /*To fetch properties added by me*/
    public function myProperties(){
        loginCheck('user');
        $userID = get_current_user_id();
        $data['propertyData'] = $this->common_model->get_two_table_data('property.*,category.name',PROPERTY,CATEGORY,"property.listing=category.id",array('user_id'=>$userID),'','created_date','desc');
        $this->load->view('frontend/my_properties',$data);
    }

    /*To fetch properties added favourite by me*/
    public function favouriteProperties(){
        loginCheck('user');
        $userID = get_current_user_id();
        $data['propertyData'] = $this->common_model->GetJoinRecordThree(FAVOURITE_PROPERTY,'property_id',PROPERTY,'id',CATEGORY,'id',PROPERTY,'listing','property.*,category.name',array('favourite_property.user_id'=>$userID,'favourite_property.status'=>1,'property.approved'=>1),"",'favourite_property.created_date','desc');
        $this->load->view('frontend/favourite_properties',$data);  
    }

    /*function to hide property*/
    public function hideProperty(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $sessionData = array();
            $id = $this->input->post('id');
            $sessionData = $this->session->userdata('hideProperty');
            $sessionData[] = $id;
            $this->session->set_userdata('hideProperty',$sessionData);
        }
    }

    /*function to post a comment*/
    public function postComment(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $propertyID = $this->input->post('property_id');
            $comment = $this->input->post('comment');
            $userID = get_current_user_id();
            $dataInsert = array();
            $dataInsert['property_id'] = $propertyID;
            $dataInsert['user_id'] = $userID;
            $dataInsert['comment'] = $comment;
            $this->common_model->insertData(COMMENTS,$dataInsert);
            $commentsData = $this->common_model->GetJoinRecord(COMMENTS,'user_id',PROPERTY_USERS,'id','property_users.profile_thumbnail,comments.comment',array('comments.property_id'=>$propertyID),'','comments.comment_date','desc');
            
            $html='';
            if(!empty($commentsData['result'])){
                foreach ($commentsData['result'] as $comment) {
                    $html.='<li><span><img src="'.$comment->profile_thumbnail.'"></span>'.$comment->comment.'</li>';
                }
            }
            echo json_encode(array('html'=>$html));
        }
    }

    /*function to record call activity*/
    public function recordCallActivity(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if(!$this->session->userdata('sessionData')){
            echo json_encode(array('user_login'=>1));
            die;
        }
        if($this->input->post()){
            $dataInsert = array();
            if(get_current_user_id()){
                $dataInsert['user_id'] = get_current_user_id();
            }
            $dataInsert['property_id'] = $this->input->post('property_id');
            $this->common_model->insertData(CALL_ACTIVITY,$dataInsert);
        }
    }

     /*function to compare properties*/
    public function compareProperties(){
        loginCheck('user');
        $userID = get_current_user_id();
        $data['propertyData'] = $this->common_model->GetJoinRecordThree(COMPARE_PROPERTY,'property_id',PROPERTY,'id',CATEGORY,'id',PROPERTY,'listing','property.*,category.name',array('compare_property.user_id'=>$userID,'compare_property.status'=>1),"",'compare_property.created_date','desc');
        $this->load->view('frontend/compare_properties',$data);
    }

     /*function to show list of hidden properties*/
    public function hiddenProperties(){
        loginCheck('user');
        $userID = get_current_user_id();
        $data['propertyData'] = $this->common_model->getAllwhere(PROPERTY,array('user_id'=>$userID,'archive'=>0,'approved'=>1));
        //$data['propertyData'] = $this->common_model->getAllwhere(PROPERTY,array('archive'=>0));
        $this->load->view('frontend/hidden_properties',$data);
    }
    

    /*To compare property*/
    function compareProperty(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if(!$this->session->userdata('sessionData')){
            echo json_encode(array('user_login'=>1));
            die;
        }
        if($this->input->post()){
            $status = 0;
            $dataInsert = array();
            $dataInsert['user_id'] = get_current_user_id();
            $dataInsert['property_id'] = $this->input->post('property_id');
            $getCompareData = $this->common_model->getsingle(COMPARE_PROPERTY,$dataInsert);
            if(empty($getCompareData)){
                $dataInsert['status'] = 1;
                $favouriteID = $this->common_model->insertData(COMPARE_PROPERTY,$dataInsert);
                if($favouriteID){
                    $status = 1; 
                }
            }else{
                if($getCompareData->status == 0){
                    $dataUpdate['status'] = 1; 
                    $status = 1;
                }else{
                    $dataUpdate['status'] = 0; 
                    $status = 2;
                }
                $dataUpdate['created_date'] = date('Y-m-d H:i:s'); 
                $this->common_model->updateFields(COMPARE_PROPERTY,$dataUpdate,$dataInsert);
            }
            echo json_encode(array('status'=>$status));
        }
    }

    /*to remove property from compare list*/
    public function removeProperty(){
         if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $status = 0;
            $dataCheck = array();
            $dataCheck['user_id'] = get_current_user_id();
            $dataCheck['property_id'] = $this->input->post('property_id');
            $type = $this->input->post('type');
            if($type == 'compare'){
                $getCompareData = $this->common_model->getsingle(COMPARE_PROPERTY,$dataCheck);
                if(!empty($getCompareData)){
                    if($getCompareData->status == 0){
                        $dataUpdate['status'] = 1; 
                        $status = 1;
                    }else{
                        $dataUpdate['status'] = 0; 
                        $status = 2;
                    }
                    $this->common_model->updateFields(COMPARE_PROPERTY,$dataUpdate,$dataCheck);
                }
            }else if($type == 'favourite'){
                $dataUpdate['status'] = 0; 
                $this->common_model->updateFields(FAVOURITE_PROPERTY,$dataUpdate,$dataCheck);
                $status = 1;
            }else if($type == 'hidden'){
                $dataUpdate['status'] = 0; 
                $this->common_model->updateFields(PROPERTY,array('archive'=>1),array('id'=>$dataCheck['property_id'],'user_id'=>get_current_user_id()));
                $status = 1;
            }
            echo json_encode(array('status'=>$status));
        }
    }

    /*To share note*/
    public function shareNote(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
         if(!$this->session->userdata('sessionData')){
            echo json_encode(array('user_login'=>1));
            die;
        }
        if($this->input->post()){
            $userSession = $this->session->userdata('sessionData');
            $from = 'info@mawjuud.com';
            $emails = $this->input->post('email');
            $data['note'] = $this->input->post('note');
            $data['firstImg'] = $this->input->post('first_img');
            $data['propertyID'] = $this->input->post('property_ids');
            $data['sent_by'] = $userSession['username'];
            //$data['propertyData'] = $this->common_model->getsingle(PROPERTY,array('id'=>$data['propertyID']));

            $propertyData = $this->common_model->GetJoinRecord(PROPERTY,'listing',CATEGORY,'id','property.*,category.name,category.image',array('property.id'=>$data['propertyID']));
            $data['propertyData'] = isset($propertyData['result'][0])?$propertyData['result'][0]:'';

            if(!empty($emails)){
                foreach($emails as $email){
                    $message = '';
                    $message = $this->load->view('frontend/share_template',$data,true);
                    sendMail($email,$from,$message,'there','Mawjuud','property_share');
                }
                echo json_encode(array('status'=>1));
            }
        }
    }

    /*To refresh property*/
    public function refreshProperty(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $propertyID = $this->input->post('propertyID');
            $dataUpdate['publish_date'] = date('Y-m-d H:i:s'); 
            $this->common_model->updateFields(PROPERTY,$dataUpdate,array('id'=>$propertyID));
            echo json_encode(array('publish_date'=>date("j M Y",strtotime($dataUpdate['publish_date']))));
        }
    }

    /*To refresh property*/
    public function rentedSold(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $propertyID = $this->input->post('propertyID');
            $dataUpdate['rent_sale'] = $this->input->post('rentSale');
            $dataUpdate['sold_rented_date'] = date('Y-m-d');
            $this->common_model->updateFields(PROPERTY,$dataUpdate,array('id'=>$propertyID));
            echo json_encode(array('status'=>1));
        }
    }

    /*To activate deactivate property*/
    public function activeProperty(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $propertyID = $this->input->post('propertyID');
            $status = 1;
            if($this->input->post('activate') == 1){
                $status = 0;
                $dataUpdate['publish_date'] = date('Y-m-d');
            }else{
                $dataUpdate['publish_date'] = NULL;
            }
            $dataUpdate['save_as_draft'] = $status;
            $this->common_model->updateFields(PROPERTY,$dataUpdate,array('id'=>$propertyID));
            $publishDate = '-';
            if(!empty($dataUpdate['publish_date'])){
                $publishDate = date("j M Y",strtotime($dataUpdate['publish_date']));
            }

            echo json_encode(array('status'=>$dataUpdate['save_as_draft'],'publish_date'=>$publishDate));
        }
    }

    /*To delete property*/
    public function deleteProperty(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $propertyID = $this->input->post('propertyID');
            $this->common_model->deleteData(PROPERTY,array('id'=>$propertyID));
            echo json_encode(array('status'=>1));
        }
    }

    /*To search my property*/
    public function searchMyPropertyFilter(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $type = $this->input->post('type');
            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $category = $this->input->post('category');
            $sortBy = $this->input->post('sortBy');
            $status = $this->input->post('status');
            $propertyType = $this->input->post('propertyType');
            //$where = " property.id!=0 and property.archive=1";
            //$where = " property.id!=0 and property.archive=1  and property.approved=1 and property.user_id=".get_current_user_id();
            $where = " property.id!=0 and property.archive=1  and property.approved=1";
            if(!empty($category)){
                $category = implode(",",$category);
                $where.= " and listing IN(".$category.")";
            }
            $order_by = 'created_date';
            $order = 'desc';
            if(isset($sortBy) && !empty($sortBy)){
                if($sortBy == 'recent_publish'){
                    $order_by = "publish_date";
                }else if($sortBy == 'recent_added'){
                    $order_by = "created_date";
                }else if($sortBy == 'high_low'){
                    $order_by = "property_price";
                }else if($sortBy == 'low_high'){
                    $order_by = "publish_date";
                    $order = 'asc';
                }else if($sortBy == 'size'){
                    $order_by = "property_range";
                }
            }
            if(isset($status) && !empty($status)){
                if($status == 'active'){
                    $where.= " and save_as_draft=0 ";
                }else{
                    $where.= " and save_as_draft=1 ";
                }
            }

            if(isset($propertyType) && !empty($propertyType)){
                if($propertyType == 'featured'){
                    $where.= "and featured=1 ";
                }else if($propertyType == 'rented'){
                    $where.= " and rent_sale=1 and property_type='rent' ";
                }else if($propertyType == 'sold'){
                    $where.= " and rent_sale=1 and property_type='sale' ";
                }else if($propertyType == 'open'){
                    $where.= " and rent_sale=0 ";
                }
            }

            $sessionData = array();
            $sessionData = $this->session->userdata('hideProperty');
            if(!empty($sessionData)){
                $hidePropertyIDs = implode(",", $sessionData);
                $where.= " and property.id NOT IN(".$hidePropertyIDs.")";
            }
            $propertyData = $this->common_model->GetJoinRecord(PROPERTY,'listing',CATEGORY,'id','property.*,category.name,category.image',$where,'',$order_by,$order);
            $propertyCount = 0;
            if(!empty($propertyData['result'])){
                $propertyCount = $propertyData['total_count']; 
            }

            $totalData  = $totalFiltered = $propertyCount;

            $propertyData = $this->common_model->GetJoinRecord(PROPERTY,'listing',CATEGORY,'id','property.*,category.name,category.image',$where,'',$order_by,$order,$limit,$start);
            $userId = get_current_user_id();
            if(!empty($userId)){
                $favouriteProperties = $this->common_model->getAllwhere(FAVOURITE_PROPERTY,array('user_id'=>$userId,'status'=>1));
                if(!empty($favouriteProperties['result'])){
                    foreach($favouriteProperties['result'] as $property){
                        $datas['favourite_properties'][] = $property->property_id;
                    }
                }
            }
            $data = array();
            if($type == 'photo'){
                if(!empty($propertyData['result']))
                {
                    foreach ($propertyData['result'] as $property)
                    {
                        $datas['property'] = (array)$property;
                        $nestedData['id'] = $this->load->view('frontend/my_properties_photo_view',$datas,true);
                        $data[] = $nestedData;
                    }
                }
            }else if($type == 'table'){

                 if(!empty($propertyData['result']))
                {
                    foreach ($propertyData['result'] as $property)
                    {
                        $datasP['property'] = $property = (array)$property;
                        $favourite = '';
                        $class = 'sale-prs';
                        $rentedSold = 'Sold';
                        $propertyTypes = 'S';
                        if($property['property_type'] == 'rent'){
                            $class = 'rent-prs';
                            $rentedSold = 'Rented';
                            $propertyTypes = 'R';
                        }
                        if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                            $favourite = 'fillHearts';
                        }
                       $nestedData['R / S'] = '<span class="'.$class.'">'.$propertyTypes.'</span>';

                        $nestedData['Type'] = '<span class="'.$class.'">'.$property['name'].'</span>';

                        $nestedData['Ref #'] = $property['mawjuud_reference'];

                        $nestedData['Title'] = '<a class="title_anchores2" href="'.base_url().'single_property?id='.encoding($property['id']).'" target="_blank">'.$property['title'].'</a>';

                        $nestedData['Address'] = isset($property['property_address'])?ucfirst($property['property_address']):'';

                        $nestedData['Price (AED)'] = isset($property['property_price'])?number_format($property['property_price']):'';
                        $bed = '';
                        if(isset($property['bedselect'])){
                            if($property['bedselect'] == 100){
                                $bed =  "Studio";
                            }else{
                                $bed = $property['bedselect'];
                            }
                        }
                        $nestedData['Bed'] = $bed;

                        $nestedData['Bath'] = isset($property['bathselect'])?$property['bathselect']:'';;

                        $nestedData['Size'] = isset($property['square_feet'])?number_format($property['square_feet']):'';

                        $nestedData['Date Added'] = (!empty($property['created_date']) && $property['created_date']!='0000-00-00')?date("j M Y",strtotime($property['created_date'])):'-';

                        $nestedData['Date Published'] = '<span class="publisheds'.$property['id'].'">'.(!empty($property['publish_date']) && $property['publish_date']!='0000-00-00')?date("j M Y",strtotime($property['publish_date'])):'-'.'</span>';
                        $propertyID = $property['id'];
                        $draft = (isset($property['save_as_draft']) && $property['save_as_draft'] == 0)?'checked':'';

                        $activate = ($property['save_as_draft'] == 0)?0:1;
                        $nestedData['Status'] = '<span class="act-m">Active</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox" class="activate" '.$draft.' data-activate="'.$activate.'" data-property_id="'.$propertyID.'">
                                    <span class="lever"></span>
                                </label>
                            </div>';
                        $pageView = isset($property['page_view'])?$property['page_view']:'';
                        $favourites = countRecords(FAVOURITE_PROPERTY,array('property_id'=>$property['id'],'status'=>1));
                        
                        $nestedData['Activity'] = '<p><img src="'.base_url().'assets/images/view.png" alt=""> <b>'.$pageView.'</b></p>
    <p><span class="ti-heart"></span> <b>'.$favourites.'</b></p>';

                        $marked = (isset($property['rent_sale']) && $property['rent_sale'] == 1)?'checked':'';

                       

                        $nestedData['Mark'] = '<span class="'.$class.'">'.$rentedSold.'</span>
    <div class="switch">
        <label>
            <input type="checkbox" class="rent_sale"  data-property_id="'.$propertyID.'"  '.$marked.'>
            <span class="lever"></span>
        </label>
    </div>';

                        $nestedData['ESD'] = $this->load->view('frontend/esd',$datasP,true);
                        $data[] = $nestedData;
                    }
                }
            }
            $json_data = array(
                "draw"            => intval($this->input->post('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data,
            );
            echo json_encode($json_data);
        }
    }



    public function getPropertyDetails()
    {
        $location = array();
        $schoolPointer = array();
        $transportPointer = array();
        $type = $this->input->post('type');
        if($type != 'table'){
            $columns = array( 
                0 =>'', 
                1 =>'',
            );
        }else{
            $columns = array( 
                0 =>'', 
                1 =>'type',
                2 =>'title',
                3 =>'address',
                4 =>'price',
                5 =>'bed',
                6 =>'bath',
                7 =>'size',
                8 =>'favorite',
                9 =>'add_to_compare',
                10 =>'hide',
            );
        }
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $where = " save_as_draft = 0 and approved=1 ";
        $area = $this->input->post('area');
        $listing = $this->input->post('listing');
        $beds = $this->input->post('beds');
        $baths = $this->input->post('baths');
        $min_sqft = $this->input->post('min_sqft');
        $max_sqft = $this->input->post('max_sqft');
        $min_price = $this->input->post('min_price');
        $max_price = $this->input->post('max_price');
        $days_zillow = $this->input->post('days_zillow');
        $keywords = $this->input->post('keywords');
        $category = $this->input->post('category');
        $propertyID = $this->input->post('propertyID');
        $schoolID = $this->input->post('schoolID');
        $transportID = $this->input->post('transportID');
        $polygon = $this->input->post('polygon');

        /*to fetch transports existing within the draw path*/
        if(!empty($transportID)){
            $transports = implode(',',$transportID);
            $transID = " id IN(".$transports.")";
            $transportPointer = $this->facilities(TRANSPORT,$transID);
        }

        /*to fetch schools existing within the draw path*/
        if(!empty($schoolID)){
            $schools = implode(',',$schoolID);
            $schoID = " id IN(".$schools.")";
            $schoolPointer = $this->facilities(SCHOOL,$schoID);
        }

        if($polygon == 1 || $polygon == 2 || $polygon == 3){
            $where = " save_as_draft = 0 and latitude!='' and approved=1 and longitude!='' ";
            if(!empty($propertyID)){
                $propertyIDs = implode(',',$propertyID);
                $where.= " and property.id IN(".$propertyIDs.")";
            }else{
                $where.= " and property.id IN(0)";
            }
        }

        $sort = $this->input->post('sort');
        if($area!=''){
            $area = preg_replace( '/\s+/', ' ', $area);
            $area = str_replace('United Arab Emirates','',$area);//removing country from search string
            $term = explode(' ',trim($area));
            if(count($term) > 1){
                $count = 0;
                $area = $term[0].' '.$term[1];
                $where.= " and (property_address like '%$area%') ";
                // foreach($term as $row){
                //     if($row!=''){
                //         $count++;
                //         if($count == 1){
                //             //$where.= " and (property_address like '%$row%' OR neighbourhood like '%$row%' ";
                //             $where.= " and (property_address like '%$row%' ";
                //         }else{
                //             //$where.= " OR property_address like '%$row%' OR neighbourhood like '%$row%' ";
                //             $where.= " OR property_address like '%$row%' ";
                //         }
                //     }
                // }
                // if(count($term) == $count){
                //     $where.=") ";
                // }

            }
            else{
                //$where.=" and (property_address like '%$term[0]%' OR neighbourhood like '%$term[0]%') ";
                $where.=" and (property_address like '%$term[0]%') ";
            }
        }

        if($beds!='' && $beds!=100 && $beds!='all'){
            $where.= " and bedselect >=".$beds." and bedselect!=100";
        }
        if($beds!='' && $beds==100 && $beds!='all'){
            $where.= " and bedselect =".$beds;
        }
        if(!empty($category)){
            $category = implode(",",$category);
            $where.= " and listing IN(".$category.")";
        }
        if(!empty($baths) && $baths!='all'){
            $where.= " and bathselect =".$baths;
        }

        $min_price = preg_replace('/[^0-9]/', '', $min_price);
        if($max_price!='any' && $max_price!=''){
            $max_price = preg_replace('/[^0-9]/', '', $max_price);
        }

        if(($min_price!='') && ($max_price=='')){
            $where.= " and property_price >= ".$min_price;
        }else if(($min_price=='') && ($max_price!='') && ($max_price!='any')){
            $where.= " and property_price <= ".$max_price;
        }else if(($min_price!='') && ($max_price!='') && ($max_price!='any') ){
            $where.=" and property_price>=".$min_price." and property_price<=".$max_price;
        }else if(($min_price!='') && ($max_price!='') && ($max_price=='any') ){
            $where.= " and property_price >= ".$min_price;
        }

        if($min_sqft!='' && $max_sqft!=''){
            $where.= " and (square_feet between ".$min_sqft." and ".$max_sqft.")";
        }else if($min_sqft!=''){
            $where.= " and square_feet >= ".$min_sqft;
        }else if($max_sqft!=''){
            $where.= " and square_feet <= ".$max_sqft;
        }

        if($listing!='' && $listing!='all'){
            $where.= " and property_type='".$listing."'";
        }

        if($keywords!=''){
            $keywords = explode(",",$keywords);
            if(!empty($keywords)){
                $count = 0;
                $arrCount = count($keywords);
                foreach($keywords as $word){
                    $count++;
                    if($count == 1){
                        $where.= " and (";
                        $where.= "(property_address like '".$word."' OR property_type like '".$word."' OR other_type like '".$word."' OR name like '".$word."')";
                    }else {
                        $where.= " OR(property_address like '".$word."' OR property_type like '".$word."' OR other_type like '".$word."' OR name like '".$word."')";
                    }
                    if($arrCount == $count){
                        $where.= " )";
                    }
                }
            }
        }

        $sessionData = array();
        $sessionData = $this->session->userdata('hideProperty');
        if(!empty($sessionData)){
            $hidePropertyIDs = implode(",", $sessionData);
            $where.= " and property.id NOT IN(".$hidePropertyIDs.")";
        }

        $order_by = 'property.created_date';
        $order = 'desc';
        if($sort == 'new'){
            $order_by = 'property.created_date';
        }else if($sort == 'cheap'){
            $order_by = 'property_price';
            $order = 'asc';
        }else if($sort == 'size'){
            $order_by = 'square_feet';
        }else if($sort == 'image'){
            $order_by = 'img_count';
        }
        $propertyCount = 0;
        $propertyData = $this->common_model->GetJoinRecordThree(PROPERTY,'listing',CATEGORY,'id',PROPERTY_USERS,'id',PROPERTY,'user_id','property.property_address,property.longitude,property.id,property.thumbnail_photo_media,property.photo_media,property.property_type,property.bathselect,property.bedselect,property.square_feet,property.title,property.latitude,category.name,category.image, property_users.profile_thumbnail,property.property_price,(LENGTH(`thumbnail_photo_media`) - LENGTH(REPLACE(`thumbnail_photo_media`,"|","")) + 1) AS img_count',$where,"",$order_by,$order);
        
        if(!empty($propertyData['result'])){
            $propertyCount = $propertyData['total_count']; 
        }

        $totalData  = $totalFiltered = $propertyCount;
        if($propertyCount>0){
            $lastRecordID = $propertyData['result'][$totalData-1]->id;
            if(!empty($propertyData['result'])){ 
                $count = 0;
                foreach($propertyData['result'] as $prop){ 
                    $property = (array)$prop;
                    $location[$count][] = $property['property_address'];
                    $location[$count][] = $property['latitude'];
                    $location[$count][] = $property['longitude'];
                    $location[$count][] = $property['id'];
                    if(isset($property['thumbnail_photo_media'])){
                        $imgArray = explode('|',$property['thumbnail_photo_media']); 
                        $location[$count][] = $imgArray[0];
                    }else{
                        $location[$count][] = base_url().DEFAULT_PROPERTY_IMAGE;
                    }

                    if($property['property_type']=='sale'){
                        $location[$count][] = 'SGC1';
                    }else{
                        $location[$count][] = 'SGC';
                    }

                    $location[$count][] = isset($property['property_type'])?ucfirst($property['property_type']):'';

                    $bath = '';
                    if(isset($property['bathselect'])){
                        if($property['bathselect'] == 0){
                            $bath = '-';
                        }else {
                            $bath = $property['bathselect'];
                        }
                    }
                    $location[$count][] = $bath;

                    $bed = '';
                    if(isset($property['bedselect'])){
                        if($property['bedselect']==100)
                            $bed = 'Studio';
                        else if($property['bedselect']==0)
                            $bed = '-';
                        else 
                            $bed = $property['bedselect'];  
                    }
                    $location[$count][] = $bed;

                    //$location[$count][] = isset($property['square_feet'])?number_format($property['square_feet'])." Sq. ft.":'';
                    $location[$count][] = isset($property['square_feet'])?number_format($property['square_feet']):'';
                    $location[$count][] =isset($property['name'])?$property['name']:'';

                    $location[$count][] =isset($property['property_address'])?ucfirst($property['property_address']):'';

                    $location[$count][] = isset($property['property_price'])?number_format($property['property_price']).' AED':'';

                    $images = isset($property['thumbnail_photo_media'])?explode(",",$property['thumbnail_photo_media']):0;
                    if($images){
                        $location[$count][] = count($images);
                    }else{
                        $location[$count][] = 0;
                    }
                    if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                        $favourite = 'fillHearts';
                        $location[$count][] = 'fillHearts';
                    }else{
                        $location[$count][] = '';
                    }
                    $location[$count][] = encoding($property['id']);
                    if(isset($property['title']) && !empty($property['title']))
                        $location[$count][] = substr($property['title'], 0, 100).'...';
                    else
                        $location[$count][] = '';
                    $count++;
                }
            }
        }



        $userId = get_current_user_id();
        $favourite_properties = array();
        $compare_properties = array();
        if(!empty($userId)){
            $favouriteProperties = $this->common_model->getAllwhere(FAVOURITE_PROPERTY,array('user_id'=>$userId,'status'=>1));
            if(!empty($favouriteProperties['result'])){
                foreach($favouriteProperties['result'] as $property){
                    $favourite_properties[] = $property->property_id;
                }
            }

            $compareProperties = $this->common_model->getAllwhere(COMPARE_PROPERTY,array('user_id'=>$userId,'status'=>1));
            if(!empty($compareProperties['result'])){
                foreach($compareProperties['result'] as $property){
                    $compare_properties[] = $property->property_id;
                }
            }
        }

     
        $propertyDetails = $this->common_model->GetJoinRecordThree(PROPERTY,'listing',CATEGORY,'id',PROPERTY_USERS,'id',PROPERTY,'user_id','property.property_address,property.longitude,property.id,property.thumbnail_photo_media,property.photo_media,property.property_type,property.bathselect,property.bedselect,property.square_feet,property.title,property.latitude,category.name,category.image, property_users.profile_thumbnail,property.property_price,(LENGTH(`thumbnail_photo_media`) - LENGTH(REPLACE(`thumbnail_photo_media`,"|","")) + 1) AS img_count',$where,"",$order_by,$order,$limit,$start);
        
        $data = array();
        if(!empty($propertyDetails['result']))
        {
            $count = 0;
            foreach ($propertyDetails['result'] as $property)
            {
                $count++;
                $datas['property'] = (array)$property;
                if(!empty($favourite_properties) && in_array($property->id,$favourite_properties)){
                    $datas['favourite'] = 'fillHearts';
                }else{
                    $datas['favourite'] = '';
                }

                if(!empty($compare_properties) && in_array($property->id,$compare_properties)){
                    $datas['compare'] = 'style="color:#ff8787"';
                }else{
                    $datas['compare'] = '';
                }

                if($type == 'grid'){
                    if($count == 1){
                        $nestedData['id'] = $this->load->view('frontend/grid_view',$datas,true);
                        if($lastRecordID == $property->id){
                            $nestedData['title'] = '';
                            $data[] = $nestedData;
                        }
                    }
                    if($count == 2){
                        $nestedData['title'] = $this->load->view('frontend/grid_view',$datas,true);
                        $data[] = $nestedData;
                        $count = 0;
                    }
                }
                else if($type == 'photo'){
                    $nestedData['id'] = $this->load->view('frontend/photo_view',$datas,true);
                    $nestedData['title'] = '';
                    $data[] = $nestedData;
                }
                else if($type == 'table'){
                    $property = $datas['property'];
                    $typeRent = 'R';
                    $class = '';
                    if(isset($property['property_type']) && ($property['property_type']=='sale')){
                        $class = 'color:#9a9595';
                        $typeRent = 'S';
                    }
                    $nestedData['id'] = '<span style="'.$class.'">'.$typeRent.'</span>';
                    $nestedData['type'] = isset($property['name'])?$property['name']:'';
                    $title = isset($property['title'])?$property['title']:'';
                    $nestedData['title'] = '<a href="'.base_url().'single_property?id='.encoding($property['id']).'" target="_blank">'.$title.'</a>';
                    $address = isset($property['property_address'])?$property['property_address']:'';
                    $nestedData['address'] = '<p>'.$address.'</p>';
                    $nestedData['price'] = isset($property['property_price'])?number_format($property['property_price'])."":'';
                    $bed = '';
                    if(isset($property['bedselect'])){
                        if($property['bedselect']==100)
                            $bed = 'Studio';
                        else if($property['bedselect']==0)
                            $bed = '-';
                        else 
                            $bed = $property['bedselect'];  
                    }
                    $nestedData['bed'] = $bed;
                    $bath = '';
                    if(isset($property['bathselect'])){
                        if($property['bathselect'] == 0){
                            $bath = '-';
                        }else {
                            $bath = $property['bathselect'];
                        }
                    }
                    $nestedData['bath'] = $bath;
                    $nestedData['size'] = isset($property['square_feet'])?$property['square_feet']:'';
                    $nestedData['favorite'] = '<div class=""><span class="ti-heart '.$datas['favourite'].'"  onclick="favouriteProperty('.$property['id'].',this);"></span></div>';
                    $nestedData['add_to_compare'] = '<div class=""><span class="ti-plus" onclick="compareProperty('.$property['id'].',this);" '.$datas['compare'].'></span></div>';
                    $nestedData['hide'] = '<img src="'.base_url().'assets/images/map-icon/table-delete.png" class="fixsizeiconM Mhideproperty" alt="images" data-property = "'.$property['id'].'"/>';
                    $data[] = $nestedData;
                }
            }
        }

        if(!empty($location) && isset($location[0])){
            $location = json_encode($location);
        }

        if(!empty($schoolPointer) && isset($schoolPointer[0])){
            $schoolPointer = json_encode($schoolPointer);
        }

        if(!empty($transportPointer) && isset($transportPointer[0])){
            $transportPointer = json_encode($transportPointer);
        }

        $this->session->set_userdata('rentSale','');
        $json_data = array(
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data,
            'location'=> $location,
            'transportPointer'=> $transportPointer,
            'schoolPointer'=> $schoolPointer
        );
        echo json_encode($json_data); 
    }

    /*function to fetch facilities*/
    public function fetchFacilities(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $facility = $this->input->post('typeF');
            $schoolID = $this->input->post('schoolID');
            $schoolSet = $this->input->post('schoolSet');
            $transportID = $this->input->post('transportID');
            $transportSet = $this->input->post('transportSet');
            $tableName='';
            $where = '';
            if($facility == 'transport'){
                $tableName = TRANSPORT;
                if($transportSet == 1){
                    if(!empty($transportID)){
                        $transports = implode(',',$transportID);
                        $where = " id IN(".$transports.")";
                    }
                }
            }
            else if($facility == 'school'){
                $tableName = SCHOOL;
                if($transportSet == 1){
                    if(!empty($schoolID)){
                        $schools = implode(',',$schoolID);
                        $where = " id IN(".$schools.")";
                    }
                }
            }
            $allFacitlties = $this->facilities($tableName,$where);
            echo json_encode(array('facilities'=>$allFacitlties));
        }
    }


    function facilities($tableName,$where=false){
        $getAllFacilities = $this->common_model->getAllwhere($tableName,$where);
        $allFacitlties = array();
        if(!empty($getAllFacilities['result'])){
            foreach($getAllFacilities['result'] as $row){
                if(isset($row->ratings) && $row->ratings!=''){
                    $ratings = starRating($row->ratings);
                }
                else{
                    $ratings = starRating(0);
                }
                $ratings = preg_replace("/\([^)]+\)/","",$ratings);
                if(isset($row->ratings) && $row->ratings!=''){
                    $row->star_ratings = $ratings.'('.$row->ratings.')';
                }
                else{
                    $row->star_ratings = $ratings.'(0)';
                }

                $allFacitlties[] = $row;
            }
        }
        return $allFacitlties;
    }

    /*open and inquiry form*/
    public function openInquiryForm(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $propertyID = $this->input->post('propertyID');
            $data['property'] = $this->common_model->getsingle(PROPERTY,array('id'=>$propertyID));
            $html = $this->load->view('frontend/inquiry_modal',$data,true);
            echo json_encode(array('modalData'=>$html));
        }
    }

    /*for setting nearby rent sale*/
    public function setNearBy($type){
        if($type == 'sale'){
            $data['page'] = 'sale';
        }else{
            $data['page'] = 'rent';
        }
        $this->session->set_userdata('rentSale',$type);
        redirect('search_properties');
    }

    /** 
     * Function Name: deleteRecord
     * Description: To delete record
    */
    public function deleteRecord(){
        if($this->input->post()){
            $status = 0;
            $postData = $this->input->post();
            $table = $postData['table_name'];
            $record = $postData['record'];
            $where = array('id'=>$record);
            if($this->common_model->deleteData($table,$where)){
                $status = 1;
            }
            echo json_encode(array('status'=>$status));
        }
    }

    /*view my search*/
    public function viewMySearch($id){
        $titleID = decoding($id);
        $searchData = $this->common_model->getsingle(PROPERTY_SEARCH,array('id'=>$titleID));
        if(!empty($searchData)){
            $data['listing'] = $searchData->listing;
            $data['baths'] = $searchData->baths;
            $data['beds'] = $searchData->beds;
            $data['min_price'] = $searchData->min_price;
            $data['max_price'] = $searchData->max_price;
            $data['area'] = $searchData->area;
            $data['min_sqft'] = $searchData->min_sqft;
            $data['max_sqft'] = $searchData->max_sqft;
            $data['keywords'] = $searchData->keywords;
            if(!empty($searchData->category)){
                $data['category'] = unserialize($searchData->category);
            }
            $this->session->set_userdata('save_search',$data);
            redirect('search_properties');
        }
    }

    /*for archiving property*/
    public function archiveProperty(){
        if(!$this->input->is_ajax_request()){
            echo json_encode(array('response'=>'Invalid request'));
        }
        if($this->input->post()){
            $hide = $this->input->post('hide');
            $this->common_model->updateFields(PROPERTY,array('archive'=>0),array('id'=>$hide));
            echo json_encode(array('status'=>1));
        }
    }

    /*for edit property*/
    public function editProperty(){
        loginCheck('user');
        $id = $this->input->get('id');
        $propertyID = base64_decode($id);
        $where = array('property.id'=>$propertyID);
        $propertyData = $this->common_model->GetJoinRecord(PROPERTY,'listing',CATEGORY,'id','property.*,category.name,category.image as cat_img,',$where);
        $data['propertyData'] = $propertyData['result'][0];
        $data['amenities'] = $this->common_model->getAllwhere(AMENITIES,'','name','asc');
        $data['questions'] = $this->common_model->getAllwhere(QUESTIONS,array('property_id'=>$propertyID));
        $this->load->view('frontend/edit_property',$data);
    }

    /*update property data*/
    public function toUpdateProperty(){
        loginCheck('user');
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
            echo json_encode(array('status'=>1));
            die;
        }
    }
}