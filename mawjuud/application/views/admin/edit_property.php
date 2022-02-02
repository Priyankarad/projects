<?php include APPPATH.'views/admin/includes/header.php';?>
<link href="<?php echo base_url();?>assets/css/richtext.min.css" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/intlTelInput.min.css" />
<style type="text/css">
	.intl-tel-input .flag-dropdown {
		position: absolute;
		z-index: 1;
		cursor: pointer;
		top: -1px !important;
	}
	span.ti-close {
		position: absolute;
		right: 5px;
		top: 0;
		color: white;
		z-index: 9;
		background: #ff3333;
		padding: 5px;
		font-size: 12px;
		cursor: pointer;
	}
	.ti-close:before {
		content: "\e646";
	}
</style>
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
									<li class="breadcrumb-item"><a href="<?php echo site_url('adusers');?>">Property List</a>
									</li>
									<li class="breadcrumb-item"><a href="#!"><?php echo isset($title)?$title:'';?></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<?php 
				$property_type = isset($propertyData->property_type)?$propertyData->property_type:'';
				?>
				<div class="page-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<h5><?php echo isset($title)?$title:'';?></h5>
								</div>
								<div class="card-block">
									<form id="editPropertyForm" method="post" enctype="multipart/form-data">
										<input type="hidden" name="property_id" value="<?php echo isset($propertyData->id)?$propertyData->id:'';?>">
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Property Title</label>
											<div class="col-sm-10">
												<input id="titleproperty" name="property_title" type="text"  placeholder="Add property title here" maxlength="60" value="<?php echo isset($propertyData->title)?$propertyData->title:'';?>" class="form-control validate[required]"/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Price (AED)</label>
											<?php 
											if($property_type == 'sale'){ ?>
												<div class="col-sm-10">
													<input id="price" name="price" value="<?php echo isset($propertyData->property_price)?number_format($propertyData->property_price):'';?>" type="text"  placeholder="Property Price" class="form-control validate[required]">                                 
												</div>
											<?php }else{ ?>
												<div class="col-sm-7">
													<input id="price" name="price" type="text"  placeholder="Rent price" value="<?php echo isset($propertyData->property_price)?number_format($propertyData->property_price):'';?>" class="form-control validate[required]"> 
												</div>
												<div class="col-sm-3">
													<select name="rent_duration" id="rent_duration" class="form-control validate[required]">
														<?php 
														$duration = isset($propertyData->rent_duration)?$propertyData->rent_duration:''; 
														?>
														<option value="">Select Duration</option>
														<option value="Yr" <?php echo ($duration == 'Yr')?'selected=selected':'';?>>/Yr.</option>
														<option value="Mo" <?php echo ($duration == 'Mo')?'selected=selected':'';?>>/Mo.</option>
														<option value="Wk" <?php echo ($duration == 'Wk')?'selected=selected':'';?>>/Wk.</option>
													</select>                              
												</div>

											<?php } ?>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Size (Sq. Ft.)</label>
											<div class="col-sm-10">
												<input name="square_feet" id="square_feet" value="<?php echo isset($propertyData->square_feet)?number_format($propertyData->square_feet):'';?>" type="text"  placeholder="Property Size" class="form-control validate[required]"/>
											</div>
										</div>
										<?php
										if(!empty($propertyData->bedselect)){
											$bed_1 = $propertyData->bedselect;
											?>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">Bed(s)</label>
												<div class="col-sm-10">
													<select name="beds" id="beds" class="form-control validate[required]">
														<option value="" disabled selected >Beds</option>
														<option value="100" <?php echo ($bed_1 == 100)?'selected=selected':'';?>>Studio</option>
														<?php 
														$bed = '';
														for($i=1; $i<=10; $i++){ 
															if($i == 1){
																$bed = '1 Bed';
															}else if($i>1 && $i<10){
																$bed = $i.' Beds';
															}else{
																$bed = '10+ Beds';
															}
															?>
															<option value="<?php echo $i;?>" <?php echo ($bed_1 == $i)?'selected=selected':'';?>><?php echo $bed;?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										<?php }  

										if(!empty($propertyData->bathselect)){
											$bath_1 = $propertyData->bathselect;
											?>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">Bath(s)</label>
												<div class="col-sm-10">
													<select name="baths" id="baths" class="form-control validate[required]">
														<option value="" disabled selected >Baths</option>
														<?php 
														$bath = '';
														for($i=1; $i<=10; $i++){ 
															if($i == 1){
																$bath = '1 Bath';
															}else if($i>1 && $i<10){
																$bath = $i.' Baths';
															}else{
																$bath = '10+ Baths';
															}
															?>
															<option value="<?php echo $i;?>" <?php echo ($bath_1 == $i)?'selected=selected':'';?>><?php echo $bath;?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										<?php } ?>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Date Available</label>
											<div class="col-sm-10">
												<input id="DateAvb" name="date_available" type="text" placeholder="Date Available" value="<?php echo !empty($propertyData->date_available)?date('M j, Y', strtotime($propertyData->date_available)):'';?>" class="form-control validate[required] datepicker">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Property Reference #</label>
											<div class="col-sm-10">
												<input id="leaseTrms" name="property_reference" type="text"  placeholder="Add property reference #" value="<?php echo !empty($propertyData->property_reference)?$propertyData->property_reference:'';?>" class="form-control validate[required]">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Security Deposit</label>
											<div class="col-sm-10">
												<input id="security_dps" name="security_deposit" type="text"  placeholder="Security Deposit" value="<?php echo !empty($propertyData->security_deposit)?$propertyData->security_deposit:'';?>" class="form-control validate[required]">
											</div>
										</div>

										<div class="form-group row">
											<?php 
											$view_type = !empty($propertyData->view_type)?$propertyData->view_type:'';
											?>
											<label class="col-sm-2 col-form-label">View</label>
											<div class="col-sm-10">
												<select id="view_type" name="view_type" class="form-control validate[required]">
													<option value="no" <?php echo  ($view_type == 'no')?'selected=selected':'';?>>No View</option>
													<option value="sea" <?php echo ($view_type == 'sea')?'selected=selected':'';?>>Sea View</option>
													<option value="community" <?php echo ($view_type == 'community')?'selected=selected':'';?>>Community View</option>
													<option value="park" <?php echo ($view_type == 'park')?'selected=selected':'';?>>Park View</option>
													<option value="street" <?php echo ($view_type == 'street')?'selected=selected':'';?>>Street View</option>
													<option value="partial_sea" <?php echo ($view_type == 'partial_sea')?'selected=selected':'';?>>Partial Sea View</option>
													<option value="city" <?php echo ($view_type == 'city')?'selected=selected':'';?>>City View</option>
													<option value="pool" <?php echo ($view_type == 'pool')?'selected=selected':'';?>>Pool View</option>
												</select>
											</div>
										</div>

										<div class="form-group row">
											<?php 
											$furnishing = !empty($propertyData->furnishing)?$propertyData->furnishing:'';
											?>
											<label class="col-sm-2 col-form-label">Furnishings</label>
											<div class="col-sm-10">
												<select id="furnishing" name="furnishing" class="form-control validate[required]">
													<option value="unfurnished" <?php echo ($furnishing == 'unfurnished')?'selected=selected':'';?>>Unfurnished</option>
													<option value="furnished" <?php echo ($furnishing == 'furnished')?'selected=selected':'';?>>Furnished</option>
													<option value="partial" <?php echo ($furnishing == 'partial')?'selected=selected':'';?>>Partial</option>
												</select>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Property Terms & Options</label>
											<div class="col-sm-10">
												<textarea type="text" name="property_terms" id="property_terms" placeholder="Add property terms here like , 4 cheque payment, One month free rent,. pay 5% down payment. Etc" class="form-control"><?php echo !empty($propertyData->property_terms)?$propertyData->property_terms:'';?></textarea>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Description</label>
											<div class="col-sm-10">
												<textarea type="text" name="description" class="textareaeditors form-control" placeholder="Add Property Description here" id="desctxtareas"><?php 
												echo !empty($propertyData->description)?$propertyData->description:'Add your Description here';
												?></textarea>
											</div>
										</div>

										<div class="form-group row">
											<h4>
												<div class="col-sm-12">Contact Information
												</div>
											</h4>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Name</label>
											<div class="col-sm-10">
												<input name="user_name" type="text"  placeholder="Your name here" class="form-control" value="<?php echo !empty($propertyData->user_name)?$propertyData->user_name:'';?>">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Email</label>
											<div class="col-sm-10">
												<input type="email" name="email" placeholder="demo@gmail.com" value="<?php echo !empty($propertyData->email)?$propertyData->email:'';?>" class="form-control">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Phone</label>
											<div class="col-sm-10">
												<input type="text" class="phone form-control" id="user_number" name="phone"  placeholder="(123) 456-7890" value="<?php echo !empty($propertyData->phone)?$propertyData->phone:'';?>">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Other Contact Number</label>
											<div class="col-sm-10">
												<input type="text" class="phone form-control" id="other_contact" name="other_contact"  placeholder="(123) 456-7890" value="<?php echo !empty($propertyData->other_contact)?$propertyData->other_contact:'';?>">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Other Contact Number</label>
											<div class="col-sm-10">
												<input type="checkbox" name="hide_property_address" <?php echo !empty($propertyData->hide_property_address)?'checked=checked':'';?> class="form-control"/>
											</div>
										</div>


										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Amenities and rules</label>
											<?php 
											$amenities1 = !empty($propertyData->amenities)?unserialize($propertyData->amenities):array();
											if(!empty($amenities['result'])){
												foreach ($amenities['result'] as $row) {  ?> 
													<div class="col-sm-12">
														<img src="<?php echo base_url();?>assets/images/amenities/<?php echo $row->image;?>" alt="icons" width="20" height="20">
														<input type="checkbox" value="<?php echo $row->id?>" name="amenities[]" <?php echo (in_array($row->id,$amenities1))?'checked':'';?>/>
														<span><?php echo $row->name?></span>
													</div>
												<?php }
											} ?>
										</div>


										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Additional Amenities</label>

											<div class="col-sm-10">
												<div class="newAmntsAppend">
													<?php 
													$amenities = !empty($propertyData->additional_amenities)?explode(',',$propertyData->additional_amenities):'';
													if(!empty($amenities)){
														foreach($amenities as $ame){
															?>
															<div class="group-checkbox"> 
																<label class="hide_P">
																	<span class=span_ami> <?php echo $ame;?> </span>
																</label> 
																<i class="removeTags"> x </i>
															</div>
														<?php }
													} ?>

												</div>

												<div class="positionrelt">
													<input type="text" name="additional_amenities" placeholder="Enter an amenity" id="additional_amenities" class="additional_amenities form-control">

													<input type="hidden" name="additional_amenities1" placeholder="Enter an amenity" id="additional_amenities1" class="additional_amenities" value="<?php echo 
													!empty($propertyData->additional_amenities)?$propertyData->additional_amenities:''; ?>">
													<button type="button" id="newAddAminities" class="btn btn-success"> Add </button>
												</div>
											</div>
										</div>


										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Photo & media</label>

											<div class="col-sm-10">
												<div id="dragimgappend">
													<?php 
													$index = 0;
													$images = !empty($propertyData->thumbnail_photo_media)?explode('|',$propertyData->thumbnail_photo_media):'';
													?>
													<?php if(!empty($images)){
														foreach($images as $img){ ?>
															<div class='col s2 documentUploadS'>
																<img class='imageThumb' src='<?php echo $img;?>' title=''>
															</img>
															<span class='ti-close selFile' data-file='' data-source="<?php echo $img;?>">
															</span>
														</div>
													<?php  }
												} ?>
												<input type="hidden" name="images" id="images" value="<?php echo str_replace('|',',',$propertyData->thumbnail_photo_media);?>">
											</div>
											<input type="file" id="filesss" multiple class="upload-fileS" accept="image/*" class="form-control" />
											<div class="documentUploadS">
												<label class="chsimg_btn fullsizeUpd" for="filesss"><span class="ti-plus"></span></label>
											</div> 
										</div>
									</div>


									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Showing availability</label>
										<div class="col-sm-10">
											<?php 
											$daysAvai = !empty($propertyData->availability_days)?unserialize($propertyData->availability_days):'';
											$index = 0;
											$days = array('Mondays','Tuesdays','Wednesdays','Thursdays','Fridays','Saturdays','Sundays');
											foreach($days as $day){ ?>
												<div class="row">
													<div class="col sm2">
														<p><?php echo $day;?></p>
													</div>
													<div class="col sm6">
														<ul class="checkmultipleD">
															<li>
																<div class="group-checkbox">
																	<label class="hide_P">
																		<input type="checkbox" name="<?php echo lcfirst($day);?>[0]" value="1" <?php echo
																		!empty($daysAvai[lcfirst($day)][0])?'checked':'';
																		?>/>
																		<span>Morning</span>
																	</label>
																</div>
															</li>
															<li>
																<div class="group-checkbox">
																	<label class="hide_P"><input type="checkbox" name="<?php echo lcfirst($day);?>[1]" value="2" <?php echo 
																	!empty($daysAvai[lcfirst($day)][1])?'checked':'';
																	?>/>
																	<span>Afternoon</span>
																</label>
															</div>
														</li>
														<li>
															<div class="group-checkbox">
																<label class="hide_P">
																	<input type="checkbox" name="<?php echo lcfirst($day);?>[2]" value="3" <?php echo 
																	!empty($daysAvai[lcfirst($day)][2])?'checked':'';
																	?>/>
																	<span>Evening</span>
																</label>
															</div>
														</li>
													</ul>
												</div>
											</div>
											<?php $index++; } ?>
										</div>
									</div>


									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Add Question</label>
										<div class="col-sm-10">
											<input type="checkbox" name="directly_listing" class="switchCheck" <?php echo !empty($questions['result'])?'checked':'';?> class="form-control">
										</div>
									</div>
									<?php $questionCount = !empty($questions['total_count'])?$questions['total_count']:0;?>
						<input type="hidden" id="quest_count" value="<?php echo $questionCount;?>">
									<div class="form-group row">
										<label class="col-sm-2 col-form-label"></label>
										<div class="col-sm-10">
											<div class="questionAnswer">
												<div class="addQuestionM">
													<button type="button" class="addBtnOT addQuestionT waves-effect waves-light"><span class="ti-plus"></span> Add Questions</button>
													<div id="questionsList">
														<?php if($questions['result']){ 
															foreach($questions['result'] as $quest){
																?>	
																<div><input type="text" name="questions[]" value="<?php echo $quest->question;?>"/>
																	<a class="remove_button">Delete</a>
																</div>
															<?php  }
														} ?>
													</div>
												</div>
											</div>
											<div id="questionsArray">
											</div>
										</div>
									</div>
									<input type="hidden" name="property_draft" id="property_draft">
									<div class="form-group row">
										<button type="submit" class="btn btn-success add_property">Update</button>
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
<script src="<?php echo base_url(); ?>assets/js/richtext.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/custom/edit_property.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>