 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-light-danger elevation-4 accent-sucess">
   <!-- Brand Logo -->
   <a href="{{route('home')}}" class="brand-link accent-sucess" style="background:#1e621f">
     <img src="{{asset('dist/img/nareyimulu.png')}}" alt="Nared Yimulu Logo" class="brand-image" style="opacity: .8; margin-left:-5px">
     <span class="brand-text font-weight-light">Nared Yimulu System</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
     <!-- Sidebar user (optional) -->
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       <div class="image">
         <img src="{{asset('dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
       </div>
       <div class="info">
         {{Auth::user()->name}}

       </div>
     </div>

     <!-- Sidebar Menu -->
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-item has-treeview">
           <a href="{{route('home')}}" class="nav-link active">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Dashboard
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>

         </li>
         @can('manage-system')

         <li class="nav-item has-treeview">
           <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-book-open"></i>
             <p>
               Reports
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">

             <li class="nav-item">
               <a href="{{route('admin.reports.purchase')}}" class="nav-link">
                 <i class="fas fa-shopping-cart nav-icon"></i>
                 <p>Yimulu Purchases</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="{{route('admin.reports.refill')}}" class="nav-link">
                 <i class="fas fa-paper-plane nav-icon"></i>
                 <p>System Refills</p>
               </a>
             </li>

             <li class="nav-item">
               <a href="{{route('admin.reports.agentrefill')}}" class="nav-link">
                 <i class="fas fa-share nav-icon"></i>
                 <p>Agent to Agent Refills</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="{{route('admin.reports.agentsales')}}" class="nav-link">
                 <i class="fas fa-comment-dollar nav-icon"></i>
                 <p>Agent sales</p>
               </a>
             </li>
             
            </ul>
         </li>
         @endcan
         @can('staff-view')

         <li class="nav-item has-treeview">
           <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-book-open"></i>
             <p>
               Reports
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">



             <li class="nav-item">
               <a href="{{route('admin.reports.agentcollections')}}" class="nav-link">
                 <i class="fas fa-share nav-icon"></i>
                 <p>Transfers</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="{{route('admin.reports.staffrefills')}}" class="nav-link">
                 <i class="fas fa-share nav-icon"></i>
                 <p>Re-Fills</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="{{route('admin.reports.staffsales')}}" class="nav-link">
                 <i class="fab fa-shopify nav-icon"></i>
                 <p>Yimulu Sales</p>
               </a>
             </li>



           </ul>
         </li>
         @endcan
         @can('manage-vc')
         <li class="nav-item has-treeview">
           <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-print"></i>
             <p>
               Yimulu Purchases
               <i class="fas fa-angle-left right"></i>

             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="{{route('purchase.create')}}" class="nav-link">
                 <i class="fas fa-upload nav-icon"></i>
                 <p>Add new Purchases</p>
               </a>
             </li>

           </ul>
         </li>
         @endcan
         @can('manage-agents')
         <li class="nav-item has-treeview">
           <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-users"></i>
             <p>
               Agent Management
               <i class="fas fa-angle-left right"></i>

             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="{{route('admin.users.index')}}" class="nav-link">
                 <i class="fas fa-user-tie nav-icon"></i>
                 <p>Agents</p>
               </a>
             </li>

           </ul>
         </li>
         @endcan

         @can('manage-others')
         <li class="nav-item has-treeview">
           <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-server"></i>
             <p>
               Other
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             @can('manage-system')
             <li class="nav-item">
               <a href="{{route('admin.banks.index')}}" class="nav-link">
                 <i class="fas fa-university nav-icon"></i>
                 <p>Banks</p>
               </a>
             </li>
             @endcan
             <li class="nav-item">
               <a href="{{route('admin.deposits.index')}}" class="nav-link">
                 <i class="fas fa-money-check-alt nav-icon"></i>
                 <p>Deposits</p>
               </a>
             </li>
           </ul>
         </li>

         @endcan
       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>