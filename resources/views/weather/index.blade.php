@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/weather.css') }}">
@endsection

@section('contains')

<div class="container-fluid weather">
    <div id="top">
        <span class="title">天気予報</span>
        <span class="subTitle text-muted">東京の天気(毎日3時付近更新)</span>
    </div>
    <div class="row">
        @foreach($data as $date => $attributes)
            <div class="card col-xl-6 main">
                <span class="card-header">{{ $date }}</span>
                <div class="card-body">
                    <table class="card-text table table-sm table-bordered table-responsive">
                        <tr class="head"><th>時間</th>
                            @foreach($attributes as $attribute)
                                <th>{{ substr($attribute[0],0 ,2).'時' }}</th>
                            @endforeach
                        </tr>
                        <tr><th>気温</th>
                            @foreach($attributes as $attribute)
                                <td>{{ $attribute[1] }}</td>
                            @endforeach
                        </tr>
                        <tr><th>湿度</th>
                            @foreach($attributes as $attribute)
                                <td>{{ $attribute[2] }}</td>
                            @endforeach
                        </tr>
                        <tr><th>天気</th>
                            @foreach($attributes as $attribute)
                                <td>{{ $attribute[3] }}</td>
                            @endforeach
                        </tr>
                        <tr class="desc"><th>詳細</th>
                            @foreach($attributes as $attribute)
                                <td>{{ $attribute[4] }}</td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection