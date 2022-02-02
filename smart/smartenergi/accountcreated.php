<?php 
require_once('header.php');

/*if(!isset($_SESSION['merchant_account_created'])){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/merchant-signup/step1');
	exit;
}*/
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major">
			<h2><?php echo($transArr['Account created with']); ?> <?=PROJECT_NAME?>!</h2>
			<p><?php echo($transArr['Your merchant account has been successfully created. Please be patient while the admin approves your account. You will be able to login to your account once approved and then you can apply for loans for your customers.']); ?></p>
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
//unset($_SESSION['merchant_account_created']);
require_once('footer.php');
?>