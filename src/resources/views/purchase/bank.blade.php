

<!DOCTYPE html>
<html>
<head>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <form id="payment-form">
      <div id="payment-element">
      </div>
      <button id="submit">Submit</button>
      <div id="error-message">
    </form>

    <script>
        const stripe = Stripe('{{ env("STRIPE_PUBLIC_KEY") }}');

        const options = {
          clientSecret: '{{ $client_secret }}',
          appearance: {/*...*/},
        };

        const elements = stripe.elements(options);

        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');

        const form = document.getElementById('payment-form');

form.addEventListener('submit', async (event) => {
  event.preventDefault();

  const {error} = await stripe.confirmPayment({
    elements,
    confirmParams: {
      return_url: 'https://example.com/order/123/complete',
    },
  });

  if (error) {
    const messageContainer = document.querySelector('#error-message');
    messageContainer.textContent = error.message;
  } else {
  }
});

const clientSecret = new URLSearchParams(window.location.search).get(
  'payment_intent_client_secret'
);

stripe.retrievePaymentIntent(clientSecret).then(({paymentIntent}) => {
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
