@extends('layouts.shop_header')

<head>
    <link href="{{ asset('css/shop_contact.css') }}" rel="stylesheet">
</head>
@section('content')
    <div class="contact__box">
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

        <form class="form" method="POST" action="{{ route('shop-send-mail-to-user', ['id' => $contact->id]) }}">
            @csrf
            <textarea class="contact__form" name="content" id="content" required>{{ old('content') }}</textarea>
            @error('message')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <button class="button" type="submit">送信</button>
        </form>
    </div>
    @if($contactNotDone)
    <a href="{{route('contact-done',['id'=>$contact->id])}}" class="done" onclick="return confirm('対応済みにしてよろしいですか？')">対応済みにする</a>
    @endif
@endsection
