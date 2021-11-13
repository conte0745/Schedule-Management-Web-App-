<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">


    <title>Generate Random String</title>
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
   

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/public.css') }}" rel="stylesheet">
</head>
<body>
    <div class="card">
        
        <h1 class="card-header">Generate Random String</h1>
        
        <ul>
            @foreach($random as $char)
                <input type="text" id="string{{ $loop->index }}" value="{{ $char }}" size="30"/>
                <button class="btn btn-sm btn-secondary" onclick="copyToClipboard({{$loop->index }})">copy</button>
                <span id="copied{{ $loop->index }}" style="visibility: hidden">copied</span>
                <br><br>
            @endforeach
        </ul>
        
        <form action="{{ route('random') }}">
            <label>文字列の長さ</label>
            <select name="num">
                @for($i=3;$i<51;$i++)
                    @if($i==30)
                        <option selected>{{ $i }}</option>
                    @else
                        <option>{{ $i }}</option>
                    @endif
                @endfor
            </select>
            <label>文字列の個数</label>
            <select name="cnt">
                @for($i=1;$i<20;$i++)
                    @if($i==5)
                        <option selected>{{ $i }}</option>
                    @else
                        <option>{{ $i }}</option>
                    @endif
                @endfor
            </select>
            <input type="submit" class="btn btn-sm btn-primary" value="make">
        </form>
        
            
    </div>
    <script type="text/javascript" src="{{ asset('js/copy.js') }}"></script>
</body>
</html>
