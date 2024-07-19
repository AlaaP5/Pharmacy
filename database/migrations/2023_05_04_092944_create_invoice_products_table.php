<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->id();
       $table->unsignedBigInteger('invoice_id');
       $table->unsignedBigInteger('product_id');
       $table->integer('quantity');
       $table->double('price')->nullable();
       $table->double('total_price')->nullable();
      $table->timestamps();

       $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
       $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_products');
    }
};
