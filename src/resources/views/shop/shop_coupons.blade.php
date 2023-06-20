@extends('layouts.shop_header')

<head>
    <link href="{{ asset('css/coupons.css') }}" rel="stylesheet">
</head>

@section('content')
    <div class="myshop__box">
        <div class="staff">
            <h2 class="title">クーポン一覧</h2>
            <a class="add__staff" href="{{ route('show-create-coupon', ['id' => $shop->id]) }}">クーポンを作成する</a>
        </div>

        @if ($coupons->count() === 0)
            <div class="staff__none">まだクーポンがありません</div>
        @else
            <div class="shop__detail">
                @foreach ($coupons as $coupon)
                    <div class="coupon__box">
                        <div class="left">
                            <div class="staff__name">{{ $coupon->coupon_name }}</div>
                            <div class="type__box">
                                <div class="type__title">割引タイプ:</div>
                                @if ($coupon->discount_type === 'fixed_amount')
                                    <div class="type">〇〇円割引</div>
                                @else
                                    <div class="type">〇〇%OFF</div>
                                @endif
                            </div>
                            <div class="value__box">
                                <div class="value__title">割引額：</div>
                                @if ($coupon->discount_type === 'fixed_amount')
                                    <div class="value">{{ $coupon->discount_value }}円</div>
                                @else
                                    <div class="value">{{ $coupon->discount_value }}%</div>
                                @endif
                            </div>
                        </div>
                        <div class="right">
                            <form action="{{ route('coupon-destroy', $coupon) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete">削除する</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="overlay"></div>
            <div class="dialog-box">
                <p class="delete__confirm">本当に削除しますか？</p>
                <div class="btn-wrapper">
                    <button class="confirm">削除する</button>
                    <button class="cancel">閉じる</button>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const deleteForms = document.querySelectorAll('.delete-form');
                    const overlay = document.querySelector('.overlay');
                    const dialogBox = document.querySelector('.dialog-box');
                    const confirmButton = dialogBox.querySelector('.confirm');
                    const cancelButton = dialogBox.querySelector('.cancel');

                    deleteForms.forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
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
                        deleteForms.forEach(function(form) {
                            form.submit();
                        });
                    });
                });
            </script>
        @endif
    @endsection
