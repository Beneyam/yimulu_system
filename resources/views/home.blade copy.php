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
        <h1>Dashboard</h1>
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
              <div class="col col-lg-4 col-md-4 col-12 right-divider mt-2 ">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-university fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">

                    <a href="#card-stats" style="color: inherit; text-decoration: none">
                      <h4 class="text-md-right text-bold" id="systemcards">{{number_format($system_cards)}} Birr</h4>
                    </a>
                    <p>Total Available Cards</p>
                  </div>
                </div>
                <div class="bottom-divider"></div>
                <!-- /.col -->
              </div>
              <div class="col col-lg-4 col-md-4 col-12 right-divider mt-2">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-coins fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="systembalance">{{number_format($system_balance)}} Birr</h4>
                    <p>System Balance</p>
                  </div>

                </div>
                <div class="bottom-divider"></div>
              </div>
              <div class="col col-lg-4 col-md-4 col-12 mt-2">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-piggy-bank fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="agentbalance">{{number_format($agentsBalance)}} Birr</h4>
                    <p>Agent's Balance</p>
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
                    <h4 class="text-md-right text-bold" id="yimulu_sales">{{number_format($yimulu_sales->amount)}}</h4>
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
                    <h4 class="text-md-right text-bold" id="balance_refills">{{number_format($txs['system_to_agent']['total'])}}</h4>
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
                    <h4 class="text-md-right text-bold" id="receivable">{{number_format($collections['receivable']-$collections['deposit'])}} Birr</h4>
                    <p>Receivables</p>
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
                    <h4 class="text-md-right text-bold" id="allagentcount">{{number_format($user_stat['all_users'])}}</h4>
                    <p>Agents</p>
                  </div>
                </div>
                <div></div>
              </div>
              <div class="col col-lg-4 col-md-4 col-12 right-divider mt-2">
                <div class="row text-white">
                  <div class="mx-5 my-auto  justify-content-end">
                    <span class="bg-transparent "><i class="fas fa-user-plus fa-3x"></i></span>
                  </div>
                  <div class="mx-1 my-auto  justify-content-begin">
                    <h4 class="text-md-right text-bold" id="newagentcount">{{number_format($user_stat['new_users'])}}</h4>
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
                    <h4 class="text-md-right text-bold" id="activeagentcount">{{number_format($user_stat['active_users'])}}</h4>
                    <p>Active Agents</p>
                  </div>
                </div>
                <div></div>
              </div>
            </div>

          </div>
        </div>
        <div class="card" style="background-color:#49b54b ">
          <div class="card-header">
            <h1 class="card-title text-white">Sales</h1>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
          </div>

          <div class="card-body" style="overflow: scroll;">


            <div id="sales-amount-chart" class="bg-transparent" style="height:500px"> </div>


          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  @php
                  if($comparisons['DTD']>0){
                  @endphp
                  <span class="font-weight-bolder" style="font-size:25px; color:#1e621f">
                    <i class="fas fa-caret-up"></i>
                    @php
                    }
                    elseif($comparisons['DTD']==0){
                    @endphp
                    <span class="text-warning font-weight-bolder" style="font-size:25px">
                      <i class="fas fa-caret-left"></i>

                      @php
                      }
                      else{
                      @endphp
                      <span class="text-danger font-weight-bolder" style="font-size:25px"><i class="fas fa-caret-down"></i>
                        @php
                        }
                        @endphp
                        {{number_format(abs($comparisons['DTD']))}} %
                      </span>
                      <h5 class="description-header">{{$comparisons['today_sales']}} Birr</h5>
                      <span class="description-text">Today's Sales</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">

                  @php
                  if($comparisons['WTW']>0){
                  @endphp
                  <span class="font-weight-bolder" style="font-size:25px; color:#1e621f">
                    <i class="fas fa-caret-up"></i>
                    @php
                    }
                    elseif($comparisons['WTW']==0){
                    @endphp
                    <span class="text-warning font-weight-bolder" style="font-size:25px"><i class="fas fa-caret-left"></i>

                      @php
                      }
                      else{
                      @endphp
                      <span class="text-danger font-weight-bolder" style="font-size:25px"><i class="fas fa-caret-down"></i>
                        @php
                        }
                        @endphp
                        {{number_format(abs($comparisons['WTW']))}} %
                      </span>
                      <h5 class="description-header">{{$comparisons['cur_WTD']}}</h5>
                      <span class="description-text">This Week Sales</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">

                  @php
                  if($comparisons['MTM']>0){
                  @endphp
                  <span class="font-weight-bolder" style="font-size:25px; color:#1e621f">
                    <i class="fas fa-caret-up"></i>
                    @php
                    }
                    elseif($comparisons['MTM']==0){
                    @endphp
                    <span class="text-warning font-weight-bolder" style="font-size:25px"><i class="fas fa-caret-left"></i>

                      @php
                      }
                      else{
                      @endphp
                      <span class="text-danger font-weight-bolder" style="font-size:25px"><i class="fas fa-caret-down"></i>
                        @php
                        }
                        @endphp
                        {{number_format(abs($comparisons['MTM']))}}
                        %</span>
                      <h5 class="description-header">{{$comparisons['cur_MTD']}}</h5>
                      <span class="description-text">This Month's Sales</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block">

                  @php
                  if($comparisons['YTY']>0){
                  @endphp
                  <span class="font-weight-bolder" style="font-size:25px; color:#1e621f">
                    <i class="fas fa-caret-up"></i>
                    @php
                    }
                    elseif($comparisons['YTY']==0){
                    @endphp
                    <span class="text-warning font-weight-bolder" style="font-size:25px"><i class="fas fa-caret-left"></i>

                      @php
                      }
                      else{
                      @endphp
                      <span class="text-danger font-weight-bolder" style="font-size:25px"><i class="fas fa-caret-down"></i>
                        @php
                        }
                        @endphp
                        {{number_format(abs($comparisons['YTY']))}} %
                      </span>
                      <h5 class="description-header">{{$comparisons['cur_YTD']}}</h5>
                      <span class="description-text">This year's sales</span>
                </div>
                <!-- /.description-block -->
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-footer -->
        </div>
        <div class="card" style="background-color:#49b54b ">
          <div class="card-header">
            <h1 class="card-title text-white">Purchases</h1>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
          </div>
          <div class="card-body" style="overflow: scroll;">

            <div id="purchase-amount-chart" class="bg-transparent" style="height:500px">


            </div>


          </div>
        </div>
        <div class="card" style="background-color:#49b54b ">
          <div class="card-header">
            <h1 class="card-title text-white">Top agents</h1>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
          </div>
          <div class="card-body" style="overflow: scroll;">

            <div class="row">
              <div id="agent-sale-chart" style="height:400px" class="bg-transparent col col-12 col-lg-6"></div>

              <div id="first-sale-chart" style="height:400px" class="bg-transparent  col col-12 col-lg-6"></div>


            </div>
          </div>
        </div>
        <div class="card" id="card-stats" style="background-color:#49b54b ">
          <div class="card-header">
            <h1 class="card-title text-white">System Card Stats</h1>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
          </div>
          <div class="card-body" style="overflow: scroll;">
            <table id="cards_list" class="display table table-striped table-hover responsive bg-white text-bold" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Face Value</th>
                  <th>Remaining amount</th>
                  <th>Total Amount</th>
                  <th>Average Sales per day</th>
                  <th>Estimated Days</th>
                  <th>Purchase Suggestion</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @php
                $i=1;
                $total_amount=0;
                @endphp
                @foreach($card_stats as $card_stat)
                <tr>
                  <td>{{$i}}</td>
                  @php
                  $i++;
                  $total_amount+=$card_stat['total_amount'];
                  $color="";
                  if($card_stat['status']=="Good"){
                  $color="text-green";
                  }
                  if($card_stat['status']=="Warning"){
                  $color="text-yellow";
                  }
                  if($card_stat['status']=="Critical"){
                  $color="text-orange";
                  }
                  if($card_stat['status']=="Out"){
                  $color="text-red";
                  }
                  @endphp
                  <td align="right">{{$card_stat['face_value']}}</td>
                  <td align="right">{{number_format($card_stat['rem_amount'])}}</td>
                  <td align="right">{{number_format($card_stat['total_amount'])}}</td>
                  <td align="right">{{number_format($card_stat['average_SPD'])}}</td>
                  <td align="right">{{number_format($card_stat['rem_days'],1)}}</td>
                  <td align="right">{{number_format($card_stat['purchase_suggestion'])}}</td>
                  <td align="right" class="{{$color}}">{{$card_stat['status']}}</td>
                </tr>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <td col-span="2" align="right">Total</td>
                  <td align="right">{{number_format($total_amount)}}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tfoot>

            </table>

          </div>
        </div>

      </div>
    </div>
  </div>



