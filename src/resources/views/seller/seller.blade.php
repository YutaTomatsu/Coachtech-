@extends('layouts.common')

@section('content')

    <head>
        <link href="{{ asset('css/seller.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <div class="top">
        <div class="user">
            <div class="icon__name__box">
                <div class="icon">
                    <img id="preview" src="{{ asset($user->icon) }}" alt="プロフィール画像"
                        style="width: 100px; height: 100px; border-radius: 50%;">
                </div>

                <div class="user__left__right">
                    <div class="username">{{ $user->name }}</div>
                    <a class="rating__detail" href="{{ route('show-reviews', ['id' => $user->id]) }}">
                        <p class="star-rating" data-rate="{{ round($reviewsAvg * 2) / 2 }}"></p>
                        <p class="rating__count">{{ $totalReviews }}</p>
                    </a>
                </div>
            </div>

            @if (Auth::check())
                <button id="follow-button-{{ $user->id }}" class="button"
                    style="{{ $isFollowing ? 'display: none;' : '' }}">フォロー</button>

                <button id="unfollow-button-{{ $user->id }}" class="button"
                    style="{{ $isFollowing ? '' : 'display: none;' }}">フォロー解除</button>
            @else
                <a class="button" href="{{ route('login') }}">フォロー</a>
            @endif
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

    </div>

    <button class="change__button active" id="recommendTrigger">出品した商品</button>

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
    </div>

    <script>
        document.getElementById('follow-button-{{ $user->id }}').addEventListener('click', function(event) {
            event.preventDefault();
            var button = this;
            var sellerId = "{{ $user->id }}";

            fetch('{{ route('follow') }}', {
                method: 'POST',
                body: JSON.stringify({
                    user_id: "{{ auth()->id() }}",
                    seller_id: sellerId
                }),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(function(response) {
                if (response.ok) {
                    console.log('フォローしました！');
                    button.style.display = 'none';
                    document.getElementById('unfollow-button-' + sellerId).style.display = 'inline-block';
                } else {
                    console.error('フォローできませんでした。');
                }
            }).catch(function(error) {
                console.error(error);
            });
        });

        document.getElementById('unfollow-button-{{ $user->id }}').addEventListener('click', function(event) {
            event.preventDefault();
            var button = this;
            var sellerId = "{{ $user->id }}";

            fetch('{{ route('unfollow') }}', {
                method: 'POST',
                body: JSON.stringify({
                    user_id: "{{ auth()->id() }}",
                    seller_id: sellerId
                }),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(function(response) {
                if (response.ok) {
                    console.log('フォローを解除しました！');
                    button.style.display = 'none';
                    document.getElementById('follow-button-' + sellerId).style.display = 'inline-block';
                } else {
                    console.error('フォロー解除できませんでした。');
                }
            }).catch(function(error) {
                console.error(error);
            });
        });
    </script>
@endsection
