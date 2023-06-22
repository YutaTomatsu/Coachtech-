@extends('layouts.logo_only')

<head>
    <link href="{{ asset('css/shop_contact.css') }}" rel="stylesheet">
</head>
@section('content')
<p class="title">ショップへの質問</p>
    <div class="contact__box">
        <div class="contents">
            @foreach ($contacts as $contact)
                @if ($contact->sent_by === 'user')
                    <div class="shop__content-wrapper">
                        <div class="shop__content">{{ $contact->content }}</div>
                    </div>
                @else
                    <div class="icon__name">
                        @if ($shop->icon)
                            <img class="user__icon" src="{{ $shop->shop_icon }}" alt="プロフィール画像">
                        @else
                            <img class="user__icon" src="/img/icon_user_2.svg" alt="プロフィール画像">
                        @endif
                        <div class="user__name">{{ $shop->shop_name }}</div>
                    </div>
                    <div class="user__content-wrapper">
                        <div class="content">{{ $contact->content }}</div>
                    </div>
                @endif
            @endforeach
        </div>

        <form class="form" method="POST" action="{{ route('shop-send-mail', ['id' => $shop->id]) }}">
            @csrf
            <textarea class="contact__form" name="content" id="content" required>{{ old('content') }}</textarea>
            @error('content')
                <!-- バリデーションエラーメッセージの表示 -->
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <button class="button" type="submit">送信</button>
        </form>
    </div>
@endsection
