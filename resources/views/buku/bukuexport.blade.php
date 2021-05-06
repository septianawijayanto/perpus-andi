<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>ISBN</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th>Jumlah Buku</th>
            <th>Lokasi</th>
            <th>Deskripsi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $e=>$dt)

        <tr>
            <td>{{$e+1}}</td>
            <td>{{$dt->kode_buku}}</td>
            <td>{{$dt->isbn}}</td>
            <td>{{$dt->judul}}</td>
            <td>{{$dt->pengarang}}</td>
            <td>{{$dt->penerbit}}</td>
            <td>{{$dt->tahun_terbit}}</td>
            <td>{{$dt->jumlah_buku}}</td>
            <td>{{$dt->lokasi}}</td>
            <td>{{$dt->deskripsi}}</td>
        </tr>
        @endforeach
    </tbody>
</table>