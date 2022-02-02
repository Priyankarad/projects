<?php 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Common;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use DB;
use Adminlogin;
use Session;
use Utility;
use Mails;
use PDF;

class DashboardController extends Controller {

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
		//mails::loanapproved(8);die();
		$records = DB::table('backoffice_loan_applications AS LA')
				   ->leftJoin('backoffice_borrowers AS BO', 'BO.id', '=', 'LA.borrower_id')
				   ->leftJoin('backoffice_merchants AS BM', 'BM.id', '=', 'LA.merchant_id')
				   ->select('LA.*','BO.firstname','BO.surname','BM.merchant_name','BM.merchant_cif')
				   ->orderBy('LA.id', 'desc')
				   ->get(5);
				   
		$data['records'] = $records;
		
		$statuscount = Utility::getloanstatuscount();
		$statuscountPer = Utility::getloanstatuscountpercentage();
		
		//dd($statuscount);
		//dd($statuscountPer);

		$pendinglendercount = DB::table('backoffice_lenders AS BM')
				   ->where("status","=","pending")
				   ->get();

		$pendingloancount = DB::table('backoffice_loan_applications AS LA')
				   ->select('*')
				   ->where('LA.status','=',"pending")
				   ->get();	 		   
		
		$data['pendinglendercount'] = count($pendinglendercount);
		$data['lendersectionname'] = 'Lenders';

		$data['pendingloancount'] = count($pendingloancount);
		$data['Loansectionname'] = 'Loans';
		
		
		$data['statuscount'] = $statuscount;
		$data['statuscountper'] = $statuscountPer;
		
		

		$data['sectionname'] = 'Dashboard';
		$data['pagetitle'] = 'Dashboard - '.config('constants.project_name');
		$data['pagedescription'] = 'Dashboard - '.config('constants.project_name');
		
		return view('admin.dashboard',$data);
	}
	
	public function changepassword(Request $request)
	{
		$errors = array();
		
		$userid = Session::get('adminid');
		
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			if($act == 'changepassword'){
				
				$oldpass = $request->input('oldpass');
				$newpass = $request->input('newpass');
				$conpass = $request->input('conpass');
				
				$flag = 0;
				
				if(empty($oldpass)){
					
					$errors[] = 'Enter your old password';
					$flag = 1;
				}
				else{
					
					$chkpass = DB::table('backoffice_admin')
							   ->where("id","=",$userid)
							   ->first();
							   
					//dd($chkpass);
					
					$password = $chkpass->password;
					
					if($password != md5($oldpass)){
						
						$errors[] = 'Old password is not correct';
						$flag = 1;
					}
				}
				if(empty($newpass)){
					
					$errors[] = 'Enter your new password';
					$flag = 1;
				}
				if(empty($conpass)){
					
					$errors[] = 'Confirm your new password';
					$flag = 1;
				}
				else if($newpass != $conpass){
					
					$errors[] = 'Passwords given are not matching';
					$flag = 1;
				}
				
				if($flag == 0){
					
					DB::table("backoffice_admin")
					->where("id","=",$userid)
					->update(
						[
							'password' => md5($newpass)
						]
					);
					
					return redirect()->route('adminchangepassword')->with('action','updated');
				}
			}
		}
		
		$data['errors'] = $errors;
		$data['sectionname'] = 'Change Password';
		$data['pagetitle'] = 'Change Password - '.config('constants.project_name');
		$data['pagedescription'] = 'Change Password - '.config('constants.project_name');
		
		return view('admin.changepassword',$data);
	}

	public function siteContent(Request $request,$id=null)
	{

		
		if($request->doedit=="Update"){

				$term_id = $request->input('term_id');
				//DB::enableQueryLog();
				//if(!empty($request->input('term_english'))){
					DB::table('term_language')
						->where('term_id', $term_id)
						->where('language_id', 1)
						->update(
						[
							'language_term' => addslashes($request->input('term_english')), 
						]
					);
				//}

				//if(!empty($request->input('term_spanish'))){
					DB::table('term_language')
						->where('term_id', $term_id)
						->where('language_id', 2)
						->update(
						[
							'language_term' => addslashes($request->input('term_spanish')), 
						]
					);	
						//print_r(DB::getQueryLog());
				//}
//die();
		}

		if(!empty($id)){
			
				$records =DB::select("SELECT a.id,a.term,MAX( CASE WHEN b.language_id = 1 THEN language_term END ) as term_english , MAX(CASE WHEN b.language_id = 2 THEN language_term END ) as term_spanish FROM `smc_terms` a join `smc_term_language` b on a.id=b.term_id join `smc_languages` c on c.id=b.language_id where a.id='$id' group by b.term_id");
				$data['records']=$records;
				$data['id'] = $id;
				//print_r($data); die();
				return view('admin.sitecontent',$data);
				exit;
		}
        

		$records =Common::Sitecontent();
		if($request->has('page')){
			$currentPage = LengthAwarePaginator::resolveCurrentPage();
		}
		else{
			$currentPage = 1;
		}

		$collection = new Collection($records);
		$per_page = 50;
		$currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
		
		$data['records'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);

		$data['records']->setPath($request->url());
		
		$data['per_page'] = $per_page;
		$data['currentPage'] = $currentPage;
		$data['id'] ="";
		$data['totcount'] = count($records);
		return view('admin.sitecontent',$data);
	}

}
