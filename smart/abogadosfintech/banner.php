<?php
$homepageTitle = $allcontents[27]['sectionTitle'];
$homepageDesc = $allcontents[27]['sectionDesc'];
?>

<!-- Intro Section
================================================== -->
<section id="intro">

  <!-- Flexslider Start-->
   <div id="intro-slider" class="flexslider">
	
	   <ul class="slides">

		   <!-- Slide -->
		   <li>
			   <div class="row">
				   <div class="twelve columns">
					   <div class="slider-text">
						   <h1><?php echo($homepageTitle); ?><span>.</span></h1>
						   <?php echo($homepageDesc); ?>
					   </div>
					   <div class="row">
						 <p class="align-center"><a href="<?=$allcontents[18]['sectionLink']?>" class="button"><?php echo($transArr['Read More']); ?></a></p>
					   </div>
					   <div class="slider-image">
						 <img src="<?=$allcontents[13]['sectionImage']?>" alt="" />
					   </div>
				   </div>
			   </div>
		   </li>

		<!-- Slide -->
		   <li>
			   <div class="row">
				   <div class="twelve columns">
					   <div class="slider-text">
						   <h1><?php echo($homepageTitle); ?><span>.</span></h1>
						   <?php echo($homepageDesc); ?>
					   </div>
					   <div class="row">
						 <p class="align-center"><a href="<?=$allcontents[18]['sectionLink']?>" class="button"><?php echo($transArr['Read More']); ?></a></p>
					   </div>
					   <div class="slider-image">
						 <img src="<?=$allcontents[14]['sectionImage']?>" alt="" />
					   </div>
				   </div>
			   </div>
		   </li>

	   </ul>

   </div> <!-- Flexslider End-->

</section> <!-- Intro Section End-->