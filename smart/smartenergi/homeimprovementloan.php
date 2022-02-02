<?php 
require_once('header.php');?>


<section class="Shomeimprove" style="background:url(../images/dark_tint.png),url('<?php echo($allcontents[67]['sectionImage']); ?>');">
	<div class="container">
		<h1><?php echo($allcontents[67]['sectionDesc']); ?></h1>
		<a href="<?=BASE_URL.$_SESSION['currentLang']?>/getloan/step1" class="smartBtnsX"><?php echo($allcontents[67]['sectionTitle']); ?></a>
	</div>
</section>

<div class="home_labt">
	<div class="container">
		<div class="row 100%">
			<div class="5u 12u$(medium)">
				<h2 class="headingfc"><?php echo($allcontents[68]['sectionTitle']); ?></h2>
			</div>	
			<div class="7u 12u$(medium)">
				<?php echo($allcontents[68]['sectionDesc']); ?>
			</div>	
		</div>
	</div>
</div>


<div class="homeimproveic">
	<div class="container">
		<h1><?php echo($allcontents[73]['sectionTitle']); ?></h1>
		<div class="row 100%">
			<div class="3u 12u$(medium)">
				<div class="oan-improveB">
					<img src="images/home1.png" alt="images">
					<h2><?php echo($allcontents[69]['sectionTitle']); ?></h2>
					<?php echo($allcontents[69]['sectionDesc']); ?>
				</div>
			</div>	
			<div class="3u 12u$(medium)">
				<div class="oan-improveB">
					<img src="images/home2.png" alt="images">
					<h2><?php echo($allcontents[70]['sectionTitle']); ?></h2>
					<?php echo($allcontents[70]['sectionDesc']); ?>
				</div>
			</div>	
			<div class="3u 12u$(medium)">
				<div class="oan-improveB">
					<img src="images/home3.png" alt="images">
					<h2><?php echo($allcontents[71]['sectionTitle']); ?></h2>
					<?php echo($allcontents[71]['sectionDesc']); ?>
				</div>
			</div>	
			<div class="3u 12u$(medium)">
				<div class="oan-improveB">
					<img src="images/home4.png" alt="images">
					<h2><?php echo($allcontents[72]['sectionTitle']); ?></h2>
					<?php echo($allcontents[72]['sectionDesc']); ?>
				</div>
			</div>	
		</div>
		<center class="mtop50"><a href="" class="smartBtnsX"><?php echo($transArr['Find My Rate Button']); ?></a></center>
	</div>
</div>



<?php require_once('footer.php');