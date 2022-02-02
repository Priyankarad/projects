
    <div id="conversation" data-id="<?php echo $user_data->id; ?>" class="conversation">
	 <div id="oldconversation">

      </div>
        <?php
if(!empty($conversation['result'])){
$allmessages=array_reverse($conversation['result']);
	foreach($allmessages as $msgs){  ?>
	<input type="hidden" name="msgid" id="topId" value="<?php echo $msgs->id; ?>" >
            <?php if($msgs->sender == get_current_user_id()){ ?>
            <div class="fil_ds wid_ri">
                <a href="<?php echo base_url()?>viewdetails/profile/<?php echo encoding($msgs->sender);?>">
                    <div class="pro_img">
                        <img src="<?php echo (!empty($personal_data->profile))? $personal_data->profile:DEFAULT_IMAGE; ?>" alt="<?php echo strtoupper(substr($personal_data->firstname,0,1)); ?>" style="width: 40px;border-radius: 20px;">
                    </div>
                </a>
                <div class="msg_bx bg_chng">
                    <pre>
                    <?php echo $msgs->message;  ?></pre>
                </div>
                <span class="date">
            <?php echo date('M-d-Y h:i A',strtotime($msgs->message_date));  ?>
          </span>
            </div>
            <?php }else{ ?>
            <div class="fil_ds">
                <a href="<?php echo base_url()?>viewdetails/profile/<?php echo encoding($msgs->sender);?>">
                    <div class="pro_img">
                        <img src="<?php echo (!empty($user_data->profile))? $user_data->profile:DEFAULT_IMAGE; ?>" alt="<?php echo strtoupper(substr($user_data->firstname,0,1)); ?>" style="width: 40px;border-radius: 20px;">
                    </div>
                </a>
                <div class="msg_bx ">

                   <pre> <?php echo $msgs->message;  ?> </pre></div>
                <span class="date">
                <?php echo date('M-d-Y h:i A',strtotime($msgs->message_date));  ?>
                </span>
            </div>
            <?php } } } ?>
            <div id="newconversation">

            </div>
    </div>

    <div id="messageerror"></div>
    <form id="sendMessage" action="javascript:void(0)" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <textarea class="form-control tetx_bx check_empty" name="message" onkeyup="sendOnKeyup(event)" id="messageTextarea" placeholder="Type Something ...">
</textarea>
            <div class="input_error_msg">Please Write Something.</div>
            <input type="hidden" value="<?php echo encoding($user_data->id); ?>" name="userid">
            <a href="#">
                <div class="icon_shap">
                    <img src="<?php echo base_url();?>assets/images/m1.png">
                    <img src="<?php echo base_url();?>assets/images/m2.png">
                </div>
            </a>
            <button type="button" onclick="saveData('sendMessage','<?php echo site_url('user/sendmessage'); ?>','newconversation','messageerror')" class="sandss" id="SendMessageButton">Send</button>
        </div>
    </form>
