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
?>

<!-- Main -->
<div id="main">

	<!-- Section -->
	<section class="wrapper">
		<div class="inner">
			<header class="align-center">
				<h1><?php echo($blogTitle); ?></h1>
				<p class="postedon"><?php echo($transArr['Posted On']); ?>: <?=date('dS M Y',stripslashes($row['createdate']))?></p>
			</header>
			<div class="flex">
				<div class="col col2">
					<?php echo($blogDesc); ?>
				</div>
			</div>
			
		</div>
	</section>

</div>

<?php include('footer.php'); ?>