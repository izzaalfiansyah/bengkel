<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Kas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kas', function (Blueprint $table) {
            $table->id();
            $table->text('deskripsi');
            $table->integer('jumlah');
            $table->enum('tipe', [1, 0])->comment('1 = masuk, 2 = keluar');
            $table->bigInteger('id_user')->unsigned();
            $table->timestamps();

            $table->foreign('id_user', 'kas_id_user')->on('data_user')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('data_kas');
    }
}
