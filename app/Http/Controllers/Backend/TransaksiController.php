<?php

namespace App\Http\Controllers\Backend;

use App\Anggota;
use App\Buku;
use App\Http\Controllers\Controller;
use App\Transaksi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class TransaksiController extends Controller
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

        $data = Transaksi::orderBy('id', 'DESC')->get();
        $title = 'Peminjaman';
        return view('admin.peminjaman.index', compact('title', 'data', 'anggota', 'buku', 'kode'));
    }
    public function create(Request $request)
    {
        $cek = Transaksi::whereIn('status', ['pinjam', 'proses'])->where('anggota_id', $request->get('anggota_id'))->count();
        if ($cek < 3) {
            if (Transaksi::where('anggota_id', $request->get('anggota_id'))->where('buku_id', $request->get('buku_id'))->whereIn('status', ['pinjam', 'proses'])->exists()) {
                return redirect()->back()->with('info', 'Buku Telah dipinjam');
            } else {
                $messages = [
                    'required' => ':attribute wajib diisi!',
                    'min' => ':attribute harus diisi minimal :min karakter!',
                    'max' => ':attribute harus diisi maksimal :max karakter!',
                    'kode.required' => 'isbn Wajib di Isi',
                    'judul.required' => 'Judul Wajib di Isi',
                    'nama.required' => 'nama Wajib di Isi',
                ];
                //dd($request->all());
                $this->validate($request, [
                    'buku_id' => 'required',
                    'anggota_id' => 'required',
                ], $messages);

                // DD($request->all());
                $transaksi = Transaksi::create([
                    'kode_transaksi' => $request->get('kode_transaksi'),
                    'tgl_pinjam' => Date('Y-m-d', strtotime(Carbon::today()->toDateString())),
                    'tgl_kembali' => Date('Y-m-d', strtotime(Carbon::today()->addDay(7)->toDateString())),
                    'buku_id' => $request->get('buku_id'),
                    'anggota_id' => $request->get('anggota_id'),
                    'denda' => 0,
                    'status' => 'pinjam'
                ]);


                $transaksi->buku->where('id', $transaksi->buku_id)
                    ->update([
                        'jml_buku' => ($transaksi->buku->jml_buku - 1),
                        'jml_dipinjam' => $transaksi->buku->jml_dipinjam + 1,
                    ]);

                // Transaksi::insert($data);
                return redirect()->back()->with('sukses', 'Transaksi Berhasil ditambah');
            }
        } else {
            return  redirect()->back()->with('info', 'Peminjaman Maksimal');
        }
    }
    public function setujui($id)
    {
        $data = Transaksi::find($id);
        $buku_id = $data->buku_id;
        $bk = Buku::find($buku_id);
        $b = $bk->jml_buku;
        $c = $b - 1;


        $dipinjam = $bk->jml_dipinjam;
        $d = $dipinjam + 1;

        $cek = Buku::where('id', $buku_id)->where('jml_buku', '>', 0)->count();
        if ($cek) {
            Transaksi::where('id', $id)->update(['status' => 'pinjam']);
            Buku::where('id', $buku_id)
                ->update([
                    'jml_buku' => $c,
                    'jml_dipinjam' => $d,
                ]);

            return redirect()->back()->with('sukses', 'Transaksi Berhasil disetujui');
        } else {
            Transaksi::where('id', $id)->update(['status' => 'tolak']);
            return redirect()->back()->with('gagal', 'Buku Kosong Transaksi Ditolak');
        }
    }
    public function tolak($id)
    {
        $data = Transaksi::find($id);
        Transaksi::where('id', $id)->update(['status' => 'tolak']);

        return redirect()->back()->with('sukses', 'Transaksi Ditolak');
    }
    public function perpanjang($id)
    {
        $data = Transaksi::find($id);
        Transaksi::where('id', $id)->update(['tgl_kembali' => Date('Y-m-d', strtotime(Carbon::today()->addDay(7)->toDateString())),]);
        return redirect()->back()->with('sukses', 'Berhasil Di perpanjang');
    }
}
