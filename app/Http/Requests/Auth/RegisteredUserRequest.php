<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Models\User;

class RegisteredUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'=>['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'name' => ['string', 'max:255', 'nullable'],
            'surname' => ['string', 'max:255', 'nullable'],
            'birth' => ['date', 'nullable'],

        ];
    }
    public function attributes(): array
   {
       return [
        
        'email'=>'email',
        'password' => 'password',
        'name' => 'nome',
        'surname' => 'cognome',
        'birth' => 'data di nascita',

       ];
   }
}
