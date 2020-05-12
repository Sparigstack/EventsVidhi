<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Vidhi Events') }}</title>

        <!-- Scripts -->
        <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- datetimepicker -->
        <link href="{{ asset('assets/plugins/datetimepicker-master/jquery.datetimepicker.css') }}" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- custom styles -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- simplebar CSS-->
        <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet">
        <!-- Bootstrap core CSS-->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <!--animate CSS-->
    <li nk href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css">
        <!--Icons CSS-->
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <!--Sidebar CSS-->
        <link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet">
        <!--Custom Style-->
        <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet">
        <!--Bootstrap date picker-->
        <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">

        <!-- Data Tables -->
        <link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">


    </head>

<body>
    <div id="pageloader-overlay" class="visible incoming" style="display: none;">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <div id='app'></div>
    <div id="wrapper">
        <div id="sidebar-wrapper" class="bg-theme bg-theme2 active" data-simplebar="init" data-simplebar-auto-hide="true">
            <div class="simplebar-track vertical" style="visibility: visible;">
                <div class="simplebar-scrollbar" style="visibility: visible; top: 0px; height: 140px;"></div>
            </div>
            <div class="simplebar-track horizontal" style="visibility: hidden;">
                <div class="simplebar-scrollbar"></div>
            </div>
            <div class="simplebar-scroll-content" style="padding-right: 17px; margin-bottom: -34px;">
                <div class="simplebar-content" style="padding-bottom: 17px; margin-right: -17px;">
                    <div class="brand-logo">
                        <a href="index.html">
                            <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                            <h5 class="logo-text">Vidhi's Events</h5>
                        </a>
                    </div>
                    <div class="user-details">
                        <div class="media align-items-center" data-toggle="collapse">
                            <div class="avatar"><img class="mr-3 side-user-img" src="https://via.placeholder.com/110x110" alt="user avatar"></div>
                            <div class="media-body">
                                <h6 class="side-user-name">{{ Auth::user()->name }}</h6>
                            </div>
                        </div>
                    </div>
                    <ul class="sidebar-menu do-nicescrol in">
                        <li class="sidebar-header">MAIN NAVIGATION</li>
                        <li class="active">
                            <a href="javaScript:void();" class="waves-effect">
                                <i class="zmdi zmdi-view-dashboard"></i> <span>Events</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu in">
                                <li class="active"><a href="{{ url('org/events/new') }}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Add Event</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javaScript:void();" class="waves-effect">
                                <i class="zmdi zmdi-email"></i>
                                <span>Messages</span>
                                <small class="badge float-right badge-warning">12</small>
                            </a>
                        </li>

                        <li>
                            <a href="javaScript:void();" class="waves-effect">
                                <i class="zmdi zmdi-grid"></i> <span>Followers</span>
                            </a>
                        </li>



                    </ul>

                </div>
            </div>
        </div>
        <header class="topbar-nav">
            <nav class="navbar navbar-expand fixed-top">
                <ul class="navbar-nav mr-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link toggle-menu" href="javascript:void();">
                            <i class="icon-menu menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form class="search-bar">
                            <input type="text" class="form-control" placeholder="Enter keywords">
                            <a href="javascript:void();"><i class="icon-magnifier"></i></a>
                        </form>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center right-nav-link">

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                            <span class="user-profile"><img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar"><img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar"></div>
                                        <div class="media-body">
                                            <h6 class="mt-2 user-title">{{ Auth::user()->name }}</h6>
                                            <p class="user-subtitle">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <!-- <li class="dropdown-item"><i class="icon-envelope mr-2"></i> Inbox</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Account</li>
                            <li class="dropdown-divider"></li> -->
                            <li class="dropdown-item"><i class="icon-settings mr-2"></i> Profile</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><a class style="color:inherit" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" ><i class="icon-power mr-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>   
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <div class="clearfix"></div>
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>



    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.loading-indicator.js') }}"></script>
    <script src="{{ asset('assets/js/app-script.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script>
    <script src="{{asset('/js/customScript.js')}}" type="text/javascript"></script>
    <!-- Data Tables -->
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jszip.min.js') }}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>


    <!-- datetimepicker -->
    <script src="{{ asset('assets/plugins/datetimepicker-master/jquery.datetimepicker.js') }}"></script>
    <!-- <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
      $('#default-datepicker').datepicker({
        todayHighlight: true,
        format: 'mm/dd/yyyy',
        startDate: '-3d'
      });
      $('#autoclose-datepicker').datepicker({
        autoclose: true,
        todayHighlight: true
      });

      $('#inline-datepicker').datepicker({
         todayHighlight: true
      });

      $('#dateragne-picker .input-daterange').datepicker({
       });

    </script> -->

</body>

</html>