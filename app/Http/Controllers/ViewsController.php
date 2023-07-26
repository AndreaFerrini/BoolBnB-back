<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Views;
use App\Models\Apartment;

class ViewsController extends Controller
{
    public function index()
    {
        $apartment_id = Auth::apartment()->id;

        $apartments = Apartment::where('apartment_id', $apartment_id)->get();
        return view('dashboard', compact('apartments'));
    }
}
