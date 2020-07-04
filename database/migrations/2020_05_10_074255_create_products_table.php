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
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('unit_id')->unsigned();
            $table->string('code')->unique();
            $table->string('name');
            $table->double('purchase_price', 16, 0)->nullable();
            $table->double('price', 16, 0)->nullable();
            $table->integer('stock')->unsigned()->default(0);
            $table->integer('stockmin')->unsigned()->default(0);
            $table->text('description')->nullable();
            $table->foreign('category_id')->references('id')->on('product_categories');
            $table->foreign('unit_id')->references('id')->on('product_units');
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
