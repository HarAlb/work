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


Route::get('/','PageController@index')->name('home');
Route::post('/create','PageController@create')->name('create');
Route::get('/{token}','PageController@redirect')->middleware('verifyToken')->where('token', '[a-zA-Z0-9]{6}');

