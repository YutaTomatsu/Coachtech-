@extends('layouts.common_admin')

@section('content')
<form class="form" method="POST" action="{{ route('admins.send-email') }}">
    @csrf

    <div class="center">
        <div class="item">
            <div class="column">

                <div class="title">メール一斉送信</div>

                <div class="item__all">

                    <div class="line">
                        <label class="item__name" for="subject">Subject</label>
                        <input class="shop__name__text" type="text" name="subject" id="subject" value="{{ old('subject') }}" required>
                    </div>

                    @error('subject')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <div class="about">
                        <label class="about__name" for="message">Message</label>
                        <textarea name="message" id="message" required>{{ old('message') }}</textarea>
                    </div>

                    @error('message')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror

                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <button class="button" type="submit">Send Email</button>
</form>
@endsection