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

Route::get('/top', function () {
    return view('top');
})->name('top');

Route::get('/register/select', function() {
    return view('auth/select');  
});

Route::post('/register/select/new' , 'ShopController@new_create')->name('select.new');
Route::post('/register/select/already' , 'ShopController@already_create')->name('select.already');

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

Route::get('/home', 'HomeController@index')->name('home');

// --calendar--
Route::group(['prefix' => '/calendar'], function () {
    Route::get('/','CalendarController@index')->name('calendar');
    Route::post('/','CalendarController@store')->name('calendar.store');
    Route::put('/update/{calendar_id}','CalendarController@update')->name('calendar.update');
    Route::get('/show/edit','CalendarController@edit2')->name('calendar.edit2');
    Route::get('/show/{month}','CalendarController@index_move')->name('calendar.index.move');
    Route::get('/show/{month}/week{counter}','CalendarController@show')->name('calendar.show');
    Route::get('/create/date','CalendarController@create')->name('calendar.create');
    Route::delete('/delete/{calendar_id}','CalendarController@del')->name('calendar.del');
});

// ----mypage-----
Route::group(['prefix'=>'/calendar/mypage'], function(){
    Route::get('/','UserController@index')->name('calendar.mypage');
    Route::get('/profile/edit','UserController@edit')->name('calendar.mypage.edit');
    Route::put('/profile/update','UserController@update')->name('calendar.mypage.update');
});

Route::group(['prefix' => '/calendar/root'], function () {
    Route::get('/','ShopController@index')->name('calendar.root');
    Route::get('/edit','ShopController@edit')->name('calendar.root.edit');
    Route::put('/update/{id}','ShopController@update')->name('calendar.root.update');
});
//------
Route::get('/vue', function(){
    return view('dm');
});

//---chat SPAアプリにしたい
Route::get('/calendar/chat','ChatController@index')->name('calendar.chat');
Route::get('/calendar/ajax/chat','Ajax\ChatController@index')->name('calendar.chat.index');
Route::post('/calendar/ajax/chat','Ajax\ChatController@store')->name('calendar.chat.store');


// -----line notify
Route::group(['prefix' => '/calendar/mypage/line'], function () {
    Route::get('/', 'LineController@index')->name('calendar.line.');
    Route::get('/lift', 'LineController@lift')->name('calendar.line.lift');
    Route::get('/register', 'LineController@redirectToProvider')->name('calendar.line.register');
    Route::post('/send', 'LineController@send')->name('calendar.line.send');
    
    
});