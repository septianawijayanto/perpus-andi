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
                <th>Status</th>
                <th>Denda</th>
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
                    <span class="badge badge-warning">Hilang</span>
                    @else
                    <span class="badge badge-warning">Ditolak</span>
                    @endif
                </td>
                <td>Rp. {{number_format($dt->denda)}}</td>
                <td>

                    @if($dt->status=='pinjam')
                    <a href="{{url('admin/pengembalian/kembali/'.$dt->id)}}" class="btn btn-success btn-sm btn-flat">Kembalikan</a>
                    @if($dt->anggota->jenis_anggota=='siswa')
                    <button data-toggle="modal" data-target="#modalrusak-{{$dt->id}}" class="btn btn-danger btn-sm " class="fa fa-check">Rusak</button>
                    <!-- <a href="{{ url('/pinjam/hilang/'.$dt->id) }}" class="btn btn-warning btn-xs " class="fa fa-check">Hilang</a> -->
                    <button data-toggle="modal" data-target="#modalhilang-{{ $dt->id }}" class="btn btn-warning btn-sm " class="fa fa-check">Hilang</button>
                    @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <!-- Tabel End -->
    </table>
</div>
<!-- Modal Hilang-->
@foreach($data as $hilang)
<div class="modal fade" id="modalhilang-{{ $hilang->id }}" tabindex=" -1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Pinjaman</h5>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/pengembalian/hilang/'.$hilang->id) }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group {{$errors->has('denda') ? 'has-error' :''}}">
                        <label for="exampleFormControlInput1">Denda Sebelumnya</label>
                        <input name="denda" type="text" class="form-control" readonly id="inputdhs" placeholder="Denda Sebelumnya" value="{{$hilang->denda}}">
                        @if($errors->has('denda'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('denda')}}</span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('denda') ? 'has-error' :''}}">
                        <label for="exampleFormControlInput1">Denda Hilang</label>
                        <input name="denda" type="text" class="form-control" id="inputdh" placeholder="Input Judul Buku" value="">
                        @if($errors->has('denda'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('denda')}}</span>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas  fa-power-off"></i> Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- Modal Rusak-->
@foreach($data as $rusak)
<div class="modal fade" id="modalrusak-{{ $rusak->id }}" tabindex=" -1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Rusak</h5>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/pengembalian/rusak/'.$rusak->id) }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group {{$errors->has('denda') ? 'has-error' :''}}">
                        <label for="exampleFormControlInput1">Denda Sebelumnya</label>
                        <input name="denda" type="text" class="form-control" id="inputds" readonly placeholder="Denda Sebelumnya" value="{{$rusak->denda}}">
                        @if($errors->has('denda'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('denda')}}</span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('denda') ? 'has-error' :''}}">
                        <label for="exampleFormControlInput1">Denda Rusak</label>
                        <input name="denda" type="text" class="form-control" id="inputdr" placeholder="Denda Rusak" value="">
                        @if($errors->has('denda'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('denda')}}</span>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas  fa-power-off"></i> Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
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