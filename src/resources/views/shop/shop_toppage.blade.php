@extends('layouts.common')

@section('content')

    <head>
        <link href="{{ asset('css/shop_toppage.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <div class="top">
        <div class="user">
            <div class="icon__name__box">
                <div class="icon">
                    @if ($shop->shop_icon)
                        <img class="shop__icon" src="{{ asset($shop->shop_icon) }}" alt="プロフィール画像">
                    @else
                        <img class="shop__icon" src="/img/icon_default.svg" alt="プロフィール画像">
                    @endif
                </div>

                <div class="user__left__right">
                    <div class="name__tag">
                        <div class="username">{{ $shop->shop_name }}</div>
                        <div class="shop__tag">SHOPS</div>
                    </div>
                    <a class="rating__detail" href="{{ route('show-shop-reviews', ['id' => $shop->id]) }}">
                        <p class="star-rating" data-rate="{{ round($reviewsAvg * 2) / 2 }}"></p>
                        <p class="rating__count">{{ $totalReviews }}</p>
                    </a>
                </div>
            </div>

            @if ($shop->user_id === Auth::id())
                <a class="shop" href="{{ route('show-shop', ['id' => Auth::id()]) }}">ショップ管理</a>
            @else
                <div class="follow__contact">
                    @if (Auth::check())
                        <button id="follow-button-{{ $shop->id }}" class="button"
                            style="{{ $isFollowing ? 'display: none;' : '' }}">フォロー</button>

                        <button id="unfollow-button-{{ $shop->id }}" class="button"
                            style="{{ $isFollowing ? '' : 'display: none;' }}">フォロー解除</button>
                    @else
                        <a class="button" href="{{ route('login') }}">フォロー</a>
                    @endif

                    <a class="shop" href="{{ route('contact', ['id' => $shop->id]) }}">お問い合わせ</a>
                </div>
            @endif
        </div>
        <div class="follow__box">
            <a class="follower" href="{{ route('shop-follower', ['id' => $shop->id]) }}">
                {{ $follower }} フォロワー
            </a>
            @if ($shop->user_id === Auth::id())
                <a class="shop__edit" href="{{ route('show-shop', ['id' => Auth::id()]) }}">ショップ管理</a>
            @else
                <div class="follow__responsive__contact">
                    @if (Auth::check())
                        <button id="follow-button-{{ $shop->id }}" class="button"
                            style="{{ $isFollowing ? 'display: none;' : '' }}">フォロー</button>

                        <button id="unfollow-button-{{ $shop->id }}" class="button"
                            style="{{ $isFollowing ? '' : 'display: none;' }}">フォロー解除</button>
                    @else
                        <a class="button" href="{{ route('login') }}">フォロー</a>
                    @endif

                    <a class="shop" href="{{ route('contact', ['id' => $shop->id]) }}">お問い合わせ</a>
                </div>
            @endif
        </div>
    </div>
    <button class="change__button active" id="recommendTrigger">出品した商品</button>

    <div class="main">
        <div class="recommend">
            <div class="item__box" id="recommendItems">
                @foreach ($shopItems as $shopItem)
                    <a class="item" href="{{ route('detail', ['id' => $shopItem->item_id]) }}">
                        <img class="image" src="{{ $shopItem->item->image }}" alt="Item Image">
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.getElementById('follow-button-{{ $shop->id }}').addEventListener('click', function(event) {
            event.preventDefault();
            var button = this;
            var shopId = "{{ $shop->id }}";
            fetch('{{ route('shop-follow') }}', {
                method: 'POST',
                body: JSON.stringify({
                    user_id: "{{ auth()->id() }}",
                    shop_id: shopId
                }),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(function(response) {
                if (response.ok) {
                    console.log('フォローしました！');
                    button.style.display = 'none';
                    document.getElementById('unfollow-button-' + shopId).style.display = 'inline-block';
                } else {
                    console.error('フォローできませんでした。');
                }
            }).catch(function(error) {
                console.error(error);
            });
        });

        document.getElementById('unfollow-button-{{ $shop->id }}').addEventListener('click', function(event) {
            event.preventDefault();
            var button = this;
            var shopId = "{{ $shop->id }}";
            fetch('{{ route('shop-unfollow') }}', {
                method: 'POST',
                body: JSON.stringify({
                    user_id: "{{ auth()->id() }}",
                    shop_id: shopId
                }),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(function(response) {
                if (response.ok) {
                    console.log('フォローを解除しました！');
                    button.style.display = 'none';
                    document.getElementById('follow-button-' + shopId).style.display = 'inline-block';
                } else {
                    console.error('フォロー解除できませんでした。');
                }
            }).catch(function(error) {
                console.error(error);
            });
        });
    </script>
@endsection
