<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment as Apartment;
use App\Models\Sponsor as Sponsor;
use App\Models\Service as Service;
use Carbon\Carbon;

class ApartmentFrontController extends Controller
{

    public function get_services()
    {
        $all_services = Service::All();
        if ($all_services->isNotEmpty())
            return response()->json(    [
                                            'success'   => true,
                                            'services'  => $all_services
                                        ]);
        else
            return response()->json(    [
                                            'success'   => false
                                        ]);
    }

    public function get_apartments($with_sponsor, $city)
    {
        $now = Carbon::now();
        $temporary = Apartment::with(['pictures', 'services', 'sponsors', 'messages']);
        if ($city != "")
        {
            $temporary = $temporary->where('city', $city);
        }
        if ($with_sponsor)
        {
            $apartments = $temporary->whereHas('sponsors', function ($query) use ($now) 
            {
                $query->where('expire_at', '>=', $now->toDateString());
            })->get();
        }
        else
        {
            $apartments = $temporary->where(function ($query) use ($now) 
            {
                $query->whereHas('sponsors', function ($subQuery) use ($now) 
                {
                    $subQuery->where('expire_at', '<', $now->toDateString());
                })->orWhereDoesntHave('sponsors');
            })->get();
        }
        return $apartments;
    }

    public function index(Request $request)
    {
        $apartments = [];
        $city = "";
        if (isset($request->city))
            $city = $request->city;
        if (!((strtolower($request->filter) == "all") && ($city == "")))
        {
            $apartments_active = $this->get_apartments(true, $city);
            if (strtolower($request->filter) == "sponsored")
            {
                $apartments = $apartments_active;
            }
            elseif (strtolower($request->filter) == "all")
            {
                $apartments = $apartments_active->merge($this->get_apartments(false, $city));
            }
        }

        if ($apartments->isNotEmpty())
            return response()->json(
                                        [
                                            'success'       => true,
                                            'apartments'    => $apartments
                                        ]);
        else
            return response()->json(
                                        [
                                            'success'   => false
                                        ]);
    }

//     public function index(Request $request)
//     {
//         $now = Carbon::now();

//         // manda solo i dati che hanno o hanno avuto una sponsor e la data di scadenza della sponsor deve essere uguale o maggiore a oggi che ricaviamo con $now
//         $apartments_active = Apartment::with(['pictures', 'services', 'sponsors', 'messages'])

//             // ricerca per nome città
//             // ->where('city', 'Cortina d Ampezzo')

//             ->whereHas('sponsors', function ($query) use ($now) {
//                 $query->where('expire_at', '>=', $now->toDateString());
//             })

//             // ricerca che deve contenere almeno service id...
//             // ->whereHas('services', function ($query) {
//             //     $query->where('id', 2);
//             // })

//             ->get();

//         // manda i dati di tutti gli appartamenti che non hanno lo sponsor e con lo sponsor scaduto
//         $apartments_others = Apartment::with(['pictures', 'services', 'sponsors', 'messages'])

//             // ricerca per nome città
//             // ->where('city', 'Cortina d Ampezzo')

//             ->where(function ($query) use ($now) {
//             $query->whereHas('sponsors', function ($subQuery) use ($now) {
//                 $subQuery->where('expire_at', '<', $now->toDateString());
//             })
//             ->orWhereDoesntHave('sponsors');
//         })

//         // ricerca che deve contenere almeno service id...
//         // ->whereHas('services', function ($query) {
//         //     $query->where('id', 2);
//         // })

//         ->get();

//         // manda prima i dati delle sponsor e poi tutti gli altri

//         if (strtolower($request->filter) == "all")
//         {
//             $apartments = $apartments_active->merge($apartments_others);
//         }
//         elseif (strtolower($request->filter) == "sponsored")
//         {
//             $apartments = $apartments_active;
//         }

//         if ($apartments->isNotEmpty())
//         {
//             return response()->json([
//                                         'success' => true,
//                                         'apartments' => $apartments,
//                                         'filter' => $request->filter
//                                     ]);
//         }
//         else
//         {
//             return response()->json([
//                                         'success' => false,
//                                         'message' => "Nessun appartamento disponibile"
//                                     ]);   
//         } 
//     }
// }
}