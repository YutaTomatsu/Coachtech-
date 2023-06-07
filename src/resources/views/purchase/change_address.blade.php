@extends('layouts.no_item')
    <head>
        <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    </head>
@section('content')
    <form class="form" method="POST" action="{{ route('change-address',['id'=>$item->id]) }}">
        @csrf
        <div class="title">住所の変更</div>

        <div class="item__box">
            <x-label class="item__name" for="postcode" :value="__('郵便番号')" />
            <x-input class="text" id="postcode" type="postcode" name="postcode" :value="optional()->postcode" required />
        </div>

        <div class="item__box">
            <x-label class="item__name" for="address" :value="__('住所')" />
            <x-input class="text" id="address" type="address" name="address" :value="optional()->address" required />
        </div>

        <div class="item__box">
            <x-label class="item__name" for="build" :value="__('建物名')" />
            <x-input class="text" id="build" type="text" name="build" :value="optional()->build"/>
        </div>
        <div class="under__box">
            <x-button class="button">
                {{ __('更新する') }}
            </x-button>
        </div>
        <x-auth-session-status class="status" :status="session('status')" />
        <x-auth-validation-errors class="error" :errors="$errors" />
    </form>
@endsection
