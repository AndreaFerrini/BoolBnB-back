<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Config\Data_for_seeding\Bnb_api_client_functions;

use App\Http\Requests\ApartmentsCreateRequest;
use App\Http\Requests\ApartmentsEditRequest;
use App\Models\Sponsor;

// require_once __DIR__ . '../../../config/Data_For_Seeding/bnb_api_client_functions.php';

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        // dd(User::findOrFail($user_id));
        // dd($user->apartments();
        $apartments = Apartment::where('user_id', $user_id)->with('sponsors')->get();
        return view('dashboard', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        $cities = config('data_storage.cities.cities');
        $tomtomApiKey = env('TOMTOM_API_KEY');
        return view('pages.ur.create', compact('services', 'cities', 'tomtomApiKey'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApartmentsCreateRequest $request)
{
    // validazione
    $form_data = $request->validated();

    // inizializzazione: indirizzo composto, path img, slug, user id, latitudine, longitudine
    $indirizzo = $form_data['address'] . ' ' . str_replace(' ', '', $form_data['address_number']) . ' ' . $form_data['postal_code'];
    if ($request->hasFile('cover_img')) {        
        $path = Storage::disk('public')->put('cover_img', $form_data['cover_img']);
        $form_data['cover_img'] = $path;
    } 

    $uploadedImages = []; // Inizializza l'array vuoto per le immagini caricate

    if ($request->hasFile('images')) {
        $images = $request->file('images');

        foreach ($images as $image) {
            $path = Storage::disk('public')->put('apartment_images', $image);
            $uploadedImages[] = ['picture_url' => $path];
        }
    }

    $slug = Str::slug($form_data['title']);
    $user_id = Auth::user()->id;
    $tomtomResponseJson = get_coordinates($indirizzo, $form_data['city']);
    $tomtomResponseDecoded = json_decode($tomtomResponseJson, true);
    $lat = $tomtomResponseDecoded['results'][0]['position']['lat'];
    $long = $tomtomResponseDecoded['results'][0]['position']['lon'];
    
    // riempimento form data
    $form_data['user_id'] = $user_id;
    $form_data['slug'] = $slug;
    $form_data['address'] = $indirizzo;
    $form_data['longitude'] = $long;
    $form_data['latitude'] = $lat;

    // inizializzazione nuovo appartamento
    $new_apartment = new Apartment();

    // compilazione entry e salvataggio
    $new_apartment->fill($form_data);
    $new_apartment->save();

    // Collega le immagini caricate all'appartamento
    if (!empty($uploadedImages)) {
        $new_apartment->pictures()->createMany($uploadedImages);
    }

    $new_apartment->services()->attach($form_data['services']);

    $user_id = Auth::user()->id;
    $apartments = Apartment::where('user_id', $user_id)->get();
    
    return redirect()->route('admin.apartments.index', compact('apartments'))->with('success', 'Card creata con successo!');
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        if(Auth::user()->id === $apartment->user_id){
            $services = Service::all();
            $cities = config('data_storage.cities.cities');
            $tomtomApiKey = env('TOMTOM_API_KEY');

            return view('pages.ura.edit', compact('services', 'cities', 'apartment', 'tomtomApiKey'));
        } else{
            return redirect()->route('admin.apartments.index')->with('negate', 'Non sei autorizzato ad entrare in questa pagina');
        };
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(ApartmentsEditRequest $request, Apartment $apartment)
    {     
              
        
        $form_data = $request->validated();
        
        if( $request->hasFile('cover_img') ){       
            if( $apartment->image ){
                Storage::delete($apartment->image);
            }
            $path = Storage::disk('public')->put('cover_img', $form_data['cover_img']);

            $form_data['cover_img'] = $path;
        } 

        $indirizzo = $form_data['address'] . ' ' . str_replace(' ', '', $form_data['address_number']) . ' ' . $form_data['postal_code'];
   
        $slug = Str::slug($form_data['title']);
        $user_id = Auth::user()->id;
        $tomtomResponseJson = get_coordinates($indirizzo, $form_data['city']);
        $tomtomResponseDecoded = json_decode($tomtomResponseJson, true);
        $lat = $tomtomResponseDecoded['results'][0]['position']['lat'];
        $long = $tomtomResponseDecoded['results'][0]['position']['lon'];
        
        // riempimento form data
        $form_data['user_id'] = $user_id;
        $form_data['slug'] = $slug;
        $form_data['address'] = $indirizzo;
        $form_data['longitude'] = $long;
        $form_data['latitude'] = $lat;

        $apartment->update($form_data);


        $apartment->services()->sync($form_data['services']);

        $apartments = Apartment::where('user_id', $user_id)->get();
        
        // return view('dashboard', compact('apartments'));
        return redirect()->route('admin.apartments.index', compact('apartments'))->with('success', 'Hai modificato ' . $apartment['title']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        $user_id = Auth::user()->id;

        if($apartment->user_id === $user_id){

            if( $apartment->image ){
                Storage::delete($apartment->image);
            }
            $apartment->delete();
        }

        $apartments = Apartment::where('user_id', $user_id)->get();
        return view('dashboard', compact('apartments'));
    }

    public function visibility(Apartment $apartment) {
        $apartment->update(['visibility' => !$apartment->visibility]);
        $id_apartment = $apartment->id;
        return redirect()->route('admin.apartments.index', compact('id_apartment'))->with('success', "Hai modificato la visibilità di ".$apartment['title']);
    }

    public function sponsor(Request $request, Apartment $apartment)
    {
        // Verifica che l'appartamento esista
        if (!$apartment) {
            return redirect()->back()->with('error', 'Appartamento non trovato');
        }

        // Verifica se l'appartamento è già sponsorizzato
        if ($apartment->sponsor) {
            return redirect()->back()->with('error', 'L\'appartamento è già sponsorizzato');
        }

        // Recupera l'ID dello sponsor dal form utilizzando il nome dell'input nascosto
        $sponsorId = $request->input('sponsor_id');

        // Verifica che l'ID dello sponsor sia valido
        $sponsor = Sponsor::find($sponsorId);
        if (!$sponsor) {
            return redirect()->back()->with('error', 'Sponsorizzazione non trovata');
        }

        // Aggiungi la sponsorizzazione all'appartamento
        $expireDate = add_hours_to_date($sponsor->period * 24); // Converti il periodo in ore
        $apartment->sponsors()->attach($sponsor->id, ['expire_at' => $expireDate]);

        return redirect()->back()->with('success', 'Sponsorizzazione aggiunta con successo');
    }

}