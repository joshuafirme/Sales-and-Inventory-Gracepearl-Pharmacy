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

//Admin
Route::get('/admin-login', 'AdminLoginCtr@index');
Route::post('/admin-login/login', 'AdminLoginCtr@login');
Route::get('/admin-login/logout', 'AdminLoginCtr@logout');

//CUSTOMER---------------------------------------------------------------------------------------------------------------
//login
Route::get('/customer-login', 'Customer\CustomerLoginCtr@index');
Route::get('/customer-login/google', 'Customer\CustomerLoginCtr@redirectToGoogle');
Route::get('/customer-login/google/callback', 'Customer\CustomerLoginCtr@handleGoogleCallback');
Route::get('/customer/logout', 'Customer\CustomerLoginCtr@logout');
Route::get('/customer/islogged', 'Customer\CustomerLoginCtr@isLoggedIn');
//homepage
Route::get('/homepage', 'Customer\HomePageCtr@index');
Route::get('/homepage/pricefilter', 'Customer\HomePageCtr@getPriceFilter');
//product detail
Route::get('/productdetail', 'Customer\ProductDetailCtr@index');
Route::get('/productdetails/{product_code}', 'Customer\ProductDetailCtr@getProductDetails');
//cart
Route::post('/homepage/addtocart', 'Customer\CartCtr@addToCart');
Route::get('/cart', 'Customer\CartCtr@index');
Route::post('/cart/remove', 'Customer\CartCtr@removeFromCart');
Route::post('/cart/updateQtyAndAmount', 'Customer\CartCtr@updateQtyAndAmount');
Route::get('/cart/countcart', 'Customer\CartCtr@countCart');
Route::get('/cart/getsubtotal', 'Customer\CartCtr@getSubtotalAmount');
//checkout
Route::get('/checkout', 'Customer\CheckoutCtr@index');
Route::get('/checkout/getsubtotal', 'Customer\CheckoutCtr@getSubtotalAmount');
Route::post('/checkout/placeorder', 'Customer\CheckoutCtr@placeOrder');
//Payment
Route::get('/payment', 'Customer\PaymentCtr@index');
Route::post('/payment/cod', 'Customer\PaymentCtr@cashOnDelivery');   //COD
Route::get('/customer/gcashpayment', 'Customer\PaymentCtr@gcashPayment')->name('gcashpayment');
Route::get('/payment/afterpayment', 'Customer\PaymentCtr@afterPayment');
//Stripe payment
Route::get('stripe', 'Customer\StripePaymentCtr@stripe');
Route::post('stripe', 'Customer\StripePaymentCtr@stripePost')->name('stripe.post');

//Stripe payment
Route::get('myorders', 'Customer\MyOrdersCtr@index');

//
Route::get('/dashboard', 'DashboardCtr@index')->name('dashboard');

Route::resource('/products', 'ProductSearch');


//SALES---------------------------------------------------------------------------------------------------------------

// Cashiering
Route::get('/sales/cashiering', 'Sales\SalesCtr@index');
Route::post('/sales/cashiering/{search_key}', 'Sales\SalesCtr@search');
Route::get('/sales/cashiering/addToCart', 'Sales\SalesCtr@addToCart');
Route::get('/sales/cashiering/process', 'Sales\SalesCtr@process');
Route::get('/sales/cashiering/getTransNo', 'Sales\SalesCtr@getCurrentTransacNo');
Route::get('/sales/cashiering/getSalesInvNo', 'Sales\SalesCtr@getSalesInvNo');
Route::get('/sales/cashiering/isInvoiceExist/{sales_inv_no}', 'Sales\SalesCtr@isInvoiceExist');

// Sales report
Route::get('/sales/salesreport', 'Sales\SalesReportCtr@index');
Route::get('/sales/displaySales', 'Sales\SalesReportCtr@displaySales');

//MAINTENANCE---------------------------------------------------------------------------------------------------------------

// Supplier
Route::get('maintenance/supplier/', 'Maintenance\SupplierMaintenanceCtr@index');
Route::post('/maintenance/supplier/store', 'Maintenance\SupplierMaintenanceCtr@store');
Route::post('/maintenance/supplier/update', 'Maintenance\SupplierMaintenanceCtr@update');
Route::post('/maintenance/supplier/edit/{id}', 'Maintenance\SupplierMaintenanceCtr@edit');
Route::delete('/maintenance/supplier/{supplierID}', 'Maintenance\SupplierMaintenanceCtr@destroy');
Route::post('/maintenance/supplier/action', 'Maintenance\SupplierMaintenanceCtr@action');
Route::post('/getCompanyID/{supplierID}', 'Maintenance\SupplierMaintenanceCtr@getCompanyID');

// Product
Route::resource('/maintenance/product', 'Maintenance\ProductMaintenanceCtr');
Route::post('/maintenance/product/store', 'Maintenance\ProductMaintenanceCtr@store');
Route::post('/maintenance/updateproduct', 'Maintenance\ProductMaintenanceCtr@updateProduct');
Route::post('/maintenance/product/show/{productCode}', 'Maintenance\ProductMaintenanceCtr@show');
Route::delete('/maintenance/product/delete/{productCode}', 'Maintenance\ProductMaintenanceCtr@destroy');

//Unit 
Route::resource('/maintenance/unit', 'Maintenance\UnitMaintenanceCtr');
Route::post('/maintenance/unit/edit/{id}', 'Maintenance\UnitMaintenanceCtr@edit');
Route::post('/maintenance/unit/update/{id}', 'Maintenance\UnitMaintenanceCtr@update');
Route::delete('/maintenance/unit/{id}', 'Maintenance\UnitMaintenanceCtr@destroy');

