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
            <div class="header__menu">
                <button class="menu__design" type="button"></button>
                <div class="under__line"></div>
                <div class="menu__items">
                    <ul class="menu">
                        <li title="閉じる"><a href="#" class="close-button">閉じる</a></li>
                        <li title="ホーム"><a href="{{ route('show-shop', ['id' => $shop->user_id]) }}"
                                class="home">ホーム</a></li>
                        <li title="出品"><a href="{{ route('show-shop-sell', ['id' => $shop->id]) }}"
                                class="search">出品/a>
                        </li>
                        <li title="クーポン"><a href="{{ route('show-coupons', ['id' => $shop->id]) }}"
                                class="pencil">クーポン</a>
                        </li>
                        <li title="スタッフ"><a href="{{ route('show-staff', ['id' => $shop->id]) }}"
                                class="stuff">スタッフ</a>
                        </li>
                        <li title="メール"><a href="{{ route('show-mails', ['id' => $shop->id]) }}"
                                class="email">メール</a></li>
                        @if (!isset($userStaff))
                            <li title="編集"><a href="{{ route('show-shop-edit', ['id' => $shop->id]) }}"
                                    class="archive">編集</a>
                            </li>
                        @endif
                        @if (!isset($userStaff))
                            <li title="戻る"><a href="{{ route('mypage') }}" class="contact">contact</a></li>
                        @else
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                                @csrf
                            </form>

                            <li title="ログアウト">
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="contact">ログアウト</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="rogo">
                <a href="{{ route('show-shop', ['id' => $shop->user_id]) }}">
                    <img class="ct" src="https://flea-market-bucket.s3.ap-northeast-1.amazonaws.com/etc/cd_logo.png" alt="CT">
                </a>
            </div>
            <div class="rogo__name">SHOP</div>
        </div>
        <div class="header__right">
        </div>
    </header>

    <script>
        const button = document.querySelector('.menu__design');
        const menu = document.querySelector('.menu__items');
        const closeButton = document.querySelector('.close-button');

        function toggleMenu() {
            menu.classList.toggle('menu-open');
        }
        button.addEventListener('click', toggleMenu);
        closeButton.addEventListener('click', toggleMenu);
    </script>

    <div class="menu__main">
        <div class="menu__hidden">
            <ul class="menu">
                <li title="ホーム"><a href="{{ route('show-shop', ['id' => $shop->user_id]) }}" class="home">ホーム</a>
                </li>
                <li title="出品"><a href="{{ route('show-shop-sell', ['id' => $shop->id]) }}" class="search">出品/a>
                </li>
                <li title="クーポン"><a href="{{ route('show-coupons', ['id' => $shop->id]) }}" class="pencil">クーポン</a>
                </li>
                <li title="スタッフ"><a href="{{ route('show-staff', ['id' => $shop->id]) }}" class="stuff">スタッフ</a>
                </li>
                <li title="メール"><a href="{{ route('show-mails', ['id' => $shop->id]) }}" class="email">メール</a>
                </li>
                @if (!isset($userStaff))
                    <li title="編集"><a href="{{ route('show-shop-edit', ['id' => $shop->id]) }}"
                            class="archive">編集</a>
                    </li>
                @endif
                @if (!isset($userStaff))
                    <li title="戻る"><a href="{{ route('mypage') }}" class="contact">戻る</a></li>
                @else
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                        @csrf
                    </form>
                    <li title="ログアウト">
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="contact">ログアウト</a>
                    </li>
                @endif
            </ul>
        </div>
        <main class="common__main">
            @yield('content')
        </main>
    </div>
</body>

</html>
