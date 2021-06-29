<?php

namespace App\Http\Controllers\Anggota;

use App\Anggota;
use App\Buku;
use App\Http\Controllers\Controller;
use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Selamat Datang ' . Session::get('nama');
        $data = Transaksi::where('tgl_pinjam', today())->get();
        $buku = Buku::where('created_at', today())->count();
        $transaksi = Transaksi::where('anggota_id', Session::get('id'))->where('status', 'pinjam')->count();
        $selesai = Transaksi::where('anggota_id', Session::get('id'))->where('status', 'kembali')->count();
        return view('anggota.dashboard.index', compact('title', 'buku',  'transaksi', 'selesai', 'data'));
    }
}
