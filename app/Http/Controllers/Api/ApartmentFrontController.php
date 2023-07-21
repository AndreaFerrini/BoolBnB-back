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

            } else 
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
            $place = $request->city;
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