<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service as Model;

class ServiceController extends Controller
{
    public function __construct() {
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

    public function index(Request $request)
    {
        $data = new Model();

        $data = $data->select('data_service.*');
        $data = $data->leftJoin('data_transaksi', 'data_transaksi.id', '=', 'data_service.id_transaksi');
        $data = $data->leftJoin('kendaraan_pelanggan', 'kendaraan_pelanggan.id', '=', 'data_service.id_kendaraan_pelanggan');
        $data = $data->orderBy('data_service.created_at', 'desc');

        if ($id_user = $request->id_user) {
            $data = $data->where('id_user', $id_user);
        }

        $recordTotal = count($data->get());
        $pageTotal = $request->limit ? ceil($recordTotal / $request->limit) : 0;

        if ($limit = $request->limit) {
            $data = $data->limit($limit)->offset($request->page ? $request->page * $limit - $limit : 0);
        }

        if ($search = $request->search) {
            $data = $data->where('kode', 'like', "%$search%");
            $data = $data->orWhere('kendaraan_pelanggan.merek', 'like', "%$search%");
            $data = $data->orWhere('kendaraan_pelanggan.brand', 'like', "%$search%");
        }

        $data = $data->get();

        foreach ($data as $key => $item) {
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

    public function show($id)
    {
        $data = Model::find($id);

        if ($data) {
            $data->user = \App\Models\User::find($data->id_user);
            $data->teknisi = \App\Models\Teknisi::find($data->id_teknisi);
            $transaksi = new TransaksiController;
            $data->transaksi = $transaksi->show($data->id_transaksi)['data'];
            $data->kendaraan = \App\Models\KendaraanPelanggan::find($data->id_kendaraan_pelanggan);
            
            if ($data->kendaraan) {
                $data->pelanggan = \App\Models\Pelanggan::find($data->kendaraan->id_pelanggan);
            }

            if ($data->status == '0') {
                $data->kode = 'ES' . substr($data->kode, 2);
            } else if ($data->status == '1') {
                $data->kode = 'IN' . substr($data->kode, 2);
            } else {
                $data->kode = 'WO' . substr($data->kode, 2);
            }
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
        $data['kode'] = Model::getKode();
        $data['pajak_ppn'] = $request->total_harga * ($this->app->ppn / 100);

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
        $data['pajak_ppn'] = $request->total_harga * ($this->app->ppn / 100);
        Model::find($id)->update($data);

        if ($request->status == '2') {
            $service = $this->show($id)['data'];

            $whatsapp = new WhatsappController;
            $data_whatsapp = $whatsapp->index()['data'];

            $message = str_replace('{nama}', $service->pelanggan->nama, $data_whatsapp->pesan->service);
            $message = str_replace('{kode}', $service->kode, $message);

            $request->message = $message;
            $request->to = $service->pelanggan->whatsapp;
            
            $whatsapp->send($request);
        }

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
