@extends('layouts.common')
    <head>
        <link href="{{ asset('css/reviews.css') }}" rel="stylesheet">
    </head>

@section('content')
    <div class="top">
        <div class="user">
            <div class="icon">
                <img id="preview" src="{{ asset($user->icon) }}" alt="プロフィール画像"
                    style="width: 100px; height: 100px; border-radius: 50%;">
            </div>

            <div class="user__right">
                <div class="username">{{ $user->name }}</div>
                <div class="rating__detail">
                    <div clss="rating__avg">
                        <p class="star-rating" data-rate="{{ round($reviewsAvg * 2) / 2 }}"></p>
                    </div>
                    <p>{{ $totalReviews }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="reviews__title" id="recommendTrigger">評価一覧</div>

    @foreach ($reviews as $review)
        <div>{{ $review->user->name }}</div>
        <div>{{ $review->comment }}</div>
        <div class="rating__detail">
            <div clss="rating__avg">
                <p class="star-rating" data-rate="{{ round($reviewsAvg * 2) / 2 }}"></p>
            </div>
        </div>
    @endforeach
@endsection
