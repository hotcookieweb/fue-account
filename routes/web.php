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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/dashboard', 'HomeController@dashboard');

Route::get('/board', 'OrderController@board');

Route::get('/orders', 'OrderController@orders');
Route::get('/orders/{id}', 'OrderController@order');

Route::get('/data/board', 'BoardController@board');

Route::get('/data/statuses', 'BoardController@statuses');

Route::get('/logout', 'HomeController@logout');

Route::post('/test', 'OrderController@test');
