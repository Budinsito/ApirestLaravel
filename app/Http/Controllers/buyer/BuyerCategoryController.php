<?php

namespace App\Http\Controllers\buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
         $categories = $buyer->transaccions()->with('product.categories')->get()->pluck('product.categories')->collapse()
        ->unique('id')
        ->values();
    // dd($categories);
    return  $this->showAll($categories);
    //Collapse toma toda una serie de lista y convierte en una sola
    }

   
}
