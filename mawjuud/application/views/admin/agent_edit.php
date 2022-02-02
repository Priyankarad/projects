<?php include APPPATH.'views/admin/includes/header.php';?>
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		<div class="main-body">
			<div class="page-wrapper">
				<!-- Page-header start -->
				<div class="page-header">
					<div class="row align-items-end">
						<div class="col-lg-8">
							<div class="page-header-title">
								<div class="d-inline">
									<h4><?php echo isset($title)?$title:'';?></h4>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="page-header-breadcrumb">
								<ul class="breadcrumb-title">
									<li class="breadcrumb-item">
										<a href="<?php echo site_url('dashboard');?>"> <i class="feather icon-home"></i> </a>
									</li>
									<li class="breadcrumb-item"><a href="<?php echo site_url('adagents');?>">Agents List</a>
									</li>
									<li class="breadcrumb-item"><a href="#!"><?php echo isset($title)?$title:'';?></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="page-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<h5><?php echo isset($title)?$title:'';?></h5>
								</div>
								<div class="card-block">
									<form id="adminForm" action="<?php echo site_url('agent_edit/'.encoding(isset($userData->id)?$userData->id:''));?>" method="post" enctype= multipart/form-data>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Firstname</label>
											<div class="col-sm-10">
												<input type="text" class="form-control validate[required,custom[onlyLetterSp]]" id="firstname" name="firstname" value="<?php echo isset($userData->firstname)?$userData->firstname:'';?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Lastname</label>
											<div class="col-sm-10">
												<input type="text" id="lastname" name="lastname" class="form-control validate[required,custom[onlyLetterSp]]" value="<?php echo isset($userData->lastname)?$userData->lastname:'';?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Email</label>
											<div class="col-sm-10">
												<input type="text" id="email" name="email" class="form-control" readonly="" value="<?php echo isset($userData->email)?$userData->email:'';?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Agency Name</label>
											<div class="col-sm-10">
												<input type="text" id="agency_name" name="agency_name" class="form-control" value="<?php echo isset($userData->agency_name)?$userData->agency_name:'';?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Agency Phone</label>
											<div class="col-sm-10">
												<input type="text" id="agency_phone" name="agency_phone" class="form-control validate[mob_number]" value="<?php echo isset($userData->agency_name)?$userData->agency_name:'';?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Country Code</label>
											<div class="col-sm-10">
												<input type="text" id="country_code" name="country_code" class="form-control" value="<?php echo isset($userData->user_country_code)?$userData->user_country_code:'';?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Cell Phone</label>
											<div class="col-sm-10">
												<input type="text" id="cell_phone" name="cell_phone" class="form-control validate[custom[mob_number]]" value="<?php echo isset($userData->user_number)?$userData->user_number:'';?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Upload Profile Image</label>
											<div class="col-sm-9">
												<input type="file" id="profile_img" name="profile_img" class="form-control" accept="image/*">
											</div>
											<?php
											$img = base_url().DEFAULT_PROPERTY_IMAGE;
											if(checkRemoteFile($userData->profile_thumbnail)){
												$img = $userData->profile_thumbnail; 
											}
											?>
											<div class="col-sm-1 user_img">
												<img id="user_img" src="<?php echo $img;?>" height="100" width="100">
											</div>
										</div>

									<hr>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Professional Licenses :</label>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Description</label>
											<div class="col-sm-10">
												<input type="text" id="license_description" name="license_description" class="form-control" value="<?php echo isset($userData->license_description)?$userData->license_description:'';?>">
											</div>
										</div>

										<div class="LicensesRepeat">
											<?php 
											$licenses_number = isset($userData->licenses_number)?explode(",",$userData->licenses_number):array();
											if(!empty($licenses_number)){
												$count = 0;
												foreach($licenses_number as $lic){
													$count++;
													?>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Licenses #:</label>
														<div class="col-sm-9">
															<input name="licenses_number[]" type="text" class="form-control" value="<?php echo $lic;?>"/>
														</div>
														<?php if($count == 1){ ?>
															<div class="col-sm-1">
																<button type="button" class="addMoreField waves-effect waves-light btn btn-info">+</button>
															</div>
														<?php }else{ ?>
															<div class="col-sm-1">
																<button type="button" class="closeField waves-effect waves-light btn btn-danger">-</button>
															</div>
													<?php } ?>
													</div>
												<?php }
											}
											else{ ?>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Licenses #:</label>
													<div class="col-sm-9">
														<input name="licenses_number[]" type="text" class="form-control"/>
													</div>
													<div class="col-sm-1">
														<button type="button" class="addMoreField waves-effect waves-light btn btn-info">+</button>
													</div>
												</div>
												<?php 
											} ?>
										</div>
										<hr>


										<div class="servicesRepeat">
											<?php 
											$services_area = isset($userData->services_area)?explode(",",$userData->services_area):array();
													if(!empty($services_area)){
														$count = 0;
														foreach($services_area as $ser){
															$count++;
													?>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Services Areas #:</label>
														<div class="col-sm-9">
															<input id="services_area" name="services_area[]" type="text" class="form-control" value="<?php echo $ser;?>"/>
														</div>
														<?php if($count == 1){ ?>
															<div class="col-sm-1">
																<button type="button" class="addMoreField2 waves-effect waves-light btn btn-info">+</button>
															</div>
														<?php }else{ ?>
															<div class="col-sm-1">
																<button type="button" class="closeField waves-effect waves-light btn btn-danger">-</button>
															</div>
													<?php } ?>
													</div>
												<?php }
											}
											else{ ?>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Services Areas #:</label>
													<div class="col-sm-9">
														<input id="services_area" name="services_area[]" type="text" class="form-control"/>
													</div>
													<div class="col-sm-1">
														<button type="button" class="addMoreField2 waves-effect waves-light btn btn-info">+</button>
													</div>
												</div>
												<?php 
											} ?>
										</div>
										<hr>



										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Language Fluency </label>
											<?php $languages = isset($userData->language)?explode(",",$userData->language):array();?>
											<div class="col-sm-10">

												<div class="">
													<label>
														<input type="checkbox" id="language" name="language[]" value="spanish" <?php echo (in_array("spanish",$languages))?'checked':''; ?>>
														<span class="cr">
															<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
														</span>
														<span>Spanish</span>
													</label>
												</div>

												<div class="">
													<label>
														<input type="checkbox" id="language1" name="language[]" value="mandarin" <?php echo (in_array("mandarin",$languages))?'checked':''; ?>>
														<span class="cr">
															<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
														</span>
														<span>Mandarin</span>
													</label>
												</div>

												<div class="">
													<label>
														<input type="checkbox" id="language2" name="language[]" value="french" <?php echo (in_array("french",$languages))?'checked':''; ?>>
														<span class="cr">
															<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
														</span>
														<span>French</span>
													</label>
												</div>

												<div class="">
													<label>
														<input type="checkbox" id="language" name="language[]" value="russian" <?php echo (in_array("russian",$languages))?'checked':''; ?>>
														<span class="cr">
															<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
														</span>
														<span>Russian</span>
													</label>
												</div>

											</div>
										</div>

                            
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Profile Video</label>
											<div class="col-sm-10">
												<input type="text" id="profile_video" name="profile_video" class="form-control validate[custom[url]]" value="<?php echo isset($userData->profile_video)?$userData->profile_video:'';?>">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Website</label>
											<div class="col-sm-10">
												<input type="text" id="website_url" name="website_url" class="form-control validate[custom[url]]" value="<?php echo isset($userData->website_url)?$userData->website_url:'';?>">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Blog</label>
											<div class="col-sm-10">
												<input type="text" id="blog" name="blog" class="form-control validate[custom[url]]" value="<?php echo isset($userData->blog)?$userData->blog:'';?>">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Facebook</label>
											<div class="col-sm-10">
												<input type="text" id="fb_url" name="fb_url" class="form-control validate[custom[url]]" value="<?php echo isset($userData->fb_url)?$userData->fb_url:'';?>">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Twitter</label>
											<div class="col-sm-10">
												<input type="text" id="twitter_url" name="twitter_url" class="form-control validate[custom[url]]" value="<?php echo isset($userData->twitter_profile_url)?$userData->twitter_profile_url:'';?>">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Linkedin</label>
											<div class="col-sm-10">
												<input type="text" id="linkedin_url" name="linkedin_url" class="form-control validate[custom[url]]" value="<?php echo isset($userData->linkedin_profile_url)?$userData->linkedin_profile_url:'';?>">
											</div>
										</div>


										<div class="form-group row">
											<button type="submit" class="btn btn-success">Update</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include APPPATH.'views/admin/includes/footer.php';?>
<script type="text/javascript" src="<?php echo site_url('assets/admin/js/custom/user.js');?>"></script>