@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><a class="text-success" href="{{route('admin.salestypes.index')}}">Sales Types</a></h1>
            </div>
            
        </div>
    </div><!-- /.container-fluid -->
</section>
@yield('main-content')

@endsection