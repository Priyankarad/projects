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
		
		header('location:'.BASE_URL.$getLang.'/contact/sent');
	}
	else{
		
		header('location:'.BASE_URL.$getLang.'/contact/invalidcaptcha');
	}
}

$sectionContent = getCMS(7,$langID,$con);

$sectionTitle = stripslashes($sectionContent['page_title']);
$sectionDesc = stripslashes($sectionContent['page_desc']);

$randNo1 = rand(1,9);
$randNo2 = rand(1,9);
$randSum = $randNo1+$randNo2;

$_SESSION['randNo1'] = $randNo1;
$_SESSION['randNo2'] = $randNo2;
$_SESSION['randSum'] = $randSum;
?>

<!-- Main -->
<div id="main">

	<section class="wrapper style1">
		<div class="inner">
			<header class="align-center">
				<h1><?php echo($sectionTitle); ?></h1>
			</header>
			
			<div class="row 200%">
			
				<div class="4u 12u$(medium)">

					<!-- Text stuff -->
					
					<header>
						<h3><?php echo($transArr['Contact Details']); ?></h3>
					</header>
					<?php echo($sectionDesc); ?>				
				
				</div>
		
				<div class="8u 12u$(medium)">
					
					<?php
					if($_REQUEST['action'] == 'sent'){
						?>
						<p class="alertmessage success"><?php echo($transArr['Message Sent Successfully']); ?></p>
						<?php
					}
					else if($_REQUEST['action'] == 'invalidcaptcha'){
						?>
						<p class="alertmessage failed"><?php echo($transArr['Invalid Captcha Entered']); ?></p>
						<?php
					}
					?>
					
					<h3><?php echo($transArr['Enquiry Form']); ?></h3>
					<p><?php echo($transArr['Do you have an enquiry? Please fill up the details below and send me your message.']); ?></p>

					<form method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>">
					
						<input type="hidden" name="sendmessage" value="yes" />
						<input type="hidden" name="language" value="<?php echo($getLang); ?>" />
						
						<div class="row uniform">
							<div class="6u 12u$(xsmall)">
								<input type="text" name="name" id="name" value="" required placeholder="<?php echo($transArr['Name']); ?>" />
							</div>
							<div class="6u$ 12u$(xsmall)">
								<input type="email" name="email" id="email" value="" required placeholder="<?php echo($transArr['Email']); ?>" />
							</div>
							<div class="12u$">
								<textarea name="message" id="message" required placeholder="<?php echo($transArr['Enter your message']); ?>" rows="6"></textarea>
							</div>
							<!-- Break -->
							
							<div class="2u 12u$(xsmall)">
								<h3><?php echo($_SESSION['randNo1']); ?>&nbsp;&nbsp;&nbsp;+&nbsp;&nbsp;&nbsp;<?php echo($_SESSION['randNo2']); ?>&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;</h3>
							</div>
							<div class="4u$ 12u$(xsmall)">
								<input type="text" name="result" id="result" required value="" placeholder="<?php echo($transArr['Result']); ?>" />
							</div>
							
							<div class="12u$">
								<ul class="actions">
									<li><input type="submit" value="<?php echo($transArr['Send Message']); ?>" /></li>
									<li><input type="reset" value="<?php echo($transArr['Reset']); ?>" class="alt" /></li>
								</ul>
							</div>
						</div>
					</form>

				</div>
			</div>
			
		</div>
	</section>

</div>

<?php include('footer.php'); ?>