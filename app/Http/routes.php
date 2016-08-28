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



// outside
//Route::get('/', function () {
//    return view('layout.landing');
//});

// outside=>login or inside=>dashboard (auth middleware in __construct)
Route::get('/', 'HomeController@index');


// login, register, resetpass rute -------------------------------------------------
// ovo automatski ispiše sve za sve 3 grupe
// Route::auth();
// -----------------------------------------|
// ne želim register tu, pa ću direktno napisati rute bez toga
// Authentication Routes...
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/reset', 'Auth\PasswordController@reset');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');

//// Registration Routes...
//Route::get('register', 'Auth\AuthController@showRegistrationForm');
//Route::post('register', 'Auth\AuthController@register');
// ----------------------------------------------------------------------------------



// inside
Route::group(['middleware'=>'auth'], function(){









	// in apps/routes.php 
	//Route::get('sse', 'HomeController@sse');



	// samo logirani korisnik
	// ========================
	// 
	// dodaj score useru
	Route::post('addscore', 'UsersController@addScore');

	// save scrapbook
	Route::post('saveScrapBook', 'UsersController@saveScrapBook');

	// realizacije detaljno
	Route::get('realisation/{period?}', 'RealisationController@index')->where('period','[m,c,q]');

	// lista aktivnih artikala (onih koji imaju > 0 bodova!)
	// možda s vremenom staviti da mogu preporučiti artikl ili prijaviti nelogičnost?
	Route::get('activeItems', 'ItemController@activeItems');

	// samo admin ili vlasnik
	// ========================
	// 
	// briši realizaciju
	Route::delete('deleterealisationitem/{id}', 'RealisationController@destroyItem')->where('id','[0-9]+');

	// affiliate detaljno
	Route::get('affiliate/{user}', ['uses'=>'UsersController@show'])->where('user','[0-9]+');

	// affiliate update details
	Route::put('affiliate/{user}', 'UsersController@update')->where('user','[0-9]+');

	// preračunaj rezultate za korisnika
	Route::get('recalculateResults/{user}', 'UsersController@recalculateResults')->where('user','[0-9]+');
	


	// samo admin
	// ========================
	// 
	// user list
	Route::get('users', 'UsersController@index');
	// user edit
	Route::get('users/{user}/edit', 'UsersController@edit')->where('user','[0-9]+');
	// user show = user edit
	Route::get('users/{user}', 'UsersController@edit')->where('user','[0-9]+');
	// user create
	Route::get('users/create', 'UsersController@create');
	// user update
	Route::put('users/{user}', 'UsersController@adminUpdate')->where('user','[0-9]+');
	// user store
	Route::post('users', 'UsersController@store');
	// user delete
	// Route::get('users/{user}/edit', 'UsersController@edit')->where('user','[0-9]+');


	// partners list
	Route::get('partners', 'PartnersController@index');
	// create partner
	Route::get('partners/create', 'PartnersController@create');
	// edit partner
	Route::get('partners/pos/{pos}/edit', 'PartnersController@editpos')->where('pos','[0-9]+');
	Route::get('partners/{partner}/edit', 'PartnersController@edit')->where('partner','[0-9]+');
	// show partner = edit partner
	Route::get('partners/pos/{pos}', 'PartnersController@editpos')->where('pos','[0-9]+');
	Route::get('partners/{partner}', 'PartnersController@edit')->where('partner','[0-9]+');
	// store partner
	Route::post('partners/pos', 'PartnersController@storepos');
	Route::post('partners', 'PartnersController@store');
	// update partner
	Route::put('partners/pos/{pos}', 'PartnersController@updatepos')->where('pos','[0-9]+');
	Route::put('partners/{partner}', 'PartnersController@update')->where('partner','[0-9]+');
	// partner delete
	Route::delete('partners/pos/{pos}', 'PartnersController@destroypos')->where('pos','[0-9]+');
	Route::delete('partners/{partner}', 'PartnersController@destroy')->where('partner','[0-9]+');


	// items list
	Route::get('items','ItemController@index');
	// item edit
	Route::get('items/{item}/edit', 'ItemController@edit')->where('item','[0-9]+');
	// item create
	Route::get('items/create', 'ItemController@create');
	// item delete
	Route::delete('items/{item}', 'ItemController@destroy')->where('item','[0-9]+');
	// item toogle active status
	Route::post('items/toggleActive/{item}', 'ItemController@toggleActive')->where('item','[0-9]+');
	// item update
	Route::put('items/{item}', 'ItemController@update')->where('item','[0-9]+');
	// item store
	Route::post('items', 'ItemController@store');




	// preračunaj rezultate za sve korisnike
	Route::get('recalculateAllResults', 'UsersController@recalculateAllResults');
	// realizacija detaljno za korisnika / period
	Route::get('realisationUserPeriod/{user}/{period}', 'RealisationController@realisationForUserInPeriod')->where(['period'=>'[m,q,c]', 'user'=>'[0-9]+']);

	// category index
	Route::get('categories', 'CategoryController@index');
	// category edit
	Route::get('categories/{category}/edit', 'CategoryController@edit')->where('category','[0-9]+');
	// category show
	Route::get('categories/{category}', 'CategoryController@edit')->where('category','[0-9]+');
	// category update
	Route::put('categories/{category}', 'CategoryController@update')->where('category','[0-9]+');
	// category create
	Route::get('categories/create', 'CategoryController@create');
	// category delete
	Route::delete('categories/{category}', 'CategoryController@destroy')->where('category','[0-9]+');
	// category store
	Route::post('categories', 'CategoryController@store');


	// brand index
	Route::get('brands', 'BrandController@index');
	// brand edit
	Route::get('brands/{brand}/edit', 'BrandController@edit')->where('brand','[0-9]+');
	// brand show
	Route::get('brands/{brand}', 'BrandController@edit')->where('brand','[0-9]+');
	// brand update
	Route::put('brands/{brand}', 'BrandController@update')->where('brand','[0-9]+');
	// brand create
	Route::get('brands/create', 'BrandController@create');
	// brand delete
	Route::delete('brands/{brand}', 'BrandController@destroy')->where('brand','[0-9]+');
	// brand store
	Route::post('brands', 'BrandController@store');



	// stats
	Route::get('stats', 'StatsController@index');

	// messages
	Route::get('messages', 'MessagesController@index');
	Route::get('inbox', 'MessagesController@inbox');
	Route::get('messages/create', 'MessagesController@create');
	Route::get('messages/{msg}/edit', 'MessagesController@edit')->where('msg','[0-9]+');
	Route::get('messages/{msg}', 'MessagesController@show')->where('msg','[0-9]+');
	Route::post('messages', 'MessagesController@store');
	Route::put('messages/{msg}', 'MessagesController@update')->where('msg','[0-9]+');
	Route::delete('messages/{msg}', 'MessagesController@destry')->where('msg','[0-9]+');


	//API, chainedselect
	Route::get('api/partnersposes/{partner_id}', 'ApiController@partnersposes');
	Route::get('api/posusers/{pos_id}', 'ApiController@posusers');










});



