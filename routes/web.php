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
Route::get('orders/create', function () {
    return view('orders.form');
})->name('orders.create');

Route::get('/products', function(){
    return view('products.index');
})->name('products.index');
Route::get('/products/create', function(){
    return view('products.form');
})->name('products.create');
Route::get('/products/stocks', function(){
    return view('products.stock');
})->name('products.stock');


Route::get('/stocks', 'StockController@index');
Route::get('/stocks/data', 'StockController@data')->name('stocks.data');
Route::post('/stocks', 'StockController@store')->name('stocks.store');
Route::post('/stocks/{id}', 'StockController@update')->name('stocks.update');
Route::delete('/stocks/{id}', 'StockController@destroy')->name('stocks.destroy');
