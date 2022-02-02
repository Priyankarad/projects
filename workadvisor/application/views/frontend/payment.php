<div class="thankyou_pg">
	<div class="my_pagth">

<?php 
echo '<div class="text-center">';
if($status == 'success'){
    echo '<h1>Thank you for your recent payment.</h1>';
    echo '<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Light_green_check.svg/768px-Light_green_check.svg.png">';
    echo '<h5>Now its time to get noticed.</h5>';
    echo '<p>Please allow up to 24hrs for your profile to appear on homepage top 6 performers </p>';
    echo '<a href = "'.site_url('profile').'">Back</a>';
}else{
    echo '<h1>Oops !!!</h1>';
    echo '<h5>Your payment was not successful</h5>';
    echo '<a href = "'.site_url('profile').'">Back</a>';
}
echo '</div>';
?>


<!-- <h1>Thank you for your recent payment.</h1>
<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Light_green_check.svg/768px-Light_green_check.svg.png">
<h5>Now its time to get noticed.</h5>
<p>Please allow up to 24hrs for your profile to appear on homepage top 6 performers </p>
<a href = "'.site_url('profile').'">Back</a> -->
		
	</div>
</div>
<style type="text/css">
	body {
   margin: 0;
}
.thankyou_pg {
   background: #eaeaea;
   height: 100vh;
   width: 100%;
   display: flex;
   flex-direction: column;
   justify-content: center;
   text-align: center;
   font-family: tahoma;
}
.my_pagth {
   width: 100%;
   max-width: 605px;
   background: #fff;
   margin: 0 auto;
   padding: 30px;
   box-shadow: 0px 0px 15px 0px #ddd;
}
.my_pagth h1 {
margin-top: 0;
color: #2a2a2a;
font-size: 26px;
}
.my_pagth img {
width: 115px;
}
.my_pagth h5 {
font-size: 21px;
}
.my_pagth p {
font-size: 15px;
color: #808080;
letter-spacing: 0.3px;
}
.my_pagth a {
display: inline-block;
background: #00bf26;
padding: 7px 20px 8px 20px;
color: #fff;
text-decoration: none;
border-radius: 2px;
margin-top: 17px;
font-size: 14px;
letter-spacing: 0.5px;
box-shadow: 0px 0px 20px 0px #ccc;
}
</style>