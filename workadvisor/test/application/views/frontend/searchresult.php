<!--profil start-->

<!--section log_inheder start-->

<?php 

$imgs =""; 

$usernamefb = "";

if(!empty($user_data)){

     $imgs = ($user_data->profile !=  'assets/images/default_image.jpg')? $user_data->profile: base_url().'/assets/images/icon-facebook.gif';;

     if($user_data->business_name!=''){

        $usernamefb = $user_data->business_name;

    }else{

        $usernamefb = $user_data->firstname." ".$user_data->lastname;

    }

}

?>

<style type="text/css">

#share-buttons img {

    width: 35px;

    padding: 5px;

    border: 0;

    box-shadow: 0;

    display: inline;

}



</style>

<section class="profile_tab" >

    <div class="container">

        <div class="row">

            <div class="col-md-12 col-12 pl_inlft">

                <div class="tab_list">

                    <div class="card lc-wz">

                        <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" class="bell notification_toggle">

                                <a> <i class="fa fa-bell" ></i><span class="rivew-bell notification_bell">0</span> Notification </a><ul id="notifications_ul"><?php 

                                if($this->session->userdata('notifications'))

                                {

                                    echo $this->session->userdata('notifications');

                                }

                                ?></ul>

                            </li>  

                            <?php if(get_current_user_id()){ ?>

                                <li role="presentation">

                                    <a href="<?php echo base_url()?>user/favourites_list"> <i class="fa fa-heart" aria-hidden="true"></i> Favorites </a>

                                </li>   

                            <?php } ?>              

                            

                            <li role="presentation">

                                <a  aria-controls="ShareProfile" role="tab" data-toggle="tab">

                                    <i class="fa fa-share-square-o"></i> Share Profile

                                </a>

                            </li>





                            <div id="share-buttons" title="Share Profile">

                              <?php /*   <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url()?>viewdetails/profile/<?php echo encoding(get_current_user_id());?>" target="_blank">

                                    <i class="fa fa-facebook"></i>

                                </a> */ ?>

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

    <input type="hidden" id="base_url" value="<?php echo base_url() ?>">

</section>

<input type="hidden" name="base_url" value="<?php echo base_url()?>" id="base_url">

