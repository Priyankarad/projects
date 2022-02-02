<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/user/{id}', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('home', 'HomeController@index');

Route::group(['prefix'=>'controlpanel','namespace'=>'Admin'],function(){

	Route::any('home/{mode?}/{id?}', [ 'as' => 'adminuser', 'uses' => 'UserController@index']);
	Route::any('login', [ 'as' => 'login', 'uses' => 'LoginController@index']);
	Route::any('logout', [ 'as' => 'logout', 'uses' => 'LoginController@logout']);
	
});
