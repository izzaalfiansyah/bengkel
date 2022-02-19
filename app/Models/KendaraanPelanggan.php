<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanPelanggan extends Model
{
    use HasFactory;

    public $table = 'kendaraan_pelanggan';
    
    public $timestamps = false;

    public $fillable = [
        'merek',
        'brand',
        'tahun',
        'warna',
        'nomor_rangka',
        'nomor_mesin',
        'nomor_plat',
        'deskripsi',
        'service',
        'id_pelanggan'
    ];

    public static function rules() {
        return [
            'merek' => 'required|max:50',
            'brand' => 'required|max:50',
            'tahun' => 'required',
            'warna' => 'required|max:50',
            'nomor_rangka' => 'nullable|max:50',
            'nomor_mesin' => 'nullable|max:50',
            'nomor_plat' => 'required|max:50',
            'deskripsi' => 'required',
            'service' => 'required',
            'id_pelanggan' => 'required|integer'
        ];
    }
}
