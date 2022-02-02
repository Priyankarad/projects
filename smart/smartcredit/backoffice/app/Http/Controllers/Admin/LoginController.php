<?php 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Adminlogin;
use Session;

class LoginController extends Controller {
	
	public function __construct()
	{
		$this->middleware('guest');
		
		if(Adminlogin::isloggedin()){
			
			return redirect()->route('admindashboard')->send();
		}
	}

	
	public function index(Request $request)
	{
		//die('ssss');

		if($request->has('act')){
			//print_r($_POST);die();
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			$username = $request->input('username');
			$password = $request->input('password');
			
			if($act == 'dologin'){
				
				$checklogin = Adminlogin::checklogin($username,$password);
				
				if(!empty($checklogin)){
					
					Session::put('adminid', $checklogin->id);
					//Session::put('adminidtest', $checklogin->id);

					/*var_dump($_SESSION);
					exit;*/
					//Session::save();

					/*var_dump(Session::get('adminid'));
					exit;*/
					
					return redirect()->route('admindashboard');
				}
				else{
					
					return redirect()->route('adminlogin')->with('action','invalid');
				}
			}
		}
		
		$data['sectionname'] = 'Admin Login';
		$data['pagetitle'] = 'Admin Login - '.config('constants.project_name');
		$data['pagedescription'] = 'Admin Login - '.config('constants.project_name');
		
		return view('admin.login',$data);
	}
	
	public function logout(){
		
		Session::forget('adminid');
		
		return redirect()->route('adminlogin');
	}

}
