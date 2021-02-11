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


Route::get('/', 'Customer\LoginCtr@index');

//Admin
Route::get('/admin-login', 'AdminLoginCtr@index');
Route::post('/admin-login/login', 'AdminLoginCtr@login');
Route::get('/admin-login/logout', 'AdminLoginCtr@logout');


//DASHBOARD
Route::get('/dashboard', 'DashboardCtr@index')->name('dashboard');

Route::resource('/products', 'ProductSearch');

//CUSTOMER---------------------------------------------------------------------------------------------------------------
//login
Route::post('customer-login/login', 'Customer\LoginCtr@login');
Route::get('/customer/logout', 'Customer\LoginCtr@logout');
//google login
Route::get('/customer-login/google', 'Customer\GoogleLoginCtr@redirectToGoogle');
Route::get('/customer-login/google/callback', 'Customer\GoogleLoginCtr@handleGoogleCallback');
Route::get('/customer/islogged', 'Customer\GoogleLoginCtr@isLoggedIn');
//sing up
Route::get('/signup', 'Customer\SignUpCtr@index');
Route::post('/signup/signup', 'Customer\SignUpCtr@signUp');
Route::get('/signup/isexists', 'Customer\SignUpCtr@isPhoneNoExists');
Route::get('/signup/send-OTP', 'Customer\SignUpCtr@sendOTP');
Route::get('/signup/validate-otp/{otp}', 'Customer\SignUpCtr@validateOTP');

//customer account
Route::get('/account', 'Customer\CustomerAccountCtr@index');
Route::get('/account/getaccountinfo', 'Customer\CustomerAccountCtr@getAccountInfo');
Route::get('/account/getshippinginfo', 'Customer\CustomerAccountCtr@getShippingInfo');
Route::post('/account/update', 'Customer\CustomerAccountCtr@updateAccount');
Route::post('/account/uploadID', 'Customer\CustomerAccountCtr@uploadID');
Route::get('/account/checkifverified', 'Customer\CustomerAccountCtr@checkIfVerified');
Route::get('/account/getBrgyList/{municipality}', 'Customer\CustomerAccountCtr@getBrgyList');

//homepage
Route::get('/homepage', 'Customer\HomePageCtr@index');
Route::get('/homepage/pricefilter', 'Customer\HomePageCtr@getPriceFilter');
Route::get('/homepage/allproduct', 'Customer\HomePageCtr@getAllProduct');
Route::get('/homepage/searchproduct/{search_key}', 'Customer\HomePageCtr@searchProduct');
Route::get('/terms_and_condition', 'Customer\HomePageCtr@termsAndCondition');

//product detail
Route::get('/productdetails', 'Customer\ProductDetailCtr@index');
Route::get('/productdetails/{product_code}', 'Customer\ProductDetailCtr@getProductDetails');
Route::post('/productdetails/buynow', 'Customer\ProductDetailCtr@buyNow');
Route::get('/productdetails/buynow/forget', 'Customer\ProductDetailCtr@forgetBuyNow');
//cart
Route::post('/homepage/addtocart', 'Customer\CartCtr@addToCart');
Route::get('/cart', 'Customer\CartCtr@index');
Route::post('/cart/remove', 'Customer\CartCtr@removeFromCart');
Route::post('/cart/updateQtyAndAmount', 'Customer\CartCtr@updateQtyAndAmount');
Route::get('/cart/countcart', 'Customer\CartCtr@countCart');
Route::get('/cart/getsubtotal', 'Customer\CartCtr@getSubtotalAmount');
Route::get('/cart/sc_discount', 'Customer\CartCtr@seniorGenericItemDiscount');
Route::get('/cart/pwd_discount', 'Customer\CartCtr@pwdGenericItemDiscount');
Route::get('/cart/total_due_discount', 'Customer\CartCtr@getTotalDueWithDiscount');
//checkout
Route::get('/checkout', 'Customer\CheckoutCtr@index');
Route::get('/checkout/getsubtotal', 'Customer\CheckoutCtr@getSubtotalAmount');
Route::post('/checkout/placeorder', 'Customer\CheckoutCtr@placeOrder');
Route::get('/checkout/shipping_fee', 'Customer\CheckoutCtr@getShippingFee');
Route::get('/checkout/forget', 'Customer\CheckoutCtr@forgetDiscount');
//Payment
Route::get('/payment', 'Customer\PaymentCtr@index');
Route::post('/payment/cod', 'Customer\PaymentCtr@cashOnDelivery');   //COD
Route::get('/customer/gcashpayment', 'Customer\PaymentCtr@gcashPayment')->name('gcashpayment');
Route::get('/payment/afterpayment', 'Customer\PaymentCtr@afterPayment');
Route::get('/payment/paynow/{order_no}', 'Customer\PaymentCtr@payNow');
Route::get('/payment/afterpayment/forget', 'Customer\PaymentCtr@forgetOrder');
//Stripe payment
Route::get('stripe', 'Customer\StripePaymentCtr@stripe');
Route::post('stripe', 'Customer\StripePaymentCtr@stripePost')->name('stripe.post');
Route::get('stripe/success_payment', 'Customer\StripePaymentCtr@stripeSuccess');
//my order
Route::get('myorders', 'Customer\MyOrdersCtr@index');
Route::get('myorder/cancel/{order_no}', 'Customer\MyOrdersCtr@cancelOrder');



