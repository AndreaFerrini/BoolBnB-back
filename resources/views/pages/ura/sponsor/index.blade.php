@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Checkout</div>
                <div class="card-body">
                    <form method="post" action="{{ route('processPayment') }}">
                        @csrf
                        <div class="form-group">
                            <label for="amount">Amount (EUR)</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="10.00" readonly>
                        </div>
                        <div class="form-group">
                            <label for="payment_method_nonce">Payment Method Nonce</label>
                            <div id="dropin-container"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.braintreegateway.com/web/dropin/1.39.0/js/dropin.js"></script>

<script>
    var form = document.querySelector('form');
    var button = document.querySelector('button');
    var dropinContainer = document.getElementById('dropin-container');

    braintree.dropin.create({
        authorization: 'YOUR_BRAINTREE_CLIENT_TOKEN', // Replace with your Braintree client token
        container: dropinContainer
    }, function (createErr, instance) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                    console.error(err);
                    return;
                }

                // Set the payment method nonce value to a hidden input field
                var nonceInput = document.createElement('input');
                nonceInput.type = 'hidden';
                nonceInput.name = 'payment_method_nonce';
                nonceInput.value = payload.nonce;
                form.appendChild(nonceInput);

                // Submit the form
                form.submit();
            });
        });
    });
</script>

@endsection