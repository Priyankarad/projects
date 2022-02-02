<?php 
require_once('header.php');

$identifier = isset($_REQUEST['identifier']) ? $_REQUEST['identifier'] : '';

$checkexistsQry = selectQueryWithJoin("SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE unique_identifier = '".$identifier."'",$con);
$checkexistsRow = mysqli_num_rows($checkexistsQry);

if($checkexistsRow == 0){
	
	header("Location:".BASE_URL.$_SESSION['currentLang']);
	exit;
}
else{
	
	$checkexistsData = mysqli_fetch_assoc($checkexistsQry);
	
	$_SESSION['userid'] = $checkexistsData['id'];
	$_SESSION['usertype'] = 'merchant';
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/merchant/myprofile#bank');
	exit;
}
?>

<?php 
require_once('footer.php');
?>