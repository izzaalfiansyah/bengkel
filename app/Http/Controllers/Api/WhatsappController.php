<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WhatsappController extends Controller
{
    public function __construct()
    {
        $this->whatsapp = json_decode(
            file_get_contents(
                public_path('/asset/json/app.json'), 
                false, 
                stream_context_create([
                    'ssl' => [ 'verify' => false, 'verify_peer' => false ]
                ])
            )
        );
    }

    public function index() {
        $data = $this->whatsapp;

        return [
            'error' => false,
            'data' => $data
        ];
    }

    public function send(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'message' => 'required',
            'to' => 'required'
        ]);

        if ($validation->fails()) {
            return [
                'error' => true,
                'message' => $validation->errors()->first()
            ];
        }

        $curl = curl_init();

        $message = $request->message;
        $to = $request->to[0] == '0' ? '62' . substr($request->to, 1) : $request->to;

        $url = 'https://starsender.online/api';
        $url .= ($request->file) ? '/sendFiles' : '/sendText';
        $url .= '?message=```' . rawurlencode($message) . '```';
        $url .= '&tujuan=' . rawurlencode($to) . '@s.whatsapp.net';

        $curl_option = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $this->whatsapp->key
            ]
        ];

        if ($request->file) {
            $curl_option[CURLOPT_POSTFIELDS] = ['file' => $request->file];
        }

        curl_setopt_array($curl, $curl_option);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return [
                'error' => true,
                'message' => curl_error($curl)
            ];
        }

        curl_close($curl);
        
        return [
            'error' => false,
            'message' => "pesan whatsapp berhasil dikirim"
        ];
    }
}
