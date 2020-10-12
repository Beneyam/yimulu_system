 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-light" style="background: #1e621f ">
   <!-- Left navbar links -->
   <ul class="navbar-nav text-white">
     <li class="nav-item">
       <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
     </li>
     <li class="nav-item d-none d-sm-inline-block text-white font-weight-bolder">
       <a href="{{route('home')}}" class="nav-link text-white">Home</a>
     </li>
   </ul>


   <!-- Right navbar links -->
   <ul class="navbar-nav ml-auto">
     <li class="nav-item dropdown">
     <a class="nav-link text-white" data-toggle="dropdown" href="#">
         <i class="far fa-user"></i>
        
       </a>
       <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-success">
       <a class="btn  btn-outline text-warning dropdown-item " title="Logout" href="{{ route('logout') }}">
         <i class="fas fa-sign-out-alt"></i>Sign Out
       </a>
       <a class="btn  btn-outline text-warning dropdown-item " title="Change Password" data-toggle="modal" data-target="#modal-change-my-password">
       <i class="fas fa-key"></i>Change Password
       </a>
</div>
     </li>
     @php
     $user=Auth::user();
     //$orders=App\Order::where('to',$user->id)->where('order_status_id','1')->count();
     //$system_orders=App\Order::where('to','1')->where('order_status_id','1')->count();
     $users=App\User::where('parent_id',NULL)->where('user_status','!=','4')->count();
     @endphp
     <!-- Notifications Dropdown Menu -->
     <li class="nav-item dropdown">
       <a class="nav-link text-white" data-toggle="dropdown" href="#">
         <i class="far fa-bell"></i>
         <span class="badge badge-success navbar-badge">{{$users}}</span>
       </a>
       <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-success">
         <span class="dropdown-item dropdown-header text-green">{{$users}} Notifications</span>

         <div class="dropdown-divider"></div>
         <a href="{{route('admin.users.newagents')}}" class="dropdown-item text-success">
           <i class="fas fa-users mr-2"></i> {{$users}} new users

         </a>
         <div class="dropdown-divider"></div>
         <a href="{{route('admin.users.logins')}}" class="dropdown-item text-success">
           <i class="fas fa-user-tie mr-2"></i> See new logins

         </a>
       </div>
     </li>
   </ul>
 </nav>
 <div class="modal fade" id="modal-change-my-password">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('users.changeMyPassword')}}" method="POST">
          @csrf
          
          <div class="modal-header">
            <h4 class="modal-title">Change Password</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form role="form">
              <div class="card-body">
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-group">
                  <label for="password">Confirm Password</label>
                  <input type="password" class="form-control" id="c_password" name="c_password">
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-success" onclick="return Validate()">Submit</button>
              </div>
            </form>
          </div>

        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
 <!-- /.navbar -->