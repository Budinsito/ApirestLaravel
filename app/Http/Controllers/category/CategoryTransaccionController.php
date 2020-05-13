<?php

namespace App\Http\Controllers\category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CategoryTransaccionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $transaccion = $category->products()
        ->whereHas('transaccions')//Si no tienen una transaccion no sera inlcuido en las transacciones
        ->with('transaccions')
        ->get()
        ->pluck('transaccions')
        ->collapse();
         return  $this->showAll($transaccion);
    }

 
}
