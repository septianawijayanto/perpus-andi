@extends('layouts.backend.master')
@section('konten')
<div class="card-header border-0">
    <div class="row align-items-center">
        <div class="col">
            <a href="#!" class="btn btn-sm btn-warning btn-refresh">Refresh</a>
        </div>
        <div class="col text-right">
            <div class="btn-group dropdown float-right">
                <button class="btn btn-sm btn-flat btn-warning btn-refresh"> Refresh</button>
                <button type="button" class="btn btn-sm btn-flat btn-primary  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <b><i class="fa fa-printh"></i> Cetak Laporan</b>
                </button>
                <div class="dropdown-menu " x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                    <a href="{{url('admin/laporan/pdf')}}" class="dropdown-item"> Laporan Semua Transaksi</a>

                    <a href="{{url('admin/laporan/peminjamanpdf?status=pinjam')}}" class="dropdown-item"> Laporan Sedang Di pinjam</a>

                    <button class="dropdown-item btn-priodepdf" data-toggle="modal" data-target="#modal"> Laporan Periode</button>

                    <a href="{{url('admin/laporan/peminjamanpdf?status=kembali')}}" class="dropdown-item"> Laporan Pengembalian</a>


                    <a href="{{url('admin/laporan/anggotapdf')}}" class="dropdown-item"> Laporan Anggota</a>

                    <a href="{{url('admin/laporan/bukupdf')}}" class="dropdown-item"> Laporan Buku</a>

                </div>
            </div>
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
                <th>Status</th>
                <th>Denda</th>
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
                <td>
                    @if($dt->status=='proses')
                    <span class="badge badge-info">Proses</span>
                    @elseif($dt->status=='pinjam')
                    <span class="badge badge-primary">Dipinjam</span>
                    @elseif($dt->status=='kembali')
                    <span class="badge badge-success">Kembali</span>
                    @elseif($dt->status=='rusak')
                    <span class="badge badge-danger">Rusak</span>
                    @elseif($dt->status=='hilang')
                    <span class="badge badge-warning">Kembali</span>
                    @endif
                </td>
                <td>Rp. {{number_format($dt->denda)}}</td>
            </tr>
            @endforeach
        </tbody>

        <!-- Tabel End -->
    </table>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-default modal-dialog-centered modal-" role="document">
        <div class="modal-content">

            <div class="modal-header">
                Pilih Panggal
            </div>
            <div class="modal-body">

                <form role="form" action="{{ url('admin/laporan/periodepdf') }}" method="get">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Dari Tanggal</label>
                            <input type="date" class="form-control datepicker" id="inputtgl" placeholder="Dari Tanggal" name="dari" autocomplete="off" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Sampai tanggal</label>
                            <input type="date" class="form-control datepicker" name="sampai" id="inputtgl2" placeholder="Sampai Tanggal" autocomplete="off" value="{{ date('Y-m-d') }}">
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa  fa-power-off"></i> Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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