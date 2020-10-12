@extends('admin.banks.base')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-sm-1"></div>
            <div class="col-lg-9 col-sm-10">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Create New</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{route('admin.banks.store')}}" method="POST">
                            @csrf

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Bank Name</label>

                                <div class="col-md-6">
                                    <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}">
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif

                                </div>

                            </div>
                            <div class="form-group{{ $errors->has('branch') ? ' has-error' : '' }}">
                                <label for="branch" class="col-md-4 control-label">Branch</label>

                                <div class="col-md-6">
                                    <input type="text" id="branch" class="form-control" name="branch" value="{{old('branch')}}">Branch Name</label>
                                    @if ($errors->has('branch'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('branch') }}</strong>
                                    </span>
                                    @endif

                                </div>

                            </div>

                            <div class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
                                <label for="account_number" class="col-md-4 control-label">Account Number</label>

                                <div class="col-md-6">
                                    <input type="text" id="account_number" class="form-control" name="account_number" value="{{old('account_number')}}">
                                    @if ($errors->has('account_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('account_number') }}</strong>
                                    </span>
                                    @endif

                                </div>

                            </div>
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="col-md-4 control-label">Address</label>

                                <div class="col-md-6">
                                    <input type="textarea" id="address" class="form-control" name="address" value="{{old('address')}}">
                                    @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
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