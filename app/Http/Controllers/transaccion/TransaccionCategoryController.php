<?php

namespace App\Http\Controllers\transaccion;

use App\Http\Controllers\ApiController;
use App\Transaccion;
use Illuminate\Http\Request;

class TransaccionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaccion $transaccion)
    {
        $categories = $transaccion->product->categories;
        return $this->showAll($categories);
    }

   
}
