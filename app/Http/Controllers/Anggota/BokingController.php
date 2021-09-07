<?php

namespace App\Http\Controllers\Anggota;

use App\Anggota;
use App\Buku;
use App\Http\Controllers\Controller;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BokingController extends Controller
{
    public function index()
    {
        $getRow = Transaksi::orderBy('id', 'DESC')->get();
        $rowCount = $getRow->count();

        $lastId = $getRow->first();

        $kode = "TR00001";

        if ($rowCount > 0) {
            if ($lastId->id < 9) {
                $kode = "TR0000" . '' . ($lastId->id + 1);
            } else if ($lastId->id < 99) {
                $kode = "TR000" . '' . ($lastId->id + 1);
            } else if ($lastId->id < 999) {
                $kode = "TR00" . '' . ($lastId->id + 1);
            } else if ($lastId->id < 9999) {
                $kode = "TR0" . '' . ($lastId->id + 1);
            } else {
                $kode = "TR" . '' . ($lastId->id + 1);
            }
        }
        $anggota = Anggota::get();
        $buku = Buku::where('jml_buku', '>', 0)->get();

        $data = Transaksi::where('anggota_id', Session::get('id'))->orderBy('id', 'DESC')->get();
        $title = 'Peminjaman';
        return view('anggota.transaksi.index', compact('title', 'data', 'anggota', 'buku', 'kode'));
    }

    public function create(Request $request)
    {
        $cek = Transaksi::whereIn('status', ['pinjam', 'proses'])->where('anggota_id', Session::get('id'))->count();
        if ($cek < 3) {
            if (Transaksi::where('anggota_id', Session::get('id'))->where('buku_id', $request->get('buku_id'))->whereIn('status', ['pinjam', 'proses'])->exists()) {
                return redirect()->back()->with('peringatan', 'Buku Telah dipinjam');
            } else {
                $messages = [
                    'required' => ':attribute wajib diisi!',
                    'min' => ':attribute harus diisi minimal :min karakter!',
                    'max' => ':attribute harus diisi maksimal :max karakter!',

                ];
                //dd($request->all());
                $this->validate($request, [
                    'buku_id' => 'required',
                ], $messages);

                $transaksi = Transaksi::create([
                    'anggota_id' => Session::get('id'),
                    'kode_transaksi' => $request->get('kode_transaksi'),
                    'tgl_pinjam' => Date('Y-m-d', strtotime(Carbon::today()->toDateString())),
                    'tgl_kembali' => Date('Y-m-d', strtotime(Carbon::today()->addDay(7)->toDateString())),
                    'buku_id' => $request->get('buku_id'),
                    'denda' => 0,
                    'status' => 'proses'
                ]);
                return redirect()->back()->with('sukses', 'Transaksi Berhasil ditambah');
            }
        } else {
            return  redirect()->back()->with('info', 'Peminjaman Maksimal');
        }
    }
}
