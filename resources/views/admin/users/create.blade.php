@extends('admin.users.base')
@section('main-content')

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Create new User</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{route('admin.users.store')}}" method="POST">
              @csrf
              <div class="form-group">
                <label for="user_name" class="col-md-4 control-label">User name/phone</label>

                <div class="col-md-6">
                  <input type="text" id="user_name" class="form-control" name="phone_number" value="{{old('phone_number')}}">
                </div>
                

              </div>
              <div class="form-group">
                <label for="password" class="col-md-4 control-label">password</label>

                <div class="col-md-6">
                  <input type="password" id="password" class="form-control" name="password" value="{{old('phone_number')}}">
                </div>
                

              </div>
              <div class="form-group">
                <label for="name" class="col-md-4 control-label">Name</label>

                <div class="col-md-6">
                  <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}">
                </div>
                

              </div>
              <div class="form-group">
                <label for="commission" class="col-md-4 control-label">Commission</label>

                <div class="col-md-6">
                  <input type="number" id="commission" class="form-control" name="commission" value="{{old('commission')}}">
                </div>
                

              </div>
                   <button class="btn btn-primary">Create</button>
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