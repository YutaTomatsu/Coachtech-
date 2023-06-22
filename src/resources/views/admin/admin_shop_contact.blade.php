@extends('layouts.common_admin')

<head>
    <link href="{{ asset('css/shop_contact.css') }}" rel="stylesheet">
</head>
@section('content')
    <div class="contact__box">
        <div class="contents">
            @foreach ($contacts as $contact)
                @if ($contact->sent_by === 'shop')
                    <div class="shop__content-wrapper">
                        <div class="shop__content">{{ $contact->content }}</div>
                    </div>
                @else
                    <div class="icon__name">
                        @if ($contact->user->icon)
                            <img class="user__icon" src="{{ $contact->user->icon }}" alt="プロフィール画像">
                        @else
                            <img class="user__icon" src="/img/icon_user_2.svg" alt="プロフィール画像">
                        @endif
                        <div class="user__name">{{ $contact->user->name }}</div>
                    </div>
                    <div class="user__content-wrapper">
                        <div class="content">{{ $contact->content }}</div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
