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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::get('/sync-transactions/{address}',
    'TransactionController@syncTransaction')
    ->name('transaction.sync');


Route::post('/login', 'LoginController@login')->name('login');
Route::post('/register','RegisterController@register')->name('register');

Route::post('/upload', 'UploadController@upload')->name('upload');

Route::group(['middleware' => ['auth:api']],function (){
    Route::get('/user', 'UserController@info')->name('user');
    Route::get('/watchers', 'WatcherController@index')->name('watcher.index');
    Route::post('/watchers/{id}/watch-again', 'WatcherController@watcherAgain')->name('watcher.watcher-again');
    Route::post('/watchers', 'WatcherController@store')->name('watcher.store');
    Route::delete('/watchers/{id}', 'WatcherController@destroy')->name('watcher.destroy');

    Route::get('/reports','ReportController@index')->name('reports.index');
    Route::post('/reports','ReportController@store')->name('reports.store');
});

Route::get('/transactions/{address}', 'TransactionController@getTransactions');