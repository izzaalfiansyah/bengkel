<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teknisi extends Model
{
    use HasFactory;

    public $table = 'data_teknisi';

    public $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email'
    ];

    public $timestamps = false;

    public static function rules() {
        return [
            'nama' => 'required|max:50',
            'alamat' => 'required',
            'telepon' => 'required|numeric',
            'email' => 'nullable|email'
        ];
    }
}
