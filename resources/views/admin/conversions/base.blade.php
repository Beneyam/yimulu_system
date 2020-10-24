@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><a class="text-primary" href="{{route('admin.conversions.index')}}">Conversions</a></h1>
            </div>
            
        </div>
    </div><!-- /.container-fluid -->
</section>
@yield('main-content')

@endsection