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
// Default route for the welcome user
Route::get('/', 'HomeController@index');
Route::post('/changeLanguage', ['as' => 'changeLanguage', 'uses' => 'HomeController@postChangeLanguage']);

// Register Routes
Route::get('/register', 'Auth\RegisterController@getRegister');
Route::post('/register', 'Auth\RegisterController@postRegister');
// Login Routes
Route::get('/login', 'Auth\LoginController@getLogin');
Route::post('/login', 'Auth\LoginController@postLogin');

// Logout Route
Route::get('/logout', 'HomeController@getLogout');

// Leave Route
Route::get('leaves/create', 'HomeController@getLeave')->name('leaves/create');
Route::post('leaves/store', 'HomeController@postLeave')->name('leaves/store');
Route::post('leaves/checkvalidation', 'HomeController@checkValidation')->name('leaves/checkvalidation');
Route::get('leaves/showleaves', 'HomeController@showUserLeaveRecords')->name('leaves/showleaves');

// Admin Routes
Route::get('/admin', 'AdminController@getLogin');
Route::post('/admin', 'AdminController@postLogin');
Route::post('/deleteUser', 'DashboardController@deleteUser');
Route::group(['middleware' => ['admin']], function () {
    Route::get('/dashboard', ['as'=>'dashboard','uses'=>'DashboardController@index']);
    Route::get('/users', ['as'=>'users','uses'=>'DashboardController@users']);
    Route::get('/adminUsers', ['as'=>'dashboard','uses'=>'DashboardController@users']);
    Route::get('/addUser/{user_id?}', ['as'=>'addUser','uses'=>'DashboardController@getUser']);
    Route::get('/addLeave/{id}', ['as'=>'addLeave','uses'=>'DashboardController@getLeave']);
    Route::post('/addUser/{user_id?}', ['as'=>'editUser','uses'=>'DashboardController@postUser']);
    Route::get('leaves/show/{id}', 'DashboardController@show')->name('leaves/show');
    Route::post('admin/store', 'DashboardController@postLeave')->name('admin/store');
    Route::post('admin/checkvalidation', 'DashboardController@checkValidation')->name('admin/checkvalidation');
    Route::post('leaves/changestatus', 'DashboardController@changeLeaveStatus')->name('leaves/changestatus');
    Route::get('/addLeaveType', ['as'=>'addLeaveType','uses'=>'DashboardController@getLeaveType']);
    Route::post('/addLeaveType', ['as'=>'addLeaveType','uses'=>'DashboardController@postLeaveType']);
    Route::get('/leaveTypes', ['as'=>'leaveTypes','uses'=>'DashboardController@leaveTypes']);
});

//export to excel
Route::post('leaves/downloadExcel/', 'DashboardController@downloadExcel');
Route::post('leaves/importExcel', 'DashboardController@importExcel');