//SALES---------------------------------------------------------------------------------------------------------------

// Cashiering
Route::get('/sales/cashiering', 'Sales\SalesCtr@index');
Route::post('/sales/cashiering/{search_key}', 'Sales\SalesCtr@search');
Route::get('/sales/cashiering/addToCart', 'Sales\SalesCtr@addToCart');
Route::get('/cashiering/total_amount', 'Sales\SalesCtr@getTotalAmount');
Route::get('/cashiering/generic_total_amount', 'Sales\SalesCtr@getGenericTotalAmount');
Route::get('/sales/cashiering/process', 'Sales\SalesCtr@process');
Route::get('/sales/cashiering/getTransNo', 'Sales\SalesCtr@getCurrentTransacNo');
Route::get('/sales/cashiering/getSalesInvNo', 'Sales\SalesCtr@getSalesInvNo');
Route::get('/sales/cashiering/isInvoiceExist/{sales_inv_no}', 'Sales\SalesCtr@isInvoiceExist');
Route::get('/cashiering/reciept/print', 'Sales\SalesCtr@pdf');
Route::get('/cashiering/void', 'Sales\SalesCtr@void');
Route::get('/cashiering/forgetcart', 'Sales\SalesCtr@forgetCart');
Route::post('/cashiering/credential', 'Sales\SalesCtr@credentialBeforeVoid');

// Sales report
Route::get('/sales/salesreport', 'Sales\SalesReportCtr@index');
Route::get('/sales/displaySales', 'Sales\SalesReportCtr@displaySales');
Route::get('/sales/salesreport/compute', 'Sales\SalesReportCtr@computeSales');

//MAINTENANCE---------------------------------------------------------------------------------------------------------------

// Supplier
Route::get('maintenance/supplier/', 'Maintenance\SupplierMaintenanceCtr@index');
Route::post('/maintenance/supplier/store', 'Maintenance\SupplierMaintenanceCtr@store');
Route::post('/maintenance/supplier/update', 'Maintenance\SupplierMaintenanceCtr@update');
Route::post('/maintenance/supplier/edit/{id}', 'Maintenance\SupplierMaintenanceCtr@edit');
Route::post('/maintenance/supplier/{supplierID}', 'Maintenance\SupplierMaintenanceCtr@destroy');
Route::post('/maintenance/supplier/action', 'Maintenance\SupplierMaintenanceCtr@action');
Route::post('/getCompanyID/{supplierID}', 'Maintenance\SupplierMaintenanceCtr@getCompanyID');

// Product
Route::resource('/maintenance/product', 'Maintenance\ProductMaintenanceCtr');
Route::post('/maintenance/product/store', 'Maintenance\ProductMaintenanceCtr@store');
Route::post('/maintenance/updateproduct', 'Maintenance\ProductMaintenanceCtr@updateProduct');
Route::post('/maintenance/product/show/{productCode}', 'Maintenance\ProductMaintenanceCtr@show');
Route::post('/maintenance/product/delete', 'Maintenance\ProductMaintenanceCtr@destroy');
Route::post('/maintenance/product/bulk-archive/{id}', 'Maintenance\ProductMaintenanceCtr@bulkArchive');

//Unit 
Route::resource('/maintenance/unit', 'Maintenance\UnitMaintenanceCtr');
Route::post('/maintenance/unit/edit/{id}', 'Maintenance\UnitMaintenanceCtr@edit');
Route::post('/maintenance/unit/update/{id}', 'Maintenance\UnitMaintenanceCtr@update');
Route::post('/maintenance/unit/{id}', 'Maintenance\UnitMaintenanceCtr@destroy');

