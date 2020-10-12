@extends('layouts.app')
@section('styles')
<style>
  .right-divider {
    text-align: center;
    border-right: 1px solid #1e621f;
  }

  .bottom-divider {
    text-align: center;
    padding: 10px;
    margin: auto;
    width: 60%;
    border-bottom: 1px solid #1e621f;
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
        <div class="card" style="background-color:#49b54b ">
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
                    <p>Direct agent Balance</p>
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
                    <h4 class="text-md-right text-bold" id="tsubagentbalance">{{number_format($totalSubagentBalance)}}</h4>
                    <p>Total Subagent Balance</p>
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
                    <h4 class="text-md-right text-bold" id="yimulu_sales">{{number_format($soldCardAmount)}}</h4>
                    <p>Card Sales</p>
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



</section>
@endsection
