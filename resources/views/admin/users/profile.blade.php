@extends('admin.users.base')
@section('main-content')

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-success card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" src="../../dist/img/avatar.png" alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{$user->name}}</h3>

            <p class="text-muted text-center">{{$user->phone_number}}</p>
            @if($user->user_status==2)
            <form action="{{route('admin.users.suspend')}}" method="POST">
              @csrf
              <input type="hidden" name='user_id' value="{{$user->id}}">
              <button type="submit" class="btn btn-outline-light">
                <span style="color:green">
                  <i class="fas fa-toggle-on fa-lg"></i>
                </span>
              </button>
              <label style="color:green">Active</label>
            </form>
            @endif
            @if($user->user_status==1)
            <form action="{{route('admin.users.activate')}}" method="POST">
              @csrf
              <input type="hidden" name='user_id' value="{{$user->id}}">
              <button type="submit" class="btn btn-outline-light">
                <span style="color:red">
                  <i class="fas fa-toggle-off fa-lg"></i>
                </span>
              </button>
              <label style="color:orange">active</label>
            </form>
            @endif
            @if($user->user_status==4)
            <form action="{{route('admin.users.activate')}}" method="POST">
              @csrf
              <input type="hidden" name='user_id' value="{{$user->id}}">
              <button type="submit" class="btn btn-outline-light">
                <span style="color:green">
                  <i class="fas fa-trash-restore"></i>
                </span>Restore
              </button>
            </form>
            @endif
            @if($user->user_status!=4)
            <form action="{{route('admin.users.delete')}}" method="POST">
              @csrf
              <input type="hidden" name='user_id' value="{{$user->id}}">
              <button type="submit" class="btn btn-outline-light">
                <span style="color:red">
                  <i class="fas fa-trash"></i>
                </span>Delete
              </button>

            </form>
            @endif

            <ul class="list-group list-group-unbordered mb-3">

              <li class="list-group-item">
                <b>Parent</b> <a class="float-right" href="{{ (isset($parent) && $parent->id!=1)?route('admin.users.show', ['user' => $parent['id']]):'#'}}">{{isset($parent->name)?$parent->name:""}}</a>

              </li>
            </ul>
            @can('manage-transaction')
            <a class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-fill">
              <b>Fill Balance</b>
            </a>
            <a class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-record-deposits">
              <b>Record Deposits</b>
            </a>
            @endcan

            @can('staff-view')
            <a class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-fill2">
              <b>Fill Balance</b>
            </a>
            @endcan
            @can('manage-others')
            <a class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-edit">
              <b>Edit</b>
            </a>
            @endcan
            @can('edit-users')
            <a class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-change-parent">
              <b>Change Parent</b>
            </a>

            <a class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-show-otp">
              <b>Show OTP Code</b>
            </a>
            @endcan
            @can('manage-system')
            <a class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-change-password">
              <b>Change Password</b>
            </a>
            @endcan
           

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->


      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="row">
          <div class="col col-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">{{$allsubagents->count()}} agents</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Direct</b> <a class="float-right">{{$subagents->count()}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Indirect</b> <a class="float-right">{{$allsubagents->count()-$subagents->count()}}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <a href="#" class="small-box-footer float-right" data-toggle="modal" data-target="#modal-subagent-list">
                  More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <div class="col col-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Total Balance {{number_format($balance+$totalSubagentBalance+$subagentBalance)}}</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Agent Balance</b> <a class="float-right">{{number_format($balance)}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Direct Subagent's Balance</b> <a class="float-right">{{number_format($subagentBalance)}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Indirect Subagent's Balance</b> <a class="float-right">{{number_format($totalSubagentBalance)}}</a>
                  </li>
                </ul>

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <a href="#" class="small-box-footer float-right" data-toggle="modal" data-target="#modal-subagent-list">
                  More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <div class="col col-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Transactions</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Begining Balance</b> <a class="float-right">{{number_format($transaction['beginingBalance'])}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Refilled</b> <a class="float-right">{{number_format($transaction['refills'])}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Filled</b> <a class="float-right">{{number_format($transaction['fills'])}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Sold</b> <a class="float-right">{{number_format($allSubagentSales+$sales)}}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <a href="#" class="small-box-footer float-right" data-toggle="modal" data-target="#modal-transaction-list">
                  More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <div class="col col-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Other Stats</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                 
                  <li class="list-group-item">
                    <b>Sales per agent</b> <a class="float-right">{{($allsubagents->count()>0)?number_format(($allSubagentSales+$sales)/$allsubagents->count()):0}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Active Agents</b> <a class="float-right">{{number_format($active_agents)}}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <a href="#" class="small-box-footer float-right">
                  More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- /.card -->
          </div>

        </div>


        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
  <!-- /.modal -->

  <div class="modal fade" id="modal-fill">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{route('admin.transactions.transfer')}}" method="POST">
          @csrf
          <input type="hidden" name="to_agent" value="{{$user->id}}" />
          <input type="hidden" name="performed_by" value="{{Auth::user()->id}}" />
          <div class="modal-header">
            <h4 class="modal-title">Fill Agents Balance</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form role="form">
              <div class="card-body">
                <div class="form-group">
                  <label for="amount">Amount</label>
                  <input type="number" class="form-control" id="amount" name="amount" onkeyup="myFunction(this.value)">
                </div>
                <div class="form-group">
                  <label for="Commision">Commission</label>
                  <input type="number" step="0.01" class="form-control" id="commission" name="commission" value="{{$commission}}" onkeyup="myFunction(this.value)">
                  <label class="text-danger">last Month's Refill: {{number_format($lastMRefill)}}, Suggestion: {{$commmission_sugg}}%</label>
                </div>
                <div class="form-group">
                  <label for="payable">Amount to be paid</label>
                  <input id="payable" class="form-control" value="0" onkeyup="myFunction2(this.value)" />
                </div>



              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </form>
          </div>

        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-fill2">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{route('admin.transactions.transfer_staff')}}" method="POST">
          @csrf
          <input type="hidden" name="to_agent" value="{{$user->id}}" />
          <input type="hidden" name="performed_by" value="{{Auth::user()->id}}" />
          <div class="modal-header">
            <h4 class="modal-title">Fill Agents Balance</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form role="form">
              <div class="card-body">
                <div class="form-group">
                  <label for="amount">Amount</label>
                  <input type="number" class="form-control" id="amount2" name="amount" onkeyup="myFunction3(this.value)">
                </div>
                <div class="form-group">
                  <label for="Commision">Commision</label>
                  <input type="number" step="0.01" class="form-control" id="commission2" name="commission" value="{{$commission}}" onkeyup="myFunction(this.value)">
                  <label class="text-danger">last Month's Refill: {{number_format($lastMRefill)}}</label>
                </div>
                <div class="form-group">
                  <label for="payable">Amount to be paid</label>
                  <input id="payable2" class="form-control" value="0" onkeyup="myFunction4(this.value)" />
                </div>



              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </form>
          </div>

        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">


        <div class="modal-header">
          <h4 class="modal-title">Edit {{$user->name}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="card-body">
            <form action="{{route('users.editagent')}}" method="POST">
              @csrf
              <input type="hidden" name="agent_id" value="{{$user->id}}" />
              <div class="form-group">
                <label for="name">name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
              </div>
              <div class="form-group">
                <label for="Commision">Commission</label>
                <input type="number" step="0.01" class="form-control" id="commission3" name="commission" value="{{$user->commission}}">
                <label class="text-danger">Proposed Commission:{{$commission}} with LMS {{number_format($lastMRefill)}}</label>
              </div>
              <div class="form-group">
                <label for="multi_login">Multiple Logins</label>
                <input type='hidden' value='0' name='multi_login'>

                <input type="checkbox" id="multi_login" name="multi_login" value='1' {{($user->multi_login)?"checked":""}}>
              </div>
              <button type="submit" class="btn btn-success">Submit</button>

            </form>
          </div>
          <!-- /.card-body -->

          <div class="card-footer">
          </div>
        </div>

        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-record-deposits">
    <div class="modal-dialog">
      <div class="modal-content">


        <div class="modal-header">
          <h4 class="modal-title">Record Deposists</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="card-body">
          <form action="{{route('admin.deposits.store2')}}" method="POST">
              @csrf
              <input type="hidden" name="user_id" value="{{$user->id}}" />
              <div class="row">
              <div class="form-group col col-12 col-md-6 {{ $errors->has('agent_id') ? ' has-error' : '' }}">
                <label for="agent" class="control-label">agent </label>

                <div >
                  <select id="agent" class="form-control" name="agent_id">
                    @foreach($subagents as $agent)
                    <option value="{{$agent->id}}">
                      {{$agent->name}}, {{$agent->phone_number}}
                    </option>
                    @endforeach
                  </select>

                  @if ($errors->has('agent_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('agent_id') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group col col-12 col-md-6 {{ $errors->has('bank_id') ? ' has-error' : '' }}">
                <label for="bank_id" class="control-label">Bank </label>

                <div >
                  <select id="bank" class="form-control" name="bank_id">
                    @foreach($banks as $bank)
                    <option value="{{$bank->id}}">{{$bank->name}}, {{$bank->account_number}}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('bank_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group col col-12 col-md-6 {{ $errors->has('amount') ? ' has-error' : '' }}">
                <label for="amount" class="control-label">amount</label>
                <div >
                  <input type="number" id="amount" class="form-control" name="amount" value="{{old('amount')}}">
                  @if ($errors->has('amount'))
                  <span class="help-block">
                    <strong>{{ $errors->first('amount') }}</strong>
                  </span>
                  @endif

                </div>

              </div>
              <div class="form-group col col-12 col-md-6 {{ $errors->has('ref_number') ? ' has-error' : '' }}">
                <label for="ref_number" class="control-label">Bank slip number</label>
                <div >
                  <input type="string" id="ref_number" class="form-control" name="ref_number" value="{{old('ref_number')}}">
                  @if ($errors->has('ref_number'))
                  <span class="help-block">
                    <strong>{{ $errors->first('ref_number') }}</strong>
                  </span>
                  @endif

                </div>

              </div>
              <div class="form-group col col-12 col-md-6 {{ $errors->has('deposit_date') ? ' has-error' : '' }}">
                <label for="deposit_date" class="control-label">Deposit Date</label>
                <div >
                  <input type="string" id="deposit_date" class="form-control" name="deposit_date" value="{{date('Y-m-d')}}">
                  @if ($errors->has('deposit_date'))
                  <span class="help-block">
                    <strong>{{ $errors->first('deposit_date') }}</strong>
                  </span>
                  @endif

                </div>

              </div>
              <div class="form-group col col-12 col-md-6 {{ $errors->has('remark') ? ' has-error' : '' }}">
                <label for="remark" class="control-label">Remark</label>
                <div class="col-md-8">
                  <input type="textarea" rows="2" id="remark" class="form-control" name="remark" value="{{old('remark')}}">
                  @if ($errors->has('remark'))
                  <span class="help-block">
                    <strong>{{ $errors->first('remark') }}</strong>
                  </span>
                  @endif

                </div>

              </div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Record
                  </button>
                </div>
              </div>
              </div>
            </form>
          </div>
          <!-- /.card-body -->

          <div class="card-footer">
          </div>
        </div>

        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-change-parent" style="width: 100%; height: 100%; margin: 0; padding: 0;">
    <div class="modal-dialog" style="height: auto; min-height: 100%;   border-radius: 0;">
      <div class="modal-content">
        <form action="{{route('admin.users.changeParent')}}" method="POST">
          @csrf
          <input type="hidden" name="user_id" value="{{$user->id}}" />

          <div class="modal-header">
            <h4 class="modal-title">Change Parent</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form role="form">
              <div class="card-body" id="select2">
                <div class="form-group">
                  <label for="parent_phone_number">Select Parents</label>

                  <select id="select" name="parent_id" style="width:80%">
                    @foreach($parentlists as $parent)
                    <option value="{{$parent->id}}">

                      <p class="text-success text-bold">{{$parent->name}}</p>

                      <p class="text-success text-sm">{{$parent->phone_number}}</span>

                    </option>
                    @endforeach
                  </select>

                </div>

              </div>
              <!-- /.card-body -->


              <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-change-password">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('admin.users.changePassword')}}" method="POST">
          @csrf
          <input type="hidden" name="user_id" value="{{$user->id}}" />

          <div class="modal-header">
            <h4 class="modal-title">Change Password</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form role="form">
              <div class="card-body">
                <div class="form-group">
                  <label for="password2">Password</label>
                  <input type="password" class="form-control" id="password2" name="password">
                </div>
                <div class="form-group">
                  <label for="password">Confirm Password</label>
                  <input type="password" class="form-control" id="c_password2" name="c_password">
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-success" onclick="return Validate2()">Submit</button>
              </div>
            </form>
          </div>

        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-show-otp">
    <div class="modal-dialog">
      <div class="modal-content">

        <input type="hidden" name="user_id" value="{{$user->id}}" />

        <div class="modal-header">
          <h4 class="modal-title">OTP Code</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form role="form">
            <div class="card-body">
              @if(isset($otp->otp_code))
              <P>Code: {{$otp->otp_code}}
                <p>

                  <p>Generated: {{$otp->created_at}}</p>
                  @else
                  <P>No OTP Code!<p>
                      @endif
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
            </div>
          </form>
        </div>

        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  
  <div class="modal fade" id="modal-assign-paper">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('admin.others.assign-papers')}}" method="POST">
          @csrf
          <input type="hidden" name="user_id" value="{{$user->id}}" />

          <div class="modal-header">
            <h4 class="modal-title">Assign Papers</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form role="form">
              <div class="card-body">
                <div class="form-group">
                  <label for="amount">amount</label>
                  <input type="number" class="form-control" id="amount" name="amount">
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </form>
          </div>

        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <div class="modal fade" id="modal-subagent-list">
    <div class="modal-dialog">
      <div class="modal-content">
        <input type="hidden" name="user_id" value="{{$user->id}}" />

        <div class="modal-header">
          <h4 class="modal-title">Sub-agents Lists</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <table id="example1" class="example1 table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Parent</th>
                <th>Balance</th>
                <th>Sales</th>
              </tr>
            </thead>
            <tbody>
              @php
              $i=1;
              @endphp
              @foreach($allsubagents_stat as $subagent)
              <tr>
                <td>{{$i}}</td>
                @php
                $i++;
                @endphp
                <td><a href="{{ route('admin.users.show', ['user' => $subagent['id']]) }}">{{$subagent['name']}}</a></td>
                <td>{{$subagent['phone_number']}}</td>
                <td>{{$subagent['parent']}}</td>
                <td>{{$subagent['balance']}}</td>
                <td>{{$subagent['sales']}}</td>
              </tr>
              @endforeach

            </tbody>

          </table>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <div class="modal fade" id="modal-transaction-list">
    <div class="modal-dialog">
      <div class="modal-content">
        <input type="hidden" name="user_id" value="{{$user['id']}}" />

        <div class="modal-header">
          <h4 class="modal-title">Transaction lists</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#transactions" data-toggle="tab">Transactions</a></li>

                <li class="nav-item"><a class="nav-link" href="#sold_cards" data-toggle="tab">Sold Cards</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane table-responsive" id="transactions">
                  <!-- Post -->
                  <form action="{{route('admin.reports.singleagenttxs')}}" method="POST">
                    @csrf
                    <input name="agent_id" value="{{$user->id}}" hidden>
                    <button type="submit" class="btn btn-primary">See Agent Detailed Transactions</button>
                  </form>
                  <table id="example1" class="example1 table table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <th>Time</th>
                        <th>Type</th>
                        <th>To/From</th>
                        <th>Amount</th>
                        <th>Commission</th>
                        <th>Paid Amount</th>

                      </tr>
                    </thead>
                    <tbody>

                      @php
                      $transfers=$transaction_details['transfers'];
                      $deposits=$transaction_details['deposits'];
                      $sdeposits=$transaction_details['sDeposits'];
                      @endphp
                      @foreach($transfers as $transfer)
                      <tr>
                        @php
                        $receiver=App\User::where('id',$transfer->to_agent)->first();
                        @endphp
                        <td>{{$transfer['created_at']}}</td>
                        <td>Transfer</td>
                        <td>{{$receiver->name}}</td>
                        <td>{{$transfer['amount']}}</td>
                        <td>{{$transfer['commission']}}</td>
                        <td>{{$transfer['amount']*(1-0.01*$transfer['commission'])}}</td>

                      </tr>
                      @endforeach
                      @foreach($deposits as $deposit)
                      @php
                      $receiver=App\User::where('id',$deposit->from_agent)->first();
                      @endphp
                      <tr>
                        <td>{{$deposit['created_at']}}</td>
                        <td>Deposit</td>
                        <td>{{$receiver->name}}</td>

                        <td>{{$deposit['amount']}}</td>
                        <td>{{$deposit['commission']}}</td>
                        <td>{{$deposit['amount']*(1-0.01*$deposit['commission'])}}</td>
                      </tr>
                      @endforeach
                      @foreach($sdeposits as $sdeposit)
                      <tr>
                        @php
                        $receiver=App\User::where('id',$sdeposit->performed_by)->first();
                        @endphp

                        <td>{{$sdeposit['created_at']}}</td>
                        <td>Deposit by System</td>
                        <td>{{$receiver->name}}</td>
                        <td>{{$sdeposit['amount']}}</td>
                        <td>{{$sdeposit['commission']}}</td>
                        <td>{{$sdeposit['amount']*(1-0.01*$sdeposit['commission'])}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>

                </div>
                <!-- /.tab-pane -->
                
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</section>
<!-- /.content -->
@endsection
@section('styles')
<link rel="stylesheet" href="{{asset('/dist/css/selectize.bootstrap3.min.css')}}" />

@endsection
@section('javascript')
<script src="{{asset('/dist/js/selectize.min.js')}}"></script>

<script>
  $(document).ready(function() {
    $('#select').selectize({
      sortField: 'text',
    });
   
  });

  function Validate2() {
    var password = document.getElementById("password2").value;
    var confirmPassword = document.getElementById("c_password2").value;
    //console.log(password);
    //console.log(confirmPassword)
    if (password != confirmPassword) {
      alert("Passwords do not match.");
      return false;
    }
    return true;
  }


  function myFunction(val) {
    var amount = document.getElementById("amount").value;
    var commission = document.getElementById("commission").value;

    //console.log(amount);
    //console.log(commission);
    //console.log(amount*commission);
    document.getElementById("payable").value = Math.floor(amount * (100 - commission) * .01);
  }

  function myFunction2(val) {
    var payable = document.getElementById("payable").value;
    var commission = document.getElementById("commission").value;

    //console.log(amount);
    //console.log(commission);
    //console.log(amount*commission);
    document.getElementById("amount").value = Math.floor(payable / ((100 - commission) * .01));
  }

  function myFunction3(val) {
    var amount = document.getElementById("amount2").value;
    var commission = document.getElementById("commission2").value;

    //console.log(amount);
    //console.log(commission);
    //console.log(amount*commission);
    document.getElementById("payable2").value = Math.floor(amount * (100 - commission) * .01);
  }

  function myFunction4(val) {
    var payable = document.getElementById("payable2").value;
    var commission = document.getElementById("commission2").value;

    //console.log(amount);
    //console.log(commission);
    //console.log(amount*commission);
    document.getElementById("amount2").value = Math.floor(payable / ((100 - commission) * .01));
  }
</script>

@endsection