<?php 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Adminlogin;
use Session;
use Mails;
use Utility;

class PaymentsController extends Controller {

	protected $mode = '';
	
	public function __construct()
	{
		$this->middleware('guest');
		
		if(!Adminlogin::isloggedin()){
			
			return redirect()->route('adminlogin')->send();
			exit;
		}
	}

	public function index(Request $request)
	{	   
		$loan_unique_id = '';
		$loan_id = '';
		$errors = array();
		
		$loanInstallments = array();
		$loanDetails = array();
		
		$sectionname = 'Payments';
		
		$all_install_cleared = 0;
		$loan_closed = 0;
		if($request->has('id') || ($request->has('act') && $request->input('act') == 'search')){

			$loan_unique_id = $request->input('id');
			
			$flag = 0;
			
			if(empty($loan_unique_id)){
				
				$errors[] = 'Enter Loan ID';
				$flag = 1;
			}
			else{
				
				// Get Loan ID
				$getLoan = DB::table('backoffice_loan_applications AS LA')
						   ->leftJoin('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')
						   ->leftJoin('backoffice_merchants AS BM', 'BM.id', '=', 'LA.merchant_id')
						   ->select('LA.*','BO.firstname','BO.surname','BM.bank_account_no','BM.bank_name')
						   ->where("LA.unique_id","=",$loan_unique_id)
						   ->first();
				if(empty($getLoan)){
					
					$errors[] = 'Invalid Loan ID';
					$flag = 1;
				}
			}
			
			if($flag == 0){
						  
				$loan_id = $getLoan->id;
				
				$loanDetails = $getLoan;
				
				// Get Loan Installments
				
				$loanInstallments = DB::table('backoffice_loan_payments')
								   ->where("loan_id","=",$loan_id)
								   ->get();
						   
				//dd($loanInstallments);
				
				
				$emi_c = 0;
				
				if(count($loanInstallments)){
					
					foreach($loanInstallments as $emi){
						
						if($emi->emi_paid == 1)
							$emi_c++;
					}
				}
				
				$all_install_cleared = $emi_c == $getLoan->loan_terms ? 1 : 0;
				$loan_closed = $getLoan->status == 'closed' ? 1 : 0;
				
				//dd($all_install_cleared);
				
				$sectionname = 'Payments for Loan ID: "'.$loan_unique_id.'"';
			}
			
			if($request->has('act') && $request->input('act') == 'markpaid'){
				
				//dd($request->all());
				
				$emi_id = $request->input('emi_id');
				$loan_unique_id = $request->input('id');
				
				DB::table('backoffice_loan_payments')
					->where('id', $emi_id)
					->update(
					[
						'emi_paid' => '1'
					]
				);
				
				return redirect()->route('adminloanpayments', ['id' => $loan_unique_id])->with('action','updated');
			}
			
			if($request->has('act') && $request->input('act') == 'markclose'){
				
				//dd($request->all());
				
				$loan_id = $request->input('loan_id');
				$loan_unique_id = $request->input('id');
				
				DB::table('backoffice_loan_applications')
					->where('id', $loan_id)
					->update(
					[
						'status' => 'closed',
						'close_date' => time()
					]
				);
				
				Mails::loanclosed($loan_id);
				
				return redirect()->route('adminloanpayments', ['id' => $loan_unique_id])->with('action','closed');
			}
		}else if($request->segment(2)!="" && !is_numeric($request->segment(2))){
			  $flag=0;
			  $loan_unique_id=trim($request->segment(2));
			  $loanDetails = DB::table('backoffice_loan_applications AS LA')
						   ->leftJoin('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')
						   ->leftJoin('backoffice_merchants AS BM', 'BM.id', '=', 'LA.merchant_id')
						   ->select('LA.*','BO.firstname','BO.surname','BO.accountnumber','BO.bankname','BO.street_bank_branch','BO.bank_branch','BO.ibannumber','BO.nameofaccountholder')
						   ->where("LA.unique_id","=",$loan_unique_id)
						   ->first();

				if(empty($loanDetails)){
					
					$errors[] = 'Invalid Loan ID';
					$flag = 1;
				}

            if($flag==0){ 
				$loanInstallments = DB::table('backoffice_loan_payments')
								   ->where("loan_id","=",$loanDetails->id)
								   ->get();
						   
				//dd($loanInstallments);
				
				
				$emi_c = 0;
				
				if(count($loanInstallments)){
					
					foreach($loanInstallments as $emi){
						
						if($emi->emi_paid == 1)
							$emi_c++;
					}
				}
				
				$all_install_cleared = $emi_c == $loanDetails->loan_terms ? 1 : 0;
				$loan_closed = $loanDetails->status == 'closed' ? 1 : 0;
				
				//dd($all_install_cleared);
				
				$sectionname = 'Payments for Loan ID: "'.$loan_unique_id.'"';
             }  
			
		}else if($request->segment(2)!="" && is_numeric($request->segment(2))){
			  $merchant_id=$request->segment(2);
			  $checkmerchant=DB::table('backoffice_merchants AS BM')
				   ->where('BM.id','=',$merchant_id)
				   ->first();
				if(empty($checkmerchant)){
                      return abort(404);
				}   
             	$approved_loans = DB::table('backoffice_loan_applications AS LA')
								   ->Join('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')
								   ->select('LA.*','BO.firstname','BO.surname')
								   ->whereIn('LA.status',array('approved','covered'))
								   ->where('LA.merchant_id','=',$merchant_id)
								   ->orderBy('LA.id', 'desc')
								   ->get();
			
				    $data['approved_loans'] = $approved_loans;
		}else{
			//DB::enableQueryLog();
			$current_time=time();
			$approved_loans = DB::table("backoffice_loan_applications AS LA")
							  ->join('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')	
					          ->select('LA.*','BO.firstname','BO.surname',                    
					                    DB::raw("(select a.emi_timestamp from smc_backoffice_loan_payments as a where a.loan_id=smc_LA.id and  a.emi_timestamp > ".$current_time." order by a.id asc limit 0,1) AS next_payment_date "),
					                    DB::raw("(select sum(b.emi_amount) from smc_backoffice_loan_payments as b where b.loan_id=smc_LA.id and b.emi_paid='0') AS total_debit_amount"),
					                    DB::raw("(select c.emi_late_days from smc_backoffice_loan_payments as c where c.loan_id=smc_LA.id and c.emi_paid='0' order by c.id asc limit 0,1) AS total_past_days")
					                )
					          ->whereIn('LA.status',array('covered','completed'))
				   			  ->orderBy('LA.id', 'desc')
					          ->get();
			//dd(DB::getQueryLog());
					          /*
			$approved_loans = DB::table('backoffice_loan_applications AS LA')
				   ->leftJoin('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')
				   ->select('LA.*','BO.firstname','BO.surname')
				   ->where('LA.status','covered')
				   ->orderBy('LA.id', 'desc')
				   ->get();
			*/
		    $data['approved_loans'] = $approved_loans;
		}

		

		
		$data['records'] = $loanInstallments;
		$data['loandetails'] = $loanDetails;
		$data['loan_unique_id'] = $loan_unique_id;
		$data['loanid'] = $loan_id;
		$data['errors'] = $errors;
		$data['all_install_cleared'] = $all_install_cleared;
		$data['loan_closed'] = $loan_closed;
		
		$data['sectionname'] = $sectionname;
		$data['pagetitle'] = $sectionname.' - '.config('constants.project_name');
		$data['pagedescription'] = $sectionname.' - '.config('constants.project_name');
		
		return view('admin.loanpayments',$data);
	}

