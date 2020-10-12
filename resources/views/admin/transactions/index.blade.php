@extends('admin.transactions.base')
@section('styles')
<link href="{{asset('/dist/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection
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
                <h3 class="box-title">Transactions</h3>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-success" href="{{ route('admin.transactions.create') }}">Add new</a>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            
            <table id="example" class="example1 table table-striped table-bordered"  style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Type</th> 
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @php
                $i=1;
                @endphp
                @foreach($transactions as $transaction)
                <tr>
                  <td>{{$i}}</td>
                  @php
                  $i++;
                  @endphp
                  
                  <td>{{$transaction->type}}</td>
                 
                </tr>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                <tr>
                  <th>No</th>
                  <th>Type</th>
                  
                  <th>Action</th>
                </tr>
              </tfoot>
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

  <script src="{{asset('/dist/js/jquery-3.3.1.js')}}"></script>
  <script src="{{asset('/dist/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('/dist/js/dataTables.bootstrap4.min.js')}}"></script>
  <script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
@endsection