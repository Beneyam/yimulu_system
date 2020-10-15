@extends('admin.deposits.base')
@section('main-content')

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">

            <div class="row">
              <div class="col-sm-9">
                <h3 class="box-title">deposits</h3>
              </div>
              <div class="col-sm-3">
                <a class="btn 
btn-primary

" href="{{ route('admin.deposits.create') }}">Record My Deposits</a>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>

                  <th>Staff</th>

                  <th>Deposited By</th>
                  <th>Bank</th>
                  <th>Branch</th>
                  <th>Account Number</th>
                  <th>Amount</th>
                  <th>Ref</th>
                  <th>Remark</th>
                  <th>System Date</th>
                  <th>Deposit Date</th>
                  <th>Status</th>
                  
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @php
                $i=1;
                @endphp
                @foreach($deposits as $deposit)
                <tr>
                  <td>{{$i}}</td>
                  @php
                  $i++;
                   $textstat='text-warning';
                  $stat='Not Approved';

                  if($deposit->status==1){
                    $stat='Approved';
                    $textstat='text-success';

                  }
                  
                  if($deposit->status==2){
                    $stat='Canceled';
                    $textstat='text-danger';                    
                  }
                  @endphp
                  <td>{{$deposit->staff}}</td>

                  <td>{{$deposit->agent}}</td>
                  <td>{{$deposit->bank_name}}</td>
                  <td>{{$deposit->branch_name}}</td>
                  <td>{{$deposit->account_number}}</td>

                  <td>{{$deposit->amount}}</td>
                  <td>{{$deposit->ref_number}}</td>
                  <td>{{$deposit->remark}}</td>

                  <td>{{$deposit->date}}</td>
                  <td>{{$deposit->deposit_date}}</td>
                  <td class="{{$textstat}}">{{$stat}}</td>
                  <td>
                    @can('verify-deposits')
                    @if($deposit->status==0)
                    <div class="row">
                      <div class="col col-6">
                        <form method="POST" action="{{route('admin.deposits.approve')}}">
                          @csrf
                          <input name="id" value="{{$deposit->id}}" hidden>
                          <button class="btn btn-primary" type="submit">Approve</button>
                        </form>

                      </div>
                      <div class="col col-6">
                        <form method="POST" action="{{route('admin.deposits.cancel')}}">
                          @csrf
                          <input name="id" value="{{$deposit->id}}" hidden>
                          <button class="btn btn-warning" type="submit">Cancel</button>
                        </form>
                      </div>
                    </div>
                    @endif

                    @endcan

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