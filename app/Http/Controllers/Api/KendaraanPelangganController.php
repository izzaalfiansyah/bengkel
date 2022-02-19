<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\KendaraanPelanggan as Model;

class KendaraanPelangganController extends Controller
{
    public function index(Request $request)
    {
        $data = new Model();

        $data = $data->select('kendaraan_pelanggan.*');
        $data = $data->leftJoin('data_pelanggan', 'data_pelanggan.id', '=', 'kendaraan_pelanggan.id_pelanggan');
        $data = $data->orderBy('kendaraan_pelanggan.id', 'desc');

        if ($id_pelanggan = $request->id_pelanggan) {
            $data = $data->where('id_pelanggan', $id_pelanggan);
        }

        $recordTotal = count($data->get());
        $pageTotal = $request->limit ? ceil($recordTotal / $request->limit) : 0;

        if ($limit = $request->limit) {
            $data = $data->limit($limit)->offset($request->page ? $request->page * $limit - $limit : 0);
        }

        if ($search = $request->search) {
            $data = $data->where('merek', 'like', "%$search%");
            $data = $data->orWhere('brand', 'like', "%$search%");
            $data = $data->orWhere('nomor_plat', 'like', "%$search%");
            $data = $data->orWhere('data_pelanggan.nama', 'like', "%$search%");
        }

        $data = $data->get();

        foreach ($data as $key => $item) {
            $data[$key]->pelanggan = \App\Models\Pelanggan::find($item->id_pelanggan);
        }

        return [
            'error' => false,
            'data' => $data,
            'recordTotal' => $recordTotal,
            'pageTotal' => $pageTotal
        ];
    }

    public function show($id)
    {
        $data = Model::find($id);

        return [
            'error' => false,
            'data' => $data
        ];
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), Model::rules());

        if ($validation->fails()) {
            return [
                'error' => true,
                'message' => $validation->errors()->first()
            ];
        }

        $data = $validation->validate();
        Model::create($data);

        return [
            'error' => false,
            'message' => "data berhasil disimpan"
        ];
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), Model::rules());

        if ($validation->fails()) {
            return [
                'error' => true,
                'message' => $validation->errors()->first()
            ];
        }

        $data = $validation->validate();
        Model::find($id)->update($data);

        return [
            'error' => false,
            'message' => "data berhasil diedit"
        ];
    }

    public function destroy($id)
    {
        Model::destroy($id);

        return [
            'error' => false,
            'message' => "data berhasil dihapus"
        ];
    }
}
