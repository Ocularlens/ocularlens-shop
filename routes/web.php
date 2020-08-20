<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/products', 'HomeController@show_products');

Route::view('/register', 'home.register');
Route::post('/register', 'MemberController@store');

Route::view('/login', 'home.login')->name('login');
Route::post('/login', 'MemberLoginController@login');

Route::group(array('prefix' => 'member'), function() {
    Route::get('/verify', 'VerifyController@member');
    Route::get('/logout', function() {
        Auth::guard('members')->logout();
        return redirect('/');
    });
    Route::get('verify/{verification_token}', 'MemberController@verify');
});

Route::group(array('prefix' => 'admin'), function() {
    Route::get('/', 'AdminHomeController@index');

    Route::view('/edit', 'admin.edit');

    Route::group(array('prefix' => 'products'), function() {
        Route::get('/', 'ProductController@index');

        Route::view('/new', 'admin.products.new');
        Route::post('/new', 'ProductController@store');

        Route::get('/edit/{product}', 'ProductController@view');
        Route::post('/edit/{product}', 'ProductController@edit');
    });

    Route::group(array('prefix' => 'members'), function() {
        Route::get('/', 'AdminHomeController@show_members');
    });

    Route::view('/login', 'admin.login')->name('login');
    Route::post('/login', 'AdminLoginController@login');

    Route::view('/register', 'admin.register');
    Route::post('/register', 'AdminController@store');

    Route::get('/logout', 'AdminHomeController@logout');
});


