@extends('admin.reports.base')
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
                <h3 class="box-title">Agent Sales</h3>
              </div>

            </div>
            <div class="row">
              <form role="form" action="{{route('admin.reports.agentsales')}}" method="POST" class="col-12">
                @csrf
                <div class="row">
                  <div class="col col-sm-4">
                    <!-- text input -->
                    <div class="form-group">
                      <label>From</label>
                      <input type="date" class="form-control" name="first_date" value="{{$first_date}}">
                    </div>
                  </div>
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <label>To</label>
                      <input type="date" class="form-control" name="last_date" value="{{$last_date}}">
                    </div>
                  </div>

                  <div class="col col-sm-4">
                    <div class="form-group">
                      <label> </label>

                      <button class="btn btn-primary form-control">Filter</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <div class="row my-2 py-2 ">
              <div class="dropdown float-right">
                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Actions
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="table-actions">

                </div>
              </div>
            </div>
            <div class="my-auto">
              <table id="report" class="display">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Agent Name</th>
                    <th>Phone Number</th>
                   
                    <th>Amount</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>

                  @php
                  $i=1;
                  $total_amount=0;
                 
                  @endphp
                  @foreach($sales as $sale)
                  <tr>
                    <td>{{$i}}</td>
                    @php
                    $i++;
                    $total_amount+=$sale->amount;
                    @endphp

                    <td>{{$sale->name}}</td>
                    <td>{{$sale->phone_number}}</td>
                    
                    <td>{{number_format($sale->amount)}}</td>
                    <td>{{$sale->date}}</td>
                  </tr>
                  @endforeach

                </tbody>
                <tfoot>

                  <tr>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                     <th>{{number_format($total_amount)}}</th>
                    <th></th>

                  </tr>
                </tfoot>
              </table>
            </div>
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

<script src="{{asset('/dist/js/jquery-3.3.1.js')}}"></script>
<script src="{{asset('/dist/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/dist/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/dist/js/jszip.min.js')}}"></script>
<script src="{{asset('/dist/js/pdfmake.min.js')}}"></script>
<script src="{{asset('/dist/js/vfs_fonts.js')}}"></script>
<script src="{{asset('/dist/js/buttons.html5.min.js')}}"></script>



@endsection

@section('styles')
<link href="{{asset('/dist/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('/dist/css/jbuttons.dataTables.min.css')}}" rel="stylesheet">
@endsection