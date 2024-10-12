<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name').' - '.config('app.desc') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('theme/AdminLTE/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('theme/AdminLTE/dist/css/adminlte.min.css')}}">
    @yield('moreCSS')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button class="btn btn-primary-light" method="post" type="submit"><i data-feather="log-out"></i> Log out</button>
                </form>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <!-- Message Start -->--}}
{{--                        <div class="media">--}}
{{--                            <img src="theme/AdminLTE/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">--}}
{{--                            <div class="media-body">--}}
{{--                                <h3 class="dropdown-item-title">--}}
{{--                                    Brad Diesel--}}
{{--                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>--}}
{{--                                </h3>--}}
{{--                                <p class="text-sm">Call me whenever you can...</p>--}}
{{--                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- Message End -->--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <!-- Message Start -->--}}
{{--                        <div class="media">--}}
{{--                            <img src="theme/AdminLTE/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
{{--                            <div class="media-body">--}}
{{--                                <h3 class="dropdown-item-title">--}}
{{--                                    John Pierce--}}
{{--                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>--}}
{{--                                </h3>--}}
{{--                                <p class="text-sm">I got your message bro</p>--}}
{{--                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- Message End -->--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <!-- Message Start -->--}}
{{--                        <div class="media">--}}
{{--                            <img src="theme/AdminLTE/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
{{--                            <div class="media-body">--}}
{{--                                <h3 class="dropdown-item-title">--}}
{{--                                    Nora Silvester--}}
{{--                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>--}}
{{--                                </h3>--}}
{{--                                <p class="text-sm">The subject goes here</p>--}}
{{--                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- Message End -->--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
{{--                    <span class="dropdown-item dropdown-header">15 Notifications</span>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-envelope mr-2"></i> 4 new messages--}}
{{--                        <span class="float-right text-muted text-sm">3 mins</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-users mr-2"></i> 8 friend requests--}}
{{--                        <span class="float-right text-muted text-sm">12 hours</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-file mr-2"></i> 3 new reports--}}
{{--                        <span class="float-right text-muted text-sm">2 days</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="{{ asset('theme/AdminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('theme/AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth()->user()->name.' '.Auth()->user()->lastname }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @if(auth()->user()->department != 'laboratory')
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="nav-icon fas fa-copy"></i><p>COC Services</p></a>
                            <ul class="nav nav-treeview">
                                @if(auth()->user()->sector == 'management' or auth()->user()->sector == 'branch')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('order.create') }}">
                                            <i class="far fa-circle nav-icon"></i><p>New RFC</p>
                                        </a>
                                    </li>
                                    <li  class="nav-item">
                                        <a class="nav-link" href="{{ route('order.index') }}">
                                            <i class="far fa-circle nav-icon"></i><p>Drafts</p>
                                        </a>
                                    </li>
                                    <li  class="nav-item">
                                        <a class="nav-link" href="{{ route('coc.index') }}">
                                            <i class="far fa-circle nav-icon"></i><p>Approved</p>
                                        </a>
                                    </li>
                                    <li  class="nav-item">
                                        <a class="nav-link" href="{{ route('ncr.index') }}">
                                            <i class="far fa-circle nav-icon"></i><p>NCR</p>
                                        </a>
                                    </li>
                                    <li  class="nav-item">
                                        <a class="nav-link" href="{{ route('coc.archive') }}">
                                            <i class="far fa-circle nav-icon"></i><p>Archive</p>
                                        </a>
                                    </li>
                                @elseif(auth()->user()->sector == 'cosqc')
                                    <li  class="nav-item">
                                        <a class="nav-link" href="{{ route('coc.archive') }}">
                                            <i class="far fa-circle nav-icon"></i><p>Archive</p>
                                        </a>
                                    </li>
                                    <li  class="nav-item">
                                        <a class="nav-link" href="{{ route('ncr.index') }}">
                                            <i class="far fa-circle nav-icon"></i><p>NCR</p>
                                        </a>
                                    </li>
                                @else
                                    <li  class="nav-item">
                                        <a class="nav-link" href="{{ route('coc.archive') }}">
                                            <i class="far fa-circle nav-icon"></i><p>Archive</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if(auth()->user()->department == 'management' or auth()->user()->department == 'financial' or auth()->user()->department == 'laboratory')
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="nav-icon fas fa-copy"></i><p>Laboratory Services</p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a  class="nav-link" href="{{ route('request.create') }}"><i class="far fa-circle nav-icon"></i><p>New RFT</p></a></li>
                                <li class="nav-item"><a  class="nav-link" href="{{ route('rft.index','In Progress') }}"><i class="far fa-circle nav-icon"></i><p>In Progress</p></a></li>
                                <li class="nav-item"><a  class="nav-link" href="{{ route('rft.index','Completed') }}"><i class="far fa-circle nav-icon"></i><p>Archive</p></a></li>
                            </ul>
                        </li>
                    @endif

                    @if(auth()->user()->department == 'management' or auth()->user()->department == 'technical' or auth()->user()->department == 'branch' or auth()->user()->department == 'financial' or auth()->user()->department == 'laboratory')
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="nav-icon fas fa-copy"></i><p>Customers</p></a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a class="nav-link" href="/customer/create"><i class="far fa-circle nav-icon"></i><p>New Customer</p></a></li>
                                <li class="nav-item"><a class="nav-link" href="/customer/index"><i class="far fa-circle nav-icon"></i><p>Customers List</p></a></li>
                            </ul>
                        </li>
                    @endif
                    @if(strtolower(Auth()->user()->department) == 'management')
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="nav-icon fas fa-copy"></i><p>Users</p></a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a class="nav-link" href="{{ route('user.create') }}"><i class="far fa-circle nav-icon"></i><p>New User</p></a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('user.index') }}"><i class="far fa-circle nav-icon"></i><p>Users List</p></a></li>
                            </ul>
                        </li>
                    @endif
                    @if(auth()->user()->department == 'management' or auth()->user()->department == 'technical' or auth()->user()->department == 'branch' or auth()->user()->department == 'financial' or auth()->user()->department == 'laboratory')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('staticDocs.index') }}"><i class="far fa-circle nav-icon"></i><p>Document Center</p></a>
                            {{--                                    <ul class="nav-submenu menu-content">--}}
                            {{--                                        @if(Auth()->user()->level == 'manager')--}}
                            {{--                                            <li><a href="{{ route('tdms.index') }}">Master List</a></li>--}}
                            {{--                                            <li><a href="{{ route('tdms.indexExternalDocument') }}">External Documents</a></li>--}}
                            {{--                                            <li><a href="{{ route('tdms.create') }}">New Document</a></li>--}}
                            {{--                                            <li><a href="{{ route('tdms.createExternalDocument') }}">New External Doc</a></li>--}}
                            {{--                                            <li><a href="{{ route('tdms.withdraw') }}">Withdraw Documents</a></li>--}}
                            {{--                                        @elseif(Auth()->user()->level == 'expert')--}}
                            {{--                                            <li><a href="{{ route('tdms.index') }}">Master List</a></li>--}}
                            {{--                                            <li><a href="{{ route('tdms.indexExternalDocument') }}">External Documents</a></li>--}}
                            {{--                                        @endif--}}
                            {{--                                    </ul>--}}
                        </li>
                    @endif
                    @if(strtolower(Auth()->user()->department) == 'management')
                        <li class="nav-item"><a class="nav-link" href="{{ route('report.create') }}"><i class="far fa-circle nav-icon"></i><p>Reports</p></a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('search.index') }}"><i class="far fa-circle nav-icon"></i><p>Search</p></a></li>
                    @if(strtolower(Auth()->user()->department) == 'management')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('labfees.index') }}">
                                <i class="far fa-circle nav-icon"></i> <!-- Use an appropriate icon -->
                                <p>Lab Fee Management</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <section class="content">
            <br>
                @section('body')
                @show
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
        </div>
        <strong>Copyright &copy; {{ date('Y') }} <a href="{{ env('APP_URL') }}">{{ env('APP_NAME')}}</a></strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('theme/AdminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('theme/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('theme/AdminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('theme/AdminLTE/dist/js/demo.js')}}"></script>
@yield('moreJs')
</body>
</html>
