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
                <th>Nama</th>
                <th>Username</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $e=>$dt)

            <tr>
                <td>{{$e+1}}</td>
                <td>{{$dt->nama}}</td>
                <td>{{$dt->username}}</td>

                <td>
                    <a href="{{url('admin/admin/edit/'.$dt->id)}}" class="btn btn-success btn-sm btn-flat">Edit</a>
                    <a href="{{url('admin/admin/delete/'.$dt->id)}}" class="btn btn-danger btn-sm btn-flat" onclick="return confirm ('Apakah Akan Anda Hapus?')">Hapus</a>
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
                <h5 class="modal-title">Tambah Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/admin/create') }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group {{$errors->has('nama') ? 'has-error' :''}}">
                        <label for="exampleFormControlInput1">Nama</label>
                        <input name="nama" type="text" class="form-control" id="inputnama" placeholder="Input nama" value="{{old('nama')}}">
                        @if($errors->has('nama'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('nama')}}</span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('username') ? 'has-error' :''}}">
                        <label for="exampleFormControlInput1">Username</label>
                        <input name="username" type="text" class="form-control" id="inputusername" placeholder="Input Username" value="{{old('username')}}">
                        @if($errors->has('username'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('username')}}</span>
                        @endif
                    </div>

                    <div class="form-group {{$errors->has('password') ? 'has-error' :''}}">
                        <label for="exampleFormControlInput1">Password</label>
                        <input name="password" type="password" class="form-control" id="exampleInputEmail1" placeholder="Input Password" value="{{old('password')}}">
                        @if($errors->has('password'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('password')}}</span>
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