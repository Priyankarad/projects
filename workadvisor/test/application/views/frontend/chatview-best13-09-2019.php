<input type="hidden" name="is_group" id="is_group" value="<?php if(isset($group) && $group == 1){ echo 'group'; } else{ echo ''; }?>">
<div id="conversation" data-id="<?php if(isset($other_user)){ echo $other_user; } ?>" class="conversation">
    <?php
    $allUserData = !empty($allUserData)?json_encode($allUserData):'';
    ?>
    <input type="hidden" id="usersData" value='<?php echo $allUserData;?>'>
    <input type="hidden" id="urlImage">
    <input type="hidden" id="typeImage">
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
       
        <p class="lead emoji-picker-container">
            <textarea class="form-control textarea-control tetx_bx check_empty" name="message" id="messageTextarea" rows="3" placeholder="Type Something ..." data-emojiable="true"></textarea>
        </p>
        <input type="file" class="file" id="file" accept=".jpeg,.jpg,.png,.mp4"/>

        <input type="file" class="file" id="doc_file" accept=".pdf,.docx,.doc,.xls,.xlsx"/>

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
    var fileSet = 0;
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
        storageBucket: "gs://workadvisor-d1c17.appspot.com",
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
                msgHTML ='<div class="'+snapKey+' fil_ds '+myMsgClass+'  "><a href=""><div class="pro_img"><img src="'+usersData1[chats.sender].profile+'" style="width: 40px;border-radius: 20px;"></div></a><div class="msg_bx '+bg_chng+'"><b>'+senderName+'</b><pre>';

                if(chats.message!=''){
                    msgHTML+=chats.message;
                }

                if(chats.image!=''){
                    msgHTML+='<img src="'+chats.image+'" width="30%">';
                }

                if(chats.video!=''){
                    msgHTML+='<video width="320" height="240" controls><source src="'+chats.video+'" type="video/mp4"></video>';
                }

                if(chats.documentF!=''){
                    var doc = chats.documentF;
                    if(doc.includes("pdf")){
                        msgHTML+='<a href="'+doc+'" download><img src="'+site_url+'assets/images/pdf.png" width="30%"></a>';
                    }else if(doc.includes("xls")){
                        msgHTML+='<a href="'+doc+'"><img src="'+site_url+'assets/images/xlsx.png" width="30%"></a>';
                    }else if(doc.includes("doc")){
                        msgHTML+='<a href="'+doc+'"><img src="'+site_url+'assets/images/doc.png" width="30%"></a>';
                    }
                }

                msgHTML+='</pre></div><span class="date">'+chats.time+'</span></div>';  

                $('#conversation').append(msgHTML);
            }
        }
        //$('#messageTextarea').val('');
        //$('.emoji-wysiwyg-editor').html('');
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
        var image='';
        var video='';
        var documentF='';
        var file = $('#urlImage').val();
        var type = $('#typeImage').val();
        if(type == 'image'){
            image = file;
        }else if(type == 'video'){
            video = file;
        }else if(type == 'document'){
            documentF = file;
        }

        if(message!='' || type!=''){
            if(sender>receiver){
                chatuser+=sender+'_'+receiver;
            }else{
                chatuser+=receiver+'_'+sender;
            }
            if(is_group!=''){
                groupSet = 1;
                chatuser = 'group_'+receiver; 
            }
            var readBy = [sender];
            msg.child(chatuser).push ({
                sender: sender,
                receiver: receiver,
                message: message,
                image: image,
                lat: lat,
                lng: lng,
                documentF: documentF,
                time: messageDate,
                type: '',
                video: video,
                read_by: readBy
            });
        }else{
            if(fileSet == 0){
                $('#messageerror').html('<span style="color:red;">Message can\'t be empty</span>');
            }
        }
        fileSet=0;
        $('#urlImage').val('');
        $('#typeImage').val('');
        $('.file').val('');
        $('#messageTextarea').val('');
        $('.emoji-wysiwyg-editor').html('');

        $.ajax({
            type:'POST',
            url:site_url+'user/insertFirebaseMessage',
            data: {sender:sender,receiver:receiver,message:message,image:image,video:video,documentF:documentF,is_group:is_group},
            dataType: 'json',
            success:function(res){

            }
        });
    }

    $(document).on('keyup','#messageTextarea',function(){
        if($(this).val() == ''){
            $('#messageerror').html('<span style="color:red;">Please enter a message</span>');
        }else{
            $('#messageerror').html('');
        }
    });

        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: site_url+'assets/lib/img/',
            popupButtonClasses: 'fa fa-smile-o'
        });
        window.emojiPicker.discover();

