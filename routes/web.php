<?php

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
    return redirect()->route('login');
});

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('/client', 'ClientController');
    Route::resource('/role','RoleController');
    Route::resource('/user','UserController');
    Route::resource('/log','LogController');

    Route::group(['namespace' => 'Admin'], function () {
        Route::resource('admin-role','RoleController');
        Route::resource('admin-user','UserController');
    });
});
