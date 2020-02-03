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
        Route::get('/loan-type', 'LoanTypeController@index')->name('loan-type-list')->middleware(['permission:Loan Type List']);
        Route::get('/loan-type/create', 'LoanTypeController@create')->name('loan-type-create')->middleware(['permission:Loan Type Create']);
        Route::post('/loan-type/store', 'LoanTypeController@store')->name('loan-type-save')->middleware(['permission:Loan Type Create']);
        Route::get('/loan-type/edit/{id}', 'LoanTypeController@edit')->name('loan-type-edit')->middleware(['permission:Loan Type Edit']);
        Route::post('/loan-type/update/{id}', 'LoanTypeController@update')->name('loan-type-update')->middleware(['permission:Loan Type Edit']);
        Route::get('/ajax/loan-type/view/{id}', 'LoanTypeController@show')->name('loan-type-view')->middleware(['permission:Loan Type View']);
    });
	
	//Document Master
    Route::group(['middleware' => ['permission:Loan Type Master']], function() {
            Route::get('/loan-field', 'LoanFieldController@index')->name('loan-field-list')->middleware(['permission:Loan Field List']);
        Route::get('/loan-field/create', 'LoanFieldController@create')->name('loan-field-create')->middleware(['permission:Loan Field Create']);
        Route::post('/loan-field/store', 'LoanFieldController@store')->name('loan-field-save')->middleware(['permission:Loan Field Create']);
        Route::get('/loan-field/edit/{id}', 'LoanFieldController@edit')->name('loan-field-edit')->middleware(['permission:Loan Field Edit']);
        Route::post('/loan-field/update/{id}', 'LoanFieldController@update')->name('loan-field-update')->middleware(['permission:Loan Field Edit']);
        Route::get('/ajax/loan-field/view/{id}', 'LoanFieldController@show')->name('loan-field-view')->middleware(['permission:Loan Field View']);
    });
	
	//Document Master
    Route::group(['middleware' => ['permission:Document Master']], function() {
        Route::get('/document-field', 'DocumentFieldController@index')->name('document-field-list')->middleware(['permission:Document Field List']);
        Route::get('/document-field/create', 'DocumentFieldController@create')->name('document-field-create')->middleware(['permission:Document Field Create']);
        Route::post('/document-field/store', 'DocumentFieldController@store')->name('document-field-save')->middleware(['permission:Document Field Create']);
        Route::get('/document-field/edit/{id}', 'DocumentFieldController@edit')->name('document-field-edit')->middleware(['permission:Document Field Edit']);
        Route::post('/document-field/update/{id}', 'DocumentFieldController@update')->name('document-field-update')->middleware(['permission:Document Field Edit']);
        Route::get('/ajax/document-field/view/{id}', 'DocumentFieldController@show')->name('document-field-view')->middleware(['permission:Document Field View']);
    });
	
	//Document Master
    Route::group(['middleware' => ['permission:Document Master']], function() {
        Route::get('/document-group', 'DocumentGroupController@index')->name('document-group-list')->middleware(['permission:Document Group List']);
        Route::get('/document-group/create', 'DocumentGroupController@create')->name('document-group-create')->middleware(['permission:Document Group Create']);
        Route::post('/document-group/store', 'DocumentGroupController@store')->name('document-group-save')->middleware(['permission:Document Group Create']);
        Route::get('/document-group/edit/{id}', 'DocumentGroupController@edit')->name('document-group-edit')->middleware(['permission:Document Group Edit']);
        Route::post('/document-group/update/{id}', 'DocumentGroupController@update')->name('document-group-update')->middleware(['permission:Document Group Edit']);
        Route::get('/ajax/document-group/view/{id}', 'DocumentGroupController@show')->name('document-group-view')->middleware(['permission:Document Group View']);
    });

	//Document Master
    Route::group(['middleware' => ['permission:Document Master']], function() {
        Route::get('/document-set', 'DocumentSetController@index')->name('document-set-list')->middleware(['permission:Document Set List']);
        Route::get('/document-set/create', 'DocumentSetController@create')->name('document-set-create')->middleware(['permission:Document Set Create']);
        Route::post('/document-set/store', 'DocumentSetController@store')->name('document-set-save')->middleware(['permission:Document Set Create']);
        Route::get('/document-set/edit/{id}', 'DocumentSetController@edit')->name('document-set-edit')->middleware(['permission:Document Set Edit']);
        Route::post('/document-set/update/{id}', 'DocumentSetController@update')->name('document-set-update')->middleware(['permission:Document Set  Edit']);
        Route::get('/ajax/document-set/view/{id}', 'DocumentSetController@show')->name('document-set-view')->middleware(['permission:Document Set View']);
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
