
@extends('admin.users.base')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
            <div class="card-header">
              <h3 class="card-title">New Logins</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
            <div class="row my-2 py-2 ">
              <div class="dropdown float-right">
                <button class="btn 
btn-primary

 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Actions
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="table-actions">

                </div>
              </div>
            </div>
              <table id="report" class="example1 table table-striped table-bordered"  style="width:100%">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>parent Pame</th>
                  <th>Parent Phone</th>
                  <th>App Version</th>
                  <th>Phone Model</th>
                  <th>Login Time</th>
                  <th>Location</th>    

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
                  <td><a href="{{ route('admin.users.userlogins', ['user' => $user->id]) }}">{{$user->name}}</a></td>
                  <td>{{$user->phone_number}}</td>  
                  <td>{{$user->parent_name}}</td>
                  <td>{{$user->parent_phone}}</td>
                  <td>{{$user->app_version}}</td> 
                  <td>{{$user->phone_model}}</td>   
                  
                  <td>{{$user->created_at}}</td>        
                  <td id="{{$user->phone_number}}">
                    
                    <script>
                     
                        $.getJSON("https://api.opencagedata.com/geocode/v1/json?key=cbde2c9d230f4094ae33dba497a9dd90&q={{isset($user->latitude)?$user->latitude:0}}%2C+{{isset($user->longitude)?$user->longitude:0}}&pretty=1&no_annotations=1", function(result){
                          //console.log(result.results[0].formatted);
                          $("#{{$user->phone_number}}").html(result.results[0].formatted);
                        });
                     

                     // $.get("https://api.opencagedata.com/geocode/v1/json?key=cbde2c9d230f4094ae33dba497a9dd90&q={{isset($user->longitude)?$user->longitude:0}}%2C+{{isset($user->latitude)?$user->latitude:0}}&pretty=1&no_annotations=1", function(data, status){
                        //data2=$.parseJSON(data);
                      
                        //$("#{{$user->phone_number}}").value(data2.formatted);
                      //});
                    </script>
                    {{$user->longitude}},{{$user->latitude}} </td>
                  
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
@section('javascript')
<script>
  $(document).ready(function() {
    codeListTable = $("#report").DataTable();
    new $.fn.dataTable.Buttons(codeListTable, {
      buttons: [{
          extend: 'copy',
          text: '<i class="fa fa-files-o"></i> Copy',
          titleAttr: 'Copy',
          className: 'btn btn-primary dropdown-item'
        },
        {
          extend: 'csv',
          text: '<i class="fa fa-files-o"></i> CSV',
          titleAttr: 'CSV',
          className: 'btn btn-danger dropdown-item',
          exportOptions: {
            columns: ':visible'
          }
        },
        {
          extend: 'excel',
          text: '<i class="fa fa-files-o"></i> Excel',
          titleAttr: 'Excel',
          className: 'btn btn-danger dropdown-item',
          exportOptions: {
            columns: ':visible'
          }
        },
        {
          extend: 'pdf',
          text: '<i class="fa fa-file-pdf-o"></i> PDF',
          titleAttr: 'PDF',
          className: 'btn btn-danger dropdown-item',
          exportOptions: {
            columns: ':visible'
          }
        },

      ]
    });
    codeListTable.buttons().container().appendTo('#table-actions');
  });
</script>

<script src="{{asset('/dist/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/dist/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/dist/js/jszip.min.js')}}"></script>
<script src="{{asset('/dist/js/pdfmake.min.js')}}"></script>
<script src="{{asset('/dist/js/vfs_fonts.js')}}"></script>







@endsection

@section('styles')
<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">


@endsection