<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    public $table = 'data_supplier';

    public $timestamps = false;

    public $fillable = [
        'nama',
        'kontak',
        'alamat'
    ];

    public static function rules() {
        return [
            'nama' => 'required|max:50',
            'kontak' => 'required|max:50',
            'alamat' => 'required'
        ];
    }
}