</section>
@endsection
@section('javascript')
<script>
  $(document).ready(function() {
    $('#cards_list').DataTable({
      "scrollX": 700,
      "display": false,
      "paging": false,

    });

  });
  $(function() {
    function update() {
      $.getJSON("{{route('webapi123bb.get')}}",
        function(json) {
         // console.log(json);
          $('#systemcards').text(new Intl.NumberFormat('en', {
            style: 'decimal',

          }).format(parseFloat(json.system_cards).toFixed(0)) + " Birr");
          $('#systembalance').text(new Intl.NumberFormat('en', {
            style: 'decimal',

          }).format(parseFloat(json.system_balance)) + " Birr");
          $('#agentbalance').text(new Intl.NumberFormat('en', {
            style: 'decimal',

          }).format(parseFloat(json.agentsBalance).toFixed(0)) + " Birr");

          $('#yimulu_sales').text(new Intl.NumberFormat('en', {
            style: 'decimal',

          }).format(parseFloat(json.yimulu_sales).toFixed(0)) + " Birr");
          $('#balance_refills').text(new Intl.NumberFormat('en', {
            style: 'decimal',

          }).format(parseFloat(json.txsta).toFixed(0)) + " Birr");
          $('#receivable').text(new Intl.NumberFormat('en', {
            style: 'decimal',

          }).format(parseFloat(json.agentsDebt).toFixed(0)) + " Birr")


          $('#allagentcount').text(new Intl.NumberFormat('en', {
            style: 'decimal',

          }).format(parseFloat(json.agent_count).toFixed(0)));

          $('#newagentcount').text(new Intl.NumberFormat('en', {
            style: 'decimal',

          }).format(parseFloat(json.new_agents).toFixed(0)));
          $('#activeagentcount').text(new Intl.NumberFormat('en', {
            style: 'decimal',

          }).format(parseFloat(json.active_agents).toFixed(0)));

        });
    }
    setInterval(update, 10000);
    update();
  });
