@extends('admin.salestypes.base')
@section('styles')



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
                <h3 class="box-title">Sales Types</h3>
              </div>
              <div class="col-sm-2">
                <a class="btn 
btn-primary

" href="{{ route('admin.salestypes.create') }}">Add new</a>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            
            <table id="example" class="display" >
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
                @foreach($salestypes as $salestype)
                <tr>
                  <td>{{$i}}</td>
                  @php
                  $i++;
                  @endphp
                  
                  <td>{{$salestype->type}}</td>
                  <td>
                    <a href="{{ route('admin.salestypes.edit', ['salestype' => $salestype->id]) }}" style="width:100%" class="btn btn-primary"><i class="mdi mdi-cloud-download"></i>Edit</a>


                  </td>
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




  <script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
@endsection