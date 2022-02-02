<?php
$getfeatured = getFeaturedBlog($langID,$con);

//echo '<pre>'; print_r($getfeatured); exit;
?>

<div id="secondary" class="four columns end">

<aside id="sidebar">
   
   <?php
   if(!empty($getfeatured)){
	   
	   $featuredImage = !empty($getfeatured['image_path']) ? ADMIN_URL.'userfiles/'.$getfeatured['image_path'] : '';
	   $featuredTitle = stripslashes($getfeatured['blog_title']);
       $featuredDesc = stripslashes(strip_tags($getfeatured['blog_desc']));	  
       $featuredDesc = strlen($featuredDesc) > 190 ? substr($featuredDesc,0,190).'...' : $featuredDesc;	
       $featuredUrl = BASE_URL.$getLang.'/blog/'.stripslashes($getfeatured['blog_slug']);	   
   ?>
   <div class="widget widget_text">
	  <h5 class="widget-title"><?php echo($transArr['Featured News']); ?></h5>
	  <div class="textwidget">
		<a href="<?php echo($featuredUrl); ?>"><?php echo($featuredTitle); ?></a>
		<p>
		  <?php
		  if(!empty($featuredImage)){
		  ?>
		  <a href="<?php echo($featuredUrl); ?>"><img class="pull-left" alt="image" src="<?php echo($featuredImage); ?>" width="120" height="120"></a>
		  <?php
		  }
		  ?>
		  <?php echo($featuredDesc); ?>
		</p>
	  </div>
   </div>
   <?php
   }
   ?>
   
   <?php
	$getrows = "SELECT BP.*, BC.blog_title, BC.blog_desc, ML.image_path FROM ".TABLE_PREFIX."blog_posts AS BP 
				LEFT JOIN ".TABLE_PREFIX."blog_contents AS BC ON BC.blog_id = BP.id  
				LEFT JOIN ".TABLE_PREFIX."media_library AS ML ON ML.id = BP.media_id  
				WHERE BC.language_id = (".$langID.") AND BP.flag = '1' ORDER BY id DESC";
						   
	$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
	$numrows = mysqli_num_rows($getrows);
	
	if($numrows){
		
		?>
		<div class="widget widget_text" style="margin-top:20px;">
	    <h5 class="widget-title"><?php echo($transArr['Recent News']); ?></h5>
	    <dl>
		<?php
		
		while($row = mysqli_fetch_array($getrows)){
			
			$blog_title = stripslashes($row['blog_title']);
			$blog_title = strlen($blog_title) > 30 ? substr($blog_title,0,30).'...' : $blog_title;
			$blog_desc = stripslashes(strip_tags($row['blog_desc']));
			$blog_desc = strlen($blog_desc) > 60 ? substr($blog_desc,0,60).'...' : $blog_desc;	
			$blog_url = BASE_URL.$getLang.'/blog/'.stripslashes($row['blog_slug']);
			?>
   
			 <dt><a href="<?php echo($blog_url); ?>"><b><?php echo($blog_title); ?></b></a></dt>
			 <dd><?php echo($blog_desc); ?></dd>
			 
			<?php
		}
		?>
	    </dl>
        </div>
        <?php
   }
   ?>
   
   <?php
   $getArchives = "SELECT COUNT(*) AS totcount, DATE_FORMAT(FROM_UNIXTIME(`createdate`), '%Y-%m') AS dateformatted FROM ".TABLE_PREFIX."blog_posts WHERE flag = '1' GROUP BY dateformatted HAVING totcount > 0";
   
   $getArchives = mysqli_query($con,$getArchives) or die(mysqli_error());
   
   $rowArchives = mysqli_num_rows($getArchives);
   
   if($rowArchives > 0){
	   
	   ?>
	   <div class="widget widget_categories">
		  <h5 class="widget-title"><?php echo($transArr['Archives']); ?></h5>
		  <ul class="link-list cf">
			 
			 <?php
			 while($rowarchive = mysqli_fetch_assoc($getArchives)){
				 
				 ?>
				 <li><a href="<?php echo(BASE_URL.$getLang.'/blog/archive/'.$rowarchive['dateformatted']); ?>"><?php echo($rowarchive['dateformatted'].' ('.$rowarchive['totcount'].')'); ?></a></li>
				 <?php
			 }
			 ?>
		  </ul>
	   </div>
	   <?php
   }
   ?>

</aside> <!-- Sidebar End -->

</div> <!-- Comments End -->