<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->string('idPasien');
            $table->string('noreg');
            $table->date('tanggal');
            $table->string('nrm');
            $table->string('namaPasien');
            $table->string('kamar');
            $table->time('waktuVerif')->nullable();
            $table->time('waktuIKS')->nullable();
            $table->time('waktuSelesai')->nullable();
            $table->time('waktuPasien')->nullable();
            $table->time('waktuLunas')->nullable();
            $table->string("petugasFO")->nullable();
            $table->string("petugasPerawat")->nullable();
            $table->text('keterangan');
            $table->bigInteger('idUser')->unsigned();
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
        Schema::dropIfExists('pasien');
    }
}
