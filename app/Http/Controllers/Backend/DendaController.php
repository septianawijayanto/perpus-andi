<?php

namespace App\Http\Controllers\Backend;

use App\Anggota;
use App\Buku;
use App\Denda;
use App\Http\Controllers\Controller;
use App\Transaksi;
use App\User;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DendaController extends Controller
{
    public function index()
    {
        $title = 'Data Denda';

        $anggota = Anggota::get();
        $buku = Buku::where('jml_buku', '>', 0)->get();

        $data = Transaksi::whereIn('status_denda', ['belum lunas', 'lunas'])->get();
        $title = 'Denda';
        return view('admin.denda.index', compact('title', 'data', 'anggota', 'buku'));
    }
    public function bayar($id)
    {
        $data = Transaksi::findOrFail($id);
        Transaksi::where('id', $id)->update(['status_denda' => 'lunas']);
        // Denda::where('id', $id)->update(['status_denda' => 'lunas']);
        return redirect()->back()->with('sukses', 'Denda Berhasi dilunasi');
    }
    public function kwitansi($id)
    {
        $tgl = date('d F Y');
        // $tgl = date('F - d - y');
        $data = Transaksi::find($id);
        $pdf = PDF::loadview('admin.denda.kwitansi', compact('data', 'tgl'))->setPaper('a5', 'landscape');
        return $pdf->stream('kwitansi' . date('Y-m-d_H:i:s') . '.pdf');
    }
}
