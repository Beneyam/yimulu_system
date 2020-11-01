@extends('layouts.app')
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><a class="text-success" href="{{route('admin.transactions.topup')}}">Send Yimulu</a></h1>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>


<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2 col-sm-1"></div>
      <div class="col-lg-9 col-sm-10">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Ethiotel Topup</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{route('admin.transactions.send')}}" method="POST">
              @csrf
              <div class="row">
                <div class="form-group col-12">
                  <label for="type">Type</label>
                  <select class="form-control" name="sales_type" id="type">
                    <option value="0">Top up</option>
                    <option value="1">Bill</option>

                  </select>
                </div>
                <div class="form-group col-md-6 col-lg-6 col-12">
                  <label for="phone">Zemed's Phone</label>
                  <input type="number" class="form-control" id="phone" name="phone_number" placeholder="09xxxxxxxx">
                </div>
                <div class="form-group col-md-6 col-lg-6 col-12">
                  <label for="phone">Zemed's Name</label>
                  <input type="string" class="form-control" id="recipient_name" name="recipient_name" >
                </div>
           
                <div class="form-group col-md-6 col-lg-6 col-12">
                  <label for="sender_phone_number">Sender's Phone</label>
                  <input type="number" class="form-control" id="sender_phone_number" name="sender_phone_number" placeholder="xxxxxx">
                </div>
                <div class="form-group col-md-6 col-lg-6 col-12">
                  <label for="sender_name">Sender's Name</label>
                  <input type="text" class="form-control" id="sender_name" name="sender_name">
                </div>
                <div class="form-group col-12">

                  <label for="buttons">Amount to send (USD)</label>
                  <div id="buttons">
                    @foreach($conversions as $conversion)
                    
                    <input type="button" class="btn btn-danger" value="${{$conversion->dollar}}" onclick="addConversion(this)" usd="{{$conversion->dollar}}" birr="{{$conversion->birr}}">
  
                    <!-- /.col -->
                    @endforeach
                  </div>
                </div>
                <div class="form-group col-md-4 col-lg-4 col-12">
                  <label for="amount">Sender's Pay($)</label>
                  <input readonly class="form-control" name="amount_usd" type="number" id="amount_usd" placeholder="in USD">
                </div>
                <div class="form-group col-md-4 col-lg-4 col-12">
                  <label for="amount">Receive Amount(approx. ETB)</label>
                  <input readonly class="form-control" name="amount" type="number" id="amount" placeholder="in ETB" required>
                
                </div>
                <div class="form-group col-md-4 col-lg-4 col-12">
                  <label for="bonus">Amount+Bonus(ETB)</label>
                  <input readonly class="form-control" type="number" id="bonus" placeholder="in ETB">
                 
                </div>
              </div>
              <div class="float-right">
                <button type="submit" class="btn btn-primary">send</button>
              </div>
            </form>
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
function addConversion(element) {
   console.log('gothere');
  //console.log(element.getAttribute('birr'));
  var birr=element.getAttribute('birr');
  var dollar=element.getAttribute('usd');
  var withbonus=birr*1.5;
  //console.log(withbonus);
  $('#amount').val(birr);
  $('#amount_usd').val(dollar);
  $('#bonus').val(withbonus);

}
</script>
@endsection