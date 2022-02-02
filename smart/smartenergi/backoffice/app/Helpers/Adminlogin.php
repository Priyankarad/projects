<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use DB;
use Session;

class Adminlogin
{
    public static function checklogin($username,$password)
    {
        $recorddetails = DB::table('backoffice_admin')
						 ->where('username', $username)
						 ->where('password', md5($password))
						 ->first();
						 
		//echo '<pre>'; print_r($recorddetails); exit;
		
		return $recorddetails;
    }
	
	public static function loggedinadmindetails($id)
    {
        $recorddetails = DB::table('backoffice_admin')
						 ->where('id', $id)
						 ->first();
						 
		//echo '<pre>'; print_r($recorddetails); exit;
		
		return $recorddetails;
    }
	
	public static function isloggedin()
    {
    	/*echo "Ocean";
    	var_dump(Session::get('adminid'));
    	exit;*/
        $status = !empty(Session::get('adminid')) ? 1 : 0;
		
		return $status;
    }
}