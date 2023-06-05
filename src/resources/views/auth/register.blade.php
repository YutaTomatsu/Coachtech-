<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <title>Document</title>
</head>

<body>

</body>

</html>
<header class="header">
    <a href="/">
    </a>
</header>

<form class="form" method="POST" action="{{ route('register') }}">
    @csrf

    <div class="title">会員登録</div>

    <!-- Email Address -->
    <div class="item__box">
        <x-label class="item__name" for="email" :value="__('Email')" />

        <x-input id="email" class="text" type="email" name="email" :value="old('email')" required />
    </div>

    <!-- Password -->
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
    <!-- Validation Errors -->
<x-auth-validation-errors class="mb-4" :errors="$errors" />
</form>
