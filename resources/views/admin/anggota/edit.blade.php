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
            <form action="{{ url('admin/anggota/update/'.$data->id) }}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group {{$errors->has('nama') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">Nama</label>
                    <input name="nama" type="text" class="form-control" id="inputnama" placeholder="Input nama" value="{{$data->nama}}">
                    @if($errors->has('nama'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('nama')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('username') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">Username</label>
                    <input name="username" type="text" class="form-control" id="inputusername" placeholder="Input Username" value="{{$data->username}}">
                    @if($errors->has('username'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('username')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('jenis_anggota') ? 'has-error' :''}}">
                    <label for="exampleFormControlSelec*ut1">Pilih Jenis Anggota</label>
                    <select name="jenis_anggota" class="form-control" id="exampleFormControlSelect1">
                        <option value="">-Pilih-</option>
                        <option value="siswa" @if($data->jenis_anggota=='siswa') selected @endif>Siswa</option>
                        <option value="guru" @if($data->jenis_anggota=='guru') selected @endif>Guru</option>
                        <option value="staf" @if($data->jenis_anggota=='staf') selected @endif>Staf</option>
                    </select>
                    @if($errors->has('jenis_anggota'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('jenis_anggota')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('tempat_lahir') ? 'has-error' :''}}">
                    <label for="exampleFormControlTextarea1">tempat_lahir</label>
                    <textarea name="tempat_lahir" class="form-control" id="exampleFormControlTextarea1" rows="2">{{$data->tempat_lahir}}</textarea>
                    @if($errors->has('tempat_lahir'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('tempat_lahir')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('tgl_lahir') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">Tanggal Lahir</label>
                    <input name="tgl_lahir" type="date" class="form-control" id="inputnoinduk" placeholder="Input No Induk" value="{{$data->tgl_lahir}}">
                    @if($errors->has('tgl_lahir'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('tgl_lahir')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('jk') ? 'has-error' :''}}">
                    <label for="exampleFormControlSelect1">Pilih Jenis Kelamin</label>
                    <select name="jk" class="form-control" id="exampleFormControlSelect1">
                        <option value="">-Pilih-</option>
                        <option value="L" @if($data->jk=='L') selected @endif>L</option>
                        <option value="P" @if($data->jk=='P') selected @endif>P</option>
                    </select>
                    @if($errors->has('jk'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('jk')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('no_hp') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">No Hp</label>
                    <input name="no_hp" type="text" class="form-control" id="inputno_hp" placeholder="Input no_hp" value="{{$data->no_hp}}">
                    @if($errors->has('no_hp'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('no_hp')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('alamat') ? 'has-error' :''}}">
                    <label for="exampleFormControlTextarea1">Alamat</label>
                    <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="2">{{$data->alamat}}</textarea>
                    @if($errors->has('alamat'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('alamat')}}</span>
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