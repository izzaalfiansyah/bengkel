<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public $table = 'data_service';

    public $fillable = [
        'kode',
        'keluhan',
        'perintah_kerja',
        'total_harga',
        'total_bayar',
        'status',
        'status_pengerjaan',
        'id_user',
        'id_teknisi',
        'id_transaksi',
        'id_kendaraan_pelanggan'
    ];

    public static function rules()
    {
        return [
            'kode' => 'nullable',
            'keluhan' => 'required',
            'perintah_kerja' => 'nullable',
            'total_harga' => 'nullable|integer',
            'total_bayar' => 'nullable|integer',
            'status' => 'required|in:0,1,2',
            'status_pengerjaan' => 'nullable|in:0,1,2',
            'id_user' => 'nullable|integer',
            'id_teknisi' => 'nullable|integer',
            'id_transaksi' => 'nullable|integer',
            'id_kendaraan_pelanggan' => 'required|integer'
        ];
    }

    public static function getKode()
    {
        $kode = date('Ymd-Hi');
        return 'PS-' . $kode;
    }
}
