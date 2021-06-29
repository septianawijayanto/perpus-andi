<?php

namespace App\Http\Controllers\Backend;

use App\Anggota;
use App\Buku;
use App\Http\Controllers\Controller;
use App\Transaksi;
use App\User;
use PDF;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $title = 'Data Denda';
        $anggota = Anggota::get();
        $buku = Buku::where('jml_buku', '>', 0)->get();
        $data = Transaksi::paginate(10);
        $title = 'Laporan';
        return view('admin.laporan.index', compact('title', 'data', 'anggota', 'buku'));
    }
    public function peminjamanpdf(Request $request)
    {
        // $denda = $request->denda;
        $tgl = date('d F Y');
        $dt = Transaksi::query();

        if ($request->get('status')) {
            if ($request->get('status') == 'pinjam') {
                $dt->where('status', 'pinjam');
            } elseif ($request->get('status') == 'kembali') {
                $dt->where('status', 'kembali');
            }
        }
        $data = $dt->get();

        $pdf = PDF::loadView('admin.laporan.pdf', compact('data', 'tgl'))->setPaper('a4', 'Landscape');
        //S return $pdf->download('laporan_transaksi_harian' . date('Y-m-d_H-i-s') . '.pdf');
        return $pdf->stream();
    }
    public function pdf()
    {
        $tgl = date('d F Y');
        $data = Transaksi::get();
        $pdf = PDF::loadview('admin.laporan.pdf', compact('data', 'tgl'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan' . date('Y-m-d_H:i:s') . '.pdf');
    }
    public function anggotapdf()
    {
        $tgl = date('d F Y');
        $data = Anggota::get();
        $pdf = PDF::loadview('admin.laporan.lapanggota', compact('data', 'tgl'))->setPaper('a4', 'landscape');
        return $pdf->stream('anggota' . date('Y-m-d_H:i:s') . '.pdf');
    }
    public function bukupdf()
    {
        $tgl = date('d F Y');
        $data = Buku::get();
        $pdf = PDF::loadview('admin.laporan.lapbuku', compact('data', 'tgl'))->setPaper('a4', 'landscape');
        return $pdf->stream('buku' . date('Y-m-d_H:i:s') . '.pdf');
    }
    public function periodepdf(Request $request)
    {
        $tgl = date('d F Y');
        $dari = $request->dari;
        $sampai = $request->sampai;
        // $total = Peminjaman::where('created_at', today())->sum('denda', $denda);

        $data = Transaksi::whereDate('created_at', '>=', $dari)->whereDate('created_at', '<=', $sampai)->orderBy('created_at', 'ASC')->get();
        $pdf = PDF::loadView('admin.laporan.periode', compact('data', 'dari', 'sampai', 'tgl'))->setPaper('a4', 'Landscape');
        //S return $pdf->download('laporan_transaksi_harian' . date('Y-m-d_H-i-s') . '.pdf');
        return $pdf->stream();
    }
}
