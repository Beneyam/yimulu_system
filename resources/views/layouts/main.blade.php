@extends('layouts.app')
@section('main')

 dd('ll');
@include('layouts.header')
  <!-- Content Wrapper. Contains page content -->
  @include('layouts.sidebar')
  <div class="content-wrapper">
  
    <!-- Content Header (Page header) -->
    @yield('content')
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
  @include('layouts.footer')
 
@endsection