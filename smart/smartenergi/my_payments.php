<?php 
require_once('header.php');

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/borrower-signin');
	exit;
}
/*
$p = intval(3000);
$j = 18.68/(12*100);
$n = 12;

$m = ($p*$j)/(1-pow((1+$j),-$n));
echo pow((1+$j),-$n);
die();*/
$loan_id = $_REQUEST['loan_id'];

if(!empty($loan_id)){
	
	$data = selectQuery("backoffice_loan_applications","id = '".$loan_id."' AND borrower_id = '".$_SESSION['userid']."'",$con);
	
	if(empty($data)){		
		header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/borrower/myloans');
		exit;
	}
}
else{	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/myaccount/borrower/myloans');
	exit;
}
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major myaccountheader">
			<h2><?php echo($transArr['My Payments']); ?></h2>
		</header>
		
		<section>
			
			
			<table id="example" class="display" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo($transArr['EMI Amount']); ?> #</th>
						<th><?php echo($transArr['EMI Date']); ?></th>
						<th><?php echo($transArr['Status']); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					$qry = selectQueryWithJoin("SELECT * FROM ".TABLE_PREFIX."backoffice_loan_payments WHERE loan_id = '".$loan_id."'",$con);
					$rows = mysqli_num_rows($qry);
					
					if(count($rows)){
						
						$sl = 1;
						while($row = mysqli_fetch_assoc($qry)){
							
							$emi_amount = stripslashes($row['emi_amount']);
							$emi_date = stripslashes(date('d/m/Y',$row['emi_timestamp']));
							$emi_paid = stripslashes($row['emi_paid']);
							
							switch($emi_paid){
																
								case "1":
									$paytext = 'Paid';
									break;
								case "0":
									$paytext = 'Due';
									break;
							}
							?>
							<tr>
								<td><?php echo($sl); ?></td>
								<td>&euro; <?php echo($emi_amount); ?></td>
								<td><?php echo($emi_date); ?></td>
								<td><?php echo($paytext); ?></td>
							</tr>
							<?php
							$sl++;
						}
					}
					?>					
				</tbody>
			</table>
			
			
		</section>
		
	</div>
</section>

<script>

$.extend( true, $.fn.dataTable.defaults, {
    "searching": false
} );

$(document).ready(function() {
    $('#example').DataTable();
	$('#example_length').hide();
});
</script>

<?php 
require_once('footer.php');
?>