<?php

namespace App\Http\Controllers\Backend;

use App\Anggota;
use App\Buku;
use App\Denda;
use App\Http\Controllers\Controller;
use App\Pengembalian;
use App\Transaksi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    public function index()
    {
        $user = User::get();
        $anggota = Anggota::get();
        $buku = Buku::where('jml_buku', '>', 0)->get();
        if (Auth::user()->role == 'admin') {
            $data = Transaksi::orderBy('id', 'DESC')->get();
        } else {
            $data = Transaksi::where('anggota_id', Auth::user()->anggota->id)->where('status', 'kembali')->orderBy('id', 'DESC')->get();
        }

        $title = 'Pengembalian';
        return view('pengembalian.index', compact('title', 'data', 'anggota', 'user', 'buku'));
    }
    public function kembalikan($id)
    {
        $data = Transaksi::find($id);
        $tgl_kembali = $data->tgl_kembali;
        $tgl2 = today();

        $selisih = $tgl2->diffInDays($tgl_kembali);

        $coba = Pengembalian::create([
            'kode_transaksi' => $data->kode_transaksi,
            'anggota_id' => $data->anggota_id,
            'buku_id' => $data->buku_id,
            'tgl_pengembalian' => date('Y-m-d', strtotime(Carbon::today()->toDateString())),
            'status' => 'kembali',
            'created_at' => date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString())),
            'updated_at' => date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString())),
        ]);


        $data->buku->where('id', $data->buku_id)->update([
            'jml_buku' => ($data->buku->jml_buku + 1),
            'jml_dipinjam' => $data->buku->jml_dipinjam - 1,
        ]);

        $jns = $data->anggota->jenis_anggota;
        if ($jns == 'siswa') {
            if ($tgl_kembali < $tgl2) {
                $denda = 1000 * $selisih;

                $coba = Denda::create([
                    'kode_transaksi' => $data->kode_transaksi,
                    'anggota_id' => $data->anggota_id,
                    'buku_id' => $data->buku_id,
                    'status' => 'kembali',
                    // 'status_denda' => 'belum lunas',
                    'denda' => $denda,
                ]);

                Transaksi::where('id', $id)->update([
                    'status' => 'kembali',
                    'denda' => $denda,
                    'status_denda' => 'belum lunas',
                    'updated_at' => date('Y-m-d', strtotime(Carbon::today()->toDateString())),
                ],);
            } else {
                $denda = 0;
                Transaksi::where('id', $id)->update([
                    'status' => 'kembali',
                    'denda' => $denda,

                    'updated_at' => date('Y-m-d', strtotime(Carbon::today()->toDateString())),
                ],);
            }
            return redirect()->back()->with('sukses', 'Buku Dikembalikan');
        } else {
            Transaksi::where('id', $id)->update([
                'status' => 'kembali',
                'denda' => 0,

                'updated_at' => date('Y-m-d', strtotime(Carbon::today()->toDateString())),
            ],);
            return redirect()->back()->with('sukses', 'Buku Dikembalikan');
        }
    }
    public function rusak(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $dt = Transaksi::find($id);
            //Update Jumlah Buku
            $id_buku = $dt->buku_id;
            $buku = Buku::find($id_buku);
            $sekarang = $buku->rusak;
            $jml_rusak = $sekarang + 1;

            $tgl_kembali = $dt->tgl_kembali;
            $tgl2 = today();
            $selisih = $tgl2->diffInDays($tgl_kembali);

            $dipinjam = $buku->jml_dipinjam;
            $jmldpskr = $dipinjam - 1;

            $coba = Pengembalian::create([
                'kode_transaksi' => $dt->kode_transaksi,
                'anggota_id' => $dt->anggota_id,
                'buku_id' => $dt->buku_id,
                'tgl_pengembalian' => date('Y-m-d', strtotime(Carbon::today()->toDateString())),
                'status' => 'rusak',
                'created_at' => date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString())),
                'updated_at' => date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString())),
            ]);


            Buku::where('id', $id_buku)->update([
                'rusak' => $jml_rusak,
                'jml_dipinjam' => $jmldpskr,
            ]);


            if ($tgl_kembali < $tgl2) {
                $denda = 1000 * $selisih;

                $coba = Denda::create([
                    'kode_transaksi' => $dt->kode_transaksi,
                    'anggota_id' => $dt->anggota_id,
                    'buku_id' => $dt->buku_id,
                    'status' => 'rusak',
                    // 'status_denda' => 'belum lunas',
                    'denda' => $denda + $request->denda,
                ]);

                Transaksi::where('id', $id)->update([
                    'status' => 'rusak',
                    'denda' => $denda + $request->denda,
                    'status_denda' => 'belum lunas',
                    'updated_at' => date('Y-m-d', strtotime(Carbon::today()->toDateString())),
                ],);
            } else {
                $denda = 0;
                $coba = Denda::create([
                    'kode_transaksi' => $dt->kode_transaksi,
                    'anggota_id' => $dt->anggota_id,
                    'buku_id' => $dt->buku_id,
                    'status' => 'rusak',
                    // 'status_denda' => 'belum lunas',
                    'denda' => $denda + $request->denda,
                ]);

                Transaksi::where('id', $id)->update([
                    'status' => 'rusak',
                    'denda' => $denda + $request->denda,
                    'updated_at' => date('Y-m-d', strtotime(Carbon::today()->toDateString())),
                ],);
            }
        }
        return redirect()->back()->with('sukses', 'Status Peminjaman Rusak');
    }
    public function hilang(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $dt = Transaksi::find($id);
            //Update Jumlah Buku
            $id_buku = $dt->buku_id;
            $buku = Buku::find($id_buku);
            $sekarang = $buku->hilang;
            $jml_hilang = $sekarang + 1;
            $denda = $dt->denda;

            $tgl_kembali = $dt->tgl_kembali;
            $tgl2 = today();
            $selisih = $tgl2->diffInDays($tgl_kembali);

            $dipinjam = $buku->jml_dipinjam;
            $jmldpskr = $dipinjam - 1;

            $coba = Pengembalian::create([
                'kode_transaksi' => $dt->kode_transaksi,
                'anggota_id' => $dt->anggota_id,
                'buku_id' => $dt->buku_id,
                'tgl_pengembalian' => date('Y-m-d', strtotime(Carbon::today()->toDateString())),
                'status' => 'hilang',
                'created_at' => date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString())),
                'updated_at' => date('Y-m-d H:i:s', strtotime(Carbon::today()->toDateString())),
            ]);


            Buku::where('id', $id_buku)->update([
                'hilang' => $jml_hilang,
                'jml_dipinjam' => $jmldpskr,
            ]);
            if ($tgl_kembali < $tgl2) {
                $denda = 1000 * $selisih;

                $coba = Denda::create([
                    'kode_transaksi' => $dt->kode_transaksi,
                    'anggota_id' => $dt->anggota_id,
                    'buku_id' => $dt->buku_id,
                    'status' => 'hilang',
                    // 'status_denda' => 'belum lunas',
                    'denda' => $denda + $request->denda,
                ]);

                Transaksi::where('id', $id)->update([
                    'status' => 'hilang',
                    'denda' => $denda + $request->denda,
                    'status_denda' => 'belum lunas',
                    'updated_at' => date('Y-m-d', strtotime(Carbon::today()->toDateString())),
                ],);
            } else {
                $denda = 0;
                $coba = Denda::create([
                    'kode_transaksi' => $dt->kode_transaksi,
                    'anggota_id' => $dt->anggota_id,
                    'buku_id' => $dt->buku_id,
                    'status' => 'hilang',
                    // 'status_denda' => 'belum lunas',
                    'denda' => $denda + $request->denda,
                ]);

                Transaksi::where('id', $id)->update([
                    'status' => 'hilang',
                    'denda' => $denda + $request->denda,
                    'updated_at' => date('Y-m-d', strtotime(Carbon::today()->toDateString())),
                ],);
            }
        }
        return redirect()->back()->with('sukses', 'Status Peminjaman Hilang');
    }
}
