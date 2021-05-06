<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        $title = 'Data User';
        return view('user.index', compact('title', 'data'));
    }
    public function create(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute harus diisi minimal :min karakter!',
            'max' => ':attribute harus diisi maksimal :max karakter!',
            'name.required' => 'Name Wajib di Isi',
            'email.required' => 'email Wajib di Isi',
            'role.required' => 'role Wajib di Isi',
            'password.required' => 'password Wajib di Isi',

            'email.unique' => 'Email Sudah Terdaftar',
        ];
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
            'email' => 'required|unique:users',
        ], $messages);

        User::create([
            'name' => $request->name,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'email' => $request->email,
        ]);
        return redirect('user')->with('sukses', 'Data  Berhasil di Tambah');
    }
    public function delete($id)
    {
        try {
            $data = User::find($id);
            $data->delete();
            return \redirect()->back()->with('sukses', 'Data Anggota Berhasil Dihapus');
        } catch (\throwable $th) {
            return \redirect()->back()->with('Gagal', 'Gagal Data Berelasi DiTabel Lain');
        }
    }
    public function edit($id)
    {
        $title = 'Edit User';

        $data = User::find($id);
        return view('user.edit', compact('data', 'title'));
    }
    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => 'Nama Wajib di Isi',
            'email.required' => 'Email Wajib di Isi',
            // 'kelas.required' => 'Kelas Wajib di Isi',
        ];
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',

        ], $messages);
        // $data['user_id'] = $request->user_id;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        // $data['role'] = 'siswa';
        // /'created_at' => date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString())),
        $data['updated_at'] = date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString()));

        User::where('id', $id)->update($data);
        return redirect('user')->with('sukses', 'User Berhasil Diedit');
    }
}
