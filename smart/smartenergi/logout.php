<?php 
require_once('header.php');

if($_SESSION['usertype'] == 'merchant'){
	$redirecturl = BASE_URL.$_SESSION['currentLang'].'/merchant-signin';
}
else if($_SESSION['usertype'] == 'borrower'){
	$redirecturl = BASE_URL.$_SESSION['currentLang'].'/borrower-signin';
}
else{
	$redirecturl = BASE_URL.$_SESSION['currentLang'].'/signin';
}

//unset($_SESSION['userid']);
//unset($_SESSION['usertype']);
session_destroy();	

header("Location:".$redirecturl);
exit;
?>