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
    return view('dashboard');
})->middleware('auth');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
// Route::get('/system-management/{option}', 'SystemMgmtController@index');
Route::get('/profile', 'ProfileController@index');

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
