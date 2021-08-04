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
| laravelの日本語化
        https://qiita.com/rf_p/items/f07a3ef1dbaa6f3813ab
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register/select', function() {
    return view('auth/select');  
});

// -------
Route::get('/posts', 'PostController@index');
// ブログの最初の画面
Route::post('/posts', 'PostController@store');
// DBへの保存
Route::get('/posts/create', 'PostController@create');
// create 
Route::delete('/posts/delete/{post}', 'PostController@del');
// 投稿内容の削除
Route::get('/posts/{post}','PostController@show');
// 投稿内容の詳細画面
Route::put('/posts/{post}', 'PostController@update');
// 投稿内容の修正
Route::get('/posts/{post}/edit','PostController@edit');
// 投稿内容の編集
Auth::routes();

// --calendar--
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/calendar','CalendarController@index');

Route::post('/calendar/','CalendarController@store');

Route::put('/calendar/update/{calendar_id}','CalendarController@update');

Route::get('/calendar/edit/{calendar_id}','CalendarController@edit');

Route::get('/calendar/show/{month}','CalendarController@index_move')->name('calendar');

Route::get('/calendar/show/{month}/week{counter}','CalendarController@show');

Route::get('/calendar/create/{date}','CalendarController@create');

Route::delete('/calendar/delete/{calendar_id}','CalendarController@del');

Route::get('/calendar/mypage','ProfilerController@index');
