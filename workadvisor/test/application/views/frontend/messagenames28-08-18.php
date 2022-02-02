
<?php if(!empty($allFriends)){ foreach($allFriends as $frl){ ?>
         <li onclick="getIndivisualMsg('<?php echo encoding($frl['id']); ?>')" class="chatuser <?php if(isset($user_data->id) && $user_data->id==$frl['id']){ echo "activechat"; }?>" id="friendlistmenu<?php echo $frl['id']; ?>">
         <div class="pro_img">
           <img src="<?php echo (!empty($frl['profile']))? $frl['profile']:DEFAULT_IMAGE; ?>" alt="<?php echo strtoupper(substr($frl['firstname'],0,1)); ?>" style="width: 40px;border-radius: 20px;">
         </div>
          <div class="pro_img comt">
              <h1><?php 
              if($frl['business_name']!='' && isset($frl['business_name'])){
                echo $frl['business_name'];
              }else{
                echo $frl['firstname'].' '.$frl['lastname'];
              } ?></h1>
              
              <p id="latestMessage_<?php echo $frl['id']; ?>"></p>
          <span class="cuircl"> </span>
          </div>
          <div class="pro_img fl_ri">
            <span class="" id="latestMessageCount_<?php echo $frl['id']; ?>"></span>
          </div>
            <i class="fa fa-close" data-toggle="modal" data-target="#modalDelete" onclick="setID(<?php echo $frl['id'];?>);"></i>
         </li>
     <?php } }else{ ?>
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