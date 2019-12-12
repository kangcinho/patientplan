<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalisaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analisa', function (Blueprint $table) {
            $table->string('analisaID');
            $table->date('tanggal');
            $table->string('jenisKerjasama');
            $table->int('jumlahMutuValid');
            $table->int('jumlahMutuNonValid');
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
        Schema::dropIfExists('analisa');
    }
}
