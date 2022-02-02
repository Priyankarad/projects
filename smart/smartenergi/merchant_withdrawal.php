<?php 
require_once('header.php');
if($_SESSION['usertype'] != 'merchant'){
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/signin');
	exit;
}
$errors=array();
$success="";
if(isset($_POST['walletamountwithdraw'])){
	if(!empty($_POST['withdraw_amount'])){
	if(isset($_SESSION['wallet_id']) && $_SESSION['wallet_id']!=""){
		$amountTot=sprintf('%0.2f', $_POST['withdraw_amount']);

		if($_POST['iban']!="" && $_POST['accountholder']!=""){
			$RegisteredIBAN=RegisterIBAN($_SESSION['wallet_id'],$_POST['iban'],$_POST['accountholder'],$_POST['bic']);
			
			if(isset($RegisteredIBAN->RegisterIBANResult->E->Msg)){
				$errors[]=$RegisteredIBAN->RegisterIBANResult->E->Msg;
			}else{
				$ibanid=$RegisteredIBAN->RegisterIBANResult->IBAN->ID;
				updateQuery('backoffice_merchants',
								array('id'=>$_SESSION['userid']),
								array('iban_number'=>$_POST['iban'],
									  'account_holder'=>$_POST['accountholder'],
									  'bic'=>$_POST['bic'],
									  'iban_id'=>$ibanid
									),
								$con
					);
				$MoneyOut=	MoneyOut($_SESSION['wallet_id'],$amountTot,$ibanid);
				if(isset($MoneyOut->MoneyOutResult->E->Msg)){
					$errors[]=$MoneyOut->MoneyOutResult->E->Msg;
				}else{
					$GetInvestorWalletDetails = GetWalletDetails($_SESSION['wallet_id']);
					if(isset($GetInvestorWalletDetails->GetWalletDetailsResult->E)){
						$errors[]=$GetWalletDetails->GetWalletDetailsResult->E->Msg;

					}else{
						$wallet_balance=$GetInvestorWalletDetails->GetWalletDetailsResult->WALLET->BAL;
						updateQuery('backoffice_merchants',
									array('id'=>$_SESSION['userid']),
									array('wallet_balance'=>$wallet_balance),
									$con
						);
						$success="Amount withdraw successfully from your wallet.";
					}
				}
			}
		}else{
			$MoneyOut=	MoneyOut($_SESSION['wallet_id'],$amountTot,$ibanid);
			if(isset($MoneyOut->MoneyOutResult->E->Msg)){
				$errors[]=$MoneyOut->MoneyOutResult->E->Msg;
			}else{
				$GetInvestorWalletDetails = GetWalletDetails($_SESSION['wallet_id']);
				if(isset($GetInvestorWalletDetails->GetWalletDetailsResult->E)){
					$errors[]=$GetWalletDetails->GetWalletDetailsResult->E->Msg;

				}else{
					$wallet_balance=$GetInvestorWalletDetails->GetWalletDetailsResult->WALLET->BAL;
					updateQuery('backoffice_merchants',
								array('id'=>$_SESSION['userid']),
								array('wallet_balance'=>$wallet_balance),
								$con
					);
					$success="Amount withdraw successfully from your wallet.";
				}
			}
		}
	}else{
		$errors[]="Please create wallet first.";
	}
	}else{
		$errors[]="Please enter withdraw amount.";
	}
}

$getMerchantRow = selectQuery("backoffice_merchants","id =".$_SESSION['userid'],$con);;
?>

<div class="invest_dashboard">
	<div class="container">
		<?php
		if(!empty($errors)){
				echo '<div class="12 12u$(medium)">';
				foreach($errors as $errorsval){
					echo '<p style="color:red">'.$errorsval.'</p>';
				}
				echo '</div>';
		}else if($success!=""){
			echo "<p>".$success."</p>";
		}
		?>
		<div class="my_dashbox deposits_Ins">
			<div class="row 100%">
				<div class="9u 12u$(medium)">
					<div class="form_dopt">
						

						<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
							<div class="row 100%">
								<div class="3u 12u$(medium)">
									<input type="text" name="accountholder" placeholder="holder">
								</div>
								<div class="3u 12u$(medium)">
									<input type="text" name="bic" placeholder="BIC">
								</div>
								<div class="3u 12u$(medium)">
									<input type="text" class="" name="iban" placeholder="iban">
								</div>
								<div class="3u 12u$(medium)">
									<input type="text" name="withdraw_amount" placeholder="withdraw amount">
								</div>
								<div class="3u 12u$(medium)">
									<input type="submit" value="Withdraw amount" name="walletamountwithdraw" class="with_drawlB">
								</div>
							</div>
						</form>
					</div>

					<div class="form_cont">	
						<h3>:)</h3>
						<h1>We are almost ready</h1>
						<p>Our payment entity is verifying your identity document. It is a very important step that ensures the tranquility and safety of all our users. In 24 working hours you can deposit money in your wallet and start investing.</p>
					</div>

				</div>
				<div class="3u 12u$(medium)">
					<div class="Dinvest-bx">
						<h3>MY WALLET <i class="fa fa-info-circle"></i></h3>
						<div class="Dbody-box">
							<div class="dprice-invest">
								<h1>€ <?php

	if(isset($getMerchantRow['wallet_balance']) && $getMerchantRow['wallet_balance']!="")
	 	echo $getMerchantRow['wallet_balance'];
	else 
		echo "0.00"; 							
								 ?></h1>
							</div>
							<button type="button" class="collaspe_btns"> Details </button>
							<div class="collaspeable_div">
								<table class="table">
								   <tbody>
								        <tr>
								         <td class="info-tooltip text-center"><a href="#"><i class="fa fa-info-circle"></i></a></td>
								         <td>Joined</td>
								         <td class="success nowrap">€ 0.00</td>
								        </tr>
								        <tr>
								         <td class="info-tooltip text-center"><a href="#"><i class="fa fa-info-circle"></i></a></td>
								         <td>Joined</td>
								         <td class="success nowrap">€ 0.00</td>
								        </tr>
								        <tr>
								         <td class="info-tooltip text-center"><a href="#"><i class="fa fa-info-circle"></i></a></td>
								         <td>Joined</td>
								         <td class="success nowrap">€ 0.00</td>
								        </tr>
								        <tr>
								         <td class="info-tooltip text-center"><a href="#"><i class="fa fa-info-circle"></i></a></td>
								         <td>Joined</td>
								         <td class="success nowrap">€ 0.00</td>
								        </tr>
								        <tr>
								         <td class="info-tooltip text-center"><a href="#"><i class="fa fa-info-circle"></i></a></td>
								         <td>Joined</td>
								         <td class="success nowrap">€ 0.00</td>
								        </tr>
								   </tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<?php require_once('footer.php');