<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Newprofile extends MY_Controller {
    public function index(){
        if($this->checkUserLogin()){
            $user_id = get_current_user_id();
            $condition=array('id'=>$user_id); 			     					                                             
            $data['user_data'] = get_where('tb_users',$condition,'row');
            $category=$data['user_data']->user_category;
            if($category==""){
                redirect('user/create_category');
            }
            $data['category_details']=$this->common_model->getAllwhere(CATEGORY,array('category_status'=>1));
            $data['category_questions'] = $this->common_model->getsingle(CATEGORY,array('id'=>$category));
            $data['posts_details']    = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_status'=>0), 'id', 'DESC','all',5,0,$group_by='',$and_where = '');
            /*******POST-BY-COMPANY******/
            $datacomps = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_status'=>0), 'id', 'DESC','all','','',$group_by='company',$and_where = '');
            if(!empty($datacomps['result'])){
                foreach($datacomps ['result'] as $compss){
                    $company_ids=$compss->company;
                    if($company_ids==0){
                        $company_name="No Joined";
                    }else{
                        $companyDTL =$this->common_model->getsingle(USERS,array('id'=>$company_ids));
                        $company_name=isset($companyDTL->business_name)?$companyDTL->business_name:'';
                    }

                    $postbycomp = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_status'=>0,'company'=>$company_ids), 'id', 'DESC','all','','',$group_by='',$and_where = ''); 

                    $data['postbycompany'][$company_name]= $postbycomp;
                }
            }
            /**********************/
            if($data['user_data']->user_role == 'Performer'){
                $workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$user_id,'status'=>1),'id','DESC','all',1);

                if(!empty($workingAt['result'])){
                    $compId=$workingAt['result'][0]->receiver;
                    $data['workingAt'] = get_where('tb_users',array('id'=>$compId),'row');
                }else{
                    $data['workingAt']=array();
                }


                $info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country','tb_users.user_role','tb_users.business_name');
                $relation="tb_users.id=friends.user_one_id";
                $condition=array('friends.user_two_id'=>$user_id,'friends.status'=>0);
                $relation2="tb_users.id=friends.user_one_id OR tb_users.id=friends.user_two_id";
                $condition2="(friends.user_two_id='$user_id' OR friends.user_one_id='$user_id') AND friends.status=1 AND tb_users.id!='$user_id' ";
                $data['pendingRequest'] = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,$groupby="");
                $data['allFriends'] = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation2,$condition2,$groupby="");

                $relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
                $condition2="(requests.receiver='$user_id' OR requests.sender='$user_id') AND requests.status=1 AND tb_users.id!='$user_id' ";
                $data['workingAt1'] = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");

                $data['logoutUrl'] = $this->facebook->logout_url();
