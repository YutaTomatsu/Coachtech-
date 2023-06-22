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
            @if (Auth::check())
            <div class="header__menu">
                <button class="menu__design" type="button"></button>
                <div class="under__line"></div>
                <div class="menu">
                    <button class="close-button" type="button">X</button>
                    <div class="menu__all">
                        <a class="menu__item" href="{{ route('admin-show-email') }}">メール送信</a>
                        <form class="logout" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="menu__item">ログアウト</button>
                        </form>
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
                        <a href="{{ route('register') }}" class="menu__item">会員登録</a>
                        <a href="{{ route('login') }}" class="menu__item">ログイン</a>
                    </div>
                </div>
            </div>
            @endif
            <div class="rogo">
                <a href="{{route('admin.dashboard')}}">
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

        <div class="header__right">
            <form class="logout" method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="header__item" href="#" onclick="event.preventDefault(); this.closest('form').submit();">ログアウト</a>
            </form>
            <a class="header__item" href="{{ route('admin-show-email') }}">メール送信</a>
        </div>

    </header>
    <main class="common__main">
    @yield('content')
    </main>
</body>

</html>