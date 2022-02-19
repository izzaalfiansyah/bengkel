<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Bengkel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_bengkel', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->text('alamat');
            $table->text('lokasi')->nullable();
            $table->string('whatsapp', 50);
            $table->string('foto', 50)->nullable();
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
        Schema::drop('data_bengkel');
    }
}
