<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// -----line notify
Route::group(['prefix' => '/calendar/mypage/line'], function () {
    Route::get('/', 'LineController@index')->name('calendar.line.');
    Route::get('/lift', 'LineController@lift')->name('calendar.line.lift');
    Route::get('/register', 'LineController@redirectToProvider')->name('calendar.line.register');
    Route::post('/', function(){dd('test');})->name('calendar.line.');
    Route::post('/send', 'LineController@send')->name('calendar.line.send');
    
    
});
