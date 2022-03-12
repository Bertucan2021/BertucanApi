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


Route::post('/users','UserController@store');
Route::middleware('auth:api')->group(function () {    
    Route::post('/users/logout', 'UserController@logout');
    Route::get('/users','UserController@index');
});
Route::get('/articles/{id}','ArticleController@show');
Route::get('/articles','ArticleController@index');
Route::post('/articles','ArticleController@store');
Route::put('/articles','ArticleController@update');
Route::delete('/articles','ArticleController@destroy');

Route::post('/addresses','AddressController@store');
Route::get('/memberships','MembershipController@index');
Route::post('/memberships','MembershipController@store');
Route::put('/memberships','MembershipController@update');
Route::delete('/memberships','MembershipController@destroy');
 
Route::get('/companies/{id}','CompanyController@show');
Route::get('/companies','CompanyController@index');
Route::post('/companies','CompanyController@store');
Route::put('/companies','CompanyController@update');
Route::delete('/companies','CompanyController@destroy');

Route::get('/ads','AdController@index');
Route::post('/ads','AdController@store');
Route::put('/ads','AdController@update');
Route::delete('/ads','AdController@destroy');

Route::get('/adTypes','AdTypeController@index');
Route::post('/adTypes','AdTypeController@store');
Route::put('/adTypes','AdTypeController@update');
Route::delete('/adTypes','AdTypeController@destroy');

Route::get('/gbvcenters/{id}','GBVCenterController@show');
Route::get('/gbvcenters','GBVCenterController@index');
Route::post('/gbvcenters','GBVCenterController@store');
Route::put('/gbvcenters','GBVCenterController@update');
Route::delete('/gbvcenters','GBVCenterController@destroy');


Route::post('/users/login', 'UserController@login');

Route::middleware(['cors'])->group(function () {
    
});