//Company
Route::resource('/maintenance/company', 'Maintenance\CompanyMaintenanceCtr');
Route::post('/maintenance/company/edit/{id}', 'Maintenance\CompanyMaintenanceCtr@edit');
Route::post('/maintenance/company/update/{id}', 'Maintenance\CompanyMaintenanceCtr@update');
Route::delete('/maintenance/company/destroy/{id}', 'Maintenance\CompanyMaintenanceCtr@destroy');
Route::post('/maintenance/company/getCompanyMarkup/{companyID}', 'Maintenance\CompanyMaintenanceCtr@getCompanyMarkup');

//Discount
Route::resource('/maintenance/discount', 'Maintenance\DiscountCtr');
Route::post('/maintenance/discount/activate', 'Maintenance\DiscountCtr@activate');
Route::post('/maintenance/discount/getdiscount', 'Maintenance\DiscountCtr@getDiscount');

// category
Route::get('/maintenance/category', 'Maintenance\CategoryMaintenanceCtr@index');
Route::post('/maintenance/category', 'Maintenance\CategoryMaintenanceCtr@store');
Route::post('/maintenance/category/edit/{id}', 'Maintenance\CategoryMaintenanceCtr@edit');
Route::post('/maintenance/category/update/{category_id}', 'Maintenance\CategoryMaintenanceCtr@updateCategory');
Route::delete('/maintenance/category/{id}', 'Maintenance\CategoryMaintenanceCtr@destroy');

//User
Route::get('/maintenance/user', 'Maintenance\UserMaintenanceCtr@index');
Route::get('/maintenance/user/displayuser', 'Maintenance\UserMaintenanceCtr@displayUsers');
Route::get('/maintenance/user/getname', 'Maintenance\UserMaintenanceCtr@getName');
Route::post('/maintenance/user/store', 'Maintenance\UserMaintenanceCtr@store');
Route::post('/maintenance/user/show/{empID}', 'Maintenance\UserMaintenanceCtr@show');
Route::post('/maintenance/user/update', 'Maintenance\UserMaintenanceCtr@update');
Route::delete('/maintenance/user/delete/{empID}', 'Maintenance\UserMaintenanceCtr@destroy');

//INVENTORY---------------------------------------------------------------------------------------------------------------

//Stock Adjustment
Route::resource('/inventory/stockadjustment', 'Inventory\StockAdjustmentCtr');
Route::post('/inventory/stockadjustment/show/{productCode}', 'Inventory\StockAdjustmentCtr@show');
Route::post('/inventory/stockadjustment/adjust', 'Inventory\StockAdjustmentCtr@adjust');

//Purchase Order
Route::resource('/inventory/purchaseorder', 'Inventory\PurchaseOrderCtr');
Route::post('/inventory/purchaseorder/show/{product_code}', 'Inventory\PurchaseOrderCtr@show');
Route::post('/inventory/purchaseorder/addToOrder', 'Inventory\PurchaseOrderCtr@addToOrder');
Route::get('/inventory/order/print', 'Inventory\PurchaseOrderCtr@pdf');
Route::get('/inventory/order/downloadOrderPDF', 'Inventory\PurchaseOrderCtr@downloadOrderPDF');
Route::get('/sendorder', 'PurchaseOrderCtr@sendMail');
Route::post('/getSupplierEmail/{supplier_id}', 'Inventory\PurchaseOrderCtr@getSupplierEmail');
Route::post('/filterSupplier/{supplier_id}', 'Inventory\PurchaseOrderCtr@filterSupplier');
Route::post('/inventory/addRecord', 'Inventory\PurchaseOrderCtr@recordOrder');
Route::get('/inventory/displayReorders', 'Inventory\PurchaseOrderCtr@displayReorders');
Route::get('/inventory/displayOrders', 'Inventory\PurchaseOrderCtr@displayOrders');

//Supplier Delivery
Route::get('/inventory/delivery', 'Inventory\SupplierDeliveryCtr@index');
Route::get('/inventory/delivery/displayPO', 'Inventory\SupplierDeliveryCtr@displayPurchaseOrder');
Route::get('/inventory/delivery/show', 'Inventory\SupplierDeliveryCtr@show');
Route::get('/inventory/delivered', 'Inventory\SupplierDeliveryCtr@displayDelivered');
Route::post('/inventory/delivery/recordDelivery', 'Inventory\SupplierDeliveryCtr@recordDelivery');
Route::post('/inventory/delivery/markascompleted/{del_nums}', 'Inventory\SupplierDeliveryCtr@markAsCompleted');

//Stock Entry
Route::get('/inventory/stockentry', 'Inventory\StockEntryCtr@index');

//Return
Route::get('/inventory/return', 'Inventory\ReturnCtr@index');
Route::post('/inventory/return/searchSalesInvoice', 'Inventory\ReturnCtr@searchSalesInvoice');
Route::post('/inventory/return/searchProdAndInv', 'Inventory\ReturnCtr@searchProdAndInv');
Route::post('/inventory/return/store', 'Inventory\ReturnCtr@returnItem');
Route::get('/inventory/return/displayreturn', 'Inventory\ReturnCtr@displayReturns');

//Notification
Route::resource('/inventory/notification', 'Inventory\NotificationCtr');
Route::get('/notification/getAllNotif', 'Inventory\NotificationCtr@getAllNotif');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
