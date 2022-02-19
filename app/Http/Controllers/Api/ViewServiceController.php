<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\WorkOrder;
use App\Models\Estimasi;
use Illuminate\Http\Request;

class ViewServiceController extends Controller
{
    public function estimasi(Request $request)
    {
        $data = $this->builder(new Estimasi, 'estimasi', $request);
        return $data;
    }

    public function invoice(Request $request)
    {
        $data = $this->builder(new Invoice, 'invoice', $request);
        return $data;
    }
    
    public function workOrder(Request $request)
    {
        $data = $this->builder(new WorkOrder, 'work_order', $request);
        return $data;
    }

    private function builder($builder, $table, $request) {

        $builder = $builder->select("data_$table.*");
        $builder = $builder->leftJoin('kendaraan_pelanggan', 'kendaraan_pelanggan.id', '=',  "data_$table.id_kendaraan_pelanggan");
        $builder = $builder->orderBy("data_$table.created_at", 'desc');

        if ($id_user = $request->id_user) {
            $builder = $builder->where("data_$table.id_user", $id_user);
        }

        $recordTotal = count($builder->get());
        $pageTotal = $request->limit ? ceil($recordTotal / $request->limit) : 0;

        if ($limit = $request->limit) {
            $builder = $builder->limit($limit)->offset($request->page ? $request->page * $limit - $limit : 0);
        }

        if ($search = $request->search) {
            $builder = $builder->where('kode', 'like', "%$search%");
            $builder = $builder->orWhere('kendaraan_pelanggan.merek', 'like', "%$search%");
            $builder = $builder->orWhere('kendaraan_pelanggan.brand', 'like', "%$search%");
        }

        $data = $builder->get();

        foreach ($data as $key => $item) {
            $data[$key]->kode = strtoupper(substr($table, 0, 2)) . substr($item->kode, 2);
            $data[$key]->user = \App\Models\User::find($item->id_user);
            $data[$key]->transaksi = \App\Models\Transaksi::find($item->id_transaksi);
            $data[$key]->kendaraan = \App\Models\KendaraanPelanggan::find($item->id_kendaraan_pelanggan);
        }

        return [
            'error' => false,
            'data' => $data,
            'recordTotal' => $recordTotal,
            'pageTotal' => $pageTotal
        ];
    }
}