/*to upload files*/
$('.file').change(function() {
    fileSet = 1;
    $('#messageerror').html('');
    var fileField = $(this).attr('id');
    ref = firebase.storage().ref();
    const file = document.querySelector('#'+fileField).files[0]
    myfilename = file.name;
    var ex = myfilename.substr((myfilename.lastIndexOf('.') + 1));
    var type = '';
    var folder = '';
    if(fileField == 'doc_file'){
        if (!/(pdf|docx|doc|xls|xlsx)$/ig.test(ex)) {
            $('#messageerror').html('<span style="color:red;">Please select any pdf,docx,doc,xls or xlsx file</span>');
            return false;
        }else{
            type = 'document';
            folder = 'ChatDocuments/';
        }
    }
    else{
        if (!/(png|PNG|jpg|JPEG|JPG|jpeg)$/ig.test(ex)) {
            if (!/(mp4)$/ig.test(ex)) {
                $('#messageerror').html('<span style="color:red;">Please select any png,jpg,jpeg or mp4 file</span>');
                return false;
            }else{
                type = 'video';
                folder = 'ChatVideos/';
            }
        }else{
            type = 'image';
            folder = 'ChatImages/';
        }
    }
    const name = (+new Date()) + '-' + file.name;
    const metadata = {
        contentType: file.type
    };
    const task = ref.child(folder + name).put(file, metadata);
    task.then(snapshot => snapshot.ref.getDownloadURL()).then((url) => {
        $('#urlImage').val(url);
        $('#typeImage').val(type);
    });
});


/*for setting notification count*/
var friendsArray = $('#friendsArray').val();
friendsArray = JSON.parse(friendsArray);
setInterval(checkNewMessages,1000);
function checkNewMessages(){
    for(var i=0;i<friendsArray.length;i++){
        var count = 0;
        firebase.database().ref('messages/'+friendsArray[i]).on('child_added', function(snapshot) {
            var chats = snapshot.val();
            var readBy = chats.read_by;
            if(($.inArray(sender,readBy) === -1) && (sender!=chats.sender)){
               count++;
            }
        });
        if((count > 0) && (chat!=friendsArray[i])){ // show count only if not the current chat open
            $('.'+friendsArray[i]+' .notificationCircle').addClass('cuircl2');
            $('.'+friendsArray[i]+' .notificationCircle').html(count);
        }else{
            $('.'+friendsArray[i]+' .notificationCircle').html('');
            $('.'+friendsArray[i]+' .notificationCircle').removeClass('cuircl2');
        }
    }
}

// var reference = firebase.database();
// reference.ref('messages/'+chat).on('value', function(snapshot) {
//     var msgData = snapshot.val();
//     if(msgData!=null){
//         var key = Object.keys(msgData);
//         for(i=0;i<key.length;i++){
//             var index = key[i];
//             var read_by = msgData[index].read_by;
//             console.log(read_by);
//             //reference.ref().child('messages/'+chat+'/'+key[i]).update({ read_by: 3331});
//         }
//     }
// });

var reference = firebase.database();
reference.ref('messages/'+chat).on('value', function(snapshot) {
    var msgData = snapshot.val();
    if(msgData!=null){
        var key = Object.keys(msgData);
        for(i=0;i<key.length;i++){
            var index = key[i];
            var readBy = [];
            readBy = msgData[index]['read_by'];
            var receiverRow = msgData[index]['receiver'];
            if(is_group!=''){
                if(($.inArray(sender,readBy) === -1) && $.isNumeric(receiverRow) && (receiverRow == receiver)){
                    readBy.push(sender);
                    reference.ref().child('messages/'+chat+'/'+index).update({ read_by: readBy});
                }
            }else{
                if(($.inArray(sender,readBy) === -1) && $.isNumeric(receiverRow) && (receiverRow == sender)){
                    readBy.push(sender);
                    reference.ref().child('messages/'+chat+'/'+index).update({ read_by: readBy});
                }
            }
        }
    }
});
</script>