//Company
Route::resource('/maintenance/company', 'Maintenance\CompanyMaintenanceCtr');
Route::post('/maintenance/company/edit/{id}', 'Maintenance\CompanyMaintenanceCtr@edit');
Route::post('/maintenance/company/update/{id}', 'Maintenance\CompanyMaintenanceCtr@update');
Route::delete('/maintenance/company/destroy/{id}', 'Maintenance\CompanyMaintenanceCtr@destroy');
Route::post('/maintenance/company/getCompanyMarkup/{companyID}', 'Maintenance\CompanyMaintenanceCtr@getCompanyMarkup');

//Discount
Route::resource('/maintenance/discount', 'Maintenance\DiscountCtr');
Route::post('/maintenance/discount/activate', 'Maintenance\DiscountCtr@activate');
Route::post('/maintenance/discount/sc_discount', 'Maintenance\DiscountCtr@getSeniorCitizenDiscount');
Route::post('/maintenance/discount/pwd_discount', 'Maintenance\DiscountCtr@getPWDDiscount');

// category
Route::get('/maintenance/category', 'Maintenance\CategoryMaintenanceCtr@index');
Route::post('/maintenance/category', 'Maintenance\CategoryMaintenanceCtr@store');
Route::post('/maintenance/category/edit/{id}', 'Maintenance\CategoryMaintenanceCtr@edit');
Route::post('/maintenance/category/update/{category_id}', 'Maintenance\CategoryMaintenanceCtr@updateCategory');
Route::post('/maintenance/category/{id}', 'Maintenance\CategoryMaintenanceCtr@destroy');

//shipping address
Route::get('/maintenance/shippingadd', 'Maintenance\ShippingAddressCtr@index');
Route::get('/maintenance/shippingadd/brgylist/{municipality_name}', 'Maintenance\ShippingAddressCtr@getBrgyList');
Route::post('/maintenance/shippingadd/store', 'Maintenance\ShippingAddressCtr@store');
Route::get('/maintenance/shippingadd/show/{id}', 'Maintenance\ShippingAddressCtr@show');
Route::post('/maintenance/shippingadd/update', 'Maintenance\ShippingAddressCtr@update');
Route::post('/maintenance/shippingadd/delete/{id}', 'Maintenance\ShippingAddressCtr@destroy');

//User
Route::get('/maintenance/user', 'Maintenance\UserMaintenanceCtr@index');
Route::get('/maintenance/user/displayuser', 'Maintenance\UserMaintenanceCtr@displayUsers');
Route::get('/maintenance/user/getname', 'Maintenance\UserMaintenanceCtr@getName');
Route::post('/maintenance/user/store', 'Maintenance\UserMaintenanceCtr@store');
Route::post('/maintenance/user/show/{empID}', 'Maintenance\UserMaintenanceCtr@show');
Route::post('/maintenance/user/update', 'Maintenance\UserMaintenanceCtr@update');
Route::post('/maintenance/user/delete/{empID}', 'Maintenance\UserMaintenanceCtr@destroy');

//MANAGE ONLINE ORDER-----------------------------------------------------------------------------------------------------
Route::get('/manageorder', 'ManageOnlineOrderCtr@index');
Route::get('/manageorder/pending', 'ManageOnlineOrderCtr@displayPendingOrder');
Route::get('/manageorder/processing', 'ManageOnlineOrderCtr@displayProcessingOrder');
Route::get('/manageorder/packed', 'ManageOnlineOrderCtr@displayPackedOrder');
Route::get('/manageorder/dispatch', 'ManageOnlineOrderCtr@displayDispatchOrder');
Route::get('/manageorder/delivered', 'ManageOnlineOrderCtr@displayDeliveredOrder');
Route::get('/manageorder/cancelled', 'ManageOnlineOrderCtr@displayCancelledOrder');
Route::post('/manageorder/pack_items/{order_no}', 'ManageOnlineOrderCtr@packItems');
Route::get('/manageorder/shippingfee/{order_id}', 'ManageOnlineOrderCtr@getShippingFee');
Route::get('/manageorder/discount/{order_id}', 'ManageOnlineOrderCtr@getDiscount');
Route::get('/manageorder/total_amount/{order_id}', 'ManageOnlineOrderCtr@getOrderTotalAmount');
Route::get('/manageorder/showitems/{order_no}', 'ManageOnlineOrderCtr@showOrderItems');
Route::get('/manageorder/customerinfo/{user_id}', 'ManageOnlineOrderCtr@getCustomerInfo');
Route::get('/manageorder/shippinginfo/{user_id}', 'ManageOnlineOrderCtr@getShippingInfo');
Route::get('/manageorder/salesinvoice/{user_id}/{discount}/{shipping_fee}', 'ManageOnlineOrderCtr@generateSalesInvoice');
Route::get('/manageorder/verification_info/{user_id}', 'ManageOnlineOrderCtr@verificationInfo');
Route::post('/manageorder/bulk_dispatch/{order_no}', 'ManageOnlineOrderCtr@bulkDispatch');
Route::post('/manageorder/bulk_delivered/{order_no}', 'ManageOnlineOrderCtr@bulkDelivered');

