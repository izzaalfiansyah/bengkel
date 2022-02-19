<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    public $table = 'data_transaksi';

    public $fillable = [
        'kode',
        'produk',
        'jasa',
        'total_harga',
        'total_bayar',
        'pajak_ppn',
        'pajak_pph',
        'grand_total',
        'status',
        'id_user',
        'id_pelanggan'
    ];

    public static function rules()
    {
        return [
            'kode' => 'nullable',
            'produk' => '',
            'jasa' => '',
            'total_harga' => 'required|integer',
            'total_bayar' => 'required|integer',
            'status' => 'required|in:1,0',
            'id_user' => 'required|integer',
            'id_pelanggan' => 'nullable|integer',
            'pajak_ppn' => 'nullable|integer',
            'pajak_pph' => 'nullable|integer',
            'grand_total' => 'nullable|integer'
        ];
    }

    public static function getKode()
    {
        $kode = date('Ymd-Hi');
        return 'TPO-' . $kode;
    }
}
