<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('group_id')->unsigned()->default(1);
            $table->string('name', 128);
            $table->text('address')->nullable();
            $table->bigInteger('regency_id')->nullable();
            $table->bigInteger('province_id')->nullable();
            $table->string('postcode', 8)->nullable();
            $table->string('email', 128)->nullable();
            $table->string('phone', 32)->nullable();
            $table->text('description')->nullable();
            $table->double('saldo_tabungan', 16, 0)->default(0);
            $table->foreign('group_id')->references('id')->on('customer_groups');
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
        Schema::dropIfExists('customers');
    }
}
