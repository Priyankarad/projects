<?php
include('../config.php');

if($_COOKIE[base64_encode(PROJECT_NAME).'crm_cookie'] != ""){
	
	$getcookie = explode("@@",$_COOKIE[base64_encode(PROJECT_NAME).'crm_cookie']);
	$_SESSION[base64_encode(PROJECT_NAME).'userid'] = $getcookie[0];
	$_SESSION[base64_encode(PROJECT_NAME).'username'] = $getcookie[1];
	$_SESSION[base64_encode(PROJECT_NAME).'usergroup'] = $getcookie[2];
}

if($_SESSION[base64_encode(PROJECT_NAME).'userid'] != "")
{
	header('location:dashboard.php');
	exit();
}

if(isset($_POST['dologin']) && $_POST['dologin'] == 'yes')
{
	$chklogin = "SELECT * FROM ".TABLE_PREFIX."admin WHERE 
				 username = '".$_POST['username']."' AND 
				 password = '".$_POST['password']."' AND status = 'Yes'"; 
				 
	$chklogin = mysqli_query($con,$chklogin) or die(mysqli_error());
	$cntlogin = mysqli_num_rows($chklogin);
	$rowlogin = mysqli_fetch_array($chklogin);
	
	if($cntlogin)
	{
		$_SESSION[base64_encode(PROJECT_NAME).'userid'] = $rowlogin['id'];
		$_SESSION[base64_encode(PROJECT_NAME).'username'] = $rowlogin['username'];
		$_SESSION[base64_encode(PROJECT_NAME).'usergroup'] = $rowlogin['user_group'];
		
		if(isset($_POST['rememberme']) && $_POST['rememberme'] == 'yes'){
			
			$cookieval = $_SESSION[base64_encode(PROJECT_NAME).'userid']."@@".$_SESSION[base64_encode(PROJECT_NAME).'username']."@@".$_SESSION[base64_encode(PROJECT_NAME).'usergroup'];
			setcookie(base64_encode(PROJECT_NAME).'crm_cookie',$cookieval,time()+(7*24*60*60));
		}

		header('location:dashboard.php');
	}
	else
	{
		header('location:'.ADMIN_URL.'index.php?login=failed');
	}
}
?>

<!DOCTYPE html>
<html class="bg-black">
<head>
<meta charset="UTF-8">
<title><?=PROJECT_NAME?> | Log in</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- bootstrap 3.0.2 -->
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<link rel="shortcut icon" type="image/png" href="<?=BASE_URL?>/images/favicon.png"/>
</head>
<body class="bg-black">
<div class="form-box" id="login-box" style="text-align:center">
  
  <h2 style="margin:20px 0"><?=PROJECT_NAME?></h2>
  	
	<?php
	if($_REQUEST['login'] == 'failed'){
		
		?>
		<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<b>Login failed!</b> Invalid username or password.
		</div>
		<?php
	}
	?>
	
  <div class="header">Sign In</div>
  <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
  	<input type="hidden" name="dologin" value="yes" />
	
    <div class="body bg-gray">
      <div class="form-group">
        <input type="text" name="username" id="username" class="form-control" placeholder="User ID" required/>
      </div>
      <div class="form-group">
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required/>
      </div>
      <!--<div class="form-group">
        <div class="checkbox">
			<label style="line-height:20px">
				<input type="checkbox" id="rememberme" name="rememberme" value="yes"/>&nbsp;&nbsp;Remember me
			</label>
		</div> 
	  </div>-->
    </div>
	
    <div class="footer">
      <button type="submit" class="btn bg-olive btn-block">Sign me in</button>
      <!--<p><a href="#">I forgot my password</a></p>-->
    </div>
	
  </form>
  
  <h6 style="margin-top:20px;">Copyright &copy; <?=date('Y')?>. <?=PROJECT_NAME?></h6>
  
</div>
<!-- jQuery 2.0.2 -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="js/AdminLTE/app.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="js/AdminLTE/demo.js" type="text/javascript"></script>   
</body>
</html>