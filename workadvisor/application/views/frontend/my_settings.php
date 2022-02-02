<div class="row">
<div class="col-md-8">
<?php echo $this->session->flashdata('updatemsg'); ?>

<form method="post" action="<?php echo site_url(); ?>Profile/Editprofile" class="userprofile-form">
<div class="row">
<!--first Basic start-->
<div class="Basic Aft_mleft">
<div id="accordion">
<div class="card">
<div class="card-header" id="headingOne">
<h5 class="mb-0">
<div class="collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
<h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Basic Information</h1>
</div>
</h5>
</div>

<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
<div class="card-body">
<!--row start-->
<div class="row">
<div class="col-md-6 col-12">
<div class="slesh"></div>
<div class="form-group">
    <label class="ener-name">Name</label>
    <input name="firstname" class="form-control chinput dulinput ag1" placeholder="first name" type="text" value="<?php if(!empty($user_data->firstname)) { echo $user_data->firstname; } ?>" >
    <input name="lastname" class="form-control chinput dulinput ag2" placeholder="last name" type="text" value="<?php if(!empty($user_data->lastname)) { echo $user_data->lastname; } ?>" >
</div>
</div>

<div class="col-md-6 col-12">
<div class="form-group">
    <label class="ener-name">Email </label>
    <input type="text" class="form-control chinput" name="Cheryl" value="<?php if(!empty($user_data->email)) { echo $user_data->email; } ?>" disabled required>
</div>
</div>
</div>
<!--row close-->
<!--row start-->
<div class="row">
<div class="col-md-6 col-12">
<div class="form-group">
    <label class="ener-name">Zip</label>
    <input type="text" name="zip"  class="form-control chinput zip" placeholder="Your zipcode" value="<?php if(!empty($user_data->zip)) { echo $user_data->zip; } ?>" required>
</div>
</div>
<div class="col-md-6 col-12">
<div class="form-group">
    <label class="ener-name">City</label>
    <input type="text" name="city" class="form-control chinput city" placeholder="Your City" value="<?php if(!empty($user_data->city)) { echo $user_data->city; } ?>" required>
</div>
</div>


</div>
<!--row close-->
<div class="row">
<div class="col-md-6 col-12">
<div class="form-group">
    <label class="ener-name">State</label>
    <input type="text" name="state" class="form-control chinput state" placeholder="Your State" value="<?php if(!empty($user_data->state)) { echo $user_data->state; } ?>" required>
</div>
</div>
<div class="col-md-6 col-12">
<div class="form-group">
    <label class="ener-name">Country</label>
    <input type="text" name="country"  class="form-control chinput country" placeholder="Your Country" value="<?php if(!empty($user_data->country)) { echo $user_data->country; } ?>" required>
</div>
</div>

</div>
<!--row close-->

<div class="row">
<div class="col-md-6 col-12">
<div class="form-group">
    <label class="ener-name">Phone 
        <?php 
        $checked = '';
        if(!empty($user_data->display_phone)) {
            $checked ='checked=checked';
        }
        ?>
        <input type="checkbox" id="mycheckbox12" name="display_phone" <?php echo $checked;?>>
        <small> click to display </small>
    </label>
    <input type="text" name="phone" id="mycontact" class="form-control chinput" placeholder="Contact" value="<?php if(!empty($user_data->phone)) { echo $user_data->phone; } ?>" >
</div>
</div>
<div class="col-md-6 col-12">
<div class="form-group">
    <label class="ener-name">Website
        <?php 
        $checked = '';
        if(!empty($user_data->display_website)) {
            $checked ='checked=checked';
        }
        ?>
        <input type="checkbox" id="mycheckbox12" name="display_website" <?php echo $checked;?>>
        <small> click to display </small></label>
        <input type="text" name="website_link" class="form-control chinput" placeholder="Website link" value="<?php if(!empty($user_data->website_link)) { echo $user_data->website_link; } ?>">
    </div>
</div>
</div>
<!--row close-->
</div>
</div>
</div>


