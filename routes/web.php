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

Route::get('/', function () {
    return view('welcome');
});


Route::post('/api/register', 'UserController@register');
Route::post('/api/login', 'UserController@login');
Route::put('/api/update', 'UserController@update');
Route::get('/api/getuser', 'UserController@getusers');
Route::get('/api/filter/', 'UserController@filterusers');
Route::post('/api/resetpwd', 'UserController@forgot_pwd');
Route::delete('/api/deleteuser/{id}', 'UserController@deleteusers');

