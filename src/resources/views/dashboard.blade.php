@extends('layouts.common')

<head>
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
@section('content')
    <div class="list">
        <button class="change__button active" id="recommendTrigger">おすすめ</button>
        <button class="change__button" id="mylistTrigger">マイリスト</button>
    </div>

    <div class="main">
        <label>
            <input type="checkbox" id="onlyAvailableCheckbox">
            出品中のみ表示
        </label>
        <div class="recommend">
            <div class="item__box" id="recommendItems">
                @foreach ($items as $item)
                    <a class="item" href="{{ route('detail', ['id' => $item->id]) }}" data-item-id="{{ $item->id }}"
                        data-purchased="{{ in_array($item->id, $purchasedItemIds) ? 'true' : 'false' }}">
                        @if (in_array($item->id, $purchasedItemIds))
                            <div class="image-container">
                                <img class="image" src="{{ $item->image }}" alt="Item Image">
                                <span class="sold-label">
                                    <div class="sold">sold</div>
                                </span>
                            </div>
                        @else
                            <img class="image" src="{{ $item->image }}" alt="Item Image">
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mylist">
            <div class="item__box" id="mylistItems" style="display: none;">
                @foreach ($mylists as $mylist)
                    <a class="item" href="{{ route('detail', ['id' => $mylist->item_id]) }}">
                        @if (in_array($mylist->item_id, $purchasedItemIds))
                            <div class="image-container">
                                <img class="image" src="{{ $mylist->image }}" alt="Item Image">
                                <span class="sold-label">
                                    <div class="sold">sold</div>
                                </span>
                            </div>
                        @else
                            <img class="image" src="{{ $mylist->image }}" alt="Item Image">
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var recommendTrigger = document.getElementById('recommendTrigger');
            var recommendItems = document.getElementById('recommendItems');
            var mylistTrigger = document.getElementById('mylistTrigger');
            var mylistItems = document.getElementById('mylistItems');
            var onlyAvailableCheckbox = document.getElementById('onlyAvailableCheckbox');

            recommendTrigger.addEventListener('click', function() {
                recommendItems.style.display = 'flex';
                mylistItems.style.display = 'none';
                updateItemVisibility();
                recommendTrigger.classList.add('active');
                mylistTrigger.classList.remove('active');
            });

            mylistTrigger.addEventListener('click', function() {
                recommendItems.style.display = 'none';
                mylistItems.style.display = 'flex';
                updateItemVisibility();
                mylistTrigger.classList.add('active');
                recommendTrigger.classList.remove('active');
            });

            onlyAvailableCheckbox.addEventListener('change', function() {
                updateItemVisibility();
            });

            function updateItemVisibility() {
                var items = document.querySelectorAll('.item');

                items.forEach(function(item) {
                    var itemId = item.getAttribute('data-item-id');
                    var purchased = item.getAttribute('data-purchased');

                    if (onlyAvailableCheckbox.checked && purchased === 'true') {
                        item.style.display = 'none';
                    } else {
                        item.style.display = 'flex';
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var recommendTrigger = document.getElementById('recommendTrigger');
            var recommendItems = document.getElementById('recommendItems');
            var mylistTrigger = document.getElementById('mylistTrigger');
            var mylistItems = document.getElementById('mylistItems');

            recommendTrigger.addEventListener('click', function() {
                recommendItems.style.display = 'flex';
                mylistItems.style.display = 'none';

                recommendTrigger.classList.add('active');
                mylistTrigger.classList.remove('active');
            });

            mylistTrigger.addEventListener('click', function() {
                recommendItems.style.display = 'none';
                mylistItems.style.display = 'flex';

                mylistTrigger.classList.add('active');
                recommendTrigger.classList.remove('active');
            });
        });
    </script>
@endsection
