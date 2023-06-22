@extends('layouts.common_admin')

<head>
    <link href="{{ asset('css/admin_dashboard.css') }}" rel="stylesheet">
</head>

@section('content')
<h2 class="title">ショップ一覧</h2>
    <div class="shops__box">
        @foreach ($shops as $shop)
            <a href="{{ route('admin-show-shop-contacts', ['id' => $shop->id]) }}" class="shop__box">
                <div class="icon__name">
                    @if ($shop->shop_icon)
                        <img class="shop__icon" src="{{ $shop->shop_icon }}">
                    @else
                        <img class="shop__icon" src="/img/icon_default.svg">
                    @endif
                    <div class="shop__name">{{ $shop->shop_name }}</div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
