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
                <h3 class="box-title">Invoices</h3>
              </div>

            </div>
            <div class="row">
              <form role="form" action="{{route('admin.reports.invoice')}}" method="POST" class="col-12">
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
                <button class="btn 
btn-primary

 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    <th>Amount</th>
                    <th>Average Commission</th>
                    <th>To be Collected</th>
                    <th>Performed By</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  @php
                  $i=1;
                  $total_amount=0;
                  $total_receivables=0;
                  @endphp
                  @foreach($refills as $refill)
                  <tr>
                    <td>{{$i}}</td>
                    @php
                    $i++;
                    $total_amount+=$refill->amount;
                    $receivable=$refill->amount-$refill->amount*$refill->commission*0.01;
                    $total_receivables+=$receivable;
                    @endphp

                    <td>{{$refill->agent_name}}</td>
                    <td>{{number_format($refill->amount)}}</td>
                    <td>{{number_format($refill->commission)}}</td>
                    <td>{{number_format($receivable)}}</td>
                    <td>{{$refill->staff_name}}</td>
                     <td>
                      <form role="form" action="{{route('admin.reports.invoiceprint')}}" method="POST">
                          @csrf
                        <input name="first_date" value="{{$first_date}}" hidden>
                        <input name="last_date" value="{{$last_date}}" hidden>
                        <input name="agent_id" value="{{$refill->agent_id}}" hidden>
                        <input name="staff_id" value="{{$refill->staff_id}}" hidden>
                        <button class="btn 
btn-primary

" type="submit">Make Invoice</button>
                      </form>
                    </td>
                  </tr>
                  @endforeach

                </tbody>
                <tfoot>

                  <tr>
                    <th></th>
                    <th>Total</th>
                    <th>{{number_format($total_amount)}}</th>
                    <th></th>
                    <th>{{number_format($total_receivables)}}</th>
                    <th></th>
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

<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.5.0/jszip.min.js" integrity="sha512-y3o0Z5TJF1UsKjs/jS2CDkeHN538bWsftxO9nctODL5W40nyXIbs0Pgyu7//icrQY9m6475gLaVr39i/uh/nLA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js" integrity="sha512-gYUM+7JjtBqPPGOgwgOZ+NwjGl+11/EP124oB+ihjlBpLgP5LTh7R/Iwcdy//cgH+QzrjspBiJI5iUegTNww3w==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.min.js" integrity="sha512-VIF8OqBWob/wmCvrcQs27IrQWwgr3g+iA4QQ4hH/YeuYBIoAUluiwr/NX5WQAQgUaVx39hs6l05cEOIGEB+dmA==" crossorigin="anonymous"></script>








@endsection

@section('styles')
<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">


@endsection