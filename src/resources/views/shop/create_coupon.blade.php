@extends('layouts.shop_header')

<head>
    <link href="{{ asset('css/add_staff.css') }}" rel="stylesheet">
</head>

@section('content')
    <form class="form" action="{{ route('create-coupon', ['id' =>$shop->id]) }}" method="POST" id="coupon-form">
    @csrf
    <div class="item__box">
        <label class="item__name" for="coupon_name">クーポン名</label>
        <input class="text" type="text" name="coupon_name" required>
    </div>
    <div class="item__box">
        <label class="item__name" for="discount_type">割引タイプ</label>
        <select class="text" name="discount_type" id="discount-type">
            <option value="percentage">割引率(〇〇%OFF)</option>
            <option value="fixed_amount">割引額(〇〇円割引)</option>
        </select>
    </div>
    <div class="item__box">
        <label class="item__name" for="discount_value">割引料</label>
        <input class="text" type="number" name="discount_value" id="discount-value" required>
    </div>
    <div class="items__box">
        <button class="button" type="submit">クーポンを作成する</button>
    </div>

    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif
</form>

<script>
    window.onload = function() {
        const discountTypeSelect = document.querySelector('select[name="discount_type"]');
        const discountValueInput = document.querySelector('input[name="discount_value"]');

        discountTypeSelect.addEventListener('change', function() {
            switch (this.value) {
                case 'percentage':
                    discountValueInput.placeholder = "例: 20 (% OFF)";
                    break;
                case 'fixed_amount':
                    discountValueInput.placeholder = "例: 1000 (¥ 割引)";
                    break;
                default:
                    discountValueInput.placeholder = '';
            }
        });
    };
</script>
<script>
    window.onload = function() {
        const couponForm = document.querySelector('#coupon-form');
        const discountTypeSelect = document.querySelector('#discount-type');
        const discountValueInput = document.querySelector('#discount-value');
        let errorMsg;

        // エラーメッセージを表示する要素を作成
        errorMsg = document.createElement("p");
        errorMsg.style.color = "red";
        errorMsg.id = "error-msg";
        discountValueInput.parentNode.appendChild(errorMsg);

        // 割引タイプの選択肢が変更されたときにエラーメッセージをクリア
        discountTypeSelect.addEventListener('change', function() {
            errorMsg.textContent = "";
        });

        // 割引料の入力値が変更されたときに範囲チェックを実行
        discountValueInput.addEventListener('input', function() {
            if(discountTypeSelect.value === 'percentage') {
                if(this.value < 5 || this.value > 90) {
                    errorMsg.textContent = "割引率は5%から90%の間で選択してください";
                } else {
                    errorMsg.textContent = "";
                }
            }
        });

        // フォームの送信をハンドリング
        couponForm.addEventListener('submit', function(e) {
            if(discountTypeSelect.value === 'percentage' && (discountValueInput.value < 5 || discountValueInput.value > 90)) {
                e.preventDefault();
                alert("割引率は5%から90%の間で選択してください");
            }
        });
    };
</script>



@endsection
