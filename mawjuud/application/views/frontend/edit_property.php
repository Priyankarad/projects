<?php include APPPATH.'views/frontend/includes/header.php'; ?>




<!--================ Edit-Property ==================-->
<!--================ Edit-Property ==================-->
<?php 
$property_type = isset($propertyData->property_type)?$propertyData->property_type:'';
?>
<div class="addListingP mw-editproperty" id="topViewAdd">
	<div class="container">
		<div class="addListingParent">
			<form id="editPropertyForm" method="post" class="addPropertyForm" enctype="multipart/form-data">
				<input type="hidden" name="property_id" value="<?php echo isset($propertyData->id)?$propertyData->id:'';?>">
				<input type="hidden" name="latitude" id="latitude" value="<?php echo isset($propertyData->latitude)?$propertyData->latitude:'';?>">
				<input type="hidden" name="longitude" id="longitude" value="<?php echo isset($propertyData->longitude)?$propertyData->longitude:'';?>">
				<div class="add_maps_list">
					<h5>Edit Properties</h5>
					<div class="map_setX">
						<div id="map_canvas_1" width="100%">  
						</div>

						<div class="mapEditOption">
							<div class="groupMapPin">
								<span class="ti-location-pin"></span>
								<input id="searchLocationS1" name="search_location1" type="text" class="validate" placeholder="Enter a location" autocomplete="off" value="<?php echo isset($propertyData->property_address)?$propertyData->property_address:'';?>">
								<button type="button" class="addBtnOT codeAddressDetail" onclick="codeAddressDetail()"><span class="ti-search"></span></button>
							</div>
						</div>
						<div class="mapEditOption2">
							<div class="input-groupMapPin">
								<input id="neighbourhood1" name="neighbourhood1" type="text" class="validate" value="<?php echo isset($propertyData->neighbourhood)?$propertyData->neighbourhood:'';?>">
								<label for="searchLocationS">Building / Complex / Neighbourhood </label>
							</div>
						</div> 

					</div>
					<div class="addPlistingS">  
						<ul class="tabs">
							<li class="tab"><a class="active" href="#addlistP1">Listing</a></li>
							<li class="tab"><a href="#addlistP2">Contacts</a></li>
							<li class="tab"><a href="#addlistP3">Applications</a></li>
							<li class="tab"><a href="#addlistP4">Payments</a></li>
						</ul>
						<div id="addlistP1">
							<div class="listingSM">
								<div class="hideDivSkip">
									<!-- <h5>Listing features</h5> -->
									<div class="row">
										<div class="col s2">
											<h5>Listing features</h5>
										</div>
										<div class="list_f">
											<?php 
											if($property_type == 'sale'){
												echo '<div class="col s1 list_sale">For Sale</div>';
											}else{
												echo '<div class="col s1 list_rent">For Rent</div>';
											}
											?>
										</div>
									</div>
									<div class="row MawjuudlisTopl">
										<div class="col s4">
											<div class="inlineTxts">
												<div id="aed"><?php echo isset($propertyData->property_price)?number_format($propertyData->property_price).' ':'';?></div>
												&nbsp;
												<div id="duration">
													<?php 
													if($property_type == 'rent'){ 
														echo isset($propertyData->rent_duration)?'AED/'.$propertyData->rent_duration.'.':'AED';

													}
													?>	

												</div>
											</div>
										</div>
										<div class="col s4 bed_bath">
											<div class="UlinlineTxts">
												<div id="bed1">
													<?php 
													if(!empty($propertyData->bedselect)){
														$bed = $propertyData->bedselect;
														if($bed == 100){
															$bed = 'Studio Bed';
														}
														if($bed == 10){
															$bed = '10+ Beds';
														}
														if($bed > 1){
															$bed = $bed.' Beds';
														}
														if($bed == 1){
															$bed = $bed.' Bed';
														}
														echo $bed.' ';
														?>
														<img src="<?php echo base_url();?>assets/images/bed1.png" alt=""/>
													<?php }
													?>
												</div>
												<div id="bath1">
													<?php 
													if(!empty($propertyData->bathselect)){
														$bath = $propertyData->bathselect;

														if($bath == 10){
															$bath = '10+ Baths';
														}
														if($bath > 1){
															$bath = $bath.' Baths';
														}
														if($bath == 1){
															$bath = $bath.' Bath';
														}
														echo $bath.' ';
														?>
														<img src="<?php echo base_url();?>assets/images/bath1.png" alt=""/>
													<?php }
													?>
												</div>
											</div>
										</div>
										<div class="col s4 square_feet">
											<div class="aedPriceAqaures">
												<?php echo isset($propertyData->square_feet)?number_format($propertyData->square_feet).' Sq. ft.':'';?>
											</div>
										</div>
									</div>
								</div>

								<div class="details_2">
									<h5>Details and description 
										<span class="selectcat-imgs">
											<?php 
											if(!empty($propertyData->name)){ ?>
												<img src="<?php echo base_url('assets/images').'/'.$propertyData->cat_img;?>" alt="images"/> <?php echo $propertyData->name; ?>
											<?php }
											?>
										</span>
									</h5>
									<div class="row">
										<div class="col s12">
											<div class="input-field">
												<label>Property Title</label>
												<input id="titleproperty" name="property_title" type="text"  placeholder="Add property title here" maxlength="200" value="<?php echo isset($propertyData->title)?$propertyData->title:'';?>" />
											</div>       
										</div>
									</div>
									<div class="row">
										<?php 
										if($property_type == 'sale'){ ?>
											<div class="col s6 full_rent">
												<div class="input-field Sale-price9">
													<label>Price (AED)</label>
													<input id="price" name="price" value="<?php echo isset($propertyData->property_price)?number_format($propertyData->property_price):'';?>" type="text"  placeholder="Property Pricee">
												</div>                                           
											</div>
										<?php }else{ ?>
											<div class="col s6 RntFullCol half_rent">
												<div class="RntFullColMain">
													<div class="input-field RntSelect">
														<label>Price (AED)</label>
														<input id="price" name="price" type="text"  placeholder="Rent price" value="<?php echo isset($propertyData->property_price)?number_format($propertyData->property_price):'';?>">
														<select name="rent_duration" id="rent_duration">
															<?php 
															$duration = isset($propertyData->rent_duration)?$propertyData->rent_duration:''; 
															?>
															<option value="">Select Duration</option>
															<option value="Yr" <?php echo ($duration == 'Yr')?'selected=selected':'';?>>/Yr.</option>
															<option value="Mo" <?php echo ($duration == 'Mo')?'selected=selected':'';?>>/Mo.</option>
															<option value="Wk" <?php echo ($duration == 'Wk')?'selected=selected':'';?>>/Wk.</option>
														</select>
													</div>
												</div>
											</div>
										<?php } ?>

										<div class="col s6">
											<div class="input-field">
												<label>Size (Sq. Ft.)</label>
												<input name="square_feet" id="square_feet" value="<?php echo isset($propertyData->square_feet)?number_format($propertyData->square_feet):'';?>" type="text" class="" placeholder="Property Size">
											</div>
										</div>
									</div>
									<div class="row">
										<?php
										if(!empty($propertyData->bedselect)){
											$bed_1 = $propertyData->bedselect;
											?>
											<div class="col s6">
												<div class="input-field" id="bed_details">
													<select name="beds" id="beds">

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
													<label>Bed(s)</label>
												</div>
											</div>
										<?php } 

										if(!empty($propertyData->bathselect)){
											$bath_1 = $propertyData->bathselect;
											?>
											<div class="col s6">
												<div class="input-field" id="bath_details">
													<select name="baths" id="baths">
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
													<label>Bath(s)</label>
												</div>
											</div>
										<?php  } ?>
									</div>

									<div class="row">
										<div class="col s6">
											<div class="input-field RntSelect">
												<label>Date Available</label>
												<input id="DateAvb" name="date_available" type="text" class="datepicker" placeholder="Date Available" value="<?php echo !empty($propertyData->date_available)?date('M j, Y', strtotime($propertyData->date_available)):'';?>">
												<span class="ti-calendar"></span>
											</div><br/><br/>
											<div class="input-field mtop5">
												<label>Property Reference #</label>
												<input id="leaseTrms" name="property_reference" type="text" class="" placeholder="Add property reference #" value="<?php echo !empty($propertyData->property_reference)?$propertyData->property_reference:'';?>">
											</div><br/><br/>
											<div class="input-field securtyDsptb mtop5">
												<label>Security Deposit</label>
												<input id="security_dps" name="security_deposit" type="text"  placeholder="Security Deposit" value="<?php echo !empty($propertyData->security_deposit)?$propertyData->security_deposit:'';?>">
											</div>
										</div>

										<div class="col s6">
											<div class="input-field mawjuud-tnspc"> 
												<?php 
												$view_type = !empty($propertyData->view_type)?$propertyData->view_type:'';
												?>
												<select id="view_type" name="view_type">
													<option value="no" <?php echo  ($view_type == 'no')?'selected=selected':'';?>>No View</option>
													<option value="sea" <?php echo ($view_type == 'sea')?'selected=selected':'';?>>Sea View</option>
													<option value="community" <?php echo ($view_type == 'community')?'selected=selected':'';?>>Community View</option>
													<option value="park" <?php echo ($view_type == 'park')?'selected=selected':'';?>>Park View</option>
													<option value="street" <?php echo ($view_type == 'street')?'selected=selected':'';?>>Street View</option>
													<option value="partial_sea" <?php echo ($view_type == 'partial_sea')?'selected=selected':'';?>>Partial Sea View</option>
													<option value="city" <?php echo ($view_type == 'city')?'selected=selected':'';?>>City View</option>
													<option value="pool" <?php echo ($view_type == 'pool')?'selected=selected':'';?>>Pool View</option>
												</select>
												<label>View</label>
											</div>
											<div class="input-field mawjuud-tnspc">
												<?php 
												$furnishing = !empty($propertyData->furnishing)?$propertyData->furnishing:'';
												?>
												<select id="furnishing" name="furnishing">
													<option value="unfurnished" <?php echo ($furnishing == 'unfurnished')?'selected=selected':'';?>>Unfurnished</option>
													<option value="furnished" <?php echo ($furnishing == 'furnished')?'selected=selected':'';?>>Furnished</option>
													<option value="partial" <?php echo ($furnishing == 'partial')?'selected=selected':'';?>>Partial</option>
												</select>
												<label>Furnishings</label>
											</div>
											<div class="input-field">
												<label>Property Terms & Options</label>
												<textarea type="text" name="property_terms" id="property_terms" class="" placeholder="Add property terms here like , 4 cheque payment, One month free rent,. pay 5% down payment. Etc"><?php echo !empty($propertyData->property_terms)?$propertyData->property_terms:'';?></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col s12">
											<div class="input-field">
												<label class="active">Description</label>
												<textarea type="text" name="description" class="textareaeditors" placeholder="Add Property Description here" id="desctxtareas"><?php 
												echo !empty($propertyData->description)?$propertyData->description:'Add your Description here';
												?></textarea>
											</div>
										</div>
									</div>
									<div class="row hide" id="options_term">
										<div class="col s12">
											<div class="input-field">
												<label>Property Terms & Options</label>
												<div id="term_text"></div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="details_2">
								<h5>Contact information</h5>
								<div class="row">
									<div class="col s6">
										<div class="input-field">
											<label>Name </label>
											<input name="user_name" type="text"  placeholder="Your name here" value="<?php echo !empty($propertyData->user_name)?$propertyData->user_name:'';?>">
										</div>
									</div>
									<div class="col s6">
										<div class="input-field">
											<label>Email </label>
											<input type="email" name="email" placeholder="demo@gmail.com" value="<?php echo !empty($propertyData->email)?$propertyData->email:'';?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<div class="input-field">
											<label class="contact_numbers">Phone </label>
											<input type="text" class="phone" id="user_number" name="phone"  placeholder="(123) 456-7890" value="<?php echo !empty($propertyData->phone)?$propertyData->phone:'';?>"/>
											<input type="hidden" name="number_code" id="number_code">
										</div>
										<label class="hide_P"><input type="checkbox" name="hide_property_address" <?php echo !empty($propertyData->hide_property_address)?'checked=checked':'';?> /><span>Hide property address on listing</span></label>
									</div>
									<div class="col s6">
										<div class="input-field">
											<label class="contact_numbers">Other Contact Number </label>
											<input type="text" class="phone" id="other_contact" name="other_contact"  placeholder="(123) 456-7890" value="<?php echo !empty($propertyData->other_contact)?$propertyData->other_contact:'';?>" />
											<input type="hidden" name="other_code" id="other_code">
										</div>
									</div>
								</div>
							</div>


							<div class="details_2">
								<h5>Amenities and rules</h5>
								<h3 class="asLabelF">Amenities</h3>  
								<div class="row checkboxspaceF">
									<?php 
									$amenities1 = !empty($propertyData->amenities)?unserialize($propertyData->amenities):array();
									if(!empty($amenities['result'])){
										foreach ($amenities['result'] as $row) {  ?> 
											<div class="col s4">
												<div class="group-checkbox labelimgnews">
													<label class="hide_P">
														<img src="<?php echo base_url();?>assets/images/amenities/<?php echo $row->image;?>" alt="icons">
														<input type="checkbox" value="<?php echo $row->id?>" name="amenities[]" <?php echo (in_array($row->id,$amenities1))?'checked':'';?>/>
														<span><?php echo $row->name?></span>
													</label>
												</div>
											</div>  
										<?php }
									} ?>


								</div>
								<div class="row checkboxspaceF">
									<div class="col s12 input-field">
										<h3 class="asLabelF">Additional Amenities </h3>
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
											<input type="text" name="additional_amenities" placeholder="Enter an amenity" id="additional_amenities" class="additional_amenities">

											<input type="hidden" name="additional_amenities1" placeholder="Enter an amenity" id="additional_amenities1" class="additional_amenities" value="<?php echo 
											!empty($propertyData->additional_amenities)?$propertyData->additional_amenities:''; ?>">
											<button type="button" id="newAddAminities" class="addBtnOT waves-effect waves-light"> Add </button>
										</div>
									</div>
								</div>
							</div>

							<div class="details_2">
								<h5>Photo & media</h5>
								<div class="row">
									<div class="col s12 imageUploadN">
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
									<input type="file" id="filesss" multiple class="upload-fileS" accept="image/*" />
									<div class="documentUploadS">
										<label class="chsimg_btn fullsizeUpd" for="filesss"><span class="ti-plus"></span></label>
									</div> 
									<label>Select area to add photos.</label>
								</div>
							</div>
						</div>

						<div class="details_2">
							<h5>Showing availability</h5>
							<div class="dayselecttimeC">
								<?php 
								$daysAvai = !empty($propertyData->availability_days)?unserialize($propertyData->availability_days):'';
								$index = 0;
								$days = array('Mondays','Tuesdays','Wednesdays','Thursdays','Fridays','Saturdays','Sundays');
								foreach($days as $day){ ?>
									<div class="row">
										<div class="col s2">
											<p><?php echo $day;?></p>
										</div>
										<div class="col s6">
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
						<?php $questionCount = !empty($questions['total_count'])?$questions['total_count']:0;?>
						<input type="hidden" id="quest_count" value="<?php echo $questionCount;?>">

						<div class="details_2">
							<h5>Rental applications</h5>
							<div class="row">
								<div class="col s7">
									<div class="switch">
										<!-- <p class="inheritX">Allow renters to apply for this property directly from this listing <span class="ti-help"></span></p> -->
										<p class="inheritX">Ask people to to answer some questions before they send me? 
											<div class="hvrAllcnts">
												<div class="whenHDvShow">
													<h5>When Off,</h5>
													<p>Applicants can directly send you a request to apply</p>
													<hr/>

													<h5>When On, </h5>
													<p>you will have the option to add screening questions, which applicants will have to answer before applying to the Property Listing</p>
													<hr/>
													<p><a href="">Contact us for more info </a></p>
												</div>
											</div>
										</p>
										<label> 
											Off
											<input type="checkbox" name="directly_listing" class="switchCheck" <?php echo !empty($questions['result'])?'checked':'';?>>
											<span class="lever"></span>
											On
										</label>
										<input type="hidden" name="property_draft" id="property_draft">
									</div>
									<div class="activelistingS">
										<button type="submit" class="activelistingbtn greenClrs waves-effect waves-light add_property" data-btn_name="activate"> Activate listing </button>

										<p class="fontBB"> 
											By clicking Activate Listing, you agree to Mawjuud’s <a href="">Terms</a> and <a href="">Privacy Policy</a></p>
										</div>
									</div>
									<div class="col s5">
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
							</div>



						</div>
					</div>
					<div id="addlistP2">There are no Contacts yet for this property</div>


					<!--=================Completed applications==================-->  
					<!--=================Completed applications==================-->  
					<div id="addlistP3">
						<div class="payment-activelisting completeApplication">
							<h1>Completed Applications</h1>
							<p>You haven't received any applications yet, but you can activate your listings or invite a renter to apply.</p>
							<div class="activelistingS">
								<a class="activelistingbtn waves-effect waves-light btn modal-trigger" href="#applicationCmpt">Invite someone to apply</a>
							</div>
						</div>    
					</div>
					<!--=================Completed applications==================-->  
					<!--=================Completed applications==================-->  


					<!--=================payment==================--> 
					<!--=================payment==================--> 
					<div id="addlistP4">
						<div class="payment-activelisting">
							<img src="<?php echo base_url();?>assets/images/online-payment.png" class="mw-100" alt="images"/>
							<h1>Say Hello to Online Rent Payments</h1>
							<p>You get a free, secure way to collect rent right into your bank account. Your tenant gets more flexible ways to pay. You both get freedom from checks.</p>
							<p><a href="">Learn More</a></p>
							<button type="button" class="collectingrent waves-effect waves-light"> Start collecting rent </button>
							<p class="fontBB">By clicking "Start collecting rent" you agree to comply with the <a href="">Terms of Use. Rental User Terms,</a> and our third-party payment processor's  <a href="">Payment Terms</a> and <a href="">Authorization Terms.</a></p>
						</div>
					</div>
					<!--=================payment==================--> 
					<!--=================payment==================--> 
				</div>
			</form>
		</div>

		<div id="questionModal" class="modal custompopupdesign">
			<a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
			<img class="logoTopFix" src="<?php echo base_url();?>assets/images/imglogopop.png" alt="img" />
			<div class="my-signup">
				<h4 class="modal-title"><center>Edit question</center></h4>

				<div class="row">
					<div class="col s12">
						<div class="input-field">
							<input name="ques" id="ques" type="text" placeholder="Question">
						</div>
						<div class="input-field">
							<button type="submit" class="cntagents addQuestion waves-effect waves-light">Save</button>
						</div>
					</div>
				</div>     
			</div>
		</div>

	</div>
</div>

<!--================ Edit-Property ==================-->
<!--================ Edit-Property ==================-->





<?php include APPPATH.'views/frontend/includes/footer.php'; ?>
<?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyB1msoSFExJ6QVhosWAT9U30xQ7CbwvuM0"></script>
<script src="<?php echo base_url(); ?>assets/js/richtext.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/edit_property.js?<?php echo $timeStamp;?>"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>