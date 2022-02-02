<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors', 1);
error_reporting(E_ALL);

class Profile extends MY_Controller {

    public function index(){

        $this->session->set_userdata('user_login_type','performer');

        if($this->checkUserLogin()){
            if($this->input->get('page') && $this->input->get('page')=='task'){
                $this->session->set_userdata('my_tasks',1);
            }else{
                $this->session->set_userdata('my_tasks','');
            }
            $user_id = get_current_user_id();
            $lastData=$this->common_model->custom_query("SELECT `id` as last_ID from ".POSTS." WHERE post_status='0' AND user_id='$user_id'  ORDER BY id DESC LIMIT 1");
            if(!empty($lastData)){
                $data['last_ID']=$lastData[0]['last_ID'];
            }
            $condition=array('id'=>$user_id);
            $data['user_data'] = get_where('tb_users',$condition,'row');
            if($data['user_data']->user_role == ''){
                $this->session->set_flashdata('loginmsg','<div class="alert alert-danger text-center">Oops!.  Plz Set your Role!!!</div>');
                redirect('create-category');
            }
            $category=isset($data['user_data']->user_category) ? $data['user_data']->user_category : '';
            $data['category_details']=$this->common_model->getAllwhere(CATEGORY,array('category_status'=>1));
            if($category!='')
                $data['category_questions'] = $this->common_model->getsingle(CATEGORY,array('id'=>$category));

            $this->common_model->updateFields(POSTS,array('repeat_status'=>0),array('user_id'=>$user_id));
            $data['posts_details']    = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_status'=>0), 'id', 'DESC','all',2,0,$group_by='',$and_where = '');
            if(!empty($data['posts_details']['result'])){
                foreach($data['posts_details']['result'] as $row1){
                    $this->common_model->updateFields(POSTS,array('repeat_status'=>1),array('id'=>$row1->id));
                }
            }
            $this->session->set_userdata('posts',array());
            $info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country','tb_users.user_role','tb_users.business_name');
            $relation2="tb_users.id=friends.user_one_id OR tb_users.id=friends.user_two_id";
            $condition2="(friends.user_two_id='$user_id' OR friends.user_one_id='$user_id') AND friends.status=1 AND tb_users.id!='$user_id' ";
            $allFriends = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation2,$condition2,$groupby="");
            $allFriendsCompany = array();
            if(!empty($allFriendsCompany) && !empty($allFriends)){
                $data['allFriends'] = array_merge($allFriends,$allFriendsCompany);
            }else if(!empty($allFriends)){
                $data['allFriends'] = $allFriends;
            }else if(!empty($allFriendsCompany)){
                $data['allFriends'] = $allFriendsCompany;
            }
            //QR code generate
            $data['img_url']="";
            $this->load->library('ciqrcode');
            $qr_image=rand().'.png';
            $params['data'] = base_url().'viewdetails/profile/'.encoding(get_current_user_id())."?review=1";
            $params['level'] = 'H';
            $params['size'] = 5;
            $params['savename'] =FCPATH."qr_code/".$qr_image;
            if($this->ciqrcode->generate($params))

            {
                $data['qr_image']=base_url().'qr_code/'.$qr_image; 
            }
            $data['albumData']=$this->common_model->getAllwhere(ALBUMS,array('user_id'=>get_current_user_id(),'folder_id' => 0));
            $data['albumFolderData']=$this->common_model->getAllwhere(ALBUM_DIR,array('user_id'=>get_current_user_id(),'dir_parent'=>0));
            
            /**********************/
            if($data['user_data']->user_role == 'Performer'){
                $workingAt=$this->common_model->getAllwhere(REQUESTS,array('sender'=>$user_id,'status'=>1),'id','DESC','all',1);
                if(!empty($workingAt['result'])){
                    $compId=$workingAt['result'][0]->receiver;
                    $data['workingAt'] = get_where('tb_users',array('id'=>$compId),'row');
                }else{
                    $data['workingAt']=array();
                }
                $data['logoutUrl'] = $this->facebook->logout_url();
                
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
                    foreach($data['ratingDetails']['result'] as $row)
                    {
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
                $params['data'] = base_url().'viewdetails/profile/'.encoding(get_current_user_id())."?review=1";
                $params['level'] = 'H';
                $params['size'] = 5;
                $params['savename'] =FCPATH."qr_code/".$qr_image;
                if($this->ciqrcode->generate($params))

                {
                    $data['qr_image']=base_url().'qr_code/'.$qr_image; 
                }
                
                /*To get my tasks*/
                $data['taskList'] = $this->common_model->GetJoinRecordThree(TASK,'id',TASK_ASSIGNED,'task_id',USERS,'id',TASK,'assigned_by','task.*,task_assigned.*,tb_users.business_name',array('task_assigned.user_id'=>$user_id),"",'task_assigned.assigned_date','DESC');
                $this->pageviewnofooter('profile',$data,$data,array()); 
            }else{
                //code for yahoo invites mail url //
                // require_once(APPPATH.'libraries/yahoo_api/globals.php');
                // require_once(APPPATH.'libraries/yahoo_api/oauth_helper.php');
                // $callback    =    base_url()."user/yahoo_response";
                // $retarr = get_request_token(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET,
                //     $callback, false, true, true);
                // if (! empty($retarr)){
                //     list($info, $headers, $body, $body_parsed) = $retarr;
                //     if ($info['http_code'] == 200 && !empty($body)) {
                //         $_SESSION['request_token']  = $body_parsed['oauth_token'];
                //         $_SESSION['request_token_secret']  = $body_parsed['oauth_token_secret']; $_SESSION['oauth_verifier'] = $body_parsed['oauth_token'];
                //         $data['yahooURL'] = urldecode($body_parsed['xoauth_request_auth_url']);
                //     }
                // }
                $info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country','tb_users.user_role');
                $relation="tb_users.id=requests.sender";
                $condition=array('requests.receiver'=>$user_id,'requests.status'=>0,'requests.job_requested_by!='=>get_current_user_id());
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
                $params['data'] = base_url().'viewdetails/profile/'.encoding(get_current_user_id())."?review=1";
                $params['level'] = 'H';
                $params['size'] = 5;
                $params['savename'] =FCPATH."qr_code/".$qr_image;
                if($this->ciqrcode->generate($params))
                {
                    $data['qr_image']=base_url().'qr_code/'.$qr_image; 
                }
                $data['albumData']=$this->common_model->getAllwhere(ALBUMS,array('user_id'=>get_current_user_id(),'folder_id' => 0));
                $data['albumFolderData']=$this->common_model->getAllwhere(ALBUM_DIR,array('user_id'=>get_current_user_id(),'dir_parent'=>0));

                /*to fetch performers under employer*/
                $relation2="tb_users.id=requests.sender";
                $condition2=" requests.status=1 and  requests.receiver=".$user_id;
                $data['performersList'] = $this->common_model->get_two_table_data('tb_users.id,tb_users.firstname,tb_users.lastname',USERS,REQUESTS,$relation2,$condition2,$groupby='');

                /*To fetch all tasks assigned*/
                $data['taskList'] = $this->common_model->getAllwhere(TASK,array('assigned_by'=>$user_id),'start_date','DESC');

                $data['startDates'] = $this->common_model->getAllwhere(TASK,array('assigned_by'=>$user_id),'start_date','ASC');

                /*To get my tasks*/
                $data['taskListAssigned'] = $this->common_model->GetJoinRecordThree(TASK,'id',TASK_ASSIGNED,'task_id',USERS,'id',TASK_ASSIGNED,'user_id','task.*,task_assigned.*,tb_users.firstname,tb_users.lastname',array('task.assigned_by'=>$user_id),"",'task_assigned.assigned_date','DESC');

                
                $this->pageviewnofooter('businessprofile',$data,$data,array()); 
            }                
        }else{
            $this->session->set_flashdata('loginmsg','<div class="alert alert-danger text-center">Oops!.  Plz Set your Role!!!</div>');
            redirect('create-category');
        }

    }
  /*******************GET-POST-BY-Id*******************/

    public function postByLimit($limit,$last_id,$userId,$type=false){
        if($last_id==0){
            echo "";
            die();
        }

        $user_data = $this->common_model->getsingle(USERS,array('id'=>$userId));
        $random = substr(md5(mt_rand()), 0, 7);
        $id = $userId;
        if($type){
            /*Post of all the members within contact*/
            $contactIDs = array();

            $info = 'tb_users.id';
            $relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
            $condition2="(requests.receiver='$userId' OR requests.sender='$userId') AND requests.status=1 AND tb_users.id!='$userId' ";
            $companyContacts = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,"");
            if(!empty($companyContacts)){
                foreach($companyContacts as $id){
                    if(get_current_user_id()!=$id['id']){
                        $contactIDs[] = $id['id'];
                    }
                }
            }


            $relation="tb_users.id=friends.user_one_id";
            $condition="(friends.user_two_id='$userId' OR friends.user_one_id='$userId') AND friends.status=1 AND tb_users.id!='$userId' ";
            $friendContacts = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,"");
            if(!empty($friendContacts)){
                foreach($friendContacts as $id){
                    if(get_current_user_id()!=$id['id']){
                        $contactIDs[] = $id['id'];
                    }
                }
            }

