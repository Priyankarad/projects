<?php 
require_once('header.php');

if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['usertype'] = 'merchant'){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/merchant/myprofile');
	exit;
}

if(isset($_REQUEST['dologin']) && !empty($_REQUEST['dologin']) && $_REQUEST['dologin'] == 'yes'){
	
	if(count($_POST)){
			
		foreach($_POST as $key=>$val){
			
			$_POST[$key] = trim(htmlspecialchars($val));
		}
	}
	
	$email 				= isset($_POST['email']) ? $_POST['email'] : '';
	$password 			= isset($_POST['password']) ? $_POST['password'] : '';
	
	$flag = 1;
	
	if(empty($email)){
		
		$errors['type'] = 'email';
		$errors['msg'] = '* Enter email address';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		
		$errors['type'] = 'email';
		$errors['msg'] = '* Enter proper email address';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if(empty($password)){
			
		$errors['type'] = 'password';
		$errors['msg'] = '* Enter password';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	
	
	if($flag == 1){
		
		$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE email = '".$email."' AND password = '".md5($password)."' AND status = 'approved'";
		$checkemailSql = mysqli_query($con,$checkemailQry) or die(mysqli_error());
		$checkemailRow = mysqli_fetch_assoc($checkemailSql);
		
		$merchant_id = $checkemailRow['id']; 
		
		if(!empty($merchant_id)){
			
			$_SESSION['userid'] = $merchant_id;
			$_SESSION['usertype'] = 'merchant';
			$_SESSION['wallet_id'] = $checkemailRow['wallet_id'];
		
			header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/merchant/myprofile');
			exit;
		}
		else{
			
			$errors['type'] = 'accountmessage';
			$errors['msg'] = $transArr['Invalid username or password'];
			$errorsFinal[] = $errors;
		}
	}
	
	$errstr = json_encode($errorsFinal);
	
	//echo '<pre>'; print_r($errorsFinal); //exit;
}
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major">
			<h2><?php echo($transArr['Welcome back']); ?></h2>
			<p><?php echo($transArr['To sign in, please enter your details. Not got an account?']); ?> <a href="<?=BASE_URL.$getLang?>/merchant-signup/step1"><?php echo($transArr['Click here']); ?></a> <?php echo($transArr['to signup']); ?>.</p>
		</header>
		
		<section class="investorsignup">
			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>"">
			
				<input type="hidden" name="dologin" value="yes">
					
				<h2><?php echo($transArr['Merchant Signin']); ?></h2>
				
				<div id="accountmessage" style="display:none;"></div>
				
				<div class="row uniform 50%" style="text-align:left;">
					
					<div class="12u$">
						<input type="text" name="email" id="email" value="<?php echo($email); ?>" placeholder="<?php echo($transArr['Email']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="password" name="password" id="password" value="<?php echo($password); ?>" placeholder="<?php echo($transArr['Password']); ?>" />
					</div>
					
				</div>
				
				<div class="12u$" style="margin-top:25px;">
					<?php /* ?><input type="checkbox" name="rememberme" id="rememberme" value="yes" checked>
					<label for="rememberme" class="termlabel"><?php echo($transArr['Remember Me']); ?></label><?php */ ?>
				</div>
				
				<div class="12u$ formbtn">
					<ul class="actions">
						<li><input type="submit" value="<?php echo($transArr['Sign in Securely']); ?>" class="special" /></li>
					</ul>
				</div>
				
				<div class="12u$" style="margin-top:25px;">
					<a href="<?=BASE_URL.$getLang?>/merchant-forgot-password"><?php echo($transArr['Forgot Password']); ?>?</a>
				</div>

			</form>
		</section>
		
	</div>
</section>

<script>
window.onload = function(){
	
	var errstr = JSON.parse('<?php echo($errstr); ?>');

	console.log(errstr);
	
	if(errstr.length > 0){
	
		errstr.forEach(function(err){
			
			$('#' + err.type).addClass('errbrdr');
			$('#' + err.type).after('<div class="errtxt">' + err.msg + '</div>');
			
		});
	}
	
	$('html,body').animate({scrollTop : $('.errbrdr:first').offset().top-50},600);
	
	//$('.errbrdr:first').click();
	$('.errbrdr:first').focus();
}

$(document).ready(function(){
	
	$('select,input[type=text],input[type=password],input[type=file]').on('keyup change keypress blur',function(){
		
		var val = $(this).val();
		
		if(val != ''){
			
			$(this).removeClass('errbrdr');
			$(this).next('.errtxt').remove();
		}
		
	});
	
});
</script>

<?php 
require_once('footer.php');
?>