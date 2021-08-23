@extends('layouts.app')
@section('contains') 
@can('hasLine')
    <p>line notifyと連携を解除しました。</p><br><br>
@endcan
@cannot('hasLine')
    <p>line notifyと連携が完了しました。</p><br><br>
    
    <!--<h1>試し打ち</h1>-->
    <!--<form action="{{ route('calendar.mypage.line.send') }}" method="post">-->
    <!--    @csrf-->
    <!--    <label>-->
    <!--        メッセージ-->
    <!--        <input type="text" name="message" value="">-->
    <!--    </label>-->
    <!--    <input type="submit" value="送信">-->
    <!--</form>-->
@endcannot
    <p><a href="{{ route('calendar.mypage') }}">マイページへ戻る</a></p>

@endsection