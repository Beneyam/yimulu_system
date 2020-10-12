
@extends('admin.userstatuses.base')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-2 col-sm-1"></div>
            <div class="col-lg-9 col-sm-10">
            <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Edit Status: {{$userstatus->name}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="{{route('admin.userstatuses.update',$userstatus)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">

                                <label for="status" class="col-md-4 control-label">Status Name</label>

                                <div class="col-md-6">
                                    <input type="text" id="status" class="form-control" name="status" value="{{$userstatus->status}}">
                                    @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                               
                                </div>
                               
                            </div>
                           
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
            </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
            </div>
        </div>
    </div>
</section>
@endsection