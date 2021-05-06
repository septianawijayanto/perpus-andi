<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
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
Route::get('coba', function () {
    return view('buku.coba');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth', 'chekRole:admin']], function () {
    route::get('/dashboard', 'Backend\DashboardController@index');

    route::get('/transaksi', 'Backend\TransaksiController@index');
    Route::get('/denda', 'Backend\DendaController@index');
    route::get('/pengembalian', 'Backend\PengembalianController@index');
    route::post('/transaksi/create', 'Backend\TransaksiController@create');

    route::get('/buku', 'Backend\BukuController@index');


    // ============================================================

    //anggota
    route::get('/anggota', 'Backend\AnggotaController@index');
    route::post('/anggota/create', 'Backend\AnggotaController@create');
    route::get('/anggota/edit/{id}', 'Backend\AnggotaController@edit');
    route::post('/anggota/update/{id}', 'Backend\AnggotaController@update');
    route::get('/anggota/delete/{id}', 'Backend\AnggotaController@delete');

    //user
    route::get('/user', 'Backend\UserController@index');
    route::post('/user/create', 'Backend\UserController@create');
    route::get('/user/edit/{id}', 'Backend\UserController@edit');
    route::post('/user/update/{id}', 'Backend\UserController@update');
    route::get('/user/delete/{id}', 'Backend\UserController@delete');

    //buku
    route::post('/buku/create', 'Backend\BukuController@create');
    route::get('/buku/edit/{id}', 'Backend\BukuController@edit');
    route::post('/buku/update/{id}', 'Backend\BukuController@update');
    route::get('/buku/delete/{id}', 'Backend\BukuController@delete');
    Route::get('/buku/export', 'Backend\BukuController@export');
    Route::post('/buku/import', 'Backend\BukuController@import');

    //transaksi

    route::get('transaksi/setujui/{id}', 'Backend\TransaksiController@setujui');
    route::get('transaksi/tolak/{id}', 'Backend\TransaksiController@tolak');
    route::get('transaksi/perpanjang/{id}', 'Backend\TransaksiController@perpanjang');

    //pengembalian
    route::get('pengembalian/kembali/{id}', 'Backend\PengembalianController@kembalikan');

    //denda

    Route::get('/denda/lunasi/{id}', 'Backend\DendaController@bayar');
    Route::get('/denda/kwitansi/{id}', 'Backend\DendaController@kwitansi');

    //laporan
    Route::get('/laporan', 'Backend\LaporanController@index');
    Route::get('/laporan/pdf', 'Backend\LaporanController@pdf');
    Route::get('/laporan/peminjamanpdf', 'Backend\LaporanController@peminjamanpdf');
    Route::get('/laporan/periodepdf', 'Backend\LaporanController@periodepdf');
    Route::get('/laporan/anggotapdf', 'Backend\LaporanController@anggotapdf');
    Route::get('/laporan/bukupdf', 'Backend\LaporanController@bukupdf');
});

Route::get('keluar', function () {
    Auth::logout();
    return redirect('/login');
});
Auth::routes();

Route::get('/home', function () {
    return redirect('/dashboard');
});
