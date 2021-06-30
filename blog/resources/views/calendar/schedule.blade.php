@extends('layouts.standard')

@section('contains')
    <h1>Calendar</h1>
    <h2>{{ \Carbon\Carbon::yesterday()->format('Y年m月d日') }}</h2>
    <table>
        <tr>
            <td>日</td><td>月</td><td>火</td><td>水</td><td>木</td><td>金</td><td>土</td>
        </tr>
        <tr>
            <th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th>
        </tr>
    </table>
    <input type="date" min="2021-07-01" max="2021-10-01"></input>

@endsection