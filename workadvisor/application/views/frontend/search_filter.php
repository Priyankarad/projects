<?php
if(!empty($results )){ $count =0; foreach($results as $row){

    if($row->id!=get_current_user_id()){
        $count++;
        $userProfileUrl = base_url('viewdetails/profile/'.encoding($row->id));
        $title=$row->firstname.' '.$row->lastname;
        if($row->user_role=='Employer' && $row->user_role!=""){
            $title=$row->business_name;
        }

        ?>
        <div class="Donald_Boyd row">
            <div class="col-md-3">
                <a href="<?php echo $userProfileUrl; ?>">
                    <div class="main_kv">
                        <img src="<?php echo (!empty($row->profile) && $row->profile!='assets/images/default_image.jpg') ? $row->profile : base_url().DEFAULT_IMAGE; ?>">
                    </div>
                </a>
            </div>
            <div class="col-md-7">
                <div class="Donald_contnt">
                    <div class="img_id">
                        <a href="<?php echo $userProfileUrl; ?>">
                            <h1><?php echo ucwords($title); ?></h1>
                        </a>
                        <p><?php 
                        $address = array();
                        if(isset($row->city) && !empty($row->city))
                            $address[] = trim($row->city);
                        if(isset($row->state) && !empty($row->state))
                            $address[] = trim($row->state);
                        if(isset($row->country) && !empty($row->country))
                            $address[] = trim($row->country);
                        if(isset($row->zip) && !empty($row->zip))
                            $address[] = trim($row->zip);
                        if(!empty($address)){
                            $address = implode(", ", $address);
                            echo $address;
                        }
// $row->city.', '.$row->state.', '.$row->country.' '.$row->zip; ?></p>
</div>
<div class="strt">
    <?php 
    if($row->user_role!='Employer'){
        $ratingData =  userOverallRatings($row->id);
        if(isset($ratingData['starRating'])){
            echo $ratingData['starRating'];
        }
    }
    ?>
</div>
</div>
</div>
<div class="col-md-2">
    <div class="main_3btn donald">
        <?php 
        if($row->user_role=='Employer'){ 

            if($userRole == 'Employer'){ 
            }
            else{  
                if(get_current_user_id()){
                    $userOne=get_current_user_id();
                    $userTwo=$row->id;
                    $isRequest=checkRequest($userOne,$userTwo);
                    $requestedByUser = jobRequestedBy($userOne,$row->id);
                    if($requestedByUser != $userOne && $requestedByUser!=0 && $isRequest!='Accepted'){
                        $isRequest = 'NotConfirm';
                    }
                }else{
                    $isRequest="No";  
                }
                if($isRequest=='No'){ ?>
                    <button class="btn btn-info btn-sm" class="jBrQ" onclick="sendJobRequest('<?php echo encoding($row->id); ?>',this)" >
                        <i class="fa fa-plus"></i> Job Request
                    </button>
                <?php }
                else if($isRequest=='NotConfirm'){ 
                    $senderID = get_current_user_id();
                    $requestedByUser = jobRequestedBy($senderID,$row->id);
                    ?>
                    <?php if($requestedByUser != $senderID && $requestedByUser!=0){ ?>
                        <button class="btn btn-info btn-sm" class="jBrQ" onclick="jobRequest('<?php echo encoding($row->id); ?>','Accept','<?php echo 'FR'.$row->id; ?>',this,'per')" >
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
        }else{
            if($userRole == 'Employer'){ 
                if(get_current_user_id()){
                    $userOne=get_current_user_id();
                    $userTwo=$row->id;
                    $isRequest=checkRequest($userOne,$userTwo);
                }else{
                    $isRequest="No";  
                }
                if($isRequest=='No'){ ?>
                    <button class="btn btn-info btn-md" class="jBrQ" onclick="sendJobRequest('<?php echo encoding($row->id); ?>',this,'emp');" >
                        <i class="fa fa-plus"></i> Job Request
                    </button>
                <?php }else if($isRequest=='NotConfirm'){
                    $senderID = get_current_user_id();
                    $requestedByUser = jobRequestedBy($row->id,$senderID);
                    ?>
                    <?php if($requestedByUser != $senderID && $requestedByUser!=0){ ?>
                        <button class="btn btn-info btn-sm" class="jBrQ" onclick="jobRequest('<?php echo encoding($row->id); ?>','Accept','<?php echo 'FR'.$row->id; ?>',this)" >
                            <i class="fa fa-plus"></i> Accept Request 
                        </button>
                    <?php }else{ ?>
                        <button class="btn btn-info btn-sm" class="jBrQ" >
                            <i class="fa fa-clock-o" aria-hidden="true"></i>  Pending
                        </button>
                    <?php } 
                    ?>
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
                    $userTwo=$row->id;
                    $isFriend=checkFriend($userOne,$userTwo);
                }else{
                    $isFriend="No"; 
                }

                if($isFriend=='No'){ ?>
                    <div class="Chery3">
                        <!-- <i class="fa fa-plus"></i> -->
                        <a onclick="addfriend('<?php echo encoding($row->id); ?>',this)" href="javascript:void(0)"><i class="fa fa-plus"></i> Add Friend</a>
                    </div>
                <?php }else if($isFriend=='NotConfirm'){ ?>
                    <div class="Chery3">
                        <i class="fa fa-plus"></i>
                        <a href="javascript:void(0)" onclick="friendRequest('<?php echo encoding($row->id); ?>','Accept','<?php echo 'FR'.$row->id; ?>')"> Confirm</a>
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

        
        <div class="Chery3 send_btn donal">
            <a href="<?php echo $userProfileUrl."?msg=1"; ?>">
                Send Message
            </a>
        </div>
        <?php 
        $isFavourite = '';
        if(get_current_user_id()){
            $isFavourite = isFavourite(get_current_user_id(),$row->id);
        }
        if($isFavourite == '' || $isFavourite == 'no'){
            ?>
            <div class="Chery3 send_btn donal">
                <span  class="favourites unfavorites_wa" data-other_id = "<?php echo isset($row->id)?$row->id:'';?>">
                    <i class="fa fa-heart-o" aria-hidden="true"></i> 
                    Add to favorites
                </span>
            </div>
        <?php }else{ ?>
            <div class="Chery3 send_btn donal">
                <span  class="favourites favorites_wa" data-other_id = "<?php echo isset($row->id)?$row->id:'';?>"> 
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    Favorite
                </span>
            </div>

        <?php } ?>

    </div>
</div>
</div>
<?php } } 
if($count == 0){ ?>
    <div class="alert alert-danger">
        <strong>Oops!</strong> No Result Found.
    </div>
<?php }
} else{ ?>
    <div class="alert alert-danger">
        <strong>Oops!</strong> No Result Found.
    </div>
<?php } ?>
<!--second stat-->

<script type="text/javascript">
    $('.favourites').click(function(){
        var other_id = $(this).data('other_id');
        var _this = $(this);
        $.ajax({
            url:site_url+"/user/addToFavourite",  
            method:"POST",  
            dataType:'json',
            data:{other_id:other_id},  
            success:function(data){
                if(data.status==1){
                    $(_this).html('Favorite');
                }else if(data.status==2){
                    $(_this).html('Add to favorites');
                }
            }  
        });
    });
</script>