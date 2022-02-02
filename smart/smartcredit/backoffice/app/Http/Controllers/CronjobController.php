<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Mail;
use Response;
use Login;
use Session;
use URL;
use View;
use Utility;
use Mails;
use Lemonway;
//https://sandbox-webkit.lemonway.fr/demo/dev/?signingToken=
//LWDEMOX008340052
class CronjobController extends Controller {

	public function __construct(){
		
	}

	public function defaultcommunication(Request $request){	
			
		$config = Utility::getconfig();
		
		//dd($config);
		
		$today = date('d-m-Y');
		
		$todaytimestamp = strtotime($today);
		
		//echo $tmp = strtotime('-90 days', $todaytimestamp); die();
		
		$getnopayments = DB::table("backoffice_loan_payments AS LP")
						 ->leftJoin("backoffice_loan_applications AS LA","LA.id","=","LP.loan_id")
						 ->leftJoin("backoffice_borrowers AS BO","BO.id","=","LA.borrower_id")
						 ->select('LP.*','BO.emailaddress','BO.cellphonenumber')
						 ->where("emi_paid","0")
						 ->orderBy('id')
						 ->groupBy('loan_id')
						 ->get();
		
		//dd($getnopayments);
		
		if(count($getnopayments)){
			
			foreach($getnopayments as $valnopay){
				
				$id = $valnopay->id;
				
				$loan_id = $valnopay->loan_id;
				
				$emi_amount = $valnopay->emi_amount;
				
				$emitimestamp = $valnopay->emi_timestamp;
				
				$cellphonenumber = $config->country_prefix.$valnopay->cellphonenumber;
				$emailaddress = $valnopay->emailaddress;
				
				$threedaysbeforetimestamp = strtotime("-3 days", $emitimestamp);
				$onedaybeforetimestamp = strtotime("-1 day", $emitimestamp);
				$threedaysaftertimestamp = strtotime("+3 days", $emitimestamp);
				$sevendaysaftertimestamp = strtotime("+7 days", $emitimestamp);
				$tendaysaftertimestamp = strtotime("+10 days", $emitimestamp);
				$fifteendaysaftertimestamp = strtotime("+15 days", $emitimestamp);
				$twentyfivedaysaftertimestamp = strtotime("+25 days", $emitimestamp);
				$thirtyfivedaysaftertimestamp = strtotime("+35 days", $emitimestamp);
				$sixtydaysaftertimestamp = strtotime("+60 days", $emitimestamp);
				$ninetydaysaftertimestamp = strtotime("+90 days", $emitimestamp);
				
				if($todaytimestamp == $threedaysbeforetimestamp){
					
					$message = 'Le recordamos que próximamente se realizará el cobro de su préstamo vigente - '.config('constants.project_name');
					
					Utility::sendsms($cellphonenumber,$message);
					
					DB::table("backoffice_loan_payments")->where("id", $id)->update([
						
						'communication_status' => '-3'
					]);
				}
				else if($todaytimestamp == $onedaybeforetimestamp){
					
					Mails::defaultcommunicationmail($loan_id,$emi_amount,'-1');
					
					DB::table("backoffice_loan_payments")->where("id", $id)->update([
						
						'communication_status' => '-1'
					]);
				}
				else if($todaytimestamp == $threedaysaftertimestamp){
					
					$message = 'Le recordamos que su préstamo con '.config('constants.project_name').' lleva más de 3 días de deuda, le rogamos haga efectivo el pago para evitar posibles reclamaciones legales';
					
					Utility::sendsms($cellphonenumber,$message);
					
					DB::table("backoffice_loan_payments")->where("id", $id)->update([
						
						'communication_status' => '+3'
					]);
				}
				else if($todaytimestamp == $sevendaysaftertimestamp){
					
					Mails::defaultcommunicationmail($loan_id,$emi_amount,'+7');
					
					DB::table("backoffice_loan_payments")->where("id", $id)->update([
						
						'communication_status' => '+7'
					]);
				}
				else if($todaytimestamp == $tendaysaftertimestamp){
					
					Mails::defaultcommunicationmail($loan_id,$emi_amount,'+10');
					
					DB::table("backoffice_loan_payments")->where("id", $id)->update([
						
						'communication_status' => '+10'
					]);
				}
				else if($todaytimestamp == $fifteendaysaftertimestamp){
					
					Mails::defaultcommunicationmail($loan_id,$emi_amount,'+15');
					
					DB::table("backoffice_loan_payments")->where("id", $id)->update([
						
						'communication_status' => '+15'
					]);
				}
				else if($todaytimestamp == $twentyfivedaysaftertimestamp){
					
					Mails::defaultcommunicationmail($loan_id,$emi_amount,'+25');
					
					DB::table("backoffice_loan_payments")->where("id", $id)->update([
						
						'communication_status' => '+25'
					]);
				}
				else if($todaytimestamp == $thirtyfivedaysaftertimestamp){
					
					Mails::defaultcommunicationmail($loan_id,$emi_amount,'+35');
					
					DB::table("backoffice_loan_payments")->where("id", $id)->update([
						
						'communication_status' => '+35'
					]);
				}
				else if($todaytimestamp == $sixtydaysaftertimestamp){
					
					Mails::defaultcommunicationmail($loan_id,$emi_amount,'+60');
					
					DB::table("backoffice_loan_payments")->where("id", $id)->update([
						
						'communication_status' => '+60'
					]);
				}
				else if($todaytimestamp == $ninetydaysaftertimestamp){
					
					Mails::defaultcommunicationmail($loan_id,$emi_amount,'+90');
					
					DB::table("backoffice_loan_payments")->where("id", $id)->update([
						
						'communication_status' => '+90'
					]);
				}
			}
		}
		
		mail('neha.pixlr@gmail.com','Daily communication Cron Mail executed','Daily communication Cron Mail executed at '.date('d/m/Y h:i:s A'));
		mail('subh.laha@gmail.com','Daily communication Cron Mail executed','Daily communication Cron Mail executed at '.date('d/m/Y h:i:s A'));
	}

