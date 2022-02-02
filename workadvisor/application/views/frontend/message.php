<!--section log_inheder start-->
<style type="text/css">
    button.scrol_loding {
    display: block;
    position: absolute;
    margin: 188px;
    margin-top: 454px;
}
.pro_img{
    position: relative;
}

.login_status {
    position: absolute;
    height: 10px;
    width: 10px;
    border-radius: 100px;
    background: #59dc5b;
    top: 13px;
    right: 0px;
}
</style>
<section class="profile_tab">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12 pl_inlft">
                <div class="tab_list">
                    <div class="card">
                        <ul class="nav nav-tabs" role="tablist">
                            <!--  <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Notification</a></li> -->
                            <li role="presentation" class="bell notification_toggle">
                                <a> <i class="fa fa-bell" ></i><span class="rivew-bell notification_bell">0</span> Notification </a>
                                <ul id="notifications_ul"></ul>
                            </li>
                            <?php if(get_current_user_id()){ ?>
                                <li role="presentation">
                                    <a href="<?php echo base_url()?>user/favourites_list"> <i class="fa fa-heart" aria-hidden="true"></i> Favorites </a>
                                </li>
                            <?php } ?>
                            <!-- <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Create Category</a></li> -->
<!--   <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="modal" data-target="#myModal5" data-toggle="tab">
    <i class="fa fa-star-o"></i> Write review</a></li> -->
    <li role="presentation"><a  aria-controls="ShareProfile" role="tab" data-toggle="tab">
        <i class="fa fa-share-square-o"></i> Share Profile</a>
    </li>
    <div id="share-buttons" title="Share Profile">
        <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
            <!-- <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" /> -->
            <i class="fa fa-facebook"></i>
        </a>
        <a href="https://plus.google.com/share?url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
            <!-- <img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" /> -->
            <i class="fa fa-google-plus"></i>
        </a>
        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
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
<section class="paddingBtm60" >
    <input type="hidden" name="is_group" id="is_group" value="<?php if(isset($group) && $group == 1){ echo 'group'; } else{ echo ''; }?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12" style="margin-top:20px">
                <!--third tab link strat--> 
                <div class="tab-pane container" id="menu6">
                    <input type="hidden" id="base_url" value="<?php echo base_url();?>">
                    <div class="row" id="search_">
                        <div class="col-md-5 col-12">
                            <div class="serch_profile">
                                <form>
                                    <div class="form-group">
                                        <input type="search" name="search" class="form-control prile" placeholder="Search" id="searchName">
                                        <img src="<?php echo base_url();?>assets/images/shrc.png" class="po_right">
                                    </div>
                                    <ul id="friendsList">
                                        <?php 
                                        $allFriendsCount = 0;
                                        $friendsArray = array();
                                        $userID = get_current_user_id();
                                        if(!empty($allFriends)){

                                            foreach($allFriends as $frl){ 

                                                $allFriendsCount++;
                                                $group = 'group';
                                                $groupAppend = 'group_'.$frl->id;

                                                if(isset($frl->group) && $frl->group){
                                                    $group = 'no_group';

                                                    if($userID>$frl->id){
                                                        $chatBetween = $userID.'_'.$frl->id;
                                                    }else{
                                                        $chatBetween = $frl->id.'_'.$userID;
                                                    }
                                                    $groupAppend = $chatBetween;
                                                }

                                                $friendsArray[] = $groupAppend;

                                                ?>
                                                <li onclick="getIndivisualMsg('<?php echo encoding($frl->id); ?>','<?php echo $group;?>')" class="chatuser <?php if(isset($other_user) && $other_user==$frl->id){ echo "activechat"; }?>  <?php echo $groupAppend;?>" id="friendlistmenu<?php echo $frl->id; ?>" data-lid="<?php echo $frl->id; ?>" data-gtype="<?php echo $group;?>">
                                                    <div class="pro_img">
                                                        <img src="<?php 
                                                        if(!empty($frl->profile) && $frl->profile!='assets/images/default_image.jpg' )

                                                        {

                                                            echo $frl->profile;

                                                            }else{

                                                                echo base_url().DEFAULT_IMAGE;

                                                            }

                                                            ?>
                                                            " alt="<?php echo strtoupper(substr(isset($frl->firstname)?$frl->firstname:$frl->business_name,0,1)); ?>" style="width: 40px;border-radius: 20px;">

                                                            <?php 
                                                            if($frl->login_status == 1){
                                                            ?>
                                                            <div class="login_status"></div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="pro_img comt">
                                                            <h1><?php if($frl->business_name!='' && isset($frl->business_name)){
                                                                echo ucfirst($frl->business_name);

                                                            }else{

                                                                echo ucfirst($frl->firstname).' '.ucfirst($frl->lastname);

                                                            } ?></h1>
                                                            <p id="latestMessage_<?php echo $frl->id; ?>"></p>
                                                            <span class="cuircl"> </span>
                                                        </div>
                                                        <div class="pro_img fl_ri">
                                                            <?php 
                                                           // if($allFriendsCount != 1){ 
                                                                ?>
                                                                <span class="notificationCircle  latestMessageCount_<?php echo $frl->id; ?>"></span>
                                                            <?php 
                                                        //} ?>
                                                        </div>
                                                        <?php if((isset($frl->owner_id) && $frl->owner_id == get_current_user_id())){ ?>
                                                            <!-- <i class="fa fa-close" data-toggle="modal" data-target="#modalDelete" onclick="setDeleteID(<?php echo $frl->id;?>);"></i> -->
                                                            <i class="fa fa-pencil modalEdit" data-toggle="modal" data-target="#modalEdit" onclick="setGroupID(<?php echo $frl->id;?>);"></i>
                                                        <?php }else if(!isset($frl->owner_id)){ ?>
                                                            <!-- <i class="fa fa-close" data-toggle="modal" data-target="#modalDelete" onclick="setID(<?php echo $frl->id;?>);"></i> -->
                                                        <?php } 
                                                        if($group == 'group'){?>
                                                            <i class="fa fa-eye" data-toggle="modal" data-target="#modalView"></i>
                                                        <?php } ?>
                                                    </li>
                                                <?php }
                                                if(!empty($friendsArray)){
                                                    $friendsArray1 = json_encode($friendsArray);
                                                }else{
                                                    $friendsArray1 = array();   
                                                }
                                                ?>
                                                <input type="hidden" id="friendsArray" value='<?php echo $friendsArray1;?>'>
                                            <?php } ?>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                            <div id="modalDelete" class="modal fade">
                                <div class="modal-dialog modal-confirm">
                                    <div class="modal-content">
                                        <div id="success"></div>
                                        <div class="modal-header">
                                            <h4 class="modal-title">Are you sure?</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body delete_grp">
                                            <p>Do you really want to delete this message ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="record_id">
                                            <input type="hidden" id="group" name="group" value="">
                                            <input type="hidden" id="current_user" name="current_user" value="<?php echo get_current_user_id();?>">
                                            <input type="hidden" id="delete_url" value="<?php echo base_url() ?>user/deleteMessage">
                                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-danger" onclick="deleteMessage()">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="modalView" class="modal fade">
                                <div class="modal-dialog modal-confirm">
                                    <div class="modal-content">
                                        <div id="success"></div>
                                        <div class="modal-header">
                                            <h4 class="modal-title">Group Members</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body delete_grp">
                                            <p id="usersList"></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modalEdit" role="dialog">
                                <div class="modal-dialog">
                                    <form action="<?php echo base_url()?>user/create_group" method="post"  enctype="multipart/form-data">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Group</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="text" class="form-control" name="group_name" placeholder="Group Name" id="group_name" required="">
                                                <input type="hidden" id="g_id" name="g_id">
                                                <select class="form-control contacts" id="group_members" name="group_members[]"  multiple="multiple" style="width: 466px;" required="">
                                                    <?php if(!empty($contactsData)){
                                                        foreach($contactsData as $row){ ?>
                                                            <option value="<?php echo $row['id'];?>"><?php echo ucwords($row['name']);?></option>
                                                        <?php }
                                                    } ?>
                                                </select>
                                                <!-- <input type="file" name="group_profile" class="form-control"> -->
                                                <!-- <img src="" id="group_icon" height="20%" width="20%">  -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-info">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-7 col-12" class="msgAds">
                                <input type="button" class="btn btn-info" value="Create Group" data-toggle="modal" data-target="#myModal"><br/>
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog">
                                        <form action="<?php echo base_url()?>user/create_group" method="post"  enctype="multipart/form-data">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Group</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="text" class="form-control" name="group_name" placeholder="Group Name" id="group_name" required="">
                                                    <select class="form-control contacts" id="group_members1" name="group_members[]"  multiple="multiple" style="width: 466px;" required="">
                                                        <?php if(!empty($contactsData)){
                                                            foreach($contactsData as $row){ ?>
                                                                <option value="<?php echo $row['id'];?>"><?php echo ucwords($row['name']);?></option>
                                                            <?php }
                                                        } ?>
                                                    </select>
                                                    <!-- <input type="file" name="group_profile" class="form-control"> -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-info">Create</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <button class="scrol_loding">
                                    <img src="<?php echo base_url();?>assets/images/giphy.gif">
                                </button>
                                <div class="chat_box" id="indivisualChatBox">
                                    <div id="conversation" class="conversation">
                                    </div>
                                    <div id="messageerror"></div>
                                    <form id="sendMessage" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <textarea class="form-control tetx_bx check_empty" name="message" id="messageTextarea" placeholder="Type Something ..."></textarea>
                                            <div class="input_error_msg">Please Write Something.</div>
                                            <input type="hidden" value="<?php if(isset($other_user)){ echo encoding($other_user); } ?>" name="userid">

                                            <input type="hidden" value="<?php if(isset($other_user)){ echo ($other_user); } ?>" id="receiver" >

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
                        </div>
                    </div>
                    <!--third tab link close--> 
                </div>
            </div>
        </div>
    </section>

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
        $( document ).ready(function() {
            $('.activechat').trigger('click');
        });
    </script>