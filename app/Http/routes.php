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

Route::group(['middleware' => ['web']], function ()
{
	Route::get('/login', 'AuthController@index');
	Route::post('/login', 'AuthController@login');
});

Route::group(['middleware' => ['web', 'SYM']], function ()
{
	Route::get('/logout', 'AuthController@logout');

	Route::get('/', 'HomeController@index');

	Route::resource('accounts', 'AccountsController');
	Route::model('accounts', \App\Models\Account::class);

	Route::resource('packages', 'PackagesController');
	Route::model('packages', \App\Models\Package::class);
	Route::post('packages/packageJSON', 'PackagesController@packageJSON');

	Route::get('/server/services', 'ServerController@services');
	Route::post('/server/service', 'ServerController@serviceChange');

	Route::get('/server/updates', 'ServerController@updates');
});