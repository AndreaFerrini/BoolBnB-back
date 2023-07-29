<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsor;
use Braintree\Result\Successful;
use Braintree\Transaction;
use Braintree\Gateway; // Importa la classe Braintree\Gateway
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SponsorController extends Controller
{
    public function selectSponsor(Request $request, $apartment_id)
    {

        $apartment = Apartment::where('id', $apartment_id)->first();
        
        return view('pages.ura.sponsor.select', compact('apartment_id', 'apartment'));
    }

    public function checkout(Request $request, $apartment_id)
    {

        $amount = $request->input;
        
        $gateway = new Gateway([
            'environment' => env('BT_ENVIRONMENT'),
            'merchantId' => env('BT_MERCHANT_ID'),
            'publicKey' => env('BT_PUBLIC_KEY'),
            'privateKey' => env('BT_PRIVATE_KEY')
        ]);
    
        $clientToken = $gateway->clientToken()->generate();
    
        return view('pages.ura.sponsor.index', compact('clientToken', 'apartment_id', 'amount'));
    }

    public function processPayment(Request $request, $apartment_id)
    {
        $user_id = Auth::user()->id;
        $apartments = Apartment::where('user_id', $user_id)->get();

        $apartment = $apartments->where('id', $apartment_id)->first();

    
        $gateway = new Gateway([
            'environment' => env('BT_ENVIRONMENT'),
            'merchantId' => env('BT_MERCHANT_ID'),
            'publicKey' => env('BT_PUBLIC_KEY'),
            'privateKey' => env('BT_PRIVATE_KEY')
        ]);

        
        $amount = $request->input('amount');
        $nonce = $request->input('payment_method_nonce');
        
        // dd($request->nonce);

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

            //se lammontare del pagamento e 2.99
            if($amount == 2.99) {

                $currentDate = Carbon::now();
                $expire_date = $currentDate->addHours(24);
                $expire_date_formatted = $expire_date->format('Y-m-d H:i:s');

                //associa all'appartamento la sponsor da 24h
                $apartment->sponsors()->attach(['apartment_id' => $apartment->id], ['sponsor_id' => 1], ['expire_at' => $expire_date_formatted]);

            //se lammontare del pagamento e 5.99
            } else if($amount == 5.99){

                $currentDate = Carbon::now();
                $expire_date = $currentDate->addHours(72);
                $expire_date_formatted = $expire_date->format('Y-m-d H:i:s');

                //associa all'appartamento la sponsor da 72h
                $apartment->sponsors()->attach(['apartment_id' => $apartment->id], ['sponsor_id' => 2], ['expire_at' => $expire_date_formatted]);

            //se lammontare del pagamento e 9.99
            } else if($amount == 9.99) {

                $currentDate = Carbon::now();
                $expire_date = $currentDate->addHours(144);
                $expire_date_formatted = $expire_date->format('Y-m-d H:i:s');

                //associa all'appartamento la sponsor da 144h
                $apartment->sponsors()->attach(['apartment_id' => $apartment->id], ['sponsor_id' => 3], ['expire_at' => $expire_date_formatted]);
            }

            //rimando alla dashboard 
            $result->status = 'success';
            $result->message = "la transazione è stata accettata l'appartamento: " . $apartment->title . " ha ora una sponsorizzazione attiva";
            return view('dashboard', compact('apartments', 'result'))->with('success', 'La transazione è andata a buon fine ' );
        } else {
            // Pagamento fallito
            $result->status = 'failed';
            return view('dashboard', compact('apartments', 'result'))->with('error', 'Si è verificato un errore durante il pagamento: ' . $result->message);
        }
    }
}

