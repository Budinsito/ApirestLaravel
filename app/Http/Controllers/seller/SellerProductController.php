<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Storage;

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
        // Aca lo guarda y le da automaticamente un nombre aleatorio al archivo
        $data['image'] = $request->image->store('');
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
        // Verificamos si recibimos un archivo llamado image
            if ($request->hasfile('image')){
                //Si recibimos el archivo lo eliminamos
                Storage::delete($product->image);
                //Despues actualizamos el nombre del nuevo archivo que vamos a recibir actual
                $product->image = $request->image->store('');
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
        //Elimina el archivo fisico de la tabla img
        Storage::delete($product->image);
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
