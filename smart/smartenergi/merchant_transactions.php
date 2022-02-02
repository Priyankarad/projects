<?php 
require_once('header.php');

if($_SESSION['usertype'] != 'merchant'){
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/merchant-signin');
	exit;
}
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major myaccountheader">
			<h2><?php echo($transArr['Fund Transfer']); ?></h2>
		</header>
		
		<section>
			<table class="example" class="display" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th>Payer</th>
						<th>Amount</th>
						<th>Date</th>
						<th>Message</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$MLABEL=array();
					if(!empty($_SESSION['wallet_id'])){
					$GetWalletTransHistory= GetWalletTransHistory($_SESSION['wallet_id']);
					if(isset($GetWalletTransHistory->GetWalletTransHistoryResult->E)){
						$errors =$response->RegisterWalletResult->E->Msg;
						
					}else{
						$result1=$GetWalletTransHistory->GetWalletTransHistoryResult->TRANS->HPAY;
					}

					if(count($result1) == 1){
						$result[]=$result1;
					}else
					    $result=$result1;

					if(count($result)){
						$sl = 1;
						
						foreach($result as $history){
							if(!$history->MLABEL){
							$borrower_name	=getNameUsingWallet($history->SEN,"borrower");
							
					?>
					<tr>
						<td><?php echo($sl); ?></td>
						<td><?php echo (ucfirst($borrower_name['firstname']." ".$borrower_name['surname'])." ( ".$borrower_name['emailaddress']." )"); ?></td>
						<td>&euro;<?php echo($history->CRED); ?></td>
						<td><?php echo($history->DATE); ?></td>
						<td><?php echo($history->MSG); ?></td>
					</tr>
							<?php
							$sl++;
						}else{
						   $MLABEL[]=$history;
						}		
								} 
							}
						}
					else{
						echo "Wallet id not available.";
					}
					?>					
				</tbody>
			</table>

<?php if(!empty($MLABEL)){ ?>
<h2><?php echo($transArr['Withdrawal Transactions']); ?></h2>			
			<table class="example" class="display" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th>Amount</th>
						<th>IBAN</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sl1 = 1;
						foreach($MLABEL as $history){
							if($history->MLABEL){
?>
							<tr>
								<td><?php echo($sl1); ?></td>
								<td>&euro;<?php echo($history->DEB); ?></td>
								<td><?php echo($history->MLABEL); ?></td>
								<td><?php echo($history->DATE); ?></td>
								
							</tr>
						<?php
							}	
							$sl1++;
						}
						
					?>					
				</tbody>
			</table>
	<?php } ?>		
			
		</section>
		
	</div>
</section>

<script>

$.extend( true, $.fn.dataTable.defaults, {
    "searching": true
} );

$(document).ready(function() {
    $('.example').DataTable();
	$('#example_length').hide();
});
</script>

<?php 
require_once('footer.php');
?>