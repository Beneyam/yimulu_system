@extends('yimulu.base')
@section('main-content')

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2 col-sm-1"></div>
      <div class="col-lg-9 col-sm-10">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Record New Purchase</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form method='post' action="{{route('purchase.store')}}" enctype="multipart/form-data" id="uform">
              @csrf
              <div class="form-group{{ $errors->has('order_number') ? ' has-error' : '' }}" style="width:100%">

                <label for="order_number" class="col-md-2 control-label">Order Number</label>

                <div class="col-md-6">
                  <input type="text" id="order_number" class="form-control" name="order_number" value="{{old('order_number')}}">
                  @if ($errors->has('order_number'))
                  <span class="help-block">
                    <strong>{{ $errors->first('order_number') }}</strong>
                  </span>
                  @endif

                </div>

              </div>
              <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">

                <label for="amount" class="col-md-4 control-label">Yimulu Amount</label>

                <div class="col-md-6">
                  <input type="text" id="amount" class="form-control" name="amount" value="{{old('amount')}}">
                  @if ($errors->has('amount'))
                  <span class="help-block">
                    <strong>{{ $errors->first('amount') }}</strong>
                  </span>
                  @endif

                </div>

              </div>
              
              <div class="col-md-6">
                <input type="submit" name="submit" class="btn 
btn-primary

 submitBtn float-right" value="Record Purchase">
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
<div class="modal modal" id="#loader">
  <div class="modal-body">
    Here
    <img src="{{asset('dist/img/busy.gif')}}" title="Loading" height="100px" width="120px" />
  </div>

</div>
@endsection


@section('javascript')


<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.5.0/jszip.min.js" integrity="sha512-y3o0Z5TJF1UsKjs/jS2CDkeHN538bWsftxO9nctODL5W40nyXIbs0Pgyu7//icrQY9m6475gLaVr39i/uh/nLA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js" integrity="sha512-gYUM+7JjtBqPPGOgwgOZ+NwjGl+11/EP124oB+ihjlBpLgP5LTh7R/Iwcdy//cgH+QzrjspBiJI5iUegTNww3w==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.min.js" integrity="sha512-VIF8OqBWob/wmCvrcQs27IrQWwgr3g+iA4QQ4hH/YeuYBIoAUluiwr/NX5WQAQgUaVx39hs6l05cEOIGEB+dmA==" crossorigin="anonymous"></script>





@endsection

@section('styles')
<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">


@endsection