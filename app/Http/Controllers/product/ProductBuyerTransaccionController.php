<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\User;
use App\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransaccionController extends ApiController
{
   
    public function store(Request $request, Product $product, User $buyer )
    {
       
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];
        $this->validate($request, $rules);

        // El comprador y el vendedor deben ser diferentes
        if($buyer->id == $product->seller_id){
            return  $this->errorResponse('El comprador debe ser diferente al vendedor', 404);
        }

        if(!$buyer->esverificado()){
            if($buyer->id == $product->seller_id){
            return  $this->errorResponse('El comprador debe ser un usuario verificado', 404);
            }
        }


        if(!$product->seller->esverificado()){
            return  $this->errorResponse('El vendedor debe ser un usuario verificado', 404);
        }
    
        if(!$product->estadodisponible()){
            return  $this->errorResponse('El producto para esta transaccion no esta disponible', 404);
        }

        //La cantidad no debe ser disponible a la cantidad requerida del producto
        if($product->quantity < $request->quantity){
            return  $this->errorResponse('El producto no tiene la cantidad disponible requerida para esa transaccion', 404);
        }
    
        return DB::transaction(function () use ($request, $product, $buyer){

// dd($request);
            
         // Reducir la cantidad disponible del producto
            $product->quantity -= $request->quantity;
            $product->save();
            // Si no se realiza bien la transaccion el producto se va a revertir
            // Se crea la instancia
            $transaccion = Transaccion::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,

            ]);

            
                return  $this->showOne($transaccion,201);
        });
}
}