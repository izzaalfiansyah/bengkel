<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Service extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_service', function(Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->text('keluhan');
            $table->text('perintah_kerja')->nullable();
            $table->enum('status', ['0', '1', '2'])->comment('0 = menunggu, 1 = sedang dikerjakan, 2 = selesai')->default('0');
            $table->integer('total_harga');
            $table->integer('total_bayar');
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('id_transaksi')->unsigned()->nullable();
            $table->bigInteger('id_kendaraan_pelanggan')->unsigned();
            $table->timestamps();

            $table->foreign('id_user', 'service_id_user')->on('data_user')->references('id');
            $table->foreign('id_transaksi', 'service_id_transaksi')->on('data_transaksi')->references('id');
            $table->foreign('id_kendaraan_pelanggan', 'service_id_kendaraan_pelanggan')->on('kendaraan_pelanggan')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('data_service');
    }
}
