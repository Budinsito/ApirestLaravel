<?php

use Illuminate\Http\Request;


//Solo permitira index y Show dentro del controlador

//Buyers
Route::resource('buyers','buyer\BuyerController',['only' => ['index','show']]);
Route::resource('buyers.transaccions','buyer\BuyerTransaccionController',['only' => ['index']]);
Route::resource('buyers.products','buyer\BuyerProductController',['only' => ['index']]);
Route::resource('buyers.sellers','buyer\BuyerSellerControler',['only' => ['index']]);
Route::resource('buyers.categories','buyer\BuyerCategoryController',['only' => ['index']]);

//Categories
Route::resource('categories','category\CategoryController',['except' => ['create','edit']]);
Route::resource('categories.products','category\CategoryProductController',['only' => ['index']]);
Route::resource('categories.sellers','category\CategorySellerController',['only' => ['index']]);

//Products
Route::resource('products','product\ProductController',['only' => ['index','show']]);
//Transactions
Route::resource('transaccions','transaccion\TransaccionController',['only' => ['index','show']]);

Route::resource('transaccions.categories','transaccion\TransaccionCategoryController',['only' => ['index']]);

Route::resource('transaccions.sellers','transaccion\TransaccionSellerController',['only' => ['index']]);


//Sellers
Route::resource('sellers','seller\SellerController',['only' => ['index','show']]);
//Users
Route::resource('users','user\UserController',['except' => ['create','edit']]);