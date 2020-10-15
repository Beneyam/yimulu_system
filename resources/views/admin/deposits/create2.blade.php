@extends('admin.banks.base')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-sm-1"></div>
            <div class="col-lg-9 col-sm-10">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Create New</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{route('admin.deposits.store2')}}" method="POST">
                            @csrf
                            <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                                <label for="user" class="col-md-4 control-label">agent </label>

                                <div class="col-md-6">
                                    <select id="user" class="form-control" name="user_id">
                                        @foreach($agents as $agent)
                                        <option value="{{$agent->id}}">
                                            {{$agent->name}}, {{$agent->phone_number}}
                                        </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('user_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('agent_id') ? ' has-error' : '' }}">
                                <label for="agent" class="col-md-4 control-label">agent </label>

                                <div class="col-md-6">
                                    <select id="agent" class="form-control" name="agent_id">
                                        @foreach($agents as $agent)
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

                            <div class="form-group{{ $errors->has('bank_id') ? ' has-error' : '' }}">
                                <label for="bank_id" class="col-md-4 control-label">Bank </label>

                                <div class="col-md-6">
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

                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="amount" class="col-md-4 control-label">amount</label>
                                <div class="col-md-6">
                                    <input type="number" id="amount" class="form-control" name="amount" value="{{old('amount')}}">
                                    @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                    @endif

                                </div>

                            </div>
                            <div class="form-group{{ $errors->has('ref_number') ? ' has-error' : '' }}">
                                <label for="ref_number" class="col-md-4 control-label">Bank slip number</label>
                                <div class="col-md-6">
                                    <input type="string" id="ref_number" class="form-control" name="ref_number" value="{{old('ref_number')}}">
                                    @if ($errors->has('ref_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ref_number') }}</strong>
                                    </span>
                                    @endif

                                </div>

                            </div>
                            <div class="form-group{{ $errors->has('deposit_date') ? ' has-error' : '' }}">
                                <label for="deposit_date" class="col-md-4 control-label">Deposit Date</label>
                                <div class="col-md-6">
                                    <input type="string" id="deposit_date" class="form-control" name="deposit_date" value="{{date('Y-m-d')}}">
                                    @if ($errors->has('deposit_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('deposit_date') }}</strong>
                                    </span>
                                    @endif

                                </div>

                            </div>
                            <div class="form-group{{ $errors->has('remark') ? ' has-error' : '' }}">
                                <label for="remark" class="col-md-4 control-label">Remark</label>
                                <div class="col-md-6">
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
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha512-nATinx3+kN7dKuXEB0XLIpTd7j8QahdyJjE24jTJf4HASidUCFFN/TkSVn3CifGmWwfC2mO/VmFQ6hRn2IcAwg==" crossorigin="anonymous" />
@endsection
@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha512-hgoywpb1bcTi1B5kKwogCTG4cvTzDmFCJZWjit4ZimDIgXu7Dwsreq8GOQjKVUxFwxCWkLcJN5EN0W0aOngs4g==" crossorigin="anonymous"></script>




<script>
    $(document).ready(function() {
        $('#agent').selectize({
            sortField: 'text',
        });
        $('#user').selectize({
            sortField: 'text',
        });
        $('#bank').selectize({
            sortField: 'text',
        });
      
    });
</script>
@endsection