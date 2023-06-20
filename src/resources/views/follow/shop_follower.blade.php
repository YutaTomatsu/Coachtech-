@extends('layouts.common')

@section('content')

    <head>
        <link href="{{ asset('css/follower.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <div class="seller__box">
        @foreach ($followers as $follower)
            <a class="seller" href="{{ route('show-following-seller', ['id' => $follower->user_id]) }}">
                <div class="seller__left">
                    <img class="icon" src="{{ asset($follower->user->icon) }}" alt="User Icon">
                    <div class="seller__name">{{ $follower->user->name }}</div>
                </div>
            </a>
            @if (Auth::user())
                @if (Auth::id() != $follower->user_id)
                    @php
                        $isFollowing = \App\Models\Follow::where('user_id', \Auth::id())
                            ->where('seller_id', $follower->user_id)
                            ->exists();
                    @endphp
                    <button class="button" id="follow-button-{{ $follower->user->id }}"
                        style="{{ $isFollowing ? 'display: none;' : '' }}">フォロー</button>

                    <button class="button" id="unfollow-button-{{ $follower->user->id }}"
                        style="{{ $isFollowing ? '' : 'display: none;' }}">フォロー解除</button>
                @endif
            @endif

            <script>
                function updateFollowStatus(sellerId, isFollowing) {
                    var followButton = document.getElementById('follow-button-' + sellerId);
                    var unfollowButton = document.getElementById('unfollow-button-' + sellerId);

                    if (isFollowing) {
                        followButton.style.display = 'none';
                        unfollowButton.style.display = 'inline-block';
                    } else {
                        followButton.style.display = 'inline-block';
                        unfollowButton.style.display = 'none';
                    }
                }

                document.getElementById('follow-button-{{ $follower->user->id }}').addEventListener('click', function(event) {
                    event.preventDefault();
                    var button = this;
                    var sellerId = "{{ $follower->user->id }}";

                    // フォローの非同期リクエストを送信
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
                            // 成功した場合の処理
                            console.log('フォローしました！');
                            updateFollowStatus(sellerId, true);
                        } else {
                            // エラーが発生した場合の処理
                            console.error('フォローできませんでした。');
                        }
                    }).catch(function(error) {
                        console.error(error);
                    });
                });

                document.getElementById('unfollow-button-{{ $follower->user->id }}').addEventListener('click', function(event) {
                    event.preventDefault();
                    var button = this;
                    var sellerId = "{{ $follower->user->id }}";

                    // フォロー解除の非同期リクエストを送信
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
                            // 成功した場合の処理
                            console.log('フォローを解除しました！');
                            updateFollowStatus(sellerId, false);
                        } else {
                            // エラーが発生した場合の処理
                            console.error('フォロー解除できませんでした。');
                        }
                    }).catch(function(error) {
                        console.error(error);
                    });
                });
            </script>
        @endforeach
        @if (count($followers) === 0)
            <p>まだフォローされていません</p>
        @endif
    </div>
@endsection
