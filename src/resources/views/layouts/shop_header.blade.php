<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/shop_header.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">
    <title>Document</title>
</head>


<body>
    <header>
        <div class="header__left">
            <div class="rogo">
                <a href="{{ route('home') }}">
                    <img class="ct" src="/img/cd_logo.png" alt="CT">
                </a>
            </div>
            <div class="rogo__name">SHOP</div>
        </div>
        <div class="header__right">
            <div class="profit">今月の利益 0円
            </div>
        </div>
    </header>
    <div class="menu__main">
        <ul class="menu">
            <li title="ホーム"><a href="{{ route('show-shop', ['id' => $shop->user_id]) }}" class="home">home</a></li>
            <li title="出品"><a href="{{ route('show-shop-sell', ['id' => $shop->id]) }}" class="search">search</a></li>
            <li title="クーポン"><a href="#" class="pencil">pencil</a></li>
            <li title="スタッフ"><a href="{{ route('show-staff', ['id' => $shop->id]) }}" class="stuff">about</a></li>
            <li title="編集"><a href="{{ route('show-shop-edit', ['id' => $shop->id]) }}" class="archive">archive</a>
            </li>
            @if(!$userEmail)
            <li title="戻る"><a href="{{ route('mypage') }}" class="contact">contact</a></li>
            @endif
        </ul>
        <main class="main">
            @yield('content')
        </main>
    </div>
    <script>
        $(document).ready(function() {
            $('main').css('overflow-y', 'scroll');
            $('main').css('max-height', '700px');
        });
    </script>

</body>

</html>
