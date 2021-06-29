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
                <th>Cover</th>
                <th>Kode</th>
                <th>ISBN</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Sumber</th>
                <th>Lokasi</th>
                <th>Jumlah Buku</th>
                <th>Aksi</th>
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

                <td>
                    <a href="{{url('admin/buku/edit/'.$dt->id)}}" class="btn btn-success btn-sm btn-flat">Edit</a>
                    <a href="{{url('admin/buku/delete/'.$dt->id)}}" class="btn btn-danger btn-sm btn-flat" onclick="return confirm ('Apakah Akan Anda Hapus?')">Hapus</a>

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
                <h5 class="modal-title">Tambah Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/buku/create') }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group {{$errors->has('judul') ? 'has-error' :''}}">
                        <label for="exampleFormControlInput1">Judul</label>
                        <input name="judul" type="text" class="form-control" id="inputjudul" placeholder="Input judul" value="{{old('judul')}}">
                        @if($errors->has('judul'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('judul')}}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group {{$errors->has('kode_buku') ? 'has-error' :''}}">
                                <label for="exampleFormControlInput1">Kode Buku</label>
                                <input name="kode_buku" type="text" class="form-control" id="inputkode_buku" placeholder="Input kode_buku" value="{{old('kode_buku')}}">
                                @if($errors->has('kode_buku'))
                                <span class="right badge badge-danger" class=" help-block">{{$errors->first('kode_buku')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('isbn') ? 'has-error' :''}}">
                                <label for="exampleFormControlInput1">ISBN</label>
                                <input name="isbn" type="text" class="form-control" id="inputisbn" placeholder="Input isbn" value="{{old('isbn')}}">
                                @if($errors->has('isbn'))
                                <span class="right badge badge-danger" class=" help-block">{{$errors->first('isbn')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('penerbit') ? 'has-error' :''}}">
                                <label for="exampleFormControlInput1">Pengarang</label>
                                <input name="pengarang" type="text" class="form-control" id="inputpengarang" placeholder="Input pengarang" value="{{old('pengarang')}}">
                                @if($errors->has('pengarang'))
                                <span class="right badge badge-danger" class=" help-block">{{$errors->first('pengarang')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('penerbit') ? 'has-error' :''}}">
                                <label for="exampleFormControlInput1">Penerbit</label>
                                <input name="penerbit" type="text" class="form-control" id="inputpenerbit" placeholder="Input penerbit" value="{{old('penerbit')}}">
                                @if($errors->has('penerbit'))
                                <span class="right badge badge-danger" class=" help-block">{{$errors->first('penerbit')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('tahun_terbit') ? 'has-error' :''}}">
                                <label for="exampleFormControlInput1">Tahun Terbit</label>
                                <input name="tahun_terbit" type="text" class="form-control" id="inputtahun_terbit" placeholder="Input tahun_terbit" value="{{old('tahun_terbit')}}">
                                @if($errors->has('tahun_terbit'))
                                <span class="right badge badge-danger" class=" help-block">{{$errors->first('tahun_terbit')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{$errors->has('jml_buku') ? 'has-error' :''}}">
                                <label for="exampleFormControlInput1">Jumlah Buku</label>
                                <input name="jml_buku" type="text" class="form-control" id="inputjml_buku" placeholder="Input jml_buku" value="{{old('jml_buku')}}">
                                @if($errors->has('jml_buku'))
                                <span class="right badge badge-danger" class=" help-block">{{$errors->first('jml_buku')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('sumber') ? 'has-error' :''}}">
                                <label for="exampleFormControlInput1">Sumber</label>
                                <input name="sumber" type="text" class="form-control" id="inputsumber" placeholder="Input sumber" value="{{old('sumber')}}">
                                @if($errors->has('sumber'))
                                <span class="right badge badge-danger" class=" help-block">{{$errors->first('sumber')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('lokasi') ? 'has-error' :''}}">
                                <label for="exampleFormControlInput1">Lokasi</label>
                                <input name="lokasi" type="text" class="form-control" id="inputlokasi" placeholder="Input lokasi" value="{{old('lokasi')}}">
                                @if($errors->has('lokasi'))
                                <span class="right badge badge-danger" class=" help-block">{{$errors->first('lokasi')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('deskripsi') ? 'has-error' :''}}">
                                <label for="exampleFormControlInput1">Deskripsi</label>
                                <input name="deskripsi" type="text" class="form-control" id="inputdeskripsi" placeholder="Input deskripsi" value="{{old('deskripsi')}}">
                                @if($errors->has('deskripsi'))
                                <span class="right badge badge-danger" class=" help-block">{{$errors->first('deskripsi')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('cover') ? 'has-error' :''}}">
                                <label for="exampleFormControlInput1">Cover</label>
                                <input name="cover" type="file" class="form-control" id="inputcover" placeholder="Input covern" value="{{old('cover')}}">
                                @if($errors->has('cover'))
                                <span class="right badge badge-danger" class=" help-block">{{$errors->first('cover')}}</span>
                                @endif
                            </div>
                        </div>
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