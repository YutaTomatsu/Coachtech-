@extends('layouts.common')

@section('content')

    <head>
        <link href="{{ asset('css/detail.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <div class="detail">
        <div class="detail__left">
            <img class="image" src="{{ $item->image }}">
        </div>
        <div class="detail__right">
            <div class="center">
                <div class="item__name">{{ $item->item_name }}</div>
                <div class="price">¥{{ $item->price }}（値段）</div>
                <div class="mylist__comment">
                    <div class="mylist__box">
                        @if (Auth::check())
                            @if (in_array($item->id, $mylist_items))
                                <div class="mylist">
                                    <img class="toggle_img" src="{{ asset('img/delete_mylist.svg') }}" alt="mylist"
                                        data-itemid="{{ $item->id }}" data-userid="{{ Auth::id() }}">
                                </div>
                            @else
                                <div class="mylist">
                                    <img class="toggle_img" src="{{ asset('img/add_mylist.svg') }}" alt="mylist"
                                        data-itemid="{{ $item->id }}" data-userid="{{ Auth::id() }}">
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}">
                                <div class="mylist">
                                    <img src="{{ asset('img/add_mylist.svg') }}" alt="mylist">
                                </div>
                            </a>
                        @endif
                        <div class="mylist__count">
                            @php
                                $mylistCount = \App\Models\Mylist::where('item_id', $item->id)->count();
                                echo $mylistCount;
                            @endphp
                        </div>
                    </div>
                    <div class="comment__box">
                        <a href="{{ route('show-comment', ['id' => $item->id]) }}">
                            <img class="comment" src="/img/comment.svg" alt="comment">
                        </a>
                        <div class="comment__count">
                            @php
                                $commentCount = count($comments);
                                echo $commentCount;
                            @endphp
                        </div>
                    </div>
                </div>
                @if ($item->user_id === Auth::id())
                @else
                    @if (in_array($item->id, $purchasedItemId))
                    @else
                        <a class="purchage" href="{{ route('show-purchage', ['id' => $item->id]) }}">
                            <button class="purchage__button" type="submit">購入する</button>
                        </a>
                    @endif
                @endif
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
