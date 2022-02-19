<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\KasController as Kas;
use App\Http\Controllers\Api\TransaksiController as Transaksi;

class ExcelController extends Controller
{
    public function export($tipe = '')
    {
        $date = date('Y-m-d');

        header('Content-Type: application/vnd-ms-excel');
        header('Content-Disposition: attachment; filename=Laporan ' . $tipe . ' ' . $date . '.xls');
    }

    public function kas(Request $req)
    {
        $kas = new Kas;

        $data = $kas->report($req)['data'];
        
        $this->export('Kas');
        echo view('excel/kas', compact('data'));
    }
    
    public function produk(Request $req)
    {
        $transaksi = new Transaksi;
        
        $data = $transaksi->produk($req)['data'];
        
        $this->export('Penjualan Produk');
        echo view('excel/produk', compact('data'));
    }
    
    public function jasa(Request $req)
    {
        $transaksi = new Transaksi;
        
        $this->export('Pemakaian Jasa');
        $data = $transaksi->jasa($req)['data'];

        echo view('excel/jasa', compact('data'));
    }
}
