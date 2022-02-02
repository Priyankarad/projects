<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
/*Route::namespace('Admin')->group(function () {
	Route::any('/', 'DashboardController@index');
});*/
//Route::any('login', [ 'as' => 'adminlogin', 'uses' => 'Admin/LoginController@index']);
//Clear route cache:
//Clear route cache:
 Route::get('/route-cache', function() {
     $exitCode = Artisan::call('route:cache');
     return 'Routes cache cleared';
 });

 //Clear config cache:
 Route::get('/config-cache', function() {
     $exitCode = Artisan::call('config:cache');
     return 'Config cache cleared';
 }); 

// Clear application cache:
 Route::get('/clear-cache', function() {
     $exitCode = Artisan::call('cache:clear');
     return 'Application cache cleared';
 });

 // Clear view cache:
 Route::get('/view-clear', function() {
     $exitCode = Artisan::call('view:clear');
     return 'View cache cleared';
 });

Route::get('/', function(){
	
	return Redirect::route('admindashboard', array());
	
});

/*Route::group(['middleware' => ['web']], function () {

    Route::any('/', [ 'as' => 'admindashboard', 'uses' => 'admin\DashboardController@index']);
	Route::any('dashboard', [ 'as' => 'admindashboard', 'uses' => 'admin\DashboardController@index']);
	Route::any('login', [ 'as' => 'adminlogin', 'uses' => 'LoginController@index']);
});*/

Route::group(['namespace'=>'Admin','middleware' => ['web']],function(){

	Route::any('/','DashboardController@index')->name('admindashboard');
	Route::any('dashboard','DashboardController@index')->name('admindashboard');
    Route::any('changepassword','DashboardController@changepassword')->name('adminchangepassword');

    Route::any('user/{mode?}/{id?}','UserController@index')->name('adminuser');
	Route::any('borrower/{mode?}/{id?}','BorrowerController@index')->name('adminborrower')->where('mode','add|edit|delete');
    Route::any('borrower/details/{id}','BorrowerController@details')->name('adminborrowerdetails');
    Route::any('merchant/{mode?}/{id?}','MerchantController@index')->name('adminmerchant');

    Route::any('processedloans/merchant/{id}','MerchantController@processedloans')->name('adminmerchantprocessedloans');
	Route::any('login','LoginController@index')->name('adminlogin');
    Route::any('logout','LoginController@logout')->name('adminlogout');
    Route::any('loanapplication/{type}/{mode?}/{id?}','LoanapplicationController@index')->name('adminloanapplication')->where('type','pending|approved|closed|rejected|covered');
	
	Route::any('loanpayments','PaymentsController@index')->name('adminloanpayments');
	Route::any('loanaccounting','PaymentsController@loanaccounting')->name('adminloanaccounting');
	
	Route::any('generatepdf/{loanid}', function($loanid){		
		Utility::generatepdf('seccis_document',$loanid);
		Utility::generatepdf('pre_contractual_document',$loanid);
		Mails::loanpreapproval($loanid);
		Mails::loanapplicationnotifymail($loanid);
		dd('done');		
	});
		
	Route::any('merchantemailverify/{merchantid}', function($merchantid){
		Mails::merchantemailverifymail($merchantid);
		dd('done');		
	});

	Route::any('merchantregister/{merchantid}', function($merchantid){
		Mails::merchantregister($merchantid);
		dd('done');		
	});

	Route::any('borrowerlogindetails/{borrowerid}/{pwd}/{loanid}', function($borrowerid,$pwd,$loanid){
		Mails::borrowerlogindetails($borrowerid,$pwd,$loanid);
		dd('done');		
	});

	Route::any('borrowerlogindetails/{borrowerid}/{pwd}', function($borrowerid,$pwd){
		Mails::borrowerlogindetails($borrowerid,$pwd);
		dd('done');		
	});
	
	Route::any('merchantforgotpassword/{merchantid}', function($merchantid){
		Mails::merchantforgotpassword($merchantid);
		dd('done');		
	});


	Route::any('borrowerforgotpassword/{borrowerid}', function($borrowerid){
		Mails::borrowerforgotpassword($borrowerid);
		dd('done');		
	});

	Route::any('merchantFundedEmailNotify/{loanid}', function($loanid){
		Mails::merchantFundedEmailNotify($loanid);
		dd('done');		
	});
    /***** Developer : PIXLRIT ******/
    Route::any('bankagregator','MerchantController@bankagregator')->name('adminbankagregator');
	Route::any('lendercashin','LenderController@lendercashin')->name('adminlendercashin');
    Route::get('lendercashout','LenderController@lendercashout')->name('adminlendercashout');

    Route::any('lenderaccounting','LenderController@lenderaccounting')->name('admininvestoraccounting');
	Route::any('loaninvestors/{loan_id?}','LenderController@loaninvestors')->name('loaninvestors');
    Route::get('downloadExcel2/{type}','LenderController@downloadExcel2');
    Route::any('merchanttransaction/{id}','MerchantController@merchanttransaction')->name('adminmerchanttransaction');
    Route::any('loanpayments/{merchant_id?}','PaymentsController@index')->name('adminloanpayments');

	//Route::any('loanapplication/{mode?}','LoanapplicationController@modify')->name('adminloanapplicationmodify');
    Route::any('loanapplication/{mode?}/{id?}/{file}','LoanapplicationController@modify')->name('adminloanapplicationmodify');
    Route::any('loanapplication/{mode?}/{id?}','LoanapplicationController@modify')->name('adminloanapplicationmodify');
	Route::any('lender/{mode?}/{id?}','LenderController@index')->name('adminlender');
	Route::get('siteContent/{id?}','DashboardController@siteContent')->name('siteContent');
	Route::any('getLoandetails','PaymentsController@getLoandetails')->name('getLoandetails');
	Route::any('savemanualpayment','PaymentsController@savemanualpayment')->name('savemanualpayment');
	Route::any('getWalletList','PaymentsController@getWalletList')->name('getwalletlist');
	Route::any('investoradmininvestment','LenderController@investoradmininvestment')->name('investoradmininvestment');	
	Route::any('investorforgotpassword/{investorid}', function($investorid){
		Mails::investorforgotpassword($investorid);
		dd('done');		
	});
   
	Route::any('lendersemailverify/{lenderid}', function($lenderid){
		Mails::lendersemailverifymail($lenderid);
		dd('done');		
	});
	/***** Developer : PIXLRIT ******/
});

Route::group(['prefix'=>'cronjobs'],function(){

	Route::get('/defaultcommunication','CronjobController@defaultcommunication')->name('crondefaultcommunication');
});

Route::group(['prefix'=>'cronjobs'],function(){

	Route::get('/borrowermonthlyinstallment','CronjobController@borrowermonthlyinstallment')->name('borrowermonthlyinstallment');
		
});

//Route::any('export', [ 'as' => 'export', 'uses' => 'LenderController@export']);