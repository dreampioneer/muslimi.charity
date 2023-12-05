@extends('layouts.layouts')

@section('content')
    <section>
        <div class="container">
            <form id="payment-form">
                <div id="card-element">
                </div>
                <button id="submit">Submit</button>
                <div id="error-message">
                    <!-- Display error message to your customers here -->
                </div>
                <div class="test">

                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/vendor/jquery.mask.min.js') }}"></script>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        const stripe = Stripe('{{ env("STRIPE_KEY") }}');

        const options = {
            appearance: {},
        };

        // Set up Stripe.js and Elements to use in checkout form, passing the client secret obtained in a previous step
        const elements = stripe.elements(options);

        // Create and mount the Payment Element
        const card  = elements.create('card');
        card.mount('#card-element');

        const form = document.getElementById('payment-form');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const {token, error} = await stripe.createToken(card);

            const response = await fetch('create-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({card_token: token.id}),
            });

            const data = await response.json();

            var msg = '';
            if(data.status === 'requires_action'){
                var iframe = document.createElement('iframe');
                iframe.src = data.next_action.redirect_to_url.url;;
                iframe.width = 600;
                iframe.height = 400;
                $('.test').append(iframe);
            }else if(data.status === 'succeeded'){
                msg = "Payment succeeded!";
            }else if(data.status === 'processing'){
                msg = "Your payment is processing.";
            }else if(data.status === 'requires_payment_method'){
                msg = "Your payment was not successful, please try again.";
            }else{
                msg = "Something went wrong.";
            }
        });


        async function on3DSComplete(client_secret) {
            // Hide the 3DS UI
            $('.test').remove();
            console.log("on3DSComplete");
            console.log(client_secret);

            const { paymentIntent } = await stripe.retrievePaymentIntent(client_secret);

            console.log(paymentIntent);

            switch (paymentIntent.status) {
                case "succeeded":
                    alert("Payment succeeded!");
                break;
                case "processing":
                    alert("Your payment is processing.");
                break;
                case "requires_payment_method":
                    alert("Your payment was not successful, please try again.");
                break;
                case "requires_confirmation":
                    const response = await fetch('confirm-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({paymentIntentId: paymentIntent.id}),
                    });
                    const data = await response.json();
                    console.log("here");
                    console.log(data);
                    if(data.status === "succeeded"){
                        alert("Payment succeeded!");
                    }else{
                        alert("Something went wrong.");
                    }
                break;
                default:
                    alert("Something went wrong.");
                break;
            }
        }

        window.addEventListener('message', function(ev) {
            if (typeof ev.data.status !== 'undefined' && ev.data.status === '3DS-authentication-complete') {
                on3DSComplete(ev.data.clientSecret);
            }
        }, false);
    </script>

@endsection
