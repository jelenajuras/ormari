<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Index page
Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);
// Home page
Route::get('home', ['as' => 'home', 'uses' => 'User\HomeController@index']);

// Authorization
Route::get('login', ['as' => 'auth.login.form', 'uses' => 'Auth\SessionController@getLogin']);
Route::post('login', ['as' => 'auth.login.attempt', 'uses' => 'Auth\SessionController@postLogin']);
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\SessionController@getLogout']);

// Registration
Route::get('register', ['as' => 'auth.register.form', 'uses' => 'Auth\RegistrationController@getRegister']);
Route::post('register', ['as' => 'auth.register.attempt', 'uses' => 'Auth\RegistrationController@postRegister']);

// Activation
Route::get('activate/{code}', ['as' => 'auth.activation.attempt', 'uses' => 'Auth\RegistrationController@getActivate']);
Route::get('resend', ['as' => 'auth.activation.request', 'uses' => 'Auth\RegistrationController@getResend']);
Route::post('resend', ['as' => 'auth.activation.resend', 'uses' => 'Auth\RegistrationController@postResend']);

// Password Reset
Route::get('password/reset/{code}', ['as' => 'auth.password.reset.form', 'uses' => 'Auth\PasswordController@getReset']);
Route::post('password/reset/{code}', ['as' => 'auth.password.reset.attempt', 'uses' => 'Auth\PasswordController@postReset']);
Route::get('password/reset', ['as' => 'auth.password.request.form', 'uses' => 'Auth\PasswordController@getRequest']);
Route::post('password/reset', ['as' => 'auth.password.request.attempt', 'uses' => 'Auth\PasswordController@postRequest']);

/*############# ADMIN ##############*/
Route::group(['prefix' => 'admin'], function () {
  // Dashboard
  Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'Admin\DashboardController@index']);
  // Users
  Route::resource('users', 'Admin\UserController');
  // Roles
  Route::resource('roles', 'Admin\RoleController');
  //Posts
  Route::resource('posts', 'Admin\PostController', ['names' => [
  'index' 		=> 'admin.posts.index', 
  'create' 		=> 'admin.posts.create', 
  'store' 		=> 'admin.posts.store', 
  'show' 		=> 'admin.posts.show', 
  'edit' 		=> 'admin.posts.edit', 
  'update'		=> 'admin.posts.update', 
  'destroy'		=> 'admin.posts.destroy'
  ]]);
  Route::resource('cities', 'Admin\CityController', ['names' => [
  'index' 		=> 'admin.cities.index', 
  'create' 		=> 'admin.cities.create', 
  'store' 		=> 'admin.cities.store', 
  'show' 		=> 'admin.cities.show', 
  'edit' 		=> 'admin.cities.edit', 
  'update'		=> 'admin.cities.update', 
  'destroy'		=> 'admin.cities.destroy'
  ]]);
  Route::resource('customers', 'Admin\CustomerController', ['names' => [
  'index' 		=> 'admin.customers.index', 
  'create' 		=> 'admin.customers.create', 
  'store' 		=> 'admin.customers.store', 
  'show' 		=> 'admin.customers.show', 
  'edit' 		=> 'admin.customers.edit', 
  'update'		=> 'admin.customers.update', 
  'destroy'		=> 'admin.customers.destroy'
  ]]);
  Route::resource('projects', 'Admin\ProjectController', ['names' => [
  'index' 		=> 'admin.projects.index', 
  'create' 		=> 'admin.projects.create', 
  'store' 		=> 'admin.projects.store', 
  'show' 		=> 'admin.projects.show', 
  'edit' 		=> 'admin.projects.edit', 
  'update'		=> 'admin.projects.update', 
  'destroy'		=> 'admin.projects.destroy'
  ]]);
  Route::resource('cabinets', 'Admin\CabinetController', ['names' => [
  'index' 		=> 'admin.cabinets.index', 
  'create' 		=> 'admin.cabinets.create', 
  'store' 		=> 'admin.cabinets.store', 
  'show' 		=> 'admin.cabinets.show', 
  'edit' 		=> 'admin.cabinets.edit', 
  'update'		=> 'admin.cabinets.update', 
  'destroy'		=> 'admin.cabinets.destroy'
  ]]);
  Route::resource('productions', 'Admin\ProductionController', ['names' => [
  'index' 		=> 'admin.productions.index', 
  'create' 		=> 'admin.productions.create', 
  'store' 		=> 'admin.productions.store', 
  'show' 		=> 'admin.productions.show', 
  'edit' 		=> 'admin.productions.edit', 
  'update'		=> 'admin.productions.update', 
  'destroy'		=> 'admin.productions.destroy'
  ]]);
  Route::resource('preparations', 'Admin\PreparationController', ['names' => [
  'index' 		=> 'admin.preparations.index', 
  'create' 		=> 'admin.preparations.create', 
  'store' 		=> 'admin.preparations.store', 
  'show' 		=> 'admin.preparations.show', 
  'edit' 		=> 'admin.preparations.edit', 
  'update'		=> 'admin.preparations.update', 
  'destroy'		=> 'admin.preparations.destroy'
  ]]);
  Route::resource('purchases', 'Admin\PurchaseController', ['names' => [
  'index' 		=> 'admin.purchases.index', 
  'create' 		=> 'admin.purchases.create', 
  'store' 		=> 'admin.purchases.store', 
  'show' 		=> 'admin.purchases.show', 
  'edit' 		=> 'admin.purchases.edit', 
  'update'		=> 'admin.purchases.update', 
  'destroy'		=> 'admin.purchases.destroy'
  ]]);
});

// Post page
Route::post('/comment/store', ['as' => 'comment.store', 'uses' => 'IndexController@storeComment']);
Route::get('/{slug}', ['as' => 'post.show', 'uses' => 'IndexController@show']);

// Kontakt - kupac
Route::post('customer/contact', ['as' => 'customer.contact', 'uses' => 'Admin\UserController@store']);

// izjava
Route::get('/izjava_pdf/{ormar_id}','Admin\CabinetController@izjava_pdf');
Route::get('/izjava/{ormar_id}','Admin\CabinetController@izjava');

// protokol
Route::get('/protokol_pdf/{ormar_id}','Admin\CabinetController@protokol_pdf');
Route::get('/protokol/{ormar_id}','Admin\CabinetController@protokol');