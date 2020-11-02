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

Route::get('/', 'DashboardController@index')->middleware('auth');

Auth::routes();


Route::get('/dashboard', 'DashboardController@index');
// Route::get('/system-management/{option}', 'SystemMgmtController@index');
Route::get('/profile', 'ProfileController@index');

Route::post('patient-management/search', 'PatientsController@search')->name('patient-management.search');
Route::resource('patient-management', 'PatientsController');
//Route::get('patient-management/update1', 'PatientsController@update1');
Route::get('patient-management/checkin/{id}', 'PatientsController@checkIn')->name('patient-management.checkIn');
Route::post('patient-management/save', 'PatientsController@updateCheckIn')->name('patient-management.updateCheckIn');


Route::resource('atmreport-management', 'CallLogController');
Route::resource('partreplace-management', 'PartReplaceController');
//Route::resource('vendor-daily-report', 'VendorReportController');
Route::get('vendor-daily-report2', 'VendorReportController@searchreporter');
Route::get('vendor-daily-report', 'VendorReportController@searchreporterVendor');
Route::post('vendor-daily-report-view', 'VendorReportController@viewDailyReporter');

Route::get('sla-report-management', 'ServiceLevelAggrementController@searchslareport');
Route::post('view-sla-management', 'ServiceLevelAggrementController@viewSLAReport');

Route::get('search-management', 'CallLogController@searchreporter');
Route::post('atmviewreport-management', 'CallLogController@viewReporter');
Route::get('search-terminal', 'CallLogController@searchTerminal');
Route::post('viewterminalreport', 'CallLogController@viewTerminalReporter');
Route::resource('atmdata-management', 'BankDataController');
Route::resource('engineer-management', 'CustomerEngineerController');
//Route::get('atmreport-management/checkin/{id}', 'CallLogController@checkIn')->name('atmreport-management.checkIn');
Route::resource('incidence-status','IncidenceStatusController');

Route::get('incidence-status-vendor2','IncidenceStatusController@index2');
Route::get('incidence-status-vendor','IncidenceStatusController@index22');
Route::get('assign-track-call','IncidenceStatusController@trackCall');
Route::post('incidence-status/changeStatus', array('as' => 'changeStatus', 'uses' => 'IncidenceStatusController@changeStatus'));

Route::resource('sla-management','RulesController');
Route::resource('pm-management','PreventiveMentanaceController');
Route::post('sla-management/changeStatusRule', array('as' => 'changeStatusRule', 'uses' => 'RulesController@changeStatus'));


Route::get('mail22', 'CallLogController@mail');


//
//
//Route::post('status-management/search', 'StatusesController@search')->name('status-management.search');
//Route::resource('status-management', 'StatusesController');
//Route::get('status-management/checkout/{id}', 'StatusesController@checkOut')->name('status-management.checkout');
//Route::post('status-management/save', 'StatusesController@updateCheckOut')->name('status-management.updateCheckOut');
//Route::post('status-management/goto', 'StatusesController@goToStatus')->name('status-management.goto');
//Route::post('status-management/checkout', 'StatusesController@updateCheckOut');
//
//
//Route::post('quickreg-management/search', 'QuickRegController@search')->name('quickreg-management.search');
//Route::resource('quickreg-management', 'QuickRegController');
//Route::get('quickreg-management/checkin/{id}', 'QuickRegController@checkIn')->name('quickreg-management.checkIn');
//Route::post('quickreg-management/save', 'QuickRegController@updateCheckIn')->name('quickreg-management.updateCheckIn');


Route::get('mail', function () {
//    return view('welcome');


    $data=[

        'title'=>'Hi I hope you like this course',
        'content'=> 'This laravel course was created with a lot of love'
    ];
    Mail::send('atmreport.index', $data, function ($message) {
        $message->to('oladejisteven@gmail.com', 'Stev000')->subject('Helo Saint');
    });

});


//
//Route::resource('brand-management', 'BrandsController');
//Route::post('brand-management/search', 'BrandsController@search')->name('brand-management.search');
//
//Route::resource('category-management', 'CategoriesController');
//Route::post('category-management/search', 'CategoriesController@search')->name('category-management.search');
//
//Route::resource('drug-strength', 'StrengthsController');
//Route::post('drug-strength/search', 'StrengthsController@search')->name('drug-strength.search');
//
//Route::resource('drug-presentation', 'DrugpresentationsController');
//Route::post('drug-presentation/search', 'DrugpresentationsController@search')->name('drug-presentation.search');
//
//Route::resource('doc-management', 'ConsultantsController');
//Route::post('doc-management/search', 'ConsultantsController@search')->name('doc-management.search');
//Route::post('doc-management/save', 'ConsultantsController@toBeAttendedTo');
//
//Route::get('doc-management2/auto', 'ConsultantsController@autocomplete');
//
//Route::get('select2-autocomplete', 'Select2AutocompleteController@layout');
////Route::get('select2-autocomplete-ajax', 'Select2AutocompleteController@dataAjax');
//Route::get('select2-autocomplete-ajax', ['as'=>'select2-autocomplete-ajax','uses'=>'Select2AutocompleteController@dataAjax']);
//
////Route::resource('autocomplete', 'AutocompleteController');
//Route::get('autocomplete2', 'AutocompleteController@index2');
//Route::get('ajax','AutocompleteController@ajax');
//
//Route::get('doc-managemen/autocomplete', 'AutocompleteController@index');
//Route::get('searchajax', ['as'=>'searchajax','uses'=>'AutocompleteController@searchResponse']);
//
//// AUTO ATM TERMINAL ID DISPLAY
Route::get('searchatm', ['as'=>'searchatm','uses'=>'CallLogController@searchResponse']);
//
//
//Route::resource('appointment-management', 'ConsultantAppointmentController');
//Route::post('appointment-management/search', 'ConsultantAppointmentController@search')->name('appointment-management.search');
//
//Route::resource('dental-management', 'DentalController');
//Route::post('dental-management/search', 'DentalController@search')->name('appointment-management.search');
//Route::post('dental-management/save', 'DentalController@toBeAttendedTo');


Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');
Route::resource('user-management', 'UserManagementController');

