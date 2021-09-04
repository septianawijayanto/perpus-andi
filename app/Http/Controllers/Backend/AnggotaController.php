<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Anggota;
use App\User;
use PDF;
use Carbon\Carbon;
use Symfony\Contracts\Service\Attribute\Required;

class AnggotaController extends Controller
{
    public function index()
    {
        $getRow = Anggota::orderBy('id', 'DESC')->get();
        $rowCount = $getRow->count();

        $lastId = $getRow->first();

        $kode = "AGT00001";

        if ($rowCount > 0) {
            if ($lastId->id < 9) {
                $kode = "AGT0000" . '' . ($lastId->id + 1);
            } else if ($lastId->id < 99) {
                $kode = "AGT000" . '' . ($lastId->id + 1);
            } else if ($lastId->id < 999) {
                $kode = "AGT00" . '' . ($lastId->id + 1);
            } else if ($lastId->id < 9999) {
                $kode = "AGT0" . '' . ($lastId->id + 1);
            } else {
                $kode = "AGT" . '' . ($lastId->id + 1);
            }
        }

        $data = Anggota::all();
        $title = 'Data Anggota';
        return view('admin.anggota.index', compact('title', 'data', 'kode'));
    }
    public function create(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute harus diisi minimal :min karakter!',
            'max' => ':attribute harus diisi maksimal :max karakter!',
            'username.unique' => 'Username Suda Terdaftar',
        ];
        //dd($request->all());
        $this->validate($request, [
            // 'kode_anggota' => 'required',
            'nama' => 'required',
            'username' => 'required|unique:anggota',
            'password' => 'required',
            'jenis_anggota' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ], $messages);

        $data['kode_anggota'] = $request->kode_anggota;

        $data['nama'] = $request->nama;
        $data['username'] = $request->username;
        $data['password'] = bcrypt($request->password);
        $data['jenis_anggota'] = $request->jenis_anggota;
        $data['tempat_lahir'] = $request->tempat_lahir;
        $data['tgl_lahir'] = $request->tgl_lahir;
        $data['jk'] = $request->jk;
        $data['alamat'] = $request->alamat;
        $data['no_hp'] = $request->no_hp;
        $data['created_at'] = date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString()));
        $data['updated_at'] = date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString()));

        Anggota::create($data);

        return redirect()->back()->with('sukses', 'Data Siswa Berhasil di Tambah');
    }
    public function delete($id)
    {
        try {
            $data = Anggota::find($id);
            $data->delete();
            return \redirect()->back()->with('sukses', 'Data Anggota Berhasil Dihapus');
        } catch (\throwable $th) {
            return \redirect()->back()->with('Gagal', 'Gagal Data Berelasi DiTabel Lain');
        }
    }
    public function edit($id)
    {
        $title = 'Edit Anggota';

        $data = Anggota::find($id);
        return view('admin.anggota.edit', compact('data', 'title'));
    }
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute harus diisi minimal :min karakter!',
            'max' => ':attribute harus diisi maksimal :max karakter!',
        ];
        //dd($request->all());
        $this->validate($request, [
            // 'kode_anggota' => 'required',
            'nama' => 'required',
            'username' => 'required',
            // 'password' => 'required',
            'jenis_anggota' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ], $messages);


        $data['nama'] = $request->nama;
        $data['username'] = $request->username;
        $data['jenis_anggota'] = $request->jenis_anggota;
        $data['tempat_lahir'] = $request->tempat_lahir;
        $data['tgl_lahir'] = $request->tgl_lahir;
        $data['jk'] = $request->jk;
        $data['alamat'] = $request->alamat;
        $data['no_hp'] = $request->no_hp;
        // /'created_at' => date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString())),
        $data['updated_at'] = date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString()));

        Anggota::where('id', $id)->update($data);
        return redirect('admin/anggota')->with('sukses', 'Anggota Berhasil Diedit');
    }
    public function cetak($id)
    {
        $tgl = date('d F Y');
        $data = Anggota::find($id);
        $pdf = PDF::loadview('admin.anggota.kartu', compact('data', 'tgl'))->setPaper('a5', 'landscape');
        return $pdf->stream('Kartu ' . $data->nama . ' ' . date('Y-m-d_H:i:s') . '.pdf');
    }
}
