<?php 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Adminlogin;
use Session;
use Spreadsheet_Excel_Reader;
use Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Mails;
use Utility;
use File;

class LoanapplicationController extends Controller {

	protected $mode = '';
	
	public function __construct()
	{
		$this->middleware('guest');
		
		if(!Adminlogin::isloggedin()){
			
			return redirect()->route('adminlogin')->send();
			exit;
		}

	}

	public function index(Request $request, $type, $mode = null, $id = null,$file=null)
	{
		/* Utility::generatepdf('seccis_document',4);
		Utility::generatepdf('pre_contractual_document',4);
		die(); */
		
		//return view('templates.seccis');
		
		if($mode == 'delete'){
			
			$this->deleteloandocuments($id);
			
			DB::table('backoffice_loan_applications')->where('id', '=', $id)->delete();
			
			return redirect()->route('adminloanapplication', array('type'=>$type))->with('action','deleted');
		}
		
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			if($act == 'delsel'){
				
				$ids = $request->input('chk_id');
				
				//echo '<pre>'; print_r($ids); exit;
				
				if(count($ids)){
					
					foreach($ids as $valid){
						
						$this->deleteloandocuments($valid);
						
						DB::table('backoffice_loan_applications')->where('id', '=', $valid)->delete();
					}
				}
				
				return redirect()->route('adminloanapplication', array('type'=>$type))->with('action','deleted');
			}
		}
		//DB::enableQueryLog();
		
		if($type!='pending')
		$records = DB::table('backoffice_loan_applications AS LA')
				   ->leftJoin('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')
				   ->leftJoin('backoffice_merchants AS BM', 'BM.id', '=', 'LA.merchant_id')
				   ->leftJoin('backoffice_merchants_wallet AS MW','MW.loan_id','=','LA.id')
				   ->leftJoin('backoffice_investores_bid AS IB','IB.loan_id','=','LA.id')
				   ->select('LA.*','BO.firstname','BO.surname','BM.merchant_name','BM.merchant_cif','BO.merchantnamecontactorwebsite as merchant_info','MW.loan_id as checkmoneyout',DB::raw('sum(CASE WHEN `smc_LA`.status="approved" THEN smc_IB.bid_amount ELSE 0 END) as coveredamount'))
				   ->where('LA.status','=',$type)
				   ->groupBy('IB.loan_id')
				   ->orderBy('LA.id', 'desc')
				   ->get();
		else	
		    $records = DB::table('backoffice_loan_applications AS LA')
				   ->leftJoin('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')
				   ->leftJoin('backoffice_merchants AS BM', 'BM.id', '=', 'LA.merchant_id')
				   ->select('LA.*','BO.firstname','BO.surname','BM.merchant_name','BM.merchant_cif','BO.merchantnamecontactorwebsite as merchant_info')
				   ->where('LA.status','=',$type)
				   ->orderBy('LA.id', 'desc')
				   ->get();	   
		
		//$laQuery = DB::getQueryLog();
		//print_r($laQuery);
		//echo '<pre>'; print_r($records); exit; 
		
		//Get current page form url e.g. &page=6
		if($request->has('page')){
			$currentPage = LengthAwarePaginator::resolveCurrentPage();
		}
		else{
			$currentPage = 1;
		}

		//Create a new Laravel collection from the array data
		$collection = new Collection($records);

		//Define how many items we want to be visible in each page
		$per_page = 50;

		//Slice the collection to get the items to display in current page
		$currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
		
		//echo '<pre>'; print_r($currentPageResults); exit;

		//Create our paginator and add it to the data array
		$data['records'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);

		//Set base url for pagination links to follow e.g custom/url?page=6
		$data['records']->setPath($request->url());
		
		$this->mode = $mode;
		
		$data['loggedinadminid'] = Session::get('adminid');
		$data['mode'] = $this->mode;
		$data['per_page'] = $per_page;
		$data['currentPage'] = $currentPage;
		$data['id'] = $id;
		$data['type'] = $type;
		$data['totcount'] = count($records);
		$data['sectionname'] = ucfirst($type).' Loan Applications';
		$data['pagetitle'] = ucfirst($type).' Loan Applications - '.config('constants.project_name');
		$data['pagedescription'] = ucfirst($type).' Loan Applications - '.config('constants.project_name');
		
