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
                <div class="img__box">
                    <img class="item__img" id="imagePreview" src="{{ old('image') ? asset(old('image')) : '#' }}"
                        alt="選択した画像" style="{{ old('image') ? 'display:block' : 'display:none' }}">
                    <div class="icon">
                        <label for="image">画像を選択する</label>
                        <input type="file" id="image" name="image" accept="image/*" style="display:none"
                            onchange="previewImage(event)">
                    </div>
                </div>
            </div>
        </div>

        <div class="class">商品の詳細</div>
        <div class="item__box">
            <x-label class="item__name" for="category1" :value="__('カテゴリー1')" />
            <select class="text" id="category1" name="category[]">
                <option value="">選択する</option>
                @foreach ($categories as $key => $category)
                    <option value="{{ $category->category }}"
                        {{ old('category.0') == $category->category ? 'selected' : '' }}>{{ $category->category }}</option>
                @endforeach
            </select>
            <x-label class="item__name" for="category2" :value="__('カテゴリー2')" />
            <select class="text" id="category2" name="category[]">
                <option value="">選択する</option>
                @foreach ($categories as $key => $category)
                    <option value="{{ $category->category }}"
                        {{ old('category.1') == $category->category ? 'selected' : '' }}>{{ $category->category }}</option>
                @endforeach
            </select>
            <x-label class="item__name" for="category3" :value="__('カテゴリー3')" />
            <select class="text" id="category3" name="category[]">
                <option value="">選択する</option>
                @foreach ($categories as $key => $category)
                    <option value="{{ $category->category }}"
                        {{ old('category.2') == $category->category ? 'selected' : '' }}>{{ $category->category }}
                    </option>
                @endforeach
            </select>
            <div class="item__box">
                <x-label class="item__name" for="condition" :value="__('商品の状態')" />
                <select class="text" id="condition" name="condition" required>
                    <option value="">選択する</option>
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition->condition }}"
                            {{ old('condition') == $condition->condition ? 'selected' : '' }}>{{ $condition->condition }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="class">商品名と説明</div>
        <div class="item__box">
            <x-label class="item__name" for="item_name" :value="__('商品名')" />

            <x-input class="text" id="item_name" type="text" name="item_name" :value="old('item_name')" required />
        </div>

        <div class="item__box">
            <x-label class="item__name" for="about" :value="__('商品の説明')" />

            <textarea class="textarea" id="about" type="text" name="about" required>{{ old('about') }}</textarea>
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

        <x-auth-validation-errors class="error" :errors="$errors" />
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </form>
    <script>
        function previewImage(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
