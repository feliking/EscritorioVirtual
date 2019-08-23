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

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/notice/main', 'NoticeController@main')->name('notice.main')->middleware('auth');
Route::get('/option/main', 'OptionController@main')->name('option.main')->middleware('auth');
Route::get('/item/main', 'ItemController@main')->name('item.main')->middleware('auth');
Route::get('/user/main', 'UserController@main')->name('user.main')->middleware(['auth', 'admin']);

Route::get('/home', 'HomeController@index')->name('home');