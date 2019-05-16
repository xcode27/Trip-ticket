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

Route::get('/', "PagesController@index");
Route::get('/home', "PagesController@home");
Route::get('/vehiclepass', "PagesController@vehiclepass");
Route::get('/tripList', "PagesController@tripList");
Route::get('/create_schedule', "PagesController@create_schedule");

//transaction route
Route::get('/payment/{id}',"DeliveryController@show");
Route::get('/displayEntry',"DeliveryController@displayEntry")->name('displayEntry');
Route::get('/getDriver',"DeliveryController@getDriver");
Route::get('/getHelper',"DeliveryController@getHelper");
Route::post('/savetoTemp',"DeliveryController@savetoTemp");
Route::post('/savetoMain',"DeliveryController@savetoMain");
Route::get('/getLastSeq',"DeliveryController@getLastSeq");
Route::get('/printTripSchedule/{frm}',"DeliveryController@printTripSchedule")->name('printTripSchedule');
Route::get('/cancelList/{id}',"DeliveryController@cancelList");
Route::get('/tripList/{date}',"DeliveryController@tripList")->name('tripList');
Route::get('/redisplayEntry/{formno}',"DeliveryController@redisplayEntry");
Route::get('/adon_filter',"DeliveryController@adon_filter")->name('adon_filter');

//schedule trip
Route::get('/getroute',"SheduleRouteController@getroute");
Route::get('/displaySchedule',"SheduleRouteController@displaySchedule")->name('displaySchedule');
Route::post('/saveTrip',"SheduleRouteController@saveTrip");
Route::get('/removeTrip/{id}',"SheduleRouteController@removeTrip");
//user route
Route::post('/addUser',"UserController@addUser");
Route::get('/userlist',"UserController@userList")->name('userlist');
Route::post('/updateUser',"UserController@updateUser");
Route::get('/deleteUser/{id}',"UserController@deleteUser");
Route::post('/userLogin',"UserController@userLogin");
Route::post('/updatecredentials',"UserController@updatecredentials");
Route::post('/logout', "UserController@logout");

