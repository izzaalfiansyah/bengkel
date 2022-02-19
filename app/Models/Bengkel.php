<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bengkel extends Model
{
    use HasFactory;

    public $table = 'data_bengkel';

    public $fillable = [
        'nama',
        'jam_buka',
        'jam_tutup',
        'alamat',
        'lokasi',
        'whatsapp',
        'foto'
    ];

    public static function rules() {
        return [
            'nama' => 'required|max:50',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'alamat' => 'required',
            'lokasi' => 'nullable',
            'whatsapp' => 'required',
            'foto' => 'nullable'
        ];
    }
}
