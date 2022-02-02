<?php 
require_once('header.php');

$identifier = isset($_REQUEST['identifier']) ? $_REQUEST['identifier'] : '';

if(isset($_REQUEST['doresetpass']) && !empty($_REQUEST['doresetpass']) && $_REQUEST['doresetpass'] == 'yes'){
	
	if(count($_POST)){
			
		foreach($_POST as $key=>$val){
			
			$_POST[$key] = trim(htmlspecialchars($val));
		}
	}
	
	$newpass 			= isset($_POST['newpass']) ? $_POST['newpass'] : '';
	$conpass 			= isset($_POST['conpass']) ? $_POST['conpass'] : '';
	
	$flag = 1;
	
	if(empty($newpass)){
		
		$errors['type'] = 'newpass';
		$errors['msg'] = '* Enter New Password';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if(empty($conpass)){
		
		$errors['type'] = 'conpass';
		$errors['msg'] = '* Confirm Password';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	if($conpass != $newpass){
		
		$errors['type'] = 'conpass';
		$errors['msg'] = '* Passwords mismatch';
		$errorsFinal[] = $errors;
		$flag = 0;
	}
	
	
	if($flag == 1){

		$updateSql = updateQuery("backoffice_borrowers",
									array("unique_identifier"=>$identifier),
									array("password"=>addslashes(md5($newpass))),
									$con);
	
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/resetpassword/borrower/'.$identifier.'?action=success');
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
			<h2><?php echo($transArr['Reset Password']); ?></h2>
			<p><?php echo($transArr['Please set your new password below']); ?></p>
		</header>
		
		<section class="investorsignup">
			
			<?php
			if($_REQUEST['action'] == 'success'){
			?>
			<div id="message-success">
			 <i class="icon-ok"></i><?php echo($transArr['Your password has been successfully reset. Please']); ?> <a href="<?=BASE_URL.$getLang?>/borrower-signin"><?php echo($transArr['Click here to Sign In']); ?></a><br />
			</div>
			<?php
			}
			?>
			
			<form method="post" action="<?=$_SERVER['REQUEST_URI']?>"">
			
				<input type="hidden" name="doresetpass" value="yes">
					
				<div id="accountmessage" style="display:none;"></div>
				
				<div class="row uniform 50%" style="text-align:left;">
					
					<div class="12u$">
						<input type="password" name="newpass" id="newpass" value="<?php echo($newpass); ?>" placeholder="<?php echo($transArr['New Password']); ?>" />
					</div>
					
					<div class="12u$">
						<input type="password" name="conpass" id="conpass" value="<?php echo($conpass); ?>" placeholder="<?php echo($transArr['Confirm Password']); ?>" />
					</div>
					
				</div>
				
				<div class="12u$ formbtn">
					<ul class="actions">
						<li><input type="submit" value="Reset Password" class="special" /></li>
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