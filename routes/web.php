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

Route::get('/test', function () {
    return view('auth.login');
});

Auth::routes();



Route::group(['middleware' => ['auth'], 'namespace' => 'Backend'], function() {

    //['middleware' => ['permission:publish articles|edit articles']], function
//->middleware(['permission:User View|User Edit']);

	Route::get('/', 'DashboardController@index')->name('dashboard');
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


    //User Master
    Route::group(['middleware' => ['permission:User Master']], function() {
        Route::get('/users', 'UserController@index')->name('user-list')->middleware(['permission:User List']);
        Route::get('/users/create', 'UserController@create')->name('user-create')->middleware(['permission:User Create']);
        Route::post('/users/store', 'UserController@store')->name('user-save')->middleware(['permission:User Create']);
        Route::get('/users/edit/{id}', 'UserController@edit')->name('user-edit')->middleware(['permission:User Edit']);
        Route::post('/users/update/{id}', 'UserController@update')->name('user-update')->middleware(['permission:User Edit']);
        Route::get('/ajax/users/view/{id}', 'UserController@show')->name('user-view')->middleware(['permission:User View']);
    });

	Route::get('/post-list', 'PostController@index')->name('post-list');
    Route::get('/post/create', 'PostController@create')->name('post-create');
    Route::post('/post/store', 'PostController@store')->name('post-store');
    Route::get('/post/edit/{id}', 'PostController@edit')->name('post-edit');
    Route::post('/post/update/{id}', 'PostController@update')->name('post-update');
    Route::get('/post/delete/{id}', 'PostController@destroy')->name('post-delete');
    Route::get('/ajax/post/view/{id}', 'PostController@show')->name('post-view');
	
	
	Route::get('/news-list', 'NewsController@index')->name('news-list');
    Route::get('/news/create', 'NewsController@create')->name('news-create');
    Route::post('/news/store', 'NewsController@store')->name('news-store');
    Route::get('/news/edit/{id}', 'NewsController@edit')->name('news-edit');
    Route::post('/news/update/{id}', 'NewsController@update')->name('news-update');
    Route::get('/news/delete/{id}', 'NewsController@destroy')->name('news-delete');
    Route::get('/ajax/news/view/{id}', 'NewsController@show')->name('news-view');
	
	
	Route::get('/banner-list', 'BannerController@index')->name('banner-list');
    Route::get('/banner/create', 'BannerController@create')->name('banner-create');
    Route::post('/banner/store', 'BannerController@store')->name('banner-store');
    Route::get('/banner/edit/{id}', 'BannerController@edit')->name('banner-edit');
    Route::post('/banner/update/{id}', 'BannerController@update')->name('banner-update');
    Route::get('/banner/delete/{id}', 'BannerController@destroy')->name('banner-delete');
	
	
	
	Route::get('/user-apply-list', 'JobApplicationController@index')->name('user-apply-list');
	Route::get('/user-apply-view/{job_id}', 'JobApplicationController@show')->name('user-apply-view');
	Route::get('/user-apply-detail/{job_id}', 'JobApplicationController@detail')->name('user-apply-detail');
	Route::post('/user-job-assign', 'JobApplicationController@assignTo')->name('assign-job');
	Route::post('/user-job-status-update/{job_id}', 'JobApplicationController@updateStatus')->name('user-job-status-update');
	Route::post('/user-job-message/{job_id}', 'JobApplicationController@sendMessage')->name('user-job-message');
	Route::post('/ajax/user-job-message-get/{jobapply_id}/{lastid}', 'JobApplicationController@getMessage')->name('user-job-message-get');
	
	Route::get('/mobile-users-list', 'MobileUsersController@index')->name('mobile-users-list');
    Route::get('/ajax/mobile-users/view/{id}', 'MobileUsersController@show')->name('mobile-users-view');
	
	
    Route::get('/contact/list', 'ContactController@index')->name('user-contact-list');
	
	Route::get('/mobile-notification-list', 'MobileNotificationController@index')->name('mobile-notification-list');
    Route::get('/mobile-notification/create', 'MobileNotificationController@create')->name('mobile-notification-create');
    Route::post('/mobile-notification/store', 'MobileNotificationController@store')->name('mobile-notification-store');
    Route::get('/mobile-notification/edit/{id}', 'MobileNotificationController@edit')->name('mobile-notification-edit');
    Route::post('/mobile-notification/update/{id}', 'MobileNotificationController@update')->name('mobile-notification-update');
    Route::get('/mobile-notification/delete/{id}', 'MobileNotificationController@destroy')->name('mobile-notification-delete');

    
    Route::get('/setting', 'SettingController@index')->name('setting');
    Route::post('/setting/password/update', 'SettingController@updatePassword')->name('password-update');


    Route::get('/roles-list', 'RolePermissionController@roles')->name('roles-list');
    Route::get('/roles/create', 'RolePermissionController@create')->name('roles-create');
    Route::post('/roles/store', 'RolePermissionController@store')->name('roles-store');
    Route::get('/roles/edit/{id}', 'RolePermissionController@edit')->name('roles-edit');
    Route::post('/roles/update/{id}', 'RolePermissionController@update')->name('roles-update');
    Route::get('/ajax/roles/view/{id}', 'RolePermissionController@show')->name('roles-view');


});
