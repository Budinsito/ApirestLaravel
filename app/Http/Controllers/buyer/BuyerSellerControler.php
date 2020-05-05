<?php

namespace App\Http\Controllers\buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerSellerControler extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        
    $seller = $buyer->transaccions()->with('product.seller')->get()->pluck('product.seller')
    ->unique('id')
    ->values();

    // dd($seller);

    return  $this->showAll($seller);
    }

 
}
