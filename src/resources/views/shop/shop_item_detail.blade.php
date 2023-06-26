@extends('layouts.shop_header')

@section('content')

    <head>
        <link href="{{ asset('css/shop_item_detail.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <div class="detail">
        <div class="detail__left">
            <div class="left__box">
                <img class="image" src="{{ $item->image }}">
            </div>
        </div>
        <div class="detail__right">
            <div class="center">
                @if(!$purchasedItem)
                <div class="delete__box">
                    @if(!$userStaff)
                    <form action="{{ route('shop-item-destroy', $item) }}" method="POST" class="item__delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete">削除する</button>
                    </form>
                    @endif
                </div>
                @endif
                <div class="item__name">{{ $item->item_name }}</div>
                <div class="price">¥{{ $item->price }}（値段）</div>
                <div class="mylist__comment">
                    <div class="mylist__box">
                        <div class="mylist">
                            <img class="toggle_img" src="{{ asset('img/delete_mylist.svg') }}" alt="mylist">
                        </div>
                        <div class="mylist__count">
                            @php
                                $mylistCount = \App\Models\Mylist::where('item_id', $item->id)->count();
                                echo $mylistCount;
                            @endphp
                        </div>
                    </div>
                </div>
                <div class="about__box">
                    <div class="about__title">商品説明</div>
                    <div class="about">{{ $item->about }}</div>
                </div>
                <div class="information__box">
                    <div class="information__title">商品の情報</div>
                    <div class="category__box">
                        <div class="category__title">カテゴリー</div>
                        <div class="category__item__box">
                            @foreach ($categories as $category)
                                <div class="category">{{ $category->category }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="condition__box">
                        <div class="condition__title">商品の状態</div>
                        <div class="condition">{{ $item->condition }}</div>
                    </div>
                </div>
            </div>

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
                        const deleteForms = document.querySelectorAll('.item__delete');
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
            <script>
                $(document).on('click', '.toggle_img', function(e) {
                    e.preventDefault();
                    var item_id = $(this).data('itemid');
                    var user_id = $(this).data('userid');
                    var $img = $(this);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    $.ajax({
                        url: "{{ route('mylist.toggle') }}",
                        method: "POST",
                        data: {
                            item_id: item_id,
                            user_id: user_id
                        },
                    }).done(function(data) {
                        if (data.status == 'success') {
                            if ($img.attr('src').includes('add_mylist.svg')) {
                                $img.attr('src', '{{ asset('img/delete_mylist.svg') }}');
                            } else {
                                $img.attr('src', '{{ asset('img/add_mylist.svg') }}');
                            }
                            $img.closest('.mylist__box').find('.mylist__count').text(data.newCount);
                            console.log(data.message);
                        }
                    }).fail(function() {
                        console.log('Error: the request was not sent!!!.');
                    });
                });
            </script>
        @endsection
