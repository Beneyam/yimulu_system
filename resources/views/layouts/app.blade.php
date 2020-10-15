<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NazrethMobile| Yimulu System</title>
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>



  @yield('styles')
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">

  <!-- Site wrapper -->
  <div class="wrapper">

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

  </div>
  <!-- ./wrapper -->
  <!-- jQuery -->
  <script type="text/javascript">
    //for busy

    function Validate() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("c_password").value;
        //console.log(password);
        //console.log(confirmPassword)
        if (password != confirmPassword) {
          alert("Passwords do not match.");
          return false;
        }
        return true;
      }
    $(document).ready(function() {
     

      @foreach($errors-> all() as $error)
      Toast.fire({
        icon: 'error',
        title: '{{$error }}'
      });
      @endforeach
      @if(isset($success_message))
      swal({
        icon: 'success',
        title: 'Success',
        text: '{{$success_message}}!',
      });

      @endif
      @if(null !== session('success_message'))
      swal({
        icon: 'success',
        title: 'Success',
        text: "{{session('success_message')}}!",
      });
      @php
      Session::forget('success_message');
      @endphp
      @endif
      @if(isset($warning_message))

      Toast.fire({
        icon: 'warning',
        title: '{{$warning_message}}'
      });
      @php
      Session::forget('warning_message');
      @endphp
      @endif
      @if(isset($errors2))
      swal({
        icon: 'error',

        title: 'Oops...',
        text: '{{$errors2}}!',
      });

      @endif
      @if(null !== session('error_message'))
      swal({
        icon: 'error',
        title: 'Oops...',
        text: "{{session('error_message')}}!",
      });
      @php
      Session::forget('error_message');
      @endphp
      @endif
      $('.example1').DataTable({
        responsive: true,
      });
    })
  </script>

  <!-- Custom js for this page-->
  @yield('javascript')
  <!-- End custom js for this page-->
  <!-- endinject -->
</body>

</html>