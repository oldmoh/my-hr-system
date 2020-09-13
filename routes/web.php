<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', 'UserController@index')->name('users');
Route::get('/users/create', 'UserController@create')->name('users.create');
Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
Route::get('/users/{user}/edit/password', 'UserController@edit_password')->name('users.edit.password');
Route::get('/users/{user}', 'UserController@show')->name('users.show');
Route::put('/users/{user}', 'UserController@update')->name('users.update');
Route::put('/users/{user}/password', 'UserController@update_password')->name('users.update.password');
Route::post('/users', 'UserController@store')->name('users.store');
Route::delete('/users', 'UserController@delete')->name('users.delete');
