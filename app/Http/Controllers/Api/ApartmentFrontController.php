<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment as Apartment;

class ApartmentFrontController extends Controller
{
    public function index(Request $request)
    {
        $apartments = Apartment::with(['pictures', 'services', 'sponsors', 'messages'])->get();
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
