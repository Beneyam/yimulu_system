@extends('admin.conversions.base')
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
                <h3 class="box-title">Conversions</h3>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-primary" href="{{ route('admin.conversions.create') }}">Add new</a>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Dollar</th>
                  <th>Birr</th>
                  <th>Comission Factor</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @php
                $i=1;
                @endphp
                @foreach($conversions as $conversion)
                <tr>
                  <td>{{$i}}</td>
                  @php
                  $i++;
                  @endphp

                  <td>{{$conversion->dollar}}</td>
                  <td>{{$conversion->birr}}</td>

                  <td>{{$conversion->commission}}</td>
                  <td>
                    <a href="{{ route('admin.conversions.edit', ['conversion' => $conversion->id]) }}" style="width:100%" class="btn btn-primary"><i class="mdi mdi-cloud-download"></i>Edit</a>
                  </td>
                </tr>
                @endforeach

              </tbody>

            </table>
          </div>
          <h5>Note: only the first five conversions will be visible at home page</h5>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>
@endsection
