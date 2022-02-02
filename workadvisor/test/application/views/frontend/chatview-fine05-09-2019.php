<input type="hidden" name="is_group" id="is_group" value="<?php if(isset($group) && $group == 1){ echo 'group'; } else{ echo ''; }?>">
<div id="conversation" data-id="<?php if(isset($other_user)){ echo $other_user; } ?>" class="conversation">
    <?php
    $allUserData = !empty($allUserData)?json_encode($allUserData):'';
    ?>
    <input type="hidden" id="usersData" value='<?php echo $allUserData;?>'>
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
                            <pre> <?php echo $msgs->message;  ?> 
                        </pre>
                    </div>
                    <span class="date">
                        <?php echo date('M-d-Y h:i A',strtotime($msgs->message_date));  ?>
                    </span>
                </div>
            <?php }
        } 
    } ?>
</div>

<div id="messageerror"></div>


<form id="sendMessage" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <textarea class="form-control tetx_bx check_empty" name="message" id="messageTextarea" placeholder="Type Something ..."></textarea>
        <div class="input_error_msg">Please Write Something.</div>
        <input type="hidden" value="<?php if(isset($other_user)){ echo ($other_user); } ?>" id="receiver" >
        <!-- <input type="hidden" value="<?php if(isset($other_user)){ echo encoding($other_user); } ?>" id="encoded_receiver" > -->
        <input type="hidden" value="<?php echo get_current_user_id();?>" id="sender" >
        <a href="#">
            <div class="icon_shap">
                <img src="<?php echo base_url();?>assets/images/m1.png">
                <img src="<?php echo base_url();?>assets/images/m2.png">
            </div>
        </a>
        <button type="button" onclick="saveFirebaseMessage();" class="sandss" id="SendMessageButton">Send</button>
    </div>
</form>

<script> 
    var lat = '';
    var lng = '';
    var messageDate = new Date().toLocaleString('en-US');
    if ("geolocation" in navigator){
        navigator.geolocation.getCurrentPosition(function(position){ 
            lat = position.coords.latitude;
            lng = position.coords.longitude;
        });
    }else{
        console.log("Browser doesn't support geolocation!");
    }


    var firebaseConfig = {
        apiKey: "AIzaSyDsWzwATbwIRvz6DYq2Mp4ZCvlZ1cmWZWk",
        authDomain: "workadvisor-d1c17.firebaseapp.com",
        databaseURL: "https://workadvisor-d1c17.firebaseio.com",
        projectId: "workadvisor-d1c17",
        storageBucket: "",
        messagingSenderId: "1028409820829",
        appId: "1:1028409820829:web:242835cb5126953d"
    };


    if (!firebase.apps.length) {
        firebase.initializeApp(firebaseConfig);
    }
    var database = firebase.database();

    var firebaseRef = new Firebase("https://workadvisor-d1c17.firebaseio.com");
    firebaseRef.child('messages').on('value', function(connectedSnap) {
        if (connectedSnap.val() === true) {
        } else {

        }
    });

    /*To fetch chat between two users*/
    var receiver = $('#receiver').val();
    var sender = $('#sender').val();
    var is_group = $('#is_group').val();
    var usersData = $('#usersData').val();
    var usersData1=JSON.parse(usersData);
    var chat;
    if(is_group!=''){
        chat = 'group_'+receiver;
    }else{
        if(sender>receiver){
            chat = sender+'_'+receiver;
        }else{
            chat = receiver+'_'+sender;
        }
    }
    var senderName = '';
    var profileImg = '';
    var msgHTML = '';
    firebase.database().ref('messages/'+chat).on('child_added', function(snapshot) {
        var chats = snapshot.val();
        var snapKey = snapshot.key;
        var myMsgClass = '';
        var bg_chng = '';
        if(sender == chats.sender)
        {
            myMsgClass = 'wid_ri';
            bg_chng = 'bg_chng';
        }

        if((chats.sender == receiver) || (chats.receiver == receiver )){
            if(usersData1[chats.sender].business_name!=''){
                senderName = usersData1[chats.sender].business_name;
            }else{
                senderName = usersData1[chats.sender].firstname+' '+usersData1[chats.sender].lastname;
            }
            if($('.'+snapKey).length == 0){
                msgHTML ='<div class="'+snapKey+' fil_ds '+myMsgClass+'  "><a href=""><div class="pro_img"><img src="'+usersData1[chats.sender].profile+'" style="width: 40px;border-radius: 20px;"></div></a><div class="msg_bx '+bg_chng+'"><b>'+senderName+'</b><pre>'+chats.message+'</pre></div><span class="date">'+chats.time+'</span></div>';  

                $('#conversation').append(msgHTML);
            }
        }

        $('#messageTextarea').val('');
        scrolltopposition();
    });

    function scrolltopposition() {
        elmnt = document.getElementById("conversation");
        elmnt.scrollTop = elmnt.scrollHeight;
    }

    var msg = firebaseRef.child('messages');
    function saveFirebaseMessage(){
        $('#messageerror').html('');
        var message = $('#messageTextarea').val();
        var receiver = $('#receiver').val();
        var sender = $('#sender').val();
        var chatuser = '';
        var is_group = $('#is_group').val();
        var groupSet = 0;
        if(message!=''){
            if(sender>receiver){
                chatuser+=sender+'_'+receiver;
            }else{
                chatuser+=receiver+'_'+sender;
            }
            if(is_group!=''){
                groupSet = 1;
                chatuser = 'group_'+receiver; 
            }
            msg.child(chatuser).push ({
                sender: sender,
                receiver: receiver,
                message: message,
                image: '',
                lat: lat,
                lng: lng,
                pdf: '',
                time: messageDate,
                type: '',
                video: '',
            });
            autoscrollnow('conversation');
        }else{
            $('#messageerror').html('<span style="color:red;">Please enter a message</span>');
        }
    }

    $(document).on('keyup','#messageTextarea',function(){
        if($(this).val() == ''){
            $('#messageerror').html('<span style="color:red;">Please enter a message</span>');
        }else{
            $('#messageerror').html('');
        }
    });

</script>