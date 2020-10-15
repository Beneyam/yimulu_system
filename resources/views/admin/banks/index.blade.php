@extends('admin.banks.base')
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
                <h3 class="box-title">Banks</h3>
              </div>
              <div class="col-sm-2">
                <a class="btn 
btn-primary

" href="{{ route('admin.banks.create') }}">Add new</a>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Branch</th>
                  <th>Account Number</th>
                  <th>Address</th>

                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @php
                $i=1;
                @endphp
                @foreach($banks as $bank)
                <tr>
                  <td>{{$i}}</td>
                  @php
                  $i++;
                  @endphp
                  
                  <td>{{$bank->name}}</td>
                  <td>{{$bank->branch}}</td>
                  <td>{{$bank->account_number}}</td>

                  <td>{{$bank->address}}</td>
                  <td>
                    <a href="{{ route('admin.banks.edit', ['bank' => $bank->id]) }}" style="width:100%" class="btn btn-primary"><i class="mdi mdi-cloud-download"></i>Edit</a>


                  </td>
                </tr>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Branch Name</th>
                  <th>Account Number</th>
                  <th>Address</th>

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