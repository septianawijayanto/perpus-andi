<?php

use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web Routes for your application. These
| Routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('master', function () {
    $title = 'coba';
    return view('layouts.backend.master', compact('title'));
});
Route::get('/', function () {
    return redirect('login');
});

Route::get('login', 'Login\LoginController@index');
Route::post('post/login', 'Login\LoginController@postlogin');
Route::get('keluar', 'Login\LoginController@logout');


Route::group(['middleware' => 'admin'], function () {
    Route::prefix('/admin')->group(function () {
        Route::get('dashboard', 'Backend\DashboardController@index')->name('dashboard');

        // ============================================================

        //anggota
        Route::get('/anggota', 'Backend\AnggotaController@index')->name('anggota');
        Route::post('/anggota/create', 'Backend\AnggotaController@create');
        Route::get('/anggota/edit/{id}', 'Backend\AnggotaController@edit');
        Route::post('/anggota/update/{id}', 'Backend\AnggotaController@update');
        Route::get('/anggota/delete/{id}', 'Backend\AnggotaController@delete');
        Route::get('/anggota/cetak/{id}', 'Backend\AnggotaController@cetak');

        //admin
        Route::get('/admin', 'Backend\AdminController@index')->name('admin');
        Route::post('/admin/create', 'Backend\AdminController@create');
        Route::get('/admin/edit/{id}', 'Backend\AdminController@edit');
        Route::post('/admin/update/{id}', 'Backend\AdminController@update');
        Route::get('/admin/delete/{id}', 'Backend\AdminController@delete');

        //buku
        Route::get('/buku', 'Backend\BukuController@index')->name('buku');
        Route::post('/buku/create', 'Backend\BukuController@create');
        Route::get('/buku/edit/{id}', 'Backend\BukuController@edit');
        Route::post('/buku/update/{id}', 'Backend\BukuController@update');
        Route::get('/buku/delete/{id}', 'Backend\BukuController@delete');
        Route::get('/buku/export', 'Backend\BukuController@export');
        Route::post('/buku/import', 'Backend\BukuController@import');

        //peminjaman
        Route::get('/peminjaman', 'Backend\TransaksiController@index')->name('peminjaman');
        Route::post('/peminjaman/create', 'Backend\TransaksiController@create');
        Route::get('peminjaman/setujui/{id}', 'Backend\TransaksiController@setujui');
        Route::get('peminjaman/tolak/{id}', 'Backend\TransaksiController@tolak');
        Route::get('peminjaman/perpanjang/{id}', 'Backend\TransaksiController@perpanjang');

        //pengembalian
        Route::get('/pengembalian', 'Backend\PengembalianController@index')->name('pengembalian');
        Route::get('pengembalian/kembali/{id}', 'Backend\PengembalianController@kembalikan');
        Route::match(['get', 'post'], 'pengembalian/rusak/{id}', 'Backend\PengembalianController@rusak');
        Route::match(['get', 'post'], 'pengembalian/hilang/{id}', 'Backend\PengembalianController@hilang');

        //denda
        Route::get('/denda', 'Backend\DendaController@index')->name('denda');
        Route::get('/denda/lunasi/{id}', 'Backend\DendaController@bayar');
        Route::get('/denda/kwitansi/{id}', 'Backend\DendaController@kwitansi');

        //laporan
        Route::get('/laporan', 'Backend\LaporanController@index')->name('laporan');
        Route::get('/laporan/pdf', 'Backend\LaporanController@pdf');
        Route::get('/laporan/peminjamanpdf', 'Backend\LaporanController@peminjamanpdf');
        Route::get('/laporan/periodepdf', 'Backend\LaporanController@periodepdf');
        Route::get('/laporan/anggotapdf', 'Backend\LaporanController@anggotapdf');
        Route::get('/laporan/bukupdf', 'Backend\LaporanController@bukupdf');
    });
});
Route::group(['middleware' => 'anggota'], function () {
    Route::prefix('/anggota')->group(function () {
        //Dashboard
        Route::get('dashboard', 'Anggota\DashboardController@index')->name('adashboard');
        Route::get('buku', 'Anggota\BukuController@index')->name('abuku');
        Route::get('transaksi', 'Anggota\BokingController@index')->name('atransaksi');
        Route::post('transaksi/create', 'Anggota\BokingController@create');


        // Route::get
    });
});
