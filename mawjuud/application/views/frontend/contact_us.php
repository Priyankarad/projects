<?php include APPPATH.'views/frontend/includes/header.php'; ?>


<div class="common-innerdiv">
	<div class="container-fluid">
		<h1 class="text-center"><span>Contact Us</span></h1>
		<div class="row">
			<div class="col s6">
				<div class="contact-img">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d231022.77057853303!2d55.1928570461963!3d25.212299673730246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f43496ad9c645%3A0xbde66e5084295162!2sDubai+-+United+Arab+Emirates!5e0!3m2!1sen!2sin!4v1556273939105!5m2!1sen!2sin" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>	
			</div>
			<div class="col s6">
				<div class="contact-form">
					<form id="contactForm" action="<?php echo base_url('contact_us');?>" method="post">
						<div class="input-field">
							<input placeholder="Enter Your Name" type="text" class="contact-input" name="name" />
						</div>
						<div class="input-field">
							<input placeholder="Enter Your Email" type="email" class="contact-input" name="email"/>
						</div>
						<div class="input-field">
							<input placeholder="Enter Your Subject" type="text" class="contact-input" name="subject"/>
						</div>
						<div class="input-field">
							<textarea placeholder="Type Your Message" class="contact-input" name="message"></textarea>
						</div>
						<div class="input-field">
							<button type="submit" class=" waves-effect waves-light cnt-submit">Send Message</button>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
</div>


<?php include APPPATH.'views/frontend/includes/footer.php'; ?>
<?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/settings.js?<?php echo $timeStamp;?>"></script>