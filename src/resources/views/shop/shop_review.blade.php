@extends('layouts.common')

<head>
    <link href="{{ asset('css/reviews.css') }}" rel="stylesheet">
</head>

@section('content')
    <div class="top">
        <div class="user">
            <a class="icon" href="{{ route('shop-toppage', ['id' => $shop->id]) }}">
                <img id="preview" src="{{ asset($shop->shop_icon) }}" alt="プロフィール画像"
                    style="width: 100px; height: 100px; border-radius: 50%;">
            </a>

            <div class="user__right">
                <div class="username">{{ $shop->shop_name }}</div>
                <a class="rating__detail" href="{{ route('show-shop-reviews', ['id' => $shop->id]) }}">
                    <p class="star-rating" data-rate="{{ round($reviewsAvg * 2) / 2 }}"></p>
                    <p class="rating__count">{{ $totalReviews }}</p>
                </a>
            </div>
        </div>
    </div>

    <div class="reviews__title" id="recommendTrigger">評価一覧</div>

    @foreach ($reviews as $review)
        <div class="review">
            <img class="buyer__icon" src="{{ asset($review->user->icon) }}">
            <div class="review__right">
                <div>{{ $review->user->name }}</div>
                <div class="comment">{{ $review->comment }}</div>
            </div>
        </div>
    @endforeach
@endsection
