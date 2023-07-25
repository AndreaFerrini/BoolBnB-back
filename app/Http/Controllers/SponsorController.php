<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function sponsor($apartment_id)
    {

        

        return view('pages.ura.sponsor.index');
    }
}
