<?php 
require_once('header.php');

if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['usertype'] = 'borrower'){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/borrower/myprofile');
	exit;
}

if(isset($_REQUEST['doresetpass']) && !empty($_REQUEST['doresetpass']) && $_REQUEST['doresetpass'] == 'yes'){
	
	if(count($_POST)){
			
		foreach($_POST as $key=>$val){
			
			$_POST[$key] = trim(htmlspecialchars($val));
		}
	}
	
	$email 				= isset($_POST['email']) ? $_POST['email'] : '';
	
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
	else{
			
		$checkemailQry = "SELECT * FROM ".TABLE_PREFIX."backoffice_borrowers WHERE emailaddress = '".$email."'";
		$checkemailSql = mysqli_query($con,$checkemailQry) or die(mysqli_error());
		$checkemailRow = mysqli_fetch_assoc($checkemailSql);
		
		if(empty($checkemailRow)){
			
			$errors['type'] = 'email';
			$errors['msg'] = '* Email address is not registered with us';
			$errorsFinal[] = $errors;
			$flag = 0;
		}
	}
	
	
	if($flag == 1){
		
		$time = time();
		
		$lastid = $checkemailRow['id'];
		
		$uniqueid = md5(uniqid($lastid, true));
		
		$updateSql = "UPDATE ".TABLE_PREFIX."backoffice_borrowers SET 
					  unique_identifier = '".addslashes($uniqueid)."'
					  WHERE id = '".$lastid."'";
					  
		mysqli_query($con,$updateSql) or die(mysqli_error());
		
		
		// Send Reset Password Email
		
		$request = curl_init(BASE_URL.'backoffice/borrowerforgotpassword/'.$lastid);
		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($request);
		curl_close($request);
		
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/borrower-forgot-password?action=sent');
		exit;
	}
	
	$errstr = json_encode($errorsFinal);
	
	//echo '<pre>'; print_r($errorsFinal); //exit;
}
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major">
			<h2><?php echo($transArr['Forgot Password']); ?>?</h2>
			<p><?php echo($transArr["Don't worry we'll help you to retrive your password. Enter your registered email address below:"]); ?></p>
		</header>
		
		<section class="investorsignup">
			
			<?php
			if($_REQUEST['action'] == 'sent'){
			?>
			<div id="message-success">
			 <i class="icon-ok"></i><?php echo($transArr['An email has been sent to your email address with the instructions to reset your password.']); ?><br />
			</div>
			<?php
			}
			?>
			
			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>"">
			
				<input type="hidden" name="doresetpass" value="yes">
					
				<div id="accountmessage" style="display:none;"></div>
				
				<div class="row uniform 50%" style="text-align:left;">
					
					<div class="12u$">
						<input type="text" name="email" id="email" value="<?php echo($email); ?>" placeholder="<?php echo($transArr['Email']); ?>" />
					</div>
					
				</div>
				
				<div class="12u$ formbtn">
					<ul class="actions">
						<li><input type="submit" value="<?php echo($transArr['Reset Password']); ?>" class="special" /></li>
					</ul>
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