	function getLoandetails(){
	//	echo $request->input('loan_id');
		$loan_id=$_POST['loan_id'];

		$variables = Utility::variables();
		//DB::enableQueryLog();
		$approved_loans = DB::table('backoffice_loan_applications AS LA')
				   ->leftJoin('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')
				   ->leftJoin('backoffice_merchants AS BM', 'BM.id', '=', 'LA.merchant_id')
				   ->leftJoin('loan_petitions AS LP', 'LP.loan_id', '=', 'LA.id')
				   ->select("LP.*",'LA.*','BO.*','LA.id as id','LA.status as loan_status')
				   ->whereIn('LA.status',array('breach_of_contract','covered','completed'))
				   ->where('LA.unique_id','=',$loan_id)
				   ->orderBy('LA.id', 'desc')
				   ->first();
		//$laQuery = DB::getQueryLog();
		$attachments = array();
		$genfiles = array();
		$attachmentsbytype = array();
		$payments = array();
		if(!empty($approved_loans)){
			
				
				$loan_id = $approved_loans->id;
				//echo $loan_id;
				$unique_id = $approved_loans->unique_id;
				
				// Get Attachments
				$documents = DB::table('backoffice_loan_documents')
							 ->where('loan_id','=',$loan_id)
							 ->where('type','=','useruploaded')
							 ->get();
							 
				$attachments[$unique_id] = $documents;
				
				// Get Documents
				$documents = DB::table('backoffice_loan_documents')
							 ->where('loan_id','=',$loan_id)
							 ->where('type','=','systemgenerated')
							 ->get();
							 
				$genfiles[$unique_id] = $documents;
				
				// Get Payments
				//echo $loan_id;
				$paymentsdata = DB::table('backoffice_loan_payments')
								 ->where('loan_id','=',$loan_id)
								 ->get();
					//print_r($paymentsdata);		 
				$payments[$unique_id] = $paymentsdata;
				
				// Get Attachment by type
				$attachmentType = ['lastpayslip','bankcertificate','idproof','budgetattachment'];
				
				foreach($attachmentType as $valattach){
					
					$attachdata = DB::table('backoffice_loan_documents')
									->where('loan_id','=',$loan_id)
									->where('document_type','=',$valattach)
									->first();
									
					$attachmentsbytype[$unique_id][$valattach] = !empty($attachdata) ? $attachdata->document_path : '';									
				}
				/*$manual_payments =DB::table('manual_payment')
						   ->select('*')
						   ->where('loan_id',$loan_id)
						   ->orderBy('id', 'desc')
						   ->get();
				$data['manual_payments'] = $manual_payments;*/				   
				$data['attachments'] = $attachments;
				$data['genfiles'] = $genfiles;
				$data['attachmentsbytype'] = $attachmentsbytype;
				$data['payments'] = $payments;		   
		        $data['records']=$approved_loans;
				$data['variables'] = $variables;
			}else{
				$approved_loans="This Loan is not approved yet.";
				$data['records']=$approved_loans;
			}
		
		return view('admin.loandetails',$data);	
	}

