<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">		
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home | Absolute EMC</title>
	<!-- <link rel="icon" href="<?php echo BASEURL; ?>assets/web/images/favi.png"> -->
	<link rel='stylesheet' href='<?php echo BASEURL; ?>assets/web/css/bootstrap.min.css' type='text/css' media='all'/>
	<link rel='stylesheet' href='<?php echo BASEURL; ?>assets/web/css/owl.carousel.min.css' type='text/css' media='all'/>
	<link rel='stylesheet' href='<?php echo BASEURL; ?>assets/web/css/font-awesome.min.css' type='text/css' media='all'/>
	<link rel='stylesheet' href='<?php echo BASEURL; ?>assets/web/css/aos.css' type='text/css' media='all'/>
	<link rel='stylesheet' href='<?php echo BASEURL; ?>assets/web/css/style.css' type='text/css' media='all'/>
	<link rel='stylesheet' href='<?php echo BASEURL; ?>assets/web/css/responsive.css' type='text/css' media='all'/>
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="js/html5shiv.min.js"></script>
	  <script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>

<!--========header=============-->

<section class="top_header">
	<div class="container contain_overide">
		<div class="row">
			<div class="col-md-4 col-xl-4 col-lg-4 col-7">

				<p class="contact_detail">Phone : +1 (703) 774-7505 </p>
			</div>

			<div class="col-md-5 col-xl-5 col-lg-5 col-12">
				<div class="search_box">
					<form method="post">
						
						<input type="text" name="" class="form-control" placeholder="product search" id="livesearch">
						<button type="submit" class="search_btn"><img src="<?php echo BASEURL; ?>assets/web/images/search.png"></button>
						
					</form>
				</div>
			</div>

			<div class="col-md-3 col-xl-3 col-lg-3 col-12">
				<div class="login_rgst add_cart">
					<ul class="nav">
					    <!--
						<li><a href="<?php echo site_url('login'); ?>">Login</a></li>
						<li> & </li>
						<li><a href="<?php echo site_url('login'); ?>">Signup</a></li>
                           -->
						<li><a class="nav-link" href="<?php echo site_url('cart'); ?>"><span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span> Cart</a></li>

					</ul>
				</div>
			</div>
		</div>
	</div>
</section>


<header>
	<div class="our_menus">
		<div class="container contain_overide">
			<nav class="navbar navbar-expand-lg navbar-light">

			   <a class="navbar-brand" href="<?php echo BASEURL; ?>"><img src="<?php echo BASEURL; ?>assets/web/images/logo.png" alt="images"></a>
	
			  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>
			  
			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav main_menu ml-auto">
			      <li class="nav-item">
			        <a class="nav-link" href="<?php echo BASEURL; ?>">Home</a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link" href="<?php echo site_url('about'); ?>">About</a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link" href="<?php echo site_url('services'); ?>">SERVICES</a>
			      </li>
				  


			     <li class="nav-item dropdown">
			        <a class="nav-link" href="<?php echo site_url('products'); ?>">PRODUCTS</a>
			        <i class="fa fa-angle-down dropdown-toggle" data-toggle="dropdown" aria-hidden="true"></i>
			      	 <ul class="dropdown-menu">
					 <?php
					 if(!empty($categories)){ foreach($categories as $cats){
                     $getchild=getDataByCondition(array('category','id','parent_id'),'category',array('parent_id'=>$cats->id));
					 ?>
					 	<li>
					    <a  class="dropdown-item"  href="<?php echo site_url('category/viewcategory/'.encoding($cats->id)); ?>"><?php echo $cats->category; ?></a>
						<?php if(!empty($getchild)){?>
					    <ul class="dropdown-menu MultiDrop">
						<?php foreach($getchild as $childs){ ?>
                           <li><a class="dropdown-item" href="<?php echo site_url('category/viewcategory/'.encoding($childs['id'])); ?>"><?php echo $childs['category']; ?></a></li>
                          <?php } ?>                         
                       </ul>
					   <?php } ?>
					 <?php } } ?>
					  </li>
  					</ul>
			      </li>

			      <li class="nav-item dropdown">
			        <a class="nav-link" href="<?php echo site_url('partners'); ?>">Partners</a>
			         <i class="fa fa-angle-down dropdown-toggle" data-toggle="dropdown" aria-hidden="true"></i>
			      	 <div class="dropdown-menu">
			      	 	<?php if(!empty($partners)){ foreach($partners as $partnersval){ ?>
                          <a class="dropdown-item" href="<?php echo site_url('partners/'.encoding($partnersval->id)); ?>"><?=$partnersval->title?></a>
                          <?php } } ?> 
  					</div>
			      </li>

					<li class="nav-item dropdown">
				        <a class="nav-link" href="<?php echo site_url('markets'); ?>">Markets</a>
				        <i class="fa fa-angle-down dropdown-toggle" data-toggle="dropdown" aria-hidden="true"></i>
				      	 <div class="dropdown-menu">
				     <?php if(!empty($markets)){ foreach($markets as $mkts){ ?>
					    <a class="dropdown-item" href="<?php echo site_url('market/viewmarket/'.encoding($mkts->id)) ?>"><?php echo $mkts->name; ?></a>
						
					 <?php } } ?>
						    <!-- <a class="dropdown-item" href="information-technology.html">Information Technology</a>
						    <a class="dropdown-item" href="emc.html">EMC</a> -->
						    
	  					</div>
			      	</li>

				   <li class="nav-item dropdown">
			        <a class="nav-link" href="<?php echo site_url('information'); ?>">information</a>
			         <i class="fa fa-angle-down dropdown-toggle" data-toggle="dropdown" aria-hidden="true"></i>
			      	 <div class="dropdown-menu">
					    <a class="dropdown-item" href="<?php echo site_url('standards'); ?>">Standards</a>
					    <a class="dropdown-item" href="<?php echo site_url('articles'); ?>">Articles</a>
					    <a class="dropdown-item" href="<?php echo site_url('links'); ?>">links</a>
					    <a class="dropdown-item" href="<?php echo site_url('download'); ?>">Download</a>
  					</div>
			      </li>
				  

			      <li class="nav-item">
			        <a class="nav-link" href="<?php echo site_url('contact'); ?>">Contact</a>
			      </li>
			    </ul>

			  </div>
			
			

			</nav>
		</div>
	</div>
</header>

<!--========header=============-->