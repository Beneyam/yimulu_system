<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Nazreth | Mobile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/fontawesome.min.js" integrity="sha512-kI12xOdWTh/nL2vIx5Yf3z/kJSmY+nvdTXP2ARhepM/YGcmo/lmRGRttI3Da8FXLDw0Y9hRAyZ5JFO3NrCvvXA==" crossorigin="anonymous"></script>
  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
<script nomodule="" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/css/adminlte.min.css" integrity="sha512-rVZC4rf0Piwtw/LsgwXxKXzWq3L0P6atiQKBNuXYRbg2FoRbSTIY0k2DxuJcs7dk4e/ShtMzglHKBOJxW8EQyQ==" crossorigin="anonymous" />
  <!-- Google Font: Source Sans Pro -->
 
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
  <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <!-- Bootstrap 4 -->
 
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js" integrity="sha512-++c7zGcm18AhH83pOIETVReg0dr1Yn8XTRw+0bWSIWAVCAwz1s2PwnSj4z/OOyKlwSXc4RLg3nnjR22q0dhEyA==" crossorigin="anonymous"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- Theme style -->

</head>

<body class="hold-transition login-page" background="{{asset('dist/img/back.svg')}}">
  <div class="login-box">

    <!-- /.login-logo -->
    <div class="card  opacity-8 rounded">
      <div class="card-body login-card-body bg-transparent">
        <div class="login-logo">

          <a href="#"><img src="{{asset('dist/img/lezemedlogo.png')}}" alt="Nazreth Mobile" class="responsive" style="opacity: .8;width:60%;height:auto;">

        </div>
        <form method="POST" action="{{ route('login') }}" id="quickForm">
          @csrf

          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputEmail1" class="text-dark">User Name</label>
              <input type="phone_number" name="phone_number" class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Phone">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1" class="text-dark">Password</label>
              <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="exampleInputPassword1" placeholder="Password">
            </div>

          
          <!-- /.card-body -->
          <div class="form-group">
            <button type="submit" class="btn float-right text-white text-bold" style="background: #0f75bc ">Login</button>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js" integrity="sha512-++c7zGcm18AhH83pOIETVReg0dr1Yn8XTRw+0bWSIWAVCAwz1s2PwnSj4z/OOyKlwSXc4RLg3nnjR22q0dhEyA==" crossorigin="anonymous"></script>

</body>

</html>