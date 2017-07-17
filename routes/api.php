<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api', 'namespace'=>'Admin', 'prefix'=>'user'], function(){
  Route::post('listing', 'UserController@listing');
  Route::get('check-mail/{email}', 'UserController@checkMail');
  Route::get('check-username/{username}', 'UserController@checkUsername');
  Route::post('/', 'UserController@store');
});

Route::group(['middleware' => 'auth:api','prefix'=>'profile'], function(){
  Route::post('listing/{user_id}','ProfileController@listing');
  Route::put('/{id}', 'ProfileController@update');
});

Route::group(['middleware' => 'auth:api','prefix'=>'password'], function(){
  Route::post('/{user_id}','PasswordUtilityController@changePassword');
  Route::get('/{user_id}/reset','PasswordUtilityController@resetPassword');
});

Route::group(['middleware' => 'auth:api','prefix'=>'upload'], function(){
  Route::post('/avatar/{user_id}','UploadController@uploadAvatar');
});

Route::group(['middleware' => 'auth:api','namespace' => 'Admin', 'prefix'=>'dashboard'], function(){
  Route::get('/get-user-count', 'DashboardUtilityController@getUserCount');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'export-data'], function(){
  Route::get('/users', 'ExportController@exportUser');
});

// Area
Route::group(['middleware' => 'auth:api','namespace' => 'Admin', 'prefix'=>'area'], function(){
  Route::post('/listing', 'AreaController@listing');
  Route::post('/', 'AreaController@store');
  Route::put('/{id}', 'AreaController@update');
  Route::delete('/{id}', 'AreaController@destroy');
  Route::get('/for/dropdown', 'AreaController@getAreaForDropdown');
});

// Market
Route::group(['middleware' => 'auth:api','namespace' => 'Admin', 'prefix'=>'market'], function(){
  Route::post('/listing', 'MarketController@listing');
  Route::post('/', 'MarketController@store');
  Route::post('/{id}/upload', 'MarketController@uploadPhoto');
  Route::delete('/{id}', 'MarketController@destroy');
  Route::put('/{id}', 'MarketController@update');
  Route::post('/{id}/set_location', 'MarketController@setLocation');
});
