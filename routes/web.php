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


Route::get('/search', 'SearchController@index');

Route::get('/download/{id}', 'SearchController@download');

Route::get('/echarts', 'echartscontroller@test2');

Route::get('/inceptor', 'InceptorController@odbcConnector');

Route::get('/BIcharts', 'InceptorController@echartsViews');

Route::get('/visualze', 'InceptorController@visualzeViews');
//Route::post('/odata', 'CunliangController@odata');

