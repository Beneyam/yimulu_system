
@extends('admin.users.base')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
            <div class="card-header">
              <h3 class="card-title">Agent Lists</h3>
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
                  <td>{{isset($user->parent_id)?$user->parent->name:''}}</td>
                  
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