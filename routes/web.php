<?php

// Route::get('/', function () {
//     return view('layouts.master');
// });

// Auth::routes();
Route::post('logout','Auth\LoginController@logout')->name('logout');
Route::get('forgot-password', 'PasswordUtilityController@getForgotPassword')->name('forgot-password');
Route::post('forgot-password', 'PasswordUtilityController@postForgotPassword')->name('forgot-password');

Route::group(['middleware' => 'guest'], function(){
  Route::get('login', 'Auth\LoginController@showLoginForm');
  Route::post('login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => 'auth'], function(){
  Route::get('dashboard','DashboardController@index')->name('dashboard.index');
  Route::get('/home', 'DashboardController@index');
  Route::get('/', 'DashboardController@index');
  // Profile
  Route::get('profile/{username}', 'ProfileController@index')->name('profile.index');
  // Export
  Route::get('export-data/user', 'ExportController@exportUser')->name('export-data.user');
  Route::get('export-data/area', 'ExportController@exportArea')->name('export-data.area');
  Route::get('export-data/market', 'ExportController@exportMarket')->name('export-data.market');
});

Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function(){
  Route::get('users', 'UserController@index')->name('users.index');
  Route::get('users/create', 'UserController@create')->name('users.create');
});

// Area
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'area'], function(){
  Route::get('/', 'AreaController@index')->name('area.index');
});

// Market
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'market'], function(){
  Route::get('/', 'MarketController@index')->name('market.index');
  Route::get('/{slug}', 'MarketController@show')->name('market.show');
});

Route::get('test/email', function(){
  $user = App\User::first();
  $password = str_random(6);
  return view('emails.new_password_mail')->with([
    'user' => $user,
    'password' => $password
  ]);
});

Route::get('test/function/test', function(){
  $input = 'app/public/markets/';
  $result = explode('app/',$input);
  return $result[1];
});
