<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

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
        'name' => 'il nome del progetto',
        'description' => 'la descrizione del progetto',
        'short_description' => 'la descrizione BREVE del progetto',
        'image' => 'la foto del progetto',
        'relase_date' => 'la data di creazione del progetto',
        'type_id' => 'i programmi usati per il progetto',
        'visbility' => 'la visibiltà del progetto',
        'tags' => 'i tags',
        'project_link' => 'il link del progetto'

       ];
   }
}
