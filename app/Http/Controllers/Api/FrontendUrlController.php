<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendUrlController extends Controller
{
    public function save_data(Request $request)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) 
        {
            session_start();
        }
        $_SESSION['front_url'] = $request->front_url;
            return response()->json(    [
                                            'success'   => true, 
                                            'value' => $request-> front_url,
                                        ]);
    }
}
