<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function transaksi($id)
    {
        $transaksi = new Api\TransaksiController;
        $data = $transaksi->show($id);
        
        return view('print.transaksi', ['data' => $data['data']]);
    }

    public function service($id)
    {
        $service = new Api\ServiceController;
        $data = $service->show($id);
        $service = $data['data'];

        $params = [
            'data' => $service,
            'total_produk' => 0,
            'total_jasa' => 0,
            'jumlah_jasa' => 0,
            'jumlah_produk' => 0
        ];

        echo '
        <style>
            hr {
                border-color: black;
            }

            .d-flex {
                display: flex;
                flex-wrap: wrap;
            }

            .table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 8px;
            }

            .table td, .table th {
                padding: 5px;
            }

            .table th {
                border-bottom: 2px solid black;
                border-top: 2px solid black;
            }
        </style>
        ';
        
        if ($service->status == '0') {
            echo view('print.service.estimasi', $params);
        } else if ($service->status == '1') {
            echo view('print.service.invoice', $params);
        } else {
            echo view('print.service.work_order', $params);
        }

        echo '
        <script>
            window.print();
            setTimeout(window.close, 4000);
        </script>
        ';
    }

    public function pelanggan()
    {
        $pelanggan = \App\Models\Pelanggan::all();

        return view('print.pelanggan', compact('pelanggan'));
    }
}