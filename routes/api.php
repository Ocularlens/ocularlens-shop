<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(array('prefix'=> 'admins'), function() {
    Route::post('/login', 'ApiController@adminLogin');

    Route::get('/me', 'ApiController@getAdminCredentials')->middleware('auth:admin-api');

    Route::post('/register', 'ApiController@adminRegister');

    Route::post('/logout', 'ApiController@adminLogout')->middleware('auth:admin-api');

    Route::post('/refresh', 'ApiController@adminRefresh')->middleware('auth:admin-api');

    Route::post('/edit', 'ApiController@adminEdit')->middleware('auth:admin-api');
});


Route::group(array('prefix'=> 'products'), function() {
    Route::get('/', 'ApiController@getAllProducts');

    Route::get('/{id}', 'ApiController@getProduct');

    Route::post('/', 'ApiController@createProduct')->middleware('auth:admin-api');

    Route::put('/{id}', 'ApiController@editProduct')->middleware('auth:admin-api');

    Route::delete('/{id}', 'ApiController@deleteProduct')->middleware('auth:admin-api');
});

Route::group(array('prefix' => 'members'), function () {
    Route::post('/login', 'ApiController@memberLogin');

    Route::get('/me', 'ApiController@getMemberCredentials')->middleware('auth:member-api');

    Route::post('/register', 'ApiController@memberRegister');

    Route::post('/logout', 'ApiController@memberLogout')->middleware('auth:member-api');

    Route::post('/refresh', 'ApiController@memberRefresh')->middleware('auth:member-api');

    Route::post('/edit', 'ApiController@memberEdit')->middleware('auth:member-api');

    Route::delete('/{id}', 'ApiController@deleteMember')->middleware('auth:admin-api');
});

Route::group(array('prefix' => 'cart', 'middleware' => 'auth:member-api'), function() {
    Route::get('/checkout', 'ApiController@checkout');
});

Route::group(array('prefix' => 'transactions'), function() {
    Route::get('/refunded', 'ApiController@getRefunded');

    Route::get('/', 'ApiController@getTransactions')->middleware('auth:admin-api');

    Route::post('/refund', 'ApiController@requestRefund')->middleware('auth:member-api');
    Route::post('/approve', 'ApiController@approveRefund')->middleware('auth:admin-api');

    Route::get('/my-transactions', 'ApiController@memberTransactions')->middleware('auth:member-api');
});