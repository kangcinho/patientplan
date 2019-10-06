<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->string('idLog');
            $table->string('idUser')->nullable();
            $table->string('action');
            $table->string('idBukti')->nullable();
            $table->binary('valueBefore')->nullable();
            $table->binary('valueAfter')->nullable();
            $table->primary('idLog');
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
        Schema::dropIfExists('log');
    }
}
