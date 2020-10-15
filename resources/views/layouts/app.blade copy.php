<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Nared Telecom | EVD System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/dist/css/fontawesome.all.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('/dist/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/css/adminlte.min.css" integrity="sha512-rVZC4rf0Piwtw/LsgwXxKXzWq3L0P6atiQKBNuXYRbg2FoRbSTIY0k2DxuJcs7dk4e/ShtMzglHKBOJxW8EQyQ==" crossorigin="anonymous" />
  <!-- Google Font: Source Sans Pro -->
  <link href="{{asset('/dist/css/fonts.css')}}" rel="stylesheet">

  <link href="{{asset('/dist/css/jquery.dataTables.min.css')}}">
  <link href="{{asset('/dist/css/dataTables.bootstrap4.min.css')}}">


 

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
  <script src="{{asset('/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js" integrity="sha512-++c7zGcm18AhH83pOIETVReg0dr1Yn8XTRw+0bWSIWAVCAwz1s2PwnSj4z/OOyKlwSXc4RLg3nnjR22q0dhEyA==" crossorigin="anonymous"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('/dist/js/demo.js')}}"></script>
  <script src="{{asset('/dist/js/sweetalert2@9.js')}}"></script>
  <script src="{{asset('/dist/js/fontawesome.all.js')}}"></script>



  <script src="{{asset('/dist/js/gchart.js')}}"></script>
  <script type="text/javascript">
    //for busy
   
       const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $(document).ready(function() {
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

      @foreach($errors->all() as $error)
      Toast.fire({
        icon: 'error',
        title: '{{$error }}'
      });
      @endforeach
      @if(isset($success_message))
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{$success_message}}!',
      });

      @endif
      @if(null !== session('success_message'))
      Swal.fire({
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
      Swal.fire({
        icon: 'error',

        title: 'Oops...',
        text: '{{$errors2}}!',
      });

      @endif
      @if(null !== session('error_message'))
      Swal.fire({
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