//*******************//
                $inform=array('ratings.company_id','tb_users.business_name');
                $compRatdata=$this->common_model->get_two_table_data($inform,RATINGS,USERS,'ratings.company_id=tb_users.id',array('ratings.rated_to_user'=>$user_id),"ratings.company_id");
                /************************/
                $indivReview=array();
                foreach($compRatdata as $com){
                    $companyId=$com['company_id'];
                    $business_name=$com['business_name'];
                    $ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id,'company_id'=>$companyId));
                    $reviewcounter=$ratingDetails['total_count'];
                    $ratingAverages=0;
                    $ques1 = 0;
                    $ques2 = 0;
                    $ques3 = 0;
                    $ques4 = 0;
                    $ques5 = 0;
                    $ques = array();
                    if(!empty($ratingDetails['result'])){
                        foreach($ratingDetails['result'] as $row){
                            $retedby=$row->rated_by_user;	
                            $cusers = $this->common_model->getsingle(USERS,array('id'=>$retedby));
                            $givername=isset($cusers->firstname) ? $cusers->firstname : "" ;
                            $profile=isset($cusers->profile) ? $cusers->profile : "" ;
                            $city=isset($cusers->city) ? $cusers->city : "" ;
                            $state=isset($cusers->state) ? $cusers->state : "" ;
                            $country=isset($cusers->country) ? $cusers->country : "";

                            if($row->ques_1){
                                $ques1+= $row->ques_1;
                            }
                            if($row->ques_2){
                                $ques2+= $row->ques_2;
                            }
                            if($row->ques_3){
                                $ques3+= $row->ques_3;
                            }
                            if($row->ques_4){
                                $ques4+= $row->ques_4;
                            }
                            if($row->ques_5){
                                $ques5+= $row->ques_5;
                            }

                            $history = array();
                            if($ques1!=0){
                                $ques = $ques1/$reviewcounter;
                                $history[0] = $ques;
                                $ques_[0] = starRating($ques);
                            }
                            else
                                $ques_[0] = starRating(0);


                            if($ques2!=0){
                                $ques = $ques2/$reviewcounter;
                                $history[1] = $ques;
                                $ques_[1] = starRating($ques);
                            }
                            else
                                $ques_[1] = starRating(0);

                            if($ques3!=0){
                                $ques = $ques3/$reviewcounter;
                                $history[2] = $ques;
                                $ques_[2] = starRating($ques);
                            }
                            else
                                $ques_[2] = starRating(0);

                            if($ques4!=0){
                                $ques = $ques4/$reviewcounter;
                                $history[3] = $ques;
                                $ques_[3] = starRating($ques);
                            }
                            else
                                $ques_[3] = starRating(0);

                            if($ques5!=0){
                                $ques = $ques5/$reviewcounter;
                                $history[4] = $ques;
                                $ques_[4] = starRating($ques);
                            }
                            else{
                                $ques_[4] = starRating(0);
                            }
                            $ques_['message']=$row->message;
                            $ques_['company_id']=$companyId;
                            $ques_['retedbyid']=$row->rated_by_user;
                            $ques_['givername']=$givername;
                            $ques_['profile']=$profile;
                            $ques_['address']=$city.','.$state.','.$country;
                            $indivReview[$business_name][]= $ques_;
                        }

                    } else{
                        for($i=0;$i<=5;$i++){
                            $ques_[$i] = starRating(0);
                        }
                        $indivReview[$business_name]['historyRating'][]= $ques_;
                    }
                }
                $data['MyhistoryRating'] = $indivReview;
//code for overall rating
                $data['ratingDetails'] = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$user_id));
                $data['reviewCount'] = $data['ratingDetails']['total_count'];

                if(!empty($data['ratingDetails']['result'])){
                    $ratingAverage=0;
                    $reviewCount  = $data['ratingDetails']['total_count'];
                    foreach($data['ratingDetails']['result'] as $row){
                        $average = 0;
                        $total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
                        if($total>0){
                            $average = $total/5;
                        }
                        $ratingAverage+=$average;
                    }
                    if($ratingAverage>0)
                        $data['ratingAverage'] = $ratingAverage/$reviewCount;
                    else
                        $data['ratingAverage'] = 0;
                    $data['starRating'] = starRating($data['ratingAverage'],$data['reviewCount']);
//code for questionwise rating in history
                    $ques1 = 0;
                    $ques2 = 0;
                    $ques3 = 0;
                    $ques4 = 0;
                    $ques5 = 0;
                    $ques = array();
                    foreach($data['ratingDetails']['result'] as $row){
                        if($row->ques_1){
                            $ques1+= $row->ques_1;
                        }
                        if($row->ques_2){
                            $ques2+= $row->ques_2;
                        }
                        if($row->ques_3){
                            $ques3+= $row->ques_3;
                        }
                        if($row->ques_4){
                            $ques4+= $row->ques_4;
                        }
                        if($row->ques_5){
                            $ques5+= $row->ques_5;
                        }

                        $history = array();
                        if($ques1!=0){
                            $ques = $ques1/$reviewCount;
                            $history[0] = $ques;
                            $ques_[0] = starRating($ques);
                        }
                        else
                            $ques_[0] = starRating(0);


                        if($ques2!=0){
                            $ques = $ques2/$reviewCount;
                            $history[1] = $ques;
                            $ques_[1] = starRating($ques);
                        }
                        else
                            $ques_[1] = starRating(0);

                        if($ques3!=0){
                            $ques = $ques3/$reviewCount;
                            $history[2] = $ques;
                            $ques_[2] = starRating($ques);
                        }
                        else
                            $ques_[2] = starRating(0);

                        if($ques4!=0){
                            $ques = $ques4/$reviewCount;
                            $history[3] = $ques;
                            $ques_[3] = starRating($ques);
                        }
                        else
                            $ques_[3] = starRating(0);

                        if($ques5!=0){
                            $ques = $ques5/$reviewCount;
                            $history[4] = $ques;
                            $ques_[4] = starRating($ques);
                        }
                        else
                            $ques_[4] = starRating(0);
                    }

                    $data['historyRating'] = $ques_;
                    $data['historyReviewsRating'] = $history;
                }else{
                    for($i=0;$i<=5;$i++){
                        $ques_[$i] = starRating(0);
                    }
                    $data['historyRating'] = $ques_;
                    $data['starRating'] = starRating(0,0);
                }

