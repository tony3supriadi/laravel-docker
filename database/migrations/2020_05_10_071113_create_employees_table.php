<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_id')->unsigned();
            $table->string('name', 128);
            $table->string('birthplace', 32)->nullable();
            $table->date('birthdate')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('regency_id')->nullable();
            $table->bigInteger('province_id')->nullable();
            $table->string('postcode', 8)->nullable();
            $table->string('email', 128)->nullable();
            $table->string('phone', 32)->nullable();
            $table->double('salary', 16, 0)->nullable();
            $table->text('description')->nullable();
            $table->foreign('branch_id')->references('id')->on('branchs');
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
        Schema::dropIfExists('employees');
    }
}
