@extends('layouts.logo_only')

<head>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

@section('content')
    <form class="form" method="POST" action="{{ route('password.update') }}">
        @csrf

        <div class="title">ログイン</div>

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="item__box">
            <x-label class="item__name" for="email" :value="__('メールアドレス')" />

            <x-input class="text" id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus />

        </div>

        <div class="item__box">
            <x-label class="item__name" for="password" :value="__('パスワード')" />

            <x-input class="text" id="password" type="password" name="password" required
                autocomplete="current-password" />
        </div>

        <div class="item__box">
            <x-label class="item__name" for="password_confirmation" :value="__('パスワード確認')" />

            <x-input id="password_confirmation" class="text" type="password" name="password_confirmation"
                required />
        </div>

        <div class="under__box">
            <x-button class="button">
                {{ __('パスワードをリセットする') }}
            </x-button>

        </div>

        <x-auth-session-status class="status" :status="session('status')" />
        <x-auth-validation-errors class="error" :errors="$errors" />
    </form>
@endsection


