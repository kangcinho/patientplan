<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('idUser');
            $table->string('namaUser');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('canInsert')->default(0);
            $table->boolean('canUpdate')->default(0);
            $table->boolean('canDelete')->default(0);
            $table->boolean('canAdmin')->default(0);
            $table->boolean('canEkspor')->default(0);
            $table->boolean('isEdit')->default(0);
            $table->primary('idUser');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
