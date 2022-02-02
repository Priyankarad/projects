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

<!-- Page Title
================================================== -->
<div id="page-title">

  <div class="row">

	 <div class="ten columns centered text-center">
		<h1><?php echo($sectionTitle); ?><span>.</span></h1>
	 </div>

  </div>

</div> <!-- Page Title End-->

<!-- Content
================================================== -->
<div class="content-outer">

  <div id="page-content" class="row page">

	 <div id="primary" class="twelve columns">

		<section>

		   <?php echo($sectionDesc); ?>

		</section> <!-- section end -->

	 </div> <!-- primary end -->
   

  </div> <!-- page-content End-->

</div> <!-- Content End-->

<?php include('footer.php'); ?>