            if(!empty($contactIDs)){
                $contacts = implode(",",$contactIDs);
                $condition = ' user_id IN('.$contacts.') and post_status=0 and posts.id<'.$last_id;
                $posts_details = $this->common_model->GetJoinRecord(USERS,'id',POSTS,'user_id','tb_users.firstname,tb_users.lastname,tb_users.business_name,tb_users.user_role,tb_users.profile,tb_users.id as user_id1,posts.*',$condition,'','posts.id','DESC','2','0');
            }

        }else{
            $posts_details = $this->common_model->getAllwhere(POSTS,array('user_id'=>$id,'post_status'=>0,'id<'=>$last_id,'repeat_status'=>0), 'id', 'DESC','all','2','0',$group_by='',$and_where = '');
        }
        $html="";
        $sessionArr = $this->session->userdata('posts');
        if(!empty($posts_details['result'])){
            $md = 0;
            foreach($posts_details['result'] as $post){ 
                $md=$post->id;
                if($type){
                    $html.='<div class="user_highlights"><h5>';
                    $html.=($post->user_role == 'Performer')?($post->firstname." ".$post->lastname):$post->business_name;
                    $html.='</h5>';
                    if($post->profile!='assets/images/default_image.jpg'){ 
                        $html.='<img src="'.$post->profile.'" alt="Post Image" class="">';
                    } 
                    else{
                        $html.='<img src="'.base_url().$post->profile.'" alt="Post Image" class="">';
                    }
                    $userRating = userOverallRatings($post->user_id1);
                    if(!empty($userRating['starRating'])){
                        $html.=preg_replace("/\([^)]+\)/","",$userRating['starRating']);
                    }
                    $html.='</div>';
                }else{
                    $this->common_model->updateFields(POSTS,array('repeat_status'=>1),array('id'=>$md));
                }
                if(!in_array($post->id,$sessionArr)){
                    $sessionArr[] = $post->id;
                    $postimg="";
                    if($post->post_image!=""){
                        $imgsert=$post->post_image;
                        $postimgarr=explode(',',$imgsert);
                        if(count($postimgarr)>1){ 
                            $postimg.='<div class="row">';
                            foreach($postimgarr as $postim){
                                $postimg.='<div class = "col-sm-3 col-md-3 thumb_upx2">
                                <div class="fansy-gallry">  
                                <a class="thumbnail" data-fancybox="gallery11'.$random.$md.'" href="'.$postim.'">
                                <img src="'.$postim.'">
                                </a>
                                </div>
                                </div>';

                            }
                            $postimg.='
                            <div class="col-tz">    
                            <div id="myModal00new'.$md.'" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                            <div class="row">';
                            foreach($postimgarr as $postim){
                                $postimg.='<div class="col-md-3">
                                <div class="fansy-gallry">  
                                <a class="fancybox" data-fancybox="gallery11'.$random.$md.'" href="'.$postim.'">
                                <img src="'.$postim.'">
                                </a>
                                </div>
                                </div>';
                            }  
                            $postimg.=' </div>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>';
                        }else{
                            if(count($postimgarr) == 1){ 
                                $postimg='<div class = "over_viewimg">
                                <a class="img-fluid" data-fancybox="gallery11'.$random.$md.'" href="'.$postimgarr[0].'">
                                <img src="'.$postimgarr[0].'">
                                </a>
                                </div>';
                            }
                            $postimg.='
                            <div class="col-tz">    
                            <div id="myModal00new'.$md.'" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                            <div class="row">';
                            foreach($postimgarr as $postim){
                                $postimg.='<div class="col-md-3">
                                <div class="fansy-gallry">  
                                <a class="fancybox" data-fancybox="gallery11'.$random.$md.'" href="'.$postim.'">
                                <img src="'.$postim.'">
                                </a>
                                </div>
                                </div>';
                            }  
                            $postimg.=' </div>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>';
                        }
                    }
                    if($post->post_video!=''){
                        $html.='<div class="row">
                        <div>
                        <video width="320" height="240" controls class="videos">
                        <source src="'.base_url().'uploads/videos/'.$post->post_video.'" type="video/mp4">
                        <source src="'.base_url().'ploads/videos/'.$post->post_video.'" type="video/webm">
                        <source src="'.base_url().'uploads/videos/'.$post->post_video.'" type="video/ogg">
                        <source src="'.base_url().'uploads/videos/'.$post->post_video.'" type="video/mts">
                        </video>
                        </div>
                        </div>';
                    } 
                    if($type){
                        $html.='    
                        <div class="main_blog post-id1" id="'.$post->id.'" data-uid="'.$userId.'">
                        '.$postimg;

                    }
                    else{
                        $html.='    
                        <div class="main_blog post-id" id="'.$post->id.'" data-uid="'.$userId.'">
                        '.$postimg;
                    }


                    $html.='<div class="contant_overviw esdu" onclick="setID('.$post->id.');"><h1 class="datess">'. date('d-m-Y H:i A',strtotime($post->post_date)).'</h1>
                    <div class="btnns">';
                    $classShare = 'sharePostModal';
                    if($type){
                        $classShare = 'sharePostModal1';
                    }
                    $html.='
                    <div class="form-group">';
                    $html.='<a href="#" class="linke" data-toggle="modal" data-target="#'.$classShare.$md.'"><img src="'.base_url().'assets/images/share.png">
                    <i class="fa fa-thumbs-up"></i>
                    </a>';
                    $html.='<div class="modal fade" id="'.$classShare.$md.'">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Boost Visibility</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>';
                    $fullURL = basE_url().'viewdetails/profile/'.encoding($userId);
                    if(isset($imgsert))
                        $imgserts = "'".$imgsert."'";
                    else
                        $imgserts = '';

                    if($type){
                        if($post->user_role == 'Employer'){
                            $sname = "'".ucwords($post->business_name). ' status'."'";
                        }else{
                            $sname = "'".ucwords($post->firstname)." ".ucwords($post->lastname). " status"."'";
                        }
                    }else{
                        if($user_data->user_role == 'Employer'){
                            $sname = "'".ucwords($user_data->business_name). ' status'."'";
                        }else{
                            $sname = "'".ucwords($user_data->firstname)." ".ucwords($user_data->lastname). " status"."'";
                        }
                    }

                    $html.='</div>
                    <div class="modal-body">
                    <div id="share-buttons" title="Share Profile">
                    <a href="https://twitter.com/share?url='.$fullURL.'" target="_blank">
                    <i class="fa fa-twitter"></i>
                    </a>';
                    if($post->post_video!=''){
                        $video = "'".base_url()."uploads/videos/".$post->post_video."'";
                        $html.='<a href="javascript:void(0)" class="PIXLRIT1" onclick="publish('.$video.','.$sname.');" target="_blank">
                        <i class="fa fa-facebook"></i>
                        </a>';
                    }
                    else if($imgserts!=''){
                        $imgsert1 = explode(',',$imgserts);
                        if(count($imgsert1) >1)
                            $imgsert2 = $imgsert1[0]."'";
                        else
                            $imgsert2 = $imgsert1[0];
                        $html.='<a href="javascript:void(0)" class="PIXLRIT1" onclick="submitAndShare('.$imgsert2.','.$sname.')" target="_blank">
                        <i class="fa fa-facebook"></i>
                        </a>';
                    }
                    $html.='<a href="https://plus.google.com/share?url="'.$fullURL.'" target="_blank">
                    <i class="fa fa-google-plus"></i>
                    </a>
                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url="'.$fullURL.'" target="_blank">
                    <i class="fa fa-linkedin"></i>
                    </a>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>';

                    if($userId == get_current_user_id() && $type == false){
                        $html.='
                        <a href="" class="editss" data-toggle="modal" data-target="#myModal2"><img src="'.base_url().'assets/images/edit.png" onclick="editPost('.$post->id.')"></a>

                        <a href="" class="editss" data-toggle="modal" data-target="#modalDelete"><i class="fa fa fa-trash-o"></i></a>';
                    }
                    $html.='</div>
                    <p>';
                    $regex = "((https?|ftp)\:\/\/)?";
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";  
                    $regex .= "(\:[0-9]{2,5})?";
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";
                    if(preg_match("/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i", $post->post_content))
                    { 
                        $html.='<a href="'.$post->post_content.'" target="_blank">'.$post->post_content.'</a>'; 
                    }else{
                        $html.=$post->post_content;
                    }
                    $html.='</p></div>';

                    $html.='<div class="commentSection">
                    <div id="all_comments'.$post->id.'">';
                    $oldComments = getComments($post->id);
                    if(!empty($oldComments)){
                        foreach($oldComments as $comment){
                            $html.= '<div class="wa_app_comm">';
                            if(!empty($comment->profile)){
                                $html.='<img src="'.$comment->profile.'">';
                            }else{
                                $html.='<img src="'.DEFAULT_IMAGE.'">';
                            }
                            $html.='<h4>'.$comment->firstname.' '.$comment->lastname.'</h4>';
                            $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                            $text = $comment->comments;
                            if(preg_match($reg_exUrl, $text, $url)) {
                                $comments = preg_replace($reg_exUrl, "<a href='".$url[0]."' target='_blank'>{$url[0]}</a>", $text);
                            } else {
                                $comments = $text;
                            }

                            $html.='<p>'.$comments.'</p>';
                            if(get_current_user_id() == $comment->user_id){
                                $html.='<i class="fa fa fa-trash-o" data-comment_id="'.$comment->id.'" data-toggle="modal" data-target="#modalDeleteComment"></i>';
                            }
                            $html.='</div>';
                        }
                    }
                    $html.='</div>';
                    if(get_current_user_id()){
                        $html.='<form method="post" class="commentForm">
                        <textarea type="text" class="comment form-control" name="comment" placeholder="Enter your comment" data-comment="'.$post->id.'"></textarea>
                        <input type="submit" name="post" value="POST" class="post_comment">
                        </form>';
                    }
                    $html.='</div></div></div>';
                }
            }
            $this->session->set_userdata('posts',$sessionArr);
        }else{
            $html="";
        } 
        echo $html;
    }       

    // public function postByLimit($limit,$last_id,$userId,$type=false){
    //     if($last_id==0){
    //         echo "";
    //         die();
    //     }

    //     $user_data = $this->common_model->getsingle(USERS,array('id'=>$userId));
    //     $random = substr(md5(mt_rand()), 0, 7);
    //     $id = $userId;
    //     if($type){
    //         /*Post of all the members within contact*/
    //         $contactIDs = array();

    //         $info = 'tb_users.id';
    //         $relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
    //         $condition2="(requests.receiver='$userId' OR requests.sender='$userId') AND requests.status=1 AND tb_users.id!='$userId' ";
    //         $companyContacts = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,"");
    //         if(!empty($companyContacts)){
    //             foreach($companyContacts as $id){
    //                 $contactIDs[] = $id['id'];
    //             }
    //         }


    //         $relation="tb_users.id=friends.user_one_id";
    //         $condition="(friends.user_two_id='$userId' OR friends.user_one_id='$userId') AND friends.status=1 AND tb_users.id!='$userId' ";
    //         $friendContacts = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,"");
    //         if(!empty($friendContacts)){
    //             foreach($friendContacts as $id){
    //                 $contactIDs[] = $id['id'];
    //             }
    //         }

    //         if(!empty($contactIDs)){
    //             $contacts = implode(",",$contactIDs);
    //             $condition = ' user_id IN('.$contacts.') and post_status=0 and posts.id<'.$last_id;
    //             $posts_details = $this->common_model->GetJoinRecord(USERS,'id',POSTS,'user_id','tb_users.firstname,tb_users.lastname,tb_users.business_name,tb_users.user_role,tb_users.profile,tb_users.id as user_id1,posts.*',$condition,'','posts.id','DESC','5','0');
    //         }

    //     }else{
    //         $posts_details = $this->common_model->getAllwhere(POSTS,array('user_id'=>$id,'post_status'=>0,'id<'=>$last_id,'repeat_status'=>0), 'id', 'DESC','all','5','0',$group_by='',$and_where = '');
    //     }
    //     $html="";
    //     $sessionArr = $this->session->userdata('posts');
    //     if(!empty($posts_details['result'])){
    //         $md = 0;
    //         foreach($posts_details['result'] as $post){ 
    //             $md=$post->id;
    //             if($type){
    //                 $html.='<div class="user_highlights"><h5>';
    //                 $html.=($post->user_role == 'Performer')?($post->firstname." ".$post->lastname):$post->business_name;
    //                 $html.='</h5>';
    //                 if($post->profile!='assets/images/default_image.jpg'){ 
    //                     $html.='<img src="'.$post->profile.'" alt="Post Image" class="">';
    //                 } 
    //                 else{
    //                     $html.='<img src="'.base_url().$post->profile.'" alt="Post Image" class="">';
    //                 }
    //                 $userRating = userOverallRatings($post->user_id1);
    //                 if(!empty($userRating['starRating'])){
    //                     $html.=preg_replace("/\([^)]+\)/","",$userRating['starRating']);
    //                 }
    //                 $html.='</div>';
    //             }else{
    //                 $this->common_model->updateFields(POSTS,array('repeat_status'=>1),array('id'=>$md));
    //             }
    //             if(!in_array($post->id,$sessionArr)){
    //                 $sessionArr[] = $post->id;
    //                 $postimg="";
    //                 if($post->post_image!=""){
    //                     $imgsert=$post->post_image;
    //                     $postimgarr=explode(',',$imgsert);
    //                     if(count($postimgarr)>1){ 
    //                         $postimg.='<div class="row">';
    //                         foreach($postimgarr as $postim){
    //                             $postimg.='<div class = "col-sm-3 col-md-3 thumb_upx2">
    //                             <div class="fansy-gallry">  
    //                             <a class="thumbnail" data-fancybox="gallery11'.$random.$md.'" href="'.$postim.'">
    //                             <img src="'.$postim.'">
    //                             </a>
    //                             </div>
    //                             </div>';

    //                         }
    //                         $postimg.='
    //                         <div class="col-tz">    
    //                         <div id="myModal00new'.$md.'" class="modal fade" role="dialog">
    //                         <div class="modal-dialog">
    //                         <div class="modal-content">
    //                         <div class="modal-header">
    //                         <button type="button" class="close" data-dismiss="modal">&times;</button>
    //                         </div>
    //                         <div class="modal-body">
    //                         <div class="row">';
    //                         foreach($postimgarr as $postim){
    //                             $postimg.='<div class="col-md-3">
    //                             <div class="fansy-gallry">  
    //                             <a class="fancybox" data-fancybox="gallery11'.$random.$md.'" href="'.$postim.'">
    //                             <img src="'.$postim.'">
    //                             </a>
    //                             </div>
    //                             </div>';
    //                         }  
    //                         $postimg.=' </div>
    //                         </div>
    //                         </div>
    //                         </div>
    //                         </div>
    //                         </div></div>';
    //                     }else{
    //                         if(count($postimgarr) == 1){ 
    //                             $postimg='<div class = "over_viewimg">
    //                             <a class="img-fluid" data-fancybox="gallery11'.$random.$md.'" href="'.$postimgarr[0].'">
    //                             <img src="'.$postimgarr[0].'">
    //                             </a>
    //                             </div>';
    //                         }
    //                         $postimg.='
    //                         <div class="col-tz">    
    //                         <div id="myModal00new'.$md.'" class="modal fade" role="dialog">
    //                         <div class="modal-dialog">
    //                         <div class="modal-content">
    //                         <div class="modal-header">
    //                         <button type="button" class="close" data-dismiss="modal">&times;</button>
    //                         </div>
    //                         <div class="modal-body">
    //                         <div class="row">';
    //                         foreach($postimgarr as $postim){
    //                             $postimg.='<div class="col-md-3">
    //                             <div class="fansy-gallry">  
    //                             <a class="fancybox" data-fancybox="gallery11'.$random.$md.'" href="'.$postim.'">
    //                             <img src="'.$postim.'">
    //                             </a>
    //                             </div>
    //                             </div>';
    //                         }  
    //                         $postimg.=' </div>
    //                         </div>
    //                         </div>
    //                         </div>
    //                         </div>
    //                         </div></div>';
    //                     }
    //                 }
    //                 if($post->post_video!=''){
    //                     $html.='<div class="row">
    //                     <div>
    //                     <video width="320" height="240" controls class="videos">
    //                     <source src="'.base_url().'uploads/videos/'.$post->post_video.'" type="video/mp4">
    //                     <source src="'.base_url().'ploads/videos/'.$post->post_video.'" type="video/webm">
    //                     <source src="'.base_url().'uploads/videos/'.$post->post_video.'" type="video/ogg">
    //                     <source src="'.base_url().'uploads/videos/'.$post->post_video.'" type="video/mts">
    //                     </video>
    //                     </div>
    //                     </div>';
    //                 } 
    //                 if($type){
    //                     $html.='    
    //                     <div class="main_blog post-id1" id="'.$post->id.'" data-uid="'.$userId.'">
    //                     '.$postimg;

    //                 }
    //                 else{
    //                     $html.='    
    //                     <div class="main_blog post-id" id="'.$post->id.'" data-uid="'.$userId.'">
    //                     '.$postimg;
    //                 }


    //                 $html.='<div class="contant_overviw esdu" onclick="setID('.$post->id.');"><h1 class="datess">'. date('d-m-Y H:i A',strtotime($post->post_date)).'</h1>
    //                 <div class="btnns">';
    //                 $classShare = 'sharePostModal';
    //                 if($type){
    //                     $classShare = 'sharePostModal1';
    //                 }
    //                 $html.='
    //                 <div class="form-group">';
    //                 $html.='<a href="#" class="linke" data-toggle="modal" data-target="#'.$classShare.$md.'"><img src="'.base_url().'assets/images/share.png">
    //                 <i class="fa fa-thumbs-up"></i>
    //                 </a>';
    //                 $html.='<div class="modal fade" id="'.$classShare.$md.'">
    //                 <div class="modal-dialog">
    //                 <div class="modal-content">
    //                 <div class="modal-header">
    //                 <h4 class="modal-title">Boost Visibility</h4>
    //                 <button type="button" class="close" data-dismiss="modal">&times;</button>';
    //                 $fullURL = basE_url().'viewdetails/profile/'.encoding($userId);
    //                 if(isset($imgsert))
    //                     $imgserts = "'".$imgsert."'";
    //                 else
    //                     $imgserts = '';

    //                 if($type){
    //                     if($post->user_role == 'Employer'){
    //                         $sname = "'".ucwords($post->business_name). ' status'."'";
    //                     }else{
    //                         $sname = "'".ucwords($post->firstname)." ".ucwords($post->lastname). " status"."'";
    //                     }
    //                 }else{
    //                     if($user_data->user_role == 'Employer'){
    //                         $sname = "'".ucwords($user_data->business_name). ' status'."'";
    //                     }else{
    //                         $sname = "'".ucwords($user_data->firstname)." ".ucwords($user_data->lastname). " status"."'";
    //                     }
    //                 }

    //                 $html.='</div>
    //                 <div class="modal-body">
    //                 <div id="share-buttons" title="Share Profile">
    //                 <a href="https://twitter.com/share?url='.$fullURL.'" target="_blank">
    //                 <i class="fa fa-twitter"></i>
    //                 </a>';
    //                 if($post->post_video!=''){
    //                     $video = "'".base_url()."uploads/videos/".$post->post_video."'";
    //                     $html.='<a href="javascript:void(0)" class="PIXLRIT1" onclick="publish('.$video.','.$sname.');" target="_blank">
    //                     <i class="fa fa-facebook"></i>
    //                     </a>';
    //                 }
    //                 else if($imgserts!=''){
    //                     $imgsert1 = explode(',',$imgserts);
    //                     if(count($imgsert1) >1)
    //                         $imgsert2 = $imgsert1[0]."'";
    //                     else
    //                         $imgsert2 = $imgsert1[0];
    //                     $html.='<a href="javascript:void(0)" class="PIXLRIT1" onclick="submitAndShare('.$imgsert2.','.$sname.')" target="_blank">
    //                     <i class="fa fa-facebook"></i>
    //                     </a>';
    //                 }
    //                 $html.='<a href="https://plus.google.com/share?url="'.$fullURL.'" target="_blank">
    //                 <i class="fa fa-google-plus"></i>
    //                 </a>
    //                 <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url="'.$fullURL.'" target="_blank">
    //                 <i class="fa fa-linkedin"></i>
    //                 </a>
    //                 </div>
    //                 </div>
    //                 </div>
    //                 </div>
    //                 </div>
    //                 </div>';
    //                 if($userId == get_current_user_id() && $type == false){
    //                     $html.='
    //                     <a href="" class="editss" data-toggle="modal" data-target="#myModal2"><img src="'.base_url().'assets/images/edit.png" onclick="editPost('.$post->id.')"></a>

    //                     <a href="" class="editss" data-toggle="modal" data-target="#modalDelete"><i class="fa fa fa-trash-o"></i></a>';
    //                 }
    //                 $html.='</div>
    //                 <p>';
    //                 $regex = "((https?|ftp)\:\/\/)?";
    //                 $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; 
    //                 $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";  
    //                 $regex .= "(\:[0-9]{2,5})?";
    //                 $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
    //                 $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; 
    //                 $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";
    //                 if(preg_match("/^$regex$/i", $post->post_content)) 
    //                 { 
    //                     $urls = '';
    //                     if(strpos($post->post_content, 'http://') !== 0) {
    //                         $urls =  'http://' . $post->post_content;
    //                     } else {
    //                         $urls = $post->post_content;
    //                     }
    //                     $html.='<a href="'.$urls.'" target="_blank">'.$post->post_content.'</a>'; 
    //                 }else{
    //                     $html.=$post->post_content;
    //                 }
    //                 $html.='</p></div></div>';
    //             } 
    //         }
    //         $this->session->set_userdata('posts',$sessionArr);
    //     }else{
    //         $html="";
    //     } 
    //     echo $html;
    // }       
    

