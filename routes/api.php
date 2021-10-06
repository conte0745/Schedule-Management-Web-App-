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
    Route::get('', 'LineController@handleProviderCallback')->name('api.line');
});



//Route::post('/calendar/ajax/chat','Ajax\ChatController@store')->name('calendar.chat.store');
