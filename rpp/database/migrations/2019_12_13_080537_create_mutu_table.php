<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mutuUmum');
            $table->integer('mutuIKS');
            $table->integer('mutuBPJS');
            $table->boolean('isAktif');
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
        Schema::dropIfExists('mutu');
    }
}
