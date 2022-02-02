<?php 
require_once('header.php');
require_once('merchantbanner.php');
?>

<!-- One -->
<section id="one" class="wrapper style1 special">
	<div class="container">
		<header class="major">
			<h2><?php echo($allcontents[38]['sectionTitle']); ?></h2>
		</header>
		<div class="row 150%">
			<div class="4u 12u$(medium)">
				<section class="box">
					<i class="icon big rounded color1 fa-credit-card"></i>
					<h3><?php echo($allcontents[32]['sectionTitle']); ?></h3>
					<p><?php echo($allcontents[32]['sectionDesc']); ?></p>
				</section>
			</div>
			<div class="4u 12u$(medium)">
				<section class="box">
					<i class="icon big rounded color9 fa-eur"></i>
					<h3><?php echo($allcontents[33]['sectionTitle']); ?></h3>
					<p><?php echo($allcontents[33]['sectionDesc']); ?></p>
				</section>
			</div>
			<div class="4u$ 12u$(medium)">
				<section class="box">
					<i class="icon big rounded color6 fa-paper-plane"></i>
					<h3><?php echo($allcontents[34]['sectionTitle']); ?></h3>
					<p><?php echo($allcontents[34]['sectionDesc']); ?></p>
				</section>
			</div>
		</div>
	</div>
</section>

<section id="two" class="wrapper style2 special">
	<div class="container">
		<header class="major merchantfaq">
			<h2><?php echo($allcontents[55]['sectionTitle']); ?></h2>
			<?php echo($allcontents[55]['sectionDesc']); ?>
		</header>
		<section class="profiles merfaqflow">
			<div class="row">
				<section class="4u 6u(medium) 12u$(xsmall) profile">
					<img src="<?php echo(BASE_URL); ?>/images/web1.png" alt="" />
					<h4><?php echo($transArr['Web']); ?></h4>
				</section>
				<section class="4u 6u$(medium) 12u$(xsmall) profile">
					<img src="<?php echo(BASE_URL); ?>/images/phone1.png" alt="" />
					<h4><?php echo($transArr['Telephone']); ?></h4>
				</section>
				<section class="4u 6u(medium) 12u$(xsmall) profile">
					<img src="<?php echo(BASE_URL); ?>/images/setting1.png" alt="" />
					<h4><?php echo($transArr['100% Flexible']); ?></h4>
				</section>
			</div>
		</section>
	</div>
</section>

<!-- Two -->
<?php /* ?><section id="two" class="wrapper style2 special">
	<div class="container">
		<header class="major">
			<h2><?php echo($allcontents[39]['sectionTitle']); ?></h2>
		</header>
		<footer>
			<p><?php echo($allcontents[39]['sectionDesc']); ?></p>
		</footer>
	</div>
</section><?php */ ?>

<?php 
require_once('footer.php');
?>
   