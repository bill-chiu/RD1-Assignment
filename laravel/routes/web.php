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
// use App\Http\Controllers;
// Route::get('/', function(){
//     $controller = new Controllers\newDataController;
//     $controller->newdata();
//     $controller = new Controllers\TodayController;
//     $controller->index();
// });




Route::get('/', 'TodayController@index');
Route::post('/weather', 'TodayController@newData');