<!--second card start-->
<div class="card">
<div class="card-header" id="headingTwo">
<h5 class="mb-0">
<div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
<h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Category Information</h1>
</div>
</h5>
</div>
<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="">
<div class="card-body">       
<!--category strat-->
<div class="row">
<div class="col-md-7 col-12">
    <div class="form-group">
        <label class="ener-name">Select your category</label>
        <select class="form-control chinput" name="user_category">
            <!-- <option value="<?php if(!empty($user_data->user_category)) { echo $user_data->user_category; } ?>" style="color: #fff;"><?php if(!empty($user_data->user_category)) { echo $user_data->user_category; } ?></option> -->
            <?php if(!empty($category_details['result'])){
                foreach($category_details['result'] as $categories){ ?>
                    <?php
                    $cateStatus = ($categories->id == $user_data->user_category) ? "selected": ""; 
                    ?>
                    <option value="<?php echo $categories->id; ?>" <?php echo $cateStatus; ?> ><?php echo $categories->name; ?></option>

                <?php } } ?>

            </select>
        </div>
    </div>
</div>
</div>
<!--category close-->
</div>
</div>

<!--second card start-->


<!--third card start-->
<div class="card">
<div class="card-header" id="headingThree">
<h5 class="mb-0">
<div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
    <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Current Position</h1>
</div>
</h5>
</div>
<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion" style="">
<div class="card-body">     
<div class="row">
    <div class="col-md-6 col-12">
        <div class="form-group">
            <label class="ener-name">Current Position</label>
            <input type="text" name="current_position" id="current_position" class="form-control chinput" placeholder="Current Position" value="<?php if(!empty($user_data->current_position)) { echo $user_data->current_position; } ?>">
        </div>
    </div>
</div>
</div>
</div>
</div>

<!--third card close-->

<!--fourth card strat-->
<div class="card">
<div class="card-header" id="headingfour">
<h5 class="mb-0">
<div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
    <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Professional Skills <span class="professional_qmark"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>
</div>
</h5>
</div>
<div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordion" style="">
<div class="card-body extra-linow">
<div class="row">
    <div class="col-md-12 col-12">
        <div id="bootstrapTagsInputForm" method="post" class="form-horizontal">
            <div class="form-group">

                <input type="text" name="newprofessional_skill" class="form-control chinput"
                value="" data-role="tagsinput" placeholder="eg - Cook , Artist , ....">
                <div class="ddaa">
                    <i class="fa fa-plus"></i>
                </div>

                <div class="bootstrap-tagsinput1">
                    <?php if(!empty($user_data->professional_skill)) {  
                        $skills = explode(",",$user_data->professional_skill); 
                        foreach ($skills as $skill) {
                            ?>               
                            <span class="tag label label-info"><?php echo $skill; ?>
                            <input type="hidden" name="oldprofessional_skill[]" value="<?php echo $skill; ?>">
                            <span data-role="remove" class="removetag">

                            </span>
                        </span>               
                    <?php  } } ?>
                </div>

            </div>
        </div>
        <!--new contant close-->
    </div>
</div>
</div>
<!--category close--> 
</div>
</div>
<!--fourth card close-->

<!--five card strat-->

<div class="card">
<div class="card-header" id="headingfive">
<h5 class="mb-0">
<div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="true" aria-controls="collapsefive">
    <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Additional Services <span class="additional_qmark"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>
</div>
</h5>
</div>
<div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordion" style="">
<div class="card-body extra-linow">
<!--new contant aad-->

<div class="row">
    <div class="col-md-12 col-12">
        <div id="bootstrapTagsInputForm" method="post" class="form-horizontal">
            <div class="form-group">
                <input type="text" name="newadditional_services" class="form-control chinput"
                value="" data-role="tagsinput" placeholder="eg - Delivery , Pickup , ....">
                <div class="ddaa"><i class="fa fa-plus"></i></div>
                <div class="bootstrap-tagsinput1">
                    <?php if(!empty($user_data->additional_services)) {  
                        $services = explode(",",$user_data->additional_services); 
                        foreach ($services as $service) {
                            ?>
                            <span class="tag label label-info"><?php echo $service; ?>
                            <input type="hidden" name="oldadditional_services[]" value="<?php echo $service; ?>">
                            <span data-role="remove" class="removetag"></span></span>
                        <?php  } } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--new contant close-->
</div>
</div>
<!--five card close--> 

<div class="card">
<div class="card-header" id="headingfives">
<h5 class="mb-0">
    <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse_settings" aria-expanded="true" aria-controls="collapse_settings">
        <h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Email Notification Settings</h1>
    </div>
