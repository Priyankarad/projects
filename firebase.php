<script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js"></script> 
<!-- <script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-auth.js"></script>  -->
<script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-database.js"></script> 
<script src="https://www.gstatic.com/firebasejs/5.5.1/firebase.js"></script> 
<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script> 
<script> 
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
firebaseRef.child('.info/connected').on('value', function(connectedSnap) {
    if (connectedSnap.val() === true) {
    } else {

    }
});

var sender = 1;
var receiver = 2;
firebaseRef.child("messages").push ({
   sender: sender,
   receiver: receiver,
   message: 'testing for firebase'
});

var firebaseRef = firebase.database().ref("messages/");

firebaseRef.on("child_removed", function(data) {
   var deletedPlayer = data.val();
   alert(deletedPlayer);
   // console.log(deletedPlayer.name + " has been deleted");
});

// var node = '25-30';
// var sender = 25;
// var msg_by = 0;
// if(sender == 26){
//     msg_by = 1;
// }
// set_message = 'priyanka';
// firebase.database().ref("messages/" + node).push({
//     message: 'how are you',
//     msg_by: msg_by
// });

// var messageRef = firebase.database().ref("messages/");
// var node = '25-30';
// var sender = 25;
// if(sender == 25){
//     msg_by = 1;
// }
// messageRef.set ({
//    node: {
//       msg_by: msg_by,
//       message: 'test'
//    },
// });
</script>