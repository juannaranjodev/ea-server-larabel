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

Route::get('/licenses/getbyeaid/{ea_id}/{user_id}', 'APIControllers\LicenseController@getByEaId');
Route::get('/ea_products/myea_products/{user_id}', 'APIControllers\EaProductController@getByUserId');


