@extends('layouts.shop_header')

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
            <img class="user__icon" src="{{ $user->icon }}" alt="プロフィール画像">
            <div class="user__name">{{ $contact->user->name }}</div>
        </div>
        <div class="user__content-wrapper">
            <div class="content">{{ $contact->content }}</div>
        </div>
        @endif
        @endforeach
    </div>

    <form class="form" method="POST" action="{{ route('shop-send-mail-to-user', ['id' => $contact->id]) }}">
        @csrf
        <textarea class="contact__form" name="content" id="content" required>{{ old('content') }}</textarea>
        @error('message')
        <p class="text-danger">{{ $message }}</p>
        @enderror
        <button class="button" type="submit">送信</button>
    </form>
</div>
@if ($contactNotDone)
<a href="{{ route('contact-done', ['id' => $contact->id]) }}" class="done">対応済みにする</a>
@endif




<div class="overlay"></div>
<div class="dialog-box">
    <p class="delete__confirm">対応済みにしてよろしいですか？</p>
    <div class="btn-wrapper">
        <button class="confirm">対応済みにする</button>
        <button class="cancel">閉じる</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteLinks = document.querySelectorAll('.done');
        const overlay = document.querySelector('.overlay');
        const dialogBox = document.querySelector('.dialog-box');
        const confirmButton = dialogBox.querySelector('.confirm');
        const cancelButton = dialogBox.querySelector('.cancel');
        let currentLink = null;

        deleteLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                currentLink = e.target;
                overlay.style.visibility = 'visible';
                overlay.style.opacity = '1';
                dialogBox.style.visibility = 'visible';
                dialogBox.style.opacity = '1';
            });
        });

        cancelButton.addEventListener('click', function() {
            overlay.style.opacity = '0';
            dialogBox.style.opacity = '0';
            setTimeout(function() {
                overlay.style.visibility = 'hidden';
                dialogBox.style.visibility = 'hidden';
            }, 500);
        });

        confirmButton.addEventListener('click', function() {
            window.location = currentLink.href;
        });
    });
</script>
@endsection