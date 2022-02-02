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
    var second;
    var minute;
    var hour;
    var day;
    var week;
    var month;
    var year;
// var messageDate = new Date().toLocaleString('en-US');
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
    if(Number(sender)>Number(receiver)){
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
        if(typeof(usersData1[chats.sender]) != 'undefined'){
            if(usersData1[chats.sender].business_name!=''){
                senderName = usersData1[chats.sender].business_name;
            }else{
                senderName = usersData1[chats.sender].firstname+' '+usersData1[chats.sender].lastname;
            }
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

            var dateTime = dateDiff(chats.time);
            second = Number(dateTime.second);
            minute = Number(dateTime.minute);
            hour = Number(dateTime.hour);
            day = Number(dateTime.day);
            week = Number(dateTime.week);
            month = Number(dateTime.month);
            year = Number(dateTime.year);
            if(year>=1){
                dateTime = year+' yr ago';
            }else if(month<=11 && month>0){
                dateTime = month+' mo ago';
            }else if(week<=4 && week>0){
                dateTime = week+' wk ago';
            }else if(day<8 && day>0){
                dateTime = day+' day ago';
            }else if(hour<24 && hour>0){
                dateTime = hour+' hr ago';
            }else if(minute<60 && minute>0){
                dateTime = minute+' min ago';
            }else if(second<60){
                dateTime = second+' sec ago';
            }
            msgHTML+='</pre></div><span class="date">'+dateTime+'</span></div>';  
            $('#conversation').append(msgHTML);
        }
    }
    scrolltopposition();
});

function scrolltopposition() {
    elmnt = document.getElementById("conversation");
    elmnt.scrollTop = elmnt.scrollHeight;
}

