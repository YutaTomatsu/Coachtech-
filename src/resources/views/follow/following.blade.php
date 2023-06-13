@extends('layouts.common')

@section('content')

    <head>
        <link href="{{ asset('css/following.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <div>
        <div class="seller__box">
            @foreach ($following as $follow)
                <a class="seller" href="{{ route('show-following-seller', ['id' => $follow->seller_id]) }}">
                    <div class="seller__left">
                        <img class="icon" src="{{ $follow->seller->icon }}" alt="User Icon">
                        <div class="seller__name">{{ $follow->seller->name }}</div>
                    </div>

                    @if (Auth::user())
                        @if (Auth::id() != $follow->seller_id)
                            <button id="follow-button-{{ $follow->seller->id }}"
                                style="{{ $isFollowing ? 'display: none;' : '' }}">フォロー</button>

                            <button id="unfollow-button-{{ $follow->seller->id }}"
                                style="{{ $isFollowing ? '' : 'display: none;' }}">フォロー解除</button>
                        @endif
                    @endif
                </a>

                <script>
                    document.getElementById('follow-button-{{  $follow->seller->id }}').addEventListener('click', function(event) {
                        event.preventDefault();
                        var button = this;
                        var sellerId = "{{  $follow->seller->id }}";

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
                                button.style.display = 'none';
                                document.getElementById('unfollow-button-' + sellerId).style.display = 'inline-block';
                            } else {
                                // エラーが発生した場合の処理
                                console.error('フォローできませんでした。');
                            }
                        }).catch(function(error) {
                            console.error(error);
                        });
                    });

                    document.getElementById('unfollow-button-{{  $follow->seller->id }}').addEventListener('click', function(event) {
                        event.preventDefault();
                        var button = this;
                        var sellerId = "{{  $follow->seller->id }}";

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
                                button.style.display = 'none';
                                document.getElementById('follow-button-' + sellerId).style.display = 'inline-block';
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
            @if (count($following) === 0)
                <p>まだ誰もフォローしていません</p>
            @endif
        </div>
    </div>
@endsection
