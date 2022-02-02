<?php
if(!empty($conversation['result'])){
    $alreadyDiplayedMessages = array();
$allmessages=array_reverse($conversation['result']);
$alreadyDiplayedMessages = $this->session->userdata('messages');
	foreach($allmessages as $msgs){ 
        if(!in_array($msgs->msg_id,$alreadyDiplayedMessages)){
            $alreadyDiplayedMessages[] =  $msgs->msg_id;
 ?>
	<input type="hidden" class="topId" name="msgid" value="<?php echo $msgs->msg_id; ?>" >
            <?php if($msgs->sender == get_current_user_id()){ ?>
            <div class="fil_ds wid_ri">
                <a href="<?php echo base_url()?>viewdetails/profile/<?php echo encoding($msgs->sender);?>">
                    <div class="pro_img">
                        <img src="<?php echo (!empty($msgs->profile))? $msgs->profile:DEFAULT_IMAGE; ?>" alt="<?php echo strtoupper(substr($msgs->firstname,0,1)); ?>" style="width: 40px;border-radius: 20px;">
                    </div>
                </a>
                <div class="msg_bx bg_chng">
                    <b>
                        <?php 
                        if(!empty($msgs->business_name)){
                            echo ucwords($msgs->business_name);
                        }else{
                            echo ucwords($msgs->firstname.' '.$msgs->lastname);
                        }
                        ?>
                    </b>
                   <pre> <?php echo $msgs->message;  ?> </pre>
                </div>
                <span class="date">
            <?php echo date('M-d-Y h:i A',strtotime($msgs->message_date));  ?>
          </span>
            </div>
            <?php }else{ ?>
            <div class="fil_ds">
                <a href="<?php echo base_url()?>viewdetails/profile/<?php echo encoding($msgs->sender);?>">
                    <div class="pro_img">
                        <img src="<?php echo (!empty($msgs->profile))? $msgs->profile:DEFAULT_IMAGE; ?>" alt="<?php echo strtoupper(substr($msgs->firstname,0,1)); ?>" style="width: 40px;border-radius: 20px;">
                    </div>
                </a>
                <div class="msg_bx ">
                    <b>
                        <?php 
                        if(!empty($msgs->business_name)){
                            echo ucwords($msgs->business_name);
                        }else{
                            echo ucwords($msgs->firstname.' '.$msgs->lastname);
                        }
                        ?>
                    </b>
                    <pre><?php echo $msgs->message;  ?></pre> </div>
                <span class="date">
                <?php echo date('M-d-Y h:i A',strtotime($msgs->message_date));  ?>
                </span>
            </div>
            <?php } } 
        } 
        $this->session->set_userdata('messages',$alreadyDiplayedMessages);
    } ?>

            