</h5>
</div>
<div id="collapse_settings" class="collapse" aria-labelledby="headingfive" data-parent="#accordion" style="">
<div class="card-body extra-linow">
    <!--new contant aad-->

    <div class="row">
        <div class="col-md-12 col-12">
            <div id="bootstrapTagsInputForm" method="post" class="form-horizontal switch_onOff">
                <div class="form-group">
                    <p>Notification for received messages</p>
                    <label class="switch">
                        <input type="checkbox" name="noti_msg" id="noti_msg"
                        <?php 
                        if(isset($user_data->message_notification) && $user_data->message_notification!=0)
                        {
                            echo "checked=checked";
                        }
                        ?>
                        >
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="form-group">
                    <p>Notification for reviews</p>
                    <label class="switch">
                        <input type="checkbox" name="review_notification" id="review_notification"
                        <?php 
                        if(isset($user_data->review_notification) && $user_data->review_notification!=0)
                        {
                            echo "checked=checked";
                        }
                        ?>
                        >
                        <span class="slider round"></span>
                    </label>
                </div>

<!-- <div class="form-group">
<label class="switch">
<input type="checkbox" name="noti_job" id="noti_job">
<span class="slider round"></span>
</label>
</div>
Notification for receiving messages -->

<div class="form-group">
<p>Notification for friend request received</p>
<label class="switch">
<input type="checkbox" name="noti_fr_req" id="noti_fr_req"
<?php 
if(isset($user_data->friend_request_received_notification) && $user_data->friend_request_received_notification!=0)
{
echo "checked=checked";
}
?>
>
<span class="slider round"></span>
</label>
</div>


<div class="form-group">
<p>Notification for friend request acceptance</p>
<label class="switch">
<input type="checkbox" name="noti_fr_ac" id="noti_fr_ac"
<?php 
if(isset($user_data->friend_request_acceptance_notification) && $user_data->friend_request_acceptance_notification!=0)
{
echo "checked=checked";
}
?>>
<span class="slider round"></span>
</label>
</div>


<div class="form-group">
<p> Notification for job request acceptance</p>
<label class="switch">
<input type="checkbox" name="noti_job_ac" id="noti_job_ac"
<?php 
if(isset($user_data->job_request_acceptance_notification) && $user_data->job_request_acceptance_notification!=0)
{
echo "checked=checked";
}
?>>
<span class="slider round"></span>
</label>
</div>


<div class="form-group">
<p>Notification for new task</p>
<label class="switch">
<input type="checkbox" name="new_task_notification" id="new_task_notification"
<?php 
if(isset($user_data->new_task_notification) && $user_data->new_task_notification!=0)
{
echo "checked=checked";
}
?>>
<span class="slider round"></span>
</label>
</div>

</div>
</div>
</div>
</div>
<!--new contant close-->
</div>
</div>
<!--five card close--> 


<!--19april start new tab add do it.-->

<div class="card">
<div class="card-header" id="heading7">
<h5 class="mb-0">
<div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
<h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Search Friends</h1>
</div>
</h5>
</div>
<div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion" style="">
<div class="card-body">     
<div class="row">
<div class="serch-fn-up">
<!--  <div class="fb-tz bordr" data-toggle="modal" data-target="#fbmodal">
<p><i class="fa fa-facebook-square"></i>On Facebook</p>
</div> -->
<div class="ml-tz e-ml bordr" data-toggle="modal" data-target="#emailmodal">
<p><i class="fa fa-envelope"></i>In Your Email Contacts</p>
</div>
<div class="invt-tz in-te bordr">
<a href="<?php echo base_url()?>user/invite_gmail_contacts">
<p><i class="fa fa-user-plus"></i> Invite Friends to WorkAdvisor</p>
</a>
</div> 
</div>

</div>
</div>
</div>

<div class="thre-popup">
<!--model-start 30april-->
<!-- first Modal start -->
<div class="modal fade" id="fbmodal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<h4 class="modal-title">adding your Facebook friends to WorkAdvisor. </h4>
<!-- Modal body strat-->

<!-- Modal body -->
<div class="modal-body">
<div class="only-bkvlr">
<p class="emil-cntnt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua.</p>
</div>
</div>
</div>
</div>
</div>

<!-- first Modal close -->


