@extends('layouts.logo_only')

<head>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

@section('content')
    <form class="form" method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="title">パスワード再設定</div>

        <div class="item__box">
            <x-label class="item__name" for="email" :value="__('メールアドレス')" />

            <x-input class="text" id="email" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <div class="message">パスワードを再設定するアカウントのメールアドレスを記入してください</div>

        <div class="under__box">
            <x-button class="button">メールを送信する</x-button>
        </div>

        <x-auth-session-status class="status" :status="session('status')" />
        <x-auth-validation-errors class="error" :errors="$errors" />
    </form>
@endsection