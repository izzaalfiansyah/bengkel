<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    public $table = 'data_produk';

    public $fillable = [
        'nama',
        'deskripsi',
        'stok',
        'harga_jual',
        'harga_beli',
        'foto',
        'id_bengkel'
    ];

    public static function rules() {
        return [
            'nama' => 'required|max:50',
            'deskripsi' => 'required',
            'stok' => 'required|integer',
            'harga_jual' => 'required|integer',
            'harga_beli' => 'required|integer',
            'id_bengkel' => 'required|integer'
        ];
    }
}
