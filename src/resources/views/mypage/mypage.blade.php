<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mypage.css') }}" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <header class="header">
        <div class="header__left">
            @if (Auth::check())
                <div class="header__menu">
                    <button class="menu__design" type="button"></button>
                    <div class="under__line"></div>
                    <div class="menu">
                        <button class="close-button" type="button">X</button>
                        <div class="menu__all">
                            <a class="menu__item" href="{{ route('show-sell') }}">出品</a>
                            <form class="logout" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="menu__item">ログアウト</button>
                            </form>
                            <a href="{{ route('mypage') }}" class="menu__item">マイページ</a>
                            @if (!$haveShop)
                                <a class="menu__item" href="{{ route('show-create-shop') }}">ショップ作成</a>
                            @else
                                <a class="menu__item" href="{{ route('show-shop', ['id' => $user->id]) }}">ショップ管理</a>
                            @endif

                            <a class="menu__item" href="{{ route('profile') }}">プロフィール編集</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="header__menu">
                    <button class="menu__design" type="button">
                        <div class="third-line"></div>
                    </button>
                    <div class="under__line"></div>
                    <div class="menu">
                        <button class="close-button" type="button">X</button>
                        <div class="menu__all">
                            <a class="menu__item" href="{{ route('show-sell') }}">出品</a>
                            <a href="{{ route('register') }}" class="menu__item">会員登録</a>
                            <a href="{{ route('login') }}" class="menu__item">ログイン</a>
                        </div>
                    </div>
                </div>
            @endif
            <div class="rogo">
                <a href="{{ route('home') }}">
                    <img class="ct" src="/img/cd_logo.png" alt="CT">
                </a>
            </div>
            <div class="rogo__name">COATCHTECH</div>
        </div>

        <style>
            .menu {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: #ffffffaa;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                z-index: 1;
            }

            .close-button {
                background-color: black;
                color: white;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
                border: none;
                width: 40px;
                height: 40px;
                border-radius: 7px;
                margin: 50px 100px;
            }

            .menu__all {
                margin: 200px 0;
            }

            .logout {
                display: flex;
                justify-content: center;
                background-color: none;
            }

            .menu__item {
                display: flex;
                justify-content: center;
                color: black;
                font-size: 30px;
                margin: 15px 0;
                text-decoration: none;
                border: none;
                background-color: #ff000000;
            }

            .menu-open {
                transform: translateX(0%);
            }
        </style>

        <script>
            const button = document.querySelector('.menu__design');
            const menu = document.querySelector('.menu');
            const closeButton = document.querySelector('.close-button');

            function toggleMenu() {
                menu.classList.toggle('menu-open');
            }
            button.addEventListener('click', toggleMenu);
            closeButton.addEventListener('click', toggleMenu);
        </script>

        <form class="search" method="GET" action="{{ route('search') }}">
            <input class="search__text" name="search" type="text" placeholder="なにをお探しですか？">
        </form>

        @if (Auth::check())
            <div class="header__right">
                <form class="logout" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="header__item" href="#"
                        onclick="event.preventDefault(); this.closest('form').submit();">ログアウト</a>
                </form>
                <a class="header__item" href="{{ route('mypage') }}">マイページ</a>
                <a class="sell" href="{{ route('sell') }}">出品</a>
            </div>
        @else
            <div class="header__right">
                <a class="header__item" href="{{ route('login') }}">ログイン</a>
                <a class="header__item" href="{{ route('register') }}">会員登録</a>
                <a class="sell" href="{{ route('show-sell') }}">出品</a>
            </div>
        @endif
    </header>

<main>
    <div class="top">
        <div class="user">
            <div class="icon__name__box">
                <div class="icon">
                    <img class="user__icon" id="preview" src="{{ $user->icon }}" alt="プロフィール画像">
                </div>
                <div class="user__left__right">
                    <div class="username">{{ $user->name }}</div>
                    <a class="rating__detail" href="{{ route('show-reviews', ['id' => $user->id]) }}">
                        <p class="star-rating" data-rate="{{ round($reviewsAvg * 2) / 2 }}"></p>
                        <p class="rating__count">{{ $totalReviews }}</p>
                    </a>
                </div>
            </div>

            <div class="user__right">
                @if (!$haveShop)
                    <a class="shop" href="{{ route('show-create-shop') }}">ショップ作成</a>
                @else
                    <a class="shop" href="{{ route('show-shop', ['id' => $user->id]) }}">ショップ管理</a>
                @endif

                <a class="edit" href="{{ route('profile') }}">プロフィールを編集</a>
            </div>
        </div>

        <div class="follow__box">
            <a class="following" href="{{ route('following', ['id' => $user->id]) }}">
                {{ $following }} フォロー中
            </a>
            <a class="follower" href="{{ route('follower', ['id' => $user->id]) }}">
                {{ $follower }} フォロワー
            </a>
        </div>
    </div>

    <div class="buttton__box">
        <button class="change__button active sell__button" id="recommendTrigger">出品した商品</button>
        <div class="button__buttom">
            <button class="change__button" id="mylistTrigger">購入した商品</button>
            <button class="change__button" id="reviewTrigger">未レビューの商品</button>
        </div>
    </div>
    <div class="main">
        <div class="recommend">
            <div class="item__box" id="recommendItems">
                @foreach ($items as $item)
                    <a class="item" href="{{ route('detail', ['id' => $item->id]) }}">
                        <img class="image" src="{{ $item->image }}" alt="Item Image">
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mylist">
            <div class="item__box" id="mylistItems" style="display: none;">
                @foreach ($purchaseItems as $purchaseItem)
                    <a class="item" href="{{ route('detail', ['id' => $purchaseItem->id]) }}">
                        <img class="image" src="{{ $purchaseItem->image }}" alt="Item Image">
                    </a>
                @endforeach
            </div>
        </div>
        <div class="not__review">
            <div class="item__box" id="reviewItems" style="display: none;">
                @foreach ($notReviews as $notReview)
                    <a class="item" href="{{ route('detail', ['id' => $notReview->id]) }}">
                        <img class="image" src="{{ $notReview->image }}" alt="Item Image">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var recommendTrigger = document.getElementById('recommendTrigger');
            var recommendItems = document.getElementById('recommendItems');
            var mylistTrigger = document.getElementById('mylistTrigger');
            var mylistItems = document.getElementById('mylistItems');
            var reviewTrigger = document.getElementById('reviewTrigger');
            var reviewItems = document.getElementById('reviewItems');

            recommendTrigger.addEventListener('click', function() {
                recommendItems.style.display = 'flex';
                mylistItems.style.display = 'none';
                reviewItems.style.display = 'none';

                recommendTrigger.classList.add('active');
                mylistTrigger.classList.remove('active');
                reviewTrigger.classList.remove('active');
            });

            mylistTrigger.addEventListener('click', function() {
                recommendItems.style.display = 'none';
                mylistItems.style.display = 'flex';
                reviewItems.style.display = 'none';

                mylistTrigger.classList.add('active');
                recommendTrigger.classList.remove('active');
                reviewTrigger.classList.remove('active');
            });

            reviewTrigger.addEventListener('click', function() {
                recommendItems.style.display = 'none';
                mylistItems.style.display = 'none';
                reviewItems.style.display = 'flex';

                mylistTrigger.classList.remove('active');
                recommendTrigger.classList.remove('active');
                reviewTrigger.classList.add('active');
            });
        });
    </script>

</body>

</html>
