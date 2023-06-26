@extends('layouts.shop_header')

<head>
    <link href="{{ asset('css/staff.css') }}" rel="stylesheet">
</head>

@section('content')
    <div class="myshop__box">
        <div class="staff">
            <h2 class="title">スタッフ一覧</h2>
            @if (!$userStaff)
                <a class="add__staff" href="{{ route('show-create-staff', ['id' => $shop->id]) }}">スタッフを追加する</a>
            @endif
        </div>

        @if ($staffs->count() === 0)
            <div class="staff__none">まだスタッフがいません</div>
        @else
            <div class="shop__detail">
                @foreach ($staffs as $staff)
                    <div class="staff__box">
                        <div class="left">
                            <div class="name__box">
                                <div class="staff__name__title">スタッフ名　</div>
                                <div class="staff__name">{{ $staff->staff->name }}</div>
                            </div>
                            <div class="email__box">
                                <div class="staff__email__title">メールアドレス　</div>
                                <div class="staff__email">{{ $staff->staff->email }}</div>
                            </div>
                        </div>
                        <div class="right">
                            @if (!$userStaff)
                                <form action="{{ route('staff-destroy', $staff) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete">削除する</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach

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
