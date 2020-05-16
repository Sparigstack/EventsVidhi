<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
                <a href="{{ url('/') }}" class="my-0 mr-md-auto font-weight-normal"><img src="{{ asset('assets/images/logo-icon.png') }}" alt="logo icon" style="max-height: 36px;max-width: inherit;"><h5 class="font-weight-normal">PanelHive</h5></a>
                <nav class="my-2 my-md-0 mr-md-3">
                    <a class="p-2 text-dark" href="#">Events</a>
                    <a class="p-2 text-dark" href="#">Organizers</a>
                    <a class="p-2 text-dark" href="#">Support</a>
                    <a class="p-2 text-dark" href="#">Pricing</a>
                    <a class="p-2 text-dark" href="{{ route('login') }}">Login</a>
                </nav>
                <a class="btn btn-outline-primary" href="{{ route('register') }}">List Your Event</a>
            </div>
        </div>
        <div id="app2">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <a href="{{ url('/') }}" class="navbar-brand ml-4"><img src="{{ asset('assets/images/logo-icon.png') }}" alt="logo icon" style="max-height: 36px;max-width: inherit;"></a>
                <div class="container">
                    <!-- <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a> -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>

</html>