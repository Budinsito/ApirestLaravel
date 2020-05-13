<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;

class SellerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $category =  $seller->products()
        ->whereHas('categories')
        ->get()
        ->pluck('categories')
        ->collapse()
        ->unique('id')
        ->values();
        return  $this->showAll($category);
    }

    
}
