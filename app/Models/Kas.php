<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;

    public $table = 'data_kas';

    public $fillable = [
        'deskripsi',
        'jumlah',
        'tipe',
        'id_user'
    ];

    public static function rules()
    {
        return [
            'deskripsi' => 'required',
            'jumlah' => 'required|integer',
            'tipe' => 'required|in:1,0',
            'id_user' => 'required'
        ];
    }
}
