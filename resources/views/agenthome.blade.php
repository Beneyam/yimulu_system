@extends('layouts.app')
@section('styles')
<style>
  .right-divider {
    text-align: center;
    border-right: 1px solid 
#0f75bc

;
  }

  .bottom-divider {
    text-align: center;
    padding: 10px;
    margin: auto;
    width: 60%;
    border-bottom: 1px solid 
#0f75bc

;
  }

  .chartWithMarkerOverlay {
    position: relative;

  }



  .overlay-marker {
    width: 100px;
    height: 100px;
    position: absolute;
    top: 53px;
    /* chartArea top */
    left: 100px;
    /* chartArea left */
  }
</style>
@endsection
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Staff Agent Dashboard</h1>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- Default box -->
        <div class="card" style="background-color:#003366 ">
          <div class="card-header">
            <h1 class="card-title text-white">Today</h1>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="row ">
              
              <div class="col col-lg-4 col-md-4 col-12 right-divider mt-2">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-piggy-bank fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="agentbalance">{{number_format($balance)}} Birr</h4>
                    <p>Agent's Balance</p>
                  </div>
                </div>
                <div class="bottom-divider"></div>
              </div>
              <div class="col col-lg-4 col-md-4 col-12 right-divider mt-2">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-user-plus fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="subagentBalance">{{number_format($subagentBalance)}}</h4>
                    <p>Direct Subagent's Balance</p>
                  </div>
                </div>
                <div class="bottom-divider"></div>
              </div>
              <div class="col col-lg-4 col-md-4 col-12  mt-2">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-user-tie fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="tsubagentbalance">{{number_format($totalSubagentBalance-$subagentBalance)}}</h4>
                    <p>Indirect Subagent's Balance</p>
                  </div>
                </div>
                <div class="bottom-divider"></div>
              </div>
            </div>
            <div class="row">
              <div class="col right-divider col-lg-4 col-md-4 col-12 mt-2">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-money-check fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="yimulu_sales">{{number_format($sales)}}</h4>
                    <p>Yimulu Sales</p>
                  </div>
                </div>
                <div class="bottom-divider"></div>
              </div>
              <div class="col col-lg-4 col-md-4 col-12 right-divider mt-2">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-share fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="balance_refills">{{number_format($transaction['refills'])}}</h4>
                    <p>Balance Refills</p>
                  </div>
                </div>
                <div class="bottom-divider"></div>
              </div>
              <div class="col col-lg-4 col-md-4 col-12  mt-2 ">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-archive fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="receivable">{{number_format($transaction['fills'])}} Birr</h4>
                    <p>Balance Fills</p>
                  </div>
                </div>
                <div class="bottom-divider"></div>
              </div>
            </div>
            <div class="row">
              <div class="col col-lg-4 col-md-4 col-12 right-divider mt-2">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-users fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="allagentcount">{{number_format($allsubagents->count())}}</h4>
                    <p>Agents</p>
                  </div>
                </div>
                <div>
                </div>
              </div>
              <div class="col col-lg-4 col-md-4 col-12 right-divider mt-2">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-user-plus fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="newagentcount">{{number_format($newAgents)}}</h4>
                    <p>New Agents</p>
                  </div>
                </div>
                <div></div>
              </div>
              <div class="col col-lg-4 col-md-4 col-12  mt-2">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-user-tie fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="activeagentcount">{{number_format($activeAgents)}}</h4>
                    <p>Active Agents</p>
                  </div>
                </div>
                <div></div>
              </div>
            </div>

          </div>
        </div>
        
      </div>
    </div>
  </div>


  <div id="mybutton" style=" position: fixed; bottom: 120px;   right: 50px;">
    <div class="info-box" data-toggle="modal" data-target="#send-money">
      <span class="info-box-icon" style="background-color:#003366 "><i class="fas fa-share-alt fa-2x btn-outline text-white"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Send Yimulu</span>
        <span class="info-box-number">1 USD= <span id="exrate"></span> ETB</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    
  </div>
  <div class="modal fade" id="send-money">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{route('admin.transactions.send')}}" method="POST">
          @csrf
          <div class="modal-header">
            <h4 class="modal-title">Yimulu Transfer</h4>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form role="form">
              <div class="card-body">
                <div class="form-group">
                  <label for="type">Type</label>
                  <select class="form-control" name="sales_type" id="type">
                    <option value="0">Top up</option>
                    <option value="1">Bill</option>

                  </select>
                </div>
                <div class="form-group">
                  <label for="phone">Zemed's Phone</label>
                  <input type="number" class="form-control" id="phone" name="phone_number" placeholder="09xxxxxxxx">
                </div>
                <div class="form-group">
                  <label for="amount">Amount</label>
                  <input class="form-control" name="amount" type="number" id="amount" onkeyup="myFunction3(this.value)" placeholder="in Birr">
                  <p style="color:crimson" ><span id="converted">0.00</span> USD</p>
                   </div>



              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>

        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</section>
@endsection
@section('javascript')
<script>
   var exrate=0;
  $(document).ready(function() {

  
    var delayInMilliseconds = 100; //1 second

     
      $.ajax({
        type: 'GET',
        url: "https://free.currconv.com/api/v7/convert?q=USD_ETB&compact=ultra&apiKey=a9cb1c997d96f61b42b5",
        timeout: 90000,
        contentType: "text/plain",
        dataType: 'json',
        success: function(json) {
          // console.log(json);

          $('#exrate').text(new Intl.NumberFormat('en', {
            style: 'decimal',

          }).format(parseFloat(json.USD_ETB).toFixed(2)));
          exrate=json.USD_ETB;
         
        }
      });


  });
  function myFunction3(val) {
    var amount = document.getElementById("amount").value;
    console.log((amount/exrate).toFixed(2));
    $('#converted').text((amount/exrate).toFixed(2));
  }

</script>

@endsection