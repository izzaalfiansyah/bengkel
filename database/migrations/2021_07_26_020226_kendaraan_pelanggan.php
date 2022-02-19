<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KendaraanPelanggan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kendaraan_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('merek', 50);
            $table->string('brand', 50);
            $table->year('tahun', 50);
            $table->string('warna', 50);
            $table->string('nomor_rangka', 50)->nullable();
            $table->string('nomor_mesin', 50)->nullable();
            $table->string('nomor_plat', 50);
            $table->text('deskripsi');
            $table->bigInteger('id_pelanggan')->unsigned();

            $table->foreign('id_pelanggan', 'kendaraan_pelanggan_id_pelanggan')->on('data_pelanggan')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('kendaraan_pelanggan');
    }
}
