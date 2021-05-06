<?php

namespace App\Imports;

use App\Buku;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BukuImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $head = [
            'No',
            'Kode',
            'ISBN',
            'Judul',
            'Pengarang',
            'Penerbit',
            'Tahun Terbit',
            'Jumlah Buku',
            'Lokasi',
            'Deskripsi',
        ];
        if ($head != $collection[0]->toArray()) {
            return back()->with('gagal', 'Format Data Tidak sesuai');
        }
        unset($collection[0]);
        set_time_limit(0);

        foreach ($collection as $key => $row) {
            $baris = $key + 1;
            Validator::make($row->toArray(), [
                ['nullable'],
                ['required'],
                ['required'],
                ['required'],
                ['required'],
                ['required'],
                ['required'],
                ['required'],
                ['required'],
                ['required'],
            ], [
                '1.required' => 'Kode (kolom B baris ke-' . $baris . ')wajib diisi.',
                '2.required' => 'ISBN (kolom c baris ke-' . $baris . ')wajib diisi.',
                '3.required' => 'Judul (kolom D baris ke-' . $baris . ')wajib diisi.',
                '4.required' => 'Pengarang (kolom E baris ke-' . $baris . ')wajib diisi.',
                '5.required' => 'Penerbit (kolom F baris ke-' . $baris . ')wajib diisi.',
                '6.required' => 'Tahun Terbit (kolom G baris ke-' . $baris . ')wajib diisi.',
                '7.required' => 'Jumlah Buku (kolom H baris ke-' . $baris . ')wajib diisi.',
                '8.required' => 'Lokasi (kolom I baris ke-' . $baris . ')wajib diisi.',
                '9.required' => 'Deskripsi (kolom J baris ke-' . $baris . ')wajib diisi.',
            ])->validate();

            $kode = $row[1];

            $data = [
                'kode_buku' => $kode,
                'isbn' => $row[2],
                'judul' => $row[3],
                'pengarang' => $row[4],
                'penerbit' => $row[5],
                'tahun_terbit' => $row[6],
                'jumlah_buku' => $row[7],
                'lokasi' => $row[8],
                'deskripsi' => $row[9],
            ];
            $buku = Buku::where('kode_buku', $kode)->first();

            if ($buku) {
                $buku->update($data);
            } else {
                Buku::create($data);
            }
        }
        return back()->with('sukses', 'Data buku berhasil diimport');
    }
}
