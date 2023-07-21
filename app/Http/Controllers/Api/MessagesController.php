<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        
        $apartments = Apartment::with("messages");
    
        return response()->json(
            [
            'success' => true,
            'messages' => $messages
            ]
        );

        
    }
    
    public function show($message)
    {
        
        if( $message ){
            return response()->json([
    
                'success' => true,
                'message' => $message
                
            ]);

        } else {
    
            return response()->json([
    
                'success' => false,
                'error' => "Non sono presenti messages"

            ])->setStatusCode(404);
        }

    }

}
