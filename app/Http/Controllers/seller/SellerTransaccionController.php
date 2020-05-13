<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;

class SellerTransaccionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $transaccions = $seller->products()
        ->whereHas('transaccions')
        ->with('transaccions')
        ->get()
        ->pluck('transaccions')
        ->collapse();
        return  $this->showAll($transaccions);
}
}