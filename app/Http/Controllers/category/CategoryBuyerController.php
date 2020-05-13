<?php

namespace App\Http\Controllers\category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CategoryBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $buyers = $category->products()
        ->whereHas('transaccions')
        ->with('transaccions.buyer')
        ->get()
         ->pluck('transaccions')
        ->collapse()
         ->pluck('buyer')
        ->unique()
        ->values();
        return  $this->showAll($buyers);
    }

}