		return view('admin.loanapplication',$data);
	}
	
	public function modify(Request $request, $mode = null, $id = null,$file=null)
	{
		/*
		if($id){
			Mails::defaultcommunicationmail($id,"230","+90");
			echo "called";
			die();
		}
*/
		if(!empty($file)){
			$pathToFile="../merchant_invoices/".$file;
    		return response()->download($pathToFile);
		}

		$errors = array();
	
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			$loan_amount = $request->input('loan_amount');
			$loan_terms = $request->input('loan_terms');
			$loan_apr = $request->input('loan_apr');
			$borrower_id = $request->input('borrower_id');
			$merchant_id = $request->input('merchant_id');
			$product_name = $request->input('product_name');
			$status = $request->input('status');
			$payment_sent = $request->input('payment_sent');
			$pending_to_be_paid=$request->input('pending_to_be_paid');
			
			$flag = 0;
			
			if(empty($borrower_id)){
				
				$errors[] = 'Choose borrower';
				$flag = 1;
			}
			if(empty($loan_amount)){
				
				$errors[] = 'Enter loan amount';
				$flag = 1;
			}
			else if(!is_numeric($loan_amount)){
				
				$errors[] = 'Loan amount must be numeric';
				$flag = 1;
			}
			if(empty($loan_terms)){
				
				$errors[] = 'Choose loan terms';
				$flag = 1;
			}
			if(empty($loan_apr)){
				
				$errors[] = 'Enter loan APR (%)';
				$flag = 1;
			}
			else if(!is_numeric($loan_apr)){
				
				$errors[] = 'Loan APR (%) must be numeric';
				$flag = 1;
			}

			if($status!="pending" && empty($merchant_id)){
				
				$errors[] = 'Select merchantid';
				$flag = 1;
			}
			if($act == 'doadd'){
				
				if(!$request->hasFile('lastpayslip')){
				
					$errors[] = 'Attach Last Payslip';
					$flag = 1;
				}
				else{
					
					if($request->file('lastpayslip')->isValid()){
						
						$origFileName = $request->file('lastpayslip')->getClientOriginalName();
						$fileext = File::extension($origFileName);
						
						if($fileext != 'pdf'){
							
							$errors[] = 'Last Payslip must be in PDF format';
							$flag = 1;
						}
					}
				}
				
				if(!$request->hasFile('bankcertificate')){
					
					$errors[] = 'Attach Bank Certificate';
					$flag = 1;
				}
				else{
					
					if($request->file('bankcertificate')->isValid()){
						
						$origFileName = $request->file('bankcertificate')->getClientOriginalName();
						$fileext = File::extension($origFileName);
						
						if($fileext != 'pdf'){
							
							$errors[] = 'Bank Certificate must be in PDF format';
							$flag = 1;
						}
					}
				}
			}
			
			if($act == 'doadd' && $flag == 0){
				
				$time = time();
				
				$loan_unique_id = 'SMC-'.$time.'-'.$borrower_id.rand(100000,999999);
				
				$loan_id = DB::table('backoffice_loan_applications')->insertGetId(
					[
						//'unique_id' => $loan_unique_id, 
						'loan_amount' => $loan_amount, 
						'loan_terms' => $loan_terms, 
						'loan_apr' => $loan_apr,
						'borrower_id' => $borrower_id,
						'merchant_id' => $merchant_id,
						'product_name' => $product_name,
						'payment_sent'=>'no',
						'createdate' => $time,
						'status' => 'pending'
					]
				);
				
				
				$loan_unique_id = 'SC-'.date('Y').'-'.(str_pad($loan_id,2,0,STR_PAD_LEFT));
				
				DB::table('backoffice_loan_applications')->where('id',$loan_id)->update([
					
					'unique_id' => $loan_unique_id
				
				]);
				
				
				if($request->hasFile('lastpayslip')){
					
					if($request->file('lastpayslip')->isValid()){
						
						$origFileName = $request->file('lastpayslip')->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.pdf';
							
							$request->file('lastpayslip')->move($destinationPath,$fileName);
							
							DB::table('backoffice_loan_documents')->insert(
								[
									'loan_id' => $loan_id, 
									'document_type' => 'lastpayslip', 
									'document_path' => $fileName, 
									'type' => 'useruploaded',
									'createdate' => time()
								]
							);
						}
					}
				}
				if($request->hasFile('bankcertificate')){
				
					if($request->file('bankcertificate')->isValid()){
						
						$origFileName = $request->file('bankcertificate')->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.pdf';
							
							$request->file('bankcertificate')->move($destinationPath,$fileName);
							
							DB::table('backoffice_loan_documents')->insert(
								[
									'loan_id' => $loan_id, 
									'document_type' => 'bankcertificate', 
									'document_path' => $fileName, 
									'type' => 'useruploaded',
									'createdate' => time()
								]
							);
						}
					}
				}
				if($request->hasFile('idproof')){
				
					if($request->file('idproof')->isValid()){
						
						$origFileName = $request->file('idproof')->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf' || $ext == 'jpg' || $ext == 'jpeg'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.'.$ext;
							
							$request->file('idproof')->move($destinationPath,$fileName);
							
							DB::table('backoffice_loan_documents')->insert(
								[
									'loan_id' => $loan_id, 
									'document_type' => 'idproof', 
									'document_path' => $fileName, 
									'type' => 'useruploaded',
									'createdate' => time()
								]
							);
						}
					}
				}
				if($request->hasFile('budgetattachment')){
				
					if($request->file('budgetattachment')->isValid()){
						
						$origFileName = $request->file('budgetattachment')->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf' || $ext == 'jpg' || $ext == 'jpeg'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.'.$ext;
							
							$request->file('budgetattachment')->move($destinationPath,$fileName);
							
							DB::table('backoffice_loan_documents')->insert(
								[
									'loan_id' => $loan_id, 
									'document_type' => 'budgetattachment', 
									'document_path' => $fileName, 
									'type' => 'useruploaded',
									'createdate' => time()
								]
							);
						}
					}
				}
				
				return redirect()->route('adminloanapplication', array('type'=>'pending'))->with('action','added');
			}
			
			if($act == 'doedit' && $flag == 0){
				
				$id = $request->input('id');
				
				$status = !empty($status) ? $status : 'pending';
				
				$loan_id = $id;
					
				if($request->hasFile('lastpayslip')){
				
					if($request->file('lastpayslip')->isValid()){
						
						$origFileName = $request->file('lastpayslip')->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.pdf';
							
							$request->file('lastpayslip')->move($destinationPath,$fileName);
							
							$getfileinfo = DB::table('backoffice_loan_documents')
										   ->where("loan_id","=",$loan_id)
										   ->where("document_type","=",'lastpayslip')
										   ->first();
										   
							if(empty($getfileinfo)){
								
								DB::table('backoffice_loan_documents')->insert(
									[
										'loan_id' => $loan_id, 
										'document_type' => 'lastpayslip', 
										'document_path' => $fileName, 
										'type' => 'useruploaded',
										'createdate' => time()
									]
								);
							}
							else{
								
								$filePath = $getfileinfo->document_path;
							
								@unlink(base_path().'/userfiles/'.$filePath);
								
								DB::table('backoffice_loan_documents')
								->where('loan_id', $loan_id)
								->where('document_type', 'lastpayslip')
								->update(
									[
										'document_path' => $fileName
									]
								);
							}
						}
					}
				}
				if($request->hasFile('bankcertificate')){
				
					if($request->file('bankcertificate')->isValid()){
						
						$origFileName = $request->file('bankcertificate')->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.pdf';
							
							$request->file('bankcertificate')->move($destinationPath,$fileName);
							
							$getfileinfo = DB::table('backoffice_loan_documents')
										   ->where("loan_id","=",$loan_id)
										   ->where("document_type","=",'bankcertificate')
										   ->first();
										   
							if(empty($getfileinfo)){
								
								DB::table('backoffice_loan_documents')->insert(
									[
										'loan_id' => $loan_id, 
										'document_type' => 'bankcertificate', 
										'document_path' => $fileName, 
										'type' => 'useruploaded',
										'createdate' => time()
									]
								);
							}
							else{
								
								$filePath = $getfileinfo->document_path;
							
								@unlink(base_path().'/userfiles/'.$filePath);
								
								DB::table('backoffice_loan_documents')
								->where('loan_id', $loan_id)
								->where('document_type', 'bankcertificate')
								->update(
									[
										'document_path' => $fileName
									]
								);
							}
						}
					}
				}
				if($request->hasFile('idproof')){
				
					if($request->file('idproof')->isValid()){
						
						$origFileName = $request->file('idproof')->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf' || $ext == 'jpg' || $ext == 'jpeg'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.'.$ext;
							
							$request->file('idproof')->move($destinationPath,$fileName);
							
							$getfileinfo = DB::table('backoffice_loan_documents')
										   ->where("loan_id","=",$loan_id)
										   ->where("document_type","=",'idproof')
										   ->first();
										   
							if(empty($getfileinfo)){
								
								DB::table('backoffice_loan_documents')->insert(
									[
										'loan_id' => $loan_id, 
										'document_type' => 'idproof', 
										'document_path' => $fileName, 
										'type' => 'useruploaded',
										'createdate' => time()
									]
								);
							}
							else{
								
								$filePath = $getfileinfo->document_path;
							
								@unlink(base_path().'/userfiles/'.$filePath);
								
								DB::table('backoffice_loan_documents')
								->where('loan_id', $loan_id)
								->where('document_type', 'idproof')
								->update(
									[
										'document_path' => $fileName
									]
								);
							}
						}
					}
				}
				if($request->hasFile('budgetattachment')){
				
					if($request->file('budgetattachment')->isValid()){
						
						$origFileName = $request->file('budgetattachment')->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf' || $ext == 'jpg' || $ext == 'jpeg'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.'.$ext;
							
							$request->file('budgetattachment')->move($destinationPath,$fileName);
							
							$getfileinfo = DB::table('backoffice_loan_documents')
										   ->where("loan_id","=",$loan_id)
										   ->where("document_type","=",'budgetattachment')
										   ->first();
										   
							if(empty($getfileinfo)){
								
								DB::table('backoffice_loan_documents')->insert(
									[
										'loan_id' => $loan_id, 
										'document_type' => 'budgetattachment', 
										'document_path' => $fileName, 
										'type' => 'useruploaded',
										'createdate' => time()
									]
								);
							}
							else{
								
								$filePath = $getfileinfo->document_path;
							
								@unlink(base_path().'/userfiles/'.$filePath);
								
								DB::table('backoffice_loan_documents')
								->where('loan_id', $loan_id)
								->where('document_type', 'budgetattachment')
								->update(
									[
										'document_path' => $fileName
									]
								);
							}
						}
					}
				}
				//echo $status."<br/>".$payment_sent;die();
				DB::table('backoffice_loan_applications')
					->where('id', $id)
					->update(
					[
						'loan_amount' => $loan_amount, 
						'loan_terms' => $loan_terms, 
						'loan_apr' => $loan_apr,
						'borrower_id' => $borrower_id,
						'merchant_id' => $merchant_id,
						'product_name' => $product_name,
						'payment_sent' => $payment_sent,
						'status' => $status,
						'pending_to_be_paid'=>$pending_to_be_paid
					]
				);
				
				
				// Calculate EMI
				
				if($status == 'approved'){
					$loggedinadminid = Session::get('adminid');
					$loggedinUserDetails = Adminlogin::loggedinadmindetails($loggedinadminid);
					DB::table('backoffice_loan_applications')
					->where('id', $id)
					->update(
					[
						
						'loan_approve_date' => time(),
						'admin_user'=>$loggedinUserDetails->id
					]
				);
					/*
					$p = intval($loan_amount);
					$j = $loan_apr/(12*100);
					$n = $loan_terms;
					
					$m = ($p*$j)/(1-pow((1+$j),-$n));
					
					$m = round($m,2);
					
					$emis = array();
					
					$currentMonth = date('m');
					$currentYear = date('Y');
					
					$nextMonth = $currentMonth == 12 ? 2 : $currentMonth+2;
					$nextYear = $currentMonth == 12 ? $currentYear+1 : $currentYear;
					
					$firstEmiDate = '1-'.$nextMonth.'-'.$nextYear;
					$timestampfirstemidate = strtotime($firstEmiDate);
					
					for($i=0;$i<$n;$i++){
						
						$time = strtotime("+$i month", $timestampfirstemidate);
						$emis[] = array(
							
							'amount' => $m,
							'date' => date('d-m-Y',$time),
							'day' => date('d',$time),
							'month' => date('m',$time),
							'year' => date('Y',$time)
						);
					}
					
					//dd($emis);
					
					if(count($emis)){
						
						foreach($emis as $emi){
							
							DB::table('backoffice_loan_payments')->insert(
								[
									'loan_id' => $id, 
									'emi_amount' => $emi['amount'], 
									'emi_day' => $emi['day'], 
									'emi_month' => $emi['month'],
									'emi_year' => $emi['year'],
									'emi_timestamp' => strtotime($emi['date'])
								]
							);
						}
					}
					*/
					// Generate Contract File
					
					Utility::generatepdf('contractual_document',$id);
					
					Mails::loanapproved($id);
					
				}
				else if($status == 'rejected'){
					
					Mails::loanrejected($id);
				}
				else if($status == 'closed'){
					
					Mails::loanclosed($id);
				}
				
				
				return redirect()->route('adminloanapplication', array('mode'=>'','id'=>'','type'=>'pending'))->with('action','updated');
			}
			
			$data['recorddetails'] = (object) $request->all();
			
			//dd($data['recorddetails']);
		}
		
		if($mode == 'edit'){

			//DB::enableQueryLog();
		
			;
			$recorddetails = DB::table('backoffice_loan_applications as LA')
							 ->join('backoffice_borrowers AS BB','LA.borrower_id','=','BB.id')
							 ->join('dropdown_values AS ET','ET.id','=','BB.employmenttype')
							 ->join('dropdown_values AS MS','MS.id','=','BB.maritalstatus')
							 ->join('dropdown_values AS ST','ST.id','=','BB.servicetype')
							 ->join('dropdown_values AS LS','LS.id','=','BB.status')
							 ->leftJoin('loan_petitions AS LP','LP.loan_id','=','LA.id')
							 ->leftJoin('backoffice_merchants_wallet AS MW','MW.loan_id','=','LA.id')
							 ->select('LA.*','MW.loan_id as checkmoneyout',"BB.employmenttype","BB.maritalstatus","BB.servicetype","BB.noofdependants","LP.*","ET.business_rules as employmentbusinessrule","ET.value as employmentname","ST.business_rules as servicebusinessrule","ST.value as servicename","MS.business_rules as maritialtbusinessrule","MS.value as maritialtname","LS.business_rules as livingstatus","LS.value as residetialname","BB.firstname","BB.surname","BB.dob","BB.emailaddress","BB.city","BB.province","BB.postcode","BB.idnumber","BB.cellphonenumber")
							 ->where('LA.id', $id)
							 ->first();


			//$laQuery = DB::getQueryLog();
		//print_r($laQuery);		 
			//echo '<pre>'; print_r($recorddetails); exit; 
			
			$data['recorddetails'] = $recorddetails;
			
			// Get Attachments
			$documents = DB::table('backoffice_loan_documents')
						 ->where('loan_id','=',$id)
						 ->where('type','=','useruploaded')
						 ->get();
						 
			$attachments = array();
			
			if(count($documents)){
				
				foreach($documents as $doc){
					
					$attachments[$doc->document_type] = $doc->document_path;
				}
				$data['recorddetails']->attachments = $attachments;
			}
						 
			
			
			//dd($data['recorddetails']);
		}
		
		
		$borrowers = DB::table('backoffice_borrowers')->get();
		
		//dd($borrowers);
		
		
		$this->mode = $mode;
		
		$statusArr = array(
			
			'approved' => 'Approve',
			'rejected' => 'Reject',
			'closed' => 'Close',
		);
		
		$merchants = DB::table('backoffice_merchants')->where('status','=','approved')->whereNotNull('iban_id')->get();
		
		$getLoanterms = DB::table('config')
						 ->where('config_type','=','loan_months')
						 ->first();
						 
		$data['merchants'] = $merchants;
		
		$data['loggedinadminid'] = Session::get('adminid');
		$data['mode'] = $this->mode;
		$data['errors'] = $errors;
		$data['id'] = $id;
		$data['sectionname'] = 'Loan Application';
		$data['borrowers'] = $borrowers;
		$data['terms'] = explode(",", $getLoanterms->config_val);
		$data['statusarr'] = $statusArr;
		$data['pagetitle'] = ($mode ? ucfirst($mode).' || ' : '').'Loan Application - '.config('constants.project_name');
		$data['pagedescription'] = ($mode ? ucfirst($mode).' || ' : '').'Loan Application - '.config('constants.project_name');
		
		return view('admin.modifyloanapplication',$data);
	}
	
	public function deleteloandocuments($id){
		
		$getdocuments = DB::table('backoffice_loan_documents')->where('loan_id',$id)->get();
				
		if(count($getdocuments)){
			
			foreach($getdocuments as $valdoc){
				
				if($valdoc->type == 'useruploaded'){
					@unlink(base_path().'/userfiles/'.$valdoc->document_path);
				}
				else if($valdoc->type == 'systemgenerated'){
					@unlink(base_path().'/generatedfiles/'.$valdoc->document_path);
				}
			}
		}
	}

	public function getDownload($file)
    {
    	$pathToFile="../merchant_invoices/".$file;
    	return response()->download($pathToFile);
    }
}
