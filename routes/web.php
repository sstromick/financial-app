<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

Auth::routes();
// Verify login of an already-logged in user (bankruptcy step)
Route::post('/user/verify-login', 'LoginController@authenticate');
Route::post('/user/login', 'LoginController@login');
Route::post('/user/logout', 'LoginController@logout');

Route::get('/inf/login', 'InfusionsoftController@login');
Route::get('/inf/callback', 'InfusionsoftController@callback');
//Route::get('/inf/test', 'InfusionsoftController@test');

Route::get('/{any}', 'SpaController@index')->where('any', '.*');
