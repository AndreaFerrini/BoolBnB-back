<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function save_message(Request $request)
    {
        $message = new Message();


        $message->apartment_id = $request->apartment_id;
        $message->name = $request->nome;
        $message->surname = $request->cognome;
        $message->email = $request->email;
        $message->email_body = $request->email_body;



        if(($request->email) && ($request->apartment_id) && ($request->nome) && ($request->cognome) && ($request->email_body)){

            $message->save();

            return response()->json(  
            [
                'success'   => "Messaggio inviato correttamente",
                'apartment_id' => $message->apartment_id,
                'name' => $message->name,
                'surname' => $message->surname,
                'email' => $message->email,
                'email_body' => $message->email_body,
            ]);

        } else {

            return response()->json(  
            [
                'success'   => "Qualcosa è andato storto", 
                'value' => "Messaggio inviato non corretto",
            ]); 

        }
  
    }

}
