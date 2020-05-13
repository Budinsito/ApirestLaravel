<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
             $product = $seller->products;
        return  $this->showAll($product);
    }
    public function store(Request $request, User $seller)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        $data['status'] = Product::PRODUCTO_NO_DISPONIBLE;
        $data['image'] = '1.jpg';
        $data['seller_id'] = $seller->id;
        $product = Product::create($data);
        return  $this->showOne($product,201);
    }

   
    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'quantity' => 'integer|min:1',
            'status' => 'in:' . Product::PRODUCTO_DISPONIBLE . ',' . Product::PRODUCTO_NO_DISPONIBLE,
            'image' => 'image',
        ];

        $this->validate($request,$rules);
        
         /*     if($seller->id != $product->seller_id){
            return $this->errorResponse('El vendedor especificado no es el vendedor real del producto',422);
        }*/

        $this->verificarVendedor($seller, $product);

        $product->fill($request->only([
            'name',
            'description',
            'quantity',
        ]));

        //La función has() se asegura de verificar si esa petición tiene presente en su lista de campos uno llamado status.

        if($request->has('status')){
            $product->status = $request->status;

            if($product->estadodisponible() && $product->categories()->count() == 0 ){
                return  $this->errorResponse('Un producto activo al menos debe tener una categoria',409);
            }
        }

        // la funcion isClean()  nos devuelve verdadero o falso si el modelo o el atributo permanecieron igual

        if($product->isClean()){
            return $this->errorResponse('Se debe especificar un valor diferente para actualizar',422);
        }
            $product->save();
            return  $this->showOne($product,201);
    }


    public function destroy(Seller $seller, Product $product)
    {
        $this->verificarVendedor($seller, $product);
        $product->delete();
        return  $this->showOne($product);
    }

    protected function verificarVendedor(Seller $seller, Product $product){

       if($seller->id != $product->seller_id){
            throw new HttpException(422,'El vendedor especificado no es el vendedor real del producto');
       /*     return $this->errorResponse('El vendedor especificado no es el vendedor real del producto',422);*/
        }

    }
}
