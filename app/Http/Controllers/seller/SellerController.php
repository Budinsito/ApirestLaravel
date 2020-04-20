<?php

namespace App\Http\Controllers\seller;
use App\Seller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedores = Seller::has('products')->get();
        // return response()->json(['data' => $vendedores], 200);
        return $this->showAll($vendedores);
    }

   
    public function show(Seller $seller)
    {
        // $vendedor = Seller::has('products')->findOrFail($id);
       
        // return response()->json(['data' => $vendedor], 200);
        return $this->showOne($seller,200);

    }

   
}
