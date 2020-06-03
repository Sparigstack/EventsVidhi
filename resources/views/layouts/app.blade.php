<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PanelHive - Event Management System') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Custom Theme Scripts -->
        <script src="{{ asset('assets/js/jquery.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/popper.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/sidebar-menu.js') }}" defer></script>
        <script src="{{ asset('assets/js/app-script.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Custom Theme Styles -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet">
    </head>

    <body>
        <!-- start loader -->
        <!-- <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div> -->
        <!-- end loader -->
        <div id="app">
            <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
                <a href="{{ url('/') }}" class="my-0 mr-md-auto font-weight-normal"><img src="{{ asset('assets/images/logo-icon.png') }}" alt="logo icon" style="max-height: 36px;max-width: inherit;"></a>
                <nav class="my-2 my-md-0 mr-md-3">
                    <a class="p-2 text-dark" href="#">Events</a>
                    <a class="p-2 text-dark" href="#">Organizers</a>
                    <a class="p-2 text-dark" href="#">Support</a>
                    <a class="p-2 text-dark" href="#">Pricing</a>
                    @guest
                    <a class="p-2 text-dark text-bold" href="{{ route('login') }}">Login</a>
                    @else
                    <a class="p-2 text-dark" title="go to My Account" href="{{ route('orgEvents') }}">{{ Auth::user()->name }}</a>
                    @endguest
                </nav>
                @guest
                <a class="btn btn-outline-primary  " href="{{ route('register') }}">List Your Event</a>
                @else
                <a class="btn btn-outline-primary" href="{{ route('newEvent') }}">Create New Event</a>
                @endguest

            </div>
            <main class="py-4">
                @yield('content')
            </main>
        </div>

    </body>
</html>