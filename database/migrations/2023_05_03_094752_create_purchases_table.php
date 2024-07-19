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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('net_price');
            $table->integer('salling_price');
            $table->string('paracode')->nullable();
            $table->integer('quantity');
            $table->text('image')->nullable();
            $table->foreignId('category_id')
            -> constrained('categories')
          
            ->cascadeOnUpdate();
            $table->foreignId('supplier_id')
            -> constrained('suppliers')
          
            ->cascadeOnUpdate();
            $table->date('expiry_date');
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};
