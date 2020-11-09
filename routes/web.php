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

Route::resource('/products', 'ProductSearch');

// category
Route::get('/maintenance/category', 'CategoryMaintenanceCtr@index');
Route::post('/maintenance/category', 'CategoryMaintenanceCtr@store');
Route::post('/maintenance/category/edit/{id}', 'CategoryMaintenanceCtr@edit');
Route::post('/maintenance/category/update/{category_id}', 'CategoryMaintenanceCtr@updateCategory');
Route::delete('/maintenance/category/{id}', 'CategoryMaintenanceCtr@destroy');

// Sales
Route::get('/sales/cashiering', 'SalesCtr@index');
Route::post('/sales/cashiering/{search_key}', 'SalesCtr@search');
Route::get('/sales/cashiering/addToCart', 'SalesCtr@addToCart');

// Supplier
Route::get('maintenance/supplier/', 'SupplierMaintenanceCtr@index');
Route::post('/maintenance/supplier/store', 'SupplierMaintenanceCtr@store');
Route::post('/maintenance/supplier/update', 'SupplierMaintenanceCtr@update');
Route::post('/maintenance/supplier/edit/{id}', 'SupplierMaintenanceCtr@edit');
Route::delete('/maintenance/supplier/{supplierID}', 'SupplierMaintenanceCtr@destroy');
Route::post('/maintenance/supplier/action', 'SupplierMaintenanceCtr@action');

// Product
Route::resource('/maintenance/product', 'ProductMaintenanceCtr');
Route::post('/maintenance/product', 'ProductMaintenanceCtr@store');
Route::post('/maintenance/updateproduct/{id}', 'ProductMaintenanceCtr@updateProduct');
Route::post('/maintenance/product/show/{productCode}', 'ProductMaintenanceCtr@show');
Route::delete('/maintenance/product/delete/{productCode}', 'ProductMaintenanceCtr@destroy');
// Filter Product
Route::get('/maintenance/product/search', 'ProductMaintenanceCtr@search');
Route::get('/maintenance/product/filterByCategory', 'ProductMaintenanceCtr@filterByCategory');
// PDF Product
Route::get('/maintenance/product/pdf/{filter_category}', 'ProductMaintenanceCtr@pdf');
Route::post('/maintenance/product/getCategoryParam/{category_param}', 'ProductMaintenanceCtr@getCategoryParam');
Route::get('my-demo-mail','TestController@myDemoMail');

//Unit 
Route::resource('/maintenance/unit', 'UnitMaintenanceCtr');
Route::post('/maintenance/unit/edit/{id}', 'UnitMaintenanceCtr@edit');
Route::post('/maintenance/unit/update/{id}', 'UnitMaintenanceCtr@update');
Route::delete('/maintenance/unit/{id}', 'UnitMaintenanceCtr@destroy');

//Markup
Route::resource('/maintenance/markup', 'MarkupMaintenanceCtr');
Route::post('/maintenance/markup/edit/{id}', 'MarkupMaintenanceCtr@edit');
Route::post('/maintenance/markup/update/{id}', 'MarkupMaintenanceCtr@update');
Route::post('/maintenance/markup/getSupplierMarkup/{id}', 'MarkupMaintenanceCtr@getSupplierMarkup');

//Discount
Route::resource('/maintenance/discount', 'DiscountCtr');
Route::post('/maintenance/discount/activate', 'DiscountCtr@activate');
Route::post('/maintenance/discount/getdiscount', 'DiscountCtr@getDiscount');


//Stock Adjustment
Route::resource('/inventory/stockadjustment', 'StockAdjustmentCtr');
Route::post('/inventory/stockadjustment/show/{productCode}', 'StockAdjustmentCtr@show');
Route::post('/inventory/stockadjustment/adjust', 'StockAdjustmentCtr@adjust');

//Purchase Order
Route::resource('/inventory/purchaseorder', 'PurchaseOrderCtr');
//Notification
Route::resource('/inventory/notification', 'NotificationCtr');
Route::get('/inventory/notification/expired', 'NotificationCtr@expiredProduct');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
