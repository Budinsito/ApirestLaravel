<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Product;
use App\Transaccion;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

    	//Desactivamos la verificacion de las claves foraneas
    DB::statement('SET FOREIGN_KEY_CHECKS = 0');
     User::truncate();
     Category::truncate();
     Product::truncate();
     Transaccion::truncate();
     DB::table('category_product')->truncate();
     // Establecemos la cantidad 
     $cantidadUsuarios = 1000;
     $cantidadCategorias = 30;
     $cantidadProductos = 1000;
     $cantidadTransacciones = 1000;

     factory(User::class, $cantidadUsuarios)->create();
     factory(Category::class, $cantidadCategorias)->create();

     factory(Product::class, $cantidadTransacciones)->create()->each(
     		function($producto){

     			//Obtenemos las categorias aleatoriamente
     			$categorias = Category::all()->random(mt_rand(1,5))->pluck('id');
     			$producto->categories()->attach($categorias);
     		}


     );

     factory(Transaccion::class, $cantidadTransacciones)->create();

    }
}
