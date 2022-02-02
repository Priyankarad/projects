<!-- Banner -->
<section class="banner" id="merchantbanner" style="background-image: url(../images/dark_tint.png), url(<?=$allcontents[37]['sectionImage'];?>);">
	<h2><?php echo($allcontents[37]['sectionTitle']); ?></h2>
	<p><?php echo($allcontents[37]['sectionDesc']); ?></p>
	<ul class="actions">
		<li>
			
			<a href="<?=BASE_URL.$getLang?>/merchant-signin" class="button big btnmerchant"><?php echo($transArr['Sign In']); ?></a>
			<a href="<?=BASE_URL.$getLang?>/merchant-signup/step1" class="button big btnmerchant"><?php echo($transArr['Create an Account']); ?></a>
		</li>
	</ul>
</section>