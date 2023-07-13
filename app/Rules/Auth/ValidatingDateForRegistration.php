<?php

namespace App\Rules\Auth;

use Illuminate\Contracts\Validation\Rule;

// Regola di validazione per la data di nascita inserita in fase di registrazione
class ValidatingDateForRegistration implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    // Il seguente metodo si occupa di determinare se la data inserita sia di almeno 18 anni fa (utente maggiorenne)
    public function passes($attribute, $value)
    {
        // Se la data inserita è null o stringa vuota la validazione passa con successo, essendo il campo "birth" nullable
        if (($value === null) || ($value === ""))
            return true;
        // Se la condizione precedente non è verificata si passa a valutare se la data sia di almeno 18 anni fa (utente maggiorenne)
        // Nel seguente comando si crea un'istanza "Carbon" a partire dal valore del parametro $value (la data inserita)
        $birth_date         = \Carbon\Carbon::parse($value);
        // Nel seguente comando si crea una seconda istanza di "Carbon". Il metodo statico "now" restituisce la data odierna, dopodichè il metodo "subYears(18)" sottrae 18 anni alla stessa, restituendo infine la data di 18 anni fa a partire da oggi
        $eighteen_years_ago = \Carbon\Carbon::now()->subYears(18);
        // Infine si restituisce, come risultato di validazione, il booleano derivante dalla condizione: "birth_date è minore o uguale a eighteen_years_ago?" nel senso che la data inserita come data di compleanno deve essere più vecchia di 18 anni fa
        return $birth_date->lte($eighteen_years_ago);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    // Il seguente metodo produce il messaggio di errore in caso di validazione non favorevole (passes = false)
    public function message()
    {
        return 'La data inserita non è valida. Si accettano solo utenti maggiorenni oppure si può omettere di inserire una data (non obbligatoria)';
    }
}
