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
    return view('welcome');
});

Route::get('/posts', 'PostController@index');
// ブログの最初の画面
Route::get('/posts/create', 'PostController@create');
// create 
Route::get('/posts/{post}','PostController@show');
// 投稿内容の詳細画面
Route::post('posts', 'PostController@store');
