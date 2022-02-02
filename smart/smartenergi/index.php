<?php 
require_once('header.php');
require_once('homebanner.php');


	if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['usertype'] == 'merchant'){
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/merchant/myprofile');
		exit;
	}

	if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['usertype'] == 'borrower'){

		header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/borrower/myloans');
		exit;
	}

	if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['usertype'] == 'lender'){

		header("Location:".BASE_URL.$_SESSION['currentLang'].'/investor/myaccount');
		exit;
	}
	?>

	<!-- One -->
	<section id="one" class="wrapper style1 special">
	<div class="container">
	<header class="major">
	<h2><?php echo($allcontents[36]['sectionTitle']); ?></h2>
	<p><?php echo($allcontents[36]['sectionDesc']); ?></p>
	</header>
	<div class="row 150%">
	<div class="4u 12u$(medium)">
	<section class="pricesSd">
	<!-- <i class="icon big rounded color1 fa-credit-card"></i> -->
	<img src="images/perchase.png" alt="images">
	<h3><?php echo($allcontents[32]['sectionTitle']); ?></h3>
	<p><?php echo($allcontents[32]['sectionDesc']); ?></p>
	</section>
	</div>
	<div class="4u 12u$(medium)">
	<section class="pricesSd">
	<!-- <i class="icon big rounded color9 fa-eur"></i> -->
	<img src="images/price.png" alt="images">
	<h3><?php echo($allcontents[33]['sectionTitle']); ?></h3>
	<p><?php echo($allcontents[33]['sectionDesc']); ?></p>
	</section>
	</div>
	<div class="4u$ 12u$(medium)">
	<section class="pricesSd">
	<!-- <i class="icon big rounded color6 fa-paper-plane"></i> -->
	<img src="images/ups.png" alt="images">
	<h3><?php echo($allcontents[34]['sectionTitle']); ?></h3>
	<p><?php echo($allcontents[34]['sectionDesc']); ?></p>
	</section>
	</div>
	</div>
	</div>
	</section>

	<!-- Two -->
	<?php /* ?><section id="two" class="wrapper style2 special">
	<div class="container">
	<header class="major">
	<h2>Lorem ipsum dolor sit</h2>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, autem.</p>
	</header>
	<section class="profiles">
	<div class="row">
	<section class="3u 6u(medium) 12u$(xsmall) profile">
	<img src="images/profile_placeholder.gif" alt="" />
	<h4>Lorem ipsum</h4>
	<p>Lorem ipsum dolor</p>
	</section>
	<section class="3u 6u$(medium) 12u$(xsmall) profile">
	<img src="images/profile_placeholder.gif" alt="" />
	<h4>Voluptatem dolores</h4>
	<p>Ullam nihil repudi</p>
	</section>
	<section class="3u 6u(medium) 12u$(xsmall) profile">
	<img src="images/profile_placeholder.gif" alt="" />
	<h4>Doloremque quo</h4>
	<p>Harum corrupti quia</p>
	</section>
	<section class="3u$ 6u$(medium) 12u$(xsmall) profile">
	<img src="images/profile_placeholder.gif" alt="" />
	<h4>Voluptatem dicta</h4>
	<p>Et natus sapiente</p>
	</section>
	</div>
	</section>
	<footer>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam dolore illum, temporibus veritatis eligendi, aliquam, dolor enim itaque veniam aut eaque sequi qui quia vitae pariatur repudiandae ab dignissimos ex!</p>
	<ul class="actions">
	<li>
					<a href="#" class="button big">Lorem ipsum dolor sit</a>
					</li>
					</ul>
					</footer>
					</div>
					</section>

					<!-- Three -->
					<section id="three" class="wrapper style3 special">
					<div class="container">
					<header class="major">
					<h2>Consectetur adipisicing elit</h2>
					<p>Lorem ipsum dolor sit amet. Delectus consequatur, similique quia!</p>
					</header>
					</div>
					<div class="container 50%">
					<form action="#" method="post">
					<div class="row uniform">
					<div class="6u 12u$(small)">
					<input name="name" id="name" value="" placeholder="Name" type="text">
					</div>
					<div class="6u$ 12u$(small)">
					<input name="email" id="email" value="" placeholder="Email" type="email">
					</div>
					<div class="12u$">
					<textarea name="message" id="message" placeholder="Message" rows="6"></textarea>
					</div>
					<div class="12u$">
					<ul class="actions">
					<li><input value="Send Message" class="special big" type="submit"></li>
					</ul>
					</div>
					</div>
					</form>
					</div>
					</section><?php */ ?>

					<!----<div class="clienlogo">
					<div class="container">
					<div class="owl-carousel owl-theme" id="client_logo">
					<?php $clientLogo= mediaImage('Client Logo',$con);

					if(!empty($clientLogo['image_path'])){
						$path=explode(" | ",$clientLogo['image_path']);
						foreach($path as $image_path){
							$link = ADMIN_URL.'userfiles/'.stripslashes($image_path);
							?>
							<div class="item">
							<div class="logo_cl">
							<a href=""><img src="<?=$link;?>" alt="images"></a>
							</div>			
							</div>
							<?php
						}
					}
					?>

					</div>
					</div>
					</div>----->

					<div class="loanBox" id="howitworks">
					<div class="container">

					<header class="major">
					<h2><?php echo($transArr['Gettingaloan']); ?></h2>
					</header>
					<div class="tab3steps">
					<div class="row 150%">
					<div class="6u 12u$(medium)">
					<div class="loan_divC">
					<div class="loanlistX activeloan">
					<span>1</span>
					<h4><?php echo($transArr['checkrate']); ?></h4>
					<p><?php echo($transArr['Check Your Rate Content']); ?></p>
					</div>
					<div class="loanlistX">
					<span>2</span>
					<h4><?php echo($transArr['Choose Your Loan']); ?></h4>
					<p><?php echo($transArr['Choose Your Loan Content']); ?></p>
					</div>
					<!--<div class="loanlistX">
					<span>3</span>
					<h4><?php //echo($transArr['Get Your Funds']); ?></h4>
					<p><?php //echo($transArr['Get Your Funds Content']); ?></p>
					</div>-->
					</div>
					</div>
					<div class="6u 12u$(medium)">
					<div class="loan_video">
					<video width="100%" controls>
					<source src="<?php echo BASE_URL; ?>/smccontrolpanel/userfiles/Swish-626B512F-8BA0-4F3F-9FA2-CD1E81BE204D.MOV" type="video/mp4">
					</video>
					</div>
					</div>
					</div>
					</div>
					</div>
					</div>	
					</div>


					<section id="three" class="wrapper style3 special">
					<div class="container">
					<header class="major">
					<h2><?php echo($allcontents[51]['sectionTitle']); ?></h2>
					<p><?php echo($allcontents[51]['sectionDesc']); ?></p>
					</header>
					</div>
					</section>

					<section id="two" class="wrapper style2 special">
					<div class="container">
					<header class="major">
					<p><strong><i class="fa fa-envelope"></i></strong>&nbsp;&nbsp;<?php echo($config['company_official_email_address']); ?></p>
					<p><strong><i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo($config['company_phone_no']); ?></strong> <?php echo($transArr['for loans']); ?></p>
					<p><strong><i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo($config['company_phone_no']); ?></strong> <?php echo($transArr['for investments']); ?></p>
					<p style="font-size:14px"><?php echo($transArr['We can\'t take applications over the phone. Spanish residents only. Calls may be monitored or recorded.']); ?></p>
					</header>
					</div>
					</section>
					<?php 
					require_once('footer.php');
					?>
