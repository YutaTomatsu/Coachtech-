<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <title>Document</title>
</head>

<body>

    <header class="header">
    </header>

    <form class="form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="title">ログイン</div>

        <div class="item__box">
            <x-label class="item__name" for="email" :value="__('メールアドレス')" />

            <x-input class="text" id="email" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <div class="item__box">
            <x-label class="item__name" for="password" :value="__('パスワード')" />

            <x-input class="text" id="password" type="password" name="password" required
                autocomplete="current-password" />
        </div>
        <div class="under__box">
            <x-button class="button">
                {{ __('ログインする') }}
            </x-button>

            <a class="register" href="{{ route('register') }}">会員登録はこちら</a>
        </div>

        <x-auth-session-status class="status" :status="session('status')" />
        <x-auth-validation-errors class="error" :errors="$errors" />
    </form>

</body>

</html>
