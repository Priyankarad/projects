<?php 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Login;
use Session;

class UserController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	 
	protected $mode = '';
	
	public function __construct()
	{
		$this->middleware('guest');
		
		if(!Login::isloggedin()){
			
			return redirect()->route('login')->send();
			exit;
		}
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request, $mode = null, $id = null)
	{
		//die('ssss');
		
		if($request->has('act')){
			
			//echo '<pre>'; print_r($request->all()); exit; 
			
			$act = $request->input('act');
			
			$studname = $request->input('studname');
			$username = $request->input('username');
			$password = $request->input('password');
			$active = $request->input('active');
			
			if($act == 'doadd'){
				
				DB::table('user')->insert(
					[
						'name' => $studname, 
						'username' => $username,
						'password' => $password,
						'active' => $active
					]
				);
				
				return redirect()->route('adminuser')->with('action','added');
			}
			
			if($act == 'doedit'){
				
				$id = $request->input('id');
				
				DB::table('user')
					->where('id', $id)
					->update(
					[
						'name' => $studname, 
						'username' => $username,
						'password' => $password,
						'active' => $active
					]
				);
				
				return redirect()->route('adminuser')->with('action','updated');
			}
		}
		
		if($mode == 'edit'){
			
			$recorddetails = DB::table('user')
							 ->where('id', $id)
							 ->first();
					 
			//echo '<pre>'; print_r($recorddetails); exit; 
			
			$data['recorddetails'] = $recorddetails;
		}
		
		if($mode == 'delete'){
				
			DB::table('user')->where('id', '=', $id)->delete();
			
			return redirect()->route('adminuser')->with('action','deleted');
		}
		
		$records = DB::table('user')
				 ->orderBy('id', 'desc')
				 ->get();
		
		//echo '<pre>'; print_r($records); exit; 
		
		$this->mode = $mode;
		
		$data['records'] = $records;
		$data['mode'] = $this->mode;
		$data['id'] = $id;
		$data['sectionname'] = 'User';
		$data['pagetitle'] = ($mode ? ucfirst($mode).' || ' : '').'User - '.config('constants.project_name');
		$data['pagedescription'] = ($mode ? ucfirst($mode).' || ' : '').'User - '.config('constants.project_name');
		
		return view('admin.user',$data);
	}

}
