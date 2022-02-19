<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    use HasFactory;

    public $table = 'data_jasa';

    public $fillable = [
        'nama',
        'harga'
    ];

    public static function rules() {
        return [
            'nama' => 'required|max:50',
            'harga' => 'required|integer'
        ];
    }
}
