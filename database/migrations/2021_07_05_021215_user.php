<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_user', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50);
            $table->string('password', 255);
            $table->string('nama', 50);
            $table->string('email', 100);
            $table->string('telepon', 50);
            $table->text('alamat')->nullable();
            $table->bigInteger('id_bengkel')->unsigned();
            $table->enum('level', [1, 2, 3, 4])->comment('1 = root, 2 = admin, 3 = pekerja, 4 = kasir');
            $table->timestamps();

            $table->foreign('id_bengkel', 'user_id_bengkel')->on('data_bengkel')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('data_user');
    }
}
