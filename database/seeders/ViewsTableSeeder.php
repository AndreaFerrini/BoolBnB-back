<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ViewSeeder extends Seeder
{
    public function run()
    {
        $apartments = App\Models\Apartment::all(); // Assumendo che il modello degli appartamenti sia "Apartment"

        foreach ($apartments as $apartment) {
            for ($i = 0; $i < 5; $i++) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                
                // Creazione di un record nella tabella "views"
                Views::table('views')->insert([
                    'apartment_id' => $apartment->id,
                    'date' => $date,
                ]);
            }
        }
    }
}