<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

        <title>シフト管理アプリ しふとん</title>
        <link rel="icon" href="{{ asset('/image/icon_maru.png') }}" sizes="32x32" />
        <link rel="icon" href="{{ asset('/image/icon_maru.png') }}" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="{{ asset('/image/icon.png') }}" />
        <link rel="manifest" href="{{ asset('manifest.json') }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/top.css') }}" rel="stylesheet">
    
    </head>
    <body>
        <div id="app">
        <div class="flex-center position-ref full-height main">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="/calendar" class="btn btn-light btn-lg flex">　HOME　</a><br><br>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="btn btn-light btn-lg flex">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg">ログイン</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg">新規登録</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    シフト管理アプリ<br>しふとん<br><br>
                </div>
            </div>
        </div>
        </div>
        <script>
        // PWA
            window.addEventListener("load", () => {
             if ("serviceWorker" in navigator) {
                 navigator.serviceWorker
                     .register("/sw.js")
                     .then(registration => {
                         console.log("ServiceWorker registered");
                         registration.onupdatefound = function() {
                             console.log("Exist update");
                             registration.update();
                         };
                     })
                     .catch(error => {
                         console.warn("ServiceWorker error", error);
                     });
             }
            });
        </script>
    </body>
</html>
