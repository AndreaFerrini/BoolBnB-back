@extends('layouts.app')

@section('content')

<div id="dropin-container"></div>
<button id="submit-button" class="button button--small button--green">Purchase</button>

<script src="https://js.braintreegateway.com/web/dropin/1.39.0/js/dropin.js"></script>

<script>

    var button = document.querySelector('#submit-button');

    braintree.dropin.create({
    authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
    selector: '#dropin-container'
    }, function (err, instance) {
    button.addEventListener('click', function () {
        instance.requestPaymentMethod(function (err, payload) {
        // Submit payload.nonce to your server
        });
    })
    });

</script>

@endsection