@extends('layouts.app')
@section('contains') 
@can('hasLine')
    <p>line notifyと連携を解除しました。</p><br><br>
@endcan
@cannot('hasLine')
    <p>line notifyと連携が完了しました。</p><br><br>
    
@endcannot
    <p><a href="{{ route('calendar.mypage') }}">マイページへ戻る</a></p>

@endsection