<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsor;
use Braintree\Result\Successful;
use Braintree\Transaction;
use Braintree\Gateway; // Importa la classe Braintree\Gateway
use Illuminate\Support\Facades\Auth;

class SponsorController extends Controller
{
    public function checkout($apartment_id)
    {
        $gateway = new Gateway([
            'environment' => env('BT_ENVIRONMENT'),
            'merchantId' => env('BT_MERCHANT_ID'),
            'publicKey' => env('BT_PUBLIC_KEY'),
            'privateKey' => env('BT_PRIVATE_KEY')
        ]);
    
        $clientToken = $gateway->clientToken()->generate();
    
        return view('pages.ura.sponsor.index', compact('clientToken', 'apartment_id'));
    }

    public function processPayment(Request $request)
    {
        $user_id = Auth::user()->id;
        $apartments = Apartment::where('user_id', $user_id)->get();
    
        $gateway = new Gateway([
            'environment' => env('BT_ENVIRONMENT'),
            'merchantId' => env('BT_MERCHANT_ID'),
            'publicKey' => env('BT_PUBLIC_KEY'),
            'privateKey' => env('BT_PRIVATE_KEY')
        ]);
    
        $amount = $request->input('amount');
        $nonce = $request->input('payment_method_nonce');

        $nonces = ['fake-valid-nonce', 'fake-valid-nonce', 'fake-valid-nonce'];
        $nonce = $nonces[array_rand($nonces)];
    
        // Simulare una transazione di successo
        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce, // Utilizza un nonce valido per simulare una transazione di successo
            'options' => [
                'submitForSettlement' => true
            ]
        ]);
    
        if ($result->success) {
            // Pagamento completato con successo
            // Puoi gestire l'ordine qui

            $result->message = 'la transazione è stata accettata';
            return view('dashboard', compact('apartments', 'result'))->with('succes', 'La transazione è andata a buon fine ' );
        } else {
            // Pagamento fallito
            return view('dashboard', compact('apartments', 'result'))->with('error', 'Si è verificato un errore durante il pagamento: ' . $result->message);
        }
    }
}
