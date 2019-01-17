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
Route::post('/register','LoginController@register')->name('register');

Route::group(['middleware' => ['auth:api']],function (){
    Route::get('/user', 'UserController@info')->name('user');
    Route::post('/watcher', 'WatcherController@store')->name('watcher.store');
    Route::delete('/watcher/{id}', 'WatcherController@destroy')->name('watcher.destroy');

    Route::get('/reports','ReportController@index')->name('reports.index');
    Route::post('/reports','ReportController@store')->name('reports.store');
});

Route::get('/transactions/{address}', 'TransactionController@getTransactions');