	public function borrowermonthlyinstallment(Request $request){	
					
		
		$today = date('d-m-Y');
		$todaytimestamp = strtotime($today);
		$getnopayments = DB::table("backoffice_loan_payments AS LP")
						 ->join("backoffice_loan_applications AS LA","LA.id","=","LP.loan_id")
						 ->join("backoffice_borrowers AS BO","BO.id","=","LA.borrower_id")
						 ->select('*','LP.id as payment_id')
						 ->whereRaw('emi_timestamp <= '.$todaytimestamp)
						 ->where(array("emi_paid"=>"0","BO.block"=>1,"LA.status"=>"covered"))
						 ->orderBy('LP.id')
						 ->get();

		if(count($getnopayments)){

			$getDefaultTerms = DB::table("config AS SC")
		 ->whereIn('config_type', array("smartcredit_wallet","default_fee","default_rate"))
							 ->select('*')							 
							 ->get();
			foreach($getDefaultTerms as $configVal){

				if($configVal->config_type=="smartcredit_wallet")
					$smartcredit_wallet=	$configVal->config_val;

				if($configVal->config_type=="default_fee")
					$default_fee=	$configVal->config_val;

				if($configVal->config_type=="default_rate")
					$default_rate=	$configVal->config_val;
				
			}			 

			$total_default_rate=(($default_rate)/100);
			$count=1;
			
			$findArr=array();
			$unpaid_arr=array();
			foreach($getnopayments as $key=>$valnopay){

				
				$emi_amount=$valnopay->emi_amount;
				$emi_order=$valnopay->emi_order;
				//$default_apr=$valnopay->loan_apr;
				if(!empty($findArr[$valnopay->loan_id]))
					$findArr[$valnopay->loan_id]=$findArr[$valnopay->loan_id]+1;
			$latedays = round(($todaytimestamp - $valnopay->emi_timestamp)/ (60 * 60 * 24));
				
				if(is_numeric($latedays) && $latedays > 90){

		          		$getallotherpayments = DB::table("backoffice_loan_payments AS LP")    
					          		         ->select('*')
											 ->where(array("loan_id"=>$valnopay->loan_id))
											 ->whereRaw('id >= '.$valnopay->payment_id)
											 ->forPage(0,3)						 
											 ->get();
					
						$overdueamount=0;
						foreach($getallotherpayments as $paymentList){
							$otherinstallmentdays = round(($todaytimestamp - $paymentList->emi_timestamp)/ (60 * 60 * 24));
							$emi=sprintf('%0.2f',($valnopay->emi_amount+($valnopay->emi_amount*($otherinstallmentdays/360)*$total_default_rate)+$default_fee));
							$overdueamount+=$emi;

									DB::table('backoffice_loan_payments')
												->where('id', $paymentList->id)
												->update(array("unpaid_balance"=>$emi,
													           "emi_late_days"=>$otherinstallmentdays,
													           "default_interest"=>($default_rate)
													       ));
						}
						$total_debit=$valnopay->loan_amount+$overdueamount;
				        if(!empty($total_debit)){
		              		$loanstatus=array("total_debit"=>$total_debit);
							DB::table('backoffice_loan_applications')
									->where('id', $valnopay->loan_id)
									->update($loanstatus);
	
						}
						$emi_amount=($total_debit+($total_debit*($latedays/360)*$total_default_rate));
						$findArr[$valnopay->loan_id]=1;
				}else if(is_numeric($latedays) && $latedays < 5){
					$emi_amount=($valnopay->emi_amount+($valnopay->emi_amount*($latedays/360)*$total_default_rate));
				}else{
					$emi_amount=($valnopay->emi_amount)+($valnopay->emi_amount*($latedays/360)*$total_default_rate)+($default_fee);
				}
				//if(empty($valnopay->cardid) && !isset($findArr[$valnopay->loan_id])){	
				if(empty($valnopay->cardid)){
					$month = $valnopay->expirymonth;
					$num_padded = sprintf("%02d", $month);
					Lemonway::UpdateWalletStatus($valnopay->wallet_id,5);	
					$RegisterCard=	Lemonway::RegisterCard(array("wlLogin" => config('constants.LOGIN'),
														    "wlPass" 		=> config('constants.PASSWORD'),
														    "language" 		=> config('constants.LANGUAGE'),
														    "version" 		=> config('constants.VERSION'),
														    "walletIp" 		=> Lemonway::getUserIP(),
														    "walletUa" 		=> config('constants.UA'),
														    "wallet" 		=>$valnopay->wallet_id,
														    "cardType" 		=> "1",
														    "cardNumber" 	=> $valnopay->cardnumber,
														    "cardCode" 		=> $valnopay->cvvnumber,
														    "cardDate" 		=> $num_padded."/".$valnopay->expiryyear
														));
						if(isset($RegisterCard->RegisterCardResult->E->Msg)){
							$errors=$RegisterCard->RegisterCardResult->E->Msg;
						}else{
							$cardid=$RegisterCard->RegisterCardResult->CARD->ID;
							DB::table('backoffice_borrowers')
										->where('id', $valnopay->id)
										->update(array("cardid"=>$cardid));
						}

				}else{
					$cardid= $valnopay->cardid;
				}
				//if(($cardid)  && !isset($findArr[$valnopay->loan_id])){

	if($cardid){
				$MoneyInWithCardId=	Lemonway::MoneyInWithCardId(array(
		                                    "wlLogin"   => config('constants.LOGIN'),
		                                    "wlPass"    => config('constants.PASSWORD'),
		                                    "language"  => config('constants.LANGUAGE'),
		                                    "version"   => config('constants.VERSION'),
		                                    "walletIp"  => Lemonway::getUserIP(),
		                                    "walletUa"  => config('constants.UA'),
		                                    "wallet"    => $valnopay->wallet_id,
		                                    "cardId"=>$valnopay->cardid,
		                                    "amountTot"  =>sprintf('%0.2f',$emi_amount),
		                                    "autoCommission"=>0
		                                ));
				
				//die();
						if(isset($MoneyInWithCardId->MoneyInResult->E)){
								$errors=$MoneyInWithCardId->MoneyInResult->E->Msg;

									$updateArr=array('unpaid_balance'=>$emi_amount,
										              "emi_late_days"=>$latedays,
										              "default_interest"=>($default_rate)
										            );
									DB::table('backoffice_loan_payments')
											->where('id', $valnopay->payment_id)
											->update($updateArr);								
						}else{
								/****** Update borrower wallet balance *********/
								$GetWalletDetailsBorrower=Lemonway::GetWalletDetails($valnopay->wallet_id);
								if(isset($GetWalletDetailsBorrower->GetWalletDetailsResult->E)){
									$errors=$GetWalletDetailsBorrower->GetWalletDetailsResult->E->Msg;

								}else{
									$wallet_balance=$GetWalletDetailsBorrower->GetWalletDetailsResult->WALLET->BAL;
									$updateArr=array('wallet_balance' => $wallet_balance);
									DB::table('backoffice_borrowers')
											->where('id', $valnopay->id)
											->update($updateArr);
								}
								/****** Update borrower wallet balance *********/
								
			if($wallet_balance > $emi_amount){

				if((!empty($findArr[$valnopay->loan_id]) && $findArr[$valnopay->loan_id] < 2 ) || empty($findArr[$valnopay->loan_id])){
						
						

					$investorpayments =DB::table("backoffice_investor_installment as LA")
									  ->join("backoffice_lenders as BL","BL.id","=","LA.lender_id")	
									  ->select('*','LA.id as installment_id')
									  ->where(array("LA.installment_order"=>$emi_order,"LA.loan_id"=>$valnopay->loan_id))
									  ->get();
									   
				$investor_total_interest=0;
				 foreach($investorpayments as $emiAmount){

		$investor_amount=	($emiAmount->installment_amount);
		$investor_total_interest +=$investor_amount;
	$investor_send_amount=Lemonway::SendPayment($valnopay->wallet_id,$emiAmount->wallet_id,sprintf('%0.2f',$investor_amount),$emiAmount->lender_name,"Investor interest");
					if(isset($investor_send_amount->SendPaymentResult->E)){
						$errors=$investor_send_amount->SendPaymentResult->E->Msg;
					}else{
						mail('neha.pixlr@gmail.com','amount credited to investor [loan id( '.$valnopay->unique_id.' ) ]',"emi installllment amount ".$investor_amount.date('d/m/Y h:i:s A'));
						DB::table('backoffice_lenders_payments')
										->insert([			
										        'loan_id'=> $emiAmount->loan_id,
										        'lender_id'=> $emiAmount->lender_id,
												'amount'=>sprintf('%0.2f',$investor_amount),
												'payment_mode'=>"deposit",
												'payment_type'=>"EMI"
										]);
						/****** Update investor wallet balance *******/				
						$GetWalletDetailsInvestor=Lemonway::GetWalletDetails($emiAmount->wallet_id);
						if(isset($GetWalletDetailsInvestor->GetWalletDetailsResult->E)){
							$errors=$GetWalletDetailsInvestor->GetWalletDetailsResult->E->Msg;

						}else{
							$wallet_balance=$GetWalletDetailsInvestor->GetWalletDetailsResult->WALLET->BAL;
							DB::table('backoffice_lenders')
								->where('id', $emiAmount->lender_id)
								->update(array("wallet_balance"=>$wallet_balance));
						}

						/****** Update investor wallet balance *******/	

						$installmentArr=array('installment_paid'=>'1',"paid_date"=>strtotime(date("Y-m-d H:i:s")));
						DB::table('backoffice_investor_installment')
								->where('id', $emiAmount->installment_id)
								->update($installmentArr);	

					}	
				  }

				}
					
				}

				  
				  if(!empty($investor_total_interest)){	

					
					  $smartcredit_amount=($emi_amount)-($investor_total_interest);	
					  echo "<br/> emi amount = ".$emi_amount." investor total interest = ".$investor_total_interest." emi amount = ".$emi_amount." smartcredit amount = ".$smartcredit_amount." loan id = ".$valnopay->loan_id."<br/>";
						$SendPayment=Lemonway::SendPayment($valnopay->wallet_id,$smartcredit_wallet,sprintf('%0.2f',$smartcredit_amount),$valnopay->firstname." ".$valnopay->surname,"Smartcredit");


						if(isset($SendPayment->SendPaymentResult->E)){
							$errors=$SendPayment->SendPaymentResult->E->Msg;
							$updateArr=array('unpaid_balance'=>$emi_amount,
								             "emi_late_days"=>$latedays,
								             "default_interest"=>($default_rate)
								            );
									DB::table('backoffice_loan_payments')
											->where('id', $valnopay->payment_id)
											->update($updateArr);
						}else{
							
							 mail('neha.pixlr@gmail.com','amount credited to smartcredit [loan id( '.$valnopay->unique_id.' ) ]',"emi amount ".$smartcredit_amount.date('d/m/Y h:i:s A'));
							 switch (true) {
										    case $latedays == 0:
										        $payment_staus = 'on_due';
										        break;

										    case $latedays <= 5:
										        $payment_staus = 'paid';
										        break;

										    case ($latedays > 5) && ($latedays < 90):
										        $payment_staus = 'overdue_default';
										        break;

										    case $latedays <= 89:
										        $payment_staus = 'arrears';
										        break;    

										    case $latedays >= 90:
										        $payment_staus = 'breach_of_contract';
										        break;    

										    default:
										        $payment_staus = NULL;
										        break;
										}
							
					
							$updateArr=array('emi_paid'=>"1",
								 			 "paid_balance"=>sprintf('%0.2f',$emi_amount),
								 			 "default_interest"=>($default_rate),
								 			 "emi_paid_date"=>time()	
								 			);
							if(!empty($latedays))
								$updateArr['emi_late_days']=$latedays;

							if(isset($payment_staus))
								$updateArr['payment_status']=$payment_staus;
/*
							if(array_key_exists($valnopay->payment_id, $unpaid_arr)){
								unset($unpaid_arr[$valnopay->payment_id]);
							}*/
							
	
							DB::table('backoffice_loan_payments')
										->where('id', $valnopay->payment_id)
										->update($updateArr);
							
							/****** Check Loan complete or not ********/
							//if($emi_order==$valnopay->loan_terms){
									$countPaidEmi=DB::table('backoffice_loan_payments')
										->select('*')
										->where(array('loan_id'=>$valnopay->loan_id,"emi_paid"=>'1'))
										->get();
								if(count($countPaidEmi)==$valnopay->loan_terms){
									DB::table('backoffice_loan_applications')
										->where('id', $valnopay->loan_id)
										->update(array("status"=>"completed",'close_date'=>time()));
								}
							//}
							/****** Check Loan complete or not ********/


								
						}
					
					
					
						}
					}
				$count++;
				
				}			
			}

																			
		}				
	}
}




