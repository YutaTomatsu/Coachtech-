@extends('layouts.shop_header')

<head>
    <link href="{{ asset('css/shop_contacts.css') }}" rel="stylesheet">
</head>
@section('content')
    @php
        $uniqueUsers = $users->unique('user_id');
        $uniquedoneContactUsers = $doneContactUsers->unique('user_id');
    @endphp
    <div class="items__box">
        <h2 class="title">出品履歴</h2>
        <div class="list">
            <button class="change__button active" id="recommendTrigger">未対応</button>
            <button class="change__button" id="mylistTrigger">対応済み</button>
        </div>
        <div class="main">
            <div class="users__box" id="recommendItems">
                @if ($uniqueUsers->count() === 0)
                    <div class="user__none">現在未対応のユーザーはいません</div>
                @else
                    @foreach ($uniqueUsers->sortByDesc('created_at') as $user)
                        <div class="user__box">
                            <a class="icon__name" href="{{ route('user-contents', ['id' => $user->id]) }}">
                                @if ($user->user->icon)
                                    <img class="icon" src="{{ $user->user->icon }}">
                                @else
                                    <img class="icon" src="/img/icon_user_2.svg">
                                @endif
                                <div class="user__name">{{ $user->user->name }}</div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="mylist">
                <div class="users__box" id="mylistItems" style="display: none;">
                    @if ($uniquedoneContactUsers->count() === 0)
                        <div class="user__none">現在対応済みのユーザーはいません</div>
                    @else
                        @foreach ($uniquedoneContactUsers->sortByDesc('created_at') as $doneContactUser)
                            <div class="user__box">
                                <a class="icon__name" href="{{ route('user-contents', ['id' => $doneContactUser->id]) }}">
                                    @if ($doneContactUser->user->icon)
                                        <img class="icon" src="{{ $doneContactUser->user->icon }}">
                                    @else
                                        <img class="icon" src="/img/icon_user_2.svg">
                                    @endif
                                    <div class="user__name">{{ $doneContactUser->user->name }}</div>
                                </a>
                            </div>
                        @endforeach
                    @endif
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
                    recommendItems.style.display = 'block';
                    mylistItems.style.display = 'none';

                    recommendTrigger.classList.add('active');
                    mylistTrigger.classList.remove('active');
                });

                mylistTrigger.addEventListener('click', function() {
                    recommendItems.style.display = 'none';
                    mylistItems.style.display = 'block';

                    mylistTrigger.classList.add('active');
                    recommendTrigger.classList.remove('active');
                });
            });
        </script>
    </div>
@endsection