//appends all error messages

private function handle_error($err) {

    $this->error .= $err . "rn";

}



//appends all success messages

private function handle_success($succ) {

    $this->success .= $succ . "rn";

}





/****************************************/

public function Update_profileimg1(){

    if(isset($_FILES['profileimg']['name']) && !empty($_FILES['profileimg']['name'])){

        $image = fileUploading('profileimg','users','jpg|gif|png|jpeg|JPG|PNG');

        if(isset($image['error'])){

            $return['status']         =   0; 

            $return['message']        =   strip_tags($image['error']);

            $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Photo Not Uploaded.'.$image['error'].' </div>');

            redirect('profile');

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

        redirect('profile');

    }



}


public function Update_profileimg1111(){
    if(isset($_FILES['profileimg']['name']) && !empty($_FILES['profileimg']['name'])){
        $newImage = '';
        $fileName = basename($_FILES["profileimg"]["name"]);
        $fileTmp = $_FILES["profileimg"]["tmp_name"];
        $fileType = $_FILES["profileimg"]["type"];
        $fileSize = $_FILES["profileimg"]["size"];
        $fileExt = substr($fileName, strrpos($fileName, ".") + 1);
        $largeImageLoc = 'uploads/images/'.$fileName;
        $thumbImageLoc = 'uploads/images/thumb/'.$fileName;

        if(!empty($fileName)){
            if(move_uploaded_file($fileTmp, $largeImageLoc)){
                $Orientation = 0;
                $imgdata=@exif_read_data(FCPATH.$largeImageLoc,"FILE,COMPUTED,ANY_TAG,IFD0,THUMBNAIL,COMMENT,EXIF,Orientation", true);
                if(isset($imgdata['IFD0']['Orientation'])){
                    $Orientation = $imgdata['IFD0']['Orientation'];
                }

                chmod ($largeImageLoc, 0777);
                list($width_org, $height_org) = getimagesize($largeImageLoc);
                $x = (int) $_POST['x'];
                $y = (int) $_POST['y'];
                $width = (int) $_POST['w'];
                $height = (int) $_POST['h'];
                $width_new = $width;
                $height_new = $height;
                if($width_new!='' && $height_new!=''){
                    $newImage = imagecreatetruecolor($width_new,$height_new);
                }
                switch($fileType) {
                    case "image/gif":
                    $source = imagecreatefromgif($largeImageLoc); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    $source = imagecreatefromjpeg($largeImageLoc); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    $source = imagecreatefrompng($largeImageLoc); 
                    break;
                }

                if($x!='' && $y!=''){
                    imagecopyresampled($newImage,$source,0,0,$x,$y,$width_new,$height_new,$width,$height);
                }

                switch($fileType) {
                    case "image/gif":
                    imagegif($newImage,$thumbImageLoc); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    imagejpeg($newImage,$thumbImageLoc,90); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    imagepng($newImage,$thumbImageLoc);  
                    break;
                }
                imagedestroy($newImage);
                $config['image_library'] = 'gd2';
                $config['master_dim'] = 'auto';
                $config['maintain_ratio'] = FALSE;
                $this->load->library('image_lib',$config); 
                if (!$this->image_lib->resize()){  
                    echo "error";
                }else{
                    $this->image_lib->clear();
                    $config=array();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = FCPATH.$thumbImageLoc;
                    if($Orientation!=0){
                        switch($Orientation) {
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
                $dataArr['profile']    =  base_url().$thumbImageLoc;
                $user_id = get_current_user_id();
                $condition=array('id'=>$user_id);   
                $update = $this->common_model->updateFields(USERS,$dataArr,array('id'=>$user_id));
                if($update)
                {                   
                    redirect('profile');
                }
            }else{
                $error = "Sorry, there was an error uploading your file.";
            }
        }else{
            echo $error;
        }
    }
}

public function Update_profileimg(){
    if(isset($_FILES['profileimg']['name']) && !empty($_FILES['profileimg']['name'])){
        $newImage = '';
        $fileName = basename($_FILES["profileimg"]["name"]);
        $fileTmp = $_FILES["profileimg"]["tmp_name"];
        $fileType = $_FILES["profileimg"]["type"];
        $fileSize = $_FILES["profileimg"]["size"];
        $fileExt = substr($fileName, strrpos($fileName, ".") + 1);
        $largeImageLoc = 'uploads/images/'.time().".".$fileExt;
        $thumbImageLoc = 'uploads/images/thumb/'.time().".".$fileExt;

        if(!empty($fileName)){
            if(move_uploaded_file($fileTmp, $largeImageLoc)){
                $Orientation = 0;
                $imgdata=@exif_read_data(FCPATH.$largeImageLoc,"FILE,COMPUTED,ANY_TAG,IFD0,THUMBNAIL,COMMENT,EXIF,Orientation", true);
                if(isset($imgdata['IFD0']['Orientation'])){
                    $Orientation = $imgdata['IFD0']['Orientation'];
                }

                chmod ($largeImageLoc, 0777);
                list($width_org, $height_org) = getimagesize($largeImageLoc);
                $x = (int) $_POST['x'];
                $x=$x+1;
                $y = (int) $_POST['y'];
                $y=$y+1;
                $width = (int) $_POST['w'];
                $height = (int) $_POST['h'];
                $width_new = $width;
                $height_new = $height;
                if($width_new!='' && $height_new!=''){
                    $newImage = imagecreatetruecolor($width_new,$height_new);
                }
                $source = '';
                switch($fileType) {
                    case "image/gif":
                    $source = imagecreatefromgif($largeImageLoc); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    $source = imagecreatefromjpeg($largeImageLoc); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    $source = imagecreatefrompng($largeImageLoc); 
                    break;
                }

                if($x!='' && $y!=''){
                    imagecopyresampled($newImage,$source,0,0,$x,$y,$width_new,$height_new,$width,$height);
                }

                switch($fileType) {
                    case "image/gif":
                    imagegif($newImage,$thumbImageLoc); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    imagejpeg($newImage,$thumbImageLoc,90); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    imagepng($newImage,$thumbImageLoc);  
                    break;
                }
                imagedestroy($newImage);
                $config['image_library'] = 'gd2';
                $config['master_dim'] = 'auto';
                $config['maintain_ratio'] = FALSE;
                $this->load->library('image_lib',$config); 
                if (!$this->image_lib->resize()){  
                    echo "error";
                }else{
                    $this->image_lib->clear();
                    $config=array();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = FCPATH.$thumbImageLoc;
                    if($Orientation!=0){
                        switch($Orientation) {
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
                $dataArr['profile']    =  base_url().$thumbImageLoc;
                $user_id = get_current_user_id();
                $condition=array('id'=>$user_id);   
                $update = $this->common_model->updateFields(USERS,$dataArr,array('id'=>$user_id));
                if($update)
                {                   
                    redirect('profile');
                }
            }else{
                $error = "Sorry, there was an error uploading your file.";
            }
        }else{
            echo $error;
        }
    }
}

public function Update_profileimg222(){
    if(isset($_FILES['profileimg']['name']) && !empty($_FILES['profileimg']['name'])){

        $config['upload_path'] = 'uploads/users/';

        $config['allowed_types'] = 'jpg|jpeg|gif|png';

        $config['max_size'] = '6048';

        $this->load->library('upload', $config);

//check if a file is being uploaded

        if(strlen($_FILES["profileimg"]["name"])>0){

            if ( !$this->upload->do_upload("profileimg"))

            {

                $error = array('error' => $this->upload->display_errors());

                print_r($error);

            }

            else

            {

                $config['image_library'] = 'gd2';

                $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;

                $filename = $_FILES['profileimg']['tmp_name'];





                $imgdata=@exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');





                list($width, $height) = getimagesize($filename);

                if ($width >= $height){

                    $config['width'] = 800;

                }

                else{

                    $config['height'] = 800;

                }

                $config['master_dim'] = 'auto';

// $config['maintain_ratio'] = TRUE;

                $config['maintain_ratio'] = FALSE;



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

        }  

    }

    $dataArr['profile']    =  base_url().'uploads/users/'.$this->upload->file_name;



    $user_id = get_current_user_id();



    $condition=array('id'=>$user_id);   



    $update = $this->common_model->updateFields(USERS,$dataArr,array('id'=>$user_id));

    if($update)

    {                   

        redirect('profile');

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

        if($this->input->post('noti_msg')){

            $userdata['message_notification'] = 1;

        }else{

            $userdata['message_notification'] = 0;

        }

        if($this->input->post('noti_fr_req')){

            $userdata['friend_request_received_notification'] = 1;

        }else{

            $userdata['friend_request_received_notification'] = 0;

        }

        if($this->input->post('noti_fr_ac')){

            $userdata['friend_request_acceptance_notification'] = 1;

        }else{

            $userdata['friend_request_acceptance_notification'] = 0;

        }

        if($this->input->post('noti_job_ac')){

            $userdata['job_request_acceptance_notification'] = 1;

        }else{

            $userdata['job_request_acceptance_notification'] = 0;

        }

        if($this->input->post('review_notification')){

            $userdata['review_notification'] = 1;

        }else{

            $userdata['review_notification'] = 0;

        }

        if($this->input->post('new_task_notification')){
            $userdata['new_task_notification'] = 1;
        }else{
            $userdata['new_task_notification'] = 0;
        }

        if($this->input->post('display_phone')){

            $userdata['display_phone'] = 1;

        }else{

            $userdata['display_phone'] = 0;

        }

        if($this->input->post('display_website')){

            $userdata['display_website'] = 1;

        }else{

            $userdata['display_website'] = 0;

        }

        if(!empty($this->input->post('oldpassword'))){



            if($checkoldpassword=='verified'){



                if($newpass == $cnewpass){                                                 



                    $user_id = get_current_user_id();



                    $condition=array('id'=>$user_id);  

                    $this->session->set_userdata('user_login_type','');

                    $update = update_data('tb_users',$userdata,$condition);



                    if($update){ 

                        $this->session->unset_userdata('id');

                        $this->session->sess_destroy();             

                        redirect('login');

                    }

                }else{

                    $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Password does not match please try again!!!</div>');

                    redirect('profile'); 

                }



            }else{

                $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Your current password is wrong please enter correct password!!!</div>');

                redirect('profile'); 

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

                $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Password does not match please try again!!!</div>');

                redirect('profile'); 

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

        if($this->input->post('noti_msg')){

            $userdata['message_notification'] = 1;

        }else{

            $userdata['message_notification'] = 0;

        }

        if($this->input->post('noti_fr_req')){

            $userdata['friend_request_received_notification'] = 1;

        }else{

            $userdata['friend_request_received_notification'] = 0;

        }

        if($this->input->post('noti_fr_ac')){

            $userdata['friend_request_acceptance_notification'] = 1;

        }else{

            $userdata['friend_request_acceptance_notification'] = 0;

        }

        if($this->input->post('noti_job_ac')){

            $userdata['job_request_acceptance_notification'] = 1;

        }else{

            $userdata['job_request_acceptance_notification'] = 0;

        }

        if($this->input->post('review_notification')){

            $userdata['review_notification'] = 1;

        }else{

            $userdata['review_notification'] = 0;

        }

        if($this->input->post('new_task_notification')){
            $userdata['new_task_notification'] = 1;
        }else{
            $userdata['new_task_notification'] = 0;
        }

        if($this->input->post('display_phone')){

            $userdata['display_phone'] = 1;

        }else{

            $userdata['display_phone'] = 0;

        }

        if($this->input->post('display_website')){

            $userdata['display_website'] = 1;

        }else{

            $userdata['display_website'] = 0;

        }

        $user_id = get_current_user_id();



        $condition=array('id'=>$user_id);   



        $update = update_data('tb_users',$userdata,$condition);



        if($update)

        { 

            $this->session->set_flashdata('updatemsg','<div class="alert alert-success text-center">You have successfully updated your profile!</div>');                 

            redirect('profile');

        }

        else

        {

            $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Error in updating your profile</div>');

            redirect('profile');    

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



// if($this->form_validation->run() == FALSE) 

// { 

//     $ret=array('status'=>'Failed_ans','msg'=>'All answers are required.','rated_to'=>$this->input->post('rated_to'));

//}else{       



        if($this->input->post()){

            $dataInsert['rated_by_user'] = get_current_user_id();

            $sender = $this->common_model->getsingle(USERS,array('id'=>get_current_user_id()));

            if(!empty($sender) && $sender->business_name!=''){

                $senderName = $sender->business_name;

            }else{

                $senderName = $sender->firstname." ".$sender->lastname;

            }

//$receiver = $this->common_model->getsingle(USERS,array('id'=>$this->session->userdata('rated_to_')));
            $receiver = $this->common_model->getsingle(USERS,array('id'=>$this->input->post('rated_to')));

            $receiverReviewNotification = 0;

            if(!empty($receiver)){

                $receiverName = $receiver->firstname;

                $receiverReviewNotification = $receiver->review_notification;

                $receiverEmail = $receiver->email;

            }

//$dataInsert['rated_to_user'] = $this->session->userdata('rated_to_');
            $dataInsert['rated_to_user'] = $this->input->post('rated_to');

            //$userComapny = $this->common_model->getsingle(REQUESTS,array('sender'=>$dataInsert['rated_to_user']),'','id','DESC');
            $userComapny = $this->common_model->getsingle(REQUESTS,array('sender'=>$dataInsert['rated_by_user']),'','id','DESC');

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

            $dataInsert['avg_rating'] = ($this->input->post('ques1')+$this->input->post('ques2')+$this->input->post('ques3')+$this->input->post('ques4')+$this->input->post('ques5'))/5.0; 

            $dataInsert['message'] = $this->input->post('message');

            $dataInsert['rate_date'] = date('Y-m-d H:i:s');

            if($this->input->post('anonymous')){
                $dataInsert['anonymous'] = 1;
            }else{
                $dataInsert['anonymous'] = 0;
            }

            if(empty($ratingsData)){

                $this->form_validation->set_rules('ques1','Question 1','trim|required');

                $this->form_validation->set_rules('ques2','Question 2','trim|required');

                $this->form_validation->set_rules('ques3','Question 3','trim|required');

                $this->form_validation->set_rules('ques4','Question 4','trim|required');

                $this->form_validation->set_rules('ques5','Question 5','trim|required');

                if($this->form_validation->run() == FALSE) 

                { 

                    $ret=array('status'=>'Failed_ans','msg'=>'All answers are required.','rated_to'=>$this->input->post('rated_to'));

                }else{

                    $ins = $this->common_model->insertData(RATINGS, $dataInsert);

                    if($ins){

                        $ret=array('status'=>'success');



                    }

                }

            }else{

                $this->common_model->updateFields(RATINGS,$dataInsert,array('id'=>$ratingsData->id));

                $ret=array('status'=>'success');

            }

            if($receiverReviewNotification == 1){

                $from = "noreply@workadvisor.co";

                $config['protocol'] = 'ssmtp';

                $config['smtp_host'] = 'ssl://ssmtp.gmail.com';

                $config['mailtype'] = 'html';

                $config['newline'] = '\r\n';

                $config['charset'] = 'utf-8';

                $this->load->library('email', $config);

                $this->email->initialize($config);

                $subject = 'New Review';

                $message = '';

               // $message .= '<a href="'.base_url().'viewdetails/profile/'.encoding($sender->id).'">'.ucfirst($senderName)."</a> wrote you a review.";
                //$message .= '<a href="'.base_url().'viewdetails/profile/'.encoding($sender->id).'">'.ucfirst($receiverName).' great job! You got reviewed on WorkAdvisor.co. Check it out!</a>';
                //$message .= '<a href="'.base_url().'user/history" style="color:black;">'.ucfirst($receiverName).' great job! You got reviewed on WorkAdvisor.co. Check it out!</a>';
                $message .= ucfirst($receiverName).' great job! You got reviewed on WorkAdvisor.co. Check it out!<p><a href="'.base_url().'user/history" type="button" style="background: #008000;display: inline-block;color: #fff;text-decoration: none;padding: 5px 10px;margin-top: 10px;border-radius: 2px;font-size: 15px;">Review</a></p>';


                $mailData = array();

                $mailData['message'] = $message;

                $mailData['username'] = ucfirst($receiverName);

                $message = $this->load->view('frontend/mail_temp',$mailData,true);

                $this->email->set_header('From', $from);

                $this->email->from($from);

                $this->email->to($receiverEmail);

                $this->email->subject($subject);

                $this->email->message($message);

                if($this->email->send()){

                } 

            }

        }

// }

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





/*To leave job*/

public function leaveJob(){

    if($_POST){

        $record = $this->input->post('record');

        if($this->common_model->deleteData(REQUESTS,array('receiver'=>$record,'sender'=>get_current_user_id()))){

            echo json_encode(array('status'=>1));

        }

    }

}
/*For uploading document files*/
public function uploadDocFiles(){
    $dataInsert = array();
    $directoryID = !empty($_POST['directoryid'])?$_POST['directoryid']:'';
    $filesCount = !empty($_FILES['files']['name'])?count($_FILES['files']['name']):'';
    $userData = $this->common_model->getsingle(USERS,array('id'=>get_current_user_id()));
    $dataInsert['user_id'] = get_current_user_id();
    if($filesCount>0){
        /* if file is uploading outside the directory */
        for($i = 0; $i < $filesCount; $i++){
            $_FILES['docfile']['name'] = $_FILES['files']['name'][$i];
            $_FILES['docfile']['type'] = $_FILES['files']['type'][$i];
            $_FILES['docfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
            $_FILES['docfile']['error'] = $_FILES['files']['error'][$i];
            $_FILES['docfile']['size'] = $_FILES['files']['size'][$i];
            $config['upload_path'] = FCPATH.'uploads/docs/';
            $path=$config['upload_path'];
            $config['allowed_types'] = 'csv|xls|txt|pdf|doc|docx|xlsx';
            $config['overwrite'] = '1';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('docfile')){
                $fileData = $this->upload->data();
                $fileName = $fileData['file_name'];
                $dataInsert['albums']  = 'uploads/docs/'.$fileName;
                if($directoryID != '') {
                    $dataInsert['folder_id'] = $directoryID;
                }
                $dataInsert['name']  = $fileName;
                $dataInsert['created_date'] = date('Y-m-d H:i:s');
                $albumData = $this->common_model->getsingle(ALBUMS,array('user_id'=>$dataInsert['user_id'],'albums'=>$dataInsert['albums']));
                if(empty($albumData))
                    $ins = $this->common_model->insertData(ALBUMS, $dataInsert);
            }else{
                print_r($this->upload->display_errors());
            }
        }
        $html='';
        if($directoryID != '') {
            $albumData=$this->common_model->getAllwhere(ALBUMS,array('user_id'=>$dataInsert['user_id'], 'folder_id' => $directoryID));
            $adddingType = 'inDir';
            $html = "<a id='directoryBack' href='javascript:void(0)' onclick='directoryBack()'>Back</a>";
        } else {
            $albumData=$this->common_model->getAllwhere(ALBUMS,array('user_id'=>$dataInsert['user_id'],'folder_id' => 0));
            $adddingType = 'Direct';
            /* html of directory */
            $albumFolderData = $this->common_model->getAllwhere(ALBUM_DIR,array('user_id'=>get_current_user_id(),'dir_parent' => 0));
            if(!empty($albumFolderData)) {
                foreach($albumFolderData['result'] as $folderDatas) {
                    $checked11 = '';
                    $checked22 = '';
                    $checked33  ='';
                    if($folderDatas->dir_view_type == 3){
                        $checked33 = 'checked=checked';
                    } else if($folderDatas->dir_view_type == 2){
                        $checked22 = 'checked=checked';
                    } else{
                        $checked11 = 'checked=checked';
                    } 
                    $html.='
                    <div class="col-md-3 col-12 documents_drag folders  '.$folderDatas->id.'" data-doc_type="folder" onclick="setIdDir('.$folderDatas->id.')" id="'.$folderDatas->id.'">
                    <div class="album_icon">
                    <a href="javascipt:void(0)"  onclick="enterInFolder('.$folderDatas->id.','.get_current_user_id().')"">
                    <div class="jerry documents_drag_folder" data-fid="'.$folderDatas->id.'" data-doc_type="folder">
                    <div class="cat_img but_imgsize">
                    <img src="'.base_url().'/assets/images/folder_image.png">
                    </div><span class="Zdoc_content">'.$folderDatas->dir_name.'</span></div>
                    </a>

                    <p><input class="view_type" type="radio" value="1" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'"  data-vid="'.$folderDatas->id.'" '.$checked11.'>Public</p>
                    <p><input class="view_type" type="radio" value="2" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked22.' data-vid="'.$folderDatas->id.'">Private</p>';
                    if(!empty($userData) && $userData->user_role == 'Employer'){
                        $html.='<p><input class="view_type_folder" type="radio" value="3" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked33.' data-vid="'.$folderDatas->id.'">Employee</p>';
                    }
                    $html .=  '</div>
                    </div>';;
                }
            }
            /* html of directory end */
        }           
        if(!empty($albumData['result'])){
            foreach($albumData['result'] as $row){
                $checked1 = '';
                $checked2 = '';
                $checked3 = '';
                if($row->view_type == 3){
                    $checked3 = 'checked=checked';
                }
                else if($row->view_type == 2){
                    $checked2 = 'checked=checked';
                }else{
                    $checked1 = 'checked=checked';
                }
                $file_ext = pathinfo($row->name,PATHINFO_EXTENSION);
                if($file_ext == 'doc' || $file_ext == 'docs' || $file_ext == 'docx'){
                    $image = base_url().'assets/images/doc.png';
                }
                else if($file_ext == 'xlsx'){
                    $image = base_url().'assets/images/xlsx.png';
                }else if($file_ext == 'pdf'){
                    $image = base_url().'assets/images/pdf.png';
                }
                $html.='
                <div class="col-md-3 col-12 documents_drag file_'.$row->id.'" data-doc_type="file" id="'.$row->id.'" onclick="setID('.$row->id.');">
                <div class="album_icon">
                <a href="'.base_url().$row->albums.'" >
                <div class="jerry documents_drag_file" data-fid="'.$row->id.'" data-doc_type="file">
                <div class="cat_img but_imgsize">
                <img src="'.$image.'">
                </div><span class="Zdoc_content">'.$row->name.'</span></div>
                </a>
                ';
                if($directoryID!=''){
                }
                else{
                    $html.='<p><input class="view_type" type="radio" value="1" name="view_'.$row->id.'" id="view_'.$row->id.'"  data-vid="'.$row->id.'" '.$checked1.'>Public</p>
                    <p><input class="view_type" type="radio" value="2" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked2.' data-vid="'.$row->id.'">Private</p>';
                    if(!empty($userData) && $userData->user_role == 'Employer'){
                        $html.='<p><input class="view_type" type="radio" value="3" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked3.' data-vid="'.$row->id.'">Employee</p>';
                    }
                }
                $html.= '</div>
                </div>
                ';
            }
        }
        /* if file is uploading inside the directory */
        echo json_encode(array('status'=>1,'html'=>$html,'adddingType' => $adddingType));
    }else{
        echo json_encode(array('status'=>0));
    }
}


public function dragDocument(){
    if($this->input->post()){
        $source = $this->input->post('source');
        $destination = $this->input->post('destination');
        $file_folder = $this->input->post('file_folder');
        if($file_folder == 'file'){
            $this->common_model->updateFields(ALBUMS,array('folder_id'=>$destination),array('id'=>$source));
        }else if($file_folder == 'folder'){
            $this->common_model->updateFields(ALBUM_DIR,array('dir_parent'=>$destination),array('id'=>$source));
        }
        echo json_encode(array('status'=>1));
    }
}

public function deleteAlbumData(){

    $inverted = "&#39;";

    $record = $this->input->post('record');
    $userData = $this->common_model->getsingle(USERS,array('id'=>get_current_user_id()));

    $dlt = $this->common_model->deleteData(ALBUMS,array('id'=>$record));

    if($dlt){

// echo json_encode(array('status'=>1));

        $html='';

        $html .= '<div id="fileSuccessmain">';

        /* html of directory */

        $albumFolderData = $this->common_model->getAllwhere(ALBUM_DIR,array('user_id'=>get_current_user_id()));

        if(!empty($albumFolderData)) {

            foreach($albumFolderData['result'] as $folderDatas) {

                $checked11 = '';

                $checked22 = '';

                $checked33  ='';

                if($folderDatas->dir_view_type == 3){

                    $checked33 = 'checked=checked';

                } else if($folderDatas->dir_view_type == 2){

                    $checked22 = 'checked=checked';

                } else{

                    $checked11 = 'checked=checked';

                } 

                $html.='

                <div class="col-md-3 col-12 documents_drag folders  '.$folderDatas->id.'" onclick="setIdDir('.$folderDatas->id.')" data-doc_type="folder" id="'.$folderDatas->id.'">

                <div class="album_icon">

                <a href="javascipt:void(0)"  onclick="enterInFolder('.$folderDatas->id.','.get_current_user_id().',&#39;&#39;,'.$inverted.$folderDatas->dir_name.$inverted.')"">

                <div class="jerry documents_drag_folder" data-fid="'.$folderDatas->id.'" data-doc_type="folder">

                <div class="cat_img but_imgsize">

                <img src="'.base_url().'/assets/images/folder_image.png">

                </div><span class="Zdoc_content">'.$folderDatas->dir_name.'</span></div>

                </a>


                <p><input class="view_type_folder" type="radio" value="1" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'"  data-vid="'.$folderDatas->id.'" '.$checked11.'>Public</p>

                <p><input class="view_type_folder" type="radio" value="2" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked22.' data-vid="'.$folderDatas->id.'">Private</p>';

                if(!empty($userData) && $userData->user_role == 'Employer'){

                    $html.='<p><input class="view_type_folder" type="radio" value="3" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked33.' data-vid="'.$folderDatas->id.'">Employee</p>';

                }

                $html .= '</div></div>';

            }

        }

//$albumFolderData['result'];

        /* html of directory end */

        $albumData=$this->common_model->getAllwhere(ALBUMS,array('user_id'=>get_current_user_id(),'folder_id' => 0));

        if(!empty($albumData['result'])){
            $image= '';
            foreach($albumData['result'] as $row){

                $checked1 = '';

                $checked2 = '';

                $checked3 = '';

                if($row->view_type == 3){

                    $checked3 = 'checked=checked';

                }

                else if($row->view_type == 2){

                    $checked2 = 'checked=checked';

                }else{

                    $checked1 = 'checked=checked';

                }

                $file_ext = pathinfo($row->name,PATHINFO_EXTENSION);

                if($file_ext == 'doc' || $file_ext == 'docs' || $file_ext == 'docx'){

                    $image = base_url().'assets/images/doc.png';

                }

                else if($file_ext == 'xlsx'){

                    $image = base_url().'assets/images/xlsx.png';

                }else if($file_ext == 'pdf'){

                    $image = base_url().'assets/images/pdf.png';

                }

                $html.='

                <div class="col-md-3 col-12 documents_drag file_'.$row->id.'" data-doc_type="file" id="'.$row->id.'" onclick="setID('.$row->id.');">

                <div class="album_icon">

                <a href="'.base_url().$row->albums.'" >

                <div class="jerry documents_drag_file" data-fid="'.$row->id.'" data-doc_type="file">

                <div class="cat_img but_imgsize">

                <img src="'.$image.'">

                </div><span class="Zdoc_content">'.$row->name.'</span></div>

                </a>



                <p><input class="view_type" type="radio" value="1" name="view_'.$row->id.'" id="view_'.$row->id.'"  data-vid="'.$row->id.'" '.$checked1.'>Public</p>

                <p><input class="view_type" type="radio" value="2" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked2.' data-vid="'.$row->id.'">Private</p>';

                if(!empty($userData) && $userData->user_role == 'Employer'){

                    $html.='<p><input class="view_type" type="radio" value="3" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked3.' data-vid="'.$row->id.'">Employee</p>';

                }

                $html.= '</div>

                </div>

                ';

            }



        }

        $html .= '</div>            

        <div id="fileSuccessDir">

        </div>';

        echo json_encode(array('status'=>1,'html'=>$html));

    }

}

/* folder delete */



public function deleteAlbumfolderData(){
    $record = $this->input->post('record');
    $userData = $this->common_model->getsingle(USERS,array('id'=>get_current_user_id()));
    if($_POST['folderrecord_id'] == '') {

        $dlt = $this->common_model->deleteData(ALBUMS,array('id'=>$record));

    } else {

        $dlt = $this->common_model->deleteData(ALBUM_DIR,array('id'=>$_POST['folderrecord_id']));

        $this->common_model->deleteData(ALBUMS,array('folder_id'=>$_POST['folderrecord_id']));

    }

    if($dlt){

// echo json_encode(array('status'=>1));

        $html='';

        $html .= '<div id="fileSuccessmain">';

        /* html of directory */



        $albumFolderData = $this->common_model->getAllwhere(ALBUM_DIR,array('user_id'=>get_current_user_id()));

        if(!empty($albumFolderData)) {

            foreach($albumFolderData['result'] as $folderDatas) {

                $checked11 = '';

                $checked22 = '';

                $checked33  ='';

                if($folderDatas->dir_view_type == 3){

                    $checked33 = 'checked=checked';

                } else if($folderDatas->dir_view_type == 2){

                    $checked22 = 'checked=checked';

                } else{

                    $checked11 = 'checked=checked';

                } 

                $inverted = "&#39;";

                $html.='

                <div class="col-md-3 col-12 documents_drag folders  '.$folderDatas->id.'" onclick="setIdDir('.$folderDatas->id.')" data-doc_type="folder" id="'.$folderDatas->id.'">

                <div class="album_icon">

                <a href="javascipt:void(0)" onclick="enterInFolder('.$folderDatas->id.','.get_current_user_id().',&#39;&#39;,'.$inverted.$folderDatas->dir_name.$inverted.')""> 

                <div class="jerry documents_drag_folder" data-fid="'.$folderDatas->id.'" data-doc_type="folder">

                <div class="cat_img but_imgsize">

                <img src="'.base_url().'/assets/images/folder_image.png">

                </div><span class="Zdoc_content">'.$folderDatas->dir_name.'</span></div>

                </a>



                <p><input class="view_type_folder" type="radio" value="1" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'"  data-vid="'.$folderDatas->id.'" '.$checked11.'>Public</p>

                <p><input class="view_type_folder" type="radio" value="2" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked22.' data-vid="'.$folderDatas->id.'">Private</p>';



                if(!empty($userData) && $userData->user_role == 'Employer'){

                    $html.='<p><input class="view_type_folder" type="radio" value="3" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked33.' data-vid="'.$folderDatas->id.'">Employee</p>';

                }



                $html .=  '</div>

                </div>';

            }

        }

//$albumFolderData['result'];

        /* html of directory end */

        $albumData=$this->common_model->getAllwhere(ALBUMS,array('user_id'=>get_current_user_id(),'folder_id' => 0));



        if(!empty($albumData['result'])){

            foreach($albumData['result'] as $row){

                $checked1 = '';

                $checked2 = '';

                $checked3 = '';

                if($row->view_type == 3){

                    $checked3 = 'checked=checked';

                }

                else if($row->view_type == 2){

                    $checked2 = 'checked=checked';

                }else{

                    $checked1 = 'checked=checked';

                }

                $file_ext = pathinfo($row->name,PATHINFO_EXTENSION);

                if($file_ext == 'doc' || $file_ext == 'docs' || $file_ext == 'docx'){

                    $image = base_url().'assets/images/doc.png';

                }

                else if($file_ext == 'xlsx'){

                    $image = base_url().'assets/images/xlsx.png';

                }else if($file_ext == 'pdf'){

                    $image = base_url().'assets/images/pdf.png';

                }

                $html.='

                <div class="col-md-3 col-12 documents_drag file_'.$row->id.'" data-doc_type="file" id="'.$row->id.'" onclick="setID('.$row->id.');">

                <div class="album_icon">

                <a href="'.base_url().$row->albums.'" >

                <div class="jerry documents_drag_file" data-fid="'.$row->id.'" data-doc_type="file">

                <div class="cat_img but_imgsize">

                <img src="'.$image.'">

                </div><span class="Zdoc_content">'.$row->name.'</span></div>

                </a>



                <p><input class="view_type" type="radio" value="1" name="view_'.$row->id.'" id="view_'.$row->id.'"  data-vid="'.$row->id.'" '.$checked1.'>Public</p>

                <p><input class="view_type" type="radio" value="2" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked2.' data-vid="'.$row->id.'">Private</p>';

                if(!empty($userData) && $userData->user_role == 'Employer'){

                    $html.='<p><input class="view_type" type="radio" value="3" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked3.' data-vid="'.$row->id.'">Employee</p>';

                }

                $html.= '</div>

                </div>

                ';

            }



        }

        $html .= '</div>            

        <div id="fileSuccessDir">

        </div>';

        echo json_encode(array('status'=>1,'html'=>$html));

    }

}

public function changeViewAccess(){
    $id = $this->input->post('id');
    $dataUpdate= array();
    if($this->input->post('file_folder') == 'files') {
        $dataUpdate['view_type'] = $this->input->post('view_type');
        $this->common_model->updateFields(ALBUMS,$dataUpdate,array('id'=>$id));
    } else {
        $dataUpdate['dir_view_type'] = $this->input->post('view_type');
        $this->common_model->updateFields(ALBUM_DIR,$dataUpdate,array('id'=>$id));
    }
}

function getDocuments(){
    $image = '';
    $inverted = "&#39;";
    $userData = $this->common_model->getsingle(USERS,array('id'=>get_current_user_id()));
    $user_id = $this->input->post('user_id');
    $search_doc = $this->input->post('search_doc');
    if($search_doc!=''){
        $where1 = "user_id=$user_id and name like '%".$search_doc."%'";
        $where2 = "user_id=$user_id and dir_name like '%".$search_doc."%'";
    }
    else{
        $where1 = "user_id=$user_id and folder_id=0";
        $where2 = "user_id=$user_id and dir_parent=0";
    } 

    if($this->input->post('other') == 'other'){

        $albumDatas = $this->common_model->getAllwhere(ALBUMS,$where1);

        $albumFolderDatas = $this->common_model->getAllwhere(ALBUM_DIR,$where2);

        $employees = $this->common_model->getAllwhere(REQUESTS,array('receiver'=>$user_id));

        $companyEmployees = array();



        if(!empty($employees['result'])){

            foreach($employees['result'] as $row){

                $companyEmployees[] = $row->sender;

            }

        }

        if(!empty($albumDatas['result'])){

            $count = 0;

            foreach($albumDatas['result'] as $row){

                if($row->view_type == 1 || ($row->view_type == 3 && in_array(get_current_user_id(),$companyEmployees))){

                    $albumData['result'][$count] = new stdClass();

                    $albumData['result'][$count]->id = $row->id;

                    $albumData['result'][$count]->name = $row->name;

                    $albumData['result'][$count]->albums = $row->albums;

                    $albumData['result'][$count]->view_type = $row->view_type;

                    $count++;

                }

            }

        }



        if(!empty($albumFolderDatas['result'])){

            $count = 0;

            foreach($albumFolderDatas['result'] as $row){

                if($row->dir_view_type == 1 || ($row->dir_view_type == 3 && in_array(get_current_user_id(),$companyEmployees))){

                    $albumFolderData['result'][$count] = new stdClass();

                    $albumFolderData['result'][$count]->id = $row->id;

                    $albumFolderData['result'][$count]->dir_name = $row->dir_name;

                    $albumFolderData['result'][$count]->dir_view_type = $row->dir_view_type;

                    $count++;

                }

            }

        }

    }

    else{

        $albumData=$this->common_model->getAllwhere(ALBUMS,$where1);

        $albumFolderData=$this->common_model->getAllwhere(ALBUM_DIR,$where2);

    }

    $html='<div id="fileSuccessmain">';

    if(!empty($albumData['result']) || !empty($albumFolderData['result'])){

        if(!empty($albumFolderData['result'])) {

//pr($albumFolderData['result']);

            foreach($albumFolderData['result'] as $folderDatas) {

                $checked11 = '';

                $checked22 = '';

                $checked33 = '';

                if($folderDatas->dir_view_type == 3){

                    $checked33 = 'checked=checked';

                } else if($folderDatas->dir_view_type == 2){

                    $checked22 = 'checked=checked';

                } else{

                    $checked11 = 'checked=checked';

                } 

                $html.='

                <div class="col-md-3 col-12 folders documents_drag '.$folderDatas->id.'" onclick="setIdDir('.$folderDatas->id.')" data-doc_type="folder" id="'.$folderDatas->id.'">

                <div class="album_icon">';

                if($this->input->post('other') == 'other'){

                    $html.='<a href="javascipt:void(0)"  onclick="enterInFolder('.$folderDatas->id.','.$user_id.',1,'.$inverted.$folderDatas->dir_name.$inverted.')">';

                }else{

                    $html.='<a href="javascipt:void(0)"  onclick="enterInFolder('.$folderDatas->id.','.get_current_user_id().',&#39;&#39;,'.$inverted.$folderDatas->dir_name.$inverted.')"">';

                }

                $html.='<div class="jerry documents_drag_folder" data-fid="'.$folderDatas->id.'" data-doc_type="folder">

                <div class="cat_img but_imgsize">

                <img src="'.base_url().'/assets/images/folder_image.png">

                </div><span class="Zdoc_content">'.$folderDatas->dir_name.'</span></div>

                </a>';

                if($this->input->post('other') != 'other'){

                    $html.='
                    <input class="view_type" type="radio" value="1" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'"  data-vid="'.$folderDatas->id.'" '.$checked11.' data-views="folders">Public

                    <p><input class="view_type" type="radio" value="2" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked22.' data-vid="'.$folderDatas->id.'" data-views="folders">Private</p>';

                    if(!empty($userData) && $userData->user_role == 'Employer'){

                        $html.='<p><input class="view_type" type="radio" value="3" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked33.' data-vid="'.$folderDatas->id.'" data-views="folders" data-views="folders">Employee</p>



                        '; 

                    }

                }

                $html.=' </div>

                </div>';

            }

        }

        if(!empty($albumData['result'])){

            foreach($albumData['result'] as $row){

                $checked1 = '';

                $checked2 = '';

                $checked3 = '';

                if($row->view_type == 3){

                    $checked3 = 'checked=checked';

                }

                else if($row->view_type == 2){

                    $checked2 = 'checked=checked';

                }else{

                    $checked1 = 'checked=checked';

                }

                $file_ext = pathinfo($row->name,PATHINFO_EXTENSION);

                if($file_ext == 'doc' || $file_ext == 'docs' || $file_ext == 'docx'){

                    $image = base_url().'assets/images/doc.png';

                }

                else if($file_ext == 'xlsx'){

                    $image = base_url().'assets/images/xlsx.png';

                }else if($file_ext == 'pdf'){

                    $image = base_url().'assets/images/pdf.png';

                }

                $html.='

                <div class="col-md-3 col-12 documents_drag file_'.$row->id.'" data-doc_type="file" id="'.$row->id.'" onclick="setID('.$row->id.');">

                <div class="album_icon">

                <a href="'.base_url().$row->albums.'" >

                <div class="jerry documents_drag_file" data-fid="'.$row->id.'" data-doc_type="file">

                <div class="cat_img but_imgsize">

                <img src="'.$image.'">

                </div><span class="Zdoc_content">'.$row->name.'</span></div>

                </a>';

                if($this->input->post('other') != 'other'){

                    $html.='';

                }

                if($this->input->post('other') != 'other'){

                    $html.='<p><input class="view_type" type="radio" value="1" name="view_'.$row->id.'" id="view_'.$row->id.'"  data-vid="'.$row->id.'" '.$checked1.'>Public</p>

                    <p><input class="view_type" type="radio" value="2" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked2.' data-vid="'.$row->id.'">Private</p>';

                    if(!empty($userData) && $userData->user_role == 'Employer'){

                        $html.='<p><input class="view_type" type="radio" value="3" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked3.' data-vid="'.$row->id.'">Employee</p>';

                    }

                }



                $html.= '</div>

                </div>

                ';

            }

        }

        $html.='</div><div id="fileSuccessDir">

        </div>';

        echo json_encode(array('status'=>1,'html'=>$html));

    }else{

        echo json_encode(array('status'=>0));

    }

}

public function renameFolder(){
    if($this->input->post()){
        $folderID = $this->input->post('folderId');
        $folderData = $this->common_model->getsingle(ALBUM_DIR,array('id'=>$folderID));
        echo json_encode(array('foldername'=>$folderData->dir_name,'folder_id'=>$folderData->id));
    }
}

public function renameFile(){
    if($this->input->post()){
        $fileId = $this->input->post('fileId');
        $fileData = $this->common_model->getsingle(ALBUMS,array('id'=>$fileId));
        echo json_encode(array('foldername'=>$fileData->name,'folder_id'=>$fileData->id));
    }
}

public function renameFolderName(){
    if($this->input->post()){
        $foldername = $this->input->post('rename_folder');
        $folderid = $this->input->post('folderid');
        $folderData = $this->common_model->getsingle(ALBUM_DIR,array('dir_name'=>$foldername));
        if(!empty($folderData)){
            $folderData = $this->common_model->getsingle(ALBUM_DIR,array('dir_name'=>$foldername,'user_id'=>get_current_user_id(),'id'=>$folderid));
            if(!empty($folderData)){
                $this->common_model->updateFields(ALBUM_DIR,array('dir_name'=>$foldername),array('id'=>$folderid));
                echo json_encode(array('status'=>1));
            }else{
                echo json_encode(array('status'=>0));
                die;
            }
        }else{
            $this->common_model->updateFields(ALBUM_DIR,array('dir_name'=>$foldername),array('id'=>$folderid));
            echo json_encode(array('status'=>1));
        }      
    }
}

public function renameFileName(){
    if($this->input->post()){
        $filename = $this->input->post('rename_file');
        $fileid = $this->input->post('fileid');
        $fileData = $this->common_model->getsingle(ALBUMS,array('name'=>$filename));
        if(!empty($fileData)){
            $fileData = $this->common_model->getsingle(ALBUMS,array('name'=>$filename,'user_id'=>get_current_user_id(),'id'=>$fileid));
            if(!empty($fileData)){
                $this->common_model->updateFields(ALBUMS,array('name'=>$filename),array('id'=>$fileid));
                echo json_encode(array('status'=>1));
            }else{
                echo json_encode(array('status'=>0));
                die;
            }
        }else{
            $this->common_model->updateFields(ALBUMS,array('name'=>$filename),array('id'=>$fileid));
            echo json_encode(array('status'=>1));
        }      
    }
}

public function saveProfileDataInfo(){
    $userdata = array(

        'firstname' => $this->input->post('firstname'),

        'lastname' => $this->input->post('lastname'),    

        'user_category' => $this->input->post('user_category'),                                     

        'website_link' => $this->input->post('website_link'),                 

        'phone' => $this->input->post('phone'),

        'zip' => $this->input->post('zip'),

        'city' => $this->input->post('city'),

        'state' => $this->input->post('state'),

        'country' => $this->input->post('country'),

        'current_position' => $this->input->post('current_position'),     

        'basic_info' => 1               

    );

    if(isset($_FILES['profileimg']['name']) && !empty($_FILES['profileimg']['name'])){


        $config['upload_path'] = 'uploads/users/';

        $config['allowed_types'] = 'jpg|jpeg|gif|png';

        $config['max_size'] = '6048';

        $this->load->library('upload', $config);

//check if a file is being uploaded

        if(strlen($_FILES["profileimg"]["name"])>0){

            if ( !$this->upload->do_upload("profileimg"))

            {

                $error = array('error' => $this->upload->display_errors());

                print_r($error);

            }

            else

            {

                $config['image_library'] = 'gd2';

                $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;

                $filename = $_FILES['profileimg']['tmp_name'];





                $imgdata=@exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');





                list($width, $height) = getimagesize($filename);

                if ($width >= $height){

                    $config['width'] = 800;

                }

                else{

                    $config['height'] = 800;

                }

                $config['master_dim'] = 'auto';

// $config['maintain_ratio'] = TRUE;

                $config['maintain_ratio'] = FALSE;



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

        }  
        $userdata['profile'] =  base_url().'uploads/users/'.$this->upload->file_name;
    }


    if($this->input->post('display_phone')){

        $userdata['display_phone'] = 1;

    }else{

        $userdata['display_phone'] = 0;

    }

    if($this->input->post('display_website')){

        $userdata['display_website'] = 1;

    }else{

        $userdata['display_website'] = 0;

    }  

    $this->session->set_userdata('basic_info_data',$userdata);

    echo json_encode(array('status'=>1));

}



public function saveProfileData(){

    $basicInfo = $this->session->userdata('basic_info_data');

    $basicInfo['professional_skill'] = $this->input->post('newprofessional_skills');

    $basicInfo['additional_services'] = $this->input->post('newadditional_servicess');

    $user_id = get_current_user_id();

    $condition=array('id'=>$user_id);  

    $this->session->set_userdata('user_login_type','');

    $update = update_data('tb_users',$basicInfo,$condition);

    $this->session->set_userdata('basic_info_data','');

    if($update){             

        redirect('profile');

    }

}



/* add directory */

public function saveDirectory(){ 

    $userData = $this->common_model->getsingle(USERS,array('id'=>get_current_user_id()));

    $userRole = $userData->user_role;

    $dirName = $_POST['dirName'];

    $user_id = $_POST['user_id'];

    if($dirName != '' && $user_id != '') {

        $dataInsert['user_id']  = get_current_user_id();

        $dataInsert['dir_name']  = $dirName;

        $dataInsert['dir_view_type']  = 1;

        if($this->input->post('parentDirectory')!=''){

            $dataInsert['dir_parent']  = $this->input->post('parentDirectory');

        }


        $folderData = $this->common_model->getsingle(ALBUM_DIR,array('dir_name'=>$dataInsert['dir_name'],'user_id'=>get_current_user_id()));
        if(empty($folderData)){
            $this->common_model->insertData(ALBUM_DIR, $dataInsert);
        }else{
            $arr['status'] = 'exist';
            $arr['msg'] = 'Folder already exist';
            echo json_encode($arr); 
            die;
        }

        $insert_id = $this->db->insert_id();

        $arr['status'] = 'success';

        $arr['msg'] = 'folder created successfully';



        $arr['directoryname'] =$dirName;

        $arr['lastinsertedid']  = $insert_id;

        $arr['userRole']  = $userRole;

    } else {

        $arr['status'] = 'fail';

        $arr['msg'] = 'Something went wrong';

    }

    echo json_encode($arr); 

}



public function fetchParentDirectory($id,$parent=array()){
    $parentID = $this->common_model->getsingle(ALBUM_DIR,array('id'=>$id));
    if(!empty($parentID) && isset($parentID->dir_parent) && $parentID->dir_parent!=0){
        $parentID = $parentID->dir_parent." Folder";
        $parentData = $this->common_model->getsingle(ALBUM_DIR,array('id'=>$parentID));
        if(!empty($parentData)){
            $parent[] = $parentData->dir_name.' Folder';
            $parentID  = $parentData->id;
            if($parentID!=0){
                $parent = $this->fetchParentDirectory($parentID,$parent);
            }
        }
    }
    return $parent;
}

/* retrieve files from directory */

public function retrieveDirectoryFiles(){ 
    $userType = '';
    if(get_current_user_id()){
        $currentUser = get_current_user_id();
        $userData = $this->common_model->getsingle(USERS,array('id'=>$currentUser));
        if(!empty($userData)){
            if($userData->user_role == 'Employer'){
                $userType = 'Employer';
            }else{
                $userType = 'Performer';
            }
        }
    }
    $userIDCurrent = $this->input->post('userId');
    $Dirname = '';
    $c_out = 0;
    $folderid = $_POST['folderid'];
    $userId = $_POST['userId'];
    $Dirname = $_POST['Dirname'];
    $parent = array();
    $parent[] = $_POST['Dirname'].' Folder ';
    $Dirnames = $this->fetchParentDirectory($folderid,$parent);
    if(!empty($Dirnames)){
        $Dirnames = array_reverse($Dirnames);
        if(count($Dirnames)>1){
            $Dirname = implode(' > ',$Dirnames);
            $Dirname = $Dirname." > ";
        }
        else{
            $Dirname = $Dirnames[0].' > ';
        }
    }else{
        $Dirname = $Dirname." Folder >";
    }
    $html = "<div class='main_enter_header'><span>".$Dirname."</span><a id='directoryBack' href='javascript:void(0)' onclick='directoryBack()'>Back</a></div>";

    if($folderid != '' && $userId != '') {
        $where = array('user_id' => $userId, 'folder_id' => $folderid);
        $where1 = array('user_id' => $userId, 'dir_parent' => $folderid);
        $folderdata=$this->common_model->getAllwhere(ALBUMS,$where);
        $childFolders=$this->common_model->getAllwhere(ALBUM_DIR,$where1);
        if($this->input->post('other') == 'other'){
            $albumData = $this->common_model->getAllwhere(ALBUMS,array('user_id'=>$userIDCurrent,'folder_id'=>$folderid));
            $employees = $this->common_model->getAllwhere(REQUESTS,array('receiver'=>$userIDCurrent));
            $companyEmployees = array();

            if(!empty($employees['result'])){
                foreach($employees['result'] as $row){
                    $companyEmployees[] = $row->sender;
                }
            }

            if(!empty($albumData['result'])){
                $count = 0;
                $folderdata = array();
                foreach($albumData['result'] as $row){
                    if($row->view_type == 1 || ($row->view_type == 3 && in_array(get_current_user_id(),$companyEmployees))){
                        $folderdata['result'][$count] = new stdClass();
                        $folderdata['result'][$count]->id = $row->id;
                        $folderdata['result'][$count]->name = $row->name;
                        $folderdata['result'][$count]->albums = $row->albums;
                        $folderdata['result'][$count]->view_type = $row->view_type;
                        $count++;
                    }
                }
            }
            $albumFolderData = $this->common_model->getAllwhere(ALBUM_DIR,array('user_id'=>$userIDCurrent,'dir_parent'=>$folderid));
            if(!empty($albumFolderData['result'])){
                $count = 0;
                $childFolders = array();
                foreach($albumFolderData['result'] as $row){
                    if($row->dir_view_type == 1 || ($row->dir_view_type == 3 && in_array(get_current_user_id(),$companyEmployees))){
                        $childFolders['result'][$count] = new stdClass();
                        $childFolders['result'][$count]->id = $row->id;
                        $childFolders['result'][$count]->dir_name = $row->dir_name;
                        $childFolders['result'][$count]->dir_view_type = $row->dir_view_type;
                        $count++;
                    }
                }
            }  
        }


        /* html of child directory */

        if(!empty($childFolders['result'])) {
            $c_out++;
            foreach($childFolders['result'] as $folderDatas) {
                $checked11 = '';
                $checked22 = '';
                $checked33 = '';
                if($folderDatas->dir_view_type == 3){
                    $checked33 = 'checked=checked';
                }
                else if($folderDatas->dir_view_type == 2){
                    $checked22 = 'checked=checked';
                }else{
                    $checked11 = 'checked=checked';
                }
                $inverted = "&#39;";

                $html.='
                <div class="col-md-3 col-12 folders documents_drag '.$folderDatas->id.'" onclick="setIdDir('.$folderDatas->id.')" data-doc_type="folder" id="'.$folderDatas->id.'">
                <div class="album_icon">';
                if($this->input->post('other') !='other'){
                    $html.='<div onclick="enterInFolder('.$folderDatas->id.','.$userIDCurrent.',&#39;&#39;,'.$inverted.$folderDatas->dir_name.$inverted.')">';
                }else{
                    $html.='<div onclick="enterInFolder('.$folderDatas->id.','.$userIDCurrent.',1,'.$inverted.$folderDatas->dir_name.$inverted.')">';
                }

                $html.='<div class="jerry documents_drag_folder" data-fid="'.$folderDatas->id.'" data-doc_type="folder">
                <div class="cat_img but_imgsize">
                <img src="'.base_url().'/assets/images/folder_image.png">
                </div><span class="Zdoc_content">'.$folderDatas->dir_name.'</span></div>
                </div>';
                if($this->input->post('other') != 'other'){
                    $html.='
                    <p><input class="view_type" type="radio" value="1" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'"  data-vid="'.$folderDatas->id.'" '.$checked11.' data-views="folders">Public</p>
                    <p><input class="view_type" type="radio" value="2" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked22.' data-vid="'.$folderDatas->id.'" data-views="folders">Private</p>';
                    if($userType == 'Employer'){
                        $html.='<p><input class="view_type" type="radio" value="3" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked33.' data-vid="'.$folderDatas->id.'" data-views="folders">Employee</p>';
                    }
                }
                $html.='</div>
                </div>
                ';
            }
        }
        if(!empty($folderdata['result'])) {
            $c_out++;
            foreach($folderdata['result'] as $row) {
                $checked1 = '';
                $checked2 = '';
                $checked3 = '';
                if($row->view_type == 3){
                    $checked3 = 'checked=checked';
                }
                else if($row->view_type == 2){
                    $checked2 = 'checked=checked';
                }else{
                    $checked1 = 'checked=checked';
                }
                $file_ext = pathinfo($row->name,PATHINFO_EXTENSION);
                if($file_ext == 'doc' || $file_ext == 'docs' || $file_ext == 'docx'){
                    $image = base_url().'assets/images/doc.png';
                }
                else if($file_ext == 'xlsx'){
                    $image = base_url().'assets/images/xlsx.png';
                }else if($file_ext == 'pdf'){
                    $image = base_url().'assets/images/pdf.png';
                }
                $html.='
                <div class="col-md-3 col-12 documents_drag file_'.$row->id.'"  data-doc_type="file" id="'.$row->id.'" onclick="setID('.$row->id.');">
                <div class="album_icon">
                <a href="'.base_url().$row->albums.'" >
                <div class="jerry documents_drag_file" data-fid="'.$row->id.'" data-doc_type="file">
                <div class="cat_img but_imgsize">
                <img src="'.$image.'">
                </div><span class="Zdoc_content">'.$row->name.'</span></div>
                </a>';
                if($this->input->post('other') != 'other'){
                    $html.='';
                    $html.='<p><input class="view_type" type="radio" value="1" name="view_'.$row->id.'" id="view_'.$row->id.'"  data-vid="'.$row->id.'" '.$checked1.' data-views="files">Public</p>
                    <p><input class="view_type" type="radio" value="2" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked2.' data-vid="'.$row->id.'" data-views="files">Private</p>';
                    if($userType == 'Employer'){
                        $html.='<p><input class="view_type" type="radio" value="3" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked3.' data-vid="'.$row->id.'" data-views="files">Employee</p>';
                    }
                }
                $html.= '</div>
                </div>';
            }
        } 
        if($c_out==0){
            $html.='<div class="alert alert-danger">No documents exist</div>';
        }
        $arr['status'] = 'success';
        $arr['msg'] = $html;        
    } else {
        $arr['status'] = 'fail';
        $arr['msg'] = 'Something went wrong';
    }
    echo json_encode($arr); 
}


public function getFolderData(){
    $userType = '';
    $order = 'asc';
    if($this->input->post('order')){
        $order = $this->input->post('order');
    }
    if($this->input->post('user')){
        $userIDCurrent = $this->input->post('user');
    }
    if(get_current_user_id()){
        $currentUser = get_current_user_id();
        $userData = $this->common_model->getsingle(USERS,array('id'=>$currentUser));
        if(!empty($userData)){
            if($userData->user_role == 'Employer'){
                $userType = 'Employer';
            }else{
                $userType = 'Performer';
            }
        }
    }
    if(!$this->input->is_ajax_request()){
        echo json_encode(array('response'=>'Invalid request'));
    }
    if($this->input->post()){
        $folderid = $this->input->post('folderid');
        $userId = $this->input->post('user');
        $folderName = $this->common_model->getsingle(ALBUM_DIR,array('id'=>$folderid));
        $Dirname = '';
        $c_out = 0;
        $Dirname = isset($folderName->dir_name)?$folderName->dir_name:'';
        $parent = array();
        $parent[] = $Dirname.' Folder ';
        $Dirnames = $this->fetchParentDirectory($folderid,$parent);
        if(!empty($Dirnames)){
            $Dirnames = array_reverse($Dirnames);
            if(count($Dirnames)>1){
                $Dirname = implode(' > ',$Dirnames);
                $Dirname = $Dirname." > ";
            }
            else{
                $Dirname = $Dirnames[0].' > ';
            }
        }else{
            $Dirname = $Dirname." Folder >";
        }
        $html='';
        if($folderid!=0){
            $html = "<div class='main_enter_header'><span>".$Dirname."</span><a id='directoryBack' href='javascript:void(0)' onclick='directoryBack()'>Back</a></div>";
        }

        if($folderid != '' && $userId != '') {
            $folderdata=$this->common_model->getAllwhere(ALBUMS,array('user_id' => $userId, 'folder_id' => $folderid),'name',$order);
            $childFolders=$this->common_model->getAllwhere(ALBUM_DIR,array('user_id' => $userId, 'dir_parent' => $folderid),'dir_name',$order);
            if($this->input->post('other') == 'other'){
                $albumData = $this->common_model->getAllwhere(ALBUMS,array('user_id'=>$userIDCurrent,'folder_id'=>$folderid),'name',$order);
                $employees = $this->common_model->getAllwhere(REQUESTS,array('receiver'=>$userIDCurrent));
                $companyEmployees = array();

                if(!empty($employees['result'])){
                    foreach($employees['result'] as $row){
                        $companyEmployees[] = $row->sender;
                    }
                }

                if(!empty($albumData['result'])){
                    $count = 0;
                    $folderdata = array();
                    foreach($albumData['result'] as $row){
                        if($row->view_type == 1 || ($row->view_type == 3 && in_array(get_current_user_id(),$companyEmployees))){
                            $folderdata['result'][$count] = new stdClass();
                            $folderdata['result'][$count]->id = $row->id;
                            $folderdata['result'][$count]->name = $row->name;
                            $folderdata['result'][$count]->albums = $row->albums;
                            $folderdata['result'][$count]->view_type = $row->view_type;
                            $count++;
                        }
                    }
                }
                $albumFolderData = $this->common_model->getAllwhere(ALBUM_DIR,array('user_id'=>$userIDCurrent,'dir_parent'=>$folderid),'dir_name',$order);
                if(!empty($albumFolderData['result'])){
                    $count = 0;
                    $childFolders = array();
                    foreach($albumFolderData['result'] as $row){
                        if($row->dir_view_type == 1 || ($row->dir_view_type == 3 && in_array(get_current_user_id(),$companyEmployees))){
                            $childFolders['result'][$count] = new stdClass();
                            $childFolders['result'][$count]->id = $row->id;
                            $childFolders['result'][$count]->dir_name = $row->dir_name;
                            $childFolders['result'][$count]->dir_view_type = $row->dir_view_type;
                            $count++;
                        }
                    }
                }  
            }

            /* html of child directory */

            if(!empty($childFolders['result'])) {
                $c_out++;
                foreach($childFolders['result'] as $folderDatas) {
                    $checked11 = '';
                    $checked22 = '';
                    $checked33 = '';
                    if($folderDatas->dir_view_type == 3){
                        $checked3 = 'checked=checked';
                    }
                    else if($folderDatas->dir_view_type == 2){
                        $checked22 = 'checked=checked';
                    }else{
                        $checked11 = 'checked=checked';
                    }
                    $inverted = "&#39;";
                    $html.='
                    <div class="col-md-3 col-12 folders documents_drag '.$folderDatas->id.'" onclick="setIdDir('.$folderDatas->id.')"  data-doc_type="folder" id="'.$folderDatas->id.'">
                    <div class="album_icon">';
                    if($this->input->post('other') !='other'){
                        $html.='<div onclick="enterInFolder('.$folderDatas->id.','.$userIDCurrent.',&#39;&#39;,'.$inverted.$folderDatas->dir_name.$inverted.')">';
                    }else{
                        $html.='<div onclick="enterInFolder('.$folderDatas->id.','.$userIDCurrent.',1,'.$inverted.$folderDatas->dir_name.$inverted.')">';
                    }

                    $html.='<div class="jerry documents_drag_folder" data-fid="'.$folderDatas->id.'" data-doc_type="folder">
                    <div class="cat_img but_imgsize">
                    <img src="'.base_url().'/assets/images/folder_image.png">
                    </div><span class="Zdoc_content">'.$folderDatas->dir_name.'</span></div>
                    </div>';
                    if($this->input->post('other') != 'other'){
                        $html.='
                        <p><input class="view_type" type="radio" value="1" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'"  data-vid="'.$folderDatas->id.'" '.$checked11.' data-views="folders">Public</p>
                        <p><input class="view_type" type="radio" value="2" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked22.' data-vid="'.$folderDatas->id.'" data-views="folders">Private</p>';
                        if($userType == 'Employer'){
                            $html.='<p><input class="view_type" type="radio" value="3" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked33.' data-vid="'.$folderDatas->id.'" data-views="folders">Employee</p>';
                        }
                    }
                    $html.='</div>
                    </div>
                    ';
                }
            }
            if(!empty($folderdata['result'])) {
                $image='';
                $c_out++;
                foreach($folderdata['result'] as $row) {
                    $checked1 = '';
                    $checked2 = '';
                    $checked3 = '';
                    if($row->view_type == 3){
                        $checked3 = 'checked=checked';
                    }
                    else if($row->view_type == 2){
                        $checked2 = 'checked=checked';
                    }else{
                        $checked1 = 'checked=checked';
                    }
                    $file_ext = pathinfo($row->name,PATHINFO_EXTENSION);
                    if($file_ext == 'doc' || $file_ext == 'docs' || $file_ext == 'docx'){
                        $image = base_url().'assets/images/doc.png';
                    }
                    else if($file_ext == 'xlsx'){
                        $image = base_url().'assets/images/xlsx.png';
                    }else if($file_ext == 'pdf'){
                        $image = base_url().'assets/images/pdf.png';
                    }
                    $html.='
                    <div class="col-md-3 col-12 documents_drag file_'.$row->id.'" data-doc_type="file" id="'.$row->id.'" onclick="setID('.$row->id.');">
                    <div class="album_icon">
                    <a href="'.base_url().$row->albums.'" >
                    <div class="jerry documents_drag_file" data-fid="'.$row->id.'" data-doc_type="file">
                    <div class="cat_img but_imgsize">
                    <img src="'.$image.'">
                    </div><span class="Zdoc_content">'.$row->name.'</span></div>
                    </a>';
                    if($this->input->post('other') != 'other'){
                        $html.='';
                        $html.='<p><input class="view_type" type="radio" value="1" name="view_'.$row->id.'" id="view_'.$row->id.'"  data-vid="'.$row->id.'" '.$checked1.' data-views="files">Public</p>
                        <p><input class="view_type" type="radio" value="2" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked2.' data-vid="'.$row->id.'" data-views="files">Private</p>';
                        if($userType == 'Employer'){
                            $html.='<p><input class="view_type" type="radio" value="3" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked3.' data-vid="'.$row->id.'" data-views="files">Employee</p>';
                        }
                    }
                    $html.= '</div>
                    </div>';
                }
            } 
            if($c_out==0){
                $html.='<div class="alert alert-danger">No documents exist</div>';
            }
            $arr['status'] = 'success';
            $arr['msg'] = $html;        
        } else {
            $arr['status'] = 'fail';
            $arr['msg'] = 'Something went wrong';
        }
        echo json_encode($arr); 

    }
}

public function getFolderDataOld(){
    $userType = '';
    $userIDCurrent = $this->input->post('userId');
    if(get_current_user_id()){
        $currentUser = get_current_user_id();
        $userData = $this->common_model->getsingle(USERS,array('id'=>$currentUser));
        if(!empty($userData)){
            if($userData->user_role == 'Employer'){
                $userType = 'Employer';
            }else{
                $userType = 'Performer';
            }
        }
    }
    if(!$this->input->is_ajax_request()){
        echo json_encode(array('response'=>'Invalid request'));
    }
    if($this->input->post()){
        $folderid = $this->input->post('folderid');
        $userId = $this->input->post('user');
        $folderName = $this->common_model->getsingle(ALBUM_DIR,array('id'=>$folderid));
        $Dirname = '';
        $c_out = 0;
        $Dirname = isset($folderName->dir_name)?$folderName->dir_name:'';
        $parent = array();
        $parent[] = $Dirname.' Folder ';
        $Dirnames = $this->fetchParentDirectory($folderid,$parent);
        if(!empty($Dirnames)){
            $Dirnames = array_reverse($Dirnames);
            if(count($Dirnames)>1){
                $Dirname = implode(' > ',$Dirnames);
                $Dirname = $Dirname." > ";
            }
            else{
                $Dirname = $Dirnames[0].' > ';
            }
        }else{
            $Dirname = $Dirname." Folder >";
        }
        $html = "<div class='main_enter_header'><span>".$Dirname."</span><a id='directoryBack' href='javascript:void(0)' onclick='directoryBack()'>Back</a></div>";

        if($folderid != '' && $userId != '') {
            $folderdata=$this->common_model->getAllwhere(ALBUMS,array('user_id' => $userId, 'folder_id' => $folderid));
            $childFolders=$this->common_model->getAllwhere(ALBUM_DIR,array('user_id' => $userId, 'dir_parent' => $folderid));
            /* html of child directory */

            if(!empty($childFolders['result'])) {
                $c_out++;
                foreach($childFolders['result'] as $folderDatas) {
                    $checked11 = '';
                    $checked22 = '';
                    $checked33 = '';
                    if($folderDatas->dir_view_type == 3){
                        $checked3 = 'checked=checked';
                    }
                    else if($folderDatas->dir_view_type == 2){
                        $checked22 = 'checked=checked';
                    }else{
                        $checked11 = 'checked=checked';
                    }
                    $inverted = "&#39;";
                    $html.='
                    <div class="col-md-3 col-12 documents_drag folders  '.$folderDatas->id.'" onclick="setIdDir('.$folderDatas->id.')" data-doc_type="folder" id="'.$folderDatas->id.'">
                    <div class="album_icon">';
                    if($this->input->post('other') !='other'){
                        $html.='<div onclick="enterInFolder('.$folderDatas->id.','.$userIDCurrent.',&#39;&#39;,'.$inverted.$folderDatas->dir_name.$inverted.')">';
                    }else{
                        $html.='<div onclick="enterInFolder('.$folderDatas->id.','.$userIDCurrent.',1,'.$inverted.$folderDatas->dir_name.$inverted.')">';
                    }

                    $html.='<div class="jerry documents_drag_folder" data-fid="'.$folderDatas->id.'" data-doc_type="folder">
                    <div class="cat_img but_imgsize">
                    <img src="'.base_url().'/assets/images/folder_image.png">
                    </div><span class="Zdoc_content">'.$folderDatas->dir_name.'</span></div>
                    </div>';
                    if($this->input->post('other') != 'other'){
                        $html.='
                        <p><input class="view_type" type="radio" value="1" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'"  data-vid="'.$folderDatas->id.'" '.$checked11.' data-views="folders">Public</p>
                        <p><input class="view_type" type="radio" value="2" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked22.' data-vid="'.$folderDatas->id.'" data-views="folders">Private</p>';
                        if($userType == 'Employer'){
                            $html.='<p><input class="view_type" type="radio" value="3" name="view_'.$folderDatas->id.'" id="view_'.$folderDatas->id.'" '.$checked33.' data-vid="'.$folderDatas->id.'" data-views="folders">Employee</p>';
                        }
                    }
                    $html.='</div>
                    </div>
                    ';
                }
            }
            if(!empty($folderdata['result'])) {
                $c_out++;
                foreach($folderdata['result'] as $row) {
                    $checked1 = '';
                    $checked2 = '';
                    $checked3 = '';
                    if($row->view_type == 3){
                        $checked3 = 'checked=checked';
                    }
                    else if($row->view_type == 2){
                        $checked2 = 'checked=checked';
                    }else{
                        $checked1 = 'checked=checked';
                    }
                    $file_ext = pathinfo($row->name,PATHINFO_EXTENSION);
                    if($file_ext == 'doc' || $file_ext == 'docs' || $file_ext == 'docx'){
                        $image = base_url().'assets/images/doc.png';
                    }
                    else if($file_ext == 'xlsx'){
                        $image = base_url().'assets/images/xlsx.png';
                    }else if($file_ext == 'pdf'){
                        $image = base_url().'assets/images/pdf.png';
                    }
                    $html.='
                    <div class="col-md-3 col-12 documents_drag file_'.$row->id.' " data-doc_type="file" onclick="setID('.$row->id.');">
                    <div class="album_icon">
                    <a href="'.base_url().$row->albums.'" >
                    <div class="jerry documents_drag_file" data-fid="'.$row->id.'" data-doc_type="file">
                    <div class="cat_img but_imgsize">
                    <img src="'.$image.'">
                    </div><span class="Zdoc_content">'.$row->name.'</span></div>
                    </a>';
                    if($this->input->post('other') != 'other'){
                        $html.='';
                        $html.='<p><input class="view_type" type="radio" value="1" name="view_'.$row->id.'" id="view_'.$row->id.'"  data-vid="'.$row->id.'" '.$checked1.' data-views="files">Public</p>
                        <p><input class="view_type" type="radio" value="2" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked2.' data-vid="'.$row->id.'" data-views="files">Private</p>';
                        if($userType == 'Employer'){
                            $html.='<p><input class="view_type" type="radio" value="3" name="view_'.$row->id.'" id="view_'.$row->id.'" '.$checked3.' data-vid="'.$row->id.'" data-views="files">Employee</p>';
                        }
                    }
                    $html.= '</div>
                    </div>';
                }
            } 
            if($c_out==0){
                $html.='<div class="alert alert-danger">No documents exist</div>';
            }
            $arr['status'] = 'success';
            $arr['msg'] = $html;        
        } else {
            $arr['status'] = 'fail';
            $arr['msg'] = 'Something went wrong';
        }
        echo json_encode($arr); 

    }
}

public function folderData($oldID,$newID){
    /*inner files*/
    $folderInnerFiles = $this->common_model->getAllwhere(ALBUMS,array('folder_id'=>$oldID));
    if(!empty($folderInnerFiles['result'])){
        foreach($folderInnerFiles['result'] as $row){
            $dataInsert = array(); 
            $dataInsert['user_id'] = get_current_user_id();
            $dataInsert['folder_id'] = $newID;
            $dataInsert['albums'] = $row->albums;
            $dataInsert['name'] = $row->name;
            $dataInsert['view_type'] = $row->view_type;
            $dataInsert['created_date'] = date('Y-m-d H:i:s');
            $this->common_model->insertData(ALBUMS, $dataInsert);
        }
    }
    /*inner folder*/
    $folderInnerFolder = $this->common_model->getAllwhere(ALBUM_DIR,array('dir_parent'=>$oldID));
    if(!empty($folderInnerFolder['result'])){
        foreach($folderInnerFolder['result'] as $row){
            $dataInsert = array();
            $dataInsert['user_id'] = get_current_user_id();
            $dataInsert['dir_name'] = $row->dir_name;
            $dataInsert['dir_parent'] = $newID;
            $dataInsert['dir_name'] = $row->dir_name;
            $dataInsert['dir_view_type'] = $row->dir_view_type;
            $dataInsert['date_created'] = date('Y-m-d H:i:s');
            $lastID = $this->common_model->insertData(ALBUM_DIR, $dataInsert); 
            $this->folderData($row->id,$lastID);
        }
    }
    return 1;
}

public function createFolderCopy(){
    if($this->input->post()){
        $id = $this->input->post('id');
        $docType = $this->input->post('doc_type');
        $randStr =  substr(md5(mt_rand()), 0, 3);
        if($docType == 'folder'){
            $folderData = $this->common_model->getsingle(ALBUM_DIR,array('id'=>$id));
            $dataInsert = array();
            $dataInsert['user_id'] = get_current_user_id();
            $dataInsert['dir_name'] = $folderData->dir_name;
            $dataInsert['dir_parent'] = $folderData->dir_parent;
            $dataInsert['dir_name'] = $folderData->dir_name."-".$randStr;
            $dataInsert['dir_view_type'] = $folderData->dir_view_type;
            $dataInsert['date_created'] = date('Y-m-d H:i:s');
            $lastID = $this->common_model->insertData(ALBUM_DIR, $dataInsert); 
            $this->folderData($id,$lastID);
        }else if($docType == 'file') {
            $dataInsert = array();
            $fileData = $this->common_model->getsingle(ALBUMS,array('id'=>$id)); 
            if(!empty($fileData)){
                $dataInsert['user_id'] = get_current_user_id();
                $dataInsert['folder_id'] = $fileData->folder_id;
                $dataInsert['albums'] = $fileData->albums;
                $file_ext = pathinfo($fileData->name);
                $dataInsert['name'] = $file_ext['filename']."-".$randStr.".".$file_ext['extension'];
                $dataInsert['view_type'] = $fileData->view_type;
                $dataInsert['created_date'] = date('Y-m-d H:i:s');
                $this->common_model->insertData(ALBUMS, $dataInsert);
            }
        }
        echo json_encode(array('status'=>1));
    }
}
    
    function uploadModal(){
        $data = array();
        $condition=array('id'=>get_current_user_id());                                                                
        $userData = get_where('tb_users',$condition,'row');
        $data['user_role']=$userData->user_role;
        $this->load->view('frontend/upload_modal',$data);
    }

    function upload(){
      // use Facebook\FileUpload\FacebookFile;
       // require APPPATH.'third_party/php-graph-sdk-5.x/src/Facebook/FileUpload/FacebookFile.php';
        $fb = new Facebook\Facebook([
            'app_id' => '1983186745058851',
            'app_secret' => '715143b355e17d73deb5285a4d8cfa41',
            'default_graph_version' => 'v2.3',
        ]);

        $data = [
            'title' => 'My Foo Video',
            'description' => 'This video is full of foo and bar action.',
        ];

        $path = $this->get_web_page('https://www.workadvisor.co/uploads/videos/1539689041_4776491096_79779.mp4');
        try {
            $response = $fb->uploadVideo('me', $path, $data, 'access-token');
        } catch(Facebook\Exceptions\FacebookResponseException $e) {

            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {

            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $graphNode = $response->getGraphNode();
        var_dump($graphNode);

        echo 'Video ID: ' . $graphNode['id'];

    }

    function get_web_page( $url, $cookiesIn = '' ){
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => true,     //return headers in addition to content
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_SSL_VERIFYPEER => true,     // Validate SSL Cert
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_COOKIE         => $cookiesIn
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $rough_content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header_content = substr($rough_content, 0, $header['header_size']);
        $body_content = trim(str_replace($header_content, '', $rough_content));
        $pattern = "#Set-Cookie:\\s+(?<cookie>[^=]+=[^;]+)#m"; 
        preg_match_all($pattern, $header_content, $matches); 
        $cookiesOut = implode("; ", $matches['cookie']);

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['headers']  = $header_content;
        $header['content'] = $body_content;
        $header['cookies'] = $cookiesOut;
    return $header;
}

  /*to get user profile informatio*/
    public function getUserProfileInfo(){
        $dataLink = $this->input->post('dataLink');
        $user_id = get_current_user_id();
        $condition=array('id'=>$user_id);
        $data['user_data'] = get_where('tb_users',$condition,'row');
        if($dataLink == 'friends'){
            $info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country','tb_users.user_role','tb_users.business_name');
            $relation="tb_users.id=friends.user_one_id";
            $condition=array('friends.user_two_id'=>$user_id,'friends.status'=>0,'tb_users.user_role!='=>"Employer");
            $relation2="tb_users.id=friends.user_one_id OR tb_users.id=friends.user_two_id";
            $condition2="(friends.user_two_id='$user_id' OR friends.user_one_id='$user_id') AND friends.status=1 AND tb_users.id!='$user_id' ";
            $pendingRequest = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,$groupby="");
            $allFriends = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation2,$condition2,$groupby="");
            $fcount = 0;
            if(!empty($data['pendingRequest'])){
                $fcount =  count($data['pendingRequest']) - 1;
            }
            $info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country','tb_users.business_name','requests.job_requested_by','tb_users.user_role');
            $relation="tb_users.id=requests.receiver";
            $condition=array('requests.sender'=>get_current_user_id(),'requests.status'=>0,'job_requested_by!='=>get_current_user_id(0));
            $pendingRequestByCompany = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation,$condition,$groupby="");
            if(!empty($pendingRequestByCompany) && !empty($pendingRequest)){
                $data['pendingRequest'] = array_merge($pendingRequest,$pendingRequestByCompany);
            }else if(!empty($pendingRequest)){
                $data['pendingRequest'] = $pendingRequest;
            }else if(!empty($pendingRequestByCompany)){
                $data['pendingRequest'] = $pendingRequestByCompany;
            }
            $relation2="tb_users.id=requests.receiver";
            $condition2="(requests.sender='$user_id') AND requests.status=1 AND tb_users.id!='$user_id' ";
            $allFriendsCompany = array();
            if(!empty($allFriendsCompany) && !empty($allFriends)){
                $data['allFriends'] = array_merge($allFriends,$allFriendsCompany);
            }else if(!empty($allFriends)){
                $data['allFriends'] = $allFriends;
            }else if(!empty($allFriendsCompany)){
                $data['allFriends'] = $allFriendsCompany;
            }

            $relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
            $condition2="(requests.receiver='$user_id' OR requests.sender='$user_id') AND requests.status=1 AND tb_users.id!='$user_id' ";
            $data['workingAt1'] = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");
            $html = $this->load->view('frontend/friends',$data,true);
            echo json_encode(array('html'=>$html));
        }
    else if($dataLink == 'album' || $dataLink == 'ablum_doc'){
        /*******POST-BY-COMPANY******/
            $datacomps = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_status'=>0), 'id', 'DESC','all','','',$group_by='company',$and_where = '');
            if(!empty($datacomps['result'])){
                foreach($datacomps ['result'] as $compss){
                    $company_ids=$compss->company;
                    if($company_ids==0){
                        $company_name=isset($data['category_questions']->name)?$data['category_questions']->name:'';
                    }else{
                        $companyDTL =$this->common_model->getsingle(USERS,array('id'=>$company_ids));
                        $company_name=isset($companyDTL->business_name)?$companyDTL->business_name:'';
                    }
                    $postbycomp = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_status'=>0,'company'=>$company_ids), 'id', 'DESC','all','','',$group_by='',$and_where = ''); 
                    $data['postbycompany'][$company_name]= $postbycomp;
                }
            }
            $html = $this->load->view('frontend/albums',$data,true);
            echo json_encode(array('html'=>$html));
    }
    else if($dataLink == 'community'){
        /*Post of all the members within contact*/
        $contactIDs = array();
//company contacts
        $info = 'tb_users.id';
        $relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
        $condition2="(requests.receiver='$user_id' OR requests.sender='$user_id') AND requests.status=1";
        $companyContacts = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,"");
        if(!empty($companyContacts)){
            foreach($companyContacts as $id){
                if($user_id!=$id['id']){
                    $contactIDs[] = $id['id'];
                }
            }
        }

//friend contacts
        $relation="tb_users.id=friends.user_one_id";
        $condition="(friends.user_two_id='$user_id' OR friends.user_one_id='$user_id') AND friends.status=1";
        $friendContacts = $this->common_model->get_two_table_data($info,USERS,FRIENDS,$relation,$condition,"");
        if(!empty($friendContacts)){
            foreach($friendContacts as $id){
                if($user_id!=$id['id']){
                    $contactIDs[] = $id['id'];
                }
            }
        }

        if(!empty($contactIDs)){
            $contacts = implode(",",$contactIDs);
            $condition = ' user_id IN('.$contacts.')';
            $data['highlights'] = $this->common_model->GetJoinRecord(USERS,'id',POSTS,'user_id','tb_users.firstname,tb_users.lastname,tb_users.business_name,tb_users.user_role,tb_users.profile,tb_users.id as user_id1,posts.*',$condition,'','posts.id','DESC','2','0');
        }
        //QR code generate
        $data['img_url']="";
        $this->load->library('ciqrcode');
        $qr_image=rand().'.png';
        $params['data'] = base_url().'viewdetails/profile/'.encoding(get_current_user_id())."?review=1";
        $params['level'] = 'H';
        $params['size'] = 5;
        $params['savename'] =FCPATH."qr_code/".$qr_image;
        if($this->ciqrcode->generate($params))

        {
            $data['qr_image']=base_url().'qr_code/'.$qr_image; 
        }
        $html = $this->load->view('frontend/community',$data,true);
        echo json_encode(array('html'=>$html));
    }else if($dataLink == 'rank'){
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
        $html = $this->load->view('frontend/rank',$data,true);
        echo json_encode(array('html'=>$html));
    }else if($dataLink == 'rating'){
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
                for($i=0;$i<=5;$i++)
                {
                    $ques_[$i] = starRating(0);
                }
                $indivReview[$business_name]['historyRating'][]= $ques_;
            }
        }
        $data['MyhistoryRating'] = $indivReview;
        $condition=array('id'=>$user_id);
        $data['user_data'] = get_where('tb_users',$condition,'row');
        $category=isset($data['user_data']->user_category) ? $data['user_data']->user_category : '';
        $data['category_details']=$this->common_model->getAllwhere(CATEGORY,array('category_status'=>1));
        if($category!='')
            $data['category_questions'] = $this->common_model->getsingle(CATEGORY,array('id'=>$category));
        $html = $this->load->view('frontend/rating_history',$data,true);
        echo json_encode(array('html'=>$html));
    }else if($dataLink == 'home'){
        $condition=array('id'=>$user_id);
        $data['user_data'] = get_where('tb_users',$condition,'row');
        $category=isset($data['user_data']->user_category) ? $data['user_data']->user_category : '';
        $data['category_details']=$this->common_model->getAllwhere(CATEGORY,array('category_status'=>1));
        //code for yahoo invites mail url //
        // require_once(APPPATH.'libraries/yahoo_api/globals.php');
        // require_once(APPPATH.'libraries/yahoo_api/oauth_helper.php');
        // $callback    =    base_url()."user/yahoo_response";
        // $retarr = get_request_token(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET,$callback, false, true, true);
        // if (! empty($retarr)){
        //     list($info, $headers, $body, $body_parsed) = $retarr;
        //     if ($info['http_code'] == 200 && !empty($body)) {
        //         $_SESSION['request_token']  = $body_parsed['oauth_token'];
        //         $_SESSION['request_token_secret']  = $body_parsed['oauth_token_secret']; $_SESSION['oauth_verifier'] = $body_parsed['oauth_token'];
        //         $data['yahooURL'] = urldecode($body_parsed['xoauth_request_auth_url']);
        //     }
        // }
        $html = $this->load->view('frontend/my_settings',$data,true);
        echo json_encode(array('html'=>$html));
    }else if($dataLink == 'my_account'){
        $condition=array('id'=>$user_id);
        $data['user_data'] = get_where('tb_users',$condition,'row');
         //QR code generate
        $data['img_url']="";
        $this->load->library('ciqrcode');
        $qr_image=rand().'.png';
        $params['data'] = base_url().'viewdetails/profile/'.encoding(get_current_user_id())."?review=1";
        $params['level'] = 'H';
        $params['size'] = 5;
        $params['savename'] =FCPATH."qr_code/".$qr_image;
        if($this->ciqrcode->generate($params))
        {
            $data['qr_image']=base_url().'qr_code/'.$qr_image; 
        }
        $category=isset($data['user_data']->user_category) ? $data['user_data']->user_category : '';
        $data['category_details']=$this->common_model->getAllwhere(CATEGORY,array('category_status'=>1));
        $html = $this->load->view('frontend/my_account',$data,true);
        echo json_encode(array('html'=>$html));
    }
}
}