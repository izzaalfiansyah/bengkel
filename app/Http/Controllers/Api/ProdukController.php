<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Produk as Model;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $data = new Model();

        $data = $data->select('data_produk.*');
        $data = $data->leftJoin('data_bengkel', 'data_bengkel.id', '=', 'data_produk.id_bengkel');
        $data = $data->orderBy('data_produk.id', 'desc');

        if ($id_bengkel = $request->id_bengkel) {
            $data = $data->where('id_bengkel', $id_bengkel);
        }

        $recordTotal = count($data->get());
        $pageTotal = $request->limit ? ceil($recordTotal / $request->limit) : 0;

        if ($limit = $request->limit) {
            $data = $data->limit($limit)->offset($request->page ? $request->page * $limit - $limit : 0);
        }

        if ($search = $request->search) {
            $data = $data->where('data_produk.nama', 'like', "%$search%");
            $data = $data->orWhere('data_bengkel.nama', 'like', "%$search%");
            $data = $data->orWhere('deskripsi', 'like', "%$search%");
            $data = $data->orWhere('stok', 'like', "%$search%");
            $data = $data->orWhere('harga_jual', 'like', "%$search%");
            $data = $data->orWhere('harga_beli', 'like', "%$search%");
        }

        $data = $data->get();

        foreach ($data as $key => $item) {
            $data[$key]->foto = unserialize($item->foto);
            $data[$key]->bengkel = \App\Models\Bengkel::find($item->id_bengkel);
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

        if ($data) {
            $data->foto = unserialize($data->foto);
            $data->bengkel = \App\Models\Bengkel::find($data->id_bengkel);
        }

        return [
            'error' => false,
            'data' => $data
        ];
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), array_merge(Model::rules(), [
            'foto' => 'required'
        ]));

        if ($validation->fails()) {
            return [
                'error' => true,
                'message' => $validation->errors()->first()
            ];
        }

        $data = $validation->validate();

        if ($request->foto && is_array($request->foto) && (count($request->foto) > 0)) {
            foreach ($request->foto as $item) {
                $foto = explode(';base64,', $item)[1];
                $foto_nama = $this->random() . '.jpg';
                file_put_contents(public_path('asset/produk/' . $foto_nama), base64_decode($foto));
                $data_foto[] = $foto_nama;
            }

            $data['foto'] = serialize($data_foto);
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

        $data['warna'] = serialize($request->warna);
        $data['stok_warna'] = serialize($request->stok_warna);

        if ($request->foto && is_array($request->foto) && (count($request->foto) > 0)) {
            foreach ($request->foto as $item) {
                $foto = explode(';base64,', $item)[1];
                $foto_nama = $this->random() . '.jpg';
                file_put_contents(public_path('asset/produk/' . $foto_nama), base64_decode($foto));
                $data_foto[] = $foto_nama;
            }

            $data['foto'] = serialize($data_foto);

            if ($foto = Model::find($id)->foto) {
                foreach (unserialize($foto) as $item) {
                    unlink(public_path('asset/produk/' . $item));
                }
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
            foreach (unserialize($foto) as $item) {
                unlink(public_path('asset/produk/' . $item));
            }
        }

        \App\Models\Transaksi::where('produk', 'LIKE', '%s:2:"id";i:' . $id . '%')->delete();
        Model::destroy($id);

        return [
            'error' => false,
            'message' => "data berhasil dihapus"
        ];
    }
}
