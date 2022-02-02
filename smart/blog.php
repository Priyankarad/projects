<?php include('header.php'); ?>

<!-- Main -->
<div id="main">

	<!-- Section -->
	<section class="wrapper style1">
		<div class="inner">
			<header class="align-center">
				<h1><?php echo($transArr['Blog Posts']); ?></h1>
			</header>
			
			<div class="row 200%">
			<div class="12u 12u$(medium)">

			<!-- Text stuff -->
			
			<?php
			$getrows = "SELECT BP.*, BC.blog_title, BC.blog_desc FROM ".TABLE_PREFIX."blog_posts AS BP 
						LEFT JOIN ".TABLE_PREFIX."blog_contents AS BC ON BC.blog_id = BP.id  
						WHERE BC.language_id = (".$langID.") ORDER BY id DESC";
								   
			$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
			$numrows = mysqli_num_rows($getrows);
			
			if($numrows){
				
				$sl = 1;
				
				while($row = mysqli_fetch_array($getrows)){
					
					$blog_desc = stripslashes(($row['blog_desc']));
					?>
				
					<header>
						<h3><?=stripslashes($row['blog_title'])?></h3>
						<p class="postedon"><?php echo($transArr['Posted On']); ?>: <?=date('dS M Y',stripslashes($row['createdate']))?></p>
					</header>
					
					<p><?php echo(strlen($blog_desc) > 340 ? substr($blog_desc,0,340).'...' : $blog_desc); ?></p>
					
					<ul class="actions small" style="float:right">
						<li><a href="<?php echo(BASE_URL.$getLang.'/blog/'.stripslashes($row['blog_slug'])); ?>" class="button special small"><?php echo($transArr['Read More']); ?></a></li>
					</ul>
					
					<div style="clear:both"></div>
					
					<?php
					if($sl < $numrows){
					?>
					<hr class="major" />
					<?php
					}
					?>
					
					<?php
					
					$sl++;
				}
			}
			else{
				
				?>
				<header>
					<p class="postedon"><?php echo($transArr['No Blog Posts Found']); ?></p>
				</header>
				<?php
			}
			?>
			

			</div>
		
			<!--<div class="4u 12u$(medium)">

					<h4>Unordered</h4>
					<ul>
						<li>Dolor pulvinar etiam magna etiam.</li>
						<li>Sagittis adipiscing lorem eleifend.</li>
						<li>Felis enim feugiat dolore viverra.</li>
					</ul>

			</div>-->
		</div>
			
		</div>
	</section>

</div>

<?php include('footer.php'); ?>