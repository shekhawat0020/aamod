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
	
    Route::post('login', 'Auth\ApiAuthController@login');
    Route::post('register', 'Auth\ApiAuthController@register');
    Route::post('send-verify-otp', 'Auth\ApiAuthController@sendVerifyOtp');
	Route::post('forgot/sendotp', 'Auth\ApiAuthController@sendOtp');
	Route::post('forgot/password', 'Auth\ApiAuthController@passwordSet');
	
	Route::post('user/addprofile', 'UserProfilesController@store');
	Route::post('user/addprofile/step1', 'UserProfilesController@storeStep1');
	Route::post('user/addprofile/step2', 'UserProfilesController@storeStep2');
	Route::post('user/addprofile/step3', 'UserProfilesController@storeStep3');
	
	Route::post('user/updateprofile/step1', 'UserProfilesController@updateStep1');
	Route::post('user/updateprofile/step2', 'UserProfilesController@updateStep2');
	Route::post('user/updateprofile/step3', 'UserProfilesController@updateStep3');
	
	
	
		Route::post('user/updateprofile/{profile_id}', 'UserProfilesController@update');
		Route::post('user/profilelist/{user_id}', 'UserProfilesController@profileList');
		Route::post('user/joblist/{user_id}', 'UserProfilesController@jobList');		
		Route::post('user/applyjob', 'ActionController@applyJob');
		Route::post('posts', 'PostApiController@index');
		Route::post('postdetail/{post_id}', 'PostApiController@detail');
		
		Route::post('category/joblist/{category_id}', 'PostApiController@categoryJobList');
		Route::post('category/list', 'CategoryController@index');
		
		Route::post('user/newslist', 'UserProfilesController@newsList');
		Route::post('user/newsdetail/{news_id}', 'UserProfilesController@newsdetail');
		Route::post('banner', 'DataController@banner');
		Route::post('user/getchat/{job_apply_id}', 'DataController@getchat');
		Route::post('user/sendchat/{job_apply_id}', 'DataController@sendchat');
		
		
	Route::post('user/contact', 'MobileContactController@store');	
	Route::post('user/mobile/notification/list', 'DataController@mobileNotification');	
	
	
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
		
		
    });
});
