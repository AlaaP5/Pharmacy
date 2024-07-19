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
        Schema::create('debt_records', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->unique();
            $table->integer('debt_value');
            $table->foreignId('invoice_id')
            ->nullable();
            $table->date('debt_date');
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
        Schema::dropIfExists('debt_records');
    }
};
