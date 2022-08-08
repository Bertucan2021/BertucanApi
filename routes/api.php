<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Controllers;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/users', 'UserController@store');
Route::post('/requestpasswordreset', 'PasswordResetController@requestpasswordreset');
Route::post('/resetpassword', 'PasswordResetController@resetpassword');

Route::post('/users/update', 'UserController@update')
    ->middleware('auth:api');
Route::get('/users/getLoggedInUser', 'UserController@getLoggedInUser')
    ->middleware('auth:api');
Route::put('/users/changePassword', 'UserController@changePassword')
    ->middleware('auth:api');

Route::get('/articles', 'ArticleController@index');
Route::get('/articles/byLanguage/{language}', 'ArticleController@fetchbylanguage');
Route::middleware(['auth:api', 'scope:user'])->group(function () {
    Route::get('/users', 'UserController@index');


    Route::post('/cycleHistories', 'CycleHistoryController@store');
    Route::get('/cycleHistories', 'CycleHistoryController@index');
    Route::get('/cycleHistories/{cycleHistoryRequest}', 'CycleHistoryController@show');
    Route::put('/cycleHistories', 'CycleHistoryController@update');
    Route::delete('/cycleHistories/{cycleHistoryRequest}', 'CycleHistoryController@destroy');

    Route::post('/logInfos', 'LogInfoController@store');
    Route::get('/logInfos', 'LogInfoController@index');
    Route::get('/logInfos/{id}', 'LogInfoController@show');
    Route::put('/logInfos', 'LogInfoController@update');
    Route::delete('/logInfos', 'LogInfoController@destroy');

    Route::post('/symptomLogs', 'SymptomLogController@store');
    Route::get('/symptomLogs', 'SymptomLogController@index');
    Route::get('/symptomLogs/{id}', 'SymptomLogController@show');
    Route::put('/symptomLogs', 'SymptomLogController@update');
    Route::delete('/symptomLogs', 'SymptomLogController@destroy');

    Route::post('/userSymptomLogs', 'UserSymptomLogController@store');
    Route::get('/userSymptomLogs', 'UserSymptomLogController@index');
    Route::get('/userSymptomLogs/{id}', 'UserSymptomLogController@show');
    Route::put('/userSymptomLogs', 'UserSymptomLogController@update');
    Route::delete('/userSymptomLogs', 'UserSymptomLogController@destroy');
});

Route::post('/symptomTypes', 'SymptomTypeController@store');
Route::get('/symptomTypes', 'SymptomTypeController@index');
Route::get('/symptomTypes/{id}', 'SymptomTypeController@show');
Route::put('/symptomTypes', 'SymptomTypeController@update');
Route::delete('/symptomTypes', 'SymptomTypeController@destroy');

Route::group(['middleware' => ['auth:api', 'scope:user,admin,organization']], function () {
    Route::post('/users/logout', 'UserController@logout');
});
Route::get('/articles/{id}', 'ArticleController@show');
Route::post('/articles', 'ArticleController@store');
Route::put('/articles', 'ArticleController@update');
Route::delete('/articles', 'ArticleController@destroy');

Route::post('/addresses', 'AddressController@store');
Route::get('/memberships', 'MembershipController@index');
Route::post('/memberships', 'MembershipController@store');
Route::put('/memberships', 'MembershipController@update');
Route::delete('/memberships', 'MembershipController@destroy');

Route::get('/companies/{id}', 'CompanyController@show');
Route::get('/companies', 'CompanyController@index');
Route::post('/companies', 'CompanyController@store');
Route::put('/companies', 'CompanyController@update');
Route::delete('/companies', 'CompanyController@destroy');

Route::get('/ads', 'AdController@index');
Route::post('/ads', 'AdController@store');
Route::put('/ads', 'AdController@update');
Route::delete('/ads', 'AdController@destroy');

Route::get('/adTypes', 'AdTypeController@index');
Route::post('/adTypes', 'AdTypeController@store');
Route::put('/adTypes', 'AdTypeController@update');
Route::delete('/adTypes', 'AdTypeController@destroy');

Route::get('/gbvcenters/{id}', 'GbvCenterController@show');
Route::get('/gbvcenters', 'GbvCenterController@index');
Route::post('/gbvcenters', 'GbvCenterController@store');
Route::put('/gbvcenters', 'GbvCenterController@update');
Route::delete('/gbvcenters', 'GbvCenterController@destroy');


Route::post('/reports', 'ReportController@store')
    ->middleware('auth:api');

Route::get('/reports', 'ReportController@index');

Route::post('/media', 'MediaController@store');

Route::post('/users/login', 'UserController@login');

Route::get('/abuseTypes', 'AbuseTypeController@index');
Route::post('/abuseTypes', 'AbuseTypeController@store');

Route::middleware(['cors'])->group(function () {
});
