@extends('layouts.backend.master')
@section('konten')
<div class="card-header border-0">
    <div class="row align-items-center">
        <div class="col">
            <a href="#!" class="btn btn-sm btn-warning btn-refresh">Refresh</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card-body">
            <!-- Konten -->
            <form action="{{ url('admin/buku/update/'.$data->id) }}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group {{$errors->has('kode_buku') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">kode_buku</label>
                    <input name="kode_buku" type="text" class="form-control" id="inputkode_buku" placeholder="Input kode_bukun" value="{{$data->kode_buku}}">
                    @if($errors->has('kode_buku'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('kode_buku')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('isbn') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">isbn</label>
                    <input name="isbn" type="text" class="form-control" id="inputisbn" placeholder="Input isbnn" value="{{$data->isbn}}">
                    @if($errors->has('isbn'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('isbn')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('judul') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">judul</label>
                    <input name="judul" type="text" class="form-control" id="inputjudul" placeholder="Input juduln" value="{{$data->judul}}">
                    @if($errors->has('judul'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('judul')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('pengarang') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">pengarang</label>
                    <input name="pengarang" type="text" class="form-control" id="inputpengarang" placeholder="Input pengarangn" value="{{$data->pengarang}}">
                    @if($errors->has('pengarang'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('pengarang')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('penerbit') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">penerbit</label>
                    <input name="penerbit" type="text" class="form-control" id="inputpenerbit" placeholder="Input penerbitn" value="{{$data->penerbit}}">
                    @if($errors->has('penerbit'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('penerbit')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('tahun_terbit') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">tahun_terbit</label>
                    <input name="tahun_terbit" type="text" class="form-control" id="inputtahun_terbit" placeholder="Input tahun_terbitn" value="{{$data->tahun_terbit}}">
                    @if($errors->has('tahun_terbit'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('tahun_terbit')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('jml_buku') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">jml_buku</label>
                    <input name="jml_buku" type="text" class="form-control" id="inputjml_buku" placeholder="Input jml_bukun" value="{{$data->jml_buku}}">
                    @if($errors->has('jml_buku'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('jml_buku')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('sumber') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">sumber</label>
                    <input name="sumber" type="text" class="form-control" id="inputsumber" placeholder="Input sumbern" value="{{$data->sumber}}">
                    @if($errors->has('sumber'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('sumber')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('lokasi') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">lokasi</label>
                    <input name="lokasi" type="text" class="form-control" id="inputlokasi" placeholder="Input lokasin" value="{{$data->lokasi}}">
                    @if($errors->has('lokasi'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('lokasi')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('deskripsi') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">deskripsi</label>
                    <input name="deskripsi" type="text" class="form-control" id="inputdeskripsi" placeholder="Input deskripsin" value="{{$data->deskripsi}}">
                    @if($errors->has('deskripsi'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('deskripsi')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('cover') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">cover</label>
                    <input name="cover" type="file" class="form-control" id="inputcover" placeholder="Input covern">
                    @if($errors->has('cover'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('cover')}}</span>
                    @endif
                </div>


                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
            <!-- Konten End -->
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