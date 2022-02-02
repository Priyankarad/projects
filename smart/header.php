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
		$title = $transArr['Contact Me'];
		$selected[$pagenav] = 'class="subpage"';
		break;
		
	case 'blog':
		$title = $transArr['Blog'];
		$selected[$pagenav] = 'class="subpage"';
		break;
		
	case 'blogdetails':
		$row = getBlog($blogSlug,$langID,$con);
		$title = stripslashes($row['blog_title']);
		$selected[$pagenav] = 'class="subpage"';
		break;
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?=$title?> | <?=PROJECT_NAME?></title>
<meta name="description" content="<?=$title?> | <?=PROJECT_NAME?>" />
<base href="<?=BASE_URL?>" />

<link rel="stylesheet" href="<?=BASE_URL?>assets/css/main.css" />
</head>
<body>

<!-- Header -->
<header id="header" <?php echo($selected[$pagenav]); ?>>
	<div class="logo"><a href="<?=BASE_URL.$getLang?>"><?=PROJECT_NAME?></a></div>
	
	<?php
	$getLangData = "SELECT * FROM ".TABLE_PREFIX."languages WHERE flag = '1'";
	$getLangData = mysqli_query($con,$getLangData) or die(mysqli_error());
	$numdata = mysqli_num_rows($getLangData);
	
	$currentURL = HTTP_HOST.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	if($numdata){
		?>
		<div class="langchooser">
			
			<?php
			$sl = 1;
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
				<span><a href="<?php echo($newURL); ?>" class="<?php echo($getLang == stripslashes($rowdata['code']) ? 'selected' : ''); ?>"><?php echo(strtoupper(stripslashes($rowdata['code']))); ?></a></span>
				<?php
				if($sl < $numdata){
				?>
				<span>|</span>
				<?php
				}
				?>
				<?php
				$sl++;
			}
			?>
			
		</div>
		<?php
	}
	?>
	
	<a href="#menu"><?php echo($transArr['Menu']); ?></a>
</header>

<!-- Nav -->
<nav id="menu">
	<ul class="links">
		<li><a href="<?=BASE_URL.$getLang?>"><?php echo($transArr['Home']); ?></a></li>
		<li><a href="<?=$allcontents[3]['sectionLink']?>"><?php echo($transArr['About Me']); ?></a></li>
		<li><a href="<?=BASE_URL.$getLang.'/blog'?>"><?php echo($transArr['Blog']); ?></a></li>
		<li><a href="<?=BASE_URL.$getLang.'/contact'?>"><?php echo($transArr['Contact Me']); ?></a></li>
	</ul>
</nav>