<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = ['id', 'kode_buku', 'sumber', 'judul', 'isbn', 'pengarang', 'penerbit', 'tahun_terbit', 'jml_buku', 'jml_dipinjam', 'deskripsi', 'lokasi', 'cover'];
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
    public function getAvatar()
    {
        if (!$this->cover) {
            return asset('gambar/dokumen.png');
        }
        return asset('gambar/' . $this->cover);
    }
}
