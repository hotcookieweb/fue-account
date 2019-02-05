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
// Route::get('/dashboard', 'HomeController@dashboard');
Route::get('/dashboard', 'OrderController@board');

// Route::get('/board', 'OrderController@board');

Route::get('/orders', 'OrderController@orders');
Route::get('/orders/{id}', 'OrderController@order');

Route::get('/data/board', 'BoardController@board');
Route::post('/data/board', 'OrderController@update');

Route::get('/data/statuses', 'BoardController@statuses');

Route::get('/logout', 'HomeController@logout');

Route::get('/pdf/{order_number}.pdf', 'PackingSlipController@download');
Route::get('/receipt/{order_number}', 'PackingSlipController@print');
// Route::get('/receipt/test', 'PackingSlipController@test');

Route::get('/manage/users', 'ManageUserController@manage_users');
Route::get('/manage/users/delete/{id}', 'ManageUserController@delete');
Route::post('/manage/users/create', 'ManageUserController@create');
