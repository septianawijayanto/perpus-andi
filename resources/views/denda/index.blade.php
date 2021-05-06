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
                <th>Kode</th>
                <th>Judul</th>
                <th>Peminjam</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Denda</th>
                <th>Status Denda</th>
                @if(Auth::user()->role=='admin')
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $e=>$dt)
            <tr>
                <td>{{$e+1}}</td>
                <td>{{$dt->kode_transaksi}}</td>
                <td>{{$dt->buku->judul}}</td>
                <td>{{$dt->anggota->nama}}</td>
                <td>{{$dt->tgl_pinjam}}</td>
                <td>{{$dt->tgl_kembali}}</td>
                <td>{{$dt->status}}</td>
                <td>Rp. {{number_format($dt->denda)}}</td>
                <td>{{$dt->status_denda}}</td>
                @if(Auth::user()->role=='admin')
                <td>
                    @if($dt->status_denda=='belum lunas')
                    <a href="{{url('/denda/lunasi/'.$dt->id)}}" class="btn btn-success btn-sm btn-flat">Lunasi</a>
                    @elseif($dt->status_denda=='lunas')
                    <a href="{{url('/denda/kwitansi/'.$dt->id)}}" class="btn btn-success btn-sm btn-flat">Kwitansi</a>

                    @endif

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