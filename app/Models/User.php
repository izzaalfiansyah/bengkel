<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $table = 'data_user';

    public $fillable = [
        'username',
        'password',
        'nama',
        'email',
        'telepon',
        'alamat',
        'id_bengkel',
        'level'
    ];

    public static function rules() {
        return [
            'username' => 'required|min:5|max:20',
            'nama' => 'required|max:50',
            'email' => 'required|max:100|email',
            'telepon' => 'required|max:50',
            'alamat' => 'nullable',
            'id_bengkel' => 'required|integer',
            'level' => 'required|in:1,2,3,4'
        ];
    }
}
