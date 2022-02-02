<?php include('header.php'); ?>

<?php
$archive = $_GET['archive'];
?>

<!-- Page Title
================================================== -->
<div id="page-title">

  <div class="row">

	 <div class="ten columns centered text-center">
		<h1><?php echo($transArr['News']); ?><span>.</span></h1>
	 </div>

  </div>

</div> <!-- Page Title End-->

<!-- Content
================================================== -->
<div class="content-outer">

  <div id="page-content" class="row">

	 <div id="primary" class="eight columns">
		
		<?php
		if(!isset($archive)){
			
			$getrows = "SELECT BP.*, BC.blog_title, BC.blog_desc, ML.image_path FROM ".TABLE_PREFIX."blog_posts AS BP 
						LEFT JOIN ".TABLE_PREFIX."blog_contents AS BC ON BC.blog_id = BP.id  
						LEFT JOIN ".TABLE_PREFIX."media_library AS ML ON ML.id = BP.media_id  
						WHERE BC.language_id = (".$langID.") AND BP.flag = '1' ORDER BY id DESC";
		}
		else{
			
			$getrows = "SELECT BP.*, DATE_FORMAT(FROM_UNIXTIME(BP.createdate), '%Y-%m') AS dateformatted, BC.blog_title, BC.blog_desc, ML.image_path FROM ".TABLE_PREFIX."blog_posts AS BP 
						LEFT JOIN ".TABLE_PREFIX."blog_contents AS BC ON BC.blog_id = BP.id  
						LEFT JOIN ".TABLE_PREFIX."media_library AS ML ON ML.id = BP.media_id  
						WHERE BC.language_id = (".$langID.") AND BP.flag = '1'
						HAVING dateformatted = '".$archive."'
						ORDER BY id DESC";
		}		
							   
		$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
		$numrows = mysqli_num_rows($getrows);
		
		if($numrows){
			
			$sl = 1;
			
			while($row = mysqli_fetch_array($getrows)){
				
				$blog_desc = stripslashes(strip_tags($row['blog_desc']));
				$blog_url = BASE_URL.$getLang.'/blog/'.stripslashes($row['blog_slug']);
				$blog_image = !empty($row['image_path']) ? ADMIN_URL.'userfiles/'.$row['image_path'] : '';
				?>
		
				<article class="post">

				   <div class="entry-header cf">

					  <h1><a href="<?php echo($blog_url); ?>" title=""><?=stripslashes($row['blog_title'])?></a></h1>

					  <p class="post-meta">

						 <?php echo($transArr['Posted On']); ?>: <time class="date" datetime="2014-01-14T11:24"><?=date('dS M Y',stripslashes($row['createdate']))?></time>

					  </p>

				   </div>
				   
				   <?php
				   if(!empty($blog_image)){
				   ?>
				   <div class="post-thumb imagecenter" style="background-image:url('<?php echo($blog_image); ?>')">
					  <a href="<?php echo($blog_url); ?>" title=""></a>
				   </div>
				   <?php
				   }
				   ?>

				   <div class="post-content">

					  <p><?php echo(strlen($blog_desc) > 340 ? substr($blog_desc,0,340).'...' : $blog_desc); ?></p>

				   </div>

				</article> <!-- post end -->
				
				<?php
			}
		}
		else{
			
			?>
			<article class="post">

			   <div class="post-content">
				  
				  <h1 class="title-heading"><?php echo($transArr['No Records']); ?></h1>

			   </div>

			</article> <!-- post end -->
			<?php
		}
		?>

	 </div> <!-- Primary End-->

	 <?php require_once('blogsidepanel.php'); ?>

  </div>

</div> <!-- Content End-->

<?php include('footer.php'); ?>