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
        // $apartments = Apartment::with(['pictures', 'services', 'sponsors', 'messages'])
        //     ->whereHas('sponsors', function ($query) use ($today) {
        //         $query->where('expire_at', '>=', $today->toDateString());
        //     })
        //     ->get();

        // manda i dati di tutti gli appartamenti che non hanno lo sponsor e con lo sponsor scaduto
        $apartments = Apartment::with(['pictures', 'services', 'sponsors', 'messages'])
        ->where(function ($query) use ($today) {
            // Get apartments that have sponsors but are older than today.
            $query->whereHas('sponsors', function ($subQuery) use ($today) {
                $subQuery->where('expire_at', '<', $today->toDateString());
            })
            // Get apartments that do not have any sponsors.
            ->orWhereDoesntHave('sponsors');
        })->get();

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
