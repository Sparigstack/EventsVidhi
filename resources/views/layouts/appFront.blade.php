<!doctype html>
<?php $v = "1.0.1"; ?>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PanelHive - Event Management System') }}</title>
<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

    <!-- datetimepicker -->
    <!-- <link href="{{ asset('assets/plugins/datetimepicker-master/jquery.datetimepicker.css') }}" rel="stylesheet"> -->
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- <link href="{{ asset('css/fonts.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/custom.css?v='.$v) }}" rel="stylesheet">
    <!-- custom styles -->
    <link href="{{ asset('css/style.css?v='.$v) }}" rel="stylesheet">
    <!-- simplebar CSS-->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet">
    <!-- Bootstrap core CSS-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--animate CSS-->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css">
    <!--Icons CSS-->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <!--Sidebar CSS-->
    <link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet">
    <!--Custom Style-->
    <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/owl.carousel.css') }}" rel="stylesheet">
        @yield('css')
    </head>

    <body>
        <?php $AwsUrl = env('AWS_URL'); ?>
        <header class="site-header">
        <div class="container">
            <input type="hidden" class="homePageUrl" value="{{url('/')}}">
            <!-- padding: 29px 0px; -->
            <!-- padding: 20px 0px; -->
            <div class="row" style="padding: 15px 0px;">
                <div class="col-md-3 col-lg-3 logodiv" style="display: flex;
                /*justify-content: center;*/
                align-items: center;
                /*align-content: center;*/
                ">
                    <h4 style="font-family: rockwell;font-weight: 400;" class="mt-1"> <span class="dot1"></span> <span class="dot"></span> <a href="{{ url('/') }}" style="color: black;"> panelhive </a> </h4>
                </div>

                <div class="col-md-5 col-lg-5 MobileMt searchbardiv mt-1">
                <!-- <div class="col-md-4 col-lg-4 mt-2"> -->
                    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                   <input name="" id="" type="search" value="" class="large serachEvent" placeholder="Search..." autocomplete="off">
                   <div class="searchIcon">
                    <!-- <a href="javascript:void();"> -->
                    <a onclick="searchTitle();" style="cursor: pointer;">
                        <i class="icon-magnifier" style=""></i>
                    </a>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4 MobileMt signupindiv" style="display: flex;justify-content: center;align-items: center;align-content: center;">
                    <!-- <div class="col-md-5 col-lg-5 mt-2 MobileMt" style="display: flex;align-items: center;"> -->
                        <!-- <span class="parent" style="margin-left: 5%;">
                        <a href="#" class="mr-4" style="color: black;">Help</a>
                            <a href="#" style="color:black;"> Why Us? </a>
                        </span> -->
                    @guest
                    <span class="parent marginzeromobile" style="margin-left: 40%;">
                        <a href="{{ route('login') }}">
                            <input type="button" id="" class="clickable signInButton" value="Sign In"></a>
                            <a href="{{ url('userRegister') }}">
                                <input type="button" id="" class="clickable signUpButton" value="Sign Up"></a>
                            </span>
                            @else

                            <?php
                            $marginLeft = "margin-left: 80%;";
                             if(Auth::user()->user_type == 1){
                                $marginLeft = "margin-left: 20%;";
                              ?>
                                <a href="{{ url('org/events') }}" target="_blank">
                                    <input type="button" id="" class="clickable createEventButton" value="Create an Event" style="background: #FED8C6;color:black;padding: 8px 25px;"></a>
                                <?php } ?>

                            <span class="parent marginzeromobile" style="{{$marginLeft}}">

                                <ul class="navbar-nav align-items-center right-nav-link">

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret UserIconWithText pt-0 pb-0" data-toggle="dropdown" href="#">

                            <div>
                                <!-- <span class="user-profile"><img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar"></span> -->
                                <?php
                                $profileLogo = "";
                                 if(!is_null(Auth::user()->profile_pic) && Auth::user()->profile_pic != ""){
                                 $profileLogo = env("AWS_URL"). Auth::user()->profile_pic; ?>
                                 <!-- img-circle -->
                                <span class="user-profile"><img src="{{$profileLogo}}" class="profileImg" alt="user avatar" style="height: 45px !important;width:45px !important;"></span>
                               <?php } else{ ?>
                                    <span class="user-profile"><img src="https://via.placeholder.com/110x110" class="profileImg" alt="user avatar" style="height: 45px !important;width:45px !important;"></span>
                               <?php } ?>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" style="">
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
                                            <h6 class="mt-3 user-title">{{ Auth::user()->name }}</h6>
                                            <!-- <p class="user-subtitle">{{ Auth::user()->email }}</p> -->
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <!-- <li class="dropdown-item"><i class="icon-envelope mr-2"></i> Inbox</li>
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Account</li>
                                <li class="dropdown-divider"></li> -->
                            <?php if(Auth::user()->user_type != 3){ ?>
                            <li class="dropdown-item"><a style="color:inherit" href="#"><i class="icon-settings mr-2"></i> My Account</a></li>
                            <?php } else { ?>
                                <li class="dropdown-item"><a style="color:inherit" href="{{url('myAccount')}}"><i class="icon-settings mr-2"></i> My Account</a></li>
                            <?php } ?>
                            <li class="dropdown-divider"></li>
                            <?php if(Auth::user()->user_type != 3){ ?>
                                <li class="dropdown-item"><a style="color:inherit" href="{{url('myContent')}}"><i class="icon-settings mr-2"></i> My Content</a></li>
                                <li class="dropdown-divider"></li>
                            <?php } ?>
                            <!-- <li class="dropdown-item"><a style="color:inherit" href="{{url('account')}}"><i class="icon-wallet mr-2"></i> Account</a></li> -->
                            <!-- <li class="dropdown-divider"></li> -->
                            <!-- <li class="dropdown-item"><a style="color:inherit" href="{{url('org/settings')}}"><i class="icon-settings mr-2"></i> Settings</a></li> -->
                            <!-- <li class="dropdown-divider"></li> -->
                            <li class="dropdown-item"><a class style="color:inherit" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="icon-power mr-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

                                    <!-- <img class="align-self-start profileImg ml-5" src="https://panelhiveus.s3.us-west-1.amazonaws.com/org_5/Profile/1601453003thumb1.jpg" alt="user avatar" style=""> -->
                                    <!-- <h5 style="font-weight: bold;" class="">
                                    <a href="#" class="" style="color: black;">{{Auth::user()->name}}</a></h5> -->
                                </span>
                                @endguest
                            </div>

                        </div>
                    </div>
                </header>

                @yield('content')

                <footer class="site-footer" style="height: 150px;">
                                        <div class="container mt-5" style="background:#fff;">
                                            <div class="col-md-12 row">
                                                <div class="col-md-6 footer-menu-column">
                                                    <div class="col-md-12 row">
                                                        <div class="col-md-4 footer-menu-first-column">
                                                            <a href="{{url('aboutUs')}}" class="mob-pd-common">About Us</a> 
                                                            <a href="{{url('information')}}" class="mob-pd-common" style="padding-top:20px">Help</a>
                                                        </div>
                                                        <div class="col-md-4 footer-menu-second-column">
                                                            <a href="#" class="mob-pd-common">Privacy Policy</a> 
                                                            <a href="#" class="mob-pd-common" style="padding-top:20px;">Pricing & Plans</a>
                                                        </div>
                                                        <div class="col-md-4 footer-menu-third-column">
                                                            <a href="#" class="mob-pd-common">Contact Us</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 footer-social">
                                                    <a href="javascript:void()" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-facebook"></i></a>

                                                    <a href="javascript:void()" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-linkedin"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </footer>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.form.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('assets/js/app-script.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script>
<script src="{{asset('/js/customScript.js?v='.$v)}}" type="text/javascript"></script>
<script src="{{ asset('assets/js/owl.carousel.js') }}"></script>
<script src="{{asset('/js/custom.js?v='.$v)}}" type="text/javascript"></script>
@yield('script')

    </body>
</html>