<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = ['id', 'kode_transaksi', 'status_denda', 'anggota_id', 'buku_id', 'tgl_pinjam', 'tgl_kembali', 'status', 'ket'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
