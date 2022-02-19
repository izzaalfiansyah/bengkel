<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Bengkel as Model;

class BengkelController extends Controller
{
    public function index(Request $request)
    {
        $data = new Model();

        $recordTotal = count($data->get());
        $pageTotal = $request->limit ? ceil($recordTotal / $request->limit) : 0;

        if ($limit = $request->limit) {
            $data = $data->limit($limit)->offset($request->page ? $request->page * $limit - $limit : 0);
        }

        if ($search = $request->search) {
            $data = $data->where('nama', 'like', "%$search%");
            $data = $data->orWhere('jam_buka', 'like', "%$search%");
            $data = $data->orWhere('jam_tutup', 'like', "%$search%");
            $data = $data->orWhere('alamat', 'like', "%$search%");
            $data = $data->orWhere('whatsapp', 'like', "%$search%");
        }

        $data = $data->get();

        foreach ($data as $key => $item) {
            if ($item->lokasi) {
                $lokasi = explode(',', str_replace(' ', '', $item->lokasi));
                $data[$key]->lat = $lokasi[0];
                $data[$key]->lng = $lokasi[1];
            }
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
        
        if ($data->lokasi) {
            $lokasi = explode(',', str_replace(' ', '', $data->lokasi));
            $data->lat = $lokasi[0];
            $data->lng = $lokasi[1];
        }

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

        if ($request->foto && $foto = explode(';base64,', $request->foto)[1]) {
            $foto_nama = $this->random() . '.jpg';
            file_put_contents(public_path('asset/bengkel/' . $foto_nama), base64_decode($foto));
            $data['foto'] = $foto_nama;
        }

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

        if ($request->foto && $foto = explode(';base64,', $request->foto)[1]) {
            $foto_nama = $this->random() . '.jpg';
            file_put_contents(public_path('asset/bengkel/' . $foto_nama), base64_decode($foto));
            $data['foto'] = $foto_nama;

            if ($foto = Model::find($id)->foto) {
                unlink(public_path('asset/bengkel/' . $foto));
            }
        }

        Model::find($id)->update($data);

        return [
            'error' => false,
            'message' => "data berhasil diedit"
        ];
    }

    public function destroy($id)
    {
        if ($foto = Model::find($id)->foto) {
            unlink(public_path('asset/bengkel/' . $foto));
        }

        Model::destroy($id);

        return [
            'error' => false,
            'message' => "data berhasil dihapus"
        ];
    }
}
