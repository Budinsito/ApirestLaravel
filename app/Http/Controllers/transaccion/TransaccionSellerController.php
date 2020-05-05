<?php

namespace App\Http\Controllers\transaccion;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transaccion;

class TransaccionSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaccion $transaccion)
    {
        $seller = $transaccion->product->seller;
        return $this->showOne($seller);
    }

   
}
