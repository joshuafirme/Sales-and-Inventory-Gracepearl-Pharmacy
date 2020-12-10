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
Route::get('/admin-login', 'AdminLoginCtr@index');
Route::post('/admin-login/login', 'AdminLoginCtr@login');
Route::get('/admin-login/logout', 'AdminLoginCtr@logout');

//User
Route::get('/maintenance/user', 'UserMaintenanceCtr@index');
Route::get('/maintenance/user/displayuser', 'UserMaintenanceCtr@displayUsers');
Route::post('/maintenance/user/store', 'UserMaintenanceCtr@store');
Route::post('/maintenance/user/show/{empID}', 'UserMaintenanceCtr@show');
Route::post('/maintenance/user/update', 'UserMaintenanceCtr@update');
Route::delete('/maintenance/user/delete/{empID}', 'UserMaintenanceCtr@destroy');

Route::get('/dashboard', 'DashboardCtr@index')->name('dashboard');

Route::resource('/products', 'ProductSearch');

// category
Route::get('/maintenance/category', 'CategoryMaintenanceCtr@index');
Route::post('/maintenance/category', 'CategoryMaintenanceCtr@store');
Route::post('/maintenance/category/edit/{id}', 'CategoryMaintenanceCtr@edit');
Route::post('/maintenance/category/update/{category_id}', 'CategoryMaintenanceCtr@updateCategory');
Route::delete('/maintenance/category/{id}', 'CategoryMaintenanceCtr@destroy');

// Cashiering
Route::get('/sales/cashiering', 'SalesCtr@index');
Route::post('/sales/cashiering/{search_key}', 'SalesCtr@search');
Route::get('/sales/cashiering/addToCart', 'SalesCtr@addToCart');
Route::get('/sales/cashiering/process', 'SalesCtr@process');
Route::get('/sales/cashiering/getTransNo', 'SalesCtr@getCurrentTransacNo');
Route::get('/sales/cashiering/getSalesInvNo', 'SalesCtr@getSalesInvNo');
Route::get('/sales/cashiering/isInvoiceExist/{sales_inv_no}', 'SalesCtr@isInvoiceExist');
// Sales report
Route::get('/sales/salesreport', 'SalesReportCtr@index');
Route::get('/sales/displaySales', 'SalesReportCtr@displaySales');
//Route::get('/sales/displaySalesByDate', 'SalesReportCtr@displaySalesByDate');

// Supplier
Route::get('maintenance/supplier/', 'SupplierMaintenanceCtr@index');
Route::post('/maintenance/supplier/store', 'SupplierMaintenanceCtr@store');
Route::post('/maintenance/supplier/update', 'SupplierMaintenanceCtr@update');
Route::post('/maintenance/supplier/edit/{id}', 'SupplierMaintenanceCtr@edit');
Route::delete('/maintenance/supplier/{supplierID}', 'SupplierMaintenanceCtr@destroy');
Route::post('/maintenance/supplier/action', 'SupplierMaintenanceCtr@action');
Route::post('/getCompanyID/{supplierID}', 'SupplierMaintenanceCtr@getCompanyID');

// Product
Route::resource('/maintenance/product', 'ProductMaintenanceCtr');
Route::post('/maintenance/product/store', 'ProductMaintenanceCtr@store');
Route::post('/maintenance/updateproduct/{id}', 'ProductMaintenanceCtr@updateProduct')->name('updateProduct');
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
Route::post('/maintenance/company/getCompanyMarkup/{companyID}', 'CompanyMaintenanceCtr@getCompanyMarkup');

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
Route::get('/inventory/displayReorders', 'PurchaseOrderCtr@displayReorders');
Route::get('/inventory/displayOrders', 'PurchaseOrderCtr@displayOrders');

//Supplier Delivery
Route::get('/inventory/delivery', 'SupplierDeliveryCtr@index');
Route::get('/inventory/delivery/displayPO', 'SupplierDeliveryCtr@displayPurchaseOrder');
Route::get('/inventory/delivery/show', 'SupplierDeliveryCtr@show');
Route::get('/inventory/delivered', 'SupplierDeliveryCtr@displayDelivered');
Route::post('/inventory/delivery/recordDelivery', 'SupplierDeliveryCtr@recordDelivery');

//Return
Route::get('/inventory/return', 'ReturnCtr@index');
Route::post('/inventory/return/searchSalesInvoice', 'ReturnCtr@searchSalesInvoice');
Route::post('/inventory/return/searchProdAndInv', 'ReturnCtr@searchProdAndInv');
Route::post('/inventory/return/store', 'ReturnCtr@returnItem');
Route::get('/inventory/return/displayreturn', 'ReturnCtr@displayReturns');

//pay
Route::post('/pay', 'PurchaseOrderCtr@pay')->name('pay');

//Notification
Route::resource('/inventory/notification', 'NotificationCtr');
Route::get('/getAllNotif', 'NotificationCtr@getAllNotif');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
