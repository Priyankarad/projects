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
use Utility;
use Lemonway;

class BorrowerController extends Controller {

	protected $mode = '';
	
	public function __construct()
	{
		$this->middleware('guest');
		
		if(!Adminlogin::isloggedin()){
			
			return redirect()->route('adminlogin')->send();
			exit;
		}

	}

	public function index(Request $request, $mode = null, $id = null)
	{
		$page = $request->input('page');
		
		$config = Utility::getconfig();
		
		$errors = array();
		
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			if($act == 'delsel'){
				
				$ids = $request->input('chk_id');
				
				//echo '<pre>'; print_r($ids); exit;
				
				if(count($ids)){
					
					foreach($ids as $valid){
						
						$this->deleteloandocuments($valid);
			
						DB::table('backoffice_borrowers')->where('id',$valid)->delete();
					}
				}
				
				return redirect()->route('adminborrower')->with('action','deleted');
			}
			
			if($act == 'doadd'){
				
				$firstname = $request->input('firstname');
				$middlename = $request->input('middlename');
				$surname = $request->input('surname');	
				$second_surname = $request->input('second_surname');				
				$dob = $request->input('dob');				
				$emailaddress = $request->input('emailaddress');
				$cellphonenumber = $request->input('cellphonenumber');
				$alternatenumber = $request->input('alternatenumber');
				$idnumber = $request->input('idnumber');
				$homelanguage = $request->input('homelanguage');
				$status = $request->input('status');
				$maritalstatus = $request->input('maritalstatus');
				$noofdependants = $request->input('noofdependants');
				$employmenttype = $request->input('employmenttype');
				$employercompanyname = $request->input('employercompanyname');
				$grossmonthlyincome = $request->input('grossmonthlyincome');
				$netmonthlyincome = $request->input('netmonthlyincome');
				$servicetype = $request->input('servicetype');
				$timewithemployer = $request->input('timewithemployer');
				$workphonenumber = $request->input('workphonenumber');
				$housenumber = $request->input('housenumber');
				$streetname = $request->input('streetname');
				$suburb = $request->input('suburb');
				$city = $request->input('city');
				$province = $request->input('province');
				$postcode = $request->input('postcode');
				$bankname = $request->input('bankname');
				$street_bank_branch = $request->input('street_bank_branch');
				$accountnumber = $request->input('accountnumber');
				$nameofaccountholder = $request->input('nameofaccountholder');
				$nameoncard = $request->input('nameoncard');
				$cardnumber = $request->input('cardnumber');
				$expirymonth = $request->input('expirymonth');
				$expiryyear = $request->input('expiryyear');
				$cvvnumber = $request->input('cvvnumber');
				$username = $request->input('username');
				$secretquestion = $request->input('secretquestion');
				$secretanswer = $request->input('secretanswer');
				$password = md5($request->input('password'));
				
				$flag = 1;
		
				if(empty($firstname)){
					
					$errors[] = 'Enter first name';
					$flag = 0;
				}

				if(empty($surname)){

					$errors[] = 'Enter surname';
					$flag = 0;
				}
				if(empty($second_surname)){

					$errors[] = 'Enter second surname';
					$flag = 0;
				}
				if(empty($dob)){

					$errors[] = 'Enter Date of Birth';
					$flag = 0;
				}
				if(empty($idnumber)){
				
					$errors[] = 'Enter ID number';
					$flag = 0;
				}
				/* if(empty($homelanguage)){
					
					$errors[] = 'Enter home language';
					$flag = 0;
				} */
				if(empty($status)){
					
					$errors[] = 'Choose status';
					$flag = 0;
				}
				if(empty($maritalstatus)){
					
					$errors[] = 'Choose marital status';
					$flag = 0;
				}
				if(empty($noofdependants)){
					
					$errors[] = 'Enter no of dependants';
					$flag = 0;
				}
				else if(!is_numeric($noofdependants)){
					
					$errors[] = 'No of dependants must be numeric';
					$flag = 0;
				}
				
				if(empty($employmenttype)){
		
					$errors[] = 'Choose employment type';
					$flag = 0;
				}
				if(empty($employercompanyname)){
				
					$errors[] = 'Enter employer companyname';
					$flag = 0;
				}
				if(empty($grossmonthlyincome)){
					
					$errors[] = 'Enter gross monthly income';
					$flag = 0;
				}
				else if(!is_numeric($grossmonthlyincome)){
				
					$errors[] = 'Gross monthly income must be numeric';
					$flag = 0;
				}
				if(empty($netmonthlyincome)){
					
					$errors[] = 'Enter net monthly income';
					$flag = 0;
				}
				else if(!is_numeric($netmonthlyincome)){
					
					$errors[] = 'Net monthly income must be numeric';
					$flag = 0;
				}
				if(empty($servicetype)){
					
					$errors[] = 'Choose servicetype';
					$flag = 0;
				}
				if(empty($timewithemployer)){
					
					$errors[] = 'Enter time with employer';
					$flag = 0;
				}
				else if(!is_numeric($timewithemployer)){
					
					$errors[] = 'Time in years with employer must be numeric';
					$flag = 0;
				}
				
				if(empty($workphonenumber)){
					
					$errors[] = 'Enter work phone number';
					$flag = 0;
				}
				else if(!is_numeric($workphonenumber)){
					
					$errors[] = 'Work phone number must be digits';
					$flag = 0;
				}
				
				/* if($_FILES['lastpayslip']['name'] == ''){
					
					$errors[] = 'Attach last payslip';
					$flag = 0;
				}
				else{
					
					$allowedExt = array('pdf');
					
					$ext = end(explode(".",$_FILES['lastpayslip']['name']));
					
					if(!in_array($ext,$allowedExt)){
						
						$errors[] = 'Payslip must be in '.implode(', ',$allowedExt).' format';
						$flag = 0;
					}
				} */
				if(empty($cellphonenumber)){
				
					$errors[] = 'Enter cell phone number';
					$flag = 0;
				}
				else if(!is_numeric($cellphonenumber)){
				
					$errors[] = 'Cell phone number must be digits';
					$flag = 0;
				}
				else if(strlen($cellphonenumber) != $config->mobile_length){
					
					$errors[] = 'Cell phone number must be of '.$config->mobile_length.' digits';
					$flag = 0;
				}
				else{
					
					$chk = DB::table("backoffice_borrowers")->where("cellphonenumber","=",$cellphonenumber)->first();
					
					if(!empty($chk)){
						
						$errors[] = 'Cell phone is already registered';
						$flag = 0;
					}
				}
				if(empty($alternatenumber)){
					
					$errors[] = 'Enter alternate number';
					$flag = 0;
				}
				else if(!is_numeric($alternatenumber)){
					
					$errors[] = 'Alternate phone number must be digits';
					$flag = 0;
				}
				else if(strlen($alternatenumber) != $config->mobile_length){
					
					$errors['type'] = 'alternatenumber';
					$errors[] = 'Alternate phone number must be of '.$config->mobile_length.' digits';
					$errorsFinal[] = $errors;
					$flag = 0;
				}
				if(empty($emailaddress)){
				
					$errors[] = 'Enter email address';
					$flag = 0;
				}
				else if(!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)){
				
					$errors[] = 'Enter proper email address';
					$flag = 0;
				}else{
					
					$checkemailRow = Lemonway::checkEmail($emailaddress);
					if(($checkemailRow) > 0){
						$errors[] = '* Email address is already registered';
						$flag = 1;
					}
				}

				if(empty($housenumber)){
					
					$errors[] = 'Enter house number';
					$flag = 0;
				}
				if(empty($streetname)){
					
					$errors[] = 'Enter street name';
					$flag = 0;
				}
				if(empty($suburb)){
					
					$errors[] = 'Enter suburb';
					$flag = 0;
				}
				if(empty($city)){
					
					$errors[] = 'Enter city';
					$flag = 0;
				}
				if(empty($province)){
					
					$errors[] = 'Enter province';
					$flag = 0;
				}
				if(empty($postcode)){
					
					$errors[] = 'Enter postcode';
					$flag = 0;
				}
				else if(!is_numeric($postcode)){
				
					$errors[] = 'Postcode must be numeric';
					$flag = 0;
				}
				else if(strlen($postcode) != 5){
					
					$errors[] = 'Postcode must be of 5 digits';
					$flag = 0;
				}
				if(empty($username)){
			
					$errors[] = 'Enter username';
					$flag = 0;
				}
				if(empty($password)){
					
					$errors[] = 'Enter password';
					$flag = 0;
				}
				if(empty($secretquestion)){
					
					$errors[] = 'Choose security question';
					$flag = 0;
				}
				if(empty($secretanswer)){
					
					$errors[] = 'Enter secret answer';
					$flag = 0;
				}
				
				if(empty($bankname)){
					
					$errors[] = 'Enter bank name';
					$flag = 0;
				}
				
				if(empty($accountnumber)){			
					$errors[] = '* Enter account number';
					$flag = 0;
				}else{
					if(!empty($accountnumber)){
						$regex = '/^[A-Z]{2}[0-9]{22}$/';
						preg_match_all($regex, $accountnumber, $matches, PREG_SET_ORDER, 0);
						if(!count($matches)){			
							$errors[] = '* account number no must be of 2 Capital Letters and 22 Digits';
							$flag = 0;
						}else if(!Lemonway::checkIBAN($accountnumber)){
							$errors[] = '* Enter valid account number';
							$flag = 0;
						}
					}
				}

				if(empty($nameofaccountholder)){
					
					$errors[] = 'Enter name of account number';
					$flag = 0;
				}
				if(empty($nameoncard)){
					
					$errors[] = 'Enter name on card';
					$flag = 0;
				}
				if(empty($cardnumber)){
					
					$errors[] = 'Enter card number';
					$flag = 0;
				}
				if(empty($expirymonth)){
					
					$errors[] = 'Choose expiry month';
					$flag = 0;
				}
				if(empty($expiryyear)){
					
					$errors[] = 'Choose expiry year';
					$flag = 0;
				}
				if(empty($cvvnumber)){
					
					$errors[] = 'Enter CVV Number';
					$flag = 0;
				}


				if(empty($street_bank_branch)){
					
					$errors[] = 'Enter street bank branch';
					$flag = 0;
				}
				/* if($_FILES['bankcertificate']['name'] == ''){
			
					$errors[] = 'Attach bank certificate';
					$flag = 0;
				}
				else{
					
					$allowedExt = array('pdf');
					
					$ext = end(explode(".",$_FILES['bankcertificate']['name']));
					
					if(!in_array($ext,$allowedExt)){
						
						$errors[] = 'Bank certificate must be in '.implode(', ',$allowedExt).' format';
						$flag = 0;
					}
				} */
				
				if($flag == 1){
					
					$bankaccountval= substr($accountnumber, -20);	
					$insertArr = array(
										'firstname' => $firstname,
										'middlename' => $middlename,
										'surname' => $surname,
										'second_surname' => $second_surname,
										'dob' => $dob,
										'username' => $username,
										'emailaddress' => $emailaddress,
										'cellphonenumber' => $cellphonenumber,
										'alternatenumber' => $alternatenumber,
										'idnumber' => $idnumber,
										'homelanguage' => $homelanguage,
										'status' => $status,
										'maritalstatus' => $maritalstatus,
										'noofdependants' => $noofdependants,
										'employmenttype' => $employmenttype,
										'employercompanyname' => $employercompanyname,
										'grossmonthlyincome' => $grossmonthlyincome,
										'netmonthlyincome' => $netmonthlyincome,
										'servicetype' => $servicetype,
										'timewithemployer' => $timewithemployer,
										'workphonenumber' => $workphonenumber,
										'housenumber' => $housenumber,
										'streetname' => $streetname,
										'suburb' => $suburb,
										'city' => $city,
										'province' => $province,
										'postcode' => $postcode,
										'bankname' => $bankname,
										'street_bank_branch'=>$street_bank_branch,
										'accountnumber' => $bankaccountval,
										'ibannumber' => $accountnumber,
										'nameofaccountholder' => $nameofaccountholder,
										'nameoncard' => $nameoncard,
										'cardnumber' => $cardnumber,
										'expirymonth' => $expirymonth,
										'expiryyear' => $expiryyear,
										'cvvnumber' => $cvvnumber,
										'secretquestion' => $secretquestion,
										'secretanswer' => $secretanswer,
										'password' => md5($password),
										'createdate' => time(),
										'mobile_verified' => '1',
										'email_verified' => '1',
									);
						$borrower_id = DB::table('backoffice_borrowers')->insertGetId($insertArr);
						return redirect()->route('adminborrower')->with('action','added');		
					
				}
			}
			
