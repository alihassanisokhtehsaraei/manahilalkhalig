<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('app.desc').' - '.config('app.desc2') }}">
    <meta name="keywords" content="{{ config('app.keywords') }}">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="theme/viho/assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="theme/viho/assets/images/favicon.png" type="image/x-icon">
    <title>{{ config('app.name').' - '.config('app.desc') }}</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/fontawesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/feather-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/persian-fonts.css')}}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/chartist.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/date-picker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/prism.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/vector-map.css')}}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{ asset('theme/viho/assets/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/responsive.css')}}">
    <!-- Persian Fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/persian-fonts.css')}}">
    @yield('moreCSS')
</head>
<body>
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader">
        <div class="loader-p"></div>
    </div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start       -->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <div class="page-main-header">
        <div class="main-header-right row m-0">
            <div class="main-header-left">
                <div class="logo-wrapper"><a href="/dashboard"><img class="img-fluid" src="{{ asset('theme/viho/assets/images/logo/logo.png')}}" alt=""></a></div>
                <div class="dark-logo-wrapper"><a href="/dashboard"><img class="img-fluid" src="{{ asset('theme/viho/assets/images/logo/dark-logo.png')}}" alt=""></a></div>
                <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i></div>
            </div>
            <div class="left-menu-header col">
                <ul>
                    <li>
                        <form class="form-inline search-form">
                            <div class="search-bg"><i class="fa fa-search"></i>
                                <input class="form-control-plaintext" placeholder="Search here.....">
                            </div>
                        </form><span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
                    </li>
                </ul>
            </div>
            <div class="nav-right col pull-right right-menu p-0">
                <ul class="nav-menus">
                    <li><a class="text-dark" href="{{ $_SERVER['REQUEST_URI'] }}#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                    <li class="onhover-dropdown">
                        <div class="bookmark-box"><i data-feather="star"></i></div>
                        <div class="bookmark-dropdown onhover-show-div">
                            <div class="form-group mb-0">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
                                    <input class="form-control" type="text" placeholder="Search for bookmark...">
                                </div>
                            </div>
                            <ul class="m-t-5">
                                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="inbox"></i>Email<span class="pull-right"><i data-feather="star"></i></span></li>
                                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="message-square"></i>Chat<span class="pull-right"><i data-feather="star"></i></span></li>
                                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="command"></i>Feather Icon<span class="pull-right"><i data-feather="star"></i></span></li>
                                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="airplay"></i>Widgets<span class="pull-right"><i data-feather="star">   </i></span></li>
                            </ul>
                        </div>
                    </li>
                    <li class="onhover-dropdown">
                        <div class="notification-box"><i data-feather="bell"></i><span class="dot-animated"></span></div>
                        <ul class="notification-dropdown onhover-show-div">

                        </ul>
                    </li>
                    <li>
                        <div class="mode"><i class="fa fa-moon-o"></i></div>
                    </li>
                    <li class="onhover-dropdown"><i data-feather="message-square"></i>
                        <ul class="chat-dropdown onhover-show-div">

                        </ul>
                    </li>
                    <li class="onhover-dropdown p-0">
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button class="btn btn-primary-light" method="post" type="submit"><i data-feather="log-out"></i> Log out</button>
                        </form>
                    </li>
                </ul>
            </div>
            <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
        </div>
    </div>
    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
        <header class="main-nav">
            <div class="sidebar-user text-center"><a class="setting-primary" href="/user/profile"><i data-feather="settings"></i></a><img class="img-90 rounded-circle" src="{{ asset('theme/viho/assets/images/dashboard/1.png')}}" alt="">
                <div class="badge-bottom"><span class="badge badge-primary">{{ strtoupper(auth()->user()->level) }}</span></div><a href="user-profile.html">
                    <h6 class="mt-3 f-14 f-w-600">{{ auth()->user()->name.' '.auth()->user()->lastname }}</h6></a>
                <p class="mb-0 font-roboto">{{ ucfirst(auth()->user()->department) }} Department</p>
            </div>
            <nav>
                <div class="main-navbar">
                    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                    <div id="mainnav">
                        <ul class="nav-menu custom-scrollbar">
                            <li class="back-btn">
                                <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                            </li>

                            <li class="dropdown"><a class="nav-link menu-title link-nav" href="/dashboard"><i data-feather="home"></i><span>Dashboard</span></a></li>
                            @if(auth()->user()->department != 'laboratory')
                            <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="folder"></i><span>COC Services</span></a>
                                <ul class="nav-submenu menu-content">
                                    @if(auth()->user()->sector == 'management' or auth()->user()->sector == 'branch')
                                        <li><a href="{{ route('order.create') }}">New RFC</a></li>
                                        <li><a href="{{ route('order.index') }}">Drafts</a></li>
                                        <li><a href="{{ route('coc.index') }}">Approved</a></li>
                                        <li><a href="{{ route('ncr.index') }}">NCR</a></li>
                                        <li><a href="{{ route('coc.archive') }}">Archive</a></li>
                                    @elseif(auth()->user()->sector == 'cosqc')
                                        <li><a href="{{ route('coc.archive') }}">Archive</a></li>
                                        <li><a href="{{ route('ncr.index') }}">NCR</a></li>
                                    @else
                                        <li><a href="{{ route('coc.archive') }}">Archive</a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                            @if(auth()->user()->department == 'management' or auth()->user()->department == 'financial' or auth()->user()->department == 'laboratory')
                                <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="folder"></i><span>Laboratory Services</span></a>
                                    <ul class="nav-submenu menu-content">
                                        <li><a href="{{ route('request.create') }}">New RFT</a></li>
                                        <li><a href="{{ route('rft.index','In Progress') }}">In Progress</a></li>
                                        <li><a href="{{ route('rft.index','Completed') }}">Archive</a></li>
                                    </ul>
                                </li>
                            @endif


