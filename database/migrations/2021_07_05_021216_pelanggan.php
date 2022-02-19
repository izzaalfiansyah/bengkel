<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pelanggan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_pelanggan', function(Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->text('alamat');
            $table->date('tanggal_lahir');
            $table->string('whatsapp', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('data_pelanggan');
    }
}
