<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/review_form.css') }}">
    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>

@extends('layouts.common')

@section('content')

    <div class="detail">
        <div class="detail__left">
            <div class="left__box">
                <div class="seller__box">
                    <a class="icon__link" href="{{ route('show-seller', ['id' => $item->id]) }}">
                        <img class="seller__icon" src="{{ $seller->icon }}" alt="icon">
                    </a>
                    <div class="seller__right">
                        <div class="seller__name">{{ $seller->name }}</div>
                        <div class="review">
                        </div>
                    </div>
                </div>
                <img class="image" src="{{ $item->image }}">
            </div>
        </div>
        <div class="detail__right">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="review__box">
                            <div class="review__title">{{ __('レビューを書く') }}</div>
                            <div class="review__body">
                                <form class="review__form" method="POST"
                                    action="{{ route('review', ['id' => $item->id]) }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="rating"
                                            class="col-md-4 col-form-label text-md-right">{{ __(' 5段階評価') }}</label>
                                        <input type="hidden" name="" value="">
                                        <div class="rate-form">
                                            <input id="star5" type="radio" name="rating" value="5">
                                            <label for="star5">★</label>
                                            <input id="star4" type="radio" name="rating" value="4">
                                            <label for="star4">★</label>
                                            <input id="star3" type="radio" name="rating" value="3">
                                            <label for="star3">★</label>
                                            <input id="star2" type="radio" name="rating" value="2">
                                            <label for="star2">★</label>
                                            <input id="star1" type="radio" name="rating" value="1">
                                            <label for="star1">★</label>
                                            @error('rating')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="comment__group">
                                        <label for="comment"
                                            class="col-md-4 col-form-label text-md-right">{{ __('コメント') }}</label>
                                        <div class="col-md-6">
                                            <textarea class="comment__text" name="comment" id="comment" class="form-control">{{ old('comment') }}</textarea>

                                            @error('comment')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="button__group">
                                            <button class="review-button" type="submit">
                                                {{ __('送信する') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success mt-3">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
