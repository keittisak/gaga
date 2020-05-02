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

Route::get('/layouts', function () {
    return view('layouts.app');
});

Route::get('orders', function () {
    return view('orders.index');
})->name('orders.index');

//Order
Route::get('/orders/create', 'OrderController@create')->name('orders.create');
Route::post('/orders', 'OrderController@store')->name('orders.store');
//Product
Route::get('/products', 'ProductController@index')->name('products.index');
Route::get('/products/data', 'ProductController@data')->name('products.data');
Route::get('/products/create', 'ProductController@create')->name('products.create');
Route::post('/products', 'ProductController@store')->name('products.store');
Route::get('/products/{id}', 'ProductController@show')->name('products.show');
Route::get('/products/{id}/edit', 'ProductController@edit')->name('products.edit');
Route::put('/products/{id}', 'ProductController@update')->name('products.update');
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
