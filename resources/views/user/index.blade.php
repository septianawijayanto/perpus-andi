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
                <th>Email</th>
                <th>level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $e=>$dt)

            <tr>
                <td>{{$e+1}}</td>
                <td>{{$dt->name}}</td>
                <td>{{$dt->email}}</td>
                <td>{{$dt->role}}</td>
                <td>
                    <a href="{{url('/user/edit/'.$dt->id)}}" class="btn btn-success btn-sm btn-flat">Edit</a>
                    <a href="{{url('/user/delete/'.$dt->id)}}" class="btn btn-danger btn-sm btn-flat" onclick="return confirm ('Apakah Akan Anda Hapus?')">Hapus</a>
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
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('user/create') }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group {{$errors->has('name') ? 'has-error' :''}}">
                        <label for="exampleFormControlInput1">Name</label>
                        <input name="name" type="text" class="form-control" id="inputname" placeholder="Input name" value="{{old('name')}}">
                        @if($errors->has('name'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('name')}}</span>
                        @endif
                    </div>

                    <div class="form-group {{$errors->has('email') ? 'has-error' :''}}">
                        <label for="exampleFormControlInput1">Email</label>
                        <input name="email" type="email" class="form-control" id="inputemail" placeholder="Input email" value="{{old('email')}}">
                        @if($errors->has('email'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('role') ? 'has-error' :''}}">
                        <label for="exampleFormControlSelect1">Pilih Level</label>
                        <select name="role" class="form-control" id="exampleFormControlSelect1">
                            <option value="">-Pilih-</option>
                            <option value="admin" {{(old('role') == 'admin')? 'selected':''}}>Admin</option>
                            {{-- <option value="siswa" {{(old('role') == 'siswa')? 'selected':''}}>Siswa</option> --}}
                        </select>
                        @if($errors->has('role'))
                        <span class="right badge badge-danger" class=" help-block">{{$errors->first('role')}}</span>
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