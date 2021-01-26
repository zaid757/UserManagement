<?php

/**
 * prefix:data
 * namespace: Data
 */

 Route::prefix('accounts')->namespace('Accounts')->group(function () {
     Route::get('user/{user?}', 'UserAccountController@index');
     Route::prefix('updates')->namespace('Updates')->group(function () {
         Route::put('email/{user}', 'EmailUpdatesController@update');
         Route::put('name/{user}', 'NamedUpdatesController@update');
     });
 });


 Route::prefix('users')->namespace('Users')->group(function () {
     Route::prefix('logs')->namespace('Logs')->group(function () {
         Route::get('{user}', 'UserLogsController@index');
     });

     Route::prefix('updates')->namespace('Updates')->group(function () {
         Route::put('password/{user}', 'UpdatePasswordsController@update');
         Route::post('send-reset-link/{user}', 'UpdatePasswordsController@sendResetLink');
     });

     Route::get('/', 'UsersController@index');
     Route::post('/', 'UsersController@store');
     Route::put('{user}', 'UsersController@update');
     Route::delete('{user}', 'UsersController@destroy');
 });