</script>

<script type='text/javascript'>
  google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    $.ajax({
      url: "{{route('webapi123bb.sales')}}",
      dataType: "json",
      type: "GET",
      contentType: "application/json; charset=utf-8",
      success: function(data2) {
        var qdata = new google.visualization.DataTable();
        //console.log(data2);
        qdata.addColumn('string', 'yimulu_sales_type');
        qdata.addColumn('number', 'YTD');
        qdata.addColumn({
          type: 'string',
          role: 'tooltip'
        });
        qdata.addColumn('number', 'MTD');
        qdata.addColumn({
          type: 'string',
          role: 'tooltip'
        });
        qdata.addColumn('number', 'WTD');
        qdata.addColumn({
          type: 'string',
          role: 'tooltip'
        });

        $.each(data2, function(index, value) {
         // console.log(value);
          var ytdQ = parseFloat(value['ytd']);
          var ytdA = parseFloat(value['ytd'] * value['type']);
          var mtdQ = parseFloat(value['mtd']);
          var mtdA = parseFloat(value['mtd'] * value['type']);
          var wtdQ = parseFloat(value['wtd']);
          var wtdA = parseFloat(value['wtd'] * value['type']);
          var ytdLabel = 'YTD \n yimulu_salesType: ' + value['type'] + '\n amount: ' + ytdQ + " \n Amount: " + ytdA;
          var mtdLabel = 'MTD \n yimulu_salesType: ' + value['type'] + '\n amount: ' + mtdQ + " \n Amount: " + mtdA;
          var wtdLabel = 'WTD \n yimulu_salesType: ' + value['type'] + '\n amount: ' + wtdQ + " \n Amount: " + wtdA;
          qdata.addRow([value['type'].toString(), ytdA, ytdLabel, mtdA, mtdLabel, wtdA, wtdLabel]);

        });

        //console.log(qdata);
        /*  function placeMarker(dataTable) {
          var cli = this.getChartLayoutInterface();
          var chartArea = cli.getChartAreaBoundingBox();
          // "Zombies" is element #5.
          document.querySelector('.overlay-marker').style.top = Math.floor(cli.getYLocation(dataTable.getValue(5, 1))) - 50 + "px";
          document.querySelector('.overlay-marker').style.left = Math.floor(cli.getXLocation(6)) - 10 + "px";
        };
    */

        var sqChart = new google.visualization.LineChart(document.getElementById('sales-amount-chart'));

        var options = {
          displayAnnotations: true,
          backgroundColor: {
            fill: 'transparent'
          },
          title: 'yimulu_salesSales',
          hAxis: {
            title: 'face values',

          },

          lineWidth: 4,

          vAxis: {
            title: 'Amount',
            gridlines: {
              count: 4,
              color: 'green'
            },
            minorGridlines: {
              color: 'transparent'
            }
          },
          pointSize: 10,


          colors: ['#d32f2f', '#fb8c00', '#ffffff']

        };

        /* google.visualization.events.addListener(sqChart, 'ready',
           placeMarker.bind(sqChart, qdata));*/
        sqChart.draw(qdata, options);
      }

    });
    $.ajax({
      url: "{{route('webapi123bb.purchase')}}",
      dataType: "json",
      type: "GET",
      contentType: "application/json; charset=utf-8",
      success: function(data2) {
        var qdata = new google.visualization.DataTable();
        qdata.addColumn('string', 'yimulu_sales_type');
        qdata.addColumn('number', 'YTD');
        qdata.addColumn({
          type: 'string',
          role: 'tooltip'
        });
        qdata.addColumn('number', 'MTD');
        qdata.addColumn({
          type: 'string',
          role: 'tooltip'
        });
        qdata.addColumn('number', 'WTD');
        qdata.addColumn({
          type: 'string',
          role: 'tooltip'
        });
        //console.log(data2);
        $.each(data2, function(index, value) {
          var ytdQ = parseFloat(value['ytd']);
          var ytdA = parseFloat(value['ytd'] * value['type'])
          var mtdQ = parseFloat(value['mtd']);
          var mtdA = parseFloat(value['mtd'] * value['type']);
          var wtdQ = parseFloat(value['wtd']);
          var wtdA = parseFloat(value['wtd'] * value['type'])
          var ytdLabel = 'YTD \n yimulu_salesType: ' + value['type'] + '\n amount: ' + ytdQ + " \n Amount: " + ytdA;
          var mtdLabel = 'MTD \n yimulu_salesType: ' + value['type'] + '\n amount: ' + mtdQ + " \n Amount: " + mtdA;
          var wtdLabel = 'WTD \n yimulu_salesType: ' + value['type'] + '\n amount: ' + wtdQ + " \n Amount: " + wtdA;
          qdata.addRow([value['type'].toString(), ytdA, ytdLabel, mtdA, mtdLabel, wtdA, wtdLabel]);

        });
        var sqChart = new google.visualization.LineChart(document.getElementById('purchase-amount-chart'));
        var options = {
          displayAnnotations: true,
          backgroundColor: {
            fill: 'transparent'
          },
          title: 'Card purchase',
          hAxis: {
            title: 'face values',

          },

          vAxis: {
            title: 'amount',

          },
          lineWidth: 4,

          vAxis: {
            title: 'amount',
            gridlines: {
              count: 4,
              color: 'green'
            },
            minorGridlines: {
              color: 'transparent'
            }
          },
          pointSize: 10,

          colors: ['#d32f2f', '#fb8c00', '#ffffff']

        };


        sqChart.draw(qdata, options);
      }
    });

    $.ajax({
      url: "{{route('webapi123bb.topstat')}}",
      dataType: "json",
      type: "GET",
      contentType: "application/json; charset=utf-8",
      success: function(data2) {
        var sales = data2['yimulu_sales'];
        var first = data2['first'];
        var second = data2['second'];

        //console.log(first);
        var qdata = new google.visualization.DataTable();
        qdata.addColumn('string', 'rank');
        qdata.addColumn('number', 'Sales');
        qdata.addColumn({
          type: 'string',
          role: 'style'
        });
        qdata.addColumn({
          type: 'string',
          role: 'annotation'
        });
        var cc = 0;
        var gg = ['', '', '', '', ''];
        var col = ['#1e621f ', '#afb42b', '#fdd835', '#ffc107', '#ff7043'];
        $.each(sales, function(index, value) {
          qdata.addRow([gg[cc], parseFloat(value['amount']), col[cc], value['name']]);
          cc++;
        });

        var sqChart = new google.visualization.BarChart(document.getElementById('agent-sale-chart'));
        var options = {
          displayAnnotations: true,
          backgroundColor: {
            fill: 'transparent'
          },
          title: 'Top Selling Agents',
          hAxis: {
            title: 'Sales amount',
            gridlines: {
              count: 4,
              color: 'transparent'
            },
            minorGridlines: {
              color: 'transparent'
            }
          },
          legend: 'none',

          bar: {
            groupWidth: "90%"
          },

          vAxis: {

            color: "white",
            lineWidth: 2,
            gridlines: {

              color: 'transparent'
            },
            minorGridlines: {
              color: 'transparent'
            }
          },


          legend: 'none',

        };


        sqChart.draw(qdata, options);



        var fdata = new google.visualization.DataTable();
        fdata.addColumn('string', 'rank');
        fdata.addColumn('number', 'refills');
        fdata.addColumn({
          type: 'string',
          role: 'style'
        });
        fdata.addColumn({
          type: 'string',
          role: 'annotation'
        });
        var cc = 0;
        var gg = [' ', ' ', ' ', ' ', ' '];
        var col = ['#1e621f ', '#afb42b', '#fdd835', '#ffc107', '#ff7043'];

        $.each(first, function(index, value) {
          fdata.addRow([gg[cc], parseFloat(value['amount']), col[cc], value['name']]);
          cc++;
        });

        var sqChart2 = new google.visualization.BarChart(document.getElementById('first-sale-chart'));
        var options = {
          displayAnnotations: true,
          backgroundColor: {
            fill: 'transparent'
          },
          title: 'Top Refiling Direct Agents',
          bar: {
            groupWidth: "90%"
          },
          hAxis: {
            title: 'Refill amount',
            gridlines: {
              count: 4,
              color: 'transparent'
            },
            minorGridlines: {
              color: 'transparent'
            }
          },

          legend: 'none',
          vAxis: {
            gridlines: {

              color: 'transparent'
            },
            minorGridlines: {
              color: 'transparent'
            }
          },



        };

        sqChart2.draw(fdata, options);



      }
    });

  }
</script>

@endsection