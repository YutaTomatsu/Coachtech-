@extends('layouts.common')

<head>
    <link href="{{ asset('css/reviews.css') }}" rel="stylesheet">
</head>

@section('content')
    <div class="top">
        <div class="user">
            <a class="icon" href="{{ route('shop-toppage', ['id' => $shop->id]) }}">
                @if ($shop->shop_icon)
                    <img id="preview" src="{{ $shop->shop_icon }}" alt="プロフィール画" class="shop__icon">
                @else
                    <img class="shop__icon"
                        src="https://flea-market-bucket.s3.ap-northeast-1.amazonaws.com/shops_icon/icon_default.svg"
                        alt="icon">
                @endif
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

    <main class="review__main">
        @if ($reviews->count() === 0)
            <div class="review__none">まだレビューがありません</div>
        @else
            @foreach ($reviews as $review)
                <div class="review">
                    <img class="buyer__icon" src="{{ $review->user->icon }}">
                    <div class="review__right">
                        <div>{{ $review->user->name }}</div>
                        <div class="comment">{{ $review->comment }}</div>
                    </div>
                </div>
            @endforeach
        @endif
    </main>
@endsection
