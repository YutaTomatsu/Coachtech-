@extends('layouts.common_admin')

@section('content')

    <head>
        <link href="{{ asset('css/admin_email.css') }}" rel="stylesheet">
    </head>


    <div class="title">メール一斉送信</div>

    <div class="form__box">
        <form class="form" method="POST" action="{{ route('admins.send-email') }}">
            @csrf

            <div class="item__all">

                <div class="subject__box">
                    <label class="subject__name" for="subject">件名</label>
                    <input class="subject__text" type="text" name="subject" id="subject" value="{{ old('subject') }}"
                        required>
                </div>

                @error('subject')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="about__box">
                    <label class="about__name" for="message">本文</label>
                    <textarea class="about__text" name="message" id="message" required>{{ old('message') }}</textarea>
                </div>

                @error('message')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <button class="button" type="submit">メールを送信する</button>
        </form>
    </div>
@endsection
