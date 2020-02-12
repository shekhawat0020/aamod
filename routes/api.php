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



Route::group(['prefix' => 'system', 'middleware' => ['client'], 'namespace' => 'Api\Client'], function() {
    
});

Route::group([
    'prefix' => 'auth', 'namespace' => 'Api\Mobile'
], function () {
	
    Route::post('/send-login-otp', 'Auth\ApiAuthController@sendLoginOtp');
    Route::post('/verify-login-otp', 'Auth\ApiAuthController@verifyLoginOtp');
    Route::post('/registor-for-login', 'Auth\ApiAuthController@registorForLogin');
	
	
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
		
		Route::post('/loan-list', 'DataController@loanList');
    });
});
