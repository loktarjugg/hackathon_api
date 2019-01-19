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

Route::get('/test',function (){

    $unknownIncome = '24737651700000012000';
    $cleanIncome = '150805000000000000000';
   $test =  bcdiv(bcmul(100, $unknownIncome), bcadd($unknownIncome, $cleanIncome));

   dd($test);
});