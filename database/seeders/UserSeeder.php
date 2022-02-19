<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'username' => 'superadmin',
            'password' => '$2y$10$.f7nR8X0AzPC9zMLWDMcHeiNnZA0.hK.1OPlS/VJ.f280xm4jkHDu',
            'nama' => 'Muhammad Alfiansyah',
            'email' => 'iansyah@gmail.com',
            'telepon' => '082330538264',
            'alamat' => 'Karanganyar - Gumukmas - Jember',
            'id_bengkel' => '1',
            'level' => '1'
        ]);
    }
}
