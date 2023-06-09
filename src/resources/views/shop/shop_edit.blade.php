@extends('layouts.shop_header')

@section('content')

<head>
    <link href="{{ asset('css/create_shop.css') }}" rel="stylesheet">
</head>
<form class="form" method="POST" action="{{ route('shop-edit', ['id' => $shop->id]) }}" enctype="multipart/form-data">
    @csrf
    <div class="title">ショップ情報の編集</div>
    <div class="top">
        <div class="user">
            <div class="icon">
                <img class="shop__icon" id="preview" src="{{ $shop->shop_icon }}" alt="プロフィール画像">
            </div>
            <div class="edit">
                <label for="shop_icon" class="select-image">画像を選択する</label>
                <input type="file" id="shop_icon" name="shop_icon" accept="image/*" style="display: none;" onchange="previewImage(this)">
            </div>
        </div>
    </div>
    <div class="item__box">
        <x-label class="item__name" for="shop_name" :value="__('ショップ名')" />
        <x-input class="text" id="shop_name" type="text" name="shop_name" :value="optional($shop)->shop_name" required />
    </div>
    <div class="item__box">
        <x-label class="item__name" for="name" :value="__('ショップ説明')" />
        <textarea class="text" id="about" type="text" name="about" required>{{ $shop->about }}</textarea>
    </div>
    <div class="under__box">
        <x-button class="button">
            {{ __('ショップを作成する') }}
        </x-button>
    </div>
    <x-auth-session-status class="status" :status="session('status')" />
    <x-auth-validation-errors class="error" :errors="$errors" />
</form>
<script>
    function previewImage(input) {
        var preview = document.getElementById('preview');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
</script>
@endsection