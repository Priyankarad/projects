<!--section log_inheder start-->

<style type="text/css">
    button.scrol_loding {
        display: block;
        position: absolute;
        margin: 188px;
        margin-top: 454px;
    }
    #share-buttons img {
        width: 35px;
        padding: 5px;
        border: 0;
        box-shadow: 0;
        display: inline;
    }
    video {
        cursor: pointer;
    }
    a.likePost {
        color: #159317 !important;
    }
</style>
<?php
$imgs =""; 
$usernamefb = "";
$imgs = (!empty($user_data->profile))? $user_data->profile:DEFAULT_IMAGE;
// $usernamefb = $user_data->firstname." ".$user_data->lastname;
if($user_data->business_name!=''){
    $usernamefb = $user_data->business_name." on WorkAdvisor.co";
}else{
    $usernamefb = $user_data->firstname." ".$user_data->lastname." on WorkAdvisor.co";
}
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$this->session->set_userdata('actual_link',$actual_link);
?>
<section class="profile_tab">
    <input type="hidden" id="other_user" value="other">
    <?php 
    if(isset($_GET['review']) && $_GET['review'] == 1 && $user_data->user_role == 'Performer'){ ?>
        <input type="hidden" id="review_modal" value="1">
    <?php }else{ ?>
        <input type="hidden" id="review_modal" value="0">
    <?php }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12 pl_inlft">
                <div class="tab_list">
                    <div class="card lc-wz">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="bell notification_toggle">
                                <a> <i class="fa fa-bell" ></i><span class="rivew-bell notification_bell">0</span> Notification </a><ul id="notifications_ul" style="display: none;"><?php 
                                if($this->session->userdata('notifications'))
                                {
                                    echo $this->session->userdata('notifications');
                                }else{
                                    echo '<li>No new notifications found</li>';
                                }
                                ?></ul>
                            </li>
                            <!-- <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Create Category</a></li> -->
                            <?php if($user_data->user_role == 'Performer'){ ?>
                                <li role="presentation" class="m-hide-review"><a href="#messages" aria-controls="messages" role="tab" data-toggle="modal" data-target="#myModal5" data-toggle="tab">
                                    <i class="fa fa-star-o"></i> Write Review</a></li>
                                <?php } ?>
<!-- <li role="presentation"><a href="#ShareProfile" aria-controls="ShareProfile" role="tab" data-toggle="tab">
    <i class="fa fa-share-square-o"></i> Share Profile</a></li> -->
    <li role="presentation"><a  aria-controls="ShareProfile" role="tab" data-toggle="tab">
        <i class="fa fa-share-square-o"></i> Share Profile</a>
    </li>
    <?php  $currentURL = current_url(); 
    $params = $_SERVER['QUERY_STRING']; 
    $fullURL = $currentURL . '?' . $params;
    if($user_data->user_role == 'Employer'){
        $name = ucwords($user_data->business_name);
    }else{
        $name = ucwords($user_data->firstname)." ".ucwords($user_data->lastname);
    }
    $urlP = base_url().'viewdetails/profile/'.encoding($user_data->id);
    ?>
    <div id="share-buttons" title="Share Profile">
        <a href="javascript:void(0)" onclick="submitAndShare('<?php echo $imgs; ?>','<?php echo $usernamefb; ?>','<?php echo $urlP;?>')" target="_blank">  
            <i class="fa fa-facebook"></i>
        </a>

        <a href="https://plus.google.com/share?url=<?php echo $fullURL;?>" target="_blank">
            <i class="fa fa-google-plus"></i>
            <!-- <img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" /> -->
        </a>

        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $fullURL;?>" target="_blank">
            <!-- <img src="https://simplesharebuttons.com/images/somacro/linkedin.png" alt="LinkedIn" /> -->
            <i class="fa fa-linkedin"></i>
        </a>
    </div>
</ul>
</div>

</div>
</div>
</div>
</div>
</section>
<!--log_inheder start- ->
    <!-profil start-->
    <section class="chery1">
        <div class="modal fade" id="qr_code_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">QR Code</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body qr_modal" id="printThis">

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row pl_inlft">
                <div class="col-md-10 col-12 pl_inlft">


                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12 ">  
                            <?php if(!empty($user_data->profile)){ ?>
                                <div class="chery11 profile-img">
                                    <img src="<?php 
                                    if($user_data->profile!='' && $user_data->profile !='assets/images/default_image.jpg') {
                                        echo $user_data->profile;
                                        }else{
                                            echo base_url().DEFAULT_IMAGE;;
                                        }?>"/>
                                    </div>
                                <?php }else{ ?>
                                    <div class="chery11" style="background:url('<?php echo base_url().DEFAULT_IMAGE; ?>');">
                                    </div>
                                <?php } 
                                $urlP = base_url().'viewdetails/profile/'.encoding(get_current_user_id());
                                ?>

                                <!--================mobile_social_icons=================-->
                                <!--================mobile_social_icons=================-->
                                <div id="share-buttons" class="mobile_opens" title="Share Profile">
                                    <a href="javascript:void(0)" onclick="submitAndShare('<?php echo $imgs; ?>','<?php echo $usernamefb; ?>','<?php echo $urlP;?>')" target="_blank">  
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                    <a href="https://plus.google.com/share?url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
                                        <i class="fa fa-google-plus"></i>
                                    </a>
                                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </div>
                                <!--================mobile_social_icons=================-->
                                <!--================mobile_social_icons=================-->
                                <?php $this->session->set_userdata('rated_to_',$user_data->id);?>

                            </div>
                            <div class="col-md-9 col-sm-6 col-12  paaA"> 
                                <div class="Chery2">
                                    <h2>
                                        <?php if($user_data->user_role == 'Performer') { ?>
                                            <?php if(!empty($user_data->firstname)) { echo $user_data->firstname; } ?>
                                            <?php if(!empty($user_data->lastname)) { echo $user_data->lastname; } ?>
                                        <?php } else if($user_data->user_role == 'Employer'){ ?>
                                            <?php if($user_data->business_name!=""){ echo $user_data->business_name; }else{ echo "Business Name"; } ?>
                                        <?php }else{
//echo "User role not defined";
                                         if(!empty($user_data->firstname)) { echo $user_data->firstname; } 
                                         if(!empty($user_data->lastname)) { echo " ".$user_data->lastname; } 

                                     } ?>
                                 </h2>
                                 <p>
                                    <?php if(!empty($user_data->city)) { echo trim($user_data->city).', '; } ?>
                                    <?php if(!empty($user_data->state)) { echo trim($user_data->state).', '; } ?>
                                    <?php if(!empty($user_data->country)) { echo trim($user_data->country).', '; } ?>
                                    <?php if(!empty($user_data->zip)) { echo trim($user_data->zip); } ?>
                                </p>
                                <?php
                                if($user_data->user_role == 'Performer'){ $upid=encoding($user_data->id); ?>
                                    <a href="<?php echo site_url('user/viewhistory/'.$upid) ?>"><?php echo $starRating; ?></a>
                                <?php }

                                if($user_data->user_role == 'Performer'){ ?>
                                    <li class="write_mbshowX"><a href="#messages" aria-controls="messages" role="tab" data-toggle="modal" data-target="#myModal5" data-toggle="tab">
                                        <i class="fa fa-star-o"></i> Write Review</a></li>
                                    <?php } 

//if(isset($user_data->user_role) && $user_data->user_role == 'Performer') { 

                                    ?>
                                    <li class="his_img extr nav-item mbdshow7">
                                        <a class="nav-link" data-toggle="tab" href="#menu7">
                                            <div class="his_img">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            Member Since <?php
                                            if(!empty($user_data->reg_date)) { 
                                                $date = date("Y-m-d",strtotime($user_data->reg_date));
                                                $convert_date = strtotime($date);
                                                $month = date('F',$convert_date);
                                                $year = date('Y',$convert_date);
                                                echo $month.", ".$year; 
                                            } ?>
                                        </a>
                                    </li>
                                    <?php 
// } 




                                    if($user_data->display_phone == 1 || $user_data->user_role == 'Employer'){ ?>
                                       <!--  <p> Phone No. : <?php echo $user_data->phone; ?></p> -->
                                       <div class="callno col_chn">
                                        <i class="fa fa-phone"></i>
                                        <a href="tel:(707)500-8711" class="OnClrX"><?php echo $user_data->phone; ?> </a>
                                    </div>
                                <?php } ?>
                                <?php if($user_data->display_website == 1 || $user_data->user_role == 'Employer'){ 
                                   $urls = '';
$regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
$regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
$regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
$regex .= "(\:[0-9]{2,5})?"; // Port 
$regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
$regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
$regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

if(preg_match("/^$regex$/i", $user_data->website_link)) 
{         
    if(strpos($user_data->website_link, 'http://') !== 0) {
        $urls =  'http://' . $user_data->website_link;
    } else {
        $urls = $user_data->website_link;
    }
}
?>
<!-- <p>Website URL : <?php echo $user_data->website_link; ?></p> -->
<div class="callno col_chn">
    <i class="fa fa-link"></i>
    <a href="<?php echo $urls; ?>" target="_blank" class="OnClrX"><?php echo $user_data->website_link; ?> </a>
</div>

<?php } ?>
<div class="callno col_chn">
    <i class="fa fa-envelope"></i>
    <a href="mailto:<?php echo $user_data->email; ?>" class="OnClrX"><?php echo $user_data->email; ?></a> 
