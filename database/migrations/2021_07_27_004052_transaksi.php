<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->text('produk');
            $table->text('jasa');
            $table->integer('total_harga');
            $table->integer('total_bayar');
            $table->enum('status', ['1', '0'])->comment('1 = selesai, 0 = belum')->default('0');
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('id_pelanggan')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('id_user', 'transaksi_id_user')->on('data_user')->references('id');
            $table->foreign('id_pelanggan', 'transaksi_id_pelanggan')->on('data_pelanggan')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('data_transaksi');
    }
}
