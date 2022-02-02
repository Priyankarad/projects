<!-- footer
   ================================================== -->
   <footer>

      <div class="row">

         <div class="twelve columns">

            <ul class="footer-nav">
				<li><a href="<?=BASE_URL?>"><?php echo($transArr['Home']); ?>.</a></li>
				<li><a href="<?=$allcontents[26]['sectionLink']?>"><?=$allcontents[26]['sectionTitle']?>.</a></li>
				<li><a href="<?=BASE_URL.$getLang.'/blog'?>"><?php echo($transArr['News']); ?>.</a></li>
				<li><a href="<?=BASE_URL.$getLang.'/contact'?>"><?php echo($transArr['Contact']); ?>.</a></li>              	
			   </ul>

            <ul class="footer-social">
               <li><a href="<?php echo($config['facebook_url']); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
               <li><a href="<?php echo($config['twitter_url']); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
               <li><a href="<?php echo($config['googleplus_url']); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
               <li><a href="<?php echo($config['linkedin_url']); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
            </ul>

            <ul class="copyright">
               <li><?php echo($transArr['Copyright']); ?> &copy; <?=date('Y')?>. <?=PROJECT_NAME?></li> 
               <!--<li>Design by <a href="http://www.styleshout.com/">Styleshout</a></li>-->               
            </ul>
			
			<?php
			$getLangData = "SELECT * FROM ".TABLE_PREFIX."languages WHERE flag = '1'";
			$getLangData = mysqli_query($con,$getLangData) or die(mysqli_error());
			$numdata = mysqli_num_rows($getLangData);
			
			$currentURL = HTTP_HOST.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			
			if($numdata){
				?>
				<nav class="pagination add-bottom" style="margin-top:40px;">
					  
					  <span class="page-numbers prev inactive"><?php echo($transArr['Choose Language']); ?>: </span>
					  
					    <?php
						while($rowdata = mysqli_fetch_assoc($getLangData)){
							
							$langCode = stripslashes($rowdata['code']);
							
							$searchURI = stripos($currentURL,"/".$langCode);
							if(!$searchURI){
								$newURL = str_replace_first("/".$getLang,"/".$langCode,$currentURL);
							}
							else{
								$newURL = $currentURL;
							}
							?>
							<a href="<?php echo($newURL); ?>" class="page-numbers <?php echo($getLang == stripslashes($rowdata['code']) ? 'current' : ''); ?>"><?php echo(strtoupper(stripslashes($rowdata['code']))); ?></a>
							<?php
						}
						?>

				 </nav>
				 <?php
			}
			?>

         </div>

         <div id="go-top" style="display: block;"><a title="Back to Top" href="#">Go To Top</a></div>

      </div>

   </footer> <!-- Footer End-->

   <!-- Java Script
   ================================================== -->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   <script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
   <script type="text/javascript" src="<?=BASE_URL?>js/jquery-migrate-1.2.1.min.js"></script>

   <script src="<?=BASE_URL?>js/jquery.flexslider.js"></script>
   <script src="<?=BASE_URL?>js/doubletaptogo.js"></script>
   <script src="<?=BASE_URL?>js/init.js"></script>

</body>

</html>