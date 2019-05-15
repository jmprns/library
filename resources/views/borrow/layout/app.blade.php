<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>BOOKLAT - @yield('html-title')</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

  @section('css')
  @show

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/library/dashboard">
        <div class="sidebar-brand-icon">
          <img src="{{ asset('img/logo.png') }}" height="50px" width="50px">
        </div>
        <div class="sidebar-brand-text mx-3">BOOKLAT</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Heading -->
      <div class="sidebar-heading">
        Library
      </div>

        <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="/borrow/books">
       <i class="fas fa-fw fa-book-open"></i>
          <span>Book List</span>
      </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-book"></i>
          <span>Subjects</span>
        </a>
        @php
          $subsMenus = App\RealSub::all();
        @endphp
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Subject List:</h6>
            @foreach($subsMenus as $subMenu)
            <a class="collapse-item" href="/borrow/books/subject/{{ $subMenu->id }}">{{ $subMenu->name }}</a>
           @endforeach
          </div>
        </div>
      </li>

        <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="/borrow/reserve">
       <i class="fas fa-fw fa-list"></i>
          <span>Reservations</span>
      </a>
      </li>



      <!-- Divider -->
      <hr class="sidebar-divider">

       <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="/borrow/settings">
       <i class="fas fa-fw fa-cog"></i>
          <span>Settings</span>
      </a>
      </li>



      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/borrow/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span>
      </a>
      </li>

      

      <form id="logout-form" action="{{ url('/borrow/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>
 

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          
          @if(strpos(url()->current(), '/borrow/books') !== false)
            <!-- Topbar Search -->
            <form method="POST" action="/borrow/books/search" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
              @csrf<div class="input-group">
                <input required type="text" name="search_query" class="form-control bg-light border-0 small" placeholder="Search book or author" aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>

            <ul class="navbar-nav ml-auto">
               <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form method="POST" action="/borrow/books/search" class="form-inline mr-auto w-100 navbar-search">
                  @csrf<div class="input-group">
                    <input required type="text" name="search_query" class="form-control bg-light border-0 small" placeholder="Search book or author" aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            </ul>
          @else
          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <p>Baler National High School</p>
            </div>
          </form>
          @endif

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            @php
              $noteC = App\Notification::where('borrow_id', Auth::user()->id)->count();
              $notifications = App\Notification::where('borrow_id', Auth::user()->id)->orderBy('id', 'desc')->take(3)->get();
            @endphp

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">{{ $noteC }}</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Latest Notifications
                </h6>
                @foreach($notifications as $notify)
                <a class="dropdown-item d-flex align-items-center" href="/borrow/reserve">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">{{ $notify->created_at }}</div>
                    <span class="font-weight-bold">{{ $notify->notif }}</span>
                  </div>
                </a>
                @endforeach
                <a class="dropdown-item text-center small text-gray-500" href="/borrow/reserve">Show Reservation List</a>
              </div>
            </li>

            

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</span>
                <img class="img-profile rounded-circle" src="{{ asset('img/avatar') }}/{{ Auth::user()->img }}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                
                <a class="dropdown-item" href="{{ url('/borrow/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

          

        </nav>
        <!-- End of Topbar -->



        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">@yield('page-title')</h1>
          <p class="mb-4">@yield('page-title-sub')</p>

          @section('main-content')
          @show


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>BOOKLAT <br> &copy; Library Automated System</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

  @section('js')
  @show

</body>

</html>