<section class="Dona_serch search_allP" style="margin-top:15px">

    <div class="container">

        <div class="row" id="body-row">



            <div class="col-md-2 col-12 sidebar-expanded" id="sidebar-container">

                <div class="sticky-top sticky-offset" >

                <form  method="post" id="searchfilter1" action="<?php echo base_url()?>search/searchFilter">

                    <div class="stars_searchRes_top">

                        <h1>Rating</h1>

                        <input type="hidden" id="searchTags" value="<?php echo isset($tags) ? $tags : ''; ?>" name="searchTags">

                        <input type="hidden" id="locality" value="<?php echo isset($locality) ? $locality : ''; ?>" name="locality">



                        <div class="stars_searchRes">

                            <p>

                                <input type="checkbox" name="stars[]" value="5" onclick="searchFilter()" /> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>

                            </p>

                            <p>

                                <input type="checkbox" name="stars[]" value="4" onclick="searchFilter()"/> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>

                            </p>

                            <p>

                                <input type="checkbox" name="stars[]" value="3" onclick="searchFilter()"/> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>

                            </p>

                            <p>

                                <input type="checkbox" name="stars[]" value="2" onclick="searchFilter()"/> <i class="fa fa-star"></i> <i class="fa fa-star"></i>

                            </p>

                            <p>

                                <input type="checkbox" name="stars[]" value="1" onclick="searchFilter()"/> <i class="fa fa-star"></i>

                            </p>

                        </div>

                    </div> 



                    <div class="stars_searchRes_top">

                        <h1>Reviews</h1>

                        <div class="stars_searchRes">

                            <p>

                                <input type="radio" name="mostleast" class="radio-btn" value="1" onclick="searchFilter()"/> Most To Least

                            </p>

                            <p>

                                <input type="radio" name="mostleast" class="radio-btn" value="2" onclick="searchFilter()"/> Least To Most

                            </p>

                        </div>

                    </div> 



                    <div class="stars_searchRes_top">

                        <h1>Profile Type</h1>

                        <div class="stars_searchRes">

                            <p>

                                <input type="radio" name="profile" class="radio-btn" value="1" onclick="searchFilter()"/> <!--Employer--> Business

                            </p>

                            <p>

                                <input type="radio" name="profile" class="radio-btn" value="2" onclick="searchFilter()"/> <!--Performer--> Individual

                            </p>

                        </div>

                    </div> 



                    <?php if(!empty($categoryData['result'])){?>

                        <div class="stars_searchRes_top">

                            <h1>Category</h1>

                            <div class="stars_searchRes">

                                <?php foreach($categoryData['result'] as $row){ 

                                    if($row->id!=1){?>

                                    <p>

                                        <input type="checkbox" value="<?php echo $row->id;?>" name="category[]" onclick="searchFilter()"/>&nbsp;&nbsp;<?php echo $row->name;?>

                                    </p>

                                <?php }

                                } ?>

                            </div>

                        </div> 

                    <?php } ?>

                </form>

                <!--col-3 close-->

            </div>

        </div>

            <!--col-3 close-->

            <div class="col-md-7 col-12">

                <div class="Donald">

                    <?php

                    if(!empty($results )){ $count =0; foreach($results as $row){

                        if($row->id!=get_current_user_id()){

                            $count++;

							/*** custom _url ***/

							$userProfileUrl = base_url('viewdetails/profile/'.encoding($row->id));

                            /*** custom _url end ***/

							$title=$row->firstname.' '.$row->lastname;

                            if($row->user_role=='Employer' && $row->user_role!=""){

                                $title=$row->business_name;

                            }



                            ?>

                            <div class="Donald_Boyd row">

                                <div class="col-md-3">

                                    <a href="<?php echo $userProfileUrl; ?>">

                                        <div class="main_kv">

                                            <img src="<?php echo (!empty($row->profile) && $row->profile!='assets/images/default_image.jpg') ? $row->profile : base_url().DEFAULT_IMAGE; ?>">

                                        </div>

                                    </a>

                                </div>

                                <div class="col-md-7">

                                    <div class="Donald_contnt">

                                        <div class="img_id">

                                            <a href="<?php echo $userProfileUrl; ?>">

                                                <h1><?php echo ucwords($title); ?></h1>

                                            </a>

                                            <p><?php 

                                            $address = array();

                                            if(isset($row->city) && !empty($row->city))

                                                $address[] = trim($row->city);

                                            if(isset($row->state) && !empty($row->state))

                                                $address[] = trim($row->state);

                                            if(isset($row->country) && !empty($row->country))

                                                $address[] = trim($row->country);

                                            if(isset($row->zip) && !empty($row->zip))

                                                $address[] = trim($row->zip);

                                            if(!empty($address)){

                                                $address = implode(", ", $address);

                                                echo $address;

                                            }

// $row->city.', '.$row->state.', '.$row->country.' '.$row->zip; ?></p>

										</div>

										<div class="strt">

											<?php 

											if($row->user_role!='Employer' && $row->user_role!=''){

												$ratingData =  userOverallRatings($row->id);

												if(isset($ratingData['starRating'])){

													echo $ratingData['starRating'];

												}

											}

											?>

										</div>

									</div>

								</div>

<div class="col-md-2">

    <div class="main_3btn donald sticky-top sticky-offset">

        <?php 

        if($row->user_role=='Employer'){ // employer row



            if($userRole == 'Employer'){ // current logged in employer

            }

            else{  // current logged in performer

                if(get_current_user_id()){

                    $userOne=get_current_user_id();

                    $userTwo=$row->id;

                    $isRequest=checkRequest($userOne,$userTwo);

                    $requestedByUser = jobRequestedBy($userOne,$row->id);

                    if($requestedByUser != $userOne && $requestedByUser!=0 && $isRequest!='Accepted'){

                        $isRequest = 'NotConfirm';

                    }

                }else{

                    $isRequest="No";  

                }

                if($isRequest=='No'){ ?>

                    <button class="btn btn-info btn-sm" class="jBrQ" onclick="sendJobRequest('<?php echo encoding($row->id); ?>',this)" >

                        <i class="fa fa-plus"></i> Job Request

                    </button>

                <?php }

                else if($isRequest=='NotConfirm'){ 

                    $senderID = get_current_user_id();

                    $requestedByUser = jobRequestedBy($senderID,$row->id);

                    ?>

                    <?php if($requestedByUser != $senderID && $requestedByUser!=0){ ?>

                        <button class="btn btn-info btn-sm" class="jBrQ" onclick="jobRequest('<?php echo encoding($row->id); ?>','Accept','<?php echo 'FR'.$row->id; ?>',this,'per')" >

                            <i class="fa fa-plus"></i> Accept Request 

                        </button>

                    <?php }else{ ?>

                        <button class="btn btn-info btn-sm" class="jBrQ" >

                            <i class="fa fa-clock-o" aria-hidden="true"></i>  Pending

                        </button>

                    <?php } ?>

                <?php }

                else if($isRequest=='Pending'){ 

                    ?> 

                    <button class="btn btn-info btn-sm" class="jBrQ" >

                        <i class="fa fa-clock-o" aria-hidden="true"></i>  Pending

                    </button>

                <?php }

                else if($isRequest=='Accepted'){



                }

                else{

                    echo '';

                } 

            }

        }else{ // performer row

            if($userRole == 'Employer'){ // current logged in employer

                if(get_current_user_id()){

                    $userOne=get_current_user_id();

                    $userTwo=$row->id;

                    $isRequest=checkRequest($userOne,$userTwo);

                }else{

                    $isRequest="No";  

                }

                 if($isRequest=='No'){ ?>

                    <button class="btn btn-info btn-md" class="jBrQ" onclick="sendJobRequest('<?php echo encoding($row->id); ?>',this,'emp');" >

                        <i class="fa fa-plus"></i> Job Request

                    </button>

                <?php }else if($isRequest=='NotConfirm'){

                    $senderID = get_current_user_id();

                    $requestedByUser = jobRequestedBy($row->id,$senderID);

                    ?>

                    <?php if($requestedByUser != $senderID && $requestedByUser!=0){ ?>

                        <button class="btn btn-info btn-sm" class="jBrQ" onclick="jobRequest('<?php echo encoding($row->id); ?>','Accept','<?php echo 'FR'.$row->id; ?>',this)" >

                            <i class="fa fa-plus"></i> Accept Request 

                        </button>

                    <?php }else{ ?>

                        <button class="btn btn-info btn-sm" class="jBrQ" >

                            <i class="fa fa-clock-o" aria-hidden="true"></i>  Pending

                        </button>

                    <?php } 

                 ?>

                    <!-- <button class="btn btn-info btn-md" class="jBrQ" onclick="jobRequest('<?php echo encoding($row->id); ?>','Accept','<?php echo 'FR'.$row->id; ?>',this)" >

                        <i class="fa fa-plus"></i> Accept Request

                    </button> -->

                <?php } else if($isRequest=='Pending'){ 

                    ?>

                    <button class="btn btn-info btn-sm" class="jBrQ" >

                        <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;&nbsp;Pending

                    </button>

                <?php }else if($isRequest=='Accepted'){



                }

                else{

                    echo '';

                }

            }else{

                if(get_current_user_id()){

                    $userOne=get_current_user_id();

                    $userTwo=$row->id;

                    $isFriend=checkFriend($userOne,$userTwo);

                }else{

                    $isFriend="No"; 

                }



                if($isFriend=='No'){ ?>

                    <div class="Chery3">

                        

                        <a onclick="addfriend('<?php echo encoding($row->id); ?>',this)" href="javascript:void(0)"><i class="fa fa-plus"></i> Add Friend</a>

                    </div>

                <?php }else if($isFriend=='NotConfirm'){ ?>

                    <div class="Chery3">

                        <i class="fa fa-plus"></i>

                        <a href="javascript:void(0)" onclick="friendRequest('<?php echo encoding($row->id); ?>','Accept','<?php echo 'FR'.$row->id; ?>')"> Confirm</a>

                    </div>

                <?php }else if($isFriend=='Pending'){ ?>

                    <div class="Chery3">

                        <a href="javascript:void(0)"> <i class="fa fa-clock-o"></i>&nbsp;&nbsp;Pending</a>

                    </div>

                <?php }else if($isFriend=='Accepted'){



                }else{ echo ''; } 

            }

        }

?>

<div class="Chery3 send_btn donal">

    <a href="<?php echo $userProfileUrl."?msg=1"; ?>"> 

        Send Message

    </a>

</div>

<?php 

$isFavourite = '';

    if(get_current_user_id()){

        $isFavourite = isFavourite(get_current_user_id(),$row->id);

    }

if($isFavourite == '' || $isFavourite == 'no'){

?>

<div class="Chery3 send_btn donal">

    <span  class="favourites unfavorites_wa" data-other_id = "<?php echo isset($row->id)?$row->id:'';?>"> 

        <i class="fa fa-heart-o" aria-hidden="true"></i>

        Add to favorites

    </span>

</div>

<?php }else{ ?>

<div class="Chery3 send_btn donal">

    <span  class="favourites favorites_wa" data-other_id = "<?php echo isset($row->id)?$row->id:'';?>"> 

        <i class="fa fa-heart" aria-hidden="true"></i>

        Favorite

    </span>

</div>

<?php } ?>

</div>

</div>

</div>

<?php } }  if($count == 0){ ?>

    <div class="alert alert-danger">

        <strong>Oops!</strong> No Result Found.

    </div>

<?php } } else{ ?>

    <div class="alert alert-danger">

        <strong>Oops!</strong> No Result Found.

    </div>

<?php } ?>

