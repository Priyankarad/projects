<!--section log_inheder start-->
<style type="text/css">

    #share-buttons img {
        width: 35px;
        padding: 5px;
        border: 0;
        box-shadow: 0;
        display: inline;
    }

</style>
<section class="profile_tab">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12 pl_inlft">
                <div class="tab_list">
                    <div class="card">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="bell notification_toggle">
                                <!-- <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Notification</a> -->
                                <a> <i class="fa fa-bell"></i><span class="rivew-bell notification_bell">0</span> Notification </a>
                            </li>
                            <li role="presentation">
                                <!-- <a href="#ShareProfile" aria-controls="ShareProfile" role="tab" data-toggle="tab">
                                <i class="fa fa-share-square-o"></i> Share Profile</a> -->
                                <a aria-controls="ShareProfile" role="tab" data-toggle="tab">
  <i class="fa fa-share-square-o"></i> Share Profile</a>
                            </li>
                                <div id="share-buttons" title="Share Profile">
                                    <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
                                        <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />
                                    </a>

                                    <a href="https://plus.google.com/share?url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
                                        <img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" />
                                    </a>

                                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">
                                        <img src="https://simplesharebuttons.com/images/somacro/linkedin.png" alt="LinkedIn" />
                                    </a>
                                </div>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="" >

        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12" style="margin-top:20px"> 
                    <!--third tab link strat--> 
                    <div class="tab-pane container" id="menu6">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="inner_fmains">
                                <h3>Invite Friends</h3>
                                <label class="">
                                    <input type="checkbox" value="<?php echo $row['email']; ?>" class="all_invitation"> Select All
                                </label>
                                <form action="<?php echo base_url();?>user/send_invitation" method="post" class="row">
                                <button type="submit" class="invite-emil find">Send Invitation</button>
                                <br/>
                                <br/>
                                <?php if(!empty($contacts)){ 
                                    foreach($contacts as $row){
                                    if(isset($row['email'])){
                                     ?>
                                    <div class="inner-mailbox col-md-4 col-12">
                                        <div class="mail-box-content">
                                            <ul>
                                                <li>
                                                    <label class="chckprofile">
                                                        <input type="checkbox" name="emails[]" value="<?php echo $row['email']; ?>" class="invitation">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li> <div class="mail-img-profile">
                                                    <img src="<?php echo $row['image']; ?>">
                                                </div>
                                            </li>
                                            <li><h1><?php echo isset($row['name'])?$row['name']:''; ?></h1>
                                                <p><?php echo $row['email']; ?></p></li>
                                            </ul>

                                        </div>


                                    </div>
                                    <?php }
                                    }
                                } ?>
                                <button type="submit" class="invite-emil find">Send Invitation</button>
                            </form>
                            </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <!--third tab link close--> 

</div>

</div>
</div>
</section>
<script type="text/javascript">
    $('.all_invitation').click(function(){
        $(".invitation").prop('checked', $(this).prop("checked"));
    });

    $('.invitation').click(function(){
        $(".all_invitation").prop('checked', false);
    });
</script>
<!--profil close-->