<?php include('header.php'); ?>

<?php

if(empty($blogSlug)){
	
	header('location:'.BASE_URL.$defaultLangCode);
}

$row = getBlog($blogSlug,$langID,$con);

if(empty($row)){
	
	header('location:'.BASE_URL.$defaultLangCode);
}

$blogTitle = stripslashes($row['blog_title']);
$blogDesc = stripslashes($row['blog_desc']);
$blog_image = !empty($row['image_path']) ? ADMIN_URL.'userfiles/'.$row['image_path'] : '';
?>

<!-- Page Title
   ================================================== -->
   <div id="page-title">

      <div class="row">

         <div class="ten columns centered text-center">
            <h1><?php echo($transArr['News Details']); ?><span>.</span></h1>
         </div>

      </div>

   </div> <!-- Page Title End-->

<!-- Content
================================================== -->
<div class="content-outer">

  <div id="page-content" class="row">

	 <div id="primary" class="eight columns">

		<article class="post">

		   <div class="entry-header cf">

			  <h1><?php echo($blogTitle); ?></h1>

			  <p class="post-meta">

				 <?php echo($transArr['Posted On']); ?>: <time class="date" datetime="2014-01-14T11:24"><?=date('dS M Y',stripslashes($row['createdate']))?></time>

			  </p>

		   </div>
		   
		   <?php
		   if(!empty($blog_image)){
		   ?>
		   <div class="post-thumb">
			  <img src="<?php echo($blog_image); ?>" alt="post-image" title="post-image">
		   </div>
		   <?php
		   }
		   ?>

		   <div class="post-content">

			  <?php echo($blogDesc); ?>

		   </div>

		</article> <!-- post end -->

	 </div>

	 <?php require_once('blogsidepanel.php'); ?>

  </div>

</div> <!-- Content End-->

<?php include('footer.php'); ?>