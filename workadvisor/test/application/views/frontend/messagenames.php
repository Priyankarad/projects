
<?php if(!empty($allFriends)){ foreach($allFriends as $frl){ 
  $group = 'group';
  if(isset($frl->group) && $frl->group){
    $group = 'no_group';
  }
  ?>
  <li onclick="getIndivisualMsg('<?php echo encoding($frl->id); ?>','<?php echo $group;?>')" class="chatuser <?php if(isset($user_data->id) && $user_data->id==$frl->id){ echo "activechat"; }?>" id="friendlistmenu<?php echo $frl->id; ?>" data-lid="<?php echo $frl->id; ?>" data-gtype="<?php echo $group;?>">
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
       <span class="latestMessageCount_<?php echo $frl->id; ?> <?php if(!empty($frl->msg_count) && $frl->msg_count!=0){ echo 'cuircl2'; }?>"><?php if(!empty($frl->msg_count) && $frl->msg_count!=0){ echo $frl->msg_count; }?></span>
     </div>
     <!-- <i class="fa fa-close" data-toggle="modal" data-target="#modalDelete" onclick="setID(<?php echo $frl->id;?>);"></i> -->
     <?php if((isset($frl->owner_id) && $frl->owner_id == get_current_user_id())){ ?>
      <!-- <i class="fa fa-close" data-toggle="modal" data-target="#modalDelete" onclick="setID(<?php echo $frl->id;?>);"></i> -->
      <i class="fa fa-pencil" data-toggle="modal" data-target="#modalEdit" onclick="setID(<?php echo $frl->id;?>);"></i>
    <?php }else if(!isset($frl->owner_id)){ ?>
      <!-- <i class="fa fa-close" data-toggle="modal" data-target="#modalDelete" onclick="setID(<?php echo $frl->id;?>);"></i> -->
    <?php } 

    if($group == 'group'){?>
    <i class="fa fa-eye" data-toggle="modal" data-target="#modalView"></i>
  <?php } ?>
  </li>
<?php 
}} else{ ?>
  <li>No results found</li>
<?php }
?>

<div id="modalDelete" class="modal fade">
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div id="success"></div>
      <div class="modal-header">        
        <h4 class="modal-title">Are you sure?</h4>  
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete this message ?</p>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="record_id">
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