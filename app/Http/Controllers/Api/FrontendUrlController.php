<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FrontendUrlController extends Controller
{
    public function save_data(Request $request)
    {
        File::put(storage_path("app/public/front_end_url.txt"), $request->front_url);
        return response()->json(    [
                                        'success'   => true, 
                                        'value' => $request-> front_url,
                                    ]);
    }
}
