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
Route::get('/login-backend', 'LoginCtr@index');

Route::get('/dashboard', 'DashboardCtr@index');

// category
Route::get('/maintenance/category', 'CategoryMaintenanceCtr@index');

Route::post('/maintenance/category', 'CategoryMaintenanceCtr@store');

Route::delete('/maintenance/category/{id}', 'CategoryMaintenanceCtr@destroy');

// Sales
Route::get('/sales/cashiering', 'SalesCtr@index');
Route::post('/sales/cashiering/{search_key}', 'SalesCtr@search');
Route::get('/sales/cashiering/addToCart', 'SalesCtr@addToCart');

// Supplier
Route::get('maintenance/supplier/', 'SupplierMaintenanceCtr@index');
Route::post('/maintenance/supplier', 'SupplierMaintenanceCtr@store');
Route::post('/maintenance/supplier/update/{supplierID}', 'SupplierMaintenanceCtr@update');
Route::get('/maintenance/supplier/edit/{id}', 'SupplierMaintenanceCtr@edit');
Route::delete('/maintenance/supplier/{supplierID}', 'SupplierMaintenanceCtr@destroy');
Route::post('/maintenance/supplier/action', 'SupplierMaintenanceCtr@action');

// Product
Route::resource('/maintenance/product', 'ProductMaintenanceCtr');
Route::post('/maintenance/product', 'ProductMaintenanceCtr@store');
Route::post('/maintenance/product/update', 'ProductMaintenanceCtr@update');
Route::get('/maintenance/product/edit/{id}', 'ProductMaintenanceCtr@edit');
Route::delete('/maintenance/product/delete/{productCode}', 'ProductMaintenanceCtr@destroy');
// Filter Product
Route::get('/maintenance/product/search', 'ProductMaintenanceCtr@search');
Route::get('/maintenance/product/filterByCategory', 'ProductMaintenanceCtr@filterByCategory');
// PDF Product
Route::get('/maintenance/product/pdf/{filter_category}', 'ProductMaintenanceCtr@pdf');
Route::post('/maintenance/product/getCategoryParam/{category_param}', 'ProductMaintenanceCtr@getCategoryParam');
Route::post('/maintenance/product/show/{productCode}', 'ProductMaintenanceCtr@show');
Route::get('my-demo-mail','TestController@myDemoMail');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