//Rank section
                $userInfo = $this->common_model->getsingle(USERS,array('id'=>$user_id));
                $category = $userInfo->user_category;
                $data['userRankRatings'] = $this->common_model->get_two_table_data('tb_users.*,count(ratings.id) as review_count',USERS,RATINGS,'tb_users.id = ratings.rated_to_user',array('tb_users.user_category'=>$category,'user_role!='=>'Employer'),'rated_to_user','review_count',"DESC");
                if(!empty($data['userRankRatings'])){
                    $count = 0;
                    foreach($data['userRankRatings'] as $key=>$rating){
                        $count++;
                        $ratingDetails = $this->common_model->getAllwhere(RATINGS,array('rated_to_user'=>$rating['id']));
                        if(!empty($ratingDetails['result'])){
                            $ratingAverage=0;
                            $reviewCount  = $rating['review_count'];
                            foreach($ratingDetails['result'] as $row){
                                $average = 0;
                                $total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
                                if($total>0){
                                    $average = $total/5;
                                }
                                $ratingAverage+=$average;
                            }
                            if($ratingAverage>0)
                                $ratingAverage = $ratingAverage/$reviewCount;
                            else
                                $ratingAverage = 0;
                            $starRating = starRating($ratingAverage,$rating['review_count']);

                        }
                        else{
                            $ratingAverage = 0;
                            $starRating = starRating($ratingAverage,0);
                        }
                        $data['userRankRatings'][$key]['star_rating'] = $starRating;
                        $data['userRankRatings'][$key]['rank'] = $count;
                    }
                }
