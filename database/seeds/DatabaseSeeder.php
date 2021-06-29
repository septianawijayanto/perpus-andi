<?php

use App\Admin;
use App\Anggota;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
        ]);
        Anggota::create([
            'nama' => 'Anggota',
            'username' => 'anggota',
            'password' => bcrypt('anggota'),
            'kode_anggota' => 'AG1',
            'jenis_anggota' => 'siswa',
            'tempat_lahir' => 'Bumi',
            'tgl_lahir' => today(),
            'jk' => 'L',
            'alamat' => 'Jambi',
            'no_hp' => '0890'
        ]);
    }
}
