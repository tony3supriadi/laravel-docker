<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shopping_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->double('billing')->default(0);
            $table->double('payment')->default(0);
            $table->double('debit')->default(0);
            $table->text('description')->nullable();
            $table->foreign('shopping_id')->references('id')->on('shoppings');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
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
        Schema::dropIfExists('shopping_payments');
    }
}
