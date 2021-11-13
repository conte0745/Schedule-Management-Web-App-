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
        <style>
            html, body {
                background-color: #fffafa;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 300;
                font-size: 125%;
                margin: 0;
            }

            .item {
                height: 100px;
            }
            
            .parent{
                height: 200px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            
            
           
        </style>
        
    </head>
    <body>
        <div class="">
            <div class="parent">
                <p class="item">登録されていないアカウントです。</p>
                <p class="item"></p>
            </div>
            <div class="parent">
                <div class="item">
                    <a href="login" class="btn btn-primary" role="bottom">ログイン</a> 
                    <a href="register" class="btn btn-primary" role="bottom">新規登録</a> 
                </div>
            </div>
        </div>
    </body>
</html>
