<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id');
            $table->foreignId('category_id');
            $table->string('name');
            $table->string('description');
            $table->unsignedInteger('price');
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->string('image');
            $table->unsignedFloat('rating')->nullable();
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
        Schema::dropIfExists('products');
    }
}
