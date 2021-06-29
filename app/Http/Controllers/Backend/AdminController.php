<?php

namespace App\Http\Controllers\Backend;

use App\Admin;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $data = Admin::all();
        $title = 'Data Admin';
        return view('admin.admin.index', compact('title', 'data'));
    }
    public function create(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute harus diisi minimal :min karakter!',
            'max' => ':attribute harus diisi maksimal :max karakter!',


        ];
        //dd($request->all());
        $this->validate($request, [
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required',
        ], $messages);

        Admin::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);
        return redirect()->back()->with('sukses', 'Data  Berhasil di Tambah');
    }
    public function delete($id)
    {
        try {
            $data = Admin::find($id);
            $data->delete();
            return \redirect()->back()->with('sukses', 'Data Anggota Berhasil Dihapus');
        } catch (\throwable $th) {
            return \redirect()->back()->with('Gagal', 'Gagal Data Berelasi DiTabel Lain');
        }
    }
    public function edit($id)
    {
        $title = 'Edit Admin';

        $data = Admin::find($id);
        return view('admin.admin.edit', compact('data', 'title'));
    }
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute harus diisi minimal :min karakter!',
            'max' => ':attribute harus diisi maksimal :max karakter!'
        ];
        //dd($request->all());
        $this->validate($request, [
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required',
        ], $messages);
        $data['nama'] = $request->nama;
        $data['username'] = $request->username;
        $data['password'] = bcrypt($request->password);
        $data['updated_at'] = date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString()));

        Admin::where('id', $id)->update($data);
        return redirect('admin/admin')->with('sukses', 'Data Berhasil Diedit');
    }
}
