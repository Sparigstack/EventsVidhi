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

    <body style="background:white;">
        <?php $AwsUrl = env('AWS_URL'); ?>
        <header class="site-header">
        <div class="container">
            <div class="row" style="padding: 15px 0px;">
                <div class="col-md-3 col-lg-3" style="display: flex;justify-content: center;align-items: center;align-content: center;">
                    <a href="{{ url('/') }}" style="color: black;">
                    <h4 style="font-family: rockwell;font-weight: 400;" class=""> <span class="dot1"></span> <span class="dot"></span> panelhive </h4></a>
                </div>

                


                        </div>
                    </div>
                </header>

                @yield('content')

                <!--<footer class="site-footer" style="height: 150px;">-->
                <!--                        <div class="container mt-5" style="background:#fff;">-->
                <!--                            <div class="col-md-12 row">-->
                <!--                                <div class="col-md-6 footer-menu-column">-->
                <!--                                    <div class="col-md-12 row">-->
                <!--                                        <div class="col-md-4 footer-menu-first-column">-->
                <!--                                            <a href="#" class="mob-pd-common">About Us</a> -->
                <!--                                            <a href="#" class="mob-pd-common" style="padding-top:20px">Help</a>-->
                <!--                                        </div>-->
                <!--                                        <div class="col-md-4 footer-menu-second-column">-->
                <!--                                            <a href="#" class="mob-pd-common">Privacy Policy</a> -->
                <!--                                            <a href="#" class="mob-pd-common" style="padding-top:20px;">Pricing & Plans</a>-->
                <!--                                        </div>-->
                <!--                                        <div class="col-md-4 footer-menu-third-column">-->
                <!--                                            <a href="#" class="mob-pd-common">Contact Us</a>-->
                <!--                                        </div>-->
                <!--                                    </div>-->
                <!--                                </div>-->

                <!--                                <div class="col-md-6 footer-social">-->
                <!--                                    <a href="javascript:void()" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-facebook"></i></a>-->

                <!--                                    <a href="javascript:void()" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-linkedin"></i></a>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </footer>-->

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
@yield('script')

    </body>
</html>