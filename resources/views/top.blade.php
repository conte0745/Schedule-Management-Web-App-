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
        <div class="body">
            <table class="main" id="app">
                <tr class="blank">
                </tr>
                <tr>
                    <td class="title item">
                        <span>シフト管理アプリ</span><br><span>しふとん</span>
                    </td>
                </tr>
                @if (Route::has('login'))
                <tr>
                    <td>
                    <table class="links item">
                        <tr>
                        @auth
                            <td><a href="/calendar" class="btn btn-light btn-lg inline-block">　HOME　</a></td>
                            <td><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" class="btn btn-light btn-lg inline-block">
                                {{ __('Logout') }}
                            </a></td>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            </form>
                        @else
                            <td><a href="{{ route('login') }}" class="btn btn-light btn-lg inline-block">ログイン</a></td>
    
                            @if (Route::has('register'))
                                <td><a href="{{ route('register') }}" class="btn btn-light btn-lg inline-block">新規登録</a></td>
                            @endif
                        @endauth
                        </tr>
                    </table>
                    </td>
                </tr>
                @endif
            </table>
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
