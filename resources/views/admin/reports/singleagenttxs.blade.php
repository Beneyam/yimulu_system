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
                <h3 class="box-title">{{$agent->name}} Transactions</h3>
              </div>

            </div>
            <div class="row">
              <form role="form" action="{{route('admin.reports.singleagenttxs')}}" method="POST" class="col-12">
                @csrf
                <input name="agent_id" value="{{$agent->id}}" hidden>
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
                        <th>Time</th>
                        <th>Type</th>
                        <th>To/From</th>
                        <th>Amount</th>
                        <th>Commission</th>
                        <th>Paid Amount</th>

                      </tr>
                    </thead>
                    <tbody>

                      @php
                      $transfers=$transaction_details['transfers'];
                      $deposits=$transaction_details['deposits'];
                      $sdeposits=$transaction_details['sDeposits'];
                      $net_trans=0;
                      $net_pay=0;
                      @endphp
                      @foreach($transfers as $transfer)
                      <tr>
                        @php
                        $net_trans-=$transfer['amount'];
                        $net_pay+=$transfer['amount']*(1-0.01*$transfer['commission']);
                        $receiver=App\User::where('id',$transfer->to_agent)->first();
                        @endphp
                        <td>{{$transfer['created_at']}}</td>
                        <td>Fill</td>
                        <td>{{$receiver->name}}</td>
                        <td>{{$transfer['amount']}}</td>
                        <td>{{$transfer['commission']}}</td>
                        <td>{{$transfer['amount']*(1-0.01*$transfer['commission'])}}</td>

                      </tr>
                      @endforeach
                      @foreach($deposits as $deposit)
                      @php
                      $receiver=App\User::where('id',$deposit->from_agent)->first();
                      $net_trans+=$deposit['amount'];
                      $net_pay-=$deposit['amount']*(1-0.01*$deposit['commission']);
                      @endphp
                      <tr>
                        <td>{{$deposit['created_at']}}</td>
                        <td>Refill</td>
                        <td>{{$receiver->name}}</td>

                        <td>{{$deposit['amount']}}</td>
                        <td>{{$deposit['commission']}}</td>
                        <td>{{$deposit['amount']*(1-0.01*$deposit['commission'])}}</td>
                      </tr>
                      @endforeach
                      @foreach($sdeposits as $sdeposit)
                      <tr>
                        @php
                        $receiver=App\User::where('id',$sdeposit->performed_by)->first();
                        $net_trans+=$sdeposit['amount'];
                        $net_pay-=$sdeposit['amount']*(1-0.01*$sdeposit['commission']);
                     
                        @endphp

                        <td>{{$sdeposit['created_at']}}</td>
                        <td>Refill by System</td>
                        <td>{{$receiver->name}}</td>
                        <td>{{$sdeposit['amount']}}</td>
                        <td>{{$sdeposit['commission']}}</td>
                        <td>{{$sdeposit['amount']*(1-0.01*$sdeposit['commission'])}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                        <td></td>
                        <td></td>
                        <td>Net</td>
                        
                        <td id="net_trans">{{number_format($net_trans)}}</td>
                        <td></td>
                        <td id="net_pay">{{number_format($net_pay)}}</td>
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
    jQuery.fn.dataTable.Api.register( 'sum()', function () {
      return this.flatten().reduce( function ( a, b ) {
        return (a*1) + (b*1); // cast values in-case they are strings
      });
    });

    $("#report").on('search.dt', function() {
        $("#net_trans").html(codeListTable.column( 3, {page:'current'} ).data().sum());
        $("#net_pay").html(codeListTable.column(5, {page:'current'} ).data().sum());
        //console.log(codeListTable.column( 3, {page:'current'} ).data().sum() );
    });
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