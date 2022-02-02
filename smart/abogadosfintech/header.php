<?php

include('config.php');
$defaultLang = getDefaultLang($con);

$defaultLangCode = $defaultLang['code'];
$defaultLangID = $defaultLang['id'];

$getLang = $_REQUEST['language'];

$getdet = "SELECT * FROM ".TABLE_PREFIX."languages WHERE code = '".$getLang."' AND flag = '1'";
$getdet = mysqli_query($con,$getdet) or die(mysqli_error());
$rowdet = mysqli_fetch_array($getdet);

$langID = $rowdet['id'];

if(empty($getLang) || empty($langID)){
	
	header('location:'.BASE_URL.$defaultLangCode);
}

$transArr = getTranslation($langID,$con);

$allcontents = allcontents($langID,$getLang,$con);

//echo '<pre>'; print_r($allcontents); exit;


$pageSlug = $_REQUEST['slug'];
$pageID = getpageIDbySlug($pageSlug,$con);

$blogSlug = $_REQUEST['postslug'];

$pagenav = end(explode("/",$_SERVER['PHP_SELF']));
$pagenav = explode(".",$pagenav);
$pagenav = $pagenav[0];

$pagetrail = end(explode("/",$_SERVER['REQUEST_URI']));

switch($pagenav)
{
	case 'index':
		$title = $transArr['Home'];
		$selected[$pagenav] = 'class="alt"';
		break;
		
	case 'page':
		$title = $allcontents[$pageID]['sectionTitle'];
		$selected[$pagenav] = 'class="subpage"';
		break;
	
	case 'contact':
		$title = $transArr['Contact'];
		$selected[$pagenav] = 'class="subpage"';
		break;
		
	case 'blog':
		$title = $transArr['News'];
		$selected[$pagenav] = 'class="subpage"';
		break;
		
	case 'blogdetails':
		$row = getBlog($blogSlug,$langID);
		$title = stripslashes($row['blog_title']);
		$selected[$pagenav] = 'class="subpage"';
		break;
}
?>

<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 8)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>

   <!--- Basic Page Needs
   ================================================== -->
   <meta charset="utf-8">
	<title><?=$title?> | <?=PROJECT_NAME?></title>
	<meta name="description" content="<?=$title?> | <?=PROJECT_NAME?>">
	<meta name="author" content="">

   <!-- Mobile Specific Metas
   ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
    ================================================== -->
   <link rel="stylesheet" href="<?=BASE_URL?>css/default.css">
   <link rel="stylesheet" href="<?=BASE_URL?>css/layout.css">
   <link rel="stylesheet" href="<?=BASE_URL?>css/media-queries.css">

   <!-- Script
   ================================================== -->
	<script src="<?=BASE_URL?>js/modernizr.js"></script>

   <!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="<?=BASE_URL?>favicon.ico" > 

</head>

<body>

   <!-- Header
   ================================================== -->
   <header>

      <div class="row">

         <div class="twelve columns">

            <div class="logo">
               <a href="<?=BASE_URL.$getLang?>"><img alt="" src="<?=BASE_URL?>images/logo_new.png"></a>
            </div>

            <nav id="nav-wrap">

               <a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show navigation</a>
	            <a class="mobile-btn" href="#" title="Hide navigation">Hide navigation</a>

               <ul id="nav" class="nav">

	               <li class="current"><a href="<?=BASE_URL.$getLang?>"><?php echo($transArr['Home']); ?></a></li>
	               <li><span><a href="javascript:void(0);"><?php echo($transArr['Operating Strategy']); ?></a></span>
                     <ul>
                        <li><a href="<?=$allcontents[15]['sectionLink']?>"><?=$allcontents[15]['sectionTitle']?></a></li>
                        <li><a href="<?=$allcontents[16]['sectionLink']?>"><?=$allcontents[16]['sectionTitle']?></a></li>
                        <li><a href="<?=$allcontents[17]['sectionLink']?>"><?=$allcontents[17]['sectionTitle']?></a></li>
                     </ul>
                  </li>
                  <li><span><a href="javascript:void(0);"><?php echo($transArr['Legal Advice']); ?></a></span>
                     <ul>
                        <li><a href="<?=$allcontents[18]['sectionLink']?>"><?=$allcontents[18]['sectionTitle']?></a></li>
                        <li><a href="<?=$allcontents[19]['sectionLink']?>"><?=$allcontents[19]['sectionTitle']?></a></li>
                        <li><a href="<?=$allcontents[20]['sectionLink']?>"><?=$allcontents[20]['sectionTitle']?></a></li>
                        <li><a href="<?=$allcontents[21]['sectionLink']?>"><?=$allcontents[21]['sectionTitle']?></a></li>
                        <li><a href="<?=$allcontents[22]['sectionLink']?>"><?=$allcontents[22]['sectionTitle']?></a></li>
                        <li><a href="<?=$allcontents[23]['sectionLink']?>"><?=$allcontents[23]['sectionTitle']?></a></li>
                        <li><a href="<?=$allcontents[24]['sectionLink']?>"><?=$allcontents[24]['sectionTitle']?></a></li>
                     </ul>
                  </li>
	               <li><a href="<?=$allcontents[26]['sectionLink']?>"><?=$allcontents[26]['sectionTitle']?></a></li>
                  <li><a href="<?=BASE_URL.$getLang.'/blog'?>"><?php echo($transArr['News']); ?></a></li>
                  <li><a href="<?=BASE_URL.$getLang.'/contact'?>"><?php echo($transArr['Contact']); ?></a></li>

               </ul> <!-- end #nav -->

            </nav> <!-- end #nav-wrap -->

         </div>

      </div>

   </header> <!-- Header End -->