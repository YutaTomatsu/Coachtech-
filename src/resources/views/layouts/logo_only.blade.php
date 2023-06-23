<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <header class="header">
        <div class="header__left">
            <div class="rogo">
                <a href="{{ route('home') }}">
                    <img class="ct" src="https://flea-market-bucket.s3.ap-northeast-1.amazonaws.com/etc/cd_logo.png" alt="CT">
                </a>
            </div>
            <div class="rogo__name">COATCHTECH</div>
        </div>
    </header>
    @yield('content')
</body>

</html>
