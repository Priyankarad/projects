<!-- <?php
//pr($favouritesData);
?> -->

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
							
							<li role="presentation">
								<a  aria-controls="ShareProfile" role="tab" data-toggle="tab">
									<i class="fa fa-share-square-o"></i> Share Profile
								</a>
							</li>
							<div id="share-buttons" title="Share Profile">
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
		<div class="row">
			<div class="col-md-7 col-12">
				<h4>My Favorites</h4>
				<div class="Donald">
					<?php
					if(!empty($favouritesData['result'])){ $count =0; foreach($favouritesData['result'] as $row){
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
												<h1><?php echo $title; ?></h1>
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
											?></p>
										</div>
										<div class="strt">
											<?php 
											if($row->user_role!='Employer'){
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
									<div class="main_3btn donald">
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
												<span  class="favourites unfavorites_wa" data-other_id = "<?php echo isset($row->id)?$row->id:'';?>" data-fvrt="1"> 
													<i class="fa fa-heart-o" aria-hidden="true"></i>
													Add to favorites
												</span>
											</div>
										<?php }else{ ?>
											<div class="Chery3 send_btn donal">
												<span  class="favourites favorites_wa" data-other_id = "<?php echo isset($row->id)?$row->id:'';?>" data-fvrt="1"> 
													<i class="fa fa-heart " aria-hidden="true"></i>
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

				</div>


			</div>

		</section>
