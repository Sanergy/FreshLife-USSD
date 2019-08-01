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
});


Route::get('transactions', 'TransactionController@index');
Route::get('transactions/{id}', 'TransactionController@show');
Route::post('transactions', 'TransactionController@store');
Route::put('transactions/{id}', 'TransactionController@update');
Route::delete('transactions/{id}', 'TransactionController@delete');*/

// Transactions
Route::resource('/', 'TransactionController');
Route::post('transactions/search','TransactionController@searchByPhoneOrFLTOrClientAccount');
Route::post('transactions/searchByDate','TransactionController@searchByDate');

// Checkouts
Route::resource('/checkouts','CheckoutController');
Route::post('checkouts/search','CheckoutController@searchByPhoneOrStatus');
Route::post('checkouts/searchByDate','CheckoutController@searchByDate');

//Airtime
Route::get('/airtime/index','AirtimeController@sendAirtime');