var reference = firebase.database();
var msg = firebaseRef.child('messages');
function saveFirebaseMessage(){
    var usersData = $('#usersData').val();
    var usersData1=JSON.parse(usersData);
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
    var dataType = 0;
    if(type == 'image'){
        image = file;
        dataType = 1;
    }else if(type == 'video'){
        video = file;
        dataType = 3;
    }else if(type == 'document'){
        documentF = file;
        dataType = 4;
    }

    if(message!='' || type!=''){
        if(Number(sender)>Number(receiver)){
            chatuser+=sender+'_'+receiver;
        }else{
            chatuser+=receiver+'_'+sender;
        }
        if(is_group!=''){
            groupSet = 1;
            chatuser = 'group_'+receiver; 
        }
        var readBy = [sender];
        var messageDate = new Date().getTime();
        msg.child(chatuser).push ({
            sender: sender,
            receiver: receiver,
            message: message,
            image: image,
            lat: lat,
            lng: lng,
            documentF: documentF,
            time: messageDate.toString(),
            type: dataType.toString(),
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

    /*for saving the message data in local db*/
    $.ajax({
        type:'POST',
        url:site_url+'user/insertFirebaseMessage',
        data: {sender:sender,receiver:receiver,message:message,image:image,video:video,documentF:documentF,is_group:is_group},
        dataType: 'json',
        success:function(res){

        }
    });

    /*for saving the recent message, for app developer use only*/
    var profileImgReceiver = '';
    var profileImgSender = '';
    if(typeof(usersData1[sender]) != 'undefined'){
        profileImgSender = usersData1[sender].profile;
    }
    if(typeof(usersData1[receiver]) != 'undefined'){
        profileImgReceiver = usersData1[receiver].profile;
    }

    var receiverCount = '0';
    var senderCount = '0';
    reference.ref('recents/'+chatuser+'/').once('value', function(snapshot) {
        var senderName;
        var receiverName;
        if(typeof(usersData1[sender]) != 'undefined'){
            if(usersData1[sender].business_name!=''){
                senderName = usersData1[sender].business_name;
            }else{
                senderName = usersData1[sender].firstname+' '+usersData1[sender].lastname;
            }
        }

        if(typeof(usersData1[receiver]) != 'undefined'){
            if(usersData1[receiver].business_name!=''){
                receiverName = usersData1[receiver].business_name;
            }else{
                receiverName = usersData1[receiver].firstname+' '+usersData1[receiver].lastname;
            }
        }

        if(groupSet!=1){
            var recentData = snapshot.val();
            if (snapshot.hasChild('unread_'+receiver)) {
                if((recentData['unread_'+receiver]!='undefined') && (!isNaN(recentData['unread_'+receiver]))){
                    receiverCount = recentData['unread_'+receiver];
                    receiverCount = Number(receiverCount)+Number(1);
                    var senderUnread = ('unread_'+sender).toString();
                    senderCount = (recentData[senderUnread]).toString();
                    var recentCount = {};
                    var receiverUnread = ('unread_'+receiver).toString();
                    recentCount[receiverUnread] = receiverCount.toString();
                    reference.ref().child('recents/'+chatuser+'/').update(recentCount);
                }
            }

            var senderUnread = ('unread_'+sender).toString();
            var receiverUnread = ('unread_'+receiver).toString();

            var messageDate = new Date().getTime();
            var recentArr = {};
            recentArr['image'] = image;
            recentArr['message'] = message;
            recentArr['name_receiver'] = receiverName;
            recentArr['name_sender'] = senderName;
            recentArr['pdf'] = documentF;
            recentArr['profile_receiver'] = profileImgReceiver;
            recentArr['profile_sender'] = profileImgSender;
            recentArr['receiver'] = receiver;
            recentArr['sender'] = sender;
            recentArr['time'] = messageDate.toString();
            recentArr['type'] = '';
            recentArr['typing'] = '0';
            recentArr[senderUnread] = senderCount.toString();
            recentArr[receiverUnread] = receiverCount.toString();
            recentArr['video'] = video;
            reference.ref().child('recents/'+chatuser+'/').update(recentArr);
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
    $('#SendMessageButton').prop('disabled',true);
    $('.scrol_loding').show();
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
        $('.scrol_loding').hide();
        $('#SendMessageButton').prop('disabled',false);
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

/*code for checking typing status*/
setInterval(checkTypingStatus,7000);
function checkTypingStatus(){
    $('#latestMessage_'+receiver).html('');
    var reference = firebase.database();
    reference.ref('is_typing/'+chat).on('value', function(snapshot) {
        var msgData = snapshot.val();
        if(msgData!=null){
            var typingStatus = msgData['typing'];
            var sender1 = msgData['sender'];
            var receiver1 = msgData['receiver'];
            if(is_group!=''){
                if((typingStatus != 0) && (receiver1 == receiver) && (sender1!=sender)){
                    $('#latestMessage_'+receiver).html('someone is typing...');
                }
            }else{
                if((typingStatus != 0) && (sender1 == receiver)){
                    $('#latestMessage_'+receiver).html('typing...');
                }
            }
        }
    });
}

/*for updating the read by status*/
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

/*update the read count to 0*/
var receiverCount = 0;
var recentCount = {};
reference.ref('recents/'+chat+'/').once('value', function(snapshot) {
    var recentData = snapshot.val();
    if (snapshot.hasChild('unread_'+sender)) {
        var senderUnread = ('unread_'+sender).toString();
        recentCount[senderUnread] = receiverCount;
        reference.ref().child('recents/'+chat+'/').update(recentCount);
    }
});

$(document).on('keyup','.tetx_bx',function(){
    reference.ref().child('is_typing/'+chat+'/').update({image:'',message:'',name_receiver:'',name_sender:'',pdf:'',profile_receiver:'',profile_sender:'',receiver:receiver,sender:sender,time:'',type:'',typing:'0',video:''});
});

$(document).on('keydown','.tetx_bx',function(){
    reference.ref().child('is_typing/'+chat+'/').update({image:'',message:'',name_receiver:'',name_sender:'',pdf:'',profile_receiver:'',profile_sender:'',receiver:receiver,sender:sender,time:'',type:'',typing:'1',video:''});
});

function dateDiff(timestamp){
    var d = Math.abs(timestamp - new Date().getTime()) / 1000;                 
    var r = {};    
    var s = { 
        year: 31536000,
        month: 2592000,
        week: 604800,
        day: 86400,
        hour: 3600,
        minute: 60,
        second: 1
    };
    Object.keys(s).forEach(function(key){
        r[key] = Math.floor(d / s[key]);
        d -= r[key] * s[key];
    });
    return r;
}
</script>