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

Route::get('/artisan/storage', function() {
    $command = 'storage:link';
    $result = \Artisan::call($command);
    return \Artisan::output();
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/layouts', function () {
    return view('layouts.app');
});

//Order
Route::get('/orders', 'OrderController@index')->name('orders.index');
Route::get('/orders/data', 'OrderController@data')->name('orders.data');
Route::get('/orders/data/{id}', 'OrderController@getOrderById')->name('orders.by.id');
Route::get('/orders/overview', 'OrderController@overview')->name('orders.overview');
Route::get('/orders/create', 'OrderController@create')->name('orders.create');
Route::post('/orders', 'OrderController@store')->name('orders.store');
Route::patch('/orders/change-status', 'OrderController@changeStatus')->name('orders.status');
Route::get('/orders/print/label','OrderController@printLabel')->name('orders.print.label');
Route::get('/orders/print/label/to-text','OrderController@labelToText')->name('orders.print.label.to_text');
Route::get('/orders/print/list','OrderController@printList')->name('orders.print.list');
Route::get('/orders/{id}/edit', 'OrderController@edit')->name('orders.edit');
Route::put('/orders/{id}/update', 'OrderController@update')->name('orders.update');

//Product
Route::get('/products', 'ProductController@index')->name('products.index');
Route::get('/products/data', 'ProductController@data')->name('products.data');
Route::get('/products/create', 'ProductController@create')->name('products.create');
Route::post('/products', 'ProductController@store')->name('products.store');
Route::get('/products/{id}', 'ProductController@show')->name('products.show');
Route::get('/products/{id}/edit', 'ProductController@edit')->name('products.edit');
Route::put('/products/{id}', 'ProductController@update')->name('products.update');
Route::patch('/products/{id}', 'ProductController@changeStatus')->name('products.status');
Route::delete('/products/{id}', 'ProductController@destroy')->name('products.delete');
//Customer
Route::get('/customers', 'CustomerController@index')->name('customers.index');
Route::get('/customers/data', 'CustomerController@data')->name('customers.index');
Route::get('/customers/search-phone', 'CustomerController@searchPhone')->name('customers.search.phone');


Route::get('/stocks', 'StockController@index')->name('stocks.index');
Route::get('/stocks/data', 'StockController@data')->name('stocks.data');
Route::post('/stocks', 'StockController@store')->name('stocks.store');
Route::put('/stocks/{id}', 'StockController@update')->name('stocks.update');
Route::delete('/stocks/{id}', 'StockController@destroy')->name('stocks.destroy');

//Dashboard
Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

//Customer Portal
Route::get('/customer-portal/{id}', 'CustomerPortalController@index')->name('customerportal.index');

Route::get('/reset', function (){
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});
