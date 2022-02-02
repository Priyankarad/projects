<?php include('header.php'); ?>

<?php

//echo '<pre>'; print_r($_REQUEST); exit;

if(isset($_REQUEST['sendmessage']) && $_REQUEST['sendmessage'] == 'yes'){
	
	if($_POST['result'] == $_SESSION['randSum']){
		
		$update = "INSERT INTO ".TABLE_PREFIX."feedback SET
				   name = '".addslashes($_POST['name'])."',
				   email = '".addslashes($_POST['email'])."',
				   message = '".addslashes($_POST['message'])."',
				   createdate = '".time()."'";
				   
		mysqli_query($con,$update) or die(mysqli_error());
		
		$feedID = mysqli_insert_id();
		
		sendemail($feedID,$config,$con);
		
		header('location:'.BASE_URL.$getLang.'/contact?action=sent');
		exit;
	}
	else{
		
		header('location:'.BASE_URL.$getLang.'/contact?action=invalidcaptcha');
		exit;
	}
}
else{
	
	$randNo1 = rand(1,9);
	$randNo2 = rand(1,9);
	$randSum = $randNo1+$randNo2;
	
	$_SESSION['randNo1'] = $randNo1;
	$_SESSION['randNo2'] = $randNo2;
	$_SESSION['randSum'] = $randSum;
}

$sectionContent = getCMS(25,$langID,$con);

$sectionTitle = stripslashes($sectionContent['page_title']);
$sectionDesc = stripslashes($sectionContent['page_desc']);
?>

<!-- Page Title
================================================== -->
<div id="page-title">

  <div class="row">

	 <div class="ten columns centered text-center">
		<h1><?php echo($sectionTitle); ?><span>.</span></h1>
	 </div>

  </div>

</div> <!-- Page Title End-->

<!-- Content
================================================== -->
<div class="content-outer">

  <div id="page-content" class="row page">

	 <div id="primary" class="eight columns">

		<section>
		
		  <h1><?php echo($transArr['Enquiry Form']); ?></h1>
		  <p><?php echo($transArr['Do you have an enquiry? Please fill up the details below and send me your message.']); ?></p>

		  <div id="contact-form">
		  
				<?php
				if($_REQUEST['action'] == 'sent'){
				?>
				<div id="message-success">
				 <i class="icon-ok"></i><?php echo($transArr['Message Sent Successfully']); ?><br />
				</div>
				<?php
				}
				else if($_REQUEST['action'] == 'invalidcaptcha'){
				?>
				<div id="message-warning">
				 <i class="icon-ok"></i><?php echo($transArr['Invalid Captcha Entered']); ?><br />
				</div>
				<?php
				}
				?>

			  <!-- form -->
			  <form method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>">
					
					<input type="hidden" name="sendmessage" value="yes" />
					<input type="hidden" name="language" value="<?php echo($getLang); ?>" />
					
					<fieldset>

					<div class="half">
					   <label for="contactName"><?php echo($transArr['Name']); ?> <span class="required">*</span></label>
					   <input type="text" name="name" id="name" value="" required />
					</div>

					<div class="half pull-right">
					   <label for="contactEmail"><?php echo($transArr['Email']); ?> <span class="required">*</span></label>
					   <input type="email" name="email" id="email" value="" required />
					</div>

					<div>
					   <label for="contactMessage"><?php echo($transArr['Enter your message']); ?> <span class="required">*</span></label>
					   <textarea name="message" id="message" required ></textarea>
					</div>
					
					<div>
						<h3><?php echo($_SESSION['randNo1']); ?>&nbsp;&nbsp;&nbsp;+&nbsp;&nbsp;&nbsp;<?php echo($_SESSION['randNo2']); ?>&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;</h3>
						<input type="text" name="result" id="result" required value="" />
					</div>

					<div>
					   <button class="submit"><?php echo($transArr['Send Message']); ?></button>
					   <span id="image-loader">
						  <img src="images/loader.gif" alt="" />
					   </span>
					</div>
					
					</fieldset>
					
				</form> <!-- Form End -->

		   </div>

		</section> <!-- section end -->

	 </div>

	 <div id="secondary" class="four columns end">

		<aside id="sidebar">

		   <div class="widget widget_contact">
			   <h5><?php echo($transArr['Contact Details']); ?></h5>
			   <?php echo($sectionDesc); ?>
			</div>

		</aside>

	 </div>

  </div>

</div> <!-- Content End-->

<?php include('footer.php'); ?>