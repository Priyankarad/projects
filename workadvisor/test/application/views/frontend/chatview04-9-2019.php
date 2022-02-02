
<div id="conversation" data-id="<?php if(isset($other_user)){ echo $other_user; } ?>" class="conversation">
    <input type="hidden" name="is_group" id="is_group" value="<?php if(isset($group) && $group == 1){ echo 'group'; } else{ echo ''; }?>">
    <div id="oldconversation">

    </div>
    <?php
    if(!empty($conversation['result'])){
        $allmessages=array_reverse($conversation['result']);
        foreach($allmessages as $msgs){  ?>
            <input type="hidden" name="msgid" class="topId" value="<?php echo $msgs->msg_id; ?>" >
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
                        <textarea class="form-control tetx_bx check_empty" name="message" id="messageTextarea" placeholder="Type Something ...">
                        </textarea>
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
                        <button type="button" onclick="saveMessage1();" class="sandss" id="SendMessageButton">Send</button>
                    </div>
                </form>
                <script type="text/javascript">
                    var is_group = $('#is_group').val();
                    $(document).ready(function(){
                        autoscrollnow('conversation');
                    });
                    function autoscrollnow(classofdiv){
                        $('.'+classofdiv).animate({
                            scrollTop: $('.'+classofdiv).get(0).scrollHeight}, 2000);
                    }
                    function callpreviouse(){
                        if($(".conversation").scrollTop()==0){
                            var topid=$('.topId').val();
                            var userId=$("#conversation").attr("data-id");
                            getoldermessage(topid,userId);
                            $("#conversation").scrollTop(1);
                        } 
                    }

                    $(".conversation").scroll(function(){
                        if($(".conversation").scrollTop()==0){
                            console.log($(".conversation").scrollTop());
                            var topid=$('.topId').val();
                            var userId=$("#conversation").attr("data-id");
                            getoldermessage(topid,userId)

                            $("#conversation").scrollTop(1); 
                        }  
                    });

                    function getoldermessage(topid,userId){
                        $('.serch_profile').find(".chatuser").removeClass('activechat');  
                        $.ajax({
                            type:'POST',
                            url:site_url+'/user/indivisualMessageOld',
                            data: {userid:userId,top_id:topid,group:is_group},
                            dataType: 'json',
                            success:function(res){
// $('.topId').remove();
$('.conversation').prepend(res.msg);
$('#friendlistmenu'+res.userid).addClass('activechat');
$(".latestMessageCount_"+res.userid).html('');
$(".latestMessageCount_"+res.userid).removeClass('cuircl2');
if(res.msg!=""){
    $('#chatBox').scrollTop(30);
}
},
error:function(){
    $(".loader").css("transform", 'scale(0)'); 
    alert('An error has occurred');
}
});  
                    }
                </script>