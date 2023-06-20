@extends('layouts.shop_header')

@section('content')

    <head>
        <link href="{{ asset('css/comment.css') }}" rel="stylesheet">
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
                        <a class="comment" href="{{ route('comment', ['id' => $item->id]) }}">
                            <img src="/img/comment.svg" alt="comment">
                        </a>
                        <div class="comment__count">
                            @php
                                $commentCount = count($comments);
                                echo $commentCount;
                            @endphp
                        </div>
                    </div>
                </div>

                <div class="comments__box">
                    @foreach ($comments as $comment)
                        <div class="comments {{ $comment->is_seller ? 'seller-comment' : 'buyer-comment' }}">
                            <div class="comment__user">
                                <img class="icon" src="{{ asset($comment->user_icon) }}" alt="User Icon">
                                <span class="comment__username">{{ $comment->user_name }}</span>
                            </div>
                            <div class="comment__content">
                                {{ $comment->comment }}
                                @if ($item->user_id === Auth::id())
                                    <form action="{{ route('comment-delete', ['id' => $comment->id]) }}" method="POST">
                                        @csrf
                                        <a onclick="return confirm('本当にコメントを削除しますか？')" type="submit" class="btn btn-danger">
                                            <img class="comment__delete" src="/img/delete.svg" alt="delete">
                                        </a>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>


                @if (in_array($item->id, $purchasedItemId))
                    <div class="sold" type="submit">売り切れのためコメントできません</div>
                @else
                    <form class="comment__form" action="{{ route('comment', ['id' => $item->id]) }}" method="POST">
                        @csrf
                        <div class="comment__box">
                            <label class="comment__title" for="comment">商品へのコメント</label>
                            <textarea class="comment__text" name="comment"></textarea>
                        </div>
                        <button class="comment__button" type="submit">コメントを送信する</button>
                    </form>
                @endif
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
            <script>
                $(document).ready(function() {
                    $('.detail__right').css('overflow-y', 'scroll');
                    $('.detail__right').css('max-height', '700px');
                });
            </script>

        @endsection
