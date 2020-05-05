<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class productController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return $this->showAll($product);

    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->showOne($product,200);
    }

  
}
