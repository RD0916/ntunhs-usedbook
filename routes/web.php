<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'SellController@index');
Route::get('show/{id}', 'SellController@show');

Route::group(['middleware' => 'auth'], function() {
  Route::resource('sell', 'SellController', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);

  // Profile
  Route::get('profile/{id}', 'ProfileController@show');
  Route::post('profile/{id}', 'ProfileController@store');
  Route::get('myBooks/{id}', 'ProfileController@showMyBooks');

  // message board
  Route::post('show_messageBoard', 'SellController@show_messageBoard');
  Route::post('create_messageBoard', 'SellController@create_messageBoard');
});


// Register & login & Mail
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::get('register/sendMail', 'Auth\MailController@showSendMailForm');
Route::post('register/sendMail', 'Auth\MailController@sendMail');
Route::get('register/{code}', 'Auth\RegisterController@showRegistrationForm');
Route::post('register/{code}', 'Auth\RegisterController@register');
Route::get('logout', 'Auth\LoginController@logout');
