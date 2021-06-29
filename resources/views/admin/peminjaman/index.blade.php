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
                    <span class="badge badge-warning">Kembali</span>
                    @endif
                </td>
                <td>Rp. {{number_format($dt->denda)}}</td>
                <td>
                    @if($dt->status=='proses')
                    <a href="{{url('admin/peminjaman/setujui/'.$dt->id)}}" class="btn btn-primary btn-sm btn-flat">Setujui</a>
                    <a href="{{url('admin/peminjaman/tolak/'.$dt->id)}}" class="btn btn-danger btn-sm btn-flat">Tolak</a>
                    @elseif($dt->status=='pinjam')
                    <a href="{{url('admin/peminjaman/perpanjang/'.$dt->id)}}" class="btn btn-success btn-sm btn-flat">Perpanjang</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <!-- Tabel End -->
    </table>
</div>
<div class="modal" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/peminjaman/create') }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group {{$errors->has('kode_transaksi') ? 'has-error' :''}}">
                        <label for="exampleFormControlInput1">Kode Transaksi</label>
                        <input name="kode_transaksi" type="text" class="form-control" id="inputkode" required readonly placeholder="Input kode" value="{{$kode}}">
                        @if($errors->has('kode_transaksi'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('nisn')}}</span>
                        @endif
                    </div>

                    <div class="form-group {{$errors->has('anggota_id') ? 'has-error' :''}}">
                        <label for="exampleFormControlSelect1">Nama</label>
                        <select name="anggota_id" class="form-control" id="exampleFormControlSelect1">
                            <option value="">-Pilih-</option>
                            @foreach ($anggota as $ang)
                            <option value="{{$ang->id}}">{{$ang->nama}} ({{$ang->jenis_anggota}})</option>
                            @endforeach
                        </select>
                        @if($errors->has('anggota_id'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('anggota_id')}}</span>
                        @endif
                    </div>


                    <div class="form-group {{$errors->has('buku_id') ? 'has-error' :''}}">
                        <label for="exampleFormControlSelect1">Judul Buku</label>
                        <select name="buku_id" class="form-control" id="exampleFormControlSelect1">
                            <option value="">-Pilih-</option>
                            @foreach ($buku as $ang)
                            <option value="{{$ang->id}}">{{$ang->judul}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('buku_id'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('buku_id')}}</span>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa  fa-power-off"></i> Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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