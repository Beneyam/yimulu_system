
@extends('admin.salestypes.base')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-2 col-sm-1"></div>
            <div class="col-lg-9 col-sm-10">
            <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Edit Status: {{$salestype->name}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="{{route('admin.salestypes.update',$salestype)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                
                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">

                                <label for="type" class="col-md-4 control-label">Type</label>

                                <div class="col-md-6">
                                    <input type="text" id="type" class="form-control" name="type" value="{{$salestype->type}}">
                                    @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
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