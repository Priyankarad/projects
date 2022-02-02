<?php 
include('header.php'); 
require_once('contactbanner.php');
//echo '<pre>'; print_r($_REQUEST); exit;

if(isset($_REQUEST['sendmessage']) && $_REQUEST['sendmessage'] == 'yes'){

	if($_POST['result'] == $_SESSION['randSum']){
		$insertarr=array();
		$insertarr['name']=addslashes($_POST['name']);
		$insertarr['email']=addslashes($_POST['email']);
		$insertarr['message']=addslashes($_POST['message']);
		$insertarr['createdate']=time();		
		$feedID = insertQuery("feedback",$insertarr,$con);
		if(is_numeric($feedID))		  				
			sendemail($feedID,$config);
		
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
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<section class="contactusform">
		
			
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
			
			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
			
				<input type="hidden" name="sendmessage" value="yes" />
				<input type="hidden" name="language" value="<?php echo($getLang); ?>" />
					
				<h2><?php echo($transArr['Enquiry Form']); ?></h2>
				<p><?php echo($transArr['Do you have an enquiry? Please fill up the details below and send me your message']); ?>.</p>
				
				<div class="row uniform 50%">
					
					<div class="12u$">
						<input type="text" name="name" id="name" value="" required placeholder="<?php echo($transArr['Name']); ?>"/>
					</div>
					
					<div class="12u$">
						<input type="email" name="email" id="email" value="" required placeholder="<?php echo($transArr['Email Address']); ?>" />
					</div>
					
					<div class="12u$">
						<textarea name="message" id="message" required placeholder="<?php echo($transArr['Message']); ?>"></textarea>
					</div>
					
					<div class="12u$">
						<h3><?php echo($_SESSION['randNo1']); ?>&nbsp;&nbsp;&nbsp;+&nbsp;&nbsp;&nbsp;<?php echo($_SESSION['randNo2']); ?>&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;</h3>
						<input type="text" name="result" id="result" required value="" placeholder="<?php echo($transArr['Enter Result']); ?>"/>
					</div>
					
				</div>
				
				<div class="12u$ formbtn">
					<ul class="actions">
						<li><input type="submit" value="<?php echo($transArr['Send Message']); ?>" class="special" /></li>
					</ul>
				</div>

			</form>
		</section>
		
	</div>
</section>


<?php include('footer.php'); ?>