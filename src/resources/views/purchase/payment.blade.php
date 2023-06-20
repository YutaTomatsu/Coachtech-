<!DOCTYPE html>
<html>

<head>
    <script src="https://js.stripe.com/v3/"></script>
    <link href="{{ asset('css/payment.css') }}" rel="stylesheet">
</head>

<body>
    <form id="payment-form" method="POST" action="{{ route('payment-success', ['id' => $items->id]) }}">
        @csrf
        <input type="hidden" name="postcode" value="{{ $addresses->postcode }}">
        <input type="hidden" name="address" value="{{ $addresses->address }}">
        <input type="hidden" name="build" value="{{ $addresses->build }}">
        <div class="payment__box">
            <div class="item__title">支払い方法</div>
            <div id="payment-element"></div>
        </div>
        <div class="amount__box">
            <div class="amount__title">支払い金額</div>
            <div class="amount">{{ $paymentIntent->amount }}¥</div>
        </div>

        <div class="address__box">
            <div class="item__title">配送先</div>
            <div class="addresses">
                <div class="address">{{ $user->name }}</div>
                <div class="address">{{ $addresses->postcode }}</div>
                <div class="address">{{ $addresses->address }}</div>
                <div class="address">{{ $addresses->build }}</div>
            </div>
        </div>
        <div class="button">
            <button id="submit">購入する</button>
        </div>
        <div id="error-message">
    </form>
    @if (session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif
    <x-auth-session-status class="status" :status="session('status')" />
    <x-auth-validation-errors class="error" :errors="$errors" />

    <script>
        const stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY') }}');
        const options = {
            clientSecret: '{{ $client_secret }}',
            appearance: {
                /*...*/
            },
        };
        const elements = stripe.elements(options);
        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');
        const form = document.getElementById('payment-form');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const {
                error
            } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: "{{ route('payment-success', ['id' => $items->id]) }}",
                },
            });

            if (error) {
                const messageContainer = document.querySelector('#error-message');
                messageContainer.textContent = error.message;
            } else {
                form.submit();
            }
        });

        const clientSecret = new URLSearchParams(window.location.search).get(
            'payment_intent_client_secret'
        );

        stripe.retrievePaymentIntent(clientSecret).then(({
            paymentIntent
        }) => {
            const message = document.querySelector('#message')

            switch (paymentIntent.status) {
                case 'succeeded':
                    message.innerText = 'Success! Payment received.';
                    break;

                case 'processing':
                    message.innerText = "Payment processing. We'll update you when payment is received.";
                    break;

                case 'requires_payment_method':
                    message.innerText = 'Payment failed. Please try another payment method.';
                    break;

                default:
                    message.innerText = 'Something went wrong.';
                    break;
            }
        });
    </script>
</body>

</html>
