<input type="hidden" class="sender" value="41">
<input type="hidden" class="receiver" value="22">
<input type="hidden" class="messageTextarea" value="hthththhthththt grgfgff">
<input type="hidden" class="is_group" value="1">
<input type="hidden" id="site_url" value="<?php echo base_url();?>">
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js"></script> 
<script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-database.js"></script> 
<script src="https://www.gstatic.com/firebasejs/5.5.1/firebase.js"></script> 
<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script> 
<script> 
    saveOldMessage();
    function saveOldMessage(){
        var firebaseConfig = {
            apiKey: "AIzaSyDsWzwATbwIRvz6DYq2Mp4ZCvlZ1cmWZWk",
            authDomain: "workadvisor-d1c17.firebaseapp.com",
            databaseURL: "https://workadvisor-d1c17.firebaseio.com",
            projectId: "workadvisor-d1c17",
            storageBucket: "",
            messagingSenderId: "1028409820829",
            appId: "1:1028409820829:web:242835cb5126953d"
        };
        firebase.initializeApp(firebaseConfig);
        var database = firebase.database();
        var firebaseRef = new Firebase("https://workadvisor-d1c17.firebaseio.com");
        firebaseRef.child('messages').on('value', function(connectedSnap) {
            if (connectedSnap.val() === true) {
            } else {

            }
        });
        var msg = firebaseRef.child('messages');
        var message = $('.messageTextarea').val();
        var receiver = $('.receiver').val();
        var sender = $('.sender').val();
        var chatuser = 'chat-';
        var is_group = $('.is_group').val();
        var site_url = $('#site_url').val();

        $.ajax({
            type:'post',
            url : site_url+'user/saveOldMessages',
            data:{a:1},
            dataType: 'json',
            success:function(result){
                //alert(result.messageData.length);
                for(var i=0;i<result.messageData.length;i++){
                    //alert(result.messageData[i].id);
                }
                //alert(result.messageData[0].id);
            }
        });







        var groupSet = 0;
        if(sender>receiver){
            chatuser+=sender+'_'+receiver;
        }else{
            chatuser+=receiver+'_'+sender;
        }
        if(is_group!=''){
            groupSet = 1;
            chatuser = 'chat-'+receiver; 
        }
        msg.child(chatuser).push ({
            sender: sender,
            receiver: receiver,
            message: message,
            is_group: groupSet
        });
    }

</script>