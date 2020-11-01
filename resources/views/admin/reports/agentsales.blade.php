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
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    <th>User Name</th>
                    <th>Recipient</th>
                    <th>Sender</th>
                    <th>Amount|ETB</th>
                    <th>Amount|USD</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>

                  @php
                  $i=1;
                  $total_amount=0;
                  $total_amount_usd=0;
                 
                  @endphp
                  @foreach($sales as $sale)
                  <tr>
                    <td>{{$i}}</td>
                    @php
                    $i++;
                    $total_amount+=$sale->amount;
                    $total_amount_usd+=$sale->amount_usd;
                    @endphp

                    <td>{{$sale->name}}</td>
                    <td>{{$sale->phone_number}}</td>
                    <td>{{$sale->recipient_name}},{{$sale->zemed_phone}}</td>
                    <td>{{$sale->sender_name}},{{$sale->sender_phone_number}}</td>
                    <td>{{number_format($sale->amount)}}</td>
                    <td>{{number_format($sale->amount_usd)}}</td>
                    <td>{{$sale->date}}</td>
                  </tr>
                  @endforeach

                </tbody>
                <tfoot>

                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                     <th>{{number_format($total_amount)}}</th>
                     <th>{{number_format($total_amount_usd)}}</th>
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


<script src="https://cdn.datatables.net/1.10.22/js/dataTables.jqueryui.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.5.0/jszip.min.js" integrity="sha512-y3o0Z5TJF1UsKjs/jS2CDkeHN538bWsftxO9nctODL5W40nyXIbs0Pgyu7//icrQY9m6475gLaVr39i/uh/nLA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js" integrity="sha512-gYUM+7JjtBqPPGOgwgOZ+NwjGl+11/EP124oB+ihjlBpLgP5LTh7R/Iwcdy//cgH+QzrjspBiJI5iUegTNww3w==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.min.js" integrity="sha512-VIF8OqBWob/wmCvrcQs27IrQWwgr3g+iA4QQ4hH/YeuYBIoAUluiwr/NX5WQAQgUaVx39hs6l05cEOIGEB+dmA==" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>







@endsection

@section('styles')
<link href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.jqueryui.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.22/css/dataTables.jqueryui.min.css" rel="stylesheet">


@endsection