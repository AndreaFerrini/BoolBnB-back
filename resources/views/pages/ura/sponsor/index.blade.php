@extends('layouts.app')

@section('content')
<main class="container-fluid">
  <div class="row justify-content-center pt-5">
    <h1 class="text-center">Complete transaction</h1>
    <form class="col-6" id="payment-form" action="{{ route('processPayment', $apartment_id) }}" method="post">
        @csrf
        <select class="form-select d-none" aria-label="Default select example" id="amount" name="amount">
          <option  :value={{$amount}}>{{$amount}}</option>
        </select>
        <div id="dropin-container"></div>
        <input class="btn btn-primary" type="submit" value="Purchase"></input>
        <input type="hidden" id="nonce" name="payment_method_nonce"></input>
    </form>
  </div>
</main>

<script src="https://js.braintreegateway.com/web/dropin/1.39.0/js/dropin.min.js"></script>

<script>
      var form = document.querySelector('#payment-form');
      var nonceInput = document.querySelector('#nonce');

      braintree.dropin.create({
        authorization: '{{ $clientToken }}',
        container: '#dropin-container'
      }, function (err, dropinInstance) {
        if (err) {
          // Handle any errors that might've occurred when creating Drop-in
          console.error(err);
          return;
        }
        form.addEventListener('submit', function (event) {
          event.preventDefault();

          dropinInstance.requestPaymentMethod(function (err, payload) {
            if (err) {
              // Handle errors in requesting payment method
              return;
            }

            // Send payload.nonce to your server
            nonceInput.value = payload.nonce;
            form.submit();
          });
        });
      });
</script>
@endsection


