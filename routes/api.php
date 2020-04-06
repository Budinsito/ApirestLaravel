<?php

use Illuminate\Http\Request;


//Solo permitira index y Show dentro del controlador

//Buyers
Route::resource('buyers','buyer\BuyerController',['only' => ['index','show']]);
//Categories
Route::resource('categories','category\CategoryController',['except' => ['create','edit']]);
//Products
Route::resource('products','product\ProductController',['only' => ['index','show']]);
//Transactions
Route::resource('transaccions','transaccion\TransaccionController',['only' => ['index','show']]);
//Sellers
Route::resource('sellers','seller\SellerController',['only' => ['index','show']]);
//Users
Route::resource('users','user\UserController',['except' => ['create','edit']]);