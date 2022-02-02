<?php 
require_once('header.php');

if(!isset($_SESSION['email_verification_sent'])){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/merchant-signup/step1');
	exit;
}
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major">
			<h2><?php echo($transArr['Verify your email']); ?></h2>
			<p><?php echo($transArr['An email with verification link has been sent to your email address. Please click on that link to verify your account']); ?></p>
		</header>
		
		<section>
			<div class="12u$ formbtn">
				<ul class="actions">
					<li><input type="button" value="<?php echo($transArr['Click here to Sign In']); ?>" class="special" onclick="location.href='<?=BASE_URL.$getLang?>/merchant-signin'"/></li>
				</ul>
			</div>
		</section>
		
	</div>
</section>

<?php 
//unset($_SESSION['email_verification_sent']);
require_once('footer.php');
?>