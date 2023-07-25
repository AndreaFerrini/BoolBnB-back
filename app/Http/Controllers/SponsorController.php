<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function addSponsorToApartment(Request $request)
    {

        $apartment_id = $request->input('apartment_id');
        $sponsor_id = $request->input('sponsor_id');

        // Recupera l'appartamento a cui desideri aggiungere la sponsorizzazione
        $apartment = Apartment::find($apartment_id);

        // Controlla se l'appartamento esiste
        // if (!$apartment) {
        //     return response()->json(['error' => 'Appartamento non trovato'], 404);
        // }

        // Controlla se l'ID della sponsorizzazione è valido
        $sponsor = Sponsor::find($sponsor_id);
        // if (!$sponsor) {
        //     return response()->json(['error' => 'Sponsorizzazione non trovata'], 404);
        // }

        // Aggiungi la sponsorizzazione all'appartamento
        $expire_at = add_hours_to_date($sponsor->period);
        $apartment->sponsors()->attach($sponsor->id, ['expire_at' => $expire_at]);

        return response()->json(['message' => 'Sponsorizzazione aggiunta con successo']);
    }
}
