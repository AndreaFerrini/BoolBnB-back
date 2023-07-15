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
        $apartments = Apartment::where('user_id', $user_id)->get();
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
        return view('pages.ur.create', compact('services', 'cities'));
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
        $path = Storage::disk('public')->put('cover_img', $form_data['cover_img']);
        $slug = Str::slug($form_data['title']);
        $user_id = Auth::user()->id;
        $tomtomResponseJson = get_coordinates($indirizzo, $form_data['city']);
        $tomtomResponseDecoded = json_decode($tomtomResponseJson, true);
        $lat = $tomtomResponseDecoded['results'][0]['position']['lat'];
        $long = $tomtomResponseDecoded['results'][0]['position']['lon'];
        
        // riempimento form data
        $form_data['cover_img'] = $path;
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

        // dd($new_apartment);
        
        $new_apartment->services()->attach( $form_data['services'] );

        // $request->services()->attach($request->services);

        // $cap = (explode(' ',$form_data['address']));
        // dd(end($cap), $cap[count($cap) - 2]);

        $user_id = Auth::user()->id;
        $apartments = Apartment::where('user_id', $user_id)->get();
        
        return view('dashboard', compact('apartments'));
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
        $services = Service::all();
        $cities = config('data_storage.cities.cities');
        return view('pages.ura.edit', compact('services', 'cities', 'apartment'));
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
        
        return view('dashboard', compact('apartments'));
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
            Storage::delete($apartment->cover_img);
            $apartment->delete();
        }

        $apartments = Apartment::where('user_id', $user_id)->get();
        return view('dashboard', compact('apartments'));
    }
}