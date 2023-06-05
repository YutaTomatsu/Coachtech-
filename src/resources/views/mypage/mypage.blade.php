@extends('layouts.common')

@section('content')

    <head>
        <link href="{{ asset('css/mypage.css') }}" rel="stylesheet">
    </head>
    <div class="top">
        <div class="user">
            <div class="icon">
                <img id="preview" src="{{ asset($user->icon) }}" alt="プロフィール画像"
                    style="width: 100px; height: 100px; border-radius: 50%;">
            </div>

            <div class="username">{{ $user->name }}</div>
        </div>

        <a class="edit" href="{{ route('profile') }}">プロフィールを編集</a>
    </div>

    <style>
        .change__button {
            background-color: transparent;
            color: gray;
        }

        .active {
            color: #ff5858;
            ;
        }
    </style>

    <button class="change__button active" id="recommendTrigger">出品した商品</button>
    <button class="change__button" id="mylistTrigger">購入した商品</button>

    <div class="main">
        <div class="recommend">
            <div class="item__box" id="recommendItems">
                @foreach ($items as $item)
                    <a class="item" href="{{ route('detail', ['id' => $item->id]) }}">
                        <img class="image" src="{{ $item->image }}" alt="Item Image">
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mylist">
            <div class="item__box" id="mylistItems" style="display: none;">
                @foreach ($purchaseItems as $purchaseItem)
                    <a class="item" href="{{ route('detail', ['id' => $purchaseItem->id]) }}">
                        <img class="image" src="{{ $purchaseItem->image }}" alt="Item Image">
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
@endsection
