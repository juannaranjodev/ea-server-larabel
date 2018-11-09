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
Route::middleware('api')->post('/register' , 'APIControllers\AuthController@register');
Route::middleware('api')->post('/login' , 'APIControllers\AuthController@login');
Route::middleware('api')->post('/password-reset-email' , 'APIControllers\AuthController@passwordResetEmail');
Route::middleware('api')->post('/reset-password' , 'APIControllers\AuthController@resetPassword');
Route::middleware('api')->post('/send-sms/{toPhoneNumber}' , 'APIControllers\SmsController@sendSms');

Route::group(['middleware' => ['auth:api']], function () {
    //Route::any('/your_route', 'APIControllers\YourController@index');

    
});
    Route::apiResource('products', 'APIControllers\ProductController');
    Route::apiResource('users', 'APIControllers\UserController');
    Route::apiResource('ea_products', 'APIControllers\EaProductController');
    Route::apiResource('licenses', 'APIControllers\LicenseController');

//Route::get('api/licenses/getbyeaid', 'APIControllers\LicenseController@getByEaId');
