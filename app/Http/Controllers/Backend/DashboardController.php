<?php

namespace App\Http\Controllers\Backend;

use App\Anggota;
use App\Buku;
use App\Http\Controllers\Controller;
use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {


        $data = Transaksi::where('tgl_pinjam', today())->get();
        $title = 'Dashboard Admin';
        $buku = Buku::count();
        $as = Anggota::where('jenis_anggota', 'siswa')->count();
        $ag = Anggota::where('jenis_anggota', 'guru')->count();
        $ast = Anggota::where('jenis_anggota', 'staf')->count();
        $transaksi = Transaksi::where('status', 'pinjam')->count();
        $selesai = Transaksi::where('status', 'kembali')->count();
        return view('admin.dashboard.index', compact('title', 'buku', 'as', 'ag', 'ast', 'transaksi', 'selesai', 'data'));
    }
}
