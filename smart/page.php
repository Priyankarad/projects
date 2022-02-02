<?php include('header.php'); ?>

<?php
if(empty($pageSlug) || empty($pageID)){
	
	header('location:'.BASE_URL.$defaultLangCode);
}

$sectionContent = getCMS($pageID,$langID,$con);

$sectionImage = !empty($sectionContent['image_path']) ? ADMIN_URL.'userfiles/'.$sectionContent['image_path'] : '';
$sectionTitle = stripslashes($sectionContent['page_title']);
$sectionDesc = stripslashes($sectionContent['page_desc']);

$fullClass = !empty($sectionImage) ? 'flex-2' : '';
?>

<!-- Main -->
<div id="main">

	<!-- Section -->
	<section class="wrapper">
		<div class="inner">
			<header class="align-center">
				<h1><?php echo($sectionTitle); ?></h1>
			</header>
			<div class="flex <?php echo($fullClass); ?>">
				<div class="col col2">
					<?php echo($sectionDesc); ?>
				</div>
				<?php
				if(!empty($sectionImage)){
				?>
				<div class="col col1 first">
					<div class="image round fit">
						<a href="generic.html" class="link"><img src="<?php echo($sectionImage); ?>" alt="" /></a>
					</div>
				</div>
				<?php } ?>
			</div>
			
		</div>
	</section>

</div>

<?php include('footer.php'); ?>