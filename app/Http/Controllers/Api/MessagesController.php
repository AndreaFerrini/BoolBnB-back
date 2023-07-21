<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function save_message(Request $request)
    {
        
        $apartment_id = $request->apartment_id;
        $name = $request->nome;
        $surname = $request->cognome;
        $email = $request->email;
        $email_body = $request->email_body;

        if(($request->message) && ($request->apartment_id)){

            return response()->json(  
            [
                'success'   => true,
                'apartment_id' => $apartment_id,
                'name' => $name,
                'surname' => $surname,
                'email' => $email,
                'email_body' => $email_body,
            ]);

        } else {

            return response()->json(  
            [
                'success'   => false, 
                'value' => "Messaggio inviato non corretto",
            ]); 

        }
  
    }

}
