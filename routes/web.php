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

Route::get('/clear-cache', function() {
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('config:clear');
	// $exitCode = Artisan::call('config:cache');
});

Route::resource('confirmcall', 'ajaxcrud\AjaxPostController');

Route::get('/phpinfo', function() {
	phpinfo();
});

Route::get('/updateapp', function()
{
    \Artisan::call('dump-autoload');
    echo 'dump-autoload complete';
});

Route::get('/', 'DashboardController@index')->middleware('auth');

Auth::routes();


Route::get('send','MailController@send');


Route::get("/email22", function() {
    Mail::raw('Now I know how to send emails with Laravel', function($message)
    {
        $message->subject('Hi There!!');
        $message->from(config('mail.from.address'), config("app.name"));
        $message->to('oladejisteven@gmail.com');
    });
});

Route::get('/dashboard', 'DashboardController@index');
// Route::get('/system-management/{option}', 'SystemMgmtController@index');
Route::get('/profile', 'ProfileController@index');


Route::resource('atmreport-management', 'CallLogController');
Route::get('logeco', 'CallLogController@createEco');
Route::post('logecosave', 'CallLogController@storeEco');
Route::get('listopencall', 'CallLogController@indexopencall');
Route::resource('confirmclosure', 'ConfirmClosureController');
Route::resource('partreplace-management', 'PartReplaceController');
//Route::resource('vendor-daily-report', 'VendorReportController');
Route::get('vendor-daily-report', 'VendorReportController@searchreporter');
Route::get('vendor-daily-report2', 'VendorReportController@searchreporterVendor');
Route::post('vendor-daily-report-view', 'VendorReportController@viewDailyReporter');

Route::get('sla-report-management', 'ServiceLevelAggrementController@searchslareport');
Route::post('view-sla-management', 'ServiceLevelAggrementController@viewSLAReport');

Route::get('search-management', 'CallLogController@searchreporter');
Route::post('atmviewreport-management', 'CallLogController@viewReporter');
Route::get('search-terminal', 'CallLogController@searchTerminal');
Route::post('viewterminalreport', 'CallLogController@viewTerminalReporter');

Route::get('uploadCall', 'CallLogController@uploadCallLog');
Route::post('uploadCallFile', 'CallLogController@uploadCallLogFile');

// POS ROUTES

Route::resource('posreport-management', 'PosLogController');
Route::get('poslogeco', 'PosLogController@createEco');
Route::post('poslogecosave', 'PosLogController@storeEco');
Route::get('poslistopencall', 'PosLogController@indexopencall');
//Route::resource('confirmclosure', 'ConfirmClosureController');
Route::get('possearch-management', 'PosLogController@searchreporter');
Route::post('posatmviewreport-management', 'PosLogController@viewReporter');
Route::get('possearch-terminal', 'PosLogController@searchTerminal');
Route::post('posviewterminalreport', 'PosLogController@viewTerminalReporter');

Route::get('posuploadCall', 'PosLogController@uploadCallLog');
Route::post('posuploadCallFile', 'PosLogController@uploadCallLogFile');
// end of Pos routes



Route::resource('atmdata-management', 'BankDataController');
Route::get('uploadATM', 'BankDataController@upload');
Route::post('uploadFile', 'BankDataController@uploadFile');
Route::resource('engineer-management', 'CustomerEngineerController');
Route::resource('vendordata-management', 'VendorDataController');
Route::resource('requester-management', 'RequesterController');
//Route::get('atmreport-management/checkin/{id}', 'CallLogController@checkIn')->name('atmreport-management.checkIn');
Route::resource('incidence-status','IncidenceStatusController');

Route::get('incidence-status-vendor2','IncidenceStatusController@index2');

Route::get('incidence-status-vendor','IncidenceStatusController@index22');
Route::get('assign-track-call','IncidenceStatusController@trackCall');
Route::post('incidence-status/changeStatus', array('as' => 'changeStatus', 'uses' => 'IncidenceStatusController@changeStatus'));

Route::resource('incidence-vendor','VendorIncidenceStatusController');
Route::get('incidence-vendor','VendorIncidenceStatusController@vendorIndex');
Route::post('incidence-vendor/changeStatus', array('as' => 'changeStatus', 'uses' => 'VendorIncidenceStatusController@changeStatus'));

Route::resource('sla-management','RulesController');
Route::resource('pm-management','PreventiveMentanaceController');
Route::get('pmcert','PreventiveMentanaceController@uploadPM');
Route::post('pmcert', 'PreventiveMentanaceController@upload');
Route::delete('pmcert/{id}', 'PreventiveMentanaceController@destroy');

Route::post('sla-management/changeStatusRule', array('as' => 'changeStatusRule', 'uses' => 'RulesController@changeStatus'));


Route::get('mail22', 'CallLogController@mail');


Route::get('pm-cert', 'VendorPMController@index');
Route::post('pm-cert', 'VendorPMController@upload');
Route::delete('pm-cert/{id}', 'VendorPMController@destroy');



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
Route::resource('vendor-management', 'BrandsController');
Route::post('vendor-management/search', 'BrandsController@search')->name('vendor-management.search');

//
//Route::resource('category-management', 'CategoriesController');
//Route::post('category-management/search', 'CategoriesController@search')->name('category-management.search');
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



Route::resource('product-management', 'ProductsController');
Route::post('product-management/search', 'ProductsController@search')->name('product-management.search');

Route::resource('stock-management', 'StocksController');
//Route::get('stock-management-create', 'StocksController@create1');
//Route::get('api/get-brand-list','StocksController@getList');
//Route::get('api/get-category-list','StocksController@getCategoryList');
Route::post('stock-management/search', 'StocksController@search')->name('stock-management.search');

//Route::get('shop-management', 'StocksController@shop');

Route::get('shop/shop/{id}', 'StocksController@show');



//Route::get('api/get-brand-list','StocksController@getList');
//Route::get('api/get-category-list','StocksController@getCategoryList');

Route::get('shop-management','StocksController@getStockList');
Route::get('api/get-state-list','StocksController@getBrandList');
Route::get('api/get-city-list','StocksController@getSupplierList');
Route::get('api/get-price-list','StocksController@getPriceList');

//Route::get('shop-management/cart','SalesController@getCart');
//Route::get('sale-management/sales','SalesController@storeSales');
Route::get('api/get-supplier-list','StocksController@getSuppliersList');




Route::post('carts','StocksController@addCart');



Route::get('test2', function()
{
    $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
    $beautymail->send('emails.welcome', [], function($message)
    {
        $message
            ->from('oladejisteven@gmail.com')
            ->to('oladejisteven@gmail.com', 'John Smith')
            ->subject('Welcome!');
    });

});




Route::resource('sale-management', 'SalesController');
//Route::post('sale-management/delete', 'SalesController@destroyCart');
//Route::get('sale-management/delete/{id}', 'SalesController@destroyCart');


Route::post('sale-management/search', 'SalesController@search')->name('sale-management.search');

Route::resource('account-management', 'PatientExpensesController');
Route::get('account-management/showQuick', 'PatientExpensesController@showQuick')->name('account-management.showQuick');
Route::post('account-management/save', 'PatientExpensesController@createPatientExpenses');

Route::post('account-management/search', 'PatientExpensesController@search')->name('account-management.search');

Route::post('account-management/topharmaccount', 'PatientExpensesController@toPharmAccount');
Route::post('account-management/acc', 'PatientExpensesController@storeCredit');


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

