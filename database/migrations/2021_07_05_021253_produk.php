<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Produk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_produk', function(Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->text('deskripsi');
            $table->integer('stok');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->text('foto');
            $table->bigInteger('id_bengkel')->unsigned();
            $table->timestamps();

            $table->foreign('id_bengkel', 'produk_id_bengkel')->on('data_bengkel')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('data_produk');
    }
}
