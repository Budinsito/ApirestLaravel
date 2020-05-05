<?php

namespace App\Http\Controllers\buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $product = $buyer->transaccions()->with('product')->get()->pluck('product');
        //pluck solo obtiene una parte de la coleccion completa ( En este caso es product)
        // dd($product);
        return $this->showAll($product);
    }

   
}
