<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', function () {
    return view('home.index');
});

Route::get('/shop', 'HomeController@showProducts');

Route::view('/register', 'home.register');
Route::post('/register', 'MemberController@store');

Route::group(array('prefix' => 'cart'), function() {
    Route::get('/add/{product}', 'CartController@addToCart');
    Route::get('/view', 'CartController@view');
    Route::get('/clear', 'CartController@clearCart');
    Route::get('/deduct/{product}', 'CartController@deductSpecificProduct');
    Route::get('/remove/{product}', 'CartController@removeProduct');
});

Route::group(array('prefix' => 'checkout'), function () {
    Route::get('/', 'CheckOutController@show');
    Route::post('/', 'CheckOutController@charge');
});

Route::get('/login', 'MemberLoginController@showAdminLoginForm')->name('home.login');
Route::post('/login', 'MemberLoginController@login');

Route::group(array('prefix' => 'member'), function() {
    Route::get('/verify', 'VerifyController@member');
    Route::get('/logout', function() {
        Auth::guard('members')->logout();
        Session::forget('my-cart');
        return redirect('/');
    });
    Route::get('verify/{verification_token}', 'MemberController@verify');

    Route::get('/transactions', 'MemberController@viewTransactions');

    Route::get('/edit', 'MemberController@view');
    Route::post('/edit', 'MemberController@edit');

    Route::get('/refund/{id}', 'MemberController@requestRefund');
});

Route::group(array('prefix' => 'admin'), function() {
    Route::get('/', 'AdminHomeController@index');

    Route::view('/edit', 'admin.edit');
    Route::post('/edit', 'AdminController@edit');

    Route::group(array('prefix' => 'products'), function() {
        Route::get('/', 'ProductController@index');

        Route::view('/new', 'admin.products.new');
        Route::post('/new', 'ProductController@store');

        Route::get('/edit/{product}', 'ProductController@view');
        Route::post('/edit/{product}', 'ProductController@edit');

        Route::get('/delete/{product}', 'ProductController@delete');
    });

    Route::group(array('prefix' => 'members'), function() {
        Route::get('/', 'AdminHomeController@showMembers');

        Route::get('/delete/{member}', 'AdminHomeController@deleteMember');
    });

    Route::group(array('prefix' => 'transactions'), function() {
        Route::get('/', 'AdminHomeController@showTransactions');
        Route::get('/refunded', 'AdminHomeController@showRefunded');
        Route::get('/refund/{transaction}', 'AdminHomeController@approveRefund');
    });

    Route::group(array('prefix'=> 'refunded'), function(){
        Route::get('/', 'AdminHomeController@showRefunded');
    });

    Route::get('/login', 'AdminLoginController@showAdminLoginForm')->name('login');
    Route::post('/login', 'AdminLoginController@login');

    Route::view('/register', 'admin.register');
    Route::post('/register', 'AdminController@store');

    Route::get('/logout', 'AdminHomeController@logout');
});