//VERIFY CUSTOMER---------------------------------------------------------------------------------------------------------
Route::get('/verifycustomer', 'VerifyCustomerCtr@index');
Route::get('/verifycustomer/verifiedcustomer', 'VerifyCustomerCtr@displayVerifiedCustomer');
Route::get('/verifycustomer/countforvalidation', 'VerifyCustomerCtr@countValidationCustomer');
Route::get('/verifycustomer/getverificationinfo/{cust_id}', 'VerifyCustomerCtr@getVerificationInfo');
Route::post('/verifycustomer/approve/{cust_id}', 'VerifyCustomerCtr@approve');
Route::post('/verifycustomer/decline/{cust_id}', 'VerifyCustomerCtr@decline');
Route::post('/verifycustomer/checkifverified/{cust_id}', 'VerifyCustomerCtr@checkIfVerified');
Route::post('/verifycustomer/bulkverified/{user_ids}', 'VerifyCustomerCtr@bulkVerified');

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
Route::get('/inventory/order/totalamount', 'Inventory\PurchaseOrderCtr@getTotalAmount');
Route::post('/inventory/order/remove/{product_code}', 'Inventory\PurchaseOrderCtr@removeProduct');
Route::get('/inventory/order/downloadOrderPDF', 'Inventory\PurchaseOrderCtr@downloadOrderPDF');
Route::get('/sendorder', 'Inventory\PurchaseOrderCtr@sendMail');
Route::post('/getSupplierEmail/{supplier_id}', 'Inventory\PurchaseOrderCtr@getSupplierEmail');
Route::post('/filterSupplier/{supplier_id}', 'Inventory\PurchaseOrderCtr@filterSupplier');
Route::post('/inventory/addRecord', 'Inventory\PurchaseOrderCtr@recordOrder');
Route::get('/inventory/displayReorders', 'Inventory\PurchaseOrderCtr@displayReorders');
Route::get('/inventory/displayOrders', 'Inventory\PurchaseOrderCtr@displayOrders');
Route::get('/inventory/po/get_po_supplier', 'Inventory\PurchaseOrderCtr@getPOSupplier');

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

//Drug Disposal
Route::get('/inventory/drugdisposal', 'Inventory\DrugDisposalCtr@index');
Route::delete('/inventory/drugdisposal/dispose/{id}', 'Inventory\DrugDisposalCtr@dispose');

//REPORTS---------------------------------------------------------------------------------------------------------------
Route::get('/reports/inventory', 'Reports\InventoryReportCtr@index');

Route::get('/reports/stockadjustment', 'Reports\StockAdjustmentReportCtr@index');

Route::get('/reports/purchasedorder', 'Reports\PurchasedOrderReportCtr@index');

Route::get('/reports/supplierdelivery', 'Reports\SupplierDeliveryReportCtr@index');

Route::get('/reports/returns', 'Reports\ReturnsReportCtr@index');

Route::get('/reports/reorder', 'Reports\ReOrderReportCtr@index');

Route::get('/reports/expired', 'Reports\ExpiredProductReportCtr@index');

Route::get('/reports/fastAndSlowMoving', 'Reports\FastAndSlowMovingReportCtr@index');

Route::get('/reports/audittrail', 'Reports\AuditTrailCtr@index');

//UTILITIES---------------------------------------------------------------------------------------------------------------
Route::get('/utilities/backup_restore', 'Utilities\BackupAndRestoreCtr@index');
Route::post('/utilities/backup_restore/backup', 'Utilities\BackupAndRestoreCtr@backup');
Route::post('/utilities/backup_restore/restore', 'Utilities\BackupAndRestoreCtr@restore');

Route::get('/utilities/archive', 'Utilities\ArchiveCtr@index');
Route::get('/utilities/archive/product', 'Utilities\ArchiveCtr@displayArchivedProduct');
Route::post('/utilities/archive/retrieve-product/{id}', 'Utilities\ArchiveCtr@retrieveProduct');
Route::post('/utilities/archive/bulk-retrieve-product/{id}', 'Utilities\ArchiveCtr@bulkRetrieveProduct');

Route::get('/utilities/archive/sales', 'Utilities\ArchiveCtr@displayArchivedSales');
Route::post('/utilities/archive/retrieve-sales/{id}', 'Utilities\ArchiveCtr@retrieveSales');




Route::get('/pages/404', 'Pages@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
