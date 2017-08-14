<?php

// Route::get('/', function () {
//     return view('layouts.master');
// });

// Auth::routes();
Route::post('logout','Auth\LoginController@logout')->name('logout');
Route::get('forgot-password', 'PasswordUtilityController@getForgotPassword')->name('forgot-password');
Route::post('forgot-password', 'PasswordUtilityController@postForgotPassword')->name('forgot-password');

Route::get('test/mail/view', function(){
  $transaction = App\Models\Transaction::find(1);
  return view('emails.transaction_verified')->with([
    'transaction' => $transaction,
  ]);
});

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
  Route::get('export-data/stokiest', 'ExportController@exportStokiest')->name('export-data.stokiest');
  Route::get('export-data/item', 'ExportController@exportItem')->name('export-data.item');
  Route::get('export-data/outlet', 'ExportController@exportOutlet')->name('export-data.outlet');
  Route::get('export-data/seller-target', 'ExportController@exportSellerTarget')->name('export-data.seller-target');
  Route::get('export-data/transaction/{dates}', 'ExportController@exportTransaction')->name('export-data.transaction');
  Route::get('export-data/{code}/transaction/', 'ExportController@exportTransactionPdf')->name('export-data.transaction-pdf');

});

Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function(){
  Route::get('users', 'UserController@index')->name('users.index');
  Route::get('users/create', 'UserController@create')->name('users.create');
});

// Area
Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'area'], function(){
  Route::get('/', 'AreaController@index')->name('area.index');
});

// Market
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'market'], function(){
  Route::get('/', 'MarketController@index')->name('market.index');
  Route::get('/{slug}', 'MarketController@show')->name('market.show');
});

// Stokiest
Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'stokiest'], function(){
  Route::get('/', 'StokiestController@index')->name('stokiest.index');
  Route::get('/create', 'StokiestController@create')->name('stokiest.create');
  Route::get('/{code}', 'StokiestController@show')->name('stokiest.show');
});

// Item
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'items'], function(){
  Route::get('/', 'ItemController@index')->name('items.index');
  Route::get('/create', 'ItemController@create')->name('items.create');
  Route::get('/{code}', 'ItemController@show')->name('items.show');
});



// Supervisors
Route::group(['middleware' => 'supervisor', 'namespace' => 'Supervisor'], function(){
  Route::group(['prefix' => 'seller'], function(){
    Route::get('/', 'SellerController@index')->name('seller.index');
    Route::get('/create', 'SellerController@create')->name('seller.create');
  });
  Route::group(['prefix' => 'seller-target'], function(){
    Route::get('/', 'SellerTargetController@index')->name('seller-target.index');
    Route::get('/create', 'SellerTargetController@create')->name('seller-target.create');
  });
});

// Seller
Route::group(['middleware' => 'seller', 'namespace' => 'Seller'], function(){
  Route::group(['prefix' => 'target'], function(){
    Route::get('/', 'TargetController@index')->name('target.index');
  });
  Route::group(['prefix' => 'transaction'], function(){
    Route::get('/', 'TransactionController@index')->name('transaction.index');
    Route::get('/create', 'TransactionController@create')->name('transaction.create');
    Route::get('/{code}', 'TransactionController@show')->name('transaction.show');
  });
});

// Outlet
Route::group(['middleware' => 'auth', 'namespace' => 'Seller', 'prefix' => 'outlet'], function(){
  Route::get('/', 'OutletController@index')->name('outlet.index');
  Route::get('/create', 'OutletController@create')->name('outlet.create');
  Route::get('/{code}', 'OutletController@show')->name('outlet.show');
});