{{--                            <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="folder"></i><span>COI Services</span></a>--}}
{{--                                <ul class="nav-submenu menu-content">--}}
{{--                                    <li><a href="{{ route('order.create') }}">New Order</a></li>--}}
{{--                                    <li><a href="{{ route('order.index') }}">Drafts</a></li>--}}
{{--                                    <li><a href="{{ route('ic.index') }}">Approved</a></li>--}}
{{--                                    <li><a href="#">Archive</a></li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
                            @if(auth()->user()->department == 'management' or auth()->user()->department == 'technical' or auth()->user()->department == 'branch' or auth()->user()->department == 'financial' or auth()->user()->department == 'laboratory')
                            <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="users"></i><span>Customers</span></a>
                                <ul class="nav-submenu menu-content">
                                    <li><a href="/customer/create">New Customer</a></li>
                                    <li><a href="/customer/index">Customers List</a></li>
                                </ul>
                            </li>
                            @endif

                            @if(strtolower(Auth()->user()->department) == 'management')

                                <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="users"></i><span>Users</span></a>
                                    <ul class="nav-submenu menu-content">
                                        <li><a href="{{ route('user.create') }}">New User</a></li>
                                        <li><a href="{{ route('user.index') }}">Users List</a></li>
                                    </ul>
                                </li>
                            @endif
                            @if(auth()->user()->department == 'management' or auth()->user()->department == 'technical' or auth()->user()->department == 'branch' or auth()->user()->department == 'financial' or auth()->user()->department == 'laboratory')
                                <li class="dropdown"><a class="nav-link menu-title" href="{{ route('staticDocs.index') }}"><i data-feather="file"></i><span>Document Center</span></a>
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
                                <li><a class="nav-link menu-title" href="{{ route('report.create') }}"><i data-feather="database"></i><span>Reports</span></a></li>
                            @endif
                            <li><a class="nav-link menu-title link-nav" href="{{ route('search.index') }}"><i data-feather="search"></i><span>Search</span></a></li>
                        </ul>
                    </div>
                    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                </div>
            </nav>
        </header>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            @section('body')

            @show
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 footer-copyright">
                        <p class="mb-0">Copyright {{ date('Y') }} © Raymoon.io All rights reserved.</p>
                    </div>
                    <div class="col-md-6">
                        <p class="pull-right mb-0">Hand crafted & made with <i class="fa fa-heart font-secondary"></i></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- latest jquery-->
<script src="{{ asset('theme/viho/assets/js/jquery-3.5.1.min.js')}}"></script>
<!-- feather icon js-->
<script src="{{ asset('theme/viho/assets/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('theme/viho/assets/js/sidebar-menu.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/config.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('theme/viho/assets/js/bootstrap/popper.min.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/bootstrap/bootstrap.min.js')}}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('theme/viho/assets/js/chart/chartist/chartist.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/chart/chartist/chartist-plugin-tooltip.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/chart/knob/knob.min.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/chart/knob/knob-chart.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/prism/prism.min.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/counter/counter-custom.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/custom-card/custom-card.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/vector-map/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/vector-map/map/jquery-jvectormap-au-mill.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/vector-map/map/jquery-jvectormap-in-mill.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/vector-map/map/jquery-jvectormap-asia-mill.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/dashboard/default.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{ asset('theme/viho/assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('theme/viho/assets/js/script.js')}}"></script>
<!-- login js-->
@yield('moreJs')
<!-- Plugin used-->
</body>
</html>