			$data['recorddetails'] = (object) $request->all();
		}
		
		if($mode == 'delete'){
				
			$this->deleteloandocuments($id);
			
			DB::table('backoffice_borrowers')->where('id',$id)->delete();
			
			return redirect()->route('adminborrower')->with('action','deleted');
		}
		
		$records = DB::table('backoffice_borrowers')
				   ->orderBy('id', 'desc')
				   ->get();
		
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
		
		
		$variables = Utility::variables();
		
		$data['loggedinadminid'] = Session::get('adminid');
		$data['mode'] = $mode;
		$data['per_page'] = $per_page;
		$data['currentPage'] = $currentPage;
		$data['variables'] = $variables;
		$data['errors'] = $errors;
		$data['id'] = $id;
		$data['totcount'] = count($records);
		$data['sectionname'] = 'Borrower';
		$data['pagetitle'] = ($mode ? ucfirst($mode).' || ' : '').'Borrower - '.config('constants.project_name');
		$data['pagedescription'] = ($mode ? ucfirst($mode).' || ' : '').'Borrower - '.config('constants.project_name');
		
		return view('admin.borrower',$data);
	}
	
	public function details(Request $request, $id = null)
	{
	
		if($request->has('act')){
			
			//dd($request->all()); 
			
			$act = $request->input('act');
			
			if($act == 'personaldetails'){
				
				DB::table('backoffice_borrowers')
					->where('id', $id)
					->update(
					[
						'firstname' => $request->input('firstname'),
						'middlename' => $request->input('middlename'),
						'surname' => $request->input('surname'),
						'second_surname' => $request->input('second_surname'),
						'dob' => $request->input('dob'),
						'username' => $request->input('username'),
						'emailaddress' => $request->input('emailaddress'),
						'cellphonenumber' => $request->input('cellphonenumber'),
						'alternatenumber' => $request->input('alternatenumber'),
						'idnumber' => $request->input('idnumber'),
						'homelanguage' => $request->input('homelanguage'),
						'status' => $request->input('status'),
						'maritalstatus' => $request->input('maritalstatus'),
						'noofdependants' => $request->input('noofdependants')
					]
				);
				
				return redirect()->route('adminborrowerdetails',[ 'id' => $id, '#personaldetails' ])->with('action','updated');
			}
			else if($act == 'employmentdetails'){
				
				DB::table('backoffice_borrowers')
					->where('id', $id)
					->update(
					[
						'employmenttype' => $request->input('employmenttype'),
						'employercompanyname' => $request->input('employercompanyname'),
						'grossmonthlyincome' => $request->input('grossmonthlyincome'),
						'netmonthlyincome' => $request->input('netmonthlyincome'),
						'servicetype' => $request->input('servicetype'),
						'timewithemployer' => $request->input('timewithemployer'),
						'workphonenumber' => $request->input('workphonenumber')
					]
				);
				
				return redirect()->route('adminborrowerdetails',[ 'id' => $id, '#employmentdetails' ])->with('action','updated');
			}
			else if($act == 'addressdetails'){
				
				DB::table('backoffice_borrowers')
					->where('id', $id)
					->update(
					[
						'housenumber' => $request->input('housenumber'),
						'streetname' => $request->input('streetname'),
						'suburb' => $request->input('suburb'),
						'city' => $request->input('city'),
						'province' => $request->input('province'),
						'postcode' => $request->input('postcode')
					]
				);
				
				return redirect()->route('adminborrowerdetails',[ 'id' => $id, '#addressdetails' ])->with('action','updated');
			}
			else if($act == 'bankdetails'){
				$bankname = $request->input('bankname');
				$street_bank_branch=$request->input('street_bank_branch');
				$accountnumber = $request->input('accountnumber');
				$nameofaccountholder = $request->input('nameofaccountholder');
				$nameoncard = $request->input('nameoncard');
				$cardnumber = $request->input('cardnumber');
				$expirymonth = $request->input('expirymonth');
				$expiryyear = $request->input('expiryyear');
				$cvvnumber = $request->input('cvvnumber');
				$borrowerWalletid=$request->input('wallet_id');

				$flag=1;
				if(empty($borrowerWalletid)){
					
					$errors[] = 'Empty Wallet id';
					$flag = 0;
				}

				if(empty($bankname)){
					
					$errors[] = 'Enter bank name';
					$flag = 0;
				}
				
				if(empty($accountnumber)){			
					$errors[] = '* Enter account number';
					$flag = 0;
				}else{
					if(!empty($accountnumber)){
						$regex = '/^[A-Z]{2}[0-9]{22}$/';
						preg_match_all($regex, $accountnumber, $matches, PREG_SET_ORDER, 0);
						if(!count($matches)){			
							$errors[] = '* account number no must be of 2 Capital Letters and 22 Digits';
							$flag = 0;
						}else if(!Lemonway::checkIBAN($accountnumber)){
							$errors[] = '* Enter valid account number';
							$flag = 0;
						}
					}
				}

				if(empty($nameofaccountholder)){
					
					$errors[] = 'Enter name of account number';
					$flag = 0;
				}
				if(empty($nameoncard)){
					
					$errors[] = 'Enter name on card';
					$flag = 0;
				}
				if(empty($cardnumber)){
					
					$errors[] = 'Enter card number';
					$flag = 0;
				}
				if(empty($expirymonth)){
					
					$errors[] = 'Choose expiry month';
					$flag = 0;
				}
				if(empty($expiryyear)){
					
					$errors[] = 'Choose expiry year';
					$flag = 0;
				}
				if(empty($cvvnumber)){
					
					$errors[] = 'Enter CVV Number';
					$flag = 0;
				}


				if(empty($street_bank_branch)){
					
					$errors[] = 'Enter street bank branch';
					$flag = 0;
				}

				if(!empty($borrowerWalletid)){
						//echo $_SESSION['customerdata']['previousibannumber'];
						if(Session::get('previousibannumber')!= $accountnumber){
							$RegisteredIBAN=Lemonway::RegisterIBAN($borrowerWalletid, $accountnumber,$nameofaccountholder,$bankname,$street_bank_branch);
							if(isset($RegisteredIBAN->RegisterIBANResult->E->Msg)){
								$errors[] = $RegisteredIBAN->RegisterIBANResult->E->Msg;
								$flag = 0;
							}else{
								$ibanid=$RegisteredIBAN->RegisterIBANResult->IBAN->ID;

								Session::put('ibanid', $ibanid);
								Session::put('previousibannumber',$accountnumber);
								//echo "if else";
							}
						}else{

							$ibanid=Session::get('ibanid');
							//echo "else called ".$ibanid;
						}
				}


				if((Session::get('previouscardnumber')!=$cardnumber) && $ibanid){
							$num_padded = sprintf("%02d",$expirymonth);
							$getCreditCardType=(Lemonway::getCreditCardType(trim($cardnumber)));

							if(is_numeric($getCreditCardType) && $getCreditCardType < 4){
								$RegisterBorrowerCard= Lemonway::RegisterCard(array(
															"wlLogin"   => config('constants.LOGIN'),
			                                                "wlPass"    => config('constants.PASSWORD'),
			                                                "language"  => config('constants.LANGUAGE'),
			                                                "version"   => config('constants.VERSION'),
			                                                "walletIp"  => Lemonway::getUserIP(),
			                                                "walletUa"  => config('constants.UA'),
														    "wallet" 	=> $borrowerWalletid,
														    "cardType" 	=> $getCreditCardType,
														    "cardNumber" => $cardnumber,
														    "cardCode" 	=>  $cvvnumber,
														    "cardDate" 	=> $num_padded."/".$expiryyear
														));
								print_r(array(
															"wlLogin"   => config('constants.LOGIN'),
			                                                "wlPass"    => config('constants.PASSWORD'),
			                                                "language"  => config('constants.LANGUAGE'),
			                                                "version"   => config('constants.VERSION'),
			                                                "walletIp"  => Lemonway::getUserIP(),
			                                                "walletUa"  => config('constants.UA'),
														    "wallet" 	=> $borrowerWalletid,
														    "cardType" 	=> $getCreditCardType,
														    "cardNumber" => $cardnumber,
														    "cardCode" 	=>  $cvvnumber,
														    "cardDate" 	=> $num_padded."/".$expiryyear
														));
										if(isset($RegisterBorrowerCard->RegisterCardResult->E->Msg)){
											$errors[] = $RegisterBorrowerCard->RegisterCardResult->E->Msg;
											$flag = 0;

										}else{
											$cardid=$RegisterBorrowerCard->RegisterCardResult->CARD->ID;
											Session::put('cardid', $cardid);
											Session::put('previouscardnumber',$cardnumber);
										}
							}else{
								$errors[] ="Lemonway only allows Visa, Mastercard and Mastro.";
								$flag = 0;
							}
								
						}else{
							$cardid=Session::get('cardid');
							//echo "else called ".$ibanid;
						}
				if($flag==1){
					DB::table('backoffice_borrowers')
								->where('id', $id)
								->update(
										[
											'bankname' => $request->input('bankname'),
											'street_bank_branch'=>$request->input('street_bank_branch'),
											'accountnumber' => $request->input('accountnumber'),
											'nameofaccountholder' => $request->input('nameofaccountholder'),
											'nameoncard' => $request->input('nameoncard'),
											'cardnumber' => $request->input('cardnumber'),
											'expirymonth' => $request->input('expirymonth'),
											'expiryyear' => $request->input('expiryyear'),
											'cvvnumber' => $request->input('cvvnumber')
										]
									);
						
					return redirect()->route('adminborrowerdetails',[ 'id' => $id, '#bankdetails' ])->with('action','updated');

				}

			}
			else if($act == 'accountrecovery'){
				
				DB::table('backoffice_borrowers')
					->where('id', $id)
					->update(
					[
						'secretquestion' => $request->input('secretquestion'),
						'secretanswer' => $request->input('secretanswer'),
						'password' => md5($request->input('password'))
					]
				);
				
				return redirect()->route('adminborrowerdetails',[ 'id' => $id, '#accountrecovery' ])->with('action','updated');
			}
			else if($act == 'attachmentdelete'){
				
				$getfileinfo = DB::table('backoffice_loan_documents')
							   ->where("id","=",$request->input('id'))
							   ->first();
							   
				$filePath = $getfileinfo->document_path;
				
				@unlink(base_path().'/userfiles/'.$filePath);
				
				DB::table('backoffice_loan_documents')->where("id","=",$request->input('id'))->delete();
				
				return redirect()->route('adminborrowerdetails',[ 'id' => $id, '#attachments' ])->with('action','updated');
			}
			else if($act == 'attachmentupdate'){
				
				//dd($request->all());
				
				$getLoanID = DB::table('backoffice_loan_applications')
							   ->where("unique_id","=",$request->input('id'))
							   ->first();
							   
				$loan_id = $getLoanID->id;
				
				if($request->hasFile('lastpayslip_'.$request->input('id'))){
					
					if($request->file('lastpayslip_'.$request->input('id'))->isValid()){
						
						$origFileName = $request->file('lastpayslip_'.$request->input('id'))->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.pdf';
							
							$request->file('lastpayslip_'.$request->input('id'))->move($destinationPath,$fileName);
							
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
				if($request->hasFile('bankcertificate_'.$request->input('id'))){
				
					if($request->file('bankcertificate_'.$request->input('id'))->isValid()){
						
						$origFileName = $request->file('bankcertificate_'.$request->input('id'))->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.pdf';
							
							$request->file('bankcertificate_'.$request->input('id'))->move($destinationPath,$fileName);
							
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
				
				if($request->hasFile('idproof_'.$request->input('id'))){
				
					if($request->file('idproof_'.$request->input('id'))->isValid()){
						
						$origFileName = $request->file('idproof_'.$request->input('id'))->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf' || $ext == 'jpg' || $ext == 'jpeg'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.'.$ext;
							
							$request->file('idproof_'.$request->input('id'))->move($destinationPath,$fileName);
							
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
				
				if($request->hasFile('budgetattachment_'.$request->input('id'))){
				
					if($request->file('budgetattachment_'.$request->input('id'))->isValid()){
						
						$origFileName = $request->file('budgetattachment_'.$request->input('id'))->getClientOriginalName();
						$extArr = explode('.',$origFileName);
						$ext = $extArr[1];
						
						if($ext == 'pdf' || $ext == 'jpg' || $ext == 'jpeg'){
							
							$randomStr = md5(uniqid(rand(), true));
							
							$destinationPath = 'userfiles';
							$fileName = $randomStr.'.'.$ext;
							
							$request->file('budgetattachment_'.$request->input('id'))->move($destinationPath,$fileName);
							
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
				
				return redirect()->route('adminborrowerdetails',[ 'id' => $id, '#attachments' ])->with('action','updated');
			}
			else if($act == 'notedetails'){
				
				DB::table('backoffice_borrowers')
					->where('id', $id)
					->update(
					[
						'note' => $request->input('note')
					]
				);
				
				return redirect()->route('adminborrowerdetails',[ 'id' => $id, '#notedetails' ])->with('action','updated');
			}
		}
		
		$records = DB::table('backoffice_borrowers')
				   ->where('id','=',$id)
				   ->first();
				   
		//dd($records);
		
		$borrower_id = $records->id;
		
		$loans = DB::table('backoffice_loan_applications AS LA')
				 ->leftJoin('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')
				 ->leftJoin('backoffice_merchants AS BM', 'BM.id', '=', 'LA.merchant_id')
				 ->select('LA.*','BO.firstname','BO.surname','BM.merchant_name','BM.merchant_cif')
				 ->where('borrower_id','=',$borrower_id)
				 ->get();
				 
		//dd($loans);
		
		$attachments = array();
		$genfiles = array();
		$attachmentsbytype = array();
		$payments = array();
		$riskdata=array();
		
		if(count($loans)){
			
			foreach($loans as $valloan){
				
				$loan_id = $valloan->id;
				$unique_id = $valloan->unique_id;
				
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
				$paymentsdata = DB::table('backoffice_loan_payments')
								 ->where('loan_id','=',$loan_id)
								 ->get();
							 
				$payments[$unique_id] = $paymentsdata;

				$risk = DB::table('loan_petitions')
								 ->where('loan_id','=',$loan_id)
								 ->get();

				$riskdata[$unique_id] = $risk;


				// Get Attachment by type
				$attachmentType = ['lastpayslip','bankcertificate','idproof','budgetattachment'];
				
				foreach($attachmentType as $valattach){
					
					$attachdata = DB::table('backoffice_loan_documents')
									->where('loan_id','=',$loan_id)
									->where('document_type','=',$valattach)
									->first();
									
					$attachmentsbytype[$unique_id][$valattach] = !empty($attachdata) ? $attachdata->document_path : '';									
				}
			}
		}
		
		//dd($attachments);
		//dd($attachmentsbytype);
		//dd($genfiles);
		
		$variables = Utility::variables();		
		//dd($variables);	
		if(!empty($errors)){
			$data['errors'] = $errors;
		}
		$data['loggedinadminid'] = Session::get('adminid');	
		$data['id'] = $id;
		$data['sectionname'] = 'Borrower Details';
		$data['borrowerdata'] = $records;
		$data['variables'] = $variables;
		$data['attachments'] = $attachments;
		$data['genfiles'] = $genfiles;
		$data['attachmentsbytype'] = $attachmentsbytype;
		$data['payments'] = $payments;
		$data['loans'] = $loans;
		$data['creditriskarea'] = $riskdata;
		$data['pagetitle'] = 'Borrower Details - '.config('constants.project_name');
		$data['pagedescription'] = 'Borrower Details - '.config('constants.project_name');
		
		return view('admin.borrowerdetails',$data);
	}
	
	public function deleteloandocuments($id){
		
		$getloans = DB::table('backoffice_loan_applications')->where('borrower_id',$id)->get();
			
		if(count($getloans)){
			
			foreach($getloans as $valloan){
				
				$getdocuments = DB::table('backoffice_loan_documents')->where('loan_id',$valloan->id)->get();
				
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
		}
	}
}
