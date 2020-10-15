
@extends('admin.users.base')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
            <div class="card-header">
              <div class="row">
            <div class="col-sm-10">
              <h3 class="card-title"> Staff Agent Lists</h3>
            </div>
              <div class="col-sm-2">
                <a class="btn 
btn-primary

" href="{{ route('admin.users.create') }}">Add new</a>
              </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example1" class="example1 table table-striped table-bordered"  style="width:100%">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Parent</th>
                  <th>Balance</th>
                  <th>Receivables</th>
                  <th>Roles</th>
                  <th>Action</th>                  
                </tr>
                </thead>
                <tbody>
                
                    @php
                        $i=1;

                    @endphp
                    @foreach($users as $user)
                    <tr>
                  <td>{{$i}}</td>
                    @php
                        $i++; 

                    @endphp
                  <td><a href="{{ route('admin.users.show', ['user' => $user->id]) }}">{{$user->name}}</a></td>
                  <td>{{$user->phone_number}}</td>                  
                  <td>{{$user->parent->name}}</td>
                  <td>{{App\Http\Controllers\StatController::getAgentBalance($user->id)}}</td>
                  <td>{{App\Http\Controllers\StatController::getAgentDebt($user->id)}}</td>
                  <td>{{implode(', ',$user->roles()->get()->pluck('name')->toArray())}}</td>
                  <td>
                    <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" style="width:100%" class="btn btn-primary"><i class="mdi mdi-cloud-download"></i>Edit</a>
                                      
                    
                  </td>
                  </tr>
                  @endforeach
                
                </tbody>
                
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
            </div>
        </div>
    </div>
</section>
@endsection