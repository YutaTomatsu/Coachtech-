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
                    @if ($coupons)
                        <div class="right__top__bottom__item">
                            <div class="item__name">使用するクーポン</div>
                            <select id="coupon-select">
                                <option>使用しない</option>
                                @foreach ($coupons as $coupon)
                                    <option data-discount-type="{{ $coupon->discount_type }}"
                                        data-discount-value="{{ $coupon->discount_value }}">{{ $coupon->coupon_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="right__top__bottom__item">
                        <div class="item__name">支払い金額</div>
                        <div id="total-price" class="item">¥{{ $item->price }}</div>
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
                    <input type="hidden" name="price" value="{{ $item->price }}">
                @else
                @endif
                <button class="purchage__button" type="submit">購入する</button>
            </form>
            <div id="error-message" class="error-message"></div>
        </div>
    </div>

    <div id="dialog-overlay" class="overlay"></div>

    <!-- ダイアログボックス -->
    <div id="dialog-box" class="dialog-box">
        <p id="dialog-message"></p>
        <div class="btn-wrapper">
            <button id="dialog-ok" class="ok">OK</button>
        </div>
    </div>

    <script>
            document.getElementById('payment-form').addEventListener('submit', function(e) {
        var paymentMethod = document.getElementById('payment-method').value;
        var itemPrice = {{ $item->price }};
        var dialogBox = document.getElementById('dialog-box');
        var dialogMessage = document.getElementById('dialog-message');
        var dialogOverlay = document.getElementById('dialog-overlay');
        var dialogOkButton = document.getElementById('dialog-ok');

        if (paymentMethod === '') {
            e.preventDefault();
            dialogMessage.textContent = '支払い方法を選択して下さい';

            dialogBox.style.opacity = 1;
            dialogBox.style.visibility = 'visible';
            dialogOverlay.style.opacity = 1;
            dialogOverlay.style.visibility = 'visible';

            dialogOkButton.addEventListener('click', function() {
                dialogBox.style.opacity = 0;
                dialogBox.style.visibility = 'hidden';
                dialogOverlay.style.opacity = 0;
                dialogOverlay.style.visibility = 'hidden';
            });

        } else if (paymentMethod === 'convenience_store' && itemPrice >= 300000) {
            e.preventDefault();
            var errorMessage = document.getElementById('error-message');
            errorMessage.textContent = '300000円以上の商品を購入する場合は、クレジットカード払いか銀行振り込みを選択してください。';
        }
    });

    document.getElementById('payment-form').addEventListener('submit', function(event) {
        var addresses = {!! json_encode($addresses) !!};
        var dialogBox = document.getElementById('dialog-box');
        var dialogMessage = document.getElementById('dialog-message');
        var dialogOverlay = document.getElementById('dialog-overlay');
        var dialogOkButton = document.getElementById('dialog-ok');

        if (!addresses) {
            event.preventDefault();
            dialogMessage.textContent = '配送先が指定されていません';

            dialogBox.style.opacity = 1;
            dialogBox.style.visibility = 'visible';
            dialogOverlay.style.opacity = 1;
            dialogOverlay.style.visibility = 'visible';

            dialogOkButton.addEventListener('click', function() {
                dialogBox.style.opacity = 0;
                dialogBox.style.visibility = 'hidden';
                dialogOverlay.style.opacity = 0;
                dialogOverlay.style.visibility = 'hidden';
            });
        }
    });
        document.getElementById('payment-method').addEventListener('change', function(e) {
            var paymentMethod = e.target.value;
            var selectedPaymentMethod = document.getElementById('selected-payment-method');
            var form = document.getElementById('payment-form');
            var dialogBox = document.getElementById('dialog-box');
            var dialogMessage = document.getElementById('dialog-message');
            var dialogOverlay = document.getElementById('dialog-overlay');
            var dialogOkButton = document.getElementById('dialog-ok');

            switch (paymentMethod) {
                case 'credit_card':
                    dialogMessage.textContent = 'クレジットカード決済が選択されました';
                    selectedPaymentMethod.textContent = 'クレジットカード';
                    form.action = "{{ route('card', ['id' => $item->id]) }}";
                    break;
                case 'convenience_store':
                    dialogMessage.textContent = 'コンビニ決済が選択されました';
                    selectedPaymentMethod.textContent = 'コンビニ支払い';
                    form.action = "{{ route('convenience', ['id' => $item->id]) }}";
                    break;
                case 'bank_transfer':
                    dialogMessage.textContent = '銀行振り込みが選択されました';
                    selectedPaymentMethod.textContent = '銀行振込';
                    form.action = "{{ route('bank', ['id' => $item->id]) }}";
                    break;
                default:
                    selectedPaymentMethod.textContent = '変更する';
                    break;
            }

            // ダイアログを表示
            dialogBox.style.opacity = 1;
            dialogBox.style.visibility = 'visible';
            dialogOverlay.style.opacity = 1;
            dialogOverlay.style.visibility = 'visible';

            // OKボタンがクリックされた時の挙動
            dialogOkButton.addEventListener('click', function() {
                // ダイアログを非表示にする
                dialogBox.style.opacity = 0;
                dialogBox.style.visibility = 'hidden';
                dialogOverlay.style.opacity = 0;
                dialogOverlay.style.visibility = 'hidden';
            });
        });
    </script>
    <script>
        let finalPrice = {{ $item->price }};
        const itemPrice = {{ $item->price }};
        const couponSelect = document.getElementById('coupon-select');
        const totalPriceElement = document.getElementById('total-price');

        couponSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const discountType = selectedOption.getAttribute('data-discount-type');
            const discountValue = parseInt(selectedOption.getAttribute('data-discount-value'), 10);

            if (discountType === 'percentage') {
                finalPrice = itemPrice - ((itemPrice * discountValue) / 100);
            } else if (discountType === 'fixed_amount') {
                finalPrice = itemPrice - discountValue;
            } else {
                finalPrice = itemPrice;
            }

            totalPriceElement.textContent = `¥${finalPrice}`;
        });

        document.getElementById('payment-form').addEventListener('submit', function(e) {
            const priceField = this.elements['price'];
            if (priceField) {
                priceField.value = finalPrice;
            }
        });
    </script>


@endsection
