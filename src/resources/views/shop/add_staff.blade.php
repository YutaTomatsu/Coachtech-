@extends('layouts.shop_header')

<head>
    <link href="{{ asset('css/add_staff.css') }}" rel="stylesheet">
</head>

@section('content')
    <form class="form" method="POST" action="/user-emails">
        @csrf
        <div class="item__box">
            <label class="item__name" for="name">スタッフ名</label>
            <input class="text" id="name" type="name" name="name" required>
        </div>
        <div class="item__box">
            <label class="item__name" for="email">メールアドレス</label>
            <input class="text" id="email" type="email" name="email" required>
        </div>
        <div class="item__box">
            <label class="item__name" for="password">パスワード</label>
            <input class="text" id="password" type="password" name="password" required>
        </div>
        <div class="items__box">
            <button class="button" type="submit">スタッフを作成する</button>
        </div>
        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>

@endsection
