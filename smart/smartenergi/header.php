<?php
@session_start();
$error="";
/*$logincheck=false;
if(isset($_POST['checkvalidelogin'])){
	if($_POST['username']=='smartcredit.es' && $_POST['password']=='smartcredit.es'){
		$_SESSION['logincheck']=1;
		$logincheck=true;
	}else{
		$error= "<p style='color:red'>Wrong username password.</p>";
	}
}

if(isset($_SESSION['logincheck']) && $_SESSION['logincheck']==1){
       
}else if(!$logincheck && !isset($_SESSION['logincheck'])){
	echo "<h3 style='text-align: center;padding: 30px;'>We are under regulation process</h3>";
?>
<!-- <div style="width: 50%;margin: 0 auto;text-align: center;">
	<?php  //echo $error;?>
	<form method="post">
		<p>
		<label><strong>Username</strong></label>
		<input type="text" name="username" placeholder="username" /><br>
	</p>
	<p>
		<label><strong>Password</strong></label>
		<input type="password" name="password" placeholder="password"/><br>
	</p>
	<p>
		<input type="submit" value="Submit" name="checkvalidelogin"/>
	</p>
	</form>
</div> -->

<?php
/*die();
}*/

require_once('config.php');
$defaultLang = getDefaultLang($con);
$defaultLangCode = $defaultLang['code'];
$defaultLangID = $defaultLang['id'];
$getLang = $_REQUEST['language'];
$_SESSION['currentLang'] = $getLang;

$getdet = "SELECT * FROM ".TABLE_PREFIX."languages WHERE code = '".$getLang."' AND flag = '1'";

$getdet = mysqli_query($con,$getdet) or die(mysqli_error());
$rowdet = mysqli_fetch_array($getdet);

$langID = $rowdet['id'];

if(empty($getLang) || empty($langID)){
	header('location:'.BASE_URL.$defaultLangCode);
}

$transArr = getTranslation($langID,$con);

$allcontents = allcontents($langID,$getLang,$con);

$pageSlug = $_REQUEST['slug'];
$pageID = getpageIDbySlug($pageSlug,$con);

$blogSlug = $_REQUEST['postslug'];

$pagenav = end(explode("/",$_SERVER['PHP_SELF']));
$pagenav = explode(".",$pagenav);
$pagenav = $pagenav[0];
$pagetrail = end(explode("/",$_SERVER['REQUEST_URI']));

