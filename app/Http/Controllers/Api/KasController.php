<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Kas as Model;

class KasController extends Controller
{
    public function index(Request $request)
    {
        $data = new Model();

        $data = $data->select('data_kas.*');
        $data = $data->leftJoin('data_user', 'data_user.id', '=', 'data_kas.id_user');
        $data = $data->orderBy('data_kas.created_at', 'desc');

        if ($tipe = $request->tipe) {
            $data = $data->where('tipe', $tipe);
        }

        $recordTotal = count($data->get());
        $pageTotal = $request->limit ? ceil($recordTotal / $request->limit) : 0;

        if ($limit = $request->limit) {
            $data = $data->limit($limit)->offset($request->page ? $request->page * $limit - $limit : 0);
        }

        if ($search = $request->search) {
            $data = $data->where('deskripsi', 'like', "%$search%");
            $data = $data->orWhere('data_user.nama', 'like', "%$search%");
            $data = $data->orWhere('jumlah', 'like', "%$search%");
        }

        $data = $data->get();

        foreach ($data as $key => $item) {
            $data[$key]->user = \App\Models\User::find($item->id_user);
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

        $data->user = \App\Models\User::find($id);

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

    public function report(Request $request)
    {
        $data = new Model;
        $data = $data->select(
            DB::raw('date_format(created_at, "%Y-%m") as bulan_tahun')
        )->groupBy('bulan_tahun');

        if ($tahun = $request->tahun) {
            $data = $data->where(DB::raw('date_format(created_at, "%Y")'), $tahun);
        }

        $data = $data->get();

        $bulan = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        foreach ($data as $key => $item) {
            $pendapatan = Model::select(DB::raw('sum(jumlah) as jumlah'))
                ->where(DB::raw('date_format(created_at, "%Y-%m")'), '=', $item->bulan_tahun)
                ->where('tipe', '1')->first();
            $pengeluaran = Model::select(DB::raw('sum(jumlah) as jumlah'))
                ->where(DB::raw('date_format(created_at, "%Y-%m")'), '=', $item->bulan_tahun)
                ->where('tipe', '0')->first();

            $data[$key]->tahun = date('Y', strtotime($item->bulan_tahun));
            $data[$key]->bulan = $bulan[(int) date('m', strtotime($item->bulan_tahun))];
            $data[$key]->pendapatan = (int) $pendapatan->jumlah;
            $data[$key]->pengeluaran = (int) $pengeluaran->jumlah;
        }

        return [
            'error' => false,
            'data' => $data
        ];
    }

    public function graphic(Request $req)
    {
        if ($req->tahun) {
            $tahun = $req->tahun;
        } else {
            $tahun = date('Y');
        }
        $bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
        
        for ($i = 0; $i < count($bulan); $i++) {
            // pendapatan
            $model = new Model;
            $j = $i + 1;

            $model = $model->where(DB::raw('date_format(created_at, "%Y")'), $tahun);
            $model = $model->where(DB::raw('date_format(created_at, "%m")'), $j < 10 ? '0' . $j : $j);

            $pendapatan = $model->select(DB::raw('sum(jumlah) as total'))->where('tipe', '1')->groupBy(DB::raw('date_format(created_at, "%Y-%m")'))->first();
            
            // pengeluaran
            $model = new Model;

            $model = $model->where(DB::raw('date_format(created_at, "%Y")'), $tahun);
            $model = $model->where(DB::raw('date_format(created_at, "%m")'), $j < 10 ? '0' . $j : $j);

            $pengeluaran = $model->select(DB::raw('sum(jumlah) as total'))->where('tipe', '0')->groupBy(DB::raw('date_format(created_at, "%Y-%m")'))->first();

            // perhitungan
            $data_pendapatan[$i] = $pendapatan ? (int) $pendapatan->total : 0;
            $data_pengeluaran[$i] = $pengeluaran ? (int) $pengeluaran->total : 0;
            $data_profit[$i] = $data_pendapatan[$i] - $data_pengeluaran[$i];
        }

        return [
            'error' => true,
            'data' => [
                'label' => $bulan,
                'pendapatan' => $data_pendapatan,
                'pengeluaran' => $data_pengeluaran,
                'profit' => $data_profit
            ]
        ];
    }
}
