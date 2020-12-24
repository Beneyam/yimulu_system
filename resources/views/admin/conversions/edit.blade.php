
@extends('admin.conversions.base')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-2 col-sm-1"></div>
            <div class="col-lg-9 col-sm-10">
            <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Edit Conversion: ${{$conversion->dollar}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="{{route('admin.conversions.update',$conversion)}}" method="POST">
                @csrf
                {{method_field('PUT')}}

                <div class="form-group{{ $errors->has('dollar') ? ' has-error' : '' }}">

                                <label for="dollar" class="col-md-4 control-label">Dollar Name</label>

                                <div class="col-md-6">
                                    <input type="text" id="dollar" class="form-control" name="dollar" value="{{$conversion->dollar}}">
                                    @if ($errors->has('dollar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dollar') }}</strong>
                                    </span>
                                    @endif

                                </div>

                            </div>
                            <div class="form-group{{ $errors->has('birr') ? ' has-error' : '' }}">
                                <label for="birr" class="col-md-4 control-label">Birr</label>

                                <div class="col-md-6">
                                    <input type="text" id="birr" class="form-control" name="birr" value="{{$conversion->birr}}">
                                    @if ($errors->has('birr'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birr') }}</strong>
                                    </span>
                                    @endif

                                </div>

                            </div>
                            <div class="form-group{{ $errors->has('commission') ? ' has-error' : '' }}">
                                <label for="commission" class="col-md-4 control-label">Commission Factor</label>

                                <div class="col-md-6">
                                    <input type="text" id="commission" class="form-control" name="commission" value="{{$conversion->commission}}">
                                    @if ($errors->has('commission'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('commission') }}</strong>
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
