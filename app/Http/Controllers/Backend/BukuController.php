<?php

namespace App\Http\Controllers\Backend;

use App\Buku;
use App\Exports\BukuExport;
use App\Http\Controllers\Controller;
use App\Imports\BukuImport;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BukuController extends Controller
{
    public function index()
    {
        $kode = Str::random(12);
        $data = Buku::all();
        $title = 'Data Buku';
        return view('admin.buku.index', compact('title', 'data', 'kode'));
    }
    public function create(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute harus diisi minimal :min karakter!',
            'max' => ':attribute harus diisi maksimal :max karakter!',
            'isbn.required' => 'isbn Wajib di Isi',
            'judul.required' => 'Judul Wajib di Isi',
            'pengarang.required' => 'pengarang Wajib di Isi',
            'penerbit.required' => 'penerbit Wajib di Isi',
            'tahun_terbit.required' => 'tahun terbit Wajib di Isi',
            'jml_admin.buku.required' => 'jumlah buku Wajib di Isi',
            'lokasi.required' => 'lokasi Wajib di Isi',
            'deskripsi.required' => 'deskripsi Wajib di Isi',
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute harus diisi minimal :min karakter!',
            'max' => ':attribute harus diisi maksimal :max karakter!',
            'name.required' => 'Nama Wajib di Isi',
            'sumber.required' => 'Sumber Wajib di Isi',
            // 'cover.required' => 'cover Wajib di Isi',
            // 'kelas.required' => 'Kelas Wajib di Isi',
            'email.unique' => 'Email Sudah Terdaftar',
            'cover.mimes' => 'Format Foto jpeg/png',
        ];
        //dd($request->all());
        $this->validate($request, [
            'isbn' => 'required',
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'jml_buku' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'kode_buku' => 'required',
            'cover' => 'mimes:jpeg,png',
            'sumber' => 'required',


        ], $messages);
        $data['kode_buku'] = $request->kode_buku;
        $data['isbn'] = $request->isbn;
        $data['judul'] = $request->judul;
        $data['sumber'] = $request->sumber;
        $data['pengarang'] = $request->pengarang;
        $data['penerbit'] = $request->penerbit;
        $data['tahun_terbit'] = $request->tahun_terbit;
        $data['jml_buku'] = $request->jml_buku;
        $data['lokasi'] = $request->lokasi;
        $data['deskripsi'] = $request->deskripsi;
        $data['created_at'] = date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString()));
        $data['updated_at'] = date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString()));

        $file = $request->file('cover');
        if ($file) {
            $file->move('gambar', $file->getClientOriginalName());
            $data['cover'] = $file->getClientOriginalName();
        }
        Buku::create($data);



        // //insert ke tabel buku
        // $file = $request->file('cover');
        // if ($file) {
        //     $file->move('gambar/profil', $file->getClientOriginalName());
        //     $user['cover'] =  $file->getClientOriginalName();
        // }



        return redirect()->back()->with('sukses', 'Data Buku Berhasil di Tambah');
    }
    public function delete($id)
    {
        try {
            $data = Buku::find($id);
            $data->delete();
            return \redirect()->back()->with('sukses', 'Data Buku Berhasil Dihapus');
        } catch (\throwable $th) {
            return \redirect()->back()->with('Gagal', 'Gagal Data Berelasi DiTabel Lain');
        }
    }
    public function edit($id)
    {
        $title = 'Edit Buku';

        $data = Buku::find($id);
        return view('admin.buku.edit', compact('data', 'title'));
    }
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute harus diisi minimal :min karakter!',
            'max' => ':attribute harus diisi maksimal :max karakter!',
            'isbn.required' => 'isbn Wajib di Isi',
            'judul.required' => 'Judul Wajib di Isi',
            'pengarang.required' => 'pengarang Wajib di Isi',
            'penerbit.required' => 'penerbit Wajib di Isi',
            'tahun_terbit.required' => 'tahun terbit Wajib di Isi',
            'jml_buku.required' => 'jumlah buku Wajib di Isi',
            'lokasi.required' => 'lokasi Wajib di Isi',
            'deskripsi.required' => 'deskripsi Wajib di Isi',
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute harus diisi minimal :min karakter!',
            'max' => ':attribute harus diisi maksimal :max karakter!',
            'cover.mimes' => 'Format Foto jpeg/png',
            'name.required' => 'Nama Wajib di Isi',
            'cover.required' => 'cover Wajib di Isi',
            // 'kelas.required' => 'Kelas Wajib di Isi',
            'email.unique' => 'Email Sudah Terdaftar',
            'sumber.required' => 'Sumber Wajib di Isi',
        ];
        //dd($request->all());
        $this->validate($request, [
            'isbn' => 'required',
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'jml_buku' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'sumber' => 'required',
            'cover' => 'mimes:jpeg,png',


        ], $messages);
        $data['kode_buku'] = $request->kode_buku;
        $data['isbn'] = $request->isbn;
        $data['judul'] = $request->judul;
        $data['sumber'] = $request->sumber;
        $data['pengarang'] = $request->pengarang;
        $data['penerbit'] = $request->penerbit;
        $data['tahun_terbit'] = $request->tahun_terbit;
        $data['jml_buku'] = $request->jml_buku;
        $data['lokasi'] = $request->lokasi;
        $data['deskripsi'] = $request->deskripsi;
        //   $data['created_at'] = date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString()));
        $data['updated_at'] = date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString()));
        $file = $request->file('cover');
        if ($file) {
            $file->move('gambar', $file->getClientOriginalName());
            $data['cover'] = $file->getClientOriginalName();
        }
        Buku::where('id', $id)->update($data);
        return redirect('admin/buku')->with('sukses', 'Buku Berhasil Diedit');
    }
    public function export()
    {
        return Excel::download(new BukuExport, 'buku_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file_name' => ['required', 'file', 'max:2048']
        ]);
        Excel::import(new BukuImport, $request->file('file_name'));
        return back();
    }
}
