<?php 
require_once('header.php');
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major">
			<h2><?php echo($transArr['Account created with']); ?> <?=PROJECT_NAME?>!</h2>
			<p><?php echo($transArr['An email with verification link has been sent to your email address. Please click on that link to verify your account']); ?>.</p>
		</header>
		
		<section>
			<div class="12u$ formbtn">
				<ul class="actions">
					<li><input type="button" value="<?php echo($transArr['Click here to Sign In']); ?>" class="special" onclick="location.href='<?=BASE_URL.$getLang?>/signin'"/></li>
				</ul>
			</div>
		</section>
		
	</div>
</section>

<?php 
require_once('footer.php');
?>