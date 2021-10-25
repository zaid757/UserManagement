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
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('users')->namespace('Users')->name('users.')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', 'UsersController@index')->name('dashboard');
});

Route::prefix('accounts')->namespace('Accounts')->name('accounts.')->middleware(['web','auth'])->group(function () {
    Route::get('/', 'UsersAccountsController@index')->name('dashboard');
});

Route::prefix('data')->namespace('Data')->middleware(['web', 'auth'])->group(base_path('routes/web/data.php'));


Route::get('/home', 'HomeController@index')->name('home');

Route::resource('register', 'registerController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
