<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shopping_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->double('price', 16, 0)->default(0);
            $table->integer('qty')->unsigned()->default(0);
            $table->double('sub_total')->default(0);
            $table->text('description')->nullable();
            $table->foreign('shopping_id')->references('id')->on('shoppings');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('shopping_items');
    }
}