/*
				if(empty($valnopay->sddmandate)){
					$RegisterSddMandate=Lemonway::RegisterSddMandate($valnopay->wallet_id,
											                         $valnopay->nameofaccountholder,
											                         $valnopay->bicnumber,
											                         $valnopay->ibannumber,
											                         0);
					if(isset($RegisterSddMandate->RegisterSddMandateResult->E)){
						echo $RegisterSddMandate->RegisterSddMandateResult->E->Msg;
					}else{
						$RegisterSddMandateId=$RegisterSddMandate->RegisterSddMandateResult->SDDMANDATE->ID;
						
						$updateArr=array('sddmandate' => $RegisterSddMandateId);
						
						DB::table('backoffice_loan_applications')
								->where('id', $valnopay->loan_id)
								->update($updateArr);

						
						
					}
				}else{
					
$SignDocumentInit=Lemonway::SignDocumentInit($valnopay->wallet_id,$valnopay->sddmandate,$valnopay->cellphonenumber);
						
						echo "<pre>";
						print_r($SignDocumentInit);
						echo "</pre>";	

						if(isset($SignDocumentInit->SignDocumentInitResult->E->Msg)){

						}else{
							 $token=$SignDocumentInit->SignDocumentInitResult->SIGNDOCUMENT->TOKEN;
						}

						
					$MoneyInSddInit=Lemonway::MoneyInSddInit("Smartcredit-5bb36e62c9b1f","15.00","4830");
						echo "<pre>";
						print_r($MoneyInSddInit);
						echo "</pre>";	


				}
investor emi
				$getnopayments = DB::table("backoffice_loan_applications as LA")
						  ->join("backoffice_investores_bid as IB","IB.loan_id","=","LA.id")
						  ->select('*')
						  ->selectRaw('sum(smc_IB.bid_amount) as total_bid')
						  ->where(array("LA.status"=>'covered',"IB.loan_id"=>13))
						  ->groupby("IB.investor_id")
						  ->get();

						 $investor_emi=sprintf('%0.2f',($valnopay->total_bid/$valnopay->loan_terms));
				for($i=1;$valnopay->loan_terms >= $i;$i++)
				{
					DB::table('backoffice_investor_installment')
										->insert([
										        'loan_id'=>$valnopay->loan_id,
												'lender_id'=>$valnopay->investor_id,
												'installment_amount'=>$investor_emi,
												'installment_order'=>$i
										]);
				}
				*/			