<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Requests\ApartmentsCreateRequest;

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
        dd($request);
        $form_data = $request->validated();


        $indirizzo = $form_data['address'] . ' ' . $form_data['address_number'] . ' ' . $form_data['postal_code'];
        $path = Storage::disk('public')->put('cover_img', $form_data['cover_img']);
        $slug = Str::slug($form_data['title']);
        $user_id = Auth::user()->id;
        
        $form_data['cover_img'] = $path;
        $form_data['user_id'] = $user_id;
        $form_data['slug'] = $slug;
        $form_data['address'] = $indirizzo;

        // $request->services()->attach($request->services);

        // $cap = (explode(' ',$form_data['address']));
        // dd(end($cap), $cap[count($cap) - 2]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}
