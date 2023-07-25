<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsor;
use Braintree\Transaction;

class SponsorController extends Controller
{
    public function checkout($apartment_id)
    {

        

        return view('pages.ura.sponsor.index');
    }

    public function processPayment(Request $request)
    {
        $gateway = new Gateway([
            'environment' => env('BT_ENVIRONMENT'),
            'merchantId' => env('BT_MERCHANT_ID'),
            'publicKey' => env('BT_PUBLIC_KEY'),
            'privateKey' => env('BT_PRIVATE_KEY')
        ]);

        $amount = $request->input('amount');
        $nonce = $request->input('payment_method_nonce');

        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            // Pagamento completato con successo
            // Puoi gestire l'ordine qui
            return redirect()->route('checkout')->with('success', 'Pagamento completato con successo!');
        } else {
            // Pagamento fallito
            return redirect()->route('checkout')->with('error', 'Si è verificato un errore durante il pagamento: ' . $result->message);
        }
    }
}