Route::post('supplier-management/search', 'SuppliersController@search')->name('supplier-management.search');
Route::resource('supplier-management', 'SuppliersController');

Route::resource('category-management', 'CategoriesController');
Route::post('category-management/search', 'CategoriesController@search')->name('category-management.search');

Route::resource('brand-management', 'BrandsController');
Route::post('brand-management/search', 'BrandsController@search')->name('brand-management.search');

Route::resource('product-management', 'ProductsController');
Route::post('product-management/search', 'ProductsController@search')->name('product-management.search');

Route::resource('stock-management', 'StocksController');
Route::get('stock-management-create', 'StocksController@create1');
Route::get('api/get-brand-list','StocksController@getList');
Route::get('api/get-category-list','StocksController@getCategoryList');
Route::post('stock-management/search', 'StocksController@search')->name('stock-management.search');

//Route::get('shop-management', 'StocksController@shop');

Route::get('shop/shop/{id}', 'StocksController@show');



Route::get('api/get-brand-list','StocksController@getList');
Route::get('api/get-category-list','StocksController@getCategoryList');

Route::get('shop-management','StocksController@getStockList');
Route::get('api/get-state-list','StocksController@getBrandList');
Route::get('api/get-city-list','StocksController@getSupplierList');
Route::get('api/get-price-list','StocksController@getPriceList');

//Route::get('shop-management/cart','SalesController@getCart');
//Route::get('sale-management/sales','SalesController@storeSales');
Route::get('api/get-supplier-list','StocksController@getSuppliersList');




Route::post('carts','StocksController@addCart');

Route::post('sale-management/save', 'SalesController@storeNotBillable');
Route::post('sale-management/save1', 'SalesController@storeBillable');
Route::post('sale-management/save2', 'SalesController@storeStockCE');

Route::resource('sale-management', 'SalesController');

//Route::get('system-management/report', 'SalesController@index');
Route::post('sale-management/report/search', 'SalesController@search')->name('reportSale.search');
Route::post('sale-management/report/excel', 'SalesController@exportSaleExcel')->name('reportSale.excel');
Route::post('sale-management/report/pdf', 'SalesController@exportSalePDF')->name('reportSale.pdf');








//Route::post('sale-management/delete', 'SalesController@destroyCart');
//Route::get('sale-management/delete/{id}', 'SalesController@destroyCart');

Route::post('sale-management/search', 'SalesController@search')->name('sale-management.search');






Route::resource('employee-management', 'EmployeeManagementController');
Route::post('employee-management/search', 'EmployeeManagementController@search')->name('employee-management.search');

Route::resource('system-management/department', 'DepartmentController');
Route::post('system-management/department/search', 'DepartmentController@search')->name('department.search');

Route::resource('system-management/division', 'DivisionController');
Route::post('system-management/division/search', 'DivisionController@search')->name('division.search');

Route::resource('system-management/country', 'CountryController');
Route::post('system-management/country/search', 'CountryController@search')->name('country.search');

Route::resource('system-management/state', 'StateController');
Route::post('system-management/state/search', 'StateController@search')->name('state.search');

Route::resource('system-management/city', 'CityController');
Route::post('system-management/city/search', 'CityController@search')->name('city.search');

Route::get('system-management/report', 'ReportController@index');
Route::post('system-management/report/search', 'ReportController@search')->name('report.search');
Route::post('system-management/report/excel', 'ReportController@exportExcel')->name('report.excel');
Route::post('system-management/report/pdf', 'ReportController@exportPDF')->name('report.pdf');

Route::get('avatars/{name}', 'EmployeeManagementController@load');

Route::get('/infos/{id}', 'CartController@getInfo');




Route::resource('cart', 'CartController');
Route::get('shop/proceed', 'CartController@proceed');
//Route::post('storeCart', 'CartController@storeCart');

Route::delete('emptyCart', 'CartController@emptyCart');
Route::post('switchToWishlist/{id}', 'CartController@switchToWishlist');

Route::resource('wishlist', 'WishlistController');
Route::delete('emptyWishlist', 'WishlistController@emptyWishlist');
Route::post('switchToCart/{id}', 'WishlistController@switchToCart');

//Route::resource('shop/proceed', 'SalesController');


Route::resource('invoices', 'InvoiceController');
Route::post('invoices/updateStatus/{id}', 'InvoiceController@updateStatus')->name('invoices.updateStatus');
Route::post('invoices/updateWHT/{id}', 'InvoiceController@updateWHT')->name('invoices.updateWHT');
Route::post('invoices-management/report/search', 'InvoiceController@search')->name('invoices.search');
Route::post('invoices-management/report/excel', 'InvoiceController@exportExcel')->name('invoices.excel');
Route::post('invoices-management/report/pdf', 'InvoiceController@exportPDF')->name('invoices.pdf');

//Route::get('pdfview/{$id}', 'InvoiceController@pdfview')->name('pdfview.pdf');

Route::get('pdfview',array('as'=>'pdfview','uses'=>'InvoiceController@pdfview'));
//Route::get('pdfview',array('as'=>'pdfview','uses'=>'InvoiceController@pdfview'));
//Route::get('htmltopdfview2',array('as'=>'htmltopdfview','uses'=>'ProductsController@htmltopdfview'));


Route::get('invoices/getPDF/{id}', 'InvoiceController@getPDF');
