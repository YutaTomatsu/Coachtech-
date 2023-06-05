@extends('layouts.common')

@section('content')

    <head>
        <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    </head>
    <form class="form" method="POST" action="{{ route('update-profile') }}" enctype="multipart/form-data">
        @csrf
        <div class="title">プロフィール設定</div>
        <div class="top">
            <div class="user">
                <div class="icon">
                @if ($profile && $profile->icon)
                    <img id="preview" src="{{ $profile->icon }}" alt="プロフィール画像"
                        style="width: 100px; height: 100px; border-radius: 50%;">
                @else
                    <img id="preview" src="" alt="プロフィール画像"
                        style="width: 100px; height: 100px; border-radius: 50%;">
                @endif
                </div>
                <div class="edit">
                    <label for="icon" class="select-image">画像を選択する</label>
                    <input type="file" id="icon" name="icon" accept="image/*" style="display: none;" onchange="previewImage(this)">
                </div>
            </div>
        </div>
        <div class="item__box">
            <x-label class="item__name" for="name" :value="__('ユーザー名')" />
            <x-input class="text" id="name" type="text" name="name" :value="$user->name" required />
        </div>

        <div class="item__box">
            <x-label class="item__name" for="postcode" :value="__('郵便番号')" />
            <x-input class="text" id="postcode" type="postcode" name="postcode" :value="optional($profile)->postcode" required />
        </div>

        <div class="item__box">
            <x-label class="item__name" for="address" :value="__('住所')" />
            <x-input class="text" id="address" type="address" name="address" :value="optional($profile)->address" required />
        </div>

        <div class="item__box">
            <x-label class="item__name" for="build" :value="__('建物名')" />
            <x-input class="text" id="build" type="text" name="build" :value="optional($profile)->build" required />
        </div>
        <div class="under__box">
            <x-button class="button">
                {{ __('更新する') }}
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
