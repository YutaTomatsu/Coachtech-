@extends('layouts.shop_header')

<head>
    <link href="{{ asset('css/shop_dashboard.css') }}" rel="stylesheet">
</head>

@section('content')
    <div class="myshop__box">
        <h2 class="title">マイショップ</h2>
        <div class="shop__detail">
            <div class="icon__name">
                @if ($shop->shop_icon)
                    <img class="shop__icon" src="{{ $shop->shop_icon }}">
                @else
                    <img class="shop__icon" src="/img/icon_default.svg" alt="icon">
                @endif
                <div class="shop__name">{{ $shop->shop_name }}</div>
            </div>
            <div class="about__box">
                <div class="about__title">ショップ説明</div>
                <div class="about">{{ $shop->about }}</div>
            </div>
        </div>
        <div class="items__box">
            <h2 class="title">出品履歴</h2>
            <div class="list">
                <button class="change__button active" id="recommendTrigger">出品中の商品</button>
                <button class="change__button" id="mylistTrigger">購入された商品</button>
            </div>
            <div class="main">
                <div class="recommend">
                    <div class="item__box" id="recommendItems">
                        @foreach ($sellingItems as $sellingItem)
                            <a class="item" href="{{ route('shop-item', ['id' => $sellingItem->id]) }}">
                                <img class="image" src="{{ $sellingItem->image }}" alt="Item Image">
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="mylist">
                    <div class="item__box" id="mylistItems" style="display: none;">
                        @foreach ($purchasedItems as $purchasedItem)
                            <a class="item" href="{{ route('shop-item', ['id' => $purchasedItem->id]) }}">
                                <div class="image-container">
                                    <img class="image" src="{{ $purchasedItem->image }}" alt="Item Image">
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var recommendTrigger = document.getElementById('recommendTrigger');
                    var recommendItems = document.getElementById('recommendItems');
                    var mylistTrigger = document.getElementById('mylistTrigger');
                    var mylistItems = document.getElementById('mylistItems');

                    recommendTrigger.addEventListener('click', function() {
                        recommendItems.style.display = 'flex';
                        mylistItems.style.display = 'none';

                        recommendTrigger.classList.add('active');
                        mylistTrigger.classList.remove('active');
                    });

                    mylistTrigger.addEventListener('click', function() {
                        recommendItems.style.display = 'none';
                        mylistItems.style.display = 'flex';

                        mylistTrigger.classList.add('active');
                        recommendTrigger.classList.remove('active');
                    });
                });
            </script>
        </div>
    @endsection
