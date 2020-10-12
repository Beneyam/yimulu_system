@extends('admin.terminals.base')
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
                <h3 class="box-title">Terminals</h3>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-success" href="{{ route('admin.terminals.create') }}">Add new</a>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Brand</th>
                  <th>Serial number</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @php
                $i=1;
                @endphp
                @foreach($terminals as $terminal)
                <tr>
                  <td>{{$i}}</td>
                  @php
                  $i++;
                  @endphp
                  
                  <td>{{$terminal->brand}}</td>
                  <td>{{$terminal->serial_number}}</td>
                 
                  <td>{{$terminal->terminal_status?'Active':'Inactive'}}</td>
                  <td>
                    <a href="{{ route('admin.terminals.edit', ['terminal' => $terminal->id]) }}" style="width:100%" class="btn btn-primary"><i class="mdi mdi-cloud-download"></i>Edit</a>
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