@extends('layouts.logo_only')

<head>
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
</head>

@section('content')
    <form class="form" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="title">会員登録</div>

        <div class="item__box">
            <x-label class="item__name" for="name" :value="__('ユーザー名')" />

            <x-input id="name" class="text" type="name" name="name" :value="old('name')" required />
        </div>

        <div class="item__box">
            <x-label class="item__name" for="email" :value="__('Email')" />

            <x-input id="email" class="text" type="email" name="email" :value="old('email')" required />
        </div>

        <div class="item__box">
            <x-label class="item__name" for="password" :value="__('Password')" />

            <x-input id="password" class="text" type="password" name="password" required autocomplete="new-password" />
        </div>

        <div class="under__box">
            <x-button class="button">
                {{ __('Register') }}
            </x-button>
            <a class="login" href="{{ route('login') }}">
                {{ __('ログインはこちら') }}
            </a>
        </div>

        <x-auth-validation-errors class="mb-4" :errors="$errors" />
    </form>
@endsection
