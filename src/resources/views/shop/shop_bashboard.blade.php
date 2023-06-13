@extends('layouts.shop_header')

<head>
    <link href="{{ asset('css/shop_dashboard.css') }}" rel="stylesheet">
</head>

@section('content')
<div class="myshop__box">
    <h2 class="title">マイショップ</h2>
    <div class="shop__detail">
        <div class="icon__name">
            <img class="shop__icon" src="{{$shop->shop_icon}}">
            <div class="shop__name">{{$shop->shop_name}}</div>
        </div>
        <div class="about__box">
            <div class="about__title">ショップ説明</div>
            <div class="about">{{$shop->about}}</div>
        </div>
    </div>

<div class="items__box">
    <h2 class="title">出品履歴</h2>
</div>
    @endsection