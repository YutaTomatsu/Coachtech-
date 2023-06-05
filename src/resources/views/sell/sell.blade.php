@extends('layouts.no_item')

<head>
    <link href="{{ asset('css/sell.css') }}" rel="stylesheet">
</head>

@section('content')
    <form class="form" method="POST" action="{{ route('sell') }}" enctype="multipart/form-data">
        @csrf
        <div class="title">商品の出品</div>
        <div class="item__box">
            <x-label class="item__name" for="category" :value="__('商品画像')" />
            <div class="top">
                <div class="icon">
                    <label for="image">画像を選択する</label>
                    <input type="file" id="image" name="image" accept="image/*" style="display:none">
                </div>
            </div>
        </div>

        <div class="class">商品の詳細</div>
        <div class="item__box">
            <x-label class="item__name" for="category1" :value="__('カテゴリー1')" />

            <select class="text" id="category1" name="category[]" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
            </select>

            <x-label class="item__name" for="category2" :value="__('カテゴリー2')" />

            <select class="text" id="category2" name="category[]" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
            </select>

            <x-label class="item__name" for="category3" :value="__('カテゴリー3')" />

            <select class="text" id="category3" name="category[]" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
            </select>


            <div class="item__box">
                <x-label class="item__name" for="condition" :value="__('商品の状態')" />

                <select class="text" id="condition" name="condition" required>
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition->condition }}">{{ $condition->condition }}</option>
                    @endforeach
                </select>
            </div>

            <div class="class">商品名と説明</div>
            <div class="item__box">
                <x-label class="item__name" for="item_name" :value="__('商品名')" />

                <x-input class="text" id="item_name" type="text" name="item_name" :value="old('item_name')" required />
            </div>

            <div class="item__box">
                <x-label class="item__name" for="about" :value="__('商品の説明')" />

                <textarea class="textarea" id="about" type="text" name="about" :value="old('about')" required> </textarea>
            </div>

            <div class="class">販売価格</div>
            <div class="item__box">
                <x-label class="item__name" for="price" :value="__('販売価格')" />

                <x-input class="text" id="price" type="text" name="price" :value="old('price')" required />
            </div>
            <div class="under__box">
                <x-button class="button">
                    {{ __('出品する') }}
                </x-button>
            </div>

            <x-auth-session-status class="status" :status="session('status')" />
            <x-auth-validation-errors class="error" :errors="$errors" />
    </form>

                <script>
                var categories = [document.getElementById('category1'), document.getElementById('category2'), document
                    .getElementById('category3')
                ];

                function updateCategories() {
                    var selected = [];
                    categories.forEach(function(category) {
                        if (category.value) selected.push(category.value);
                    });

                    categories.forEach(function(category) {
                        var options = category.querySelectorAll('option');
                        options.forEach(function(option) {
                            if (selected.includes(option.value) && option.value != category.value) {
                                option.setAttribute('disabled', 'disabled');
                            } else {
                                option.removeAttribute('disabled');
                            }
                        });
                    });
                }

                categories.forEach(function(category) {
                    category.addEventListener('change', updateCategories);
                });

                window.addEventListener('DOMContentLoaded', updateCategories);
            </script>
@endsection
