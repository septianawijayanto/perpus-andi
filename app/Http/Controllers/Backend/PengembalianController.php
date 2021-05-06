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



        $data->buku->where('id', $data->buku_id)
            ->update([
                'jml_buku' => ($data->buku->jml_buku + 1),
                'jml_dipinjam' => $data->buku->jml_dipinjam - 1,
            ]);

        $jns = $data->anggota->jenis_anggota;
        if ($jns == 'siswa') {
            if ($tgl_kembali < $tgl2) {
                $denda = 1000 * $selisih;
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
}
