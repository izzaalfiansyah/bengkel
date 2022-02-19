<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    public $table = 'data_pelanggan';
    
    public $timestamps = false;

    public $fillable = [
        'nama',
        'alamat',
        'tanggal_lahir',
        'whatsapp'
    ];

    public static function rules() {
        return [
            'nama' => 'required|max:50',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'whatsapp' => 'required|max:50'
        ];
    }
}
