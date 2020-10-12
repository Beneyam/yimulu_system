<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Nared | EVD</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/dist/css/fontawesome.all.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('/dist/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="{{asset('/dist/css/fonts.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->

</head>

<body class="hold-transition login-page" background="{{asset('dist/img/back.svg')}}">
  <div class="login-box">

    <!-- /.login-logo -->
    <div class="card  opacity-8 rounded">
      <div class="card-body login-card-body bg-transparent">
        <div class="login-logo">

          <a href="#"><img src="{{asset('dist/img/naredevd.png')}}" alt="Nared EVD System" class="responsive" style="opacity: .8;width:60%;height:auto;">

        </div>
        <form method="POST" action="{{ route('login') }}" id="quickForm">
          @csrf

          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputEmail1" class="text-dark">Phone Number</label>
              <input type="phone_number" name="phone_number" class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Phone">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1" class="text-dark">Password</label>
              <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="exampleInputPassword1" placeholder="Password">
            </div>

          
          <!-- /.card-body -->
          <div class="form-group">
            <button type="submit" class="btn float-right text-white text-bold" style="background: #286429 ">Login</button>
          </div>

          </div>
        </form>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="{{asset('/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('/dist/js/adminlte.min.js')}}"></script>

</body>

</html>