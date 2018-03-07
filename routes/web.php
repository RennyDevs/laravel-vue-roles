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

Route::get('/', 'HomeController@index');//->middleware('permisology:asd,ads');

/*Route::auth();*/
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::match(['post', 'get'], 'logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
	// Users Routes...
	Route::resource('usuarios', 'UserController')->except(['create', 'edit']);
	Route::post('get-data-users', 'UserController@dataForRegister');
	Route::post('edit-password', 'UserController@editPassword');
	Route::post('restore-user/{id}', 'UserController@restore');
	Route::view('perfil/{id}', 'users.perfil');
	Route::get('init-session-user/{id}', 'UserController@initWithOneUser');
	Route::match(['post', 'get'], 'change-module-user', 'UserController@changeModule');

	// Roles Routes...
	Route::resource('roles', 'RoleController')->except(['create', 'edit']);
	Route::post('get-data-roles', 'RoleController@dataForRegister');
	Route::post('restore-rol/{id}', 'RoleController@restore');

	// Permissions Routes...
	Route::resource('permisos', 'PermissionController')->except(['create', 'edit', 'store']);
	Route::post('restore-permission/{id}', 'PermissionController@restore');
});

// Test Route...
Route::post('/test', 'HomeController@test');
