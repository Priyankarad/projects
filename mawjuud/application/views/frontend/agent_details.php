<?php include APPPATH.'views/frontend/includes/header.php';  
$sessionData = '';
if($this->session->userdata('sessionData')){
    $sessionData = $this->session->userdata('sessionData');
}
?>
<div class="agents-details">
    <div class="container">
        <div class="agentspro-files">
			<div class="row">
				<div class="col s8">
					<div class="row">
						<div class="col s3">
							<?php 
							$img = isset($agentDetails->profile_thumbnail)?$agentDetails->profile_thumbnail:base_url().DEFAULT_IMAGE;
							?>
							<div class="details-agentimg">
								<img src="<?php echo $img;?>" class="responsive-img" alt=""/>
							</div>
						</div>
						<div class="col s5">
							<div class="details-agentname">
								<h3><?php echo isset($agentDetails->firstname)?$agentDetails->firstname.' '.$agentDetails->lastname:'-';?></h3>
								<h6>Managing Partner</h6>
								<ul>
									<li><p><span>NATIONALITY:</span> <?php echo isset($agentDetails->nationality)?ucwords($agentDetails->nationality):'-';?></p></li>
									<li><p><span>LANGUAGES:</span> <?php echo isset($agentDetails->language)?ucwords($agentDetails->language):'-';?></p></li>
								</ul>
							</div>
						</div>	
						<div class="col s4">
							<?php 
							$img = isset($agentDetails->agency_logo)?$agentDetails->agency_logo:base_url().'assets/images/nologo.png';
							?>
							<div class="details-agentname">
								<img src="<?php echo $img;?>" class="responsive-img" alt=""/>
								<p><?php echo isset($agentDetails->agency_name)?ucwords($agentDetails->agency_name):'-';?></p>
								<!-- <h6><a href="">View profile</a></h6> -->
							</div>
						</div>	
						<div class="col s12">
							<div class="details-personal">
								<h5>PERSONAL INFORMATION</h5>
								<div class="row">
									<div class="col s6">
										<ul>
											<li>
												<p>
													<span>ACTIVE LISTINGS:</span> 
													<a href="" id="active_properties">13 Properties</a>
												</p>
											</li>
											<li>
												<?php
												$licensesNumber = isset($agentDetails->licenses_number)?str_replace(',','<br/>',$agentDetails->licenses_number):'-';
												?>
												<p>
													<span>LICENSE NO.</span> 
													<span class="marina-towns">
														<?php echo $licensesNumber;?>
													</span>
												</p>
											</li>
											<li>
												<p>
													<span>LINKEDIN:</span> 
													<a href="<?php echo isset($agentDetails->linkedin_profile_url)?$agentDetails->linkedin_profile_url:'#';?>" target="_blank">View profile
													</a>
												</p>
											</li>
										</ul>
									</div>
									<div class="col s6">
										<ul>
											<?php
											$servicesArea = isset($agentDetails->services_area)?str_replace(',','<br/>',$agentDetails->services_area):'-';
											?>
											<li>
												<p>
													<span>AREAS:</span> 
													<span class="marina-towns">
														<?php echo $servicesArea;?>
													</span>
												</p>
											</li>
											<li>
												<p>
													<span>CONTACT:</span> <?php 
													echo (isset($agentDetails->agency_cell)&&!empty($agentDetails->agency_cell))?$agentDetails->agency_cell_code.$agentDetails->agency_cell	:'-';
													?>
												</p>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col s4">
					<div class="contact-agents1">
						<h4>Contact Us</h4>
						<form id="contactOwner" method="post">
							<div class="input-field">
								<input type="hidden" id="agent_id" name="agent_id" value="<?php echo isset($agentDetails->id)?$agentDetails->id:'';?>">
								<input name="name" type="text" placeholder="Your Name" value="<?php echo 
								(isset($sessionData['first_name'])&&isset($sessionData['last_name']))?ucwords($sessionData['first_name']." ".$sessionData['last_name']):'';
								?>">
			                </div>
			                <div class="input-field">
			                	<?php 
			                	$number='';
			                	if(isset($sessionData['user_number'])){
			                		$number = (int)$sessionData['user_number'];
			                	}
			                	if($number == 0){
			                		$number='';  
			                	}
			                	?>
			                	<input type="tel" class="phone" name="phone_number"  placeholder="Phone No." value="<?php echo isset($sessionData['user_number'])?$sessionData['code'].$number:'';?>">
			                </div>
			                <div class="input-field">
			                    <input name="email" type="email" placeholder="Email" value="<?php echo isset($sessionData['username'])?$sessionData['username']:'';?>">
			                </div>
			                <div class="input-field">
			                    <textarea placeholder="Message" id="message" name="message"></textarea>
			                </div>
			                <div class="input-field">
			                    <button type="submit" class="activelistingbtn greenClrs waves-effect waves-light add_property contactOwner"> Contact Us </button>
			                </div>
						</form>
					</div>	
				</div>
        	</div> 
        </div> 

		<div class="agentspro-files">
			<div class="row">
				<div class="col s12">
					<h2>Our Listing & Sales</h2>
					<div id="agent_propeties_map" class="custom_search_map" width="100%">  
					</div>
				</div>
			</div>
		</div>

		<div class="agentspro-files">
			<div class="row">
				<div class="col s12">
					<h2>Our Active Listing <span id="active_listings">(15)</span> </h2>
					<table class="responsive-table ouractivelistings">
				      <thead>
				      	<tr>
				      		<th style="width:50%;"><b>PROPERTY ADDRESS</b></th>
				      		<th><b>BED / BATH</b></th>
				      		<th><b>PRICE</b></th>
				      	</tr>
				      </thead>
                    </table>	
				</div>
			</div>
		</div>


		<div class="agentspro-files">
			<div class="row">
				<div class="col s12">
					<h2>Our Past Sales <span id="past_total">(11 all-time)</span> </h2>

					<table class="responsive-table ourpastsales">
						<thead>
							<tr>
								<th style="width:42%;"><b>PROPERTY ADDRESS</b></th>
								<th><b>REPRESENTED</b></th>
								<th><b>SOLD DATE</b></th>
								<th><b>PRICE</b></th>
								<th><b></b></th>
							</tr>
						</thead>
					</table>	
				</div>
			</div>
		</div>

		<div class="agentspro-files">
			<div class="row">
				<div class="col s12">
					<h2>Rating & Reviews <button class="typrreview">Write a review</button> </h2>
					<div class="reviewstart">
						<p>No reviews yet </p>
					</div>
				</div>
			</div>
		</div>
			

    </div>
</div>


<?php include APPPATH.'views/frontend/includes/footer.php'; ?>
<?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=AIzaSyB1msoSFExJ6QVhosWAT9U30xQ7CbwvuM0"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/login.js?<?php echo $timeStamp;?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/agent_details.js?<?php echo $timeStamp;?>"></script>