</div>
<?php

if($user_data->user_role == 'Performer'){ ?>
    <div class="current">
        <p class="fl_lft">Current Position  - </p>
        <span class="Paul">
            <strong><?php if(!empty($user_data->current_position)) { echo ucwords($user_data->current_position); } ?></strong> 
            <strong> <?php if(!empty($workingAt->business_name)) { 
                $companyProfileURL = site_url('viewdetails/profile/'.encoding($workingAt->id));
                echo '<b class="at"> At </b><a href="'.$companyProfileURL.'"> '.ucwords($workingAt->business_name).'</a>'; } ?></strong>
            </span>
        </div>
    <?php } ?>
</div>
</div>
</div>
<!--row close-->


</div>

<!-- ===========COLUMN TEN END======== -->
<div class="col-md-2 col-12">
    <div class="main_3btn">

        <?php 
if($user_data->user_role=='Employer'){ // employer row

if(isset($role) && $role == 'Employer'){ // current logged in employer
}
else{  // current logged in performer
    if(get_current_user_id()){
        $userOne=get_current_user_id();
        $userTwo=$user_data->id;
        $isRequest=checkRequest($userOne,$userTwo);
        $requestedByUser = jobRequestedBy($userOne,$user_data->id);
        if($requestedByUser != $userOne && $requestedByUser!=0 && $isRequest!='Accepted'){
            $isRequest = 'NotConfirm';
        }
    }else{
        $isRequest="No";  
    }
    if($isRequest=='No'){ ?>
        <button class="btn btn-info btn-sm" class="jBrQ" onclick="sendJobRequest('<?php echo encoding($user_data->id); ?>',this)" >
            <i class="fa fa-plus"></i> Job Request
        </button>
    <?php }
    else if($isRequest=='NotConfirm'){ 
        $senderID = get_current_user_id();
        $requestedByUser = jobRequestedBy($senderID,$user_data->id);
        ?>
        <?php if($requestedByUser != $senderID && $requestedByUser!=0){ ?>
            <button class="btn btn-info btn-sm" class="jBrQ" onclick="jobRequest('<?php echo encoding($user_data->id); ?>','Accept','<?php echo 'FR'.$user_data->id; ?>',this,'per')" >
                <i class="fa fa-plus"></i> Accept Request 
            </button>
        <?php }else{ ?>
            <button class="btn btn-info btn-sm" class="jBrQ" >
                <i class="fa fa-clock-o" aria-hidden="true"></i>  Pending
            </button>
        <?php } ?>
    <?php }
    else if($isRequest=='Pending'){ 
        ?> 
        <button class="btn btn-info btn-sm" class="jBrQ" >
            <i class="fa fa-clock-o" aria-hidden="true"></i>  Pending
        </button>
    <?php }
    else if($isRequest=='Accepted'){

    }
    else{
        echo '';
    } 
}
}else{ // performer row
if(isset($role) && $role == 'Employer'){ // current logged in employer
    if(get_current_user_id()){
        $userOne=get_current_user_id();
        $userTwo=$user_data->id;
        $isRequest=checkRequest($userOne,$userTwo);
    }else{
        $isRequest="No";  
    }
    if($isRequest=='No'){ ?>
        <button class="btn btn-info btn-md" class="jBrQ" onclick="sendJobRequest('<?php echo encoding($user_data->id); ?>',this,'emp');" >
            <i class="fa fa-plus"></i> Job Request
        </button>
    <?php }else if($isRequest=='NotConfirm'){
        $senderID = get_current_user_id();
        $requestedByUser = jobRequestedBy($user_data->id,$senderID);
        ?>
        <?php if($requestedByUser != $senderID && $requestedByUser!=0){ ?>
            <button class="btn btn-info btn-sm" class="jBrQ" onclick="jobRequest('<?php echo encoding($user_data->id); ?>','Accept','<?php echo 'FR'.$user_data->id; ?>',this)" >
                <i class="fa fa-plus"></i> Accept Request 
            </button>
        <?php }else{ ?>
            <button class="btn btn-info btn-sm" class="jBrQ" >
                <i class="fa fa-clock-o" aria-hidden="true"></i>  Pending
            </button>
        <?php } 
        ?>
<!-- <button class="btn btn-info btn-md" class="jBrQ" onclick="jobRequest('<?php echo encoding($user_data->id); ?>','Accept','<?php echo 'FR'.$user_data->id; ?>',this)" >
<i class="fa fa-plus"></i> Accept Request
</button> -->
<?php } else if($isRequest=='Pending'){ 
    ?>
    <button class="btn btn-info btn-sm" class="jBrQ" >
        <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;&nbsp;Pending
    </button>
<?php }else if($isRequest=='Accepted'){

}
else{
    echo '';
}
}else{
    if(get_current_user_id()){
        $userOne=get_current_user_id();
        $userTwo=$user_data->id;
        $isFriend=checkFriend($userOne,$userTwo);
    }else{
        $isFriend="No"; 
    }

    if($isFriend=='No'){ ?>
        <div class="Chery3">                        <a onclick="addfriend('<?php echo encoding($user_data->id); ?>',this)" href="javascript:void(0)"><i class="fa fa-plus"></i> Add Friend</a>
        </div>
    <?php }else if($isFriend=='NotConfirm'){ ?>
        <div class="Chery3">
            <a href="javascript:void(0)" onclick="friendRequest('<?php echo encoding($user_data->id); ?>','Accept','<?php echo 'FR'.$user_data->id; ?>')"><i class="fa fa-plus"></i> Confirm</a>
        </div>
    <?php }else if($isFriend=='Pending'){ ?>
        <div class="Chery3">
            <a href="javascript:void(0)"> <i class="fa fa-clock-o"></i>&nbsp;&nbsp;Pending</a>
        </div>
    <?php }else if($isFriend=='Accepted'){

    }else{ echo ''; } 
}
}
?>

<div class="Chery3 send_btn">
    <a href="javascript:void(0)" onclick="document.getElementById('MesssageLink').click()"><i class="fa fa-plus"></i> Send Message</a>
</div>


<?php 
$isFavourite = '';
if(get_current_user_id()){
    $isFavourite = isFavourite(get_current_user_id(),$user_data->id);
}
if($isFavourite == '' || $isFavourite == 'no'){
    ?>
    <div class="Chery3 send_btn donal">
        <span  class="favourites unfavorites_wa" data-other_id = "<?php echo isset($user_data->id)?$user_data->id:'';?>">
            <i class="fa fa-heart-o" aria-hidden="true"></i> 
            Add to favorites
        </span>
    </div>
<?php }else{ ?>
    <div class="Chery3 send_btn donal">
        <span  class="favourites favorites_wa" data-other_id = "<?php echo isset($row->id)?$row->id:'';?>"> 
            <i class="fa fa-heart " aria-hidden="true"></i>
            Favorite
        </span>
    </div>

<?php } ?>

</div>
</div>
<!-- ===========COLUMN TWO END======== -->
</div>
<!-- ================MAIN ROW END============== -->
</div>
</section>