<!-- second Modal start -->
<div class="modal fade" id="emailmodal">
<div class="modal-dialog">
<div class="modal-content">
<!-- Modal Header -->
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<h4 class="modal-title">Send Invites</h4>
<!-- Modal body strat-->
<div class="modal-body">
<div class="only-bkvlr">
<div class="row">
<div class="col-md-3 col-sm-3 col-12">
<div class="imgs-emil mail-img-click">
<a href="https://accounts.google.com/o/oauth2/auth?client_id=252607257150-kr5at3658jl7mtoef6boer0ign6ue3fk.apps.googleusercontent.com&redirect_uri=https://workadvisor.co/user/google&scope=https://www.google.com/m8/feeds/&response_type=code"><img src="<?php echo base_url();?>assets/images/b3c993e.png"></a>
</div>
</div>
<div class="col-md-3 col-sm-3 col-12">
<div class="imgs-emil mail-img-click">
<a href="<?php echo isset($yahooURL)?$yahooURL:'';?>" ><img src="<?php echo base_url();?>assets/images/yahoo.png"></a>
</div>
</div>
</div>
</div>
</div>
<!-- Modal body close-->
</div>
</div>
</div>
<!-- second Modal close -->


<!-- third Modal start -->
<div class="modal fade" id="invitemodal">
<div class="modal-dialog">
<div class="modal-content">
<!-- Modal Header -->
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<h4 class="modal-title">Send WorkAdvisor Invites To These Email Addresses.</h4>

<!-- Modal body -->
<!-- Modal body strat-->
<div class="modal-body">
<div class="only-bkvlr">
<form method="post"  action="<?php echo base_url();?>user/send_invitation">
<div id="friend_invitation1" >
<div class="form-group">
<input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
</div>
<div class="form-group">
<input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
</div>
<div class="form-group">
<input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email">
</div>
<a class="emil-cntnt" style="cursor: pointer;" onclick = "addMore(1);">add another email address</a>
</div>
<button type="submit" class="invite-emil find">invitation email</button>
</form>
</div>
</div>
<!-- Modal body close-->
</div>
</div>
</div>
<!-- third Modal close -->
</div>
<!--model-close 30april-->

</div>
<!--19april close new tab add do it.-->

<!--last card div strat-->
<div class="card">
<div class="card-header" id="headingsix">
<h5 class="mb-0">
<div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">
<h1 class="Basic-grn"> <i class="fa fa-asterisk" aria-hidden="true"></i>Reset Password</h1>
</div>
</h5>
</div>
<div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion" style="">
<div class="card-body">
<!--category strat-->
<div class="row">
<?php if(!empty($user_data->password)) { ?>
<div class="col-md-4 col-12">
<div class="form-group">
<label class="ener-name">Current Password</label>
<input type="Password" name="oldpassword" id="oldpassword" class="form-control chinput" placeholder="Current Password">
</div>
</div>
<?php } ?>
<div class="col-md-4 col-12">
<div class="form-group">
<label class="ener-name">New Password</label>
<input type="Password" name="newpassword" id="newpassword" class="form-control chinput" placeholder="New Password">
</div>
</div>
<div class="col-md-4 col-12">
<div class="form-group">
<label class="ener-name">Confirm Password</label>
<input type="Password" name="cnewpassword" id="cnewpassword" class="form-control chinput" placeholder="Confirm Password"><span id='message1'></span>
</div>
</div>

<div class="col-md-4 col-12">
<div class="delet-formt">
<a class="nav-link"  onclick="return confirm('Are you sure you want to delete this account?');" href="<?php echo site_url('user/deleteaccount'); ?>">
<div class="his_img">
<i class="fa fa-trash" aria-hidden="true"></i>
</div>
DELETE PROFILE
</a>
</div>      
</div>


</div>
</div>


<!--category close-->
</div>
</div>
</div>
<!--last card div close-->  

</div>
<!--row close-->
<!--first Basic close-->
<div class="enter_name">
<button type="submit" class="find extra">
Save
</button>
</div>
</div>
</form>
</div>
<!-- <div class="col-md-4">


<ins class="adsbygoogle"
style="display:block"
data-ad-client="ca-pub-3979824042791728"
data-ad-slot="2846184025"
data-ad-format="auto"
data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div> -->
</div>

