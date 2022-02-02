<!--section log_inheder start-->

<?php

$imgs =""; 
$usernamefb = "";
$imgs = ($user_data->profile !=  'assets/images/default_image.jpg')? $user_data->profile: base_url().'/assets/images/icon-facebook.gif';;
// $usernamefb = $user_data->firstname." ".$user_data->lastname;
if($user_data->business_name!=''){
    $usernamefb = $user_data->business_name;
}else{
    $usernamefb = $user_data->firstname." ".$user_data->lastname;
}
?>


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
                            <li role="presentation"><a aria-controls="ShareProfile" role="tab" data-toggle="tab">
                                <i class="fa fa-share-square-o"></i> Share Profile</a></li>
                                <div id="share-buttons" title="Share Profile">
<?php /* <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">

<i class="fa fa-facebook"></i>
</a> */?>
<a href="javascript:void(0)" onclick="submitAndShare('<?php echo $imgs; ?>','<?php echo $usernamefb; ?>')" target="_blank">  
    <i class="fa fa-facebook"></i>
</a>

<a href="https://plus.google.com/share?url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">

    <i class="fa fa-google-plus"></i>
</a>

<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">

    <i class="fa fa-linkedin"></i>
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
                <div class="tab-pane container hist_reviews2" id="menu6">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">



                            <ul style="list-style: none; padding-left: 0;">
                                <?php //if($count == 1){ ?>
                                    <li class="ful_cntant min-pdn">
                                        <div class="row rating_rev_89">
                                            <div class="col-md-12">
                                                <h3>Ratings and Reviews</h3>
                                                <?php if($userType!='self'){ ?>
                                                    <a href="" class="reviews_wri56" data-toggle="modal" data-target="#myModal5" data-toggle="tab"> <i class="fa fa-star-o"></i> Write Review </a>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="F_rat_profile">
                                                    <div class="chery11 profile-img">
                                                        <img src="<?php
                                                        if(!empty($user_data->profile) && $user_data->profile!='assets/images/default_image.jpg'){
                                                            echo $user_data->profile;
                                                            }else
                                                            {
                                                                echo base_url().DEFAULT_IMAGE;;
                                                            }
                                                            ?>">
                                                        </div>
                                                        <div class="Chery2">
                                                            <h4><?php if(!empty($user_data->firstname)) { echo ucfirst($user_data->firstname); } ?> <?php if(!empty($user_data->lastname)) { echo ucfirst($user_data->lastname); } ?></h4>
                                                            <p><?php if(!empty($user_data->city)) { echo trim($user_data->city).', '; } ?>
                                                            <?php if(!empty($user_data->state)) { echo trim($user_data->state).', '; } ?>
                                                            <?php if(!empty($user_data->country)) { echo trim($user_data->country).', '; } ?>
                                                            <?php if(!empty($user_data->zip)) { echo trim($user_data->zip); } ?></p>
                                                            <div class="current">
                                                                <p class="fl_lft">Current Position  - </p>
                                                                <span class="Paul">
                                                                    <strong><?php if(!empty($user_data->current_position)) { echo $user_data->current_position; } ?> </strong> 
                                                                    <strong> <?php if(!empty($workingAt->business_name)) { 
                                                                        $companyProfileURL = site_url('viewdetails/profile/'.encoding($workingAt->id));
                                                                        echo '<small> At </small><a href="'.$companyProfileURL.'"> '.$workingAt->business_name.'</a>'; } ?>

                                                                    </strong>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="F_rating_txt">
                                                        <div class="Chery2">
                                                            <h1><?php
                                                            if(!empty($ratingsData['ratingAverage'])){ echo number_format($ratingsData['ratingAverage'],1);}?></h1>
                                                            <a href="http://workadvisor.co/user/history.html">
                                                                <span class="quyntity">
                                                                    <?php if(!empty($ratingsData['starRating'])){ echo $ratingsData['starRating'];}?>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="F_ratings89">
                                                            <?php if(isset($user_data->user_role) && $user_data->user_role == 'Performer') { 
// $last = $this->uri->total_segments();
                                                                $record_num = encoding($user_id);
                                                                ?>
                                                                <div class="progrs">
                                                                    <h1>Performance</h1>
                                                                    <?php if(isset($percentarray[5])) {?>
                                                                        <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/5">
                                                                        <?php }else{ ?>
                                                                            <a href="#">
                                                                            <?php }?>
                                                                            <div class="bar-one">
                                                                                <span class="quntit"><?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?></span>
                                                                                <div style="width: <?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?>"></div>
                                                                                <span class="star_rigth">5&nbsp;&nbsp;stars</span>
                                                                            </div>
                                                                        </a>

                                                                        <?php if(isset($percentarray[4])) {?>
                                                                            <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/4">
                                                                            <?php }else{ ?>
                                                                                <a href="#">
                                                                                <?php }?>
                                                                                <div class="bar-one">
                                                                                    <span class="quntit"><?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?></span>
                                                                                    <div  style="width: <?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?>"></div>
                                                                                    <span class="star_rigth">4&nbsp;&nbsp;stars</span>
                                                                                </div>
                                                                            </a>

                                                                            <?php if(isset($percentarray[3])) {?>
                                                                                <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/3">
                                                                                <?php }else{ ?>
                                                                                    <a href="#">
                                                                                    <?php }?>
                                                                                    <div class="bar-one">
                                                                                        <span class="quntit"><?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?></span>
                                                                                        <div  style="width: <?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?>"></div>
                                                                                        <span class="star_rigth">3&nbsp;&nbsp;stars</span>
                                                                                    </div>
                                                                                </a>

                                                                                <?php if(isset($percentarray[2])) {?>
                                                                                    <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/2">
                                                                                    <?php }else{ ?>
                                                                                        <a href="#">
                                                                                        <?php }?>
                                                                                        <div class="bar-one">
                                                                                            <span class="quntit"><?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?></span>
                                                                                            <div  style="width: <?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?>"></div>
                                                                                            <span class="star_rigth">2&nbsp;&nbsp;stars</span>
                                                                                        </div>
                                                                                    </a>

                                                                                    <?php if(isset($percentarray[1])) {?>
                                                                                        <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/1">
                                                                                        <?php }else{ ?>
                                                                                            <a href="#">
                                                                                            <?php }?>
                                                                                            <div class="bar-one">
                                                                                                <span class="quntit"><?php echo isset($percentarray[1])?number_format($percentarray[1],1).'%':'0%';?></span>
                                                                                                <div  style="width: <?php echo isset($percentarray[1])?number_format($percentarray[1],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[1])?number_format($percentarray[1],1):'0%';?>"></div>
                                                                                                <span class="star_rigth">1&nbsp;&nbsp;stars</span>
                                                                                            </div>
                                                                                        </a>
                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <?php //} ?>

                                                            <li>
                                                                <label>Sort By : </label>
                                                                <select class="form-control" id="review_filter" name="review_filter">
                                                                     <option value="" disabled selected="selected">Select Filter</option>
                                                                    <option value="new_old">Newest To Oldest</option>
                                                                    <option value="old_new">Oldest To Newest</option>
                                                                    <option value="most_least">Most To Least</option>
                                                                    <option value="least_most">Least To Most</option>
                                                                    <option value="employer">Employers</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                        <ul id="filter_data">
                                                            <?php if(!empty($MyhistoryRating)){ 
                                                                $count = 0;
                                                                foreach($MyhistoryRating as $key=>$historyratings){ 
                                                                    $count++;

                                                                    $i=0; foreach($historyratings as $r){
                                                                        $userProfileUrl = site_url('viewdetails/profile/'.encoding($r['retedbyid']));
                                                                        ?>	 

                                                                        <li class="ful_cntant min-pdn">
                                                                            <div class="lin-higthdiv">
                                                                                <div class="row pading-tp F_reviewC">
                                                                                    <div class="col-md-1">
                                                                                        <div class="profil-mgg">

                                                                                            <a href="<?php  
                                                                                            if($r['anonymous']!=1)
                                                                                            echo $userProfileUrl;
                                                                                            else
                                                                                            echo '#';
                                                                                            ?>">
                                                                                            <img src="<?php echo (!empty($r['profile']) && $r['profile']!='assets/images/default_image.jpg')? $r['profile']:base_url().DEFAULT_IMAGE; ?>" alt="<?php echo $r['givername']; ?>">
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <div class="howwas chg chg">
                                                                                        <h2><?php 
                                                                                        if($r['anonymous']!=1)
                                                                                            echo $r['givername']; 
                                                                                        else
                                                                                            echo 'Anonymous user';?></h2>
                                                                                        <p><?php echo $r['address']; ?></p>
                                                                                        <?php echo isset($r['star_ratings']['starRating'])?preg_replace("/\([^)]+\)/","",$r['star_ratings']['starRating']):'';?>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-9">

                                                                                    <!--row start-->
                                                                                    <div class="row">

                                                                                        <div class="col-md-11">
                                                                                            <div class="combaine-ss">


                                                                                                <div class="questin">
                                                                                                    <p><?php
                                                                                                    if($r['user_role'] == 'Performer')
                                                                                                        echo isset($category_questions_performer[0]['question'])?$category_questions_performer[0]['question']:'';
                                                                                                    else
                                                                                                        echo isset($category_questions_employer[0]['question'])?$category_questions_employer[0]['question']:''; ?>
                                                                                                </p>
                                                                                            </div> 
                                                                                            <?php  echo preg_replace("/\([^)]+\)/","",$r[0]); ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!--row close-->
                                                                                <!--row start-->
                                                                                <div class="row">
                                                                                    <div class="col-md-11">
                                                                                        <div class="combaine-ss">
                                                                                            <div class="questin">
                                                                                                <p><?php  if($r['user_role'] == 'Performer')
                                                                                                echo isset($category_questions_performer[1]['question'])?$category_questions_performer[1]['question']:'';
                                                                                                else
                                                                                                    echo isset($category_questions_employer[1]['question'])?$category_questions_employer[1]['question']:'';  ?>
                                                                                            </p>
                                                                                        </div>
                                                                                        <?php  echo preg_replace("/\([^)]+\)/","",$r[1]); ?> 
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <!--row close-->
                                                                            <div class="row">
                                                                                <div class="col-md-11">
                                                                                    <div class="combaine-ss">
                                                                                        <div class="questin">
                                                                                            <p><?php  if($r['user_role'] == 'Performer')
                                                                                            echo isset($category_questions_performer[2]['question'])?$category_questions_performer[2]['question']:'';
                                                                                            else
                                                                                                echo isset($category_questions_employer[2]['question'])?$category_questions_employer[2]['question']:'';  ?>
                                                                                        </p>
                                                                                    </div> 
                                                                                    <?php  echo preg_replace("/\([^)]+\)/","",$r[2]); ?>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-11">
                                                                                <div class="combaine-ss"> 
                                                                                    <div class="questin">
                                                                                        <p><?php if($r['user_role'] == 'Performer')
                                                                                        echo isset($category_questions_performer[3]['question'])?$category_questions_performer[3]['question']:'';
                                                                                        else
                                                                                            echo isset($category_questions_employer[3]['question'])?$category_questions_employer[3]['question']:'';  ?>
                                                                                    </p>
                                                                                </div> 
                                                                                <?php  echo preg_replace("/\([^)]+\)/","",$r[3]); ?>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <!--row start-->
                                                                    <div class="row">
                                                                        <div class="col-md-11">
                                                                            <div class="combaine-ss">
                                                                                <div class="questin">
                                                                                    <p><?php  if($r['user_role'] == 'Performer')
                                                                                    echo isset($category_questions_performer[4]['question'])?$category_questions_performer[4]['question']:'';
                                                                                    else
                                                                                        echo isset($category_questions_employer[4]['question'])?$category_questions_employer[4]['question']:'';  ?>,
                                                                                </p>
                                                                            </div> 
                                                                            <?php  echo preg_replace("/\([^)]+\)/","",$r[4]); ?>
                                                                        </div>



                                                                        <div id="modalDelete<?php echo $r['rate_id']?>" class="modal fade">
                                                                            <div class="modal-dialog modal-confirm">
                                                                                <div class="modal-content">
                                                                                    <div id="success"></div>
                                                                                    <div class="modal-header">        
                                                                                        <h4 class="modal-title">Are you sure?</h4>  
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <p>Do you really want to delete this review ?</p>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                                                                        <a href="<?php echo base_url();?>user/deleteReview/<?php echo encoding($user_id);?>/<?php echo encoding(get_current_user_id());?>" class="btn btn-danger">Delete</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>  
                                                                        <!--comment view-->
                                                                        <div class="coment-fd">
                                                                            <p><i class="fa fa-comment" aria-hidden="true"></i> <?php echo $r['message']; ?></p>
                                                                            <?php if($userType=='self' && $r['reply'] == ''){ ?>
                                                                                <div class="replaydX reply_" data-reply_id="<?php echo $r['rate_id'];?>" data-toggle="modal" data-target="#replyModal"><i class="fa fa-reply"></i> Reply</div>
                                                                            <?php } ?>
                                                                            <div class="reply_comment">
                                                                                <?php echo isset($r['reply'])?$r['reply']:'';
                                                                                ?>
                                                                            </div>
                                                                            <div id="replyModal" class="modal fade" role="dialog">
                                                                                <div class="modal-dialog">

                                                                                    <!-- Modal content-->
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h4 class="modal-title">Reply</h4>
                                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden" id="history" name="history" value="history">
                                                                                            <textarea class="form-control" id="reply" name="reply"></textarea>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-success send_reply" data-dismiss="modal">Send</button>
                                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                        <?php if(get_current_user_id() && get_current_user_id() == $r['retedbyid']){ ?>
                                                                            <a href="" class="delete_comments" data-toggle="modal" data-target="#modalDelete<?php echo $r['rate_id']?>"><i class="fa fa fa-trash-o"></i> Review</a>
                                                                        <?php } ?>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php $i++; }  } } ?> 

                                                </ul>

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
        <!-- The Modal start 22march -->
        <div class="modal fade" id="myModal5">
            <div class="modal-dialog">
                <div class="modal-content crox">
                    <!-- Modl Header -->

                    <button type="button" class="close crox" data-dismiss="modal">&times;</button>
                    <div id="ratings_"></div>
                    <div id="ratings_fail"></div>
                    <div class="witreview">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="mw">
                                    <ul>
                                        <form id="ratings">
                                            <li><input type="checkbox" name="anonymous" <?php echo (isset($anonymous->anonymous) && ($anonymous->anonymous==1))?'checked':''; ?> > Make review Anonymous</li>
                                            <li class="ful_cntant">
                                                <div class="howwas">
                                                    <i class="fa fa-check"></i>
                                                    <h2><?php if($user_role == 'Performer')
                                                    echo isset($category_questions_performer[0]['question'])?$category_questions_performer[0]['question']:'';
                                                    else
                                                        echo isset($category_questions_employer[0]['question'])?$category_questions_employer[0]['question']:'';?></h2>
                                                </div>
                                                <?php 
                                                $array5 = array(5);
                                                $array4 = array(4,5);
                                                $array3 = array(3,4,5);
                                                $array2 = array(2,3,4,5);
                                                $array1 = array(1,2,3,4,5);
                                                ?>
                                                <div class="stars">

                                                    <input class="star star-5" id="star-5" type="radio"  name="ques1" value="5"/>
                                                    <label class="star star-5 <?php 
                                                    if(isset($questionRating[0]) && in_array($questionRating[0],$array5)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-5"></label>
                                                    <input class="star star-4" id="star-4" type="radio"  name="ques1" value="4"/>
                                                    <label class="star star-4 <?php 
                                                    if(isset($questionRating[0]) && in_array($questionRating[0],$array4)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-4"></label>
                                                    <input class="star star-3" id="star-3" type="radio"  name="ques1" value="3"/>
                                                    <label class="star star-3 <?php 
                                                    if(isset($questionRating[0]) && in_array($questionRating[0],$array3)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-3"></label>
                                                    <input class="star star-2" id="star-2" type="radio"  name="ques1" value="2"/>
                                                    <label class="star star-2 <?php 
                                                    if(isset($questionRating[0]) && in_array($questionRating[0],$array2)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-2"></label>
                                                    <input class="star star-1" id="star-1" type="radio"  name="ques1" value="1"/>
                                                    <label class="star star-1 <?php 
                                                    if(isset($questionRating[0]) && in_array($questionRating[0],$array1)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-1"></label>

                                                </div>
                                            </li>

                                            <li class="ful_cntant">
                                                <div class="howwas">
                                                    <i class="fa fa-check"></i>
                                                    <h2><?php if($user_role == 'Performer')
                                                    echo isset($category_questions_performer[1]['question'])?$category_questions_performer[1]['question']:'';
                                                    else
                                                        echo isset($category_questions_employer[1]['question'])?$category_questions_employer[1]['question']:'';?></h2>
                                                </div>
                                                <div class="stars">

                                                    <input class="star star-5" id="star-6" type="radio"  name="ques2" value="5"/>
                                                    <label class="star star-5 <?php 
                                                    if(isset($questionRating[1]) && in_array($questionRating[1],$array5)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-6"></label>
                                                    <input class="star star-7" id="star-7" type="radio" name="ques2" value="4"/>
                                                    <label class="star star-7 <?php 
                                                    if(isset($questionRating[1]) && in_array($questionRating[1],$array4)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-7"></label>
                                                    <input class="star star-8" id="star-8" type="radio" name="ques2" value="3"/>
                                                    <label class="star star-8 <?php 
                                                    if(isset($questionRating[1]) && in_array($questionRating[1],$array3)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-8"></label>
                                                    <input class="star star-9" id="star-9" type="radio" name="ques2" value="2"/>
                                                    <label class="star star-9 <?php 
                                                    if(isset($questionRating[1]) && in_array($questionRating[1],$array2)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-9"></label>
                                                    <input class="star star-1" id="star-10" type="radio" name="ques2" value="1"/>
                                                    <label class="star star-1 <?php 
                                                    if(isset($questionRating[1]) && in_array($questionRating[1],$array1)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-10"></label>

                                                </div>
                                            </li>

                                            <li class="ful_cntant">
                                                <div class="howwas">
                                                    <i class="fa fa-check"></i>
                                                    <h2><?php if($user_role == 'Performer')
                                                    echo isset($category_questions_performer[2]['question'])?$category_questions_performer[2]['question']:'';
                                                    else
                                                        echo isset($category_questions_employer[2]['question'])?$category_questions_employer[2]['question']:'';?></h2>
                                                </div>
                                                <div class="stars">

                                                    <input class="star star-5" id="star-11" type="radio" name="ques3" value="5"/>
                                                    <label class="star star-5 <?php 
                                                    if(isset($questionRating[2]) && in_array($questionRating[2],$array5)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-11"></label>
                                                    <input class="star star-12" id="star-12" type="radio" name="ques3" value="4"/>
                                                    <label class="star star-12 <?php 
                                                    if(isset($questionRating[2]) && in_array($questionRating[2],$array4)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-12"></label>
                                                    <input class="star star-13" id="star-13" type="radio" name="ques3" value="3"/>
                                                    <label class="star star-13 <?php 
                                                    if(isset($questionRating[2]) && in_array($questionRating[2],$array3)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-13"></label>
                                                    <input class="star star-14" id="star-14" type="radio" name="ques3" value="2"/>
                                                    <label class="star star-14 <?php 
                                                    if(isset($questionRating[2]) && in_array($questionRating[2],$array2)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-14"></label>
                                                    <input class="star star-1" id="star-15" type="radio" name="ques3" value="1"/>
                                                    <label class="star star-1 <?php 
                                                    if(isset($questionRating[2]) && in_array($questionRating[2],$array1)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-15"></label>

                                                </div>
                                            </li>

                                            <li class="ful_cntant">
                                                <div class="howwas">
                                                    <i class="fa fa-check"></i>
                                                    <h2><?php if($user_role == 'Performer')
                                                    echo isset($category_questions_performer[3]['question'])?$category_questions_performer[3]['question']:'';
                                                    else
                                                        echo isset($category_questions_employer[3]['question'])?$category_questions_employer[3]['question']:'';?></h2>
                                                </div>
                                                <div class="stars">



                                                    <input class="star star-5" id="star-16" type="radio" name="ques4" value="5"/>
                                                    <label for="star-16" class="star star-5 <?php 
                                                    if(isset($questionRating[3]) && in_array($questionRating[3],$array5)){
                                                        echo 'feelin';
                                                    }
                                                    ?>"></label>


                                                    <input name="ques4" class="star star-17" id="star-17" type="radio" value="4"/>
                                                    <label class="star star-17 <?php 
                                                    if(isset($questionRating[3]) && in_array($questionRating[3],$array4)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-17"></label>
                                                    <input name="ques4" class="star star-18" id="star-18" type="radio" value="3"/>
                                                    <label class="star star-18 <?php 
                                                    if(isset($questionRating[3]) && in_array($questionRating[3],$array3)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-18"></label>
                                                    <input name="ques4" class="star star-19" id="star-19" type="radio" value="2"/>
                                                    <label class="star star-19 <?php 
                                                    if(isset($questionRating[3]) && in_array($questionRating[3],$array2)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-19"></label>
                                                    <input name="ques4" class="star star-1" id="star-20" type="radio" value="1"/>
                                                    <label class="star star-1 <?php 
                                                    if(isset($questionRating[3]) && in_array($questionRating[3],$array1)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-20"></label>

                                                </div>
                                            </li>

                                            <li class="ful_cntant">
                                                <div class="howwas">
                                                    <i class="fa fa-check"></i>
                                                    <h2><?php if($user_role == 'Performer')
                                                    echo isset($category_questions_performer[4]['question'])?$category_questions_performer[4]['question']:'';
                                                    else
                                                        echo isset($category_questions_employer[4]['question'])?$category_questions_employer[4]['question']:'';?></h2>
                                                </div>
                                                <div class="stars">

                                                    <input name="ques5" class="star star-5" id="star-21" type="radio" value="5"/>
                                                    <label class="star star-5 <?php 
                                                    if(isset($questionRating[4]) && in_array($questionRating[4],$array5)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-21"></label>
                                                    <input name="ques5" class="star star-22" id="star-22" type="radio" value="4"/>
                                                    <label class="star star-22 <?php 
                                                    if(isset($questionRating[4]) && in_array($questionRating[4],$array4)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-22"></label>
                                                    <input name="ques5" class="star star-23" id="star-23" type="radio" value="3"/>
                                                    <label class="star star-23 <?php 
                                                    if(isset($questionRating[4]) && in_array($questionRating[4],$array3)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-23"></label>
                                                    <input name="ques5" class="star star-24" id="star-24" type="radio" value="2"/>
                                                    <label class="star star-24 <?php 
                                                    if(isset($questionRating[4]) && in_array($questionRating[4],$array2)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-24"></label>
                                                    <input name="ques5" class="star star-1" id="star-25" type="radio" value="1"/>
                                                    <label class="star star-1 <?php 
                                                    if(isset($questionRating[4]) && in_array($questionRating[4],$array1)){
                                                        echo 'feelin';
                                                    }
                                                    ?>" for="star-25"></label>

                                                </div>
                                            </li>
                                            <div class="form-group">
                                                <textarea autofocus="" class="form-control tetx_bx andbts check_empty" name="message" id="messageTextarea" placeholder="Type Something ..." maxlength="140"><?php echo isset($questionRating[5])?$questionRating[5]:'';?></textarea>
                                            </div>
                                            <p class="comntss"> Upto 140 characters only </p>
                                            <input type="hidden" id="rated_to" name="rated_to" value="<?php echo isset($user_data->id)?$user_data->id:'';?>">
                                            <button type="button" onclick="saveData('ratings','<?php echo site_url('profile/ratings')?>','messageBox','messageerror')" class="sandss" id="SendMessageButton">Send</button>
                                        </form>
                                    </ul>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-12">
                                <div class="review_start">

                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--model close-->

    </section>

<!--profil close-->