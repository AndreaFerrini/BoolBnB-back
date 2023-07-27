<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment as Apartment;
use App\Models\Sponsor as Sponsor;
use App\Models\Service as Service;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ApartmentFrontController extends Controller
{

    private $distance   = 10;
    private $front_lat  = 0;
    private $front_long = 0;
    private $distance_calculated = 0; 
    private $distances_array = [];
    private $services_array = [];

    function is_within_range($lat, $long)
    {
        $result = false;
        if ($this->calculateDistanceInKilometers($lat, $long, $this->front_lat, $this->front_long) <= $this->distance)
            $result = true;
        return $result;
    }

    function calculateDistanceInKilometers($lat1, $lon1, $lat2, $lon2) 
	{
        $R = 6371e3; // meters

        $φ1 = deg2rad($lat1); // φ, λ in radians
        $φ2 = deg2rad($lat2);
        $Δφ = deg2rad($lat2 - $lat1);
        $Δλ = deg2rad($lon2 - $lon1);

        $a =    sin($Δφ / 2) * sin($Δφ / 2) + cos($φ1) * cos($φ2) * sin($Δλ / 2) * sin($Δλ / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $d = $R * $c; // in meters

        $distanceInKilometers = round($d / 1000, 1);

        return $distanceInKilometers;
    }

    // Metodo che restituisce al frontend tutti i servizi potenzialmente presenti nel database
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

    // Metodo che restituisce una collezione di appartamenti, eventualmente filtrati per città e/o per presenza di una sponsorizzazione tuttora attiva
    public function get_apartments($with_sponsor, $city)
    {
        // Acquisizione della data/ora atuale
        $now = Carbon::now();
        // Collezione TEMPORANEA di appartamenti non filtrati
        $temporary = Apartment::with(['pictures', 'services', 'sponsors', 'messages']);
        // Se la città è definita, si procede con il filtraggio della collezione temporanea, sulla città in questione
        if ($city != "")
        {
            $temporary = $temporary->where('city', $city);

            /////////////////////////////////////////////////////////////////////////////////////////////////////////

            if (count($this->services_array) != 0)
            {
                $services_ids_int = [];
                foreach ($this->services_array as $str_id)
                {
                    $services_ids_int[] = intval($str_id);
                }

                // $temporary_copy = $temporary;
                // foreach ($temporary as $apt)
                // {
                //     $valid = true;
                //     $apt_services = $apt->services()->pluck('id')->toArray();
                //     foreach ($services_ids_int as $service_id)
                //     {
                //         $valid = in_array($service_id, $apt_services);
                //         if (!$valid)
                //             continue;
                //     }

                // }


                $temporary = $temporary->where(function ($query) use ($services_ids_int) 
                {
                    foreach ($services_ids_int as $service_id) 
                    {
                        $query->whereHas('services', function ($innerQuery) use ($service_id) 
                        {
                            $innerQuery->where('service_id', $service_id);
                        });
                    }
                });                


                // dd("stringhe: ",$this->services_array, "<br> interi: ", $services_ids_int);
                // $collection = collect($temporary);
                // $filtered_apartments = $collection->filter(function($apartment) use ($services_ids_int) 
                // {
                //     $apartment_services = $apartment->services->pluck('id')->toArray();
                //     return empty(array_diff($services_ids_int, $apartment_services));
                // });
                // // dd("servizi richiesti: ",$services_ids_int, "appartamenti prima del filtraggio: ", $temporary->all(), "appartamenti dopo filtraggio :", $filtered_apartments->all());
                // $temporary = $filtered_apartments;
                //-----------------------------------------------------------------------
                // $temporary = $temporary->whereHas('services', function ($query) use ($services_ids_int) 
                // {
                //     // Include apartments that have all the requested services
                //     $query->whereIn('service_id', $services_ids_int);
                // });
            
                // // Exclude apartments that have fewer services than the requested ones
                // $temporary = $temporary->whereDoesntHave('services', function ($query) use ($services_ids_int) 
                // {
                //     $query->whereNotIn('service_id', $services_ids_int);
                // });
                //---------------------------------------------------------------------
                // $temporary = $temporary->where(function ($query) use ($services_ids_int) 
                // {
                //     // per ogni elemento in services
                //     foreach ($services_ids_int as $service_id) 
                //     {
                //     //  dalla query usiamo il wereHas  [per calcolare le relazioni con services] usando i service_id che abbiamo estrapolato
                //         $query->whereHas('services', function ($query) use ($service_id) 
                //         {
                //     //  usando la clausola where ->  prendiamo ogni elemnto che corrisponde all'id di servecies tramite modello
                //             $query->where('services.id', $service_id);
                //         });
                //     }
                // });

            }


            //////////////////////////////////////////////////////////////////////////////////////////////////////////

            if ($this->front_lat !== 0)
            foreach ($temporary->get() as $key => $item)
            {
                $this->distance_calculated = $this->calculateDistanceInKilometers($this->front_lat, $this->front_long, floatval($item->latitude), floatval($item->longitude));
                $this->distances_array[] = $this->distance_calculated;
            }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////


        }

        // Se si richiedono solo appartamenti con sponsorizzazione attiva, si filtrano in questo senso gli elementi della collezione temporanea....
        if ($with_sponsor)
        {
            if($city != "")
            {

                $apartments = $temporary->whereHas('sponsors', function ($query) use ($now) 
                {
                    $query->where('expire_at', '>=', $now->toDateString());
                })->get();

            } 
            else 
            {
                $apartments = $temporary->whereHas('sponsors', function ($query) use ($now) 
                    {
                        $query->where('expire_at', '>=', $now->toDateString());
                    })->paginate(6);
            }
        }
        // .... altrimenti gli appartamenti della collezione temporanea verranno filtrati solo per assenza di sponsorizzazione o sponsorizzazioni scadute
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
        // Si setta l'opportuno valore di "place" a seconda che nella request ci sia o meno un'indicazione di filtraggio sulla città
        if ($request->city)
            {
                $place = $request->city;
                if ($request->lat)
                {
                    $this->distance = floatval($request->range);
                    $this->front_lat = floatval($request->lat);
                    $this->front_long = floatval($request->long);
                    $this->distances_array = [];
                }
                if ($request->service)
                {
                    $this->services_array = explode("-", $request->service);
                }
            }
        else
            $place = ""; 
        // Si procede nella ricerca dei dati richiesti solo se la richiesta stessa è opportuna, ovvero se non si verificano le condizioni di invalidità della ricerca, ovvero:
        // 1) si vogliono ottenere tutti gli appartamenti, senza specificarne la città (RICERCA NON VALIDA)
        if (!((strtolower($request->filter) == "all") && ($place == "")))
        {
            // Essere dentro l'if implica che la ricerca in corso è valida
            // Come prima cosa si ottengono tutti gli appartamenti sponsorizzati (sponsorizzazione attiva) che serviranno in ogni caso poichè saranno gli unici elementi restituiti nel caso in cui si stiano cercando proprio gli appartamenti sponsorizzati oppure saranno presenti come primi elementi della collezione nel caso in cui la ricerca sia più ampia
            $apartments_active = $this->get_apartments(true, $place);
            if (strtolower($request->filter) == "sponsored")
            {
                // Caso in cui la ricerca è mirata ai soli appartamenti sponsorizzati.....Si associano gli stessi alla variabile "apartments" e si va al return
                $apartments = $apartments_active;
            }
            elseif (strtolower($request->filter) == "all")
            {
                // Caso in cui la ricerca non preveda i soli appartamenti sponsorizzati.....si uniscono gli sponsorizzati (già acquisiti, tenendoli in testa) ai non sponsorizzati (che andranno in coda)
                $apartments = $apartments_active->merge($this->get_apartments(false, $place));
                if (($request->city) && ($this->front_lat !== 0))
                {
                    $temporary = $apartments->map(function ($item)
                    {
                        $item['distance'] = array_shift($this->distances_array);
                            return $item;
                    });
                    $apartments = null;
                    $apartments = $temporary->filter(function ($item)
                    {
                        return ($item->distance <= $this->distance);
                    });
                }
            }
        }
        else
        {
            // Siamo nella parte relativa alla richiesta non valida. Dovendo usare il metodo "isNotEmpty" ed essendo lo stesso non compatibile con i normali array, si crea una collezione vuota tale che isNotEmpty sia utilizzabile
            $empty_array = [];
            $apartments = collect($empty_array);
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

    public function show($apartment_id)
    {
        // Ottieni l'appartamento tramite id 
        $apartment = Apartment::where('id', $apartment_id)->with(['pictures', 'services', 'sponsors', 'messages'])->first();

        if ($apartment) {
            return response()->json([
                'success' => true,
                'apartment' => $apartment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Appartamento non trovato.'
            ]);
        }
    }
    
}