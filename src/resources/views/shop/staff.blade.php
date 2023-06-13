@extends('layouts.shop_header')

<head>
    <link href="{{ asset('css/staff.css') }}" rel="stylesheet">
</head>

@section('content')
    <div class="myshop__box">
        <div class="staff">
            <h2 class="title">スタッフ一覧</h2>
            <a class="add__staff" href="{{ route('show-create-staff', ['id' => $shop->id]) }}">スタッフを追加する</a>
        </div>

        @if($staffs->count() === 0)
        <div class="staff__none">まだスタッフがいません</div>
        @else
        <div class="shop__detail">
            @foreach ($staffs as $staff)
                <div class="staff__box">
                    <div class="staff__name">{{ $staff->name }}</div>
                    <div class="staff__email">{{ $staff->email }}</div>
                </div>
            @endforeach
        </div>
        @endif
    @endsection
