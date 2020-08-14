<!doctype html>
<?php $v = "1.0.1"; ?>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PanelHive - Event Management System') }}</title>

        <!-- Scripts -->
        <!-- <script src="{{ asset('assets/js/app.js') }}" defer></script> -->

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.form.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
        <script src="{{ asset('assets/js/sidebar-menu.js') }}" defer></script>
        <script src="{{ asset('assets/js/app-script.js') }}" defer></script>

        @yield('script')

         <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Custom Theme Styles -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css?v='.$v) }}" rel="stylesheet">
        @yield('css')

        <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
        <!-- Custom Theme Scripts -->
        <!-- <script src="{{ asset('assets/js/jquery.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/popper.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
        <script src="{{ asset('assets/js/sidebar-menu.js') }}" defer></script>
        <script src="{{ asset('assets/js/app-script.js') }}" defer></script> -->
    </head>

    <body>
        <!-- start loader -->
        <!-- <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div> -->
        <!-- end loader -->
        <div id="app">
            <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
                <a href="{{ url('/') }}" class="my-0 mr-md-auto font-weight-normal"><img src="{{ asset('assets/images/logo-icon.png') }}" alt="logo icon" style="max-height: 36px;max-width: inherit;"></a>
                <nav class="my-2 my-md-0 mr-md-3 row">
                    <a class="p-2 text-dark" href="#">Events</a>
                    <a class="p-2 text-dark" href="#">Organizers</a>
                    <a class="p-2 text-dark" href="#">Support</a>
                    <a class="p-2 text-dark" href="#">Pricing</a>

                    <?php 
                    $userType = 0;
                        if(Auth::user()){
                            $userType = Auth::user()->user_type;
                        }

                        if($userType == 2){?>

                        <ul class="navbar-nav align-items-center right-nav-link">

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret UserIconWithText pt-0" data-toggle="dropdown" href="#">
                           
                            <div>
                                <!-- <span class="user-profile"><img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar"></span> -->
                                <?php
                                $profileLogo = "";
                                 if(!is_null(Auth::user()->profile_pic) && Auth::user()->profile_pic != ""){
                                 $profileLogo = env("AWS_URL"). Auth::user()->profile_pic; ?>
                                <span class="user-profile"><img src="{{$profileLogo}}" class="img-circle" alt="user avatar"></span>
                               <?php } else{ ?>
                                    <span class="user-profile"><img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar"></span>
                               <?php } ?>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <!-- <div class="avatar"><img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar"></div> -->
                                        <?php
                                $profileLogo = "";
                                 if(!is_null(Auth::user()->profile_pic) && Auth::user()->profile_pic != ""){
                                 $profileLogo = env("AWS_URL"). Auth::user()->profile_pic; ?>
                                 <div class="avatar"><img class="align-self-start mr-3" src="{{$profileLogo}}" alt="user avatar"></div>
                               <?php } else{ ?>
                                    <div class="avatar"><img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar"></div>
                               <?php } ?>

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
                            <li class="dropdown-item"><a style="color:inherit" href="{{url('userProfile')}}"><i class="icon-settings mr-2"></i> Profile</a></li>
                            <li class="dropdown-divider"></li>
                            <!-- <li class="dropdown-item"><a style="color:inherit" href="{{url('account')}}"><i class="icon-wallet mr-2"></i> Account</a></li> -->
                            <!-- <li class="dropdown-divider"></li> -->
                            <li class="dropdown-item"><a style="color:inherit" href="{{url('org/settings')}}"><i class="icon-settings mr-2"></i> Settings</a></li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><a class style="color:inherit" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="icon-power mr-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

                    <?php } else{ ?>

                    @guest
                    <a class="p-2 text-dark text-bold" href="{{ route('login') }}">Login</a>
                    @else
                    <a class="p-2 text-dark" title="go to My Account" href="{{ route('orgEvents') }}">{{ Auth::user()->name }}</a>
                    @endguest

                    <?php } ?>

                </nav>
                <?php 
                    $userTypeCheck = 0;
                        if(Auth::user()){
                            $userTypeCheck = Auth::user()->user_type;
                        }

                        if($userTypeCheck == 2){} else{ ?>
                @guest
                <a class="btn btn-outline-primary" href="{{ route('register') }}">List Your Event</a>
                @else
                <a class="btn btn-outline-primary" href="{{ route('newEvent') }}">Create New Event</a>
                @endguest
                <?php } ?>

            </div>
            <main class="py-4">
                @yield('content')
            </main>
        </div>

    </body>
</html>