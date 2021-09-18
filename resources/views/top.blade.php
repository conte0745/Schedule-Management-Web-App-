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
        <style>
            html, body {
                background-color: #dbebc4;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                text-align: center;
                bottom: 25%;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 45px;
            }

            .links > a,form {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div id="app">
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <div class="links">
                            <a href="/calendar">しふとんのページへ</a><br><br>
                            <a  href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}">ログイン</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">新規登録</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    シフト管理アプリ<br>しふとん
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
