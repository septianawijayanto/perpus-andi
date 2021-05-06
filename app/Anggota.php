<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $fillable = [
        'id', 'kode_anggota', 'nama', 'jenis_anggota',
        'tempat_lahir', 'tgl_lahir', 'jk', 'no_hp', 'alamat'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
