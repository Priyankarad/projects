<?php 
require_once('header.php'); 
?>
<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major myaccountheader">
			<h2><?php echo($transArr['loans available to invest	']); ?></h2>
		</header>
		
		<section>
			
			
			<table id="example" class="display" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo($transArr['Loan']); ?> #</th>
						<th><?php echo($transArr['Amount Lended']); ?></th>
						<th><?php echo($transArr['Terms']); ?></th>
						<th>% APR</th>
						<th><?php echo($transArr['Product Name']); ?></th>
						<th><?php echo($transArr['Date of sale']); ?></th>
						<th><?php echo($transArr['Invest']); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
		
					$rows = selectQueryWithJoin("SELECT a.*,count(distinct(c.investor_id)) as total_investor,sum(c.bid_amount) as total_bid FROM 
     ".TABLE_PREFIX."backoffice_loan_applications as a JOIN 
     ".TABLE_PREFIX."backoffice_investores_bid as c ON c.loan_id=a.id  WHERE a.status IN ('approved','covered') group by a.id order by a.id desc",$con);

					if(mysqli_num_rows($rows)){
						$sl = 1;
						while($row=mysqli_fetch_assoc($rows)){
							
							$loan_id = stripslashes($row['unique_id']);
							$loan_terms = stripslashes($row['loan_terms']);
							$loan_amount = stripslashes($row['loan_amount']);
							$loan_apr = stripslashes($row['loan_apr']);
							$product_name = stripslashes($row['product_name']);
							$createdate = stripslashes($row['createdate']);
							$payment_sent = ucfirst(stripslashes($row['payment_sent']));
							$percent1=intval($row['total_bid']/$row['loan_amount'] * 100);
							$percent = $percent1."%";
							?>

							<tr>
								<td><?php echo($sl); ?></td>
								<td><?php echo($loan_id); ?></td>
								<td><?php echo($loan_amount); ?>&euro;</td>
								<td><?php echo($loan_terms); ?> months</td>
								<td><?php echo($loan_apr); ?></td>
								<td><?php echo($product_name); ?></td>
								<td><?php echo(date('d/m/Y',$createdate)); ?></td>
								<td>
<?php  if(!empty($percent1)){
			$remainingdata=100-$percent1;
			echo '<label>'.$remainingdata."%"." Remaining".'</label>'; 
			if(!empty($remainingdata)){
			 ?>

								<div class="progressD">
									<div class="progress-bar progress-bar-striped active" role="progressbar" style="width:<?php echo($percent); ?>"><?php echo($percent); ?>	</div>
									<?php if(!empty($remainingdata)){ ?>
									<div class="progress-bar progress-bar-striped active" role="progressbar" style="width:<?=$remainingdata."%"?>;background-color: red;"><?=$remainingdata."%"?></div>
									<?php } ?>
								</div>
							<?php } } ?>
								</td>
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
<?php 

require_once('footer.php'); 
?>