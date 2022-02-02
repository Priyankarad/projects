<?php 
require_once('header.php');
if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/borrower-signin');
	exit;
}
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major myaccountheader">
			<h2><?php echo($transArr['My Loans']); ?></h2>
		</header>
		
		<section>
			
			
			<table id="example" class="display" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo($transArr['Loan']); ?> #</th>
						<th><?php echo($transArr['Amount Lended']); ?></th>
						<th><?php echo($transArr['Terms']); ?></th>
						<th>% <?php echo($transArr['Annual Interest']); ?></th>
						<th><?php echo($transArr['Product Name']); ?></th>
						<th><?php echo($transArr['Applied On']); ?></th>
						<th><?php echo($transArr['Status']); ?></th>
						<th><?php echo($transArr['Actions']); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					$sql = "SELECT LA.*, CONCAT_WS(' ',BO.firstname, BO.surname) AS borrowername FROM ".TABLE_PREFIX."backoffice_loan_applications AS LA
							LEFT JOIN ".TABLE_PREFIX."backoffice_borrowers BO ON BO.id = LA.borrower_id 
							WHERE LA.borrower_id = '".$_SESSION['userid']."'
							ORDER BY LA.id DESC";
							
					$qry = mysqli_query($con,$sql) or die(mysqli_error());
					$rows = mysqli_num_rows($qry);
					
					if(count($rows)){
						
						$sl = 1;
						while($row = mysqli_fetch_assoc($qry)){
							
							$id = stripslashes($row['id']);
							$loan_id = stripslashes($row['unique_id']);
							$loan_terms = stripslashes($row['loan_terms']);
							$loan_amount = stripslashes($row['loan_amount']);
							$loan_apr = stripslashes($row['loan_apr']);
							$product_name = stripslashes($row['product_name']);
							$createdate = stripslashes($row['createdate']);
							$status = ucfirst(stripslashes($row['status']));
							?>
							<tr>
								<td><?php echo($sl); ?></td>
								<td><?php echo($loan_id); ?></td>
								<td>&euro;<?php echo($loan_amount); ?></td>
								<td><?php echo($loan_terms); ?> months</td>
								<td><?php echo($loan_apr); ?></td>
								<td><?php echo($product_name); ?></td>
								<td><?php echo(date('d/m/Y',$createdate)); ?></td>
								<td><?php echo($status); ?></td>
								<td><a href="<?=BASE_URL.$getLang?>/myaccount/borrower/mypayments?loan_id=<?php echo($id); ?>">Payments</a></td>
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