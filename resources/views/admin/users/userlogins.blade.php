
@extends('admin.users.base')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
            <div class="card-header">
              <h3>Login Details</h3>
              <h5>{{$user->name}},{{$user->phone}}</h5>
              <p>Parent:{{$user->parent->name}},{{$user->parent->phone_number}}</p>
            </div>
            <!-- /.card-header -->

            <div class="card-body table-responsive">
              <table id="example1" class="example1 table table-striped table-bordered"  style="width:100%">
                <thead>
                <tr>
                  <th>No</th>
                  <th>App Version</th>
                  <th>Phone Model</th>
                  <th>Phone Id</th>
                  <th>Login Time</th>
                  <th>Location</th>    

                </tr>
                </thead>
                <tbody>
                
                    @php
                        $i=1;
                    @endphp
                    @foreach($logins as $login)
                    <tr>
                  <td>{{$i}}</td>
                    @php
                        $i++;  
                    @endphp
                  <td>{{$login->app_version}}</td> 
                  <td>{{$login->phone_model}}</td>  
                  <td>{{$login->phone_id}}</td> 
                  <td>{{$login->created_at}}</td>        
                  <td>{{$login->longitude}},{{$login->latitude}} </td>
                  
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