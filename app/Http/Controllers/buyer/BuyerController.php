<?php

namespace App\Http\Controllers\buyer;
use App\Buyer;
// use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

// class BuyerController extends Controller
class BuyerController extends ApiController
{
    
    public function index()
    {
        $compradores = Buyer::has('transaccions')->get();
        // return response()->json(['data' => $compradores], 200);
        return $this->showAll($compradores);

    }



    public function show(Buyer $buyer)
    {
        // $compradores = Buyer::has('transaccions')->findOrFail($id);
       
        // return response()->json(['data' => $compradores], 200);
        return $this->showOne($buyer,200);
    }

  
}
