<?php include('header.php'); ?>

<?php include('banner.php'); ?>

<!-- Main -->
<div id="main">
	
	<?php
	$fullClass = !empty($allcontents[9]['sectionImage']) ? 'flex-2' : '';
	?>
	
	<!-- Section -->
	<section class="wrapper style1">
		<div class="inner">
			<!-- 2 Columns -->
				<div class="flex <?php echo($fullClass); ?>">
					<?php
					if(!empty($allcontents[9]['sectionImage'])){
					?>
					<div class="col col1">
						<div class="image round fit">
							<a href="javascript:void(0);" class="link"><img src="<?php echo($allcontents[9]['sectionImage']); ?>" alt="" /></a>
						</div>
					</div>
					<?php } ?>
					<div class="col col2">
						<h3><?php echo($allcontents[9]['sectionTitle']); ?></h3>
						<p><?php echo(strlen($allcontents[9]['sectionDesc']) > 574 ? substr($allcontents[9]['sectionDesc'],0,574).'...' : $allcontents[9]['sectionDesc']); ?></p>
						<a href="<?php echo($allcontents[9]['sectionLink']); ?>" class="button"><?php echo($transArr['Learn More']); ?></a>
					</div>
				</div>
		</div>
	</section>
	
	<?php
	$fullClass = !empty($allcontents[10]['sectionImage']) ? 'flex-2' : '';
	?>
	
	<!-- Section -->
	<section class="wrapper style2">
		<div class="inner">
			<div class="flex <?php echo($fullClass); ?>">
				<div class="col col2">
					<h3><?php echo($allcontents[10]['sectionTitle']); ?></h3>
					<p><?php echo(strlen($allcontents[10]['sectionDesc']) > 574 ? substr($allcontents[10]['sectionDesc'],0,574).'...' : $allcontents[10]['sectionDesc']); ?></p>
					<a href="<?php echo($allcontents[10]['sectionLink']); ?>" class="button"><?php echo($transArr['Learn More']); ?></a>
				</div>
				
				<?php
				if(!empty($allcontents[10]['sectionImage'])){
				?>
				<div class="col col1 first">
					<div class="image round fit">
						<a href="javascript:void(0);" class="link"><img src="<?php echo($allcontents[10]['sectionImage']); ?>" alt="" /></a>
					</div>
				</div>
				<?php } ?>
				
			</div>
		</div>
	</section>

	<!-- Section -->
	<?php /* ?><section class="wrapper style1">
		<div class="inner">
			
			<header class="align-center">
				<h2><?php echo($allcontents[8]['sectionTitle']); ?></h2>
				<p><?php echo(strlen($allcontents[8]['sectionDesc']) > 80 ? substr($allcontents[8]['sectionDesc'],0,80).'...' : $allcontents[8]['sectionDesc']); ?></p>
			</header>
			
			<div class="flex flex-3">
				
				<div class="col align-center">
					<div class="image round fit">
						<img src="<?php echo($allcontents[4]['sectionImage']); ?>" alt="" />
					</div>
					<p><?php echo(strlen($allcontents[4]['sectionDesc']) > 140 ? substr($allcontents[4]['sectionDesc'],0,140).'...' : $allcontents[4]['sectionDesc']); ?></p>
					<a href="<?php echo($allcontents[4]['sectionLink']); ?>" class="button"><?php echo($transArr['Learn More']); ?></a>
				</div>
				
				<div class="col align-center">
					<div class="image round fit">
						<img src="<?php echo($allcontents[5]['sectionImage']); ?>" alt="" />
					</div>
					<p><?php echo(strlen($allcontents[5]['sectionDesc']) > 140 ? substr($allcontents[5]['sectionDesc'],0,140).'...' : $allcontents[5]['sectionDesc']); ?></p>
					<a href="<?php echo($allcontents[5]['sectionLink']); ?>" class="button"><?php echo($transArr['Learn More']); ?></a>
				</div>
				
				<div class="col align-center">
					<div class="image round fit">
						<img src="<?php echo($allcontents[6]['sectionImage']); ?>" alt="" />
					</div>
					<p><?php echo(strlen($allcontents[6]['sectionDesc']) > 140 ? substr($allcontents[6]['sectionDesc'],0,140).'...' : $allcontents[6]['sectionDesc']); ?></p>
					<a href="<?php echo($allcontents[6]['sectionLink']); ?>" class="button"><?php echo($transArr['Learn More']); ?></a>
				</div>
				
			</div>
		</div>
	</section><?php */ ?>

</div>

<?php include('footer.php'); ?>