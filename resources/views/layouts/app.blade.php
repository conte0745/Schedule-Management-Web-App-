<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">


    <title>シフト管理アプリ しふとん</title>
    <link rel="icon" href="{{ asset('/image/icon_maru.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('/image/icon_maru.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="{{ asset('/image/icon.png') }}" />
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
   

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('call_css')
</head>
<body style="background-color:#fffafa">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/top') }}">
                    しふとん
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!--<ul class="navbar-nav mr-auto">-->

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
                        @if ($_SERVER['REQUEST_URI'] == '/calendar')
                            <li class="nav-item active" >
                        @else
                            <li class="nav-item">
                        @endif
                            <a class="nav-link" href="{{ route('calendar') }}">マンツリー</a>
                        </li>
                        
                        @if($_SERVER['REQUEST_URI'] == '/calendar/chat')
                            <li class="nav-item active" >
                        @else
                            <li class="nav-item">
                        @endif
                            <a class="nav-link" href="{{ route('chat') }}">チャット</a>
                        </li>
                        
                        @if ($_SERVER['REQUEST_URI'] == '/calendar/mypage')
                            <li class="nav-item active">
                        @else
                            <li class="nav-item">
                        @endif
                            <a class="nav-link" href="{{ route('calendar.mypage') }}">マイページ</a>
                        </li>
                            
                    </ul>
                    <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            </li>
                    </ul>        
                    @endguest
                    </ul>
                </div>
            </div>
        </nav>
    <main class="py-4">
        @yield('contains')
    </main>
    </div>
    
    @yield('javascript')
    
</body>
</html>
