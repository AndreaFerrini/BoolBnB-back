<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentsCreateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:100'],
            'cover_img' => ['required', 'image'],
            'description' => ['required', 'string'],
            'address' => ['required','string','max:100'],
            'address_number' => ['required', 'string', 'min:1','max:99999','regex:/^[0-9a-zA-Z]+$/'],
            'city' => ['required', 'string', 'max:50'],
            'postal_code' => ['required', 'string', 'min:5', 'max:5', 'regex:/^[0-9]{5}$/'],
            'number_of_rooms'=>['required', 'int', 'min:1', 'max:20'],
            'number_of_bathrooms' => ['required', 'int', 'min:1', 'max:20'],
            'square_meters' => ['required', 'int', 'min:1', 'max:1000'],
            'price' => ['required', 'numeric', 'min:1', 'max:99999'],
            'services' => ['required', 'exists:services,id'],
            'visibility'=>['boolean']
        ];
    }

    public function attributes(): array
    {
        return [
           'title' => 'Nome',
           'cover_img' => 'Cover Image',
           'description' => 'Descrizione',
           'address' => 'Indirizzo',
           'address_number' => 'Numero civico',
           'city' => 'Città',
           'postal_code' => 'CAP',
           'number_of_rooms' => 'Numero delle stanze',
           'number_of_bathrooms' => 'Numero delle stanze',
           'square_meters' => 'Metri quadrati',
           'price' => 'Prezzo',
           'services' => 'Servizi',
           'visibility' => 'Visibilità'
       ];
    }
}