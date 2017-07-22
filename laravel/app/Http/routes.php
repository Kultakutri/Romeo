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


Route::get('/', function () {
    return view('index');
});

// Registration Routes...
//Route::get('register', 'Auth\AuthController@showRegistrationForm');
//Route::post('register', 'Auth\AuthController@register');



Route::group(['prefix' => 'api'], function(){
	


	Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
  Route::post('authenticate', 'AuthenticateController@authenticate');
  Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');

  //Route::get('register', 'Auth\AuthController@showRegistrationForm'); //tämä
  Route::post('register', 'Auth\AuthController@register', ['only' => ['auth']]);
  

	Route::resource('shops', 'ShopsController');
  Route::resource('shop', 'ShopController');
  Route::resource('usershop', 'UserShopController');
  Route::delete('listas', 'ListasController@destroy');
  Route::resource('listas', 'ListasController');
  Route::resource('products', 'ProductsController');
  Route::resource('productlists', 'ProductsListController');

});
