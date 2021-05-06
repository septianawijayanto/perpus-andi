@extends('layouts.backend.master')
@section('konten')
<div class="card-header border-0">
    <div class="row align-items-center">
        <div class="col">
            <a href="#!" class="btn btn-sm btn-warning btn-refresh">Refresh</a>
        </div>
        <div class="col text-right">
            <a href="#!" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah Data </a>
        </div>
    </div>
</div>
<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
        <!-- Tabel -->
        <thead>
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Kode</th>
                <th>ISBN</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Sumber</th>
                <th>Lokasi</th>
                <th>Jumlah Buku</th>
                @if(Auth::user()->role=='admin')
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $e=>$dt)

            <tr>
                <td>{{$e+1}}</td>
                <td><a href="{{$dt->getAvatar()}}"> <img height="70px" width=" 50px" class="" src="{{$dt->getAvatar()}}" alt="Photo"></td>
                <td>{{$dt->kode_buku}}</td>
                <td>{{$dt->isbn}}</td>
                <td>{{$dt->judul}}</td>
                <td>{{$dt->pengarang}}</td>
                <td>{{$dt->penerbit}}</td>
                <td>{{$dt->sumber}}</td>
                <td>{{$dt->lokasi}}</td>
                <td>{{$dt->jml_buku}}</td>
                @if(Auth::user()->role=='admin')
                <td>
                    <a href="{{url('/buku/edit/'.$dt->id)}}" class="btn btn-success btn-sm btn-flat">Edit</a>
                    <a href="{{url('/buku/delete/'.$dt->id)}}" class="btn btn-danger btn-sm btn-flat" onclick="return confirm ('Apakah Akan Anda Hapus?')">Hapus</a>

                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
        <!-- Tabel End -->
    </table>
</div>

@endsection
@section('scripts')

<script type="text/javascript">
    $(document).ready(function() {

        // btn refresh
        $('.btn-refresh').click(function(e) {
            e.preventDefault();
            $('.preloader').fadeIn();
            location.reload();
        })

    })
</script>

@endsection