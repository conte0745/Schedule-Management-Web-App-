@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection


@section('contains')

<chatshow-component></chatshow-component>

@endsection