<!--second stat-->

</div>

<!----------

<div class="row mar_tp">

<div class="col-md-4 col-12">

<ul class="pagination">

<li class="page-item"><a class="page-link b_chn" href="#">1</a></li>

<li class="page-item"><a class="page-link" href="#">2</a></li>

<li class="page-item"><a class="page-link" href="#">3</a></li>

<li class="page-item"><a class="page-link" href="#">4</a></li>

<li class="page-item"><a class="page-link" href="#">5</a></li>

<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a></li>

</ul> 

</div> 

</div>

--------->

</div>

<div class="col-md-3 col-12 mt-4">

<!-- work_advisor_searchresult 

<ins class="adsbygoogle"

     style="display:block"

     data-ad-client="ca-pub-3979824042791728"

     data-ad-slot="6332689816"

     data-ad-format="auto"

     data-full-width-responsive="true"></ins>

<script>

(adsbygoogle = window.adsbygoogle || []).push({});

</script>-->



    <br>

    <!-- workadvisor searchresult sidebar 2 -->

    <!-- <ins class="adsbygoogle"

    style="display:inline-block;width:250px;height:250px"

    data-ad-client="ca-pub-3979824042791728"

    data-ad-slot="9695297554"></ins>

    <script>

        (adsbygoogle = window.adsbygoogle || []).push({});

    </script> -->

    <br>

    <!-- workadvisor searchresult sidebar 3 -->

   <!--  <ins class="adsbygoogle"

    style="display:inline-block;width:250px;height:250px"

    data-ad-client="ca-pub-3979824042791728"

    data-ad-slot="8645105613"></ins>

    <script>

        (adsbygoogle = window.adsbygoogle || []).push({});

    </script> -->

</div>	



</div>



</section>

<!--profil close-->



<style type="text/css">

.serch-contant {

    position: relative;

}

.ixon {

    position: absolute;

    right: 11px;

    top: 6px;

}

.blank-start{

    position: relative;

}

.blank-start::before {

    content: '\f006';

    font-family: FontAwesome;

    font-style: normal;

    color: #51c821;

}

.staress i {

    color: #51c821;

}

</style>



