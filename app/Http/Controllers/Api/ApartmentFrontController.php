<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment as Apartment;
use App\Models\Sponsor as Sponsor;
use Carbon\Carbon;

class ApartmentFrontController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        // manda solo i dati che hanno o hanno avuto una sponsor e la data di scadenza della sponsor deve essere uguale o maggiore a oggi che ricaviamo con $today
        $apartments1 = Apartment::with(['pictures', 'services', 'sponsors', 'messages'])

            // ricerca per nome città
            // ->where('city', 'Cortina d Ampezzo')

            ->whereHas('sponsors', function ($query) use ($today) {
                $query->where('expire_at', '>=', $today->toDateString());
            })

            // ricerca che deve contenere almeno service id...
            // ->whereHas('services', function ($query) {
            //     $query->where('id', 2);
            // })

            ->get();

        // manda i dati di tutti gli appartamenti che non hanno lo sponsor e con lo sponsor scaduto
        $apartments2 = Apartment::with(['pictures', 'services', 'sponsors', 'messages'])

            // ricerca per nome città
            // ->where('city', 'Cortina d Ampezzo')

            ->where(function ($query) use ($today) {
            $query->whereHas('sponsors', function ($subQuery) use ($today) {
                $subQuery->where('expire_at', '<', $today->toDateString());
            })
            ->orWhereDoesntHave('sponsors');
        })

        // ricerca che deve contenere almeno service id...
        // ->whereHas('services', function ($query) {
        //     $query->where('id', 2);
        // })

        ->get();

        // manda prima i dati delle sponsor e poi tutti gli altri
        $apartments = $apartments1->merge($apartments2);


        if ($apartments->isNotEmpty())
        {
            return response()->json([
                                        'success' => true,
                                        'apartments' => $apartments
                                    ]);
        }
        else
        {
            return response()->json([
                                        'success' => false,
                                        'message' => "Nessun appartamento disponibile"
                                    ]);   
        } 
    }
}
