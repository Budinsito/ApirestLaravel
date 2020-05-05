<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaccions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity')->unsigned(); 
           /* $table->integer('buyer_id')->unsigned(); */
      /*      $table->integer('product_id')->unsigned(); */
            $table->timestamps();
            $table->unsignedBigInteger('buyer_id')->unsigned();
            $table->foreign('buyer_id')->references('id')->on('users');
            $table->unsignedBigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaccions');
    }
}
