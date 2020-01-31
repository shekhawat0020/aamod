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
	
	//Borrower Master
    Route::group(['middleware' => ['permission:Borrower Master']], function() {
        Route::get('/borrower', 'BorrowerController@index')->name('borrower-list')->middleware(['permission:Borrower List']);
        Route::get('/borrower/create', 'BorrowerController@create')->name('borrower-create')->middleware(['permission:Borrower Create']);
        Route::post('/borrower/store', 'BorrowerController@store')->name('borrower-save')->middleware(['permission:Borrower Create']);
        Route::get('/borrower/edit/{id}', 'BorrowerController@edit')->name('borrower-edit')->middleware(['permission:Borrower Edit']);
        Route::post('/borrower/update/{id}', 'BorrowerController@update')->name('borrower-update')->middleware(['permission:Borrower Edit']);
        Route::get('/ajax/borrower/view/{id}', 'BorrowerController@show')->name('borrower-view')->middleware(['permission:Borrower View']);
    });
	
	//Loan Type Master
    Route::group(['middleware' => ['permission:Loan Type Master']], function() {
        Route::get('/loan-type', 'LoanTypeController@index')->name('loan-type-list')->middleware(['permission:Loan Type  List']);
        Route::get('/loan-type/create', 'LoanTypeController@create')->name('loan-type-create')->middleware(['permission:Loan Type  Create']);
        Route::post('/loan-type/store', 'LoanTypeController@store')->name('loan-type-save')->middleware(['permission:Loan Type  Create']);
        Route::get('/loan-type/edit/{id}', 'LoanTypeController@edit')->name('loan-type-edit')->middleware(['permission:Loan Type  Edit']);
        Route::post('/loan-type/update/{id}', 'LoanTypeController@update')->name('loan-type-update')->middleware(['permission:Loan Type  Edit']);
        Route::get('/ajax/loan-type/view/{id}', 'LoanTypeController@show')->name('loan-type-view')->middleware(['permission:Loan Type  View']);
    });

	
	
	
	

    
    Route::get('/setting', 'SettingController@index')->name('setting');
    Route::post('/setting/password/update', 'SettingController@updatePassword')->name('password-update');


    Route::get('/roles-list', 'RolePermissionController@roles')->name('roles-list');
    Route::get('/roles/create', 'RolePermissionController@create')->name('roles-create');
    Route::post('/roles/store', 'RolePermissionController@store')->name('roles-store');
    Route::get('/roles/edit/{id}', 'RolePermissionController@edit')->name('roles-edit');
    Route::post('/roles/update/{id}', 'RolePermissionController@update')->name('roles-update');
    Route::get('/ajax/roles/view/{id}', 'RolePermissionController@show')->name('roles-view');


});
