<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User as Model;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = new Model();

        if ($id_bengkel = $request->id_bengkel) {
            $data = $data->where('id_bengkel', $id_bengkel);
        }

        $recordTotal = count($data->get());
        $pageTotal = $request->limit ? ceil($recordTotal / $request->limit) : 0;

        if ($limit = $request->limit) {
            $data = $data->limit($limit)->offset($request->page ? $request->page * $limit - $limit : 0);
        }

        if ($search = $request->search) {
            $data = $data->where('username', 'like', "%$search%");
            $data = $data->orWhere('nama', 'like', "%$search%");
            $data = $data->orWhere('email', 'like', "%$search%");
            $data = $data->orWhere('telepon', 'like', "%$search%");
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
        $validation = Validator::make($request->all(), array_merge(Model::rules(), [
            'password' => 'required|min:8|max:16'
        ]));

        if ($validation->fails()) {
            return [
                'error' => true,
                'message' => $validation->errors()->first()
            ];
        }

        $data = $validation->validate();
        $data['password'] = password_hash($request->password, PASSWORD_DEFAULT);

        Model::create($data);

        return [
            'error' => false,
            'message' => "data berhasil disimpan"
        ];
    }

    public function update(Request $request, $id)
    {
        $user = Model::find($id);
        
        if ($user->username == $request->username) {
            $validation = Validator::make($request->all(), Model::rules());
        } else {
            $validation = Validator::make($request->all(), array_merge(Model::rules(), [
                'password_lama' => 'required'
            ]));
        }

        if ($validation->fails()) {
            return [
                'error' => true,
                'message' => $validation->errors()->first()
            ];
        }

        $data = $validation->validate();

        if ($request->password_lama) {
            if (password_verify($request->password_lama, $user->password)) {
                if ($password = $request->password_baru) {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }
                
                Model::find($id)->update($data);
            } else {
                return [
                    'error' => true,
                    'message' => 'password salah'
                ];
            }
        } else {
            Model::find($id)->update($data);
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

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validation->fails()) {
            return [
                'error' => true,
                'message' => $validation->errors()->first()
            ];
        }

        if ($user = Model::where('username', $request->username)->first()) {
            if (password_verify($request->password, $user->password)) {
                return [
                    'error' => false,
                    'message' => "berhasil login",
                    'data' => $user
                ];
            } else {
                return [
                    'error' => true,
                    'message' => 'password salah'
                ];
            }
        } else {
            return [
                'error' => true,
                'message' => "username tidak ditemukan"
            ];
        }
    }
}
