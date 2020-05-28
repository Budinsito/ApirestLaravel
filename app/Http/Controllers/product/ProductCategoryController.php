<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $category = $product->categories;
        return  $this->showAll($category);
    }

    public function update(Request $request, Product $product, Category $category)
    {
        //sync, => Reemplaza los items
        //attach => Agrega los items sean repetidos o no //syncWithoutDetaching => Agrega los items mas no los repite
        $product->categories()->syncWithoutDetaching([$category->id]);
        return  $this->showAll($product->categories);
    }


    public function destroy(Product $product, Category $category)
    {
        if(!$product->categories()->find($category->id))
            {
                return  $this->errorResponse('La categoria especificada no es una categoria de este producto', 404);
            }

        $product->categories()->detach([$category->id]);
        return  $this->showAll($product->categories);
    }
}
