@extends('layouts.backend.master')
@section('konten')
<div class="card-header border-0">
    <div class="row align-items-center">
        <div class="col">
            <a href="#!" class="btn btn-sm btn-warning btn-refresh">Refresh</a>
        </div>
    </div>
</div>
<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush mytable">
        <!-- Tabel -->

        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Judul</th>
                <th>Peminjam</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Denda</th>
                <th>Status Denda</th>
                <th>Aksi</th>
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
                <td>Rp. {{number_format($dt->denda)}}</td>
                <td>
                    @if($dt->status_denda=='belum lunas')
                    <span class="badge badge-warning">Belum Lunas</span>
                    @elseif($dt->status_denda=='lunas')
                    <span class="badge badge-success">Lunas</span>
                    @endif
                </td>
                <td>
                    @if($dt->status_denda=='belum lunas')
                    <a href="{{url('admin/denda/lunasi/'.$dt->id)}}" class="btn btn-primary btn-sm btn-flat">Lunasi</a>
                    @elseif($dt->status_denda=='lunas')
                    <a href="{{url('admin/denda/kwitansi/'.$dt->id)}}" class="btn btn-warning btn-sm btn-flat">Kwitansi</a>

                    @endif

                </td>
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