//performance calculation
                $percentarray = array();
                if(!empty($data['ratingDetails']['result'])){
                    $percent_cnt1 = 0;
                    $percent_cnt2 = 0;
                    $percent_cnt3 = 0;
                    $percent_cnt4 = 0;
                    $percent_cnt5 = 0;

                    foreach($data['ratingDetails']['result'] as $row){
                        $average = 0;
                        $total = $row->ques_1+$row->ques_2+$row->ques_3+$row->ques_4+$row->ques_5;
                        if($total>0){
                            $average = $total/5;
                            $average = floor($average);
                            if($average > 0){
                                if($average == 1)
                                    $percent_cnt1++;
                                if($average == 2)
                                    $percent_cnt2++;
                                if($average == 3)
                                    $percent_cnt3++;
                                if($average == 4)
                                    $percent_cnt4++;
                                if($average == 5)
                                    $percent_cnt5++;
                            }
                        }
                    }
                    if($percent_cnt1>0){
                        $percentarray[1] = ($percent_cnt1/$data['ratingDetails']['total_count'])*100;
                    }if($percent_cnt2>0){
                        $percentarray[2] = ($percent_cnt2/$data['ratingDetails']['total_count'])*100;
                    }if($percent_cnt3>0){
                        $percentarray[3] = ($percent_cnt3/$data['ratingDetails']['total_count'])*100;
                    }if($percent_cnt4>0){
                        $percentarray[4] = ($percent_cnt4/$data['ratingDetails']['total_count'])*100;
                    }if($percent_cnt5>0){
                        $percentarray[5] = ($percent_cnt5/$data['ratingDetails']['total_count'])*100;
                    }
                }
                $data['percentarray'] = $percentarray;

                //QR code generate
                $data['img_url']="";
                $this->load->library('ciqrcode');
                $qr_image=rand().'.png';
                $params['data'] = $userInfo->email;
                $params['level'] = 'H';
                $params['size'] = 5;
                $params['savename'] =FCPATH."qr_code/".$qr_image;
                if($this->ciqrcode->generate($params))
                {
                    $data['qr_image']=base_url().'qr_code/'.$qr_image; 
                }

                $this->pageviewnofooter('newprofile',$data,$data,array()); 
            }else{
                $info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country');
                $relation="tb_users.id=requests.sender";

                $condition=array('requests.receiver'=>$user_id,'requests.status'=>0);
                $relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
                $condition2="(requests.receiver='$user_id' OR requests.sender='$user_id') AND requests.status=1 AND tb_users.id!='$user_id' ";
                $data['pendingRequest'] = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation,$condition,$groupby="");
                $data['allEmployee'] = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");

                $data['logoutUrl'] = $this->facebook->logout_url();
                //QR code generate
                $userData = $this->session->userdata();
                $data['img_url']="";
                $this->load->library('ciqrcode');
                $qr_image=rand().'.png';
                $params['data'] = $userData['userData']['email'];
                $params['level'] = 'H';
                $params['size'] = 5;
                $params['savename'] =FCPATH."qr_code/".$qr_image;
                if($this->ciqrcode->generate($params))
                {
                    $data['qr_image']=base_url().'qr_code/'.$qr_image; 
                }
                $this->pageviewnofooter('businessprofile',$data,$data,array()); 
// redirect('businessprofile');
            }			   	 

        }else{
            $this->session->set_flashdata('loginmsg','<div class="alert alert-danger text-center">Oops!.  Plz Set your Role!!!</div>');
            redirect('create-category');
        }           
    }
