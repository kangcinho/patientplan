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
            $table->datetime('tanggal');
            $table->string('nrm');
            $table->string('namaPasien');
            $table->string('kamar');
            $table->datetime('waktuVerif')->nullable();
            $table->datetime('waktuIKS')->nullable();
            $table->datetime('waktuSelesai')->nullable();
            $table->datetime('waktuPasien')->nullable();
            $table->datetime('waktuLunas')->nullable();
            $table->string("petugasFO")->nullable();
            $table->string("petugasPerawat")->nullable();
            $table->text('keterangan');
            $table->boolean('isEdit')->default(false);
            $table->string('idUser')->nullable();
            $table->primary('idPasien');
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
