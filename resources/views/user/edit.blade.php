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
            <form action="{{ url('/user/update/'.$data->id) }}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group {{$errors->has('name') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">Name</label>
                    <input name="name" type="text" class="form-control" id="inputnisn" placeholder="Input Name" value="{{$data->name}}">
                    @if($errors->has('name'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('name')}}</span>
                    @endif
                </div>
                <div class="form-group {{$errors->has('email') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">Email</label>
                    <input name="email" type="email" class="form-control" id="inputnoinduk" placeholder="Input email" value="{{$data->email}}">
                    @if($errors->has('email'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('email')}}</span>
                    @endif
                </div>

                <div class="form-group {{$errors->has('password') ? 'has-error' :''}}">
                    <label for="exampleFormControlInput1">password</label>
                    <input name="password" type="password" class="form-control" id="inputnoinduk" placeholder="Input password" value="{{$data->password}}">
                    @if($errors->has('password'))
                    <span class="right badge badge-danger" class=" help-block">{{$errors->first('password')}}</span>
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