	public function getWalletList(Request $request){
        $borrower_wallets = DB::table('backoffice_borrowers AS BO')
						   ->select('BO.wallet_id','BO.emailaddress')
						   ->where('BO.wallet_id','!=','')
						   ->orderBy('BO.id', 'desc')
						   ->get();
		$merchant_wallets = DB::table('backoffice_merchants AS ME')
						   ->select('ME.wallet_id','ME.email')
						   ->where('ME.wallet_id','!=','')
						   ->orderBy('ME.id', 'desc')
						   ->get();
		$lender_wallets =DB::table('backoffice_lenders AS LE')
						   ->select('LE.wallet_id','LE.email')
						   ->where('LE.wallet_id','!=','')
						   ->orderBy('LE.id', 'desc')
						   ->get();
		$sectionname = 'Wallet List';				   
		$data['merchant_wallets'] = $merchant_wallets;
		$data['borrower_wallets'] = $borrower_wallets;
		$data['lender_wallets'] = $lender_wallets;
		$data['sectionname'] = $sectionname;
		$data['pagetitle'] = $sectionname.' - '.config('constants.project_name');
		$data['pagedescription'] = $sectionname.' - '.config('constants.project_name');
						   		   		   
		return view('admin.walletlist',$data);	
	}
/*
	public function savemanualpayment(Request $request){
	
		$loan_id= $request->input('loan_id');
		$manual_payment_date=$request->input('manual_payment_date');
		$manual_amount=$request->input('manual_amount');
		$manual_payment_reason=$request->input('manual_payment_reason');
		$negociation = $request->input('negociation');

		$today = date('d-m-Y');
		$todaytimestamp = strtotime($today);
		//DB::enableQueryLog();
		$totalunpaid = DB::table("backoffice_loan_payments AS LP")
						 ->join("backoffice_loan_applications AS LA","LA.id","=","LP.loan_id")
						 ->join("backoffice_borrowers AS BO","BO.id","=","LA.borrower_id")
						 ->select("*",'LP.id as payment_id')
						 ->whereRaw('emi_timestamp <= '.$todaytimestamp)
						 ->where(array("emi_paid"=>"0","BO.block"=>1,"LA.status"=>"covered",'paid_balance'=>NULL,"loan_id"=>$loan_id))
						 ->orderBy('LP.id')
						 ->get();
//print_r(DB::getQueryLog());
						// print_r($totalunpaid);
		$flag = 0;
		if(!empty($totalunpaid)){
			$total_unpaid_balance =  array_sum(array_map(function($var) {
					  return $var->unpaid_balance;
					}, $totalunpaid));
			
			if($total_unpaid_balance < $manual_amount){
				$errors[] = 'Manual Payment must be less than total unpaid amount.';
				$flag = 1;
			}

			
			if(empty($loan_id)){
				
				$errors[] = 'Enter Loan ID';
				$flag = 1;
			}

			if(empty($manual_payment_date)){
				
				$errors[] = 'Enter Manual Payment date';
				$flag = 1;
			}

			if(empty($manual_amount)){
				
				$errors[] = 'Enter manual amount';
				$flag = 1;
			}

			if(empty($manual_payment_reason)){
				
				$errors[] = 'Enter payment reason';
				$flag = 1;
			}
		}else{
			$flag=1;
			$errors[] = 'There is no unpaid balance';
		}

		if($flag==0){
			//echo $manual_amount."\n";
			$paymentids="";
			foreach ($totalunpaid as $totalunpaid1) {

				$remaining_amount= $manual_amount-$totalunpaid1->unpaid_balance;
				
				if($remaining_amount>0){
					DB::table('backoffice_loan_payments')
							->where('id', $totalunpaid1->payment_id)
							->update(
							[
								'emi_paid' => '1',
								'emi_paid_date' => time(),
								'paid_balance'=>$totalunpaid1->unpaid_balance,
								'manual_paid'=>"1",
							]
					);
							$paymentids .=$totalunpaid1->payment_id;
				}else if($remaining_amount<0){
					DB::table('backoffice_loan_payments')
							->where('id', $totalunpaid1->payment_id)
							->update(
							[
								'unpaid_balance'=>abs($remaining_amount),
								'manual_paid_amount'=>$totalunpaid1->unpaid_balance-abs($remaining_amount)
							]
					);

				}

				$manual_amount=$remaining_amount;
				//echo "\n".$totalunpaid1->unpaid_balance." = ".$remaining_amount;
				
			}
			
			DB::table('manual_payment')->insert(
					[
						'loan_id' => $loan_id, 
						'manual_amount' => $request->input('manual_amount'), 
						'manual_date' => strtotime($manual_payment_date), 
						'negociation' => $negociation,
						'reason' => $manual_payment_reason,
						'payment_ids'=>$paymentids
					]
				);
			$list =DB::table('manual_payment')
						   ->select('*')
						   ->where('loan_id',$loan_id)
						   ->orderBy('id', 'desc')
						   ->get();

			$data['list']=$list;
			$view = view("admin.manualpayment",$data)->render();
			
			return response()->json(['html'=>$view,'result'=>1]);
		}else{
			
			return response()->json(['html'=>$errors,'result'=>0]);
		}
	}
*/

	public function loanaccounting(Request $request){

		$sectionname = 'Accounting List';	
		$records=DB::table("backoffice_merchants_wallet AS LP")
						 ->join("backoffice_loan_applications AS LA","LA.id","=","LP.loan_id")
						 ->join("backoffice_merchants AS BM","BM.id","=","LP.merchant_id")
						 ->select("*")
						 ->orderBy('LP.id')
						 ->get();	
						 		   
		$data['records'] = $records;
		$data['sectionname'] = $sectionname;
		$data['pagetitle'] = $sectionname.' - '.config('constants.project_name');
		$data['pagedescription'] = $sectionname.' - '.config('constants.project_name');
			   		   
		return view('admin.loanaccounting',$data);	
	}
}