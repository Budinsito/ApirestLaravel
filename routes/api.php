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
Route::resource('categories.transaccions','category\CategoryTransaccionController',['only' => ['index']]);
Route::resource('categories.buyers','category\CategoryBuyerController',['only' => ['index']]);

//Products
Route::resource('products','product\ProductController',['only' => ['index','show']]);
Route::resource('products.transaccions','product\ProductTransaccion',['only' => ['index']]);
Route::resource('products.buyers','product\ProductBuyerController',['only' => ['index']]);
Route::resource('products.categorys','product\ProductCategoryController',['only' => ['index','update','destroy']]);
Route::resource('products.buyers.transaccions','product\ProductBuyerTransaccionController',['only' => ['store']]);



//Transactions
Route::resource('transaccions','transaccion\TransaccionController',['only' => ['index','show']]);

Route::resource('transaccions.categories','transaccion\TransaccionCategoryController',['only' => ['index']]);

Route::resource('transaccions.sellers','transaccion\TransaccionSellerController',['only' => ['index']]);


//Sellers
Route::resource('sellers','seller\SellerController',['only' => ['index','show']]);
Route::resource('sellers.transaccions','seller\SellerTransaccionController',['only' => ['index']]);
Route::resource('sellers.categories','seller\SellerCategoryController',['only' => ['index']]);
Route::resource('sellers.buyers','seller\SellerBuyerController',['only' => ['index']]);
Route::resource('sellers.products','seller\SellerProductController',['except' => ['create','show','edit']]);
//Users
Route::resource('users','user\UserController',['except' => ['create','edit']]);
//Implementacion de la ruta de verificacion de correos
Route::name('verify')->get('users/verify/{token}', 'user/UserController@verify');

