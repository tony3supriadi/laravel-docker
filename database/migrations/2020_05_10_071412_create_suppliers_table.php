<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_id')->unsigned();
            $table->string('name', 128);
            $table->text('address')->nullable();
            $table->bigInteger('regency_id')->nullable();
            $table->bigInteger('province_id')->nullable();
            $table->string('postcode', 8)->nullable();
            $table->string('email', 128)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('telp', 32)->nullable();
            $table->string('faxmail', 32)->nullable();
            $table->bigInteger('bank_id')->unsigned();
            $table->string('bank_number', 64)->nullable();
            $table->string('bank_account', 64)->nullable();
            $table->text('description')->nullable();
            $table->foreign('branch_id')->references('id')->on('branchs');
            $table->foreign('bank_id')->references('id')->on('banks');
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
        Schema::dropIfExists('suppliers');
    }
}
