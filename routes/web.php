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
Route::get('/sales/cashiering/process', 'SalesCtr@process');
Route::get('/sales/cashiering/getTransNo', 'SalesCtr@getCurrentTransacNo');

// Supplier
Route::get('maintenance/supplier/', 'SupplierMaintenanceCtr@index');
Route::post('/maintenance/supplier/store', 'SupplierMaintenanceCtr@store');
Route::post('/maintenance/supplier/update', 'SupplierMaintenanceCtr@update');
Route::post('/maintenance/supplier/edit/{id}', 'SupplierMaintenanceCtr@edit');
Route::delete('/maintenance/supplier/{supplierID}', 'SupplierMaintenanceCtr@destroy');
Route::post('/maintenance/supplier/action', 'SupplierMaintenanceCtr@action');
Route::post('/getCompanyMarkup/{id}', 'SupplierMaintenanceCtr@getCompanyMarkup');

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

//Unit 
Route::resource('/maintenance/unit', 'UnitMaintenanceCtr');
Route::post('/maintenance/unit/edit/{id}', 'UnitMaintenanceCtr@edit');
Route::post('/maintenance/unit/update/{id}', 'UnitMaintenanceCtr@update');
Route::delete('/maintenance/unit/{id}', 'UnitMaintenanceCtr@destroy');

//Company
Route::resource('/maintenance/company', 'CompanyMaintenanceCtr');
Route::post('/maintenance/company/edit/{id}', 'CompanyMaintenanceCtr@edit');
Route::post('/maintenance/company/update/{id}', 'CompanyMaintenanceCtr@update');
Route::delete('/maintenance/company/destroy/{id}', 'CompanyMaintenanceCtr@destroy');

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
Route::post('/inventory/purchaseorder/show/{product_code}', 'PurchaseOrderCtr@show');
Route::post('/inventory/purchaseorder/addToOrder', 'PurchaseOrderCtr@addToOrder');
Route::get('/inventory/order/print', 'PurchaseOrderCtr@pdf');
Route::get('/inventory/order/downloadOrderPDF', 'PurchaseOrderCtr@downloadOrderPDF');
Route::get('/sendorder', 'PurchaseOrderCtr@sendMail');
Route::post('/getSupplierEmail/{supplier_id}', 'PurchaseOrderCtr@getSupplierEmail');
Route::post('/filterSupplier/{supplier_id}', 'PurchaseOrderCtr@filterSupplier');
Route::post('/inventory/addRecord', 'PurchaseOrderCtr@recordOrder');
//pay
Route::post('/pay', 'PurchaseOrderCtr@pay')->name('pay');

//Notification
Route::resource('/inventory/notification', 'NotificationCtr');
Route::get('/getAllNotif', 'NotificationCtr@getAllNotif');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
