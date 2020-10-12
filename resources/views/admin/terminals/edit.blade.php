
@extends('admin.terminals.base')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-2 col-sm-1"></div>
            <div class="col-lg-9 col-sm-10">
            <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Edit Terminal: {{$terminal->name}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="{{route('admin.terminals.update',$terminal)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                
                <div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}">

                                <label for="brand" class="col-md-4 control-label">Brand Name</label>

                                <div class="col-md-6">
                                    <input type="text" id="brand" class="form-control" name="brand" value="{{$terminal->name}}">
                                    @if ($errors->has('brand'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brand') }}</strong>
                                    </span>
                                    @endif
                               
                                </div>
                               
                            </div>
                            <div class="form-group{{ $errors->has('serial_number') ? ' has-error' : '' }}">
                                <label for="serial_number" class="col-md-4 control-label">Serial Number</label>

                                <div class="col-md-6">
                                    <input type="text" id="serial_number" class="form-control" name="serial_number" value="{{$terminal->serial_number}}">
                                    @if ($errors->has('serial_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serial_number') }}</strong>
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