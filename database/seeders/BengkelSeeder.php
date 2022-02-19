<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BengkelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Bengkel::create([
            'nama' => 'Fopegram',
            'jam_buka' => '08:00',
            'jam_tutup' => '15:00',
            'alamat' => 'Kencong - Jember',
            'whatsapp' => '082330538264'
        ]);
    }
}
