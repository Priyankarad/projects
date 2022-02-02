<?php
include('../config.php');

unset($_SESSION[base64_encode(PROJECT_NAME).'userid']);
unset($_SESSION[base64_encode(PROJECT_NAME).'username']);
unset($_SESSION[base64_encode(PROJECT_NAME).'usergroup']);

setcookie(base64_encode(PROJECT_NAME).'crm_cookie',$cookieval,time()-60);

header('location:'.ADMIN_URL);
?>