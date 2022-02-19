<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaksi as Model;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{

    public function index(Request $request)
    {
        $data = new Model();

        $data = $data->select('data_transaksi.*');
        $data = $data->leftJoin('data_pelanggan', 'data_pelanggan.id',  '=',  'data_transaksi.id_pelanggan');
        $data = $data->orderBy('data_transaksi.created_at', 'desc');

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
            $data = $data->orWhere('data_pelanggan.nama', 'like', "%$search%");
            $data = $data->orWhere('total_harga', 'like', "%$search%");
            $data = $data->orWhere('total_bayar', 'like', "%$search%");
        }

        $data = $data->get();

        foreach ($data as $key => $item) {
            $produk = unserialize($item->produk);
            for ($i=0; $i < count($produk); $i++) { 
                $produk[$i]['produk'] = \App\Models\Produk::find($produk[$i]['id']);
            }

            $data[$key]->produk = $produk;

            $jasa = unserialize($item->jasa);
            for ($i=0; $i < count($jasa); $i++) { 
                $jasa[$i]['jasa'] = \App\Models\Jasa::find($jasa[$i]['id']);
            }
            $data[$key]->jasa = $jasa;

            $data[$key]->pelanggan = \App\Models\Pelanggan::find($item->id_pelanggan);
            $data[$key]->user = \App\Models\User::find($item->id_user);
        }

        return [
            'error' => false,
            'data' => $data,
            'recordTotal' => $recordTotal,
            'pageTotal' => $pageTotal
        ];
    }

    public function show($kode)
    {
        $data = Model::find($kode);

        if ($data) {
            $produk = unserialize($data->produk);
            
            for ($i=0; $i < count($produk); $i++) { 
                $produk[$i]['produk'] = \App\Models\Produk::find($produk[$i]['id']);
            }

            $data->produk = $produk;

            $jasa = unserialize($data->jasa);
            
            for ($i=0; $i < count($jasa); $i++) { 
                $jasa[$i]['jasa'] = \App\Models\Jasa::find($jasa[$i]['id']);
            }

            $data->jasa = $jasa;

            $data->pelanggan = \App\Models\Pelanggan::find($data->id_pelanggan);
            $data->user = \App\Models\User::find($data->id_user);
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

        if (!is_array($request->produk)) {
            return [
                'error' => true,
                'message' => "produk tidak diketahui"
            ];
        }

        if (!is_array($request->jasa)) {
            return [
                'error' => true,
                'message' => "jasa tidak diketahui"
            ];
        }

        foreach ($request->produk as $key => $item) {
            $produk = \App\Models\Produk::find($item['id']);
            $stok = $produk->stok - $item['qty'];
            $produk->update(['stok' => $stok]);
        }

        $data['kode'] = Model::getKode();
        $data['produk'] = serialize($request->produk);
        $data['jasa'] = serialize($request->jasa);

        $transaksi = Model::create($data);

        if ($request->id_service) {
            \App\Models\Service::find($request->id_service)->update(['id_transaksi' => $transaksi->id]);
        }

        \App\Models\Kas::create([
            'deskripsi' => 'Transaksi (' . $data['kode'] . ')',
            'jumlah' => $request->grand_total,
            'tipe' => '1',
            'id_user' => $request->id_user
        ]);

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

        if (!is_array($request->produk)) {
            return [
                'error' => true,
                'message' => "produk tidak diketahui"
            ];
        }

        if (!is_array($request->jasa)) {
            return [
                'error' => true,
                'message' => "jasa tidak diketahui"
            ];
        }

        $transaksi = Model::find($id);

        foreach (unserialize($transaksi->produk) as $key => $item) {
            $produk = \App\Models\Produk::find($item['id']);
            $stok = $produk->stok + $item['qty'];
            $produk->update(['stok' => $stok]);
        }

        foreach ($request->produk as $key => $item) {
            $produk = \App\Models\Produk::find($item['id']);
            $stok = $produk->stok - $item['qty'];
            $produk->update(['stok' => $stok]);
        }

        $data['produk'] = serialize($request->produk);
        $data['jasa'] = serialize($request->jasa);

        $transaksi->update($data);

        \App\Models\Kas::where('deskripsi', '=', 'Transaksi (' . $transaksi->kode . ')')->update([
            'deskripsi' => 'Transaksi (' . $transaksi->kode . ')',
            'jumlah' => $request->grand_total,
            'tipe' => '1',
            'id_user' => $request->id_user
        ]);

        return [
            'error' => false,
            'message' => "data berhasil diedit"
        ];
    }

    public function destroy($id)
    {
        $transaksi = Model::find($id);

        foreach (unserialize($transaksi->produk) as $key => $item) {
            $produk = \App\Models\Produk::find($item['id']);
            $stok = $produk->stok + $item['qty'];
            $produk->update(['stok' => $stok]);
        }

        \App\Models\Kas::where('deskripsi', '=', 'Transaksi (' . $transaksi->kode . ')')->delete();

        \App\Models\Service::where('id_transaksi', $id)->update(['id_transaksi' => 0]);
        Model::destroy($id);

        return [
            'error' => false,
            'message' => "data berhasil dihapus"
        ];
    }

    public function produk(Request $request)
    {
        $produk = new \App\Models\Produk;
        $produk = $produk->select(
            'data_produk.id',
            'data_produk.nama',
            'data_produk.harga_jual',
            'data_produk.harga_beli'
        );
        $produk = $produk->orderBy('data_produk.id', 'desc');

        $recordTotal = count($produk->get());
        $pageTotal = $request->limit ? ceil($recordTotal / $request->limit) : 0;

        if ($limit = $request->limit) {
            $produk = $produk->limit($limit)->offset($request->page ? $request->page * $limit - $limit : 0);
        }

        if ($search = $request->search) {
            $produk = $produk->where('data_produk.nama', 'like', "%$search%");
        }

        $produk = $produk->get();

        foreach ($produk as $key => $item) {
            $transaksi = Model::all();
            $terjual = 0;
            $pengeluaran = 0;
            $penghasilan = 0;

            foreach ($transaksi as $t) {
                $t_produk = unserialize($t->produk);
                foreach ($t_produk as $p_produk) {
                    if ($p_produk['id'] == $item->id) {
                        $terjual += $p_produk['qty'];
                        $pengeluaran += $p_produk['qty'] * $item->harga_beli;
                        $penghasilan += $p_produk['qty'] * $item->harga_jual;
                    }
                }
            }
            $produk[$key]->terjual = $terjual;
            $produk[$key]->pengeluaran = $pengeluaran;
            $produk[$key]->penghasilan = $penghasilan;
        }

        return [
            'error' => false,
            'data' => $produk,
            'recordTotal' => $recordTotal,
            'pageTotal' => $pageTotal
        ];
    }

    public function jasa(Request $request)
    {
        $jasa = new \App\Models\jasa;
        $jasa = $jasa->select(
            'data_jasa.id',
            'data_jasa.nama',
            'data_jasa.harga'
        );
        $jasa = $jasa->orderBy('data_jasa.id', 'desc');

        $recordTotal = count($jasa->get());
        $pageTotal = $request->limit ? ceil($recordTotal / $request->limit) : 0;

        if ($limit = $request->limit) {
            $jasa = $jasa->limit($limit)->offset($request->page ? $request->page * $limit - $limit : 0);
        }

        if ($search = $request->search) {
            $jasa = $jasa->where('data_jasa.nama', 'like', "%$search%");
        }

        $jasa = $jasa->get();

        foreach ($jasa as $key => $item) {
            $transaksi = Model::all();
            $terpakai = 0;
            $penghasilan = 0;

            foreach ($transaksi as $t) {
                $t_jasa = unserialize($t->jasa);
                foreach ($t_jasa as $p_jasa) {
                    if ($p_jasa['id'] == $item->id) {
                        $terpakai += 1;
                        $penghasilan += $item->harga;
                    }
                }
            }
            $jasa[$key]->terpakai = $terpakai;
            $jasa[$key]->penghasilan = $penghasilan;
        }

        return [
            'error' => false,
            'data' => $jasa,
            'recordTotal' => $recordTotal,
            'pageTotal' => $pageTotal
        ];
    }

    public function report(Request $req)
    {
        $tahun = $req->tahun ? $req->tahun : date('Y');

        $data = Model::select(
            DB::raw('sum(grand_total) as total_omset'),
            DB::raw('sum(total_harga) as total_pengaluran'),
            DB::raw('sum(pajak_ppn) as laba_kotor')
        )->where(DB::raw('date_format(updated_at, "%Y")'), $tahun)->first();

        return [
            'error' => false,
            'data' => $data
        ];
    }
}
