<?php

namespace App\Http\Controllers\Anggota;

use App\Buku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $data = Buku::all();
        $title = 'Data Buku';
        return view('anggota.buku.index', compact('title', 'data'));
    }
}
