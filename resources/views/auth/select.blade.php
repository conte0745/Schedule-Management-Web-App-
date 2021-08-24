@extends('layouts.app')
@section('contains')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">お店の選択</div>

                <div class="card-body">
                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" onclick="check()" checked>
                        <label class="form-check-label" for="flexRadioDefault1">お店に参加する</label>
                    </div>
                    
                    <form method="post" action="{{ route('select.already') }}" id="check1">
                        @csrf
                        <div class="form-group row">
                            <label for="shop_id" class="col-md-4 col-form-label text-md-right">お店のID</label>

                            <div class="col-md-6">
                                <input id="shop_id" type="text" class="form-control @error('shop_id') is-invalid @enderror" name="shop_id" value="{{ old('shop_id') }}" />

                                @error('shop_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">新規参加</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" onclick="check()">
                        <label class="form-check-label" for="flexRadioDefault2">新しくお店を作る</label>
                    </div>
                    
                    <form method="post" action="{{ route('select.new') }}" id="check2" style="visibility: hidden">
                        @csrf

                        <div class="form-group row">
                            <label for="shop" class="col-md-4 col-form-label text-md-right">お店の名前</label>

                            <div class="col-md-6">
                                <input id="shop" type="text" class="form-control @error('shop') is-invalid @enderror" name="shop" value="{{ old('shop') }}" >

                                @error('shop')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">新規作成</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript" src="{{ asset('js/select.js') }}"></script>
@endsection