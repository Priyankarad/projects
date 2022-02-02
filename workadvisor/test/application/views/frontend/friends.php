    <div class="main_div_width">
        <div class="row">
            <div class="col-md-7 col-12">

                <h2 class="Cher">Friend Requests</h2>
                <?php
                if(!empty($pendingRequest)){ $a=1; foreach($pendingRequest as $req){if($req['user_role'] == 'Employer'){
                    $userProfileUrl = site_url('viewdetails/profile/'.encoding($req['id'])."?type=emp");
                } 
                else{
                    $userProfileUrl = site_url('viewdetails/profile/'.encoding($req['id']));
                }
                if($a%2==1){ echo '<ul class="new_friends">';}
                ?>
                <li id="<?php echo 'FR'.$req['id']; ?>">
                    <div class="jerry">
                        <h1><?php 

                        if(isset($req['business_name']) && $req['business_name']!='')
                            echo $req['business_name'];
                        else
                            echo $req['firstname'].' '.$req['lastname']; ?></h1>
                        <a href="<?php echo $userProfileUrl; ?>">
                            <div class="cat_img">
                                <img src="<?php echo (!empty($req['profile']))? $req['profile']:DEFAULT_IMAGE; ?>" alt="<?php echo $req['firstname'].' '.$req['lastname']; ?>" alt="">
                            </div>
                        </a>
                        <p><?php echo $req['city'].', '.$req['state'].', '.$req['country']; ?></p>
                        <p>
                            <?php if($req['user_role'] == 'Employer'){ ?>
                                <button class="btn btn-sm btn-success" onclick="jobRequest('<?php echo encoding($req['id']); ?>','Accept','<?php echo 'FR'.$req['id']; ?>',this,'per')">Accept</button>
                                &nbsp; <button class="btn btn-sm btn-danger" onclick="jobRequest('<?php echo encoding($req['id']); ?>','Reject','<?php echo 'FR'.$req['id']; ?>',this,'per')">Reject</button>
                            <?php }else{ ?>
                                <button class="btn btn-sm btn-success" onclick="friendRequest('<?php echo encoding($req['id']); ?>','Accept','<?php echo 'FR'.$req['id']; ?>')">Accept</button> &nbsp; <button class="btn btn-sm btn-danger" onclick="friendRequest('<?php echo encoding($req['id']); ?>','Reject','<?php echo 'FR'.$req['id']; ?>')">Reject</button>
                            <?php } ?>

                        </p>
                        <?php $userRating = userOverallRatings($req['id']);
                        if(!empty($userRating['starRating'])){

                            echo preg_replace("/\([^)]+\)/","",$userRating['starRating']);
                        }
                        ?>
                    </div>
                </li> 

                <?php if($a%2==0){ echo '</ul>';}
                $a++;
            } } ?>
        </div>



       
        <div class="col-md-5 col-sm-5 col-12">
            <h2 class="cher">Search Friends</h2>
            <div class="serch-fn-up">
<div class="ml-tz e-ml bordr" data-toggle="modal" data-target="#emailmodalone">
    <p><i class="fa fa-envelope"></i>In Your Email Contacts</p>
</div>
<div class="invt-tz in-te bordr">
    <a href="<?php echo base_url()?>user/invite_gmail_contacts">
        <p><i class="fa fa-user-plus"></i> Invite Friends to WorkAdvisor</p>
    </a>
</div> 
</div> 



<div class="thre-popup">
    <div class="modal fade" id="fbmodalone">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <h4 class="modal-title">adding your Facebook friends to WorkAdvisor. </h4>
                <div class="modal-body">
                    <div class="only-bkvlr">
                        <p class="emil-cntnt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="emailmodalone">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <h4 class="modal-title">Send Invites</h4>
                <div class="modal-body">
                    <div class="only-bkvlr">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-12">
                                <div class="imgs-emil mail-img-click">
                                    <a href="https://accounts.google.com/o/oauth2/auth?client_id=252607257150-kr5at3658jl7mtoef6boer0ign6ue3fk.apps.googleusercontent.com&redirect_uri=https://workadvisor.co/user/google&scope=https://www.google.com/m8/feeds/&response_type=code">
                                        <img src="<?php echo base_url();?>assets/images/b3c993e.png">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-12">
                                <div class="imgs-emil mail-img-click">
                                    <a href="<?php echo isset($yahooURL)?$yahooURL:'';?>" ><img src="<?php echo base_url();?>assets/images/yahoo.png"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
            </div>
        </div>
    </div>


    <div class="modal fade" id="invitemodalone">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <h4 class="modal-title">Send WorkAdvisor Invites To These Email Addresses.</h4>
                <div class="modal-body">
                    <div class="only-bkvlr" >
                        <form method="post" action="<?php echo base_url();?>user/send_invitation">
                            <div id="friend_invitation2" >
                                <div class="form-group">
                                    <input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
                                </div>
                                <a class="emil-cntnt" style="cursor: pointer;" onclick = "addMore(2);">add another email address</a>
                            </div>
                            <button type="submit" class="invite-emil find">invitation email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>


<div class="bor_btm"></div>

<div class="row mar_tp F_allfnds">
    <h2 class="Cher">All Friends</h2>
    <?php
    $a=0;
    if(!empty($allFriends)){  foreach($allFriends as $frie){ 
        if($frie['user_role']!='Employer'){
            $a++;
            $userProfileUrl1 = site_url('viewdetails/profile/'.encoding($frie['id']));
            ?>
            <div class="col-md-3 col-6 my_allfloatsF" id="<?php echo 'AF'.$frie['id']; ?>">
                <div class="jerry">
                    <h1><?php 
                    if(isset($frie['business_name']) && $frie['business_name']!=''){
                        echo $frie['business_name'];
                    }else{
                        echo $frie['firstname'].' '.$frie['lastname'];
                    } ?></h1>
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
                    <p>
                        <?php if($frie['user_role']!='Employer'){?>
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalUnfriend" onclick="setFriendID(<?php echo $frie['id']?>)">Unfriend</button> &nbsp; <button class="btn btn-sm btn-danger" onclick="friendRequest('<?php echo encoding($frie['id']); ?>','Block','<?php echo 'AF'.$frie['id']; ?>')">Block</button>
                        <?php } ?>
                    </p>
                    <?php $userRating = userOverallRatings($frie['id']);
                    if(!empty($userRating['starRating'])){

                        echo preg_replace("/\([^)]+\)/","",$userRating['starRating']);
                    }
                    ?>
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

<div class="row mar_tp F_allfnds">
    <h2 class="Cher">Working At</h2>
    <?php
    $a=0;
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
                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalLeave" onclick="setFriendID(<?php echo $frie['id']?>)">Leave Job</button>
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

</div>