<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment as Apartment;
use App\Models\Service as Service;

class Apartment_ServiceTableSeeder extends Seeder
{
    // Numero minimo di servizi da attribuire a ciascun appartamento
    protected   $min_services_amount = 5;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Si acquisiscono tutti gli appartamenti presenti nella tabella
        $all_apartments     =   Apartment::All();
        // Con il metodo "pluck('id')" prendiamo tutti gli id dei servizi dalla tabella "Services" e li carichiamo dentro un array
        // Ovviamente avremo tanti id quanti sono i record in tabella, essendo id "unique"
        $all_services_ids   =   Service::pluck('id');
        // Si associa ad una variabile il numero di servizi totali presenti in tabella
        $total_services     =   count($all_services_ids);
        // Il seguente controllo è inserito solo come paracadute di emergenza laddove, accidentalmente, si sia deciso di avere un numero minimo di servizi che sia in realtà superiore al numero di servizi disponibili; in quel caso, il numero minimo diventerà uguale al numero massimo disponibile, quindi tutti gli appartamenti, alla fine, si ritroverebbero con lo stesso numero di servizi, ossia con tutti.
        if ($total_services < $this->min_services_amount)
            $this->min_services_amount = $total_services;
        // Nel foreach si passa in rassegna tutta la collezione di appartamenti
        foreach ($all_apartments as $apartment)
        {
            // L'array "final_ids_array" conterrà, per ogni appartamento, tutti gli id dei servizi che verranno associati a tale appartamento. Quindi, ogni volta che il foreach ci riporta su un nuovo appartamento, l'array deve essere svuotato per essere via via popolato
            $final_ids_array = [];
            // Si estrae un numero randomico tra il minimo ed il massimo numero di servizi richiesti/disponibili. Ovviamente se minimo e massimo coincidono, anche il numero randomico coinciderà con essi
            $services_amount = mt_rand($this->min_services_amount, $total_services);
            // Nel seguente ciclo si individuano tutti i servizi che andranno ad essere associati all'appartamento
            for ($counter = 1; $counter <= $services_amount; $counter++)
            {
                // Considerato che l'array "final_ids_array" deve essere popolato con tutti gli id necessari, si ripete la generazione di un indice randomico fintantochè l'id indicizzato da tale indice non sia effettivamente un nuovo id (no ripetizioni)
                do
                {
                    $index = mt_rand(0, $total_services - 1);
                }
                while (in_array($all_services_ids[$index], $final_ids_array));
                // Una volta fuori dal "do-while" siamo certi che l'id indicizzato dall'indice randomico è effettivamente un nuovo id, quindi si procede ad inserirlo nel final_ids_array
                $final_ids_array[] = $all_services_ids[$index];
            }
            // Una volta fuori dal "for" siamo certi di aver individuato un numero di id pari a quanto richiesto dal numero randomico "services_amount", si procede quindi, mediante il metodo "attach" ad associare tutti gli id dei servizi all'appartamento del momento
            $apartment->services()->attach($final_ids_array);
        }
    }
}
