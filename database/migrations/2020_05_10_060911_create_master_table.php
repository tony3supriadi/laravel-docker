<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('regencies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provincy_id')->unsigned();
            $table->string('name');
            $table->foreign('provincy_id')->references('id')->on('provinces');
        });

        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('code', 16)->unique();
            $table->string('name')->nullablle();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regencies');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('banks');
    }
}