$step = isset($_GET['step']) ? $_GET['step'] : '';
switch($pagenav)
{
	case 'index':
		$title = $transArr['Home'];
		$selected[$pagenav] = 'class="alt"';
		$bodyclass = 'class="landing"';
		break;
		
	case 'page':
		$title = $allcontents[$pageID]['sectionTitle'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = 'class="landing"';
		break;
		
	case 'aboutus':
		$title = $transArr['About Us'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'getloan':
		$title = ucfirst($step).' - '.$transArr['Get a Loan'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = $step == 'step1' ? 'class="landing"' : '';
		break;
		
	case 'merchant':
		$title = $transArr['I am a Merchant'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = 'class="landing"';
		break;
		
	case 'merchantsignup':
		$title = $transArr['Merchant Signup'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'merchantsignin':
		$title = $transArr['Merchant Signin'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'invest':
		$title = $transArr['Invest'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'accountcreated':
		$title = $transArr['Account Created'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
	
	case 'myaccount_opportunities':
		$title = $transArr['Investment Opportunities'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'myaccount_investments':
		$title = $transArr['My Investments'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'contact':
		$title = 'Contact Us';
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = 'class="landing"';
		break;
		
	case 'borrowersignin':
		$title = $transArr['Sign In'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'emailverificationsent':
		$title = $transArr['Verify your email'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'verifyemailmerchant':
		$title = $transArr['Email address verified!'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
	case 'my_account_merchant':
		$title = $transArr['My Account'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'customer_loans':
		$title = $transArr['Customer Loans'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'merchantforgotpassword':
		$title = $transArr['Forgot Password'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'merchantresetpassword':
		$title = $transArr['Reset Password'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'my_account_borrower':
		$title = $transArr['My Account'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'my_loans':
		$title = $transArr['My Loans'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'my_payments':
		$title = $transArr['My Payments'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'borrowerforgotpassword':
		$title = $transArr['Forgot Password'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'borrowerresetpassword':
		$title = $transArr['Reset Password'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
	case 'verifyemaillender':
		$title = $transArr['Email address verified!'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;	

	case 'signin':
		$title = $transArr['Investor Login'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;

	case 'howitwork':
		$title = 'How it work';
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;	

	case 'sector':
		$title = 'Sector';
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;	

	case 'investordashboard':
		$title = 'Dashboard';
		//$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;

	case 'investaccountcreated':
		$title = 'Account created';
		//$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;	

	case 'investpast':
		$title = 'Past invest';
		//$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;

	case 'homeimprovementloan':
		$title = 'Home loan';
		//$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
	case 'merchant_transactions':
		$title = 'Merchant Transactions';
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
	case 'investor_deposit':
		$title = 'Deposit';
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
	case 'investor_withdrawal':
		$title = 'Withdrawal';
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;	
	case 'myaccount_investor':
		$title = 'Myaccount Investor';
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;	
	case 'investorforgotpassword':
		$title = $transArr['Forgot Password'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;
		
	case 'investorresetpassword':
		$title = $transArr['Reset Password'];
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;	

	case 'howitworks':
	    $title = 'How it works';
		$selected[$pagenav] = 'class="subpage"';
		$bodyclass = '';
		break;	

		
	case 'loanlistings':
		$title = 'Available loans';
		$bodyclass = '';
		break;	

	case 'getloanbymerchant':
		$title = 'Get loan by merchant';
		$bodyclass = '';
		break;	

	case 'loanremainingdata':
		$title = 'Fill Loan data';
		$bodyclass = '';
		break;	

	case 'investor_faq':
		$title = 'Investor FAQ';
		$bodyclass = '';
		break;

	case 'basic_info':
		$title = 'Basic Info';
		$bodyclass = '';
		break;

	case 'merchant_withdrawal':
		$title = 'Merchant Withdrawal';
		$bodyclass = '';
		break;														
}

$userdata = array();

if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['usertype'] == 'merchant'){
	
	$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE id = '".$_SESSION['userid']."'";
	$checkemailSql = mysqli_query($con,$checkemailQry) or die(mysqli_error());
	$checkemailRow = mysqli_fetch_assoc($checkemailSql);
	
	$_SESSION['name'] = stripslashes($checkemailRow['merchant_name']);
	$_SESSION['id'] = stripslashes($checkemailRow['merchant_cif']);
}
?>
   
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title><?=$title?> | <?=PROJECT_NAME?></title>
		<base href="<?=BASE_URL?>" />
		<meta name="description" content="<?=$title?> | <?=PROJECT_NAME?>" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="<?=BASE_URL?>css/skel.css" />
		<link rel="stylesheet" href="<?=BASE_URL?>css/style.css" />
		<link rel="stylesheet" href="<?=BASE_URL?>css/style-xlarge.css" />
		<link rel="stylesheet" href="<?=BASE_URL?>css/colorbox.css" />
		<link rel="stylesheet" href="<?=BASE_URL?>css/smoothness/jquery-ui-1.9.2.custom.min.css" />
		<link rel="stylesheet" href="<?=BASE_URL?>css/owl.carousel.min.css"/>
		<link rel="stylesheet" href="<?=BASE_URL?>css/jquery.dataTables.min.css" />
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
		<link rel="shortcut icon" type="image/png" href="<?=BASE_URL?>/images/favicon.png"/>
		
		<script src="<?=BASE_URL?>js/jquery-1.8.3.js"></script>
		<script src="<?=BASE_URL?>js/jquery-ui-1.9.2.custom.min.js"></script>
		<script src="<?=BASE_URL?>js/skel.min.js"></script>
		<script src="<?=BASE_URL?>js/jquery.rollingslider.js"></script>
		<script src="<?=BASE_URL?>js/skel-layers.min.js"></script>
		<script src="<?=BASE_URL?>js/init.js"></script>
		<script src="<?=BASE_URL?>js/owl.carousel.min.js"></script>
		<script src="<?=BASE_URL?>js/jquery.dataTables.min.js"></script>
		<script src="<?=BASE_URL?>js/jquery.colorbox-min.js"></script>
		<script src="<?=BASE_URL?>js/jquery.mask.min.js"></script>
		<script src="<?=BASE_URL?>js/custom.js"></script>
	<!---- analytics code -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144241384-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-144241384-1');
	</script>	
	<!---- analytics code -->
	</head>

	<body <?=$bodyclass?>>
	
		<div class="blurback"></div>
		<div class="globalloader"><img src="<?=BASE_URL?>/images/loader_big.svg"></div>

		<!-- Header -->
			<header id="header">
				<h1><a href="<?=BASE_URL.$getLang?>"><img src="images/logo_white.png" alt="<?=PROJECT_NAME?>" class="logo"></a></h1>
				<nav id="nav">
					<ul>
						<?php
						if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
							?>
							<li><a href="<?=BASE_URL.$getLang?>"><?php echo($transArr['Home']); ?></a></li>
							<?php
						}
						?>
						
						
						<?php
						if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
							?>
							<li><a href="<?=BASE_URL.$getLang?>/p/about-us"><?php echo($transArr['About Us']); ?></a></li>
							<li><a href="<?=BASE_URL.$getLang?>/getloan/step1"><?php echo($transArr['Doctorslist']); ?></a>
							<div class="submenusAll megaBoX">
								
								<ul>
<!---<li><a href="<?=BASE_URL.$getLang?>/"><?php echo($transArr['Borrow']); ?></a></li>
<li><a href="<?=BASE_URL.$getLang.'/sector/72'?>"><?php echo($transArr['Ophtalmology']); ?></a></li>
<li><a href="<?=BASE_URL.$getLang.'/sector/71';?>"><?php echo($transArr['Dental Health']); ?></a></li>
<li><a href="<?=BASE_URL.$getLang.'/sector/73';?>"><?php echo($transArr['Aesthetic medicine']); ?></a></li>
<li><a href="<?=BASE_URL.$getLang.'/sector/70';?>"><?php echo($transArr['Esthetic surgery']); ?></a></li>
<li><a href="<?=BASE_URL.$getLang.'/sector/79';?>"><?php echo($transArr['Ginecology']); ?></a></li>
<li><a href="<?=BASE_URL.$getLang.'/sector/80';?>"><?php echo($transArr['Other Medical treatments']); ?></a></li>--->
								</ul>
<div class="gredient_divs">
	<p><?php echo $transArr['Home Menu Content'] ?></p>
	<a href="<?php echo BASE_URL ?>/loaninfo" class="lmores"><?php echo ($transArr['Learn More']); ?></a>
</div>

</div>
</li>
<li style="display:none;">
<a href="<?=BASE_URL.$getLang?>/invest"><?php echo($transArr['Invest']); ?></a>
<div class="submenusAll">
	<ul>
		<li><a href="<?=BASE_URL.$getLang?>/howitworks"><?php echo($transArr['Investors How it works']); ?></a></li>
		<?php
		if (strpos($_SERVER['SCRIPT_NAME'], 'howitworks.php') !== false){
			echo '<li><a href="#returns">'.$transArr['Return'].'</a></li>';
		}else{
			echo '<li><a>'.$transArr['Return'].'</a></li>';
		}
		 ?>		
		
		<li><a href="<?=BASE_URL.$getLang?>/loanlistings"><?php echo($transArr['Available Loans']); ?></a></li>
		<li><a href="<?=BASE_URL.$getLang?>/signin"><?php echo ($transArr["Sign In"]); ?></a></li>
		<li><a href="<?=BASE_URL.$getLang?>/invest"><?php echo ($transArr["Register"]); ?></a></li>
		<li><a href="<?=BASE_URL.$getLang?>/investor/faq"><?php echo($transArr['Investor FAQ']); ?></a></li>
	</ul>
</div>
</li>
<li><a href="<?=BASE_URL.$getLang?>/merchant"><?php echo($transArr['medicalcenter']); ?></a></li>
<?php
}

else if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['usertype'] == 'merchant'){
?>
<li><a href="<?=BASE_URL.$getLang?>/myaccount/merchant/myprofile"><?php echo($transArr['My Account']); ?></a></li>
<li><a href="<?=BASE_URL.$getLang?>/getloanbymerchant/step1"><?php echo($transArr['Loan by Merchant']); ?></a></li>
<li><a href="<?=BASE_URL.$getLang?>/myaccount/merchant/customerloans"><?php echo($transArr['Customer Loans']); ?></a></li>
<!---<li><a href="<?=BASE_URL.$getLang?>/merchant/transaction"><?php echo('Transactions'); ?></a></li>---->
<?php
}
else if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['usertype'] == 'borrower'){
?>
<?php /* ?><li><a href="<?=BASE_URL.$getLang?>/myaccount/borrower/myprofile"><?php echo($transArr['My Account']); ?></a></li><?php */ ?>
<li>
	<a href="<?=BASE_URL.$getLang?>/myaccount/borrower/myprofile"><?php echo($transArr['My Account']); ?></a>
</li>
<li>
	<a href="<?=BASE_URL.$getLang?>/getloan/step1"><?php echo($transArr['Get Loan']); ?></a>
</li>
<li>
	<a href="<?=BASE_URL.$getLang?>/myaccount/borrower/myloans"><?php echo($transArr['My Loans']); ?></a>
</li>
<?php
}
else if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['usertype'] == 'lender'){
?>
<li><a href="<?=BASE_URL.$getLang?>/dashboard"><?php echo 'Dashboard'; ?></a></li>
<li><a href="<?=BASE_URL.$getLang?>/myaccount/opportunities"><?php echo($transArr['Investment Opportunities']); ?></a></li>
<li><a href="<?=BASE_URL.$getLang?>/myaccount/investments"><?php echo($transArr['My Investments']); ?></a></li>
<!----<li><a href="<?=BASE_URL.$getLang?>/investment_history"><?php //echo 'Past Investments'; ?></a></li>-->
<li><a href="<?=BASE_URL.$getLang?>/investor/myaccount"><?php echo($transArr['My Account']); ?></a></li>
<li><a href="<?=BASE_URL.$getLang?>/investor/faq"><?php echo($transArr['Investor FAQ']); ?></a></li>
<?php
}
						?>
						
						<?php /* ?><li><a href="<?=BASE_URL.$getLang?>/p/faq"><?php echo($transArr['FAQ']); ?></a></li>
						<li><a href="<?=BASE_URL.$getLang?>/contact"><?php echo($transArr['Contact Us']); ?></a></li><?php */ ?>
						
						<?php
						if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
							?>
							<li><a href="">Company</a>
							<div class="submenusAll">
								<ul>
									<li><a href=""><?php echo ($transArr['About Us']); ?></a></li>
		<?php
		if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') !== false){
				echo '<li><a href="#howitworks">'.$transArr['How it Works'].'</a></li>';
		}else{
				echo '<li><a href="">'.$transArr['How it Works'].'</a></li>';
		}
		 ?>							
									
		<li><a href="">Reviews</a></li>
		<li><a href="<?=BASE_URL.$getLang?>/contact"><?php echo($transArr['Contact Us']); ?></a></li>
		<!-- <li><a href="<?=BASE_URL.$getLang?>/basicinfo">Información básica</a></li> -->
		
								</ul>
							</div>
						</li>
							<li><a href="<?=BASE_URL.$getLang?>/borrower-signin"><?php echo($transArr['Sign In']); ?></a></li>
							<?php
						}
						?>
						
						<?php
						if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
							?>
							<li><a href="<?=BASE_URL.$getLang?>/logout" class="button special"><?php echo($transArr['Logout']); ?></a></li>
							<?php
						}
						?>

						
					</ul>
				</nav>
			</header>