/*******************GET-POST-BY-Id*******************/
public function postByLimit($limit,$last_id,$userId){
    $id = decoding($userId);
    $posts_details = $this->common_model->getAllwhere(POSTS,array('user_id'=>$id,'post_status'=>0,'id<'=>$last_id), 'id', 'DESC','all','3','3',$group_by='',$and_where = '');

    $html="";
    if(!empty($posts_details['result'])){ foreach($posts_details['result'] as $post){
        $postimg="";

        if($post->post_image!=""){
            $imgsert=$post->post_image;
            $postimgarr=explode(',',$imgsert);
            if(count($postimgarr)>1){ 
                $postimg.='<div class="row">';
                foreach($postimgarr as $postim){
                    $postimg.='<div class ="col-sm-4 col-md-4"><a href="#" class="thumbnail"><img src="'.base_url().$postim.'" alt="Post Image"></a></div>';
                }
                $postimg.="</div>";
            }else{
                $postimg='<div class="over_viewimg"><img src="'.base_url().$post->post_image.'" class="img-fluid"><div class="bl-box"><img src="'.base_url().'assets/images/scrl.png"></div></div>';
            }
        }


        $html.='	
        <div class="main_blog post-id" id="'.$post->id.'" data-id="'.encoding(get_current_user_id()).'">
            '.$postimg.'
            <div class="contant_overviw esdu" onclick="setID('.$post->id.');"><h1 class="datess">'. date('d-m-Y H:i A',strtotime($post->post_date)).'</h1>
                <div class="btnns">
                    <div class="form-group">
                        <a href="#" class="linke"><img src="'.base_url().'assets/images/like.png">
                            <i class="fa fa-thumbs-up"></i>
                        </a>
                    </div>
                    <a href="" class="editss" data-toggle="modal" data-target="#myModal2"><img src="'.base_url().'assets/images/edit.png" onclick="editPost('.$post->id.')"></a>
                    <a href="" class="editss" data-toggle="modal" data-target="#modalDelete"><i class="fa fa fa-trash-o"></i></a>
                </div>
                <p>'.$post->post_content.'</p></div></div>';
            } }else{
                $html="";
            } 
            echo $html;

        }		
        /****************************************/
        public function Update_profileimg(){
            if(isset($_FILES['profileimg']['name']) && !empty($_FILES['profileimg']['name'])){
                $image = fileUploading('profileimg','users','jpg|gif|png|jpeg|JPG|PNG');
                if(isset($image['error'])){
                    $return['status']         =   0; 
                    $return['message']        =   strip_tags($image['error']);
                    $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Photo Not Uploaded.'.$image['error'].' </div>');
                    redirect('newprofile');
                    exit;
                }else{
                    $dataArr['profile']    =  base_url().'uploads/users/'.$image['upload_data']['file_name'];
                }
            }

            $user_id = get_current_user_id();

            $condition=array('id'=>$user_id); 	

            $update = $this->common_model->updateFields(USERS,$dataArr,array('id'=>$user_id));
            if($update)
            {                	
                redirect('newprofile');
            }

        }
        /****************************************/
        public function Editprofile(){

            if(!empty($this->input->post('oldprofessional_skill'))){
                $proskill=array();
                $profressional_skill = implode(",",$this->input->post('oldprofessional_skill')).','.$this->input->post('newprofessional_skill');
                $profressional_skill = rtrim($profressional_skill,",");
                /*****Remove Space*****/
                $skill_array=explode(',',$profressional_skill);

                if(count($skill_array)>0){
                    foreach($skill_array as $arr){
                        $proskill[]=trim($arr);
                    }
                } 
            }else{
                $profressional_skill = $this->input->post('newprofessional_skill');
                /****Remove Space*****/
                $skill_array=explode(',',$profressional_skill);
                if(count($skill_array)>0){
                    foreach($skill_array as $arr){
                        $proskill[]=trim($arr);
                    }
                }

            }

            $profressional_skill=implode(',',$proskill);

            if(!empty($this->input->post('oldadditional_services'))){
                $additional_services = implode(",",$this->input->post('oldadditional_services')).','.$this->input->post('newadditional_services');     
                $additional_services = rtrim($additional_services,",");     
            }else{  
                $additional_services = $this->input->post('newadditional_services');
            }   

            if(!empty($this->input->post('cnewpassword'))){
                $oldpass = $this->input->post('oldpassword');
                $newpass = $this->input->post('newpassword');
                $cnewpass = $this->input->post('cnewpassword');

                $user_id = get_current_user_id();
                $condition=array('id'=>$user_id);                                                                  
                $user_data = get_where('tb_users',$condition,'row');
                $hashpassword = $user_data->password;
                $checkoldpassword = password_check($oldpass,$hashpassword);

                $userdata = array(
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),                                         
                    'website_link' => $this->input->post('website_link'), 
                    'password' => generate_password($this->input->post('cnewpassword')),                
                    'phone' => $this->input->post('phone'),
                    'zip' => $this->input->post('zip'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'user_category' => $this->input->post('user_category'),
                    'current_position' => $this->input->post('current_position'),
                    'working_at' => $this->input->post('working_at'),
                    'professional_skill' => $profressional_skill, 
                    'additional_services' => $additional_services                       
                    );
                if(!empty($this->input->post('oldpassword'))){

                    if($checkoldpassword=='verified'){

                        if($newpass == $cnewpass){                                                 

                            $user_id = get_current_user_id();

                            $condition=array('id'=>$user_id);  

                            $update = update_data('tb_users',$userdata,$condition);

                            if($update){ 
                                $this->session->unset_userdata('id');
                                $this->session->sess_destroy();             
                                redirect('login');
                            }
                        }else{
                            $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Password is Not Match Plz Try Again!!!</div>');
                            redirect('newprofile'); 
                        }

                    }else{
                        $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Your Current Password is Wrong Plz Enter Correct Password!!!</div>');
                        redirect('newprofile'); 
                    } 
                }
                else{       
                    if($newpass == $cnewpass){

                        $user_id = get_current_user_id();

                        $condition=array('id'=>$user_id);  

                        $update = update_data('tb_users',$userdata,$condition);
                        if($update){ 
                            $this->session->unset_userdata('id');
                            $this->session->sess_destroy();             
                            redirect('login');
                        }
                    }else{
                        $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Password is Not Match Plz Try Again!!!</div>');
                        redirect('newprofile'); 
                    }
                }                                          
            }

            else
            { 
                $userdata = array(
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'website_link' => $this->input->post('website_link'),													
                    'phone' => $this->input->post('phone'),
                    'zip' => $this->input->post('zip'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'user_category' => $this->input->post('user_category'),
                    'current_position' => $this->input->post('current_position'),
                    'working_at' => $this->input->post('working_at'),
                    'professional_skill' => $profressional_skill,	
                    'additional_services' => $additional_services													
                    );
                $user_id = get_current_user_id();

                $condition=array('id'=>$user_id); 	

                $update = update_data('tb_users',$userdata,$condition);

                if($update)
                { 
                    $this->session->set_flashdata('updatemsg','<div class="alert alert-success text-center">You are Successfully Updated your Profile!</div>');               	
                    redirect('newprofile');
                }
                else
                {
                    $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">error in update your profile</div>');
                    redirect('newprofile');	
                }
            }


        }
//************************************/
        public function Checkoldpassword(){
            if($this->input->server('REQUEST_METHOD') == 'POST'){ 
                $userdata=json_decode($this->input->post('userdata'));
                $oldpassword = $userdata->oldpassword;
                $user_id = get_current_user_id();
                $condition=array('id'=>$user_id); 			     					                                             
                $user_data = get_where('tb_users',$condition,'row');
                $hashpassword = $user_data->password;
                $checkoldpassword = password_check($oldpassword,$hashpassword);
                if($checkoldpassword=='verified'){
                    $arr['result']=1;
                }
                else{
                    $arr['result']=0;
                }
            }
            else{
                $arr['result']=0;

            }     
            echo json_encode($arr);
        }

        /*for saving ratings of the user*/
        public function ratings(){
            if(!$this->input->is_ajax_request()){
                echo json_encode(array('response'=>'Invalid request'));
            }
            if($this->checkUserLogin()){
                if($this->input->post()){
                    $dataInsert['rated_by_user'] = get_current_user_id();
                    $dataInsert['rated_to_user'] = $this->input->post('rated_to');
                    $userComapny = $this->common_model->getsingle(REQUESTS,array('sender'=>$dataInsert['rated_to_user']),'','id','DESC');
                    if(!empty($userComapny))
                        $dataInsert['company_id'] = $userComapny->receiver;
                    else
                        $dataInsert['company_id'] = 0;
                    $ratingsData = $this->common_model->getsingle(RATINGS,$dataInsert);
                    if($this->input->post('ques1'))
                        $dataInsert['ques_1'] = $this->input->post('ques1');
                    if($this->input->post('ques2'))
                        $dataInsert['ques_2'] = $this->input->post('ques2');
                    if($this->input->post('ques3'))
                        $dataInsert['ques_3'] = $this->input->post('ques3');
                    if($this->input->post('ques4'))
                        $dataInsert['ques_4'] = $this->input->post('ques4');
                    if($this->input->post('ques5'))
                        $dataInsert['ques_5'] = $this->input->post('ques5');
                    $dataInsert['message'] = $this->input->post('message');
                    $dataInsert['rate_date'] = date('Y-m-d H:i:s');
                    if(empty($ratingsData)){
                        $ins = $this->common_model->insertData(RATINGS, $dataInsert);
                        if($ins){
                            $ret=array('status'=>'success');
                        }
                    }else{
                        $this->common_model->updateFields(RATINGS,$dataInsert,array('id'=>$ratingsData->id));
                        $ret=array('status'=>'success');
                    }
                }
            }else{
                $ret=array('status'=>'Failed','msg'=>'Login first');
            }
            echo json_encode($ret);
            exit;
        }

        /*Edit post*/
        public function editPost(){
            if($this->input->is_ajax_request()){
                $postID = $this->input->post('id');
                $data['postData'] = $this->common_model->getsingle(POSTS,array('id'=>$postID));
                $this->load->view('frontend/modal_edit',$data);
            }
        }

        /*To unfriend*/
        public function unfriend(){
            if($_POST){
                $record = $this->input->post('record');
                if($this->common_model->deleteData(FRIENDS,array('user_one_id'=>$record,'user_two_id'=>get_current_user_id()))){
                    echo json_encode(array('status'=>1));
                }else if($this->common_model->deleteData(FRIENDS,array('user_one_id'=>get_current_user_id(),'user_two_id'=>$record))){
                    echo json_encode(array('status'=>1));
                }
            }
        }

/****************************************/
public function wallpost2(){
if($this->checkUserLogin()){
if(!empty($_FILES['file'])){
				$loggedUserId=get_current_user_id();
				$fileName = $_FILES['file']['name'];
				$dats=explode('.',$fileName);
				$ext=$dats[1];
				$targetDir = FCPATH."uploads/videos/";
				$newfilename=time().'_'.rand(99999,9999999999).'_'.rand(10000,99999).'.'.$ext;
				$targetFile = $targetDir.$newfilename;
   if(move_uploaded_file($_FILES['file']['tmp_name'],$targetFile)){
	   $dataArr['post_video']=$newfilename;
	   $datam=array('lastFileName'=>$newfilename);
	   $this->session->set_userdata($datam);
	   $loggedUserId=get_current_user_id();
			$user_data = $this->common_model->getsingle(USERS,array('id'=>$loggedUserId));
			if($user_data->user_role == 'Performer'){
				$workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$loggedUserId,'status'=>1),'id','DESC','all',1);
				if(!empty($workingAt['result'])){
					$compId=$workingAt['result'][0]->receiver;
					$company =$this->common_model->getsingle(USERS,array('id'=>$compId));
					$dataArr['company']=$company->id;
				}else{
					$dataArr['company']=0;
				}
			}

			$dataArr['post_title']=$_POST['post_title'];
			$dataArr['post_content']=$_POST['post_content'];
			$dataArr['user_id']=$loggedUserId;
			$dataArr['post_status']=0;
	        $addpost = $this->common_model->insertData(POSTS,$dataArr); 
			//$postData = $this->common_model->getsingle(POSTS,array('id'=>$addpost));

   }else{
	   echo $fileName. " Not Getting";
   }
			}else{
				echo "not";
			}
}else{
		$ret=array('status'=>'Failed','msg'=>'Something Went Wrong, Try Again');
		echo json_encode($ret);	
}	
}
public function wallpost3(){
	$dataArr=array();
	$filename=$this->session->userdata('lastFileName');
	$post=$this->input->post('post_content');
	$dataArr['post_content']=$post;
	 $addpost = $this->common_model->updateFields(POSTS,$dataArr,array('post_video'=>$filename));
	if($addpost){
		$arr=array('results'=>1,'msg'=>'posted successfully');
	}else{
		$arr=array('results'=>0,'msg'=>'something went wrong');
	}
	$datam=array('lastFileName'=>'');
	$this->session->set_userdata($datam);
	$this->session->unset_userdata($datam);
	echo json_encode($arr);
}
/*******************/
    }