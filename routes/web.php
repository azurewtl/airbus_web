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

Route::get('/production', 'ProductionController@index');

Route::get('/inceptor', 'InceptorController@odbcConnector');

Route::get('/visualze', 'InceptorController@visualzeViews');

Route::get('/table', 'StaticPagesController@table');

Route::get('/download/{id}', 'SearchController@download');

//Route::post('/odata', 'CunliangController@odata');

