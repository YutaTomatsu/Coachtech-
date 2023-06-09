@extends('layouts.common')

<head>
    <link href="{{ asset('css/reviews.css') }}" rel="stylesheet">
</head>

@section('content')
    <div class="top">
        <div class="user">
            <a class="icon" href="{{ route('show-seller', ['id' => $item->id]) }}">
                <img id="preview" src="{{ asset($user->icon) }}" alt="プロフィール画像"
                    style="width: 100px; height: 100px; border-radius: 50%;">
            </a>
            <div class="user__right">
                <div class="username">{{ $user->name }}</div>
                <a class="rating__detail" href="{{ route('show-reviews', ['id' => $user->id]) }}">
                    <p class="star-rating" data-rate="{{ round($reviewsAvg * 2) / 2 }}"></p>
                    <p class="rating__count">{{ $totalReviews }}</p>
                </a>
            </div>
        </div>
    </div>

    <div class="reviews__title" id="recommendTrigger">評価一覧</div>

    <div class="reviews__box">

        @if ($reviews->count() === 0)
            <div class="none__review">まだレビューがありません</div>
        @else
            @foreach ($reviews as $review)
                <div class="review">
                    <a href="{{ route('show-seller', ['id' => $review->user->id]) }}">
                        <img class="buyer__icon" src="{{ asset($review->user->icon) }}">
                    </a>
                    <div class="review__right">
                        <div>{{ $review->user->name }}</div>
                        <div class="comment">{{ $review->comment }}</div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
@endsection
