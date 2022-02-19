<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Supplier as Model;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $data = new Model();

        $data = $data->orderBy('data_supplier.id', 'desc');

        $recordTotal = count($data->get());
        $pageTotal = $request->limit ? ceil($recordTotal / $request->limit) : 0;

        if ($limit = $request->limit) {
            $data = $data->limit($limit)->offset($request->page ? $request->page * $limit - $limit : 0);
        }

        if ($search = $request->search) {
            $data = $data->where('nama', 'like', "%$search%");
            $data = $data->orWhere('harga', 'like', "%$search%");
            $data = $data->orWhere('alamat', 'like', "%$search%");
        }

        $data = $data->get();

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
