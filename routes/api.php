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
  Route::get('{id}/check', 'AreaController@checkBeforeDelete');
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

// Stokiest
Route::group(['middleware' => 'auth:api','namespace' => 'Admin', 'prefix'=>'stokiest'], function(){
  Route::post('/listing', 'StokiestController@listing');
  Route::post('/', 'StokiestController@store');
  Route::post('/{id}/upload', 'StokiestController@uploadPhoto');
  Route::delete('/{id}', 'StokiestController@destroy');
  Route::put('/{id}', 'StokiestController@update');
  Route::post('/{id}/set_location', 'StokiestController@setLocation');
});

// Items
Route::group(['middleware' => 'auth:api','namespace' => 'Admin', 'prefix'=>'items'], function(){
  Route::post('/listing', 'ItemController@listing');
  Route::post('/', 'ItemController@store');
  Route::post('/{id}/upload', 'ItemController@uploadPhoto');
  Route::delete('/{id}', 'ItemController@destroy');
  Route::put('/{id}', 'ItemController@update');
  Route::get('/medias/{id}', 'ItemController@getMedias');
});

// Gallery
Route::group(['middleware' => 'auth:api', 'prefix'=>'gallery'], function(){
  Route::get('{id}/{model}', 'GalleryController@getMedia');
  Route::post('{id}/{model}', 'GalleryController@storeMedia');
  Route::put('{id}/edit_caption', 'GalleryController@editCaption');
  Route::delete('{id}', 'GalleryController@destroy');

});

// Outlet
Route::group(['middleware' => 'auth:api','namespace' => 'Admin', 'prefix'=>'outlet'], function(){
  Route::post('/listing', 'OutletController@listing');
  Route::post('/', 'OutletController@store');
  Route::post('/{id}/upload', 'OutletController@uploadPhoto');
  Route::delete('/{id}', 'OutletController@destroy');
  Route::put('/{id}', 'OutletController@update');
  Route::post('/{id}/set_location', 'OutletController@setLocation');
});