<section class="history">
    <div class="container">
        <div class="row">
            <!--tab list start-->
            <div class="col-md-3 col-12 pl_inlft sidebar-expanded" id="sidebar-container">
                <div class="sticky-top sticky-offset">
                    <div class="icon_fclick">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <b>Menu</b>
                    </div>
                    <div class="history_cont">
                        <ul class="nav nav-tabs">
                            <li class="his_img extr nav-item">
                                <a class="nav-link <?php if(isset($_GET['msg']) && $_GET['msg'] == 1){}else{ echo 'active';}?>" data-toggle="tab" href="#home">
                                    <div class="his_img">
                                        <img src="<?php echo base_url();?>assets/images/h8.png">
                                    </div>
                                    Highlights
                                </a>
                            </li>
                            <?php if(isset($user_data->user_role) && $user_data->user_role == 'Performer') { ?>
                                <li class="his_img extr nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#menu2">
                                        <!--<li class="his_img extr"> -->
                                            <div class="his_img">
                                                <i class="fa fa-history"></i>
                                                <!--  <img src="<?php echo base_url();?>assets/images/h1.png"> -->
                                            </div>
                                            Rating History
                                            <!--</li> -->
                                        </a>
                                    </li>
                                <?php } ?>
                                <li class="his_img extr nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#menu3">
                                        <!--   <li class="his_img extr"> -->
                                            <div class="his_img">
                                                <img src="<?php echo base_url();?>assets/images/h10.png">
                                            </div>
                                            <?php if(isset($user_data->user_role) && $user_data->user_role == 'Performer'){
                                                echo 'Friends';
                                            }else{
                                                echo 'Employees';
                                            }?>

                                            <span class="2_green"><?php  if(!empty($allFriends)){ echo count($allFriends); }else{ echo 0;} ?></span>
                                            <!--     </li> -->
                                        </a>
                                    </li>

                                    <li class="his_img extr nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#menu4">
                                            <!--   <li class="his_img extr"> -->
                                                <div class="his_img">
                                                    <img src="<?php echo base_url();?>assets/images/h3.png">
                                                </div>
                                                Albums / Documents
                                                <!-- </li> -->
                                            </a>
                                        </li>
                                        <?php if(isset($user_data->user_role) && $user_data->user_role == 'Performer') { ?>
                                            <li class="his_img extr nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#menuR1">
                                                    <div class="his_img">
                                                        <img src="<?php echo base_url();?>assets/images/h4.png">
                                                    </div>
                                                    Rank
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <li class="his_img extr nav-item">
                                            <a class="nav-link <?php if(isset($_GET['msg']) && $_GET['msg'] == 1){ echo 'active';}else{}?>" data-toggle="tab" id="MesssageLink" href="#menu6">
                                                <!--   <li class="his_img extr"> -->
                                                    <div class="his_img">
                                                        <img src="<?php echo base_url();?>assets/images/h6.png">
                                                    </div>
                                                    Messages
                                                    <!-- </li> -->
                                                </a>
                                            </li>
                                            <?php if(isset($user_data->user_role) && $user_data->user_role == 'Performer') { ?>
                                                <li class="his_img extr nav-item mbdNone7">
                                                    <a class="nav-link" data-toggle="tab" href="#menu7">
                                                        <div class="his_img">
                                                            <img src="<?php echo base_url();?>assets/images/h7.png">
                                                        </div>
                                                        Member Since <?php
                                                        if(!empty($user_data->reg_date)) { 
                                                            $date = date("Y-m-d",strtotime($user_data->reg_date));
                                                            $convert_date = strtotime($date);
                                                            $month = date('F',$convert_date);
                                                            $year = date('Y',$convert_date);
                                                            echo $month.", ".$year; 
                                                        } ?>
                                                    </a>
                                                </li>
                                            <?php } ?>

                                            <li class="his_img extr nav-item" data-toggle="modal" data-target="#modalReport">
                                                <a class="nav-link" data-toggle="tab" href="#menu7">
                                                    <div class="his_img">
                                                        <img src="<?php echo base_url();?>assets/images/h7.png">
                                                    </div>
                                                    Report Profile
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--==tab list close=====-->
                            <!--tab main contant start-->


                            <div class="col-md-9 col-12">
                                <div id="modalReport" class="modal fade">
                                    <div class="modal-dialog modal-confirm">
                                        <div class="modal-content">
                                            <div id="success"></div>
                                            <div class="modal-header">        
                                                <h4 class="modal-title">Are you sure?</h4>  
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you really want to report this profile ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-danger" onclick="reportProfile(<?php echo $user_data->id?>,'<?php echo $user_data->firstname." ".$user_data->lastname;?>');">Report</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class="tab-content">
                                    <input type="hidden" id="base_url" name="base_url" value="<?php echo base_url();?>">
                                    <input type="hidden" id="uname" value="<?php echo $uname;?>">
                                    <input type="hidden" id="uemail" value="<?php echo $uemail;?>">
                                    <!--====================overview page first tab link start=====================-->
                                    <div class="tab-pane <?php if(isset($_GET['msg']) && $_GET['msg'] == 1){}else{ echo 'active';}?> container" id="home">
                                        <div class="row">
                                            <div class="col-md-8 full_fillBx">
                                                <div class="main_with over">
                                                    <h3 class="high_shwM">Highlights</h3>    
                                                    <div class="userposts">
                                                        <div id="responseDiv"></div>
                                                        <?php 
                                                        $imgsert='';
                                                        if(!empty($posts_details['result'])){ $md = 0; foreach($posts_details['result'] as $post){ $md++;?>
                                                            <div class="main_blog post-id" id="<?php echo $post->id; ?>" data-uid="<?php echo $user_data->id; ?>">

                                                                <?php if($post->post_image!=""){
                                                                    $imgsert=$post->post_image;
                                                                    $postimgarr=explode(',',$imgsert);
                                                                    if(count($postimgarr)>1){ ?>
                                                                        <div class = "row pdbothS">
                                                                            <?php foreach($postimgarr as $postim){ ?>
                                                                                <div class = "col-sm-3 col-md-3 thumb_upx2">
<!-- <a href = "#" class = "thumbnail" data-toggle="modal" data-target="#myModal00<?php echo $md; ?>">
<img src = "<?php echo $postim; ?>" alt= "Post Image">
</a> -->
<div class="fansy-gallry">  
    <a class="thumbnail" data-fancybox="gallery1<?php echo $md; ?>" href="<?php echo $postim; ?>">
        <img src="<?php echo $postim; ?>">
    </a>
</div>
</div>

<?php } ?>
</div>

<div class="col-tz">    
    <div id="myModal00<?php echo $md; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <!--  <h4 class="modal-title"><?php echo $newkey; ?></h4> -->
                <div class="modal-body">
                    <div class="row">
                        <?php foreach($postimgarr as $postim){

                          ?>

                          <div class="col-md-3">
                            <div class="fansy-gallry">  
                              <a class="fancybox" data-fancybox="gallery1<?php echo $md; ?>" href="<?php echo $postim; ?>">
                                <img src="<?php echo $postim; ?>">
                            </a>
                        </div>
                    </div>
                <?php  }  ?>
            </div>
        </div>

    </div>
</div>
</div>
</div>

<?php }else{ ?>

    <div class = "over_viewimg">

        <a class="img-fluid" data-fancybox="gallery111<?php echo $md; ?>" href="<?php echo $imgsert; ?>">
            <img src="<?php echo $imgsert; ?>">
        </a>
    </div>
    <div class="col-tz">    
        <div id="myModal002<?php echo $md; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <!--  <h4 class="modal-title"><?php echo $newkey; ?></h4> -->
                    <div class="modal-body">
                        <div class="row">
                            <?php foreach($postimgarr as $postim){
                              ?>
                              <div class="col-md-3">
                                <div class="fansy-gallry">  
                                  <a class="fancybox" data-fancybox="gallery111<?php echo $md; ?>" href="<?php echo $postim; ?>">
                                    <img src="<?php echo $postim; ?>">
                                </a>
                            </div>
                        </div>
                    <?php  }  ?>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<?php  } } ?>
<?php if($post->post_video!=''){ ?>
    <div class="row">
<!--                       <div  data-toggle="modal" data-target="#myModal002<?php echo $md; ?>">
-->                        <div >
    <video width="320" height="240"  controls="true" controlsList="nodownload" class="videos">
        <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/mp4">
            <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/webm">
                <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/ogg">
                    <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/mts">
                    </video>
                </div>
            </div>

        <?php } ?>
        <div class="contant_overviw esdu">
            <h1 class="datess">
                <?php echo date('d-m-Y H:i A',strtotime($post->post_date)); ?>
            </h1>
            <a class="likePost">
                <?php
                $likeStatus = getLikeStatus(get_current_user_id(),$post->id);
                echo '<span class="likeSpan">';
                if(!empty($likeStatus[0])){
                    if($likeStatus[0]->status == 0){
                        echo 'Like';
                    }else{
                        echo 'Liked';
                    }
                }else{
                    echo 'Like';
                }
                echo '</span>';
                ?>
                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                <span class="likeCount"><?php echo ($likeStatus[1]>0)?$likeStatus[1]:'';?></span>
            </a>
            <div class="btnns">
                <div class="form-group">
                   
                    <?php //if($post->post_video==''){ ?>
                        <a href="#" class="linke" data-toggle="modal" data-target="#sharePostModal<?php echo $md; ?>"><img src="<?php echo base_url();?>assets/images/share.png">
                            <i class="fa fa-thumbs-up"></i>
                        </a>
                        <?php //} ?>
                        <div class="modal fade" id="sharePostModal<?php echo $md; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Boost Visibility</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <?php  $currentURL = current_url(); 
                                        $params = $_SERVER['QUERY_STRING']; 
                                        $fullURL = $currentURL . '?' . $params;
                                        ?>
                                    </div>
                                    <div class="modal-body">
                                        <div id="share-buttons" title="Share Profile">
                                            <a href="https://twitter.com/share?url=<?php echo $fullURL;?>" target="_blank">
                                                <i class="fa fa-twitter"></i>
                                            </a>


                                            <?php if($imgsert == '') {
                                                $imgsert = '';
                                            } else {
                                                $imgsert = $imgsert;
                                            } 


                                            if($post->post_video!=''){ 
                                                $video = "'".base_url()."uploads/videos/".$post->post_video."'";
                                                if($user_data->user_role == 'Employer'){
                                                    $name = ucwords($user_data->business_name);
                                                }else{
                                                    $name = ucwords($user_data->firstname)." ".ucwords($user_data->lastname);
                                                }
                                                $urlP = base_url().'viewdetails/profile/'.encoding($user_data->id);
                                                ?>
                                                <a href="javascript:void(0)" class="PIXLRIT1" onclick="publish($video,'<?php echo $name. ' status'; ?>','<?php echo $urlP;?>');" target="_blank">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            <?php } 
                                            else if($imgsert!=''){ 
                                                $imgsert1 = explode(',',$imgsert);
                                                $imgsert2 = $imgsert1[0];
                                                if($user_data->user_role == 'Employer'){
                                                    $name = ucwords($user_data->business_name);
                                                }else{
                                                    $name = ucwords($user_data->firstname)." ".ucwords($user_data->lastname);
                                                }
                                                $urlP = base_url().'viewdetails/profile/'.encoding($user_data->id);
                                                ?>
                                                <a href="javascript:void(0)" class="PIXLRIT1" onclick="submitAndShare('<?php echo $imgsert2; ?>','<?php echo $name. ' status'; ?>','<?php echo $urlP;?>')" target="_blank">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            <?php } ?>
                                            <a href="https://plus.google.com/share?url=<?php echo $fullURL;?>" target="_blank">
                                                <i class="fa fa-google-plus"></i>
                                            </a>

                                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $fullURL;?>" target="_blank">
                                                <i class="fa fa-linkedin"></i>
                                            </a>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contant_overviw">
                <p>
                    <?php
                    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                    $posts = '';
                    $text = $post->post_content;
                    if(preg_match($reg_exUrl, $text, $url)) {
                        $posts = preg_replace($reg_exUrl, "<a href='".$url[0]."' target='_blank'>{$url[0]}</a>", $text);
                    } else {
                        $posts = $post->post_content;
                    }
                    echo $posts;
                    ?>   
                </p>
            </div>
            <div class="commentSection">
                <div id="all_comments<?php echo $post->id;?>">
                    <?php $oldComments = getComments($post->id);
                    if(!empty($oldComments)){
                        foreach($oldComments as $comment){
                            $html = '';
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
                            echo $html;
                        }
                    }
                    ?>
                </div>
                <?php if(get_current_user_id()){ ?>
                    <form method="post" class="commentForm">
                        <textarea type="text" class="comment form-control" name="comment" placeholder="Enter your comment" data-comment="<?php echo $post->id;?>"></textarea>
                        <input type="submit" name="post" value="POST" class="post_comment">
                    </form>
                <?php } ?>
            </div>
        </div>
    <?php  } } ?>
</div>

<div id="lastresponse"></div>

<?php if(!empty($posts_details['result'])){ ?>
    <button class="scrol_loding">
        <img src="<?php echo base_url();?>assets/images/giphy.gif">
    </button>
<?php } ?>

</div>
</div>


<div id="modalDeleteComment" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div id="success"></div>
            <div class="modal-header">        
                <h4 class="modal-title">Are you sure?</h4>  
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete this comment ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="record_id">
                <input type="hidden" id="folderrecord_id">
                <input type="hidden" id="delete_url" value="<?php echo base_url() ?>profile/deleteData">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger del_comment">Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4 col-12 sidebar-expanded" id="sidebar-container">
    <div class="sticky-top sticky-offset">
        <?php if(isset($user_data->user_role) && $user_data->user_role == 'Performer') { 
            $last = $this->uri->total_segments();
            $record_num = $this->uri->segment($last);
            ?>
            <div class="progrs">
                <h1>Performance</h1>
                <?php if(isset($percentarray[5])) {?>
                    <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/5">
                    <?php }else{ ?>
                        <a href="#">
                        <?php }?>
                        <div class="bar-one">
                            <span class="quntit"><?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?></span>
                            <div style="width:<?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?>"></div>
                            <span class="star_rigth">5&nbsp;&nbsp;stars</span>
                        </div>
                    </a>

                    <?php if(isset($percentarray[4])) {?>
                        <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/4">
                        <?php }else{ ?>
                            <a href="#">
                            <?php }?>
                            <div class="bar-one">
                                <span class="quntit"><?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?></span>
                                <div style="width:<?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?>"></div>
                                <span class="star_rigth">4&nbsp;&nbsp;stars</span>
                            </div>
                        </a>

                        <?php if(isset($percentarray[3])) {?>
                            <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/3">
                            <?php }else{ ?>
                                <a href="#">
                                <?php }?>
                                <div class="bar-one">
                                    <span class="quntit"><?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?></span>
                                    <div style="width:<?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?>"></div>
                                    <span class="star_rigth">3&nbsp;&nbsp;stars</span>
                                </div>
                            </a>

                            <?php if(isset($percentarray[2])) {?>
                                <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/2">
                                <?php }else{ ?>
                                    <a href="#">
                                    <?php }?>
                                    <div class="bar-one">
                                        <span class="quntit"><?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?></span>
                                        <div style="width:<?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?>"></div>
                                        <span class="star_rigth">2&nbsp;&nbsp;stars</span>
                                    </div>
                                </a>

                                <?php if(isset($percentarray[1])) {?>
                                    <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/1">
                                    <?php }else{ ?>
                                        <a href="#">
                                        <?php }?>
                                        <div class="bar-one">
                                            <span class="quntit"><?php echo isset($percentarray[1])?number_format($percentarray[1],1).'%':'0%';?></span>
                                            <div style="width:<?php echo isset($percentarray[1])?number_format($percentarray[1],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[1])?number_format($percentarray[1],1).'%':'0%';?>"></div>
                                            <span class="star_rigth">1&nbsp;&nbsp;stars</span>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                            <!--Qr-code start-->
                            <div class="Qr-code">
                                <p> QR Code</p>
                                <p>Scan My Code</p>
                                <a href="#" id="qrCodeImg">
                                    <!-- <img src="<?php echo base_url();?>assets/images/code.png"> --> 
                                    <img class="qr_code1" class="qr_code1" src="<?php echo isset($qr_image)?$qr_image:'';?>">
                                </a>
                                <input type="button" class="btn btn-info" id="btnPrint" value="Click To Print"><span class="qrCodeQuestion"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <!-------------Advertise------------->
<!-- work_advisor_otheruser1 
<ins class="adsbygoogle"
style="display:block"
data-ad-client="ca-pub-3979824042791728"
data-ad-slot="3798133618"
data-ad-format="auto"
data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>-->


<br>
<!-- work_advisor_otheruser2 
<ins class="adsbygoogle"
style="display:block"
data-ad-client="ca-pub-3979824042791728"
data-ad-slot="9466636537"
data-ad-format="auto"
data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
-->
<!-------------Advertise------------->
</div>
<!--progresh bar close-->
</div>
</div>
<!--====================overview page first tab link close=====================-->


<!--====================history page first tab link =====================-->
<?php if(isset($user_data->user_role) && $user_data->user_role == 'Performer') { ?>
    <!--====================history page first tab link =====================--> 
    <div class="tab-pane container" id="menu2">
        <div class="row">
            <div class="col-md-8">

                <div class="main_with coutm-wit">
                    <h3>Rating History &nbsp;<span class="history_"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h3>
                    <ul>
                        <?php if(!empty($MyhistoryRating)){ foreach($MyhistoryRating as $key=>$historyratings){
                            $upid=encoding($user_data->id);
                            $compid=encoding($MyhistoryRating[$key][0]['company_id']);
                            ?>              
                            <li class="ful_cntant min-pdn">
                                <div class="lin-higthdiv">
                                    <a href="<?php echo site_url('user/indivisualhistory/'.$upid.'/'.$compid) ?>">  <?php 
                                    if($key!=''){
                                        echo $key;
                                    }else if(isset($category_det->name)){
                                        echo $category_det->name;
                                    }else{
                                        echo 'Unknown';
                                    }
                                    ?>

                                    (<?php echo count($historyratings);  ?> Ratings) </a>
                                </div>
                            </li>
                        <?php } } ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <!-------------Advertise------------->
                <!-- work_advisor_otheruser3 -->
                <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-3979824042791728"
                data-ad-slot="1260843457"
                data-ad-format="auto"
                data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <!-------------Advertise------------->
            </div>               
        </div>
    </div>
<?php } ?>
<!--====================history page first tab link close =====================-->


<!--====================rank page six tab link  =====================--> 
<div class="tab-pane container" id="menuR1">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <div class="rankPshadows boxCenterTall" >
                <div class="row">
                    <h1 class="you-sm">Ranking <span class="other_ranking"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>
                    <?php if(!empty($userRankRatings)){
                        foreach($userRankRatings as $row){
                            if($row['id'] == $other_user_id){?>
                                <div class="col-md-3 col-sm-3 col-6 custmizecol3">
                                    <a href="<?php echo base_url() ?>profile">
                                        <div class="nam-tz">
                                            <div class="us-tz rank_imgs">
                                                <?php if($row['profile']!='assets/images/default_image.jpg'){?>
                                                    <img src="<?php echo $row['profile'];?>" alt="Post Image" class="img-fluid rmvobj">
                                                <?php } else{ ?>
                                                    <img src="<?php echo base_url().$row['profile'];?>" alt="Post Image" class="img-fluid rmvobj">
                                                <?php } ?>
                                            </div>
                                            <p><?php echo $row['firstname']." ".$row['lastname'];?></p>
                                            <div class="combaine-sstx-z comrank">
                                                <?php echo $row['star_rating'];?>
                                            </div>
                                            <p>Rank - <span><?php echo $row['rank'];?></span> </p>
                                        </div>
                                    </a>
                                </div>

                            <?php       }
                        }
                    } ?>
                </div>

                <div class="top-usr">
                    <div class="row">
                        <h1 class="you-sm text-center">Top 5 Rankings</h1>
                        <?php if(!empty($userRankRatings)){
                            $count = 1;
                            foreach($userRankRatings as $row){
                                if($row['id'] == get_current_user_id()){
                                    $url = base_url().'profile';
                                }else{
                                    $url = base_url().'viewdetails/profile/'.encoding($row['id']);
                                }
                                if($count <= 5){
                                    ?>
                                    <div class="col-md-3 col-sm-3 col-6 custmizecol3">
                                        <a href="<?php echo $url;?>">
                                            <div class="nam-tz">
                                                <div class="us-tz rank_imgs">
                                                    <?php if($row['profile']!='assets/images/default_image.jpg'){?>
                                                        <img src="<?php echo $row['profile'];?>" alt="Post Image" class="img-fluid rmvobj">
                                                    <?php } else{ ?>
                                                        <img src="<?php echo base_url().$row['profile'];?>" alt="Post Image" class="img-fluid rmvobj">
                                                    <?php } ?>
                                                </div>
                                                <p><?php echo $row['firstname']." ".$row['lastname'];?></p>
                                                <div class="combaine-sstx-z comrank">
                                                    <?php echo $row['star_rating'];?>
                                                </div>
                                                <p>Rank - <span><?php echo $row['rank'];?></span> </p>
                                            </div>
                                        </a>
                                    </div>

                                <?php     }else{
                                    break;
                                }
                                $count++;
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--====================rank page six  tab link close =====================-->

<!--====================Friends page first tab link  =====================-->
<div class="tab-pane container" id="menu3">

    <div class="row Pixel_ml1">
        <div class="col-md-12 full_fillBx">
            <div class="main_div_width">
                <?php if(isset($user_data->user_role) && $user_data->user_role == 'Performer'){ ?>
                    <div class="row">
                        <h2 class="Cher">All Friends</h2>
                        <?php
                        $a=0;
                        if(!empty($allFriends)){  foreach($allFriends as $frie){ 
                            $a++;
                            $userProfileUrl1 = site_url('viewdetails/profile/'.encoding($frie['id']));
                            ?>
                            <div class="col-md-3 col-6" id="<?php echo 'AF'.$frie['id']; ?>">
                                <div class="jerry">
                                    <h1>
<?php //echo $frie['firstname'].' '.$frie['lastname']; 
if(isset($frie['business_name']) && $frie['business_name']!='')
    echo $frie['business_name'];
else
    echo $frie['firstname'].' '.$frie['lastname'];
?>
</h1>
<a href="<?php echo $userProfileUrl1; ?>">
    <div class="cat_img">
        <img src="<?php echo (!empty($frie['profile']) && $frie['profile']!='assets/images/default_image.jpg') ? $frie['profile'] : base_url().DEFAULT_IMAGE; ?>" alt="<?php echo $frie['firstname'].' '.$frie['lastname']; ?>">
    </div>
</a>
<p>
    <?php 
    $address = array();
    if(isset($frie['city']) && !empty($frie['city']))
        $address[] = trim($frie['city']);
    if(isset($frie['country']) && !empty($frie['country']))
        $address[] = trim($frie['country']);
    if(isset($frie['zip']) && !empty($frie['zip']))
        $address[] = trim($frie['zip']);
    if(!empty($address)){
        $address = implode(", ", $address);
        echo $address;
    }
    ?>
</p>

<!-- <img src="<?php echo base_url();?>assets/images/s4.png" class="star_img2"> -->
<?php 
$userRating = userOverallRatings($frie['id']);
if(!empty($userRating['starRating'])){

    echo preg_replace("/\([^)]+\)/","",$userRating['starRating']);
}
?>
</div>

</div>
<?php if($a%4==0){?> </div>
<div class="row mar_tp">
<?php }  } } 
if($a==0){
    echo '<div class="alert alert-danger othAlsX">No data exist</div>';
}  ?>
</div>
<?php }else{ ?>
    <div class="row">
        <h2 class="Cher">Employees</h2>
        <?php
        $a=0;

        if(!empty($allFriends)){  foreach($allFriends as $frie1){ 
            if($frie1['user_role']=='Performer'){
                $a++;
                $userProfileUrl1 = site_url('viewdetails/profile/'.encoding($frie1['id']));
                ?>
                <div class="col-md-3 col-6" id="<?php echo 'AF'.$frie1['id']; ?>">
                    <div class="jerry" style="text-align: center;">
                        <h1>
                            <h1><?php echo $frie1['firstname']; ?> <?php echo $frie1['lastname']; ?></h1>
                        </h1>
                        <a href="<?php echo $userProfileUrl1; ?>">
                            <div class="cat_img">
                                <img src="<?php echo (!empty($frie1['profile']) && $frie1['profile']!='assets/images/default_image.jpg') ? $frie1['profile'] : base_url().DEFAULT_IMAGE; ?>" alt="<?php echo $frie1['firstname'].' '.$frie1['lastname']; ?>">
                            </div>
                        </a>
                        <p>
                           <?php 
                           $address = array();
                           if(isset($frie1['city']) && !empty($frie1['city']))
                            $address[] = trim($frie1['city']);
                        if(isset($frie1['country']) && !empty($frie1['country']))
                            $address[] = trim($frie1['country']);
                        if(isset($frie1['zip']) && !empty($frie1['zip']))
                            $address[] = trim($frie1['zip']);
                        if(!empty($address)){
                            $address = implode(", ", $address);
                            echo $address;
                        }
                        ?>
                    </p>

                    <?php
                    $ratingData =  userOverallRatings($frie1['id']);
                    if(isset($ratingData['starRating'])){
                        echo preg_replace("/\([^)]+\)/","",$ratingData['starRating']);
                    }?>
                </div>

            </div>
            <?php if($a%4==0){?> </div>
            <div class="row mar_tp">
            <?php } } } }
            if($a==0){
                echo '<div class="alert alert-danger">No data exist</div>';
            }  ?>
        </div>
    <?php } ?>
    <?php if($user_data->user_role == 'Performer'){ ?>
        <div class="row mar_tp F_allfnds otherRpf">
            <h2 class="Cher">Working At</h2>
            <?php
            $a=0;
// pr($allFriends);
            if(!empty($workingAt1)){  foreach($workingAt1 as $frie){ 
                if($frie['user_role']!='Performer'){
                    $a++;
                    $userProfileUrl1 = site_url('viewdetails/profile/'.encoding($frie['id']));
                    ?>
                    <div class="col-md-3 col-6 my_allfloatsF" id="<?php echo 'AF'.$frie['id']; ?>">
                        <div class="jerry">
                            <h1><?php echo $frie['business_name']; ?></h1>
                            <a href="<?php echo $userProfileUrl1; ?>">
                                <div class="cat_img">
                                  <img src="<?php echo (!empty($frie['profile']) && $frie['profile']!='assets/images/default_image.jpg') ? $frie['profile'] : base_url().DEFAULT_IMAGE; ?>" alt="<?php echo $frie['firstname'].' '.$frie['lastname']; ?>">
                              </div>
                          </a>

                          <p><?php 
                          $address = array();
                          if(isset($frie['city']) && !empty($frie['city']))
                            $address[] = trim($frie['city']);
                        if(isset($frie['country']) && !empty($frie['country']))
                            $address[] = trim($frie['country']);
                        if(isset($frie['zip']) && !empty($frie['zip']))
                            $address[] = trim($frie['zip']);
                        if(!empty($address)){
                            $address = implode(", ", $address);
                            echo $address;
                        }
                        ?></p>
                        <!--  <p><button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalUnfriend" onclick="setFriendID(<?php echo $frie['id']?>)">Unfriend</button> &nbsp; <button class="btn btn-sm btn-danger" onclick="friendRequest('<?php echo encoding($frie['id']); ?>','Block','<?php echo 'AF'.$frie['id']; ?>')">Block</button></p> -->
                    </div>

                </div> 
                <?php if($a%4==0){?> </div>


                <div class="row mar_tp"> <?php }
            }
        }
    }
    if($a==0){
        echo '<div class="alert alert-danger">No data exist</div>';
    }  ?>
</div>


<?php } ?>


<!--pagination row close-->
<div class="bor_btm"></div>

<!--tab-content close-->
</div>

</div>
<div class="col-md-4">

    <!-- other_profile_friends -->

    <!-- work_advisor_otheruser4 -->
    <ins class="adsbygoogle"
    style="display:block"
    data-ad-client="ca-pub-3979824042791728"
    data-ad-slot="8882831533"
    data-ad-format="auto"
    data-full-width-responsive="true">
</ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
</div>
</div>
<!--====================Friends page first tab link close =====================-->





<!--Video-photo doc tab link --> 
<div class="tab-pane container" id="menu4">
    <div class="row">
        <div class="col-md-9 col-12 full_fillBx"> 
            <div class="bx_shdImg">
                <h1>Albums  &nbsp;<span class="albums"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>
                <!--start row--> 
                <div class="row">
                    <?php if(!empty($postbycompany)){ $md=0;  foreach($postbycompany as$newkey=>$newvalue){ $md++;
                        $picarr=array();
                        $vidarray = array();
                        $latest_image1=base_url()."assets/images/p1.png";
                        $latest_image2=base_url()."assets/images/ph.png";
                        $latest_image3=base_url()."assets/images/v.png";
                        ?>
                        <div class="col-tz">    
                            <div id="myModal00<?php echo $md; ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        </div>
                                        <h4 class="modal-title"><?php echo $newkey; ?></h4>
                                        <div class="modal-body">
                                            <div class="row">
                                                <?php foreach($newvalue['result'] as $pst){
                                                    if($pst->post_image!=""){
                                                        $multiple=explode(',',$pst->post_image);
                                                        foreach($multiple as $img){

                                                          $picarr[]= $img;
                                                          $latest_image1=$img;
                                                          $latest_image2=$img;
                                                          $latest_image3=$img;

                                                          ?>

                                                          <div class="col-md-3">
                                                            <div class="fansy-gallry">  
                                                              <a class="fancybox" data-fancybox="gallery1<?php echo $md; ?>" href="<?php echo $img; ?>">
                                                                <img src="<?php echo $img; ?>">
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php } } } ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-tz">    
                            <div id="myModal00v<?php echo $md; ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        </div>
                                        <h4 class="modal-title"><?php echo $newkey; ?></h4>
                                        <div class="modal-body">
                                            <div class="row">
                                                <?php foreach($newvalue['result'] as $pst){
                                                    if($pst->post_video!=""){
                                                        $multiple=explode(',',$pst->post_video);
                                                        foreach($multiple as $video){
                                                            $vidarray[]= "uploads/videos/".$video;
                                                            $latest_video1="uploads/videos/".$video;
                                                            $latest_video2="uploads/videos/".$video;
                                                            $latest_video3="uploads/videos/".$video;
                                                            ?>
                                                            <div class="col-md-3">
                                                                <div class="fansy-gallry">  
                                                                    <a data-fancybox="gallery2<?php echo $md; ?>" href="<?php echo base_url().'uploads/videos/'.$video; ?>">
                                                                        <video width="320" height="240"  preload="metadata" class="videos">
                                                                            <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type="video/mp4">
                                                                                <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type="video/webm">
                                                                                    <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type="video/ogg">
                                                                                      <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type="video/mts">
                                                                                        <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=15" type='video/x-matroska; codecs="theora, vorbis"'>
                                                                                            <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type="video/x-matroska">
                                                                                            </video>

                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } } } ?>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4 col-12">
                                                        <a href="#">
                                                            <div class="jerry">
                                                                <h1><?php echo $newkey; ?></h1>

                                                                <div class="cat_img photss">

                                                                    <div class="atin_photos">
                                                                        <?php if(!empty($picarr) && count($picarr)>0){?>
                                                                            <img src="<?php echo $latest_image1; ?>">
                                                                            <a href="" class="bod_btm"><?php echo count($picarr)?> Photos</a><br>
                                                                        <?php } ?>
                                                                        <?php if(!empty($vidarray) && count($vidarray)>0){?>
                                                                            <video width="320" height="240"  controls="true" controlsList="nodownload" class="videos">
                                                                                <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/mp4">
                                                                                    <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/webm">
                                                                                        <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/ogg">
                                                                                            <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/mts">
                                                                                                <source src="<?php echo base_url().$latest_video1; ?>#t=1" type='video/x-matroska; codecs="theora, vorbis"'>
                                                                                                    <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/x-matroska">
                                                                                                    </video>

                                                                                                    <a href="" class="bod_btm"><?php echo count($vidarray)?> Videos</a>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="jhiga">
                                                                                            <span><?php echo $newkey; ?></span>
                                                                                            <?php if(!empty($picarr) && count($picarr)>0){?>
                                                                                                <div class="pho_cnt">
                                                                                                    <div class="photos1">
                                                                                                        <img src="<?php echo $latest_image2; ?>">
                                                                                                    </div>
                                                                                                    <a href="" data-toggle="modal" data-target="#myModal00<?php echo $md; ?>" class="bod_btm"><?php echo count($picarr)?> Photos</a>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                            <?php if(!empty($vidarray) && count($vidarray)>0){?>
                                                                                                <div class="pho_cnt">
                                                                                                    <div class="photos1 mar_lft">

                                                                                                        <video width="320" height="240" class="videos" preload="metadata">
                                                                                                            <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/mp4">
                                                                                                                <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/webm">
                                                                                                                    <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/ogg">
                                                                                                                        <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/mts">
                                                                                                                            <source src="<?php echo base_url().$latest_video1; ?>#t=1" type='video/x-matroska; codecs="theora, vorbis"'>
                                                                                                                                <source src="<?php echo base_url().$latest_video1; ?>" type="video/x-matroska">
                                                                                                                                </video>

                                                                                                                            </div>
                                                                                                                            <a href="" data-toggle="modal" data-target="#myModal00v<?php echo $md; ?>" class="bod_btm"><?php echo count($vidarray)?> Videos</a>
                                                                                                                        </div>
                                                                                                                    <?php } ?>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </a>
                                                                                                    </div> 
                                                                                                <?php } } ?>
                                                                                            </div>


                                                                                            <div class="bor_btm"></div>
                                                                                            <div class="row mar_tp">
                                                                                                <h2 class="Cher">Document-Files &nbsp;<span class="doc_files"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h2>
                                                                                                <div class="container">
                                                                                                    <form id="fileupload" action="#" method="POST" enctype="multipart/form-data">
                                                                                                        <div class="row files" id="files1">
                                                                                                            <ul class="fileList"></ul>
                                                                                                        </div>


                                                                                                    </form>
                                                                                                </div>
                                                                                                <div class="cover_FxPx">
                                                                                                    <input type="text" placeholder = "Search here" onkeyup="getDocuments('other')" id="search_doc">

                                                                                                    <select class="arrange">
                                                                                                        <option value="asc">A-Z</option>
                                                                                                        <option value="desc">Z-A</option>
                                                                                                    </select>

                                                                                                    <input type="hidden" id="user_id" value="<?php echo $user_data->id;?>">
                                                                                                    <!-- <div class="gr-lst-vie"><i class="fa fa-plus"></i></div>  -->
                                                                                                    <div tp="list" class="gr-lst-vie"><i class="fa fa-bars"></i></div>

                                                                                                    <div tp="grid" class="gr-lst-vie"><i class="fa fa-th-large"></i></div> 
                                                                                                </div>
                                                                                                <div id="fileSuccess" class="grid">
                                                                                                    <div id="fileSuccessmain">
                                                                                                        <?php 
                                                                                                        $html='';

                                                                                                        /* html of directory */
                                                                                                        $inverted = "&#39;";
                                                                                                        if(!empty($albumFolderData)) {
                                                                                                            foreach($albumFolderData['result'] as $folderDatas) {
                                                                                                                $html.='
                                                                                                                <div class="col-md-3 col-12 '.$folderDatas->id.'" onclick="setIdDir('.$folderDatas->id.')">
                                                                                                                <div class="album_icon">
                                                                                                                <div onclick="enterInFolder('.$folderDatas->id.','.$user_data->id.',1,'.$inverted.$folderDatas->dir_name.$inverted.')">
                                                                                                                <div class="jerry">
                                                                                                                <div class="cat_img but_imgsize">
                                                                                                                <img src="'.base_url().'/assets/images/folder_image.png">
                                                                                                                </div><span class="Zdoc_content">'.$folderDatas->dir_name.'</span></div>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                </div>';
                                                                                                            }
                                                                                                        }

                                                                                                        /* html of directory end */
                                                                                                        if(!empty($albumData['result'])){
                                                                                                            foreach($albumData['result'] as $row){
                                                                                                                $checked1 = '';
                                                                                                                $checked2 = '';
                                                                                                                if($row->view_type == 2){
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
                                                                                                                <div class="col-md-3 col-12" onclick="setID('.$row->id.');">
                                                                                                                <div class="album_icon">
                                                                                                                <a href="'.base_url().$row->albums.'" download="">
                                                                                                                <div class="jerry">
                                                                                                                <div class="cat_img but_imgsize">
                                                                                                                <img src="'.$image.'">
                                                                                                                </div><span class="Zdoc_content">'.$row->name.'</span></div>
                                                                                                                </a>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                ';
                                                                                                            }


                                                                                                        }else{
//$html.='<div class="alert alert-danger">No Documents Exist</div>';
                                                                                                        } 

                                                                                                        echo $html;?>
                                                                                                    </div>
                                                                                                    <div id="fileSuccessDir">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3 col-12"> 

                                                                                        <div class="Qr-code">
                                                                                            <p> QR Code</p>
                                                                                            <p>Scan My Code</p>
                                                                                            <a href="#" id="qrCodeImg">
                                                                                                <!--  <img src="<?php echo isset($qr_image)?$qr_image:'';?>"> -->
                                                                                                <img class="qr_code1" src="<?php echo isset($qr_image)?$qr_image:'';?>">
                                                                                            </a>
                                                                                            <input type="button" class="btn btn-info" id="btnPrint" value="Click To Print"><span class="qrCodeQuestion"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                                                                                        </div>
                                                                                        <br/> <br/>
                                                                                        <!-- other_user_album -->

                                                                                        <!-- work_advisor_otheruser5 -->
                                                                                        <ins class="adsbygoogle"
                                                                                        style="display:block"
                                                                                        data-ad-client="ca-pub-3979824042791728"
                                                                                        data-ad-slot="4102629214"
                                                                                        data-ad-format="auto"
                                                                                        data-full-width-responsive="true"></ins>
                                                                                        <script>
                                                                                            (adsbygoogle = window.adsbygoogle || []).push({});
                                                                                        </script>
                                                                                    </div>

                                                                                </div> 
                                                                            </div>
                                                                            <!--Video-photo doc tab link close--> 
<!-- <div class="tab-pane container" id="menu4">
<div class="row">
<div class="col-md-8 col-12">

<div class="row">


<div class="col-md-4 col-12">
<a href="#">
    <div class="jerry">
        <h1>Kingsport</h1>
        <div class="cat_img photss">
            <img src="<?php echo base_url();?>assets/images/p1.png">
            <div class="atin_photos">
                <a href="" class="bod_btm">18 Photos</a><br>
                <a href="" class="bod_btm">3 Videos</a>
            </div>
        </div>
        <div class="jhiga">
            <span> Cassandra M. Figueroa</span>
            <div class="pho_cnt">
                <div class="photos1">
                    <img src="<?php echo base_url();?>assets/images/ph.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
            <div class="pho_cnt">
                <div class="photos1 mar_lft">
                    <img src="<?php echo base_url();?>assets/images/v.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
        </div>
    </div>
</a>
</div>

<div class="col-md-4 col-12">
<a href="#">
    <div class="jerry">
        <h1>Kingsport</h1>
        <div class="cat_img photss">
            <img src="<?php echo base_url();?>assets/images/p1.png">
            <div class="atin_photos">
                <a href="" class="bod_btm">18 Photos</a><br>
                <a href="" class="bod_btm">3 Videos</a>
            </div>
        </div>
        <div class="jhiga">
            <span> Cassandra M. Figueroa</span>
            <div class="pho_cnt">
                <div class="photos1">
                    <img src="<?php echo base_url();?>assets/images/ph.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
            <div class="pho_cnt">
                <div class="photos1 mar_lft">
                    <img src="<?php echo base_url();?>assets/images/v.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
        </div>
    </div>
</a>
</div>

<div class="col-md-4 col-12">
<a href="#">
    <div class="jerry">
        <h1>Kingsport</h1>
        <div class="cat_img photss">
            <img src="<?php echo base_url();?>assets/images/p1.png">
            <div class="atin_photos">
                <a href="" class="bod_btm">18 Photos</a><br>
                <a href="" class="bod_btm">3 Videos</a>
            </div>
        </div>
        <div class="jhiga">
            <span> Cassandra M. Figueroa</span>
            <div class="pho_cnt">
                <div class="photos1">
                    <img src="<?php echo base_url();?>assets/images/ph.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
            <div class="pho_cnt">
                <div class="photos1 mar_lft">
                    <img src="<?php echo base_url();?>assets/images/v.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
        </div>
    </div>
</a>
</div>


<div class="col-md-4 col-12">
<a href="#">
    <div class="jerry">
        <h1>Kingsport</h1>
        <div class="cat_img photss">
            <img src="<?php echo base_url();?>assets/images/p1.png">
            <div class="atin_photos">
                <a href="" class="bod_btm">18 Photos</a><br>
                <a href="" class="bod_btm">3 Videos</a>
            </div>
        </div>
        <div class="jhiga">
            <span> Cassandra M. Figueroa</span>
            <div class="pho_cnt">
                <div class="photos1">
                    <img src="<?php echo base_url();?>assets/images/ph.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
            <div class="pho_cnt">
                <div class="photos1 mar_lft">
                    <img src="<?php echo base_url();?>assets/images/v.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
        </div>
    </div>
</a>
</div>


<div class="col-md-4 col-12">
<a href="#">
    <div class="jerry">
        <h1>Kingsport</h1>
        <div class="cat_img photss">
            <img src="<?php echo base_url();?>assets/images/p1.png">
            <div class="atin_photos">
                <a href="" class="bod_btm">18 Photos</a><br>
                <a href="" class="bod_btm">3 Videos</a>
            </div>
        </div>
        <div class="jhiga">
            <span> Cassandra M. Figueroa</span>
            <div class="pho_cnt">
                <div class="photos1">
                    <img src="<?php echo base_url();?>assets/images/ph.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
            <div class="pho_cnt">
                <div class="photos1 mar_lft">
                    <img src="<?php echo base_url();?>assets/images/v.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
        </div>
    </div>
</a>
</div>

<div class="col-md-4 col-12">
<a href="#">
    <div class="jerry">
        <h1>Kingsport</h1>
        <div class="cat_img photss">
            <img src="<?php echo base_url();?>assets/images/p1.png">
            <div class="atin_photos">
                <a href="" class="bod_btm">18 Photos</a><br>
                <a href="" class="bod_btm">3 Videos</a>
            </div>
        </div>

        <div class="jhiga">
            <span> Cassandra M. Figueroa</span>
            <div class="pho_cnt">
                <div class="photos1">
                    <img src="<?php echo base_url();?>assets/images/ph.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
            <div class="pho_cnt">
                <div class="photos1 mar_lft">
                    <img src="<?php echo base_url();?>assets/images/v.png">
                </div>
                <a href="" class="bod_btm">8 videos</a>
            </div>
        </div>

    </div>
</a>
</div>
</div>



<div class="bor_btm"></div>
<div class="row mar_tp">
<h2 class="Cher">Document-Files</h2>
<div class="col-md-3 col-12">
<a href="#">
    <div class="jerry">
        <div class="cat_img but_imgsize">
            <img src="<?php echo base_url();?>assets/images/doc.png">
        </div>

    </div>
</a>
</div>

<div class="col-md-3 col-12">
<a href="#">
    <div class="jerry">

        <div class="cat_img but_imgsize">
            <img src="<?php echo base_url();?>assets/images/doc.png">
        </div>

    </div>
</a>
</div>

<div class="col-md-3 col-12">
<a href="#">
    <div class="jerry">

        <div class="cat_img but_imgsize">
            <img src="<?php echo base_url();?>assets/images/doc.png">
        </div>


    </div>
</a>
</div>

<div class="col-md-3 col-12">
<a href="#">
    <div class="jerry">

        <div class="cat_img but_imgsize">
            <img src="<?php echo base_url();?>assets/images/doc.png">
        </div>

    </div>
</a>
</div>
</div>



</div>




<div class="col-md-4 col-12">

<div class="Qr-code">
<p> QR Code</p>
<a href="#">
<img src="<?php echo base_url();?>assets/images/code.png">
</a>
</div>
</div>

</div>
</div> -->
<!--Video-photo doc tab link close-->

<!--third tab link strat-->
<div class="tab-pane container <?php if(isset($_GET['msg']) && $_GET['msg'] == 1){ echo 'active';}else{}?>" id="menu6">
    <div class="row">
        <div class="col-md-9 col-12">
            <button class="scrol_loding">
                <img src="<?php echo base_url();?>assets/images/giphy.gif">
            </button>
            <div class="chat_box" id="indivisualChatBox">
                <div id="conversation" data-id="<?php echo $user_data->id; ?>" class="conversation">

                </div>

                <div id="messageerror"></div>
<!-- <form id="sendMessage" action="javascript:void(0)" method="post" enctype="multipart/form-data">
<div class="form-group"><textarea class="form-control tetx_bx check_empty" name="message" id="messageTextarea" placeholder="Type Something ..."></textarea><div class="input_error_msg">Please Write Something.</div>
<input type="hidden" value="<?php echo encoding($user_data->id); ?>" name="userid" id="user_id">
<a href="#">
<div class="icon_shap">
<img src="<?php echo base_url();?>assets/images/m1.png">
<img src="<?php echo base_url();?>assets/images/m2.png">
</div>
</a>
<button type="button" onclick="saveData('sendMessage','<?php echo site_url('user/sendmessage'); ?>','newconversation','messageerror')" class="sandss" id="SendMessageButton">Send</button>
</div>
</form> -->
<form id="sendMessage" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <textarea class="form-control tetx_bx check_empty" name="message" id="messageTextarea" placeholder="Type Something ..."></textarea>
        <div class="input_error_msg">Please Write Something.</div>
        <input type="hidden" value="<?php if(isset($user_data->id)){ echo encoding($user_data->id); } ?>" name="userid">

        <input type="hidden" value="<?php if(isset($user_data->id)){ echo ($user_data->id); } ?>" id="receiver" >

        <input type="hidden" value="<?php echo get_current_user_id();?>" id="sender" >

        <a href="#">
            <div class="icon_shap">
                <img src="<?php echo base_url();?>assets/images/m1.png">
                <img src="<?php echo base_url();?>assets/images/m2.png">
            </div>
        </a>
        <button type="button" onclick="saveMessage1()" class="sandss" id="SendMessageButton">Send</button>
    </div>
</form>
</div>

<ins class="adsbygoogle"
style="display:inline-block;width:468px;height:60px"
data-ad-client="ca-pub-3979824042791728"
data-ad-slot="9277170470"></ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>


</div>




<div class="col-md-3 col-12">

</div>


</div>
</div>

<!--third tab link close-->


</div>
</div>
</section>




<!-- The Modal start 22march -->
<div class="modal fade" id="myModal5">
    <div class="modal-dialog">
        <div class="modal-content crox">
            <!-- Modl Header -->
            <button type="button" class="close crox" data-dismiss="modal">&times;</button>
            <div id="ratings_"></div>
            <div id="ratings_fail"></div>

            <!-- <h1 class="Reviews0"><?php echo $reviewCount;?> Reviews</h1> -->
            <div class="witreview">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="mw">
                            <?php if(!empty($category_questions[0]['question']) && isset($category_questions[0]['question'])){ ?>
                                <ul>
                                    <form id="ratings">
                                        <li><input type="checkbox" name="anonymous" <?php echo (isset($anonymous->anonymous) && ($anonymous->anonymous==1))?'checked':''; ?> > Make review Anonymous</li>
                                        <li class="ful_cntant">
                                            <div class="howwas">
                                                <i class="fa fa-check"></i>
                                                <h2><?php echo $category_questions[0]['question']; ?></h2>
                                            </div>
                                            <?php 
                                            $array5 = array(5);
                                            $array4 = array(4,5);
                                            $array3 = array(3,4,5);
                                            $array2 = array(2,3,4,5);
                                            $array1 = array(1,2,3,4,5);
                                            ?>
                                            <div class="stars">

                                                <input class="star star-5" id="star-5" type="radio"  name="ques1" value="5"/>
                                                <label class="star star-5 <?php 
                                                if(isset($questionRating[0]) && in_array($questionRating[0],$array5)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-5"></label>
                                                <input class="star star-4" id="star-4" type="radio"  name="ques1" value="4"/>
                                                <label class="star star-4 <?php 
                                                if(isset($questionRating[0]) && in_array($questionRating[0],$array4)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-4"></label>
                                                <input class="star star-3" id="star-3" type="radio"  name="ques1" value="3"/>
                                                <label class="star star-3 <?php 
                                                if(isset($questionRating[0]) && in_array($questionRating[0],$array3)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-3"></label>
                                                <input class="star star-2" id="star-2" type="radio"  name="ques1" value="2"/>
                                                <label class="star star-2 <?php 
                                                if(isset($questionRating[0]) && in_array($questionRating[0],$array2)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-2"></label>
                                                <input class="star star-1" id="star-1" type="radio"  name="ques1" value="1"/>
                                                <label class="star star-1 <?php 
                                                if(isset($questionRating[0]) && in_array($questionRating[0],$array1)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-1"></label>

                                            </div>
                                        </li>

                                        <li class="ful_cntant">
                                            <div class="howwas">
                                                <i class="fa fa-check"></i>
                                                <h2><?php echo $category_questions[1]['question']; ?></h2>
                                            </div>
                                            <div class="stars">

                                                <input class="star star-5" id="star-6" type="radio"  name="ques2" value="5"/>
                                                <label class="star star-5 <?php 
                                                if(isset($questionRating[1]) && in_array($questionRating[1],$array5)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-6"></label>
                                                <input class="star star-7" id="star-7" type="radio" name="ques2" value="4"/>
                                                <label class="star star-7 <?php 
                                                if(isset($questionRating[1]) && in_array($questionRating[1],$array4)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-7"></label>
                                                <input class="star star-8" id="star-8" type="radio" name="ques2" value="3"/>
                                                <label class="star star-8 <?php 
                                                if(isset($questionRating[1]) && in_array($questionRating[1],$array3)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-8"></label>
                                                <input class="star star-9" id="star-9" type="radio" name="ques2" value="2"/>
                                                <label class="star star-9 <?php 
                                                if(isset($questionRating[1]) && in_array($questionRating[1],$array2)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-9"></label>
                                                <input class="star star-1" id="star-10" type="radio" name="ques2" value="1"/>
                                                <label class="star star-1 <?php 
                                                if(isset($questionRating[1]) && in_array($questionRating[1],$array1)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-10"></label>

                                            </div>
                                        </li>

                                        <li class="ful_cntant">
                                            <div class="howwas">
                                                <i class="fa fa-check"></i>
                                                <h2><?php echo $category_questions[2]['question']; ?></h2>
                                            </div>
                                            <div class="stars">

                                                <input class="star star-5" id="star-11" type="radio" name="ques3" value="5"/>
                                                <label class="star star-5 <?php 
                                                if(isset($questionRating[2]) && in_array($questionRating[2],$array5)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-11"></label>
                                                <input class="star star-12" id="star-12" type="radio" name="ques3" value="4"/>
                                                <label class="star star-12 <?php 
                                                if(isset($questionRating[2]) && in_array($questionRating[2],$array4)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-12"></label>
                                                <input class="star star-13" id="star-13" type="radio" name="ques3" value="3"/>
                                                <label class="star star-13 <?php 
                                                if(isset($questionRating[2]) && in_array($questionRating[2],$array3)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-13"></label>
                                                <input class="star star-14" id="star-14" type="radio" name="ques3" value="2"/>
                                                <label class="star star-14 <?php 
                                                if(isset($questionRating[2]) && in_array($questionRating[2],$array2)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-14"></label>
                                                <input class="star star-1" id="star-15" type="radio" name="ques3" value="1"/>
                                                <label class="star star-1 <?php 
                                                if(isset($questionRating[2]) && in_array($questionRating[2],$array1)){
                                                    echo 'feelin';
                                                }
                                                ?>" for="star-15"></label>

                                            </div>
                                        </li>

                                        <li class="ful_cntant">
                                            <div class="howwas">
                                                <i class="fa fa-check"></i>
                                                <h2><?php echo $category_questions[3]['question']; ?></h2>
                                            </div>
                                            <div class="stars">



                                             <input class="star star-5" id="star-16" type="radio" name="ques4" value="5"/>
                                             <label for="star-16" class="star star-5 <?php 
                                             if(isset($questionRating[3]) && in_array($questionRating[3],$array5)){
                                                echo 'feelin';
                                            }
                                            ?>"></label>


                                            <input name="ques4" class="star star-17" id="star-17" type="radio" value="4"/>
                                            <label class="star star-17 <?php 
                                            if(isset($questionRating[3]) && in_array($questionRating[3],$array4)){
                                                echo 'feelin';
                                            }
                                            ?>" for="star-17"></label>
                                            <input name="ques4" class="star star-18" id="star-18" type="radio" value="3"/>
                                            <label class="star star-18 <?php 
                                            if(isset($questionRating[3]) && in_array($questionRating[3],$array3)){
                                                echo 'feelin';
                                            }
                                            ?>" for="star-18"></label>
                                            <input name="ques4" class="star star-19" id="star-19" type="radio" value="2"/>
                                            <label class="star star-19 <?php 
                                            if(isset($questionRating[3]) && in_array($questionRating[3],$array2)){
                                                echo 'feelin';
                                            }
                                            ?>" for="star-19"></label>
                                            <input name="ques4" class="star star-1" id="star-20" type="radio" value="1"/>
                                            <label class="star star-1 <?php 
                                            if(isset($questionRating[3]) && in_array($questionRating[3],$array1)){
                                                echo 'feelin';
                                            }
                                            ?>" for="star-20"></label>

                                        </div>
                                    </li>

                                    <li class="ful_cntant">
                                        <div class="howwas">
                                            <i class="fa fa-check"></i>
                                            <h2><?php echo $category_questions[4]['question']; ?></h2>
                                        </div>
                                        <div class="stars">

                                            <input name="ques5" class="star star-5" id="star-21" type="radio" value="5"/>
                                            <label class="star star-5 <?php 
                                            if(isset($questionRating[4]) && in_array($questionRating[4],$array5)){
                                                echo 'feelin';
                                            }
                                            ?>" for="star-21"></label>
                                            <input name="ques5" class="star star-22" id="star-22" type="radio" value="4"/>
                                            <label class="star star-22 <?php 
                                            if(isset($questionRating[4]) && in_array($questionRating[4],$array4)){
                                                echo 'feelin';
                                            }
                                            ?>" for="star-22"></label>
                                            <input name="ques5" class="star star-23" id="star-23" type="radio" value="3"/>
                                            <label class="star star-23 <?php 
                                            if(isset($questionRating[4]) && in_array($questionRating[4],$array3)){
                                                echo 'feelin';
                                            }
                                            ?>" for="star-23"></label>
                                            <input name="ques5" class="star star-24" id="star-24" type="radio" value="2"/>
                                            <label class="star star-24 <?php 
                                            if(isset($questionRating[4]) && in_array($questionRating[4],$array2)){
                                                echo 'feelin';
                                            }
                                            ?>" for="star-24"></label>
                                            <input name="ques5" class="star star-1" id="star-25" type="radio" value="1"/>
                                            <label class="star star-1 <?php 
                                            if(isset($questionRating[4]) && in_array($questionRating[4],$array1)){
                                                echo 'feelin';
                                            }
                                            ?>" for="star-25"></label>

                                        </div>
                                    </li>
                                    <div class="form-group">
                                        <textarea autofocus="" class="form-control tetx_bx andbts check_empty" name="message" id="messageTextarea" placeholder="Type Something ..." maxlength="140"><?php echo isset($questionRating[5])?$questionRating[5]:'';?></textarea>
                                    </div>
                                    <p class="comntss"> Upto 140 characters only </p>
                                    <input type="hidden" id="rated_to" name="rated_to" value="<?php echo isset($user_data->id)?$user_data->id:'';?>">

                                    <button type="button" onclick="saveData('ratings','<?php echo site_url('profile/ratings')?>','messageBox','messageerror')" class="sandss" id="SendMessageButton">Send</button>
                                </form>
                            </ul>
                        <?php } else{ ?>
                            <h5>User does not belongs to any category!! No questions available.</h5>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-12">
                    <div class="review_start">

                    </div>
                </div>


            </div>
        </div>

    </div>
</div>
</div>
<!--model close-->
<!--profil close-->
<script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js"></script> 
<script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.5.1/firebase.js"></script> 
<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="<?php echo base_url();?>assets/lib/css/emoji.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/lib/js/config.js"></script>
<script src="<?php echo base_url();?>assets/lib/js/util.js"></script>
<script src="<?php echo base_url();?>assets/lib/js/jquery.emojiarea.js"></script>
<script src="<?php echo base_url();?>assets/lib/js/emoji-picker.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        getIndivisualMsg('<?php echo encoding($user_data->id) ?>','no_group');
    });
</script>

