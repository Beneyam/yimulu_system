@extends('admin.users.base')
@section('main-content')

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Edit User: {{$user->name}}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{route('admin.users.update',$user)}}" method="POST">
              @csrf
              {{method_field('PUT')}}
              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Name</label>

                <div class="col-md-6">
                  <input type="text" id="name" class="form-control" name="name" value="{{$user->name}}">
                </div>
                

              </div>
              <div class="form-group{{ $errors->has('commission') ? ' has-error' : '' }}">
                <label for="commission" class="col-md-4 control-label">Commission</label>

                <div class="col-md-6">
                  <input type="number" id="commission" class="form-control" name="commission" value="{{$user->commission}}">
                </div>
                

              </div>
              <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                <label for="roles" class="col-md-4 control-label">Roles</label>

                <div class="col-md-6">

                  @foreach($roles as $role)
                  <div class="form-check">
                    <input id="roles" type="checkbox" name="roles[]" value="{{$role->id}}" {{$user->hasRole($role->name)?'checked':''}}>
                    <label>{{$role->name}}</label>
                  </div>

                  @endforeach
                </div>
                <button class="btn btn-primary">Update</button>
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