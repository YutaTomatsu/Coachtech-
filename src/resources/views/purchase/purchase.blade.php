@extends('layouts.common')

@section('content')

    <head>
        <link href="{{ asset('css/purchase.css') }}" rel="stylesheet">
        <script src="https://js.stripe.com/v3/"></script>
    </head>

    <div class="purchage">
        <div class="purchage__left">
            <div class="left__top">
                <img class="image" src="{{ $item->image }}">
                <div class="left__top__right">
                    <div class="name">{{ $item->item_name }}</div>
                    <div class="price">¥{{ $item->price }}</div>
                </div>
            </div>

            <div class="left__bottom">
                <div class="payment__box">
                    <div class="edit__name">支払い方法</div>
                    <select class="edit" id="payment-method" name="payment-method">
                        <option value="">変更する</option>
                        <option value="credit_card">クレジットカード</option>
                        <option value="convenience_store">コンビニ支払い</option>
                        <option value="bank_transfer">銀行振込</option>
                    </select>
                </div>
                <div class="edit__box">
                    <div class="edit__name">配送先</div>
                    <a class="edit" href="{{ route('show-change-address', ['id' => $item->id]) }}">変更する</a>
                </div>
                <div class="address__box">
                    @if ($addresses)
                        <div class="address">{{ $user->name }}</div>
                        <div class="address">{{ $addresses->postcode }}</div>
                        <div class="address">{{ $addresses->address }}</div>
                        <div class="address">{{ $addresses->build }}</div>
                    @else
                        <div class="address">配送先が指定されていません。プロフィールから住所を登録するか、「変更する」ボタンから配送先を指定してください。</div>
                    @endif
                </div>
                <x-auth-session-status class="status" :status="session('status')" />
                <x-auth-validation-errors class="error" :errors="$errors" />
            </div>
        </div>

        <div class="purchage__right">
            <div class="right__top">
                <div class="right__top__top">
                    <div class="item__name">商品代金</div>
                    <div class="item">¥{{ $item->price }}</div>
                </div>
                <div class="right__top__bottom">
                    <div class="right__top__bottom__item">
                        <div class="item__name">支払い金額</div>
                        <div class="item">¥{{ $item->price }}</div>
                    </div>
                    <div class="right__top__bottom__item">
                        <div class="item__name">支払い方法</div>
                        <div id="selected-payment-method" class="item"></div>
                    </div>
                </div>
            </div>
            <form class="purchage" action="{{ route('card', ['id' => $item->id]) }}" method="GET" id="payment-form">
                @if ($addresses !== null)
                    <input type="hidden" name="postcode" value="{{ $addresses->postcode }}">
                    <input type="hidden" name="address" value="{{ $addresses->address }}">
                    <input type="hidden" name="build" value="{{ $addresses->build }}">
                @else
                @endif
                <button class="purchage__button" type="submit">購入する</button>
            </form>
            <div id="error-message" class="error-message"></div>
        </div>
    </div>

    <script>
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            var paymentMethod = document.getElementById('payment-method').value;
            var itemPrice = {{ $item->price }};

            if (paymentMethod === '') {
                e.preventDefault();
                alert('支払い方法を選択して下さい');
            } else if (paymentMethod === 'convenience_store' && itemPrice >= 300000) {
                e.preventDefault();
                var errorMessage = document.getElementById('error-message');
                errorMessage.textContent = '300000円以上の商品を購入する場合は、クレジットカード払いか銀行振り込みを選択してください。';
            }
        });

        document.getElementById('payment-form').addEventListener('submit', function(event) {
            var addresses = {!! json_encode($addresses) !!};
            if (!addresses) {
                event.preventDefault();
                alert('配送先が指定されていません');
            }
        });

        document.getElementById('payment-method').addEventListener('change', function(e) {
            var paymentMethod = e.target.value;
            var selectedPaymentMethod = document.getElementById('selected-payment-method');
            var form = document.getElementById('payment-form');

            switch (paymentMethod) {
                case 'credit_card':
                    alert('クレジットカード決済が選択されました');
                    selectedPaymentMethod.textContent = 'クレジットカード';
                    form.action = "{{ route('card', ['id' => $item->id]) }}";
                    break;
                case 'convenience_store':
                    alert('コンビニ決済が選択されました');
                    selectedPaymentMethod.textContent = 'コンビニ支払い';
                    form.action = "{{ route('convenience', ['id' => $item->id]) }}";
                    break;
                case 'bank_transfer':
                    alert('銀行振り込みが選択されました');
                    selectedPaymentMethod.textContent = '銀行振込';
                    form.action = "{{ route('bank', ['id' => $item->id]) }}";
                    break;
                default:
                    selectedPaymentMethod.textContent = '変更する';
                    break;
            }
        });
    </script>
@endsection
