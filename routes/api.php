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
Route::get('/articles','ArticleController@index');
Route::post('/articles','ArticleController@store');
Route::put('/articles','ArticleController@update');
Route::delete('/articles','ArticleController@destroy');

Route::get('/memberships','MembershipController@index');
Route::post('/memberships','MembershipController@store');
Route::put('/memberships','MembershipController@update');
Route::delete('/memberships','MembershipController@destroy');
 

Route::post('/users/login', 'UserController@login');

Route::middleware(['cors'])->group(function () {
    
});