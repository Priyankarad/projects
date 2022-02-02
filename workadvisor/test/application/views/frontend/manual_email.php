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
                                <a> <i class="fa fa-bell" ></i><span class="rivew-bell notification_bell">0</span> Notification </a><ul id="notifications_ul"></ul>
                            </li>  
                            <?php if(get_current_user_id()){ ?>
                                <li role="presentation">
                                    <a href="<?php echo base_url()?>user/favourites_list"> <i class="fa fa-heart" aria-hidden="true"></i> Favorites </a>
                                </li>   
                            <?php } ?>
                            <li role="presentation"><a href="#ShareProfile" aria-controls="ShareProfile" role="tab" data-toggle="tab">
                                <i class="fa fa-share-square-o"></i> Share Profile</a></li>
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
                                <h3>Send Workadvisor.co Invites To These Email Addresses.</h3>
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
                                        <div class="clearfix"></div>
                                        <div class="col-md-12 col-sm-12">
                                            <label>Invitation Content</label>
                                            <textarea id="message_content" name="message_content" class="form-control"></textarea>
                                        </div>
                                        <button type="submit" class="invite-emil find">invitation email</button>

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

<!--profil close-->