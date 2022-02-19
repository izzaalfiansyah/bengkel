<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller 
{
    public function __construct()
    {
        $this->app = json_decode(
            file_get_contents(
                public_path('/asset/json/app.json'), 
                false, 
                stream_context_create([
                    'ssl' => [ 'verify' => false, 'verify_peer' => false ]
                ])
            )
        );
    }

    public function index()
    {
        return [
            'error' => true,
            'data' => $this->app
        ];
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'number' => "required|max:50",
            'key' => "required",
            "pesan" => "required",
            'ppn' => 'required|integer|max:100',
            'pph' => 'required|integer|max:100'
        ]);

        if ($validation->fails()) {
            return [
                'error' => true,
                'message' => $validation->errors()->first()
            ];
        }

        $data = json_encode($validation->validate());
        file_put_contents(public_path('/asset/json/app.json'), $data);

        return [
            'error' => false,
            'message' => "data berhasil disimpan"
        ];
    }
}